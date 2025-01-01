<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $carts = Penjualan::all();

        // Ambil data keranjang dari session
        $cart = session('cart', []);
        dd($cart);

        return view('cart.index', compact('carts'));
    }

    public function save(Request $request)
    {
        // Ambil data cart dari request
        $cart = $request->input('cart', []);

        // Perkaya data cart dengan detail produk
        $cartWithDetails = collect($cart)->map(function ($item) {
            $product = Produk::find($item['id']); // Ambil detail produk dari database
            if ($product) {
                return [
                    'id' => $product->idproduk,
                    'name' => $product->nama,
                    'price' => $product->harga,
                    'quantity' => $item['quantity'],
                ];
            }
            return null;
        })->filter()->toArray(); // Filter untuk menghapus null jika produk tidak ditemukan

        // Simpan data ke session
        session(['cart' => $cartWithDetails]);

        return response()->json(['message' => 'Cart saved to session successfully.']);
    }
    
    public function clear(Request $request)
    {
        session()->forget('cart'); // Hapus data session cart
        return response()->json(['message' => 'Cart cleared successfully.']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
