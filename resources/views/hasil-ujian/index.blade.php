@extends('layouts.app2')

@section('content')
<div class="max-w-5xl mx-auto mt-32 bg-white p-8 rounded shadow-md animate-fadeIn">
    <h2 class="text-4xl font-bold mb-6 text-blue-800 text-center">Hasil Ujian TOEIC</h2>

    <div class="overflow-x-auto mt-4">
        <table id="resultTable" class="min-w-full text-left border border-gray-300">
            <thead class="bg-blue-100 font-semibold">
                <tr>
                    <th>Nama Peserta</th>
                    <th>NIM</th>
                    <th>Skor</th>
                    <th>Tanggal Ujian</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($results as $r)
                    <tr>
                        <td>{{ $r['name'] }}</td>
                        <td>{{ $r['nim'] }}</td>
                        <td>{{ $r['listening'] + $r['reading'] }}</td>
                        <td>{{ $r['tanggal_ujian'] }}</td>
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
                lengthMenu: [5, 10, 25, 50, 100]
            });
        });
    </script>
@endpush