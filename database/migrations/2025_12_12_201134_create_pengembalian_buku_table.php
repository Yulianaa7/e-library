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
        Schema::create('pengembalian_buku', function (Blueprint $table) {
            $table->bigIncrements('id_pengembalian_buku');
            $table->date('tanggal_pengembalian');
            $table->integer('denda');
            $table->unsignedBigInteger('id_peminjaman');   

            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman_buku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian_buku');
    }
};
