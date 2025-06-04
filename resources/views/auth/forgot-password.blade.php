{{-- filepath: resources/views/auth/forgot-password.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@lang('users.forgot_password') - TOEIC</title>
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
                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                    class="w-10 h-10 mr-3 rounded-full bg-white p-1 shadow" />
                <h2 class="text-2xl font-bold tracking-wide">TOEIC POLINEMA</h2>
            </div>
            <h3 class="text-3xl font-bold mb-2">@lang('users.forgot_password')</h3>
            <p class="mb-6 text-sm text-blue-100">@lang('users.forgot_password_desc')</p>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-200 bg-green-600 px-4 py-2 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-200 bg-red-600 px-4 py-2 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" id="email" required
                        placeholder="youremail@example.com"
                        class="w-full mt-1 p-3 rounded-lg text-black bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white shadow transition" />
                </div>
                <button type="submit"
                    class="w-full py-3 bg-white text-blue-700 font-semibold rounded-md hover:bg-gray-200 transition transform hover:scale-105">
                    @lang('users.send_reset_link')
                </button>
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-white underline hover:text-blue-200">
                        @lang('users.login')?
                    </a>
                </div>
            </form>
        </div>

        <!-- Image Section -->
        <div class="md:w-1/2 h-64 md:h-auto">
            <img src="{{ asset('images/gedung.png') }}" alt="Gedung" class="object-cover w-full h-full" />
        </div>
    </div>
</body>
</html>