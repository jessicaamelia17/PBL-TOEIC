<?php

namespace App\Http\Controllers\Admin;

use App\Models\JadwalUjianModel;
use App\Models\SesiUjianModel;
use App\Models\RoomUjianModel;
use App\Models\RegistrasiModel;
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
            'kapasitas' => 'required|integer|min:1', // Validasi kapasitas
        ]);

        RoomUjianModel::create([
            'id_sesi' => $id,
            'nama_room' => $request->nama_room,
            'zoom_id' => $request->zoom_id,
            'zoom_password' => $request->zoom_password,
            'kapasitas' => $request->kapasitas, // Simpan kapasitas
        ]);

        return back()->with('success', 'Room berhasil ditambahkan.');
    }

    public function bagiPesertaKeSesiRoom($idJadwal)
{
    $sesiList = SesiUjianModel::where('id_jadwal', $idJadwal)->with('rooms')->get();
    $pesertaList = RegistrasiModel::where('ID_Jadwal', $idJadwal)
        ->whereNull('id_room')
        ->orderBy('Tanggal_Pendaftaran', 'asc')
        ->get();

    $pesertaIndex = 0;

    foreach ($sesiList as $sesi) {
        foreach ($sesi->rooms as $room) {
            $kapasitas = $room->kapasitas;
            for ($i = 0; $i < $kapasitas && $pesertaIndex < $pesertaList->count(); $i++) {
                $peserta = $pesertaList[$pesertaIndex];
                $peserta->update([
                    'id_sesi' => $sesi->id_sesi,
                    'id_room' => $room->id_room,
                ]);
                $pesertaIndex++;
            }
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Peserta berhasil dibagi ke sesi dan room.'
    ]);
}


}

