<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $timestamps = false;
    
    protected $fillable = [
        'nama_buku',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'stok',
        'deskripsi',
    ];

    // RELASI KE PEMINJAMAN BUKU (TAMBAHKAN INI)
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman_Buku::class, 'id_buku', 'id_buku');
    }
}