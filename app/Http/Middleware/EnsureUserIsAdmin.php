<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     * Pastikan user yang terautentikasi memiliki role 'admin'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, logout dan arahkan ke halaman login
        auth()->logout();
        return redirect()->route('admin.login')->withErrors([
            'email' => 'Akses ditolak. Anda tidak memiliki hak akses Admin.',
        ]);
    }
}
