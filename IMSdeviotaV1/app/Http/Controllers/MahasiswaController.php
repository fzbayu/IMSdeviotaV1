<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    protected $sessionTimeout = 1; // timeout dalam menit (diubah dari 5 menit ke 1 menit)
    
    public function showLoginForm()
    {
        // Pastikan selalu menghapus data session lama
        session()->forget('login_mahasiswa');
        
        // Selalu tambahkan script untuk menghapus localStorage
        return view('login')->with('script', '<script>localStorage.removeItem("sessionStartTime");</script>');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
        ]);
        
        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();
        
        if ($mahasiswa) {
            if (strtolower(trim($mahasiswa->nama_mahasiswa)) !== strtolower(trim($request->nama))) {
                return back()->with('error', 'Nama tidak sesuai dengan NIM.')
                    ->with('script', '<script>localStorage.removeItem("sessionStartTime");</script>');
            }
        } else {
            $mahasiswa = Mahasiswa::create([
                'nim' => $request->nim,
                'nama_mahasiswa' => $request->nama,
                'kontak' => ''
            ]);
        }
        
        // Hapus semua session sebelumnya untuk memastikan bersih
        session()->forget('login_mahasiswa');
        
        // Set login time untuk timestamp
        $loginTime = now();
        
        // Tambahkan identifier unik untuk session ini
        $sessionId = uniqid('session_', true);
        
        session([
            'login_mahasiswa' => [
                'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama_mahasiswa,
                'login_time' => $loginTime,
                'last_activity' => $loginTime->timestamp,
                'php_session_id' => $sessionId // ID unik untuk membantu fresh state
            ]
        ]);
        
        // Set session timeout
        config(['session.lifetime' => $this->sessionTimeout]);
        
        return redirect()->route('welcome');
    }
    
    public function logout()
    {
        // Script untuk menghapus localStorage
        $script = "<script>localStorage.removeItem('sessionStartTime');</script>";
        
        session()->forget('login_mahasiswa');
        
        // Return dengan script yang akan dijalankan di halaman login
        return response(view('login')
            ->with('success', 'Berhasil logout.')
            ->with('script', $script));
    }
    
    // Method untuk memperpanjang sesi (bisa dipanggil dari AJAX)
    public function extendSession(Request $request)
    {
        if (session()->has('login_mahasiswa')) {
            // Hanya update last_activity untuk menjaga PHP session tetap hidup
            session(['login_mahasiswa.last_activity' => Carbon\Carbon::now()->timestamp]);
            return response()->json(['status' => 'success']);
        }
        
        return response()->json(['status' => 'error']);
    }
    
    // Middleware untuk memeriksa timeout session
    public function checkSessionTimeout()
    {
        if (session()->has('login_mahasiswa')) {
            $lastActivity = session('login_mahasiswa.last_activity');
            $currentTime = Carbon::now()->timestamp;
            
            // Jika tidak ada aktivitas selama 1 menit (60 detik)
            if (($currentTime - $lastActivity) > ($this->sessionTimeout * 60)) {
                // Script untuk menghapus sessionStartTime dari localStorage dan menampilkan pesan
                $script = "
                <script>
                    localStorage.removeItem('sessionStartTime');
                    alert('Sesi Anda telah berakhir. Silakan login kembali.');
                </script>";
                
                session()->forget('login_mahasiswa');
                
                return response(view('login')
                    ->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.')
                    ->with('script', $script));
            }
        }
        
        return true;
    }
}