<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategoris')->insert([
            [
                'nama' => 'Popok & Diaper',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Makanan Bayi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Susu Formula',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Perlengkapan Mandi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Pakaian Bayi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Mainan Bayi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Perlengkapan Makan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
