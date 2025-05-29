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
                    'Nama' => $row[1] ?? null,
                    'No_WA' => $row[2] ?? null,
                    'Email' => $row[3] ?? null,
                    'Id_Jurusan' => $row[4] ?? null,
                    'Id_Prodi' => $row[5] ?? null,
                    'Scan_KTP' => null,
                    'Scan_KTM' => null,
                    'Pas_Foto' => null,
                    'Tanggal_Pendaftaran' => now(),
                    'ID_Jadwal' => 1,
                    'id_room' => null,
                    'id_sesi' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Data berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import data: ' . $e->getMessage());
        }
    }

    // Menampilkan form export
    public function exportForm()
    {
        return view('admin.pendaftaran_toeic.export', [
            'activeMenu' => 'pendaftar'
        ]);
    }

    // Proses export data ke CSV
    public function export(Request $request)
    {
        $filename = 'pendaftaran_toeic_export_' . date('Ymd_His') . '.csv';

        $results = DB::table('pendaftaran_toeic')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'Id_Pendaftaran', 'NIM', 'Nama', 'No_WA', 'Email', 'Id_Jurusan', 'Id_Prodi',
            'Scan_KTP', 'Scan_KTM', 'Pas_Foto', 'Tanggal_Pendaftaran',
            'ID_Jadwal', 'id_room', 'id_sesi', 'created_at', 'updated_at'
        ];

        $callback = function () use ($results, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($results as $row) {
                fputcsv($file, [
                    $row->Id_Pendaftaran,
                    $row->NIM,
                    $row->Nama,
                    $row->No_WA,
                    $row->Email,
                    $row->Id_Jurusan,
                    $row->Id_Prodi,
                    $row->Scan_KTP,
                    $row->Scan_KTM,
                    $row->Pas_Foto,
                    $row->Tanggal_Pendaftaran,
                    $row->ID_Jadwal,
                    $row->id_room,
                    $row->id_sesi,
                    $row->created_at,
                    $row->updated_at
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
            $data = PendaftarModel::with(['jurusan', 'prodi'])->select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('scan_ktp', function ($row) {
                    return $row->Scan_KTP ? '<a href="/storage/' . $row->Scan_KTP . '" target="_blank">Lihat</a>' : '-';
                })
                ->editColumn('scan_ktm', function ($row) {
                    return $row->Scan_KTM ? '<a href="/storage/' . $row->Scan_KTM . '" target="_blank">Lihat</a>' : '-';
                })
                ->editColumn('pas_foto', function ($row) {
                    return $row->Pas_Foto ? '<a href="/storage/' . $row->Pas_Foto . '" target="_blank">Lihat</a>' : '-';
                })
                ->addColumn('aksi', function ($row) {
                    $urlDetail = url('/admin/pendaftar/detail/' . $row->Id_Pendaftaran);
                    return '<button class="btn btn-sm btn-info" onclick="modalAction(\'' . $urlDetail . '\')">Detail</button>';
                })
                ->rawColumns(['scan_ktp', 'scan_ktm', 'pas_foto', 'aksi'])
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
        $pendaftar = PendaftarModel::with(['jurusan', 'prodi'])->findOrFail($id);
        return view('admin.pendaftar.detail', compact('pendaftar'));
    }
}
