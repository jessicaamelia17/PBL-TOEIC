{{-- filepath: c:\laragon\www\PBL-TOEIC\resources\views\contacts.blade.php --}}
@php
    $breadcrumb = [
        ['label' => __('users.home'), 'url' => route('landing')],
        ['label' => __('users.contacts'), 'url' => null],
    ];
@endphp
@extends('layouts.app2')

@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection

@section('content')
    <div class="max-w-2xl mx-auto mt-20 bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-blue-700 mb-6 text-center">
            <i class="fas fa-envelope mr-2"></i> @lang('users.contacts')
        </h1>
        <div class="text-gray-700 space-y-4 text-lg">
            <div>
                <i class="fas fa-envelope text-blue-500 mr-2"></i>
                <a href="mailto:toeic@polinema.ac.id" class="text-blue-600 hover:underline">toeic@polinema.ac.id</a>
            </div>
            <div>
                <i class="fas fa-phone-alt text-blue-500 mr-2"></i>
                <a href="tel:+6281234567890" class="text-blue-600 hover:underline">+62 812-3456-7890</a>
            </div>
            <div>
                <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                <span>Jl. Soekarno Hatta No.9, Jatimulyo, Kota Malang, Jawa Timur 65141</span>
            </div>
            <div class="mt-6">
                <span class="font-semibold block mb-2">@lang('users.location'):</span>
                <iframe src="https://www.google.com/maps?q=Politeknik+Negeri+Malang&hl=id&z=16&output=embed" width="100%"
                    height="300" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
@endsection
