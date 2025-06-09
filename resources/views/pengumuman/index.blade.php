@extends('layouts.app2')

@section('breadcrumb')
    @include('layouts.breadcrumb')
@endsection

@section('backbutton')
    @include('layouts.back-button')
@endsection

@section('content')
    <section class="container mx-auto py-12 px-6">
        <h2 class="text-3xl font-bold text-center text-blue-900 mb-6">@lang('users.announcement_all')</h2>

        @if ($pengumuman->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-600">
                @lang('users.no_announcement')
            </div>
        @else
            <div class="bg-white p-6 rounded-lg shadow">
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    @foreach ($pengumuman as $item)
                        <li class="flex justify-between items-center">
                            <span>{{ $item->Judul }}</span>
                            <div class="flex items-center gap-4">
                                <span class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->Tanggal_Pengumuman)->translatedFormat('d M Y') }}
                                </span>
                                <a href="{{ route('show-pengumuman', $item->Id_Pengumuman) }}"
                                    class="text-white whitespace-nowrap btn btn-primary hover:underline">
                                    @lang('users.read_more')
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Pagination links -->
                <div class="mt-6">
                    {{ $pengumuman->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        @endif
    </section>
@endsection
