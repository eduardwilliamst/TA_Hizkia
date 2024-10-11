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
        Schema::create('produk_has_promo', function (Blueprint $table) {
            $table->foreignId('produk_idproduk')->constrained('produks', 'idproduk');
            $table->foreignId('promo_idpromo')->constrained('promos', 'idpromo');
            
            // Primary key gabungan
            $table->primary(['produk_idproduk', 'promo_idpromo']);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_has_promos');
    }
};
