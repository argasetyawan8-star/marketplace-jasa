@php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CLIENT NAVIGATION
|--------------------------------------------------------------------------
*/

$isAuthenticated = auth()->check();

$user = $isAuthenticated ? auth()->user() : null;


/*
|--------------------------------------------------------------------------
| Marketplace URLs
|--------------------------------------------------------------------------
*/

$homeUrl = route('marketplace.home');

$searchUrl = route('marketplace.search');


/*
|--------------------------------------------------------------------------
| Client URLs
|--------------------------------------------------------------------------
*/

$dashboardUrl = route('client.dashboard');

$ordersUrl = route('client.orders.index');

$messagesUrl = route('client.messages.index');

$favoritesUrl = route('client.favorites.index');

$projectsUrl = route('client.jobs.index');

$profileUrl = route('profile.show');

$notificationsUrl = route('notifications.index');


/*
|--------------------------------------------------------------------------
| Current Page State
|--------------------------------------------------------------------------
*/

$isHome = request()->routeIs('marketplace.home');

$isSearch =
    request()->routeIs('marketplace.search') ||
    request()->routeIs('marketplace.category') ||
    request()->routeIs('marketplace.service') ||
    request()->routeIs('marketplace.freelancer.show');

$isProjects =
    request()->routeIs('client.jobs.*') ||
    request()->routeIs('marketplace.jobs.*');

$isOrders =
    request()->routeIs('client.orders.*');

$isFavorites =
    request()->routeIs('client.favorites.*');

$isMessages =
    request()->routeIs('client.messages.*');

$isDashboard =
    request()->routeIs('client.dashboard');

$isProfile =
    request()->routeIs('profile.*');

$isNotifications =
    request()->routeIs('notifications.*');

@endphp


{{-- ================================================================
     NAVIGATION WRAPPER
     ================================================================ --}}

<div
    x-data="{
        moreOpen: false,
        profileOpen: false,
        categoryOpen: false,
        mobileProfileOpen: false
    }"

    @keydown.escape.window="
        moreOpen = false;
        profileOpen = false;
        categoryOpen = false;
        mobileProfileOpen = false;
    "

    @click.outside="
        moreOpen = false;
        profileOpen = false;
        categoryOpen = false;
        mobileProfileOpen = false;
    "

    class="relative z-[100]"
>


    {{-- ================================================================
         DESKTOP NAVBAR
         ================================================================ --}}

    <header
        id="pk-navbar-desktop"
        class="pk-navbar fixed inset-x-0 top-0 z-[100] hidden h-[72px] w-full border-b border-slate-200/80 bg-white/95 backdrop-blur-xl lg:block"
    >

        <div class="mx-auto flex h-full w-full max-w-[1280px] items-center px-6">


            {{-- ========================================================
                 LOGO
                 ======================================================== --}}

            <a
                href="{{ $homeUrl }}"
                class="group flex shrink-0 items-center gap-2.5"
                aria-label="ProKerja Beranda"
            >

                <span
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-lg font-extrabold text-white shadow-sm transition duration-200 group-hover:-translate-y-0.5 group-hover:shadow-md"
                >
                    P
                </span>

                <span class="flex min-w-0 flex-col leading-none">

                    <span
                        class="text-[17px] font-bold tracking-[-0.02em] text-slate-900"
                    >
                        ProKerja
                    </span>

                    <span
                        class="mt-1 text-[9px] font-medium uppercase tracking-[0.08em] text-slate-400"
                    >
                        Temukan Talenta. Wujudkan Kerja.
                    </span>

                </span>

            </a>


            {{-- ========================================================
                 MAIN NAVIGATION
                 ======================================================== --}}

            <nav class="ml-10 flex h-full items-center gap-1">


                {{-- Beranda --}}

                <a
                    href="{{ $homeUrl }}"
                    class="pk-navbar-link {{ $isHome ? 'is-active' : '' }}"
                >
                    Beranda
                </a>


                {{-- Cari Jasa --}}

                <a
                    href="{{ $searchUrl }}"
                    class="pk-navbar-link {{ $isSearch ? 'is-active' : '' }}"
                >
                    Cari Jasa
                </a>


                {{-- Job Board --}}

                <a
                    href="{{ $projectsUrl }}"
                    class="pk-navbar-link {{ $isProjects ? 'is-active' : '' }}"
                >
                    Job Board
                </a>


                {{-- Pesanan --}}

                <a
                    href="{{ $ordersUrl }}"
                    class="pk-navbar-link {{ $isOrders ? 'is-active' : '' }}"
                >
                    Pesanan
                </a>


                {{-- Favorit --}}

                <a
                    href="{{ $favoritesUrl }}"
                    class="pk-navbar-link {{ $isFavorites ? 'is-active' : '' }}"
                >
                    Favorit
                </a>

            </nav>


            {{-- ========================================================
                 RIGHT SIDE
                 ======================================================== --}}

            <div class="ml-auto flex items-center gap-2">

                @auth


                    {{-- ==================================================
                         NOTIFICATION
                         ================================================== --}}

                    <a
                        href="{{ $notificationsUrl }}"
                        class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition duration-200 hover:bg-blue-50 hover:text-blue-600 {{ $isNotifications ? 'bg-blue-50 text-blue-600' : '' }}"
                        aria-label="Notifikasi"
                    >

                        <i class="bi bi-bell text-[19px]"></i>

                        <span
                            id="pk-notification-badge"
                            class="absolute right-1.5 top-1.5 hidden min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[9px] font-bold leading-4 text-white"
                        >
                            0
                        </span>

                    </a>


                    {{-- ==================================================
                         PROFILE
                         ================================================== --}}

                    <div class="relative ml-1">

                        <button
                            type="button"

                            @click="
                                profileOpen = !profileOpen;
                                categoryOpen = false;
                            "

                            class="flex items-center gap-2 rounded-xl px-2 py-1.5 transition duration-200 hover:bg-slate-100"

                            :aria-expanded="profileOpen.toString()"
                        >

                            {{-- Avatar --}}

                            <span
                                class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full bg-blue-100 text-sm font-bold text-blue-700"
                            >

                                @if (filled($user?->avatar))

                                    <img
                                        src="{{ asset('storage/' . ltrim($user->avatar, '/')) }}"
                                        alt="{{ $user->name }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    {{ strtoupper(mb_substr($user?->name ?? 'U', 0, 1)) }}

                                @endif

                            </span>


                            {{-- Name --}}

                            <span
                                class="hidden max-w-[140px] truncate text-sm font-semibold text-slate-700 xl:block"
                            >
                                {{ $user?->name ?? 'Akun' }}
                            </span>


                            {{-- Chevron --}}

                            <i
                                class="bi bi-chevron-down text-[11px] text-slate-400 transition-transform duration-200"
                                :class="{ 'rotate-180': profileOpen }"
                            ></i>

                        </button>


                        {{-- ==================================================
                             PROFILE DROPDOWN
                             ================================================== --}}

                        <div
                            x-cloak
                            x-show="profileOpen"

                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="translate-y-1 opacity-0"
                            x-transition:enter-end="translate-y-0 opacity-100"

                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="translate-y-0 opacity-100"
                            x-transition:leave-end="translate-y-1 opacity-0"

                            class="absolute right-0 top-[52px] w-[285px] overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-900/10"
                        >


                            {{-- Account Header --}}

                            <div class="mb-1 rounded-xl bg-slate-50 px-3.5 py-3">

                                <p
                                    class="truncate text-sm font-bold text-slate-900"
                                >
                                    {{ $user?->name ?? 'Akun' }}
                                </p>

                                <p
                                    class="mt-0.5 truncate text-xs text-slate-500"
                                >
                                    Client
                                </p>

                            </div>


                            {{-- Dashboard --}}

                            <a
                                href="{{ $dashboardUrl }}"
                                @click="profileOpen = false"
                                class="pk-mobile-more-item"
                            >

                                <span class="pk-mobile-more-icon">
                                    <i class="bi bi-speedometer2"></i>
                                </span>

                                <span>
                                    Dashboard
                                </span>

                            </a>


                            {{-- Favorit --}}

                            <a
                                href="{{ $favoritesUrl }}"
                                @click="profileOpen = false"
                                class="pk-mobile-more-item"
                            >

                                <span class="pk-mobile-more-icon">
                                    <i class="bi bi-heart"></i>
                                </span>

                                <span>
                                    Favorit
                                </span>

                            </a>


                            {{-- Pesan --}}

                            <a
                                href="{{ $messagesUrl }}"
                                @click="profileOpen = false"
                                class="pk-mobile-more-item"
                            >

                                <span class="pk-mobile-more-icon">
                                    <i class="bi bi-chat-dots"></i>
                                </span>

                                <span>
                                    Pesan
                                </span>

                            </a>


                            {{-- Proyek Saya --}}

                            <a
                                href="{{ $projectsUrl }}"
                                @click="profileOpen = false"
                                class="pk-mobile-more-item"
                            >

                                <span class="pk-mobile-more-icon">
                                    <i class="bi bi-kanban"></i>
                                </span>

                                <span>
                                    Proyek Saya
                                </span>

                            </a>


                            {{-- Profil --}}

                            <a
                                href="{{ $profileUrl }}"
                                @click="profileOpen = false"
                                class="pk-mobile-more-item"
                            >

                                <span class="pk-mobile-more-icon">
                                    <i class="bi bi-person"></i>
                                </span>

                                <span>
                                    Profil
                                </span>

                            </a>


                            {{-- Notifikasi --}}

                            <a
                                href="{{ $notificationsUrl }}"
                                @click="profileOpen = false"
                                class="pk-mobile-more-item"
                            >

                                <span class="pk-mobile-more-icon">
                                    <i class="bi bi-bell"></i>
                                </span>

                                <span>
                                    Notifikasi
                                </span>

                            </a>


                            {{-- Divider --}}

                            <div class="my-2 border-t border-slate-100"></div>


                            {{-- Logout --}}

                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="flex w-full items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                                >

                                    <span
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50"
                                    >
                                        <i class="bi bi-box-arrow-right"></i>
                                    </span>

                                    <span>
                                        Keluar
                                    </span>

                                </button>

                            </form>

                        </div>

                    </div>


                @else


                    {{-- ==================================================
                         GUEST
                         ================================================== --}}

                    <a
                        href="{{ route('login') }}"
                        class="inline-flex h-10 items-center rounded-xl px-4 text-sm font-semibold text-slate-700 transition duration-200 hover:bg-slate-100 hover:text-blue-600"
                    >
                        Masuk
                    </a>


                    <a
                        href="{{ route('register') }}"
                        class="inline-flex h-10 items-center rounded-xl bg-blue-600 px-4 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-blue-700 hover:shadow-md"
                    >
                        Daftar
                    </a>


                @endauth

            </div>

        </div>

    </header>


    {{-- ================================================================
         DESKTOP SPACER
         ================================================================ --}}

    <div class="hidden h-[72px] lg:block"></div>


    {{-- ================================================================
         MOBILE TOP NAVBAR
         ================================================================ --}}

    <header
        id="pk-navbar-mobile"
        class="fixed inset-x-0 top-0 z-[110] border-b border-slate-200/80 bg-white/95 backdrop-blur-xl lg:hidden"
    >

        <div class="flex h-[64px] items-center justify-between px-4">


            {{-- ========================================================
                 MOBILE LOGO
                 ======================================================== --}}

            <a
                href="{{ $homeUrl }}"
                class="flex items-center gap-2"
                aria-label="ProKerja Beranda"
            >

                <span
                    class="flex h-9 w-9 items-center justify-center rounded-[10px] bg-blue-600 text-base font-extrabold text-white"
                >
                    P
                </span>

                <span class="flex flex-col leading-none">

                    <span
                        class="text-[16px] font-bold tracking-[-0.02em] text-slate-900"
                    >
                        ProKerja
                    </span>

                    <span
                        class="mt-1 text-[8px] font-medium uppercase tracking-[0.06em] text-slate-400"
                    >
                        Wujudkan Kerja
                    </span>

                </span>

            </a>


            {{-- ========================================================
                 MOBILE ACTIONS
                 ======================================================== --}}

            <div class="flex items-center gap-1">

                @auth

                    {{-- ==================================================
                         PROYEK / JOB BOARD
                         ================================================== --}}

                    <a
                        href="{{ $projectsUrl }}"
                        class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-blue-50 hover:text-blue-600 {{ $isProjects ? 'bg-blue-50 text-blue-600' : '' }}"
                        aria-label="Proyek"
                        title="Proyek"
                    >

                        <i
                            class="bi bi-briefcase{{ $isProjects ? '-fill' : '' }} text-[18px]"
                        ></i>

                    </a>


                    {{-- ==================================================
                         NOTIFICATION
                         ================================================== --}}

                    <a
                        href="{{ $notificationsUrl }}"
                        class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-blue-50 hover:text-blue-600 {{ $isNotifications ? 'bg-blue-50 text-blue-600' : '' }}"
                        aria-label="Notifikasi"
                    >

                        <i class="bi bi-bell text-[18px]"></i>

                        <span
                            id="pk-mobile-notification-badge"
                            class="absolute right-1.5 top-1.5 hidden min-w-[15px] items-center justify-center rounded-full bg-red-500 px-1 text-[8px] font-bold leading-4 text-white"
                        >
                            0
                        </span>

                    </a>

                @endauth


                {{-- ==================================================
                     MORE / THREE DOTS
                     ================================================== --}}

                <button
                    type="button"

                    @click="
                        moreOpen = !moreOpen;
                        mobileProfileOpen = false;
                    "

                    class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"

                    :aria-expanded="moreOpen.toString()"

                    aria-label="Menu lainnya"
                >

                    <i
                        class="bi bi-three-dots-vertical text-[20px]"
                    ></i>

                </button>

            </div>

        </div>


        {{-- ============================================================
             MOBILE MORE PANEL
             ============================================================ --}}

        <div
            x-cloak
            x-show="moreOpen"

            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="-translate-y-2 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"

            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-2 opacity-0"

            class="border-t border-slate-100 bg-white px-4 pb-4 pt-3 shadow-xl shadow-slate-900/10"
        >

            <div class="grid grid-cols-2 gap-2">


                {{-- ==================================================
                     DASHBOARD
                     ================================================== --}}

                <a
                    href="{{ $dashboardUrl }}"
                    @click="moreOpen = false"
                    class="pk-mobile-more-item"
                >

                    <span class="pk-mobile-more-icon">
                        <i class="bi bi-speedometer2"></i>
                    </span>

                    <span>
                        Dashboard
                    </span>

                </a>


                {{-- ==================================================
                     FAVORIT
                     ================================================== --}}

                <a
                    href="{{ $favoritesUrl }}"
                    @click="moreOpen = false"
                    class="pk-mobile-more-item"
                >

                    <span class="pk-mobile-more-icon">
                        <i class="bi bi-heart"></i>
                    </span>

                    <span>
                        Favorit
                    </span>

                </a>


                


                {{-- ==================================================
                     PROYEK SAYA
                     ================================================== --}}

                <a
                    href="{{ $projectsUrl }}"
                    @click="moreOpen = false"
                    class="pk-mobile-more-item"
                >

                    <span class="pk-mobile-more-icon">
                        <i class="bi bi-kanban"></i>
                    </span>

                    <span>
                        Proyek Saya
                    </span>

                </a>


                


                {{-- ==================================================
                     LOGOUT
                     ================================================== --}}

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="col-span-2"
                >

                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-100"
                    >

                        <i class="bi bi-box-arrow-right"></i>

                        Keluar

                    </button>

                </form>

            </div>

        </div>

    </header>


    {{-- ================================================================
         MOBILE TOP SPACER
         ================================================================ --}}

    <div class="h-[64px] lg:hidden"></div>

</div>


{{-- ====================================================================
     MOBILE BOTTOM NAVIGATION
     PENTING:
     NAVBAR INI BERADA DI LUAR WRAPPER x-data.
     ==================================================================== --}}

<nav
    id="pk-mobile-bottom-nav"
    class="pk-mobile-bottom-nav fixed inset-x-0 bottom-0 z-[9999] border-t border-slate-200/80 bg-white/95 shadow-[0_-8px_25px_rgba(15,23,42,0.06)] backdrop-blur-xl lg:hidden"
    aria-label="Navigasi utama mobile"
>

    <div
        class="mx-auto grid h-[72px] max-w-[520px] grid-cols-5"
    >


        {{-- ============================================================
             HOME
             ============================================================ --}}

        <a
            href="{{ $homeUrl }}"
            class="flex items-center justify-center px-1 transition {{ $isHome ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600' }}"
        >

            <span
                class="flex h-8 w-8 items-center justify-center rounded-xl {{ $isHome ? 'bg-blue-50' : '' }}"
            >

                <i
                    class="bi bi-house{{ $isHome ? '-fill' : '' }} text-[18px]"
                ></i>

            </span>

        </a>


        {{-- ============================================================
             CARI
             ============================================================ --}}

        <a
            href="{{ $searchUrl }}"
            class="flex items-center justify-center px-1 transition {{ $isSearch ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600' }}"
        >

            <span
                class="flex h-8 w-8 items-center justify-center rounded-xl {{ $isSearch ? 'bg-blue-50' : '' }}"
            >

                <i class="bi bi-search text-[17px]"></i>

            </span>

        </a>


        {{-- ============================================================
             PESAN
             ============================================================ --}}

        <a
            href="{{ $messagesUrl }}"
            class="flex items-center justify-center px-1 transition {{ $isMessages ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600' }}"
        >

            <span
                class="flex h-8 w-8 items-center justify-center rounded-xl {{ $isMessages ? 'bg-blue-50' : '' }}"
            >

                <i
                    class="bi bi-chat-dots{{ $isMessages ? '-fill' : '' }} text-[18px]"
                ></i>

            </span>

        </a>


        {{-- ============================================================
             PESANAN
             ============================================================ --}}

        <a
            href="{{ $ordersUrl }}"
            class="flex items-center justify-center px-1 transition {{ $isOrders ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600' }}"
        >

            <span
                class="flex h-8 w-8 items-center justify-center rounded-xl {{ $isOrders ? 'bg-blue-50' : '' }}"
            >

                <i
                    class="bi bi-bag{{ $isOrders ? '-fill' : '' }} text-[18px]"
                ></i>

            </span>

        </a>


        {{-- ============================================================
             PROFIL
             ============================================================ --}}

        <a
            href="{{ $profileUrl }}"
            class="flex items-center justify-center px-1 transition {{ $isProfile ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600' }}"
        >

            <span
                class="flex h-8 w-8 items-center justify-center rounded-xl {{ $isProfile ? 'bg-blue-50' : '' }}"
            >

                <i
                    class="bi bi-person{{ $isProfile ? '-fill' : '' }} text-[18px]"
                ></i>

            </span>

        </a>

    </div>

</nav>


{{-- ====================================================================
     NOTIFICATION BADGE
     ==================================================================== --}}

@auth

<script>

document.addEventListener('DOMContentLoaded', function () {

    const desktopBadge =
        document.getElementById('pk-notification-badge');

    const mobileBadge =
        document.getElementById('pk-mobile-notification-badge');


    function updateNotificationBadge(count) {

        const badges = [
            desktopBadge,
            mobileBadge
        ].filter(Boolean);


        badges.forEach(function (badge) {

            if (count > 0) {

                badge.textContent =
                    count > 99 ? '99+' : count;

                badge.classList.remove('hidden');

                badge.classList.add('flex');

            } else {

                badge.classList.add('hidden');

                badge.classList.remove('flex');

            }

        });

    }


    fetch(
        @json(route('notifications.unread_count')),
        {
            method: 'GET',

            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },

            credentials: 'same-origin'
        }
    )

    .then(function (response) {

        if (!response.ok) {

            throw new Error(
                'Failed to load notification count.'
            );

        }

        return response.json();

    })

    .then(function (data) {

        const count = Number(
            data.count ??
            data.unread_count ??
            data.unread ??
            0
        );


        updateNotificationBadge(
            Number.isFinite(count)
                ? count
                : 0
        );

    })

    .catch(function () {

        updateNotificationBadge(0);

    });

});

</script>

@endauth


{{-- ====================================================================
     MOBILE KEYBOARD HANDLER
     ==================================================================== --}}

<script>

(function () {

    function initMobileKeyboardNavigation() {

        const bottomNav =
            document.getElementById(
                'pk-mobile-bottom-nav'
            );

        if (!bottomNav) {
            return;
        }


        let keyboardOpen = false;

        let normalViewportHeight = null;

        let focusTimer = null;


        /*
        |--------------------------------------------------------------------------
        | Mobile
        |--------------------------------------------------------------------------
        */

        function isMobile() {

            return window.matchMedia(
                '(max-width: 1023px)'
            ).matches;

        }


        /*
        |--------------------------------------------------------------------------
        | Editable
        |--------------------------------------------------------------------------
        */

        function isEditable(element) {

            if (!element) {
                return false;
            }


            const tagName =
                element.tagName
                    ? element.tagName.toLowerCase()
                    : '';


            return (
                tagName === 'input' ||
                tagName === 'textarea' ||
                element.isContentEditable === true
            );

        }


        /*
        |--------------------------------------------------------------------------
        | HIDE NAV
        |--------------------------------------------------------------------------
        */

        function hideNav() {

            if (!isMobile()) {
                return;
            }


            keyboardOpen = true;


            document.body.classList.add(
                'pk-keyboard-open'
            );


            bottomNav.classList.add(
                'pk-keyboard-hidden'
            );


            bottomNav.setAttribute(
                'aria-hidden',
                'true'
            );


            bottomNav.style.setProperty(
                'display',
                'none',
                'important'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SHOW NAV
        |--------------------------------------------------------------------------
        */

        function showNav() {

            keyboardOpen = false;


            document.body.classList.remove(
                'pk-keyboard-open'
            );


            bottomNav.classList.remove(
                'pk-keyboard-hidden'
            );


            bottomNav.removeAttribute(
                'aria-hidden'
            );


            bottomNav.style.removeProperty(
                'display'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | GET VIEWPORT HEIGHT
        |--------------------------------------------------------------------------
        */

        function getViewportHeight() {

            if (window.visualViewport) {

                return window.visualViewport.height;

            }

            return window.innerHeight;

        }


        /*
        |--------------------------------------------------------------------------
        | INITIAL BASE HEIGHT
        |--------------------------------------------------------------------------
        */

        function setNormalViewportHeight() {

            const height =
                getViewportHeight();


            if (
                !normalViewportHeight ||
                height > normalViewportHeight
            ) {

                normalViewportHeight =
                    height;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | CHECK KEYBOARD
        |--------------------------------------------------------------------------
        */

        function checkKeyboard() {

            if (!isMobile()) {

                showNav();

                return;

            }


            const currentHeight =
                getViewportHeight();


            if (!normalViewportHeight) {

                normalViewportHeight =
                    currentHeight;

                return;

            }


            const difference =
                normalViewportHeight -
                currentHeight;


            /*
            |--------------------------------------------------------------------------
            | Keyboard terbuka
            |--------------------------------------------------------------------------
            */

            if (difference > 100) {

                hideNav();

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Keyboard sudah kembali
            |--------------------------------------------------------------------------
            */

            if (
                difference <= 100 &&
                keyboardOpen
            ) {

                setTimeout(function () {

                    const latestHeight =
                        getViewportHeight();

                    const latestDifference =
                        normalViewportHeight -
                        latestHeight;


                    if (
                        latestDifference <= 100
                    ) {

                        showNav();

                        normalViewportHeight =
                            latestHeight;

                    }

                }, 150);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | INPUT / TEXTAREA MENDAPAT FOCUS
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'focusin',
            function (event) {

                if (!isMobile()) {
                    return;
                }


                if (
                    !isEditable(
                        event.target
                    )
                ) {
                    return;
                }


                clearTimeout(
                    focusTimer
                );


                /*
                |--------------------------------------------------------------------------
                | Langsung hilangkan navbar
                |--------------------------------------------------------------------------
                */

                hideNav();


                /*
                |--------------------------------------------------------------------------
                | Tunggu keyboard benar-benar muncul
                |--------------------------------------------------------------------------
                */

                focusTimer =
                    setTimeout(function () {

                        setNormalViewportHeight();

                        checkKeyboard();

                    }, 250);

            },
            true
        );


        /*
        |--------------------------------------------------------------------------
        | INPUT KEHILANGAN FOCUS
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'focusout',
            function () {

                clearTimeout(
                    focusTimer
                );


                setTimeout(function () {

                    /*
                    |--------------------------------------------------------------------------
                    | Kalau user pindah ke input lain
                    |--------------------------------------------------------------------------
                    */

                    if (
                        isEditable(
                            document.activeElement
                        )
                    ) {

                        hideNav();

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Tidak ada input aktif
                    |--------------------------------------------------------------------------
                    */

                    showNav();


                    /*
                    |--------------------------------------------------------------------------
                    | Reset tinggi normal
                    |--------------------------------------------------------------------------
                    */

                    setTimeout(function () {

                        normalViewportHeight =
                            getViewportHeight();

                    }, 100);

                }, 200);

            },
            true
        );


        /*
        |--------------------------------------------------------------------------
        | Visual Viewport
        |--------------------------------------------------------------------------
        */

        if (window.visualViewport) {

            window.visualViewport.addEventListener(
                'resize',
                function () {

                    checkKeyboard();

                }
            );


            window.visualViewport.addEventListener(
                'scroll',
                function () {

                    if (keyboardOpen) {

                        hideNav();

                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Window Resize
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'resize',
            function () {

                if (!isMobile()) {

                    showNav();

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Jika sedang mengetik,
                | navbar harus tetap hilang.
                |--------------------------------------------------------------------------
                */

                if (
                    isEditable(
                        document.activeElement
                    )
                ) {

                    hideNav();

                    return;

                }


                checkKeyboard();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Orientation
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'orientationchange',
            function () {

                showNav();

                normalViewportHeight =
                    null;


                setTimeout(function () {

                    setNormalViewportHeight();

                }, 500);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Initial
        |--------------------------------------------------------------------------
        */

        setTimeout(function () {

            setNormalViewportHeight();

            checkKeyboard();

        }, 300);

    }


    /*
    |--------------------------------------------------------------------------
    | DOM READY
    |--------------------------------------------------------------------------
    */

    if (
        document.readyState === 'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initMobileKeyboardNavigation
        );

    } else {

        initMobileKeyboardNavigation();

    }

})();

</script>


<style>

/* ========================================================================
   ALPINE
   ======================================================================== */

[x-cloak] {
    display: none !important;
}


/* ========================================================================
   MOBILE BOTTOM NAV
   ======================================================================== */

#pk-mobile-bottom-nav {

    position: fixed !important;

    left: 0 !important;

    right: 0 !important;

    bottom: 0 !important;

    width: 100% !important;

    z-index: 9999 !important;

}


/* ========================================================================
   SAFE AREA IPHONE
   ======================================================================== */

@media (max-width: 1023px) {

    #pk-mobile-bottom-nav {

        padding-bottom:
            env(safe-area-inset-bottom);

    }

}


/* ========================================================================
   SAAT KEYBOARD AKTIF
   ======================================================================== */

body.pk-keyboard-open #pk-mobile-bottom-nav {

    display: none !important;

}


/* ========================================================================
   DESKTOP NAVBAR
   ======================================================================== */

.pk-navbar {

    transition:
        background-color 180ms ease,
        box-shadow 180ms ease,
        border-color 180ms ease;

}


.pk-navbar-link {

    position: relative;

    display: inline-flex;

    height: 72px;

    align-items: center;

    padding: 0 14px;

    font-size: 14px;

    font-weight: 600;

    color: #64748b;

    transition:
        color 180ms ease,
        background-color 180ms ease;

}


.pk-navbar-link:hover {

    color: #2563eb;

}


.pk-navbar-link::after {

    content: "";

    position: absolute;

    left: 14px;

    right: 14px;

    bottom: 13px;

    height: 2px;

    border-radius: 999px;

    background: #2563eb;

    opacity: 0;

    transform: scaleX(0.35);

    transition:
        opacity 180ms ease,
        transform 180ms ease;

}


.pk-navbar-link:hover::after,
.pk-navbar-link.is-active::after {

    opacity: 1;

    transform: scaleX(1);

}


.pk-navbar-link.is-active {

    color: #2563eb;

}


/* ========================================================================
   MOBILE MORE MENU
   ======================================================================== */

.pk-mobile-more-item {

    display: flex;

    align-items: center;

    gap: 12px;

    min-height: 50px;

    border-radius: 12px;

    padding: 9px 10px;

    font-size: 13px;

    font-weight: 600;

    color: #334155;

    transition:
        background-color 160ms ease,
        color 160ms ease,
        transform 160ms ease;

}


.pk-mobile-more-item:hover {

    background: #eff6ff;

    color: #2563eb;

    transform: translateY(-1px);

}


.pk-mobile-more-icon {

    display: inline-flex;

    width: 36px;

    height: 36px;

    flex: 0 0 36px;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: #f1f5f9;

    color: #64748b;

    transition:
        background-color 160ms ease,
        color 160ms ease;

}


.pk-mobile-more-item:hover .pk-mobile-more-icon {

    background: #dbeafe;

    color: #2563eb;

}


/* ========================================================================
   REDUCED MOTION
   ======================================================================== */

@media (prefers-reduced-motion: reduce) {

    .pk-navbar,
    .pk-navbar-link,
    .pk-mobile-more-item,
    .pk-mobile-more-icon {

        transition: none !important;

    }

}

</style>