@include('layouts.navbar_keranjang')

<h2>Tambah Peminjaman</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

<form action="{{ route('submit.peminjaman') }}" method="POST">
    @csrf

    <h3>Barang yang Dipinjam:</h3>
    <ul>
        @foreach ($barangWithQty as $item)
            <li style="margin-bottom: 10px;">
                <img src="{{ asset('storage/' . $item['barang']->gambar) }}" alt="{{ $item['barang']->nama_barang }}" width="80" style="border-radius: 8px; margin-right: 10px;">
                {{ $item['barang']->nama_barang }} - Jumlah: {{ $item['jumlah'] }}
            </li>
        @endforeach
    </ul>

    <input type="text" name="nim" placeholder="NIM" required>
    <input type="text" name="nama" placeholder="Nama" required>
    <input type="text" name="kontak" placeholder="Kontak" required>
    <input type="date" name="tanggal_kembali" required>

    <button type="submit" class="btn btn-primary">Submit Peminjaman</button>
</form>