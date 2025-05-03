<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel & MySQL DB CONNECTION</title>
</head>
<body>
    <div>
        <?php
            use Illuminate\Support\Facades\DB;

            try {
                if(DB::connection()->getPdo()) {
                    echo "Sukses: " . DB::connection()->getDatabaseName();
                }
            } catch (Exception $e) {
                echo "Gagal koneksi ke database: " . $e->getMessage();
            }
        ?>
    </div>
</body>
</html>
