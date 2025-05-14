@extends('layouts2.template')

@section('content')
<div class="container">
    <h3>Daftar Jadwal Ujian TOEIC</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal Ujian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwal as $jadwalItem)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($jadwalItem->Tanggal_Ujian)->format('l, d F Y') }}</td>
                    <td>
                        <!-- Link ke halaman pendaftar dengan mengirimkan parameter id jadwal -->
                        <a href="{{ route('schedule.pendaftar', ['id' => $jadwalItem->id_jadwal]) }}" class="btn btn-info">
                            Lihat Peserta
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
