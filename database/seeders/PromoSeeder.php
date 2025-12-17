<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first two products from database (if any exist)
        $products = DB::table('produks')->limit(2)->pluck('idproduk')->toArray();

        // Skip if no products exist
        if (empty($products)) {
            return;
        }

        $produk1 = $products[0];
        $produk2 = $products[1] ?? $products[0];

        DB::table('promos')->insert([
            [
                'buy_x' => 2,
                'get_y' => 1,
                'deskripsi' => 'Beli 2 Gratis 1',
                'tanggal_awal' => Carbon::now()->subDays(5),
                'tanggal_akhir' => Carbon::now()->addDays(25),
                'tipe' => 'produk gratis',
                'produk_idutama' => $produk1,
                'produk_idtambahan' => $produk1,
                'nilai_diskon' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'buy_x' => 1,
                'get_y' => 0,
                'deskripsi' => 'Diskon 15%',
                'tanggal_awal' => Carbon::now()->subDays(2),
                'tanggal_akhir' => Carbon::now()->addDays(3),
                'tipe' => 'diskon',
                'produk_idutama' => $produk1,
                'produk_idtambahan' => null,
                'nilai_diskon' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'buy_x' => 3,
                'get_y' => 1,
                'deskripsi' => 'Beli 3 Gratis 1',
                'tanggal_awal' => Carbon::now()->subDays(10),
                'tanggal_akhir' => Carbon::now()->addDays(20),
                'tipe' => 'produk gratis',
                'produk_idutama' => $produk2,
                'produk_idtambahan' => $produk1,
                'nilai_diskon' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
