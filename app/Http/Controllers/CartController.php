<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetil;
use App\Models\Produk;
use App\Models\CashFlow;
use App\Models\PosSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $totalDiskon = $request->input('total_diskon', 0);
        $caraBayar = $request->input('cara_bayar', 'cash');

        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang kosong!'], 400);
        }

        // Calculate total payment
        $totalBayar = 0;
        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $itemDiscount = $item['discount'] ?? 0;
            $totalBayar += ($itemTotal - $itemDiscount);
        }

        // Get current POS session
        $posSessionId = session('pos_session');
        if (!$posSessionId) {
            return response()->json(['error' => 'Sesi POS tidak ditemukan! Silakan login kembali.'], 400);
        }

        DB::beginTransaction();
        try {
            // Simpan ke tabel penjualans
            $penjualan = Penjualan::create([
                'tanggal' => Carbon::now(),
                'cara_bayar' => $caraBayar,
                'total_diskon' => $totalDiskon,
                'total_harga' => $totalBayar,
                'user_iduser' => auth()->id(),
                'pos_session_idpos_session' => $posSessionId,
            ]);

            // Simpan ke tabel penjualan_detils
            foreach ($cart as $item) {
                $isBonus = isset($item['is_bonus']) && $item['is_bonus'];

                PenjualanDetil::create([
                    'penjualan_idpenjualan' => $penjualan->idpenjualan,
                    'produk_idproduk' => $item['id'],
                    'harga' => $isBonus ? 0 : $item['price'],
                    'jumlah' => $item['quantity'],
                    'sub_total' => $isBonus ? 0 : ($item['price'] * $item['quantity']),
                ]);

                // Update stock: decrease quantity (skip for bonus items)
                if (!$isBonus) {
                    $produk = Produk::find($item['id']);
                    if ($produk) {
                        $produk->stok -= $item['quantity'];
                        $produk->save();
                    }
                }
            }

            // Only record cash flow for cash payments (card payments don't affect cash balance)
            if ($caraBayar === 'cash') {
                // Get current session to calculate new balance
                $posSession = PosSession::find($posSessionId);
                $balanceAwal = $posSession->balance_akhir ?? $posSession->balance_awal;
                $balanceAkhir = $balanceAwal + $totalBayar;

                // Record to cash_flows (cash in from sales)
                CashFlow::create([
                    'balance_awal' => $balanceAwal,
                    'balance_akhir' => $balanceAkhir,
                    'tanggal' => Carbon::now(),
                    'keterangan' => 'Penjualan #' . $penjualan->idpenjualan . ' (Cash)',
                    'tipe' => 'cash_in',
                    'jumlah' => $totalBayar,
                    'id_pos_session' => $posSessionId,
                ]);

                // Update session balance_akhir
                $posSession->balance_akhir = $balanceAkhir;
                $posSession->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil disimpan!',
                'penjualan_id' => $penjualan->idpenjualan
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Checkout gagal: ' . $e->getMessage()], 500);
        }
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
