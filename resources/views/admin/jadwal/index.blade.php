@extends('layouts2.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title ">Daftar Jadwal Ujian</h3>
        <div class="card-tools">
            <a href="{{ $kuotaPenuh ? '#' : route('admin.jadwal.create') }}"
               class="btn btn-success btn-sm {{ $kuotaPenuh ? 'disabled bg-secondary border-0' : '' }}"
               {{ $kuotaPenuh ? 'aria-disabled=true tabindex=-1 style=pointer-events:none;' : '' }}>
                + Tambah Jadwal
            </a>
        </div>
    </div>  
    <div class="card-body">
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
        @if($errors->has('kuota_max'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Maaf, kuota sudah penuh anda tidak dapat menambah jadwal.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

        @if($jadwals->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kuota Maksimum</th>
                        <th>Kuota Terpakai</th>
                        <th width="220">Aksi</th>
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
                                <form action="{{ route('admin.jadwal.destroy', $jadwal->id_jadwal) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
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