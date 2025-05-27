<form id="form-tambah-mahasiswa" action="{{ route('admin.mahasiswa.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>NIM</label>
        <input type="text" name="nim" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Jurusan</label>
        <select name="Id_Jurusan" id="select-jurusan" class="form-control" required>
            <option value="">Pilih Jurusan</option>
            @foreach ($jurusans as $jurusan)
                <option value="{{ $jurusan->Id_Jurusan }}">{{ $jurusan->Nama_Jurusan }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Prodi</label>
        <select name="Id_Prodi" id="select-prodi" class="form-control" required>
            <option value="">Pilih Prodi</option>
            {{-- Prodi akan diisi via AJAX --}}
        </select>
    </div>
    <div class="form-group">
        <label>No HP</label>
        <input type="text" name="no_hp" class="form-control">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script>
    $(document).ready(function() {
        $('#select-jurusan').on('change', function() {
            var jurusanId = $(this).val();
            $('#select-prodi').html('<option value="">Memuat...</option>');
            if (jurusanId) {
                $.get("{{ url('admin/mahasiswa/get-prodi') }}/" + jurusanId, function(data) {
                    var options = '<option value="">Pilih Prodi</option>';
                    $.each(data, function(i, prodi) {
                        options += '<option value="' + prodi.Id_Prodi + '">' + prodi
                            .Nama_Prodi + '</option>';
                    });
                    $('#select-prodi').html(options);
                });
            } else {
                $('#select-prodi').html('<option value="">Pilih Prodi</option>');
            }
        });
    });
</script>
