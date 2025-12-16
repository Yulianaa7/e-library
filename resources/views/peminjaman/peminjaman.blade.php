<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode == 'index' ? 'Peminjaman Buku' : ($mode == 'create' ? 'Tambah Peminjaman' : 'Edit Peminjaman') }} - Sistem Perpustakaan</title>
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

        .badge-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-dipinjam {
            background: #fff3cd;
            color: #856404;
        }

        .status-dikembalikan {
            background: #d4edda;
            color: #155724;
        }

        .status-terlambat {
            background: #f8d7da;
            color: #721c24;
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

        .btn-detail {
            background: #2196f3;
            color: white;
        }

        .btn-edit {
            background: #4caf50;
            color: white;
        }

        .btn-delete {
            background: #f44336;
            color: white;
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

        .info-helper {
            font-size: 0.85em;
            color: #666;
            margin-top: 5px;
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
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <h1>
            <i class="fa-solid fa-book-open"></i>
            @if($mode == 'index')
                Peminjaman Buku
            @elseif($mode == 'create')
                Tambah Peminjaman
            @else
                Edit Peminjaman
            @endif
        </h1>
        <a href="{{ $mode == 'index' ? '/' : route('peminjaman.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </nav>

    <div class="container">
        @if($mode == 'index')
            {{-- INDEX MODE --}}
            <div class="header-section">
                <h2 class="page-title">Data Peminjaman</h2>
                <a href="{{ route('peminjaman.create') }}" class="btn-add">
                    <i class="fa-solid fa-plus"></i> Tambah Peminjaman
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="search-box">
                <form action="{{ route('peminjaman.index') }}" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari peminjaman..." value="{{ request('search') }}">
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
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->siswa->nama_siswa }}</td>
                                <td>{{ $p->siswa->kelas->nama_kelas }}</td>
                                <td>{{ $p->buku->nama_buku }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}</td>
                                <td>
                                    @if($p->status == 'Dipinjam')
                                        <span class="badge-status status-dipinjam">Dipinjam</span>
                                    @elseif($p->status == 'Dikembalikan')
                                        <span class="badge-status status-dikembalikan">Dikembalikan</span>
                                    @else
                                        <span class="badge-status status-terlambat">Terlambat</span>
                                    @endif
                                </td>
                                <td style="white-space: nowrap;">
                                    <a href="{{ route('peminjaman.show', $p->id_peminjaman) }}" class="btn-action btn-detail">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('peminjaman.edit', $p->id_peminjaman) }}" class="btn-action btn-edit">
                                        <i class="fa-solid fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('peminjaman.destroy', $p->id_peminjaman) }}" 
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
                                <td colspan="8" style="text-align: center; padding: 40px;">Belum ada data peminjaman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @elseif($mode == 'show')
            {{-- DETAIL MODE --}}
            <div class="form-card">
                <h2 class="page-title">Detail Peminjaman</h2>

                <div style="background: #f8f9ff; padding: 30px; border-radius: 10px; margin-top: 30px;">
                    <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #e8e8ff;">
                        <span style="color: #666; font-weight: 500;">ID Peminjaman</span>
                        <span style="color: #333; font-weight: 600;">{{ $peminjaman->id_peminjaman }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #e8e8ff;">
                        <span style="color: #666; font-weight: 500;">Nama Siswa</span>
                        <span style="color: #333; font-weight: 600;">{{ $peminjaman->siswa->nama_siswa }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #e8e8ff;">
                        <span style="color: #666; font-weight: 500;">Kelas</span>
                        <span style="color: #333; font-weight: 600;">{{ $peminjaman->siswa->kelas->nama_kelas }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #e8e8ff;">
                        <span style="color: #666; font-weight: 500;">Judul Buku</span>
                        <span style="color: #333; font-weight: 600;">{{ $peminjaman->buku->nama_buku }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #e8e8ff;">
                        <span style="color: #666; font-weight: 500;">Tanggal Pinjam</span>
                        <span style="color: #333; font-weight: 600;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #e8e8ff;">
                        <span style="color: #666; font-weight: 500;">Tanggal Harus Kembali</span>
                        <span style="color: #333; font-weight: 600;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d F Y') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #e8e8ff;">
                        <span style="color: #666; font-weight: 500;">Tanggal Dikembalikan</span>
                        <span style="color: #333; font-weight: 600;">
                            {{ $peminjaman->tanggal_dikembalikan ? \Carbon\Carbon::parse($peminjaman->tanggal_dikembalikan)->format('d F Y') : 'Belum dikembalikan' }}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 15px 0;">
                        <span style="color: #666; font-weight: 500;">Status</span>
                        <span style="color: #333; font-weight: 600;">{{ $peminjaman->status }}</span>
                    </div>

                    @php
                        $hariTerlambat = 0;
                        $denda = 0;
                        if ($peminjaman->status != 'Dikembalikan') {
                            $today = \Carbon\Carbon::now();
                            $dueDate = \Carbon\Carbon::parse($peminjaman->tanggal_kembali);
                            if ($today->gt($dueDate)) {
                                $hariTerlambat = $today->diffInDays($dueDate);
                                $denda = $hariTerlambat * 500;
                            }
                        }
                    @endphp

                    @if($hariTerlambat > 0)
                        <div style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px solid #e8e8ff; margin-top: 10px;">
                            <span style="color: #666; font-weight: 500;">Hari Terlambat</span>
                            <span style="color: #d32f2f; font-weight: 600;">{{ $hariTerlambat }} hari</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 15px 0;">
                            <span style="color: #666; font-weight: 500;">Denda</span>
                            <span style="color: #d32f2f; font-weight: 600;">Rp {{ number_format($denda, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>

                <div class="form-actions">
                    <a href="{{ route('peminjaman.index') }}" class="btn-cancel" style="flex: none; width: 100%;">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

        @else
            {{-- CREATE/EDIT MODE --}}
            <div class="form-card">
                <h2 class="page-title">{{ $mode == 'create' ? 'Form Tambah Peminjaman' : 'Form Edit Peminjaman' }}</h2>

                <form action="{{ $mode == 'create' ? route('peminjaman.store') : route('peminjaman.update', $peminjaman->id_peminjaman) }}" method="POST">
                    @csrf
                    @if($mode == 'edit')
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label>Siswa <span class="required">*</span></label>
                        <select name="id_siswa" 
                                class="@error('id_siswa') is-invalid @enderror" 
                                required>
                            <option value="">Pilih Siswa</option>
                            @foreach($siswa as $s)
                                <option value="{{ $s->id_siswa }}" 
                                    {{ old('id_siswa', $peminjaman->id_siswa ?? '') == $s->id_siswa ? 'selected' : '' }}>
                                    {{ $s->nama_siswa }} ({{ $s->kelas->nama_kelas }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_siswa')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Buku <span class="required">*</span></label>
                        <select name="id_buku" 
                                class="@error('id_buku') is-invalid @enderror" 
                                required>
                            <option value="">Pilih Buku</option>
                            @foreach($buku as $b)
                                <option value="{{ $b->id_buku }}" 
                                    {{ old('id_buku', $peminjaman->id_buku ?? '') == $b->id_buku ? 'selected' : '' }}>
                                    {{ $b->nama_buku }} (Stok: {{ $b->stok }})
                                </option>
                            @endforeach
                        </select>
                        <span class="info-helper">* Hanya buku dengan stok tersedia yang dapat dipinjam</span>
                        @error('id_buku')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Pinjam <span class="required">*</span></label>
                        <input type="date" name="tanggal_pinjam" 
                               class="@error('tanggal_pinjam') is-invalid @enderror"
                               value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam ?? date('Y-m-d')) }}" 
                               required>
                        @error('tanggal_pinjam')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Harus Kembali <span class="required">*</span></label>
                        <input type="date" name="tanggal_kembali" 
                               class="@error('tanggal_kembali') is-invalid @enderror"
                               value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali ?? date('Y-m-d', strtotime('+7 days'))) }}" 
                               required>
                        <span class="info-helper">* Biasanya 7 hari dari tanggal pinjam</span>
                        @error('tanggal_kembali')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    @if($mode == 'edit')
                        <div class="form-group">
                            <label>Status <span class="required">*</span></label>
                            <select name="status" 
                                    class="@error('status') is-invalid @enderror" 
                                    required>
                                <option value="Dipinjam" {{ old('status', $peminjaman->status) == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="Dikembalikan" {{ old('status', $peminjaman->status) == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="Terlambat" {{ old('status', $peminjaman->status) == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                            @error('status')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        @if($peminjaman->status == 'Dikembalikan')
                            <div class="form-group">
                                <label>Tanggal Dikembalikan</label>
                                <input type="date" name="tanggal_dikembalikan" 
                                       class="@error('tanggal_dikembalikan') is-invalid @enderror"
                                       value="{{ old('tanggal_dikembalikan', $peminjaman->tanggal_dikembalikan) }}">
                                @error('tanggal_dikembalikan')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    @endif

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-save"></i> {{ $mode == 'create' ? 'Simpan' : 'Update' }}
                        </button>
                        <a href="{{ route('peminjaman.index') }}" class="btn-cancel">
                            <i class="fa-solid fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        @endif
    </div>
</body>

</html>