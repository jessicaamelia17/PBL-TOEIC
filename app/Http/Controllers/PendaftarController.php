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
        // Opsional: batasi akses jika bukan mahasiswa atau petugas
        return view('pendaftar.index', [
            'page' => (object)[
                'title' => 'Data Pendaftar'
            ]
        ]);
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
                    if (Auth::user()->role_id != 1) {
                        return '
                            <a href="javascript:void(0)" onclick="modalAction(\'/pendaftar/edit/' . $row->id_pendaftaran . '\')" class="btn btn-sm btn-warning">Edit</a>
                            <a href="javascript:void(0)" onclick="deleteData(\'/pendaftar/delete/' . $row->id_pendaftaran . '\')" class="btn btn-sm btn-danger">Hapus</a>
                        ';
                    } else {
                        return '-';
                    }
                })
                ->rawColumns(['scan_ktp', 'scan_ktm', 'pas_foto', 'aksi'])
                ->make(true);
        }
    }
}
