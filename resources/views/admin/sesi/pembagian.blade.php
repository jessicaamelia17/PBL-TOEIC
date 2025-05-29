{{-- filepath: resources/views/admin/sesi/pembagian.blade.php --}}
@extends('layouts2.template')

@section('title', 'Pembagian Peserta Sesi & Room')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Pembagian Peserta Sesi & Room ({{ $jadwal->Tanggal_Ujian }})</h4>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Kembali</a>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0" style="background: #f8faff;">
                <thead class="table-primary align-middle text-center">
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th style="min-width: 180px;">NAMA PESERTA</th>
                        <th style="min-width: 120px;">NIM</th>
                        <th style="min-width: 180px;">PROGRAM STUDI</th>
                        <th style="min-width: 180px;">ZOOM ID</th>
                        <th style="min-width: 120px;">PASSWORD</th>
                    </tr>
                </thead>
                <tbody>
                @php $no = 1; @endphp
                @foreach ($jadwal->sesi as $sesi)
                    <tr class="table-info">
                        <td colspan="6" class="fw-bold text-primary" style="background: #eaf4ff;">
                            <i class="bi bi-clock"></i>
                            Session {{ $loop->iteration }} ({{ $sesi->waktu_mulai }} - {{ $sesi->waktu_selesai }})
                        </td>
                    </tr>
                    @foreach ($sesi->rooms as $room)
                        <tr style="background: #f2f4f8;">
                            <td colspan="6" class="fw-semibold text-dark">
                                <i class="bi bi-door-closed"></i>
                                {{ $room->nama_room }}
                                <span class="badge bg-secondary ms-2">Kapasitas: {{ $room->kapasitas }}</span>
                            </td>
                        </tr>
                        @forelse ($room->peserta as $i => $peserta)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ optional($peserta->mahasiswa)->nama ?? '-' }}</td>
                                <td>{{ $peserta->NIM }}</td>
                                <td>{{ optional(optional($peserta->mahasiswa)->prodi)->Nama_Prodi ?? '-' }}</td>
                                <td>{{ $room->zoom_id }}</td>
                                <td>{{ $room->zoom_password }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada peserta di room ini.</td>
                            </tr>
                        @endforelse
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection