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
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sertifikats as $index => $sertifikat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sertifikat->nama_mahasiswa }}</td>
                            <td>{{ $sertifikat->nim }}</td>
                            <td>{{ $sertifikat->prodi }}</td>
                            <td>{{ $sertifikat->tanggal_pengambilan ? date('d-m-Y', strtotime($sertifikat->tanggal_pengambilan)) : '-' }}</td>
                            <td>
                                @if($sertifikat->status == 'diambil')
                                    <span class="badge badge-success">Diambil</span>
                                @else
                                    <span class="badge badge-warning">Belum Diambil</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data sertifikat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection