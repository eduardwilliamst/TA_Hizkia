<?php

namespace App\Http\Controllers;

use App\Models\PosSession;
use App\Models\CashFlow;
use App\Models\PosMesin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PosSessionController extends Controller
{
    /**
     * Display a listing of all POS sessions (Admin only)
     */
    public function index()
    {
        // Check if user is admin
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Get all sessions with relationships, ordered by latest
        $sessions = PosSession::with(['user', 'posMesin'])
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('pos-session.index', compact('sessions'));
    }

    /**
     * Show the session opening page
     */
    public function showOpenSession()
    {
        // Check if user already has an active session today
        $activeSession = PosSession::where('user_iduser', Auth::id())
            ->whereDate('tanggal', Carbon::today())
            ->whereNull('balance_akhir')
            ->first();

        if ($activeSession) {
            // Session already exists, redirect to dashboard
            return redirect()->route('dashboard')->with('info', 'Anda sudah memiliki sesi aktif');
        }

        return view('pos-session.open');
    }

    /**
     * Open a new POS session with initial balance
     */
    public function openSession(Request $request)
    {
        $request->validate([
            'balance_awal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Check if user already has an active session
            $activeSession = PosSession::where('user_iduser', Auth::id())
                ->whereNull('balance_akhir')
                ->first();

            if ($activeSession) {
                DB::rollBack();
                return redirect()->route('dashboard')
                    ->with('warning', 'Anda sudah memiliki sesi aktif. Tutup sesi sebelumnya terlebih dahulu.');
            }

            // Get POS machine from session (selected during login)
            $posMesinId = session('selected_pos_mesin');

            if (!$posMesinId) {
                DB::rollBack();
                return redirect()->route('login')
                    ->with('error', 'Sesi login tidak valid. Silakan login ulang.');
            }

            $posMesin = PosMesin::find($posMesinId);

            if (!$posMesin) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Mesin POS yang dipilih tidak ditemukan. Silakan login ulang.');
            }

            // Create new POS session
            $posSession = PosSession::create([
                'balance_awal' => $request->balance_awal,
                'balance_akhir' => null,
                'tanggal' => Carbon::now(),
                'keterangan' => $request->keterangan ?? 'Sesi dibuka',
                'user_iduser' => Auth::id(),
                'pos_mesin_idpos_mesin' => $posMesin->idpos_mesin,
            ]);

            // Store session ID in user session
            session(['pos_session' => $posSession->idpos_session]);

            // Create initial cash flow record
            CashFlow::create([
                'balance_awal' => $request->balance_awal,
                'balance_akhir' => $request->balance_awal,
                'tanggal' => Carbon::now(),
                'keterangan' => 'Saldo awal sesi - ' . ($request->keterangan ?? 'Pembukaan kas'),
                'tipe' => 'saldo_awal',
                'jumlah' => $request->balance_awal,
                'id_pos_session' => $posSession->idpos_session,
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('success',
                'Sesi berhasil dibuka dengan saldo awal Rp ' . number_format($request->balance_awal, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membuka sesi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Check if user has an active session
     */
    public function checkActiveSession()
    {
        $posSessionId = session('pos_session');

        if (!$posSessionId) {
            return response()->json(['has_session' => false]);
        }

        $posSession = PosSession::where('idpos_session', $posSessionId)
            ->whereNull('balance_akhir')
            ->first();

        return response()->json([
            'has_session' => $posSession ? true : false,
            'session_id' => $posSession ? $posSession->idpos_session : null
        ]);
    }

    /**
     * Finalize the current session when user logs out
     * Calculates total cash in/out and updates final balance
     */
    public function closeSession(Request $request)
    {
        $posSessionId = session('pos_session');

        if (!$posSessionId) {
            return response()->json(['error' => 'Tidak ada sesi aktif yang ditemukan.'], 400);
        }

        try {
            DB::beginTransaction();

            $posSession = PosSession::find($posSessionId);

            if (!$posSession) {
                return response()->json(['error' => 'Sesi POS tidak ditemukan.'], 404);
            }

            // Get all cash flows for this session
            $cashFlows = CashFlow::where('id_pos_session', $posSessionId)->get();

            // Calculate totals
            $totalCashIn = $cashFlows->where('tipe', 'cash_in')->sum('jumlah');
            $totalCashOut = $cashFlows->where('tipe', 'cash_out')->sum('jumlah');

            // Update session description with summary
            $posSession->keterangan = sprintf(
                'Sesi selesai - Cash In: Rp %s, Cash Out: Rp %s',
                number_format($totalCashIn, 0, ',', '.'),
                number_format($totalCashOut, 0, ',', '.')
            );

            // Ensure balance_akhir is set (should already be updated by transactions)
            if ($posSession->balance_akhir === null) {
                $posSession->balance_akhir = $posSession->balance_awal + $totalCashIn - $totalCashOut;
            }

            $posSession->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sesi berhasil ditutup',
                'summary' => [
                    'balance_awal' => $posSession->balance_awal,
                    'balance_akhir' => $posSession->balance_akhir,
                    'total_cash_in' => $totalCashIn,
                    'total_cash_out' => $totalCashOut,
                    'net_change' => $totalCashIn - $totalCashOut,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menutup sesi: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get session summary for the current active session
     */
    public function getSessionSummary()
    {
        $posSessionId = session('pos_session');

        if (!$posSessionId) {
            return response()->json(['error' => 'Tidak ada sesi aktif.'], 400);
        }

        $posSession = PosSession::with('posMesin', 'user')->find($posSessionId);

        if (!$posSession) {
            return response()->json(['error' => 'Sesi tidak ditemukan.'], 404);
        }

        // Get all cash flows for this session
        $cashFlows = CashFlow::where('id_pos_session', $posSessionId)->get();

        $totalCashIn = $cashFlows->where('tipe', 'cash_in')->sum('jumlah');
        $totalCashOut = $cashFlows->where('tipe', 'cash_out')->sum('jumlah');

        return response()->json([
            'session' => [
                'id' => $posSession->idpos_session,
                'pos_mesin' => $posSession->posMesin->nama ?? 'N/A',
                'user' => $posSession->user->name ?? 'N/A',
                'tanggal' => $posSession->tanggal,
                'balance_awal' => $posSession->balance_awal,
                'balance_akhir' => $posSession->balance_akhir,
            ],
            'summary' => [
                'total_cash_in' => $totalCashIn,
                'total_cash_out' => $totalCashOut,
                'net_change' => $totalCashIn - $totalCashOut,
                'current_balance' => $posSession->balance_akhir ?? ($posSession->balance_awal + $totalCashIn - $totalCashOut),
            ],
            'transactions' => $cashFlows->map(function ($cf) {
                return [
                    'tanggal' => $cf->tanggal,
                    'keterangan' => $cf->keterangan,
                    'tipe' => $cf->tipe,
                    'jumlah' => $cf->jumlah,
                    'balance_akhir' => $cf->balance_akhir,
                ];
            })
        ]);
    }

    /**
     * Show the session closing page with transaction summary
     */
    public function showCloseSession()
    {
        // Check if user is admin or kasir
        if (!auth()->user()->hasRole(['admin', 'kasir'])) {
            abort(403, 'Unauthorized action. Only admin and kasir can close sessions.');
        }

        $posSessionId = session('pos_session');

        if (!$posSessionId) {
            return redirect()->route('login')->with('error', 'Tidak ada sesi aktif yang ditemukan.');
        }

        $posSession = PosSession::find($posSessionId);

        if (!$posSession) {
            return redirect()->route('login')->with('error', 'Sesi tidak ditemukan.');
        }

        // Get all sales for this session
        $penjualans = \App\Models\Penjualan::where('pos_session_idpos_session', $posSessionId)->get();

        // Calculate total sales and breakdown by payment method
        $totalPenjualan = $penjualans->sum('total_harga');
        $cashSales = $penjualans->where('cara_bayar', 'cash')->sum('total_harga');
        $kartuTotal = $penjualans->where('cara_bayar', 'card')->sum('total_harga');

        // Get all cash flows for this session (excluding saldo_awal since it's just opening balance)
        $cashFlows = CashFlow::where('id_pos_session', $posSessionId)
            ->whereIn('tipe', ['cash_in', 'cash_out'])
            ->get();

        // Calculate manual cash in/out (excluding sales which are already in cash_in)
        // Cash from sales is already recorded in cash_flows as cash_in
        $manualCashIn = $cashFlows->where('tipe', 'cash_in')
            ->filter(function($cf) {
                return !str_contains($cf->keterangan, 'Penjualan #');
            })
            ->sum('jumlah');

        $manualCashOut = $cashFlows->where('tipe', 'cash_out')->sum('jumlah');

        // Calculate expected cash total from the current balance_akhir in pos_session
        // balance_akhir should already include: balance_awal + cash sales + manual cash in/out
        $kasTotal = $posSession->balance_akhir ?? $posSession->balance_awal;

        $summary = [
            'totalPenjualan' => $totalPenjualan,
            'kasTotal' => $kasTotal,
            'balanceAwal' => $posSession->balance_awal,
            'manualCashIn' => $manualCashIn,
            'manualCashOut' => $manualCashOut,
            'kartuTotal' => $kartuTotal,
            'cashSales' => $cashSales,
            'jumlahTransaksi' => $penjualans->count(),
        ];

        return view('pos-session.close', compact('summary'));
    }

    /**
     * Get session detail (Admin only)
     */
    public function getDetail($id)
    {
        // Check if user is admin
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $session = PosSession::with(['user', 'posMesin'])->findOrFail($id);

        // Get all sales for this session
        $penjualans = \App\Models\Penjualan::where('pos_session_idpos_session', $id)->get();

        // Get all cash flows for this session
        $cashFlows = CashFlow::where('id_pos_session', $id)->get();

        // Calculate totals
        $totalPenjualan = $penjualans->sum('total_harga');
        $cashSales = $penjualans->where('cara_bayar', 'cash')->sum('total_harga');
        $cardSales = $penjualans->where('cara_bayar', 'card')->sum('total_harga');

        $totalCashIn = $cashFlows->where('tipe', 'cash_in')->sum('jumlah');
        $totalCashOut = $cashFlows->where('tipe', 'cash_out')->sum('jumlah');

        return view('pos-session.detail', compact('session', 'penjualans', 'cashFlows', 'totalPenjualan', 'cashSales', 'cardSales', 'totalCashIn', 'totalCashOut'));
    }

    /**
     * Process the session closing with actual cash count
     */
    public function processCloseSession(Request $request)
    {
        // Check if user is admin or kasir
        if (!auth()->user()->hasRole(['admin', 'kasir'])) {
            abort(403, 'Unauthorized action. Only admin and kasir can close sessions.');
        }

        $request->validate([
            'jumlah_tunai' => 'required|numeric|min:0',
            'catatan_closing' => 'nullable|string|max:500',
            'balance_akhir' => 'required|numeric',
            'total_cash' => 'required|numeric',
            'total_card' => 'required|numeric',
        ]);

        $posSessionId = session('pos_session');

        if (!$posSessionId) {
            return redirect()->route('login')->with('error', 'Tidak ada sesi aktif yang ditemukan.');
        }

        try {
            DB::beginTransaction();

            $posSession = PosSession::find($posSessionId);

            if (!$posSession) {
                DB::rollBack();
                return redirect()->route('login')->with('error', 'Sesi tidak ditemukan.');
            }

            // Calculate difference between actual and expected cash
            $expectedCash = $request->total_cash;
            $actualCash = $request->jumlah_tunai;
            $selisih = $actualCash - $expectedCash;

            // Update session with closing information
            $posSession->balance_akhir = $request->balance_akhir;

            // Build closing note with details
            $closingNote = sprintf(
                "Tutup Kasir - Cash Expected: Rp %s, Cash Actual: Rp %s, Selisih: Rp %s, Card: Rp %s",
                number_format($expectedCash, 0, ',', '.'),
                number_format($actualCash, 0, ',', '.'),
                number_format(abs($selisih), 0, ',', '.') . ($selisih >= 0 ? ' (Lebih)' : ' (Kurang)'),
                number_format($request->total_card, 0, ',', '.')
            );

            if ($request->catatan_closing) {
                $closingNote .= " | Catatan: " . $request->catatan_closing;
            }

            $posSession->keterangan = $closingNote;
            $posSession->save();

            // If there's a cash difference, record it as cash flow
            if ($selisih != 0) {
                CashFlow::create([
                    'balance_awal' => $expectedCash,
                    'balance_akhir' => $actualCash,
                    'tanggal' => Carbon::now(),
                    'keterangan' => 'Selisih kas saat tutup kasir: ' . ($selisih > 0 ? 'Lebih Rp ' : 'Kurang Rp ') . number_format(abs($selisih), 0, ',', '.'),
                    'tipe' => $selisih > 0 ? 'cash_in' : 'cash_out',
                    'jumlah' => abs($selisih),
                    'id_pos_session' => $posSessionId,
                ]);
            }

            DB::commit();

            // Clear session data
            session()->forget('pos_session');
            session()->forget('selected_pos_mesin');

            // Logout user
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Sesi berhasil ditutup. Terima kasih!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menutup sesi: ' . $e->getMessage())
                ->withInput();
        }
    }
}
