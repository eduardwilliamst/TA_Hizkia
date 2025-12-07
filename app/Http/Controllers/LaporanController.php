<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\PenjualanDetil;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display laporan index page
     */
    public function index()
    {
        $users = User::all();
        $kategoris = Kategori::all();

        return view('laporan.index', compact('users', 'kategoris'));
    }

    /**
     * Generate PDF Laporan Penjualan
     */
    public function laporanPenjualan(Request $request)
    {
        // Parse periode
        $dateRange = $this->getDateRange($request->periode, $request->tanggal_mulai, $request->tanggal_akhir);

        // Query penjualan
        $query = Penjualan::whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);

        if ($request->user_id) {
            $query->where('user_iduser', $request->user_id);
        }

        $penjualans = $query->with(['details.produk', 'user'])->get();

        // Calculate statistics
        $totalTransaksi = $penjualans->count();
        $totalPendapatan = $penjualans->sum('total_harga');
        $totalItem = $penjualans->sum(function($penjualan) {
            return $penjualan->details->sum('jumlah');
        });
        $avgPerTransaksi = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        // Payment method breakdown
        $cashTransaksi = $penjualans->where('cara_bayar', 'cash')->count();
        $creditTransaksi = $penjualans->where('cara_bayar', 'credit')->count();
        $cashTotal = $penjualans->where('cara_bayar', 'cash')->sum('total_harga');
        $creditTotal = $penjualans->where('cara_bayar', 'credit')->sum('total_harga');

        // Top products
        $topProducts = PenjualanDetil::whereIn('penjualan_idpenjualan', $penjualans->pluck('idpenjualan'))
            ->selectRaw('produk_idproduk, SUM(jumlah) as total_qty, SUM(subtotal) as total_revenue')
            ->groupBy('produk_idproduk')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->with('produk')
            ->get();

        // Sales by hour (for today or single day only)
        $salesByHour = [];
        if ($request->periode == 'today' || $request->periode == 'yesterday') {
            $salesByHour = $penjualans->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('H:00');
            })->map(function($items) {
                return [
                    'count' => $items->count(),
                    'total' => $items->sum('total_harga')
                ];
            });
        }

        // Kasir performance (if admin)
        $kasirPerformance = [];
        if (auth()->user()->hasRole('admin') && !$request->user_id) {
            $kasirPerformance = $penjualans->groupBy('user_iduser')->map(function($items) {
                return [
                    'name' => $items->first()->user->name ?? 'Unknown',
                    'count' => $items->count(),
                    'total' => $items->sum('total_harga')
                ];
            });
        }

        $data = [
            'periode' => $this->getPeriodeName($request->periode, $dateRange),
            'dateRange' => $dateRange,
            'totalTransaksi' => $totalTransaksi,
            'totalPendapatan' => $totalPendapatan,
            'totalItem' => $totalItem,
            'avgPerTransaksi' => $avgPerTransaksi,
            'cashTransaksi' => $cashTransaksi,
            'creditTransaksi' => $creditTransaksi,
            'cashTotal' => $cashTotal,
            'creditTotal' => $creditTotal,
            'topProducts' => $topProducts,
            'salesByHour' => $salesByHour,
            'kasirPerformance' => $kasirPerformance,
            'generatedAt' => Carbon::now()->format('d/m/Y H:i'),
            'generatedBy' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('laporan.pdf.penjualan', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan-Penjualan-' . date('YmdHis') . '.pdf');
    }

    /**
     * Generate PDF Laporan Stok
     */
    public function laporanStok(Request $request)
    {
        $query = Produk::with('kategori');

        // Filter by stock status
        switch ($request->filter_stok) {
            case 'rendah':
                $query->where('stok', '<', 10)->where('stok', '>', 0);
                break;
            case 'habis':
                $query->where('stok', 0);
                break;
            case 'tinggi':
                $query->where('stok', '>', 100);
                break;
        }

        // Filter by category
        if ($request->kategori_id) {
            $query->where('kategori_idkategori', $request->kategori_id);
        }

        $produks = $query->orderBy('stok', 'asc')->get();

        // Calculate statistics
        $totalProduk = $produks->count();
        $totalNilaiInventori = $produks->sum(function($produk) {
            return $produk->stok * $produk->harga;
        });
        $produkStokRendah = Produk::where('stok', '<', 10)->where('stok', '>', 0)->count();
        $produkStokHabis = Produk::where('stok', 0)->count();

        // Category breakdown
        $categoryBreakdown = $produks->groupBy('kategori_idkategori')->map(function($items) {
            return [
                'nama' => $items->first()->kategori->nama ?? 'Unknown',
                'count' => $items->count(),
                'total_stok' => $items->sum('stok'),
                'nilai' => $items->sum(function($item) {
                    return $item->stok * $item->harga;
                })
            ];
        });

        $data = [
            'filterStok' => $this->getFilterStokName($request->filter_stok),
            'kategori' => $request->kategori_id ? Kategori::find($request->kategori_id)->nama : 'Semua Kategori',
            'produks' => $produks,
            'totalProduk' => $totalProduk,
            'totalNilaiInventori' => $totalNilaiInventori,
            'produkStokRendah' => $produkStokRendah,
            'produkStokHabis' => $produkStokHabis,
            'categoryBreakdown' => $categoryBreakdown,
            'generatedAt' => Carbon::now()->format('d/m/Y H:i'),
            'generatedBy' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('laporan.pdf.stok', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan-Stok-' . date('YmdHis') . '.pdf');
    }

    /**
     * Helper: Get date range from periode
     */
    private function getDateRange($periode, $startDate = null, $endDate = null)
    {
        switch ($periode) {
            case 'today':
                return [
                    'start' => Carbon::today(),
                    'end' => Carbon::tomorrow()
                ];
            case 'yesterday':
                return [
                    'start' => Carbon::yesterday(),
                    'end' => Carbon::today()
                ];
            case 'this_week':
                return [
                    'start' => Carbon::now()->startOfWeek(),
                    'end' => Carbon::now()->endOfWeek()
                ];
            case 'last_week':
                return [
                    'start' => Carbon::now()->subWeek()->startOfWeek(),
                    'end' => Carbon::now()->subWeek()->endOfWeek()
                ];
            case 'this_month':
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth()
                ];
            case 'last_month':
                return [
                    'start' => Carbon::now()->subMonth()->startOfMonth(),
                    'end' => Carbon::now()->subMonth()->endOfMonth()
                ];
            case 'custom':
                return [
                    'start' => Carbon::parse($startDate),
                    'end' => Carbon::parse($endDate)->endOfDay()
                ];
            default:
                return [
                    'start' => Carbon::today(),
                    'end' => Carbon::tomorrow()
                ];
        }
    }

    /**
     * Helper: Get periode name for display
     */
    private function getPeriodeName($periode, $dateRange)
    {
        $names = [
            'today' => 'Hari Ini',
            'yesterday' => 'Kemarin',
            'this_week' => 'Minggu Ini',
            'last_week' => 'Minggu Lalu',
            'this_month' => 'Bulan Ini',
            'last_month' => 'Bulan Lalu',
        ];

        if ($periode == 'custom') {
            return $dateRange['start']->format('d/m/Y') . ' - ' . $dateRange['end']->format('d/m/Y');
        }

        return $names[$periode] ?? 'Unknown';
    }

    /**
     * Helper: Get filter stok name
     */
    private function getFilterStokName($filter)
    {
        $names = [
            'semua' => 'Semua Produk',
            'rendah' => 'Stok Rendah (<10 unit)',
            'habis' => 'Stok Habis (0 unit)',
            'tinggi' => 'Stok Berlebih (>100 unit)',
        ];

        return $names[$filter] ?? 'Semua Produk';
    }
}
