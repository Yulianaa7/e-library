<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartLib</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: radial-gradient(circle at top right, #f0f9ff, #e0f2fe);
            color: #1e293b;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 20px;
        }

        .blue-gradient-glow {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
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
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.5);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        .floating-icon {
            animation: float 4s ease-in-out infinite;
        }

        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="blob" style="top: -10%; right: -10%;"></div>
    <div class="blob" style="bottom: -10%; left: -10%;"></div>

    <div class="w-full max-w-[1000px] relative z-10">
        <div class="glass-card rounded-[3.5rem] overflow-hidden flex flex-col md:flex-row min-h-[600px]">
            
            <div class="md:w-5/12 blue-gradient-glow p-12 text-white flex flex-col justify-center relative overflow-hidden">
                <i class="fa-solid fa-book-bookmark absolute -bottom-10 -right-10 text-[250px] opacity-10 rotate-12"></i>
                
                <div class="relative z-10 text-center md:text-left">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-[2rem] flex items-center justify-center mb-8 shadow-xl mx-auto md:mx-0 floating-icon text-white text-4xl">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h1 class="text-5xl font-black tracking-tighter mb-4">Smart<span class="text-blue-200">Lib</span></h1>
                    <p class="text-blue-50 text-lg font-medium leading-relaxed opacity-90 mb-8">
                        Sistem Manajemen Perpustakaan Modern untuk pengalaman literasi digital yang efisien.
                    </p>
                </div>
            </div>

            <div class="md:w-7/12 p-12 md:p-16 flex flex-col justify-center bg-white/40">
                <div class="mb-10">
                    <h2 class="text-4xl font-black text-slate-900 tracking-tight">Selamat Datang</h2>
                    <p class="text-slate-500 font-medium mt-2">Silakan login untuk mengakses panel kontrol.</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 flex items-center gap-3 p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl text-sm font-bold animate-pulse">
                        <i class="fas fa-circle-exclamation text-lg"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-blue-600 uppercase tracking-widest ml-1">Username</label>
                        <div class="relative group">
                            <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="w-full bg-white border-none rounded-2xl px-12 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 transition-all font-semibold @error('username') ring-2 ring-red-400 @enderror" 
                                placeholder="Masukkan username" required autofocus autocomplete="off">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-blue-600 uppercase tracking-widest ml-1">Kata Sandi</label>
                        <div class="relative group">
                            <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="password" name="password" id="password"
                                class="w-full bg-white border-none rounded-2xl px-12 py-4 outline-none inner-soft-shadow focus:ring-2 focus:ring-blue-100 transition-all font-semibold @error('password') ring-2 ring-red-400 @enderror" 
                                placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 ml-1">
                        <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded-lg border-slate-200 text-blue-600 focus:ring-blue-500">
                        <label for="remember" class="text-sm font-bold text-slate-500 cursor-pointer select-none">Ingat saya di perangkat ini</label>
                    </div>

                    <button type="submit" class="w-full py-5 blue-gradient-glow text-white font-bold rounded-[2rem] btn-hover-effect text-lg tracking-tight mt-4 flex items-center justify-center gap-3">
                        <span>Masuk Ke Sistem</span>
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </button>
                </form>

                <div class="mt-12 text-center border-t border-slate-100 pt-8">
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em]">
                        &copy; 2026 SmartLib
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>