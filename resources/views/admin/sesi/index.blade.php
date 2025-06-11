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
    
    {{-- Judul halaman dalam kotak, tanggal & tombol kembali di kanan --}}
    <div class="card card-outline card-primary">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="mb-1 font-weight-bold" style="font-size:1.5rem;">
                    {{ $breadcrumb->title }}
                </h4>
                <div class="text-muted" style="font-size:1.1rem;">
                    Tanggal Ujian: <b>{{ $jadwal->Tanggal_Ujian }}</b>
                </div>
            </div>
            
        </div>
    </div>
    <div class="text-muted" style="font-size:1.1rem;">
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary btn-sm mt-2 mt-md-0">
            <i class="fa fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    {{-- Tombol aksi utama --}}
    @if($jadwal->sesi->count() > 0)
    <div class="d-flex flex-wrap align-items-center my-4">
        <button class="btn btn-success mb-2 mr-2" onclick="bagiPeserta({{ $jadwal->id_jadwal }})">
            Bagi Peserta ke Sesi & Room
        </button>
        <form action="{{ route('admin.sesi-jadwal.reset', $jadwal->id_jadwal) }}" method="POST" class="d-inline" id="form-reset">
            @csrf
            <button type="button" class="btn btn-danger mb-2 mr-2" onclick="konfirmasiReset()">Reset Pembagian Peserta</button>
        </form>        
        <a href="{{ route('admin.sesi-jadwal.pembagian', $jadwal->id_jadwal) }}" class="btn btn-info mb-2">
            Lihat Pembagian Peserta
        </a>
    </div>
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

</div>

<script>
function bagiPeserta(idJadwal) {
    Swal.fire({
        title: 'Bagikan Peserta?',
        text: 'Peserta akan dibagikan ke sesi & room secara otomatis.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, lanjutkan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/sesi-jadwal/${idJadwal}/bagi-peserta`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                Swal.fire({
                    title: data.success ? 'Berhasil' : 'Gagal',
                    text: data.message,
                    icon: data.success ? 'success' : 'error',
                }).then(() => {
                    if (data.success) location.reload();
                });
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Terjadi kesalahan saat membagi peserta.', 'error');
            });
        }
    });
}
function konfirmasiReset() {
    Swal.fire({
        title: 'Reset Pembagian?',
        text: 'Seluruh pembagian peserta ke sesi dan room akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, reset',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-reset').submit();
        }
    });
}


</script>
@endsection
