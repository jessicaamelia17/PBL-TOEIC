@extends('layouts.app')

@section('content')

    {{-- Global background color (e.g., light gray) --}}
    <section class="relative w-full min-h-screen text-white overflow-hidden bg-blue-100 pt-20">
        {{-- Full background image --}}
        <img src="{{ asset('/homepage.png') }}" alt="TOEIC Banner"
            class="absolute inset-0 w-full h-full object-cover object-center z-0" />

        {{-- Dark overlay for contrast --}}
        <div class="absolute inset-0 bg-grey/40 z-10"></div>

        {{-- Text on top of image --}}
        <div
            class="absolute inset-0 flex flex-col items-center justify-start text-blue-900 px-2 text-center z-10 pt-20 space-y-4">
            <h2 class="text-4xl md:text-5xl font-bold drop-shadow-lg" data-aos="fade-down" data-aos-duration="1200">
                @lang('users.toeic_service')</h2>

            <h3 class="text-2xl md:text-3xl font-semibold drop-shadow-md" data-aos="fade-down" data-aos-delay="200"
                data-aos-duration="1000">@lang('users.polinema')</h3>

            <p class="max-w-xl text-lg md:text-xl text-blue-900 drop-shadow" data-aos="fade-up" data-aos-delay="400"
                data-aos-duration="1000">
                @lang('users.desc_toeic')
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
    <section class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8 mb-12" data-aos="fade-up" data-aos-duration="1000">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">@lang('users.announcement')</h2>
        @if ($pengumuman->isEmpty())
            <div class="text-center text-gray-600">@lang('users.no_announcement')</div>
        @else
            <div class="space-y-6 text-gray-700">
                @foreach ($pengumuman->take(3) as $item)
                    <div class="flex justify-between items-center border-b border-gray-300 pb-4">
                        <span class="text-lg font-semibold">{{ $item->Judul }}</span>
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($item->Tanggal_Pengumuman)->translatedFormat('d M Y') }}
                            </span>
                            <a href="{{ route('mahasiswa.show-pengumuman', $item->Id_Pengumuman) }}"
                                class="text-blue-600 hover:underline">
                                @lang('users.read_more')
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($pengumuman->count() > 3)
                <div class="text-center mt-8">
                    <a href="{{ route('mahasiswa.pengumuman') }}"
                        class="inline-block bg-blue-600 text-white font-semibold px-6 py-2 rounded hover:bg-blue-700 transition">
                        @lang('users.see_announcement')
                    </a>
                </div>
            @endif
        @endif
    </section>

    @auth
    @if($riwayat && count($riwayat) > 0)
        <section class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8 mb-12" data-aos="fade-up" data-aos-duration="1000">
            <h2 class="text-2xl font-bold text-blue-900 mb-6">Riwayat TOEIC Anda</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-gray-800">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Tanggal Daftar</th>
                            <th class="py-2 px-4 border-b">Jadwal Ujian</th>
                            <th class="py-2 px-4 border-b">Status Ujian</th>
                            <th class="py-2 px-4 border-b">Status Hasil</th>
                            <th class="py-2 px-4 border-b">Nilai</th>
                            <th class="py-2 px-4 border-b">Pengambilan Sertifikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $item)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $item->pendaftaran->Tanggal_Pendaftaran ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->jadwal->Tanggal_Ujian ?? '-' }}</td>

                                {{-- Status Ujian --}}
                                <td class="py-2 px-4 border-b">
                                    @if($item->hasil)
                                        Sudah Ujian
                                    @else
                                        Belum Ujian
                                    @endif
                                </td>

                                                        {{-- Status Hasil --}}
                                <td class="py-2 px-4 border-b">
                                    @if($item->hasil)
                                        {{-- Tampilkan status dari DB, tapi dengan huruf kapital --}}
                                        {{ ucfirst($item->hasil->status) }}
                                    @else
                                        Menunggu Hasil
                                    @endif
                                </td>

                                {{-- Nilai --}}
                                <td class="py-2 px-4 border-b">
                                    {{ $item->hasil->total_skor_2 ?? '-' }}
                                </td>

                                {{-- Pengambilan Sertifikat --}}
                                <td class="py-2 px-4 border-b">
                                    @if($item->hasil)
                                        @if($item->sertifikat)
                                            Diambil pada {{ \Carbon\Carbon::parse($item->sertifikat->tanggal_pengambilan)->format('d M Y') }}
                                        @else
                                            Belum Diambil
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @else
        <section class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8 mb-12" data-aos="fade-up" data-aos-duration="1000">
            <h2 class="text-2xl font-bold text-blue-900 mb-6">Riwayat TOEIC Anda</h2>
            <p class="text-gray-600">Belum ada riwayat pendaftaran TOEIC.</p>
        </section>
    @endif
@endauth

    {{-- Info Cards --}}
    @php
        $cards = [
            [
                'title' => 'users.toeic_registration',
                'desc' => 'users.toeic_registration_desc',
                'img' => 'registration.png',
                'link' => route('mahasiswa.registrasi.create'),
                'button' => 'users.toeic_registration_button',
                'bg' => 'bg-white',
                'aos' => 'fade-right',
            ],
            [
                'title' => 'users.exam_schedule',
                'desc' => 'users.exam_schedule_desc',
                'img' => 'jadwal.png',
                'link' => route('mahasiswa.schedule.index'),
                'button' => 'users.exam_schedule_button',
                'bg' => 'bg-gray-50',
                'aos' => 'fade-left',
            ],
            [
                'title' => 'users.exam_results',
                'desc' => 'users.exam_results_desc',
                'img' => 'result.png',
                'link' => url('/hasil-ujian'),
                'button' => 'users.exam_results_button',
                'bg' => 'bg-white',
                'aos' => 'fade-right',
            ],
            [
                'title' => 'users.toeic_guide',
                'desc' => 'users.toeic_guide_desc',
                'img' => 'guide.png',
                'link' => url('/panduan'),
                'button' => 'users.toeic_guide_button',
                'bg' => 'bg-gray-50',
                'aos' => 'fade-left',
            ],
        ];
    @endphp
    @foreach ($cards as $index => $card)
        <section class="max-w-5xl mx-auto {{ $card['bg'] }} rounded-2xl shadow-lg p-10 mb-12"
            data-aos="{{ $card['aos'] }}" data-aos-duration="1000">
            <div
                class="flex flex-col md:flex-row items-center gap-8
            {{ $index % 2 == 1 ? 'md:flex-row-reverse' : '' }}">
                <img src="{{ asset($card['img']) }}" alt="{{ $card['title'] }}"
                    class="w-32 md:w-40 h-auto mx-auto md:mx-0 rounded-lg shadow">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold text-blue-900">{{ __($card['title']) }}</h2>
                    <p class="text-gray-800 mt-2 text-lg leading-relaxed">{{ __($card['desc']) }}</p>
                    <a href="{{ $card['link'] }}"
                        class="inline-block mt-4 bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        {{ __($card['button']) }}
                    </a>
                </div>
            </div>
        </section>
    @endforeach

    {{-- Testimoni --}}


    {{-- Pengajuan Surat --}}
    <section class="max-w-5xl mx-auto bg-blue-100 rounded-2xl shadow-lg p-10 mb-12" data-aos="zoom-in-up"
        data-aos-duration="1000">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <img src="{{ asset('pengajuan.png') }}" alt="Pengajuan Surat"
                class="w-40 md:w-56 h-auto mx-auto md:mx-0 rounded-lg shadow">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-blue-900">@lang('users.toeic_letter')</h2>
                <p class="text-gray-800 mt-2 text-lg leading-relaxed">
                    @lang('users.toeic_letter_desc')
                </p>
                <a href="{{ route('surat.index') }}"
                    class="inline-block mt-4 bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    @lang('users.toeic_letter_button')
                </a>
            </div>
        </div>
    </section>

    {{-- Daftar Mandiri ke ITC --}}
    <section class="max-w-5xl mx-auto bg-yellow-100 rounded-2xl shadow-lg p-10 mb-12" data-aos="zoom-in-left"
        data-aos-duration="1000">
        <div class="flex flex-col md:flex-row-reverse items-center gap-8">
            <img src="{{ asset('mandiri.png') }}" alt="Pendaftaran ITC"
                class="w-40 md:w-56 h-auto mx-auto md:mx-0 rounded-lg shadow">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-yellow-900">@lang('users.itc_registration')</h2>
                <p class="text-gray-800 mt-2 text-lg leading-relaxed">
                    @lang('users.itc_registration_desc')
                </p>
                <a href="https://itc-indonesia.com/" target="_blank"
                    class="inline-block mt-4 bg-yellow-500 text-blue-900 font-semibold px-6 py-2 rounded-lg hover:bg-yellow-600 transition">
                    @lang('users.itc_registration_button')
                </a>
            </div>
        </div>
    </section>



@endsection
