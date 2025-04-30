@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-6">
    <div class="bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $pengumuman->judul_pengumuman }}</h2>
        <p class="text-gray-600 mb-2"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pengumuman->Tanggal_Pengumuman)->format('d M Y') }}</p>
        <div class="text-gray-700 leading-relaxed">
            {!! nl2br(e($pengumuman->isi_pengumuman)) !!}
        </div>
        <a href="{{ route('home') }}" class="mt-6 inline-block text-blue-600 hover:underline">← Kembali ke beranda</a>
    </div>
</div>
@endsection
