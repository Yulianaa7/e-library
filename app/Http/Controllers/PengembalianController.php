<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian_Buku;
use App\Models\Peminjaman_Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pengembalian = Pengembalian_Buku::join('peminjaman_buku', 'peminjaman_buku.id_peminjaman_buku', '=', 'pengembalian_buku.id_peminjaman_buku')
                                         ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
                                         ->join('kelas', 'kelas.id_kelas', '=', 'peminjaman_buku.id_kelas')
                                         ->select('pengembalian_buku.*', 'siswa.nama_siswa', 'kelas.nama_kelas', 
                                                  'peminjaman_buku.tanggal_pinjam', 'peminjaman_buku.tanggal_kembali');

        if ($request->search) {
            $pengembalian->where('siswa.nama_siswa', 'like', '%' . $request->search . '%')
                         ->orWhere('kelas.nama_kelas', 'like', '%' . $request->search . '%')
                         ->orWhere('pengembalian_buku.tanggal_pengembalian', 'like', '%' . $request->search . '%');
        }

        $pengembalian = $pengembalian->get();

        return view('pengembalian.index', compact('pengembalian'));
    }

    /**
     * Show the form for creating a new resource (Proses Pengembalian).
     */
    public function create()
    {
        // Ambil data peminjaman yang belum dikembalikan
        $peminjaman = Peminjaman_Buku::leftJoin('pengembalian_buku', 'pengembalian_buku.id_peminjaman_buku', '=', 'peminjaman_buku.id_peminjaman_buku')
                                     ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
                                     ->join('kelas', 'kelas.id_kelas', '=', 'peminjaman_buku.id_kelas')
                                     ->whereNull('pengembalian_buku.id_pengembalian_buku')
                                     ->select('peminjaman_buku.*', 'siswa.nama_siswa', 'kelas.nama_kelas')
                                     ->get();

        return view('pengembalian.create', compact('peminjaman'));
    }

    /**
     * Store a newly created resource in storage (Proses Pengembalian Buku).
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman_buku' => 'required|exists:peminjaman_buku,id_peminjaman_buku'
        ]);

        // Cek apakah sudah pernah dikembalikan
        $cek_kembali = Pengembalian_Buku::where('id_peminjaman_buku', $request->id_peminjaman_buku)->first();
        
        if ($cek_kembali) {
            return redirect()->route('pengembalian.create')->with('error', 'Buku ini sudah pernah dikembalikan.');
        }

        // Ambil data peminjaman
        $dt_kembali = Peminjaman_Buku::where('id_peminjaman_buku', $request->id_peminjaman_buku)->first();
        
        // Hitung denda
        $tanggal_sekarang = Carbon::now()->format('Y-m-d');
        $tanggal_kembali = new Carbon($dt_kembali->tanggal_kembali);
        $dendaperhari = 500;
        
        if (strtotime($tanggal_sekarang) > strtotime($tanggal_kembali)) {
            $jumlah_hari = $tanggal_kembali->diff(Carbon::now())->days;
            $denda = $jumlah_hari * $dendaperhari;
        } else {
            $denda = 0;
        }

        // Simpan pengembalian
        Pengembalian_Buku::create([
            'id_peminjaman_buku' => $request->id_peminjaman_buku,
            'tanggal_pengembalian' => $tanggal_sekarang,
            'denda' => $denda,
        ]);

        if ($denda > 0) {
            return redirect()->route('pengembalian.index')->with('success', 'Buku berhasil dikembalikan. Denda: Rp ' . number_format($denda, 0, ',', '.'));
        } else {
            return redirect()->route('pengembalian.index')->with('success', 'Buku berhasil dikembalikan tanpa denda.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengembalian = Pengembalian_Buku::join('peminjaman_buku', 'peminjaman_buku.id_peminjaman_buku', '=', 'pengembalian_buku.id_peminjaman_buku')
                                         ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
                                         ->join('kelas', 'kelas.id_kelas', '=', 'peminjaman_buku.id_kelas')
                                         ->select('pengembalian_buku.*', 'siswa.nama_siswa', 'kelas.nama_kelas',
                                                  'peminjaman_buku.tanggal_pinjam', 'peminjaman_buku.tanggal_kembali')
                                         ->where('pengembalian_buku.id_pengembalian_buku', $id)
                                         ->firstOrFail();

        return view('pengembalian.show', compact('pengembalian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengembalian = Pengembalian_Buku::findOrFail($id);
        $peminjaman = Peminjaman_Buku::join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
                                     ->join('kelas', 'kelas.id_kelas', '=', 'peminjaman_buku.id_kelas')
                                     ->select('peminjaman_buku.*', 'siswa.nama_siswa', 'kelas.nama_kelas')
                                     ->get();

        return view('pengembalian.edit', compact('pengembalian', 'peminjaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'denda' => 'required|numeric|min:0',
            'id_peminjaman_buku' => 'required|exists:peminjaman_buku,id_peminjaman_buku'
        ]);

        $pengembalian = Pengembalian_Buku::findOrFail($id);
        $pengembalian->update($request->all());

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengembalian = Pengembalian_Buku::findOrFail($id);
        $pengembalian->delete();

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil dihapus.');
    }
}