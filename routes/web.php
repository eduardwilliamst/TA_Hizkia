<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PosMesinController;
use App\Http\Controllers\PosSessionController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TipeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CashFlowController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Role-based dashboards
    Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/cashier/dashboard', [HomeController::class, 'cashierDashboard'])->name('user.dashboard');

    Route::post('/balanceAwal', [HomeController::class, 'store'])->name('balance.store');

    Route::get('cart', [PenjualanController::class, 'viewCart'])->name('penjualan.viewCart');
    Route::post('cart/save', [CartController::class, 'save'])->name('cart.save');
    Route::post('cart/add', [PenjualanController::class, 'addToCart'])->name('penjualan.addToCart');
    Route::post('cart/checkout', [PenjualanController::class, 'checkout'])->name('penjualan.checkout');
    Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Menambahkan resource routes untuk controller yang telah Anda buat
    // Route::resource('diskon', DiskonController::class);
    // Route::post('diskon/getEditForm', [DiskonController::class, 'getEditForm'])->name('diskon.getEditForm');

    Route::resource('cashflow', CashFlowController::class);
    Route::post('cashflow/getEditForm', [CashFlowController::class, 'getEditForm'])->name('cashflow.getEditForm');

    // Tambahkan getEditForm untuk resource lainnya
    Route::resource('kategori', KategoriController::class);
    Route::post('kategori/getEditForm', [KategoriController::class, 'getEditForm'])->name('kategori.getEditForm');

    Route::resource('pembelian', PembelianController::class);
    Route::get('pembelian/listData', [PembelianController::class, 'listData'])->name('pembelian.listData');
    Route::post('pembelian/getEditForm', [PembelianController::class, 'getEditForm'])->name('pembelian.getEditForm');

    Route::resource('penjualan', PenjualanController::class);
    Route::get('penjualan/listData', [PenjualanController::class, 'listData'])->name('penjualan.listData');
    Route::post('penjualan/getEditForm', [PenjualanController::class, 'getEditForm'])->name('penjualan.getEditForm');
    Route::post('penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');

    Route::resource('posmesin', PosMesinController::class);
    Route::post('posmesin/getEditForm', [PosMesinController::class, 'getEditForm'])->name('posmesin.getEditForm');

    // POS Session routes
    Route::get('possession/open', [PosSessionController::class, 'showOpenSession'])->name('possession.show-open');
    Route::post('possession/open', [PosSessionController::class, 'openSession'])->name('possession.open');
    Route::get('possession/check', [PosSessionController::class, 'checkActiveSession'])->name('possession.check');
    Route::get('possession/close', [PosSessionController::class, 'showCloseSession'])->name('possession.show-close');
    Route::post('possession/close', [PosSessionController::class, 'processCloseSession'])->name('possession.process-close');
    Route::get('possession/summary', [PosSessionController::class, 'getSessionSummary'])->name('possession.summary');

    Route::resource('produk', ProdukController::class);
    Route::post('produk/getEditForm', [ProdukController::class, 'getEditForm'])->name('produk.getEditForm');
    Route::post('produk/getDetailForm', [ProdukController::class, 'getDetailForm'])->name('produk.getDetailForm');

    Route::resource('promo', PromoController::class);
    Route::post('promo/getEditForm', [PromoController::class, 'getEditForm'])->name('promo.getEditForm');

    Route::resource('supplier', SupplierController::class);
    Route::post('supplier/getEditForm', [SupplierController::class, 'getEditForm'])->name('supplier.getEditForm');

    Route::resource('tipe', TipeController::class);
    Route::post('tipe/getEditForm', [TipeController::class, 'getEditForm'])->name('tipe.getEditForm');

    Route::resource('users', UserController::class);
    Route::post('users/getEditForm', [UserController::class, 'getEditForm'])->name('users.getEditForm');

    // Profile routes
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // Laporan routes
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // Web views (with charts)
    Route::get('laporan/view/penjualan', [LaporanController::class, 'viewLaporanPenjualan'])->name('laporan.view.penjualan');

    // PDF downloads (formal, black & white)
    Route::post('laporan/penjualan', [LaporanController::class, 'laporanPenjualan'])->name('laporan.penjualan');
    Route::post('laporan/stok', [LaporanController::class, 'laporanStok'])->name('laporan.stok');
    Route::post('laporan/omzet', [LaporanController::class, 'laporanOmzet'])->name('laporan.omzet');
    Route::post('laporan/laba-rugi', [LaporanController::class, 'laporanLabaRugi'])->name('laporan.laba-rugi');
    Route::post('laporan/detail-transaksi', [LaporanController::class, 'laporanDetailTransaksi'])->name('laporan.detail-transaksi');
    Route::post('laporan/inventory', [LaporanController::class, 'laporanInventory'])->name('laporan.inventory');
});
