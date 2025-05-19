@extends('layouts.app2')

@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection

@section('content')
<div class="max-w-screen-lg mx-auto px-4 py-6 mb-10">
    <h2 class="text-center font-bold text-blue-700 text-xl mb-4">Daftar Jadwal Ujian TOEIC</h2>

    <div class="overflow-x-auto">
        <table class="table table-bordered table-hover align-middle shadow-sm bg-white rounded">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Tanggal Ujian</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwal as $jadwalItem)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($jadwalItem->Tanggal_Ujian)->translatedFormat('l, d F Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('schedule.pendaftar', ['id' => $jadwalItem->id_jadwal]) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-users me-1"></i> Lihat Peserta
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">Belum ada jadwal ujian tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
