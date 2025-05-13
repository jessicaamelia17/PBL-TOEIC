@extends('layouts2.template')

@section('content')
<h4>Edit Kuota Jadwal Ujian - {{ $jadwal->Tanggal_Ujian }}</h4>

<form action="{{ route('admin.jadwal.update', $jadwal->Id_Jadwal) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="kuota_max">Kuota Maksimal</label>
        <input type="number" name="kuota_max" value="{{ $jadwal->kuota_max }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="status_registrasi">Status Registrasi</label>
        <select name="status_registrasi" class="form-control">
            <option value="buka" {{ $jadwal->status_registrasi == 'buka' ? 'selected' : '' }}>Buka</option>
            <option value="tutup" {{ $jadwal->status_registrasi == 'tutup' ? 'selected' : '' }}>Tutup</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
</form>
@endsection