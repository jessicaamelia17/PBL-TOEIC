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
    // Ambil jadwal berdasarkan id yang dipilih, termasuk sesi, room, dan peserta
    $jadwal = JadwalUjianModel::with(['sesi.rooms.peserta'])->findOrFail($id);

    // Ambil semua program studi
    $prodiList = ProdiModel::all();

    // Ambil data mahasiswa yang sedang login
    $mahasiswaLogin = auth()->user(); // Pastikan ini sesuai sistem autentikasi kamu

    // Breadcrumb dan menu aktif
    $breadcrumb = (object) [
        'title' => 'users.participants_breadcrumb',
        'list' => ['Home', 'Jadwal Ujian', 'Peserta']
    ];
    $activeMenu = 'schedule';

    // Kirim semua data ke view
    return view('schedule.pendaftar', compact('jadwal', 'breadcrumb', 'activeMenu', 'prodiList', 'mahasiswaLogin'));
}

    

}
