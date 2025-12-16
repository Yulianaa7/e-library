<?php

namespace App\Http\Controllers;

use App\Models\Detail_Peminjaman_Buku;
use App\Models\Peminjaman_Buku;
use App\Models\Buku;
use Illuminate\Http\Request;

class DetailPeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $detail = Detail_Peminjaman_Buku::join('peminjaman_buku', 'detail_peminjaman_buku.id_peminjaman_buku', '=', 'peminjaman_buku.id_peminjaman_buku')
                                        ->join('buku', 'detail_peminjaman_buku.id_buku', '=', 'buku.id_buku')
                                        ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
                                        ->select('detail_peminjaman_buku.*', 
                                                 'peminjaman_buku.tanggal_pinjam', 
                                                 'peminjaman_buku.tanggal_kembali',
                                                 'buku.nama_buku', 
                                                 'siswa.nama_siswa');

        if ($request->search) {
            $detail->where('buku.nama_buku', 'like', '%' . $request->search . '%')
                   ->orWhere('siswa.nama_siswa', 'like', '%' . $request->search . '%')
                   ->orWhere('peminjaman_buku.tanggal_pinjam', 'like', '%' . $request->search . '%');
        }

        $detail = $detail->get();

        return view('detail_peminjaman.index', compact('detail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peminjaman = Peminjaman_Buku::join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
                                     ->select('peminjaman_buku.*', 'siswa.nama_siswa')
                                     ->get();
        $buku = Buku::where('stok', '>', 0)->get();

        return view('detail_peminjaman.create', compact('peminjaman', 'buku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman_buku' => 'required|exists:peminjaman_buku,id_peminjaman_buku',
            'id_buku' => 'required|exists:buku,id_buku',
            'qty' => 'required|integer|min:1',
        ]);

        // Cek stok buku
        $buku = Buku::findOrFail($request->id_buku);
        
        if ($buku->stok < $request->qty) {
            return redirect()->back()->with('error', 'Stok buku tidak mencukupi. Stok tersedia: ' . $buku->stok);
        }

        // Simpan detail peminjaman
        Detail_Peminjaman_Buku::create($request->all());

        // Kurangi stok buku
        $buku->stok -= $request->qty;
        $buku->save();

        return redirect()->route('detail_peminjaman.index')->with('success', 'Detail peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detail = Detail_Peminjaman_Buku::join('peminjaman_buku', 'detail_peminjaman_buku.id_peminjaman_buku', '=', 'peminjaman_buku.id_peminjaman_buku')
                                        ->join('buku', 'detail_peminjaman_buku.id_buku', '=', 'buku.id_buku')
                                        ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
                                        ->select('detail_peminjaman_buku.*', 
                                                 'peminjaman_buku.tanggal_pinjam', 
                                                 'peminjaman_buku.tanggal_kembali',
                                                 'buku.nama_buku',
                                                 'buku.penulis',
                                                 'siswa.nama_siswa')
                                        ->where('detail_peminjaman_buku.id_detail', $id)
                                        ->firstOrFail();

        return view('detail_peminjaman.show', compact('detail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $detail = Detail_Peminjaman_Buku::findOrFail($id);
        $peminjaman = Peminjaman_Buku::join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
                                     ->select('peminjaman_buku.*', 'siswa.nama_siswa')
                                     ->get();
        $buku = Buku::all();

        return view('detail_peminjaman.edit', compact('detail', 'peminjaman', 'buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_peminjaman_buku' => 'required|exists:peminjaman_buku,id_peminjaman_buku',
            'id_buku' => 'required|exists:buku,id_buku',
            'qty' => 'required|integer|min:1',
        ]);

        $detail = Detail_Peminjaman_Buku::findOrFail($id);
        
        // Kembalikan stok buku lama
        $buku_lama = Buku::findOrFail($detail->id_buku);
        $buku_lama->stok += $detail->qty;
        $buku_lama->save();

        // Cek stok buku baru
        $buku_baru = Buku::findOrFail($request->id_buku);
        
        if ($buku_baru->stok < $request->qty) {
            return redirect()->back()->with('error', 'Stok buku tidak mencukupi. Stok tersedia: ' . $buku_baru->stok);
        }

        // Update detail peminjaman
        $detail->update($request->all());

        // Kurangi stok buku baru
        $buku_baru->stok -= $request->qty;
        $buku_baru->save();

        return redirect()->route('detail_peminjaman.index')->with('success', 'Detail peminjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $detail = Detail_Peminjaman_Buku::findOrFail($id);
        
        // Kembalikan stok buku
        $buku = Buku::findOrFail($detail->id_buku);
        $buku->stok += $detail->qty;
        $buku->save();

        // Hapus detail peminjaman
        $detail->delete();

        return redirect()->route('detail_peminjaman.index')->with('success', 'Detail peminjaman berhasil dihapus dan stok buku dikembalikan.');
    }
}