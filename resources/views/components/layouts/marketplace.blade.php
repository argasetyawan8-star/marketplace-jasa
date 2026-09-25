@props([
'title' => 'ProKerja — Marketplace Jasa',
])

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

<meta
    name="theme-color"
    content="#2563EB"
>

<title>
    {{ $title }}
</title>

@vite([
    'resources/css/app.css',
    'resources/js/app.js',
])


</head>

<body
    class="min-h-screen overflow-x-hidden bg-[#F8FAFC] text-[#0F172A] antialiased"
>
    {{-- =========================================================
        MARKETPLACE NAVBAR
        Satu navbar untuk Guest / Client / Freelancer / Admin.
    ========================================================== --}}
    @include('components.navigation.marketplace')


{{-- =========================================================
    MAIN CONTENT
    Mobile diberi ruang bawah agar bottom navbar tidak
    menutupi konten terakhir.
========================================================== --}}
<main
    class="min-h-screen pb-24 lg:pb-0"
>
    {{ $slot }}
</main>

{{-- =========================================================
    MARKETPLACE FOOTER
========================================================== --}}
<footer class="pb-20 lg:pb-0">
    @include('components.footer.marketplace')
</footer>


</body>

</html>
