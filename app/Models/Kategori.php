<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris'; // Nama tabel di database
    protected $primaryKey = 'idkategori'; // Primary key tabel
    protected $fillable = ['nama']; // Kolom yang dapat diisi
}
