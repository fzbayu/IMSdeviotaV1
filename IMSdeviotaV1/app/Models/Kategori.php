<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori'];
    public $timestamps = false; // ← Tambahkan ini

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_kategori');
    }
}
