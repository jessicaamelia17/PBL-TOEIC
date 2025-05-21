@extends('layouts2.template')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Halo</h3>
        <div class="card-tools"></div>
    </div>
    <h1>Selamat datang, {{ session('admin_username') }}</h1>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3" style="height: 150px;">
            <div class="card-header">
                <i class="fas fa-boxes"></i> Kuota Tersedia:
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-4">{{ $kuota }}</h1>
                <p class="mb-0">Total kuota pendaftaran</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3" style="height: 150px;">
            <div class="card-header">
                <i class="fas fa-users"></i> Total Pendaftar TOEIC:
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-4">{{ $pendaftar }}</h1>
                <p class="mb-0">Orang telah mendaftar TOEIC</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-danger mb-3" style="height: 150px;">
            <div class="card-header">
                <i class="fas fa-user-minus"></i> Sisa Kuota:
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-4">{{ $kuota - $pendaftar }}</h1>
                <p class="mb-0">Kuota yang masih tersedia</p>
            </div>
        </div>
    </div>
</div>
@endsection