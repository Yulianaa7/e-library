<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode == 'index' ? 'Pengembalian Buku' : 'Proses Pengembalian' }} - Sistem Perpustakaan</title>
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

        .page-title {
            font-size: 2em;
            color: #333;
            font-weight: 600;
            margin-bottom: 30px;
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

        .info-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .info-banner .icon {
            font-size: 3em;
        }

        .info-banner .text h3 {
            font-size: 1.3em;
            margin-bottom: 8px;
        }

        .info-banner .text p {
            opacity: 0.9;
            line-height: 1.6;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 25px;
        }

        .peminjaman-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .peminjaman-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
        }

        .peminjaman-card.normal::before {
            background: #4caf50;
        }

        .peminjaman-card.warning::before {
            background: #ff9800;
        }

        .peminjaman-card.danger::before {
            background: #f44336;
        }

        .peminjaman-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .card-id {
            font-size: 1.2em;
            font-weight: 700;
            color: #667eea;
        }

        .badge-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .status-normal {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-warning {
            background: #fff3e0;
            color: #e65100;
        }

        .status-danger {
            background: #ffebee;
            color: #c62828;
        }

        .card-body {
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-weight: 500;
        }

        .info-value {
            color: #333;
            font-weight: 600;
            text-align: right;
        }

        .denda-section {
            background: #fff3e0;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            border: 2px solid #ffb74d;
        }

        .denda-section.danger {
            background: #ffebee;
            border-color: #ef5350;
        }

        .denda-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .denda-row:last-child {
            margin-bottom: 0;
            padding-top: 10px;
            border-top: 2px solid rgba(0, 0, 0, 0.1);
            font-weight: 700;
            font-size: 1.1em;
        }

        .no-denda {
            color: #4caf50;
            text-align: center;
            padding: 15px;
            background: #e8f5e9;
            border-radius: 10px;
            margin: 15px 0;
            font-weight: 600;
        }

        .btn-kembali {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1em;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-kembali:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            grid-column: 1 / -1;
        }

        .empty-state .icon {
            font-size: 5em;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #666;
        }

        /* FORM STYLES */
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 40px;
        }

        .confirmation-content {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .total-denda {
            background: #fff3e0;
            padding: 20px;
            border-radius: 10px;
            margin-top: 15px;
            text-align: center;
            border: 2px solid #ffb74d;
        }

        .total-denda.danger {
            background: #ffebee;
            border-color: #ef5350;
        }

        .total-denda p {
            color: #666;
            margin-bottom: 8px;
        }

        .total-denda h3 {
            color: #d32f2f;
            font-size: 2em;
        }

        .no-denda-big {
            background: #e8f5e9;
            padding: 20px;
            border-radius: 10px;
            margin-top: 15px;
            text-align: center;
        }

        .no-denda-big p {
            color: #2e7d32;
            font-weight: 600;
            font-size: 1.1em;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-confirm {
            flex: 1;
            padding: 14px;
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
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

            .info-banner {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <h1>
            <i class="fa-solid fa-arrow-rotate-left"></i>
            {{ $mode == 'index' ? 'Pengembalian Buku' : 'Konfirmasi Pengembalian' }}
        </h1>
        <a href="{{ $mode == 'index' ? route('dashboard') : route('pengembalian.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </nav>

    <div class="container">
        @if($mode == 'index')
            {{-- INDEX MODE --}}
            <h2 class="page-title">Pengembalian & Perhitungan Denda</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="info-banner">
                <div class="icon">⚠️</div>
                <div class="text">
                    <h3>Informasi Denda Keterlambatan</h3>
                    <p>Denda keterlambatan pengembalian buku adalah Rp 1.500 per hari. Pastikan untuk mengembalikan buku tepat
                        waktu untuk menghindari denda.</p>
                </div>
            </div>

            <div class="cards-grid">
                @forelse($peminjaman as $item)
                    @php
                        $today = \Carbon\Carbon::now();
                        $tglKembali = \Carbon\Carbon::parse($item->tgl_kembali);
                        $hariTerlambat = $today->startOfDay()->diffInDays($tglKembali->startOfDay(), false);
                        $hariTerlambat = $hariTerlambat < 0 ? abs($hariTerlambat) : 0;
                        $denda = $hariTerlambat * 1500;
                        
                        $cardClass = 'normal';
                        $statusClass = 'status-normal';
                        $statusText = 'Tepat Waktu';
                        
                        if ($hariTerlambat > 0) {
                            $statusText = 'Terlambat ' . $hariTerlambat . ' hari';
                            if ($hariTerlambat <= 3) {
                                $cardClass = 'warning';
                                $statusClass = 'status-warning';
                            } else {
                                $cardClass = 'danger';
                                $statusClass = 'status-danger';
                            }
                        }
                    @endphp

                    <div class="peminjaman-card {{ $cardClass }}">
                        <div class="card-header">
                            <div class="card-id">#{{ $item->id_peminjaman }}</div>
                            <span class="badge-status {{ $statusClass }}">{{ $statusText }}</span>
                        </div>
                        <div class="card-body">
                            <div class="info-row">
                                <span class="info-label">Nama Siswa</span>
                                <span class="info-value">{{ $item->nama_siswa }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Kelas</span>
                                <span class="info-value">{{ $item->nama_kelas }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tgl Pinjam</span>
                                <span class="info-value">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tgl Harus Kembali</span>
                                <span class="info-value">{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') }}</span>
                            </div>
                        </div>

                        @if($hariTerlambat > 0)
                            <div class="denda-section {{ $hariTerlambat > 3 ? 'danger' : '' }}">
                                <div class="denda-row">
                                    <span>Hari Terlambat:</span>
                                    <span style="color: #d32f2f; font-weight: 700;">{{ $hariTerlambat }} hari</span>
                                </div>
                                <div class="denda-row">
                                    <span>Denda per Hari:</span>
                                    <span>Rp 1.500</span>
                                </div>
                                <div class="denda-row">
                                    <span>Total Denda:</span>
                                    <span style="color: #d32f2f;">Rp {{ number_format($denda, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="no-denda">✓ Tidak ada denda</div>
                        @endif

                        <a href="{{ route('pengembalian.create', ['id' => $item->id_peminjaman]) }}" class="btn-kembali">
                            <i class="fa-solid fa-check"></i> Proses Pengembalian
                        </a>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="icon">📚</div>
                        <h3>Tidak Ada Peminjaman Aktif</h3>
                        <p>Semua buku telah dikembalikan</p>
                    </div>
                @endforelse
            </div>

        @else
            {{-- CONFIRMATION MODE --}}
            <div class="form-card">
                <h2 class="page-title">Konfirmasi Pengembalian</h2>

                @php
                    $today = \Carbon\Carbon::now();
                    $tglKembali = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
                    $hariTerlambat = $today->startOfDay()->diffInDays($tglKembali->startOfDay(), false);
                    $hariTerlambat = $hariTerlambat < 0 ? abs($hariTerlambat) : 0;
                    $denda = $hariTerlambat * 1500;
                @endphp

                <div class="confirmation-content">
                    <div class="info-row">
                        <span class="info-label">ID Peminjaman</span>
                        <span class="info-value">#{{ $peminjaman->id_peminjaman }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nama Siswa</span>
                        <span class="info-value">{{ $peminjaman->nama_siswa }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kelas</span>
                        <span class="info-value">{{ $peminjaman->nama_kelas }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Dikembalikan</span>
                        <span class="info-value">{{ $today->format('d M Y') }}</span>
                    </div>

                    @if($hariTerlambat > 0)
                        <div class="total-denda {{ $hariTerlambat > 3 ? 'danger' : '' }}">
                            <p>Hari Terlambat: {{ $hariTerlambat }} hari</p>
                            <p>Total Denda yang Harus Dibayar:</p>
                            <h3>Rp {{ number_format($denda, 0, ',', '.') }}</h3>
                        </div>
                    @else
                        <div class="no-denda-big">
                            <p>✓ Pengembalian Tepat Waktu</p>
                            <p style="margin-top: 5px;">Tidak ada denda</p>
                        </div>
                    @endif
                </div>

                <form action="{{ route('pengembalian.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id_peminjaman }}">

                    <div class="form-actions">
                        <button type="submit" class="btn-confirm">
                            <i class="fa-solid fa-check"></i> Konfirmasi Pengembalian
                        </button>
                        <a href="{{ route('pengembalian.index') }}" class="btn-cancel">
                            <i class="fa-solid fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        @endif
    </div>
</body>

</html>