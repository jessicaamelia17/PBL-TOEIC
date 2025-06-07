<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
            'breadcrumb' => (object)['list' => ['Dashboard', 'Profil']],
        ]);
    }

    public function edit()
    {
        $admin = auth()->guard('admin')->user();

        return view('admin.profil-admin.edit', [
            'admin' => $admin,
            'breadcrumb' => (object)['list' => ['Dashboard', 'Profil', 'Edit']],
        ]);
    }

    public function update(Request $request)
    {
        $admin = Admin::find(auth()->guard('admin')->id());

        $request->validate([
            'Username' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin,email,' . $admin->Id_Admin . ',Id_Admin',
            'no_hp' => 'nullable|string|max:20',
            'Password' => 'nullable|min:8|confirmed',
            'foto' => 'nullable|image|max:2048',
        ]);

        $admin->Username = $request->Username;
        $admin->nama = $request->nama;
        $admin->email = $request->email;
        $admin->no_hp = $request->no_hp;

        if ($request->filled('Password')) {
            $admin->Password = Hash::make($request->Password);
        }

        if ($request->hasFile('foto')) {
            if ($admin->foto && Storage::exists('public/foto_admin/' . $admin->foto)) {
                Storage::delete('public/foto_admin/' . $admin->foto);
            }
            $path = $request->file('foto')->store('public/foto_admin');
            $admin->foto = basename($path);
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
