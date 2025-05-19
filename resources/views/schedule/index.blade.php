@extends('layouts.app2')

@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection

@section('content')
<div class="min-h-screen bg-blue-100 py-10 px-4">
    <div class="w-full mx-auto bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-center font-bold text-blue-700 text-3xl mb-8">Daftar Jadwal Ujian TOEIC</h2>

        <div class="w-full overflow-auto">
            <table class="w-full border border-gray-300 rounded-lg shadow text-base">
                <thead class="bg-blue-200 text-blue-800 font-bold text-lg">
                    <tr>
                        <th class="py-3 px-6 border border-gray-300 text-left">Tanggal Ujian</th>
                        <th class="py-3 px-6 border border-gray-300 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwal as $jadwalItem)
                        <tr class="hover:bg-blue-50">
                            <td class="py-4 px-6 border border-gray-300">
                                {{ \Carbon\Carbon::parse($jadwalItem->Tanggal_Ujian)->translatedFormat('l, d F Y') }}
                            </td>
                            <td class="py-4 px-6 border border-gray-300 text-center">
                                <a href="{{ route('schedule.pendaftar', ['id' => $jadwalItem->id_jadwal]) }}"
                                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                    <i class="fas fa-users me-1"></i> Lihat Peserta
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-6 text-gray-500 text-lg">Belum ada jadwal ujian tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
