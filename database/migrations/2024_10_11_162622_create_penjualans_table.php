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
            $table->enum('cara_bayar', ['cash', 'card'])->nullable();
            $table->integer('total_diskon')->nullable();
            $table->integer('total_bayar')->nullable();
            $table->unsignedBigInteger('pos_session_idpos_session'); // Foreign key to pos_sessions
            $table->unsignedBigInteger('user_iduser'); // Foreign key to users
            
            // Foreign key constraints
            $table->foreign('pos_session_idpos_session', 'penjualans_pos_session_fk')
                ->references('idpos_session')->on('pos_sessions')
                ->onDelete('restrict')->onUpdate('restrict');

            $table->foreign('user_iduser', 'penjualans_user_fk')
                ->references('id')->on('users')
                ->onDelete('restrict')->onUpdate('restrict');
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
