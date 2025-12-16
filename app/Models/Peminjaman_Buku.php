<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman_Buku extends Model
{
    protected $table = 'peminjaman_buku';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;

    protected $fillable = [
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'id_siswa',
        'id_buku',
        'id_kelas',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian_Buku::class, 'id_peminjaman_buku', 'id_peminjaman_buku');
    }
}
