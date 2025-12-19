<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Siswa;
use App\Models\Peminjaman_Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek session manual
        if (!session()->has('user_id')) {
            \Log::error('Session tidak ada user_id');
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Ambil user dari session
        $userId = session('user_id');
        $user = User::find($userId);
        
        if (!$user) {
            \Log::error('User tidak ditemukan dengan ID: ' . $userId);
            session()->flush();
            return redirect('/login')->with('error', 'Session invalid');
        }
        
        \Log::info('Dashboard berhasil diakses oleh: ' . $user->username);

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
            $activeBorrows = Peminjaman_Buku::where('status', '!=', 'Dikembalikan')->count();
        } catch (\Exception $e) {
            $activeBorrows = 0;
        }

        try {
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
            'overdueBooks',
            'user'
        ));
    }
}