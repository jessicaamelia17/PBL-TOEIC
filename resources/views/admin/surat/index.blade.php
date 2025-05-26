@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-xl font-semibold mb-4">Daftar Pengajuan Surat TOEIC</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">NIM</th>
                    <th class="px-4 py-2">Prodi</th>
                    <th class="px-4 py-2">Tanggal Pengajuan</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $item->mahasiswa->nama }}</td>
                        <td class="px-4 py-2">{{ $item->mahasiswa->nim }}</td>
                        <td class="px-4 py-2">{{ $item->mahasiswa->prodi }}</td>
                        <td class="px-4 py-2">{{ $item->tanggal_pengajuan }}</td>
                        <td class="px-4 py-2 capitalize">{{ $item->status }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.surat.show', $item->id) }}" class="text-blue-600 hover:underline">
                                Detail & Verifikasi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center text-gray-500">Belum ada pengajuan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
