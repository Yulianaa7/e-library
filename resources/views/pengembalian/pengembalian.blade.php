<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode == 'index' ? 'Pengembalian Buku' : 'Konfirmasi Pengembalian' }} - PustakaHub Premium</title>
    
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

        .overdue-pulse {
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
    </style>
</head>

<body class="pb-20">
    <div class="fixed top-0 left-0 w-1.5 h-full blue-gradient-glow z-[60]"></div>

    <nav class="glass-nav sticky top-0 z-50 px-8 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 blue-gradient-glow rounded-2xl flex items-center justify-center text-white text-xl shadow-lg">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tighter text-slate-900 leading-none">
                        {{ $mode == 'index' ? 'Pengembalian' : 'Konfirmasi' }}
                    </h1>
                    <span class="text-[9px] font-black text-blue-500 uppercase tracking-[0.2em]">SmartLib</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ $mode == 'index' ? route('dashboard') : route('pengembalian.index') }}" class="bg-slate-900 hover:bg-black text-white px-6 py-2.5 rounded-xl transition-all text-xs font-bold shadow-lg flex items-center gap-2 active:scale-95">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="container max-w-7xl mx-auto px-6 mt-12">
        @if($mode == 'index')
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Validasi Pengembalian</h2>
                <p class="text-slate-500 font-medium">Proses buku yang kembali dan hitung denda keterlambatan secara otomatis.</p>
            </div>

            @if(session('success'))
                <script>
                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: "{{ session('success') }}", showConfirmButton: false, timer: 3000 });
                </script>
            @endif

            <div class="glass-card p-6 rounded-[2rem] border-l-8 border-blue-500 mb-10 flex items-center gap-6 shadow-sm">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 text-2xl">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Kebijakan Denda</h3>
                    <p class="text-slate-500 text-sm italic">Tarif denda keterlambatan sebesar <span class="font-bold text-blue-600">Rp 500 / hari</span>. Mohon cek kondisi fisik buku.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($peminjaman as $item)
                    @php
                        $today = \Carbon\Carbon::now()->startOfDay();
                        $tglKembali = \Carbon\Carbon::parse($item->tanggal_kembali)->startOfDay();
                        $hariTerlambat = $today->diffInDays($tglKembali, false);
                        $hariTerlambat = $hariTerlambat < 0 ? abs($hariTerlambat) : 0;
                        $denda = $hariTerlambat * 500;
                    @endphp

                    <div class="glass-card p-8 rounded-[2.5rem] shadow-sm relative overflow-hidden group hover:shadow-2xl transition-all duration-500 border border-white/60">
                        <div class="absolute top-0 right-0 bg-slate-900 text-white px-6 py-2 rounded-bl-3xl text-[10px] font-black tracking-widest uppercase">
                            #TRX-{{ $item->id_peminjaman }}
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xl font-black text-slate-800 leading-tight group-hover:text-blue-600 transition-colors uppercase">{{ $item->nama_siswa }}</h3>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->nama_kelas }}</span>
                        </div>

                        <div class="bg-slate-50/50 p-5 rounded-2xl mb-6 border border-slate-100 inner-soft-shadow">
                            <label class="text-[9px] font-black text-blue-400 uppercase tracking-widest block mb-1">Judul Koleksi</label>
                            <p class="text-sm font-bold text-slate-700 italic">"{{ $item->nama_buku }}"</p>
                        </div>

                        <div class="space-y-3 mb-8">
                            <div class="flex justify-between items-center text-xs font-semibold">
                                <span class="text-slate-400">Batas Kembali</span>
                                <span class="text-slate-700">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</span>
                            </div>
                            
                            @if($hariTerlambat > 0)
                                <div class="flex justify-between items-center p-3 bg-red-50 rounded-xl border border-red-100 overdue-pulse">
                                    <span class="text-[10px] font-black text-red-500 uppercase tracking-tighter">Denda ({{ $hariTerlambat }} Hari)</span>
                                    <span class="font-black text-red-600 text-sm">Rp {{ number_format($denda, 0, ',', '.') }}</span>
                                </div>
                            @else
                                <div class="flex justify-between items-center p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-tighter">Status</span>
                                    <span class="font-black text-emerald-600 text-[10px] uppercase">Tepat Waktu</span>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('pengembalian.create', ['id' => $item->id_peminjaman]) }}" 
                           class="w-full py-4 blue-gradient-glow text-white font-bold rounded-2xl flex items-center justify-center gap-3 btn-hover-effect text-sm">
                            <i class="fa-solid fa-circle-check"></i> Proses Sekarang
                        </a>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center opacity-20 italic">
                        <i class="fa-solid fa-box-open text-8xl mb-4"></i>
                        <p class="text-2xl font-black tracking-tighter uppercase">Semua koleksi telah kembali</p>
                    </div>
                @endforelse
            </div>

        @else
            <div class="max-w-2xl mx-auto">
                <div class="glass-card p-10 md:p-14 rounded-[3.5rem] shadow-2xl relative overflow-hidden border border-white">
                    <div class="absolute top-0 right-0 w-32 h-32 blue-gradient-glow opacity-10 rounded-full -mr-16 -mt-16"></div>
                    
                    <h2 class="text-3xl font-black text-slate-900 tracking-tighter mb-8 text-center">Konfirmasi Transaksi</h2>

                    @php
                        $today = \Carbon\Carbon::now();
                        $tglKembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali);
                        $hariTerlambat = $today->startOfDay()->diffInDays($tglKembali->startOfDay(), false);
                        $hariTerlambat = $hariTerlambat < 0 ? abs($hariTerlambat) : 0;
                        $denda = $hariTerlambat * 500;
                    @endphp

                    <div class="space-y-6">
                        <div class="flex flex-col items-center text-center pb-8 border-b border-slate-100">
                            <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center text-blue-500 text-3xl mb-4 shadow-inner">
                                <i class="fa-solid fa-user-check"></i>
                            </div>
                            <h3 class="text-2xl font-black text-slate-800 uppercase">{{ $peminjaman->nama_siswa }}</h3>
                            <p class="text-blue-500 font-bold uppercase text-[10px] tracking-[0.3em]">{{ $peminjaman->nama_kelas }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-slate-50/50 p-6 rounded-3xl border border-slate-100 inner-soft-shadow">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 text-center">Buku Yang Dikembalikan</label>
                                <p class="text-lg font-bold text-slate-700 text-center italic">"{{ $peminjaman->nama_buku }}"</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-2xl border border-slate-100 text-center shadow-sm">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Tanggal Hari Ini</label>
                                    <p class="font-bold text-slate-700">{{ $today->format('d M Y') }}</p>
                                </div>
                                <div class="bg-white p-4 rounded-2xl border border-slate-100 text-center shadow-sm">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Status Durasi</label>
                                    <p class="font-bold {{ $hariTerlambat > 0 ? 'text-red-500' : 'text-emerald-500' }}">
                                        {{ $hariTerlambat > 0 ? $hariTerlambat . ' Hari Terlambat' : 'Tepat Waktu' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($hariTerlambat > 0)
                            <div class="bg-red-50 p-8 rounded-[2.5rem] border-2 border-red-200 text-center overdue-pulse">
                                <p class="text-red-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Kewajiban Denda</p>
                                <h3 class="text-4xl font-black text-red-600">Rp {{ number_format($denda, 0, ',', '.') }}</h3>
                            </div>
                        @else
                            <div class="bg-emerald-50 p-8 rounded-[2.5rem] border-2 border-emerald-200 text-center">
                                <p class="text-emerald-600 font-black text-sm uppercase tracking-widest">✓ Bebas Dari Denda</p>
                            </div>
                        @endif

                        <form action="{{ route('pengembalian.store') }}" method="POST" class="pt-6">
                            @csrf
                            <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id_peminjaman }}">
                            <div class="flex flex-col md:flex-row gap-4">
                                <button type="submit" class="flex-[2] py-5 blue-gradient-glow text-white font-bold rounded-2xl btn-hover-effect shadow-xl text-lg flex items-center justify-center gap-3">
                                    <i class="fa-solid fa-check-double"></i> Validasi Sekarang
                                </button>
                                <a href="{{ route('pengembalian.index') }}" class="flex-1 py-5 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold rounded-2xl text-center transition-all text-lg flex items-center justify-center">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>

</html>