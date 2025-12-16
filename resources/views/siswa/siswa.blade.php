<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode == 'index' ? 'Manajemen Siswa' : ($mode == 'create' ? 'Tambah Siswa' : 'Edit Siswa') }} - Sistem Perpustakaan</title>
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar h1 {
            font-size: 1.5em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-back {
            padding: 10px 25px;
            background: rgba(255,255,255,0.2);
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .student-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }

        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .student-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .student-avatar {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            color: white;
            font-weight: 600;
        }

        .student-info h3 {
            font-size: 1.3em;
            color: #333;
            margin-bottom: 5px;
        }

        .student-nis {
            color: #666;
            font-size: 0.95em;
        }

        .student-details {
            margin-bottom: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .detail-label {
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
        }

        .card-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            cursor: pointer;
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

            .cards-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>
            <i class="fa-solid fa-user-graduate"></i>
            @if($mode == 'index')
                Manajemen Siswa
            @elseif($mode == 'create')
                Tambah Siswa Baru
            @else
                Edit Siswa
            @endif
        </h1>
        <a href="{{ $mode == 'index' ? route('dashboard') : route('siswa.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </nav>

    <div class="container">
        @if($mode == 'index')
            {{-- INDEX MODE --}}
            <div class="header-section">
                <h2 class="page-title">Data Siswa Perpustakaan</h2>
                <a href="{{ route('siswa.create') }}" class="btn-add">
                    <i class="fa-solid fa-plus"></i> Tambah Siswa
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="search-box">
                <form action="{{ route('siswa.index') }}" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari siswa berdasarkan nama atau NIS..." value="{{ request('search') }}">
                    <button type="submit" class="btn-search">
                        <i class="fa-solid fa-search"></i> Cari
                    </button>
                </form>
            </div>

            <div class="cards-grid">
                @forelse($siswa as $item)
                    <div class="student-card">
                        <div class="student-header">
                            <div class="student-avatar">
                                {{ strtoupper(substr($item->nama_siswa, 0, 2)) }}
                            </div>
                            <div class="student-info">
                                <h3>{{ $item->nama_siswa }}</h3>
                                <div class="student-nis">{{ $item->tanggal_lahir }}</div>
                            </div>
                        </div>
                        <div class="student-details">
                            <div class="detail-row">
                                <span class="detail-label">Kelas</span>
                                <span class="detail-value">{{ $item->nama_kelas }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Jenis Kelamin</span>
                                <span class="detail-value">{{ $item->gender }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Alamat</span>
                                <span class="detail-value">{{ Str::limit($item->alamat, 30) }}</span>
                            </div>
                        </div>
                        <div class="card-actions">
                            <a href="{{ route('siswa.edit', $item->id_siswa) }}" class="btn-action btn-edit">
                                <i class="fa-solid fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('siswa.destroy', $item->id_siswa) }}" 
                                  method="POST" 
                                  style="flex: 1; display: inline;"
                                  onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" style="width: 100%;">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px; color: #999;">
                        <i class="fa-solid fa-user-graduate" style="font-size: 4em; margin-bottom: 20px; opacity: 0.3; display: block;"></i>
                        <p>Belum ada data siswa</p>
                    </div>
                @endforelse
            </div>

        @else
            {{-- CREATE/EDIT MODE --}}
            <div class="form-card">
                <h2 class="page-title">{{ $mode == 'create' ? 'Form Tambah Siswa' : 'Form Edit Siswa' }}</h2>

                <form action="{{ $mode == 'create' ? route('siswa.store') : route('siswa.update', $siswa->id_siswa) }}" method="POST">
                    @csrf
                    @if($mode == 'edit')
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="nama_siswa" 
                               class="@error('nama_siswa') is-invalid @enderror"
                               value="{{ old('nama_siswa', $siswa->nama_siswa ?? '') }}" required>
                        @error('nama_siswa')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir <span class="required">*</span></label>
                        <input type="date" name="tanggal_lahir" 
                               class="@error('tanggal_lahir') is-invalid @enderror"
                               value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}" required>
                        @error('tanggal_lahir')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin <span class="required">*</span></label>
                        <select name="gender" class="@error('gender') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender', $siswa->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $siswa->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kelas <span class="required">*</span></label>
                        <select name="id_kelas" class="@error('id_kelas') is-invalid @enderror" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id_kelas }}" {{ old('id_kelas', $siswa->id_kelas ?? '') == $k->id_kelas ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kelas')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Alamat <span class="required">*</span></label>
                        <input type="text" name="alamat" 
                               class="@error('alamat') is-invalid @enderror"
                               value="{{ old('alamat', $siswa->alamat ?? '') }}" required>
                        @error('alamat')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-save"></i> {{ $mode == 'create' ? 'Simpan' : 'Update' }}
                        </button>
                        <a href="{{ route('siswa.index') }}" class="btn-cancel">
                            <i class="fa-solid fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        @endif
    </div>
</body>
</html>