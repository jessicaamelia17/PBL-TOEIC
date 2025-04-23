<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOEIC Service Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        fadeIn: "fadeIn 1s ease-in-out",
                        grow: "grow 0.3s ease-in-out",
                        slideUp: "slideUp 0.5s ease-in-out"
                    },
                    keyframes: {
                        fadeIn: {
                            "0%": { opacity: "0" },
                            "100%": { opacity: "1" }
                        },
                        grow: {
                            "0%": { transform: "scale(1)" },
                            "100%": { transform: "scale(1.05)" }
                        },
                        slideUp: {
                            "0%": { transform: "translateY(50px)", opacity: "0" },
                            "100%": { transform: "translateY(0)", opacity: "1" }
                        }
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-blue-100">
    <!-- Header Navigation -->
    <nav class="bg-blue-600 text-white py-4 px-6 flex justify-between items-center fixed w-[95%] shadow-lg z-10 rounded-full left-1/2 transform -translate-x-1/2 top-2">
        <div class="flex items-center bg-white px-4 py-2 rounded-full">
            <img src="toeic.jpg" alt="TOEIC Logo" class="h-8 mr-3">
            <h1 class="text-2xl font-bold text-blue-600">TOEIC</h1>
        </div>
        <ul class="flex space-x-6">
            <li><a href="#" class="hover:underline">Home</a></li>
            <li><a href="#" class="hover:underline">Registrasion</a></li>
            <li><a href="#" class="hover:underline">Schedule</a></li>
            <li><a href="#" class="hover:underline">results</a></li>
            <li><a href="#" class="hover:underline">Guide</a></li>
            <li><a href="#" class="hover:underline">Contact</a></li>
        </ul>
    </nav>
    
    <!-- Hero -->
    <section class="pt-28 text-center px-4">
        <h2 class="text-4xl font-bold text-blue-900">TOEIC Service</h2>
        <h3 class="text-2xl font-bold text-blue-800 mt-2">POLITEKNIK NEGERI MALANG</h3>
        <p class="mt-4 text-gray-700">Get complete information about TOEIC registration, schedule and exam results.</p>
        <img src="https://jti.polinema.ac.id/wp-content/uploads/2021/07/Banner-002.jpg" class="w-full max-w-3xl mx-auto my-6 rounded-lg shadow-lg" alt="TOEIC Banner">
        <a href="#" class="bg-yellow-400 hover:bg-yellow-500 text-blue-900 font-bold py-2 px-6 rounded shadow-md transition">Register now</a>
    </section>

    <!-- Announcement -->
    <section class="container mx-auto py-12 px-6">
        <h2 class="text-3xl font-bold text-center text-blue-900 mb-6">Announcement</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <ul class="list-disc list-inside text-gray-700">
                <li class="mb-2">TOEIC registration for April is now open! <a href="#" class="text-blue-600 hover:underline">See more</a></li>
                <li class="mb-2">TOEIC Test Schedule Announcement. <a href="#" class="text-blue-600 hover:underline">Check now</a></li>
                <li class="mb-2">The latest guide to TOEIC preparation is now available. <a href="#" class="text-blue-600 hover:underline">Read the guide</a></li>
            </ul>
        </div>
    </section>
    <!-- Informasi & Fitur -->
    <section class="container mx-auto py-12 px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md text-center transition transform hover:scale-105 animate-slideUp">
            <h3 class="text-lg font-bold">TOEIC Registration</h3>
            <p class="mt-2 text-gray-600">Fill out the registration form with valid information.</p>
            <a href="#" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center transition transform hover:scale-105 animate-slideUp">
            <h3 class="text-lg font-bold">Exam Schedule</h3>
            <p class="mt-2 text-gray-600">View the latest TOEIC exam schedule.</p>
            <a href="#" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">See Schedule</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center transition transform hover:scale-105 animate-slideUp">
            <h3 class="text-lg font-bold">check exam results</h3>
            <p class="mt-2 text-gray-600">Check your TOEIC results online.</p>
            <a href="#" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">See Results</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center transition transform hover:scale-105 animate-slideUp">
            <h3 class="text-lg font-bold">Complete Guide</h3>
            <p class="mt-2 text-gray-600">Learn the complete TOEIC guide.</p>
            <a href="#" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Read the Guide</a>
        </div>
    </section>
    

    
    <!-- Footer -->
    <footer class="bg-blue-600 text-white text-center py-6 mt-12 rounded-t-lg">
        <p>&copy; 2025 TOEIC - Politeknik Negeri Malang</p>
    </footer>
</body>
</html>