<!DOCTYPE html>
<html lang="en">
<head>
    <!-- @vite(['resources/js/app.js']) -->
    <meta charset="UTF-8">
    <title>Form Kembalikan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
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

        .kotak-form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 15px;
            background-color: #f9f9f9;
            width: 500px;
            text-align: center;
            margin: 50px auto;
        }

        .popup-error {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffe0e0;
            color: #a33;
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.25);
            z-index: 1000;
            font-weight: 600;
            text-align: center;
            border: 1px solid #f5c2c2;
            animation: fadeIn 0.3s ease;
            max-width: 400px;
            width: 90%;
        }

        .popup-error p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .popup-error button {
            background-color: #a33;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
        }   

        /* Untuk Notifikasi */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            /* efek gelap */
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
</head>
<body>
    
    <!-- Header Pinjaman -->
    <div class="header">
        <h1>PINJAMAN</h1>
        <div class="button-group">
            <a href="{{ route('welcome') }}" class="btn-home">
                <img src="{{ asset('images/home.png') }}" alt="icon" class="btn-icon">

            </a>
            <a href="{{ route('welcome') }}" class="btn-back">Back</a>
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
    
    <!-- Untuk Handling error ketika Data tidak ditemukan -->
    @if ($errors->has('not_found'))
        <div class="overlay" id="popupOverlay"></div>
        <div class="popup-error" id="popupError">
            <p>{{ $errors->first('not_found') }}</p>
            <button onclick="closePopup()">Ok</button>
        </div>
    @endif

    <!-- List Barang yang dipinjam dan Form -->
    <form action="{{ route('peminjaman.kembalikanCek') }}" method="POST">
        @csrf
            <div class="container">
                    <div class="left">
                        <div class="kotak-form">
                            <h3>Masukkan NIM dan Nama</h3>
                        </div>
                    </div>

                <div class="right">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input type="text" name="nim" id="nim" placeholder="NIM" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_mahasiswa">Nama</label>
                            <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" placeholder="Nama" required>
                        </div>
                    </div>

                        <button type="submit" class="submit-btn">CARI DATA ANDA</button>
                    </form>

                </div>

            </div>
        </form>

        <!-- closePopup Notification -->
        <script>
            function closePopup() {
                const errorPopup = document.getElementById('popupError');
                const overlay = document.getElementById('popupOverlay');
                if (errorPopup) errorPopup.style.display = 'none';
                if (overlay) overlay.style.display = 'none';
            }

            // Auto-close setelah 5 detik
            setTimeout(() => {
                closePopup();
            }, 5000);
        </script>

</body>
</html>