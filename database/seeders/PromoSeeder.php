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
        // Get product IDs
        $indomie = DB::table('produks')->where('barcode', '8992234567890')->value('idproduk');
        $kaosHitam = DB::table('produks')->where('barcode', '8991234567890')->value('idproduk');
        $chitato = DB::table('produks')->where('barcode', '8992234567892')->value('idproduk');
        $aqua = DB::table('produks')->where('barcode', '8992234567896')->value('idproduk');

        DB::table('promos')->insert([
            [
                'buy_x' => 2,
                'get_y' => 1,
                'deskripsi' => 'Beli 2 Indomie Gratis 1',
                'tanggal_awal' => Carbon::now()->subDays(5),
                'tanggal_akhir' => Carbon::now()->addDays(25),
                'tipe' => 'produk gratis',
                'produk_idutama' => $indomie ?? 1,
                'produk_idtambahan' => $indomie ?? 1,
                'nilai_diskon' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'buy_x' => 1,
                'get_y' => 0,
                'deskripsi' => 'Diskon 15% Kaos Polos Hitam',
                'tanggal_awal' => Carbon::now()->subDays(2),
                'tanggal_akhir' => Carbon::now()->addDays(3),
                'tipe' => 'diskon',
                'produk_idutama' => $kaosHitam ?? 1,
                'produk_idtambahan' => null,
                'nilai_diskon' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'buy_x' => 3,
                'get_y' => 1,
                'deskripsi' => 'Beli 3 Chitato Gratis 1 Aqua',
                'tanggal_awal' => Carbon::now()->subDays(10),
                'tanggal_akhir' => Carbon::now()->addDays(20),
                'tipe' => 'produk gratis',
                'produk_idutama' => $chitato ?? 2,
                'produk_idtambahan' => $aqua ?? 2,
                'nilai_diskon' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
