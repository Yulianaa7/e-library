<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman_Buku;
use App\Models\Siswa;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggalDari = $request->input('tanggal_dari');
        $tanggalSampai = $request->input('tanggal_sampai');

        $peminjaman = Peminjaman_Buku::with(['siswa.kelas', 'buku'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('siswa', function ($s) use ($search) {
                        $s->where('nama_siswa', 'like', "%{$search}%");
                    })
                    ->orWhereHas('buku', function ($b) use ($search) {
                        $b->where('nama_buku', 'like', "%{$search}%");
                    });
                });
            })
            ->when($tanggalDari, function ($query) use ($tanggalDari) {
                $query->whereDate('tanggal_pinjam', '>=', $tanggalDari);
            })
            ->when($tanggalSampai, function ($query) use ($tanggalSampai) {
                $query->whereDate('tanggal_pinjam', '<=', $tanggalSampai);
            })
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return view('peminjaman.peminjaman', [
            'mode' => 'index',
            'peminjaman' => $peminjaman
        ]);
    }

    public function create()
    {
        return view('peminjaman.peminjaman', [
            'mode' => 'create',
            'peminjaman' => new Peminjaman_Buku(),
            'siswa' => Siswa::with('kelas')->get(),
            'buku' => Buku::where('stok', '>', 0)->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_buku' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Cek stok buku
        $buku = Buku::findOrFail($validated['id_buku']);
        if ($buku->stok <= 0) {
            return redirect()->back()
                            ->with('error', 'Stok buku tidak tersedia.')
                            ->withInput();
        }

        $validated['status'] = 'Dipinjam';
        $validated['tanggal_dikembalikan'] = null;

        Peminjaman_Buku::create($validated);

        // Kurangi stok karena status default adalah Dipinjam
        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman_Buku::with(['siswa.kelas', 'buku'])->findOrFail($id);

        return view('peminjaman.peminjaman', [
            'mode' => 'show',
            'peminjaman' => $peminjaman
        ]);
    }

    public function edit($id)
    {
        return view('peminjaman.peminjaman', [
            'mode' => 'edit',
            'peminjaman' => Peminjaman_Buku::findOrFail($id),
            'siswa' => Siswa::with('kelas')->get(),
            'buku' => Buku::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman_Buku::findOrFail($id);

        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_buku' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'status' => 'required|in:Dipinjam,Dikembalikan,Terlambat',
            'tanggal_dikembalikan' => 'nullable|date',
        ]);

        // Simpan data lama
        $statusLama = $peminjaman->status;
        $bukuLama = Buku::findOrFail($peminjaman->id_buku);
        $statusBaru = $validated['status'];
        $idBukuBaru = $validated['id_buku'];
        $bukuBerubah = $peminjaman->id_buku != $idBukuBaru;

        // LOGIKA UPDATE STOK
        
        // 1. Jika buku berubah
        if ($bukuBerubah) {
            $bukuBaru = Buku::findOrFail($idBukuBaru);
            
            // Kembalikan stok buku lama jika status lama Dipinjam atau Terlambat
            if (in_array($statusLama, ['Dipinjam', 'Terlambat'])) {
                $bukuLama->increment('stok');
            }
            
            // Kurangi stok buku baru jika status baru Dipinjam atau Terlambat
            if (in_array($statusBaru, ['Dipinjam', 'Terlambat'])) {
                if ($bukuBaru->stok <= 0) {
                    return redirect()->back()
                                    ->with('error', 'Stok buku tidak tersedia.')
                                    ->withInput();
                }
                $bukuBaru->decrement('stok');
            }
        }
        // 2. Jika buku sama tapi status berubah
        else {
            // Dari (Dipinjam/Terlambat) → Dikembalikan: tambah stok
            if (in_array($statusLama, ['Dipinjam', 'Terlambat']) && $statusBaru === 'Dikembalikan') {
                $bukuLama->increment('stok');
                
                // Set tanggal dikembalikan
                $validated['tanggal_dikembalikan'] = 
                    $validated['tanggal_dikembalikan'] ?? Carbon::now()->format('Y-m-d');
            }
            // Dari Dikembalikan → (Dipinjam/Terlambat): kurangi stok
            elseif ($statusLama === 'Dikembalikan' && in_array($statusBaru, ['Dipinjam', 'Terlambat'])) {
                if ($bukuLama->stok <= 0) {
                    return redirect()->back()
                                    ->with('error', 'Stok buku tidak tersedia.')
                                    ->withInput();
                }
                $bukuLama->decrement('stok');
                
                // Reset tanggal dikembalikan
                $validated['tanggal_dikembalikan'] = null;
            }
            // Dari Dipinjam → Terlambat atau sebaliknya: tidak ada perubahan stok
            elseif (in_array($statusLama, ['Dipinjam', 'Terlambat']) && in_array($statusBaru, ['Dipinjam', 'Terlambat'])) {
                // Tidak ada perubahan stok
                // Tapi reset tanggal dikembalikan
                $validated['tanggal_dikembalikan'] = null;
            }
        }

        // Reset tanggal dikembalikan jika status bukan Dikembalikan
        if ($statusBaru !== 'Dikembalikan') {
            $validated['tanggal_dikembalikan'] = null;
        }

        // **TAMBAHAN: Hapus dari tabel pengembalian jika status berubah ke Dikembalikan melalui edit peminjaman**
        if ($statusBaru === 'Dikembalikan') {
            // Hapus data pengembalian jika ada (untuk menghindari duplikasi)
            \App\Models\Pengembalian_Buku::where('id_peminjaman', $id)->delete();
        }

        $peminjaman->update($validated);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil diupdate!');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman_Buku::findOrFail($id);

        // Cek apakah status masih Dipinjam atau Terlambat
        if (in_array($peminjaman->status, ['Dipinjam', 'Terlambat'])) {
            return redirect()->route('peminjaman.index')
                            ->with('error', 'Peminjaman tidak dapat dihapus karena buku masih dipinjam. Silakan kembalikan buku terlebih dahulu.');
        }

        // Hapus data pengembalian yang terkait terlebih dahulu
        \App\Models\Pengembalian_Buku::where('id_peminjaman', $id)->delete();

        // Hapus peminjaman (stok tidak perlu dikembalikan karena status sudah Dikembalikan)
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
                        ->with('success', 'Data peminjaman berhasil dihapus!');
    }
}