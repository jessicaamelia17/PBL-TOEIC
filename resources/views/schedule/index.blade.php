@extends('layouts.app2')

@section('content')
<div class="max-w-5xl mx-auto mt-32 bg-white p-8 rounded shadow-md animate-fadeIn">
    <h2 class="text-xl font-bold mb-4 text-blue-800">Jadwal Ujian TOEIC</h2>

    <div class="overflow-x-auto mt-4">
        <table id="scheduleTable" class="min-w-full text-center border border-gray-300">
            <thead class="bg-blue-100 font-semibold">
                <tr>
                    <th>Day</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($schedule as $s)
                    <tr>
                        <td>{{ $s['day'] }}</td>
                        <td>{{ $s['date'] }}</td>
                        <td>10.00 - 12.00</td>
                        <td>Rt. 5 Lt. 5 Civil Engineering Building</td>
                        <td><a href="#" class="text-blue-600 hover:underline">Click Here</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('css')
    {{-- DataTables CSS --}}
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
@endpush

@push('js')
    {{-- jQuery + DataTables JS --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#scheduleTable').DataTable({
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
