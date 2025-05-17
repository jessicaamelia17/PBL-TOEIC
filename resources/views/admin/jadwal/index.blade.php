@extends('layouts2.template')

@section('title', 'Kelola Kuota Jadwal Ujian')

@section('content')
<div class="container-fluid">



    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Jadwal --}}
    <div class="card">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Jadwal Ujian</strong>
        </div>
        <div class="card-body">
            @if($jadwals->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kuota Maksimum</th>
                            <th>Kuota Terpakai</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwals as $jadwal)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($jadwal->Tanggal_Ujian)->format('d M Y') }}</td>
                                <td>{{ $jadwal->kuota_max }}</td>
                                <td>{{ $jadwal->kuota_terpakai }}</td>
                                <td>
                                    <span class="badge bg-{{ $jadwal->status_registrasi === 'dibuka' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($jadwal->status_registrasi) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.jadwal.edit', $jadwal->Id_Jadwal) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                    <a href="{{ route('admin.sesi.index', ['id' => $jadwal->Id_Jadwal]) }}" class="btn btn-sm btn-success">Sesi & Room</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p class="text-muted">Belum ada jadwal ujian tersedia.</p>
            @endif
        </div>
    </div>

</div>
@endsection
