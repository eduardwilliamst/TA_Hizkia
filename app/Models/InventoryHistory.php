<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'tanggal',
        'tipe',
        'qty_before',
        'qty_change',
        'qty_after',
        'harga_beli',
        'referensi_id',
        'referensi_tipe',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'idproduk');
    }
}
