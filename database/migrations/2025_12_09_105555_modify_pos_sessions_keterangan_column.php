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
        // Increase keterangan column length from 45 to 500 characters
        DB::statement("ALTER TABLE pos_sessions MODIFY COLUMN keterangan VARCHAR(500) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original length
        DB::statement("ALTER TABLE pos_sessions MODIFY COLUMN keterangan VARCHAR(45) NULL");
    }
};
