<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TOEIC Portal') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- DataTables CSS -->
   <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>

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
                            "0%": {
                                opacity: "0"
                            },
                            "100%": {
                                opacity: "1"
                            }
                        },
                        grow: {
                            "0%": {
                                transform: "scale(1)"
                            },
                            "100%": {
                                transform: "scale(1.05)"
                            }
                        },
                        slideUp: {
                            "0%": {
                                transform: "translateY(50px)",
                                opacity: "0"
                            },
                            "100%": {
                                transform: "translateY(0)",
                                opacity: "1"
                            }
                        }
                    }
                }
            }
        };
    </script>

    @stack('css')
</head>

<body class="bg-blue-100 min-h-screen flex flex-col">

    {{-- Navbar --}}
    @include('layouts.navbar')



    {{-- Konten --}}
    <main class="flex-grow pt-24 pb-24" >
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
<!-- jQuery (gunakan satu versi saja, misal 3.7.1) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS & CSS (gunakan satu versi saja, misal 1.13.7) -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    @stack('js')
</body>

</html>
