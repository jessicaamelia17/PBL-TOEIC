<?php

namespace App\Http\Controllers;

use App\Models\JurusanModel;
use App\Models\ProdiModel;
use App\Models\JadwalUjianModel;
use App\Models\RegistrasiModel;
use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function create()
    {
        $jurusan = JurusanModel::all();
        return view('registrasi.index', compact('jurusan'));
    }


    public function getProdi($idJurusan)
    {
        $prodi = ProdiModel::where('Id_Jurusan', $idJurusan)->get();
        return response()->json($prodi);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NIM' => 'required|string|max:20|unique:pendaftaran_toeic,NIM',
            'Nama' => 'required|string|max:100',
            'No_WA' => 'required|string|max:15',
            'email' => 'required|email|max:100',
            'Id_Jurusan' => 'required|exists:jurusan,Id_Jurusan',
            'Id_Prodi' => 'required|exists:prodi,Id_Prodi',
            'Scan_KTP' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'Scan_KTM' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'Pas_Foto' => 'required|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        // Cari jadwal yang masih tersedia kuota
        $jadwal = JadwalUjianModel::where('status_registrasi', 1)
            ->whereColumn('kuota_terpakai', '<', 'kuota_max')
            ->orderBy('Tanggal_Ujian', 'asc')
            ->first();

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Semua jadwal sudah penuh. Silakan coba lagi nanti.'
            ], 422);
        }

        $ktpPath = $request->file('Scan_KTP')->store('uploads/ktp', 'public');
        $ktmPath = $request->file('Scan_KTM')->store('uploads/ktm', 'public');
        $pasFotoPath = $request->file('Pas_Foto')->store('uploads/pas_foto', 'public');

        RegistrasiModel::create([
            'NIM' => $validated['NIM'],
            'Nama' => $validated['Nama'],
            'No_WA' => $validated['No_WA'],
            'email' => $validated['email'],
            'Id_Jurusan' => $validated['Id_Jurusan'],
            'Id_Prodi' => $validated['Id_Prodi'],
            'Scan_KTP' => $ktpPath,
            'Scan_KTM' => $ktmPath,
            'Pas_Foto' => $pasFotoPath,
            'Tanggal_Pendaftaran' => now(),
            'ID_Jadwal' => $jadwal->Id_Jadwal,
        ]);

        $jadwal->increment('kuota_terpakai');

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil untuk tanggal ujian: ' . date('d-m-Y', strtotime($jadwal->Tanggal_Ujian)) . '. Silakan tunggu pengumuman sesi dan room melalui WhatsApp atau Email.'
        ]);
    }



    public function checkNIM($nim)
    {
        $exists = RegistrasiModel::where('NIM', $nim)->exists();

        return response()->json([
            'available' => !$exists
        ]);
    }
}
