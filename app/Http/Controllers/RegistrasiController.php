<?php

namespace App\Http\Controllers;

use App\Models\JurusanModel;
use App\Models\ProdiModel;
use App\Models\RegistrastiModel;
use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function index()
    {
        return view('registrasi.index');
    }
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
        // Validasi dan Simpan Data
        $request->validate([
            'NIM' => 'required',
            'Nama' => 'required',
            'No_WA' => 'required',
            'email' => 'required|email',
            'Id_Jurusan' => 'required',
            'Id_Prodi' => 'required',
            'Scan_KTP' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'Scan_KTM' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'Pas_Foto' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        // Simpan file
        $ktpPath = $request->file('ktp')->store('uploads/ktp', 'public');
        $ktmPath = $request->file('ktm')->store('uploads/ktm', 'public');
        $pasFotoPath = $request->file('pas_foto')->store('uploads/pas_foto', 'public');

        // Simpan ke DB
        RegistrastiModel::create([
            'NIM' => $request->NIM,
            'Nama' => $request->Nama,
            'No_WA' => $request->No_WA,
            'email' => $request->email,
            'Id_Jurusan' => $request->Id_Jurusan,
            'Id_Prodi' => $request->Id_Prodi,
            'Scan_KTP' => $ktpPath,
            'Scan_KTM' => $ktmPath,
            'Pas_Foto' => $pasFotoPath
        ]);

        return redirect()->route('registrasi.create')->with('success', 'Pendaftaran berhasil!');
    }
}
