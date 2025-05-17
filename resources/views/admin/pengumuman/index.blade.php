@extends('layouts2.template')

@section('content')
<div class="container">
    <h2>Daftar Pengumuman</h2>
    <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-success mb-3">+ Buat Pengumuman</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Isi</th>
                <th>Tanggal</th>
                <th>Dibuat Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengumuman as $p)
            <tr>
                <td>{{ $p->Judul }}</td>
                <td>{{ Str::limit($p->Isi, 100) }}</td>
                <td>{{ $p->Tanggal_Pengumuman }}</td>
                <td>{{ $p->admin->Username ?? 'Tidak diketahui' }}</td>
                <td>
                    <form action="{{ route('admin.pengumuman.destroy', $p->id_Pengumuman) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
