<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cash_flows')->insert([
            [
                'tanggal' => Carbon::now()->subDays(30),
                'tipe' => 'cash_in',
                'jumlah' => 10000000,
                'balance_awal' => 0,
                'balance_akhir' => 10000000,
                'keterangan' => 'Modal awal usaha',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(28),
                'tipe' => 'cash_out',
                'jumlah' => 5000000,
                'balance_awal' => 10000000,
                'balance_akhir' => 5000000,
                'keterangan' => 'Pembelian stok awal produk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(25),
                'tipe' => 'cash_in',
                'jumlah' => 3500000,
                'balance_awal' => 5000000,
                'balance_akhir' => 8500000,
                'keterangan' => 'Penjualan minggu pertama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(20),
                'tipe' => 'cash_out',
                'jumlah' => 500000,
                'balance_awal' => 8500000,
                'balance_akhir' => 8000000,
                'keterangan' => 'Bayar listrik dan air',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(18),
                'tipe' => 'cash_in',
                'jumlah' => 4200000,
                'balance_awal' => 8000000,
                'balance_akhir' => 12200000,
                'keterangan' => 'Penjualan minggu kedua',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(15),
                'tipe' => 'cash_out',
                'jumlah' => 2000000,
                'balance_awal' => 12200000,
                'balance_akhir' => 10200000,
                'keterangan' => 'Restock produk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(11),
                'tipe' => 'cash_in',
                'jumlah' => 3800000,
                'balance_awal' => 10200000,
                'balance_akhir' => 14000000,
                'keterangan' => 'Penjualan minggu ketiga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(8),
                'tipe' => 'cash_out',
                'jumlah' => 800000,
                'balance_awal' => 14000000,
                'balance_akhir' => 13200000,
                'keterangan' => 'Gaji karyawan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(4),
                'tipe' => 'cash_in',
                'jumlah' => 5100000,
                'balance_awal' => 13200000,
                'balance_akhir' => 18300000,
                'keterangan' => 'Penjualan minggu keempat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => Carbon::now()->subDays(2),
                'tipe' => 'cash_out',
                'jumlah' => 300000,
                'balance_awal' => 18300000,
                'balance_akhir' => 18000000,
                'keterangan' => 'Biaya operasional bulanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
