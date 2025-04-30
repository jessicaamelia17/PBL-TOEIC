<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - TOEIC</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white min-h-screen p-5">
            <div class="flex items-center mb-8">
                <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 mr-2">
                <h1 class="text-xl font-bold">TOEIC</h1>
            </div>
            <ul class="space-y-4">
                <li><a href="#" class="block py-2 hover:bg-blue-700 rounded px-2">Dashboard</a></li>
                <li><a href="#" class="block py-2 hover:bg-blue-700 rounded px-2">Data Pendaftaran</a></li>
                <li><a href="#" class="block py-2 hover:bg-blue-700 rounded px-2">Jadwal</a></li>
            </ul>
        </div>

        <!-- Content -->
        <div class="flex-1 p-6">
            <!-- Tombol Logout -->
            <div class="flex justify-end mb-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Logout
                    </button>
                </form>
            </div>

            <h2 class="text-2xl font-bold mb-4">TOEIC</h2>
            <div class="grid grid-cols-3 gap-6 mb-6">
                <div class="bg-purple-100 p-4 text-center rounded">
                    <h3 class="text-xl font-semibold text-purple-700">Total Jadwal</h3>
                    <p class="text-3xl font-bold">5</p>
                </div>
                <div class="bg-blue-100 p-4 text-center rounded">
                    <h3 class="text-xl font-semibold text-blue-700">Jadwal Mendatang</h3>
                    <p class="text-3xl font-bold">2</p>
                </div>
                <div class="bg-yellow-100 p-4 text-center rounded">
                    <h3 class="text-xl font-semibold text-yellow-700">Peserta Lulus</h3>
                    <p class="text-3xl font-bold">65</p>
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-2">Test Schedule</h3>
            <table class="w-full table-auto bg-white shadow-md rounded mb-6">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Hari</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Jam</th>
                        <th class="px-4 py-2">Lokasi</th>
                        <th class="px-4 py-2">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td class="border px-4 py-2">Senin</td>
                        <td class="border px-4 py-2">24/11/2025</td>
                        <td class="border px-4 py-2">10.00 - 12.00</td>
                        <td class="border px-4 py-2">Lt. 5 Gedung Teknik Sipil</td>
                        <td class="border px-4 py-2 text-blue-600 underline"><a href="#">Disini</a></td>
                    </tr>
                    <!-- Tambah baris lainnya -->
                </tbody>
            </table>

            <h3 class="text-lg font-semibold mb-2">Daftar Peserta</h3>
            <table class="w-full table-auto bg-white shadow-md rounded">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-2">Nama Lengkap</th>
                        <th class="px-4 py-2">NIM</th>
                        <th class="px-4 py-2">Program Studi</th>
                        <th class="px-4 py-2">Kelas</th>
                        <th class="px-4 py-2">Zoom</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td class="border px-4 py-2">Ahmad</td>
                        <td class="border px-4 py-2">23417</td>
                        <td class="border px-4 py-2">D-IV SIB</td>
                        <td class="border px-4 py-2">2F</td>
                        <td class="border px-4 py-2 text-blue-600 underline"><a href="#">973 123</a></td>
                    </tr>
                    <!-- Tambah peserta lain -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
