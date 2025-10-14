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
                'telepon' => '021-12345678',
                'email' => 'info@majujaya.com',
                'kontak_person' => 'Budi Santoso',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'CV Sumber Rezeki',
                'alamat' => 'Jl. Gatot Subroto No. 45, Bandung',
                'telepon' => '022-87654321',
                'email' => 'supplier@sumberrezeki.com',
                'kontak_person' => 'Siti Nurhaliza',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'UD Berkah Jaya',
                'alamat' => 'Jl. Ahmad Yani No. 78, Surabaya',
                'telepon' => '031-98765432',
                'email' => 'berkah@gmail.com',
                'kontak_person' => 'Ahmad Wijaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Toko Grosir Makmur',
                'alamat' => 'Jl. Diponegoro No. 56, Semarang',
                'telepon' => '024-55556666',
                'email' => 'makmur@yahoo.com',
                'kontak_person' => 'Dewi Lestari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
