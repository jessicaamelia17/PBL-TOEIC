@extends('layouts.app2')
@section('content')
<div class="max-w-md mx-auto mt-20 bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-2xl font-bold text-blue-700 mb-6 text-center">@lang('users.forgot_password')</h1>
    @if (session('status'))
        <div class="mb-4 text-green-600">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" required class="w-full p-3 rounded bg-gray-100 border border-gray-300" placeholder="youremail@example.com">
            @error('email') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="w-full py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
            @lang('users.send_reset_link')
        </button>
    </form>
</div>
@endsection