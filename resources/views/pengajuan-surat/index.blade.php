@extends('layouts.app2')

@section('content')
<div class="container">
    <h2 class="text-xl font-semibold mb-4">Pengajuan Surat TOEIC</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white p-4 rounded shadow">
        <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
        <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
        <p><strong>Program Studi:</strong> {{ $mahasiswa->prodi->Nama_Prodi }}</p>
        <p><strong>Jurusan:</strong> {{ $mahasiswa->jurusan->Nama_Jurusan }}</p>
        <p><strong>Tempat, Tanggal Lahir:</strong> {{ $mahasiswa->tmpt_lahir }}, {{ $mahasiswa->TTL }}</p>
        <p><strong>Alamat:</strong> {{ $mahasiswa->alamat }}</p>
    </div>

    <div class="mt-6">
        @if(!$pengajuan)
            <form action="{{ route('mahasiswa.surat.store') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Ajukan Surat
                </button>
            </form>
        @else
            <div class="mt-4 bg-gray-100 p-4 rounded">
                <p><strong>Status Pengajuan:</strong> {{ ucfirst($pengajuan->status) }}</p>
                <p><strong>Tanggal Pengajuan:</strong> {{ $pengajuan->tanggal_pengajuan }}</p>
                @if($pengajuan->status !== 'menunggu')
                    <p><strong>Tanggal Verifikasi:</strong> {{ $pengajuan->tanggal_verifikasi }}</p>
                    <p><strong>Catatan:</strong> {{ $pengajuan->catatan ?? '-' }}</p>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
