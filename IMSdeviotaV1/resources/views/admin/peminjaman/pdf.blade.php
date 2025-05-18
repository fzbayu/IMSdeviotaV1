<!DOCTYPE html>
<html>
<head>
    <title>Rekap Peminjaman</title>
    <style>
        body { 
            font-family: sans-serif;
            margin: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-text {
            margin-left: 20px;
        }
        .header-text h1 {
            margin: 0;
            font-size: 24px;
        }
        .header-text p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 12px;
            margin-top: 20px;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #eee; 
            font-weight: bold;
        }
        .filter-info {
            margin: 10px 0;
            font-size: 14px;
        }
        .logo {
            height: 80px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
        <div class="header-text">
        </div>
    </div>
    <h1>Rekap Data Peminjaman</h1>
            <p>Laporan Sistem Peminjaman Barang</p>

    <div class="filter-info">
        <p><strong>Status:</strong> {{ $status_terpilih ?: 'Semua' }}</p>
        @if($tanggal_mulai && $tanggal_selesai)
            <p><strong>Rentang Tanggal:</strong> {{ $tanggal_mulai }} s.d {{ $tanggal_selesai }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $pinjam)
            <tr>
                <td>{{ $pinjam->id_peminjaman }}</td>
                <td>{{ optional($pinjam->mahasiswa)->nama_mahasiswa ?? '-' }}</td>
                <td>{{ optional($pinjam->mahasiswa)->nim ?? '-' }}</td>
                <td>{{ optional($pinjam->barang)->nama_barang ?? '-' }}</td>
                <td>{{ $pinjam->jumlah }}</td>
                <td>{{ $pinjam->tanggal_pinjam }}</td>
                <td>{{ $pinjam->tanggal_kembali ?? '-' }}</td>
                <td>{{ $pinjam->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>