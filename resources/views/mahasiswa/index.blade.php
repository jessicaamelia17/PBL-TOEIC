@extends('layouts.app2')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-extrabold text-blue-700 mb-10 text-center tracking-wide drop-shadow">Student Profile</h1>

        @if (session('success'))
            <div
                class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded mb-6 shadow text-center max-w-xl mx-auto">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex justify-center">
            @if ($mahasiswa)
                <div
                    class="bg-white shadow-2xl hover:shadow-blue-200 transition duration-300 rounded-3xl overflow-hidden w-full max-w-2xl border border-blue-100">
                    <div class="flex flex-col md:flex-row items-center p-8 gap-8">
                        <div class="flex flex-col items-center">
                            <div class="relative">
                                <img src="{{ $mahasiswa->photo ? asset('storage/' . $mahasiswa->photo) : asset('profile-picture.jpg') }}"
                                    alt="Foto Profil"
                                    class="w-36 h-36 rounded-full object-cover border-4 border-blue-300 shadow-lg ring-4 ring-blue-100 transition duration-300">
                            </div>
                            <a href="{{ route('mahasiswa.edit', $mahasiswa->nim) }}"
                                class="mt-6 inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                                <i class="fa fa-edit mr-2"></i>Edit Profile
                            </a>
                        </div>
                        <div class="text-gray-800 text-base w-full">
                            <h2 class="text-2xl font-bold mb-2 text-blue-700">{{ $mahasiswa->nama ?? '-' }}</h2>
                            <ul class="text-gray-700 space-y-2">
                                <li class="grid grid-cols-4">
                                    <span class="font-semibold">NIM</span>
                                    <span class="text-center">: </span>
                                    <span>{{ $mahasiswa->nim }}</span>
                                </li>
                                <li class="grid grid-cols-4">
                                    <span class="font-semibold">Email</span>
                                    <span class="text-center">:</span>
                                    <span>{{ $mahasiswa->email ?? '-' }}</span>
                                </li>
                                <li class="grid grid-cols-4">
                                    <span class="font-semibold">No HP</span>
                                    <span class="text-center">:</span>
                                    <span>{{ $mahasiswa->no_hp ?? '-' }}</span>
                                </li>
                                <li class="grid grid-cols-4">
                                    <span class="font-semibold">Department</span>
                                    <span class="text-center">:</span>
                                    <span>{{ $mahasiswa->jurusan->Nama_Jurusan ?? '-' }}</span>
                                </li>
                                <li class="grid grid-cols-4">
                                    <span class="font-semibold">Study Program</span>
                                    <span class="text-center">:</span>
                                    <span>{{ $mahasiswa->prodi->Nama_Prodi ?? '-' }}</span>
                                </li>
                                <li class="grid grid-cols-4">
                                    <span class="font-semibold">Address</span>
                                    <span class="text-center">:</span>
                                    <span>{{ $mahasiswa->alamat ?? '-' }}</span>
                                </li>
                                <li class="grid grid-cols-4">
                                    <span class="font-semibold">Birthplace</span>
                                    <span class="text-center">:</span>
                                    <span>{{ $mahasiswa->tmpt_lahir ?? '-' }}</span>
                                </li>
                                <li class="grid grid-cols-4">
                                    <span class="font-semibold">Date of Birth</span>
                                    <span class="text-center">:</span>
                                    <span>{{ $mahasiswa->TTL ? \Carbon\Carbon::parse($mahasiswa->TTL)->format('d M Y') : '-' }}</span>
                                </li>
                            </ul>
                            <div class="mt-6 text-sm text-gray-500">
                                <span class="font-semibold">Registration Date:</span>
                                {{ $mahasiswa->created_at ? $mahasiswa->created_at->format('d M Y H:i') : '-' }}
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
