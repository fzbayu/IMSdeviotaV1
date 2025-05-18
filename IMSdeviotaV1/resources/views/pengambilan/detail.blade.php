<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<style>
    
    /* Main container styles */
    .product-detail-container {
        max-width: 800px;
        margin: 0 auto;
        font-family: Arial, sans-serif;
    }
    
    /* Header styles */
    .detail-header {
        color: #7B1FA2;
        font-size: 3rem;
        font-weight: 800;
        margin: 30px auto 20px auto;
        text-align: center;
    }
    
    /* Product image styles */
    .product-image {
        text-align: center;
        margin-bottom: 25px;
    }
    
    .product-image img {
        width: 300px; /* Ukuran foto yang lebih kecil */
        height: 300px; /* Ukuran foto yang lebih kecil */
        object-fit: cover; /* Memastikan gambar tetap proporsional */
        background-color: white;
    }
    
    /* Product info box */
    .product-info {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 45px;
        margin-bottom: 20px;
    }
    
    /* Form field styles */
    .info-group {
        margin-bottom: 15px;
    }
    
    .info-label {
        display: block;
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    
    .info-value {
        display: block;
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #fff;
        font-size: 14px;
        color: #333;
    }
    
    /* Back button */
    .back-button {
        display: inline-block;
        margin-top: 15px;
        color: #6a1b9a;
        text-decoration: none;
    }
    
    .back-button:hover {
        text-decoration: underline;
    }
    
    /* Product photos section */
    .product-photos {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Membuat 4 kolom untuk gambar yang lebih kecil */
        gap: 15px; /* Menambahkan jarak antar gambar */
        margin-top: 20px;
    }

    
    .product-photos .photo-container {
        width: 100%;
        height: 200px; /* Ukuran lebih kecil */
        overflow: hidden; /* Agar gambar tidak melampaui batas */
        border: 1px solid #ddd;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    
    .product-photos img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Memastikan gambar menyesuaikan ruang tanpa pecah */
    }

    .back-button {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 20px;
        background-color: #7B1FA2;
        color: white;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        box-shadow: 0 4px 8px rgba(123, 31, 162, 0.3);
        transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        user-select: none;
    }

    .back-button:hover {
        background-color: #5e148f;
        box-shadow: 0 6px 12px rgba(94, 20, 143, 0.5);
        transform: translateY(-3px);
        text-decoration: none;
    }

    .back-button:active {
        transform: translateY(1px);
        box-shadow: 0 2px 5px rgba(94, 20, 143, 0.3);
    }

</style>

<div class="product-detail-container">
    <h2 class="detail-header">DETAIL BARANG</h2>
    
    <div class="product-image">
        @if(isset($barang->foto) && count($barang->foto) > 0)
            <img src="{{ asset('storage/' . $barang->foto[0]->foto) }}" alt="{{ $barang->nama_barang }}">
        @else
            <img src="{{ asset('images/no-image.jpg') }}" alt="No Image Available">
        @endif
    </div>
    
    <div class="product-info">
        <div class="info-group">
            <label class="info-label">NAMA</label>
            <div class="info-value">{{ $barang->nama_barang }}</div>
        </div>
        
        <div class="info-group">
            <label class="info-label">STOK</label>
            <div class="info-value">{{ $barang->stok }}</div>
        </div>
        
        <div class="info-group">
            <label class="info-label">LOKASI</label>
            <div class="info-value">{{ $barang->lokasi }}</div>
        </div>
        
        <div class="info-group">
            <label class="info-label">DESKRIPSI</label>
            <div class="info-value">{{ $barang->deskripsi }}</div>
        </div>
        
        <div class="info-group">
            <label class="info-label">TIPE</label>
            <div class="info-value">{{ $barang->tipe }}</div>
        </div>
        
        <div class="info-group">
            <label class="info-label">STOK MINIMUM</label>
            <div class="info-value">{{ $barang->stok_minimum }}</div>
        </div>
        
        <div class="info-group">
            <label class="info-label">HARGA</label>
            <div class="info-value">{{ number_format($barang->harga, 0, ',', '.') }}</div>
        </div>
        
        <div class="info-group">
            <label class="info-label">KATEGORI</label>
            <div class="info-value">{{ $barang->kategori->nama_kategori }}</div>
        </div>
        
    </div>
    
    @if(isset($barang->foto) && count($barang->foto) > 1)
    <div class="product-photos">
        <h3>Foto Produk Lainnya:</h3>
        @foreach($barang->foto as $index => $f)
            @if($index > 0)
                <div class="photo-container">
                    <img src="{{ asset('storage/' . $f->foto) }}" alt="Foto {{ $index }}">
                </div>
            @endif
        @endforeach
    </div>
    @endif
    
    <a href="{{ url('/listbarang') }}" class="back-button">Kembali ke Daftar Produk</a>
</div>