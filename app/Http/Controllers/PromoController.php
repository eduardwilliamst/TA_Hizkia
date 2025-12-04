<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Produk;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Menampilkan daftar promo.
     */
    public function index()
    {
        $promos = Promo::with(['produkUtama', 'produkTambahan'])->get();
        $produks = Produk::all();
        return view('promo.index', compact('promos', 'produks'));
    }

    /**
     * Menampilkan form untuk membuat promo baru.
     */
    public function create()
    {
        $produks = Produk::all();
        return view('promo.create', compact('produks'));
    }

    /**
     * Menyimpan promo baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'deskripsi' => 'required|string|max:45',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'tipe' => 'required|in:produk gratis,diskon',
            'produk_idutama' => 'required|exists:produks,idproduk',
            'buy_x' => 'required|integer|min:1',
            'get_y' => 'nullable|integer|min:1',
            'produk_idtambahan' => 'nullable|exists:produks,idproduk',
            'nilai_diskon' => 'nullable|integer|min:1|max:100',
        ]);

        // Simpan promo baru
        Promo::create([
            'deskripsi' => $request->deskripsi,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'tipe' => $request->tipe,
            'produk_idutama' => $request->produk_idutama,
            'buy_x' => $request->buy_x,
            'get_y' => $request->tipe === 'produk gratis' ? $request->get_y : null,
            'produk_idtambahan' => $request->tipe === 'produk gratis' ? $request->produk_idtambahan : null,
            'nilai_diskon' => $request->tipe === 'diskon' ? $request->nilai_diskon : null,
        ]);

        return redirect()->route('promo.index')->with('success', 'Promo berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit promo.
     */
    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        $produks = Produk::all();
        return view('promo.edit', compact('promo', 'produks'));
    }

    /**
     * Get edit form via AJAX
     */
    public function getEditForm(Request $request)
    {
        $promo = Promo::with(['produkUtama', 'produkTambahan'])->findOrFail($request->id);
        $produks = Produk::all();

        $html = view('promo.edit-modal', compact('promo', 'produks'))->render();

        return response()->json(['msg' => $html]);
    }

    /**
     * Memperbarui promo yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'deskripsi' => 'required|string|max:45',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'tipe' => 'required|in:produk gratis,diskon',
            'produk_idutama' => 'required|exists:produks,idproduk',
            'buy_x' => 'required|integer|min:1',
            'get_y' => 'nullable|integer|min:1',
            'produk_idtambahan' => 'nullable|exists:produks,idproduk',
            'nilai_diskon' => 'nullable|integer|min:1|max:100',
        ]);

        // Temukan promo dan update data
        $promo = Promo::findOrFail($id);
        $promo->update([
            'deskripsi' => $request->deskripsi,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'tipe' => $request->tipe,
            'produk_idutama' => $request->produk_idutama,
            'buy_x' => $request->buy_x,
            'get_y' => $request->tipe === 'produk gratis' ? $request->get_y : null,
            'produk_idtambahan' => $request->tipe === 'produk gratis' ? $request->produk_idtambahan : null,
            'nilai_diskon' => $request->tipe === 'diskon' ? $request->nilai_diskon : null,
        ]);

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

    /**
     * Get active promos for a product
     */
    public static function getActivePromos($produkId)
    {
        $now = now();
        return Promo::where('produk_idutama', $produkId)
            ->where('tanggal_awal', '<=', $now)
            ->where('tanggal_akhir', '>=', $now)
            ->get();
    }
}
