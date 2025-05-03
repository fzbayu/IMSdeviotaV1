<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengambilanController;
use App\Http\Controllers\AdminController;
use App\Models\Barang;

// DASHBOARD
Route::get('/', function () {
    $barang = Barang::with('kategori', 'foto')->get();
    return view('welcome', compact('barang'));
})->name('welcome');

Route::get('/dbconn', function () {
    return view('dbconn');
});

// ADMIN-PAGE
Route::get('/adminDashboard', [BarangController::class, 'index'])->name('barang.index');
Route::get('/adminDashboard_formTambah', [BarangController::class, 'formTambah'])->name('barang.formTambah');
Route::post('/adminDashboard', [BarangController::class, 'add'])->name('barang.add');
Route::get('/adminDashboard/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/adminDashboard/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/adminDashboard/{id}', [BarangController::class, 'delete'])->name('barang.delete');
Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/admin/notifikasi', [BarangController::class, 'notifikasi'])->name('barang.notifikasi');

// PENCARIAN BARANG
Route::get('/cari-barang', [BarangController::class, 'cari']);

// FOTO
Route::post('/foto/store', [FotoController::class, 'store'])->name('foto.store');

// BARANG MASUK
Route::get('/barang_masuk', [BarangMasukController::class, 'index']);
Route::post('/barang_masuk', [BarangMasukController::class, 'store'])->name('barang_masuk.store');

// DATA MAHASISWA
Route::resource('mahasiswa', MahasiswaController::class);

// PEMINJAMAN DAN PENGEMBALIAN

    // NON ADMIN OPERATION
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/tambah', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/kembalikan', [PeminjamanController::class, 'formKembalikan'])->name('peminjaman.kembalikanCek');
    Route::post('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'prosesKembalikan'])->name('peminjaman.kembalikanProses');
    Route::get('/peminjaman/kembalikan', function () {return view('peminjaman.kembalikan_form');})->name('peminjaman.kembalikanForm');
    Route::post('/peminjaman/kembalikan-semua', [PeminjamanController::class, 'kembalikanSemuaBarang'])->name('peminjaman.kembalikanSemuaBarang');
    
    // Peminjaman barang yang FIX
    Route::get('/listbarang', [PeminjamanController::class, 'listBarang'])->name('listbarang');
    Route::get('/keranjang', [PeminjamanController::class, 'showKeranjang'])->name('keranjang');
    Route::post('/keranjang', [PeminjamanController::class, 'submitPeminjaman'])->name('submit.peminjaman');
    
    // ADMIN OPERATION
    Route::get('/riwayat_peminjaman', [PeminjamanController::class, 'show_riwayat_peminjaman'])->name('admin/peminjaman.index');
    Route::get('/admin/peminjaman/exportPDF', [PeminjamanController::class, 'exportPDF'])->name('admin/peminjaman.export');


// PENGAMBILAN

    // NON ADMIN OPERATION
    // Pengambilan Fix
    Route::get('/listbarang2', [PengambilanController::class, 'listbarang2'])->name('listbarang2');
    Route::get('/listbarang', [PeminjamanController::class, 'listBarang'])->name('listbarang');
    Route::get('/keranjang2', [PengambilanController::class, 'showKeranjang2'])->name('keranjang2');
    Route::post('/keranjang2', [PengambilanController::class, 'submitPengambilan'])->name('submit.pengambilan');

    // ini bukan fix
    Route::get('/pengambilan', [PengambilanController::class, 'index'])->name('pengambilan.index');
    Route::get('/pengambilan/tambah', [PengambilanController::class, 'create'])->name('pengambilan.create');
    Route::post('/pengambilan', [PengambilanController::class, 'store'])->name('pengambilan.store');

    // ADMIN OPERATION
    Route::get('/riwayat_pengambilan', [PengambilanController::class, 'show_riwayat_pengambilan'])->name('admin/pengambilan.index');
    Route::get('/admin/pengambilan/export-PDF', [PengambilanController::class, 'exportPDF'])->name('admin/pengambilan.export-pdf');


// ADMIN LOGIN
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');