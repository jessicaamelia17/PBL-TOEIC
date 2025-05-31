<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Pendaftar: {{ $pendaftar->nama }}</h5>
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
                    <td>{{ $pendaftar->mahasiswa->nama }}</td>
                </tr>
                <tr>
                    <th>No. HP</th>
                    <td>{{ $pendaftar->mahasiswa->no_hp }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $pendaftar->mahasiswa->email }}</td>
                </tr>
                <tr>
                    <th>Jurusan</th>
                    <td>{{ $pendaftar->mahasiswa->jurusan->Nama_Jurusan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Prodi</th>
                    <td>{{ $pendaftar->mahasiswa->prodi->Nama_Prodi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pendaftaran</th>
                    <td>{{ $pendaftar->Tanggal_Pendaftaran }}</td>
                </tr>
                <tr>
                    <th>Jadwal Ujian</th>
                    <td>{{ $pendaftar->jadwal_ujian->Tanggal_Ujian ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Scan KTP</th>
                    <td>
                        @if($pendaftar->Scan_KTP)
                            <img src="/storage/{{ $pendaftar->Scan_KTP }}" class="img-fluid" alt="Scan KTP" />
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Scan KTM</th>
                    <td>
                        @if($pendaftar->Scan_KTM)
                            <img src="/storage/{{ $pendaftar->Scan_KTM }}" class="img-fluid" alt="Scan KTM" />
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Pas Foto</th>
                    <td>
                        @if($pendaftar->Pas_Foto)
                            <img src="/storage/{{ $pendaftar->Pas_Foto }}" class="img-fluid" alt="Pas Foto" />
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>