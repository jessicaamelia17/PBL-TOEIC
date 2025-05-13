<?php

namespace App\Http\Controllers\Admin;

use App\Models\JadwalUjianModel;
use App\Models\SesiUjianModel;
use App\Models\RoomUjianModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SesiJadwalController extends Controller
{
    public function index($id_jadwal)
    {
        $jadwal = JadwalUjianModel::findOrFail($id_jadwal);
        $sesi = SesiUjianModel::with('rooms.peserta')->where('id_jadwal', $id_jadwal)->get();

        $breadcrumb = (object) [
            'title' => 'Kelola Sesi & Room',
            'list' => ['Kelola Jadwal', 'Sesi & Room', $jadwal->tanggal_ujian]
        ];

        $activeMenu = 'jadwal';

        return view('admin.sesi.index', compact('jadwal', 'sesi', 'breadcrumb', 'activeMenu'));
    }



    public function storeSesi(Request $request, $id)
    {
        $request->validate([
            'nama_sesi' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        SesiUjianModel::create([
            'id_jadwal' => $id,
            'nama_sesi' => $request->nama_sesi,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        return back()->with('success', 'Sesi berhasil ditambahkan.');
    }

    public function storeRoom(Request $request, $id)
    {
        $request->validate([
            'nama_room' => 'required',
            'zoom_id' => 'required',
            'zoom_password' => 'required',
        ]);

        RoomUjianModel::create([
            'id_sesi' => $id,
            'nama_room' => $request->nama_room,
            'zoom_id' => $request->zoom_id,
            'zoom_password' => $request->zoom_password,
        ]);

        return back()->with('success', 'Room berhasil ditambahkan.');
    }
}

