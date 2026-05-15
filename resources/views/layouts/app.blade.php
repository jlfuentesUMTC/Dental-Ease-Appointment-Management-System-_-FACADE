<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DENTAL EASE')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    
    <style>
        /* Applying the fonts to Tailwind's utility pattern */
        :root {
            --font-main: 'Oswald', sans-serif;
            --font-body: 'Source Sans 3', sans-serif;
        }

        /* Global application */
        body {
            font-family: var(--font-body);
        }

        .font-display {
            font-family: var(--font-main);
        }

        .fade-in {
            animation: fadeInUp 480ms cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .fade-in-soft {
            animation: fadeInSoft 420ms ease-out both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInSoft {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    @auth
        <script>
            window.DentalEaseUser = {
                id: @json(Auth::id()),
            };
        </script>
    @endauth
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen text-gray-800 antialiased">
    @yield('content')
    @stack('scripts')
</body>
</html>
