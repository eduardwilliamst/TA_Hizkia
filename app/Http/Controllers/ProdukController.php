<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Diskon;
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
        $diskons = Diskon::all();
        $produks = Produk::with(['kategori', 'diskon'])->get(); // Mengambil produk beserta relasi kategori dan diskon
        return view('produk.index', compact('produks', 'kategoris', 'diskons'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $diskons = Diskon::all();
        return view('produk.create', compact('kategoris', 'diskons'));
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
            'diskon_iddiskon' => 'nullable|exists:diskons,iddiskon',
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
        $produk->diskon_iddiskon = $request->diskon_iddiskon;

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
        $diskons = Diskon::all();
        return view('produk.edit', compact('produk', 'kategoris', 'diskons'));
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
            'gambar' => 'nullable|image|max:2048',
            'usia_awal' => 'required|integer',
            'usia_akhir' => 'required|integer',
            'kategori_idkategori' => 'required|exists:kategoris,idkategori',
            'diskon_iddiskon' => 'nullable|exists:diskons,iddiskon',
        ]);

        // Temukan produk dan update data
        $produk = Produk::findOrFail($id);
        $produk->fill($request->all());

        // Jika ada gambar baru, simpan file gambar baru
        if ($request->hasFile('gambar')) {
            $filePath = $request->file('gambar')->store('produk_images', 'public');
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
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
