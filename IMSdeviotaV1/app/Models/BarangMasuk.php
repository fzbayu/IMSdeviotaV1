<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk'; // Sesuai dengan tabel di database
    protected $primaryKey = 'id_masuk';
    protected $fillable = ['id_barang', 'id_supplier', 'jumlah', 'tanggal_masuk'];
    public $timestamps = false;

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    // Set tanggal otomatis saat membuat data baru
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($barangMasuk) {
            $barangMasuk->tanggal_masuk = Carbon::now('Asia/Jakarta'); // Set tanggal masuk otomatis
        });
    }
}
