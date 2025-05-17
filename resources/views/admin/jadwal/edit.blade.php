@extends('layouts2.template')


@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.jadwal.index') }}">Jadwal Ujian</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Kuota</li>
        </ol>
    </nav>

    <h4>Edit Kuota Jadwal Ujian - {{ \Carbon\Carbon::parse($jadwal->Tanggal_Ujian)->format('d M Y') }}</h4>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Card Form --}}
    <div class="card">
        <div class="card-header bg-warning">
            <strong>Edit Kuota & Status</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jadwal.update', $jadwal->Id_Jadwal) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="kuota_max" class="form-label">Kuota Maksimal</label>
                    <input type="number" name="kuota_max" value="{{ $jadwal->kuota_max }}" class="form-control" required min="1">
                </div>

                <div class="mb-3">
                    <label for="status_registrasi">Status Registrasi</label>
                    <select name="status_registrasi" class="form-control">
                        <option value="buka" {{ $jadwal->status_registrasi == 'buka' ? 'selected' : '' }}>Buka</option>
                        <option value="tutup" {{ $jadwal->status_registrasi == 'tutup' ? 'selected' : '' }}>Tutup</option>
                    </select>
                </div>
                

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
