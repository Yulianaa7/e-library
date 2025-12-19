<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode == 'index' ? 'Manajemen Kelas' : ($mode == 'create' ? 'Tambah Kelas' : 'Edit Kelas') }} - Sistem Perpustakaan</title>
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
            font-size: 1.5em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9em;
        }

        .btn-back {
            padding: 10px 25px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back:hover {
            background: white;
            color: #667eea;
        }

        .container {
            max-width: {{ $mode == 'index' ? '1400px' : '800px' }};
            margin: 40px auto;
            padding: 0 40px;
        }

        /* INDEX STYLES */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 2em;
            color: #333;
            font-weight: 600;
        }

        .btn-add {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1em;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .search-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .search-form {
            display: flex;
            gap: 10px;
        }

        .search-box input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
        }

        .btn-search {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .kelas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .kelas-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            animation: fadeIn 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .kelas-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .kelas-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .kelas-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .kelas-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            color: white;
        }

        .kelas-title {
            flex: 1;
        }

        .kelas-title h3 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 5px;
        }

        .kelas-info {
            background: #f8f9ff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
        }

        .info-icon {
            color: #667eea;
            font-size: 1.2em;
            width: 25px;
        }

        .info-text {
            color: #333;
            font-weight: 500;
        }

        .kelas-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9em;
            cursor: pointer;
            flex: 1;
            text-align: center;
        }

        .btn-edit {
            background: #4caf50;
            color: white;
        }

        .btn-edit:hover {
            background: #45a049;
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .btn-delete:hover {
            background: #da190b;
        }

        /* FORM STYLES */
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 40px;
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

        .required {
            color: #f44336;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input.is-invalid,
        .form-group select.is-invalid {
            border-color: #f44336;
        }

        .error-message {
            color: #f44336;
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-submit {
            flex: 1;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1em;
            cursor: pointer;
        }

        .btn-cancel {
            flex: 1;
            padding: 14px;
            background: #e0e0e0;
            color: #333;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1em;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
            }

            .header-section {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .kelas-grid {
                grid-template-columns: 1fr;
            }

            .navbar-right {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <h1>
            <i class="fa-solid fa-school"></i>
            @if($mode == 'index')
                Manajemen Kelas
            @elseif($mode == 'create')
                Tambah Kelas Baru
            @else
                Edit Kelas
            @endif
        </h1>
        <div class="navbar-right">
            <span class="user-badge">
                <i class="fa-solid fa-user"></i> {{ session('name') }} 
                <strong>({{ ucfirst(session('role')) }})</strong>
            </span>
            <a href="{{ $mode == 'index' ? route('dashboard') : route('kelas.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </nav>

    <div class="container">
        @if($mode == 'index')
            {{-- INDEX MODE --}}
            <div class="header-section">
                <h2 class="page-title">Data Kelas</h2>
                <a href="{{ route('kelas.create') }}" class="btn-add">
                    <i class="fa-solid fa-plus"></i> Tambah Kelas
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="search-box">
                <form action="{{ route('kelas.index') }}" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari kelas atau wali kelas..." value="{{ request('search') }}">
                    <button type="submit" class="btn-search">
                        <i class="fa-solid fa-search"></i> Cari
                    </button>
                </form>
            </div>

            <div class="kelas-grid">
                @forelse($kelas as $k)
                    <div class="kelas-card">
                        <div class="kelas-header">
                            <div class="kelas-icon">
                                <i class="fa-solid fa-school"></i>
                            </div>
                            <div class="kelas-title">
                                <h3>{{ $k->nama_kelas }}</h3>
                            </div>
                        </div>
                        <div class="kelas-info">
                            <div class="info-row">
                                <i class="fa-solid fa-chalkboard-user info-icon"></i>
                                <span class="info-text">{{ $k->wali_kelas }}</span>
                            </div>
                        </div>
                        <div class="kelas-actions">
                            <a href="{{ route('kelas.edit', $k->id_kelas) }}" class="btn-action btn-edit">
                                <i class="fa-solid fa-edit"></i> Edit
                            </a>
                            
                            {{-- Tombol Hapus - HANYA untuk Superadmin --}}
                            @if(session('role') === 'superadmin')
                                <form action="{{ route('kelas.destroy', $k->id_kelas) }}" 
                                      method="POST" 
                                      style="flex: 1;"
                                      onsubmit="return confirm('Yakin ingin menghapus kelas {{ $k->nama_kelas }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" style="width: 100%;">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                        <p style="color: #666; font-size: 1.2em;">Belum ada data kelas</p>
                    </div>
                @endforelse
            </div>

        @else
            {{-- CREATE/EDIT MODE --}}
            <div class="form-card">
                <h2 class="page-title">{{ $mode == 'create' ? 'Form Tambah Kelas' : 'Form Edit Kelas' }}</h2>

                <form action="{{ $mode == 'create' ? route('kelas.store') : route('kelas.update', $kelas->id_kelas) }}" method="POST">
                    @csrf
                    @if($mode == 'edit')
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label>Nama Kelas <span class="required">*</span></label>
                        <input type="text" name="nama_kelas" 
                               class="@error('nama_kelas') is-invalid @enderror"
                               value="{{ old('nama_kelas', $kelas->nama_kelas ?? '') }}" 
                               placeholder="Contoh: XII IPA 1"
                               required>
                        @error('nama_kelas')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Wali Kelas <span class="required">*</span></label>
                        <input type="text" name="wali_kelas" 
                               class="@error('wali_kelas') is-invalid @enderror"
                               value="{{ old('wali_kelas', $kelas->wali_kelas ?? '') }}" 
                               placeholder="Contoh: Bu Siti Rahayu"
                               required>
                        @error('wali_kelas')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-save"></i> {{ $mode == 'create' ? 'Simpan' : 'Update' }}
                        </button>
                        <a href="{{ route('kelas.index') }}" class="btn-cancel">
                            <i class="fa-solid fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        @endif
    </div>
</body>

</html>