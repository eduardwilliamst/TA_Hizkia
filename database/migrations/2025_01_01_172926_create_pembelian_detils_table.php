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
        Schema::create('pembelian_detils', function (Blueprint $table) {
            $table->foreignId('pembelian_id')->constrained('pembelians', 'idpembelian')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('produk_id')->constrained('produks', 'idproduk')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('harga')->nullable();
            $table->integer('jumlah')->nullable();
            $table->timestamps();

            $table->primary(['pembelian_id', 'produk_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_detils');
    }
};
