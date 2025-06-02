<?php

namespace App\Http\Controllers;

use App\Models\JurusanModel;
use App\Models\ProdiModel;
use App\Models\JadwalUjianModel;
use App\Models\RegistrasiModel;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\RiwayatPendaftar;

class RegistrasiController extends Controller
{
    public function create()
    {
        $jurusan = JurusanModel::all();
        $mahasiswa = Mahasiswa::where('NIM', auth()->user()->nim)->first();
        //dd($mahasiswa);
         // Cek apakah sudah pernah mendaftar
         $pendaftaran = RegistrasiModel::with('jadwal')
         ->where('NIM', $mahasiswa->nim)
         ->latest('Tanggal_Pendaftaran')
         ->first();
        return view('registrasi.index', compact('jurusan','mahasiswa','pendaftaran'));
    }


    public function getProdi($idJurusan)
    {
        $prodi = ProdiModel::where('Id_Jurusan', $idJurusan)->get();
        return response()->json($prodi);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NIM' => ['required', 'regex:/^\d{10,}$/', 'unique:pendaftaran_toeic,NIM'],
            'Scan_KTP' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'Scan_KTM' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'Pas_Foto' => 'required|file|mimes:jpg,jpeg,png|max:1024',
        ], [
            'NIM.regex' => 'NIM harus terdiri dari angka dan minimal 10 digit.',
        ]);
    
        $mahasiswa = Mahasiswa::where('NIM', auth()->user()->nim)->first();
    
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan.'
            ], 422);
        }
    
        $jadwal = JadwalUjianModel::whereColumn('kuota_terpakai', '<', 'kuota_max')
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
    
        // ⏺️ Buat pendaftaran
        $pendaftaran = RegistrasiModel::create([
            'NIM' => $mahasiswa->nim,
            'Scan_KTP' => $ktpPath,
            'Scan_KTM' => $ktmPath,
            'Pas_Foto' => $pasFotoPath,
            'Tanggal_Pendaftaran' => now(),
            'ID_Jadwal' => $jadwal->Id_Jadwal,
        ]);
    
        // ⏺️ Tambahkan ke riwayat_pendaftar
        RiwayatPendaftar::create([
            'ID_Pendaftaran' => $pendaftaran->Id_Pendaftaran, // sesuaikan dengan field yang benar
            'ID_Hasil' => null,
            'id_pengambilan' => null,
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
