<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    // Menampilkan daftar sertifikat yang bisa diambil
    public function index()
    {
    $activeMenu = 'sertifikat';

    // Dummy data sementara
    $sertifikats = [
        (object)[
            'nama_mahasiswa' => 'Budi Santoso',
            'nim' => '123456789',
            'prodi' => 'Teknik Informatika',
            'tanggal_pengambilan' => '2024-05-20',
            'status' => 'diambil'
        ],
        (object)[
            'nama_mahasiswa' => 'Sari Dewi',
            'nim' => '987654321',
            'prodi' => 'Sistem Informasi',
            'tanggal_pengambilan' => null,
            'status' => 'belum'
        ],
    ];

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