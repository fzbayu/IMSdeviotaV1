<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckMahasiswaSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah mahasiswa sudah login
        if (!session()->has('login_mahasiswa')) {
            // Script untuk menghapus localStorage
            $script = "<script>localStorage.removeItem('sessionStartTime');</script>";
            
            return redirect()->route('login.form')
                ->with('error', 'Silakan login terlebih dahulu.')
                ->with('script', $script);
        }

        // Periksa timeout session backend
        $lastActivity = session('login_mahasiswa.last_activity');
        $currentTime = Carbon::now()->timestamp;
        $sessionTimeout = config('session.lifetime', 1) * 60; // dalam detik (1 menit default)
        
        // Jika tidak ada aktivitas selama waktu yang ditentukan
        if (($currentTime - $lastActivity) > $sessionTimeout) {
            // Script untuk menghapus sessionStartTime dari localStorage dan menampilkan alert
            $script = "
            <script>
                localStorage.removeItem('sessionStartTime');
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
            </script>";
            
            session()->forget('login_mahasiswa');
            
            return redirect()->route('login.form')
                ->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.')
                ->with('script', $script);
        }
        
        // Update waktu aktivitas terakhir untuk menjaga session PHP tetap hidup
        session(['login_mahasiswa.last_activity' => $currentTime]);
        
        return $next($request);
    }
}