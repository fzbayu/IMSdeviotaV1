<nav style="background-color: #f5f5f5; padding: 10px; display: flex; justify-content: space-between; align-items: center;">
    <div style="font-weight: bold; font-size: 20px;">Pinjaman</div>
    <div>
        <a href="{{ route('welcome') }}" title="Dashboard" style="margin-right: 15px;">
            🏠
        </a>
        <a href="{{ url()->previous() }}" title="Kembali">
        Back
        </a>
    </div>
</nav>
