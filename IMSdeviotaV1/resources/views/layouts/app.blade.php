<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        .topnav {
            background-color: #333;
            overflow: hidden;
        }

        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 12px 16px;
            text-decoration: none;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #04AA6D;
            color: white;
        }

        .container {
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="topnav">
        <a class="{{ request()->routeIs('barang.index') ? 'active' : '' }}" href="{{ route('barang.index') }}">Produk</a>
        <a class="{{ request()->routeIs('admin/peminjaman.index') ? 'active' : '' }}" href="{{ route('admin/peminjaman.index') }}">Riwayat Peminjaman</a>
        <a class="{{ request()->routeIs('admin/pengambilan.index') ? 'active' : '' }}" href="{{ route('admin/pengambilan.index') }}">Riwayat Pengambilan</a>
        <a class="{{ request()->routeIs('barang.notifikasi') ? 'active' : '' }}" href="{{ route('barang.notifikasi') }}">Notifikasi</a>
    </div>

    <!-- Content -->
    <div class="container">
        @yield('content')
    </div>

</body>
</html>
