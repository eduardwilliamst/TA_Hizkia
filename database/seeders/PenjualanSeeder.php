<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get required IDs
        $userId = DB::table('users')->first()->id ?? 1;
        $posSessionId = DB::table('pos_sessions')->first()->idpos_session ?? 1;

        // Get all products with their HPP
        $produks = DB::table('produks')->get()->keyBy('idproduk');

        if ($produks->isEmpty()) {
            return; // Skip if no products
        }

        $produkIds = $produks->pluck('idproduk')->toArray();

        // Create multiple sales transactions over the past 30 days
        $salesData = [];

        // Generate 20 sales transactions
        for ($i = 0; $i < 20; $i++) {
            $tanggal = Carbon::now()->subDays(rand(1, 30))->setTime(rand(8, 20), rand(0, 59), rand(0, 59));

            // Random number of items per transaction (1-5)
            $numItems = rand(1, 5);
            $selectedProducts = collect($produkIds)->shuffle()->take($numItems);

            $items = [];
            $totalHarga = 0;
            $totalDiskon = 0;

            foreach ($selectedProducts as $produkId) {
                $produk = $produks[$produkId];
                $jumlah = rand(1, 3);
                $harga = $produk->harga;
                $hpp = $produk->harga_beli ?? (int)($harga * 0.7); // Use harga_beli or estimate 70% of selling price
                $subTotal = $harga * $jumlah;

                $items[] = [
                    'produk_idproduk' => $produkId,
                    'harga' => $harga,
                    'hpp' => $hpp,
                    'jumlah' => $jumlah,
                    'sub_total' => $subTotal,
                    'promo_produk_idproduk' => null,
                ];

                $totalHarga += $subTotal;
            }

            $salesData[] = [
                'tanggal' => $tanggal,
                'items' => $items,
                'total_harga' => $totalHarga,
                'total_diskon' => $totalDiskon,
                'cara_bayar' => rand(0, 1) ? 'cash' : 'card',
            ];
        }

        // Sort by date
        usort($salesData, fn($a, $b) => $a['tanggal']->timestamp - $b['tanggal']->timestamp);

        // Insert sales
        foreach ($salesData as $sale) {
            $penjualanId = DB::table('penjualans')->insertGetId([
                'tanggal' => $sale['tanggal'],
                'cara_bayar' => $sale['cara_bayar'],
                'total_diskon' => $sale['total_diskon'],
                'total_harga' => $sale['total_harga'],
                'pos_session_idpos_session' => $posSessionId,
                'user_iduser' => $userId,
                'created_at' => $sale['tanggal'],
                'updated_at' => $sale['tanggal'],
            ]);

            // Insert sale details
            foreach ($sale['items'] as $item) {
                DB::table('penjualan_detils')->insert([
                    'penjualan_idpenjualan' => $penjualanId,
                    'produk_idproduk' => $item['produk_idproduk'],
                    'harga' => $item['harga'],
                    'hpp' => $item['hpp'],
                    'jumlah' => $item['jumlah'],
                    'sub_total' => $item['sub_total'],
                    'promo_produk_idproduk' => $item['promo_produk_idproduk'],
                    'created_at' => $sale['tanggal'],
                    'updated_at' => $sale['tanggal'],
                ]);

                // Update stock (decrease)
                DB::table('produks')
                    ->where('idproduk', $item['produk_idproduk'])
                    ->decrement('stok', $item['jumlah']);
            }
        }
    }
}
