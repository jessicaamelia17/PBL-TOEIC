@extends('layouts2.template')

@section('title', 'Daftar Sertifikat')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Sertifikat</h3>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_sertifikat">
                <thead>
    <tr>
        <th>No</th>
        <th>Nama Mahasiswa</th>
        <th>NIM</th>
        <th>Program Studi</th>
        <th>Tanggal Diambil</th>
        <th>Status</th>
        <th>Checklist</th> {{-- Tambahan --}}
    </tr>
</thead>
<tbody>
    @forelse ($sertifikats as $index => $sertifikat)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $sertifikat->Nama }}</td>
            <td>{{ $sertifikat->NIM }}</td>
            <td>{{ $sertifikat->Program_Studi }}</td>
            <td>{{ $sertifikat->Tanggal_Diambil ? date('d-m-Y', strtotime($sertifikat->Tanggal_Diambil)) : '-' }}</td>
            <td>
                @if($sertifikat->Status == 'Diambil')
                    <span class="badge badge-success">Diambil</span>
                @else
                    <span class="badge badge-warning">Belum Diambil</span>
                @endif
            </td>
            <td>
                @if($sertifikat->Status == 'Belum Diambil')
                    <form method="POST" action="{{ route('admin.sertifikat.update', $sertifikat->id_pengambilan) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary">Sudah Diambil</button>
                    </form>
                @else
                    <i class="text-muted">Sudah</i>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">Tidak ada data sertifikat.</td>
        </tr>
    @endforelse
</tbody>

            </table>
        </div>
    </div>
@endsection