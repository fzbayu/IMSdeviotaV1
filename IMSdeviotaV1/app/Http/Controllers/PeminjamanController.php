<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use App\Models\FotoPengembalian;
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
            ->whereIn('tipe', ['Barang Dipinjam', 'Barang Diambil dan Dipinjam'])
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
            'kontak' => 'required',
            'tanggal_kembali' => 'required|date',
        ]);

        $cart = session('cart', []);

        // Ambil data mahasiswa dari session login
        $loginData = session('login_mahasiswa');
        $nim = $loginData['nim'] ?? null;
        $nama = $loginData['nama'] ?? null;

        if (!$nim || !$nama) {
            return redirect()->route('login.form')->with('error', 'Sesi login tidak ditemukan. Silakan login kembali.');
        }

        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($mahasiswa) {
            // Validasi nama juga agar tidak sembarangan login palsu
            if (strtolower(trim($mahasiswa->nama_mahasiswa)) !== strtolower(trim($nama))) {
                return redirect()->back()
                    ->with('error', 'Data login tidak valid.')
                    ->withInput();
            }

            // Update kontak jika berubah
            $mahasiswa->kontak = $validated['kontak'];
            $mahasiswa->save();
        } else {
            // Mahasiswa tidak ditemukan padahal login sukses => buat baru
            $mahasiswa = Mahasiswa::create([
                'nim' => $nim,
                'nama_mahasiswa' => $nama,
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
                'tanggal_pengembalian' => $validated['tanggal_kembali'], // ← ini benar
                'status' => 'Dipinjam',
            ]);

            $barang->stok -= $item['jumlah'];
            $barang->save();
        }

        session()->forget('cart');

        return redirect()->route('keranjang')->with('success', 'Peminjaman berhasil!');
    }

    public function directKembalikan()
    {
        // Get data from session
        $loginData = session('login_mahasiswa');

        if (!$loginData) {
            return redirect()->route('login.form')->with('error', 'Sesi login tidak ditemukan. Silakan login kembali.');
        }

        $nim = $loginData['nim'];
        $nama = $loginData['nama'];

        // Find mahasiswa by NIM
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa || strtolower(trim($mahasiswa->nama_mahasiswa)) !== strtolower(trim($nama))) {
            return redirect()->route('login.form')
                ->withErrors(['not_found' => 'Data tidak ditemukan. Silakan login kembali.']);
        }

        // Get peminjaman data
        $peminjaman = Peminjaman::with('barang')
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('status', '!=', 'Dikembalikan')
            ->where('status', '!=', 'Telat')
            ->get();

        // Save initial quantities for tracking
        foreach ($peminjaman as $pinjam) {
            $key = "jumlah_awal_{$pinjam->id_peminjaman}";
            if (!session()->has($key)) {
                session()->put($key, $pinjam->jumlah);
            }
        }

        return view('peminjaman.kembalikan', compact('peminjaman', 'mahasiswa'));
    }

    public function formKembalikan(Request $request)
    {
        // If request comes with NIM and name (from a form)
        if ($request->filled('nim') && $request->filled('nama_mahasiswa')) {
            $nim = $request->nim;
            $nama = $request->nama_mahasiswa;
        } else {
            // Otherwise use session data
            $loginData = session('login_mahasiswa');

            if (!$loginData) {
                return redirect()->route('login.form')
                    ->with('error', 'Sesi login tidak ditemukan. Silakan login kembali.');
            }

            $nim = $loginData['nim'];
            $nama = $loginData['nama'];
        }

        $mahasiswa = Mahasiswa::where('nim', $nim)
            ->where('nama_mahasiswa', $nama)
            ->firstOrFail();

        $peminjaman = Peminjaman::with('barang')
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('status', '!=', 'Dikembalikan')
            ->where('status', '!=', 'Telat')
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
            'id_mahasiswa' => 'required|exists:mahasiswa,id_mahasiswa',
            'foto_pengembalian' => 'required|array',
            'foto_pengembalian.*' => 'image|mimes:jpeg,png,jpg|max:500', // 500MB
        ]);

        $idMahasiswa = $request->id_mahasiswa;
        $mahasiswa = Mahasiswa::findOrFail($idMahasiswa);

        $peminjaman = Peminjaman::where('id_mahasiswa', $idMahasiswa)
            ->where('status', '!=', 'Dikembalikan')
            ->where('status', '!=', 'Telat')
            ->get();

        DB::beginTransaction();
        try {
            foreach ($peminjaman as $item) {
                $jumlahSekarang = $item->jumlah;

                if (!session()->has("jumlah_awal_{$item->id_peminjaman}")) {
                    session()->put("jumlah_awal_{$item->id_peminjaman}", $jumlahSekarang);

                    $barang = Barang::findOrFail($item->id_barang);
                    $barang->stok += $jumlahSekarang;
                    $barang->save();
                }

                // Simpan multiple foto
                if ($request->hasFile('foto_pengembalian')) {
                    foreach ($request->file('foto_pengembalian') as $file) {
                        $path = $file->store('uploads/pengembalian', 'public');
                        FotoPengembalian::create([
                            'id_peminjaman' => $item->id_peminjaman,
                            'foto' => $path,
                            'keterangan' => 'Pengembalian semua barang'
                        ]);
                    }
                }

                // Set tanggal kembali
                $tanggalKembali = now();
                $item->tanggal_kembali = $tanggalKembali;

                // Periksa jika pengembalian telat
                if ($tanggalKembali > $item->tanggal_pengembalian) {
                    $item->status = 'Telat';
                } else {
                    $item->status = 'Dikembalikan';
                }

                $item->save();
                session()->forget("jumlah_awal_{$item->id_peminjaman}");
            }

            DB::commit();
            return redirect()->route('peminjaman.kembalikanForm', [
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                'nim' => $mahasiswa->nim,
            ])->with('success', 'Berhasil Mengembalikan Semua Item');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengembalikan barang: ' . $e->getMessage());
        }
    }


    public function prosesKembalikan(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('mahasiswa')->findOrFail($id);

        $request->validate([
            'jumlah_kembalikan' => 'required|numeric|min:1|max:' . $peminjaman->jumlah,
            'foto_pengembalian' => 'required|array',
            'foto_pengembalian.*' => 'image|mimes:jpeg,png,jpg|max:500', // 500MB
        ]);

        DB::beginTransaction();
        try {
            $jumlahKembalikan = $request->jumlah_kembalikan;

            // Simpan jumlah awal jika belum ada
            $sessionKey = "jumlah_awal_{$peminjaman->id_peminjaman}";
            if (!session()->has($sessionKey)) {
                session()->put($sessionKey, $peminjaman->jumlah);
            }

            // Upload multiple foto
            if ($request->hasFile('foto_pengembalian')) {
                foreach ($request->file('foto_pengembalian') as $file) {
                    $path = $file->store('uploads/pengembalian', 'public');
                    FotoPengembalian::create([
                        'id_peminjaman' => $peminjaman->id_peminjaman,
                        'foto' => $path,
                        'keterangan' => 'Pengembalian sebagian'
                    ]);
                }
            }

            $barang = Barang::findOrFail($peminjaman->id_barang);
            $peminjaman->jumlah -= $jumlahKembalikan;
            $barang->stok += $jumlahKembalikan;
            $barang->save();

            if ($peminjaman->jumlah <= 0) {
                $jumlahAwal = session($sessionKey, $jumlahKembalikan);
                $peminjaman->jumlah = $jumlahAwal;
                $tanggalKembali = now();
                $peminjaman->tanggal_kembali = $tanggalKembali;

                if ($tanggalKembali > $peminjaman->tanggal_pengembalian) {
                    $peminjaman->status = 'Telat';
                } else {
                    $peminjaman->status = 'Dikembalikan';
                }
                session()->forget($sessionKey);
            } else {
                $peminjaman->status = 'Dikembalikan Sebagian';
            }

            $peminjaman->save();

            DB::commit();

            $mahasiswa = $peminjaman->mahasiswa;
            $peminjamanAll = Peminjaman::with('barang')
                ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                ->where('status', '!=', 'Dikembalikan')
                ->where('status', '!=', 'Telat')
                ->get();

            return redirect()->route('peminjaman.kembalikanForm', [
                'nama_mahasiswa' => $mahasiswa->nama_mahasiswa,
                'nim' => $mahasiswa->nim,
            ])->with('success', 'Berhasil Mengembalikan Item');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengembalikan barang: ' . $e->getMessage());
        }
    }


    public function show_riwayat_peminjaman(Request $request)
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

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('mahasiswa', function ($q) use ($searchTerm) {
                $q->where('nama_mahasiswa', 'like', "%{$searchTerm}%")
                    ->orWhere('nim', 'like', "%{$searchTerm}%");
            });
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

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:peminjaman,id_peminjaman'
        ]);

        try {
            Peminjaman::whereIn('id_peminjaman', $request->ids)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function deleteAll()
    {
        try {
            Peminjaman::truncate();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
