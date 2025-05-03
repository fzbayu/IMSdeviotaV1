<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Riwayat Pengambilan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3>Rekap Riwayat Pengambilan Barang</h3>
    @if($tanggal_mulai && $tanggal_selesai)
        <p>Periode: {{ $tanggal_mulai }} s/d {{ $tanggal_selesai }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Ambil</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengambilan as $ambil)
            <tr>
                <td>{{ $ambil->id_pengambilan }}</td>
                <td>{{ optional($ambil->mahasiswa)->nama_mahasiswa ?? '-' }}</td>
                <td>{{ optional($ambil->mahasiswa)->nim ?? '-' }}</td>
                <td>{{ optional($ambil->barang)->nama_barang ?? '-' }}</td>
                <td>{{ $ambil->jumlah }}</td>
                <td>{{ $ambil->tanggal_ambil }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
