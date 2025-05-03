<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    public $timestamps = false;

    protected $fillable = ['nama_supplier', 'kontak', 'alamat'];

    // Relasi dengan BarangMasuk
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_supplier');
    }
}
