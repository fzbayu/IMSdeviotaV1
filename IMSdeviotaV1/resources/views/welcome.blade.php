<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System Deviota</title>  
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="{{ asset('js/session-timer.js') }}" defer></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .header {
            background: linear-gradient(135deg, #1a0033, #4a0080);
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('/images/background.png');
            padding: 60px;
            color: white;
            text-align: center;
            position: relative;
            
        }
        
        .logo {
            position: absolute;
            left: 20px;
            top: 35%;
            transform: translateY(-50%);
            width: 120px;
            height: 120px;
        }
        
        .login-btn {
            position: absolute;
            right: 20px;
            top: 25%;
            transform: translateY(-50%);
            background-color: #6554C4;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
            display: flex;         
            align-items: center;         
            justify-content: center;     
            gap: 10px;
            text-decoration: none;
        }

        .login-btn .btn-icon {
            width: 20px; /* Kecilkan gambar sesuai kebutuhan */
            height: 20px; /* Sesuaikan ukuran */
            margin-right: 5px; /* Jarak antara gambar dan teks */
        }
        
        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .section-title {
            text-align: center;
            margin: 20px 0;
            font-weight: 700;
            color: #333;
        }
        
        .peraturan {
            background-color: #e5e5e5;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.20); /* bayangan tebal & ke bawah */
        }

        
        .peraturan ol {
            padding-left: 20px;
        }
        
        .peraturan li {
            margin-bottom: 15px;
            color: #333;
            line-height: 1.5;
        }
        
        .produk-container {
            display: flex;
            gap: 30px;
            overflow-x: auto;
            padding: 10px 10px 20px 10px;
            scroll-behavior: smooth;
            /* -ms-overflow-style: none;  untuk IE dan Edge */
            /* scrollbar-width: none;  */
        }
        
        .produk-container::-webkit-scrollbar {
            display: block; /* Awalnya none, ubah jadi block */
            height: 8px; /* Ini buat atur tebal scrollbarnya */
        }

        .produk-container::-webkit-scrollbar-thumb {
            background-color: #999; /* Warna scroll thumb */
            border-radius: 10px;
        }

        .produk-container::-webkit-scrollbar-track {
            background: #ddd; /* Warna background track scrollbar */
        }

        .produk-item {
            background-color: #e5e5e5;
            min-width: 250px; /* atau sesuai ukuran yang kamu mau */
            flex-shrink: 0;
            padding: 15px;
            border-radius: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.20);
            text-align: center;
        }
        
        .produk-image {
            width: 100%;
            height: 150px;
            object-fit: contain;
            padding: 10px;
            background-color: white;
        }
        
        .produk-stock {
            background-color: #7b2cbf;
            color: white;
            padding: 8px;
            border-radius: 20px;
        }
        
        .action-buttons {
            display: flex;
            gap: 30px;
            justify-content: center;
            margin: 20px 0;
            border-radius: 100px;
            text-decoration: none;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }
        
        .btn-green {
            background-color: #54C45F;
            color: white;
            padding: 18px 50px; 
            border-radius: 18px; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); 
            border: none; 
            cursor: pointer; 
            transition: all 0.3s ease;
            text-decoration: none; 
        }
        
        .footer {
            background-color: #ECECEC;
            padding: 40px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .footer-logo img {
            width: 40px;
            height: 40px;
        }
        
        .footer-logo span {
            font-weight: 700;
            font-size: 1.2rem;
            color: #333;
        }
        
        .footer-text {
            max-width: 900px;
            font-size: 1.0rem;
            color: #555;
            line-height: 1.5;
        }
        
        .contact-info {
            font-size: 0.9rem;
            color: #333;
        }
        
        .contact-us-btn {
            background-color: #6554C4;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .contact-us-btn .btn-icon {
            width: 20px; 
            height: 20px; 
            margin-right: 5px; 
        }

        .produk-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        /* Session Info Styles */
        .session-info {
            background-color: #e5e5f7;
            border: 1px solid #d1d1f0;
            border-radius: 10px;
            padding: 15px 20px;
            margin: 20px auto;
            max-width: 1500px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .session-details {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .user-info p {
            margin: 0;
            font-size: 14px;
        }
        
        .user-info .name {
            font-weight: 600;
            font-size: 16px;
        }
        
        .session-actions {
            display: flex;
            gap: 15px;
        }
        
        .timer-container {
            background-color: #f5f5ff;
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid #d1d1f0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .timer-icon {
            color: #6554C4;
        }
        
        #session-timer {
            font-weight: 600;
            color: #6554C4;
        }
        
        .logout-button {
            background-color: #ff5252;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .logout-button:hover {
            background-color: #ff3838;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img class="logo" src="{{ asset('images/logo.png') }}" alt="Logo">
        <h1>INVENTORY MANAGEMENT <br> SYSTEM DEVIOTA</h1>
        
        @if(session()->has('login_mahasiswa'))
            <!-- Jika sudah login, tampilkan username -->
            <a href="{{ route('logout') }}" class="login-btn">
                <img src="{{ asset('images/user.png') }}" alt="icon" class="btn-icon"> Logout
            </a>
        @else
            <!-- Jika belum login, tampilkan login -->
            <a href="{{ route('barang.index') }}" class="login-btn">
                <img src="{{ asset('images/user.png') }}" alt="icon" class="btn-icon"> Admin Dashboard
            </a>
        @endif
        
    </div>

    <!-- Session Info -->
    @if(session()->has('login_mahasiswa'))
        <div class="session-info">
            <div class="session-details">
                <div class="user-info">
                    <p class="name">{{ session('login_mahasiswa.nama') }}</p>
                    <p>NIM: {{ session('login_mahasiswa.nim') }}</p>
                    <p>Login: {{ \Carbon\Carbon::parse(session('login_mahasiswa.login_time'))->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <div class="session-actions">
                <div class="timer-container">
                    <span class="timer-icon">⏱️</span>
                    <span>Sesi berakhir dalam: <span id="session-timer">01:00</span></span>
                </div>
                <a href="{{ route('logout') }}" class="logout-button">Logout</a>
            </div>
        </div>
    @endif
            
        
    <!-- List Produk -->
    <div class="container">
        <h2 class="section-title">PRODUK</h2>
        <div class="produk-container">
            @foreach($barang->take(20) as $item)
                @if($item->stok > 0)
                    <div class="produk-item">
                        <p>{{ $item->nama_barang }}</p>
                        @if($item->foto->first())
                            <img class="produk-image" src="{{ asset('storage/' . $item->foto->first()->foto) }}" alt="{{ $item->nama_barang }}">
                        @else
                            <img class="produk-image" src="{{ asset('images/default.png') }}" alt="Default Image">
                        @endif
                        <div class="produk-stock">Stok : {{ $item->stok }}</div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Actions -->
        <div class="action-buttons">
            <a href="{{ route('peminjaman.kembalikanForm') }}" class="btn btn-green">
                Kembalikan Barang
            </a>
            <a href="{{ url('/listbarang2') }}" class="btn btn-green">
                <span>+</span> Ambil Barang
            </a>
            <a href="{{ url('/listbarang') }}" class="btn btn-green">
                <span>+</span> Pinjam Barang
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>
            <div class="footer-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <span>DEVIOTA</span>
            </div>
            <br>
            <p class="footer-text">We lead in Industry 4.0 technology, specializing in IoT, Big Data, Smart Systems, Machine Learning AI, Cloud Computing, and more. Committed to innovation, we deliver intelligent, customizable technology solutions tailored to our clients' unique needs.</p>
        </div>
        <div>
            <button class="contact-us-btn">
                <img src="images/phone.png" alt="icon" class="btn-icon">
                <a href="https://wa.me/6281322808849" target="_blank" class="contact-us-btn">
                    Contact Us
                </a>
            </button>
            <br>
            <div class="contact-info">
                <p><strong>Kontak</strong></p>
                <p>Admin : 0813-2280-8849</p><br>
                <p><strong>Lokasi</strong></p>
                <p>Jl. Zamrud XX No.195E, <br>
                    Ciwaruga, Kec. Parongpong, <br>
                    Kota Bandung, Jawa Barat 40559</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>