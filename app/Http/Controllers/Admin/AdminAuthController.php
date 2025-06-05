<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\PendaftarModel;
use Illuminate\Support\Facades\Storage;

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
        $status_pendaftaran = DB::table('kuota')->where('id', 1)->value('status_pendaftaran'); // Tambahkan baris ini

        return view('admin.dashboard', compact('breadcrumb', 'activeMenu', 'pendaftar', 'kuota', 'status_pendaftaran'));
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

    public function updateStatusPendaftaran(Request $request)
    {
        $request->validate([
            'status_pendaftaran' => 'required|in:0,1',
        ]);

        DB::table('kuota')->where('id', 1)->update([
            'status_pendaftaran' => $request->status_pendaftaran,
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Status pendaftaran berhasil diubah.'
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
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'Username' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'Password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $admin = Admin::find(auth()->guard('admin')->id());

        if (!$admin) {
            return back()->with('error', 'Admin tidak ditemukan.');
        }

        $admin->nama = $request->nama;
        $admin->email = $request->email;
        $admin->Username = $request->Username;
        $admin->no_hp = $request->no_hp;

        if ($request->filled('Password')) {
            $admin->Password = Hash::make($request->Password);
        }

        // Proses upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($admin->foto && Storage::disk('public')->exists('foto_admin/' . $admin->foto)) {
                Storage::disk('public')->delete('foto_admin/' . $admin->foto);
            }
            $file = $request->file('foto');
            $filename = uniqid('admin_') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto_admin', $filename, 'public');
            $admin->foto = $filename;
        }

        $admin->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
