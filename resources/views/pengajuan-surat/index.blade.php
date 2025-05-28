{{-- filepath: resources/views/pengajuan-surat/index.blade.php --}}
@extends('layouts.app2')

@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection

@section('content')
<div class="container">
    <h2 class="text-xl font-semibold mb-4">Pengajuan Surat TOEIC</h2>

    {{-- Notifikasi sukses atau error --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Data Mahasiswa --}}
    <div class="bg-white p-4 rounded shadow">
        <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
        <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
        <p><strong>Program Studi:</strong> {{ $mahasiswa->prodi->Nama_Prodi }}</p>
        <p><strong>Jurusan:</strong> {{ $mahasiswa->jurusan->Nama_Jurusan }}</p>
        <p><strong>Tempat, Tanggal Lahir:</strong> {{ $mahasiswa->tmpt_lahir }}, {{ $mahasiswa->TTL }}</p>
        <p><strong>Alamat:</strong> {{ $mahasiswa->alamat }}</p>
        
        @php
            $status = strtolower($pengajuan?->status_verifikasi ?? '');
            $ikon = '';
            $warna = '';
            switch ($status) {
                case 'menunggu':
                    $ikon = '<svg class="w-5 h-5 text-yellow-500 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 8h2v5H9V8zm0 6h2v2H9v-2z"/></svg>';
                    $warna = 'text-yellow-600';
                    break;
                case 'disetujui':
                    $ikon = '<svg class="w-5 h-5 text-green-500 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
                    $warna = 'text-green-600';
                    break;
                case 'ditolak':
                    $ikon = '<svg class="w-5 h-5 text-red-500 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7.707 7.707a1 1 0 10-1.414-1.414L10 10.586l3.707-3.707a1 1 0 00-1.414-1.414L10 8.172l-2.293-2.293z" clip-rule="evenodd"/></svg>';
                    $warna = 'text-red-600';
                    break;
                default:
                    $ikon = '';
                    $warna = 'text-gray-600';
            }
        @endphp

        <p>
            <strong>Status Verifikasi:</strong>
            <span class="{{ $warna }}">{!! $ikon !!} {{ ucfirst($status) ?: '-' }}</span>
        </p>
        @if($pengajuan)
            <p><strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->translatedFormat('d F Y') }}</p>
            <p><strong>Tanggal Verifikasi:</strong> 
                {{ $pengajuan->tanggal_verifikasi ? \Carbon\Carbon::parse($pengajuan->tanggal_verifikasi)->translatedFormat('d F Y') : '-' }}
            </p>
        @endif
    </div>

    {{-- Preview sertifikat hanya jika status BUKAN ditolak --}}
    @if($pengajuan && $pengajuan->status_verifikasi !== 'ditolak')
        <div class="bg-white p-4 rounded shadow mt-4">
            <p class="font-semibold mb-2">Preview Sertifikat:</p>
            <embed src="{{ asset('storage/' . $pengajuan->file_sertifikat) }}" type="application/pdf" width="100%" height="500px" />
        </div>
    @endif

    {{-- Jika status ditolak, tampilkan form upload ulang --}}
    @if($pengajuan && $pengajuan->status_verifikasi == 'ditolak')
        <div class="mt-4 bg-red-50 p-4 rounded">
            <p class="text-red-700 font-semibold mb-2">Pengajuan Anda ditolak.</p>
            <p><strong>Catatan:</strong> {{ $pengajuan->catatan ?? '-' }}</p>
            <form action="{{ route('mahasiswa.surat.uploadUlang') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                @csrf
                <div class="mb-2">
                    <label for="file_sertifikat" class="block font-semibold">Upload Ulang Sertifikat TOEIC (PDF, maksimal 5MB):</label>
                    <input type="file" name="file_sertifikat" accept="application/pdf" class="mt-1 block w-full border rounded px-3 py-2" required>
                    @error('file_sertifikat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Upload Ulang Sertifikat
                </button>
            </form>
        </div>
    @endif

    {{-- Jika BELUM mengajukan --}}
    @if(!$pengajuan)
        {{-- Jika belum upload sertifikat --}}
        @if(!$sertifikat)
            <div class="mt-4 bg-gray-100 p-4 rounded">
                <form action="{{ route('mahasiswa.surat.uploadSertifikat') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label for="file_sertifikat" class="block font-semibold">Upload Sertifikat TOEIC (PDF, maksimal 5MB):</label>
                        <input type="file" name="file_sertifikat" accept="application/pdf" class="mt-1 block w-full border rounded px-3 py-2" required>
                        @error('file_sertifikat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        Upload Sertifikat
                    </button>
                </form>
            </div>
        @else
            {{-- Sudah upload, belum ajukan --}}
            <div class="mt-4">
                <p class="text-green-700 font-semibold">✅ Sertifikat berhasil diupload</p>
                <p><strong>Lihat Sertifikat:</strong> 
                    <a href="{{ asset('storage/' . session('sertifikat_uploaded')) }}" class="text-blue-600 underline" target="_blank">Klik di sini</a>
                </p>
                <form action="{{ route('mahasiswa.surat.hapusSertifikat') }}" method="POST" class="inline-block mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 underline text-sm hover:text-red-800 transition" onclick="return confirm('Hapus sertifikat yang sudah diupload?')">
                        Hapus Sertifikat
                    </button>
                </form>
                {{-- Tombol ajukan surat --}}
                <form action="{{ route('mahasiswa.surat.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="NIM" value="{{ auth()->user()->nim }}">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Ajukan Surat
                    </button>
                </form>
            </div>
        @endif
    @endif
</div>
@endsection