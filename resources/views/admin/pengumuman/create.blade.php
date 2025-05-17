@extends('layouts2.template')

@section('content')
    <div class="container">
        <h2>Buat Pengumuman Baru</h2>
        <form action="{{ route('admin.pengumuman.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="isi" class="form-label">Isi</label>
                <textarea name="isi" class="form-control" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="tanggal_pengumuman" class="form-label">Tanggal Pengumuman</label>
                <input type="datetime-local" name="tanggal_pengumuman" class="form-control"
                    value="{{ now()->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
