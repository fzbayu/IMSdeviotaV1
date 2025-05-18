<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengambilan;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;

class PengambilanController extends Controller
{
    public function index()
    {
        $pengambilan = Pengambilan::with('mahasiswa', 'barang')->get();
        return view('pengambilan.index', compact('pengambilan'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('pengambilan.create', compact('barang'));
    }

    public function listBarang2(Request $request)
    {
        $kategori = Kategori::all();

        $query = Barang::with('kategori')
            ->whereIn('tipe', ['Barang Diambil', 'Barang Diambil dan Dipinjam'])
            ->where('stok', '>', 0);


        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where([
                ['id_kategori', '=', $request->kategori],
                ['tipe', '=', 'Barang Diambil'], // pastikan tipe juga "Barang Diambil"
            ]);
        }

        $barang = $query->get();

        return view('pengambilan.listbarang2', compact('barang', 'kategori'));
    }


    public function showKeranjang2(Request $request)
    {
        $cart = json_decode($request->input('cart'), true);
        session(['cart' => $cart]);

        // Ambil data barang dari database untuk ditampilkan di create
        $barangIds = collect($cart)->pluck('id_barang');
        $barang = Barang::whereIn('id_barang', $barangIds)->get();

        // Gabungkan dengan jumlah
        $barangWithQty = $barang->map(function ($barang) use ($cart) {
            $qty = collect($cart)->firstWhere('id_barang', $barang->id_barang)['jumlah'];
            return [
                'barang' => $barang,
                'jumlah' => $qty
            ];
        });

        return view('pengambilan.create', compact('barangWithQty'));
    }

    public function submitPengambilan(Request $request)
    {
        $validated = $request->validate([
            'kontak' => 'required',
        ]);

        // Ambil data mahasiswa dari session login
        $loginData = session('login_mahasiswa');
        $nim = $loginData['nim'] ?? null;
        $nama = $loginData['nama'] ?? null;

        // Pastikan nim dan nama ada di session
        if (!$nim || !$nama) {
            return redirect()->route('login.form')->with('error', 'Sesi login tidak ditemukan. Silakan login kembali.');
        }

        // Cari berdasarkan NIM
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($mahasiswa) {
            // Jika nama tidak cocok, tampilkan notifikasi error
            if (strtolower(trim($mahasiswa->nama_mahasiswa)) !== strtolower(trim($nama))) {
                return redirect()->back()
                    ->with('error', 'NIM sudah terdaftar, silahkan input dengan nama yang sama.')
                    ->withInput();
            }

            // Update kontak jika perlu
            $mahasiswa->kontak = $validated['kontak'];
            $mahasiswa->save();
        } else {
            // Insert mahasiswa baru jika belum ada
            $mahasiswa = Mahasiswa::create([
                'nim' => $nim,
                'nama_mahasiswa' => $nama,
                'kontak' => $validated['kontak'],
            ]);
        }

        // Proses pengambilan barang dari keranjang
        $cart = session('cart', []);

        foreach ($cart as $item) {
            $barang = Barang::find($item['id_barang']);
            if (!$barang || $barang->stok < $item['jumlah']) {
                return back()->withErrors(['stok' => 'Stok tidak mencukupi untuk salah satu barang.'])->withInput();
            }

            // Simpan data pengambilan
            Pengambilan::create([
                'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                'id_barang' => $item['id_barang'],
                'jumlah' => $item['jumlah'],
                'tanggal_pinjam' => now(),
                'status' => 'Dipinjam',
            ]);

            // Kurangi stok barang
            $barang->stok -= $item['jumlah'];
            $barang->save();
        }

        // Kosongkan cart setelah pengambilan
        session()->forget('cart');

        return redirect()->route('keranjang2')->with('success', 'Pengambilan berhasil!');
    }


    /*public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string',
            'nim' => 'required|string',
            'kontak' => 'required|string',
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer',
            'tanggal_ambil' => 'required|date',
        ]);

        $mahasiswa = Mahasiswa::updateOrCreate(
            ['nim' => $request->nim], 
            [
                'nama_mahasiswa' => $request->nama_mahasiswa,
                'kontak' => $request->kontak,
            ]
        );

        $barang = Barang::find($request->id_barang);

        if ($barang->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk pengambilan.'])->withInput();
        }

        Pengambilan::create([
            'id_mahasiswa' => $mahasiswa->id_mahasiswa,
            'id_barang' => $request->id_barang,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'Dipinjam',
        ]);


        $barang->stok -= $request->jumlah;
        $barang->save();


        return redirect()->route('welcome')->with('success', 'pengambilan berhasil ditambahkan.');
    }*/

    public function show_riwayat_pengambilan(Request $request)
    {
        $query = Pengambilan::with(['mahasiswa', 'barang']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_ambil', [
                $request->tanggal_mulai . ' 00:00:00',
                $request->tanggal_selesai . ' 23:59:59'
            ]);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('mahasiswa', function ($q) use ($searchTerm) {
                $q->where('nama_mahasiswa', 'like', "%{$searchTerm}%")
                    ->orWhere('nim', 'like', "%{$searchTerm}%");
            });
        }

        $pengambilan = $query->orderBy('tanggal_ambil', 'desc')->get();

        return view('admin.pengambilan.index', [
            'pengambilan' => $pengambilan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);
    }

    public function exportPDF(Request $request)
    {
        $query = Pengambilan::with(['mahasiswa', 'barang']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_ambil', [
                $request->tanggal_mulai . ' 00:00:00',
                $request->tanggal_selesai . ' 23:59:59'
            ]);
        }

        $pengambilan = $query->get();

        $pdf = PDF::loadView('admin.pengambilan.export_pdf', [
            'pengambilan' => $pengambilan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        return $pdf->download('riwayat_pengambilan.pdf');
    }

    public function deleteAll()
    {
        Pengambilan::truncate();
        return redirect()->route('admin/pengambilan.index')->with('success', 'Semua data berhasil dihapus.');
    }

    public function deleteSelected(Request $request)
    {
        Pengambilan::whereIn('id_pengambilan', $request->ids)->delete();
        return response()->json(['success' => true]);
    }
}
