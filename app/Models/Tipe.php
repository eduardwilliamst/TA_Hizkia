<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipe extends Model
{
    use HasFactory;

    protected $table = 'tipes'; // Nama tabel di database
    protected $primaryKey = 'idtipe'; // Primary key tabel
    protected $fillable = [
        'keterangan',
    ]; // Kolom yang dapat diisi

    // Relasi dengan model Pembelian
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'tipe_idtipe', 'idtipe');
    }
}
