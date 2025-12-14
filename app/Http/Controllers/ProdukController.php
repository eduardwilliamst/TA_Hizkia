<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        $produks = Produk::with(['kategori'])->get(); // Mengambil produk beserta relasi kategori dan diskon
        return view('produk.index', compact('produks', 'kategoris'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    /**
     * Menyimpan produk baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'barcode' => 'required|string|max:255|unique:produks,barcode',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal ukuran gambar 2MB
            // 'usia_awal' => 'required|date',
            // 'usia_akhir' => 'required|date',
            'kategori_idkategori' => 'required|exists:kategoris,idkategori',
        ]);

        // Membuat produk baru
        $produk = new Produk();
        $produk->barcode = $request->barcode;
        $produk->nama = $request->nama;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
        // $produk->usia_awal = $request->usia_awal;
        // $produk->usia_akhir = $request->usia_akhir;
        $produk->kategori_idkategori = $request->kategori_idkategori;

        // Menyimpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('images/produk', 'public');
            $produk->gambar = $imagePath; // Simpan path gambar ke database
        }

        // Simpan produk ke database
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    /**
     * Memperbarui produk yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'barcode' => 'required|string|max:45',
            'nama' => 'required|string|max:100',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'usia_awal' => 'nullable|integer',
            // 'usia_akhir' => 'nullable|integer',
            'kategori_idkategori' => 'required|exists:kategoris,idkategori',
        ]);

        // Temukan produk dan update data
        $produk = Produk::findOrFail($id);
        $produk->barcode = $request->barcode;
        $produk->nama = $request->nama;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
        $produk->kategori_idkategori = $request->kategori_idkategori;

        // Jika ada gambar baru, simpan file gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $filePath = $request->file('gambar')->store('images/produk', 'public');
            $produk->gambar = $filePath;
        }

        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Mendapatkan form edit produk untuk modal
     */
    public function getEditForm(Request $request)
    {
        $produk = Produk::findOrFail($request->id);
        $kategoris = Kategori::all();
        $view = view('produk.modal', compact('produk', 'kategoris'))->render();
        return response()->json(['msg' => $view]);
    }

    /**
     * Mendapatkan detail produk untuk modal
     */
    public function getDetailForm(Request $request)
    {
        $produk = Produk::with('kategori')->findOrFail($request->id);
        $view = view('produk.detail', compact('produk'))->render();
        return response()->json(['msg' => $view]);
    }
}
