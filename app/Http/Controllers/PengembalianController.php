<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian_Buku;
use App\Models\Peminjaman_Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        // **PERBAIKAN: Hanya tampilkan peminjaman yang belum dikembalikan (status Dipinjam atau Terlambat)**
        $peminjaman = Peminjaman_Buku::join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
            ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
            ->join('buku', 'buku.id_buku', '=', 'peminjaman_buku.id_buku')
            ->whereIn('peminjaman_buku.status', ['Dipinjam', 'Terlambat']) // **INI YANG PENTING**
            ->select('peminjaman_buku.*', 'siswa.nama_siswa', 'kelas.nama_kelas', 'buku.nama_buku')
            ->orderBy('peminjaman_buku.tanggal_kembali', 'asc')
            ->get();

        $mode = 'index';

        return view('pengembalian.pengembalian', compact('peminjaman', 'mode'));
    }

    public function create(Request $request)
    {
        $id = $request->id;

        $peminjaman = Peminjaman_Buku::join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
            ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
            ->join('buku', 'buku.id_buku', '=', 'peminjaman_buku.id_buku')
            ->select('peminjaman_buku.*', 'siswa.nama_siswa', 'kelas.nama_kelas', 'buku.nama_buku')
            ->where('peminjaman_buku.id_peminjaman', $id)
            ->firstOrFail();

        $mode = 'create';

        return view('pengembalian.pengembalian', compact('peminjaman', 'mode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman_buku,id_peminjaman'
        ]);

        $cek_kembali = Pengembalian_Buku::where('id_peminjaman', $request->id_peminjaman)->first();

        if ($cek_kembali) {
            return redirect()->route('pengembalian.index')->with('error', 'Buku ini sudah pernah dikembalikan.');
        }

        $dt_kembali = Peminjaman_Buku::where('id_peminjaman', $request->id_peminjaman)->first();

        // Cek apakah sudah dikembalikan
        if ($dt_kembali->status === 'Dikembalikan') {
            return redirect()->route('pengembalian.index')->with('error', 'Buku ini sudah dikembalikan.');
        }

        $today = Carbon::now()->startOfDay();
        $tanggal_kembali = Carbon::parse($dt_kembali->tanggal_kembali)->startOfDay();
        $dendaperhari = 500;

        $hariTerlambat = 0;
        $denda = 0;

        if ($today->gt($tanggal_kembali)) {
            $hariTerlambat = $tanggal_kembali->diffInDays($today, false);
            $hariTerlambat = abs($hariTerlambat);
            $denda = $hariTerlambat * $dendaperhari;
        }

        // **PERBAIKAN: Simpan status lama SEBELUM diupdate**
        $statusLama = $dt_kembali->status;

        // Simpan pengembalian
        Pengembalian_Buku::create([
            'id_peminjaman' => $request->id_peminjaman,
            'tanggal_pengembalian' => $today->format('Y-m-d'),
            'denda' => $denda,
        ]);

        // Update status peminjaman
        $dt_kembali->update([
            'status' => 'Dikembalikan',
            'tanggal_dikembalikan' => $today->format('Y-m-d')
        ]);

        // **PERBAIKAN: Kembalikan stok HANYA jika status lama adalah Dipinjam atau Terlambat**
        if (in_array($statusLama, ['Dipinjam', 'Terlambat'])) {
            $buku = \App\Models\Buku::find($dt_kembali->id_buku);
            if ($buku) {
                $buku->increment('stok');
            }
        }

        if ($denda > 0) {
            $message = "Buku berhasil dikembalikan! Terlambat {$hariTerlambat} hari. Total denda: Rp " . number_format($denda, 0, ',', '.');
        } else {
            $message = 'Buku berhasil dikembalikan! Tidak ada denda.';
        }

        return redirect()->route('pengembalian.index')->with('success', $message);
    }

    public function show(string $id)
    {
        $pengembalian = Pengembalian_Buku::join('peminjaman_buku', 'peminjaman_buku.id_peminjaman', '=', 'pengembalian_buku.id_peminjaman')
            ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
            ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
            ->join('buku', 'buku.id_buku', '=', 'peminjaman_buku.id_buku')
            ->select(
                'pengembalian_buku.*',
                'siswa.nama_siswa',
                'kelas.nama_kelas',
                'buku.nama_buku',
                'peminjaman_buku.tanggal_pinjam',
                'peminjaman_buku.tanggal_kembali'
            )
            ->where('pengembalian_buku.id_pengembalian_buku', $id)
            ->firstOrFail();

        return view('pengembalian.show', compact('pengembalian'));
    }

    public function edit(string $id)
    {
        $pengembalian = Pengembalian_Buku::findOrFail($id);
        $peminjaman = Peminjaman_Buku::join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
            ->join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
            ->join('buku', 'buku.id_buku', '=', 'peminjaman_buku.id_buku')
            ->select('peminjaman_buku.*', 'siswa.nama_siswa', 'kelas.nama_kelas', 'buku.nama_buku')
            ->get();

        return view('pengembalian.edit', compact('pengembalian', 'peminjaman'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'denda' => 'required|numeric|min:0',
            'id_peminjaman' => 'required|exists:peminjaman_buku,id_peminjaman'
        ]);

        $pengembalian = Pengembalian_Buku::findOrFail($id);

        // Simpan id_peminjaman lama untuk update status
        $old_id_peminjaman = $pengembalian->id_peminjaman;

        // Update data pengembalian
        $pengembalian->update([
            'id_peminjaman' => $request->id_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'denda' => $request->denda,
        ]);

        if ($old_id_peminjaman != $request->id_peminjaman) {
            // Kembalikan status peminjaman lama ke 'Dipinjam'
            $old_peminjaman = Peminjaman_Buku::find($old_id_peminjaman);
            if ($old_peminjaman) {
                $old_peminjaman->update([
                    'status' => 'Dipinjam',
                    'tanggal_dikembalikan' => null
                ]);

                // Kurangi stok buku lama
                $buku_lama = \App\Models\Buku::find($old_peminjaman->id_buku);
                if ($buku_lama) {
                    $buku_lama->decrement('stok');
                }
            }
        }

        // Update status peminjaman baru
        $peminjaman = Peminjaman_Buku::find($request->id_peminjaman);
        if ($peminjaman) {
            $peminjaman->update([
                'status' => 'Dikembalikan',
                'tanggal_dikembalikan' => $request->tanggal_pengembalian
            ]);

            // Tambah stok buku baru
            $buku_baru = \App\Models\Buku::find($peminjaman->id_buku);
            if ($buku_baru) {
                $buku_baru->increment('stok');
            }
        }

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pengembalian = Pengembalian_Buku::findOrFail($id);

        $peminjaman = Peminjaman_Buku::find($pengembalian->id_peminjaman);

        if ($peminjaman) {
            $peminjaman->update([
                'status' => 'Dipinjam',
                'tanggal_dikembalikan' => null
            ]);

            // Kurangi stok buku (karena buku dianggap belum dikembalikan lagi)
            $buku = \App\Models\Buku::find($peminjaman->id_buku);
            if ($buku) {
                $buku->decrement('stok');
            }
        }

        // Hapus data pengembalian
        $pengembalian->delete();

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil dihapus dan status peminjaman dikembalikan.');
    }
}