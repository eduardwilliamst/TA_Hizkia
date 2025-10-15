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
        Schema::table('pembelians', function (Blueprint $table) {
            // Add tipe_idtipe foreign key if it doesn't exist
            if (!Schema::hasColumn('pembelians', 'tipe_idtipe')) {
                $table->unsignedBigInteger('tipe_idtipe')->nullable()->after('supplier_idsupplier');
                $table->foreign('tipe_idtipe')->references('idtipe')->on('tipes')
                    ->onDelete('set null')->onUpdate('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelians', function (Blueprint $table) {
            if (Schema::hasColumn('pembelians', 'tipe_idtipe')) {
                $table->dropForeign(['tipe_idtipe']);
                $table->dropColumn('tipe_idtipe');
            }
        });
    }
};
