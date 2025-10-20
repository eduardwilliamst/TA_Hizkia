<?php

namespace App\Http\Controllers;

use App\Models\PosSession;
use App\Models\CashFlow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosSessionController extends Controller
{
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
