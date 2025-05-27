<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\JurusanModel;
use App\Models\ProdiModel;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

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

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_mahasiswa' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_mahasiswa');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            foreach ($data as $i => $row) {
                if ($i < 2) continue; // baris pertama header, baris kedua bisa skip (opsional)
                if (!isset($row['A']) || $row['A'] === null) continue;

                $insert[] = [
                    'nim' => $row['A'],
                    'nama' => $row['B'],
                    'email' => $row['C'],
                    'no_hp' => $row['D'],
                    'Id_Jurusan' => $row['E'],
                    'Id_Prodi' => $row['F'],
                    'alamat' => $row['G'],
                    'tmpt_lahir' => $row['H'],
                    'TTL' => $row['I'],
                    'password' => bcrypt($row['A']), // Default password
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if (count($insert) > 0) {
                Mahasiswa::insertOrIgnore($insert);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data valid untuk diimport'
                ]);
            }
        }

        return redirect('/admin/mahasiswa');
    }
}
