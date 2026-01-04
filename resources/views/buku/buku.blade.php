<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode == 'index' ? 'Manajemen Buku' : ($mode == 'create' ? 'Tambah Buku' : 'Edit Buku') }} - SmartLib</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: radial-gradient(circle at top right, #f0f9ff, #e0f2fe);
            color: #1e293b;
            min-height: 100vh;
        }

        .blue-gradient-glow {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .inner-soft-shadow {
            box-shadow: inset 2px 2px 5px rgba(0,0,0,0.02), inset -2px -2px 5px rgba(255,255,255,0.7);
        }

        .btn-hover-effect {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-hover-effect:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        /* Standarisasi Table */
        .premium-table thead tr {
            background: rgba(241, 245, 249, 0.5);
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            font-weight: 800;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="pb-20">
    <div class="fixed top-0 left-0 w-1.5 h-full blue-gradient-glow z-[60]"></div>

    <nav class="glass-nav sticky top-0 z-50 px-8 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 blue-gradient-glow rounded-2xl flex items-center justify-center text-white text-xl shadow-lg">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tighter text-slate-900 leading-none">
                        @if($mode == 'index') Manajemen Buku @else Form {{ $mode == 'create' ? 'Tambah' : 'Edit' }} Buku @endif
                    </h1>
                    <span class="text-[9px] font-black text-blue-500 uppercase tracking-[0.2em]">SmartLib</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col items-end mr-2">
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Admin</span>
                    <span class="text-xs font-bold text-slate-700">{{ session('name') }}</span>
                </div>
                <a href="{{ $mode == 'index' ? route('dashboard') : route('buku.index') }}" class="bg-slate-900 hover:bg-black text-white px-6 py-2.5 rounded-xl transition-all text-xs font-bold shadow-lg flex items-center gap-2 active:scale-95">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="container max-w-7xl mx-auto px-6 mt-12">
        @if($mode == 'index')
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Katalog Buku</h2>
                    <p class="text-slate-500 font-medium">Kelola stok dan data buku dalam satu panel.</p>
                </div>
                <a href="{{ route('buku.create') }}" class="w-full md:w-auto blue-gradient-glow text-white px-8 py-4 rounded-2xl font-bold flex items-center justify-center gap-3 btn-hover-effect">
                    <i class="fa-solid fa-plus-circle text-lg"></i> Tambah Koleksi Baru
                </a>
            </div>

            <div class="grid grid-cols-1 gap-6 mb-8">
                {{-- Notifikasi Success --}}
                @if(session('success'))
                    <script>
                        Swal.fire({ 
                            toast: true, 
                            position: 'top-end', 
                            icon: 'success', 
                            title: "{{ session('success') }}", 
                            showConfirmButton: false, 
                            timer: 3000,
                            timerProgressBar: true
                        });
                    </script>
                @endif

                {{-- Notifikasi Error --}}
                @if(session('error'))
                    <script>
                        Swal.fire({ 
                            toast: true, 
                            position: 'top-end', 
                            icon: 'error', 
                            title: "{{ session('error') }}", 
                            showConfirmButton: false, 
                            timer: 4000,
                            timerProgressBar: true
                        });
                    </script>
                @endif

                <div class="glass-card p-3 rounded-[2rem] shadow-xl">
                    <form action="{{ route('buku.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                        <div class="relative flex-1 group">
                            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, atau kategori..." 
                                   class="w-full bg-slate-100/50 border-none rounded-[1.5rem] pl-12 pr-6 py-4 outline-none transition-all focus:bg-white focus:ring-4 focus:ring-blue-100 font-medium">
                        </div>
                        <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-[1.5rem] font-bold btn-hover-effect shadow-lg">Filter Data</button>
                    </form>
                </div>
            </div>

            <div class="glass-card rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/60">
                <div class="overflow-x-auto">
                    <table class="w-full premium-table">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="px-8 py-6 text-center w-20">No</th>
                                <th class="px-6 py-6">Informasi Buku</th>
                                <th class="px-6 py-6">Kategori</th>
                                <th class="px-6 py-6 text-center">Tahun</th>
                                <th class="px-6 py-6 text-center">Stok</th>
                                <th class="px-8 py-6 text-right">Manajemen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($buku as $index => $item)
                                <tr class="hover:bg-blue-50/40 transition-all group">
                                    <td class="px-8 py-6 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                                    <td class="px-6 py-6">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800 text-lg group-hover:text-blue-600 transition-colors">{{ $item->nama_buku }}</span>
                                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest mt-1">{{ $item->penulis }} • {{ $item->penerbit }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="bg-blue-100 text-blue-600 px-4 py-1.5 rounded-xl font-extrabold text-[10px] uppercase tracking-wider">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-center font-bold text-slate-600">{{ $item->tahun_terbit }}</td>
                                    <td class="px-6 py-6 text-center">
                                        @if($item->stok == 0)
                                            <span class="bg-red-100 text-red-600 px-4 py-1.5 rounded-xl font-black text-[10px] uppercase">Habis</span>
                                        @elseif($item->stok <= 5)
                                            <span class="bg-orange-100 text-orange-600 px-4 py-1.5 rounded-xl font-black text-[10px] uppercase">{{ $item->stok }} Unit</span>
                                        @else
                                            <span class="bg-emerald-100 text-emerald-600 px-4 py-1.5 rounded-xl font-black text-[10px] uppercase">{{ $item->stok }} Unit</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('buku.edit', $item->id_buku) }}" class="w-10 h-10 flex items-center justify-center bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl transition-all shadow-sm">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @if(session('role') === 'superadmin')
                                                <form action="{{ route('buku.destroy', $item->id_buku) }}" method="POST" class="inline delete-form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this)" class="w-10 h-10 flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all shadow-sm">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center opacity-20 italic">
                                            <i class="fa-solid fa-inbox text-6xl mb-4"></i>
                                            <p class="text-xl font-bold">Katalog buku masih kosong</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        @else
            <div class="max-w-3xl mx-auto">
                <div class="glass-card p-10 md:p-16 rounded-[3.5rem] shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 blue-gradient-glow opacity-10 rounded-full -mr-16 -mt-16"></div>
                    
                    <h2 class="text-3xl font-black text-slate-900 tracking-tighter mb-10">
                        {{ $mode == 'create' ? 'Entri Koleksi Baru' : 'Perbarui Metadata Buku' }}
                    </h2>

                    <form action="{{ $mode == 'create' ? route('buku.store') : route('buku.update', $buku->id_buku) }}" method="POST" class="space-y-6">
                        @csrf
                        @if($mode == 'edit') @method('PUT') @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-[11px] font-black text-blue-600 uppercase tracking-widest ml-1">Judul Utama Buku</label>
                                <input type="text" name="nama_buku" value="{{ old('nama_buku', $buku->nama_buku ?? '') }}" 
                                       class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-semibold" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Penulis / Pengarang</label>
                                <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis ?? '') }}" 
                                       class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-semibold" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Penerbit</label>
                                <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit ?? '') }}" 
                                       class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-semibold" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Kategori</label>
                                <select name="kategori" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-bold appearance-none" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach(['Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Biografi', 'Pendidikan'] as $kat)
                                        <option value="{{ $kat }}" {{ old('kategori', $buku->kategori ?? '') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tahun</label>
                                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" min="1900" max="2030" 
                                           class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-semibold text-center" required>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Stok</label>
                                    <input type="number" name="stok" value="{{ old('stok', $buku->stok ?? '') }}" min="0" 
                                           class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-semibold text-center" required>
                                </div>
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Sinopsis Singkat</label>
                                <textarea name="deskripsi" rows="4" class="w-full bg-slate-50 border-none rounded-3xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-medium">{{ old('deskripsi', $buku->deskripsi ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 pt-6">
                            <button type="submit" class="flex-[2] blue-gradient-glow text-white font-bold py-5 rounded-[2rem] btn-hover-effect shadow-xl text-lg">
                                <i class="fa-solid fa-save mr-2"></i> {{ $mode == 'create' ? 'Verifikasi & Simpan' : 'Perbarui Data' }}
                            </button>
                            <a href="{{ route('buku.index') }}" class="flex-1 bg-slate-100 text-slate-500 font-bold py-5 rounded-[2rem] text-center hover:bg-slate-200 transition-all text-lg">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Hapus Koleksi?',
                text: "Data buku tidak dapat dipulihkan setelah dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: { confirmButton: 'rounded-xl px-8 py-3', cancelButton: 'rounded-xl px-8 py-3 text-slate-600' }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
</body>

</html>