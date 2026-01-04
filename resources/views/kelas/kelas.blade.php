<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode == 'index' ? 'Manajemen Kelas' : ($mode == 'create' ? 'Tambah Kelas' : 'Edit Kelas') }} - SmartLib</title>
    
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

        .icon-box-premium {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0369a1;
        }
    </style>
</head>

<body class="pb-20">
    <div class="fixed top-0 left-0 w-1.5 h-full blue-gradient-glow z-[60]"></div>

    <nav class="glass-nav sticky top-0 z-50 px-8 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 blue-gradient-glow rounded-2xl flex items-center justify-center text-white text-xl shadow-lg">
                    <i class="fa-solid fa-school"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tighter text-slate-900 leading-none">
                        @if($mode == 'index') Manajemen Kelas @else Form {{ $mode == 'create' ? 'Baru' : 'Edit' }} Kelas @endif
                    </h1>
                    <span class="text-[9px] font-black text-blue-500 uppercase tracking-[0.2em]">SmartLib</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ $mode == 'index' ? route('dashboard') : route('kelas.index') }}" class="bg-slate-900 hover:bg-black text-white px-6 py-2.5 rounded-xl transition-all text-xs font-bold shadow-lg flex items-center gap-2 active:scale-95">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="container max-w-7xl mx-auto px-6 mt-12">
        @if($mode == 'index')
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Data Struktur Kelas</h2>
                    <p class="text-slate-500 font-medium">Kelola rombongan belajar dan penugasan wali kelas.</p>
                </div>
                <a href="{{ route('kelas.create') }}" class="w-full md:w-auto blue-gradient-glow text-white px-8 py-4 rounded-2xl font-bold flex items-center justify-center gap-3 btn-hover-effect">
                    <i class="fa-solid fa-plus-circle text-lg"></i> Tambah Kelas Baru
                </a>
            </div>

            <div class="grid grid-cols-1 gap-6 mb-10">
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
                    <form action="{{ route('kelas.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                        <div class="relative flex-1 group">
                            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kelas atau wali kelas..." 
                                   class="w-full bg-slate-100/50 border-none rounded-[1.5rem] pl-12 pr-6 py-4 outline-none transition-all focus:bg-white focus:ring-4 focus:ring-blue-100 font-medium">
                        </div>
                        <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-[1.5rem] font-bold btn-hover-effect shadow-lg">Cari Data</button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($kelas as $k)
                    <div class="glass-card p-8 rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-500 border border-white/60 relative group overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                        
                        <div class="flex items-center gap-5 mb-8 relative z-10">
                            <div class="icon-box-premium w-16 h-16 rounded-2xl flex items-center justify-center text-2xl shadow-inner border border-white/50">
                                <i class="fa-solid fa-school-flag"></i>
                            </div>
                            <div class="flex flex-col">
                                <h3 class="text-2xl font-black text-slate-800 tracking-tighter group-hover:text-blue-600 transition-colors">{{ $k->nama_kelas }}</h3>
                                <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest">ID: #CLS-{{ $k->id_kelas }}</span>
                            </div>
                        </div>

                        <div class="bg-slate-50/50 p-5 rounded-2xl mb-8 border border-slate-100 inner-soft-shadow relative z-10">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Wali Kelas</label>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-chalkboard-user text-blue-500"></i>
                                <p class="text-sm font-bold text-slate-700">{{ $k->wali_kelas }}</p>
                            </div>
                        </div>

                        <div class="flex gap-3 relative z-10">
                            <a href="{{ route('kelas.edit', $k->id_kelas) }}" class="flex-1 py-3.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-2xl text-[10px] font-black tracking-widest uppercase transition-all shadow-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-pencil"></i> Edit
                            </a>
                            @if(session('role') === 'superadmin')
                                <form action="{{ route('kelas.destroy', $k->id_kelas) }}" method="POST" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="w-full py-3.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-2xl text-[10px] font-black tracking-widest uppercase transition-all shadow-sm flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center opacity-20 italic">
                        <i class="fa-solid fa-folder-open text-7xl mb-4"></i>
                        <p class="text-2xl font-bold">Data kelas tidak ditemukan</p>
                    </div>
                @endforelse
            </div>

        @else
            <div class="max-w-2xl mx-auto">
                <div class="glass-card p-10 md:p-14 rounded-[3.5rem] shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 blue-gradient-glow opacity-10 rounded-full -mr-16 -mt-16"></div>
                    
                    <h2 class="text-3xl font-black text-slate-900 tracking-tighter mb-10">
                        {{ $mode == 'create' ? 'Registrasi Kelas Baru' : 'Update Informasi Kelas' }}
                    </h2>

                    <form action="{{ $mode == 'create' ? route('kelas.store') : route('kelas.update', $kelas->id_kelas) }}" method="POST" class="space-y-8">
                        @csrf
                        @if($mode == 'edit') @method('PUT') @endif

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-blue-600 uppercase tracking-widest ml-1">Nama Rombongan Belajar</label>
                            <div class="relative">
                                <i class="fa-solid fa-tag absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas ?? '') }}" 
                                       class="w-full bg-slate-50 border-none rounded-2xl px-12 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-semibold" 
                                       placeholder="Contoh: XII IPA 1" required>
                            </div>
                            @error('nama_kelas') <span class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Wali Kelas Pengampu</label>
                            <div class="relative">
                                <i class="fa-solid fa-user-tie absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="wali_kelas" value="{{ old('wali_kelas', $kelas->wali_kelas ?? '') }}" 
                                       class="w-full bg-slate-50 border-none rounded-2xl px-12 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 font-semibold" 
                                       placeholder="Nama Lengkap Guru & Gelar" required>
                            </div>
                            @error('wali_kelas') <span class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 pt-6">
                            <button type="submit" class="flex-[2] blue-gradient-glow text-white font-bold py-5 rounded-[2rem] btn-hover-effect shadow-xl text-lg active:scale-95 transition-all">
                                <i class="fa-solid fa-save mr-2"></i> {{ $mode == 'create' ? 'Simpan Data Kelas' : 'Perbarui Data' }}
                            </button>
                            <a href="{{ route('kelas.index') }}" class="flex-1 bg-slate-100 text-slate-500 font-bold py-5 rounded-[2rem] text-center hover:bg-slate-200 transition-all text-lg">
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
                title: 'Hapus Kelas?',
                text: "Menghapus kelas dapat berdampak pada data siswa yang terhubung!",
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