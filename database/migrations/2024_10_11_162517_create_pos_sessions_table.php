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
            $table->integer('balance_awal')->nullable(); // Balance awal
            $table->integer('balance_akhir')->nullable(); // Balance akhir
            $table->dateTime('tanggal')->nullable(); // Tanggal
            $table->string('keterangan', 45)->nullable(); // Keterangan
            $table->unsignedBigInteger('user_iduser'); // ID pengguna (foreign key)
            $table->unsignedBigInteger('pos_mesin_idpos_mesin'); // ID mesin POS (foreign key)
            $table->timestamps(); // created_at and updated_at

            $table->foreign('user_iduser')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('pos_mesin_idpos_mesin')->references('idpos_mesin')->on('pos_mesins')->onDelete('restrict')->onUpdate('restrict');
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
