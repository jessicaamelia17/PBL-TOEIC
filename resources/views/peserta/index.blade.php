<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta TOEIC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
</head>
<body class="bg-blue-100 min-h-screen flex flex-col">

    <!-- Header Navigation -->
    <nav class="bg-blue-600 text-white py-4 px-6 flex justify-between items-center fixed w-[95%] shadow-lg z-10 rounded-full left-1/2 transform -translate-x-1/2 top-2">
        <div class="flex items-center bg-white px-4 py-2 rounded-full">
            <img src="{{ asset('polinema.png') }}" alt="TOEIC Logo" class="h-8 mr-3" />
            <h1 class="text-2xl font-bold text-blue-600">TOEIC</h1>
        </div>
        <ul class="flex space-x-6 text-sm font-medium">
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
        <div class="max-w-6xl mx-auto mt-32 bg-white p-8 rounded shadow-md">
            <!-- Info Session -->
            <div class="bg-cyan-200 text-black font-semibold px-4 py-2 rounded">
                DAY 1 - SATURDAY, 17 JULY 2025<br>
                SESSION 1: 08.30 - 12.30
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto mt-6">
                <table id="participantsTable" class="display min-w-full text-center border border-gray-300 bg-white">
                    <thead class="bg-blue-100 font-semibold">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>NIM</th>
                            <th>Program Studi</th>
                            <th>Kelas</th>
                            <th>Zoom ID</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @php
                            $peserta = [
                                ['nama' => 'Deva Selviana', 'nim' => '2341760060'],
                                ['nama' => 'Fachry Akbar Bagaskara', 'nim' => '2341760133'],
                                ['nama' => 'Jessica Amelia', 'nim' => '2341760185'],
                                ['nama' => 'Nervalina Adzra Nora Aqilla', 'nim' => '2341760066'],
                                ['nama' => 'Veren Regina Tirsya', 'nim' => '2341760127'],
                            ];
                        @endphp

                        @foreach ($peserta as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p['nama'] }}</td>
                            <td>{{ $p['nim'] }}</td>
                            <td>D-IV Sistem Informasi Bisnis</td>
                            <td>2 F</td>
                            <td>943 7556 1584</td>
                            <td>TOEIC2025</td>
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

    <!-- jQuery dan DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#participantsTable').DataTable({
          language: {
            search: "Search:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            paginate: {
              previous: "Previous",
              next: "Next"
            }
          },
          pageLength: 5,
          lengthMenu: [5, 25, 50, 100, 500]
        });
      });
    </script>
</body>
</html>