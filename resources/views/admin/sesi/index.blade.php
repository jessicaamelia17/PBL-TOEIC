@extends('layouts2.template')

@section('content')
<div class="container">
    <h3>Kelola Sesi dan Room untuk Jadwal Ujian: <strong>{{ $jadwal->tanggal_ujian }}</strong></h3>

    <!-- Tombol Bagi Peserta ke Sesi & Room -->
    <form action="{{ route('admin.jadwal.bagi-peserta', $jadwal->Id_Jadwal) }}" method="POST" class="mb-4">
        @csrf
        <button class="btn btn-warning" onclick="return confirm('Yakin ingin membagi peserta ke sesi dan room?')">
            Bagi Peserta ke Sesi & Room
        </button>
    </form>

    <!-- Tambah Sesi -->
    <form action="{{ route('admin.sesi.store', ['id' => $jadwal->Id_Jadwal]) }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col">
                <input type="text" name="nama_sesi" class="form-control" placeholder="Nama Sesi" required>
            </div>
            <div class="col">
                <input type="time" name="waktu_mulai" class="form-control" required>
            </div>
            <div class="col">
                <input type="time" name="waktu_selesai" class="form-control" required>
            </div>
            <div class="col">
                <button class="btn btn-primary">Tambah Sesi</button>
            </div>
        </div>
    </form>

    <!-- Menampilkan Sesi dan Room -->
    @foreach ($jadwal->sesi as $sesi)
    <div class="card mb-3">
        <div class="card-header">
            <strong>{{ $sesi->nama_sesi }}</strong> ({{ $sesi->waktu_mulai }} - {{ $sesi->waktu_selesai }})
        </div>
        <div class="card-body">
            <ul>
                @foreach ($sesi->rooms as $room)
                <li>
                    <strong>{{ $room->nama_room }}</strong> - Zoom ID: {{ $room->zoom_id }} | Password: {{ $room->zoom_password }} | Kapasitas: {{ $room->kapasitas }}
                </li>
                @endforeach
            </ul>

            <!-- Tambah Room -->
            <form action="{{ route('admin.room.store', $sesi->id_sesi) }}" method="POST" class="mt-3">
                @csrf
                <div class="row">
                    <div class="col">
                        <input type="text" name="nama_room" class="form-control" placeholder="Nama Room" required>
                    </div>
                    <div class="col">
                        <input type="text" name="zoom_id" class="form-control" placeholder="Zoom ID" required>
                    </div>
                    <div class="col">
                        <input type="text" name="zoom_password" class="form-control" placeholder="Password Zoom" required>
                    </div>
                    <div class="col">
                        <input type="number" name="kapasitas" class="form-control" placeholder="Kapasitas" required>
                    </div>
                    <div class="col">
                        <button class="btn btn-success">Tambah Room</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
