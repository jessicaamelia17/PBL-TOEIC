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
                $editUrl = route('admin.pengumuman.edit', $row->Id_Pengumuman);
                $deleteUrl = route('admin.pengumuman.destroy', $row->Id_Pengumuman);
                return '
        <a href="' . $editUrl . '" class="btn btn-warning btn-sm me-1">Edit</a>
           <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
            ' . csrf_field() . method_field('DELETE') . '
            <button class="btn btn-danger btn-sm">Hapus</button>
        </form>
    ';
            })
            ->rawColumns(['file_pengumuman', 'aksi'])
            ->make(true);
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
        // if ($pengumuman->file_pengumuman) {
        //     Storage::delete('public/' . $pengumuman->file_pengumuman);
        // }

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $breadcrumb = (object)[
            'title' => 'Edit Pengumuman',
            'list' => ['Home', 'Pengumuman', 'Edit']
        ];
        $activeMenu = 'pengumuman';
        return view('admin.pengumuman.edit', compact('pengumuman', 'breadcrumb', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_pengumuman' => 'required|date',
            'file_pengumuman' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('file_pengumuman')) {
            // Hapus file lama jika ada
            if ($pengumuman->file_pengumuman) {
                Storage::delete('public/' . $pengumuman->file_pengumuman);
            }
            $filePath = $request->file('file_pengumuman')->store('uploads/pengumuman', 'public');
            $pengumuman->file_pengumuman = $filePath;
        }

        $pengumuman->Judul = $request->judul;
        $pengumuman->Isi = $request->isi;
        $pengumuman->Tanggal_Pengumuman = $request->tanggal_pengumuman;
        $pengumuman->save();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diupdate.');
    }
}
