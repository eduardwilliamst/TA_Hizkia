<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers'; // Nama tabel di database
    protected $primaryKey = 'idsupplier'; // Primary key tabel
    protected $fillable = [
        'nama',
        'alamat',
        'telp',
    ]; // Kolom yang dapat diisi

    // Anda dapat menambahkan relasi atau metode lain sesuai kebutuhan di sini
}
