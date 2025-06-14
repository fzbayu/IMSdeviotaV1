<!DOCTYPE html>
<html lang="en">
<head>
@vite(['resources/css/listbarang.css', 'resources/js/listbarang.js'])
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/session-timer.js') }}" defer></script>
    <style>

        /* Semua */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Header */
        .header {
            background: linear-gradient(to bottom, #6554C4,rgb(233, 216, 255));
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Button */
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
            width: 21px; 
            height: 21px; 
        }
        
        .btn-trash {
            max-width: 30px;      
            max-height: 30px;     
            object-fit: contain;  
            cursor: pointer;      
            padding-right: 10px;
        }

        .button-group {
            display: flex;
            gap: 10px; /* jarak antar tombol */
        }
        .container {
            display: flex;
            padding: 20px;
            gap: 40px;
        }

        .left, .right {
            flex: 1;
        }

        .item-card {
            background: #eee;
            padding: 12px;
            margin: 0 auto 25px auto;   /* auto kiri-kanan agar center */
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            max-width: 700px;           
            width: 100%;                
        }

        .item-card img {
            width: 100%;
            max-width: 100px;
            height: auto;
        }

        .item-info {
            flex: 1;
            display: flex;
            flex-direction: column;    
            align-items: center;       
            justify-content: center;   
            text-align: center;        
            gap: 10px;                 
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
            width: 200px;
            height: 45px;
        }

        .counter button {
            background: transparent;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            margin: 0 15px;
        }

        .delete-icon {
            cursor: pointer;
            font-size: 18px;
            color: #444;
        }

        .right input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 15px;
            width: 100%;
            margin-bottom: 15px;
        }

        .right .form-row {
            display: flex;
            gap: 10px;
        }

        .form-row {
            display: flex;
            gap: 10px;
        }

        .form-group {
            flex: 1; /* biar kolom seimbang */
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
        }

        .form-group input {
            padding: 8px;
            border-radius: 15px;
            border: 1px solid #ccc;
        }

        .submit-btn {
            background: #65558F;
            color: white;
            padding: 15px;
            border-radius: 30px;
            border: none;
            width: 100%;
            cursor: pointer;
            margin: 20px 0;
        }

        .accordion {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            background: white;
        }

        .accordion summary {
            cursor: pointer;
        }

        /* Untuk Notifikasi */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5); /* efek gelap */
            z-index: 999;
        }

        .popup-success {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f0fff4;
            color: #2e7d32;
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            text-align: center;
            font-weight: bold;
            animation: fadeIn 0.3s ease;
        }

        .popup-success button {
            margin-top: 20px;
            padding: 10px 24px;
            border: none;
            background-color: #6554C4;
            color: white;
            border-radius: 15px;
            cursor: pointer;
            font-size: 16px;
        }

    </style>

    <!-- Buat Total Items -->
    <?php
        $totalItems = 0;
        foreach ($barangWithQty as $item) {
            $totalItems += $item['jumlah']; 
        }
    ?>
</head>
<body>
    
    <!-- Header Keranjang -->
    <div class="header">
        <h1>KERANJANG</h1>
        <div class="button-group">
            <a href="{{ route('welcome') }}" class="btn-home">
                <img src="images/home.png" alt="icon" class="btn-icon">
            </a>
            <a href="{{ route('listbarang') }}" class="btn-back">Back</a>
        </div>
    </div>

    <!-- Notifikasi Sukses -->
    @if (session('success'))
    <div class="overlay" id="popupOverlay"></div>
        <div class="popup-success" id="popupSuccess">
            <p>{{ session('success') }} ✅</p>
            <button onclick="closeSuccess()">Ok</button>
        </div>

    <script>
        function closeSuccess() {
            const popup = document.getElementById('popupSuccess');
            const overlay = document.getElementById('popupOverlay');
            if (popup) popup.style.display = 'none';
            if (overlay) overlay.style.display = 'none';
            
            // Redirect to home after closing the popup
            window.location.href = "{{ route('welcome') }}";
        }

        // Tutup popup setelah 3 detik, lalu redirect ke home
        setTimeout(() => {
            closeSuccess();
        }, 10000); // 10 detik
    </script>
    @endif

    @if (session('error'))
        <div class="overlay" id="popupOverlay"></div>
        <div class="popup-success" id="popupError" style="background-color: #fff4f4; color: #d32f2f;">
            <p>{{ session('error') }} ❌</p>
            <button onclick="closeError()">Ok</button>
        </div>

        <script>
            function closeError() {
                const popup = document.getElementById('popupError');
                const overlay = document.getElementById('popupOverlay');
                if (popup) popup.style.display = 'none';
                if (overlay) overlay.style.display = 'none';
            }
        </script>
    @endif

    @if(session()->has('login_mahasiswa'))
        <meta name="session-start-id" content="{{ session('login_mahasiswa.php_session_id') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div style="display: none;">
            <span id="session-timer">01:00</span>
        </div>
    @endif

    <form action="{{ route('submit.peminjaman') }}" method="POST">
        @csrf
        <div class="container">
            <div class="left">
                @foreach ($barangWithQty as $item)
                    @php $barang = $item['barang']; @endphp
                    <div class="item-card">
                        @if($barang->foto->count() > 0)
                            <img class="produk-image" src="{{ asset('storage/' . $barang->foto->first()->foto) }}" width="100">
                        @else
                            <img class="produk-image" src="{{ asset('images/no-image.png') }}" width="100">
                        @endif

                        <div class="item-info">
                            {{ $barang->nama_barang }}
                            <div class="counter" style="display: flex; align-items: center; gap: 8px;">
                                <strong><span>{{ $item['jumlah'] }}</span></strong>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="right">
                <h1 style="color:#65558F">TOTAL : <span>{{ $totalItems }} ITEM</span></h1><br>     
                <div class="form-row">
                    <div class="form-group">
                        <label for="kontak">Kontak</label>
                        <input type="text" name="kontak" id="kontak" placeholder="Kontak" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_kembali">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali" required>
                    </div>
                </div>
                    <button type="submit" class="submit-btn">PINJAM BARANG</button>

                <details class="accordion">
                    <summary>Syarat & Ketentuan</summary>
                    <p>Awas kalo ilang, kalo ilang denda 1 miliar, silahkan ambil sendiri!</p>
                </details>
            </div>
        </div>
    </form>


</body>
</html>


