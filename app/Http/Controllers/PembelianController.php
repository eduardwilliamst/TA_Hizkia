<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Menampilkan daftar pembelian.
     */
    public function index()
    {
        $pembelians = Pembelian::with('supplier')->get();
        return view('pembelian.index', compact('pembelians'));
    }

    /**
     * Menampilkan form untuk membuat pembelian baru.
     */
    public function create()
    {
        $suppliers = Supplier::all(); // Mengambil semua supplier
        return view('pembelian.create', compact('suppliers'));
    }

    /**
     * Menyimpan pembelian baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_pesan' => 'required|date',
            'tanggal_datang' => 'nullable|date',
            'supplier_idsupplier' => 'required|exists:suppliers,idsupplier',
        ]);

        // Buat pembelian baru
        Pembelian::create($request->all());

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit pembelian.
     */
    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $suppliers = Supplier::all(); // Mengambil semua supplier untuk opsi dropdown
        return view('pembelian.edit', compact('pembelian', 'suppliers'));
    }

    /**
     * Memperbarui pembelian yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal_pesan' => 'required|date',
            'tanggal_datang' => 'nullable|date',
            'supplier_idsupplier' => 'required|exists:suppliers,idsupplier',
        ]);

        // Temukan pembelian dan update data
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->update($request->all());

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diperbarui!');
    }

    /**
     * Menghapus pembelian dari database.
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus!');
    }
}
