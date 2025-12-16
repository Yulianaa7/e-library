<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian_Buku extends Model
{
    protected $table = 'pengembalian_buku';
    protected $primaryKey = 'id_pengembalian_buku';
    public $timestamps = false;
    
    protected $fillable = [
        'id_peminjaman',  // ← Foreign key ke peminjaman_buku.id_peminjaman_buku
        'tanggal_pengembalian',
        'denda',
    ];
    
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman_Buku::class, 'id_peminjaman', 'id_peminjaman');
    }
}