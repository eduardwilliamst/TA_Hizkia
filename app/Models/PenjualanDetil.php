<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetil extends Model
{
    use HasFactory;

    protected $table = 'penjualan_detils'; // Nama tabel di database
    public $timestamps = true; // Menggunakan timestamps
    protected $primaryKey = null; // Karena menggunakan composite primary key
    public $incrementing = false; // Non-incrementing karena primary key gabungan

    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'harga',
        'jumlah',
        'sub_total',
        'promo_produk_id',
        'diskon_id',
    ];

    /**
     * Relasi ke model Penjualan
     */
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    /**
     * Relasi ke model Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    /**
     * Relasi ke model Promo
     */
    public function promoProduk()
    {
        return $this->belongsTo(Promo::class, 'promo_produk_id');
    }

    /**
     * Relasi ke model Diskon
     */
    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'diskon_id');
    }
}
