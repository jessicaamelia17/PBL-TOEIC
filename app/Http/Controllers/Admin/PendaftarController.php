<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PendaftarModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;    
use App\Imports\PendaftaranImport;
use App\Exports\PendaftaranExport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendaftarController extends Controller
{
    // Menampilkan halaman daftar pendaftar
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Pendaftar',
            'list' => ['Home', 'Pendaftar']
        ];

        $activeMenu = 'pendaftar';

        return view('admin.pendaftar.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan form import
    public function importForm()
    {
        return view('admin.pendaftaran_toeic.import', [
            'activeMenu' => 'pendaftar'
        ]);
    }
    
    // Menampilkan form export
    public function exportForm()
    {
        return view('admin.pendaftaran_toeic.export', [
            'activeMenu' => 'pendaftar'
        ]);
    }
    // Proses import data
    
    // Proses import data
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
    
                DB::table('pendaftaran_toeic')->insert([
                    'NIM' => $row[0] ?? null,
                    'Scan_KTP' => $row[1] ?? null,
                    'Scan_KTM' => $row[2] ?? null,
                    'Pas_Foto' => $row[3] ?? null,
                    'Tanggal_Pendaftaran' => $row[4] ?? now(),
                    'ID_Jadwal' => $row[5] ?? 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            return redirect()->back()->with('success', 'Data berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import data: ' . $e->getMessage());
        }
    }
    
    // Proses export data ke CSV
    public function export(Request $request)
    {
        $filename = 'pendaftaran_toeic_export_' . date('Ymd_His') . '.csv';
    
        $results = DB::table('pendaftaran_toeic')
            ->join('mahasiswa', 'pendaftaran_toeic.NIM', '=', 'mahasiswa.nim')
            ->leftJoin('prodi', 'mahasiswa.id_prodi', '=', 'prodi.id')
            ->leftJoin('jurusan', 'mahasiswa.id_jurusan', '=', 'jurusan.id')
            ->select(
                'pendaftaran_toeic.NIM',
                'mahasiswa.nama',
                'mahasiswa.no_hp',
                'mahasiswa.email',
                'prodi.Nama_Prodi',
                'jurusan.Nama_Jurusan',
                'pendaftaran_toeic.Scan_KTP',
                'pendaftaran_toeic.Scan_KTM',
                'pendaftaran_toeic.Pas_Foto',
                'pendaftaran_toeic.Tanggal_Pendaftaran',
                'pendaftaran_toeic.ID_Jadwal'
            )
            ->get();
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
    
        $columns = [
            'NIM', 'Nama', 'No HP', 'Email', 'Prodi', 'Jurusan',
            'Scan_KTP', 'Scan_KTM', 'Pas_Foto', 'Tanggal_Pendaftaran', 'ID_Jadwal'
        ];
    
        $callback = function () use ($results, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
    
            foreach ($results as $row) {
                fputcsv($file, [
                    $row->NIM,
                    $row->nama,
                    $row->no_hp,
                    $row->email,
                    $row->Nama_Prodi,
                    $row->Nama_Jurusan,
                    $row->Scan_KTP,
                    $row->Scan_KTM,
                    $row->Pas_Foto,
                    $row->Tanggal_Pendaftaran,
                    $row->ID_Jadwal
                ]);
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    
    // Ambil data pendaftar untuk DataTables
    public function list(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => true, 'message' => 'Invalid request'], 400);
        }
    
        try {
            $data = DB::table('pendaftaran_toeic')
                ->join('mahasiswa', 'pendaftaran_toeic.NIM', '=', 'mahasiswa.nim')
                ->leftJoin('prodi', 'mahasiswa.id_prodi', '=', 'prodi.id_prodi')
                ->leftJoin('jurusan', 'mahasiswa.id_jurusan', '=', 'jurusan.id_jurusan')
                ->leftJoin('jadwal_ujian', 'pendaftaran_toeic.ID_Jadwal', '=', 'jadwal_ujian.id_jadwal')
                ->select(
                    'pendaftaran_toeic.id_pendaftaran',
                    'pendaftaran_toeic.NIM',
                    'mahasiswa.nama',
                    'mahasiswa.no_hp',
                    'mahasiswa.email',
                    'prodi.Nama_Prodi',
                    'jurusan.Nama_Jurusan',
                    'pendaftaran_toeic.Tanggal_Pendaftaran',
                    'jadwal_ujian.tanggal_ujian as Jadwal' 
                );
    
                return DataTables::of($data)
                ->addIndexColumn()
                // Hapus editColumn Scan_KTP, Scan_KTM, Pas_Foto
                ->addColumn('aksi', function ($row) {
                    $urlDetail = url('/admin/pendaftar/detail/' . $row->id_pendaftaran);
                    return '<button class="btn btn-sm btn-info" onclick="modalAction(\'' . $urlDetail . '\')">Detail</button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    // Menampilkan detail pendaftar
    public function show($id)
    {
        $pendaftar = PendaftarModel::with([
            'mahasiswa.prodi',
            'mahasiswa.jurusan',
            'jadwal_ujian'
        ])->findOrFail($id);
    
        return view('admin.pendaftar.detail', compact('pendaftar'));
    }
}
