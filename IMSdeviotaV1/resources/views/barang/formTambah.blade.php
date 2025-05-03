@extends('layouts.app')

@section('content')

<form action="{{ route('barang.add') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Nama Barang:</label>
    <input type="text" name="nama_barang" required><br>

    <label>Kategori:</label>
    <select name="id_kategori" required>
        @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
        @endforeach
    </select><br>

    <label>Stok:</label>
    <input type="number" name="stok" required><br>

    <label>Lokasi:</label>
    <input type="text" name="lokasi"><br>

    <label>Deskripsi:</label>
    <textarea name="deskripsi"></textarea><br>

    <label>Tipe:</label>
    <select name="tipe">
        <option value="Barang Dipinjam">Barang Dipinjam</option>
        <option value="Barang Diambil">Barang Diambil</option>
    </select><br>

    <label>Stok Minimum:</label>
    <input type="number" name="stok_minimum"><br>

    <label>Harga:</label>
    <input type="number" step="0.01" name="harga" required><br>

    <label>Foto Barang:</label>
    <input type="file" name="foto[]" accept="image/*" multiple required><br>

    <button type="submit">Tambah Barang</button>
</form>

@endsection