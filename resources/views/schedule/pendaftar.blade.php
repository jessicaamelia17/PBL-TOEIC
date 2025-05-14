@extends('layouts.app2')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $breadcrumb->title }}</h1>

    @if ($jadwal->sesi->isEmpty())
        <div class="alert alert-warning">Tidak ada sesi untuk jadwal ini.</div>
    @else
        <div class="table-responsive">
            <div class="row mb-3">
            <div class="col-md-4">
                <label for="filterProdi" class="form-label">Filter Program Studi:</label>
                <select id="filterProdi" class="form-select">
                    <option value="">- Semua -</option>
                    @foreach ($prodiList as $prodi)
                        <option value="{{ $prodi->Nama_Prodi }}">{{ $prodi->Nama_Prodi }}</option>
                    @endforeach
                </select>
            </div>
        </div>

             <table id="pesertaTable" class="table table-bordered table-striped">
            
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Sesi</th>
                        <th>Waktu</th>
                        <th>Nama Room</th>
                        <th>Zoom ID</th>
                        <th>Password</th>
                        <th>Nama Peserta</th>
                        <th>NIM</th>
                        <th>Program Studi</th>
                        {{-- <th>Kelas</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($jadwal->sesi as $sesi)
                        @foreach ($sesi->rooms as $room)
                            @if ($room->peserta->isEmpty())
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $sesi->nama_sesi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}</td>
                                    <td>{{ $room->nama_room }}</td>
                                    <td>{{ $room->zoom_id }}</td>
                                    <td>{{ $room->zoom_password }}</td>
                                    <td colspan="4" class="text-muted text-center">Belum ada peserta</td>
                                </tr>
                            @else
                                @foreach ($room->peserta as $peserta)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $sesi->nama_sesi }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}</td>
                                        <td>{{ $room->nama_room }}</td>
                                        <td>{{ $room->zoom_id }}</td>
                                        <td>{{ $room->zoom_password }}</td>
                                        <td>{{ $peserta->Nama }}</td>
                                        <td>{{ $peserta->NIM }}</td>
                                        <td>{{ $peserta->prodi->Nama_Prodi ?? '-' }}</td>
                                        {{-- <td>{{ $peserta->kelas ?? '-' }}</td> --}}
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@push('scripts')
<script>
$(document).ready(function () {
    var table = $('#pesertaTable').DataTable({
        "lengthMenu": [10, 25, 50, 100],
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
        }
    });

    // Filter berdasarkan Program Studi
    $('#filterProdi').on('change', function () {
        var selected = $(this).val();
        if (selected) {
            table.column(8).search('^' + selected + '$', true, false).draw();
        } else {
            table.column(8).search('').draw();
        }
    });
});
</script>

@endpush

@endsection
