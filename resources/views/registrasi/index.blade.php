<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Registrasi TOEIC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup {
            font-size: 1.1rem !important;
        }

        .swal2-title {
            font-size: 1.5rem !important;
        }
    </style>
</head>

<body class="bg-blue-100">
    <!-- Header Navigation -->
    <nav
        class="bg-blue-600 text-white py-4 px-6 flex justify-between items-center fixed w-[95%] shadow-lg z-10 rounded-full left-1/2 transform -translate-x-1/2 top-2">
        <div class="flex items-center bg-white px-4 py-2 rounded-full">
            <img src="{{ asset('polinema.png') }}" alt="TOEIC Logo" class="h-8 mr-3" />
            <h1 class="text-2xl font-bold text-blue-600">TOEIC</h1>
        </div>
        <ul class="flex space-x-6">
            <li><a href="#" class="hover:underline">Home</a></li>
            <li><a href="#" class="hover:underline">Registration</a></li>
            <li><a href="#" class="hover:underline">Schedule</a></li>
            <li><a href="#" class="hover:underline">Results</a></li>
            <li><a href="#" class="hover:underline">Guide</a></li>
            <li><a href="#" class="hover:underline">Contact</a></li>
        </ul>
    </nav>

    <!-- Form Container -->
    <div class="max-w-xl mx-auto mt-40 bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Form Registrasi TOEIC</h2>

        <!-- Notification Container -->
        <div id="notification-container"></div>

        <!-- Form -->
        <form id="registrasiForm" action="{{ route('registrasi.store') }}" method="POST" enctype="multipart/form-data"
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

    <!-- Footer -->
    <footer class="bg-blue-600 text-white rounded-t-lg mt-16">
        <div class="max-w-screen-xl mx-auto px-4 py-6 text-center">
            <p class="text-sm">&copy; 2025 TOEIC. All rights reserved.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Handle Jurusan-Prodi Dropdown
        document.getElementById('jurusan').addEventListener('change', function() {
            let jurusanId = this.value;
            fetch(`/registrasi/get-prodi/${jurusanId}`) // Perhatikan perubahan URL disini
                .then(response => response.json())
                .then(data => {
                    let prodiSelect = document.getElementById('prodi');
                    prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
                    data.forEach(function(prodi) {
                        prodiSelect.innerHTML +=
                            `<option value="${prodi.Id_Prodi}">${prodi.Nama_Prodi}</option>`;
                    });
                });
        });

        // Handle Form Submission
        document.getElementById('registrasiForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading indicator
            Swal.fire({
                title: 'Memproses pendaftaran',
                html: 'Mohon tunggu sebentar...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Prepare form data
            let formData = new FormData(this);

            // Send data via AJAX
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
                        return response.json().then(err => {
                            throw err;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Show success popup
                        Swal.fire({
                            icon: 'success',
                            title: 'Pendaftaran Berhasil!',
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded'
                            }
                        }).then(() => {
                            // Reset form after success
                            document.getElementById('registrasiForm').reset();

                            // Optional: Redirect or other action
                            // window.location.href = '/somewhere';
                        });
                    } else {
                        // Show error message
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
    </script>
</body>

</html>
