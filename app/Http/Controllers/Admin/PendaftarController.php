<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PendaftarModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


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
        // Opsional: batasi akses jika bukan mahasiswa atau petugas
        // return view('pendaftar.index', [
        //     'page' => (object)[
        //         'title' => 'Data Pendaftar'
        //     ]
        // ]);
        return view('admin.pendaftar.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    // Digunakan oleh DataTables Ajax
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
                    return '<a href="/storage/' . $row->Scan_KTP . '" target="_blank">Lihat</a>';
                })
                ->editColumn('scan_ktm', function ($row) {
                    return '<a href="/storage/' . $row->Scan_KTM . '" target="_blank">Lihat</a>';
                })
                ->editColumn('pas_foto', function ($row) {
                    return '<a href="/storage/' . $row->Pas_Foto . '" target="_blank">Lihat</a>';
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


    public function show($id)
    {
        $pendaftar = PendaftarModel::with(['jurusan', 'prodi'])->findOrFail($id);

        return view('admin.pendaftar.detail', compact('pendaftar'));
    }

}
