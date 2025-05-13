@extends('layouts.app')

@section('content')

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #ffffff;
        margin: 0;
        padding: 0;
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

    /* Filter Section */
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

    .date-separator {
        color: #6a0dad;
        font-weight: 500;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 40px;
        box-sizing: border-box;
    }

    .export-btn {
        background-color: #28a745;
        color: white;
    }

    .reset-link {
        color: #dc3545;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        margin-left: 10px;
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
        margin: 20px 0;
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

    .delete-btn {
        background-color: #dc3545;
        color: white;
    }

    .delete-btn:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
        opacity: 0.7;
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

    .filter-btn {
        background-color: #6a0dad;
        color: white;
    }
</style>

<div class="header-container" style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
    <h2>DATA PENGAMBILAN</h2>
</div>

<!-- Combined Filter and Action Section -->
<div class="main-action-container">
    <!-- Filter Section -->
    <form method="GET" action="{{ route('admin/pengambilan.index') }}" class="filter-section">
        <div class="filter-group">
            <label for="tanggal_mulai">Tanggal:</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                value="{{ $tanggal_mulai ?? '' }}" required>
            <span class="date-separator">s/d</span>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                value="{{ $tanggal_selesai ?? '' }}" required>
            <button type="submit" class="btn filter-btn">Filter</button>

            @if(isset($tanggal_mulai))
            <a href="{{ route('admin/pengambilan.index') }}" class="reset-link">
                Reset
            </a>
            @endif
        </div>
    </form>

    <!-- Action Buttons -->
    <!-- Action Buttons -->
    <div class="action-buttons">
        @if($pengambilan->count() > 0)
        <form method="GET" action="{{ route('admin/pengambilan.export-pdf') }}" target="_blank" class="export-form">
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

        <form id="deleteAllForm" method="POST" action="{{ route('admin/pengambilan.deleteAll') }}">
            @csrf
            @method('DELETE')
            <button type="submit" id="deleteAllBtn" class="btn delete-btn">
                <i class="fas fa-trash"></i> Hapus Semua
            </button>
        </form>
    </div>
</div>

@if(session('success'))
<div style="color: green; margin: 0 20px 15px; padding: 10px; background: #e8f5e9; border-radius: 5px;">
    {{ session('success') }}
</div>
@endif

@if($pengambilan->count() > 0)
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Ambil</th>
                <th>Pilih</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengambilan as $ambil)
            <tr data-id="{{ $ambil->id_pengambilan }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ optional($ambil->mahasiswa)->nama_mahasiswa ?? 'Mahasiswa tidak ditemukan' }}</td>
                <td>{{ optional($ambil->mahasiswa)->nim ?? '-' }}</td>
                <td>{{ optional($ambil->barang)->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                <td>{{ $ambil->jumlah }}</td>
                <td>{{ $ambil->tanggal_ambil }}</td>
                <td><input type="checkbox" class="row-checkbox" value="{{ $ambil->id_pengambilan }}"></td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
@else
<div style="color: #6c757d; font-style: italic; margin: 0 20px; padding: 15px; text-align: center;">
    Tidak ada data pengambilan yang sesuai dengan filter
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set default dates if not already set
        if (!document.getElementById('tanggal_mulai').value) {
            let today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_mulai').value = today;
            document.getElementById('tanggal_selesai').value = today;
        }

        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

        function updateDeleteButtonState() {
            const checked = document.querySelectorAll('.row-checkbox:checked').length;
            deleteSelectedBtn.disabled = checked === 0;
        }

        // Baris dapat diklik untuk memilih checkbox
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('click', function(e) {
                // Cegah toggle jika klik langsung pada checkbox
                if (e.target.type === 'checkbox') return;

                const checkbox = this.querySelector('.row-checkbox');
                checkbox.checked = !checkbox.checked;
                updateDeleteButtonState();
            });
        });

        // Tetap dukung perubahan dari klik langsung checkbox
        document.querySelectorAll('.row-checkbox').forEach(cb => {
            cb.addEventListener('change', updateDeleteButtonState);
        });

        deleteSelectedBtn.addEventListener('click', () => {
            const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
                .map(cb => cb.value);

            if (selectedIds.length > 0 && confirm('Yakin ingin menghapus data yang dipilih?')) {
                fetch("{{ route('admin/pengambilan.deleteSelected') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        ids: selectedIds
                    })
                }).then(response => {
                    if (response.ok) location.reload();
                    else alert("Gagal menghapus data.");
                });
            }
        });
    });
</script>

@endsection