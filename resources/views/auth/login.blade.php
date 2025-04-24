<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login UPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="flex w-full max-w-5xl h-[500px] rounded-xl shadow-lg overflow-hidden">
        <!-- Kiri: Form Login -->
        <div class="w-1/2 bg-blue-600 p-8 flex flex-col justify-center items-center text-white">
            <h2 class="text-3xl font-bold mb-6">Login</h2>
            <form method="POST" action="{{ route('login') }}" class="w-full">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" class="w-full mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Email" required>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" class="w-full mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Password" required>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <input type="checkbox" id="remember" name="remember" class="text-blue-600">
                        <label for="remember" class="text-sm text-white ml-2">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-sm text-white">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 focus:outline-none">Login</button>
            </form>
        </div>

        <!-- Kanan: Gambar / Konten -->
        <div class="w-1/2 bg-cover bg-center" style="background-image: url('https://via.placeholder.com/600x500');">
            <!-- Image or other content can go here -->
        </div>
    </div>
</body>

</html>
