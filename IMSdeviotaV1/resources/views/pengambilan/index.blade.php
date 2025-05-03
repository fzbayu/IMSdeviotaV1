<h2>Data Pengambilan</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1">
    <thead>
        <tr>
            <th>ID Pengambilan</th>
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
            <td>{{ optional($ambil->mahasiswa)->nama_mahasiswa ?? 'Mahasiswa tidak ditemukan' }}</td>
            <td>{{ optional($ambil->mahasiswa)->nim ?? '-' }}</td>
            <td>{{ optional($ambil->barang)->nama_barang ?? 'Barang tidak ditemukan' }}</td>
            <td>{{ $ambil->jumlah }}</td>
            <td>{{ $ambil->tanggal_ambil }}</td>
        </tr>
        @endforeach
    </tbody>
</table>