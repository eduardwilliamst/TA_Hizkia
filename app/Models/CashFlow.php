<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;

    protected $table = 'cash_flows'; // Nama tabel di database
    protected $primaryKey = 'idcashflow'; // Nama primary key
    public $timestamps = false;
    
    protected $fillable = [
        'balance_awal',
        'balance_akhir',
        'tanggal',
        'keterangan', // Kolom keterangan ditambahkan
        'tipe',    // Kolom cash_in ditambahkan
        'jumlah',   // Kolom cash_out ditambahkan
        'id_pos_session', // Foreign key untuk mesin POS
    ];

    public function posSession()
    {
        return $this->belongsTo(PosSession::class, 'id_pos_session', 'idpos_session');
    }
}
