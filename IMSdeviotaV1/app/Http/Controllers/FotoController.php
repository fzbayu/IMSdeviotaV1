<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foto;
use App\Models\Barang;

class FotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filePath = $request->file('foto')->store('uploads', 'public');

        Foto::create([
            'id_barang' => $request->id_barang,
            'foto' => $filePath
        ]);

        return redirect()->back()->with('success', 'Foto berhasil diunggah');
    }
}
