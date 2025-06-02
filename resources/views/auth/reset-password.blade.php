@extends('layouts.app2')
@section('content')
<div class="max-w-md mx-auto mt-20 bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-2xl font-bold text-blue-700 mb-6 text-center">@lang('users.reset_password')</h1>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium mb-1">@lang('users.new_password')</label>
            <input type="password" name="password" id="password" required class="w-full p-3 rounded bg-gray-100 border border-gray-300">
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium mb-1">@lang('users.confirm_password')</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full p-3 rounded bg-gray-100 border border-gray-300">
        </div>
        <button type="submit" class="w-full py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
            @lang('users.reset_password')
        </button>
    </form>
</div>
@endsection