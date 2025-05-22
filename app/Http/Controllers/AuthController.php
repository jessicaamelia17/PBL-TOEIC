<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|exists:mahasiswa,nim',
            'password' => 'required|string|min:8',
        ]);

        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

        if ($mahasiswa && Hash::check($request->password, $mahasiswa->password)) {
            Auth::login($mahasiswa);
            return redirect()->route('landing')->with('success', 'Login berhasil');
        }

        return back()->withErrors(['nim' => 'NIM atau password salah']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login-toeic')->with('success', 'Logout berhasil');
    }
}
