<!DOCTYPE html>
<html lang="en">
<head>
@vite('resources/js/app.js')
    <meta charset="UTF-8">
    <title>List Barang</title>
    <style>
    </style>
</head>
<body>

@include('layouts.navbar_listbarang')

<form method="GET" action="{{ route('listbarang') }}" class="filter-bar">
    <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}">
    
    <select name="kategori">
        <option value="">Semua Kategori</option>
        @foreach ($kategori as $k)
            <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select>

    <button type="submit">Filter</button>
</form>



<div id="list-barang">
    @foreach ($barang as $b)
        <div class="barang" data-id="{{ $b->id_barang }}" data-stok="{{ $b->stok }}">
            <img src="{{ asset('storage/' . $b->gambar) }}" width="100">
            <h4>{{ $b->nama_barang }}</h4>
            <p><strong>Kategori:</strong> {{ $b->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
            <p>Stok: <span class="stok-display">{{ $b->stok }}</span></p>
            <div class="counter">
                <button class="kurang">-</button>
                <span class="jumlah">0</span>
                <button class="tambah">+</button>
            </div>
        </div>
    @endforeach
</div>

<div class="footer">
    <form action="{{ route('keranjang') }}" method="GET" onsubmit="return syncCartToInput()">
        <input type="hidden" name="cart" id="cart-input">
        <button id="pinjam">🛒 Pinjam: <span id="total-pinjam">0</span> item</button>
    </form>
</div>

</body>
</html>