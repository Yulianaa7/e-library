<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Perpustakaan</title>
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
            background: #f5f7fa;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 1.8em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .role-badge {
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            font-weight: 500;
        }

        .container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .stat-card {
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 1.1em;
            font-weight: 500;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .menu-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border: 3px solid transparent;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }

        .menu-icon {
            font-size: 50px;
            color: #667eea;
            margin-bottom: 20px;
        }

        .menu-card h3 {
            font-size: 1.4em;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .menu-card p {
            color: #666;
            line-height: 1.6;
        }

        .section-title {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 25px;
            margin-top: 40px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            .navbar h1 {
                font-size: 1.5em;
            }

            .container {
                padding: 0 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }

            .stat-number {
                font-size: 2em;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <h1><i class="fa-solid fa-book-open"></i> Perpustakaan Digital</h1>
        <div class="user-info">
            <span class="role-badge">Sistem Perpustakaan</span>
        </div>
    </nav>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-book"></i></div>
                <div class="stat-number">{{ $totalBooks ?? 0 }}</div>
                <div class="stat-label">Total Buku</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div class="stat-number">{{ $totalStudents ?? 0 }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-book-open-reader"></i></div>
                <div class="stat-number">{{ $activeBorrows ?? 0 }}</div>
                <div class="stat-label">Sedang Dipinjam</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="stat-number">{{ $overdueBooks ?? 0 }}</div>
                <div class="stat-label">Terlambat</div>
            </div>
        </div>

        <h2 class="section-title">Menu Utama</h2>
        <div class="menu-grid">
            <a href="{{ route('buku.index') }}" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-book"></i></div>
                <h3>Manajemen Buku</h3>
                <p>Kelola data buku perpustakaan</p>
            </a>

            <a href="{{ route('siswa.index') }}" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-user-graduate"></i></div>
                <h3>Manajemen Siswa</h3>
                <p>Kelola data siswa dan anggota</p>
            </a>

            <a href="{{ route('kelas.index') }}" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-school"></i></div>
                <h3>Manajemen Kelas</h3>
                <p>Kelola data kelas</p>
            </a>

            <a href="{{ route('peminjaman.index') }}" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-book-open-reader"></i></div>
                <h3>Peminjaman Buku</h3>
                <p>Proses peminjaman buku</p>
            </a>

            <a href="{{ route('pengembalian.index') }}" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-arrow-rotate-left"></i></div>
                <h3>Pengembalian Buku</h3>
                <p>Proses pengembalian dan denda</p>
            </a>
        </div>
    </div>
</body>

</html>