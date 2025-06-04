<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjianModel;
use Illuminate\Http\Request;
use App\Models\KuotaModel;

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
    
        // Tambahkan kode ini:
        $kuota = \App\Models\KuotaModel::first();
        $totalKuotaJadwal = \App\Models\JadwalUjianModel::where('id_kuota', $kuota->id)->sum('kuota_max');
        $kuotaPenuh = $totalKuotaJadwal >= $kuota->kuota_total;
    
        // Kirim $kuotaPenuh ke view
        return view('admin.jadwal.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'jadwals' => $jadwals,
            'kuotaPenuh' => $kuotaPenuh
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

    
    // ...existing code...
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'kuota_max' => 'required|integer|min:1',
        ]);
    
        $jadwal = JadwalUjianModel::findOrFail($id);
    
        // Hitung total kuota jadwal lain (selain yang sedang diedit)
        $totalKuotaJadwalLain = JadwalUjianModel::where('id_kuota', $jadwal->id_kuota)
            ->where('Id_Jadwal', '!=', $id)
            ->sum('kuota_max');
    
        $kuotaTotal = KuotaModel::find($jadwal->id_kuota)->kuota_total;
    
        // Cek apakah penambahan kuota melebihi kuota total
        if (($totalKuotaJadwalLain + $request->kuota_max) > $kuotaTotal) {
            return back()->withErrors(['kuota_max' => 'Total kuota seluruh jadwal melebihi kuota total ('.$kuotaTotal.')!']);
        }
    
        $jadwal->kuota_max = $request->kuota_max;
        $jadwal->save();
    
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal diperbarui.');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'Tanggal_Ujian' => 'required|date',
            'kuota_max' => 'required|integer|min:1',
            'id_kuota' => 'required|exists:kuota,id', // Pastikan ada id_kuota di form
        ]);
    
        // Hitung total kuota jadwal yang sudah ada
        $totalKuotaJadwal = JadwalUjianModel::where('id_kuota', $request->id_kuota)->sum('kuota_max');
        $kuotaTotal = KuotaModel::find($request->id_kuota)->kuota_total;
    
        // Cek apakah penambahan kuota melebihi kuota total
        if (($totalKuotaJadwal + $request->kuota_max) > $kuotaTotal) {
            return back()->withErrors(['kuota_max' => 'Total kuota seluruh jadwal melebihi kuota total ('.$kuotaTotal.')!']);
        }
    
        JadwalUjianModel::create([
            'Tanggal_Ujian' => $request->Tanggal_Ujian,
            'kuota_max' => $request->kuota_max,
            'id_kuota' => $request->id_kuota,
            // tambahkan field lain jika ada
        ]);
    
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }
    public function destroy($id)
{
    $jadwal = JadwalUjianModel::findOrFail($id);
    $jadwal->delete();
    
    return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
}
public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah Jadwal Ujian',
        'list' => ['Home', 'Jadwal Ujian', 'Tambah']
    ];

    $activeMenu = 'jadwal';

    return view('admin.jadwal.create', [
        'breadcrumb' => $breadcrumb,
        'activeMenu' => $activeMenu
    ]);
}
}
