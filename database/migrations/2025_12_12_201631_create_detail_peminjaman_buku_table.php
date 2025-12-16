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
        Schema::create('detail_peminjaman_buku', function (Blueprint $table) {
            $table->bigIncrements('id_detail');
            $table->integer('qty');
            $table->unsignedBigInteger('id_buku');
            $table->unsignedBigInteger('id_peminjaman_buku');

            $table->foreign('id_buku')->references('id_buku')->on('buku');
            $table->foreign('id_peminjaman_buku')->references('id_peminjaman_buku')->on('peminjaman_buku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengembalian_buku');
    }
};
