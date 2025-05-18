<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #ffffff;
        margin: 0;
        padding: 0;
    }

    h2 {
        color: #7B1FA2;
        font-size: 3rem;
        font-weight: 800;
        margin: 30px auto 20px auto;
        text-align: center;
    }

    .form-tambah-produk {
        background: #fff;
        padding: 30px 60px;
        border-radius: 10px;
        max-width: 1100px;
        width: 95%;
        margin: 30px auto;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
    }

    label {
        display: block;
        margin-top: 15px;
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }

    input[type="text"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        padding: 12px 15px;
        margin-top: 8px;
        border-radius: 10px;
        border: 1px solid #ddd;
        font-size: 14px;
        box-sizing: border-box;
    }

    textarea {
        resize: vertical;
        min-height: 80px;
    }

    button[type="submit"] {
        margin-top: 30px;
        background: #7e22ce;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        display: block;
        width: 100%;
        transition: background 0.3s;
    }

    button[type="submit"]:hover {
        background: #5e17a7;
    }

    select:focus,
    input:focus,
    textarea:focus {
        border-color: #7e22ce;
        outline: none;
    }

    /* Drag & Drop Area */
    #drop-area {
        border: 2px dashed #ccc;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        color: #aaa;
        margin-top: 10px;
        background: #f8f8f8;
        cursor: pointer;
    }

    #drop-area.hover {
        border-color: #7e22ce;
        background: #f3e8ff;
        color: #7e22ce;
    }

    #drop-area input[type="file"] {
        display: none;
    }

    #preview {
        display: flex;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    #preview img {
        max-width: 150px;
        margin: 10px 10px 0 0;
        border-radius: 10px;
    }

    .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 5px;
        border-radius: 50%;
        cursor: pointer;
    }

    #kategori-modal {
        display: none; /* Modal tersembunyi secara default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Latar belakang semi transparan */
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    #kategori-modal span#close-modal {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }

    #kategori-modal h3 {
        color: white;
    }

    #kategori-modal form {
        background: white;
        padding: 20px;
        border-radius: 10px;
        max-width: 400px;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    #kategori-modal input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    #kategori-modal button[type="submit"] {
        background-color: #7B1FA2;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    #kategori-modal button#batal-btn {
        background-color: #ccc;
        color: black;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #kategori-modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.3s ease;
    }

    #kategori-modal h3 {
        color: #7B1FA2;
        margin-top: 0;
        font-weight: bold;
    }

    #close-modal {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    #close-modal:hover {
        color: #333;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-modal input[type="text"] {
        padding: 12px 15px;
        margin: 10px 0;
        border-radius: 10px;
        border: 1px solid #ddd;
        font-size: 14px;
        width: 100%;
        box-sizing: border-box;
    }

    .form-modal button {
        margin-top: 20px;
        background: #7e22ce;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
    }

    .form-modal button:hover {
        background: #5e17a7;
    }
    
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }
    
    .popup-success, .popup-error {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        border-radius: 8px;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
        min-width: 300px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .popup-success {
        background-color: #e8f5e9;
        border: 1px solid #4caf50;
        color: #2e7d32;
        display: none;
    }
    
    .popup-error {
        background-color: #ffebee;
        border: 1px solid #f44336;
        color: #c62828;
        display: none;
    }
    
    .popup-visible {
        opacity: 1;
        display: block;
    }
    
    .popup-success button, .popup-error button {
        background-color: #2196f3;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }
    
    .popup-success button:hover, .popup-error button:hover {
        background-color: #0d8bf2;
    }

</style>

@extends('layouts.app')

@section('content')

<!-- Notifikasi Sukses -->
@if (session('success'))
<div class="overlay" id="popupOverlay"></div>
<div class="popup-success" id="popupSuccess">
    <p>{{ session('success') }} ✅</p>
    <button onclick="closeSuccess()">Ok</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popup = document.getElementById('popupSuccess');
        const overlay = document.getElementById('popupOverlay');
        
        // Show popup and overlay
        if (popup) {
            overlay.style.display = 'block';
            popup.style.display = 'block';
            
            // Small delay to ensure display is applied before adding visible class
            setTimeout(() => {
                popup.classList.add('popup-visible');
            }, 10);
        }
    });

    function closeSuccess() {
        const popup = document.getElementById('popupSuccess');
        const overlay = document.getElementById('popupOverlay');
        
        // Fade out
        if (popup) popup.classList.remove('popup-visible');
        
        // Allow time for fade animation before hiding
        setTimeout(() => {
            if (popup) popup.style.display = 'none';
            if (overlay) overlay.style.display = 'none';
        }, 300);
    }

    // Auto-close after 5 seconds
    setTimeout(() => {
        closeSuccess();
    }, 5000);
</script>
@endif

@if ($errors->any())
<div class="overlay" id="popupOverlay"></div>
<div class="popup-error" id="popupError">
    <p>{{ $errors->first() }}</p>
    <button onclick="closePopup()">Ok</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorPopup = document.getElementById('popupError');
        const overlay = document.getElementById('popupOverlay');
        
        // Show popup and overlay
        if (errorPopup) {
            overlay.style.display = 'block';
            errorPopup.style.display = 'block';
            
            // Small delay to ensure display is applied before adding visible class
            setTimeout(() => {
                errorPopup.classList.add('popup-visible');
            }, 10);
        }
    });

    function closePopup() {
        const errorPopup = document.getElementById('popupError');
        const overlay = document.getElementById('popupOverlay');
        
        // Fade out
        if (errorPopup) errorPopup.classList.remove('popup-visible');
        
        // Allow time for fade animation before hiding
        setTimeout(() => {
            if (errorPopup) errorPopup.style.display = 'none';
            if (overlay) overlay.style.display = 'none';
        }, 300);
    }

    // Auto-close after 5 seconds
    setTimeout(() => {
        closePopup();
    }, 5000);
</script>
@endif

<h2>Edit Barang</h2>

<form action="{{ route('barang.update', $barang->id_barang) }}" method="POST" enctype="multipart/form-data" class="form-tambah-produk">
    @csrf
    @method('PUT')

    <label>Nama Barang:</label>
    <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" required><br>

    <label>Kategori:</label>
    <select name="id_kategori" required>
        @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id_kategori }}" 
                {{ $barang->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select><br>

    <label>Stok:</label>
    <input type="number" name="stok" value="{{ $barang->stok }}" required><br>

    <label>Lokasi:</label>
    <input type="text" name="lokasi" value="{{ $barang->lokasi }}"><br>

    <label>Deskripsi:</label>
    <textarea name="deskripsi">{{ $barang->deskripsi }}</textarea><br>

    <label>Tipe:</label>
    <select name="tipe" required>
        <option value="Barang Dipinjam" {{ $barang->tipe == 'Barang Dipinjam' ? 'selected' : '' }}>Barang Dipinjam</option>
        <option value="Barang Diambil" {{ $barang->tipe == 'Barang Diambil' ? 'selected' : '' }}>Barang Diambil</option>
    </select><br>

    <label>Stok Minimum:</label>
    <input type="number" name="stok_minimum" value="{{ $barang->stok_minimum }}"><br>

    <label>Harga:</label>
    <input type="number" name="harga" value="{{ $barang->harga }}" required><br>

    <!-- Foto Lama -->
    @if($barang->foto->count() > 0)
        <div>
            <h3>Foto Produk Saat Ini:</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                @foreach($barang->foto as $foto)
                    <div style="position: relative; width: 150px; margin-bottom: 15px;">
                        <img src="{{ asset('storage/' . $foto->foto) }}" style="width: 100%; height: auto;">
                        <div>
                            <input type="checkbox" name="hapus_foto[]" value="{{ $foto->id_foto }}"> Hapus
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p>Belum ada foto untuk produk ini.</p>
    @endif

    <!-- Upload Baru (opsional) -->
    <label>Foto Barang:</label>
    <div id="drop-area">
        <p>SELECT OR DROP PICTURES HERE (MAX 500 Kb)</p>
        <input type="file" id="fileElem" name="foto[]" accept="image/*" multiple>
    </div>

    <div id="preview"></div>



    <button type="submit" style="margin-top: 20px;">Simpan Perubahan</button>
</form>

@endsection

<script src="{{ asset('js/edit.js') }}"></script>
