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
        Schema::create('pos_sessions', function (Blueprint $table) {
            $table->id('idpos_session');
            $table->integer('balance_awal')->nullable();
            $table->integer('balance_akhir')->nullable();
            $table->dateTime('tanggal')->nullable();
            
            // Pastikan foreign key sesuai dengan primary key dari tabel yang direferensikan
            $table->foreignId('user_iduser')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('pos_mesin_idpos_mesin')->constrained('pos_mesins', 'idpos_mesin')->onDelete('restrict')->onUpdate('restrict');
            
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_sessions');
    }
};
