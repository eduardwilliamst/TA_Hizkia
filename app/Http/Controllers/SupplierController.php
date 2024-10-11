<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Menampilkan daftar supplier.
     */
    public function index()
    {
        $suppliers = Supplier::all(); // Mengambil semua supplier dari database
        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Menampilkan form untuk membuat supplier baru.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Menyimpan supplier baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'telp' => 'required|string|max:15',
        ]);

        // Simpan supplier baru
        Supplier::create($request->all());

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit supplier.
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id); // Mencari supplier berdasarkan ID
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Memperbarui supplier yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'telp' => 'required|string|max:15',
        ]);

        // Temukan supplier dan update data
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui!');
    }

    /**
     * Menghapus supplier dari database.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
    }
}
