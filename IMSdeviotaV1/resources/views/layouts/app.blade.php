<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .topnav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: linear-gradient(to bottom, #6554C4, #FFFFFF);
            color: white;
            width: 100%;
            box-sizing: border-box;
            flex-wrap: wrap;
            gap: 15px;
            position: relative;
        }

        .topnav>* {
            flex-shrink: 0;
            /* Prevent items from shrinking too much */
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            font-size: 23px;
            color: white;
            text-decoration: none;
            flex-shrink: 0;
        }


        .topnav .logo {
            font-weight: bold;
            font-size: 23px;
            color: white;
            text-decoration: none;
            line-height: 1.2;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .topnav a {
            display: flex;
            align-items: center;
            margin-right: 40px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 10px;
            transition: background 0.3s;
        }

        .topnav a i {
            margin-right: 8px;
        }

        .topnav a.active,
        .topnav a:hover {
            background-color: rgba(101, 84, 196, 0.3);
            color: white;
        }

        .nav-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
            flex-grow: 1;
            justify-content: space-between;
        }

        .topnav .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            margin-right: auto;
            /* Push other elements to the right */
        }

        /* Add a style for the new button */
        .btn-dashboard {
            margin-left: auto;
            display: inline-block;
            background-color: #6a0dad;
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn-dashboard:hover {
            background-color: rgba(101, 84, 196, 0.3);
        }

        .notif {
            margin-left: 20px;
            position: relative;
        }

        .notif i {
            font-size: 20px;
            color: white;
        }

        .notif .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: red;
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 50%;
            min-width: 15px;
            height: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notif a {
            position: relative;
            display: inline-block;
        }

        /* .form-logout {
            margin-left: 20px;
            margin-top: 13px;
        } */

        .btn-logout {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 16px;
            line-height: 1.2;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s ease;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        /* Right-aligned items container */
        .right-items {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        /* Logout button specific styles */
        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 16px;
            line-height: 1.2;
            cursor: pointer;
            transition: background 0.3s;
            white-space: nowrap;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .logout-btn i {
            margin-right: 8px;
        }

        /* Media queries for responsive adjustments */
        @media (max-width: 1200px) {
            .topnav {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .topnav {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                padding: 15px;
            }

            .nav-links,
            .right-items {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>

<body>

    <div class="topnav">
        <a href="/adminDashboard" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 100px;">
            <div>
                ADMIN<br>DASHBOARD
            </div>
        </a>

        <div class="nav-links">
            <a class="{{ request()->routeIs('barang.index') ? 'active' : '' }}" href="{{ route('barang.index') }}">
                <i class="fas fa-box-open"></i> Produk
            </a>
            <a class="{{ request()->routeIs('admin/peminjaman.index') ? 'active' : '' }}" href="{{ route('admin/peminjaman.index') }}">
                <i class="fas fa-shopping-bag"></i> Riwayat Peminjaman
            </a>
            <a class="{{ request()->routeIs('admin/pengambilan.index') ? 'active' : '' }}" href="{{ route('admin/pengambilan.index') }}">
                <i class="fas fa-archive"></i> Riwayat Pengambilan
            </a>
        </div>

        <!-- Right-aligned items -->
        <div class="right-items">
            <a href="{{ url('/welcome') }}" class="btn-dashboard">
                Dashboard Utama
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submitt" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>

            <div class="notif">
                <a class="{{ request()->routeIs('barang.notifikasi') ? 'active' : '' }}" href="{{ route('barang.notifikasi') }}">
                    <i class="fas fa-bell"></i>
                    <span class="badge">
                        @php
                        if (!isset($barang_notif)) {
                        $barang_notif = App\Models\Barang::whereColumn('stok', '<=', 'stok_minimum' )->get();
                            }
                            echo $barang_notif->count();
                            @endphp
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>

</body>

</html>