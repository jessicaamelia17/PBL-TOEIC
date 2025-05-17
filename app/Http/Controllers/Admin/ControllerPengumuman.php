<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerPengumuman extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Pengumuman',
            'list' => ['Home', 'Pengumuman']
        ];

        $activeMenu = 'pengumuman';

        $pengumuman = Pengumuman::with('admin')->latest()->get();

        return view('admin.pengumuman.index', compact('pengumuman', 'breadcrumb', 'activeMenu'));
    }


    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Upload Pengumuman',
            'list' => ['Home', 'Pengumuman', 'Upload']
        ];

        $activeMenu = 'pengumuman'; // Tambahkan ini agar tidak error

        return view('admin.pengumuman.create', compact('breadcrumb', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_pengumuman' => 'required|date',
        ]);

        // Tambahkan ini sementara untuk debug
        dd(Auth::guard('admin')->id());

        Pengumuman::create([
            'Judul' => $request->judul,
            'Isi' => $request->isi,
            'Tanggal_Pengumuman' => $request->tanggal_pengumuman,
            'Created_By' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
