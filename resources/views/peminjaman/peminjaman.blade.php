<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode == 'index' ? 'Peminjaman Buku' : ($mode == 'create' ? 'Input Peminjaman' : 'Edit Transaksi') }} - SmartLib</title>
    
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

        .status-badge {
            padding: 6px 16px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
</head>

<body class="pb-20">
    <div class="fixed top-0 left-0 w-1.5 h-full blue-gradient-glow z-[60]"></div>

    <nav class="glass-nav sticky top-0 z-50 px-8 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 blue-gradient-glow rounded-2xl flex items-center justify-center text-white text-xl shadow-lg">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tighter text-slate-900 leading-none">
                        @if($mode == 'index') Peminjaman Buku @else Transaksi @endif
                    </h1>
                    <span class="text-[9px] font-black text-blue-500 uppercase tracking-[0.2em]">SmartLib</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ $mode == 'index' ? route('dashboard') : route('peminjaman.index') }}" class="bg-slate-900 hover:bg-black text-white px-6 py-2.5 rounded-xl transition-all text-xs font-bold shadow-lg flex items-center gap-2 active:scale-95">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="container max-w-7xl mx-auto px-6 mt-12">
        @if($mode == 'index')
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Riwayat Peminjaman</h2>
                    <p class="text-slate-500 font-medium">Kelola peminjaman dan pantau masa aktif pengembalian.</p>
                </div>
                <a href="{{ route('peminjaman.create') }}" class="w-full md:w-auto blue-gradient-glow text-white px-8 py-4 rounded-2xl font-bold flex items-center justify-center gap-3 btn-hover-effect">
                    <i class="fa-solid fa-plus-circle text-lg"></i> Pinjam Koleksi
                </a>
            </div>

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

            <div class="glass-card p-6 rounded-[2.5rem] shadow-xl mb-10">
                <form action="{{ route('peminjaman.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-5 relative group">
                        <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa atau buku..." 
                               class="w-full bg-slate-100/50 border-none rounded-2xl pl-12 pr-6 py-4 outline-none transition-all focus:bg-white focus:ring-4 focus:ring-blue-100 font-medium text-slate-700 shadow-sm">
                    </div>

                    <div class="md:col-span-3 relative group">
                        <label class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-blue-500 uppercase tracking-widest z-10">Mulai Dari</label>
                        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" 
                               class="w-full bg-slate-100/50 border-none rounded-2xl px-5 py-4 outline-none focus:bg-white focus:ring-4 focus:ring-blue-100 font-medium text-slate-500 shadow-sm">
                    </div>

                    <div class="md:col-span-3 relative group">
                        <label class="absolute -top-2.5 left-4 px-2 bg-white text-[9px] font-black text-blue-500 uppercase tracking-widest z-10">Sampai Tanggal</label>
                        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" 
                               class="w-full bg-slate-100/50 border-none rounded-2xl px-5 py-4 outline-none focus:bg-white focus:ring-4 focus:ring-blue-100 font-medium text-slate-500 shadow-sm">
                    </div>

                    <div class="md:col-span-1 flex gap-2">
                        <button type="submit" class="w-full blue-gradient-glow text-white rounded-2xl font-bold btn-hover-effect flex items-center justify-center">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                        @if(request('search') || request('tanggal_dari') || request('tanggal_sampai'))
                            <a href="{{ route('peminjaman.index') }}" class="w-full bg-slate-200 text-slate-600 rounded-2xl flex items-center justify-center hover:bg-slate-300 transition-all shadow-sm" title="Reset Filter">
                                <i class="fa-solid fa-rotate-right"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="glass-card rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/60">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-slate-400 text-[11px] uppercase tracking-[0.2em] font-black border-b border-slate-100">
                                <th class="px-10 py-8 text-center">No</th>
                                <th class="px-6 py-8">Peminjam & Kelas</th>
                                <th class="px-6 py-8">Koleksi Buku</th>
                                <th class="px-6 py-8 text-center">Periode Pinjam</th>
                                <th class="px-6 py-8 text-center">Status</th>
                                <th class="px-10 py-8 text-right">Manajemen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($peminjaman as $index => $p)
                                @php
                                    $today = \Carbon\Carbon::now()->startOfDay();
                                    $tglKembali = \Carbon\Carbon::parse($p->tanggal_kembali)->startOfDay();
                                    $isOverdue = $p->status != 'Dikembalikan' && $today->gt($tglKembali);
                                @endphp
                                <tr class="hover:bg-blue-50/40 transition-all group">
                                    <td class="px-10 py-7 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                                    <td class="px-6 py-7">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800 text-lg group-hover:text-blue-600 transition-colors leading-tight">{{ $p->siswa->nama_siswa }}</span>
                                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Kelas: {{ $p->siswa->kelas->nama_kelas }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-7">
                                        <span class="text-sm font-bold text-slate-600 italic">"{{ $p->buku->nama_buku }}"</span>
                                    </td>
                                    <td class="px-6 py-7 text-center">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-lg">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</span>
                                            <span class="text-[9px] font-black text-slate-400 uppercase">Hingga: {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-7 text-center">
                                        @if($p->status == 'Dikembalikan')
                                            <span class="status-badge bg-emerald-100 text-emerald-600">Selesai</span>
                                        @elseif($isOverdue)
                                            <span class="status-badge bg-red-100 text-red-600 animate-pulse">Terlambat</span>
                                        @else
                                            <span class="status-badge bg-orange-100 text-orange-600">Dipinjam</span>
                                        @endif
                                    </td>
                                    <td class="px-10 py-7 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('peminjaman.show', $p->id_peminjaman) }}" class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl transition-all shadow-sm">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('peminjaman.edit', $p->id_peminjaman) }}" class="w-10 h-10 flex items-center justify-center bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl transition-all shadow-sm">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @if(session('role') === 'superadmin')
                                                <form action="{{ route('peminjaman.destroy', $p->id_peminjaman) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this, '{{ $p->status }}')" class="w-10 h-10 flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all shadow-sm">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-10 py-24 text-center opacity-30 italic font-bold text-xl">Data peminjaman tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        @elseif($mode == 'show')
            <div class="max-w-2xl mx-auto">
                <div class="glass-card p-12 rounded-[3.5rem] shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 blue-gradient-glow opacity-10 rounded-full -mr-16 -mt-16"></div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tighter mb-10">Pratinjau Transaksi</h2>

                    <div class="space-y-6">
                        <div class="p-8 bg-slate-50/50 rounded-3xl border border-slate-100 inner-soft-shadow text-center">
                            <label class="text-[10px] font-black text-blue-500 uppercase tracking-widest block mb-2">Status Saat Ini</label>
                            <span class="text-2xl font-black uppercase tracking-tight text-slate-800">{{ $peminjaman->status }}</span>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-5 bg-white/50 rounded-2xl border border-slate-100">
                                <span class="text-sm font-bold text-slate-400">Peminjam</span>
                                <span class="font-black text-slate-800">{{ $peminjaman->siswa->nama_siswa }}</span>
                            </div>
                            <div class="flex justify-between items-center p-5 bg-white/50 rounded-2xl border border-slate-100">
                                <span class="text-sm font-bold text-slate-400">Judul Buku</span>
                                <span class="font-black text-slate-800 italic">"{{ $peminjaman->buku->nama_buku }}"</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-5 bg-white/50 rounded-2xl border border-slate-100 text-center">
                                    <label class="text-[10px] font-black text-slate-400 uppercase block mb-1">Tgl Pinjam</label>
                                    <span class="font-black text-slate-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</span>
                                </div>
                                <div class="p-5 bg-white/50 rounded-2xl border border-slate-100 text-center">
                                    <label class="text-[10px] font-black text-slate-400 uppercase block mb-1">Batas Kembali</label>
                                    <span class="font-black text-slate-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('peminjaman.index') }}" class="w-full py-5 blue-gradient-glow text-white font-bold rounded-[2rem] text-center btn-hover-effect block shadow-xl mt-8">
                            Tutup Rincian
                        </a>
                    </div>
                </div>
            </div>

        @else
            <div class="max-w-2xl mx-auto">
                <div class="glass-card p-10 md:p-14 rounded-[3.5rem] shadow-2xl relative overflow-hidden border border-white">
                    <div class="absolute top-0 right-0 w-32 h-32 blue-gradient-glow opacity-10 rounded-full -mr-16 -mt-16"></div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tighter mb-10">
                        {{ $mode == 'create' ? 'Entri Peminjaman Baru' : 'Perbarui Transaksi' }}
                    </h2>

                    <form action="{{ $mode == 'create' ? route('peminjaman.store') : route('peminjaman.update', $peminjaman->id_peminjaman) }}" method="POST" class="space-y-6">
                        @csrf
                        @if($mode == 'edit') @method('PUT') @endif

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-blue-600 uppercase tracking-widest ml-1">Identitas Siswa</label>
                            <select name="id_siswa" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-bold appearance-none" required>
                                <option value="">-- Cari Nama Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id_siswa }}" {{ old('id_siswa', $peminjaman->id_siswa ?? '') == $s->id_siswa ? 'selected' : '' }}>
                                        {{ $s->nama_siswa }} (Kelas: {{ $s->kelas->nama_kelas }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-blue-600 uppercase tracking-widest ml-1">Koleksi Buku</label>
                            <select name="id_buku" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-bold appearance-none" required>
                                <option value="">-- Pilih Judul Buku --</option>
                                @foreach($buku as $b)
                                    <option value="{{ $b->id_buku }}" {{ old('id_buku', $peminjaman->id_buku ?? '') == $b->id_buku ? 'selected' : '' }}>
                                        {{ $b->nama_buku }} (Stok Tersedia: {{ $b->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Peminjaman</label>
                                <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam ?? date('Y-m-d')) }}" 
                                       class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-bold" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tenggat Waktu</label>
                                <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali ?? date('Y-m-d', strtotime('+7 days'))) }}" 
                                       class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-bold" required>
                            </div>
                        </div>

                        @if($mode == 'edit')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-blue-50/50 rounded-3xl border border-blue-100 mt-6">
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-emerald-600 uppercase tracking-widest ml-1">Update Status</label>
                                    <select name="status" class="w-full bg-white border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-emerald-100 font-bold appearance-none">
                                        <option value="Dipinjam" {{ old('status', $peminjaman->status) == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="Dikembalikan" {{ old('status', $peminjaman->status) == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                        <option value="Terlambat" {{ old('status', $peminjaman->status) == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tgl Pengembalian</label>
                                    <input type="date" name="tanggal_dikembalikan" value="{{ old('tanggal_dikembalikan', $peminjaman->tanggal_dikembalikan) }}" 
                                           class="w-full bg-white border-none rounded-2xl px-6 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-bold">
                                </div>
                            </div>
                        @endif

                        <div class="flex flex-col md:flex-row gap-4 pt-8">
                            <button type="submit" class="flex-[2] blue-gradient-glow text-white font-bold py-5 rounded-[2rem] btn-hover-effect shadow-xl text-lg">
                                <i class="fa-solid fa-save mr-2"></i> {{ $mode == 'create' ? 'Proses Pinjam' : 'Simpan Perubahan' }}
                            </button>
                            <a href="{{ route('peminjaman.index') }}" class="flex-1 bg-slate-100 text-slate-500 font-bold py-5 rounded-[2rem] text-center hover:bg-slate-200 transition-all text-lg">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <script>
        function confirmDelete(button, status) {
            if (status === 'Dipinjam' || status === 'Terlambat') {
                Swal.fire({
                    title: 'Tidak Dapat Dihapus!',
                    text: "Peminjaman dengan status '" + status + "' tidak dapat dihapus. Silakan kembalikan buku terlebih dahulu.",
                    icon: 'error',
                    confirmButtonColor: '#2563eb',
                    confirmButtonText: 'Mengerti',
                    customClass: { confirmButton: 'rounded-xl px-8 py-3' }
                });
                return;
            }

            Swal.fire({
                title: 'Hapus Transaksi?',
                text: "Data riwayat pinjam ini akan dihapus permanen dari sistem!",
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