<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman_Buku extends Model
{
    protected $table = 'peminjaman_buku';
    public $timestamps = false;
    protected $fillable = [
        'tanggal_pinjam',
        'tanggal_kembali',
        'id_siswa',
        'id_kelas',
    ];
}
