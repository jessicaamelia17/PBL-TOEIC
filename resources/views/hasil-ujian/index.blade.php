@extends('layouts.app2')
@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection
@section('content')
<div class="max-w-7xl mx-auto mt-32 bg-white p-8 rounded shadow-md animate-fadeIn">
    <h2 class="text-4xl font-bold mb-6 text-blue-800 text-center">@lang('users.toeic_score')</h2>

    {{-- Tombol Aksi atas --}}
    <div class="flex justify-end mb-4 space-x-2">
        <a href="{{ route('hasil-ujian.pdf.viewAll') }}" target="_blank"
           class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
            <i class="fas fa-file-pdf mr-1"></i> @lang('users.view_pdf')
        </a>
        <a href="{{ route('hasil-ujian.pdf.downloadAll') }}"
           class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded">
            <i class="fas fa-download mr-1"></i> @lang('users.download_all_result')
        </a>
    </div>

    {{-- Tabel Hasil Ujian --}}
    <div class="overflow-x-auto mt-4">
        <table id="resultTable" class="min-w-full text-sm text-gray-700 border border-gray-300">
            <thead class="bg-blue-100 text-gray-800 font-semibold">
                <tr>
                    <th class="px-4 py-2">@lang('users.name')</th>
                    <th class="px-4 py-2">NIM</th>
                    <th class="px-4 py-2">Listening 1</th>
                    <th class="px-4 py-2">Reading 1</th>
                    <th class="px-4 py-2">@lang('users.score') 1</th>
                    <th class="px-4 py-2">Listening 2</th>
                    <th class="px-4 py-2">Reading 2</th>
                    <th class="px-4 py-2">@lang('users.score') 2</th>
                    <th class="px-4 py-2">@lang('users.exam_date')</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">@lang('users.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $r)
                    <tr class="hover:bg-blue-50">
                        <td class="px-4 py-2">{{ optional($r->pendaftaran->mahasiswa)->nama ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $r->pendaftaran->nim }}</td>
                        <td class="px-4 py-2">{{ $r->listening_1 }}</td>
                        <td class="px-4 py-2">{{ $r->reading_1 }}</td>
                        <td class="px-4 py-2">{{ $r->total_skor_1 }}</td>
                        <td class="px-4 py-2">{{ $r->Listening_2 }}</td>
                        <td class="px-4 py-2">{{ $r->Reading_2 }}</td>
                        <td class="px-4 py-2">{{ $r->total_skor_2 }}</td>
                        <td class="px-4 py-2">
                            {{ optional($r->pendaftaran->jadwal)->Tanggal_Ujian ? \Carbon\Carbon::parse($r->jadwal->Tanggal_Ujian)->translatedFormat('d-m-Y') : '-' }}
                        </td>
                        <td class="px-4 py-2">{{ $r->Status }}</td>
                        <td class="px-4 py-2 space-y-1">
                            <a href="{{ route('hasil-ujian.pdf.view', $r->Id_Hasil) }}" target="_blank"
                               class="block bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 text-xs rounded text-center">
                                <i class="fas fa-eye mr-1"></i> @lang('users.view')
                            </a>
                            <a href="{{ route('hasil-ujian.pdf.download', $r->Id_Hasil) }}"
                               class="block bg-green-600 hover:bg-green-700 text-white px-3 py-1 text-xs rounded text-center mt-1">
                                <i class="fas fa-download mr-1"></i> @lang('users.download')
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('css')
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#resultTable').DataTable({
                language: {
                    search: "{{__('users.search')}}:",
                    lengthMenu: "{{__('users.lenght_menu')}}",
                    info: "@lang('users.info')",
                    paginate: {
                        previous: "{{__('users.prev')}}",
                        next: "{{__('users.next')}}"
                    }
                },
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 100],
                responsive: true
            });
        });
    </script>
@endpush