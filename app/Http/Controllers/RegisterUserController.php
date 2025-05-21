<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Admin;


class RegisterUserController extends Controller
{
    public function showRegister()
    {
        return view('auth.register'); // Menampilkan form registrasi
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'username' => 'required|unique:users,username',
        'password' => 'required|min:6|confirmed',
        'nim' => 'required|unique:users,nim|min:10',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Gunakan transaksi agar NIM masuk ke mahasiswa dan users secara bersamaan
    DB::transaction(function () use ($request) {
        // Simpan data mahasiswa terlebih dahulu
        Mahasiswa::create([
            'nim' => $request->nim,
        ]);

        // Simpan user dengan FK ke mahasiswa
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'nim' => $request->nim, // NIM terhubung ke mahasiswa
        ]);
    });

    return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');

    }
}
