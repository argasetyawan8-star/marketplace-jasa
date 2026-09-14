@props(['title' => 'Marketplace Jasa'])

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
        {{ $title }} — JASAIN
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-[#F8FAF9] text-[#1F2937] antialiased">

    {{-- Navbar --}}
    @include('components.navigation.marketplace')


    {{-- Main --}}
    <main class="min-h-[calc(100vh-64px)]">

        {{ $slot }}

    </main>


    {{-- Footer --}}
    @include('components.footer.marketplace')

</body>

</html>