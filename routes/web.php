<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PosMesinController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CashFlowController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/balanceAwal', [HomeController::class, 'store'])->name('balance.store');

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

Route::resource('produk', ProdukController::class);
Route::post('produk/getEditForm', [ProdukController::class, 'getEditForm'])->name('produk.getEditForm');

Route::resource('promo', PromoController::class);
Route::post('promo/getEditForm', [PromoController::class, 'getEditForm'])->name('promo.getEditForm');

Route::resource('supplier', SupplierController::class);
Route::post('supplier/getEditForm', [SupplierController::class, 'getEditForm'])->name('supplier.getEditForm');

Route::resource('users', UserController::class);
Route::post('users/getEditForm', [UserController::class, 'getEditForm'])->name('users.getEditForm');
