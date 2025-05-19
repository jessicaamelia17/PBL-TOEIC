@extends('layouts2.template')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Halo</h3>
        <div class="card-tools"></div>
    </div>
    <h1>Selamat datang, {{ session('admin_username') }}</h1>

</div>

<div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
  <div class="card-header">
    <i class="fas fa-users"></i> Total Pendaftar TOEIC
  </div>
  <div class="card-body">
    <h5 class="card-title display-4">{{ $pendaftar }}</h5>
    <p class="card-text">Orang telah mendaftar TOEIC.</p>
  </div>
</div>
@endsection