@extends('layouts2.template')

@section('content')
<h4>Kelola Kuota Jadwal Ujian</h4>
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
                                    <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.sesi.index', $jadwal->id_jadwal) }}" class="btn btn-sm btn-primary">
                                        Sesi & Room
                                    </a>
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
@endsection