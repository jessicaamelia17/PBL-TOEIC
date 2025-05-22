<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Admin TOEIC</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-gray-100 via-white to-gray-200 min-h-screen flex items-center justify-center px-4">

  <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white shadow-2xl rounded-3xl overflow-hidden transition-all">
    
    <!-- Form Section -->
    <div class="md:w-1/2 bg-gradient-to-br from-blue-700 to-blue-500 text-white px-10 py-16 flex flex-col justify-center">
      <div class="flex items-center mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 mr-3 rounded-full bg-white p-1 shadow" />
        <h2 class="text-2xl font-bold tracking-wide">TOEIC</h2>
      </div>

      <h3 class="text-3xl font-bold mb-2">Admin Login</h3>
      <p class="mb-6 text-sm text-blue-100">Silakan masukkan username dan password Anda.</p>

      {{-- Alert status --}}
      @if (session('status'))
        <div class="mb-4 text-sm text-green-200 bg-green-600 px-4 py-2 rounded">
          {{ session('status') }}
        </div>
      @endif

      {{-- Error validation --}}
      @if ($errors->any())
        <div class="mb-4 text-sm text-red-200 bg-red-600 px-4 py-2 rounded">
          <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ url('/login') }}">
        @csrf

        {{-- Username --}}
        <div class="mb-4">
          <label for="username" class="block text-sm font-medium">Username</label>
          <input type="text" id="username" name="username" required placeholder="Enter your username"
            class="w-full mt-1 p-3 rounded-lg text-black bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white shadow transition" />
        </div>

        {{-- Password --}}
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium">Password</label>
          <input type="password" id="password" name="password" required placeholder="Enter your password"
            class="w-full mt-1 p-3 rounded-lg text-black bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white shadow transition" />
        </div>

        {{-- Show Password + Forgot --}}
        <div class="flex justify-between items-center text-sm mb-6">
          <label class="flex items-center text-white">
            <input type="checkbox" id="showPassword" class="mr-2"> Show Password
          </label>
          {{-- <a href="{{ route('admin.password.request') }}" class="text-white underline hover:text-blue-200">Forgot Password?</a> --}}
        </div>

        {{-- Submit --}}
        <button type="submit"
          class="w-full py-3 bg-white text-blue-700 font-semibold rounded-md hover:bg-gray-200 transition transform hover:scale-105">
          LOGIN
        </button>
      </form>
    </div>

    <!-- Image Section -->
    <div class="md:w-1/2 h-64 md:h-auto">
      <img src="{{ asset('images/gedung.png') }}" alt="Gedung" class="object-cover w-full h-full" />
    </div>
  </div>

  <script>
    document.getElementById('showPassword').addEventListener('change', function () {
      const passwordField = document.getElementById('password');
      passwordField.type = this.checked ? 'text' : 'password';
    });
  </script>
</body>
</html>