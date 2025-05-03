@extends('layouts.app')

@section('content')
    <h2>Detail Produk</h2>
    
    <p><strong>Nama:</strong> {{ $barang->nama_barang }}</p>
    <p><strong>Kategori:</strong> {{ $barang->kategori->nama_kategori }}</p>
    <p><strong>Stok:</strong> {{ $barang->stok }}</p>
    <p><strong>Lokasi:</strong> {{ $barang->lokasi }}</p>
    <p><strong>Deskripsi:</strong> {{ $barang->deskripsi }}</p>
    <p><strong>Tipe:</strong> {{ $barang->tipe }}</p>
    <p><strong>Stok Minimum:</strong> {{ $barang->stok_minimum }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>

    <p><strong>Foto:</strong></p>
    @foreach($barang->foto as $f)
        <img src="{{ asset('storage/' . $f->foto) }}" width="200">
    @endforeach

    <br><br>
    <a href="{{ route('barang.index') }}">← Kembali ke Daftar Produk</a>
@endsection