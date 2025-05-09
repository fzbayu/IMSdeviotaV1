<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


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
        $barang = Barang::with('foto')->whereIn('id_barang', $barangIds)->get();
    
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
        $nim = $request->nim;
        $nama = $request->nama_mahasiswa;

        $mahasiswa = Mahasiswa::where('nim', $nim)
            ->where('nama_mahasiswa', $nama)
            ->firstOrFail();

        $peminjaman = Peminjaman::with('barang')
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('status', '!=', 'Dikembalikan')
            ->get();

        // Simpan jumlah awal sekali (untuk rekapan)
        foreach ($peminjaman as $pinjam) {
            $key = "jumlah_awal_{$pinjam->id_peminjaman}";
            if (!session()->has($key)) {
                session()->put($key, $pinjam->jumlah);
            }
        }

        return view('peminjaman.kembalikan', compact('peminjaman', 'mahasiswa'));
    }

 public function kembalikanSemuaBarang(Request $request)
    {
        $request->validate([
            'id_mahasiswa' => 'required|exists:mahasiswa,id_mahasiswa'
        ]);

        $idMahasiswa = $request->id_mahasiswa;
        $mahasiswa = Mahasiswa::findOrFail($idMahasiswa);

        $peminjaman = Peminjaman::where('id_mahasiswa', $idMahasiswa)
            ->where('status', '!=', 'Dikembalikan')
            ->get();

        foreach ($peminjaman as $item) {
            $sessionKey = "jumlah_awal_{$item->id_peminjaman}";
            $jumlahAwal = session($sessionKey, $item->jumlah); // fallback
            $jumlahSekarang = $item->jumlah;

            $sisa = $jumlahAwal - $jumlahSekarang;

            if ($sisa > 0) {
                $barang = Barang::findOrFail($item->id_barang);
                $barang->stok += $sisa;
                $barang->save();
            }

            // Reset jumlah & update status
            $item->jumlah = $jumlahAwal;
            $item->status = 'Dikembalikan';
            $item->tanggal_kembali = now();
            $item->save();

            session()->forget($sessionKey);
        }

        return redirect()->route('peminjaman.kembalikanForm', [
            'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
            'nim' => $mahasiswa->nim,
        ])->with('success', 'Berhasil Mengembalikan Semua Item');
    }

    public function prosesKembalikan(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('mahasiswa')->findOrFail($id);

        $request->validate([
            'jumlah_kembalikan' => 'required|numeric|min:1|max:' . $peminjaman->jumlah
        ]);

        $jumlahKembalikan = $request->jumlah_kembalikan;

        // Simpan jumlah awal jika belum ada
        $sessionKey = "jumlah_awal_{$peminjaman->id_peminjaman}";
        if (!session()->has($sessionKey)) {
            session()->put($sessionKey, $peminjaman->jumlah);
        }

        // Tambahkan ke stok barang
        $barang = Barang::findOrFail($peminjaman->id_barang);
        $barang->stok += $jumlahKembalikan;
        $barang->save();

        // Kurangi jumlah
        $peminjaman->jumlah -= $jumlahKembalikan;

        if ($peminjaman->jumlah <= 0) {
            // Ambil jumlah awal
            $jumlahAwal = session($sessionKey, $jumlahKembalikan); // fallback

            // Reset jumlah ke awal hanya untuk keperluan rekapan
            $peminjaman->jumlah = $jumlahAwal;
            $peminjaman->status = 'Dikembalikan';
            $peminjaman->tanggal_kembali = now();

            // Hapus session
            session()->forget($sessionKey);
        } else {
            $peminjaman->status = 'Dikembalikan Sebagian';
        }

        $peminjaman->save();

        // Refresh data
        $mahasiswa = $peminjaman->mahasiswa;
        $peminjamanAll = Peminjaman::with('barang')
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('status', '!=', 'Dikembalikan')
            ->get();

        return view('peminjaman.kembalikan', [
            'peminjaman' => $peminjamanAll,
            'mahasiswa' => $mahasiswa,
        ])->with('success', 'Berhasil Mengembalikan Item');
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

    // Tambah jumlah
    public function update(Request $request)
    {
        $id = $request->id_barang;
        $jumlah = $request->jumlah;

        $cart = session('cart', []);

        if ($jumlah > 0) {
            $cart[$id] = [
                'id_barang' => $id,
                'jumlah' => $jumlah
            ];
        } else {
            unset($cart[$id]);
        }

        session(['cart' => $cart]);

        return response()->json(['message' => 'Cart updated']);
    }


}