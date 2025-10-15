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
     * Menampilkan form untuk mengedit posSession.
     */
    public function edit($id)
    {
        $posSession = PosSession::findOrFail($id); // Mencari posSession berdasarkan ID
        return view('cashflow.edit', compact('posSession'));
    }

    /**
     * Memperbarui posSession yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'telp' => 'required|string|max:15',
        ]);

        // Temukan posSession dan update data
        $posSession = PosSession::findOrFail($id);
        $posSession->update($request->all());

        return redirect()->route('cahsflow.index')->with('success', 'posSession berhasil diperbarui!');
    }

    /**
     * Menghapus posSession dari database.
     */
    public function destroy($id)
    {
        $posSession = PosSession::findOrFail($id);
        $posSession->delete();

        return redirect()->route('cashflow.index')->with('success', 'Cashflow berhasil dihapus!');
    }
}
