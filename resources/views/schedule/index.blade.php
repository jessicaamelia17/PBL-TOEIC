<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal TOEIC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- DataTables CSS --}}
    <link 
        href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" 
        rel="stylesheet"
    />
</head>
<body class="bg-white min-h-screen flex flex-col">

    <!-- Navigasi -->
    <nav class="bg-blue-600 text-white py-4 px-6 flex justify-between items-center fixed w-[95%] shadow-lg z-10 rounded-full left-1/2 transform -translate-x-1/2 top-2">
        <div class="flex items-center bg-white px-4 py-2 rounded-full">
            <img src="{{ asset('polinema.png') }}" alt="TOEIC Logo" class="h-8 mr-3" />
            <h1 class="text-2xl font-bold text-blue-600">TOEIC</h1>
        </div>
        <ul class="flex space-x-6">
            <li><a href="#" class="hover:underline">Home</a></li>
            <li><a href="#" class="hover:underline">Registration</a></li>
            <li><a href="#" class="hover:underline">Schedule</a></li>
            <li><a href="#" class="hover:underline">Results</a></li>
            <li><a href="#" class="hover:underline">Guide</a></li>
            <li><a href="#" class="hover:underline">Contact</a></li>
        </ul>
    </nav>

    <!-- Konten -->
    <main class="flex-grow">
        <div class="max-w-5xl mx-auto mt-32 bg-white p-8 rounded shadow-md">
            <h2 class="text-xl font-bold mb-4 text-blue-800">Jadwal Ujian TOEIC</h2>

            <div class="overflow-x-auto mt-4">
                <table 
                    id="scheduleTable" 
                    class="min-w-full text-center border border-gray-300"
                >
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
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white mt-12 rounded-t-lg">
        <div class="text-center py-4 text-sm">
            Copyright © 2025 TOEIC
        </div>
    </footer>

    {{-- jQuery + DataTables JS --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script 
        src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"
    ></script>
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
</body>
</html>
