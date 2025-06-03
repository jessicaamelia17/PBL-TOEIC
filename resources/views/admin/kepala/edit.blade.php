@extends('layouts.app2')

@section('content')
<div class="container">
    <h2>Edit Kepala UPA Bahasa</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('kepala.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>Nama</label>
            <input type="text" name="nama" value="{{ $kepala->nama }}" class="form-control" required>
        </div>

        <div>
            <label>NIP</label>
            <input type="text" name="nip" value="{{ $kepala->nip }}" class="form-control" required>
        </div>

        <div>
            <label>Pangkat</label>
            <input type="text" name="pangkat" value="{{ $kepala->pangkat }}" class="form-control" required>
        </div>

        <div>
            <label>Jabatan</label>
            <input type="text" name="jabatan" value="{{ $kepala->jabatan }}" class="form-control" required>
        </div>

        <div>
            <label>Upload TTD (Opsional)</label>
            <input type="file" name="ttd" class="form-control">
            @if($kepala->ttd_path)
                <p>TTD saat ini:</p>
                <img src="{{ asset('storage/' . $kepala->ttd_path) }}" width="100">
            @endif
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
