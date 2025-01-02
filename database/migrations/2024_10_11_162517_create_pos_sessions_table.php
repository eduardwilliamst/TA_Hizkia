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
            $table->id('idpos_session'); // Primary key
            $table->integer('balance_awal')->nullable(); // Saldo awal
            $table->integer('balance_akhir')->nullable(); // Saldo akhir
            $table->dateTime('tanggal')->nullable(); // Tanggal sesi
            $table->integer('cash_in')->nullable(); // Jumlah uang masuk
            $table->integer('cash_out')->nullable(); // Jumlah uang keluar
            $table->string('keterangan', 45)->nullable(); // Keterangan sesi

            // Relasi foreign key
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('pos_mesin_id')->constrained('pos_mesins')->onDelete('restrict')->onUpdate('restrict');

            $table->timestamps(); // Timestamps
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
