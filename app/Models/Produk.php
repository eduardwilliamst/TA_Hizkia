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
        'harga_beli',
        'stok',
        'gambar',
        'kategori_idkategori',
    ]; // Kolom yang dapat diisi

    // Relasi dengan model Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_idkategori', 'idkategori');
    }

    // Relasi dengan inventory histories
    public function inventoryHistories()
    {
        return $this->hasMany(InventoryHistory::class, 'produk_id', 'idproduk');
    }
}
