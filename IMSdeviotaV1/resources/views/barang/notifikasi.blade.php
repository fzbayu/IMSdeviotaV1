@extends('layouts.app')

<style>
    .notif-container {
        padding: 30px 40px;
    }

    .notif-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .notif-title {
        color: #7B1FA2;
        font-size: 3rem;
        font-weight: 800;
        margin: 0;
    }

    .notif-box {
        background-color: #FF7043;
        color: white;
        border-radius: 15px; /* Mengurangi border-radius */
        padding: 15px 20px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }


    .notif-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notif-icon {
        background-color: white;
        color: #FF7043;
        font-weight: bold;
        padding: 8px 10px;
        border-radius: 10px;
    }

    .notif-text {
        font-weight: bold;
    }
</style>

@section('content')
    <div class="notif-container">
        <div class="notif-header">
            <h2 class="notif-title">NOTIFIKASI</h2>
        </div>

        @if($barang_notif->isEmpty())
            <p style="color: green;">Semua stok aman 👍</p>
        @else
            @foreach($barang_notif as $item)
                <div class="notif-box">
                    <div class="notif-left">
                        <span class="notif-text">
                            BARANG DENGAN NAMA {{ strtoupper($item->nama_barang) }} TERSISA {{ $item->stok }}
                        </span>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
