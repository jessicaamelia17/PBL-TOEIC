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
        $jadwal = JadwalUjianModel::with('sesi.rooms.peserta')->findOrFail($id_jadwal);

        $breadcrumb = (object) [
            'title' => 'Kelola Sesi & Room',
            'list' => ['Kelola Jadwal', 'Sesi & Room', $jadwal->tanggal_ujian]
        ];

        $activeMenu = 'jadwal';

        return view('admin.sesi.index', compact('jadwal', 'breadcrumb', 'activeMenu'));
    }

    public function storeSesi(Request $request, $id_jadwal)
    {
        $jadwal = JadwalUjianModel::findOrFail($id_jadwal);
    
        // Cek apakah sesi sudah 2
        if ($jadwal->sesi()->count() >= 2) {
            return redirect()->route('admin.sesi.index', $jadwal->id_jadwal)
                             ->with('error', 'Jumlah sesi maksimal 2 per hari.');
        }
    
        SesiUjianModel::create([
            'id_jadwal' => $id_jadwal,
            'nama_sesi' => $request->nama_sesi,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);
    
        return redirect()->route('admin.sesi.index', $jadwal->id_jadwal)
                         ->with('success', 'Sesi berhasil ditambahkan.');
    }
    

    public function storeRoom(Request $request, $id)
    {
        $request->validate([
            'nama_room'     => 'required|string|max:100',
            'zoom_id'       => 'required|string|max:100',
            'zoom_password' => 'required|string|max:100',
            'kapasitas'     => 'required|integer|min:1',
        ]);

        RoomUjianModel::create([
            'id_sesi'       => $id,
            'nama_room'     => $request->nama_room,
            'zoom_id'       => $request->zoom_id,
            'zoom_password' => $request->zoom_password,
            'kapasitas'     => $request->kapasitas,
        ]);

        return back()->with('success', 'Room berhasil ditambahkan.');
    }

    public function bagiPesertaKeSesiRoom($idJadwal)
    {
        $jadwal = JadwalUjianModel::findOrFail($idJadwal);
        $kuotaHarian = $jadwal->kuota;

        $sesiList = SesiUjianModel::where('id_jadwal', $idJadwal)->with('rooms')->get();
        $totalKapasitas = $sesiList->flatMap->rooms->sum('kapasitas');

        $pesertaList = RegistrasiModel::where('ID_Jadwal', $idJadwal)
            ->whereNull('id_sesi')
            ->whereNull('id_room')
            ->orderBy('ID_Prodi')
            ->orderBy('Tanggal_Pendaftaran', 'asc')
            ->take(min($kuotaHarian, $totalKapasitas))
            ->get();

        if ($pesertaList->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada peserta yang perlu dibagi.'
            ]);
        }

        $roomQueue = [];
        foreach ($sesiList as $sesi) {
            foreach ($sesi->rooms as $room) {
                $roomQueue[] = [
                    'room' => $room,
                    'kapasitas_tersisa' => $room->kapasitas,
                    'id_sesi' => $sesi->id_sesi,
                ];
            }
        }

        $pesertaIndex = 0;
        foreach ($roomQueue as &$roomItem) {
            while ($roomItem['kapasitas_tersisa'] > 0 && $pesertaIndex < $pesertaList->count()) {
                $peserta = $pesertaList[$pesertaIndex];
                $peserta->update([
                    'id_sesi' => $roomItem['id_sesi'],
                    'id_room' => $roomItem['room']->id_room,
                ]);
                $roomItem['kapasitas_tersisa']--;
                $pesertaIndex++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Peserta berhasil dibagi ke sesi dan room.',
        ]);
    }

    public function edit($id)
    {
        $sesi = SesiUjianModel::findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Edit Sesi',
            'list' => ['Kelola Jadwal', 'Sesi & Room', 'Edit Sesi']
        ];

        $activeMenu = 'jadwal';

        return view('admin.sesi.edit', compact('sesi', 'breadcrumb', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sesi'   => 'required|string|max:50',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ]);

        $sesi = SesiUjianModel::findOrFail($id);
        $sesi->update([
            'nama_sesi'     => $request->nama_sesi,
            'waktu_mulai'   => $request->jam_mulai,
            'waktu_selesai' => $request->jam_selesai,
        ]);
        

        return redirect()->route('admin.sesi.index', $sesi->id_jadwal)
            ->with('success', 'Sesi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sesi = SesiUjianModel::findOrFail($id);
        $id_jadwal = $sesi->id_jadwal;
        $sesi->delete();

        return redirect()->route('admin.sesi.index', $id_jadwal)
            ->with('success', 'Sesi berhasil dihapus.');
    }

    public function editRoom($id)
    {
        $room = RoomUjianModel::with('sesi')->findOrFail($id); // load relasi sesi
    
        $breadcrumb = (object) [
            'title' => 'Edit Room',
            'list' => ['Kelola Jadwal', 'Sesi & Room', 'Edit Room']
        ];
    
        $activeMenu = 'jadwal';
    
        return view('admin.sesi.edit-room', compact('room', 'breadcrumb', 'activeMenu'));
    }
    

    public function updateRoom(Request $request, $id)
    {
        $request->validate([
            'nama_room' => 'required',
            'zoom_id' => 'required',
            'zoom_password' => 'required',
            'kapasitas' => 'required|integer|min:1',
        ]);
    
        // Pastikan relasi sesi dimuat
        $room = RoomUjianModel::with('sesi')->findOrFail($id);
    
        $id_jadwal = optional($room->sesi)->id_jadwal;
    
        if (!$id_jadwal) {
            return back()->with('error', 'ID Jadwal tidak ditemukan.');
        }
    
        $room->update([
            'nama_room' => $request->nama_room,
            'zoom_id' => $request->zoom_id,
            'zoom_password' => $request->zoom_password,
            'kapasitas' => $request->kapasitas,
        ]);
    
        return redirect()->route('admin.sesi.index', ['id' => $id_jadwal])
            ->with('success', 'Room berhasil diperbarui.');
    }
    

    

    public function destroyRoom($id)
    {
        $room = RoomUjianModel::with('sesi')->findOrFail($id);
        $id_jadwal = $room->sesi->id_jadwal ?? null;
    
        $room->delete();
    
        return redirect()->route('admin.sesi.index', $id_jadwal)
            ->with('success', 'Room berhasil dihapus.');
    }
    
}
