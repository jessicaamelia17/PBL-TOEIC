<nav x-data="{ open: false }" class="fixed top-3 left-4 right-4 z-50 bg-blue-600 rounded-full shadow-lg">
    <div class="flex items-center justify-between px-6 py-3 text-white">
        <!-- Logo -->
        <div class="flex items-center bg-white px-4 py-2 rounded-full">
            <img src="{{ asset('polinema.png') }}" alt="TOEIC Logo" class="h-8 mr-3">
            <h1 class="text-2xl font-bold text-blue-600">TOEIC</h1>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
            <button @click="open = !open" class="text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex space-x-6 items-center">
            <li><a href="{{ url('/') }}"
                    class="hover:underline {{ request()->is('/') ? 'font-bold' : '' }}">Home</a></li>
            <li><a href="{{ route('mahasiswa.schedule.index') }}"
                    class="hover:underline {{ request()->is('schedule') ? 'font-bold' : '' }}">Schedule</a></li>
            <li><a href="{{ url('/hasil-ujian') }}"
                    class="hover:underline {{ request()->is('/hasil-ujian') ? 'font-bold' : '' }}">Results</a></li>
            <li><a href="#" class="hover:underline">Guide</a></li>
            <li><a href="#" class="hover:underline">Contact</a></li>

            @if (Auth::check())
                <li class="relative" x-data="{ openDropdown: false }" @click.away="openDropdown = false">
                    <button @click="openDropdown = !openDropdown" class="focus:outline-none">
                        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('profile-picture.jpg') }}"
                            alt="Profile" class="w-8 h-8 rounded-full border border-white">
                    </button>
                    <div x-show="openDropdown" x-cloak
                        class="absolute right-0 mt-2 w-40 bg-white text-blue-600 rounded-lg shadow-md text-sm z-30"
                        x-transition>
                        <a href="{{ route('mahasiswa.profile', Auth::user()->nim) }}"
                            class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('mahasiswa.logout-toeic') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </li>
            @else
                <li>
                    <a href="{{ route('login-toeic') }}"
                        class="hover:underline {{ request()->is('login-toeic') ? 'font-bold' : '' }}">
                        Login
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" @click.away="open = false" x-cloak
        class="md:hidden absolute top-full left-0 right-0 bg-blue-600 rounded-b-lg shadow-md py-2 z-20"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
        <ul class="space-y-2 px-6 py-3">
            <li><a href="{{ url('/') }}" class="block hover:underline">Home</a></li>
            <li><a href="{{ route('mahasiswa.schedule.index') }}" class="block hover:underline">Schedule</a></li>
            <li><a href="#" class="block hover:underline">Results</a></li>
            <li><a href="#" class="block hover:underline">Guide</a></li>
            <li><a href="#" class="block hover:underline">Contact</a></li>

            @if (Auth::check())
                <li class="relative" x-data="{ openDropdown: false }" @click.away="openDropdown = false">
                    <button @click="openDropdown = !openDropdown"
                        class="flex items-center space-x-2 focus:outline-none w-full">
                        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('profile-picture.jpg') }}"
                            alt="Profile" class="w-8 h-8 rounded-full border border-white">
                        <span class="ml-2">Profile</span>
                    </button>
                    <div x-show="openDropdown" x-cloak
                        class="absolute right-0 mt-2 w-40 bg-white text-blue-600 rounded-lg shadow-md text-sm z-30"
                        x-transition>
                        <a href="{{ route('mahasiswa.profile', Auth::user()->nim) }}"
                            class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('mahasiswa.logout-toeic') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </li>
            @else
                <li>
                    <a href="{{ route('login-toeic') }}" class="block hover:underline">Login</a>
                </li>
            @endif
        </ul>
    </div>
</nav>
