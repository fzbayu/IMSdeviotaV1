@extends('layouts.app')

@section('content')

<style>
    /* Base Styles */
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #ffffff;
        margin: 0;
        padding: 0;
        color: #333;
    }

    /* Header Section */
    .header-container {
        display: flex;
        justify-content: space-between;
        /* Mengatur agar konten tersebar di kiri dan kanan */
        align-items: center;
        padding: 20px 30px;
        background: #fff;
    }

    h2 {
        color: #7B1FA2;
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
    }

    /* Main Filter and Action Container */
    .main-action-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f9fa;
        padding: 15px 30px;
        margin: 0 20px 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    /* Combined Filter Section */
    .filter-section {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-group label {
        font-weight: 600;
        color: #6a0dad;
        white-space: nowrap;
        font-size: 0.95rem;
    }

    .filter-group select,
    .filter-group input[type="date"] {
        background-color: #6a0dad;
        color: #ffffff;
        padding: 8px 12px;
        border: 2px solid #6a0dad;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-group select:hover,
    .filter-group input[type="date"]:hover {
        background-color: #5c0b9e;
    }

    .filter-group input[type="date"] {
        min-width: 150px;
    }

    /* Action Buttons Section */
    .action-buttons {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    /* Button Styles */
    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }

    .btn i {
        margin-right: 6px;
    }

    .filter-btn {
        background-color: #6a0dad;
        color: white;
    }

    .export-btn {
        background-color: #28a745;
        color: white;
    }

    .delete-btn {
        background-color: #dc3545;
        color: white;
    }

    .delete-btn:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .reset-link {
        color: #dc3545;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        margin-left: 10px;
        transition: all 0.2s ease;
    }

    .reset-link:hover {
        text-decoration: underline;
        color: #b02a37;
    }

    /* Table Styles */
    .table-container {
        padding: 0 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        background-color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    thead {
        background-color: #7B1FA2;
        color: white;
    }

    th {
        padding: 14px 16px;
        text-align: center;
        font-weight: 600;
        border: 1px solid #555;
    }

    td {
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
        text-align: center;
        vertical-align: middle;
        border: 1px solid #555;
    }

    tbody tr:hover {
        background-color: rgba(123, 31, 162, 0.1);
    }

    /* Row Selection */
    .selected-row {
        background-color: rgba(156, 137, 184, 0.3) !important;
    }

    /* Responsive table */
    @media (max-width: 1200px) {
        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .foto-thumbs {
            justify-content: flex-start;
        }
    }

    @media (max-width: 768px) {

        td,
        th {
            padding: 8px 10px;
            font-size: 0.9rem;
        }

        .foto-thumbs a img {
            width: 50px;
            height: 50px;
        }
    }

    input[type="date"] {
        color: white;
        background-color: #6a0dad;
        /* supaya kontras */
        border: 1px solid #ccc;
        padding: 6px;
        border-radius: 4px;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }

    /* Tombol Cari yang sesuai dengan warna tombol lainnya */
    form button[type="submit"] {
        padding: 8px 14px;
        border-radius: 5px;
        background-color: #6a0dad;
        /* Warna yang sama dengan tombol lainnya */
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    form button[type="submit"]:hover {
        background-color: #5c0b9e;
        /* Efek hover */
    }

    /* Memberikan jarak antar form pencarian dan tombol */
    form {
        display: flex;
        gap: 10px;
        /* Memberikan jarak antara input dan tombol */
        align-items: center;
    }

    /* Tambahkan di bagian style */
    .foto-thumbs {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        justify-content: center;
    }

    .foto-thumbs a {
        transition: transform 0.2s;
    }

    .foto-thumbs a:hover {
        transform: scale(1.05);
    }

    /* Modal untuk preview foto */
    .modal-foto {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .modal-img {
        max-width: 90%;
        max-height: 90%;
    }

    .close-modal {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }

    .modal-nav {
        position: absolute;
        top: 50%;
        width: 100%;
        transform: translateY(-50%);
    }

    .modal-nav-btn.prev-btn,
    .modal-nav-btn.next-btn {
        position: absolute;
        background-color: rgba(255, 255, 255, 0.85);
        /* warna putih semi-transparan */
        color: black;
        /* teks panah warna hitam agar kontras */
        font-size: 30px;
        cursor: pointer;
        padding: 10px;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        /* bayangan biar tetap kelihatan di background terang */
        transition: transform 0.2s ease;
    }

    .modal-nav-btn.prev-btn:hover,
    .modal-nav-btn.next-btn:hover {
        transform: scale(1.1);
    }

    .modal-nav-btn.prev-btn {
        left: 20px;
    }

    .modal-nav-btn.next-btn {
        right: 20px;
    }

    .foto-more-indicator {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .foto-more-indicator:hover {
        background-color: rgba(0, 0, 0, 0.8) !important;
        transform: scale(1.05);
    }
</style>

<div class="header-container">
    <h2>DATA PEMINJAMAN</h2>

    <form method="GET" action="{{ route('admin/peminjaman.index') }}" style="display: flex; align-items: center; gap: 10px;">
        <input type="text" name="search" placeholder="Cari Nama atau NIM Mahasiswa"
            value="{{ request('search') }}"
            style="padding: 8px; width: 300px; border-radius: 5px; border: 1px solid #ccc;">
        <button type="submit">
            Cari
        </button>
    </form>
</div>


<!-- Combined Filter and Action Section -->
<div class="main-action-container">
    <!-- Filter Section -->
    <form method="GET" action="{{ route('admin/peminjaman.index') }}" class="filter-section">
        <div class="filter-group">
            <label for="filter_status">Status:</label>
            <select name="filter_status" id="filter_status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="Dipinjam" {{ $status_terpilih == 'Dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                <option value="Dikembalikan" {{ $status_terpilih == 'Dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                <option value="Telat" {{ $status_terpilih == 'Telat' ? 'selected' : '' }}>Telat Dikembalikan</option>
                <option value="Dikembalikan Sebagian" {{ $status_terpilih == 'Dikembalikan Sebagian' ? 'selected' : '' }}>Dikembalikan Sebagian</option>
            </select>
        </div>

        @if(isset($status_terpilih))
        <div class="filter-group">
            <label for="tanggal_mulai">Tanggal:</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                value="{{ $tanggal_mulai ?? '' }}" required>
            <span class="date-separator">s/d</span>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                value="{{ $tanggal_selesai ?? '' }}" required>
            <button type="submit" class="btn filter-btn">Filter</button>

            @if(isset($tanggal_mulai))
            <a href="{{ route('admin/peminjaman.index', ['filter_status' => $status_terpilih]) }}"
                class="reset-link">
                Reset
            </a>
            @endif
        </div>
        @endif
    </form>

    <!-- Action Buttons -->
    <div class="action-buttons">
        @if($peminjaman->count() > 0)
        <form method="GET" action="{{ route('admin/peminjaman.export') }}" target="_blank" class="export-form">
            <input type="hidden" name="filter_status" value="{{ $status_terpilih }}">
            <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
            <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
            <button type="submit" class="btn export-btn">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
        </form>
        @endif

        <button id="deleteSelectedBtn" class="btn delete-btn" disabled>
            <i class="fas fa-trash-alt"></i> Hapus Dipilih
        </button>

        <button id="deleteAllBtn" class="btn delete-btn">
            <i class="fas fa-trash"></i> Hapus Semua
        </button>
    </div>
</div>

@if(session('success'))
<div style="color: green; margin-bottom: 15px;">
    {{ session('success') }}
</div>
@endif

@if($peminjaman->count() > 0)
<!-- <div class="action-buttons">
    <button id="deleteSelectedBtn" class="delete-selected-btn" disabled>Hapus yang Dipilih</button>
</div> -->

<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>NO</th>
            <th>Nama Mahasiswa</th>
            <th>NIM</th>
            <th>Kontak</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Pengembalian</th>
            <th>Tanggal Dikembalikan</th>
            <th>Status</th>
            <th>Bukti Pengembalian</th>
            <th>Pilih</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjaman as $pinjam)
        <tr data-id="{{ $pinjam->id_peminjaman }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ optional($pinjam->mahasiswa)->nama_mahasiswa ?? 'Mahasiswa tidak ditemukan' }}</td>
            <td>{{ optional($pinjam->mahasiswa)->nim ?? '-' }}</td>
            <td>{{ optional($pinjam->mahasiswa)->kontak ?? '-' }}</td>
            <td>{{ optional($pinjam->barang)->nama_barang ?? 'Barang tidak ditemukan' }}</td>
            <td>{{ $pinjam->jumlah }}</td>
            <td>{{ $pinjam->tanggal_pinjam }}</td>
            <!-- <td>{{ $pinjam->tanggal_pengembalian }}</td> -->
            <td>{{ optional($pinjam)->tanggal_pengembalian ?? 'Pengembalian tidak ditemukan' }}</td>
            <td>{{ $pinjam->tanggal_kembali ?? '-' }}</td>
            <td>{{ $pinjam->status }}</td>
            <td>
                @if($pinjam->fotoPengembalian->count() > 0)
                <div class="foto-thumbs" style="display: flex; gap: 5px; position: relative; flex-wrap: nowrap; max-width: 140px; overflow: hidden;">
                    @foreach($pinjam->fotoPengembalian->take(2) as $index => $foto)
                    <div style="position: relative;">
                        <a href="{{ Storage::url($foto->foto) }}"
                            class="foto-thumbnail"
                            data-all-fotos='@json($pinjam->fotoPengembalian->map(function($f) { return Storage::url($f->foto); }))'
                            style="display: block;">
                            <img src="{{ Storage::url($foto->foto) }}"
                                width="60" height="60"
                                style="object-fit: cover; border-radius: 4px; border: 1px solid #ddd;"
                                alt="Foto Pengembalian">
                        </a>

                        @if($loop->last && $pinjam->fotoPengembalian->count() > 2)
                        <div class="foto-more-indicator"
                            style="position: absolute; top: 0; left: 0; width: 60px; height: 60px;
                background-color: rgba(0,0,0,0.6); color: white; display: flex;
                align-items: center; justify-content: center; border-radius: 4px;
                font-weight: bold; font-size: 16px; cursor: pointer;"
                            data-all-fotos='@json($pinjam->fotoPengembalian->map(function($f) { return Storage::url($f->foto); }))'>
                            +{{ $pinjam->fotoPengembalian->count() - 2 }}
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <span style="color: #6c757d;">Tidak ada foto</span>
                @endif
            </td>
            <td><input type="checkbox" class="row-checkbox" value="{{ $pinjam->id_peminjaman }}"></td>
        </tr>
        @endforeach
    </tbody>
</table>

@else
<p style="color: #6c757d; font-style: italic;">Tidak ada data peminjaman yang sesuai dengan filter</p>
@endif

<script>
    // Set tanggal default (opsional)
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.getElementById('tanggal_mulai').value) {
            let today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_mulai').value = today;
            document.getElementById('tanggal_selesai').value = today;
        }

        // Row selection functionality
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        const deleteAllBtn = document.getElementById('deleteAllBtn');
        const rows = document.querySelectorAll('tbody tr');

        // Add event listeners to checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');
                if (this.checked) {
                    row.classList.add('selected-row');
                } else {
                    row.classList.remove('selected-row');
                }
                updateDeleteButtonState();
            });
        });

        rows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Cegah toggle checkbox jika klik terjadi di elemen interaktif
                if (
                    e.target.tagName !== 'INPUT' &&
                    e.target.tagName !== 'A' &&
                    !e.target.closest('.foto-thumbs') && // ⬅ cegah jika klik di gambar
                    !e.target.classList.contains('foto-more-indicator') &&
                    !e.target.closest('.foto-popover')
                ) {
                    const checkbox = this.querySelector('.row-checkbox');
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        });


        // Update delete button state based on selected rows
        function updateDeleteButtonState() {
            const selectedCount = document.querySelectorAll('.row-checkbox:checked').length;
            deleteSelectedBtn.disabled = selectedCount === 0;
        }

        // Delete selected rows
        deleteSelectedBtn.addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedIds.length > 0 && confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')) {
                // Send AJAX request to delete selected items
                fetch('{{ route("admin/peminjaman.deleteSelected") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ids: selectedIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Gagal menghapus data');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus data');
                    });
            }
        });

        deleteAllBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menghapus SEMUA data peminjaman?')) {
                fetch('{{ route("admin/peminjaman.deleteAll") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Gagal menghapus semua data');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus data');
                    });
            }
        });
    });

    // Tambahkan di bagian script
    // Modal foto
    const modal = document.createElement('div');
    modal.className = 'modal-foto';
    modal.innerHTML = `
    <span class="close-modal">&times;</span>
    <div class="modal-nav">
        <span class="modal-nav-btn prev-btn">&#10094;</span>
        <span class="modal-nav-btn next-btn">&#10095;</span>
    </div>
    <div class="modal-content">
        <img class="modal-img" src="">
        <div class="foto-counter" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); 
            background: rgba(0,0,0,0.7); color: white; padding: 5px 10px; border-radius: 10px;">
            <span class="current-index">1</span>/<span class="total-fotos">0</span>
        </div>
    </div>
`;
    document.body.appendChild(modal);

    let currentFotoIndex = 0;
    let currentFotoSet = [];

    // Fungsi untuk membuka modal dengan semua foto
    function openFotoModal(fotos, startIndex = 0) {
        currentFotoSet = fotos;
        currentFotoIndex = startIndex;
        modal.querySelector('.modal-img').src = currentFotoSet[currentFotoIndex];
        modal.querySelector('.current-index').textContent = currentFotoIndex + 1;
        modal.querySelector('.total-fotos').textContent = currentFotoSet.length;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    // Event listener untuk thumbnail dan indicator
    document.querySelectorAll('.foto-thumbnail, .foto-more-indicator').forEach(element => {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            const fotos = JSON.parse(this.getAttribute('data-all-fotos'));
            // Jika klik thumbnail, cari indexnya
            const startIndex = this.classList.contains('foto-thumbnail') ?
                Array.from(this.parentElement.parentElement.querySelectorAll('.foto-thumbnail')).indexOf(this) : 0;
            openFotoModal(fotos, startIndex);
        });
    });

    // Navigasi foto
    modal.querySelector('.prev-btn').addEventListener('click', function() {
        currentFotoIndex = (currentFotoIndex - 1 + currentFotoSet.length) % currentFotoSet.length;
        modal.querySelector('.modal-img').src = currentFotoSet[currentFotoIndex];
        modal.querySelector('.current-index').textContent = currentFotoIndex + 1;
    });

    modal.querySelector('.next-btn').addEventListener('click', function() {
        currentFotoIndex = (currentFotoIndex + 1) % currentFotoSet.length;
        modal.querySelector('.modal-img').src = currentFotoSet[currentFotoIndex];
        modal.querySelector('.current-index').textContent = currentFotoIndex + 1;
    });

    // Tutup modal
    modal.querySelector('.close-modal').addEventListener('click', function() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // // Tambahkan tooltip untuk foto
    // document.querySelectorAll('.foto-thumbs a img').forEach(img => {
    //     img.addEventListener('mouseover', function() {
    //         const tooltip = document.createElement('div');
    //         tooltip.className = 'tooltip';
    //         tooltip.textContent = this.title;
    //         tooltip.style.position = 'absolute';
    //         tooltip.style.backgroundColor = 'rgba(0,0,0,0.8)';
    //         tooltip.style.color = 'white';
    //         tooltip.style.padding = '5px 10px';
    //         tooltip.style.borderRadius = '4px';
    //         tooltip.style.zIndex = '100';

    //         const rect = this.getBoundingClientRect();
    //         tooltip.style.left = `${rect.left + window.scrollX}px`;
    //         tooltip.style.top = `${rect.top + window.scrollY - 35}px`;

    //         document.body.appendChild(tooltip);

    //         this.addEventListener('mouseout', function() {
    //             document.body.removeChild(tooltip);
    //         });
    //     });
    // });
</script>

@endsection