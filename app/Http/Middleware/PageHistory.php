<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PageHistory
{
    public function handle(Request $request, Closure $next)
    {
        // Jangan simpan untuk permintaan AJAX, POST, atau file
        if ($request->method() === 'GET' && !$request->ajax() && !$request->is('go-back')) {
            $history = session()->get('page_history', []);
            $current = $request->fullUrl();

            // Hindari duplikat berturut-turut
            if (end($history) !== $current) {
                $history[] = $current;
                // Batasi history agar tidak terlalu panjang
                if (count($history) > 10) {
                    array_shift($history);
                }
                session(['page_history' => $history]);
            }
        }
        return $next($request);
    }
}
