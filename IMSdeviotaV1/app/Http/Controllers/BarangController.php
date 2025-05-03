<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\Foto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        try {
            DB::connection()->getPdo();

            // Query dasar dengan eager loading
            $query = Barang::with(['kategori', 'foto']);
            
            // Filter berdasarkan kategori jika ada parameter
            if ($request->has('filter_kategori') && $request->filter_kategori != '') {
                $query->where('id_kategori', $request->filter_kategori);
            }
            
            // Filter tambahan untuk stok (opsional)
            if ($request->has('filter_stok') && $request->filter_stok != '') {
                if ($request->filter_stok == 'low') {
                    $query->whereColumn('stok', '<=', 'stok_minimum');
                } elseif ($request->filter_stok == 'out') {
                    $query->where('stok', 0);
                }
            }
            
            // Eksekusi query
            $barang = $query->get();
            $barangMasuk = BarangMasuk::with('barang.kategori')->get();
            $kategoris = Kategori::all();

            return view('adminDashboard.index', compact('barang', 'barangMasuk', 'kategoris'));

        } catch (\Exception $e) {
        
            return redirect()->back()->with('error', 
                'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.');
        }
    }

    public function formTambah()
    {
        $kategoris = Kategori::All();
        return view('barang.formTambah', compact('kategoris'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:150',
            'id_kategori' => 'required|integer|exists:kategori,id_kategori',
            'stok' => 'required|integer',
            'lokasi' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:Barang Dipinjam,Barang Diambil',
            'stok_minimum' => 'nullable|integer',
            'harga' => 'required|numeric',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::create($request->only([
                'nama_barang', 'id_kategori', 'stok', 'lokasi', 'deskripsi', 'tipe', 'stok_minimum', 'harga'
            ]));

            BarangMasuk::create([
                'id_barang' => $barang->id_barang,
                'jumlah' => $barang->stok,
                'tanggal_masuk' => now()
            ]);
            if ($request->hasFile('foto')) {
                foreach ($request->file('foto') as $file) {
                    $path = $file->store('uploads', 'public');

                    Foto::create([
                        'id_barang' => $barang->id_barang,
                        'foto' => $path
                    ]);
                }
            }

            DB::commit();
            return redirect('/adminDashboard')->with('success', 'Barang berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/adminDashboard')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:150',
            'id_kategori' => 'required|integer|exists:kategori,id_kategori',
            'stok' => 'required|integer',
            'lokasi' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:Barang Dipinjam,Barang Diambil',
            'stok_minimum' => 'nullable|integer',
            'harga' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::findOrFail($id);
            $stokLama = $barang->stok; 
            
            $barang->update($request->only([
                'nama_barang', 'id_kategori', 'stok', 'lokasi', 'deskripsi', 'tipe', 'stok_minimum', 'harga'
            ]));

            if ($request->stok > $stokLama) {
                $stokMasuk = $request->stok - $stokLama;
                BarangMasuk::create([
                    'id_barang' => $barang->id_barang,
                    'jumlah' => $stokMasuk,
                    'tanggal_masuk' => now()
                ]);
            }

            DB::commit();
            return redirect('/adminDashboard')->with('success', 'Barang berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/adminDashboard')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $barang = Barang::findOrFail($id);
            foreach ($barang->foto as $foto) {
                if (Storage::exists('public/' . $foto->foto)) {
                    Storage::delete('public/' . $foto->foto);
                }
                $foto->delete();
            }

            BarangMasuk::where('id_barang', $barang->id_barang)->delete();

            $barang->delete();

            DB::commit();
            return redirect('/adminDashboard')->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/adminDashboard')->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }

    public function cari(Request $request)
    {
        $keyword = $request->keyword;
        $barang = Barang::with('kategori', 'foto')
                    ->where('nama_barang', 'like', "%$keyword%")
                    ->get();

        return view('welcome', compact('barang'));
    }

    public function show($id)
    {
        $barang = Barang::with(['kategori', 'foto'])->findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    public function notifikasi()
    {
        $barang_notif = Barang::whereColumn('stok', '<=', 'stok_minimum')->get();

        return view('barang.notifikasi', compact('barang_notif'));
    }

}
