<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratPengajuan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuratController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Surat Pengajuan',
            'list' => ['Dashboard', 'Surat Pengajuan']
        ];
    
        $activeMenu = 'surat';
    
        $pengajuan = SuratPengajuan::with('mahasiswa')->get(); // pastikan ada relasi 'mahasiswa'
    
        return view('admin.surat.index', compact('breadcrumb', 'activeMenu', 'pengajuan'));
    }
    
    

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = SuratPengajuan::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_pengaju', function ($row) {
                    return $row->NIM; // ganti jika ada relasi ke tabel mahasiswa
                })
                ->addColumn('judul', function ($row) {
                    return 'Pengajuan Surat'; // sesuaikan jika ada kolom judul
                })
                ->addColumn('tanggal_pengajuan', function ($row) {
                    return \Carbon\Carbon::parse($row->tanggal_pengajuan)->format('d-m-Y');
                })
                ->addColumn('status', function ($row) {
                    return $row->status_verifikasi;
                })
                ->addColumn('aksi', function ($row) {
                    $edit = '<button class="btn btn-sm btn-primary" onclick="modalAction(\'' . url('/admin/surat/' . $row->id_surat . '/edit') . '\')"><i class="fas fa-edit"></i></button>';
                    $delete = '<button class="btn btn-sm btn-danger" onclick="hapusData(' . $row->id_surat . ')"><i class="fas fa-trash"></i></button>';
                    return $edit . ' ' . $delete;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function createAjax()
    {
        return view('admin.surat.create', [
            'page' => (object)[
                'title' => 'Tambah Surat Pengajuan'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'NIM' => 'required',
            'tanggal_pengajuan' => 'required|date',
            'status_verifikasi' => 'required',
            'catatan' => 'nullable|string'
        ]);
    
        SuratPengajuan::create([
            'NIM' => $request->NIM,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'status_verifikasi' => $request->status_verifikasi,
            'tanggal_verifikasi' => null, // atau bisa auto-fill nanti saat diverifikasi
            'catatan' => $request->catatan,
        ]);
    
        return response()->json(['success' => true]);
    }
    public function show($id)
    {
        $surat = SuratPengajuan::with('mahasiswa')->find($id);
    
        if (!$surat) {
            abort(404, 'Surat tidak ditemukan');
        }
    
        return view('admin.surat.detail', compact('surat'));
    }
    

    

}
