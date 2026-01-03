<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Siswa::join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
            ->select('siswa.*', 'kelas.nama_kelas');

        if ($request->search) {
            $siswa->where('siswa.nama_siswa', 'like', '%' . $request->search . '%');
        }

        $siswa = $siswa->get();
        $mode = 'index';

        return view('siswa.siswa', compact('siswa', 'mode'));
    }

    public function create()
    {
        $mode = 'create';
        $siswa = (object) [];
        $kelas = Kelas::all();
        return view('siswa.siswa', compact('mode', 'siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:L,P',  // ← UBAH INI
            'alamat' => 'required|string',
            'id_kelas' => 'required|exists:kelas,id_kelas',
        ]);

        Siswa::create($request->all());
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $siswa = Siswa::join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
            ->select('siswa.*', 'kelas.nama_kelas')
            ->where('siswa.id_siswa', $id)
            ->firstOrFail();

        return view('siswa.show', compact('siswa'));
    }

    public function edit(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $mode = 'edit';
        $kelas = Kelas::all();
        return view('siswa.siswa', compact('siswa', 'mode', 'kelas'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:L,P',  // ← UBAH INI
            'alamat' => 'required|string',
            'id_kelas' => 'required|exists:kelas,id_kelas',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        // Cek apakah siswa memiliki data peminjaman
        if ($siswa->peminjaman()->count() > 0) {
            return redirect()->route('siswa.index')
                ->with('error', 'Siswa tidak dapat dihapus karena masih memiliki data peminjaman buku.');
        }

        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}