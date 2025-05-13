<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Pendaftar: {{ $pendaftar->Nama }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span>&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <table class="table table-striped">
                <tr>
                    <th>NIM</th>
                    <td>{{ $pendaftar->NIM }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $pendaftar->Nama }}</td>
                </tr>
                <tr>
                    <th>No. WA</th>
                    <td>{{ $pendaftar->No_WA }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $pendaftar->email }}</td>
                </tr>
                <tr>
                    <th>Jurusan</th>
                    <td>{{ $pendaftar->jurusan->Nama_Jurusan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Prodi</th>
                    <td>{{ $pendaftar->prodi->Nama_Prodi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Scan KTP</th>
                    <td><img src="/storage/{{ $pendaftar->Scan_KTP }}" class="img-fluid" alt="Scan KTP" /></td>
                </tr>
                <tr>
                    <th>Scan KTM</th>
                    <td><img src="/storage/{{ $pendaftar->Scan_KTM }}" class="img-fluid" alt="Scan KTM" /></td>
                </tr>
                <tr>
                    <th>Pas Foto</th>
                    <td><img src="/storage/{{ $pendaftar->Pas_Foto }}" class="img-fluid" alt="Pas Foto" /></td>
                </tr>
                <tr>
                    <th>Tanggal Pendaftaran</th>
                    <td>{{ $pendaftar->Tanggal_Pendaftaran }}</td>
                </tr>
            </table>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
