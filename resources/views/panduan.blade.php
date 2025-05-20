{{-- resources/views/panduan.blade.php --}}
@extends('layouts.app2') {{-- atau layouts.app sesuai struktur Anda --}}

@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection

@section('content')
<section class="min-h-screen bg-blue-100 py-10 px-4">
    <div class="w-full max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-center font-bold text-blue-700 text-3xl mb-6">Panduan TOEIC</h2>
        <div class="w-full h-[800px] border border-gray-300 rounded overflow-hidden">
            <embed 
                src="{{ asset('pdf/toeic_guide.pdf') }}" 
                type="application/pdf" 
                class="w-full h-full" />
        </div>        
    </div>
</section>
@endsection