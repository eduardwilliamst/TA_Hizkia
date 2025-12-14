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
     * View Laporan Penjualan (Web with Charts)
     */
    public function viewLaporanPenjualan(Request $request)
    {
        // Parse periode
        $dateRange = $this->getDateRange($request->periode, $request->tanggal_mulai, $request->tanggal_akhir);

        // Query penjualan
        $query = Penjualan::whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);

        if ($request->user_id) {
            $query->where('user_iduser', $request->user_id);
        }

        $penjualans = $query->with(['penjualanDetils.produk', 'user'])->get();

        // Calculate statistics
        $totalTransaksi = $penjualans->count();
        $totalPendapatan = $penjualans->sum('total_harga');
        $totalItem = $penjualans->sum(function($penjualan) {
            return $penjualan->penjualanDetils->sum('jumlah');
        });
        $avgPerTransaksi = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        // Payment method breakdown
        $cashTransaksi = $penjualans->where('cara_bayar', 'cash')->count();
        $creditTransaksi = $penjualans->where('cara_bayar', 'credit')->count();
        $cashTotal = $penjualans->where('cara_bayar', 'cash')->sum('total_harga');
        $creditTotal = $penjualans->where('cara_bayar', 'credit')->sum('total_harga');

        // Top products
        $topProducts = PenjualanDetil::whereIn('penjualan_idpenjualan', $penjualans->pluck('idpenjualan'))
            ->selectRaw('produk_idproduk, SUM(jumlah) as total_qty, SUM(sub_total) as total_revenue')
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

        return view('laporan.view.penjualan', $data);
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

        $penjualans = $query->with(['penjualanDetils.produk', 'user'])->get();

        // Calculate statistics
        $totalTransaksi = $penjualans->count();
        $totalPendapatan = $penjualans->sum('total_harga');
        $totalItem = $penjualans->sum(function($penjualan) {
            return $penjualan->penjualanDetils->sum('jumlah');
        });
        $avgPerTransaksi = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        // Payment method breakdown
        $cashTransaksi = $penjualans->where('cara_bayar', 'cash')->count();
        $creditTransaksi = $penjualans->where('cara_bayar', 'credit')->count();
        $cashTotal = $penjualans->where('cara_bayar', 'cash')->sum('total_harga');
        $creditTotal = $penjualans->where('cara_bayar', 'credit')->sum('total_harga');

        // Top products
        $topProducts = PenjualanDetil::whereIn('penjualan_idpenjualan', $penjualans->pluck('idpenjualan'))
            ->selectRaw('produk_idproduk, SUM(jumlah) as total_qty, SUM(sub_total) as total_revenue')
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

    /**
     * Generate PDF Laporan Omzet Penjualan
     */
    public function laporanOmzet(Request $request)
    {
        $dateRange = $this->getDateRange($request->periode, $request->tanggal_mulai, $request->tanggal_akhir);

        $query = Penjualan::whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
        $penjualans = $query->with(['penjualanDetils.produk', 'user'])->get();

        // Omzet by date
        $omzetByDate = $penjualans->groupBy(function($item) {
            return Carbon::parse($item->created_at)->format('Y-m-d');
        })->map(function($items, $date) {
            return [
                'tanggal' => Carbon::parse($date)->format('d/m/Y'),
                'transaksi' => $items->count(),
                'omzet' => $items->sum('total_harga'),
                'cash' => $items->where('cara_bayar', 'cash')->sum('total_harga'),
                'credit' => $items->where('cara_bayar', 'credit')->sum('total_harga'),
            ];
        })->sortKeys();

        // Summary
        $totalOmzet = $penjualans->sum('total_harga');
        $totalTransaksi = $penjualans->count();
        $rataRataPerHari = $omzetByDate->count() > 0 ? $totalOmzet / $omzetByDate->count() : 0;
        $hariTertinggi = $omzetByDate->sortByDesc('omzet')->first();
        $hariTerendah = $omzetByDate->sortBy('omzet')->first();

        $data = [
            'periode' => $this->getPeriodeName($request->periode, $dateRange),
            'dateRange' => $dateRange,
            'omzetByDate' => $omzetByDate,
            'totalOmzet' => $totalOmzet,
            'totalTransaksi' => $totalTransaksi,
            'rataRataPerHari' => $rataRataPerHari,
            'hariTertinggi' => $hariTertinggi,
            'hariTerendah' => $hariTerendah,
            'generatedAt' => Carbon::now()->format('d/m/Y H:i'),
            'generatedBy' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('laporan.pdf.omzet', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Laporan-Omzet-' . date('YmdHis') . '.pdf');
    }

    /**
     * Generate PDF Laporan Laba Rugi
     */
    public function laporanLabaRugi(Request $request)
    {
        $dateRange = $this->getDateRange($request->periode, $request->tanggal_mulai, $request->tanggal_akhir);

        $penjualans = Penjualan::whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->with(['penjualanDetils.produk'])
            ->get();

        // Revenue
        $totalPendapatan = $penjualans->sum('total_harga');
        $totalDiskon = $penjualans->sum('total_diskon');
        $pendapatanBersih = $totalPendapatan - $totalDiskon;

        // COGS (Cost of Goods Sold) - using harga_beli from produk
        $hpp = 0;
        foreach ($penjualans as $penjualan) {
            foreach ($penjualan->penjualanDetils as $detil) {
                if ($detil->produk) {
                    $hpp += ($detil->produk->harga_beli ?? 0) * $detil->jumlah;
                }
            }
        }

        // Profit
        $labaBersih = $pendapatanBersih - $hpp;
        $marginLaba = $pendapatanBersih > 0 ? ($labaBersih / $pendapatanBersih) * 100 : 0;

        // Breakdown by payment method
        $cashRevenue = $penjualans->where('cara_bayar', 'cash')->sum('total_harga');
        $creditRevenue = $penjualans->where('cara_bayar', 'credit')->sum('total_harga');

        // Product contribution to profit
        $productProfit = [];
        foreach ($penjualans as $penjualan) {
            foreach ($penjualan->penjualanDetils as $detil) {
                if ($detil->produk) {
                    $produkId = $detil->produk->idproduk;
                    if (!isset($productProfit[$produkId])) {
                        $productProfit[$produkId] = [
                            'nama' => $detil->produk->nama,
                            'qty' => 0,
                            'revenue' => 0,
                            'hpp' => 0,
                            'profit' => 0,
                        ];
                    }
                    $productProfit[$produkId]['qty'] += $detil->jumlah;
                    $productProfit[$produkId]['revenue'] += $detil->sub_total;
                    $cogs = ($detil->produk->harga_beli ?? 0) * $detil->jumlah;
                    $productProfit[$produkId]['hpp'] += $cogs;
                    $productProfit[$produkId]['profit'] += ($detil->sub_total - $cogs);
                }
            }
        }
        $productProfit = collect($productProfit)->sortByDesc('profit')->take(10);

        $data = [
            'periode' => $this->getPeriodeName($request->periode, $dateRange),
            'dateRange' => $dateRange,
            'totalPendapatan' => $totalPendapatan,
            'totalDiskon' => $totalDiskon,
            'pendapatanBersih' => $pendapatanBersih,
            'hpp' => $hpp,
            'labaBersih' => $labaBersih,
            'marginLaba' => $marginLaba,
            'cashRevenue' => $cashRevenue,
            'creditRevenue' => $creditRevenue,
            'productProfit' => $productProfit,
            'generatedAt' => Carbon::now()->format('d/m/Y H:i'),
            'generatedBy' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('laporan.pdf.laba-rugi', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Laporan-Laba-Rugi-' . date('YmdHis') . '.pdf');
    }

    /**
     * Generate PDF Laporan Detail Transaksi
     */
    public function laporanDetailTransaksi(Request $request)
    {
        $dateRange = $this->getDateRange($request->periode, $request->tanggal_mulai, $request->tanggal_akhir);

        $query = Penjualan::whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);

        if ($request->user_id) {
            $query->where('user_iduser', $request->user_id);
        }

        if ($request->cara_bayar) {
            $query->where('cara_bayar', $request->cara_bayar);
        }

        $penjualans = $query->with(['penjualanDetils.produk', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'periode' => $this->getPeriodeName($request->periode, $dateRange),
            'dateRange' => $dateRange,
            'penjualans' => $penjualans,
            'totalTransaksi' => $penjualans->count(),
            'totalNilai' => $penjualans->sum('total_harga'),
            'filter_kasir' => $request->user_id ? User::find($request->user_id)->name : 'Semua Kasir',
            'filter_bayar' => $request->cara_bayar ? strtoupper($request->cara_bayar) : 'Semua Metode',
            'generatedAt' => Carbon::now()->format('d/m/Y H:i'),
            'generatedBy' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('laporan.pdf.detail-transaksi', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Laporan-Detail-Transaksi-' . date('YmdHis') . '.pdf');
    }

    /**
     * Generate PDF Laporan Inventory
     */
    public function laporanInventory(Request $request)
    {
        $query = Produk::with('kategori');

        if ($request->kategori_id) {
            $query->where('kategori_idkategori', $request->kategori_id);
        }

        $produks = $query->orderBy('nama', 'asc')->get();

        // Inventory statistics
        $totalProduk = $produks->count();
        $totalNilaiModal = $produks->sum(function($produk) {
            return ($produk->harga_beli ?? 0) * $produk->stok;
        });
        $totalNilaiJual = $produks->sum(function($produk) {
            return $produk->harga * $produk->stok;
        });
        $potensiLaba = $totalNilaiJual - $totalNilaiModal;

        // Stock alerts
        $stokHabis = $produks->where('stok', 0)->count();
        $stokRendah = $produks->where('stok', '>', 0)->where('stok', '<', 10)->count();
        $stokAman = $produks->where('stok', '>=', 10)->count();

        // Category breakdown
        $categoryInventory = $produks->groupBy('kategori_idkategori')->map(function($items) {
            return [
                'nama' => $items->first()->kategori->nama ?? 'Unknown',
                'jumlah_produk' => $items->count(),
                'total_stok' => $items->sum('stok'),
                'nilai_modal' => $items->sum(function($item) {
                    return ($item->harga_beli ?? 0) * $item->stok;
                }),
                'nilai_jual' => $items->sum(function($item) {
                    return $item->harga * $item->stok;
                }),
            ];
        })->sortByDesc('nilai_jual');

        // Most valuable inventory items
        $topValueProducts = $produks->map(function($produk) {
            return [
                'nama' => $produk->nama,
                'stok' => $produk->stok,
                'harga_beli' => $produk->harga_beli ?? 0,
                'harga_jual' => $produk->harga,
                'nilai_modal' => ($produk->harga_beli ?? 0) * $produk->stok,
                'nilai_jual' => $produk->harga * $produk->stok,
            ];
        })->sortByDesc('nilai_jual')->take(10);

        $data = [
            'kategori' => $request->kategori_id ? Kategori::find($request->kategori_id)->nama : 'Semua Kategori',
            'produks' => $produks,
            'totalProduk' => $totalProduk,
            'totalNilaiModal' => $totalNilaiModal,
            'totalNilaiJual' => $totalNilaiJual,
            'potensiLaba' => $potensiLaba,
            'stokHabis' => $stokHabis,
            'stokRendah' => $stokRendah,
            'stokAman' => $stokAman,
            'categoryInventory' => $categoryInventory,
            'topValueProducts' => $topValueProducts,
            'generatedAt' => Carbon::now()->format('d/m/Y H:i'),
            'generatedBy' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('laporan.pdf.inventory', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Laporan-Inventory-' . date('YmdHis') . '.pdf');
    }
}
