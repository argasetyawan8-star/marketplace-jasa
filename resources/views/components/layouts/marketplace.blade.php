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
@auth
    @if(auth()->user()->role === 'client')
        {{-- Client memakai navbar yang sama di seluruh area Client --}}
        <x-navigation.client />
    @else
        {{-- Freelancer tetap memakai navbar marketplace --}}
        @include('components.navigation.marketplace')
    @endif
@else
    {{-- Guest tetap memakai navbar marketplace --}}
    @include('components.navigation.marketplace')
@endauth

{{-- Main --}}
<main class="min-h-[calc(100vh-64px)]">
    {{ $slot }}
</main>

{{-- Footer --}}
@include('components.footer.marketplace')


</body>

</html>
