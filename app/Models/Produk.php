<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks'; // Nama tabel di database
    protected $primaryKey = 'idproduk'; // Primary key tabel
    protected $fillable = [
        'barcode',
        'nama',
        'harga',
        'stok',
        'gambar',
        'kategori_idkategori',
        'diskon_iddiskon'
    ]; // Kolom yang dapat diisi

    // Relasi dengan model Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_idkategori', 'idkategori');
    }

    // Relasi dengan model Diskon
    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'diskon_iddiskon', 'iddiskon');
    }
}
