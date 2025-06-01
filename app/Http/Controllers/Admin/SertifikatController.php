<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengambilanSertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\HasilUjian;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 

class SertifikatController extends Controller
{
    // Menampilkan daftar sertifikat (semua pengambilan, tidak terbatas lulus saja)
    public function index()
    {
        $activeMenu = 'sertifikat';
    
        // Ambil semua data pengambilan sertifikat beserta relasi mahasiswa
        $sertifikats = PengambilanSertifikat::with(['hasilUjian.pendaftaran.mahasiswa.prodi'])->get();
    
        $breadcrumb = (object)[
            'title' => 'Daftar Sertifikat',
            'list' => ['Dashboard', 'Sertifikat']
        ];
    
        return view('admin.sertifikat.index', compact('activeMenu', 'sertifikats', 'breadcrumb'));
    }

    // Sinkronisasi data sertifikat dari hasil ujian yang Lulus
    public function syncSertifikat()
    {
        $hasilUjians = HasilUjian::all(); // Ambil semua hasil ujian tanpa filter Status
        $inserted = 0;
    
        foreach ($hasilUjians as $hasil) {
            $exists = PengambilanSertifikat::where('Id_Hasil', $hasil->Id_Hasil)->exists();
            if (!$exists) {
                PengambilanSertifikat::create([
                    'Id_Hasil'         => $hasil->Id_Hasil,
                    'Tanggal_Diambil'  => null,
                    'Status'           => 'Belum Diambil',
                ]);
                $inserted++;
            }
        }
    
        return redirect()->back()->with('success', "$inserted data sertifikat berhasil disinkronisasi.");
    }
    

    // Export data sertifikat ke CSV (semua pengambilan)
    public function export()
    {
        $sertifikats = PengambilanSertifikat::with(['hasilUjian.pendaftaran.mahasiswa.prodi'])->get();

        $filename = 'daftar_sertifikat_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $columns = ['No', 'Nama', 'NIM', 'Program Studi', 'Tanggal Diambil', 'Status'];

        $callback = function () use ($sertifikats, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($sertifikats as $index => $item) {
                $mahasiswa = $item->hasilUjian->pendaftaran->mahasiswa ?? null;

                fputcsv($file, [
                    $index + 1,
                    $mahasiswa->nama ?? '-',
                    "'".$mahasiswa->nim ?? '-',
                    $mahasiswa->prodi->Nama_Prodi ?? '-',
                    $item->Tanggal_Diambil ? date('d-m-Y', strtotime($item->Tanggal_Diambil)) : '-',
                    $item->Status,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // Tandai sertifikat sudah diambil
    public function ambil($id)
    {
        $sertifikat = PengambilanSertifikat::findOrFail($id);
        $sertifikat->Status = 'Diambil'; // Pastikan case sesuai kolom DB
        $sertifikat->Tanggal_Diambil = now()->toDateString(); // Huruf besar sesuai kolom DB
        $sertifikat->save();

        return redirect()->back()->with('success', 'Status sertifikat berhasil diubah menjadi Diambil.');
    }

    // Export data sertifikat ke PDF (semua pengambilan)
    public function exportPdf()
    {
        $sertifikats = PengambilanSertifikat::with(['hasilUjian.pendaftaran.mahasiswa.prodi'])->get();

        $pdf = Pdf::loadView('admin.sertifikat.exportpdf', compact('sertifikats'));
        return $pdf->download('daftar_sertifikat_' . now()->format('Ymd_His') . '.pdf');
    }
}
