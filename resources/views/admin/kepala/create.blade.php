@extends('layouts.app2')

@section('content')
<div class="container">
    <h2>Tambah Kepala UPA Bahasa</h2>
    <form action="{{ route('admin.kepala.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Pangkat</label>
            <input type="text" name="pangkat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>TTD (opsional)</label>
            <input type="file" name="ttd" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kepala.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection