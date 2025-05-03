<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .header {
            background: linear-gradient(to right, #b388f4, #a06ee1);
            padding: 20px;
            color: white;
            font-size: 28px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .buttons {
            display: flex;
            gap: 10px;
        }

        .header .buttons button {
            background: #6d4dbf;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
        }

        .container {
            display: flex;
            padding: 20px;
            gap: 40px;
        }

        .left, .right {
            flex: 1;
        }

        .item-card {
            background: #eee;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .item-card img {
            width: 60px;
        }

        .item-info {
            flex: 1;
            margin-left: 15px;
        }

        .counter {
            background: #7e57c2;
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .counter button {
            background: transparent;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        .delete-icon {
            cursor: pointer;
            font-size: 18px;
            color: #444;
        }

        .right input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 100%;
            margin-bottom: 15px;
        }

        .right .form-row {
            display: flex;
            gap: 10px;
        }

        .submit-btn {
            background: #6c4ed3;
            color: white;
            padding: 15px;
            border-radius: 30px;
            border: none;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
            margin: 20px 0;
        }

        .accordion {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            background: white;
        }

        .accordion summary {
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>KERANJANG</div>
        <div class="buttons">
            <button>🏠</button>
            <button>Back</button>
        </div>
    </div>

    <div class="container">
        <div class="left">
            <?php for ($i = 0; $i < 7; $i++): ?>
            <div class="item-card">
                <img src="https://via.placeholder.com/60" alt="Item">
                <div class="item-info">
                    <strong>GSM SMS CONTROLLER</strong>
                    <div class="counter">
                        <button>-</button>
                        <span>666</span>
                        <button>+</button>
                    </div>
                </div>
                <div class="delete-icon">🗑️</div>
            </div>
            <?php endfor; ?>
        </div>

        <div class="right">
            <h3>TOTAL : <span style="color:#6c4ed3">92 ITEM</span></h3>
            <form action="proses_peminjaman.php" method="POST">
                <div class="form-row">
                    <input type="text" name="nim" placeholder="NIM">
                    <input type="text" name="nama" placeholder="Nama">
                </div>
                <div class="form-row">
                    <input type="text" name="kontak" placeholder="Kontak">
                    <input type="date" name="tanggal_kembali" placeholder="Tanggal Kembali">
                </div>
                <button type="submit" class="submit-btn">PINJAM BARANG</button>
            </form>

            <details class="accordion">
                <summary>Syarat & Ketentuan</summary>
                <p>Awas kalo ilang, kalo ilang denda 1 miliar, silahkan ambil sendiri!</p>
            </details>
        </div>
    </div>
</body>
</html>
