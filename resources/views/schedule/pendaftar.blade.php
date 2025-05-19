@extends('layouts.app2')
@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection
@section('content')
<div class="min-h-screen bg-blue-100 py-10 px-4">
    <div class="w-full max-w-7xl mx-auto bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-blue-700 mb-6 text-center">{{ $breadcrumb->title }}</h1>

        @if ($jadwal->sesi->isEmpty())
            <div class="alert alert-warning text-center text-lg">Tidak ada sesi untuk jadwal ini.</div>
        @else
            <div class="mb-6">
                <label for="filterProdi" class="block text-sm font-medium text-gray-700 mb-1">Filter Program Studi:</label>
                <select id="filterProdi" class="form-select w-full max-w-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">- Semua -</option>
                    @foreach ($prodiList as $prodi)
                        <option value="{{ $prodi->Nama_Prodi }}">{{ $prodi->Nama_Prodi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="overflow-auto rounded-lg shadow">
                <table id="pesertaTable" class="table table-bordered table-striped w-full text-sm text-gray-800">
                    <thead class="bg-blue-200 text-blue-900 font-semibold text-md">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Nama Sesi</th>
                            <th class="px-4 py-3 text-left">Waktu</th>
                            <th class="px-4 py-3 text-left">Nama Room</th>
                            <th class="px-4 py-3 text-left">Zoom ID</th>
                            <th class="px-4 py-3 text-left">Password</th>
                            <th class="px-4 py-3 text-left">Nama Peserta</th>
                            <th class="px-4 py-3 text-left">NIM</th>
                            <th class="px-4 py-3 text-left">Program Studi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($jadwal->sesi as $sesi)
                            @foreach ($sesi->rooms as $room)
                                @if ($room->peserta->isEmpty())
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-2">{{ $no++ }}</td>
                                        <td class="px-4 py-2">{{ $sesi->nama_sesi }}</td>
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}</td>
                                        <td class="px-4 py-2">{{ $room->nama_room }}</td>
                                        <td class="px-4 py-2">{{ $room->zoom_id }}</td>
                                        <td class="px-4 py-2">{{ $room->zoom_password }}</td>
                                        <td class="px-4 py-2 text-center text-muted">Belum ada peserta</td>
                                        <td class="px-4 py-2">-</td>
                                        <td class="px-4 py-2">-</td>
                                    </tr>
                                @else
                                    @foreach ($room->peserta as $peserta)
                                        <tr>
                                            <td class="px-4 py-2">{{ $no++ }}</td>
                                            <td class="px-4 py-2">{{ $sesi->nama_sesi }}</td>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}</td>
                                            <td class="px-4 py-2">{{ $room->nama_room }}</td>
                                            <td class="px-4 py-2">{{ $room->zoom_id }}</td>
                                            <td class="px-4 py-2">{{ $room->zoom_password }}</td>
                                            <td class="px-4 py-2">{{ $peserta->Nama }}</td>
                                            <td class="px-4 py-2">{{ $peserta->NIM }}</td>
                                            <td class="px-4 py-2" data-prodi="{{ $peserta->prodi->Nama_Prodi ?? '-' }}">
                                                {{ $peserta->prodi->Nama_Prodi ?? '-' }}
                                            </td>
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
        table.column(8).search(selected).draw();
    });
});
</script>
@endpush

@endsection
