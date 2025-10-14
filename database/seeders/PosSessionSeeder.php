<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PosSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user and first pos mesin
        $userId = DB::table('users')->first()->id ?? 1;
        $posMesinId = DB::table('pos_mesins')->first()->idpos_mesin ?? 1;

        DB::table('pos_sessions')->insert([
            [
                'saldo_awal' => 0,
                'tanggal' => Carbon::now()->subDays(30),
                'keterangan' => 'Session untuk seeding cash flow',
                'user_iduser' => $userId,
                'pos_mesin_idpos_mesin' => $posMesinId,
            ],
        ]);
    }
}
