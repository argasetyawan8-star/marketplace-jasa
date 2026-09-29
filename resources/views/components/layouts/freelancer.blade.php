@props(['title' => 'Dashboard Freelancer'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $title }} - ProKerja
    </title>

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>


<body class="min-h-screen bg-[#F8FAFC] text-slate-700 antialiased">

    {{-- =========================================================
        MARKETPLACE NAVIGATION
    ========================================================== --}}
    @include('components.navigation.marketplace')


    {{-- =========================================================
        MAIN CONTENT
        Navbar marketplace sudah memiliki spacer:
        - Mobile  : 64px
        - Desktop : 72px
    ========================================================== --}}
    <main class="min-h-screen pb-24 lg:pb-8">

        {{ $slot }}

    </main>


    {{-- =========================================================
        FOOTER MARKETPLACE
    ========================================================== --}}
    @include('components.footer.marketplace')


</body>
</html>