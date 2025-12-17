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
        Schema::create('inventory_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_id');
            $table->dateTime('tanggal');
            $table->enum('tipe', ['pembelian', 'penjualan', 'adjustment']);
            $table->integer('qty_before')->default(0);
            $table->integer('qty_change');
            $table->integer('qty_after');
            $table->integer('harga_beli')->nullable();
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->string('referensi_tipe')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('produk_id')->references('idproduk')->on('produks')->onDelete('cascade');
            $table->index(['produk_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_histories');
    }
};
