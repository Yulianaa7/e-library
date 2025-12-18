<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Siswa;
use App\Models\Peminjaman_Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik dengan error handling
        $totalBooks = 0;
        $totalStudents = 0;
        $activeBorrows = 0;
        $overdueBooks = 0;

        try {
            $totalBooks = Buku::count();
        } catch (\Exception $e) {
            $totalBooks = 0;
        }

        try {
            $totalStudents = Siswa::count();
        } catch (\Exception $e) {
            $totalStudents = 0;
        }

        try {
            // Hitung peminjaman yang sedang dipinjam (status bukan 'Dikembalikan')
            $activeBorrows = Peminjaman_Buku::where('status', '!=', 'Dikembalikan')->count();
        } catch (\Exception $e) {
            $activeBorrows = 0;
        }

        try {
            // Hitung terlambat: belum dikembalikan DAN tanggal kembali sudah lewat
            $today = Carbon::now()->startOfDay();
            $overdueBooks = Peminjaman_Buku::where('status', '!=', 'Dikembalikan')
                ->whereDate('tanggal_kembali', '<', $today)
                ->count();
        } catch (\Exception $e) {
            $overdueBooks = 0;
        }

        return view('dashboard', compact(
            'totalBooks',
            'totalStudents',
            'activeBorrows',
            'overdueBooks'
        ));
    }
}