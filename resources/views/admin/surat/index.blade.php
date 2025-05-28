
                                   {{-- filepath: resources/views/admin/surat/index.blade.php --}}
@extends('layouts2.template')

@section('title', 'Daftar Pengajuan Surat TOEIC')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h3 class="card-title mb-0">Daftar Pengajuan Surat TOEIC</h3>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_pengajuan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Sertifikat</th>
                        <th>Tanggal Verifikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->mahasiswa->nama }}</td>
                            <td>{{ $item->mahasiswa->nim }}</td>
                            <td>{{ $item->mahasiswa->prodi->Nama_Prodi }}</td>
                            <td>{{ $item->tanggal_pengajuan }}</td>
                            <td>
                                @if ($item->status_verifikasi == 'disetujui')
                                    <span class="badge badge-success text-capitalize">diterima</span>
                                @elseif ($item->status_verifikasi == 'ditolak')
                                    <span class="badge badge-danger text-capitalize">ditolak</span>
                                @else
                                    <span class="badge badge-warning text-capitalize">baru</span>
                                @endif
                            </td>

                            <td>
                                @if($item->file_sertifikat)
                                <button type="button" class="btn btn-info btn-sm" onclick="lihatSertifikat('{{ asset('storage/' . $item->file_sertifikat) }}')">
                                    Lihat Sertifikat
                                </button>
                            @else
                                <span class="text-muted">Belum ada file</span>
                            @endif
                            </td>
                            <td>
                                @if($item->tanggal_verifikasi)
                                    {{ \Carbon\Carbon::parse($item->tanggal_verifikasi)->format('d-m-Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status_verifikasi == 'menunggu')
                                    <form action="{{ route('admin.surat.update_status', $item->id_surat) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status_verifikasi" value="disetujui">
                                        <button type="button" class="btn btn-sm btn-success mb-1 btn-verifikasi" data-status="disetujui" data-id="{{ $item->id_surat }}">
                                            Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.surat.update_status', $item->id_surat) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status_verifikasi" value="ditolak">
                                        <button type="button" class="btn btn-sm btn-danger mb-1 btn-verifikasi" data-status="ditolak" data-id="{{ $item->id_surat }}">
                                            Tolak
                                        </button>
                                    </form>
                                @elseif ($item->status_verifikasi == 'ditolak' && $item->catatan)
                                    <span class="badge badge-danger">Ditolak</span>
                                    <br>
                                    <small class="text-danger"><b>Catatan:</b> {{ $item->catatan }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada pengajuan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <form id="formVerifikasi" method="POST" style="display:none;">
                @csrf
                <input type="hidden" name="status_verifikasi" id="inputStatusVerifikasi">
                <input type="hidden" name="catatan" id="inputCatatan">
            </form>
<!-- Modal Sertifikat -->
<div class="modal fade" id="modalSertifikat" tabindex="-1" role="dialog" aria-labelledby="modalSertifikatLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSertifikatLabel">Sertifikat Mahasiswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center" id="sertifikatContainer">
          <!-- Sertifikat akan tampil di sini -->
        </div>
      </div>
    </div>
  </div>
        </div>
    </div>
    @push('js')
<script>
$('.btn-verifikasi').on('click', function() {
    var status = $(this).data('status');
    var id = $(this).data('id');
    var text = status === 'disetujui' ? 'Setujui pengajuan ini?' : 'Tolak pengajuan ini?';
    var confirmButton = status === 'disetujui' ? 'Ya, Setujui' : 'Ya, Tolak';
    var confirmColor = status === 'disetujui' ? '#28a745' : '#dc3545';

    if(status === 'ditolak') {
        Swal.fire({
            title: 'Tolak Pengajuan',
            text: 'Masukkan alasan penolakan untuk mahasiswa:',
            input: 'textarea',
            inputPlaceholder: 'Tulis alasan penolakan di sini...',
            inputAttributes: {
                'aria-label': 'Alasan penolakan'
            },
            showCancelButton: true,
            confirmButtonText: confirmButton,
            confirmButtonColor: confirmColor,
            cancelButtonText: 'Batal',
            reverseButtons: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'Catatan penolakan wajib diisi!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('#formVerifikasi');
                form.attr('action', '/admin/surat/' + id + '/update_status');
                $('#inputStatusVerifikasi').val(status);
                $('#inputCatatan').val(result.value);
                form.submit();
            }
        });
    } else {
        Swal.fire({
            title: 'Konfirmasi',
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: confirmButton,
            confirmButtonColor: confirmColor,
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('#formVerifikasi');
                form.attr('action', '/admin/surat/' + id + '/update_status');
                $('#inputStatusVerifikasi').val(status);
                $('#inputCatatan').val('');
                form.submit();
            }
        });
    }
});
function lihatSertifikat(url) {
    var ext = url.split('.').pop().toLowerCase();
    var html = '';
    if(ext === 'pdf') {
        html = `<iframe src="${url}" width="100%" height="500px"></iframe>`;
    } else if(['jpg','jpeg','png','gif','bmp','webp'].includes(ext)) {
        html = `<img src="${url}" alt="Sertifikat" class="img-fluid" />`;
    } else {
        html = `<a href="${url}" target="_blank">Download Sertifikat</a>`;
    }
    $('#sertifikatContainer').html(html);
    $('#modalSertifikat').modal('show');
}
</script>
@endpush
@endsection
                               