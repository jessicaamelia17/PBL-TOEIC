<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        if (Auth::guard('admin')->check()) { // Jika sudah login, maka redirect ke halaman home
            return redirect('/admin/home');
        }
        return view('auth.login');
    }

    // Proses login
    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::guard('admin')->attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return redirect('/');
    }

    // Logout admin
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('admin/login');
    }

    // Menampilkan halaman registrasi admin
    public function register()
    {
        return view('admin.auth.register');
    }

    // Proses menyimpan data admin baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:admin,username',
            'password' => 'required|min:5',
        ]);

        // Menyimpan admin baru
        Admin::create([
            'username' => $request->username,
            'password' => bcrypt($request->password), // Enkripsi password
        ]);

        // Mengirim respons JSON jika permintaan AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Registrasi Berhasil',
                'redirect' => url('admin/login')
            ]);
        }

        // Jika bukan AJAX, redirect ke halaman login dengan flash message
        return redirect('admin/login')->with('success', 'Registrasi berhasil');
    }
}
