<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $siswa = Siswa::join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                      ->select('siswa.*', 'kelas.nama_kelas');

        if ($request->search) {
            $siswa->where('siswa.nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('siswa.alamat', 'like', '%' . $request->search . '%')
                  ->orWhere('kelas.nama_kelas', 'like', '%' . $request->search . '%');
        }

        $siswa = $siswa->get();

        return view('siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('siswa.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'id_kelas' => 'required|exists:kelas,id_kelas',
        ]);

        Siswa::create($request->all());
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = Siswa::join('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                      ->select('siswa.*', 'kelas.nama_kelas')
                      ->where('siswa.id_siswa', $id)
                      ->firstOrFail();
        
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'id_kelas' => 'required|exists:kelas,id_kelas',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}