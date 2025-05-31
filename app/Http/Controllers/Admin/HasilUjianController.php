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
        $results = HasilUjian::with(['mahasiswa', 'jadwal'])
            ->join('mahasiswa', 'hasil_ujian.NIM', '=', 'mahasiswa.NIM')
            ->orderBy('mahasiswa.nama', 'asc')
            ->select('hasil_ujian.*') // agar hasil tetap model HasilUjian
            ->paginate(10);
    
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
            
                // Ambil data mahasiswa berdasarkan NIM
                
                $mahasiswa = DB::table('mahasiswa')
                    ->join('prodi', 'mahasiswa.Id_Prodi', '=', 'prodi.Id_Prodi')
                    ->where('mahasiswa.NIM', $row[0])
                    ->select('mahasiswa.*', 'prodi.Nama_Prodi')
                    ->first();

                $prodi = $mahasiswa->Nama_Prodi ?? null;
                if (!$mahasiswa) {
                    $status = 'Belum Validasi';
                } else {
                    $skor = $row[3] ?? 0;
                    if (strpos($prodi, 'D-III') === 0) {
                        $status = $skor < 400 ? 'Tidak Lulus' : 'Lulus';
                    } elseif (strpos($prodi, 'D-IV') === 0) {
                        $status = $skor < 450 ? 'Tidak Lulus' : 'Lulus';
                    } else {
                        $status = 'Belum Validasi';
                    }
                }
                // Cari id_jadwal berdasarkan tanggal ujian dari CSV
                // Pastikan format tanggal di database dan CSV sama (misal: Y-m-d)
                $tanggalUjian = $row[7];
                // Ubah format jika perlu
                $tanggalUjianDb = \Carbon\Carbon::createFromFormat('d/m/Y', $tanggalUjian)->format('Y-m-d');
                $jadwal = DB::table('jadwal_ujian')->where('Tanggal_Ujian', $tanggalUjianDb)->first();
                $id_jadwal = $jadwal ? $jadwal->Id_Jadwal : null;
            
                DB::table('hasil_ujian')->insert([
                    'NIM' => $row[0] ?? null,
                    'listening_1' => $row[1] ?? null,
                    'reading_1' => $row[2] ?? null,
                    'total_skor_1' => $row[3] ?? null,
                    'Listening_2' => $row[4] ?? null,
                    'Reading_2' => $row[5] ?? null,
                    'total_skor_2' => $row[6] ?? null,
                    'id_jadwal' => $id_jadwal,
                    'Status' => $status,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
    
            return redirect()->back()->with('success', 'Data berhasil diimport.');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import data: ' . $e->getMessage());
        }
    }



    public function export(Request $request)
    {
        $filename = 'hasil_ujian_export_' . date('Ymd_His') . '.csv';
    
        $results = HasilUjian::with(['mahasiswa', 'jadwal'])->get();
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
    
        $columns = [
            'Nama', 'NIM', 'listening_1', 'reading_1', 'total_skor_1',
            'Listening_2', 'Reading_2', 'total_skor_2',
            'Tanggal_Ujian', 'Status'
        ];
    
        $callback = function() use ($results, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
    
            foreach ($results as $row) {
                fputcsv($file, [
                    optional($row->mahasiswa)->nama ?? '-',
                    "'".$row->NIM, // <-- tambahkan tanda petik
                    $row->listening_1,
                    $row->reading_1,
                    $row->total_skor_1,
                    $row->Listening_2,
                    $row->Reading_2,
                    $row->total_skor_2,
                    optional($row->jadwal)->Tanggal_Ujian 
                    ? \Carbon\Carbon::parse($row->jadwal->Tanggal_Ujian)->format('d-m-Y') 
                    : '-',
                    $row->Status
                ]);
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    public function exportForm()
{
    return view('admin.hasil_ujian.export', [
        'activeMenu' => 'hasil-ujian'
    ]);
}


}