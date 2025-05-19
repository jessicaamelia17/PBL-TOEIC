<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TOEIC Portal') }}</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

    @stack('css')
</head>
<body class="bg-blue-100 flex flex-col min-h-screen">

    {{-- Navbar --}}
    @include('layouts.navbar')

    
    
    {{-- Konten --}}
    <main class="flex-grow pt-24">
        {{-- Breadcrumb --}}
        @hasSection('breadcrumb')
            @yield('breadcrumb')
        @endif
        {{-- Tombol kembali --}}
        @hasSection('backbutton')
            @yield('backbutton')
        @endif
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer2')

    {{-- JS & jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    @stack('js')
</body>
</html>
