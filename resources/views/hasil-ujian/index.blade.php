@extends('layouts.app2')

@section('content')
<div class="max-w-5xl mx-auto mt-32 bg-white p-8 rounded shadow-md animate-fadeIn">
    <h2 class="text-4xl font-bold mb-6 text-blue-800 text-center">Hasil Ujian TOEIC</h2>

    <div class="overflow-x-auto mt-4">
        <table id="resultTable" class="min-w-full text-sm text-gray-700 border border-gray-300">
            <thead class="bg-blue-100 text-gray-800 font-semibold">
                <tr>
                    <th class="px-4 py-2">Nama Peserta</th>
                    <th class="px-4 py-2">NIM</th>
                    <th class="px-4 py-2">Skor</th>
                    <th class="px-4 py-2">Tanggal Ujian</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $r)
                    <tr class="hover:bg-blue-50">
                        <td class="px-4 py-2">{{ $r['name'] }}</td>
                        <td class="px-4 py-2">{{ $r['nim'] }}</td>
                        <td class="px-4 py-2">{{ $r['listening'] + $r['reading'] }}</td>
                        <td class="px-4 py-2">{{ $r['tanggal_ujian'] }}</td>
                        <td class="px-4 py-2">{{ $r['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('css')
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#resultTable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                },
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 100],
                responsive: true
            });
        });
    </script>
@endpush