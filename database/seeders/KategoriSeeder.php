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
                'nama' => 'Pakaian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
