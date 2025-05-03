<!-- <div class="topnav">
  <a class="active" href="{{ route('barang.index') }}">Produk</a>
  <a href="{{ route('admin/peminjaman.index') }}">Riwayat Peminjaman</a>
  <a href="{{ route('admin/pengambilan.index') }}">Riwayat Pengambilan</a>
  <a href="#about">Notifikasi</a>
</div> -->

@extends('layouts.app')

@section('content')
<h2>List Product</h2>

<!-- Form Filter -->
<form method="GET" action="{{ route('barang.index') }}">
    <label for="filter_kategori">Filter by Kategori:</label>
    <select name="filter_kategori" id="filter_kategori">
        <option value="">Semua Kategori</option>
        @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id_kategori }}" 
                {{ request('filter_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select>
    <button type="submit">Filter</button>
    <a href="{{ route('barang.index') }}" class="btn">Reset</a>
</form>

<a href="{{ route('barang.formTambah') }}">
    <button>Add Item</button>
</a>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Lokasi</th>
            <th>Deskripsi</th>
            <th>Tipe</th>
            <th>Stok Minimum</th>
            <th>Harga</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barang as $item)
        <tr>
            <td>{{ $item->id_barang }}</td>
            <td><a href="{{ route('barang.show', $item->id_barang) }}">{{ $item->nama_barang }}</a></td>
            <td>{{ $item->kategori->nama_kategori }}</td>
            <td>{{ $item->stok }}</td>
            <td>{{ $item->lokasi }}</td>
            <td>{{ $item->deskripsi }}</td>
            <td>{{ $item->tipe }}</td>
            <td>{{ $item->stok_minimum }}</td>
            <td>{{ $item->harga }}</td>
            <td>
                @foreach($item->foto as $f)
                    <img src="{{ asset('storage/' . $f->foto) }}" width="100">
                @endforeach
            </td>
            <td>
                <a href="{{ route('barang.edit', $item->id_barang) }}">Edit</a>
            </td>
            <td>
            <form action="{{ route('barang.delete', $item->id_barang) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>

        </tr>
        @endforeach
    </tbody>
</table>


<h2>Data Barang Masuk</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID Masuk</th>
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