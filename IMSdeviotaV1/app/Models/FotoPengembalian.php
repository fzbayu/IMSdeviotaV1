<?php

// app/Models/FotoPengembalian.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPengembalian extends Model
{
    use HasFactory;

    protected $table = 'foto_pengembalian';
    protected $primaryKey = 'id_foto';
    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'foto',
        'keterangan'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}