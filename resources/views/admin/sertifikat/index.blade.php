@extends('layouts2.template')

@section('title', 'Daftar Sertifikat')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Sertifikat</h3>
        <div class="d-flex gap-2 ml-auto">
            <button class="btn btn-success mr-2" data-toggle="modal" data-target="#exportCSVModal">
                <i class="fas fa-file-export"></i> Export CSV
            </button>
            <a href="{{ route('admin.sertifikat.exportPdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('admin.sertifikat.sync') }}" class="btn btn-primary mb-2">
            <i class="fas fa-sync"></i> Sinkron Sertifikat Lulus
        </a>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_sertifikat">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                    <th>Tanggal Diambil</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sertifikats as $index => $item)
                    @php
                        // Ambil mahasiswa dari relasi pendaftaran melalui hasilUjian
                        $pendaftaran = $item->hasilUjian->pendaftaran ?? null;
                        $mahasiswa = $pendaftaran ? $pendaftaran->mahasiswa : null;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mahasiswa->nama ?? '-' }}</td>
                        <td>{{ $mahasiswa->nim ?? '-' }}</td>
                        <td>{{ $mahasiswa->prodi->Nama_Prodi ?? '-' }}</td>
                        <td>{{ $item->Tanggal_Diambil ? date('d-m-Y', strtotime($item->Tanggal_Diambil)) : '-' }}</td>
                        <td>
                            @if($item->Status == 'Diambil')
                                <span class="badge badge-success">Diambil</span>
                            @else
                                <span class="badge badge-warning">Belum Diambil</span>
                            @endif
                        </td>
                        <td>
                            @if($item->Status != 'Diambil')
                            <form action="{{ route('admin.sertifikat.ambil', $item->id_pengambilan) }}" method="POST" class="d-inline form-ambil-sertifikat">
                                @csrf
                                @method('PUT')
                                <button type="button" class="btn btn-sm btn-success btn-ambil-sertifikat">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @else
                                <button class="btn btn-sm btn-secondary" disabled>
                                    <i class="fas fa-check"></i>
                                </button>
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
        <form action="{{ route('admin.sertifikat.export') }}" method="GET">
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
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-ambil-sertifikat').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Yakin ingin menandai sertifikat ini sudah diambil?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, tandai diambil',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.closest('form').submit();
                    }
                });
            });
        });
    });
</script>
@endpush
