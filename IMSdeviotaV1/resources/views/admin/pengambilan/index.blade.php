@extends('layouts.app')

@section('content')

<style>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(#ffffff);
        margin: 0;
        padding: 0;
    }

   .header-container {
    display: flex;
    justify-content: space-between; /* Menyebarkan elemen di kiri dan kanan */
    align-items: center;
    margin: 20px;
}

.filter-container {
    display: flex;
    gap: 20px; /* Jarak antara select dan tombol */
    align-items: center;
    margin-right: 40px; /* Menambahkan margin kanan agar tidak terlalu menempel ke tepi */
}




    h2 {
        color: #7B1FA2;
        font-size: 3rem;
        font-weight: 800;
        margin: 30px 0 20px 45px; /* Atas, kanan, bawah, kiri */
    }

    .filter-container {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    select {
        background-color: #6a0dad;
        color: #ffffff;
        padding: 8px 14px;
        border: 2px solid #6a0dad;
        border-radius: 8px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        font-weight: bold;
        cursor: pointer;
    }

    button, .btn {
        background-color: #6a0dad;
        color: white;
        padding: 8px 14px;
        border: none;
        border-radius: 8px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        font-weight: bold;
        cursor: pointer;
    }

    .btn {
        background-color: #999;
    }

    table {
        width: 95%;
        margin: 20px auto;
        border-collapse: collapse;
        border-radius: 15px;
        overflow: hidden;
        background-color: #ffffff;
        color: #6554C4;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    thead {
        background-color: #C1BBE7;
        color: white;
    }

    tbody tr:hover {
        background-color: #C1BBE7;
        color: #ffffff;
    }

    th, td {
        padding: 14px 16px;
        border-bottom: 1px solid #ccc;
        vertical-align: middle;
        text-align: center;
    }

    td img {
        max-width: 60px;
        border-radius: 10px;
    }

    a {
        color: #6554C4;
        font-weight: bold;
        text-decoration: none;
    }

    a:hover {
        color: #ffffff;
        text-decoration: underline;
    }

    button[type="submit"] {
        background-color: #6a0dad;
    }

</style>

<div class="header-container">
    <h2>DATA PENGAMBILAN</h2>

    @if(count($pengambilan) > 0)
        <form method="GET" action="{{ route('admin/pengambilan.export-pdf') }}" target="_blank">
            <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
            <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
            <button type="submit" style="background: #28a745; color: white; padding: 8px 14px; border-radius: 8px; font-weight: bold;">
                Export ke PDF
            </button>
        </form>
    @endif
</div>


<form method="GET" action="{{ route('admin/pengambilan.index') }}">
    <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 5px;">
        <h4>Filter Berdasarkan Tanggal Ambil:</h4>
        <label for="tanggal_mulai">Dari Tanggal:</label>
        <input type="date" name="tanggal_mulai" value="{{ $tanggal_mulai ?? '' }}" required>

        <label for="tanggal_selesai" style="margin-left: 10px;">Sampai Tanggal:</label>
        <input type="date" name="tanggal_selesai" value="{{ $tanggal_selesai ?? '' }}" required>

        <button type="submit" style="margin-left: 10px;">Terapkan Filter</button>

        @if(isset($tanggal_mulai))
            <a href="{{ route('admin/pengambilan.index') }}" style="margin-left: 10px; color: red;">Reset</a>
        @endif
    </div>
</form>

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

@endsection