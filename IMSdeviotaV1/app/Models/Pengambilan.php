<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengambilan extends Model
{
    use HasFactory;

    protected $table = 'pengambilan';
    protected $primaryKey = 'id_pengambilan';
    protected $fillable = ['id_barang', 'id_mahasiswa', 'jumlah', 'tanggal_ambil'];
    public $timestamps = false;

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($peminjaman) {
            $peminjaman->tanggal_ambil = Carbon::now('Asia/Jakarta'); // Menggunakan timezone Jakarta
        });
    }
}
