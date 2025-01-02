<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosMesinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pos_mesins')->insert([
            [
                'nama' => 'POS Mesin 1',
            ],
            [
                'nama' => 'POS Mesin 2',
            ],
            [
                'nama' => 'POS Mesin 3',
            ],
            [
                'nama' => 'POS Mesin 4',
            ],
        ]);
    }
}
