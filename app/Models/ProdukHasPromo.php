<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProdukHasPromo extends Pivot
{
    use HasFactory;

    protected $table = 'produk_has_promo'; // Nama tabel di database
    protected $primaryKey = ['produk_idproduk', 'promo_idpromo']; // Primary key gabungan
    public $incrementing = false; // Primary key tidak otomatis increment
    protected $fillable = [
        'produk_idproduk',
        'promo_idpromo',
    ]; // Kolom yang dapat diisi

    // Anda dapat menambahkan relasi atau metode lain sesuai kebutuhan di sini

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_idproduk', 'idproduk');
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'promo_idpromo', 'idpromo');
    }
}
