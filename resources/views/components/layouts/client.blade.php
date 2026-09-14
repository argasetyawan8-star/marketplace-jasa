@props(['title' => 'Dashboard Client'])

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
        {{ $title }} - JASAIN
    </title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-[#F8FAF9] text-[#1F2937] antialiased">

    {{-- Navbar --}}
    @include('components.navigation.client')


    {{-- Main Content --}}
    <main class="min-h-[calc(100vh-80px)]">

        {{ $slot }}

    </main>


    {{-- Footer --}}
    @include('components.footer.client')

</body>

</html>