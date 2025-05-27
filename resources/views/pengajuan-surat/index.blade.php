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
        <p><strong>Status Verifikasi:</strong> {{ $pengajuan?->file_sertifikat ?? '-' }}</p>

    </div>

    <div class="mt-6">
        {{-- Jika SUDAH MENGAJUKAN --}}
        @if($pengajuan)
    @php
        $status = $pengajuan->status_verifikasi;
        $warna = match($status) {
            'menunggu' => 'bg-yellow-100 text-yellow-800',
            'diterima' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    @endphp

    <div class="mt-4 bg-gray-100 p-4 rounded space-y-2">
        <p><strong>Status Pengajuan:</strong> 
            <span class="px-2 py-1 rounded {{ $warna }}">{{ ucfirst($status) }}</span>
        </p>

        <p><strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->translatedFormat('d F Y') }}</p>

        @if($status !== 'menunggu')
            <p><strong>Tanggal Verifikasi:</strong> 
                {{ $pengajuan->tanggal_verifikasi ? \Carbon\Carbon::parse($pengajuan->tanggal_verifikasi)->translatedFormat('d F Y') : '-' }}
            </p>
            <p><strong>Catatan:</strong> {{ $pengajuan->catatan ?? '-' }}</p>
        @endif

        <div class="bg-white p-4 rounded shadow mt-4">
            <p class="font-semibold mb-2">Preview Sertifikat:</p>
            <embed src="{{ asset('storage/' . $pengajuan->file_sertifikat) }}" type="application/pdf" width="100%" height="500px" />
        </div>
        
    </div>

        
        {{-- Jika BELUM mengajukan --}}
        @else
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
                        <a href="{{ asset('storage/' . $sertifikat) }}" class="text-blue-600 underline" target="_blank">Klik di sini</a>
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
</div>
@endsection
