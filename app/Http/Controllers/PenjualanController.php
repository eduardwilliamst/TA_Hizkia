<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\PenjualanDetil;
use App\Models\Produk;
use App\Models\Promo;
use App\Models\CashFlow;
use App\Models\PosSession;
use App\Models\InventoryHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            // Jika kategori_id = 'all' atau tidak ada, tampilkan semua produk
            if (!$request->kategori_id || $request->kategori_id === 'all') {
                $produks = Produk::with('kategori')->orderBy('nama')->get();
            } else {
                $produks = Produk::where('kategori_idkategori', $request->kategori_id)->get();
            }

            // Get active promos
            $now = Carbon::now();
            $activePromos = Promo::with(['produkUtama', 'produkTambahan'])
                ->where('tanggal_awal', '<=', $now)
                ->where('tanggal_akhir', '>=', $now)
                ->get()
                ->keyBy('produk_idutama');

            return view('penjualan.data', compact('produks', 'activePromos'))->render();
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
        $totalDiskon = $request->input('total_diskon', 0);
        $caraBayar = $request->input('cara_bayar');
        $totalBayar = 0;

        // Hitung total pembayaran (harga x quantity - diskon per item)
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
            // Simpan data ke tabel penjualans
            $penjualan = Penjualan::create([
                'tanggal' => Carbon::now(),
                'cara_bayar' => $caraBayar,
                'total_diskon' => $totalDiskon,
                'total_harga' => $totalBayar,
                'user_iduser' => auth()->id(),
                'pos_session_idpos_session' => $posSessionId,
            ]);

            // Simpan data ke tabel penjualan_detils
            foreach ($cart as $item) {
                $isBonus = isset($item['is_bonus']) && $item['is_bonus'];
                $produk = Produk::find($item['id']);

                PenjualanDetil::create([
                    'penjualan_idpenjualan' => $penjualan->idpenjualan,
                    'produk_idproduk' => $item['id'],
                    'harga' => $isBonus ? 0 : $item['price'],
                    'hpp' => $produk ? $produk->harga_beli : 0,
                    'jumlah' => $item['quantity'],
                    'sub_total' => $isBonus ? 0 : ($item['price'] * $item['quantity']),
                ]);

                // Update stock: decrease quantity (skip for bonus items)
                if (!$isBonus && $produk) {
                    $stokLama = $produk->stok;
                    $produk->stok -= $item['quantity'];
                    $produk->save();

                    // Record ke inventory history
                    InventoryHistory::create([
                        'produk_id' => $produk->idproduk,
                        'tanggal' => Carbon::now(),
                        'tipe' => 'penjualan',
                        'qty_before' => $stokLama,
                        'qty_change' => -$item['quantity'],
                        'qty_after' => $produk->stok,
                        'harga_beli' => $produk->harga_beli,
                        'referensi_id' => $penjualan->idpenjualan,
                        'referensi_tipe' => 'Penjualan',
                        'keterangan' => 'Penjualan #' . $penjualan->idpenjualan,
                    ]);
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
                'message' => 'Penjualan berhasil disimpan!',
                'penjualan_id' => $penjualan->idpenjualan
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menyimpan penjualan: ' . $e->getMessage()], 500);
        }
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
                'cara_bayar' => $request->cara_bayar,
                'total_diskon' => 0, // Tambahkan logika diskon jika diperlukan
                'total_harga' => $totalBayar,
                'user_id' => auth()->id(),
                'pos_session_idpos_session' => $posSessionId,
            ]);

            // Simpan ke tabel penjualan_detils
            foreach ($cart as $item) {
                $produk = Produk::find($item['id']);

                PenjualanDetil::create([
                    'penjualan_id' => $penjualan->idpenjualan,
                    'produk_id' => $item['id'],
                    'harga' => $item['price'],
                    'hpp' => $produk ? $produk->harga_beli : 0,
                    'jumlah' => $item['quantity'],
                    'sub_total' => $item['price'] * $item['quantity'],
                ]);

                // Update stock: decrease quantity
                if ($produk) {
                    $stokLama = $produk->stok;
                    $produk->stok -= $item['quantity'];
                    $produk->save();

                    // Record ke inventory history
                    InventoryHistory::create([
                        'produk_id' => $produk->idproduk,
                        'tanggal' => Carbon::now(),
                        'tipe' => 'penjualan',
                        'qty_before' => $stokLama,
                        'qty_change' => -$item['quantity'],
                        'qty_after' => $produk->stok,
                        'harga_beli' => $produk->harga_beli,
                        'referensi_id' => $penjualan->idpenjualan,
                        'referensi_tipe' => 'Penjualan',
                        'keterangan' => 'Penjualan #' . $penjualan->idpenjualan,
                    ]);
                }
            }

            // Get current session to calculate new balance
            $posSession = PosSession::find($posSessionId);
            $balanceAwal = $posSession->balance_akhir ?? $posSession->balance_awal;
            $balanceAkhir = $balanceAwal + $totalBayar;

            // Record to cash_flows (cash in from sales)
            CashFlow::create([
                'balance_awal' => $balanceAwal,
                'balance_akhir' => $balanceAkhir,
                'tanggal' => Carbon::now(),
                'keterangan' => 'Penjualan #' . $penjualan->idpenjualan,
                'tipe' => 'cash_in',
                'jumlah' => $totalBayar,
                'id_pos_session' => $posSessionId,
            ]);

            // Update session balance_akhir
            $posSession->balance_akhir = $balanceAkhir;
            $posSession->save();

            DB::commit();

            // Kosongkan keranjang
            session()->forget('cart');

            return response()->json(['message' => 'Checkout berhasil!', 'penjualan_id' => $penjualan->idpenjualan]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Checkout gagal: ' . $e->getMessage()], 500);
        }
    }
}
