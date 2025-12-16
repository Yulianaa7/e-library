<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode == 'index' ? 'Manajemen Buku' : ($mode == 'create' ? 'Tambah Buku' : 'Edit Buku') }} - Sistem Perpustakaan</title>
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

        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        th {
            padding: 18px;
            text-align: left;
            font-weight: 600;
            white-space: nowrap;
        }

        td {
            padding: 15px 18px;
            border-bottom: 1px solid #f0f0f0;
        }

        tbody tr:hover {
            background: #f8f9ff;
        }

        .btn-action {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            margin-right: 8px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9em;
            cursor: pointer;
        }

        .btn-edit {
            background: #4caf50;
            color: white;
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .badge-stock {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            white-space: nowrap;
        }

        .stock-available {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .stock-low {
            background: #fff3e0;
            color: #e65100;
        }

        .stock-empty {
            background: #ffebee;
            color: #c62828;
        }

        .desc-cell {
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: help;
        }

        .desc-cell:hover {
            overflow: visible;
            white-space: normal;
            word-wrap: break-word;
            background: #f8f9ff;
            z-index: 1;
            position: relative;
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
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input.is-invalid,
        .form-group select.is-invalid,
        .form-group textarea.is-invalid {
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

            .desc-cell {
                max-width: 150px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <h1>
            <i class="fa-solid fa-book"></i>
            @if($mode == 'index')
                Manajemen Buku
            @elseif($mode == 'create')
                Tambah Buku Baru
            @else
                Edit Buku
            @endif
        </h1>
        <a href="{{ $mode == 'index' ? route('dashboard') : route('buku.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </nav>

    <div class="container">
        @if($mode == 'index')
            {{-- INDEX MODE --}}
            <div class="header-section">
                <h2 class="page-title">Data Buku Perpustakaan</h2>
                <a href="{{ route('buku.create') }}" class="btn-add">
                    <i class="fa-solid fa-plus"></i> Tambah Buku
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="search-box">
                <form action="{{ route('buku.index') }}" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari buku..." value="{{ request('search') }}">
                    <button type="submit" class="btn-search">
                        <i class="fa-solid fa-search"></i> Cari
                    </button>
                </form>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($buku as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_buku }}</td>
                                <td>{{ $item->penulis }}</td>
                                <td>{{ $item->penerbit }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->tahun_terbit }}</td>
                                <td>
                                    @if($item->stok == 0)
                                        <span class="badge-stock stock-empty">Habis</span>
                                    @elseif($item->stok <= 5)
                                        <span class="badge-stock stock-low">{{ $item->stok }}</span>
                                    @else
                                        <span class="badge-stock stock-available">{{ $item->stok }}</span>
                                    @endif
                                </td>
                                <td class="desc-cell" title="{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}">
                                    {{ $item->deskripsi ? Str::limit($item->deskripsi, 50) : '-' }}
                                </td>
                                <td style="white-space: nowrap;">
                                    <a href="{{ route('buku.edit', $item->id_buku) }}" class="btn-action btn-edit">
                                        <i class="fa-solid fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('buku.destroy', $item->id_buku) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px;">Belum ada data buku</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @else
            {{-- CREATE/EDIT MODE --}}
            <div class="form-card">
                <h2 class="page-title">{{ $mode == 'create' ? 'Form Tambah Buku' : 'Form Edit Buku' }}</h2>

                <form action="{{ $mode == 'create' ? route('buku.store') : route('buku.update', $buku->id_buku) }}" method="POST">
                    @csrf
                    @if($mode == 'edit')
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label>Judul Buku <span class="required">*</span></label>
                        <input type="text" name="nama_buku" 
                               class="@error('nama_buku') is-invalid @enderror"
                               value="{{ old('nama_buku', $buku->nama_buku ?? '') }}" required>
                        @error('nama_buku')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Penulis <span class="required">*</span></label>
                        <input type="text" name="penulis" 
                               class="@error('penulis') is-invalid @enderror"
                               value="{{ old('penulis', $buku->penulis ?? '') }}" required>
                        @error('penulis')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Penerbit <span class="required">*</span></label>
                        <input type="text" name="penerbit" 
                               class="@error('penerbit') is-invalid @enderror"
                               value="{{ old('penerbit', $buku->penerbit ?? '') }}" required>
                        @error('penerbit')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tahun Terbit <span class="required">*</span></label>
                        <input type="number" name="tahun_terbit" 
                               class="@error('tahun_terbit') is-invalid @enderror"
                               value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" 
                               min="1900" max="2025" required>
                        @error('tahun_terbit')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kategori <span class="required">*</span></label>
                        <select name="kategori" class="@error('kategori') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach(['Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Biografi', 'Pendidikan'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $buku->kategori ?? '') == $kat ? 'selected' : '' }}>
                                    {{ $kat }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Stok <span class="required">*</span></label>
                        <input type="number" name="stok" 
                               class="@error('stok') is-invalid @enderror"
                               value="{{ old('stok', $buku->stok ?? '') }}" min="0" required>
                        @error('stok')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="@error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $buku->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-save"></i> {{ $mode == 'create' ? 'Simpan' : 'Update' }}
                        </button>
                        <a href="{{ route('buku.index') }}" class="btn-cancel">
                            <i class="fa-solid fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        @endif
    </div>
</body>

</html>