<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengambilanSertifikat;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    // Menampilkan daftar sertifikat yang bisa diambil
    public function index()
    {
    $activeMenu = 'sertifikat';

    // Ambil sertifikat hanya dari hasil ujian yang LULUS
    $sertifikats = PengambilanSertifikat::with('hasilUjian')
        ->whereHas('hasilUjian', function ($query) {
            $query->where('Status', 'Lulus');
        })
        ->get();

   $breadcrumb = (object)[
    'title' => 'Daftar Sertifikat',
    'list' => ['Dashboard', 'Sertifikat']
];

   return view('admin.sertifikat.index', compact('activeMenu', 'sertifikats', 'breadcrumb'));
    }


    // Menampilkan arsip sertifikat yang sudah diambil
    public function arsip()
    {
        $activeMenu = 'pengambilan-arsip';
        // Ambil data arsip dari database
        return view('admin.sertifikat.arsip', compact('activeMenu'));
    }

}