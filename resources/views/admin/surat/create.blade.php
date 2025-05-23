<form action="{{ url('admin.surat.store') }}" method="POST" id="form-tambah-surat">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $page->title ?? 'Tambah Surat Pengajuan' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="NIM">NIM Mahasiswa</label>
                    <input type="text" name="NIM" id="NIM" class="form-control" required>
                    <small id="error-NIM" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="Tanggal_Pengajuan">Tanggal Pengajuan</label>
                    <input type="date" name="Tanggal_Pengajuan" id="Tanggal_Pengajuan" class="form-control" required>
                    <small id="error-Tanggal_Pengajuan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="Status_Verifikasi">Status Verifikasi</label>
                    <select name="Status_Verifikasi" id="Status_Verifikasi" class="form-control" required>
                        <option value="menunggu">Menunggu</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <small id="error-Status_Verifikasi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="Catatan">Catatan</label>
                    <textarea name="Catatan" id="Catatan" class="form-control" rows="3"></textarea>
                    <small id="error-Catatan" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $("#form-tambah-surat").validate({
        rules: {
            NIM: { required: true, minlength: 5, maxlength: 20 },
            Tanggal_Pengajuan: { required: true, date: true },
            Status_Verifikasi: { required: true },
            Catatan: { maxlength: 500 }
        },
        messages: {
            NIM: {
                required: "NIM wajib diisi",
                minlength: "NIM minimal 5 karakter",
                maxlength: "NIM maksimal 20 karakter"
            },
            Tanggal_Pengajuan: {
                required: "Tanggal pengajuan wajib diisi",
                date: "Format tanggal tidak valid"
            },
            Status_Verifikasi: {
                required: "Status verifikasi wajib dipilih"
            },
            Catatan: {
                maxlength: "Catatan maksimal 500 karakter"
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status){
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        $('#table_surat').DataTable().ajax.reload(null, false);
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function(field, messages) {
                            $('#error-' + field).text(messages[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server.'
                    });
                }
            });
            return false;
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
