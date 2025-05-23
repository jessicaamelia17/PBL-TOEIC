<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
            if (! $request->expectsJson()) {
        // Cek jika URL mengandung 'admin' => redirect ke login admin
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('login'); // route ke /login (admin)
        }

        // Selain itu anggap sebagai mahasiswa
        return route('login-toeic'); // route ke /login-toeic (mahasiswa)
    }

    return null;
    }
}
