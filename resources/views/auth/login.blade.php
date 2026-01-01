<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Left Side - Brand */
        .login-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .brand-content {
            position: relative;
            z-index: 1;
        }

        .brand-icon {
            font-size: 5em;
            margin-bottom: 30px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .brand-content h1 {
            font-size: 2.5em;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .brand-content p {
            font-size: 1.1em;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .features {
            text-align: left;
            margin-top: 40px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .feature-item i {
            font-size: 1.5em;
        }

        .feature-item span {
            font-size: 0.95em;
        }

        /* Right Side - Form */
        .login-right {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h2 {
            font-size: 2em;
            color: #333;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 0.95em;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 0.95em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1.1em;
        }

        .form-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-group input.is-invalid {
            border-color: #f44336;
        }

        .error-message {
            color: #f44336;
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-me input {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .remember-me label {
            cursor: pointer;
            user-select: none;
            font-size: 0.95em;
            color: #666;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1em;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .demo-accounts {
            background: #f8f9ff;
            padding: 20px;
            border-radius: 12px;
            margin-top: 30px;
            border: 2px dashed #d0d7ff;
        }

        .demo-accounts h4 {
            color: #667eea;
            margin-bottom: 12px;
            font-size: 0.95em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .demo-accounts p {
            font-size: 0.85em;
            color: #666;
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
        }

        .demo-accounts strong {
            color: #333;
        }

        .login-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #999;
            font-size: 0.85em;
        }

        @media (max-width: 968px) {
            .login-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .login-left {
                padding: 40px 30px;
            }

            .brand-content h1 {
                font-size: 2em;
            }

            .features {
                display: none;
            }

            .login-right {
                padding: 40px 30px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .login-right {
                padding: 30px 20px;
            }

            .login-header h2 {
                font-size: 1.6em;
            }

            .brand-icon {
                font-size: 3.5em;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Brand -->
        <div class="login-left">
            <div class="brand-content">
                <div class="brand-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <h1>Perpustakaan Digital</h1>
                <p>Sistem Manajemen Perpustakaan Modern untuk Pengelolaan yang Lebih Efisien</p>
            </div>

            <div class="features">
                <div class="feature-item">
                    <i class="fa-solid fa-check-circle"></i>
                    <span>Manajemen Buku</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-check-circle"></i>
                    <span>Peminjaman & Pengembalian</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="login-right">
            <div class="login-header">
                <h2>Selamat Datang!</h2>
                <p>Silakan login untuk melanjutkan ke sistem</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="username" 
                               class="@error('username') is-invalid @enderror"
                               value="{{ old('username') }}" 
                               placeholder="Masukkan username" 
                               required autofocus>
                    </div>
                    @error('username')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" 
                               class="@error('password') is-invalid @enderror"
                               placeholder="Masukkan password" 
                               required>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Login Sekarang</span>
                </button>
            </form>

            <div class="login-footer">
                &copy; 2025 Sistem Perpustakaan Digital. Kelompok 6.
            </div>
        </div>
    </div>
</body>
</html>