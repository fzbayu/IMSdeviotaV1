@extends('layouts.app')

@section('content')

<h2>Data Peminjaman</h2>

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

@if($peminjaman->count() > 0)
    <form method="GET" action="{{ route('admin/peminjaman.export') }}" target="_blank">
        <input type="hidden" name="filter_status" value="{{ $status_terpilih }}">
        <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
        <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
        <button type="submit" style="margin-bottom: 15px; background: #28a745; color: white; padding: 6px 12px; border-radius: 5px;">
            Export ke PDF
        </button>
    </form>
@endif

@if(session('success'))
    <div style="color: green; margin-bottom: 15px;">{{ session('success') }}</div>
@endif

@if($peminjaman->count() > 0)
    <table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID Peminjaman</th>
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