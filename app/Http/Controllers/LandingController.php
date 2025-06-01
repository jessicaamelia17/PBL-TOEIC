<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use App\Models\RiwayatPendaftar;

class LandingController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::orderBy('Tanggal_Pengumuman', 'desc')->get();

        // Selalu definisikan $riwayat agar tidak undefined di view
        $riwayat = collect();
        if (auth()->check()) {
            $riwayat = RiwayatPendaftar::with(['pendaftaran', 'jadwal', 'hasil', 'sertifikat'])
                ->whereHas('pendaftaran', function($q) {
                    $q->where('NIM', auth()->user()->nim);
                })->get();
        }

        return view('welcome', compact('pengumuman', 'riwayat'));
    }
}