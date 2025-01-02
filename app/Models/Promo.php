<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promos'; // Nama tabel di database
    protected $primaryKey = 'idpromo'; // Nama primary key
    public $timestamps = true; // Menggunakan timestamps
    protected $fillable = [
        'buy_x',
        'get_y',
        'deskripsi',
        'tanggal_awal',
        'tanggal_akhir',
        'tipe',
        'produk_idutama',
        'produk_idtambahan',
        'nilai_diskon',
    ];

    /**
     * Relasi ke model Produk (Produk Utama)
     */
    public function produkUtama()
    {
        return $this->belongsTo(Produk::class, 'produk_idutama', 'idproduk');
    }

    /**
     * Relasi ke model Produk (Produk Tambahan)
     */
    public function produkTambahan()
    {
        return $this->belongsTo(Produk::class, 'produk_idtambahan', 'idproduk');
    }
}
