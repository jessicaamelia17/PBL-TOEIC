<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengambilanSertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SertifikatController extends Controller
{
    // Menampilkan daftar sertifikat yang bisa diambil
    public function index()
    {
        $activeMenu = 'sertifikat';

        // Ambil sertifikat hanya dari hasil ujian yang LULUS
        $sertifikats = PengambilanSertifikat::with('hasilUjian')
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

    // Menampilkan arsip sertifikat yang sudah diambil
    public function arsip()
    {
        $activeMenu = 'pengambilan-arsip';

        return view('admin.sertifikat.arsip', compact('activeMenu'));
    }

    // Export data sertifikat ke CSV
    public function export()
    {
        $sertifikats = PengambilanSertifikat::with('hasilUjian')
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
                fputcsv($file, [
                    $index + 1,
                    $item->Nama,
                    $item->NIM,
                    $item->Program_Studi,
                    $item->Tanggal_Diambil ? date('d-m-Y', strtotime($item->Tanggal_Diambil)) : '-',
                    $item->Status,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}