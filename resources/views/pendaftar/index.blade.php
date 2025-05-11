@extends('layouts2.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title ?? 'Data Pendaftar' }}</h3>
            <div class="text-right mb-3">
                {{-- <a href="{{ route('pendaftar.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-user"></i> Profil Saya
            </a> --}}
            </div>
            <div class="card-tools">
                @cannot('admin')
                    <button onclick="modalAction('{{ url('/pendaftar/import') }}')" class="btn btn-info">Import Pendaftar</button>
                    <button onclick="modalAction('{{ url('/pendaftar/create_ajax') }}')" class="btn btn-success">Tambah Pendaftar
                        (Ajax)</button>
                @endcannot
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
                        <th>ID</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>No. WA</th>
                        <th>Email</th>
                        <th>Jurusan</th>
                        <th>Prodi</th>
                        {{-- <th>Scan KTP</th>
                        <th>Scan KTM</th>
                        <th>Pas Foto</th> --}}
                        <th>Tanggal Pendaftaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            $('#table_pendaftar').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('pendaftar/list') }}",
                    type: "POST",
                    dataType: "json",
                    data: function(d) {
                        // Tambah filter jika diperlukan
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "NIM"
                    },
                    {
                        data: "Nama"
                    },
                    {
                        data: "No_WA"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "jurusan.Nama_Jurusan",
                        defaultContent: '-'
                    },
                    {
                        data: "prodi.Nama_Prodi",
                        defaultContent: '-'
                    },
                    // {
                    //     data: "Scan_KTP",
                    //     render: function(data) {
                    //         return `<a href="/storage/${data}" target="_blank">Lihat</a>`;
                    //     }
                    // },
                    // {
                    //     data: "Scan_KTM",
                    //     render: function(data) {
                    //         return `<a href="/storage/${data}" target="_blank">Lihat</a>`;
                    //     }
                    // },
                    // {
                    //     data: "Pas_Foto",
                    //     render: function(data) {
                    //         return `<a href="/storage/${data}" target="_blank">Lihat</a>`;
                    //     }
                    // },
                    {
                        data: "Tanggal_Pendaftaran"
                    },
                    {
                        data: "aksi",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
