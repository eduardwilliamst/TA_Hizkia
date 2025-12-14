<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data keranjang dari session
        $cart = session('cart', []);

        return view('cart.index', compact('cart'));
    }

    public function save(Request $request)
    {
        // Ambil data cart dari request (dari POS page)
        $cart = $request->input('cart', []);
        $totalDiskon = $request->input('total_diskon', 0);
        $caraBayar = $request->input('cara_bayar', 'cash');

        // Perkaya data cart dengan detail produk
        $cartWithDetails = collect($cart)->map(function ($item) {
            $product = Produk::find($item['id']); // Ambil detail produk dari database
            if ($product) {
                $isBonus = isset($item['is_bonus']) && $item['is_bonus'];
                return [
                    'id' => $product->idproduk,
                    'name' => $product->nama,
                    'price' => $isBonus ? 0 : $product->harga,
                    'quantity' => $item['quantity'],
                    'discount' => $item['discount'] ?? 0,
                    'promo_applied' => $item['promo_applied'] ?? null,
                    'is_bonus' => $isBonus,
                ];
            }
            return null;
        })->filter()->toArray(); // Filter untuk menghapus null jika produk tidak ditemukan

        // Simpan data ke session untuk ditampilkan di cart page
        session([
            'cart' => $cartWithDetails,
            'total_diskon' => $totalDiskon,
            'cara_bayar' => $caraBayar
        ]);

        return response()->json([
            'message' => 'Cart saved to session. Redirect to cart page.',
            'redirect' => route('penjualan.viewCart')
        ]);
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
