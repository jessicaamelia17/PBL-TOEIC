{{-- filepath: c:\laragon\www\PBL-TOEIC\resources\views\layouts\navbar.blade.php --}}
<nav x-data="{ open: false }" class="fixed top-3 left-4 right-4 z-50 bg-blue-600 rounded-full shadow-lg">
    <div class="flex items-center justify-between px-6 py-3 text-white">
        <!-- Logo -->
        <div class="flex items-center bg-white px-4 py-2 rounded-full">
            <img src="{{ asset('polinema.png') }}" alt="TOEIC Logo" class="h-8 mr-3">
            <h1 class="text-2xl font-bold text-blue-600">PTC</h1>
        </div>

        <!-- Mobile Menu Button -->
        <div class="lg:hidden">
            <button @click="open = !open" class="text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Desktop Menu -->
        <ul class="hidden lg:flex space-x-4 items-center">
            <li>
                <a href="{{ url('/') }}"
                    class="px-3 py-1 rounded transition {{ request()->is('/') ? 'font-bold bg-white/20 text-white' : 'hover:underline' }}">
                    @lang('users.home')
                </a>
            </li>
            <li>
                <a href="{{ url('/mahasiswa/registrasi') }}"
                    class="px-3 py-1 rounded transition {{ request()->is('mahasiswa/registrasi') ? 'font-bold bg-white/20 text-white' : 'hover:underline' }}">
                    @lang('users.toeic_registration_button')
                </a>
            </li>
            <li>
                <a href="{{ route('mahasiswa.schedule.index') }}"
                    class="px-3 py-1 rounded transition {{ request()->routeIs('mahasiswa.schedule.index') ? 'font-bold bg-white/20 text-white' : 'hover:underline' }}">
                    @lang('users.schedule')
                </a>
            </li>
            <li>
                <a href="{{ url('/hasil-ujian') }}"
                    class="px-3 py-1 rounded transition {{ request()->is('hasil-ujian') ? 'font-bold bg-white/20 text-white' : 'hover:underline' }}">
                    @lang('users.result')
                </a>
            </li>
            <li>
                <a href="{{ url('/panduan') }}"
                    class="px-3 py-1 rounded transition {{ request()->is('panduan') ? 'font-bold bg-white/20 text-white' : 'hover:underline' }}">
                    @lang('users.guide')
                </a>
            </li>
            <li>
                <a href="{{ route('contacts') }}"
                    class="px-3 py-1 rounded transition hover:underline">@lang('users.contacts')</a>
            </li>


            {{-- Language Switcher --}}
            <li class="relative" x-data="{ openLang: false }" x-init="openLang = false">
                <button @click="openLang = !openLang"
                    class="flex items-center gap-2 px-3 py-1 rounded transition bg-white/20 text-white hover:bg-white/30">
                    <i class="fas fa-globe w-5 h-3"></i>
                    @if (app()->getLocale() == 'id')
                        <img src="https://flagcdn.com/w20/id.png" alt="ID" class="w-5 h-5 rounded-full">
                    @else
                        <img src="https://flagcdn.com/w20/gb.png" alt="EN" class="w-5 h-5 rounded-full">
                    @endif
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="openLang" @click.away="openLang = false" x-cloak
                    class="absolute right-0 mt-2 w-36 bg-white text-blue-700 rounded shadow-lg z-50 py-1">
                    <li>
                        <a href="{{ route('locale', 'id') }}"
                            class="flex items-center gap-2 px-4 py-2 hover:bg-blue-50 transition {{ app()->getLocale() == 'id' ? 'font-bold bg-blue-50' : '' }}">
                            <img src="https://flagcdn.com/w20/id.png" alt="ID" class="w-5 h-5 rounded-full">
                            <span>Indonesia</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('locale', 'en') }}"
                            class="flex items-center gap-2 px-4 py-2 hover:bg-blue-50 transition {{ app()->getLocale() == 'en' ? 'font-bold bg-blue-50' : '' }}">
                            <img src="https://flagcdn.com/w20/gb.png" alt="EN" class="w-5 h-5 rounded-full">
                            <span>English</span>
                        </a>
                    </li>
                </ul>
            </li>

            @if (Auth::check())
                <li class="relative" x-data="{ openDropdown: false }" @click.away="openDropdown = false">
                    <button @click="openDropdown = !openDropdown" class="focus:outline-none">
                        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('profile-picture.jpg') }}"
                            alt="Profile" class="w-8 h-8 rounded-full border border-white">
                    </button>
                    <div x-show="openDropdown" x-transition
                        class="absolute right-0 mt-2 w-40 bg-white text-blue-600 rounded-lg shadow-md text-sm z-30"
                        style="display:none">
                        <a href="{{ route('mahasiswa.profile', Auth::user()->nim) }}"
                            class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 rounded-t-lg">
                            <i class="fas fa-user w-5 h-3"></i>
                            <span>@lang('users.profile')</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 w-full px-4 py-2 hover:bg-blue-50 rounded-b-lg text-left">
                                <i class="fas fa-sign-out-alt w-5 h-3"></i>
                                <span>@lang('users.logout')</span>
                            </button>
                        </form>
                    </div>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}"
                        class="hover:underline {{ request()->is('login') ? 'font-bold' : '' }}">
                        @lang('users.login')
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" @click.away="open = false" x-cloak
        class="lg:hidden absolute top-full left-0 right-0 bg-white rounded-2xl shadow-lg py-4 z-20 border-t border-blue-100"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
        <ul class="space-y-1 px-2">
            <li>
                <a href="{{ url('/') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-50 text-blue-700 font-medium transition text-left">
                    <i class="fas fa-home w-5 h-5"></i> @lang('users.home')
                </a>
            </li>
            <li>
                <a href="{{ url('/mahasiswa/registrasi') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-50 text-blue-700 font-medium transition text-left">
                    <i class="fas fa-user-plus w-5 h-5"></i> @lang('users.toeic_registration_button')
                </a>
            </li>
            <li>
                <a href="{{ route('mahasiswa.schedule.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-50 text-blue-700 font-medium transition text-left">
                    <i class="fas fa-calendar-alt w-5 h-5"></i> @lang('users.schedule')
                </a>
            </li>
            <li>
                <a href="{{ url('/hasil-ujian') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-50 text-blue-700 font-medium transition text-left">
                    <i class="fas fa-clipboard-check w-5 h-5"></i> @lang('users.result')
                </a>
            </li>
            <li>
                <a href="{{ url('/panduan') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-50 text-blue-700 font-medium transition text-left">
                    <i class="fas fa-book w-5 h-5"></i> @lang('users.guide')
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-50 text-blue-700 font-medium transition text-left">
                    <i class="fas fa-envelope w-5 h-5"></i> @lang('users.contacts')
                </a>
            </li>
            {{-- Language Switcher Mobile --}}
            <li class="relative" x-data="{ openLang: false }" x-init="openLang = false">
                <button @click="openLang = !openLang"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-50 text-blue-700 font-medium transition w-full text-left">
                    <i class="fas fa-globe w-5 h-5"></i>
                    @if (app()->getLocale() == 'id')
                        <img src="https://flagcdn.com/w20/id.png" alt="ID" class="inline w-5 h-5 rounded-full">
                    @else
                        <img src="https://flagcdn.com/w20/gb.png" alt="EN" class="inline w-5 h-5 rounded-full">
                    @endif
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="openLang" @click.away="openLang = false" x-cloak
                    class="mt-2 bg-white text-blue-700 rounded shadow-lg z-50 border border-blue-100">
                    <li>
                        <a href="{{ route('locale', 'id') }}"
                            class="flex items-center gap-2 px-4 py-2 hover:bg-blue-50 transition {{ app()->getLocale() == 'id' ? 'font-bold bg-blue-50' : '' }}">
                            <img src="https://flagcdn.com/w20/id.png" alt="ID" class="w-5 h-5 rounded-full">
                            <span>Indonesia</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('locale', 'en') }}"
                            class="flex items-center gap-2 px-4 py-2 hover:bg-blue-50 transition {{ app()->getLocale() == 'en' ? 'font-bold bg-blue-50' : '' }}">
                            <img src="https://flagcdn.com/w20/gb.png" alt="EN" class="w-5 h-5 rounded-full">
                            <span>English</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <hr class="my-2 border-blue-100">
            </li>
            @if (Auth::check())
                <li class="relative" x-data="{ openDropdown: false }" @click.away="openDropdown = false">
                    <button @click="openDropdown = !openDropdown"
                        class="flex items-center gap-3 w-full px-4 py-2 rounded-lg hover:bg-blue-50 text-blue-700 font-medium transition text-left">
                        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('profile-picture.jpg') }}"
                            alt="Profile" class="w-8 h-8 rounded-full border border-blue-200">
                        <span>@lang('users.profile')</span>
                        <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openDropdown" x-cloak
                        class="mt-2 bg-white rounded-lg shadow-md text-blue-700 text-sm z-30 border border-blue-100"
                        x-transition>
                        <a href="{{ route('mahasiswa.profile', Auth::user()->nim) }}"
                            class="block px-4 py-2 hover:bg-blue-50 rounded-t-lg">@lang('users.profile')</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 hover:bg-blue-50 rounded-b-lg">@lang('users.logout')</button>
                        </form>
                    </div>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-50 text-blue-700 font-medium transition text-left">
                        <i class="fas fa-sign-in-alt w-5 h-5"></i> @lang('users.login')
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
