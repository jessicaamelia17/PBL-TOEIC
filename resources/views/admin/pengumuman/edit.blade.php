{{-- filepath: resources/views/admin/pengumuman/edit.blade.php --}}
@extends('layouts2.template')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Edit Pengumuman</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.pengumuman.update', $pengumuman->Id_Pengumuman) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="judul" class="form-label fw-semibold">Judul Pengumuman</label>
                                <input type="text" name="judul" value="{{ old('judul', $pengumuman->Judul) }}"
                                    class="form-control @error('judul') is-invalid @enderror" required autofocus>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="isi" class="form-label fw-semibold">Isi Pengumuman</label>
                                <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" rows="5" required>{{ old('isi', $pengumuman->Isi) }}</textarea>
                                @error('isi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pengumuman" class="form-label fw-semibold">Tanggal Pengumuman</label>
                                <input type="datetime-local" name="tanggal_pengumuman"
                                    value="{{ old('tanggal_pengumuman', \Carbon\Carbon::parse($pengumuman->Tanggal_Pengumuman)->format('Y-m-d\TH:i')) }}"
                                    class="form-control @error('tanggal_pengumuman') is-invalid @enderror" required>
                                @error('tanggal_pengumuman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="file_pengumuman" class="form-label fw-semibold">File Pengumuman
                                    (PDF/Gambar)</label>
                                @if ($pengumuman->file_pengumuman)
                                    <div class="mb-2">
                                        <a href="{{ asset('storage/' . $pengumuman->file_pengumuman) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">Lihat File Saat Ini</a>
                                    </div>
                                @endif
                                <input type="file" name="file_pengumuman"
                                    class="form-control @error('file_pengumuman') is-invalid @enderror"
                                    accept=".pdf,.jpg,.png">
                                @error('file_pengumuman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Kosongkan jika tidak ingin mengganti file. Maksimal 2MB.</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.pengumuman.index') }}"
                                    class="btn btn-outline-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary px-4">Update Pengumuman</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
