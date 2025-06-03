<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\KepalaUPABahasa;

class KepalaUPABahasaController extends Controller
{
    public function index()
    {
        $kepalas = KepalaUPABahasa::all();
        return view('admin.kepala.index', compact('kepalas'));
    }
    public function activate($id)
{
    // Nonaktifkan semua dulu
    KepalaUPABahasa::where('is_active', true)->update(['is_active' => false]);

    // Aktifkan kepala baru
    $kepala = KepalaUPABahasa::findOrFail($id);
    $kepala->is_active = true;
    $kepala->save();

    return redirect()->route('kepala.index')->with('success', 'Kepala UPA Bahasa berhasil diaktifkan.');
}

 public function create()
{
    return view('admin.kepala.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'nip' => 'required|string|max:30',
        'pangkat' => 'required|string|max:100',
        'jabatan' => 'required|string|max:100',
        'ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
    ]);

    // Upload TTD jika ada
    if ($request->hasFile('ttd')) {
        $path = $request->file('ttd')->store('ttd_kepala', 'public');
        $validated['ttd_path'] = $path;
    }

    $validated['is_active'] = false; // Default tidak aktif
    KepalaUPABahasa::create($validated);

    return redirect()->route('kepala.index')->with('success', 'Data kepala berhasil ditambahkan.');
}

}