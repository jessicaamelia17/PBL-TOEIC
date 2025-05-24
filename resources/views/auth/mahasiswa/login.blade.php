@extends('layouts.app2')

@section('title', 'Login TOEIC Mahasiswa')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-blue-100">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md animate-fadeIn">
            <img src="{{ asset('polinema.png') }}" alt="Polinema Logo" class="mx-auto mb-4 w-20 h-auto">
            <h3 class="mb-6 text-2xl font-bold text-blue-700 text-center tracking-wide">Login TOEIC</h3>

            {{-- Error Message --}}
            @if ($errors->any())
                <div id="login-error" class="mb-4 text-red-600 text-center font-semibold">
                    {{ __('The NIM or password you entered is incorrect.') }}
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login-toeic') }}" autocomplete="off">
                @csrf
                <div class="mb-5 text-left">
                    <label for="nim" class="block font-semibold text-gray-700 mb-1">NIM</label>
                    <input type="text" id="nim" name="nim"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Input NIM" required>
                </div>
                <div class="mb-5 text-left relative">
                    <label for="password" class="block font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none pr-10"
                        placeholder="Input password" required>
                    <button type="button" id="togglePassword"
                        class="absolute right-3 top-9 text-gray-500 hover:text-blue-600 focus:outline-none" tabindex="-1">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path id="eyeOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 3.866-3.582 7-8 7s-8-3.134-8-7 3.582-7 8-7 8 3.134 8 7z" />
                            <path id="eyeClosed" style="display:none" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3l18 18M9.88 9.88A3 3 0 0012 15a3 3 0 002.12-5.12M6.53 6.53A9.77 9.77 0 003 12c0 3.866 3.582 7 8 7 1.61 0 3.09-.38 4.37-1.05M17.47 17.47A9.77 9.77 0 0021 12c0-3.866-3.582-7-8-7-1.61 0-3.09.38-4.37 1.05" />
                        </svg>
                    </button>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow transition">Login</button>
            </form>
        </div>
    </div>

    {{-- Animasi shake jika error --}}
    <style>
        @keyframes shake {

            10%,
            90% {
                transform: translateX(-2px);
            }

            20%,
            80% {
                transform: translateX(4px);
            }

            30%,
            50%,
            70% {
                transform: translateX(-8px);
            }

            40%,
            60% {
                transform: translateX(8px);
            }
        }

        .animate-shake {
            animation: shake 0.5s;
        }
    </style>
    <script>
        // Show/hide password
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            if (type === 'text') {
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = '';
            } else {
                eyeOpen.style.display = '';
                eyeClosed.style.display = 'none';
            }
        });

        // Shake animation on error
        document.addEventListener('DOMContentLoaded', function() {
            const errorBox = document.getElementById('login-error');
            const form = document.getElementById('loginForm');
            if (errorBox && form) {
                form.classList.add('animate-shake');
                setTimeout(() => {
                    form.classList.remove('animate-shake');
                }, 600);
            }
        });
    </script>
@endsection
