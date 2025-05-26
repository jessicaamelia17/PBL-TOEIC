<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratPengajuan;
use App\Models\Mahasiswa;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('nim', $user->nim)->first();
    
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
    
        $pengajuan = SuratPengajuan::where('nim', $mahasiswa->nim)->latest()->first();
    
        return view('pengajuan-surat.index', compact('mahasiswa', 'pengajuan'));
    }

    public function store(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $existing = SuratPengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'menunggu')->first();
        if ($existing) {
            return back()->with('error', 'Anda sudah memiliki pengajuan yang sedang diproses.');
        }

        SuratPengajuan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'tanggal_pengajuan' => now(),
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim.');
    }
    
}
