<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

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

    public function data(Request $request)
    {
        try {
            $produks = Produk::where('kategori_idkategori', $request->kategori_id)->get();
            return view('penjualan.data', compact('produks'))->render();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
