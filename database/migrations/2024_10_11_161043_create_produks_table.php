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
            $table->string('barcode', 45)->nullable();
            $table->string('nama', 45)->nullable();
            $table->integer('harga')->nullable();
            $table->integer('stok')->nullable();
            $table->string('gambar', 512)->nullable();
            $table->dateTime('usia_awal')->nullable();
            $table->dateTime('usia_akhir')->nullable();

            // Foreign keys
            $table->unsignedBigInteger('kategori_idkategori');
            $table->unsignedBigInteger('diskon_iddiskon');

            // Foreign Key Constraints
            $table->foreign('kategori_idkategori')->references('idkategori')->on('kategoris');
            $table->foreign('diskon_iddiskon')->references('iddiskon')->on('diskons');

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
