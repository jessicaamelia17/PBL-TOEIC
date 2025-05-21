<?php

namespace App\Http\Controllers;

use App\Models\JadwalUjianModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // Menampilkan semua jadwal TOEIC
    public function index()
    {
        $jadwalList  = JadwalUjianModel::with('sesi.rooms.pendaftar.prodi')->get();
    
        $breadcrumb = (object) [
            'title' => 'Data Jadwal Ujian (Semua Jadwal)',
            'list' => ['Home', 'Jadwal Ujian']
        ];
    
        $activeMenu = 'schedule';

        // Ambil semua program studi jika dibutuhkan di dropdown atau lainnya
        $prodiList = ProdiModel::all();

        return view('schedule.index', compact('jadwalList', 'breadcrumb', 'activeMenu', 'prodiList'));

    }
    
    

}
