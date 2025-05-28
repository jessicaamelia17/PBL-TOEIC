{{-- filepath: resources/views/admin/jadwal/create.blade.php --}}
@extends('layouts2.template')
@section('content')
<div class="container">
    <h4>Tambah Jadwal Ujian</h4>
    <form action="{{ route('admin.jadwal.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Tanggal Ujian</label>
            <input type="date" name="Tanggal_Ujian" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kuota Maksimum</label>
            <input type="number" name="kuota_max" class="form-control" required min="1">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection