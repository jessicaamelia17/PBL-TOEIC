<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PageHistory
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('get') && !$request->ajax()) {
            $history = session()->get('page_history', []);
            $current = $request->fullUrl();

            // Tambah ke stack jika berbeda dari sebelumnya
            if (end($history) !== $current) {
                $history[] = $current;
                session(['page_history' => $history]);
            }
        }

        return $next($request);
    }
}
