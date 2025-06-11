@extends('layouts2.template')
@section('content')

<div class="card mb-4">
    <div class="card-header bg-light">
        <h4 class="mb-0">Selamat datang, <strong>Admin {{ session('admin_Nama') ?? session('admin_Username') }}</strong></h4>
    </div>
</div>

{{-- Kartu Statistik --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-success shadow-sm">
            <div class="card-header"><i class="fas fa-boxes"></i> Kuota Tersedia</div>
            <div class="card-body text-center">
                <h2 id="kuota-terpakai">{{ $kuota }}</h2>
                <p>Total kuota pendaftaran</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-primary shadow-sm">
            <div class="card-header"><i class="fas fa-users"></i> Total Pendaftar</div>
            <div class="card-body text-center">
                <h2>{{ $pendaftar }}</h2>
                <p>Orang telah mendaftar TOEIC</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger shadow-sm">
            <div class="card-header"><i class="fas fa-user-minus"></i> Sisa Kuota</div>
            <div class="card-body text-center">
                <h2 id="sisa-kuota">{{ $kuota - $pendaftar }}</h2>
                <p>Kuota yang masih tersedia</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Form Ubah Kuota --}}
    <div class="col-md-6 mb-4">
        <form id="form-kuota">
            @csrf
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <strong>Ubah Kuota Pendaftaran</strong>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="jumlah_kuota" class="form-label">Jumlah Kuota:</label>
                        <input type="number" name="jumlah_kuota" id="jumlah_kuota" class="form-control" value="{{ $kuota }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <div id="kuota-message" class="mt-2 text-success fw-semibold" style="display: none;"></div>
                </div>
            </div>
        </form>
    </div>

    {{-- Status Pendaftaran --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <strong>Status Pendaftaran TOEIC</strong>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="fw-semibold">Status saat ini:</span>
                        <span id="status-pendaftaran" class="badge {{ $status_pendaftaran ? 'bg-success' : 'bg-danger' }} fs-6 px-3 py-2">
                            {{ $status_pendaftaran ? 'DIBUKA' : 'DITUTUP' }}
                        </span>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button id="btn-buka" class="btn btn-success" {{ $status_pendaftaran ? 'disabled' : '' }}>
                        <i class="fas fa-door-open"></i> Buka Pendaftaran
                    </button>
                    <button id="btn-tutup" class="btn btn-danger" {{ !$status_pendaftaran ? 'disabled' : '' }}>
                        <i class="fas fa-door-closed"></i> Tutup Pendaftaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- jQuery dan script --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function () {
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
                    alert('Gagal memperbarui kuota. Coba lagi.');
                }
            });
        });

        $('#btn-buka').click(function () {
            $.post("{{ route('admin.kuota.updateStatus') }}", {
                _token: '{{ csrf_token() }}',
                status_pendaftaran: 1
            }, function() {
                $('#status-pendaftaran').removeClass('bg-danger').addClass('bg-success').text('DIBUKA');
                $('#btn-buka').prop('disabled', true);
                $('#btn-tutup').prop('disabled', false);
            });
        });

        $('#btn-tutup').click(function () {
            $.post("{{ route('admin.kuota.updateStatus') }}", {
                _token: '{{ csrf_token() }}',
                status_pendaftaran: 0
            }, function() {
                $('#status-pendaftaran').removeClass('bg-success').addClass('bg-danger').text('DITUTUP');
                $('#btn-buka').prop('disabled', false);
                $('#btn-tutup').prop('disabled', true);
            });
        });
    });
</script>

@endsection
