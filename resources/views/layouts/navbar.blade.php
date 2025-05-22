<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<script src="//unpkg.com/alpinejs" defer></script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('navbar', () => ({
            open: false,
            openDropdown: false,
            isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            async logout() {
                await fetch('{{ url('/logout') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                this.isLoggedIn = false;
                this.openDropdown = false;
            }
        }));
    });
</script>

<nav x-data="navbar"
    class="fixed w-[95%] z-10 left-1/2 transform -translate-x-1/2 top-2 bg-blue-600 rounded-full shadow-lg relative">
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
            <li><a href="{{ url('/schedule') }}"
                    class="hover:underline {{ request()->is('schedule') ? 'font-bold' : '' }}">Schedule</a></li>
            <li><a href="#" class="hover:underline">Results</a></li>
            <li><a href="#" class="hover:underline">Guide</a></li>
            <li><a href="#" class="hover:underline">Contact</a></li>

            {{-- <li class="relative">
                <button @click="openDropdown = !openDropdown" class="flex items-center space-x-2 focus:outline-none">
                    <template x-if="isLoggedIn">
                        <img src="{{ Auth::user() ? Auth::user()->photo ?? asset('profile-picture.jpg') : asset('profile-picture.jpg') }}"
                            class="w-8 h-8 rounded-full border border-white" alt="User Profile">
                    </template>
                    <template x-if="!isLoggedIn">
                        <img src="{{ asset('profile-picture.jpg') }}" class="w-8 h-8 rounded-full border border-white"
                            alt="Login">
                    </template>
                </button>
                <div x-show="openDropdown" @click.away="openDropdown = false" x-cloak
                    class="absolute right-0 mt-2 w-48 bg-white text-blue-600 rounded-lg shadow-md overflow-hidden text-sm"
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <template x-if="isLoggedIn">
                        <div>
                            {{-- filepath: resources/views/layouts/navbar.blade.php --}}
                            {{-- <a href="{{ Auth::check() ? route('mahasiswa.index', Auth::user()->nim) : '#' }}"
                                class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                            <button @click="logout" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                        </div>
                    </template>
                    <template x-if="!isLoggedIn">
                        <div>
                            <a href="{{ url('/login') }}" class="block px-4 py-2 hover:bg-gray-100">Login</a>
                            <a href="{{ url('/register-user') }}"
                                class="block px-4 py-2 hover:bg-gray-100">Register</a>
                        </div>
                    </template>
                </div>
            </li> --}}
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
            <li><a href="{{ url('/schedule') }}" class="block hover:underline">Schedule</a></li>
            <li><a href="#" class="block hover:underline">Results</a></li>
            <li><a href="#" class="block hover:underline">Guide</a></li>
            <li><a href="#" class="block hover:underline">Contact</a></li>
            {{-- <template x-if="isLoggedIn">
                <div>
                    <li>{{-- filepath: resources/views/layouts/navbar.blade.php --}}
                        {{-- <a href="{{ Auth::check() ? route('mahasiswa.index', Auth::user()->nim) : '#' }}"
                            class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                    </li>
                    <li>
                        <button @click="logout" class="hover:underline w-full text-left">Logout</button>
                    </li>
                </div>
            </template>
            <template x-if="!isLoggedIn">
                <div>
                    <li><a href="{{ url('/login') }}" class="block hover:underline">Login</a></li>
                    <li><a href="{{ url('/register') }}" class="block hover:underline">Register</a></li>
                </div>
            </template> --}}
        </ul>
    </div>
</nav>
