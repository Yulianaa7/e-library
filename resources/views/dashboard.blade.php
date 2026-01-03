<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PustakaHub Premium</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
        }

        .menu-card {
            background: white;
            border: 1px solid #f1f5f9;
            transition: all 0.4s ease;
        }

        .menu-card:hover {
            transform: translateY(-10px);
            border-color: #3b82f6;
            box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.15);
        }

        .icon-box {
            background: #f0f7ff;
            color: #3b82f6;
            transition: all 0.3s ease;
        }

        .menu-card:hover .icon-box {
            background: #3b82f6;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .inner-soft-shadow {
            box-shadow: inset 2px 2px 5px rgba(0,0,0,0.02), inset -2px -2px 5px rgba(255,255,255,0.7);
        }
    </style>
</head>

<body class="pb-20">
    <div class="fixed top-0 left-0 w-1.5 h-full blue-gradient-glow z-[60]"></div>

    <nav class="glass-nav sticky top-0 z-50 px-8 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 blue-gradient-glow rounded-2xl flex items-center justify-center text-white text-xl shadow-lg">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tighter text-slate-900 leading-none">Pustaka<span class="text-blue-600">Hub</span></h1>
                    <span class="text-[9px] font-black text-blue-500 uppercase tracking-[0.2em]">Premium Dashboard</span>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Petugas Aktif</span>
                    <span class="text-xs font-bold text-slate-700 bg-blue-50 px-3 py-1 rounded-lg border border-blue-100">
                        <i class="fa-solid fa-circle-user mr-1 text-blue-500"></i>
                        {{ session('name') ?? 'User' }} ({{ ucfirst(session('role') ?? 'guest') }})
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="bg-slate-900 hover:bg-black text-white px-6 py-2.5 rounded-2xl transition-all text-xs font-bold shadow-lg flex items-center gap-2 active:scale-95">
                        <i class="fa-solid fa-power-off text-[10px]"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container max-w-7xl mx-auto px-6 mt-16">
        <div class="mb-12 text-center md:text-left">
            <h2 class="text-5xl font-black text-slate-900 tracking-tighter">Ringkasan Aktivitas</h2>
            <p class="text-slate-500 mt-3 font-medium text-lg">Pantau statistik perpustakaan Anda secara real-time.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
            <div class="glass-card p-10 rounded-[3.5rem] flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 text-2xl inner-soft-shadow">
                    <i class="fa-solid fa-book"></i>
                </div>
                <span class="text-4xl font-black text-slate-800">{{ $totalBooks ?? 0 }}</span>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3">Total Koleksi</p>
            </div>

            <div class="glass-card p-10 rounded-[3.5rem] flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-5 text-2xl inner-soft-shadow">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <span class="text-4xl font-black text-slate-800">{{ $totalStudents ?? 0 }}</span>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3">Siswa Terdaftar</p>
            </div>

            <div class="glass-card p-10 rounded-[3.5rem] flex flex-col items-center text-center border-emerald-100">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5 text-2xl inner-soft-shadow">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>
                <span class="text-4xl font-black text-slate-800">{{ $activeBorrows ?? 0 }}</span>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3">Sedang Pinjam</p>
            </div>

            <div class="glass-card p-10 rounded-[3.5rem] flex flex-col items-center text-center border-red-100">
                <div class="w-16 h-16 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mb-5 text-2xl inner-soft-shadow">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <span class="text-4xl font-black text-red-600">{{ $overdueBooks ?? 0 }}</span>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3">Terlambat</p>
            </div>
        </div>

        <div class="flex items-center gap-6 mb-12">
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Navigasi Utama</h3>
            <div class="h-[1px] flex-1 bg-slate-200"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8">
            <a href="{{ route('buku.index') }}" class="menu-card p-10 rounded-[3.5rem] flex flex-col items-center text-center group">
                <div class="w-20 h-20 icon-box rounded-[2rem] flex items-center justify-center mb-6 shadow-sm">
                    <i class="fa-solid fa-book-bookmark text-3xl"></i>
                </div>
                <h4 class="text-xl font-black text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Buku</h4>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">Data Koleksi</p>
            </a>

            <a href="{{ route('siswa.index') }}" class="menu-card p-10 rounded-[3.5rem] flex flex-col items-center text-center group">
                <div class="w-20 h-20 icon-box rounded-[2rem] flex items-center justify-center mb-6 shadow-sm">
                    <i class="fa-solid fa-users-viewfinder text-3xl"></i>
                </div>
                <h4 class="text-xl font-black text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Siswa</h4>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">Manajemen Siswa</p>
            </a>

            <a href="{{ route('kelas.index') }}" class="menu-card p-10 rounded-[3.5rem] flex flex-col items-center text-center group">
                <div class="w-20 h-20 icon-box rounded-[2rem] flex items-center justify-center mb-6 shadow-sm">
                    <i class="fa-solid fa-school-flag text-3xl"></i>
                </div>
                <h4 class="text-xl font-black text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Kelas</h4>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">Struktur Kelas</p>
            </a>

            <a href="{{ route('peminjaman.index') }}" class="menu-card p-10 rounded-[3.5rem] flex flex-col items-center text-center group">
                <div class="w-20 h-20 icon-box rounded-[2rem] flex items-center justify-center mb-6 shadow-sm">
                    <i class="fa-solid fa-file-signature text-3xl"></i>
                </div>
                <h4 class="text-xl font-black text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Pinjam</h4>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">Input Transaksi</p>
            </a>

            <a href="{{ route('pengembalian.index') }}" class="menu-card p-10 rounded-[3.5rem] flex flex-col items-center text-center group">
                <div class="w-20 h-20 icon-box rounded-[2rem] flex items-center justify-center mb-6 shadow-sm">
                    <i class="fa-solid fa-clock-rotate-left text-3xl"></i>
                </div>
                <h4 class="text-xl font-black text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Kembali</h4>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">Proses & Denda</p>
            </a>
        </div>
    </div>

    <footer class="mt-24 text-center">
        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em]">&copy; 2026 PustakaHub Premium System</p>
    </footer>
</body>

</html>