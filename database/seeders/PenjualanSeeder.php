<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Generates comprehensive sales data across multiple years and months
     * to properly display in sales analytics charts:
     * 1. Monthly sales throughout a year
     * 2. Year-over-year comparison
     * 3. Product-specific sales trends
     * 4. HPP vs Revenue analysis
     */
    public function run(): void
    {
        // Get required IDs
        $users = DB::table('users')->pluck('id')->toArray();
        $userId = $users[0] ?? 1;
        $posSessionId = DB::table('pos_sessions')->first()->idpos_session ?? 1;

        // Get all products with their HPP
        $produks = DB::table('produks')->get()->keyBy('idproduk');

        if ($produks->isEmpty()) {
            $this->command->info('No products found. Skipping PenjualanSeeder.');
            return;
        }

        $produkIds = $produks->pluck('idproduk')->toArray();

        // Define years to generate data for (including current year and past 2 years)
        $currentYear = Carbon::now()->year;
        $years = [$currentYear - 2, $currentYear - 1, $currentYear];

        // Seasonal multipliers for realistic patterns (higher in holiday months)
        $monthMultipliers = [
            1 => 0.8,   // January - post holiday slowdown
            2 => 0.75,  // February
            3 => 0.85,  // March
            4 => 0.9,   // April
            5 => 1.0,   // May
            6 => 1.1,   // June - mid year
            7 => 1.0,   // July
            8 => 0.95,  // August
            9 => 1.0,   // September
            10 => 1.1,  // October
            11 => 1.2,  // November - pre holiday
            12 => 1.4,  // December - holiday season peak
        ];

        // Growth factor per year (5-15% growth)
        $yearGrowth = [
            $currentYear - 2 => 1.0,
            $currentYear - 1 => 1.1,
            $currentYear => 1.2,
        ];

        $salesData = [];
        $currentMonth = Carbon::now()->month;

        foreach ($years as $year) {
            // For current year, only generate up to current month
            $maxMonth = ($year == $currentYear) ? $currentMonth : 12;

            for ($month = 1; $month <= $maxMonth; $month++) {
                // Base transactions per month (15-25), adjusted by multipliers
                $baseTransactions = rand(15, 25);
                $adjustedTransactions = (int)($baseTransactions * $monthMultipliers[$month] * $yearGrowth[$year]);

                // Generate transactions spread throughout the month
                $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

                for ($t = 0; $t < $adjustedTransactions; $t++) {
                    // Random day in month
                    $day = rand(1, $daysInMonth);
                    $tanggal = Carbon::createFromDate($year, $month, $day)
                        ->setTime(rand(8, 20), rand(0, 59), rand(0, 59));

                    // Random number of items per transaction (1-6)
                    $numItems = rand(1, 6);
                    $selectedProducts = collect($produkIds)->shuffle()->take($numItems);

                    $items = [];
                    $totalHarga = 0;
                    $totalDiskon = rand(0, 1) ? rand(1000, 10000) : 0; // Sometimes apply discount

                    foreach ($selectedProducts as $produkId) {
                        $produk = $produks[$produkId];

                        // Quantity varies - some products sell more
                        $jumlah = rand(1, 5);
                        $harga = $produk->harga;
                        $hpp = $produk->harga_beli ?? (int)($harga * 0.7);
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

                    // Apply discount to total if any
                    $totalHarga = max(0, $totalHarga - $totalDiskon);

                    $salesData[] = [
                        'tanggal' => $tanggal,
                        'items' => $items,
                        'total_harga' => $totalHarga,
                        'total_diskon' => $totalDiskon,
                        'cara_bayar' => rand(0, 10) > 3 ? 'cash' : 'card', // 70% cash
                        'user_id' => $users[array_rand($users)] ?? $userId,
                    ];
                }
            }
        }

        // Sort by date
        usort($salesData, fn($a, $b) => $a['tanggal']->timestamp - $b['tanggal']->timestamp);

        $this->command->info('Generating ' . count($salesData) . ' sales transactions...');

        // Insert sales in batches
        $progressCount = 0;
        foreach ($salesData as $sale) {
            $penjualanId = DB::table('penjualans')->insertGetId([
                'tanggal' => $sale['tanggal'],
                'cara_bayar' => $sale['cara_bayar'],
                'total_diskon' => $sale['total_diskon'],
                'total_harga' => $sale['total_harga'],
                'pos_session_idpos_session' => $posSessionId,
                'user_iduser' => $sale['user_id'],
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
            }

            $progressCount++;
            if ($progressCount % 100 == 0) {
                $this->command->info("Processed {$progressCount} transactions...");
            }
        }

        $this->command->info('PenjualanSeeder completed! Generated ' . count($salesData) . ' transactions.');

        // Print summary
        $this->printSummary($years);
    }

    /**
     * Print summary of generated data
     */
    private function printSummary(array $years): void
    {
        $this->command->info("\n=== Sales Data Summary ===");

        foreach ($years as $year) {
            $yearTotal = DB::table('penjualans')
                ->whereYear('created_at', $year)
                ->sum('total_harga');

            $yearCount = DB::table('penjualans')
                ->whereYear('created_at', $year)
                ->count();

            $this->command->info("Year {$year}: {$yearCount} transactions, Total: Rp " . number_format($yearTotal, 0, ',', '.'));
        }

        // HPP Summary
        $totalRevenue = DB::table('penjualans')->sum('total_harga');
        $totalHpp = DB::table('penjualan_detils')
            ->selectRaw('SUM(hpp * jumlah) as total')
            ->value('total') ?? 0;
        $profit = $totalRevenue - $totalHpp;
        $margin = $totalRevenue > 0 ? round(($profit / $totalRevenue) * 100, 2) : 0;

        $this->command->info("\n=== Overall Summary ===");
        $this->command->info("Total Revenue: Rp " . number_format($totalRevenue, 0, ',', '.'));
        $this->command->info("Total HPP: Rp " . number_format($totalHpp, 0, ',', '.'));
        $this->command->info("Total Profit: Rp " . number_format($profit, 0, ',', '.'));
        $this->command->info("Profit Margin: {$margin}%");
    }
}
