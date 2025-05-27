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
    // Tampilkan halaman manajemen sesi dan room untuk jadwal tertentu
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

    // Simpan sesi baru untuk jadwal
    public function storeSesi(Request $request, $id_jadwal)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:50',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        $jadwal = JadwalUjianModel::findOrFail($id_jadwal);

        // Cek batas maksimal 2 sesi per hari
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

    // Simpan room baru untuk sesi tertentu
    public function storeRoom(Request $request, $id_sesi)
    {
        $request->validate([
            'nama_room'     => 'required|string|max:100',
            'zoom_id'       => 'required|string|max:100',
            'zoom_password' => 'required|string|max:100',
            'kapasitas'     => 'required|integer|min:1',
        ]);

        RoomUjianModel::create([
            'id_sesi'       => $id_sesi,
            'nama_room'     => $request->nama_room,
            'zoom_id'       => $request->zoom_id,
            'zoom_password' => $request->zoom_password,
            'kapasitas'     => $request->kapasitas,
        ]);

        return back()->with('success', 'Room berhasil ditambahkan.');
    }

    // Fungsi untuk membagi peserta ke sesi dan room secara otomatis
    public function bagiPesertaKeSesiRoom($id_jadwal)
    {
        $jadwal = JadwalUjianModel::findOrFail($id_jadwal);
        $kuotaHarian = $jadwal->kuota;

        $sesiList = SesiUjianModel::where('id_jadwal', $id_jadwal)->with('rooms')->get();
        $totalKapasitas = $sesiList->flatMap->rooms->sum('kapasitas');

        $pesertaList = RegistrasiModel::where('ID_Jadwal', $id_jadwal)
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

        // Buat antrian room dan kapasitas tersisa
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

        // Alokasikan peserta ke room sampai kapasitas penuh
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

    // Form edit sesi
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

    // Update sesi
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sesi'   => 'required|string|max:50',
            'waktu_mulai'   => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        $sesi = SesiUjianModel::findOrFail($id);
        $sesi->update([
            'nama_sesi'     => $request->nama_sesi,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        return redirect()->route('admin.sesi.index', $sesi->id_jadwal)
            ->with('success', 'Sesi berhasil diperbarui.');
    }

    // Hapus sesi
    public function destroy($id)
    {
        $sesi = SesiUjianModel::findOrFail($id);
        $id_jadwal = $sesi->id_jadwal;
        $sesi->delete();

        return redirect()->route('admin.sesi.index', $id_jadwal)
            ->with('success', 'Sesi berhasil dihapus.');
    }

    // Form edit room
    public function editRoom($id)
    {
        $room = RoomUjianModel::with('sesi')->findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Edit Room',
            'list' => ['Kelola Jadwal', 'Sesi & Room', 'Edit Room']
        ];

        $activeMenu = 'jadwal';

        return view('admin.sesi.edit-room', compact('room', 'breadcrumb', 'activeMenu'));
    }

    // Update room
    public function updateRoom(Request $request, $id)
    {
        $request->validate([
            'nama_room' => 'required|string|max:100',
            'zoom_id' => 'required|string|max:100',
            'zoom_password' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
        ]);

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

        return redirect()->route('admin.sesi.index', $id_jadwal)
            ->with('success', 'Room berhasil diperbarui.');
    }

    // Hapus room
    public function destroyRoom($id)
    {
        $room = RoomUjianModel::with('sesi')->findOrFail($id);
        $id_jadwal = $room->sesi->id_jadwal ?? null;

        $room->delete();

        return redirect()->route('admin.sesi.index', $id_jadwal)
            ->with('success', 'Room berhasil dihapus.');
    }
}
