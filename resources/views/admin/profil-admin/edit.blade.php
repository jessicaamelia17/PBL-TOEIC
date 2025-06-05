@extends('layouts2.template')

@section('title', 'Edit Profil Admin')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4 text-center">
                        <h3 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profil Admin</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3 text-center">
                                @if ($admin->foto)
                                    <img src="{{ asset('storage/foto_admin/' . $admin->foto) }}" alt="Foto Profil"
                                        class="rounded-circle shadow border border-3 border-primary mb-2" width="110"
                                        height="110" style="object-fit:cover;">
                                @else
                                    <img src="{{ asset('profile-picture.jpg') }}" alt="Foto Default"
                                        class="rounded-circle shadow border border-3 border-primary mb-2" width="110"
                                        height="110" style="object-fit:cover;">
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="Username" class="form-label fw-semibold">Username</label>
                                <input type="text" id="Username" name="Username"
                                    class="form-control rounded-pill @error('Username') is-invalid @enderror"
                                    value="{{ old('Username', $admin->Username) }}" required>
                                @error('Username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label fw-semibold">Nama</label>
                                <input type="text" id="nama" name="nama"
                                    class="form-control rounded-pill @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $admin->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control rounded-pill @error('email') is-invalid @enderror"
                                    value="{{ old('email', $admin->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="no_hp" class="form-label fw-semibold">No HP</label>
                                <input type="text" id="no_hp" name="no_hp"
                                    class="form-control rounded-pill @error('no_hp') is-invalid @enderror"
                                    value="{{ old('no_hp', $admin->no_hp) }}">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label fw-semibold">Foto Profil</label>
                                <input type="file" id="foto" name="foto"
                                    class="form-control rounded-pill @error('foto') is-invalid @enderror" accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 2MB. Format: JPG, JPEG, PNG.</div>
                            </div>

                            <div class="mb-3">
                                <label for="Password" class="form-label fw-semibold">Password Baru <small>(kosongkan jika
                                        tidak diganti)</small></label>
                                <input type="password" id="Password" name="Password"
                                    class="form-control rounded-pill @error('Password') is-invalid @enderror">
                                @error('Password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="Password_confirmation" class="form-label fw-semibold">Konfirmasi
                                    Password</label>
                                <input type="password" id="Password_confirmation" name="Password_confirmation"
                                    class="form-control rounded-pill">
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.profile') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="fas fa-arrow-left me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
@endpush
