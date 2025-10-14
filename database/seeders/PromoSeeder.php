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
        DB::table('promos')->insert([
            [
                'nama' => 'Diskon Akhir Tahun',
                'deskripsi' => 'Diskon spesial untuk menyambut tahun baru',
                'tanggal_mulai' => Carbon::now()->subDays(5),
                'tanggal_selesai' => Carbon::now()->addDays(25),
                'jenis_diskon' => 'persentase',
                'nilai_diskon' => 15.00,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Flash Sale Pakaian',
                'deskripsi' => 'Flash sale untuk semua produk pakaian',
                'tanggal_mulai' => Carbon::now()->subDays(2),
                'tanggal_selesai' => Carbon::now()->addDays(3),
                'jenis_diskon' => 'persentase',
                'nilai_diskon' => 20.00,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Diskon Makanan Ringan',
                'deskripsi' => 'Beli 3 gratis 1 untuk makanan ringan',
                'tanggal_mulai' => Carbon::now()->subDays(10),
                'tanggal_selesai' => Carbon::now()->addDays(20),
                'jenis_diskon' => 'nominal',
                'nilai_diskon' => 5000.00,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
