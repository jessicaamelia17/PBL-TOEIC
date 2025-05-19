<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ControllerPengumuman extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Pengumuman',
            'list' => ['Home', 'Pengumuman']
        ];

        $activeMenu = 'pengumuman';

        return view('admin.pengumuman.index', compact('breadcrumb', 'activeMenu'));
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Upload Pengumuman',
            'list' => ['Home', 'Pengumuman', 'Upload']
        ];

        $activeMenu = 'pengumuman';

        return view('admin.pengumuman.create', compact('breadcrumb', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_pengumuman' => 'required|date',
            'file_pengumuman' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Validasi file
        ]);


        $filePath = null;
        if ($request->hasFile('file_pengumuman')) {
            $filePath = $request->file('file_pengumuman')->store('uploads/pengumuman', 'public');
        }

        Pengumuman::create([
            'Judul' => $request->judul,
            'Isi' => $request->isi,
            'Tanggal_Pengumuman' => $request->tanggal_pengumuman,
            'Created_By' => Auth::guard('admin')->user()->Id_Admin,
            'file_pengumuman' => $filePath, // Menyimpan path file
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        // Hapus file dari storage jika ada
        if ($pengumuman->file_pengumuman) {
            Storage::delete('public/' . $pengumuman->file_pengumuman);
        }

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function list(Request $request)
    {
        $data = Pengumuman::with('admin')->select('pengumuman.*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('file_pengumuman', function ($row) {
                return $row->file_pengumuman

                    ? '<a href="' . asset(
                        'storage/' . $row->file_pengumuman
                    ) . '" target="_blank">Lihat File</a>'
                    : '-';
            })
            ->addColumn('aksi', function ($row) {
                $url = route('admin.pengumuman.destroy', $row->Id_Pengumuman);
                return '
                <form action="' . $url . '" method="POST" onsubmit="return confirm(\'Yakin hapus?\')">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
                ';
            })
            ->rawColumns(['file_pengumuman', 'aksi'])
            ->make(true);
    }
}
