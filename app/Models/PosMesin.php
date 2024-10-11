<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosMesin extends Model
{
    use HasFactory;

    protected $table = 'pos_mesins'; // Nama tabel di database
    protected $primaryKey = 'idpos_mesin'; // Nama primary key
    public $timestamps = true; // Menggunakan timestamps
    protected $fillable = [
        'nama', // Kolom yang dapat diisi
    ];

    // Anda dapat menambahkan relasi atau metode lain sesuai kebutuhan di sini
}
