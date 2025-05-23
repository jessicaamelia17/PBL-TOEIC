<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;  
use App\Imports\HasilUjianImport;
use App\Models\HasilUjian;

class HasilUjianController extends Controller
{
    public function index()
    {
        $results = HasilUjian::with('peserta', 'jadwal')->paginate(10); // tambahkan paginate
    
        $breadcrumb = (object) [
            'title' => 'Daftar Hasil Ujian',
            'list' => ['Home', 'Hasil Ujian']
        ];
    
        $activeMenu = 'hasil-ujian';
    
        return view('admin.hasil_ujian.index', compact('results', 'breadcrumb', 'activeMenu'));
    }                

    public function importForm()
    {
        return view('admin.hasil_ujian.import', [
            'activeMenu' => 'hasil-ujian'
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new HasilUjianImport, $request->file('file'));

            return redirect()->route('admin.hasil-ujian.index')->with('success', 'Data hasil ujian berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }
}
