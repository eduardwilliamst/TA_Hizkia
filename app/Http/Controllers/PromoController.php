<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Menampilkan daftar promo.
     */
    public function index()
    {
        $promos = Promo::all(); // Mengambil semua promo dari database
        return view('promo.index', compact('promos'));
    }

    /**
     * Menampilkan form untuk membuat promo baru.
     */
    public function create()
    {
        return view('promo.create');
    }

    /**
     * Menyimpan promo baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'buy_x' => 'nullable|integer',
            'get_y' => 'nullable|integer',
        ]);

        // Simpan promo baru
        Promo::create($request->all());

        return redirect()->route('promo.index')->with('success', 'Promo berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit promo.
     */
    public function edit($id)
    {
        $promo = Promo::findOrFail($id); // Mencari promo berdasarkan ID
        return view('promo.edit', compact('promo'));
    }

    /**
     * Memperbarui promo yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'deskripsi' => 'required|string|max:255',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'buy_x' => 'nullable|integer',
            'get_y' => 'nullable|integer',
        ]);

        // Temukan promo dan update data
        $promo = Promo::findOrFail($id);
        $promo->update($request->all());

        return redirect()->route('promo.index')->with('success', 'Promo berhasil diperbarui!');
    }

    /**
     * Menghapus promo dari database.
     */
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('promo.index')->with('success', 'Promo berhasil dihapus!');
    }
}
