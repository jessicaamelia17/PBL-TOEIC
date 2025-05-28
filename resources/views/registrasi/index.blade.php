@extends('layouts.app2')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white rounded-lg shadow-lg p-8 animate-fadeIn">
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Form Registrasi TOEIC</h2>
    @if($pendaftaran)
    <div class="p-6 bg-green-50 border border-green-200 rounded text-green-800 text-center">
        <h3 class="text-xl font-bold mb-2">Anda sudah terdaftar!</h3>
        <p>
            Tanggal ujian yang Anda dapatkan:
            <b>
                {{ \Carbon\Carbon::parse(optional($pendaftaran->jadwalUjian)->Tanggal_Ujian)->format('d-m-Y') }}
            </b>
        </p>
        <p class="mt-4">Silakan tunggu pengumuman sesi dan room melalui WhatsApp atau Email Anda.</p>
    </div>
@else
<div id="notification-container"></div>
    <!-- Form Registrasi -->
    <form id="registrasiForm" action="{{ route('mahasiswa.registrasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
    
        <input type="text" name="NIM" placeholder="NIM" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            value="{{ $mahasiswa->nim ?? '' }}" readonly />
    
        <input type="text" name="Nama" placeholder="Nama" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            value="{{ $mahasiswa->nama ?? '' }}" readonly />
    
        <input type="text" name="No_WA" placeholder="No. WA" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            value="{{ $mahasiswa->no_hp ?? '' }}" readonly />
    
        <input type="email" name="email" placeholder="Email" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            value="{{ $mahasiswa->email ?? '' }}" readonly />
           
    
            <input type="text" name="Nama_Jurusan" placeholder="Jurusan" 
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ optional($mahasiswa->jurusan)->Nama_Jurusan ?? '' }}" readonly />
            <input type="hidden" name="Id_Jurusan" value="{{ $mahasiswa->Id_Jurusan ?? '' }}" />
            
            <input type="text" name="Nama_Prodi" placeholder="Program Studi"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ optional($mahasiswa->prodi)->Nama_Prodi ?? '' }}" readonly />
            <input type="hidden" name="Id_Prodi" value="{{ $mahasiswa->Id_Prodi ?? '' }}" />
           
        <!-- File Uploads -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Scan KTP</label>
            <input type="file" name="Scan_KTP" required class="w-full px-3 py-2 border rounded" />
            <small class="text-gray-500">Format: jpg, jpeg, png. Maksimal 2MB.</small>
            <div>
                <img id="previewKtp" src="#" alt="Preview KTP" class="mt-2 rounded shadow max-h-40 hidden" />
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Scan KTM</label>
            <input type="file" name="Scan_KTM" required class="w-full px-3 py-2 border rounded" />
            <small class="text-gray-500">Format: jpg, jpeg, png. Maksimal 2MB.</small>
            <div>
                <img id="previewKtm" src="#" alt="Preview KTM" class="mt-2 rounded shadow max-h-40 hidden" />
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pas Foto</label>
            <input type="file" name="Pas_Foto" required class="w-full px-3 py-2 border rounded" />
            <small class="text-gray-500">Format: jpg, jpeg, png. Maksimal 2MB.</small>
            <div>
                <img id="previewFoto" src="#" alt="Preview Pas Foto" class="mt-2 rounded shadow max-h-40 hidden" />
            </div>
        </div>
    
        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition duration-200 font-bold">
            Daftar
        </button>
    </form>
@endif
    <!-- Notification Container -->
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
 // Validasi file upload langsung saat dipilih
 function validateFile(input, allowedTypes, maxSizeMB) {
        const file = input.files[0];
        if (!file) return true;
        const fileType = file.type;
        const fileSize = file.size / 1024 / 1024; // MB

        // Cek tipe file
        const validType = allowedTypes.some(type => fileType.includes(type));
        if (!validType) {
            Swal.fire('Error', 'Format file tidak didukung. Hanya jpg, jpeg, png.', 'error');
            input.value = '';
            return false;
        }

        // Cek ukuran file
        if (fileSize > maxSizeMB) {
            Swal.fire('Error', 'Ukuran file maksimal ' + maxSizeMB + 'MB.', 'error');
            input.value = '';
            return false;
        }
        // Cek ukuran file
        if (fileSize > maxSizeMB) {
            Swal.fire('Error', 'Ukuran file maksimal ' + maxSizeMB + 'MB.', 'error');
            input.value = '';
            return false;
        }
        return true;
    }
    function previewImage(input, previewId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    if (file && file.type.match('image.*')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.classList.add('hidden');
    }
}
    // Event listener untuk Scan KTP
    document.querySelector('input[name="Scan_KTP"]').addEventListener('change', function() {
        validateFile(this, ['jpg', 'jpeg', 'png'], 2);
        previewImage(this, 'previewKtp');
    });

    // Event listener untuk Scan KTM
    document.querySelector('input[name="Scan_KTM"]').addEventListener('change', function() {
        validateFile(this, ['jpg', 'jpeg', 'png'], 2);
        previewImage(this, 'previewKtm');
    });

    // Event listener untuk Pas Foto (letakkan di sini, bukan di dalam submit!)
    document.querySelector('input[name="Pas_Foto"]').addEventListener('change', function() {
        validateFile(this, ['jpg', 'jpeg', 'png'], 2);
        previewImage(this, 'previewFoto');
    });

    // Handle Form Submission
// ...existing code...

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
                    // Sembunyikan form
                    document.getElementById('registrasiForm').style.display = 'none';
                    // Tampilkan info jadwal dan penungguan sesi/room
                    const infoDiv = document.createElement('div');
                    infoDiv.className = 'mt-8 p-6 bg-green-50 border border-green-200 rounded text-green-800 text-center';
                    infoDiv.innerHTML = `
                        <h3 class="text-xl font-bold mb-2">Pendaftaran Berhasil!</h3>
                        <p>${data.message}</p>
                        <p class="mt-4">Silakan tunggu pengumuman sesi dan room melalui WhatsApp atau Email Anda.</p>
                    `;
                    document.querySelector('.max-w-xl').appendChild(infoDiv);
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

    fetch(`/mahasiswa/registrasi/check-nim/${nim}`)
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
