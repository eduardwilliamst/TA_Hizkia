<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PosSession;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        // Get today's date
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // Total Products
        $totalProducts = DB::table('produks')->count();

        // Low Stock Products (stock <= 10)
        $lowStockProducts = DB::table('produks')->where('stok', '<=', 10)->count();

        // Total Categories
        $totalCategories = DB::table('kategoris')->count();

        // Total Suppliers
        $totalSuppliers = DB::table('suppliers')->count();

        // Today's Sales
        $todaySales = DB::table('penjualans')
            ->whereDate('created_at', $today)
            ->count();

        // Today's Revenue
        $todayRevenue = DB::table('penjualans')
            ->whereDate('created_at', $today)
            ->sum('total_harga');

        // This Month's Sales
        $monthSales = DB::table('penjualans')
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();

        // This Month's Revenue
        $monthRevenue = DB::table('penjualans')
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->sum('total_harga');

        // Total Users
        $totalUsers = DB::table('users')->count();

        // Total POS Sessions
        $activeSessions = DB::table('pos_sessions')
            ->count();

        // Recent Sales (Last 10)
        $recentSales = DB::table('penjualans')
            ->join('users', 'penjualans.user_iduser', '=', 'users.id')
            ->select('penjualans.*', 'users.name as user_name')
            ->orderBy('penjualans.created_at', 'desc')
            ->limit(10)
            ->get();

        // Top Selling Products (This Month)
        $topProducts = DB::table('penjualan_detils')
            ->join('produks', 'penjualan_detils.produk_idproduk', '=', 'produks.idproduk')
            ->join('penjualans', 'penjualan_detils.penjualan_idpenjualan', '=', 'penjualans.idpenjualan')
            ->whereMonth('penjualans.created_at', $thisMonth)
            ->whereYear('penjualans.created_at', $thisYear)
            ->select('produks.nama', DB::raw('SUM(penjualan_detils.jumlah) as total_qty'), DB::raw('SUM(penjualan_detils.sub_total) as total_revenue'))
            ->groupBy('produks.idproduk', 'produks.nama')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        // Low Stock Products Details
        $lowStockDetails = DB::table('produks')
            ->join('kategoris', 'produks.kategori_idkategori', '=', 'kategoris.idkategori')
            ->where('produks.stok', '<=', 10)
            ->select('produks.*', 'kategoris.nama as kategori_nama')
            ->orderBy('produks.stok', 'asc')
            ->limit(10)
            ->get();

        // Sales Chart Data (Last 7 Days)
        $salesChartData = [];
        $salesChartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $salesChartLabels[] = $date->format('d M');
            $salesChartData[] = DB::table('penjualans')
                ->whereDate('created_at', $date)
                ->sum('total_harga');
        }

        // Category-wise Product Count
        $categoryStats = DB::table('kategoris')
            ->leftJoin('produks', 'kategoris.idkategori', '=', 'produks.kategori_idkategori')
            ->select('kategoris.nama', DB::raw('COUNT(produks.idproduk) as product_count'))
            ->groupBy('kategoris.idkategori', 'kategoris.nama')
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'totalCategories',
            'totalSuppliers',
            'todaySales',
            'todayRevenue',
            'monthSales',
            'monthRevenue',
            'totalUsers',
            'activeSessions',
            'recentSales',
            'topProducts',
            'lowStockDetails',
            'salesChartData',
            'salesChartLabels',
            'categoryStats'
        ));
    }

    public function store(Request $request)
    {
        $id_pos_session = session('pos_session');
        $possession = PosSession::where('idpos_session', $id_pos_session)->get();
        return view('dashboard');
    }

    /**
     * Admin Dashboard - Analytics & Management focused
     */
    public function adminDashboard()
    {
        // Get today's date
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // Total Products
        $totalProducts = DB::table('produks')->count();

        // Low Stock Products (stock <= 10)
        $lowStockProducts = DB::table('produks')->where('stok', '<=', 10)->count();

        // Total Categories
        $totalCategories = DB::table('kategoris')->count();

        // Total Suppliers
        $totalSuppliers = DB::table('suppliers')->count();

        // Today's Sales
        $todaySales = DB::table('penjualans')
            ->whereDate('created_at', $today)
            ->count();

        // Today's Revenue
        $todayRevenue = DB::table('penjualans')
            ->whereDate('created_at', $today)
            ->sum('total_harga');

        // This Month's Sales
        $monthSales = DB::table('penjualans')
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();

        // This Month's Revenue
        $monthRevenue = DB::table('penjualans')
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->sum('total_harga');

        // Total Users
        $totalUsers = DB::table('users')->count();

        // Total POS Sessions
        $activeSessions = DB::table('pos_sessions')
            ->count();

        // Recent Sales (Last 10)
        $recentSales = DB::table('penjualans')
            ->join('users', 'penjualans.user_iduser', '=', 'users.id')
            ->select('penjualans.*', 'users.name as user_name')
            ->orderBy('penjualans.created_at', 'desc')
            ->limit(10)
            ->get();

        // Top Selling Products (This Month)
        $topProducts = DB::table('penjualan_detils')
            ->join('produks', 'penjualan_detils.produk_idproduk', '=', 'produks.idproduk')
            ->join('penjualans', 'penjualan_detils.penjualan_idpenjualan', '=', 'penjualans.idpenjualan')
            ->whereMonth('penjualans.created_at', $thisMonth)
            ->whereYear('penjualans.created_at', $thisYear)
            ->select('produks.nama', DB::raw('SUM(penjualan_detils.jumlah) as total_qty'), DB::raw('SUM(penjualan_detils.sub_total) as total_revenue'))
            ->groupBy('produks.idproduk', 'produks.nama')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        // Low Stock Products Details
        $lowStockDetails = DB::table('produks')
            ->join('kategoris', 'produks.kategori_idkategori', '=', 'kategoris.idkategori')
            ->where('produks.stok', '<=', 10)
            ->select('produks.*', 'kategoris.nama as kategori_nama')
            ->orderBy('produks.stok', 'asc')
            ->limit(10)
            ->get();

        // Sales Chart Data (Last 7 Days)
        $salesChartData = [];
        $salesChartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $salesChartLabels[] = $date->format('d M');
            $salesChartData[] = DB::table('penjualans')
                ->whereDate('created_at', $date)
                ->sum('total_harga');
        }

        // Category-wise Product Count
        $categoryStats = DB::table('kategoris')
            ->leftJoin('produks', 'kategoris.idkategori', '=', 'produks.kategori_idkategori')
            ->select('kategoris.nama', DB::raw('COUNT(produks.idproduk) as product_count'))
            ->groupBy('kategoris.idkategori', 'kategoris.nama')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'totalCategories',
            'totalSuppliers',
            'todaySales',
            'todayRevenue',
            'monthSales',
            'monthRevenue',
            'totalUsers',
            'activeSessions',
            'recentSales',
            'topProducts',
            'lowStockDetails',
            'salesChartData',
            'salesChartLabels',
            'categoryStats'
        ));
    }

    /**
     * Cashier Dashboard - POS focused
     */
    public function cashierDashboard()
    {
        // Get POS session info
        $posSessionId = session('pos_session');
        $posSession = null;

        if ($posSessionId) {
            $posSession = PosSession::with('posMesin')->find($posSessionId);
        }

        // Today's sales for this cashier
        $todaySales = DB::table('penjualans')
            ->whereDate('created_at', Carbon::today())
            ->where('user_iduser', auth()->id())
            ->count();

        $todayRevenue = DB::table('penjualans')
            ->whereDate('created_at', Carbon::today())
            ->where('user_iduser', auth()->id())
            ->sum('total_harga');

        // Recent sales by this cashier
        $recentSales = DB::table('penjualans')
            ->where('user_iduser', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Low stock alerts
        $lowStockProducts = DB::table('produks')
            ->join('kategoris', 'produks.kategori_idkategori', '=', 'kategoris.idkategori')
            ->where('produks.stok', '<=', 10)
            ->select('produks.*', 'kategoris.nama as kategori_nama')
            ->orderBy('produks.stok', 'asc')
            ->limit(5)
            ->get();

        return view('cashier.dashboard', compact(
            'posSession',
            'todaySales',
            'todayRevenue',
            'recentSales',
            'lowStockProducts'
        ));
    }
}
