@extends('layouts2.template')

@section('title', 'Daftar Pengajuan Surat TOEIC')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Pengajuan Surat TOEIC</h3>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_pengajuan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->mahasiswa->nama }}</td>
                            <td>{{ $item->mahasiswa->nim }}</td>
                            <td>{{ $item->mahasiswa->prodi->Nama_Prodi }}</td>
                            <td>{{ $item->tanggal_pengajuan }}</td>
                            <td>
                                @if ($item->status_verifikasi == 'diterima')
                                    <span class="badge badge-success text-capitalize">{{ $item->status_verifikasi }}</span>
                                @elseif ($item->status_verifikasi == 'ditolak')
                                    <span class="badge badge-danger text-capitalize">{{ $item->status_verifikasi }}</span>
                                @else
                                    <span class="badge badge-warning text-capitalize">{{ $item->status_verifikasi }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.surat.show', $item->id_surat) }}" class="btn btn-sm btn-primary">
                                    Detail & Verifikasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pengajuan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection