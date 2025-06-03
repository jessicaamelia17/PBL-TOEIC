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
        $breadcrumb = (object)[
            'list' => ['Admin', 'Kepala UPA Bahasa']
        ];

        $activeMenu = 'kepala';
        return view('admin.kepala.index', compact('kepalas', 'breadcrumb', 'activeMenu'));
    }
    
        public function edit($id)
        {
            $kepala = KepalaUPABahasa::findOrFail($id);
            $breadcrumb = (object)[
                'list' => ['Admin', 'Kepala UPA Bahasa', 'Edit']
            ];
            return view('admin.kepala.edit', compact('kepala', 'breadcrumb'));
        }
    
        public function update(Request $request, $id)
        {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'nip' => 'required|string|max:30',
                'pangkat' => 'required|string|max:100',
                'jabatan' => 'required|string|max:100',
                'ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            ]);
    
            $kepala = KepalaUPABahasa::findOrFail($id);
    
            if ($request->hasFile('ttd')) {
                $path = $request->file('ttd')->store('ttd_kepala', 'public');
                $validated['ttd_path'] = $path;
            }
    
            $kepala->update($validated);
    
            return redirect()->route('admin.kepala.index')->with('success', 'Data kepala berhasil diupdate.');
        }
    
        public function setActive($id)
        {
            // Nonaktifkan semua kepala
            KepalaUPABahasa::where('is_active', true)->update(['is_active' => false]);
    
            // Aktifkan kepala yang dipilih
            $kepala = KepalaUPABahasa::findOrFail($id);
            $kepala->is_active = true;
            $kepala->save();
    
            return redirect()->route('admin.kepala.index')->with('success', 'Status kepala berhasil diubah.');
        }
        public function setNonActive($id)
{
    $kepala = KepalaUPABahasa::findOrFail($id);
    $kepala->is_active = false;
    $kepala->save();

    return redirect()->route('admin.kepala.index')->with('success', 'Kepala berhasil dinonaktifkan.');
}

    public function create()
    {
        $breadcrumb = (object)[
            'list' => ['Admin', 'Kepala UPA Bahasa', 'Tambah']
        ];
        return view('admin.kepala.create', compact('breadcrumb'));
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

        return redirect()->route('admin.kepala.index')->with('success', 'Data kepala berhasil ditambahkan.');
    }
}
