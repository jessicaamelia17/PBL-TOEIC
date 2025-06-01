<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendaftar;
use App\Models\PendaftarModel;
use Illuminate\Http\Request;

class RiwayatSeederController extends Controller
{
    public function isiRiwayat()
    {
        // Ambil pendaftaran yang belum punya riwayat dan eager load relasi yg diperlukan
        $pendaftarans = PendaftarModel::doesntHave('riwayat')
            ->with(['jadwal_ujian.hasil.pengambilanSertifikat'])
            ->get();
    
        $jumlah = 0;
    
        foreach ($pendaftarans as $daftar) {
            $jadwal = $daftar->jadwal_ujian; // Jadwal ujian pendaftar
            $hasil = $jadwal?->hasil; // Hasil ujian yang berelasi dengan jadwal
            $sertifikat = $hasil?->pengambilanSertifikat; // Pengambilan sertifikat dari hasil
    
            // Pastikan id hasil dan id pengambilan sertifikat tidak null sebelum memasukkan ke riwayat
            RiwayatPendaftar::create([
                'ID_Pendaftaran' => $daftar->Id_Pendaftaran,
                'ID_Jadwal' => $jadwal?->Id_Jadwal,
                'ID_Hasil' => $hasil?->Id_Hasil ?? null,
                'id_pengambilan' => $sertifikat?->id_pengambilan ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            $jumlah++;
        }
    
        return response()->json([
            'status' => 'success',
            'message' => "Berhasil menambahkan $jumlah riwayat dari data yang sudah ada."
        ]);
    }
    

}
