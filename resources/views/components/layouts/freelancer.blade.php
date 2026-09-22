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


<body class="bg-[#F8FAF9] text-[#1F2937] antialiased">

    <div
        x-data="{ sidebarOpen: false }"
        class="min-h-screen"
    >

        {{-- =========================================================
            FREELANCER SIDEBAR
        ========================================================== --}}

        @include('components.navigation.freelancer-sidebar')


        {{-- =========================================================
            MAIN AREA
        ========================================================== --}}

        <div class="min-h-screen lg:ml-64">


            {{-- =====================================================
                TOPBAR
            ====================================================== --}}

            <header class="sticky top-0 z-30 h-20 border-b border-gray-200 bg-white">

                <div class="flex h-full items-center justify-between px-4 sm:px-6 lg:px-8">

                    {{-- Left --}}
                    <div class="flex items-center gap-3">

                        {{-- Mobile Sidebar Button --}}
                        <button
                            type="button"
                            @click="sidebarOpen = true"
                            class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-gray-600 transition hover:bg-gray-50 lg:hidden"
                            aria-label="Buka menu"
                        >

                            <i class="bi bi-list text-xl"></i>

                        </button>


                        {{-- Page Title --}}
                        <div>

                            <p class="text-sm text-gray-400">
                                {{ now()->translatedFormat('l, d F Y') }}
                            </p>

                            <h1 class="text-lg font-semibold text-gray-900">
                                {{ $title }}
                            </h1>

                        </div>

                    </div>


                    {{-- Right --}}
                    <div class="flex items-center gap-2 sm:gap-3">

                        {{-- Messages --}}
                        <a
                            href="{{ route('freelancer.messages.index') }}"
                            class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-gray-600 transition hover:bg-gray-50 hover:text-green-600"
                            title="Pesan"
                            aria-label="Pesan"
                        >

                            <i class="bi bi-chat text-lg"></i>

                        </a>


                        {{-- Notifications --}}
                        <div class="relative">

                            <x-notification-bell />

                        </div>


                        {{-- Divider --}}
                        <div class="hidden h-8 w-px bg-gray-200 sm:block"></div>


                        {{-- Avatar --}}
                        @php
                            $user = auth()->user();

                            $freelancerProfile = $user?->freelancerProfile;

                            $avatarUrl = $freelancerProfile?->avatar
                                ? asset('storage/' . $freelancerProfile->avatar)
                                : null;

                            $initial = strtoupper(
                                substr($user?->name ?: 'U', 0, 1)
                            );
                        @endphp

                        <a
                            href="{{ route('freelancer.profile.show') }}"
                            class="block h-10 w-10 shrink-0 overflow-hidden rounded-full bg-green-100 ring-1 ring-green-100 transition hover:ring-2 hover:ring-green-200"
                            title="Profil"
                        >

                            @if ($avatarUrl)

                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="{{ $user->name }}"
                                    class="block h-full w-full object-cover"
                                >

                            @else

                                <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-green-700">
                                    {{ $initial }}
                                </div>

                            @endif

                        </a>

                    </div>

                </div>

            </header>


            {{-- =====================================================
                CONTENT
            ====================================================== --}}

            <main class="p-4 sm:p-6 lg:p-8">

                {{ $slot }}

            </main>


            {{-- =====================================================
                FOOTER
            ====================================================== --}}

            @include('components.footer.freelancer')

        </div>

    </div>

</body>

</html>