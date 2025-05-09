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

    form {
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
</style>


@extends('layouts.app')

@section('content')


<h2>TAMBAH PRODUK</h2>

<form action="{{ route('barang.add') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Nama Barang:</label>
    <input type="text" name="nama_barang" required>

    <div style="display: flex; align-items: flex-end; gap: 10px;">
        <div style="flex-grow: 1;">
            <label>Kategori:</label>
            <select name="id_kategori" id="kategori-select" required>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <button type="button" id="tambah-kategori-btn" style="background: #7B1FA2; color: white; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 20px; cursor: pointer; margin-bottom: 8px;">+</button>
    </div>

    <label>Stok:</label>
    <input type="number" name="stok" required>

    <label>Lokasi:</label>
    <input type="text" name="lokasi">

    <label>Deskripsi:</label>
    <textarea name="deskripsi"></textarea>

    <label>Tipe:</label>
    <select name="tipe">
        <option value="Barang Dipinjam">Barang Dipinjam</option>
        <option value="Barang Diambil">Barang Diambil</option>
    </select>

    <label>Stok Minimum:</label>
    <input type="number" name="stok_minimum">

    <label>Harga:</label>
    <input type="number" step="0.01" name="harga" required>

    <label>Foto Barang:</label>
    <div id="drop-area">
        <p>SELECT OR DROP PICTURES HERE</p>
        <input type="file" id="fileElem" name="foto[]" accept="image/*" multiple>
    </div>
    <div id="preview"></div>

    <button type="submit">Tambah Barang</button>
</form>

<div id="kategori-modal">
    <div id="kategori-modal-content">
        <span id="close-modal">&times;</span>
        <h3>Tambah Kategori Baru</h3>
        
        <!-- Form untuk tambah kategori -->
        <form action="{{ route('barang.tambahKategori') }}" method="POST" class="form-modal">
            @csrf
            <label>Nama Kategori:</label>
            <input type="text" name="nama_kategori" required>

            <input type="hidden" name="redirect" value="formTambah">

            <button type="submit">Simpan Kategori</button>
            <!-- Tombol Batal -->
            <button type="button" id="batal-btn" style="background: #ccc; color: black; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">Batal</button>
        </form>
    </div>
</div>


@endsection
<script src="{{ asset('js/tambah.js') }}"></script>