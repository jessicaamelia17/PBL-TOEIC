<nav class="bg-blue-600 text-white py-4 px-6 flex justify-between items-center fixed w-[95%] shadow-lg z-10 rounded-full left-1/2 transform -translate-x-1/2 top-2">
    <div class="flex items-center bg-white px-4 py-2 rounded-full">
        <img src="{{ asset('polinema.png') }}" alt="TOEIC Logo" class="h-8 mr-3">
        <h1 class="text-2xl font-bold text-blue-600">TOEIC</h1>
    </div>
    <ul class="flex space-x-6">
        <li><a href="#" class="hover:underline">Home</a></li>
        <li><a href="{{ url('/registrasi') }}" class="hover:underline">Registration</a></li>
        <li><a href="#" class="hover:underline">Schedule</a></li>
        <li><a href="#" class="hover:underline">Results</a></li>
        <li><a href="#" class="hover:underline">Guide</a></li>
        <li><a href="#" class="hover:underline">Contact</a></li>
    </ul>
</nav>
