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
}
