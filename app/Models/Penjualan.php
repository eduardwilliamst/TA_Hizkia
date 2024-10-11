<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans'; // Nama tabel di database
    protected $primaryKey = 'idpenjualan'; // Nama primary key
    public $timestamps = true; // Menggunakan timestamps
    protected $fillable = [
        'tanggal',
        'cara_bayar',
        'total_diskon',
        'total_bayar',
        'pos_session_id',
        'user_id',
    ];

    /**
     * Relasi ke model PosSession
     */
    public function posSession()
    {
        return $this->belongsTo(PosSession::class, 'pos_session_id');
    }

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model PenjualanDetail
     */
    public function penjualanDetils()
    {
        return $this->hasMany(PenjualanDetil::class, 'penjualan_idpenjualan');
    }
}
