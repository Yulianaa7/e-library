<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman_Buku;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $peminjaman = Peminjaman_Buku::join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
                                     ->join('kelas', 'kelas.id_kelas', '=', 'peminjaman_buku.id_kelas')
                                     ->select('peminjaman_buku.*', 'siswa.nama_siswa', 'kelas.nama_kelas');

        if ($request->search) {
            $peminjaman->where('siswa.nama_siswa', 'like', '%' . $request->search . '%')
                       ->orWhere('kelas.nama_kelas', 'like', '%' . $request->search . '%')
                       ->orWhere('peminjaman_buku.tanggal_pinjam', 'like', '%' . $request->search . '%');
        }

        $peminjaman = $peminjaman->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        $buku = Buku::where('stok', '>', 0)->get(); // Hanya buku yang stoknya > 0
        
        return view('peminjaman.create', compact('siswa', 'kelas', 'buku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'tanggal_pinjam' => 'nullable|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Set tanggal pinjam otomatis jika tidak diisi
        $data = $request->all();
        if (empty($data['tanggal_pinjam'])) {
            $data['tanggal_pinjam'] = Carbon::now()->format('Y-m-d');
        }

        Peminjaman_Buku::create($data);
        
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $peminjaman = Peminjaman_Buku::join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
                                     ->join('kelas', 'kelas.id_kelas', '=', 'peminjaman_buku.id_kelas')
                                     ->select('peminjaman_buku.*', 'siswa.nama_siswa', 'kelas.nama_kelas')
                                     ->where('peminjaman_buku.id_peminjaman_buku', $id)
                                     ->firstOrFail();
        
        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peminjaman = Peminjaman_Buku::findOrFail($id);
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        $buku = Buku::all();
        
        return view('peminjaman.edit', compact('peminjaman', 'siswa', 'kelas', 'buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $peminjaman = Peminjaman_Buku::findOrFail($id);
        $peminjaman->update($request->all());
        
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjaman = Peminjaman_Buku::findOrFail($id);
        $peminjaman->delete();
        
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}