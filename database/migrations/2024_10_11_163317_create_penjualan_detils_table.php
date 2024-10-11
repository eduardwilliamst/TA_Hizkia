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
            $table->foreignId('penjualan_id')->constrained('penjualans', 'idpenjualan')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('produk_id')->constrained('produks', 'idproduk')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('harga')->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('sub_total')->nullable();
            $table->foreignId('promo_produk_id')->nullable()->constrained('promos', 'idpromo')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('diskon_id')->nullable()->constrained('diskons', 'iddiskon')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();

            // Menetapkan primary key untuk kombinasi
            $table->primary(['penjualan_id', 'produk_id', 'diskon_id', 'promo_produk_id']);
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
