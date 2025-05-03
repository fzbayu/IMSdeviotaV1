@include('layouts.navbar_pinjaman')

<h2>Daftar Barang yang Belum Dikembalikan</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if($peminjaman->isEmpty())
    <p>Tidak ada barang yang sedang dipinjam.</p>
@else
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
                @foreach($peminjaman as $pinjam)
                <tr>
                    <td>{{ optional($pinjam->barang)->nama_barang ?? 'Barang sudah dihapus' }}</td>
                    <td>{{ $pinjam->jumlah }}</td>
                    <td>{{ $pinjam->tanggal_pinjam }}</td>
                    <td>
                        <a href="{{ route('peminjaman.kembalikanProses', $pinjam->id_peminjaman) }}">
                            <button type="button">Kembalikan</button>
                        </a>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
@endif

@if(session('success'))
    <br>
    <a href="{{ route('peminjaman.kembalikan') }}">
        <button>Kembalikan Barang Lain</button>
    </a>
    <a href="{{ route('welcome') }}">
        <button>Selesai</button>
    </a>
@endif

