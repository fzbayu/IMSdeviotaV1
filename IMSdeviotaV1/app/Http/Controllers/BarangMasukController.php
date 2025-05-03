<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Carbon\Carbon;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('barang')->get();
        return view('barang_masuk.index', compact('barangMasuk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|integer|exists:barang,id_barang',
            'id_supplier' => 'nullable|integer'
        ]);

        $barang = Barang::findOrFail($request->id_barang);

        BarangMasuk::create([
            'id_barang' => $barang->id_barang,
            'id_supplier' => $request->id_supplier,
            'jumlah' => $barang->stok,
            'tanggal_masuk' => Carbon::now()
        ]);

        return redirect('/barang_masuk')->with('success', 'Data barang masuk berhasil dicatat!');
    }
}
