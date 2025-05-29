<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\PendaftarModel;

class AdminAuthController extends Controller
{
    // Dashboard Admin
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';
        $pendaftar = PendaftarModel::count();
        $kuota = DB::table('kuota')->where('id', 1)->value('kuota_total');

        return view('admin.dashboard', compact('breadcrumb', 'activeMenu', 'pendaftar', 'kuota'));
    }

    // Update kuota
    public function updateKuota(Request $request)
    {
        $request->validate([
            'jumlah_kuota' => 'required|integer|min:0',
        ]);

        DB::table('kuota')->updateOrInsert(
            ['id' => 1],
            [
                'kuota_total' => $request->jumlah_kuota,
                'status_pendaftaran' => 1,
                'updated_at' => now()
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Kuota berhasil diperbarui.'
        ]);
    }

    // Halaman login
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
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login berhasil',
                    'redirect' => url('/admin/home')
                ]);
            }

            return redirect('/admin/home');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Login gagal. Username atau password salah.'
            ]);
        }

        return redirect('/admin/login')->with('error', 'Username atau password salah');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Halaman registrasi
    public function register()
    {
        return view('admin.auth.register');
    }

    // Proses registrasi
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

    public function profile()
    {
        $admin = auth()->guard('admin')->user();

        $breadcrumb = (object)[
            'list' => ['Dashboard', 'Profil Admin']
        ];

        return view('admin.profil-admin.profile', compact('admin', 'breadcrumb'));
    }

    // Update profil admin
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Ambil ulang data admin menggunakan model agar bisa gunakan method save()
        $admin = Admin::find(auth()->guard('admin')->id());

        // Jika tidak ditemukan
        if (!$admin) {
            return back()->with('error', 'Admin tidak ditemukan.');
        }

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
