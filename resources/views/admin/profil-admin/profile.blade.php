@extends('layouts2.template')

@section('title', 'Profil Admin')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-body text-center p-5"
                        style="background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%); color: #fff;">
                        <div class="mb-4 position-relative d-inline-block">
                            <div class="profile-img-wrapper mx-auto mb-2" style="position: relative;">
                                @if ($admin->foto)
                                    <img src="{{ asset('storage/foto_admin/' . $admin->foto) }}" alt="Foto Profil"
                                        class="rounded-circle shadow border border-3 border-white" width="140"
                                        height="140" style="object-fit:cover;">
                                @else
                                    <img src="{{ asset('profile-picture.jpg') }}" alt="Foto Default"
                                        class="rounded-circle shadow border border-3 border-white" width="140"
                                        height="140" style="object-fit:cover;">
                                @endif
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-light text-primary px-3 py-1 rounded-pill" style="font-size: 1rem;">
                                    <i class="fas fa-user-shield me-1"></i> {{ $admin->nama }}
                                </span>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-4 mt-3">
                            <div class="col-6 text-start">
                                <p class="mb-2"><i class="fas fa-user me-2"></i><strong> Username :</strong>
                                    {{ $admin->Username }}</p>
                                <p class="mb-2"><i class="fas fa-envelope me-2"></i><strong> Email :
                                    </strong>{{ $admin->email }}
                                </p>
                                <p class="mb-2"><i class="fas fa-phone me-2"></i><strong> No HP :</strong>
                                    {{ $admin->no_hp ?? '-' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.profile.edit') }}"
                            class="btn btn-warning px-4 rounded-pill shadow-sm mt-2">
                            <i class="fas fa-edit me-1"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        .profile-img-wrapper {
            box-shadow: 0 4px 24px 0 rgba(37, 99, 235, 0.15), 0 1.5px 4px 0 rgba(0, 0, 0, 0.08);
            border-radius: 50%;
            background: #fff;
            padding: 6px;
            display: inline-block;
        }
    </style>
@endpush
