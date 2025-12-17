<?php

namespace App\Http\Controllers;

use App\Models\CashFlow;
use App\Models\Pembelian;
use App\Models\PembelianDetil;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Tipe;
use App\Models\PosSession;
use App\Models\InventoryHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    /**
     * Menampilkan daftar pembelian.
     */
    public function index()
    {
        $pembelians = Pembelian::with(['supplier', 'tipe', 'detils.produk'])->orderBy('created_at', 'desc')->get();
        $suppliers = Supplier::all();
        $tipes = Tipe::all();
        $produks = Produk::all();
        return view('pembelian.index', compact('pembelians', 'suppliers', 'tipes', 'produks'));
    }

    public function listData()
    {
        $datas = Pembelian::with(['supplier', 'tipe', 'detils.produk'])->get();

        return view('pembelian.list', compact('datas'));
    }

    public function show($id)
    {
        $pembelian = Pembelian::with(['supplier', 'tipe', 'detils.produk'])->findOrFail($id);

        return view('pembelian.show', compact('pembelian'));
    }

    /**
     * Menampilkan form untuk membuat pembelian baru.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $tipes = Tipe::all();
        $produks = Produk::all();
        return view('pembelian.create', compact('suppliers', 'tipes', 'produks'));
    }

    /**
     * Menyimpan pembelian baru ke dalam database dan update stok produk.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_pesan' => 'required|date',
            'supplier_idsupplier' => 'required|exists:suppliers,idsupplier',
            'tipe_idtipe' => 'required|exists:tipes,idtipe',
            'products' => 'required|array|min:1',
            'products.*.produk_id' => 'required|exists:produks,idproduk',
            'products.*.harga' => 'required|numeric|min:0',
            'products.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Buat pembelian baru
            $pembelian = Pembelian::create([
                'tanggal_pesan' => $request->tanggal_pesan,
                'supplier_idsupplier' => $request->supplier_idsupplier,
                'tipe_idtipe' => $request->tipe_idtipe,
            ]);

            $totalPembelian = 0;

            // Simpan detail pembelian dan update stok
            foreach ($request->products as $product) {
                PembelianDetil::create([
                    'pembelian_id' => $pembelian->idpembelian,
                    'produk_id' => $product['produk_id'],
                    'harga' => $product['harga'],
                    'jumlah' => $product['jumlah'],
                ]);

                // Update stok produk dan hitung HPP average
                $produk = Produk::find($product['produk_id']);
                if ($produk) {
                    $stokLama = $produk->stok;
                    $hppLama = $produk->harga_beli ?? 0;
                    $qtyBeli = $product['jumlah'];
                    $hargaBeli = $product['harga'];

                    // Hitung HPP baru dengan weighted average
                    $nilaiLama = $stokLama * $hppLama;
                    $nilaiBaru = $qtyBeli * $hargaBeli;
                    $stokBaru = $stokLama + $qtyBeli;

                    // Hindari division by zero
                    $hppBaru = $stokBaru > 0 ? ($nilaiLama + $nilaiBaru) / $stokBaru : $hargaBeli;

                    // Update produk
                    $produk->stok = $stokBaru;
                    $produk->harga_beli = round($hppBaru);
                    $produk->save();

                    // Record ke inventory history
                    InventoryHistory::create([
                        'produk_id' => $produk->idproduk,
                        'tanggal' => Carbon::parse($request->tanggal_pesan),
                        'tipe' => 'pembelian',
                        'qty_before' => $stokLama,
                        'qty_change' => $qtyBeli,
                        'qty_after' => $stokBaru,
                        'harga_beli' => $hargaBeli,
                        'referensi_id' => $pembelian->idpembelian,
                        'referensi_tipe' => 'Pembelian',
                        'keterangan' => 'Pembelian dari ' . Supplier::find($request->supplier_idsupplier)->nama,
                    ]);
                }

                $totalPembelian += $product['harga'] * $product['jumlah'];
            }

            // Get current POS session
            $posSessionId = session('pos_session');

            // Get current session to calculate new balance
            $posSession = $posSessionId ? PosSession::find($posSessionId) : null;
            $balanceAwal = $posSession ? ($posSession->balance_akhir ?? $posSession->balance_awal) : 0;
            $balanceAkhir = $balanceAwal - $totalPembelian; // Subtract for cash out

            // Catat cash flow sebagai pengeluaran (cash out)
            CashFlow::create([
                'balance_awal' => $balanceAwal,
                'balance_akhir' => $balanceAkhir,
                'tanggal' => $request->tanggal_pesan,
                'keterangan' => 'Pembelian dari ' . Supplier::find($request->supplier_idsupplier)->nama,
                'tipe' => 'cash_out',
                'jumlah' => $totalPembelian,
                'id_pos_session' => $posSessionId,
            ]);

            // Update session balance_akhir if session exists
            if ($posSession) {
                $posSession->balance_akhir = $balanceAkhir;
                $posSession->save();
            }

            DB::commit();

            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil ditambahkan dan stok telah diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan form untuk mengedit pembelian.
     */
    public function edit($id)
    {
        $pembelian = Pembelian::with('detils.produk')->findOrFail($id);
        $suppliers = Supplier::all();
        $tipes = Tipe::all();
        $produks = Produk::all();
        return view('pembelian.edit', compact('pembelian', 'suppliers', 'tipes', 'produks'));
    }

    /**
     * Memperbarui pembelian yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal_pesan' => 'required|date',
            'supplier_idsupplier' => 'required|exists:suppliers,idsupplier',
            'tipe_idtipe' => 'required|exists:tipes,idtipe',
            'products' => 'required|array|min:1',
            'products.*.produk_id' => 'required|exists:produks,idproduk',
            'products.*.harga' => 'required|numeric|min:0',
            'products.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $pembelian = Pembelian::findOrFail($id);

            // Kembalikan stok dari detail pembelian lama
            foreach ($pembelian->detils as $detil) {
                $produk = Produk::find($detil->produk_id);
                if ($produk) {
                    $stokLama = $produk->stok;
                    $produk->stok -= $detil->jumlah;

                    // Record inventory history untuk reverse
                    InventoryHistory::create([
                        'produk_id' => $produk->idproduk,
                        'tanggal' => Carbon::now(),
                        'tipe' => 'adjustment',
                        'qty_before' => $stokLama,
                        'qty_change' => -$detil->jumlah,
                        'qty_after' => $produk->stok,
                        'harga_beli' => $produk->harga_beli,
                        'referensi_id' => $pembelian->idpembelian,
                        'referensi_tipe' => 'Pembelian (Reverse)',
                        'keterangan' => 'Reverse stok karena edit pembelian #' . $pembelian->idpembelian,
                    ]);

                    $produk->save();
                }
            }

            // Hapus detail pembelian lama
            PembelianDetil::where('pembelian_id', $id)->delete();

            // Update data pembelian
            $pembelian->update([
                'tanggal_pesan' => $request->tanggal_pesan,
                'supplier_idsupplier' => $request->supplier_idsupplier,
                'tipe_idtipe' => $request->tipe_idtipe,
            ]);

            $totalPembelian = 0;

            // Simpan detail pembelian baru dan update stok
            foreach ($request->products as $product) {
                PembelianDetil::create([
                    'pembelian_id' => $pembelian->idpembelian,
                    'produk_id' => $product['produk_id'],
                    'harga' => $product['harga'],
                    'jumlah' => $product['jumlah'],
                ]);

                // Update stok produk dan hitung HPP average
                $produk = Produk::find($product['produk_id']);
                if ($produk) {
                    $stokLama = $produk->stok;
                    $hppLama = $produk->harga_beli ?? 0;
                    $qtyBeli = $product['jumlah'];
                    $hargaBeli = $product['harga'];

                    // Hitung HPP baru dengan weighted average
                    $nilaiLama = $stokLama * $hppLama;
                    $nilaiBaru = $qtyBeli * $hargaBeli;
                    $stokBaru = $stokLama + $qtyBeli;

                    // Hindari division by zero
                    $hppBaru = $stokBaru > 0 ? ($nilaiLama + $nilaiBaru) / $stokBaru : $hargaBeli;

                    // Update produk
                    $produk->stok = $stokBaru;
                    $produk->harga_beli = round($hppBaru);
                    $produk->save();

                    // Record ke inventory history
                    InventoryHistory::create([
                        'produk_id' => $produk->idproduk,
                        'tanggal' => Carbon::parse($request->tanggal_pesan),
                        'tipe' => 'pembelian',
                        'qty_before' => $stokLama,
                        'qty_change' => $qtyBeli,
                        'qty_after' => $stokBaru,
                        'harga_beli' => $hargaBeli,
                        'referensi_id' => $pembelian->idpembelian,
                        'referensi_tipe' => 'Pembelian (Edit)',
                        'keterangan' => 'Edit pembelian dari ' . Supplier::find($request->supplier_idsupplier)->nama,
                    ]);
                }

                $totalPembelian += $product['harga'] * $product['jumlah'];
            }

            DB::commit();

            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus pembelian dari database dan kembalikan stok.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $pembelian = Pembelian::with('detils')->findOrFail($id);

            // Kembalikan stok dari detail pembelian
            foreach ($pembelian->detils as $detil) {
                $produk = Produk::find($detil->produk_id);
                if ($produk) {
                    $stokLama = $produk->stok;
                    $produk->stok -= $detil->jumlah;

                    // Record inventory history untuk penghapusan
                    InventoryHistory::create([
                        'produk_id' => $produk->idproduk,
                        'tanggal' => Carbon::now(),
                        'tipe' => 'adjustment',
                        'qty_before' => $stokLama,
                        'qty_change' => -$detil->jumlah,
                        'qty_after' => $produk->stok,
                        'harga_beli' => $produk->harga_beli,
                        'referensi_id' => $pembelian->idpembelian,
                        'referensi_tipe' => 'Pembelian (Delete)',
                        'keterangan' => 'Hapus pembelian #' . $pembelian->idpembelian,
                    ]);

                    $produk->save();
                }
            }

            // Hapus detail pembelian
            PembelianDetil::where('pembelian_id', $id)->delete();

            // Hapus pembelian
            $pembelian->delete();

            DB::commit();

            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus dan stok telah dikembalikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getEditForm(Request $request)
    {
        $pembelian = Pembelian::with(['detils.produk', 'supplier', 'tipe'])->find($request->id);
        $suppliers = Supplier::all();
        $tipes = Tipe::all();
        $produks = Produk::all();

        return response()->json(array(
            'status' => 'oke',
            'msg' => view('pembelian.modal', compact('pembelian', 'suppliers', 'tipes', 'produks'))->render()
        ), 200);
    }
}
