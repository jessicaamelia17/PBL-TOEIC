@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">{{ $breadcrumb->title }}</h4>

    @if ($jadwal->sesi->isEmpty())
        <div class="alert alert-warning">Tidak ada sesi untuk jadwal ini.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Sesi</th>
                        <th>Waktu</th>
                        <th>Nama Room</th>
                        <th>Zoom ID</th>
                        <th>Password</th>
                        <th>Nama Peserta</th>
                        <th>NIM</th>
                        <th>Program Studi</th>
                        {{-- <th>Kelas</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($jadwal->sesi as $sesi)
                        @foreach ($sesi->rooms as $room)
                            @if ($room->peserta->isEmpty())
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $sesi->nama_sesi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}</td>
                                    <td>{{ $room->nama_room }}</td>
                                    <td>{{ $room->zoom_id }}</td>
                                    <td>{{ $room->zoom_password }}</td>
                                    <td colspan="4" class="text-muted text-center">Belum ada peserta</td>
                                </tr>
                            @else
                                @foreach ($room->peserta as $peserta)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $sesi->nama_sesi }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}</td>
                                        <td>{{ $room->nama_room }}</td>
                                        <td>{{ $room->zoom_id }}</td>
                                        <td>{{ $room->zoom_password }}</td>
                                        <td>{{ $peserta->Nama }}</td>
                                        <td>{{ $peserta->NIM }}</td>
                                        <td>{{ $peserta->prodi->Nama_Prodi ?? '-' }}</td>
                                        {{-- <td>{{ $peserta->kelas ?? '-' }}</td> --}}
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
