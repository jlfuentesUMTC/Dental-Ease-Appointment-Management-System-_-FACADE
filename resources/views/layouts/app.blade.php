<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DENTAL EASE')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal: #00C9C8;
            --teal-dark: #00A8A7;
            --teal-light: #E0FAFA;
            --navy: #0D1B2A;
        }
        * { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }
        .btn-teal {
            background: var(--teal);
            color: white;
            transition: all 0.2s ease;
        }
        .btn-teal:hover { background: var(--teal-dark); transform: translateY(-1px); box-shadow: 0 4px 15px rgba(0,201,200,0.35); }
        .text-teal { color: var(--teal); }
        .bg-teal { background: var(--teal); }
        .border-teal { border-color: var(--teal); }
        .bg-teal-light { background: var(--teal-light); }
        .ring-teal:focus { outline: none; box-shadow: 0 0 0 3px rgba(0,201,200,0.25); }
        .card { background: white; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,0.06); }
        .nav-link { transition: color 0.2s; }
        .nav-link:hover { color: var(--teal); }
        .status-confirmed { background: #DCFCE7; color: #16A34A; }
        .status-pending { background: #FEF9C3; color: #A16207; }
        .status-completed { background: #F3F4F6; color: #6B7280; }
        .status-progress { background: #DBEAFE; color: #1D4ED8; }
        .fade-in { animation: fadeIn 0.4s ease both; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0,201,200,0.15);
        }
        .scrollbar-thin::-webkit-scrollbar { width: 4px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 4px; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    @yield('content')
    @stack('scripts')
</body>
</html>