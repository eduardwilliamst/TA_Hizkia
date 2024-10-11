<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosSession extends Model
{
    use HasFactory;

    protected $table = 'pos_sessions'; // Nama tabel di database
    protected $primaryKey = 'idpos_session'; // Nama primary key
    public $timestamps = true; // Menggunakan timestamps
    protected $fillable = [
        'balance_awal',
        'balance_akhir',
        'tanggal',
        'user_iduser', // Foreign key untuk pengguna
        'pos_mesin_idpos_mesin', // Foreign key untuk mesin POS
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_iduser');
    }

    /**
     * Relasi ke model PosMesin
     */
    public function posMesin()
    {
        return $this->belongsTo(PosMesin::class, 'pos_mesin_idpos_mesin');
    }
}
