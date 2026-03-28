<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Control Escolar')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f8fafc] text-[#1e293b] antialiased font-sans min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Main Content -->
    <main class="main-container">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>
