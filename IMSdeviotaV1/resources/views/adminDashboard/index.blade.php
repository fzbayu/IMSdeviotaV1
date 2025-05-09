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




    h2 {
        color: #7B1FA2;
        font-size: 3rem;
        font-weight: 800;
        margin: 30px 0 20px 45px; /* Atas, kanan, bawah, kiri */
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
    <h2>LIST PRODUCT</h2>
    <div class="filter-container">
        <!-- Form Filter -->
        <form method="GET" action="{{ route('barang.index') }}">
            <select name="filter_kategori" id="filter_kategori" onchange="this.form.submit()">
                <option value="">Filter : Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}" 
                        {{ request('filter_kategori') == $kategori->id_kategori ? 'selected' : '' }} >
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('barang.formTambah') }}">
            <button type="button">Add Item</button>
        </a>
    </div>
</div>




<!-- Tabel dan Konten Lainnya -->
<table border="1">
    <thead>
        <tr>
            <th>NO</th>
            <th>Foto</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Lokasi</th>
            <th>Deskripsi</th>
            <th>Tipe</th>
            <th>Stok Minimum</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barang as $item)
        <tr>
            <td>{{ $item->id_barang }}</td>
            <td>
                    @if($item->foto->isNotEmpty())
                        <div class="foto-thumbs">
                            @foreach($item->foto as $index => $foto)
                                @if($index < 1) <!-- Batasi hanya 3 thumbnail yang ditampilkan -->
                                    <a href="{{ asset('storage/' . $foto->foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $foto->foto) }}" 
                                             width="60" height="60" style="object-fit: cover; margin-right: 5px;" 
                                             alt="{{ $item->nama_barang }} - Foto {{ $index + 1 }}">
                                    </a>
                                @endif
                            @endforeach
                        
                        </div>
                    @else
                        <span>Tidak ada foto</span>
                    @endif
                </td>
                <td><a href="{{ route('barang.show', $item->id_barang) }}">{{ $item->nama_barang }}</a></td>
                <td>{{ $item->kategori->nama_kategori }}</td>
                <td>{{ $item->stok }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>{{ $item->tipe }}</td>
                <td>{{ $item->stok_minimum }}</td>
                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                
            <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <a href="{{ route('barang.edit', $item->id_barang) }}" title="Edit">
                        <i class="fas fa-pencil-alt" style="color: #6554C4;"></i>
                    </a>
                    <form action="{{ route('barang.delete', $item->id_barang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; padding: 0; margin: 0;" title="Hapus">
                            <i class="fas fa-trash-alt" style="color: #e74c3c;"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>DATA BARANG MASUK</h2>
<table border="1">
    <thead>
        <tr>
            <th>NO</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Tanggal Masuk</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangMasuk as $bm)
        <tr>
            <td>{{ $bm->id_masuk }}</td>
            <td>{{ $bm->barang->nama_barang }}</td>
            <td>{{ $bm->barang->kategori->nama_kategori }}</td>
            <td>{{ $bm->jumlah }}</td>
            <td>{{ $bm->tanggal_masuk }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
