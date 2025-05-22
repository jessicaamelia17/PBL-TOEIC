@extends('layouts.app2')

@section('content')
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 shadow-md rounded-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Student Registration</h2>
            <form method="POST" action="{{ route('register-user') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" placeholder="Username"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" name="nim" placeholder="NIM"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" placeholder="Password"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password Confirmation</label>
                    <input type="password" name="password_confirmation" placeholder="Password Confirmation"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <input type="hidden" name="role" value="mahasiswa"> <!-- Role otomatis mahasiswa -->

                <button type="submit"
                    class="w-full bg-blue-500 text-white font-semibold py-2 rounded-md hover:bg-blue-600 transition">
                    Register
                </button>
            </form>

            @if ($errors->any())
                <p class="text-red-500 text-sm mt-2">{{ $errors->first() }}</p>
            @endif

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">Have an account?
                    <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:underline">Login</a>
                </p>
            </div>
        </div>
    </div>
@endsection
