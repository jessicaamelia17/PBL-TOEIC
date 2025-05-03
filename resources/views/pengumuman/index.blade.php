<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>TOEIC - Pengumuman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100 min-h-screen flex flex-col">

    <!-- Header Navigation -->
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

    <!-- Spacer agar isi tidak tertutup navbar -->
    <div class="h-24"></div>

    <!-- Main Content -->
    <main class="flex-grow px-4 py-10">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold text-center mb-6 text-gray-800"></h2>
            <div class="rounded-lg overflow-hidden">
                <img src="{{ asset('pengumuman.jpg') }}" alt="Pengumuman TOEIC" class="w-full object-contain">
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-4 text-center text-sm">
        Copyright © 2025 TOEIC
    </footer>

</body>
</html>