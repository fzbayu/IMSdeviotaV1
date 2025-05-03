<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;
    protected $table = 'barang_foto';
    protected $primaryKey = 'id_foto';
    protected $fillable = ['id_barang', 'foto'];
    public $timestamps = false;

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
