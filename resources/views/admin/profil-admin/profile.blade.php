@extends('layouts2.template')

@section('title', 'Profil Admin')

@section('content')
<div class="container mt-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            @foreach ($breadcrumb->list as $key => $item)
                @if ($key + 1 == count($breadcrumb->list))
                    <li class="breadcrumb-item active" aria-current="page">{{ $item }}</li>
                @else
                    <li class="breadcrumb-item"><a href="#">{{ $item }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2>Profil Admin</h2>
    <div class="card mt-3">
        <div class="card-body">
            <div class="mb-3 text-center">
                @if($admin->foto)
                    <img src="{{ asset('storage/foto_admin/' . $admin->foto) }}" alt="Foto Profil" class="img-thumbnail" width="150">
                @else
                    <img src="{{ asset('images/default.png') }}" alt="Foto Default" class="img-thumbnail" width="150">
                @endif
            </div>
            <p><strong>Nama:</strong> {{ $admin->nama }}</p>
            <p><strong>Email:</strong> {{ $admin->email }}</p>
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-warning">Edit Profil</a>
        </div>
    </div>
</div>
@endsection
