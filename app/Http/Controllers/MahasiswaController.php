<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\JurusanModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Ambil data mahasiswa berdasarkan NIM user login
        $mahasiswa = Mahasiswa::with(['jurusan', 'prodi'])->where('nim', $user->nim)->first();

        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        $jurusans = JurusanModel::all();
        $prodis = ProdiModel::all();
        return view('mahasiswa.create', compact('jurusans', 'prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|unique:mahasiswa,nim',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:mahasiswa,email',
            'no_hp' => 'nullable|string|max:20',
            'id_jurusan' => 'nullable|exists:jurusan,Id_Jurusan',
            'id_prodi' => 'nullable|exists:prodi,Id_Prodi',
            'alamat' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tmpt_lahir' => 'nullable|string|max:255',
            'TTL' => 'nullable|date',
        ]);

        $data = $request->all();
        // Simpan foto ke storage/uploads/photo_profile
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads/photo_profile', 'public');
        }


        Mahasiswa::create($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function update(Request $request, $nim)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:mahasiswa,email,' . $nim . ',nim',
            'no_hp' => 'nullable|string|max:20',
            'id_jurusan' => 'nullable|exists:jurusan,Id_Jurusan',
            'id_prodi' => 'nullable|exists:prodi,Id_Prodi',
            'alamat' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tmpt_lahir' => 'nullable|string|max:255',
            'TTL' => 'nullable|date',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($nim);
        $data = $request->all();

        // Perbarui foto jika ada file baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($mahasiswa->photo) {
                Storage::disk('public')->delete($mahasiswa->photo);
            }
            // Simpan foto baru ke folder uploads/photo_profile
            $data['photo'] = $request->file('photo')->store('uploads/photo_profile', 'public');
        }


        $mahasiswa->update($data);

        return redirect()->route('mahasiswa.profile')->with('success', 'Data mahasiswa berhasil diperbarui');
    }


    public function show($nim)
    {
        $mahasiswa = Mahasiswa::with(['jurusan', 'prodi'])->findOrFail($nim);
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $jurusans = JurusanModel::all();
        $prodis = ProdiModel::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'jurusans', 'prodis'));
    }

    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus');
    }

    public function getProdiByJurusan($id_jurusan)
    {
        $prodis = ProdiModel::where('Id_Jurusan', $id_jurusan)->get(['Id_Prodi', 'Nama_Prodi']);
        return response()->json($prodis);
    }
    public function resetPasswordForm($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        return view('mahasiswa.reset-password', compact('mahasiswa'));
    }
    public function resetPassword(Request $request, $nim)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($nim);

        if (!Hash::check($request->current_password, $mahasiswa->password)) {
            $msg = ['current_password' => ['Password lama salah.']];
            if ($request->expectsJson()) {
                return response()->json(['errors' => $msg], 422);
            }
            return back()->withErrors($msg)->withInput();
        }

        $mahasiswa->password = Hash::make($request->new_password);
        $mahasiswa->save();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Password berhasil direset.']);
        }
        return back()->with('success', 'Password berhasil direset.');
    }
}
