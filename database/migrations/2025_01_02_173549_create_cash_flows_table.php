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
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id('idcashflow');
            $table->integer('balance_awal')->nullable(); // Balance awal
            $table->integer('balance_akhir')->nullable(); // Balance akhir
            $table->dateTime('tanggal')->nullable(); // Tanggal
            $table->string('keterangan', 500)->nullable(); // Keterangan
            $table->enum('tipe', ['cash_in', 'cash_out', 'saldo_awal'])->nullable();
            $table->integer('jumlah')->nullable(); // Balance akhir
            $table->unsignedBigInteger('id_pos_session'); // ID mesin POS (foreign key)

            $table->foreign('id_pos_session')->references('idpos_session')->on('pos_sessions')->onDelete('restrict')->onUpdate('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_flows');
    }
};
