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

        $validated['status'] = 'Dipinjam';
        $validated['tanggal_dikembalikan'] = null;

        Peminjaman_Buku::create($validated);

        Buku::where('id_buku', $validated['id_buku'])->decrement('stok');

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

        // Jika status berubah ke Dikembalikan
        if ($validated['status'] === 'Dikembalikan' && $peminjaman->status !== 'Dikembalikan') {
            Buku::where('id_buku', $peminjaman->id_buku)->increment('stok');

            $validated['tanggal_dikembalikan'] =
                $validated['tanggal_dikembalikan'] ?? Carbon::now()->format('Y-m-d');
        }

        // Jika status bukan Dikembalikan, reset tanggal kembali
        if ($validated['status'] !== 'Dikembalikan') {
            $validated['tanggal_dikembalikan'] = null;
        }

        $peminjaman->update($validated);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil diupdate!');
    }


    public function destroy($id)
    {
        $peminjaman = Peminjaman_Buku::findOrFail($id);

        if ($peminjaman->status !== 'Dikembalikan') {
            Buku::where('id_buku', $peminjaman->id_buku)->increment('stok');
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus!');
    }
}
