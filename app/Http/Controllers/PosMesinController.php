<?php

namespace App\Http\Controllers;

use App\Models\PosMesin;
use Illuminate\Http\Request;

class PosMesinController extends Controller
{
    /**
     * Menampilkan daftar POS mesin.
     */
    public function index()
    {
        $posMesins = PosMesin::all();
        return view('pos_mesin.index', compact('posMesins'));
    }

    /**
     * Menampilkan form untuk membuat POS mesin baru.
     */
    public function create()
    {
        return view('pos_mesin.create');
    }

    /**
     * Menyimpan POS mesin baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:45',
        ]);

        // Buat POS mesin baru
        PosMesin::create($request->all());

        return redirect()->route('pos_mesin.index')->with('success', 'POS mesin berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit POS mesin.
     */
    public function edit($id)
    {
        $posMesin = PosMesin::findOrFail($id);
        return view('pos_mesin.edit', compact('posMesin'));
    }

    /**
     * Memperbarui POS mesin yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:45',
        ]);

        // Temukan POS mesin dan update data
        $posMesin = PosMesin::findOrFail($id);
        $posMesin->update($request->all());

        return redirect()->route('pos_mesin.index')->with('success', 'POS mesin berhasil diperbarui!');
    }

    /**
     * Menghapus POS mesin dari database.
     */
    public function destroy($id)
    {
        $posMesin = PosMesin::findOrFail($id);
        $posMesin->delete();

        return redirect()->route('pos_mesin.index')->with('success', 'POS mesin berhasil dihapus!');
    }
}
