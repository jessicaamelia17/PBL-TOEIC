@extends('layouts2.template')

@section('content')
<div class="container">
    <h1>Edit Sesi</h1>
    <form action="{{ route('admin.sesi.update', $sesi->id_sesi) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Sesi</label>
            <input type="text" name="nama_sesi" value="{{ $sesi->nama_sesi }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Jam Mulai</label>
            <input type="time" name="jam_mulai" value="{{ $sesi->jam_mulai }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Jam Selesai</label>
            <input type="time" name="jam_selesai" value="{{ $sesi->jam_selesai }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
