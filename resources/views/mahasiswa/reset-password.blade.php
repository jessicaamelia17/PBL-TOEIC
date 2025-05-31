{{-- filepath: c:\laragon\www\PBL-TOEIC\resources\views\mahasiswa\reset-password.blade.php --}}
@extends('layouts.app2')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-lg">
        <div class="bg-white shadow-xl rounded-2xl p-8">
            <h1 class="text-2xl font-extrabold text-blue-700 mb-6 text-center flex items-center justify-center gap-2">
                <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3zm0 0v6m0 0H9m3 0h3"></path>
                </svg>
                @lang('users.reset_password')
            </h1>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded mb-6 shadow text-center">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded mb-6 shadow text-center">
                    @foreach ($errors->all() as $error)
                        <p class="font-medium">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('mahasiswa.resetPassword', $mahasiswa->nim) }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="current_password">
                        <i class="fa fa-lock mr-1 text-gray-400"></i>@lang('users.old_password')
                    </label>
                    <input type="password" name="current_password" id="current_password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none transition"
                        placeholder="{{ __('users.old_password_placeholder') }}" />
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="new_password">
                        <i class="fa fa-key mr-1 text-gray-400"></i>@lang('users.new_password')
                    </label>
                    <input type="password" name="new_password" id="new_password" required minlength="8"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none transition"
                        placeholder="{{ __('users.new_password_placeholder') }}" />
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="new_password_confirmation">
                        <i class="fa fa-key mr-1 text-gray-400"></i>@lang('users.confirm_password')
                    </label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                        minlength="8"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none transition"
                        placeholder="{{ __('users.confirm_password_placeholder') }}" />
                </div>
                <div class="flex justify-between mt-8">
                    <a href="{{ route('mahasiswa.profile') }}"
                        class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition">
                        @lang('users.cancel')
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow transition">
                        @lang('users.reset_password')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
