<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;    
use App\Imports\HasilUjianImport;
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

            // Ambil header dan buang baris pertama
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

            return redirect()->back()->with('success', 'Data hasil ujian berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor: ' . $e->getMessage());
        }
    }
}
