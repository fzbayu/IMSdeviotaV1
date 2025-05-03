@extends('layouts.app')

@section('content')
    <h2>📢 Notifikasi Stok Minimum</h2>

    @if($barang_notif->isEmpty())
        <p style="color: green;">Semua stok aman 👍</p>
    @else
        <ul>
            @foreach($barang_notif as $item)
                <li style="color: red; font-weight: bold;">
                    ❗ BARANG DENGAN NAMA "{{ $item->nama_barang }}" TERSISA {{ $item->stok }}
                </li>
            @endforeach
        </ul>
    @endif
@endsection