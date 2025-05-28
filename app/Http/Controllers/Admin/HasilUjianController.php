<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;    
use App\Imports\HasilUjianImport;
use App\Exports\HasilUjianExport;
use App\Models\HasilUjian;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HasilUjianController extends Controller
{
    public function index()
    {
        $results = HasilUjian::with('peserta', 'jadwal')->paginate(10); // tambahkan paginate
    
        $breadcrumb = (object) [
            'title' => 'Daftar Hasil Ujian',
            'list' => ['Home', 'Hasil Ujian']
        ];
    
        $activeMenu = 'hasil-ujian';
    
        return view('admin.hasil_ujian.index', compact('results', 'breadcrumb', 'activeMenu'));
    }                

    public function importForm()
    {
        return view('admin.hasil_ujian.import', [
            'activeMenu' => 'hasil-ujian'
        ]);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'File tidak valid. Harus format CSV dan maksimal 2MB.');
        }

        try {
            $path = $request->file('file')->getRealPath();
            $data = array_map('str_getcsv', file($path));

            if (count($data) <= 1) {
                return redirect()->back()->with('error', 'File CSV tidak memiliki data.');
            }

            // Ambil header dan hapus baris pertama
            $header = array_map('trim', $data[0]);
            unset($data[0]);

            foreach ($data as $row) {
                $row = array_map('trim', $row);

                DB::table('hasil_ujian')->insert([
                    'Nama' => $row[0] ?? null,
                    'NIM' => $row[1] ?? null,
                    'Listening' => $row[2] ?? null,
                    'Reading' => $row[3] ?? null,
                    'Skor' => $row[4] ?? null,
                    'Listening_2' => $row[5] ?? null,
                    'Reading_2' => $row[6] ?? null,
                    'Skor_2' => $row[7] ?? null,
                    'Tanggal_Ujian' => isset($row[8]) ? Carbon::parse($row[8])->format('Y-m-d') : null,
                    'Status' => $row[9] ?? 'Belum Validasi',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return redirect()->back()->with('success', 'Data berhasil diimport.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import data: ' . $e->getMessage());
        }
    }
    public function exportForm()
{
    return view('admin.hasil_ujian.export', [
        'activeMenu' => 'hasil-ujian'
    ]);
}

public function export(Request $request)
    {
        $filename = 'hasil_ujian_export_' . date('Ymd_His') . '.csv';

        $results = DB::table('hasil_ujian')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'Nama', 'NIM', 'Listening', 'Reading', 'Skor',
            'Listening_2', 'Reading_2', 'Skor_2',
            'Tanggal_Ujian', 'Status', 'Created At', 'Updated At'
        ];

        $callback = function() use ($results, $columns) {
            $file = fopen('php://output', 'w');
            // Tulis header kolom
            fputcsv($file, $columns);

            foreach ($results as $row) {
                fputcsv($file, [
                    $row->Nama,
                    $row->NIM,
                    $row->Listening,
                    $row->Reading,
                    $row->Skor,
                    $row->Listening_2,
                    $row->Reading_2,
                    $row->Skor_2,
                    $row->Tanggal_Ujian,
                    $row->Status,
                    $row->created_at,
                    $row->updated_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}