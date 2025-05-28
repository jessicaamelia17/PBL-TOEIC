@extends('layouts.app')

@section('content')

{{-- Global background color (e.g., light gray) --}}
<section class="relative w-full min-h-screen text-white overflow-hidden bg-blue-100 pt-20">
    {{-- Full background image --}}
    <img src="{{ asset('/homepage.png') }}"
         alt="TOEIC Banner"
         class="absolute inset-0 w-full h-full object-cover object-center z-0" />

    {{-- Dark overlay for contrast --}}
    <div class="absolute inset-0 bg-grey/40 z-10"></div>

    {{-- Text on top of image --}}
    <div class="absolute inset-0 flex flex-col items-center justify-start text-blue-900 px-2 text-center z-10 pt-20 space-y-4">
        <h2 class="text-4xl md:text-5xl font-bold drop-shadow-lg"
            data-aos="fade-down"
            data-aos-duration="1200">TOEIC Service</h2>

        <h3 class="text-2xl md:text-3xl font-semibold drop-shadow-md"
            data-aos="fade-down"
            data-aos-delay="200"
            data-aos-duration="1000">POLYTECHNIC STATE OF MALANG</h3>

        <p class="max-w-xl text-lg md:text-xl text-blue-900 drop-shadow"
           data-aos="fade-up"
           data-aos-delay="400"
           data-aos-duration="1000">
            Get complete information about TOEIC registration, schedules, and exam results.
        </p>
    </div>

    {{-- Button at bottom of image --}}
    {{-- <div class="w-full flex justify-center absolute bottom-20 z-20"
         data-aos="zoom-in-up"
         data-aos-delay="600"
         data-aos-duration="1000">
        <a href="{{ route('mahasiswa.registrasi.create') }}"
           class="inline-block bg-yellow-400 hover:bg-yellow-500 text-blue-900 font-bold py-2 px-8 rounded shadow-md transition">
            Register Now
        </a>
    </div> --}}
</section>

{{-- Announcement --}}
<section class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8 mb-12"
         data-aos="fade-up" data-aos-duration="1000">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Announcements</h2>
    @if ($pengumuman->isEmpty())
        <div class="text-center text-gray-600">No announcements available.</div>
    @else
        <div class="space-y-6 text-gray-700">
            @foreach ($pengumuman->take(3) as $item)
                <div class="flex justify-between items-center border-b border-gray-300 pb-4">
                    <span class="text-lg font-semibold">{{ $item->Judul }}</span>
                    <a href="{{ route('mahasiswa.pengumuman', $item->Id_Pengumuman) }}" class="text-blue-600 hover:underline">
                        See More
                    </a>
                </div>
            @endforeach
        </div>
        @if ($pengumuman->count() > 3)
            <div class="text-center mt-8">
                <a href="{{ route('mahasiswa.pengumuman') }}"
                   class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    View All Announcements
                </a>
            </div>
        @endif
    @endif
</section>

{{-- Info Cards --}}
@php
    $cards = [
        [
            'title' => 'TOEIC Registration',
            'desc' => 'Fill out the registration form with valid data to take the TOEIC test through the campus.',
            'img' => 'registration.png',
            'link' => route('mahasiswa.registrasi.create'),
            'button' => 'Register Now',
            'bg' => 'bg-white',
            'aos' => 'fade-right',
        ],
        [
            'title' => 'Exam Schedule',
            'desc' => 'Check the latest schedule for official TOEIC exams from campus.',
            'img' => 'jadwal.png',
            'link' => route('mahasiswa.schedule.index'),
            'button' => 'View Schedule',
            'bg' => 'bg-gray-50',
            'aos' => 'fade-left',
        ],
        [
            'title' => 'Check Exam Results',
            'desc' => 'Check your TOEIC test results online and get your score immediately.',
            'img' => 'result.png',
            'link' => url('/hasil-ujian'),
            'button' => 'View Results',
            'bg' => 'bg-white',
            'aos' => 'fade-right',
        ],
        [
            'title' => 'Complete Guide',
            'desc' => 'Study the complete TOEIC guide to better prepare for the test.',
            'img' => 'guide.png',
            'link' => url('/panduan'),
            'button' => 'Read Guide',
            'bg' => 'bg-gray-50',
            'aos' => 'fade-left',
        ],
    ];
@endphp
@foreach ($cards as $index => $card)
<section class="max-w-5xl mx-auto {{ $card['bg'] }} rounded-2xl shadow-lg p-10 mb-12"
        data-aos="{{ $card['aos'] }}" data-aos-duration="1000">
    <div class="flex flex-col md:flex-row items-center gap-8
        {{ $index % 2 == 1 ? 'md:flex-row-reverse' : '' }}">
        <img src="{{ asset($card['img']) }}" alt="{{ $card['title'] }}" class="w-32 md:w-40 h-auto mx-auto md:mx-0 rounded-lg shadow">
        <div class="text-center md:text-left">
            <h2 class="text-2xl md:text-3xl font-bold text-blue-900">{{ $card['title'] }}</h2>
            <p class="text-gray-800 mt-2 text-lg leading-relaxed">{{ $card['desc'] }}</p>
            <a href="{{ $card['link'] }}"
            class="inline-block mt-4 bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                {{ $card['button'] }}
            </a>
        </div>
    </div>
</section>
@endforeach


{{-- Independent Registration to ITC --}}
<section class="max-w-5xl mx-auto bg-yellow-100 rounded-2xl shadow-lg p-10 mb-12"
data-aos="zoom-in-left" data-aos-duration="1000">
<div class="flex flex-col md:flex-row-reverse items-center gap-8">
        <img src="{{ asset('mandiri.png') }}" alt="ITC Registration" class="w-40 md:w-56 h-auto mx-auto md:mx-0 rounded-lg shadow">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-yellow-900">Want to Register Independently via ITC?</h2>
            <p class="text-gray-800 mt-2 text-lg leading-relaxed">
                If you missed campus registration, you can still take the TOEIC test independently through an official ITC. Choose a test date and location that suits your needs.
            </p>
            <a href="https://itc-indonesia.com/" target="_blank"
               class="inline-block mt-4 bg-yellow-500 text-blue-900 font-semibold px-6 py-2 rounded-lg hover:bg-yellow-600 transition">
               Register at ITC
            </a>
        </div>
    </div>
</section>

{{-- TOEIC Letter Submission --}}
<section class="max-w-5xl mx-auto bg-blue-100 rounded-2xl shadow-lg p-10 mb-12"
         data-aos="zoom-in-up" data-aos-duration="1000">
    <div class="flex flex-col md:flex-row items-center gap-8">
        <img src="{{ asset('pengajuan.png') }}" alt="Recommendation Letter" class="w-40 md:w-56 h-auto mx-auto md:mx-0 rounded-lg shadow">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-blue-900">Need a Certificate of TOEIC Attendance?</h2>
            <p class="text-gray-800 mt-2 text-lg leading-relaxed">
                Submit your TOEIC recommendation or administrative request letter directly through our system. Just log in, fill in your data, and track your submission status in real-time.
            </p>
            <a href="{{ route('surat.index') }}"
               class="inline-block mt-4 bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Submit Letter Now
            </a>
        </div>
    </div>
</section>
@endsection
