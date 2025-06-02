{{-- filepath: c:\laragon\www\PBL-TOEIC\resources\views\users\contacts.blade.php --}}
@extends('layouts.app2')

@section('content')
<div class="max-w-2xl mx-auto mt-20 bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-3xl font-bold text-blue-700 mb-6 text-center">
        <i class="fas fa-envelope mr-2"></i> @lang('users.contacts')
    </h1>
    <div class="text-gray-700 space-y-4 text-lg">
        <p>
            @lang('users.contact_description', [
                'email' => 'toeic@polinema.ac.id',
                'phone' => '+62 812-3456-7890'
            ])
        </p>
        <div>
            <span class="font-semibold">@lang('users.email'):</span>
            <a href="mailto:toeic@polinema.ac.id" class="text-blue-600 hover:underline">toeic@polinema.ac.id</a>
        </div>
        <div>
            <span class="font-semibold">@lang('users.phone'):</span>
            <a href="tel:+6281234567890" class="text-blue-600 hover:underline">+62 812-3456-7890</a>
        </div>
        <div>
            <span class="font-semibold">@lang('users.office'):</span>
            <span>Jl. Soekarno Hatta No.9, Malang, Indonesia</span>
        </div>
    </div>
</div>
@endsection