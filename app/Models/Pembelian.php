<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelians'; // Nama tabel di database
    protected $primaryKey = 'idpembelian'; // Primary key tabel
    protected $fillable = [
        'tanggal_pesan',
        'tanggal_datang',
        'supplier_idsupplier',
    ]; // Kolom yang dapat diisi

    // Relasi dengan model Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_idsupplier', 'idsupplier');
    }

    // Anda dapat menambahkan relasi atau metode lain sesuai kebutuhan di sini
}
