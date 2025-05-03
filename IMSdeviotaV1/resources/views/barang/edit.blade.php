@extends('layouts.app')

@section('content')

<h2>Edit Barang</h2>
<form action="{{ route('barang.update', $barang->id_barang) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama Barang:</label>
    <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" required><br>

    <label>Kategori:</label>
    <select name="id_kategori" required>
        @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id_kategori }}" 
                {{ $barang->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select><br>

    <label>Stok:</label>
    <input type="number" name="stok" value="{{ $barang->stok }}" required><br>

    <label>Lokasi:</label>
    <input type="text" name="lokasi" value="{{ $barang->lokasi }}"><br>

    <label>Deskripsi:</label>
    <textarea name="deskripsi">{{ $barang->deskripsi }}</textarea><br>

    <label>Tipe:</label>
    <select name="tipe" required>
        <option value="Barang Dipinjam" {{ $barang->tipe == 'Barang Dipinjam' ? 'selected' : '' }}>Barang Dipinjam</option>
        <option value="Barang Diambil" {{ $barang->tipe == 'Barang Diambil' ? 'selected' : '' }}>Barang Diambil</option>
    </select><br>

    <label>Stok Minimum:</label>
    <input type="number" name="stok_minimum" value="{{ $barang->stok_minimum }}"><br>

    <label>Harga:</label>
    <input type="number" name="harga" value="{{ $barang->harga }}" required><br>

    <button type="submit">Simpan Perubahan</button>
</form>

@endsection