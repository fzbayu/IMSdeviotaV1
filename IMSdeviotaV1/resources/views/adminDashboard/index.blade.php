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
        justify-content: space-between;
        /* Menyebarkan elemen di kiri dan kanan */
        align-items: center;
        margin: 20px;
    }

    .filter-container {
        display: flex;
        gap: 20px;
        /* Jarak antara select dan tombol */
        align-items: center;
        margin-right: 40px;
        /* Menambahkan margin kanan agar tidak terlalu menempel ke tepi */
    }

    h2 {
        color: #7B1FA2;
        font-size: 3rem;
        font-weight: 800;
        margin: 30px 0 20px 45px;
        /* Atas, kanan, bawah, kiri */
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

    button,
    .btn {
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
        background-color: #6a0dad;
        color: white;
    }

    tbody tr:hover {
        background-color: #C1BBE7;
        color: #ffffff;
    }

    th,
    td {
        padding: 14px 16px;
        border-bottom: 1px solid #ccc;
        vertical-align: middle;
        text-align: center;
        border: 1px solid #555;
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

    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease-in-out;
    }

    .popup-container {
        position: fixed;
        top: 20px;
        right: 20px;
        max-width: 400px;
        max-height: 80vh;
        overflow-y: auto;
        z-index: 1001;
    }

    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .notif-box {
        background-color: #FF7043;
        color: white;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        animation: slideInRight 0.4s ease-in-out;
        position: relative;
    }

    .notif-content {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-right: 30px;
        /* Beri ruang untuk tombol tutup */
    }

    .notif-icon {
        background-color: white;
        color: #FF7043;
        font-weight: bold;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notif-message {
        font-weight: 600;
        font-size: 14px;
    }

    .close-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        transition: background-color 0.2s;
    }

    .close-btn:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .notif-header {
        background-color: #7B1FA2;
        color: white;
        padding: 10px 15px;
        border-radius: 12px 12px 0 0;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close-all-btn {
        background-color: white;
        color: #7B1FA2;
        border: none;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>


@if(count($barang_notif) > 0)
<div class="popup-container" id="notificationContainer">
    <div class="notif-header">
        <span>NOTIFIKASI STOK</span>
        <button class="close-all-btn" onclick="closeAllNotifications()">Tutup Semua</button>
    </div>
    <div class="notif-list">
        @foreach($barang_notif as $item)
        <div class="notif-box" id="notif-{{ $item->id_barang }}">
            <div class="notif-content">
                <div class="notif-icon">!</div>
                <div class="notif-message">
                    BARANG <strong>{{ strtoupper($item->nama_barang) }}</strong> TERSISA {{ $item->stok }}
                </div>
            </div>
            <button class="close-btn" onclick="closeNotification('notif-{{ $item->id_barang }}')">×</button>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- JUDUL -->
<div style="margin: 30px 45px 10px 45px;">
    <h2 style="color: #7B1FA2; font-size: 3rem; font-weight: 800; margin: 0;">LIST PRODUK</h2>
</div>

<!-- CONTROL BAR: Search, Filter, Add -->
<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 45px 20px 45px;">
    <!-- SEARCH + FILTER -->
    <div style="display: flex; align-items: center; gap: 12px;">
        <!-- Form Search -->
        <form method="GET" action="{{ route('barang.index') }}" style="display: flex; align-items: center; gap: 10px;">
            <input type="text" name="search" placeholder="Cari Nama Barang"
                value="{{ request('search') }}"
                style="padding: 8px; width: 300px; border-radius: 5px; border: 1px solid #ccc;">
            <button type="submit" style="background-color: #6a0dad; color: white; padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer;">
                Cari
            </button>
        </form>

        <!-- Form Filter -->
        <form method="GET" action="{{ route('barang.index') }}">
            <select name="filter_kategori" id="filter_kategori" onchange="this.form.submit()"
                style="background-color: #6a0dad; color: white; padding: 8px 14px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                <option value="">Filter : Semua Kategori</option>
                @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id_kategori }}"
                    {{ request('filter_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- ADD ITEM BUTTON -->
    <a href="{{ route('barang.formTambah') }}">
        <button type="button"
            style="background-color: #6a0dad; color: white; padding: 8px 16px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
            Tambah Produk
        </button>
    </a>
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
                    @if($index < 1)
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


<script>
    // Fungsi untuk menutup notifikasi individual
    function closeNotification(id) {
        const notification = document.getElementById(id);
        notification.style.animation = 'slideInRight 0.4s ease-in-out reverse';

        setTimeout(() => {
            notification.remove();

            // Jika tidak ada notifikasi tersisa, sembunyikan container
            const notificationList = document.querySelector('.notif-list');
            if (notificationList && notificationList.children.length === 0) {
                document.getElementById('notificationContainer').remove();
            }
        }, 300);
    }

    // Fungsi untuk menutup semua notifikasi
    function closeAllNotifications() {
        const container = document.getElementById('notificationContainer');
        container.style.animation = 'fadeIn 0.3s ease-in-out reverse';

        setTimeout(() => {
            container.remove();
        }, 250);
    }
</script>