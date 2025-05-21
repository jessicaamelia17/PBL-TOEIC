@extends('layouts2.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title ?? 'Data Surat Pengajuan' }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/admin/surat/create_ajax') }}')" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Surat (Ajax)
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

            <table class="table table-bordered table-striped table-hover table-sm" id="table_surat">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengaju</th>
                        <th>Judul Surat</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $('#table_surat').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.surat.list') }}", // ganti dengan route ajax untuk surat
                    type: "POST",
                    dataType: "json"
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_pengaju"
                    },
                    {
                        data: "judul"
                    },
                    {
                        data: "tanggal_pengajuan"
                    },
                    {
                        data: "status",
                        render: function(data) {
                            let badge = 'secondary';
                            if (data === 'diterima') badge = 'success';
                            else if (data === 'menunggu') badge = 'warning';
                            else if (data === 'ditolak') badge = 'danger';
                            return `<span class="badge badge-${badge}">${data}</span>`;
                        }
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