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
        Schema::create('penjualan_detils', function (Blueprint $table) {
            // Kolom penjualan_id (mengacu pada idpenjualan di tabel penjualan)
            $table->unsignedBigInteger('penjualan_idpenjualan');
            
            // Kolom produk_id (mengacu pada idproduk di tabel produk)
            $table->unsignedBigInteger('produk_idproduk');
            
            // Kolom harga, jumlah, sub_total
            $table->integer('harga')->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('sub_total')->nullable();
            
            // Kolom promo_produk_idproduk (mengacu pada idpromo di tabel promo)
            $table->unsignedBigInteger('promo_produk_idproduk')->nullable();
            
            // Menambahkan primary key yang merupakan kombinasi penjualan_idpenjualan dan produk_idproduk
            $table->primary(['penjualan_idpenjualan', 'produk_idproduk']);

            // Defining foreign key constraints
            $table->foreign('penjualan_idpenjualan')->references('idpenjualan')->on('penjualans')
                  ->onDelete('no action')->onUpdate('no action');
            
            $table->foreign('produk_idproduk')->references('idproduk')->on('produks')
                  ->onDelete('no action')->onUpdate('no action');
            
            $table->foreign('promo_produk_idproduk')->references('idpromo')->on('promos')
                  ->onDelete('no action')->onUpdate('no action');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_detils');
    }
};
