@extends('layouts2.template')

@section('title', 'Edit Profil Admin')

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

    <h2>Edit Profil Admin</h2>

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" id="nama" name="nama" 
                class="form-control @error('nama') is-invalid @enderror" 
                value="{{ old('nama', $admin->nama) }}" required>
            @error('nama') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email', $admin->email) }}" required>
            @error('email') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>

        <div class="mb-3">
            <label for="password">Password Baru <small>(kosongkan jika tidak diganti)</small></label>
            <input type="password" id="password" name="password" 
                class="form-control @error('password') is-invalid @enderror">
            @error('password') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" 
                class="form-control">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto Profil</label><br>
            @if($admin->foto)
                <img src="{{ asset('storage/foto_admin/' . $admin->foto) }}" alt="Foto Profil" width="150" class="mb-2 rounded border">
            @endif
            <input type="file" id="foto" name="foto" 
                class="form-control @error('foto') is-invalid @enderror" accept="image/*">
            @error('foto') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.profile') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
