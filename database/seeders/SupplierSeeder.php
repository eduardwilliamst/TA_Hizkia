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
                'nama' => 'PT Pampers Indonesia',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta Selatan',
                'telp' => '021-12345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'CV Baby Care Supply',
                'alamat' => 'Jl. Gatot Subroto No. 45, Bandung',
                'telp' => '022-87654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'PT Nutricia Indonesia',
                'alamat' => 'Jl. Ahmad Yani No. 78, Surabaya',
                'telp' => '031-98765432',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'UD Baby Fashion',
                'alamat' => 'Jl. Diponegoro No. 56, Semarang',
                'telp' => '024-55556666',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
