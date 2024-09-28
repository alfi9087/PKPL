<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'nama_customer',
        'alamat',
        'no_tlp',
        'berat',
        'id_paket',
        'status',
        'note',
        'total_harga',
        'tgl_masuk',
        'tgl_diambil'
    ];

    protected $dates = [
        'tgl_masuk',
        'tgl_diambil'
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }
}
