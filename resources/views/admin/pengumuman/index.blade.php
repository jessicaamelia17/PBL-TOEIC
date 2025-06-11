@extends('layouts2.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Pengumuman</h3>
            <div class="card-tools">
                <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-success">+ Buat Pengumuman</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_pengumuman">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Isi</th>
                        <th>Tanggal</th>
                        <th>Dibuat Oleh</th>
                        <th>File Pengumuman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var table = $('#table_pengumuman').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.pengumuman.list') }}",
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
                        data: 'Judul'
                    },
                    {
                        data: 'Isi',
                        render: function(data) {
                            return data.length > 100 ? data.substring(0, 100) + '...' : data;
                        }
                    },
                    {
                        data: 'Tanggal_Pengumuman'
                    },
                    {
                        data: 'admin.Username',
                        defaultContent: 'Tidak diketahui'
                    },
                    {
                        data: 'file_pengumuman',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // SweetAlert konfirmasi hapus
            $('#table_pengumuman').on('submit', 'form', function(e) {
                e.preventDefault();
                var form = this;
                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Data pengumuman akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
