@extends('layouts.app')

@section('content')

<h2>Edit Barang</h2>
<form action="{{ route('barang.update', $barang->id_barang) }}" method="POST" enctype="multipart/form-data">
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

    <!-- Bagian untuk menampilkan foto yang sudah ada -->
    @if($barang->foto->count() > 0)
        <div>
            <h3>Foto Produk Saat Ini:</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                @foreach($barang->foto as $foto)
                    <div style="position: relative; width: 150px; margin-bottom: 15px;">
                        <img src="{{ asset('storage/' . $foto->foto) }}" style="width: 100%; height: auto;">
                        <div>
                            <input type="checkbox" name="hapus_foto[]" value="{{ $foto->id_foto }}"> Hapus
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p>Belum ada foto untuk produk ini.</p>
    @endif

    <!-- Bagian untuk menambahkan foto baru -->
    <div>
        <h3>Tambah Foto Baru:</h3>
        <input type="file" name="foto_baru[]" multiple accept="image/*">
        <small>Anda dapat memilih beberapa foto sekaligus.</small>
    </div>

    <button type="submit" style="margin-top: 20px;">Simpan Perubahan</button>
</form>

@endsection