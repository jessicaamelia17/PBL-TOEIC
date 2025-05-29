@extends('layouts.app2')
@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection
@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white rounded-lg shadow-lg p-8 animate-fadeIn">
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Form Registrasi TOEIC</h2>

    @if($pendaftaran)
        <div class="p-6 bg-green-50 border border-green-200 rounded text-green-800 text-center">
            <h3 class="text-xl font-bold mb-2">Anda sudah terdaftar!</h3>
            <p>Tanggal ujian yang Anda dapatkan: <b>{{ \Carbon\Carbon::parse($pendaftaran->jadwalUjian->Tanggal_Ujian)->format('d-m-Y') }}</b></p>
            <p class="mt-4">Silakan tunggu pengumuman sesi dan room melalui WhatsApp atau Email Anda.</p>
        </div>
    @else
        <!-- Form Registrasi -->
        <form id="registrasiForm" action="{{ route('mahasiswa.registrasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <!-- ...input form seperti sebelumnya... -->
        </form>
    @endif
</div>
@endsection