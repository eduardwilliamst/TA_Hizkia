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
        Schema::create('promos', function (Blueprint $table) {
            $table->id('idpromo'); // Primary key
            $table->integer('buy_x')->nullable(); // Jumlah produk yang harus dibeli
            $table->integer('get_y')->nullable(); // Jumlah produk tambahan
            $table->string('deskripsi', 45)->nullable(); // Deskripsi promosi
            $table->dateTime('tanggal_awal')->nullable(); // Tanggal awal promosi
            $table->dateTime('tanggal_akhir')->nullable(); // Tanggal akhir promosi
            $table->enum('tipe', ['produk gratis', 'diskon'])->default('diskon'); // Tipe promosi
            $table->unsignedBigInteger('produk_idutama'); // ID produk utama
            $table->unsignedBigInteger('produk_idtambahan')->nullable(); // ID produk tambahan
            $table->integer('nilai_diskon')->nullable(); // Nilai diskon
            $table->timestamps(); // Timestamps

            // Foreign key constraints
            $table->foreign('produk_idutama')->references('id')->on('produks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('produk_idtambahan')->references('id')->on('produks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
