<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to modify ENUM column (Laravel doesn't support direct ENUM modification)
        DB::statement("ALTER TABLE cash_flows MODIFY COLUMN tipe ENUM('cash_in', 'cash_out', 'saldo_awal') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM values
        DB::statement("ALTER TABLE cash_flows MODIFY COLUMN tipe ENUM('cash_in', 'cash_out') NULL");
    }
};
