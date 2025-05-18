<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pinjaman</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <style>
        /* Reset & Font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Header */
        .header {
            background: linear-gradient(to bottom, #6554C4, rgb(233, 216, 255));
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-back,
        .btn-home {
            background-color: #6554C4;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 15px;
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .btn-home .btn-icon {
            width: 21px;
            height: 21px;
        }

        .button-group {
            display: flex;
            gap: 10px;
        }

        .content {
            display: flex;
            padding: 20px;
            gap: 40px;
        }

        .left,
        .right {
            flex: 1;
        }

        .item-card {
            background: #eee;
            padding: 20px;
            margin: 0 auto 25px auto;
            border-radius: 15px;
            display: flex;
            align-items: center;
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
            align-items: center;
            justify-content: center;
            text-align: center;
            flex: 1;
            gap: 10px;
        }

        .item-info h4 {
            font-size: 16px;
        }

        .btn-kembalikan {
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 8px 16px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-kembalikan-semua,
        .btn-kembali-home {
            background: #65558F;
            color: white;
            padding: 15px;
            border-radius: 30px;
            border: none;
            width: 100%;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
        }

        .btn-kembali-home {
            display: inline-block;
            text-decoration: none;
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

        /* Notifikasi */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
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

        .popup-detail-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease-in-out;
        }

        .popup-detail-box {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            text-align: center;
            width: 90%;
            max-width: 420px;
            animation: slideUp 0.4s ease;
            border: 2px solid #6554C4;
        }

        .popup-detail-box h2 {
            color: #4B3BA4;
            margin-bottom: 20px;
            font-size: 22px;
        }

        .popup-content {
            margin-bottom: 25px;
            text-align: left;
        }

        .popup-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .popup-row .label {
            font-weight: 600;
            color: #333;
        }

        .popup-row .value {
            color: #555;
        }

        .btn-close-popup {
            background: #6554C4;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s;
        }

        .btn-close-popup:hover {
            background: #4a3b9f;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(40px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .late-notice {
            background-color: #ffe6e6;
            color: #b30000;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .late-button {
            position: relative;
            border: 2px solid #e74c3c !important;
            color: #e74c3c !important;
        }

        /* Tambahkan di bagian style */
        .preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .preview-container img {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            background: #f8f9fa;
        }

        .text-muted {
            color: #6c757d;
            font-size: 0.875em;
        }

        /* Responsive form */
        @media (max-width: 768px) {
            .form-kembalikan-sebagian {
                flex-direction: column;
            }

            .form-kembalikan-sebagian>div {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h1>PINJAMAN</h1>
        <div class="button-group">
            <a href="{{ route('welcome') }}" class="btn-home">
                <img src="{{ asset('images/home.png') }}" alt="icon" class="btn-icon">
            </a>
            <a href="{{ route('welcome') }}" class="btn-back">Back</a>
        </div>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
    <div class="overlay" id="popupOverlay"></div>
    <div class="popup-success" id="popupSuccess">
        <p>{{ session('success') }} ✅</p>
        <button onclick="closeSuccess()">OK</button>
    </div>
    @endif

    @if(session()->has('login_mahasiswa'))
    <meta name="session-start-id" content="{{ session('login_mahasiswa.php_session_id') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div style="display: none;">
        <span id="session-timer">01:00</span>
    </div>
    @endif

    <!-- TOGGLE MODE -->
    <div style="margin: 20px 45px; display: flex; gap: 10px; justify-content: center;">
        <button id="modeSingle" style="padding: 10px 16px; border: none; border-radius: 5px; background-color: #6a0dad; color: white; font-weight: bold; cursor: pointer; margin-right: 550px;">
            Mode: Kembalikan Satu per Satu
        </button>
        <button id="modeAll" style="padding: 10px 16px; border: none; border-radius: 5px; background-color: #ccc; color: black; font-weight: bold; cursor: pointer;">
            Mode: Kembalikan Semua
        </button>
    </div>

    <div class="content">
        <!-- Kiri -->
        <div class="left">
            @if($peminjaman->isEmpty())
            <div style="padding: 20px; background-color: #ffe6e6; border: 1px solid #ff4d4d; border-radius: 8px; margin-bottom: 20px; text-align:center; color: #d8000c;">
                <strong>Tidak ada peminjaman saat ini.</strong>
            </div>
            @else
            @foreach($peminjaman as $pinjam)
            @php $barang = $pinjam->barang; @endphp

            <div class="item-card">
                {{-- Gambar Barang --}}
                @if($barang && $barang->foto->count() > 0)
                <img class="produk-image" src="{{ asset('storage/' . $barang->foto->first()->foto) }}" width="100">
                @else
                <img class="produk-image" src="{{ asset('images/no-image.png') }}" width="100">
                @endif

                <div class="item-info">
                    <h4>{{ $barang->nama_barang ?? 'Barang sudah dihapus' }}</h4>

                    {{-- Baris 1: Dipinjam dan Lihat Detail --}}
                    @php
                    $isLate = $pinjam->tanggal_pengembalian
                    ? \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($pinjam->tanggal_pengembalian))
                    : false;
                    @endphp
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 123px; margin-top: 5px;">
                        <div class="stok-btn">
                            Dipinjam: <strong>{{ $pinjam->jumlah }}</strong> item
                        </div>
                        <button
                            class="btn-kembalikan {{ $isLate ? 'late-button' : '' }}"
                            onclick="showDetailPopup(
                '{{ $barang->nama_barang ?? 'Barang sudah dihapus' }}',
                '{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}',
                '{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}',
                '{{ $pinjam->jumlah }}',
                {{ $isLate ? 'true' : 'false' }}
            )">
                            @if($isLate)
                            ❗
                            @endif
                            Lihat Detail
                        </button>
                    </div>

                    {{-- Baris 2: Kembalikan dan Upload Bukti --}}
                    <form
                        action="{{ route('peminjaman.kembalikanProses', $pinjam->id_peminjaman) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="form-single"
                        style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                        @csrf

                        <input
                            type="number"
                            name="jumlah_kembalikan"
                            min="1"
                            max="{{ $pinjam->jumlah }}"
                            value="1"
                            style="width: 60px;">

                        <input
                            type="file"
                            name="foto_pengembalian[]"
                            id="foto_pengembalian_{{ $pinjam->id_peminjaman }}"
                            multiple
                            accept="image/*"
                            required>

                        <button type="submit" class="btn-kembalikan">Kembalikan</button>

                        <div class="preview-container" style="margin-top: 10px;"></div>
                    </form>
                </div>
            </div>
            @endforeach
            @endif
        </div>


        <!-- Kanan -->
        <div class="right">
            <h1 style="color:#65558F">TOTAL: <span>{{ $peminjaman->sum('jumlah') }} ITEM</span></h1><br>

            <label>NIM</label>
            <input type="text" value="{{ $mahasiswa->nim }}" readonly>

            <label>Nama</label>
            <input type="text" value="{{ $mahasiswa->nama_mahasiswa }}" readonly>

            @php
            $masihDipinjam = $peminjaman->where('status', '!=', 'Dikembalikan')->count();
            @endphp

            @if($masihDipinjam > 0)
            <form action="{{ route('peminjaman.kembalikanSemuaBarang') }}" method="POST" enctype="multipart/form-data" id="formKembalikanSemua" class="form-all">
                @csrf
                <label for="foto_pengembalian">Bukti Foto Pengembalian:</label><br>
                <input type="file" name="foto_pengembalian[]" id="foto_pengembalian_global" multiple accept="image/*" required>
                <small class="text-muted">Maksimal 500KB per foto. Bisa upload multiple foto.</small>
                <div id="preview-container" style="margin-top: 10px;"></div>
                <br><br>

                <input type="hidden" name="id_mahasiswa" value="{{ $mahasiswa->id_mahasiswa }}">
                <button type="button" onclick="confirmKembalikanSemua()" class="btn-kembalikan-semua">
                    Kembalikan Semua
                </button>
            </form>
            @else
            <a href="{{ route('welcome') }}" class="btn-kembali-home">
                Kembali ke Home
            </a>
            @endif
        </div>
    </div>

    <!-- POPUP DETAIL -->
    <div id="popupDetail" class="popup-detail-overlay" style="display: none;">
        <div class="popup-detail-box">
            <h2 id="popupTitle">Detail Barang</h2>
            <div class="popup-content">
                <div class="popup-row">
                    <span class="label">📅 Tanggal Pinjam:</span>
                    <span id="popupTanggalPinjam" class="value"></span>
                </div>
                <div class="popup-row">
                    <span class="label">📆 Tanggal Kembali:</span>
                    <span id="popupTanggalKembali" class="value"></span>
                </div>
                <div class="popup-row">
                    <span class="label">📦 Jumlah Dipinjam:</span>
                    <span id="popupJumlah" class="value"></span>
                </div>
                <div id="popupLateNotice" class="late-notice" style="display: none;">
                    ⚠ <strong>Telat mengembalikan barang!</strong>
                </div>

            </div>
            <button class="btn-close-popup" onclick="closeDetailPopup()">Tutup</button>
        </div>
    </div>

    <!-- Script untuk fungsi closeSuccess -->
    <script>
        function closeSuccess() {
            // Redirect ke halaman welcome saat tombol OK ditekan
            window.location.href = "{{ route('welcome') }}";
        }

        // untuk pop up detail
        function showDetailPopup(namaBarang, tanggalPinjam, tanggalKembali, jumlah, isLate) {
            document.getElementById('popupTitle').innerText = namaBarang;
            document.getElementById('popupTanggalPinjam').innerText = tanggalPinjam;
            document.getElementById('popupTanggalKembali').innerText = tanggalKembali;
            document.getElementById('popupJumlah').innerText = jumlah;

            const lateNotice = document.getElementById('popupLateNotice');
            if (isLate) {
                lateNotice.style.display = 'block';
            } else {
                lateNotice.style.display = 'none';
            }

            document.getElementById('popupDetail').style.display = 'flex';
        }

        function closeDetailPopup() {
            document.getElementById('popupDetail').style.display = 'none';
        }

        // untuk foto
        document.querySelectorAll('.form-kembalikan-sebagian').forEach(form => {
            form.addEventListener('submit', function(e) {
                const globalFileInput = document.getElementById('foto_pengembalian_global');
                if (globalFileInput && globalFileInput.files.length > 0) {
                    // Buat input file baru dalam form ini
                    const clonedInput = document.createElement('input');
                    clonedInput.type = 'file';
                    clonedInput.name = 'foto_pengembalian';
                    clonedInput.files = globalFileInput.files; // penting: set FileList
                    clonedInput.style.display = 'none';
                    form.appendChild(clonedInput);
                }
            });
        });

        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const previewContainer = this.closest('form').querySelector('.preview-container') ||
                    document.getElementById('preview-container');
                previewContainer.innerHTML = '';

                if (this.files.length > 0) {
                    Array.from(this.files).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.style.maxWidth = '100px';
                                img.style.maxHeight = '100px';
                                img.style.margin = '5px';
                                previewContainer.appendChild(img);
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                }
            });
        });

        // Konfirmasi pengembalian semua
        function confirmKembalikanSemua() {
            if (confirm('Yakin ingin mengembalikan semua barang?')) {
                document.getElementById('formKembalikanSemua').submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modeSingleBtn = document.getElementById('modeSingle');
            const modeAllBtn = document.getElementById('modeAll');

            const singleForm = document.querySelectorAll('.form-single');
            const allForm = document.querySelectorAll('.form-all');

            function setMode(mode) {
                if (mode === 'single') {
                    modeSingleBtn.style.backgroundColor = '#6a0dad';
                    modeSingleBtn.style.color = 'white';
                    modeAllBtn.style.backgroundColor = '#ccc';
                    modeAllBtn.style.color = 'black';

                    // Enable single form, disable all form
                    singleForm.forEach(f => f.querySelectorAll('input, button, select').forEach(el => el.disabled = false));
                    allForm.forEach(f => f.querySelectorAll('input, button, select').forEach(el => el.disabled = true));
                } else {
                    modeAllBtn.style.backgroundColor = '#6a0dad';
                    modeAllBtn.style.color = 'white';
                    modeSingleBtn.style.backgroundColor = '#ccc';
                    modeSingleBtn.style.color = 'black';

                    // Enable all form, disable single form
                    singleForm.forEach(f => f.querySelectorAll('input, button, select').forEach(el => el.disabled = true));
                    allForm.forEach(f => f.querySelectorAll('input, button, select').forEach(el => el.disabled = false));
                }
            }

            // Default mode: single
            setMode('single');

            modeSingleBtn.addEventListener('click', () => setMode('single'));
            modeAllBtn.addEventListener('click', () => setMode('all'));
        });
    </script>

    <script src="{{ asset('js/session-timer.js') }}" defer></script>
</body>

</html>