<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'nama' => 'PT Maju Jaya',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta',
                'telp' => '021-12345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'CV Sumber Rezeki',
                'alamat' => 'Jl. Gatot Subroto No. 45, Bandung',
                'telp' => '022-87654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'UD Berkah Jaya',
                'alamat' => 'Jl. Ahmad Yani No. 78, Surabaya',
                'telp' => '031-98765432',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Toko Grosir Makmur',
                'alamat' => 'Jl. Diponegoro No. 56, Semarang',
                'telp' => '024-55556666',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
