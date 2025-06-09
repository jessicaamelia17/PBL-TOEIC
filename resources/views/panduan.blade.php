{{-- resources/views/panduan.blade.php --}}
@php
    $breadcrumb = [
        ['label' => __('users.home'), 'url' => route('landing')],
        ['label' => __('users.guide'), 'url' => null],
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
    <section class="min-h-screen bg-blue-100 py-10 px-4">
        <div class="w-full max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-center font-bold text-blue-700 text-3xl mb-6">@lang('users.toeic_guide')</h2>

            {{-- Panduan 1 --}}
            <div class="mb-10">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">@lang('users.guide_v1')</h3>
                <div class="w-full h-[800px] border border-gray-300 rounded overflow-hidden">
                    <embed src="{{ asset('pdf/toeic_guide.pdf') }}" type="application/pdf" class="w-full h-full" />
                </div>
            </div>

            {{-- Panduan 2 --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">@lang('users.guide_v2')</h3>
                <div class="w-full h-[800px] border border-gray-300 rounded overflow-hidden">
                    <embed src="{{ asset('pdf/toeic_guide_v2.pdf') }}" type="application/pdf" class="w-full h-full" />
                </div>
            </div>

        </div>
    </section>
@endsection
