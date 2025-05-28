<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $login = $request->login;
        $password = $request->password;

        // Cek apakah input angka semua (NIM Mahasiswa)
        if (ctype_digit($login)) {
            $mahasiswa = Mahasiswa::where('nim', $login)->first();
            if ($mahasiswa && Hash::check($password, $mahasiswa->password)) {
                Auth::guard('web')->login($mahasiswa);
                return redirect()->route('landing')->with('success', 'Login Mahasiswa berhasil');
            }
        } else {
            // Admin login
            $admin = Admin::where('Username', $login)->first();
            if ($admin && Hash::check($password, $admin->Password)) {
                Auth::guard('admin')->login($admin);
                return redirect()->route('admin.dashboard')->with('success', 'Login Admin berhasil');
            }
        }

        return back()->withErrors(['login' => 'Username/NIM atau password salah']);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing')->with('success', 'Logout berhasil');
    }
}
