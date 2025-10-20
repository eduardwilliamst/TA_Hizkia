<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetil extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detils';
    public $incrementing = false;
    protected $primaryKey = ['pembelian_id', 'produk_id'];

    protected $fillable = [
        'pembelian_id',
        'produk_id',
        'harga',
        'jumlah',
    ];

    // Relasi dengan Pembelian
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'idpembelian');
    }

    // Relasi dengan Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'idproduk');
    }

    // Override untuk composite primary key
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
