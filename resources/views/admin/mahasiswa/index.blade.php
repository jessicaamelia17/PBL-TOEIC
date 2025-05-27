{{-- filepath: resources/views/admin/mahasiswa/index.blade.php --}}
@extends('layouts2.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Mahasiswa</h3>
            <div class="card-tools">
                <a href="javascript:void(0)" id="btn-import-mahasiswa" class="btn btn-warning">Import Data Mahasiswa</a>
                <a href="javascript:void(0)" id="btn-tambah-mahasiswa" class="btn btn-success">+ Tambah Mahasiswa</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_mahasiswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Study Program</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal Tambah Mahasiswa -->
    <div class="modal fade" id="modalTambahMahasiswa" tabindex="-1" aria-labelledby="modalTambahMahasiswaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahMahasiswaLabel">Tambah Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="form-tambah-mahasiswa-body">
                    {{-- Form akan dimuat via AJAX --}}
                    <div class="text-center py-5">
                        <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Mahasiswa -->
    <div class="modal fade" id="modalImportMahasiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-import-mahasiswa" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Mahasiswa</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Download Template</label><br>
                            <a href="{{ asset('template/template_mahasiswa.xlsx') }}" class="btn btn-info btn-sm" download>
                                <i class="fa fa-file-excel"></i> Download
                            </a>
                        </div>
                        <div class="form-group">
                            <label>Pilih File</label>
                            <input type="file" name="file_mahasiswa" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#table_mahasiswa').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.mahasiswa.list') }}",
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'nim'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'jurusan'
                    },
                    {
                        data: 'prodi'
                    },
                    {
                        data: 'no_hp'
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'desc']
                ],
            });

            // Tampilkan modal tambah mahasiswa via AJAX
            $('#btn-tambah-mahasiswa').on('click', function() {
                $('#modalTambahMahasiswa').modal('show');
                $('#form-tambah-mahasiswa-body').html(
                    '<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i></div>'
                );
                $.get("{{ route('admin.mahasiswa.create') }}", function(res) {
                    $('#form-tambah-mahasiswa-body').html(res);
                });
            });

            // Submit form tambah mahasiswa via AJAX
            $(document).on('submit', '#form-tambah-mahasiswa', function(e) {
                e.preventDefault();
                var form = $(this);
                var btn = form.find('button[type=submit]');
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(res) {
                        $('#modalTambahMahasiswa').modal('hide');
                        $('#table_mahasiswa').DataTable().ajax.reload();
                        // Optional: tampilkan notifikasi sukses
                        location.reload(); // reload agar pesan sukses tampil
                    },
                    error: function(xhr) {
                        $('#form-tambah-mahasiswa-body').html(xhr.responseText);
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('Simpan');
                    }
                });
            });

            // Modal Import Mahasiswa
            $('#btn-import-mahasiswa').on('click', function() {
                $('#modalImportMahasiswa').modal('show');
            });

            // Submit form import mahasiswa
            $('#form-import-mahasiswa').on('submit', function(e) {
                e.preventDefault();
                var form = $(this)[0];
                var formData = new FormData(form);

                $.ajax({
                    url: "{{ route('admin.mahasiswa.import_ajax') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $('#modalImportMahasiswa').modal('hide');
                        Swal.fire('Berhasil', res.message, 'success');
                        $('#table_mahasiswa').DataTable().ajax.reload();
                    },
                    error: function() {
                        Swal.fire('Gagal', 'Terjadi kesalahan saat mengimpor data.', 'error');
                    }
                });
            });
        });
    </script>
@endpush
