<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <title>Pinjaman</title>
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
        .content {
            display: flex;
            padding: 20px;
            gap: 40px;
        }
        .left, .right {
            flex: 1;
        }

        .item-card {
            background: #eee;
            padding: 20px;
            margin: 0 auto 25px auto;
            border-radius: 15px;
            display: flex;
            align-items: center;         /* vertikal tengah */
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            max-width: 700px;
            width: 100%;
            gap: 20px;
        }

        .item-card img {
            max-width: 100px;
            border-radius: 10px;
        }

        .item-info {
            display: flex;
            flex-direction: column;
            align-items: center;         /* horizontal tengah */
            justify-content: center;     /* vertikal tengah */
            text-align: center;
            flex: 1;
            gap: 10px;
        }

        .item-info h4 {
            margin: 0 0 8px 0;
            font-size: 16px;
        }   
        .btn-kembalikan {
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 8px 16px;
            cursor: pointer;
            margin-left: 20px;
            font-weight: bold;
        }
        .btn-kembalikan-semua{
            background: #65558F;
            color: white;
            padding: 15px;
            border-radius: 30px;
            border: none;
            width: 100%;
            cursor: pointer;
        }
        .right input {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .stok-btn {
            background-color: #6554C4;
            color: white;
            padding: 8px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
            width: 200px;
            height: 45px;
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

     
    <div class="content">
        <div class="left">
            @foreach($peminjaman as $pinjam)
            <div class="item-card">
                <img src="{{ asset('storage/' . optional($pinjam->barang)->gambar) }}" alt="{{ optional($pinjam->barang)->nama_barang }}" width="80">
                
                <div class="item-info">
                    <h4>{{ optional($pinjam->barang)->nama_barang ?? 'Barang sudah dihapus' }}</h4>
                    <div class=stok-btn >Dipinjam: <strong>{{ $pinjam->jumlah }}</strong> item</div>

                    <form action="{{ route('peminjaman.kembalikanProses', $pinjam->id_peminjaman) }}" method="POST" style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
                        @csrf
                        <input type="number" 
                            name="jumlah_kembalikan" 
                            min="1" 
                            max="{{ $pinjam->jumlah }}" 
                            value="1"
                            style="width: 60px; padding: 5px; text-align: center; border-radius: 6px; border: 1px solid #ccc;">

                        <button type="submit" class="btn-kembalikan">Kembalikan</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="right">
            <h1 style="color:#65558F"> TOTAL : <span>{{ $peminjaman->sum('jumlah') }} ITEM</span></h1><br>
            <label for="nim">NIM</label>
            <input type="text" id="nim" value="{{ $mahasiswa->nim ?? '' }}" readonly>

            <label for="nama">Nama</label>
            <input type="text" id="nama" value="{{ $mahasiswa->nama_mahasiswa ?? '' }}" readonly>
            
            @if($peminjaman->where('status', 'Dipinjam')->count() > 0)
                <form action="{{ route('peminjaman.kembalikanSemuaBarang') }}" method="POST" id="formKembalikanSemua">
                    @csrf
                    <input type="hidden" name="id_mahasiswa" value="{{ $mahasiswa->id_mahasiswa }}">
                    
                    <button type="submit" class="btn-kembalikan-semua"
                        onclick="return confirm('Yakin ingin mengembalikan semua barang?')">
                        Kembalikan Semua
                </form>
            @endif
        </div>   
    </div>

</body>
</html>
