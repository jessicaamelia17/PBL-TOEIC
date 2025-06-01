<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPendaftar;

class RiwayatController extends Controller
{
    public function index()
    {
        $nimLogin = Auth::user()->nim; // NIM mahasiswa yang login
    
        $riwayat = RiwayatPendaftar::with(['pendaftaran', 'jadwal', 'hasil', 'sertifikat'])
            ->whereHas('pendaftaran', function ($query) use ($nimLogin) {
                $query->where('nim', $nimLogin);
            })
            ->get();
    
        return view('riwayat.index', compact('riwayat'));
    }
    
    public function tampilRiwayat()
{
    $nimLogin = Auth::user()->nim; // asumsi NIM ada di user login

    // Ambil riwayat peserta yang punya pendaftaran dan hasil sesuai nim login
    $riwayat = RiwayatPendaftar::with(['pendaftaran', 'jadwal', 'hasil', 'sertifikat'])
        ->whereHas('pendaftaran', function ($query) use ($nimLogin) {
            $query->where('nim', $nimLogin);
        })
        ->get();

    return view('riwayat.index', compact('riwayat'));
}
}