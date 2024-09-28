<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'paket';

    protected $fillable = [
        'nama',
        'harga'
    ];

    public function orders()
    {
        return $this->hasMany(Pesanan::class, 'id_paket');
    }
}
