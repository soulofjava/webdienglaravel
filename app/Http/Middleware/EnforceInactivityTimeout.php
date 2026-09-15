<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnforceInactivityTimeout
{
    /**
     * Batas waktu inaktivitas maksimal (dalam detik).
     * Standar keamanan OWASP / Finansial: 15 menit = 900 detik.
     */
    protected int $timeoutSeconds = 900;

    /**
     * Tangani request yang masuk dan verifikasi waktu inaktivitas sesi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = $request->session()->get('last_activity_time');
            $currentTime = time();

            // Jika ada catatan aktivitas sebelumnya dan melebihi ambang batas inaktivitas
            if ($lastActivity && ($currentTime - $lastActivity) > $this->timeoutSeconds) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Sesi Anda telah berakhir secara otomatis karena tidak ada aktivitas selama 15 menit.',
                        'session_expired' => true,
                    ], 401);
                }

                return redirect()->route('login')->with('warning', 'Sesi Anda telah ditutup secara otomatis karena tidak ada aktivitas selama 15 menit demi menjaga keamanan akun.');
            }

            // Perbarui penanda waktu aktivitas terakhir
            $request->session()->put('last_activity_time', $currentTime);
        }

        return $next($request);
    }
}
