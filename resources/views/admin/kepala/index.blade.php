@extends('layouts.app2')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Kepala UPA Bahasa</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIP</th>
                <th>Pangkat</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>TTD</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kepalas as $kepala)
                <tr>
                    <td>{{ $kepala->nama }}</td>
                    <td>{{ $kepala->nip }}</td>
                    <td>{{ $kepala->pangkat }}</td>
                    <td>{{ $kepala->jabatan }}</td>
                    <td>
                        @if($kepala->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        @if($kepala->ttd_path)
                            <img src="{{ asset('storage/' . $kepala->ttd_path) }}" width="80">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.kepala.edit.spesifik', $kepala->id) }}" class="btn btn-primary btn-sm">Edit</a>

                        @if(!$kepala->is_active)
                            <form action="{{ route('admin.kepala.activate', $kepala->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Aktifkan kepala ini? Kepala sebelumnya akan dinonaktifkan.')">Aktifkan</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
