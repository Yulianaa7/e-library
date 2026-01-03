<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    public $timestamps = false;

    protected $fillable = [
        'nama_siswa',
        'tanggal_lahir',
        'gender',
        'alamat',
        'id_kelas',
    ];

    // RELASI KE KELAS
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    // RELASI KE PEMINJAMAN BUKU (UBAH NAMA MODELNYA)
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman_Buku::class, 'id_siswa', 'id_siswa');
    }
}