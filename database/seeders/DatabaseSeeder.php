<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // User & Role
            RoleSeeder::class,
            UserSeeder::class,

            // Master Data
            KategoriSeeder::class,
            SupplierSeeder::class,
            ProdukSeeder::class,
            PromoSeeder::class,

            // POS
            PosMesinSeeder::class,

            // Financial
            CashFlowSeeder::class,
        ]);
    }
}
