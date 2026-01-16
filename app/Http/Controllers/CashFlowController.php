<?php

namespace App\Http\Controllers;

use App\Models\CashFlow;
use App\Models\PosSession;
use Illuminate\Http\Request;

class CashFlowController extends Controller
{
    /**
     * Menampilkan daftar posSession.
     */
    public function index()
    {
        $id_pos_session = session('pos_session');
        $cashflows = CashFlow::where('id_pos_session', $id_pos_session)->with('posSession')->get();
        // dd($cashflows);
        return view('cashflow.index', compact('cashflows'));
    }

    /**
     * Menampilkan form untuk membuat posSession baru.
     */
    public function create()
    {
        return view('cashflow.create');
    }

    /**
     * Menyimpan posSession baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
            'type' => 'required|in:cash_in,cash_out', // Pastikan type hanya 'cash_in' atau 'cash_out'
        ]);
        // dd($request);
        // dd(session()->all()); // Menampilkan seluruh data session yang ada

        // Tentukan apakah jumlah positif atau negatif berdasarkan tipe
        $jumlah = $request->type === 'cash_in' ? $request->jumlah : -$request->jumlah;

        // Store the pos_session ID in the session
        $id_pos_session = session('pos_session');

        if (!$id_pos_session) {
            return redirect()->back()->with('error', 'Pos Session tidak ditemukan di session.');
        }

        // Ambil data pos_session berdasarkan ID
        $posSession = PosSession::find($id_pos_session);

        if (!$posSession) {
            return redirect()->back()->with('error', 'Pos Session tidak ditemukan di database.');
        }

        // Cek apakah sudah ada data di tabel cashflows untuk id_pos_session ini
        $lastCashFlow = CashFlow::where('id_pos_session', $id_pos_session)->latest('idcashflow')->first();

        $balance_awal = $lastCashFlow
            ? $lastCashFlow->balance_akhir // Gunakan balance_akhir dari data terakhir
            : $posSession->balance_awal;    // Gunakan balance_awal dari posSession jika belum ada data

        // Simpan data baru ke tabel pos_sessions
        CashFlow::create([
            'balance_awal' => $balance_awal,
            'balance_akhir' => $balance_awal + $jumlah,
            'tanggal' => now(),
            'keterangan' => $request->keterangan,
            'tipe' => $request->type,
            'jumlah' => $jumlah,
            'id_pos_session' => $id_pos_session,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('cashflow.index')->with('success', 'Cashflow berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit cashflow.
     */
    public function edit($id)
    {
        $cashflow = CashFlow::findOrFail($id);
        return view('cashflow.edit', compact('cashflow'));
    }

    /**
     * Get edit form via AJAX
     */
    public function getEditForm(Request $request)
    {
        $cashflow = CashFlow::findOrFail($request->id);

        $html = view('cashflow.modal', compact('cashflow'))->render();

        return response()->json(['msg' => $html]);
    }

    /**
     * Memperbarui cashflow yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable|string|max:500',
            'type' => 'required|in:cash_in,cash_out',
        ]);

        // Temukan cashflow yang akan diupdate
        $cashflow = CashFlow::findOrFail($id);
        $id_pos_session = $cashflow->id_pos_session;

        // Tentukan jumlah berdasarkan tipe
        $jumlah = $request->type === 'cash_in' ? abs($request->jumlah) : -abs($request->jumlah);

        // Update cashflow
        $cashflow->update([
            'keterangan' => $request->keterangan,
            'tipe' => $request->type,
            'jumlah' => $jumlah,
            'balance_akhir' => $cashflow->balance_awal + $jumlah,
        ]);

        // Recalculate all subsequent cashflows
        $this->recalculateBalances($id_pos_session, $cashflow->idcashflow);

        return redirect()->route('cashflow.index')->with('success', 'Cashflow berhasil diperbarui!');
    }

    /**
     * Menghapus cashflow dari database.
     */
    public function destroy($id)
    {
        $cashflow = CashFlow::findOrFail($id);
        $id_pos_session = $cashflow->id_pos_session;
        $idcashflow = $cashflow->idcashflow;

        // Delete the cashflow
        $cashflow->delete();

        // Recalculate all subsequent cashflows
        $this->recalculateBalances($id_pos_session, $idcashflow);

        return redirect()->route('cashflow.index')->with('success', 'Cashflow berhasil dihapus!');
    }

    /**
     * Recalculate balance_akhir for all cashflows after the given cashflow ID
     */
    private function recalculateBalances($id_pos_session, $startFromId)
    {
        // Get all cashflows for this session, ordered by ID
        $cashflows = CashFlow::where('id_pos_session', $id_pos_session)
            ->where('idcashflow', '>=', $startFromId)
            ->orderBy('idcashflow')
            ->get();

        foreach ($cashflows as $index => $cf) {
            if ($index === 0) {
                // Get the previous cashflow's balance_akhir as this one's balance_awal
                $previousCashFlow = CashFlow::where('id_pos_session', $id_pos_session)
                    ->where('idcashflow', '<', $cf->idcashflow)
                    ->orderBy('idcashflow', 'desc')
                    ->first();

                if ($previousCashFlow) {
                    $cf->balance_awal = $previousCashFlow->balance_akhir;
                } else {
                    // If no previous cashflow, use pos_session's balance_awal
                    $posSession = PosSession::find($id_pos_session);
                    $cf->balance_awal = $posSession->balance_awal;
                }
            } else {
                // Use previous cashflow's balance_akhir
                $cf->balance_awal = $cashflows[$index - 1]->balance_akhir;
            }

            // Recalculate balance_akhir
            $cf->balance_akhir = $cf->balance_awal + $cf->jumlah;
            $cf->save();
        }

        // Update pos_session's balance_akhir
        $lastCashFlow = CashFlow::where('id_pos_session', $id_pos_session)
            ->orderBy('idcashflow', 'desc')
            ->first();

        if ($lastCashFlow) {
            $posSession = PosSession::find($id_pos_session);
            $posSession->balance_akhir = $lastCashFlow->balance_akhir;
            $posSession->save();
        }
    }
}
