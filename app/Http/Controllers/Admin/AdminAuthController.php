<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Models\PendaftarModel;

class AdminAuthController extends Controller
{
    // Halaman dashboard admin
public function index()
{
            $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';
        
        $pendaftar = PendaftarModel::count();
        $kuota = 3144;

        return view('admin.dashboard', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'pendaftar' => $pendaftar,
            'kuota' => $kuota
        ]);
}


    // Menampilkan halaman login
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/home');
        }
        return view('auth.login');
    }

    // Proses login
    public function postlogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Jika permintaan AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login berhasil',
                    'redirect' => url('/admin/home')
                ]);
            }

            // Jika bukan AJAX
            return redirect('/admin/home');
        }

        // Jika gagal login
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Login gagal. Username atau password salah.'
            ]);
        }

        return redirect('/admin/login')->with('error', 'Username atau password salah');
    }

    // Logout admin
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // logout dari guard admin
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // redirect ke halaman login admin
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

        Admin::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Registrasi berhasil',
                'redirect' => url('admin/login')
            ]);
        }

        return redirect('admin/login')->with('success', 'Registrasi berhasil');
    }

        
}
