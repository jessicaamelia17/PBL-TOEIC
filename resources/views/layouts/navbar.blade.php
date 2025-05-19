<script src="//unpkg.com/alpinejs" defer></script>
<nav x-data="{ open: false }"
    class="fixed w-[95%] z-10 left-1/2 transform -translate-x-1/2 top-2 bg-blue-600 rounded-full shadow-lg relative">
    <div class="flex items-center justify-between px-6 py-3 text-white">
        <!-- Logo -->
        <div class="flex items-center bg-white px-4 py-2 rounded-full">
            <img src="{{ asset('polinema.png') }}" alt="TOEIC Logo" class="h-8 mr-3">
            <h1 class="text-2xl font-bold text-blue-600">TOEIC</h1>
        </div>
        <!-- Desktop Menu -->
        <ul class="hidden md:flex space-x-6 items-center">
            <li>
                <a href="{{ url('/') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ url('/registrasi') }}"
                    class="hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Registration
                </a>
            </li>
            <li>
                <a href="{{ url('/schedule') }}"
                    class="hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Schedule
                </a>
            </li>
            <li>
                <a href="#" class="hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Results
                </a>
            </li>
            <li>
                <a href="#" class="hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Guide
                </a>
            </li>
            <li>
                <a href="#" class="hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Contact
                </a>
            </li>
        </ul>
        <!-- Mobile Toggle Button -->
        <button @click="open = !open" @keydown.escape.window="open = false" :aria-expanded="open"
            class="md:hidden text-white focus:outline-none focus:ring-2 focus:ring-white" aria-label="Toggle menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu: kini teks akan tampil putih karena kelas text-white -->
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="absolute top-full left-0 right-0 mt-2 bg-blue-500 rounded-xl shadow-md p-4 z-20 text-white " x-cloak>
        <ul class="space-y-3 text-center">
            <li>
                <a href="{{ url('/') }}"
                    class="block hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ url('/registrasi') }}"
                    class="block hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Registration
                </a>
            </li>
            <li>
                <a href="{{ url('/schedule') }}"
                    class="block hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Schedule
                </a>
            </li>
            <li>
                <a href="#" class="block hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Results
                </a>
            </li>
            <li>
                <a href="#" class="block hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Guide
                </a>
            </li>
            <li>
                <a href="#" class="block hover:underline focus:outline-none focus:ring-2 focus:ring-white">
                    Contact
                </a>
            </li>
        </ul>
    </div>
</nav>
