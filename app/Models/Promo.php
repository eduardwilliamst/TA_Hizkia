<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promos'; // Nama tabel di database
    protected $primaryKey = 'idpromo'; // Primary key tabel
    protected $fillable = [
        'deskripsi',
        'tanggal_awal',
        'tanggal_akhir',
        'buy_x',
        'get_y',
    ]; // Kolom yang dapat diisi

    // Anda dapat menambahkan relasi atau metode lain sesuai kebutuhan di sini
}
