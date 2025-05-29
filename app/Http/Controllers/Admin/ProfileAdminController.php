<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileAdminController extends Controller
{
    public function show()
    {
        $admin = auth()->guard('admin')->user();

        return view('admin.profil-admin.profile', [
            'admin' => $admin,
            'breadcrumb' => (object)[ 'list' => ['Dashboard', 'Profil'] ],
        ]);
    }

    public function edit()
    {
        $admin = auth()->guard('admin')->user();

        return view('admin.profil-admin.edit', [
            'admin' => $admin,
            'breadcrumb' => (object)[ 'list' => ['Dashboard', 'Profil', 'Edit'] ],
        ]);
    }

    public function update(Request $request)
    {
        $admin = auth()->guard('admin')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->Id_Admin,
            'password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|max:2048',
        ]);

        $admin->nama = $request->nama;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($admin->foto && Storage::exists('public/foto_admin/' . $admin->foto)) {
                Storage::delete('public/foto_admin/' . $admin->foto);
            }

            $path = $request->file('foto')->store('public/foto_admin');
            $admin->foto = basename($path);
        }

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}