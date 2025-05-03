<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama_barang', 'id_kategori', 'stok', 'lokasi', 'deskripsi', 'tipe', 'stok_minimum', 'harga'];
    public $timestamps = false;
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_barang');
    }
}
