@extends('layouts.app2')

@section('content')
    <div class="container mx-auto px-4 py-2">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center border-b pb-4">Profil Mahasiswa</h1>

        @if (session('success'))
            <div
                class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded mb-6 shadow text-center max-w-xl mx-auto">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex justify-center">
            @if ($mahasiswa)
                <div
                    class="bg-white shadow-md hover:shadow-xl transition duration-300 rounded-2xl overflow-hidden w-full max-w-xl">
                    <div class="flex flex-col md:flex-row items-center p-6 space-x-0 md:space-x-6 space-y-4 md:space-y-0">
                        <img src="{{ $mahasiswa->photo ? asset('storage/' . $mahasiswa->photo) : asset('profile-picture.jpg') }}"
                            alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow">
                        <div class="text-gray-800 text-base w-full">
                            <h2 class="text-2xl font-semibold mb-2">{{ $mahasiswa->nama ?? '-' }}</h2>
                            <ul class="text-gray-700 space-y-1">
                                <li><span class="font-medium">NIM:</span> {{ $mahasiswa->nim }}</li>
                                <li><span class="font-medium">Email:</span> {{ $mahasiswa->email ?? '-' }}</li>
                                <li><span class="font-medium">No HP:</span> {{ $mahasiswa->no_hp ?? '-' }}</li>
                                <li><span class="font-medium">Jurusan:</span> {{ $mahasiswa->jurusan->Nama_Jurusan ?? '-' }}
                                </li>
                                <li><span class="font-medium">Prodi:</span> {{ $mahasiswa->prodi->Nama_Prodi ?? '-' }}</li>
                                <li><span class="font-medium">Alamat:</span> {{ $mahasiswa->alamat ?? '-' }}</li>
                                <li><span class="font-medium">Tempat Lahir:</span> {{ $mahasiswa->tmpt_lahir ?? '-' }}</li>
                                <li><span class="font-medium">Tanggal Lahir:</span>
                                    {{ $mahasiswa->TTL ? \Carbon\Carbon::parse($mahasiswa->TTL)->format('d M Y') : '-' }}
                                </li>
                                <li class="text-sm text-gray-500 mt-1"><span class="font-medium">Terdaftar:</span>
                                    {{ $mahasiswa->created_at ? $mahasiswa->created_at->format('d M Y H:i') : '-' }}</li>
                            </ul>
                            <div class="mt-4">
                                <a href="{{ route('mahasiswa.edit', $mahasiswa->nim) }}"
                                    class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded-lg transition">
                                    ✏️ Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center text-gray-500">
                    <p>🚫 Tidak ada data mahasiswa.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
