<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengumuman;
use App\Models\RiwayatPendaftar;
use App\Models\PendaftarModel;
use App\Models\PengambilanSertifikat;

class LandingController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::orderBy('Tanggal_Pengumuman', 'desc')->get();
        $riwayat = collect();

        if (auth()->check()) {
            $nimLogin = auth()->user()->nim;
            $riwayat = RiwayatPendaftar::with([
                    'pendaftaran.jadwal_ujian',
                    'pendaftaran.hasil',
                    'pendaftaran.hasil.pengambilanSertifikat'
                ])
                ->whereHas('pendaftaran', function ($query) use ($nimLogin) {
                    $query->where('nim', $nimLogin);
                })
                ->get();
        }

        return view('welcome', compact('pengumuman', 'riwayat'));
    }

// Saat pendaftar mendaftar → tetap bikin RiwayatPendaftar
public function storePendaftaran(Request $request)
{
    $validated = $request->validate([
        'nim' => 'required|string|max:20',
        'nama' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'no_hp' => 'required|string|max:20',
        'id_jadwal' => 'required|exists:jadwal_ujian,id',
    ]);

    $pendaftaran = PendaftarModel::create($validated);

    RiwayatPendaftar::create([
        'ID_Pendaftaran' => $pendaftaran->Id_Pendaftaran,
    ]);

    return redirect()->back()->with('success', 'Pendaftaran berhasil!');
}


    // 2. Saat hasil ujian keluar
    public function updateHasil($id_pendaftaran, $id_hasil)
    {
        RiwayatPendaftar::where('ID_Pendaftaran', $id_pendaftaran)
            ->update(['ID_Hasil' => $id_hasil]);
    }

    // 3. Saat sertifikat diambil
    public function updatePengambilan($id_pendaftaran, $id_pengambilan)
    {
        $pengambilan = PengambilanSertifikat::find($id_pengambilan);
    
        if ($pengambilan && $pengambilan->status === 'diambil') {
            RiwayatPendaftar::where('ID_Pendaftaran', $id_pendaftaran)
                ->update(['id_pengambilan' => $id_pengambilan]);
        }
    }
}