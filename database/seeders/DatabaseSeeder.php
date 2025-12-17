<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // User & Role
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,

            // Master Data
            KategoriSeeder::class,
            SupplierSeeder::class,
            TipeSeeder::class,

            // Pembelian (creates products with HPP)
            PembelianSeeder::class,

            // Promo (requires products)
            PromoSeeder::class,

            // POS
            PosMesinSeeder::class,
            PosSessionSeeder::class,

            // Penjualan (requires products & pos_session)
            PenjualanSeeder::class,

            // Financial
            CashFlowSeeder::class,
        ]);
    }
}
