<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah terautentikasi
        if (!auth()->check()) {
            return redirect()->route('admin.login')->withErrors(['message' => 'Silakan login terlebih dahulu.']);
        }

        // Ambil role admin dari model user yang sedang login
        $user_role = $request->user()->role; // Asumsi kamu menyimpan role pada kolom 'role' di tabel users

        // Cek apakah role adalah admin
        if ($user_role !== 'admin') {
            // Jika bukan admin, tampilkan error 403
            abort(403, 'Forbidden. Kamu tidak punya akses ke halaman ini');
        }

        // Jika role adalah admin, lanjutkan request
        return $next($request);
    }
}
