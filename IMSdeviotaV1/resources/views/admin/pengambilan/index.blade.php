@extends('layouts.app')

@section('content')

<h2>Data Pengambilan</h2>

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

<!-- Tombol Export PDF -->
@if(count($pengambilan) > 0)
    <form method="GET" action="{{ route('admin/pengambilan.export-pdf') }}" target="_blank">
        <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
        <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
        <button type="submit" style="margin-bottom: 15px; background: #28a745; color: white; padding: 6px 12px; border-radius: 5px;">
            Export ke PDF
        </button>
    </form>
@endif

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