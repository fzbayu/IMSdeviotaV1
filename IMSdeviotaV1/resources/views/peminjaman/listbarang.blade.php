<!DOCTYPE html>
<html lang="en">
<head>
@vite(['resources/js/app.js'])
    <meta charset="UTF-8">
    <title>List Barang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .header {
            background: linear-gradient(to bottom, #6554C4,rgb(233, 216, 255));
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 32px;
            margin: 0;
        }

        .filter-bar {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            margin: 20px 0;
            padding: 0 40px;
        }

        .filter-bar input[type="text"] {
            flex: 1;
            width: 300px;
            padding: 10px 15px;
            border-radius: 20px;
            border: 1px solid #ccc;
            outline: none;
        }

        .filter-bar select,
        .filter-bar button {
            padding: 10px 15px;
            font-size: 14px;
            line-height: 1.2;
            border-radius: 10px;
            background-color: #6554C4;
            color: white;
            cursor: pointer;
            border: none;
        }

        .filter-bar select {
            appearance: none; 
            background-image: url("images/dropdown.png");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 10px 6px;
            padding-right: 20px; 
        }

        .search-wrapper {
            position: relative;
            flex: 1;
        }

        .search-wrapper input[type="text"] {
            width: 100%;
            padding: 10px 40px 10px 15px; /* ruang untuk ikon di kanan */
            font-size: 16px;
        }

        .search-wrapper .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            pointer-events: none;
            opacity: 0.7;
        }

        .barang {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
        }

        .barang img {
            width: 100%;
            max-width: 100px;
            height: auto;
        }

        .barang h4 {
            margin: 10px 0 5px;
            font-size: 16px;
        }

        .barang p {
            font-size: 14px;
            margin: 5px 0;
        }

        .counter {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .counter button {
            width: 30px;
            height: 30px;
            font-size: 18px;
            border: none;
            background-color: #6554C4;
            color: white;
            border-radius: 50%;
            cursor: pointer;
        }

        .counter .jumlah {
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            position: sticky;
            bottom: 0;
            padding: 15px;
            display: flex;
            justify-content: center;
        }

        .footer button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .btn-back {
            background-color: #6554C4;
            color: white;
            border: none;
            padding: 10px 40px;
            border-radius: 15px;
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .btn-home {
            background-color: #6554C4;
            color: white;
            border: none;
            padding: 10px 10px;
            border-radius: 15px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .btn-home .btn-icon {
            width: 21px; /* Kecilkan gambar sesuai kebutuhan */
            height: 21px; /* Sesuaikan ukuran */
        }

        .btn-cart {
            width: 21px; /* Kecilkan gambar sesuai kebutuhan */
            height: 21px; /* Sesuaikan ukuran */
        }

        .button-group {
            display: flex;
            gap: 10px; /* jarak antar tombol */
        }

        .section-title {
            text-align: center;
            margin: 20px 0;
            font-weight: 700;
            color: #333;
        }

        .produk-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 30px;
            padding: 20px 60px 60px 60px;
        }


        .barang {
            background-color: #e5e5e5;
            min-width: 250px; /* atau sesuai ukuran yang kamu mau */
            flex-shrink: 0;
            padding: 15px;
            border-radius: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.20);
            text-align: center;
        }
        
        .produk-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            padding: 10px;
            background-color: white;
        }
        
        .stok-display {
            text-align: center;
            padding: 2px;
        }

        .counter {
            background-color: #6554C4;
            color: white;
            padding: 8px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
        }

        .produk-add button {
            background: transparent;
            color: white;
            border: none;
            font-size: 24px; /* Perbesar ukuran tombol */
            font-weight: bold;
            cursor: pointer;
        }

        .produk-add .jumlah {
            font-size: 18px;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Header List Barang -->
    <div class="header">
        <h1>LIST BARANG</h1>
        <div class="button-group">
            <a href="{{ route('welcome') }}" class="btn-home">
                <img src="images/home.png" alt="icon" class="btn-icon">
            </a>
            <a href="{{ route('welcome') }}" class="btn-back">Back</a>
        </div>
    </div>

    <!-- Search bar dan filter -->
    <form method="GET" action="{{ route('listbarang') }}" class="filter-bar">
        <div class="search-wrapper">
            <input type="text" name="search" placeholder="Cari barang yang diinginkan..." value="{{ request('search') }}">
            <img src="{{ asset('images/search.png') }}" alt="Search" class="search-icon">
        </div>
        <select name="kategori">
            <option value="">Filter : Kategori</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </select>
        <button type="submit">Fillter</button>
    </form>

    <!-- List barang -->
    <div class="produk-container">
        @foreach ($barang as $b)
            <div class="barang" data-id="{{ $b->id_barang }}" data-stok="{{ $b->stok }}">
                <h4>{{ $b->nama_barang }}</h4>
                @if($b->foto->count() > 0)
                    <img class="produk-image" src="{{ asset('storage/' . $b->foto->first()->foto) }}" width="100">
                @else
                    <img class="produk-image" src="{{ asset('images/no-image.png') }}" width="100">
                @endif
                <p>Stok: <span class="stok-display">{{ $b->stok }}</span></p>
                <div class="counter">
                    <button class="kurang">-</button>
                    <span class="jumlah">0</span>
                    <button class="tambah">+</button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Footer -->
    <div class="footer">
        <form action="{{ route('keranjang') }}" method="GET" onsubmit="return syncCartToInput()">
            <input type="hidden" name="cart" id="cart-input">
            <button id="pinjam">
                <img src="images/cart.png" alt="icon" class="btn-cart">
                Pinjam: <span id="total-pinjam">0</span>
            </button>
        </form>
    </div> 

</div>
</body>
</html>
