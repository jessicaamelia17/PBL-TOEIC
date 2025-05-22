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
        $results = HasilUjian::orderBy('Tanggal_Ujian', 'desc')->paginate(10);
        return view('admin.hasil_ujian.index', [
            'results' => $results,
            'activeMenu' => 'hasil-ujian'  // untuk sidebar menu active
        ]);
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