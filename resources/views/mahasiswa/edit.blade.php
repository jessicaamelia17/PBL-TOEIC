@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl py-10">
    <div class="bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-3xl font-bold mb-8 text-center text-gray-800">Edit Data Mahasiswa</h2>
        <form action="{{ route('mahasiswa.update', $mahasiswa->nim) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">NIM</label>
                <input type="text" name="nim" value="{{ $mahasiswa->nim }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" readonly>
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $mahasiswa->alamat) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">Tempat Lahir</label>
                <input type="text" name="tmpt_lahir" value="{{ old('tmpt_lahir', $mahasiswa->tmpt_lahir) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">Tanggal Lahir</label>
                <input type="date" name="TTL" value="{{ old('TTL', $mahasiswa->TTL) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">Foto Profil</label>
                <input type="file" name="photo" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">
                @if($mahasiswa->photo)
                    <img src="{{ asset('storage/profil_mahasiswa/' . $mahasiswa->photo) }}" alt="Foto Profil" class="mt-2 w-20 h-20 rounded-full object-cover">
                @endif
            </div>

            {{-- JURUSAN --}}
            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">Jurusan</label>
                <select id="jurusan" name="id_jurusan" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->Id_Jurusan }}" {{ $mahasiswa->Id_Jurusan == $jurusan->Id_Jurusan ? 'selected' : '' }}>
                            {{ $jurusan->Nama_Jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- PRODI --}}
            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">Prodi</label>
                <select id="prodi" name="id_prodi" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ $mahasiswa->id_prodi == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->Nama_Prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('mahasiswa.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                    ← Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    💾 Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- AJAX SCRIPT --}}
<script>
    document.getElementById('jurusan').addEventListener('change', function () {
        let jurusanId = this.value;
        let prodiSelect = document.getElementById('prodi');

        // Kosongkan dropdown prodi
        prodiSelect.innerHTML = '<option value="">-- Pilih Prodi --</option>';

        if (jurusanId) {
            fetch(`/get-prodi/${jurusanId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(prodi) {
                        let option = document.createElement('option');
                        option.value = prodi.Id_Prodi;
                        option.text = prodi.Nama_Prodi;
                        prodiSelect.appendChild(option);
                    });
                });
        }
    });
</script>
@endsection