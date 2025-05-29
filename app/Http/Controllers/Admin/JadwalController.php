<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjianModel;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Jadwal Ujian',
            'list' => ['Home', 'Jadwal Ujian']
        ];

        $activeMenu = 'jadwal';

        $jadwals = JadwalUjianModel::all();

        return view('admin.jadwal.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'jadwals' => $jadwals
        ]);
    }
    
    public function list(Request $request)
{
    $jadwals = JadwalUjianModel::query();
    return datatables()->of($jadwals)
        ->addIndexColumn()
        ->addColumn('aksi', function($row) {
            return view('admin.jadwal.aksi', compact('row'))->render();
        })
        ->editColumn('Tanggal_Ujian', function($row) {
            return \Carbon\Carbon::parse($row->Tanggal_Ujian)->format('d M Y');
        })
        ->make(true);
}
    

    public function edit($id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Jadwal Ujian',
            'list' => ['Home', 'Jadwal Ujian', 'Edit']
        ];

        $activeMenu = 'jadwal';

        $jadwal = JadwalUjianModel::findOrFail($id);

        return view('admin.jadwal.edit', [
            'jadwal' => $jadwal,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kuota_max' => 'required|integer|min:1',
          
        ]);

        $jadwal = JadwalUjianModel::findOrFail($id);
        $jadwal->kuota_max = $request->kuota_max;
        $jadwal->save();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal diperbarui.');
    }
    public function destroy($id)
{
    $jadwal = JadwalUjianModel::findOrFail($id);
    $jadwal->delete();

    return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
}
}
