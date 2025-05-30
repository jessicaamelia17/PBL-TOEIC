@extends('layouts2.template')

@section('title', 'Daftar Sertifikat')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Daftar Sertifikat</h3>
        <div class="ml-auto">
            <button class="btn btn-success" data-toggle="modal" data-target="#exportCSVModal">
                <i class="fas fa-file-export"></i> Export CSV
            </button>
        </div>
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
                    <th>Checklist</th>
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

<!-- Modal Export CSV -->
<div class="modal fade" id="exportCSVModal" tabindex="-1" aria-labelledby="exportCSVModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.admin.sertifikat.export') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exportCSVModalLabel">Export Sertifikat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Klik tombol Export untuk mengunduh data sertifikat dalam format CSV.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Export</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#table_sertifikat').DataTable({
            paging: false,
            searching: true,
            info: false,
            ordering: true,
        });
    });
</script>
@endpush