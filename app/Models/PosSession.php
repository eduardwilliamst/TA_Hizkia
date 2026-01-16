<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosSession extends Model
{
    use HasFactory;

    protected $table = 'pos_sessions'; // Nama tabel di database
    protected $primaryKey = 'idpos_session'; // Nama primary key
    public $timestamps = true; // Menggunakan timestamps, jadi created_at dan updated_at akan otomatis ada

    // Menentukan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'balance_awal',
        'balance_akhir',
        'tanggal',
        'keterangan', // Kolom keterangan ditambahkan
        'user_iduser', // Foreign key untuk pengguna
        'pos_mesin_idpos_mesin', // Foreign key untuk mesin POS
    ];

    // Menggunakan konvensi default untuk foreign key jika nama field sesuai (user_id dan pos_mesin_id)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'id');
    }

    public function posMesin()
    {
        return $this->belongsTo(PosMesin::class, 'pos_mesin_idpos_mesin', 'idpos_mesin');
    }
}
