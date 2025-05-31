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
    // Menampilkan daftar sertifikat yang bisa diambil
    
    public function index()
    {
        $activeMenu = 'sertifikat';
    
        // Ambil sertifikat yang hasil ujiannya Lulus, beserta relasi mahasiswa
        $sertifikats = PengambilanSertifikat::with(['hasilUjian.mahasiswa', 'mahasiswa'])
            ->whereHas('hasilUjian', function ($query) {
                $query->where('Status', 'Lulus');
            })
            ->get();
    
        $breadcrumb = (object)[
            'title' => 'Daftar Sertifikat',
            'list' => ['Dashboard', 'Sertifikat']
        ];
    
        return view('admin.sertifikat.index', compact('activeMenu', 'sertifikats', 'breadcrumb'));
    }

    public function syncSertifikat()
    {
        $hasilLulus = HasilUjian::where('Status', 'Lulus')->get();
        $inserted = 0;

        foreach ($hasilLulus as $hasil) {
            // Cek apakah sudah ada di pengambilan_sertifikat
            $exists = PengambilanSertifikat::where('Id_Hasil', $hasil->Id_Hasil)->exists();
            if (!$exists) {
                PengambilanSertifikat::create([
                    'Id_Hasil'         => $hasil->Id_Hasil,
                    'NIM'              => $hasil->NIM,
                    'Tanggal_Diambil'  => null,
                    'Status'           => 'Belum Diambil',
                ]);
                $inserted++;
            }
        }

        return redirect()->back()->with('success', "$inserted data sertifikat berhasil disinkronisasi.");
    }
    // Menampilkan arsip sertifikat yang sudah diambil
    public function arsip()
    {
        $activeMenu = 'pengambilan-arsip';

        return view('admin.sertifikat.arsip', compact('activeMenu'));
    }

    // Export data sertifikat ke CSV
   
    public function export()
    {
        $sertifikats = PengambilanSertifikat::with(['hasilUjian.mahasiswa'])
            ->whereHas('hasilUjian', function ($query) {
                $query->where('Status', 'Lulus');
            })
            ->get();

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
                $mahasiswa = $item->hasilUjian->mahasiswa ?? null;

                fputcsv($file, [
                    $index + 1,
                    $mahasiswa->nama ?? '-',
                    "'".$mahasiswa->nim ?? '-', 
                    $mahasiswa->prodi->Nama_Prodi ?? '-',
                    $item->Tanggal_Diambil ? date('d-m-Y', strtotime($item->tanggal_diambil)) : '-',
                    $item->Status,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
    public function ambil($id)
    {
        $sertifikat = PengambilanSertifikat::findOrFail($id);
        $sertifikat->Status = 'Diambil'; // S besar!
        $sertifikat->tanggal_diambil = now()->toDateString();
        $sertifikat->save();
    
        return redirect()->back()->with('success', 'Status sertifikat berhasil diubah menjadi Diambil.');
    }
    public function exportPdf()
{
    $sertifikats = PengambilanSertifikat::with(['hasilUjian.mahasiswa'])
        ->whereHas('hasilUjian', function ($query) {
            $query->where('Status', 'Lulus');
        })
        ->get();

    $pdf = Pdf::loadView('admin.sertifikat.exportpdf', compact('sertifikats'));
    return $pdf->download('daftar_sertifikat_' . now()->format('Ymd_His') . '.pdf');
}
}
