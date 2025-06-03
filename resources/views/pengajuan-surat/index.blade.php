@extends('layouts.app2')

@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection

@section('content')
<div class="container space-y-6">

    {{-- Status helper --}}
    @php
        $status = strtolower($pengajuan?->status_verifikasi ?? '');
        $ikon = '';
        $warna = '';
        $box = '';
        switch ($status) {
            case 'menunggu':
                $ikon = '<svg class="w-5 h-5 text-yellow-500 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 8h2v5H9V8zm0 6h2v2H9v-2z"/></svg>';
                $warna = 'text-yellow-800';
                $box = 'bg-yellow-50 border border-yellow-300';
                break;
            case 'disetujui':
                $ikon = '<svg class="w-5 h-5 text-green-500 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
                $warna = 'text-green-800';
                $box = 'bg-green-50 border border-green-300';
                break;
            case 'ditolak':
                $ikon = '<svg class="w-5 h-5 text-red-500 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7.707 7.707a1 1 0 10-1.414-1.414L10 10.586l3.707-3.707a1 1 0 00-1.414-1.414L10 8.172l-2.293-2.293z" clip-rule="evenodd"/></svg>';
                $warna = 'text-red-800';
                $box = 'bg-red-50 border border-red-300';
                break;
            default:
                $warna = 'text-gray-700';
                $box = 'bg-gray-100 border border-gray-300';
        }
    @endphp

    {{-- Judul --}}

    <h2 class="text-3xl font-bold text-blue-700 text-center">Pengajuan Surat TOEIC</h2>


    

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded shadow">
            {{ session('error') }}
        </div>
    @endif

    {{-- Data Mahasiswa --}}
    <div class="bg-white p-6 rounded shadow border">
        <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Data Mahasiswa</h3>
        <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-700">
            <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
            <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
            <p><strong>Program Studi:</strong> {{ $mahasiswa->prodi->Nama_Prodi }}</p>
            <p><strong>Jurusan:</strong> {{ $mahasiswa->jurusan->Nama_Jurusan }}</p>
            <p><strong>Tempat, Tanggal Lahir:</strong> {{ $mahasiswa->tmpt_lahir }}, {{ $mahasiswa->TTL }}</p>
            <p><strong>Alamat:</strong> {{ $mahasiswa->alamat }}</p>
        </div>

        {{-- Status Verifikasi --}}
        <div class="mt-6 {{ $box }} px-4 py-3 rounded flex items-center">
            {!! $ikon !!}
            <div class="{{ $warna }} font-semibold text-sm">
                Status Verifikasi: {{ ucfirst($status) ?: '-' }}
            </div>
        </div>

        {{-- Tanggal --}}
        @if($pengajuan)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-sm">
            <p><strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->translatedFormat('d F Y') }}</p>
            <p><strong>Tanggal Verifikasi:</strong> 
                {{ $pengajuan->tanggal_verifikasi ? \Carbon\Carbon::parse($pengajuan->tanggal_verifikasi)->translatedFormat('d F Y') : '-' }}
            </p>
        </div>
        @endif
    </div>

    {{-- Preview surat & sertifikat --}}
    @if($pengajuan && $pengajuan->status_verifikasi != 'ditolak')
        <div class="bg-white p-6 rounded shadow border">
            <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Preview Surat Keterangan & Sertifikat</h3>
            @if($pengajuan->status_verifikasi == 'disetujui')
                <a href="{{ route('mahasiswa.surat.preview', $pengajuan->id_surat) }}" target="_blank" class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mb-4">
                    <i class="fa fa-file-pdf mr-2"></i> Preview / Download Surat Keterangan TOEIC 2x
                </a>
            @endif
            <p class="font-bold text-sm text-gray-600 mb-2">Sertifikat TOEIC 2x:</p>
            <embed src="{{ asset('storage/' . $pengajuan->file_sertifikat) }}" type="application/pdf" width="100%" height="500px" class="border rounded" />
        </div>
    @endif

    {{-- Upload ulang jika ditolak --}}
    @if($pengajuan && $pengajuan->status_verifikasi == 'ditolak')
        <div class="bg-red-50 p-6 rounded shadow border border-red-300">
            <h3 class="text-xl font-semibold text-red-700 mb-2">Pengajuan Anda Ditolak</h3>
            <p class="mb-4 text-sm text-red-600"><strong>Catatan:</strong> {{ $pengajuan->catatan ?? '-' }}</p>

            <form action="{{ route('mahasiswa.surat.uploadUlang') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="file_sertifikat" class="block font-semibold mb-1">Upload Ulang Sertifikat TOEIC (PDF, maksimal 5MB):</label>
                <input type="file" name="file_sertifikat" accept="application/pdf" class="block w-full border rounded px-3 py-2 mt-1" required>
                @error('file_sertifikat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Upload Ulang Sertifikat
                </button>
            </form>
        </div>
    @endif

    {{-- Belum mengajukan --}}
    @if(!$pengajuan)
        @if(!$sertifikat)
            <div class="bg-gray-50 p-6 rounded shadow border">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Upload Sertifikat TOEIC</h3>
                <form action="{{ route('mahasiswa.surat.uploadSertifikat') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="file_sertifikat" class="block font-semibold mb-1">Upload File Sertifikat (PDF, maksimal 5MB):</label>
                    <input type="file" name="file_sertifikat" accept="application/pdf" class="block w-full border rounded px-3 py-2 mt-1" required>
                    @error('file_sertifikat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Upload Sertifikat
                    </button>
                </form>
            </div>
        @else
            <div class="bg-white p-6 rounded shadow border">
                <p class="text-green-700 font-semibold mb-2">✅ Sertifikat berhasil diupload</p>
                <p><strong>Lihat Sertifikat:</strong> 
                    <a href="{{ asset('storage/' . session('sertifikat_uploaded')) }}" class="text-blue-600 underline" target="_blank">Klik di sini</a>
                </p>

                <form action="{{ route('mahasiswa.surat.hapusSertifikat') }}" method="POST" class="inline-block mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 underline text-sm hover:text-red-800 transition" onclick="return confirm('Hapus sertifikat yang sudah diupload?')">
                        Hapus Sertifikat
                    </button>
                </form>

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
