@extends('layouts2.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title ?? 'Data Surat Pengajuan' }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ route('admin.surat.create_ajax') }}')" class="btn btn-success">
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
                        <th>NIM</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status Verifikasi</th>
                        <th>Tanggal Verifikasi</th>
                        <th>Catatan</th>
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
                    url: "{{ route('admin.surat.list') }}",
                    type: "POST"
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    { data: 'NIM', name: 'NIM' },
                    { data: 'Tanggal_Pengajuan', name: 'Tanggal_Pengajuan' },
                    {
                        data: 'Status_Verifikasi',
                        name: 'Status_Verifikasi',
                        render: function(data, type, row) {
                            let badge = 'secondary';
                            if (data === 'disetujui') badge = 'success';
                            else if (data === 'menunggu') badge = 'warning';
                            else if (data === 'ditolak') badge = 'danger';

                            return `
                                <select class="form-control form-control-sm status-verifikasi" data-id="${row.Id_Surat}">
                                    <option value="menunggu" ${data === 'menunggu' ? 'selected' : ''}>Menunggu</option>
                                    <option value="disetujui" ${data === 'disetujui' ? 'selected' : ''}>Disetujui</option>
                                    <option value="ditolak" ${data === 'ditolak' ? 'selected' : ''}>Ditolak</option>
                                </select>
                            `;
                        }
                    },
                    { data: 'Tanggal_Verifikasi', name: 'Tanggal_Verifikasi' },
                    { data: 'Catatan', name: 'Catatan' },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Event listener ubah status via ajax
            $('#table_surat').on('change', '.status-verifikasi', function () {
                let id = $(this).data('id');
                let status = $(this).val();

                $.post(`/admin/surat/${id}/update_status`, { status }, function (res) {
                    toastr.success(res.message);
                    $('#table_surat').DataTable().ajax.reload(null, false);
                }).fail(function () {
                    toastr.error('Gagal memperbarui status.');
                });
            });
        });
    </script>
@endpush
