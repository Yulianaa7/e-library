<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian_Buku extends Model
{
    protected $table = 'pengembalian_buku';
    public $timestamps = false;
    protected $fillable = [
        'tanggal_pengembalian',
        'denda',
        'id_peminjaman_buku',
    ];
}
