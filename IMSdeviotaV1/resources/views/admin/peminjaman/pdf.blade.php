<!DOCTYPE html>
<html>
<head>
    <title>Rekap Peminjaman</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Rekap Data Peminjaman</h2>
    <p>Status: {{ $status_terpilih ?: 'Semua' }}</p>
    @if($tanggal_mulai && $tanggal_selesai)
        <p>Rentang Tanggal: {{ $tanggal_mulai }} s.d {{ $tanggal_selesai }}</p>
    @endif

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
