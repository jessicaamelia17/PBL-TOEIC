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

        @if ($jadwalList->isEmpty()) {{-- Asumsikan $jadwal adalah collection --}}
            <div class="alert alert-warning text-center text-lg">Tidak ada jadwal untuk ditampilkan.</div>
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

            <div class="overflow-auto rounded-xl shadow-md">
                <table id="pesertaTable" class="table table-bordered text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Hari / Tanggal</th>
                            <th>Sesi</th>
                            <th>Room</th>
                            <th>Nama Lengkap</th>
                            <th>NIM</th>
                            <th>Program Studi</th>
                            <th>Zoom ID</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($jadwalList as $jadwalItem)
                            @foreach ($jadwalItem->sesi as $sesi)
                                @foreach ($sesi->rooms as $room)
                                    @if ($room->pendaftar->isEmpty())
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($jadwalItem->tanggal_ujian)->translatedFormat('l, d M Y') }}</td>
                                            <td>
                                                {{ $sesi->nama_sesi }}<br>
                                                ({{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }})
                                            </td>
                                            <td>{{ $room->nama_room }}</td>
                                            <td colspan="3" class="text-center">Belum ada peserta</td>
                                            <td>{{ $room->zoom_id }}</td>
                                            <td>{{ $room->zoom_password }}</td>
                                        </tr>
                                    @else
                                        @foreach ($room->pendaftar as $peserta)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ \Carbon\Carbon::parse($jadwalItem->tanggal_ujian)->translatedFormat('l, d M Y') }}</td>
                                                <td>
                                                    {{ $sesi->nama_sesi }}<br>
                                                    ({{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }})
                                                </td>
                                                <td>{{ $room->nama_room }}</td>
                                                <td>{{ $peserta->Nama }}</td>
                                                <td>{{ $peserta->NIM }}</td>
                                                <td>{{ $peserta->prodi->Nama_Prodi ?? '-' }}</td>
                                                <td>{{ $room->zoom_id }}</td>
                                                <td>{{ $room->zoom_password }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
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

    // Filter berdasarkan Program Studi ada di kolom ke-6 (indeks 6 karena 0-based)
    $('#filterProdi').on('change', function () {
        var selected = $(this).val();
        table.column(6).search(selected).draw();
    });
});
</script>
@endpush

@endsection
