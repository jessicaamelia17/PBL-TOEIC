<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\JurusanModel;
use App\Models\ProdiModel;
use Yajra\DataTables\Facades\DataTables;

class ControllerMahasiswa extends Controller
{
    // Tampilkan daftar mahasiswa
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Mahasiswa',
            'list' => ['Dashboard', 'Data Mahasiswa']
        ];
        $activeMenu = 'mahasiswa';

        $mahasiswas = Mahasiswa::with(['jurusan', 'prodi'])->get();
        return view('admin.mahasiswa.index', compact('mahasiswas', 'breadcrumb', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = Mahasiswa::with(['jurusan', 'prodi'])->select('mahasiswa.*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('jurusan', function ($row) {
                return $row->jurusan->Nama_Jurusan ?? '-';
            })
            ->addColumn('prodi', function ($row) {
                return $row->prodi->Nama_Prodi ?? '-';
            })
            ->addColumn('aksi', function ($row) {
                $url = route('admin.mahasiswa.destroy', $row->nim);
                return '
                <form action="' . $url . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Tampilkan form tambah mahasiswa
    public function create()
    {
        $jurusans = JurusanModel::all();
        $prodis = ProdiModel::all();
        return view('admin.mahasiswa.create', compact('jurusans', 'prodis'));
    }

    // Proses insert data mahasiswa
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim',
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'nullable',
            'Id_Jurusan' => 'required|exists:jurusan,Id_Jurusan',
            'Id_Prodi' => 'required|exists:prodi,Id_Prodi',
            'alamat' => 'nullable',
            'tmpt_lahir' => 'nullable',
            'TTL' => 'nullable|date',
            'password' => 'required|min:8',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        Mahasiswa::create($data);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    // Proses hapus data mahasiswa
    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }

    public function getProdiByJurusan($id_jurusan)
    {
        $prodis = ProdiModel::where('Id_Jurusan', $id_jurusan)->get();
        return response()->json($prodis);
    }
}
