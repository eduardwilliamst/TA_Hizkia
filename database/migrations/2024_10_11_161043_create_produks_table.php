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
        Schema::create('produks', function (Blueprint $table) {
            $table->id('idproduk');
            $table->string('barcode', 100)->nullable();
            $table->string('nama', 100)->nullable(false);
            $table->integer('harga')->nullable();
            $table->unsignedInteger('stok')->default(0);
            $table->string('gambar', 255)->nullable();

            // Foreign keys
            $table->unsignedBigInteger('kategori_idkategori');
            $table->unsignedBigInteger('diskon_iddiskon')->nullable();

            // Foreign Key Constraints
            $table->foreign('kategori_idkategori')
                  ->references('idkategori')->on('kategoris')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('diskon_iddiskon')
                  ->references('iddiskon')->on('diskons')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
