<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TOEIC Portal') }}</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Bootstrap (jika dibutuhkan) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Di bagian <head> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Custom Tailwind config --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        fadeIn: "fadeIn 1s ease-in-out",
                        grow: "grow 0.3s ease-in-out",
                        slideUp: "slideUp 0.5s ease-in-out"
                    },
                    keyframes: {
                        fadeIn: {
                            "0%": { opacity: "0" },
                            "100%": { opacity: "1" }
                        },
                        grow: {
                            "0%": { transform: "scale(1)" },
                            "100%": { transform: "scale(1.05)" }
                        },
                        slideUp: {
                            "0%": { transform: "translateY(50px)", opacity: "0" },
                            "100%": { transform: "translateY(0)", opacity: "1" }
                        }
                    }
                }
            }
        };
    </script>
    {{-- Di bagian bawah sebelum </body> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    @stack('css')
</head>
<body class="bg-blue-100">

    {{-- Navbar --}}
    @include('layouts.navbar')

    {{-- Breadcrumb --}}
    @includeWhen(View::hasSection('breadcrumb'), 'layouts.breadcrumb')

    {{-- Konten --}}
    <main class="pt-28">
        @yield('content')
    </main>

    {{-- Tombol kembali --}}
    @includeWhen(View::hasSection('backbutton'), 'layouts.backbutton')

    {{-- Footer --}}
    @include('layouts.footer2')

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('js')
</body>
</html>
