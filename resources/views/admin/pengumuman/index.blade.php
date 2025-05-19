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
            $('#table_pengumuman').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.pengumuman.list') }}", // Buat route ini di web.php & controller
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
        });
    </script>
@endpush
