<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman_Buku extends Model
{
    protected $table = 'peminjaman_buku';
    protected $primaryKey = 'id_peminjaman_buku';
    public $timestamps = false;
    protected $fillable = [
        'tanggal_pinjam',
        'tanggal_kembali',
        'id_siswa',
        'id_buku',
        'id_kelas',
    ];

    // RELASI KE SISWA
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    // RELASI KE BUKU
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}
