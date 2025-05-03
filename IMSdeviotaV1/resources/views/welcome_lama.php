<!-- <h2>INVENTORY MANAGEMENT SYSTEM DEVIOTA</h2>

<!-- Form Cari Barang -->
<form action="{{ url('/cari-barang') }}" method="GET" style="margin-bottom: 20px;">
    <label for="keyword">Cari berdasarkan nama barang:</label>
    <input type="text" name="keyword" id="keyword" placeholder="Masukkan nama barang...">
    <button type="submit">Cari</button>
</form>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Lokasi</th>
            <th>Deskripsi</th>
            <th>Tipe</th>
            <th>Stok Minimum</th>
            <th>Harga</th>
            <th>Foto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barang as $item)
        <tr>
            <td>{{ $item->id_barang }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td>{{ $item->kategori->nama_kategori }}</td>
            <td>{{ $item->stok }}</td>
            <td>{{ $item->lokasi }}</td>
            <td>{{ $item->deskripsi }}</td>
            <td>{{ $item->tipe }}</td>
            <td>{{ $item->stok_minimum }}</td>
            <td>{{ $item->harga }}</td>
            <td>
                @foreach($item->foto as $f)
                    <img src="{{ asset('storage/' . $f->foto) }}" width="100">
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.login') }}">
    <button>Login Admin</button>
</a>

<!-- Tombol untuk menuju halaman peminjaman -->
<a href="{{ url('/listbarang') }}">
    <button>Peminjaman</button>
</a>

<a href="{{ url('/listbarang2') }}">
    <button>Pengambilan</button>
</a>

<a href="{{ url('/peminjaman/kembalikan') }}">
    <button>Kembalikan Barang</button>
</a> -->


<!-- samina mina ee waka waka e e-->
<a href="https://wa.me/6281298101699" target="_blank" style="display: inline-flex; align-items: center; background-color: #9c27b0; color: white; padding: 10px 10px; border-radius: 5px; text-decoration: none; font-weight: bold;">
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WA" width="20" style="margin-right: 8px;">
    Hubungi Admin
</a>

