<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $table = 'diskons'; // Nama tabel di database
    protected $primaryKey = 'iddiskon'; // Primary key tabel
    protected $fillable = ['tanggal_awal', 'tanggal_akhir', 'presentase', 'keterangan']; // Kolom yang dapat diisi
}
