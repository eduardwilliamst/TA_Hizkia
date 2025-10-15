<?php

namespace App\Http\Controllers;

use App\Models\Tipe;
use Illuminate\Http\Request;

class TipeController extends Controller
{
    /**
     * Menampilkan daftar tipe.
     */
    public function index()
    {
        $tipes = Tipe::all();
        return view('tipe.index', compact('tipes'));
    }

    /**
     * Menyimpan tipe baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        // Buat tipe baru
        Tipe::create($request->all());

        return redirect()->route('tipe.index')->with('success', 'Tipe berhasil ditambahkan!');
    }

    /**
     * Memperbarui tipe yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        // Temukan tipe dan update data
        $tipe = Tipe::findOrFail($id);
        $tipe->update($request->all());

        return redirect()->route('tipe.index')->with('success', 'Tipe berhasil diperbarui!');
    }

    /**
     * Menghapus tipe dari database.
     */
    public function destroy($id)
    {
        $tipe = Tipe::findOrFail($id);
        $tipe->delete();

        return redirect()->route('tipe.index')->with('success', 'Tipe berhasil dihapus!');
    }

    public function getEditForm(Request $request)
    {
        $tipe = Tipe::find($request->id);

        return response()->json(array(
            'status' => 'oke',
            'msg' => view('tipe.modal', compact('tipe'))->render()
        ), 200);
    }
}
