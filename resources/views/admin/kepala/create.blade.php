{{-- filepath: resources/views/admin/kepala/create.blade.php --}}
@extends('layouts2.template')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0"><i class="fas fa-user-plus me-2"></i>Tambah Kepala UPA Bahasa</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.kepala.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama</label>
                                <input type="text" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror" required autofocus>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">NIP</label>
                                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                                    required>
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pangkat</label>
                                <input type="text" name="pangkat"
                                    class="form-control @error('pangkat') is-invalid @enderror" required>
                                @error('pangkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jabatan</label>
                                <input type="text" name="jabatan"
                                    class="form-control @error('jabatan') is-invalid @enderror" required>
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">TTD (opsional)</label>
                                <input type="file" name="ttd" class="form-control @error('ttd') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png">
                                @error('ttd')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">File maksimal 2MB. Format: JPG, JPEG, PNG.</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.kepala.index') }}" class="btn btn-outline-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary px-4">Simpan Kepala</button>
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
