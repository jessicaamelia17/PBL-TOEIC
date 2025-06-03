{{-- filepath: resources/views/admin/kepala/index.blade.php --}}
@extends('layouts2.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Kepala UPA Bahasa</h3>
            <div class="card-tools">
                <a href="{{ route('admin.kepala.create') }}" class="btn btn-success">+ Tambah Kepala</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_kepala">
                <thead>
                    <tr>
                        <th>No</th>
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
                    @foreach ($kepalas as $i => $kepala)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $kepala->nama }}</td>
                            <td>{{ $kepala->nip }}</td>
                            <td>{{ $kepala->pangkat }}</td>
                            <td>{{ $kepala->jabatan }}</td>
                            <td>
                                @if ($kepala->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if ($kepala->ttd_path)
                                    <img src="{{ asset('storage/' . $kepala->ttd_path) }}" width="80">
                                @endif
                            </td>
                            <td>
                                {{-- <a href="{{ route('admin.kepala.edit.spesifik', $kepala->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a> --}}
                                {{-- @if (!$kepala->is_active)
                                    <form action="{{ route('admin.kepala.activate', $kepala->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning btn-sm"
                                            onclick="return confirm('Aktifkan kepala ini? Kepala sebelumnya akan dinonaktifkan.')">Aktifkan</button>
                                    </form>
                                @endif --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#table_kepala').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                    emptyTable: "Tidak ada data tersedia"
                }
            });
        });
    </script>
@endpush
