@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 px-4">
    <div class="bg-blue-100 p-6 rounded-xl shadow-md flex items-center space-x-6">
        <img src="{{ asset('pengajuan.png') }}" alt="Ilustrasi Surat" class="w-40 h-40 object-contain">

        <div>
            <h2 class="text-2xl font-bold text-blue-800 mb-2">Butuh Surat Rekomendasi TOEIC?</h2>
            <p class="text-blue-900 mb-4">
                Ajukan surat pengantar atau surat kebutuhan administrasi TOEIC langsung melalui sistem kami.
                Cukup login, isi data, dan pantau status pengajuan secara real-time.
            </p>
            <a href="{{ route('suratpengajuan.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded transition">
               Ajukan Surat Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
