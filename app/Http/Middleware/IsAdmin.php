<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * Middleware lapis kedua: memastikan user yang sudah login
     * memiliki role 'admin'. Jika tidak, sesi di-flush dan
     * browser diarahkan kembali ke halaman login.
     *
     * Dipasang sebagai alias 'admin' di bootstrap/app.php dan
     * digunakan dalam grup ['auth', 'admin'] di routes/web.php.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user telah login DAN memiliki role admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Paksa logout jika user login tapi bukan admin
        if (auth()->check()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Redirect ke halaman login dengan pesan penolakan
        return redirect()->route('admin.login')->withErrors([
            'email' => 'Akses ditolak. Anda tidak memiliki hak akses sebagai Admin.',
        ]);
    }
}
