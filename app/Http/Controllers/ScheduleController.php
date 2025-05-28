<?php

namespace App\Http\Controllers;

use App\Models\JadwalUjianModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // Ambil semua jadwal dengan sesi dan rooms
        $jadwal = JadwalUjianModel::with('sesi.rooms')->get();

        // Buat breadcrumb dan activeMenu untuk tampilan
        $breadcrumb = (object) [
            'title' => 'Jadwal Ujian TOEIC',
            'list' => ['Home', 'Jadwal Ujian TOEIC']
        ];

        $activeMenu = 'schedule'; // Misalnya menu yang aktif adalah 'schedule'

        return view('schedule.index', compact('jadwal', 'breadcrumb', 'activeMenu'));
    
    }
    public function pendaftar($id)
{
    // Ambil jadwal berdasarkan id yang dipilih
   $jadwal = JadwalUjianModel::with(['sesi.rooms.peserta'])->findOrFail($id);
// dump($jadwal->id_jadwal); // pastikan = 1
// dump($jadwal->sesi->pluck('id_jadwal')); // harusnya keluar isi id_jadwal
// dd($jadwal->sesi);


    // Tambahkan breadcrumb dan activeMenu
    $breadcrumb = (object) [
        'title' => 'Peserta Jadwal TOEIC',
        'list' => ['Home', 'Jadwal Ujian', 'Peserta']
    ];

    $activeMenu = 'schedule';
   // Ambil semua program studi
   $prodiList = ProdiModel::all();

   return view('schedule.pendaftar', compact('jadwal', 'breadcrumb', 'activeMenu', 'prodiList'));
}
    

}
