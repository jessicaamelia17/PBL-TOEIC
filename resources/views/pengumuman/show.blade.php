@extends('layouts.app2')

@section('content')
    <div class="container mx-auto min-h-screen py-12 px-4 md:px-6 lg:px-8 pb-32">

        <div class="bg-white p-8 rounded-lg shadow">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $pengumuman->Judul }}</h2>
            <p class="text-gray-600 mb-2"><strong>Tanggal:</strong>
                {{ \Carbon\Carbon::parse($pengumuman->Tanggal_Pengumuman)->format('d M Y') }}</p>

            <div class="text-gray-700 leading-relaxed mb-4">
                {!! nl2br(e($pengumuman->Isi)) !!}
            </div>

            {{-- Tampilkan file jika ada --}}
            @if ($pengumuman->file_pengumuman)
                @php
                    $filePath = 'storage/' . $pengumuman->file_pengumuman; // hasil asset()
                    $extension = pathinfo($pengumuman->file_pengumuman, PATHINFO_EXTENSION);
                @endphp

                <div class="mb-4">
                    <strong class="block mb-1 text-gray-800">Lampiran:</strong>
                    <a href="{{ asset($filePath) }}" target="_blank" class="text-blue-600 hover:underline">

                    </a>
                </div>

                {{-- Preview file --}}
                @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset($filePath) }}" alt="Lampiran Gambar" class="mt-4 rounded shadow max-w-full h-auto">
                @elseif (strtolower($extension) === 'pdf')
                    <iframe src="{{ asset($filePath) }}" class="w-full h-[1000px] mt-4 border rounded" frameborder="0"></iframe>

                @endif
            @endif

            <a href="{{ route('landing') }}" class="mt-6 inline-block text-blue-600 hover:underline">← Back</a>
        </div>
    </div>
@endsection
