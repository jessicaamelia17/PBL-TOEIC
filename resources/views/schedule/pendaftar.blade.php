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
        <h1 class="text-3xl font-bold text-blue-700 text-center">{{ $breadcrumb->title }}</h1>
            <p class="text-center text-gray-600 mt-4 text-sm">
                Jadwal: {{ \Carbon\Carbon::parse($jadwal->Tanggal_Ujian)->translatedFormat('l, d F Y') }}
            </p>
            <hr class="my-6 border-t border-gray-300">


        @if ($jadwal->sesi->isEmpty())
            <div class="alert alert-warning text-center text-lg">Tidak ada sesi untuk jadwal ini.</div>
        @else
            <div class="mb-6">
                <label for="filterProdi" class="block text-sm font-medium text-gray-700 mb-1">Filter Program Studi:</label>
                <select id="filterProdi" class="form-select w-full max-w-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">- Semua -</option>
                    @foreach ($prodiList as $prodi)
                    <option value="{{ trim($prodi->Nama_Prodi) }}">{{ trim($prodi->Nama_Prodi) }}</option>
                    @endforeach
                </select>
            </div>

{{-- filepath: resources/views/schedule/pendaftar.blade.php --}}
<div class="overflow-auto rounded-xl shadow-md">
    <table id="pesertaTable" class="min-w-full bg-white rounded-xl overflow-hidden">
        <thead>
            <tr class="bg-blue-200 text-xs text-blue-800 uppercase">
                <th class="px-6 py-2 text-left">No</th>
                <th class="px-6 py-2 text-left">Nama Peserta</th>
                <th class="px-6 py-2 text-left">NIM</th>
                <th class="px-6 py-2 text-left">Program Studi</th>
                <th class="px-6 py-2 text-left">Sesi</th>
                <th class="px-6 py-2 text-left">Room</th>
                <th class="px-6 py-2 text-left">Zoom ID</th>
                <th class="px-6 py-2 text-left">Password</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 divide-y divide-gray-200 text-sm">
            @php $no = 1; @endphp
            @foreach ($jadwal->sesi as $sesi)
                @foreach ($sesi->rooms as $room)
                    @foreach ($room->peserta as $peserta)
                        <tr>
                            <td class="px-6 py-4">{{ $no++ }}</td>
                            <td class="px-6 py-4">{{ optional($peserta->mahasiswa)->nama ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $peserta->NIM }}</td>
                            <td>{{ trim(optional(optional($peserta->mahasiswa)->prodi)->Nama_Prodi ?? '-') }}</td>
                            <td class="px-6 py-4">
                                {{ $sesi->nama_sesi ?? '-' }}<br>
                                <span class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $room->nama_room ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $room->zoom_id }}</td>
                            <td class="px-6 py-4">{{ $room->zoom_password }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</div><!-- Tambahkan penutup div ini -->
@endif
</div>
</div>

@push('js')
<script>
$(document).ready(function () {
var table = $('#pesertaTable').DataTable({
"lengthMenu": [10, 25, 50, 100],
"pageLength": 50,
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
{ "orderable": false, "targets": "_all" },
{ "searchable": false, "targets": 0 },
{ "visible": false, "targets": [] }
],
"rowCallback": function(row, data, index){
if ($(row).hasClass('group')) {
    $(row).addClass('dtr-group');
}
},
"drawCallback": function(settings) {
$('.dtr-group').show();
}
});

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
@endsection