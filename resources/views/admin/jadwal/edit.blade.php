{{-- filepath: resources/views/admin/jadwal/edit.blade.php --}}
@extends('layouts2.template')
@section('content')
<div class="container">
    <h4>Edit Jadwal Ujian</h4>
    <form action="{{ route('admin.jadwal.update', $jadwal->id_jadwal) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Tanggal Ujian</label>
            <input type="date" name="Tanggal_Ujian" class="form-control" value="{{ $jadwal->Tanggal_Ujian }}" required>
        </div>
        <div class="mb-3">
            <label>Kuota Maksimum</label>
            <input type="number" name="kuota_max" class="form-control" value="{{ $jadwal->kuota_max }}" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection