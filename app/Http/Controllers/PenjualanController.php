<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\PenjualanDetil;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        try {
            $kategoris = Kategori::with('produks')->get();
            return view('penjualan.index', compact('kategoris'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listData()
    {
        $datas = Penjualan::all();
        dd($datas);

        return view('penjualan.list', compact('datas'));
    }

    public function data(Request $request)
    {
        try {
            // $kategoriId = $request->kategori_idkategori;
            $produks = Produk::where('kategori_idkategori', $request->kategori_id)->get();
            return view('penjualan.data', compact('produks'))->render();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show()
    {
        $penjualans = Penjualan::all();

        return view('penjualan.list', compact('penjualans'));
    }

    public function store(Request $request){

        try {
            $request->validate([
                'cart' => 'required|array',
                'cart.*.id' => 'required|exists:produks,idproduk',
                'cart.*.quantity' => 'required|integer|min:1',
                'cara_bayar' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $cart = $request->input('cart');
        $totalBayar = 0;

        // Hitung total pembayaran
        foreach ($cart as $item) {
            $totalBayar += $item['price'] * $item['quantity'];
        }

        // Simpan data ke tabel penjualans
        $penjualan = Penjualan::create([
            'tanggal' => Carbon::now(),
            'cara_bayar' => $request->input('cara_bayar'),
            'total_diskon' => 0, // Tambahkan logika diskon jika ada
            'total_bayar' => $totalBayar,
            // 'pos_session_id' => auth()->user()->current_session_id, // Asumsikan session aktif
            'user_id' => auth()->id(),
        ]);

        // Simpan data ke tabel penjualan_detils
        foreach ($cart as $item) {
            PenjualanDetil::create([
                'penjualan_id' => $penjualan->idpenjualan,
                'produk_id' => $item['id'],
                'harga' => $item['price'],
                'jumlah' => $item['quantity'],
                'sub_total' => $item['price'] * $item['quantity'],
            ]);
        }

        return response()->json(['message' => 'Penjualan berhasil disimpan!', 'penjualan_id' => $penjualan->idpenjualan]);
    }

    // Tambah produk ke keranjang
    public function addToCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:produks,idproduk',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        // Tambahkan item ke cart
        $cart[$request->id] = [
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ];

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang!', 'cart' => $cart]);
    }

    // Tampilkan isi keranjang
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        
        // $cart1 = session('cart', []);
        // dd($cart);
        return view('cart.index', compact('cart'));
    }

    // Hapus keranjang
    public function clearCart()
    {
        session()->forget('cart');
        return response()->json(['message' => 'Keranjang berhasil dikosongkan!']);
    }

    // Checkout (Simpan ke database)
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang kosong!'], 400);
        }

        $totalBayar = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // Simpan ke tabel penjualans
        $penjualan = Penjualan::create([
            'tanggal' => Carbon::now(),
            'cara_bayar' => $request->cara_bayar,
            'total_diskon' => 0, // Tambahkan logika diskon jika diperlukan
            'total_bayar' => $totalBayar,
            'user_id' => auth()->id(),
        ]);

        // Simpan ke tabel penjualan_detils
        foreach ($cart as $item) {
            PenjualanDetil::create([
                'penjualan_id' => $penjualan->idpenjualan,
                'produk_id' => $item['id'],
                'harga' => $item['price'],
                'jumlah' => $item['quantity'],
                'sub_total' => $item['price'] * $item['quantity'],
            ]);
        }

        // Kosongkan keranjang
        session()->forget('cart');

        return response()->json(['message' => 'Checkout berhasil!', 'penjualan_id' => $penjualan->idpenjualan]);
    }
}
