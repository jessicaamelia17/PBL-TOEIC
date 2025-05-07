@extends('layouts2.template')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Halo</h3>
        <div class="card-tools"></div>
    </div>
    <h1>Selamat datang, {{ session('admin_username') }}</h1>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
@endsection