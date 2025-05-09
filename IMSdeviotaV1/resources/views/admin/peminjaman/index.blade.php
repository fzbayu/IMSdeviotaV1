@extends('layouts.app')

@section('content')

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

    form button[type="submit"] {
        margin: 10px auto; /* Agar button berada di tengah */
        display: block;
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
    <h2>DATA PEMINJAMAN</h2>

    @if($peminjaman->count() > 0)
        <form method="GET" action="{{ route('admin/peminjaman.export') }}" target="_blank" style="display: inline;">
            <input type="hidden" name="filter_status" value="{{ $status_terpilih }}">
            <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
            <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
            <button type="submit" style="background: #28a745; color: white; padding: 8px 14px; border-radius: 8px; font-weight: bold;">
                Export ke PDF
            </button>
        </form>
    @endif
</div>


<!-- Form Filter Utama (Status) -->
<form method="GET" action="{{ route('admin/peminjaman.index') }}" id="filterForm">
    <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 5px;">
        <label for="filter_status">Status Peminjaman:</label>
        <select name="filter_status" id="filter_status" onchange="document.getElementById('filterForm').submit()">
            <option value="">Semua Status</option>
            <option value="Dipinjam" {{ $status_terpilih == 'Dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
            <option value="Dikembalikan" {{ $status_terpilih == 'Dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
        </select>
    </div>
</form>


<!-- Form Filter Tanggal (Muncul setelah status dipilih) -->
@if(isset($status_terpilih))
<form method="GET" action="{{ route('admin/peminjaman.index') }}">
    <input type="hidden" name="filter_status" value="{{ $status_terpilih }}">
    
    <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 5px;">
        <h4>Filter Berdasarkan Tanggal Pinjam:</h4>
        
        <label for="tanggal_mulai">Dari Tanggal:</label>
        <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
               value="{{ $tanggal_mulai ?? '' }}" required>
        
        <label for="tanggal_selesai" style="margin-left: 10px;">Sampai Tanggal:</label>
        <input type="date" name="tanggal_selesai" id="tanggal_selesai" 
               value="{{ $tanggal_selesai ?? '' }}" required>
        
        <button type="submit" style="margin-left: 10px;">Terapkan Filter Tanggal</button>
        @if(isset($tanggal_mulai))
            <a href="{{ route('admin/peminjaman.index', ['filter_status' => $status_terpilih]) }}" 
               style="margin-left: 10px; color: #dc3545;">
                Hapus Filter Tanggal
            </a>
        @endif
    </div>
</form>
@endif

@if(session('success'))
    <div style="color: green; margin-bottom: 15px;">{{ session('success') }}</div>
@endif

@if($peminjaman->count() > 0)
    <table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>NO</th>
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
            <td>{{ optional($pinjam->mahasiswa)->nama_mahasiswa ?? 'Mahasiswa tidak ditemukan' }}</td>
            <td>{{ optional($pinjam->mahasiswa)->nim ?? '-' }}</td>
            <td>{{ optional($pinjam->barang)->nama_barang ?? 'Barang tidak ditemukan' }}</td>
            <td>{{ $pinjam->jumlah }}</td>
            <td>{{ $pinjam->tanggal_pinjam }}</td>
            <td>{{ $pinjam->tanggal_kembali ?? '-' }}</td>
            <td>{{ $pinjam->status }}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
@else
    <p style="color: #6c757d; font-style: italic;">Tidak ada data peminjaman yang sesuai dengan filter</p>
@endif

<script>
    // Set tanggal default (opsional)
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.getElementById('tanggal_mulai').value) {
            let today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_mulai').value = today;
            document.getElementById('tanggal_selesai').value = today;
        }
    });
</script>

@endsection