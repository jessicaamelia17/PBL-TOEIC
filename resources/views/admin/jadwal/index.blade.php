@extends('layouts2.template')

@section('content')
<h4>Kelola Kuota Jadwal Ujian</h4>
<table class="table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kuota Max</th>
            <th>Kuota Terpakai</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jadwals as $jadwal)
            <tr>
                <td>{{ $jadwal->Tanggal_Ujian }}</td>
                <td>{{ $jadwal->kuota_max }}</td>
                <td>{{ $jadwal->kuota_terpakai }}</td>
                <td>{{ ucfirst($jadwal->status_registrasi) }}</td>
                <td><a href="{{ route('admin.jadwal.edit', $jadwal->Id_Jadwal) }}" class="btn btn-sm btn-primary">Edit</a></td>

            </tr>
        @endforeach
    </tbody>
</table>
@endsection
