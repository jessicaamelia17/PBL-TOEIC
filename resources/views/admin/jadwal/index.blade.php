@extends('layouts2.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Peserta Ujian (Semua Jadwal)</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hari / Tanggal</th>
                        <th>Sesi</th>
                        <th>Room</th>
                        <th>Nama Lengkap</th>
                        <th>NIM</th>
                        <th>Program Studi</th>
                        <th>Kelas</th>
                        <th>Zoom ID</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($jadwalList as $jadwal)
                        @foreach ($jadwal->sesi as $sesi)
                            @foreach ($sesi->rooms as $room)
                                @foreach ($room->pendaftar as $peserta)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}</td>
                                        <td>{{ $sesi->nama_sesi }} ({{ $sesi->waktu_mulai }} - {{ $sesi->waktu_selesai }})</td>
                                        <td>{{ $room->nama_room }}</td>
                                        <td>{{ $peserta->Nama }}</td>
                                        <td>{{ $peserta->NIM }}</td>
                                        <td>{{ $peserta->prodi->Nama_Prodi ?? '-' }}</td>
                                        <td>{{ $peserta->kelas }}</td>
                                        <td>{{ $room->zoom_id }}</td>
                                        <td>{{ $room->zoom_password }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
