@extends('layouts.app2')

@section('title', 'Login TOEIC Mahasiswa')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg text-center" style="width: 400px; animation: fadeIn 1s ease-in-out;">
        
        {{-- Logo Polinema --}}
        <img src="{{ asset('polinema.png') }}" alt="Polinema Logo" class="mx-auto d-block mb-3" style="width: 80px; height: auto;">

        <h3 class="mb-4">Login TOEIC Mahasiswa</h3>

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login-toeic') }}">
            @csrf
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" id="nim" name="nim" class="form-control" placeholder="Masukkan NIM" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login TOEIC</button>
        </form>
    </div>
</div>
@endsection