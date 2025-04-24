<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Registrasi TOEIC</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <form action="{{ route('registrasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="text" name="Nama" placeholder="Nama" required
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <input type="text" name="Nim" placeholder="NIM" required
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <input type="text" name="No_WA" placeholder="No. WA" required
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <input type="text" name="email" placeholder="Email" required
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

    <!-- JavaScript for Dropdown Logic -->
    <script>
        document.getElementById('jurusan').addEventListener('change', function() {
            let jurusanId = this.value;
            fetch(`/get-prodi/${jurusanId}`)
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
    </script>
</body>

</html>
