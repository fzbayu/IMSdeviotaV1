@include('layouts.navbar_pinjaman')

<h2>Cek Peminjaman Mahasiswa</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('peminjaman.kembalikanCek') }}">
    @csrf
    <label>Nama Mahasiswa:</label><br>
    <input type="text" name="nama_mahasiswa" required><br><br>

    <label>NIM:</label><br>
    <input type="text" name="nim" required><br><br>

    <button type="submit">Cek Peminjaman</button>
</form>
