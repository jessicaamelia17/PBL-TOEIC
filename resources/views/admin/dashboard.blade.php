@extends('layouts2.template')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Halo</h3>
        <div class="card-tools"></div>
    </div>
    <h1>Selamat datang, {{ session('admin_username') }}</h1>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3" style="height: 150px;">
            <div class="card-header">
                <i class="fas fa-boxes"></i> Kuota Tersedia:
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-4" id="kuota-terpakai">{{ $kuota }}</h1>
                <p class="mb-0">Total kuota pendaftaran</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3" style="height: 150px;">
            <div class="card-header">
                <i class="fas fa-users"></i> Total Pendaftar TOEIC:
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-4">{{ $pendaftar }}</h1>
                <p class="mb-0">Orang telah mendaftar TOEIC</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-danger mb-3" style="height: 150px;">
            <div class="card-header">
                <i class="fas fa-user-minus"></i> Sisa Kuota:
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-4" id="sisa-kuota">{{ $kuota - $pendaftar }}</h1>
                <p class="mb-0">Kuota yang masih tersedia</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <form id="form-kuota">
            @csrf
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <strong>Ubah Kuota Pendaftaran</strong>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="jumlah_kuota">Jumlah Kuota:</label>
                        <input type="number" name="jumlah_kuota" id="jumlah_kuota" class="form-control" value="{{ $kuota }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Simpan Perubahan</button>
                    <div id="kuota-message" class="mt-2 text-success" style="display: none;"></div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="mt-4 mb-5">
    <h4 class="fw-bold text-uppercase">Status Pendaftaran TOEIC</h4>

    {{-- Badge status --}}
    <span id="status-pendaftaran" class="badge {{ $status_pendaftaran ? 'bg-success' : 'bg-danger' }} px-3 py-2 fs-5">
        {{ $status_pendaftaran ? 'DIBUKA' : 'DITUTUP' }}
    </span>

    {{-- Tombol buka/tutup --}}
    <div class="mt-3 d-flex gap-2">
        <button id="btn-buka" class="btn btn-success fw-semibold" disabled>Buka Pendaftaran</button>
        <button id="btn-tutup" class="btn btn-danger fw-semibold">Tutup Pendaftaran</button>
    </div>
</div>

{{-- jQuery dan script --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Form ubah kuota
        $('#form-kuota').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.kuota.update') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    $('#kuota-message').text(response.message).show();

                    const total = parseInt($('#jumlah_kuota').val());
                    const pendaftar = {{ $pendaftar }};
                    const sisa = total - pendaftar;

                    $('#sisa-kuota').text(sisa);
                    $('#kuota-terpakai').text(total);
                },
                error: function(xhr) {
                    console.error(xhr.status, xhr.responseText);
                    alert('Gagal memperbarui kuota. Coba lagi.');
                }
            });
        });

        // Tombol buka pendaftaran
                $('#btn-buka').click(function () {
            $.post("{{ route('admin.kuota.updateStatus') }}", {
                _token: '{{ csrf_token() }}',
                status_pendaftaran: 1
            }, function(response) {
                $('#status-pendaftaran')
                    .removeClass('bg-danger')
                    .addClass('bg-success')
                    .text('DIBUKA');
                $('#btn-buka').prop('disabled', true);
                $('#btn-tutup').prop('disabled', false);
            });
        });

        $('#btn-tutup').click(function () {
            $.post("{{ route('admin.kuota.updateStatus') }}", {
                _token: '{{ csrf_token() }}',
                status_pendaftaran: 0
            }, function(response) {
                $('#status-pendaftaran')
                    .removeClass('bg-success')
                    .addClass('bg-danger')
                    .text('DITUTUP');
                $('#btn-buka').prop('disabled', false);
                $('#btn-tutup').prop('disabled', true);
            });
        });
    });
</script>

@endsection
