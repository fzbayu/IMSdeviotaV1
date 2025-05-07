@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Judul dan Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>List Product</h2>
        <a href="{{ route('barang.formTambah') }}">
            <button>Add Item</button>
        </a>
    </div>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('barang.index') }}" class="mb-3">
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
        
        <label for="filter_stok">Filter by Stok:</label>
        <select name="filter_stok" id="filter_stok">
            <option value="">Semua Stok</option>
            <option value="low" {{ request('filter_stok') == 'low' ? 'selected' : '' }}>Stok Rendah</option>
            <option value="out" {{ request('filter_stok') == 'out' ? 'selected' : '' }}>Stok Habis</option>
        </select>
        
        <button type="submit">Filter</button>
        <a href="{{ route('barang.index') }}">
            <button type="button">Reset</button>
        </a>
    </form>

    <!-- Tabel Produk -->
    <table border="1" cellpadding="5" style="width: 100%;">
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
                <th colspan="2">Aksi</th>
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
                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>
                    @if($item->foto->isNotEmpty())
                        <div class="foto-thumbs">
                            @foreach($item->foto as $index => $foto)
                                @if($index < 3) <!-- Batasi hanya 3 thumbnail yang ditampilkan -->
                                    <a href="{{ asset('storage/' . $foto->foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $foto->foto) }}" 
                                             width="60" height="60" style="object-fit: cover; margin-right: 5px;" 
                                             alt="{{ $item->nama_barang }} - Foto {{ $index + 1 }}">
                                    </a>
                                @endif
                            @endforeach
                            
                            @if($item->foto->count() > 3)
                                <span style="font-size: 12px; color: #666;">
                                    +{{ $item->foto->count() - 3 }} lainnya
                                </span>
                            @endif
                        </div>
                    @else
                        <span>Tidak ada foto</span>
                    @endif
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

    <h2 class="mt-4">Data Barang Masuk</h2>
    <table border="1" cellpadding="5" style="width: 100%;">
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
</div>

<style>
    .foto-thumbs {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .foto-thumbs img {
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: transform 0.2s;
    }
    
    .foto-thumbs img:hover {
        transform: scale(1.1);
        box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }
</style>
@endsection