@extends('layouts2.template')

@section('title', $breadcrumb->title)

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach ($breadcrumb->list as $item)
                <li class="breadcrumb-item">{{ $item }}</li>
            @endforeach
        </ol>
    </nav> --}}

    <h4>{{ $breadcrumb->title }} ({{ $jadwal->Tanggal_Ujian }})</h4>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Form tambah sesi --}}
    <div class="card mb-3">
        <div class="card-header">Tambah Sesi</div>
        <div class="card-body">
            @php
                $maxSesi = 2;
                $jumlahSesi = $jadwal->sesi->count();
                $disableTambah = $jumlahSesi >= $maxSesi;
            @endphp
            <form action="{{ route('admin.sesi.storeSesi', $jadwal->id_jadwal) }}" method="POST">
                @csrf
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" name="nama_sesi" class="form-control" placeholder="Nama Sesi" required {{ $disableTambah ? 'disabled' : '' }}>
                    </div>
                    <div class="col">
                        <input type="time" name="waktu_mulai" class="form-control" placeholder="Jam Mulai" required {{ $disableTambah ? 'disabled' : '' }}>
                    </div>
                    <div class="col">
                        <input type="time" name="waktu_selesai" class="form-control" placeholder="Jam Selesai" required {{ $disableTambah ? 'disabled' : '' }}>
                    </div>
                    <div class="col">
                        <input type="number" name="kapasitas" class="form-control" placeholder="Kapasitas" required {{ $disableTambah ? 'disabled' : '' }}>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary" {{ $disableTambah ? 'disabled style=background:#ccc;border-color:#ccc;cursor:not-allowed;' : '' }}>
                            Tambah
                        </button>
                    </div>
                </div>
            </form>
            @if($disableTambah)
                <div class="text-danger small mt-2">Jumlah sesi maksimal untuk jadwal ini adalah 2.</div>
            @endif
        </div>
    </div>

    {{-- List sesi dan room --}}
    @foreach ($jadwal->sesi as $sesi)
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                Sesi: <strong>{{ $sesi->nama_sesi }}</strong>
                ({{ $sesi->waktu_mulai }} - {{ $sesi->waktu_selesai }})
                | Kapasitas: <strong>{{ $sesi->kapasitas }}</strong>
            </span>
            <div>
                <a href="{{ route('admin.sesi.edit', $sesi->id_sesi) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.sesi.destroy', $sesi->id_sesi) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus sesi ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        </div>

        <div class="card-body">
            {{-- Form tambah room --}}
            <form action="{{ route('admin.room.storeRoom', $sesi->id_sesi) }}" method="POST">
                @csrf
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" name="nama_room" class="form-control" placeholder="Nama Room" required>
                    </div>
                    <div class="col">
                        <input type="text" name="zoom_id" class="form-control" placeholder="Zoom ID" required>
                    </div>
                    <div class="col">
                        <input type="text" name="zoom_password" class="form-control" placeholder="Zoom Password" required>
                    </div>
                    <div class="col">
                        <input type="number" name="kapasitas" class="form-control" placeholder="Kapasitas" required min="1">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Tambah Room</button>
                    </div>
                </div>
            </form>

            {{-- Daftar room --}}
            @if ($sesi->rooms->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mt-3">
                        <thead>
                            <tr>
                                <th>Nama Room</th>
                                <th>Zoom ID</th>
                                <th>Password</th>
                                <th>Kapasitas</th>
                                <th>Jumlah Peserta</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sesi->rooms as $room)
                            <tr>
                                <td>{{ $room->nama_room }}</td>
                                <td>{{ $room->zoom_id }}</td>
                                <td>{{ $room->zoom_password }}</td>
                                <td>{{ $room->kapasitas }}</td>
                                <td>{{ $room->peserta->count() }}</td>
                                <td>
                                    <a href="{{ route('admin.room.edit', $room->id_room) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.room.destroy', $room->id_room) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus room ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mt-3">Belum ada room pada sesi ini.</p>
            @endif
        </div>
    </div>
    @endforeach

    {{-- Tombol bagi peserta --}}
    @if($jadwal->sesi->count() > 0)
    <div class="mt-4">
        <button class="btn btn-success" onclick="bagiPeserta({{ $jadwal->id_jadwal }})">Bagi Peserta ke Sesi & Room</button>
    </div>
    @endif
</div>

<script>
    function bagiPeserta(idJadwal) {
        if (!confirm("Yakin ingin membagi peserta ke sesi & room?")) return;

        fetch(`/admin/sesi-jadwal/${idJadwal}/bagi-peserta`)
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) location.reload();
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat membagi peserta.');
            });
    }
</script>
@endsection
