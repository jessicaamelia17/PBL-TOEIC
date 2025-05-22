@extends('layouts.app2')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white rounded-lg shadow-lg p-8 animate-fadeIn">
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Form Registrasi TOEIC</h2>

    <!-- Notification Container -->
    <div id="notification-container"></div>

    <!-- Form -->
    <form id="registrasiForm" action="{{ route('mahasiswa.registrasi.store') }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        <input type="text" name="NIM" placeholder="NIM" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <input type="text" name="Nama" placeholder="Nama" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <input type="text" name="No_WA" placeholder="No. WA" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <input type="email" name="email" placeholder="Email" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />

        <!-- Dropdown for Jurusan -->
        <select name="Id_Jurusan" id="jurusan" class="w-full border rounded px-4 py-2">
            <option value="">Pilih Jurusan</option>
            @foreach ($jurusan as $j)
                <option value="{{ $j->Id_Jurusan }}">{{ $j->Nama_Jurusan }}</option>
            @endforeach
        </select>

        <!-- Dropdown for Program Studi -->
        <select name="Id_Prodi" id="prodi" class="w-full border rounded px-4 py-2 mt-4">
            <option value="">Pilih Program Studi</option>
        </select>

        <!-- File Uploads -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Scan KTP</label>
            <input type="file" name="Scan_KTP" required class="w-full px-3 py-2 border rounded" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Scan KTM</label>
            <input type="file" name="Scan_KTM" required class="w-full px-3 py-2 border rounded" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pas Foto</label>
            <input type="file" name="Pas_Foto" required class="w-full px-3 py-2 border rounded" />
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition duration-200 font-bold">
            Daftar
        </button>
    </form>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Handle Jurusan-Prodi Dropdown
    document.getElementById('jurusan').addEventListener('change', function () {
        let jurusanId = this.value;
        fetch(`/registrasi/get-prodi/${jurusanId}`)
            .then(response => response.json())
            .then(data => {
                let prodiSelect = document.getElementById('prodi');
                prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
                data.forEach(function (prodi) {
                    prodiSelect.innerHTML +=
                        `<option value="${prodi.Id_Prodi}">${prodi.Nama_Prodi}</option>`;
                });
            });
    });

    // Handle Form Submission
    document.getElementById('registrasiForm').addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Memproses pendaftaran',
            html: 'Mohon tunggu sebentar...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pendaftaran Berhasil!',
                        text: data.message,
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded'
                        }
                    }).then(() => {
                        document.getElementById('registrasiForm').reset();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Terjadi kesalahan saat pendaftaran'
                    });
                }
            })
            .catch(error => {
                let errorMessage = 'Terjadi kesalahan saat mengirim data';
                if (error.errors) {
                    errorMessage = Object.values(error.errors).join('<br>');
                } else if (error.message) {
                    errorMessage = error.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorMessage
                });
                console.error('Error:', error);
            });
    });

    // Cek NIM duplikat saat input berubah
document.querySelector('input[name="NIM"]').addEventListener('blur', function () {
    const nimInput = this;
    const nim = nimInput.value.trim();
    if (nim === '') return;

    fetch(`/registrasi/check-nim/${nim}`)
        .then(response => response.json())
        .then(data => {
            if (!data.available) {
                Swal.fire({
                    icon: 'warning',
                    title: 'NIM sudah digunakan',
                    text: 'Silakan gunakan NIM lain.',
                });
                nimInput.classList.add('border-red-500');
            } else {
                nimInput.classList.remove('border-red-500');
            }
        })
        .catch(error => {
            console.error('Error checking NIM:', error);
        });
});

</script>
@endpush
