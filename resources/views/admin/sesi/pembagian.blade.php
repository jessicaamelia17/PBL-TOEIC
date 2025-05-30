{{-- filepath: resources/views/admin/sesi/pembagian.blade.php --}}
@extends('layouts2.template')

@section('content')
<div><a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Kembali</a></div>
<br>
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><h4 class="card-title mb-0">Daftar Pembagian Peserta Sesi & Room TOEIC</h4></div>
        </div>

        <div class="card-body">
            <div class="mb-3 d-flex flex-wrap align-items-center justify-content-between">
                <div>
                    <label for="filterProdi" class="form-label mb-0 me-2">Filter Program Studi:</label>
                    <select id="filterProdi" class="form-select d-inline-block w-auto">
                        <option value="">- Semua -</option>
                        @php
                            $prodiList = [];
                            foreach ($jadwal->sesi as $sesi) {
                                foreach ($sesi->rooms as $room) {
                                    foreach ($room->peserta as $peserta) {
                                        $prodi = optional(optional($peserta->mahasiswa)->prodi)->Nama_Prodi;
                                        if ($prodi && !in_array($prodi, $prodiList)) {
                                            $prodiList[] = $prodi;
                                        }
                                    }
                                }
                            }
                            sort($prodiList);
                        @endphp
                        @foreach ($prodiList as $prodi)
                            <option value="{{ trim($prodi) }}">{{ trim($prodi) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-end small text-muted mt-2 mt-md-0">
                    Total Peserta: <b>{{ $jadwal->sesi->flatMap->rooms->flatMap->peserta->count() }}</b>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm" id="pesertaTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>NIM</th>
                            <th>Program Studi</th>
                            <th>Sesi</th>
                            <th>Room</th>
                            <th>Zoom ID</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($jadwal->sesi as $sesi)
                            @foreach ($sesi->rooms as $room)
                                @foreach ($room->peserta as $peserta)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ optional($peserta->mahasiswa)->nama ?? '-' }}</td>
                                        <td>{{ $peserta->NIM }}</td>
                                        <td>{{ trim(optional(optional($peserta->mahasiswa)->prodi)->Nama_Prodi ?? '-') }}</td>
                                        <td>
                                            <span class="fw-semibold">{{ $sesi->nama_sesi ?? '-' }}</span><br>
                                            <span class="text-muted small">
                                                {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}
                                            </span>
                                        </td>
                                        <td>{{ $room->nama_room ?? '-' }}</td>
                                        <td>{{ $room->zoom_id }}</td>
                                        <td>{{ $room->zoom_password }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endSection

@push('js')
<script>
$(document).ready(function () {
    var table = $('#pesertaTable').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 25,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ entri",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            },
            "emptyTable": "Tidak ada data tersedia",
        },
        "ordering": false,
        "columnDefs": [
            { "orderable": false, "targets": "_all" }
        ]
    });

    // Filtering Program Studi
    $('#filterProdi').on('change', function () {
        var selected = $(this).val();
        if(selected === "") {
            table.column(3).search('').draw();
        } else {
            table.column(3).search('^' + selected + '$', true, false).draw();
        }
    });
});
</script>
@endpush