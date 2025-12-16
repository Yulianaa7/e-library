<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman_buku', function (Blueprint $table) {
            $table->bigIncrements('id_peminjaman_buku');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_kelas');
            $table->date('tgl_pinjam')->default(DB::raw('CURRENT_DATE'));
            $table->date('tgl_kembali');

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_buku');
    }
};
