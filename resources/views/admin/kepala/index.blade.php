{{-- filepath: resources/views/admin/kepala/index.blade.php --}}
@extends('layouts2.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Kepala UPA Bahasa</h3>
            <div class="card-tools">
                <a href="{{ route('admin.kepala.create') }}" class="btn btn-success">+ Tambah Kepala</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert" style="font-size:1.1rem;">
                    <span class="mr-3"><i class="fas fa-check-circle fa-lg"></i></span>
                    <div>
                        <strong>Sukses!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert" style="font-size:1.1rem;">
                    <span class="mr-3"><i class="fas fa-exclamation-triangle fa-lg"></i></span>
                    <div>
                        <strong>Gagal!</strong> {{ session('error') }}
                    </div>
                    <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_kepala">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Pangkat</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>TTD</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kepalas as $i => $kepala)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $kepala->nama }}</td>
                            <td>{{ $kepala->nip }}</td>
                            <td>{{ $kepala->pangkat }}</td>
                            <td>{{ $kepala->jabatan }}</td>
                            <td>
                                @if ($kepala->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if ($kepala->ttd_path)
                                    <img src="{{ asset('storage/' . $kepala->ttd_path) }}" width="80">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.kepala.edit', $kepala->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                @if (!$kepala->is_active)
                                <form id="formAktifkan{{ $kepala->id }}" action="{{ route('admin.kepala.setActive', $kepala->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-warning btn-sm btn-show-modal-aktifkan"
                                        data-id="{{ $kepala->id }}">
                                        <i class="fas fa-check-circle"></i> Aktifkan
                                    </button>
                                </form>
                                @else
                                <form id="formNonAktifkan{{ $kepala->id }}" action="{{ route('admin.kepala.setNonActive', $kepala->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-danger btn-sm btn-show-modal-nonaktifkan"
                                        data-id="{{ $kepala->id }}">
                                        <i class="fas fa-times-circle"></i> Nonaktifkan
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal Konfirmasi Aktifkan -->
<div class="modal fade" id="modalAktifkan" tabindex="-1" role="dialog" aria-labelledby="modalAktifkanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="modalAktifkanLabel"><i class="fas fa-exclamation-triangle"></i> Konfirmasi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Aktifkan kepala ini? Kepala sebelumnya akan dinonaktifkan.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-warning" id="btnKonfirmasiAktifkan">Aktifkan</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Konfirmasi Nonaktifkan -->
<div class="modal fade" id="modalNonAktifkan" tabindex="-1" role="dialog" aria-labelledby="modalNonAktifkanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="modalNonAktifkanLabel"><i class="fas fa-times-circle"></i> Konfirmasi</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Nonaktifkan kepala ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="btnKonfirmasiNonAktifkan">Nonaktifkan</button>
        </div>
      </div>
    </div>
  </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#table_kepala').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                },
                emptyTable: "Tidak ada data tersedia"
            }
        });
    });

    let formIdToSubmit = null;
    $(document).on('click', '.btn-show-modal-aktifkan', function() {
        formIdToSubmit = '#formAktifkan' + $(this).data('id');
        $('#modalAktifkan').modal('show');
    });
    $('#btnKonfirmasiAktifkan').on('click', function() {
        if (formIdToSubmit) {
            $(formIdToSubmit).submit();
        }
    });

    let formIdToSubmitNon = null;
    $(document).on('click', '.btn-show-modal-nonaktifkan', function() {
        formIdToSubmitNon = '#formNonAktifkan' + $(this).data('id');
        $('#modalNonAktifkan').modal('show');
    });
    $('#btnKonfirmasiNonAktifkan').on('click', function() {
        if (formIdToSubmitNon) {
            $(formIdToSubmitNon).submit();
        }
    });
</script>
@endpush
