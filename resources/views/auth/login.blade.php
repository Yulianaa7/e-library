<!-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .login-left h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .login-left p {
            font-size: 1.1em;
            opacity: 0.9;
            line-height: 1.6;
        }

        .book-icon i {
            font-size: 50px;
            color: #ffffff;
            margin-bottom: 15px;
        }

        .login-right {
            flex: 1;
            padding: 60px 40px;
        }

        .login-form h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 2em;
        }

        .login-form p {
            color: #666;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input.is-invalid {
            border-color: #f44336;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 1.2em;
            transition: color 0.3s;
            padding: 5px;
        }

        .toggle-password:hover {
            color: #667eea;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.95em;
            border: 1px solid #ef5350;
            animation: shake 0.5s;
        }

        .text-danger {
            color: #c62828;
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .info-box {
            background: #e3f2fd;
            color: #1565c0;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 0.9em;
            border-left: 4px solid #1976d2;
        }

        .info-box strong {
            display: block;
            margin-bottom: 8px;
        }

        .info-box .credentials {
            background: white;
            padding: 10px;
            border-radius: 5px;
            margin-top: 8px;
            font-family: monospace;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-left {
                padding: 40px 30px;
            }

            .login-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <div class="book-icon">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <h1>Perpustakaan Digital</h1>
            <p>Sistem manajemen perpustakaan modern untuk pengelolaan buku, anggota, dan peminjaman yang efisien</p>
        </div>
        <div class="login-right">
            <form class="login-form" action="{{ route('login.process') }}" method="POST">
                @csrf
                <h2>Selamat Datang</h2>
                <p>Silakan login untuk melanjutkan</p>

                @if(session('error'))
                    <div class="error-message">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           class="@error('username') is-invalid @enderror" 
                           value="{{ old('username') }}"
                           required 
                           placeholder="Masukkan username" 
                           autocomplete="username">
                    @error('username') 
                        <small class="text-danger">{{ $message }}</small> 
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" 
                               id="password" 
                               name="password"
                               class="@error('password') is-invalid @enderror"
                               required 
                               placeholder="Masukkan password" 
                               autocomplete="current-password">
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fa-solid fa-eye-slash" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password') 
                        <small class="text-danger">{{ $message }}</small> 
                    @enderror
                </div>

                <button type="submit" class="btn-login">Login</button>

                {{-- Uncomment untuk menampilkan info akun demo --}}
                {{-- <div class="info-box">
                    <strong>Akun Demo:</strong>
                    <div class="credentials">
                        <div>👤 Admin: <strong>admin</strong> / <strong>admin123</strong></div>
                        <div style="margin-top: 5px;">🔐 Super Admin: <strong>superadmin</strong> / <strong>super123</strong></div>
                    </div>
                </div> --}}
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }

        // Auto-hide error messages when user starts typing
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');

        if (usernameInput) {
            usernameInput.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        }
    </script>
</body>

</html> -->