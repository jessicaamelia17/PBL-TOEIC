<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratPengajuan;

class PengajuanSuratController extends Controller
{
    // Menampilkan halaman ajukan surat (teks + tombol)
    public function index()
    {
        return view('pengajuan-surat.index');
    }
    
    public function create()
    {
        return view('pengajuan-surat.create'); // Pastikan file ini nanti dibuat juga
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:255',
        ]);
    
        SuratPengajuan::create([
            'NIM' => auth()->user()->username, // atau 'nim', tergantung field login kamu
            'tanggal_pengajuan' => now(),
            'status_verifikasi' => 'Menunggu',
            'catatan' => $request->catatan,
        ]);
    
        return redirect()->route('surat.index')->with('success', 'Pengajuan surat berhasil dikirim.');
    }
    
}
