<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratPengajuan;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;


class PengajuanSuratController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = Mahasiswa::with(['prodi', 'jurusan'])->where('NIM', $user->nim)->first();


        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

         $pengajuan = SuratPengajuan::whereRaw('LOWER(NIM) = ?', [strtolower($mahasiswa->nim)])->latest()->first();


        if ($pengajuan && $pengajuan->file_sertifikat) {
            // Kalau sudah pernah mengajukan dan ada file, pakai dari DB
            $sertifikat = $pengajuan->file_sertifikat;
        } elseif (!$pengajuan && session()->has('sertifikat_uploaded')) {
            // Kalau belum pernah mengajukan tapi baru upload
            $sertifikat = session('sertifikat_uploaded');
        } else {
            $sertifikat = null;
        }

        return view('pengajuan-surat.index', compact('mahasiswa', 'pengajuan', 'sertifikat'));
    }

    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('NIM', Auth::user()->nim)->first();

        $existing = SuratPengajuan::where('NIM', $mahasiswa->NIM)
            ->where('status_verifikasi', 'menunggu')->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah memiliki pengajuan yang sedang diproses.');
        }

        if (!session()->has('sertifikat_uploaded')) {
            return back()->with('error', 'Silakan upload sertifikat terlebih dahulu.');
        }

        SuratPengajuan::create([
            'NIM' => auth()->user()->nim, // Ambil NIM dari user yang sedang login
            'tanggal_pengajuan' => now(),
            'status_verifikasi' => 'menunggu',
            'file_sertifikat' => session('sertifikat_uploaded'),
        ]);

        // Hapus dari session setelah dipakai
        session()->forget('sertifikat_uploaded');

        return back()->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function uploadSertifikat(Request $request)
    {
        $existing = SuratPengajuan::where('NIM', Auth::user()->nim)
        ->whereIn('status_verifikasi', ['menunggu', 'diterima']) // bisa ditambah status lain
        ->first();
    
    if ($existing) {
        return back()->with('error', 'Anda sudah mengajukan surat. Tidak dapat mengunggah ulang sertifikat.');
    }
    

        $request->validate([
            'file_sertifikat' => 'required|mimes:pdf|max:5120', // max 5MB
        ]);

        $path = $request->file('file_sertifikat')->store('sertifikat', 'public');

        // Simpan sementara di session
        session(['sertifikat_uploaded' => $path]);

        return back()->with('success', 'Sertifikat berhasil diupload.');
    }

    public function hapusSertifikat()
{
    if (session()->has('sertifikat_uploaded')) {
        $path = session('sertifikat_uploaded');
        Storage::disk('public')->delete($path);
        session()->forget('sertifikat_uploaded');
    }

    return back()->with('success', 'Sertifikat berhasil dihapus.');
}
public function pengajuanSurat()
{
    $mahasiswa = Mahasiswa::where('NIM', auth()->user()->nim)->first();

    $pengajuan = SuratPengajuan::where('NIM', auth()->user()->nim)
        ->latest()
        ->first();

    $sertifikat = $pengajuan->file_sertifikat ?? null;

    return view('mahasiswa.surat', compact('mahasiswa', 'pengajuan', 'sertifikat'));
}

public function uploadUlang(Request $request)
{
    $request->validate([
        'file_sertifikat' => 'required|mimes:pdf|max:5120',
    ]);

    $pengajuan = SuratPengajuan::where('NIM', auth()->user()->nim)
        ->where('status_verifikasi', 'ditolak')
        ->latest()
        ->first();

    if (!$pengajuan) {
        return back()->with('error', 'Pengajuan tidak ditemukan atau tidak dalam status ditolak.');
    }

    // Hapus file lama jika ada
    if ($pengajuan->file_sertifikat && Storage::disk('public')->exists($pengajuan->file_sertifikat)) {
        Storage::disk('public')->delete($pengajuan->file_sertifikat);
    }

    // Simpan file baru
    $file = $request->file('file_sertifikat')->store('sertifikat', 'public');
    $pengajuan->file_sertifikat = $file;
    $pengajuan->status_verifikasi = 'menunggu'; // Set status jadi baru
    $pengajuan->catatan = null; // Reset catatan
    $pengajuan->tanggal_verifikasi = null; // Reset tanggal verifikasi
    $pengajuan->save();

    return back()->with('success', 'Sertifikat berhasil diupload ulang. Pengajuan Anda akan diproses ulang oleh admin.');
}


    public function cetakSurat($id)
    {
        $pengajuan = SuratPengajuan::with('mahasiswa.prodi')->findOrFail($id);

        if ($pengajuan->status_verifikasi !== 'disetujui') {
            abort(403, 'Surat belum disetujui.');
        }

        return view('pengajuan-surat.cetak', compact('pengajuan'));
    }
    public function preview($id)
    {
        $pengajuan = SuratPengajuan::with('mahasiswa.prodi')->findOrFail($id);
    
        $pdf = Pdf::loadView('pengajuan-surat.cetak', compact('pengajuan'));
    
        // Kembalikan response PDF langsung ditampilkan di browser
        return $pdf->stream('Surat_TOEIC_' . $pengajuan->mahasiswa->nim . '.pdf');
    }
}
