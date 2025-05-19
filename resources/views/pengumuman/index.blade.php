@extends('layouts.app')

@section('content')
<section class="container mx-auto py-12 px-6">
    <h2 class="text-3xl font-bold text-center text-blue-900 mb-6">All Announcements</h2>

    @if ($pengumuman->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-600">
            Belum ada pengumuman.
        </div>
    @else
        <div class="bg-white p-6 rounded-lg shadow">
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                @foreach ($pengumuman as $item)
                    <li class="flex justify-between items-center">
                        <span>{{ $item->Judul }}</span>
                        <a href="{{ route('pengumuman.show', $item->Id_Pengumuman) }}"
                           class="text-white-600 whitespace-nowrap btn btn-primary">
                            See More
                        </a>
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
