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
        // Hitung statistik (gunakan 0 jika model belum ada)
        $totalBooks = 0;
        $totalStudents = 0;
        $activeBorrows = 0;
        $overdueBooks = 0;

        // Jika model sudah ada, uncomment code di bawah:
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
            $activeBorrows = Peminjaman_Buku::where('status', 'dipinjam')->count();
        } catch (\Exception $e) {
            $activeBorrows = 0;
        }

        try {
            $overdueBooks = Peminjaman_Buku::where('status', 'dipinjam')
                ->where('tgl_kembali', '<', Carbon::now()->format('Y-m-d'))
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