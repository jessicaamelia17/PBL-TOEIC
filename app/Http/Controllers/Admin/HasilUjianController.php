<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\HasilUjian;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilUjianController extends Controller
{
    public function index()
    {
        $results = HasilUjian::with(['pendaftaran.mahasiswa', 'pendaftaran.jadwal_ujian'])
            ->join('pendaftaran_toeic', 'hasil_ujian.id_pendaftaran', '=', 'pendaftaran_toeic.id_pendaftaran')
            ->join('mahasiswa', 'pendaftaran_toeic.nim', '=', 'mahasiswa.nim')
            ->orderBy('mahasiswa.nama', 'asc')
            ->select('hasil_ujian.*')
            ->paginate(10);

        $breadcrumb = (object) [
            'title' => 'Daftar Hasil Ujian',
            'list' => ['Home', 'Hasil Ujian']
        ];

        $activeMenu = 'hasil-ujian';

        return view('admin.hasil_ujian.index', compact('results', 'breadcrumb', 'activeMenu'));
    }

    public function importForm()
    {
        return view('admin.hasil_ujian.import', [
            'activeMenu' => 'hasil-ujian'
        ]);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'File tidak valid. Harus format CSV dan maksimal 2MB.');
        }

        try {
            $path = $request->file('file')->getRealPath();
            $data = array_map('str_getcsv', file($path));

            if (count($data) <= 1) {
                return redirect()->back()->with('error', 'File CSV tidak memiliki data.');
            }

            $header = array_map('trim', $data[0]);
            unset($data[0]);

            foreach ($data as $row) {
                $row = array_map('trim', $row);

                $nim = $row[0] ?? null;
                $skor = $row[3] ?? 0;
                $tanggalUjian = $row[7];
                $tanggalUjianDb = Carbon::createFromFormat('d/m/Y', $tanggalUjian)->format('Y-m-d');

                $pendaftaran = DB::table('pendaftaran_toeic')
                ->join('mahasiswa', 'pendaftaran_toeic.nim', '=', 'mahasiswa.nim')
                ->join('prodi', 'mahasiswa.Id_Prodi', '=', 'prodi.Id_Prodi')
                ->join('jadwal_ujian', 'pendaftaran_toeic.id_jadwal', '=', 'jadwal_ujian.Id_Jadwal')
                ->where('pendaftaran_toeic.nim', $nim)
                ->whereDate('jadwal_ujian.Tanggal_Ujian', $tanggalUjianDb)
                ->select('pendaftaran_toeic.id_pendaftaran', 'prodi.Nama_Prodi')
                ->first();
            

                if (!$pendaftaran) {
                    $status = 'Belum Validasi';
                    $id_pendaftaran = null;
                } else {
                    $prodi = $pendaftaran->Nama_Prodi;
                    $id_pendaftaran = $pendaftaran->id_pendaftaran;

                    if (strpos($prodi, 'D-III') === 0) {
                        $status = $skor < 400 ? 'Tidak Lulus' : 'Lulus';
                    } elseif (strpos($prodi, 'D-IV') === 0) {
                        $status = $skor < 450 ? 'Tidak Lulus' : 'Lulus';
                    } else {
                        $status = 'Belum Validasi';
                    }
                }

                $idHasil = DB::table('hasil_ujian')->insertGetId([
                    'id_pendaftaran' => $id_pendaftaran,
                    'listening_1' => $row[1] ?? null,
                    'reading_1' => $row[2] ?? null,
                    'total_skor_1' => $row[3] ?? null,
                    'Listening_2' => $row[4] ?? null,
                    'Reading_2' => $row[5] ?? null,
                    'total_skor_2' => $row[6] ?? null,
                    'Status' => $status,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                if ($id_pendaftaran && $idHasil) {
                    DB::table('riwayat_pendaftar')
                        ->where('ID_Pendaftaran', $id_pendaftaran)
                        ->update(['ID_Hasil' => $idHasil]);
                }
            }

            return redirect()->back()->with('success', 'Data berhasil diimport.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    public function exportForm()
    {
        return view('admin.hasil_ujian.export', [
            'activeMenu' => 'hasil-ujian'
        ]);
    }

    public function export(Request $request)
    {
        $filename = 'hasil_ujian_export_' . date('Ymd_His') . '.csv';

        $results = HasilUjian::with(['pendaftaran.mahasiswa', 'pendaftaran.jadwal_ujian'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'Nama', 'NIM', 'listening_1', 'reading_1', 'total_skor_1',
            'Listening_2', 'Reading_2', 'total_skor_2',
            'Tanggal_Ujian', 'Status'
        ];

        $callback = function() use ($results, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($results as $row) {
                $mhs = optional($row->pendaftaran->mahasiswa);
                $jadwal = optional($row->pendaftaran->jadwal_ujian);

                fputcsv($file, [
                    $mhs->nama ?? '-',
                    "'" . ($mhs->nim ?? '-'),
                    $row->listening_1,
                    $row->reading_1,
                    $row->total_skor_1,
                    $row->Listening_2,
                    $row->Reading_2,
                    $row->total_skor_2,
                    $jadwal->Tanggal_Ujian
                        ? Carbon::parse($jadwal->Tanggal_Ujian)->format('d-m-Y')
                        : '-',
                    $row->Status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $results = HasilUjian::with(['pendaftaran.mahasiswa', 'pendaftaran.jadwal_ujian'])->get();

        $pdf = Pdf::loadView('admin.hasil_ujian.exportPDF', compact('results'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('hasil_ujian_export_' . date('Ymd_His') . '.pdf');
    }
}
