<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>TOEIC - Pengumuman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <nav class="bg-blue-600 text-white py-4 px-6 flex justify-between items-center shadow-lg z-10">
        <div class="flex items-center">
            <img src="{{ asset('polinema.png') }}" alt="Logo" class="h-8 mr-3">
            <span class="text-xl font-bold">TOEIC</span>
        </div>
        <ul class="flex space-x-6 font-medium">
            <li><a href="#" class="hover:underline">Home</a></li>
            <li><a href="#" class="hover:underline">Registration</a></li>
            <li><a href="#" class="hover:underline">Schedule</a></li>
            <li><a href="#" class="hover:underline">Results</a></li>
            <li><a href="#" class="hover:underline">Guide</a></li>
            <li><a href="#" class="hover:underline">Contact</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex justify-center items-center px-4 py-10 bg-white">
        <div class="max-w-4xl w-full">
            <img src="{{ asset('pengumuman.jpg') }}" alt="Pengumuman TOEIC" class="w-full rounded shadow-md border">
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-4 text-center text-sm">
        Copyright © 2025 TOEIC
    </footer>

</body>
</html>
