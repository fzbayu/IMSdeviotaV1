<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('mahasiswa', 'barang')->get();
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('peminjaman.create', compact('barang'));
    }

    public function listBarang(Request $request)
    {
        $kategori = Kategori::all();

        $query = Barang::with('kategori')
                    ->where('tipe', 'Barang Dipinjam')
                    ->where('stok', '>', 0);

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan ID kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        $barang = $query->get();

        return view('peminjaman.listbarang', compact('barang', 'kategori'));
    }

    public function showKeranjang(Request $request)
    {
        $cart = json_decode($request->input('cart'), true);
        session(['cart' => $cart]);

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
    
        return view('peminjaman.create', compact('barangWithQty'));
    }
    
    public function submitPeminjaman(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kontak' => 'required',
            'tanggal_kembali' => 'required|date',
        ]);

        $cart = session('cart', []);

        // Cek apakah NIM sudah terdaftar
        $mahasiswa = Mahasiswa::where('nim', $validated['nim'])->first();

        if ($mahasiswa) {
            // Jika nama tidak cocok, tampilkan warning
            if (strtolower(trim($mahasiswa->nama_mahasiswa)) !== strtolower(trim($validated['nama']))) {
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
                'nim' => $validated['nim'],
                'nama_mahasiswa' => $validated['nama'],
                'kontak' => $validated['kontak'],
            ]);
        }

        foreach ($cart as $item) {
            $barang = Barang::find($item['id_barang']);
            if (!$barang || $barang->stok < $item['jumlah']) {
                return back()->withErrors(['stok' => 'Stok tidak mencukupi untuk salah satu barang.'])->withInput();
            }

            Peminjaman::create([
                'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                'id_barang' => $item['id_barang'],
                'jumlah' => $item['jumlah'],
                'tanggal_pinjam' => now(),
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status' => 'Dipinjam',
            ]);

            $barang->stok -= $item['jumlah'];
            $barang->save();
        }

        session()->forget('cart');

        return redirect()->route('keranjang')->with('success', 'Peminjaman berhasil!');
    }


    /*public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string',
            'nim' => 'required|string',
            'kontak' => 'required|string',
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
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
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk peminjaman.'])->withInput();
        }

        Peminjaman::create([
            'id_mahasiswa' => $mahasiswa->id_mahasiswa,
            'id_barang' => $request->id_barang,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'Dipinjam',
        ]);

        $barang->stok -= $request->jumlah;
        $barang->save();

        return redirect()->route('welcome')->with('success', 'Peminjaman berhasil ditambahkan.');
    }*/

    public function formKembalikan(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string',
            'nim' => 'required|string',
        ]);

        $mahasiswa = Mahasiswa::where('nim', $request->nim)
            ->where('nama_mahasiswa', $request->nama_mahasiswa)
            ->first();

        if (!$mahasiswa) {
            return back()->withErrors(['not_found' => 'Mahasiswa tidak ditemukan.']);
        }

        $peminjaman = Peminjaman::with('barang')
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('status', 'Dipinjam')
            ->get();

        return view('peminjaman.kembalikan', compact('peminjaman', 'mahasiswa'));
    }

    public function kembalikanSemuaBarang(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_mahasiswa' => 'required|exists:mahasiswa,id_mahasiswa' // Fix the validation field name
        ]);
        
        $idMahasiswa = $request->id_mahasiswa;
        $mahasiswa = Mahasiswa::findOrFail($idMahasiswa);
        
        // Ambil semua peminjaman dengan status 'Dipinjam' untuk mahasiswa ini
        $peminjaman = Peminjaman::where('id_mahasiswa', $idMahasiswa)
                    ->where('status', 'Dipinjam')
                    ->get();
        
        if ($peminjaman->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada barang yang perlu dikembalikan');
        }
        
        $totalItemDikembalikan = 0;
        
        foreach ($peminjaman as $item) {
            // Update stok barang
            $barang = Barang::findOrFail($item->id_barang);
            $barang->stok += $item->jumlah;
            $barang->save();
            
            // Update peminjaman
            $item->status = 'Dikembalikan';
            $item->tanggal_kembali = now();
            $item->save();
            
            $totalItemDikembalikan += $item->jumlah;
        }
        
        return redirect()->route('peminjaman.kembalikanForm', [
            'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
            'nim' => $mahasiswa->nim,
        ])->with('success', 'Berhasil mengembalikan semua barang (' . $totalItemDikembalikan . ' item)');
    }

    // public function prosesKembalikan(Request $request, $id)
    // {
        
    //     $peminjaman = Peminjaman::with('mahasiswa')->findOrFail($id);

    //     $request->validate([
    //         'jumlah_kembalikan' => 'required|numeric|min:1|max:'.$peminjaman->jumlah
    //     ]);

    //     $barang = Barang::findOrFail($peminjaman->id_barang);
    //     $jumlahKembalikan = $request->jumlah_kembalikan;

    //     // 1. Update stok barang
    //     $barang->stok += $jumlahKembalikan;
    //     $barang->save();

    //     // 2. Update sisa peminjaman
    //     $peminjaman->jumlah -= $jumlahKembalikan;

    //     // 3. Jika sudah dikembalikan semua, ubah status
    //     if ($peminjaman->jumlah == 0) {
    //         $peminjaman->status = 'Dikembalikan';
    //         $peminjaman->tanggal_kembali = now();
    //     }

    //     $peminjaman->save();    

    //     return redirect()->back()->with('success', 'Berhasil mengembalikan '.$jumlahKembalikan.' item');
    // }

    public function prosesKembalikan(Request $request, $id)
{
    $peminjaman = Peminjaman::with('mahasiswa')->findOrFail($id);

    $request->validate([
        'jumlah_kembalikan' => 'required|numeric|min:1|max:' . $peminjaman->jumlah
    ]);

    $barang = Barang::findOrFail($peminjaman->id_barang);
    $jumlahKembalikan = $request->jumlah_kembalikan;

    // Update stok barang
    $barang->stok += $jumlahKembalikan;
    $barang->save();

    // Update jumlah di peminjaman
    $peminjaman->jumlah -= $jumlahKembalikan;

    if ($peminjaman->jumlah == 0) {
        $peminjaman->status = 'Dikembalikan';
        $peminjaman->tanggal_kembali = now();
    }

    $peminjaman->save();

    // ✅ Ambil ulang semua data peminjaman & mahasiswa (tanpa redirect)
    $mahasiswa = $peminjaman->mahasiswa;
    $peminjamanAll = Peminjaman::with('barang')
        ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
        ->where('status', '!=', 'Dikembalikan')
        ->get();

    return view('peminjaman.kembalikan', [
        'peminjaman' => $peminjamanAll,
        'mahasiswa' => $mahasiswa,
        'success' => 'Berhasil mengembalikan ' . $jumlahKembalikan . 'item'
    ]);
}

    public function show_riwayat_peminjaman(Request $request) 
    {
        $query = Peminjaman::with(['mahasiswa', 'barang']);
        
        // Filter status (opsional)
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }
        
        // Filter rentang datetime
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_pinjam', [
                $request->tanggal_mulai . ' 00:00:00',
                $request->tanggal_selesai . ' 23:59:59'
            ]);
        }
        
        $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')->get();
        
        return view('admin/peminjaman.index', [
            'peminjaman' => $peminjaman,
            'status_terpilih' => $request->filter_status ?? '',
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);
    }

    public function exportPDF(Request $request)
    {
        $query = Peminjaman::with(['mahasiswa', 'barang']);

        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_pinjam', [
                $request->tanggal_mulai . ' 00:00:00',
                $request->tanggal_selesai . ' 23:59:59'
            ]);
        }

        $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $pdf = Pdf::loadView('admin.peminjaman.pdf', [
            'peminjaman' => $peminjaman,
            'status_terpilih' => $request->filter_status ?? '',
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ])->setPaper('A4', 'landscape');

        return $pdf->download('rekap_peminjaman.pdf');
    }
}
