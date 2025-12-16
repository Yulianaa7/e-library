<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DetailPeminjamanController;

// Redirect root ke dashboard langsung
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Dashboard (tanpa middleware auth)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Resource routes untuk CRUD
Route::resource('buku', BukuController::class);
Route::resource('siswa', SiswaController::class);
Route::resource('kelas', KelasController::class);
Route::resource('peminjaman', PeminjamanController::class);
Route::resource('pengembalian', PengembalianController::class);