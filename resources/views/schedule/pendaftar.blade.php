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
                        <option value="{{ $prodi->Nama_Prodi }}">{{ $prodi->Nama_Prodi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="overflow-auto rounded-xl shadow-md">
                <table id="pesertaTable" class="min-w-full bg-white rounded-xl overflow-hidden">
                    <thead>
                        <tr class="bg-blue-200 text-xs text-blue-800 uppercase">
                            <th class="px-6 py-2 text-left">No</th>
                            <th class="px-6 py-2 text-left">Nama Peserta</th>
                            <th class="px-6 py-2 text-left">NIM</th>
                            <th class="px-6 py-2 text-left">Program Studi</th>
                            <th class="px-6 py-2 text-left">Zoom ID</th>
                            <th class="px-6 py-2 text-left">Password</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y divide-gray-200 text-sm">
                        @php $no = 1; @endphp
                        @foreach ($jadwal->sesi as $sesi)
                            {{-- Baris Judul Sesi --}}
                            <tr class="bg-blue-100 font-semibold text-blue-700">
                                <td colspan="6" class="px-6 py-3">
                                    {{ $sesi->nama_sesi }} ({{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }})
                                </td>
                            </tr>
            
                            @foreach ($sesi->rooms as $room)
                                {{-- Baris Nama Room --}}
                                <tr class="bg-gray-100 font-semibold text-sm text-gray-800">
                                    <td colspan="6" class="px-6 py-3">
                                        {{ $room->nama_room }}
                                    </td>
                                </tr>
                                
            
                                @if ($room->peserta->isEmpty())
                                    {{-- Tidak ada peserta --}}
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center italic text-gray-500">Belum ada peserta</td>
                                    </tr>
                                @else
                                    @foreach ($room->peserta as $peserta)
                                        <tr>
                                            <td class="px-6 py-4">{{ $no++ }}</td>
                                            <td class="px-6 py-4">{{ optional($peserta->mahasiswa)->nama ?? '-' }}</td>
                                            <td class="px-6 py-4">{{ $peserta->NIM }}</td>
                                            <td class="px-6 py-4">{{ optional(optional($peserta->mahasiswa)->prodi)->Nama_Prodi ?? '-' }}</td>
                                            <td class="px-6 py-4">{{ $room->zoom_id }}</td>
                                            <td class="px-6 py-4">{{ $room->zoom_password }}</td>
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
    
        // Kolom ke-3 (index 3) adalah Program Studi
        $('#filterProdi').on('change', function () {
            var selected = $(this).val();
            table.column(3).search(selected).draw(); // index 3 = kolom Program Studi
        });
    });
    </script>
    
@endpush

@endsection
