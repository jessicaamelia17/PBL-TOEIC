@extends('layouts2.template')

@section('content')
<div class="card card-outline card-primary">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">{{ $page->title ?? 'Data Pendaftar' }}</h3>
        <div class="d-flex justify-content-end w-100" style="gap: 8px;">
            <button class="btn btn-success mr-2" data-toggle="modal" data-target="#importCSVModal">
                <i class="fas fa-file-import"></i> Import CSV
            </button>
            <button class="btn btn-success" data-toggle="modal" data-target="#exportCSVModal">
                <i class="fas fa-file-export"></i> Export CSV
            </button>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_pendaftar">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Email</th>
                    <th>Prodi</th>
                    <th>Jurusan</th>
                    <th>Tanggal Pendaftaran</th>
                    <th>Jadwal Ujian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Import CSV -->
<div class="modal fade" id="importCSVModal" tabindex="-1" aria-labelledby="importCSVModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.pendaftar.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="importCSVModalLabel">Import Data Pendaftar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
              <label for="file">Pilih File CSV</label>
              <input type="file" name="file" accept=".csv" required class="form-control" id="file">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Export CSV -->
<div class="modal fade" id="exportCSVModal" tabindex="-1" aria-labelledby="exportCSVModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.pendaftar.export') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exportCSVModalLabel">Export Data Pendaftar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Klik tombol Export untuk mengunduh data pendaftar dalam format CSV.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Export</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Ajax -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" aria-hidden="true"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('#table_pendaftar').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.pendaftar.list') }}",
                type: "POST",
                dataType: "json"
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'NIM', name: 'NIM' },
                { data: 'nama', name: 'nama' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'email', name: 'email' },
                { data: 'Nama_Prodi', name: 'Nama_Prodi' },
                { data: 'Nama_Jurusan', name: 'Nama_Jurusan' },
                { data: 'Tanggal_Pendaftaran', name: 'Tanggal_Pendaftaran' },
                { data: 'Jadwal', name: 'Jadwal' }, // Tambahkan ini
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush