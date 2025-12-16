<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $kelas = Kelas::when($search, function($query, $search) {
            return $query->where('nama_kelas', 'like', "%{$search}%")
                        ->orWhere('wali_kelas', 'like', "%{$search}%");
        })->get();

        return view('kelas.kelas', [
            'mode' => 'index',
            'kelas' => $kelas
        ]);
    }

    public function create()
    {
        return view('kelas.kelas', [
            'mode' => 'create',
            'kelas' => new Kelas()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas' => 'required|string|max:255',
        ]);

        Kelas::create($validated);

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        return view('kelas.kelas', [
            'mode' => 'edit',
            'kelas' => $kelas
        ]);
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas' => 'required|string|max:255',
        ]);

        $kelas->update($validated);

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil diupdate!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}