<?php

namespace App\Http\Controllers;

use App\Models\JurusanModel;
use App\Models\ProdiModel;
use App\Models\Pendaftaran;
use App\Models\RegistrasiModel;
use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function create()
    {
        $jurusan = JurusanModel::all();
        return view('registrasi.index', compact('jurusan'));
    }

    public function getProdi($idJurusan)
    {
        $prodi = ProdiModel::where('Id_Jurusan', $idJurusan)->get();
        return response()->json($prodi);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NIM' => 'required|string|max:20',
            'Nama' => 'required|string|max:100',
            'No_WA' => 'required|string|max:15',
            'email' => 'required|email|max:25',
            'Id_Jurusan' => 'required|exists:jurusan,Id_Jurusan',
            'Id_Prodi' => 'required|exists:prodi,Id_Prodi',
            'Scan_KTP' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'Scan_KTM' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'Pas_Foto' => 'required|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        // Simpan file
        $ktpPath = $request->file('Scan_KTP')->store('uploads/ktp', 'public');
        $ktmPath = $request->file('Scan_KTM')->store('uploads/ktm', 'public');
        $pasFotoPath = $request->file('Pas_Foto')->store('uploads/pas_foto', 'public');

        // Simpan ke database
        RegistrasiModel::create([
            'NIM' => $validated['NIM'],
            'Nama' => $validated['Nama'],
            'No_WA' => $validated['No_WA'],
            'email' => $validated['email'],
            'id_Jurusan' => $validated['Id_Jurusan'],
            'id_Prodi' => $validated['Id_Prodi'],
            'Scan_KTP' => $ktpPath,
            'Scan_KTM' => $ktmPath,
            'Pas_Foto' => $pasFotoPath,
            'Tanggal_Pendaftaran' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil!'
        ]);
    }
}