<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = ['id_barang', 'id_mahasiswa', 'jumlah', 'tanggal_pinjam', 'tanggal_pengembalian', 'tanggal_kembali', 'status', 'foto_pengembalian'];
    public $timestamps = false;

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }
    public function fotoPengembalian()
    {
        return $this->hasMany(FotoPengembalian::class, 'id_peminjaman');
    }
}
