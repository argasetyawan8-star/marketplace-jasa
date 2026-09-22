@props(['title' => 'Admin'])

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        darkMode: localStorage.getItem('jasain-theme') === 'dark'
    }"
    :class="{ 'dark': darkMode }"
>

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

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

</head>


<body
    class="min-h-screen bg-[#F8FCF9] text-[#123128] antialiased transition-colors duration-200 dark:bg-[#0B1511] dark:text-[#E7F2EC]"
>

    <div
        x-data="{ sidebarOpen: false }"
        class="min-h-screen"
    >

        {{-- =========================================================
            MOBILE OVERLAY
        ========================================================== --}}

        <div
            x-show="sidebarOpen"
            x-transition.opacity
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/20 dark:bg-black/50 lg:hidden"
        ></div>


        {{-- =========================================================
            SIDEBAR
        ========================================================== --}}

        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-[#DCE9E2] bg-white transition-transform duration-200 dark:border-[#263B31] dark:bg-[#111F18] lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >

            {{-- =====================================================
                LOGO
            ====================================================== --}}

            <div
                class="flex h-[72px] shrink-0 items-center border-b border-[#E7EFEA] px-5 dark:border-[#263B31]"
            >

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3"
                >

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#0F6B3A] text-lg font-semibold text-white dark:bg-[#1E9E5A]"
                    >
                        J
                    </div>

                    <div>

                        <p
                            class="text-base font-semibold tracking-tight text-[#123128] dark:text-[#E7F2EC]"
                        >
                            JASAIN
                        </p>

                        <p
                            class="text-[11px] font-medium text-[#8A9B94] dark:text-[#8FA69A]"
                        >
                            Admin Panel
                        </p>

                    </div>

                </a>


                <button
                    type="button"
                    @click="sidebarOpen = false"
                    class="ml-auto flex h-9 w-9 items-center justify-center rounded-lg text-[#71837B] transition hover:bg-[#F3F8F5] hover:text-[#123128] dark:text-[#8FA69A] dark:hover:bg-[#1A2B22] dark:hover:text-[#E7F2EC] lg:hidden"
                    aria-label="Tutup menu"
                >

                    <i class="bi bi-x-lg"></i>

                </button>

            </div>


            {{-- =====================================================
                NAVIGATION
            ====================================================== --}}

            <nav class="flex-1 overflow-y-auto px-4 py-5">


                {{-- =================================================
                    UTAMA
                ================================================== --}}

                <p
                    class="px-3 text-[10px] font-semibold uppercase tracking-[0.16em] text-[#9AAEA5] dark:text-[#71877B]"
                >
                    Utama
                </p>


                <div class="mt-3 space-y-1">

                    {{-- Dashboard --}}
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.dashboard')
                            ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                            : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                    >

                        <i class="bi bi-grid-1x2 w-5 text-base"></i>

                        <span>
                            Dashboard
                        </span>

                    </a>


                    {{-- Notifikasi --}}
                    @if(Route::has('notifications.index'))

                        @php
                            $adminUnreadCount = auth()->user()?->unreadNotifications()->count() ?? 0;
                        @endphp

                        <a
                            href="{{ route('notifications.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                            {{ request()->routeIs('notifications.*')
                                ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                                : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                        >

                            <i class="bi bi-bell w-5 text-base"></i>

                            <span>
                                Notifikasi
                            </span>

                            @if($adminUnreadCount > 0)

                                <span
                                    class="ml-auto inline-flex min-w-[20px] items-center justify-center rounded-full bg-[#E5484D] px-1.5 py-1 text-[8px] font-bold leading-none text-white"
                                >
                                    {{ $adminUnreadCount > 99 ? '99+' : $adminUnreadCount }}
                                </span>

                            @endif

                        </a>

                    @endif

                </div>


                {{-- =================================================
                    MARKETPLACE
                ================================================== --}}

                <p
                    class="mt-7 px-3 text-[10px] font-semibold uppercase tracking-[0.16em] text-[#9AAEA5] dark:text-[#71877B]"
                >
                    Marketplace
                </p>


                <div class="mt-3 space-y-1">

                    {{-- Pengguna --}}
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.users.*')
                            ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                            : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                    >

                        <i class="bi bi-people w-5 text-base"></i>

                        <span>
                            Pengguna
                        </span>

                    </a>


                    {{-- Kategori --}}
                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.categories.*')
                            ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                            : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                    >

                        <i class="bi bi-grid w-5 text-base"></i>

                        <span>
                            Kategori
                        </span>

                    </a>


                    {{-- Jasa --}}
                    <a
                        href="{{ route('admin.services.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.services.*')
                            ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                            : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                    >

                        <i class="bi bi-briefcase w-5 text-base"></i>

                        <span>
                            Jasa & Moderasi
                        </span>

                    </a>


                    {{-- Pesanan --}}
                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.orders.*')
                            ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                            : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                    >

                        <i class="bi bi-bag-check w-5 text-base"></i>

                        <span>
                            Pesanan
                        </span>

                    </a>


                    {{-- Review --}}
                    <a
                        href="{{ route('admin.reviews.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.reviews.*')
                            ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                            : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                    >

                        <i class="bi bi-star w-5 text-base"></i>

                        <span>
                            Review
                        </span>

                    </a>

                </div>


                {{-- =================================================
                    OPERASIONAL
                ================================================== --}}

                <p
                    class="mt-7 px-3 text-[10px] font-semibold uppercase tracking-[0.16em] text-[#9AAEA5] dark:text-[#71877B]"
                >
                    Operasional
                </p>


                <div class="mt-3 space-y-1">

                    {{-- KYC --}}
                    @if(Route::has('admin.kyc.index'))

                        <a
                            href="{{ route('admin.kyc.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                            {{ request()->routeIs('admin.kyc.*')
                                ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                                : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                        >

                            <i class="bi bi-person-vcard w-5 text-base"></i>

                            <span>
                                KYC
                            </span>

                        </a>

                    @endif


                    {{-- Pembatalan --}}
                    @if(Route::has('admin.cancellations.index'))

                        <a
                            href="{{ route('admin.cancellations.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                            {{ request()->routeIs('admin.cancellations.*')
                                ? 'bg-[#FFF8E9] text-[#9A6800] dark:bg-[#3B301A] dark:text-[#E7C56C]'
                                : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                        >

                            <i class="bi bi-x-circle w-5 text-base"></i>

                            <span>
                                Pembatalan
                            </span>

                        </a>

                    @endif


                    {{-- Dispute --}}
                    @if(Route::has('admin.disputes.index'))

                        <a
                            href="{{ route('admin.disputes.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                            {{ request()->routeIs('admin.disputes.*')
                                ? 'bg-[#EEF5FF] text-[#315A91] dark:bg-[#1B3048] dark:text-[#8CB8EF]'
                                : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                        >

                            <i class="bi bi-shield-exclamation w-5 text-base"></i>

                            <span>
                                Dispute
                            </span>

                        </a>

                    @endif

                </div>


                {{-- =================================================
                    KEUANGAN
                ================================================== --}}

                <p
                    class="mt-7 px-3 text-[10px] font-semibold uppercase tracking-[0.16em] text-[#9AAEA5] dark:text-[#71877B]"
                >
                    Keuangan
                </p>


                <div class="mt-3 space-y-1">

                    {{-- Pembayaran --}}
                    <a
                        href="{{ route('admin.payments.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.payments.*')
                            ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                            : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                    >

                        <i class="bi bi-credit-card w-5 text-base"></i>

                        <span>
                            Pembayaran
                        </span>

                    </a>


                    {{-- Komisi --}}
                    <a
                        href="{{ route('admin.commissions.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.commissions.*')
                            ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                            : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                    >

                        <i class="bi bi-percent w-5 text-base"></i>

                        <span>
                            Komisi
                        </span>

                    </a>


                    {{-- Refund --}}
                    @if(Route::has('admin.refunds.index'))

                        <a
                            href="{{ route('admin.refunds.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                            {{ request()->routeIs('admin.refunds.*')
                                ? 'bg-[#EEF5FF] text-[#315A91] dark:bg-[#1B3048] dark:text-[#8CB8EF]'
                                : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                        >

                            <i class="bi bi-arrow-counterclockwise w-5 text-base"></i>

                            <span>
                                Refund
                            </span>

                        </a>

                    @endif


                    {{-- Penarikan --}}
                    <a
                        href="{{ route('admin.withdrawals.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.withdrawals.*')
                            ? 'bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]'
                            : 'text-[#667D73] hover:bg-[#F8FCF9] hover:text-[#123128] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#E7F2EC]' }}"
                    >

                        <i class="bi bi-bank w-5 text-base"></i>

                        <span>
                            Penarikan
                        </span>

                    </a>

                </div>

            </nav>


            {{-- =========================================================
                USER FOOTER
            ========================================================== --}}

            <div
                class="shrink-0 border-t border-[#E7EFEA] p-4 dark:border-[#263B31]"
            >

                <div
                    class="flex items-center gap-3 rounded-xl bg-[#F8FCF9] p-3 dark:bg-[#17271F]"
                >

                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A] dark:bg-[#1C402C] dark:text-[#7AD8B5]"
                    >
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0 flex-1">

                        <p
                            class="truncate text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]"
                        >
                            {{ auth()->user()->name }}
                        </p>

                        <p
                            class="truncate text-xs text-[#8A9B94] dark:text-[#8FA69A]"
                        >
                            Administrator
                        </p>

                    </div>

                </div>


                {{-- Logout --}}
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="mt-2"
                >

                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-[#667D73] transition hover:bg-[#FEF0F0] hover:text-[#B42318] dark:text-[#9CB0A5] dark:hover:bg-[#321B1B] dark:hover:text-[#F28B82]"
                    >

                        <i class="bi bi-box-arrow-right w-5"></i>

                        <span>
                            Keluar
                        </span>

                    </button>

                </form>

            </div>

        </aside>


        {{-- =========================================================
            MAIN AREA
        ========================================================== --}}

        <div class="min-h-screen lg:ml-64">


            {{-- =====================================================
                TOPBAR
            ====================================================== --}}

            <header
                class="sticky top-0 z-30 h-[72px] border-b border-[#E7EFEA] bg-white/95 backdrop-blur dark:border-[#263B31] dark:bg-[#111F18]/95"
            >

                <div
                    class="flex h-full items-center justify-between px-5 sm:px-6 lg:px-8"
                >

                    {{-- Left --}}
                    <div class="flex items-center gap-3">

                        {{-- Mobile Menu --}}
                        <button
                            type="button"
                            @click="sidebarOpen = true"
                            class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#DCE9E2] text-[#526960] transition hover:bg-[#F8FCF9] dark:border-[#2B4337] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] lg:hidden"
                            aria-label="Buka menu"
                        >

                            <i class="bi bi-list text-lg"></i>

                        </button>


                        <div>

                            <p
                                class="hidden text-xs text-[#8A9B94] dark:text-[#71877B] sm:block"
                            >
                                JASAIN Admin
                            </p>

                            <p
                                class="text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]"
                            >
                                {{ $title }}
                            </p>

                        </div>

                    </div>


                    {{-- Right --}}
                    <div class="flex items-center gap-2 sm:gap-3">

                        {{-- Theme Toggle --}}
                        <button
                            type="button"
                            @click="darkMode = !darkMode; localStorage.setItem('jasain-theme', darkMode ? 'dark' : 'light')"
                            class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#DCE9E2] bg-white text-[#526960] transition hover:bg-[#F8FCF9] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#C4D4CC] dark:hover:bg-[#1B3026]"
                            title="Ganti tema"
                            aria-label="Ganti tema"
                        >

                            <i
                                class="bi"
                                :class="darkMode ? 'bi-sun' : 'bi-moon-stars'"
                            ></i>

                        </button>


                        {{-- Notification --}}
                        <div
                            class="relative flex h-10 w-10 items-center justify-center rounded-xl text-[#526960] transition dark:text-[#C4D4CC]"
                        >

                            <x-notification-bell />

                        </div>


                        {{-- Marketplace --}}
                        <a
                            href="{{ route('marketplace.home') }}"
                            class="hidden items-center gap-2 rounded-xl border border-[#DCE9E2] bg-white px-4 py-2 text-xs font-semibold text-[#526960] transition hover:bg-[#F8FCF9] hover:text-[#0F6B3A] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#B8CAC1] dark:hover:bg-[#1B3026] dark:hover:text-[#7AD8B5] sm:inline-flex"
                        >

                            <i class="bi bi-box-arrow-up-right"></i>

                            Marketplace

                        </a>


                        {{-- User --}}
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A] dark:bg-[#1C402C] dark:text-[#7AD8B5]"
                        >
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                    </div>

                </div>

            </header>


            {{-- =====================================================
                CONTENT
            ====================================================== --}}

            <main
                class="min-h-[calc(100vh-72px)] bg-[#F8FCF9] px-5 py-6 transition-colors duration-200 dark:bg-[#0B1511] sm:px-6 lg:px-8 lg:py-8"
            >

                {{ $slot }}

            </main>

        </div>

    </div>


</body>

</html>