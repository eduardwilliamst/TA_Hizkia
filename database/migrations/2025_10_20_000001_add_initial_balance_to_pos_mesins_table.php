<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pos_mesins', function (Blueprint $table) {
            $table->integer('initial_balance')->default(1000000)->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_mesins', function (Blueprint $table) {
            $table->dropColumn('initial_balance');
        });
    }
};
