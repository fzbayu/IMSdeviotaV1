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
    }

    td {
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
        text-align: center;
        vertical-align: middle;
    }

    tbody tr:hover {
        background-color: rgba(123, 31, 162, 0.1);
    }

    /* Row Selection */
    .selected-row {
        background-color: rgba(156, 137, 184, 0.3) !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .main-action-container {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .action-buttons {
            width: 100%;
            justify-content: flex-end;
        }
    }

    @media (max-width: 768px) {
        .filter-section {
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        .filter-group {
            width: 100%;
            flex-wrap: wrap;
        }

        .header-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        h2 {
            font-size: 2rem;
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
</style>

<div class="header-container" style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
    <h2>DATA PEMINJAMAN</h2>
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
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Pilih</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjaman as $pinjam)
        <tr data-id="{{ $pinjam->id_peminjaman }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ optional($pinjam->mahasiswa)->nama_mahasiswa ?? 'Mahasiswa tidak ditemukan' }}</td>
            <td>{{ optional($pinjam->mahasiswa)->nim ?? '-' }}</td>
            <td>{{ optional($pinjam->barang)->nama_barang ?? 'Barang tidak ditemukan' }}</td>
            <td>{{ $pinjam->jumlah }}</td>
            <td>{{ $pinjam->tanggal_pinjam }}</td>
            <td>{{ $pinjam->tanggal_kembali ?? '-' }}</td>
            <td>{{ $pinjam->status }}</td>
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

        // Add click event to rows (optional for better UX)
        rows.forEach(row => {
            row.addEventListener('click', function(e) {
                if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'A') {
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
                            // Reload the page or remove the rows from DOM
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

        // Delete all rows
        deleteAllBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menghapus SEMUA data peminjaman?')) {
                // Send AJAX request to delete all items
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
</script>

@endsection