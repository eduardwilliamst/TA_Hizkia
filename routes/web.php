<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PosMesinController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\SupplierController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::resource('cart', CartController::class);

// Menambahkan resource routes untuk controller yang telah Anda buat
Route::resource('diskon', DiskonController::class);
Route::post('diskon/getEditForm', [DiskonController::class, 'getEditForm'])->name('diskon.getEditForm');

// Tambahkan getEditForm untuk resource lainnya
Route::resource('kategori', KategoriController::class);
Route::post('kategori/getEditForm', [KategoriController::class, 'getEditForm'])->name('kategori.getEditForm');

Route::resource('pembelian', PembelianController::class);
Route::post('pembelian/getEditForm', [PembelianController::class, 'getEditForm'])->name('pembelian.getEditForm');

Route::resource('penjualan', PenjualanController::class);
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

