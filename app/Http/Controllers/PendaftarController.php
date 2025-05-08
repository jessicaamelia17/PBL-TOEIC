<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftarModel;

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
        return view('pendaftar.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    // Digunakan oleh DataTables Ajax
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = PendaftarModel::with(['jurusan', 'prodi'])->select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('scan_ktp', function ($row) {
                    return '<a href="/storage/' . $row->scan_ktp . '" target="_blank">Lihat</a>';
                })
                ->editColumn('scan_ktm', function ($row) {
                    return '<a href="/storage/' . $row->scan_ktm . '" target="_blank">Lihat</a>';
                })
                ->editColumn('pas_foto', function ($row) {
                    return '<a href="/storage/' . $row->pas_foto . '" target="_blank">Lihat</a>';
                })
                ->addColumn('aksi', function ($row) {
                    // Tombol aksi hanya untuk non-admin
                    if (Auth::check() && Auth::user()->role_id != 1) {
                        return '
                            <a href="javascript:void(0)" onclick="modalAction(\'/pendaftar/detail/' . $row->Id_Pendaftaran . '\')" class="btn btn-sm btn-info">Detail</a>
                            <a href="javascript:void(0)" onclick="deleteData(\'/pendaftar/delete/' . $row->Id_Pendaftaran . '\')" class="btn btn-sm btn-danger">Hapus</a>
                        ';
                    } else {
                        return '-';
                    }
                })
                ->rawColumns(['scan_ktp', 'scan_ktm', 'pas_foto', 'aksi'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $pendaftar = PendaftarModel::with(['jurusan', 'prodi'])->findOrFail($id);

        return view('pendaftar.detail', compact('pendaftar'));
    }
}
