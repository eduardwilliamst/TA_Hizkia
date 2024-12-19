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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id('idpenjualan');
            $table->dateTime('tanggal')->nullable();
            $table->string('cara_bayar', 45)->nullable();
            $table->integer('total_diskon')->nullable();
            $table->integer('total_bayar')->nullable();
            
            // $table->foreignId('pos_session_id')->constrained('pos_sessions', 'idpos_session')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
                        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
