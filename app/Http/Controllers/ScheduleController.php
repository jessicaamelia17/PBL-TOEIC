<?php

namespace App\Http\Controllers;

use App\Models\JadwalUjianModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // Ambil semua jadwal dengan sesi dan rooms, urutkan terbaru di atas
        $jadwal = JadwalUjianModel::with('sesi.rooms')
            ->orderBy('Tanggal_Ujian', 'desc')
            ->get();

        // Buat breadcrumb dan activeMenu untuk tampilan
        $breadcrumb = [
            ['label' => __('users.home'), 'url' => route('landing')],
            ['label' => __('users.schedule'), 'url' => null],
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
        $breadcrumb = [
            ['label' => __('users.home'), 'url' => route('landing')],
            ['label' => __('users.schedule'), 'url' => route('mahasiswa.schedule.index')],
            ['label' => __('users.participants_breadcrumb'), 'url' => null],
        ];
        $activeMenu = 'schedule';

        // Kirim semua data ke view
        return view('schedule.pendaftar', compact('jadwal', 'breadcrumb', 'activeMenu', 'prodiList', 'mahasiswaLogin'));
    }
}
