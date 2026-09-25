@php
    use Illuminate\Support\Facades\Route;

    $isAuth = auth()->check();
    $role = $isAuth ? auth()->user()->role : null;

    /*
    |--------------------------------------------------------------------------
    | Public URLs
    |--------------------------------------------------------------------------
    */
    $homeUrl = Route::has('marketplace.home')
        ? route('marketplace.home')
        : url('/');

    $searchUrl = Route::has('marketplace.search')
        ? route('marketplace.search')
        : '#';

    $jobsUrl = Route::has('marketplace.jobs.index')
        ? route('marketplace.jobs.index')
        : '#';

    /*
    |--------------------------------------------------------------------------
    | Role URLs
    |--------------------------------------------------------------------------
    */
    $dashboardUrl = '#';
    $ordersUrl = '#';
    $messagesUrl = '#';
    $profileUrl = '#';
    $projectsUrl = '#';
    $favoritesUrl = '#';
    $servicesUrl = '#';
    $walletUrl = '#';
    $withdrawalsUrl = '#';
    $verificationUrl = '#';

    if ($role === 'client') {
        $dashboardUrl = Route::has('client.dashboard')
            ? route('client.dashboard')
            : '#';

        $ordersUrl = Route::has('client.orders.index')
            ? route('client.orders.index')
            : '#';

        $messagesUrl = Route::has('client.messages.index')
            ? route('client.messages.index')
            : '#';

        $profileUrl = Route::has('profile.show')
            ? route('profile.show')
            : '#';

        $projectsUrl = Route::has('client.jobs.index')
            ? route('client.jobs.index')
            : '#';

        $favoritesUrl = Route::has('client.favorites.index')
            ? route('client.favorites.index')
            : '#';
    }

    if ($role === 'freelancer') {
        $dashboardUrl = Route::has('freelancer.dashboard')
            ? route('freelancer.dashboard')
            : '#';

        $ordersUrl = Route::has('freelancer.orders.index')
            ? route('freelancer.orders.index')
            : '#';

        $messagesUrl = Route::has('freelancer.messages.index')
            ? route('freelancer.messages.index')
            : '#';

        $profileUrl = Route::has('freelancer.profile.show')
            ? route('freelancer.profile.show')
            : '#';

        $projectsUrl = Route::has('freelancer.jobs.index')
            ? route('freelancer.jobs.index')
            : '#';

        $servicesUrl = Route::has('freelancer.services.index')
            ? route('freelancer.services.index')
            : '#';

        $walletUrl = Route::has('freelancer.wallet.index')
            ? route('freelancer.wallet.index')
            : '#';

        $withdrawalsUrl = Route::has('freelancer.withdrawals.index')
            ? route('freelancer.withdrawals.index')
            : '#';

        $verificationUrl = Route::has('freelancer.verification.index')
            ? route('freelancer.verification.index')
            : '#';
    }

    /*
    |--------------------------------------------------------------------------
    | Admin URLs
    |--------------------------------------------------------------------------
    */
    $adminDashboardUrl = Route::has('admin.dashboard')
        ? route('admin.dashboard')
        : '#';

    $adminUsersUrl = Route::has('admin.users.index')
        ? route('admin.users.index')
        : '#';

    $adminServicesUrl = Route::has('admin.services.index')
        ? route('admin.services.index')
        : '#';

    $adminCategoriesUrl = Route::has('admin.categories.index')
        ? route('admin.categories.index')
        : '#';

    $adminBannersUrl = Route::has('admin.banners.index')
        ? route('admin.banners.index')
        : '#';

    $notificationUrl = Route::has('notifications.index')
        ? route('notifications.index')
        : '#';

    /*
    |--------------------------------------------------------------------------
    | Active States
    |--------------------------------------------------------------------------
    */
    $isHome = request()->routeIs('marketplace.home');

    $isSearch = request()->routeIs(
        'marketplace.search',
        'marketplace.service'
    );

    $isJobs = request()->routeIs(
        'marketplace.jobs.*',
        'client.jobs.*',
        'freelancer.jobs.*'
    );

    $isProfile = request()->routeIs(
        'profile.*',
        'client.profile.*',
        'freelancer.profile.*'
    );

    $isMessages = request()->routeIs(
        'client.messages.*',
        'freelancer.messages.*',
        'client.jobs.chat.*'
    );

    $isOrders = request()->routeIs(
        'client.orders.*',
        'freelancer.orders.*'
    );

    $isNotifications = request()->routeIs(
        'notifications.*'
    );
@endphp


{{-- ============================================================
     DESKTOP NAVIGATION
============================================================ --}}

<nav
    class="fixed inset-x-0 top-0 z-50 hidden h-[72px] border-b border-slate-200/80 bg-white/95 backdrop-blur-xl lg:block"
>
    <div class="mx-auto flex h-full max-w-7xl items-center px-6">

        {{-- Logo --}}
        <a
            href="{{ $homeUrl }}"
            class="group flex shrink-0 items-center gap-3"
        >
            <div
                class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#2563EB] text-white shadow-sm transition duration-200 group-hover:scale-105 group-hover:bg-blue-700"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M12 3v18"/>
                    <path d="M5 8h14"/>
                    <path d="M7 8c0 4 2 6 5 6s5-2 5-6"/>
                    <path d="M5 18h14"/>
                </svg>
            </div>

            <div class="leading-none">
                <div class="text-lg font-extrabold tracking-tight text-slate-900">
                    ProKerja
                </div>

                <div class="mt-1 text-[10px] font-medium uppercase tracking-[0.18em] text-slate-400">
                    Marketplace Jasa
                </div>
            </div>
        </a>


        {{-- Main Menu --}}
        <nav class="ml-10 flex h-full items-center gap-2">

            {{-- Beranda --}}
            <a
                href="{{ $homeUrl }}"
                class="{{ $isHome
                    ? 'bg-blue-50 text-[#2563EB]'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}
                    inline-flex h-10 items-center gap-2 rounded-xl px-4 text-sm font-semibold transition"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m3 10 9-7 9 7"/>
                    <path d="M5 9v11h14V9"/>
                    <path d="M9 20v-6h6v6"/>
                </svg>

                <span>Beranda</span>
            </a>


            {{-- Cari Jasa --}}
            <a
                href="{{ $searchUrl }}"
                class="{{ $isSearch
                    ? 'bg-blue-50 text-[#2563EB]'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}
                    inline-flex h-10 items-center gap-2 rounded-xl px-4 text-sm font-semibold transition"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="11" cy="11" r="7"/>
                    <path d="m20 20-4-4"/>
                </svg>

                <span>Cari Jasa</span>
            </a>


            {{-- Kategori --}}
            <a
                href="{{ $searchUrl }}#kategori"
                class="inline-flex h-10 items-center gap-2 rounded-xl px-4 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M4 5h6v6H4z"/>
                    <path d="M14 5h6v6h-6z"/>
                    <path d="M4 15h6v4H4z"/>
                    <path d="M14 15h6v4h-6z"/>
                </svg>

                <span>Kategori</span>
            </a>


            {{-- JobBoard --}}
            <a
                href="{{ $jobsUrl }}"
                class="{{ $isJobs
                    ? 'bg-blue-50 text-[#2563EB]'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}
                    inline-flex h-10 items-center gap-2 rounded-xl px-4 text-sm font-semibold transition"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <rect x="3" y="5" width="18" height="15" rx="2"/>
                    <path d="M8 5V3h8v2"/>
                    <path d="M3 10h18"/>
                    <path d="M9 14h6"/>
                </svg>

                <span>JobBoard</span>
            </a>

        </nav>


        {{-- Right Side --}}
        <div class="ml-auto flex items-center gap-3">

            @auth

                {{-- Notification --}}
                <a
                    href="{{ $notificationUrl }}"
                    class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-50 hover:text-slate-900"
                    aria-label="Notifikasi"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                        <path d="M10 21h4"/>
                    </svg>

                    <span
                        id="marketplace-notification-badge"
                        class="absolute right-1 top-1 hidden min-w-[17px] rounded-full bg-rose-500 px-1 text-center text-[9px] font-bold leading-[17px] text-white"
                    ></span>
                </a>


                {{-- Profile --}}
                <div class="relative">

                    <button
                        type="button"
                        id="marketplace-profile-button"
                        class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 transition hover:border-blue-200 hover:bg-blue-50/50"
                    >

                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-700">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>

                        <div class="hidden text-left xl:block">
                            <div class="max-w-[120px] truncate text-sm font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </div>

                            <div class="text-[11px] font-medium capitalize text-slate-400">
                                {{ $role ?? 'User' }}
                            </div>
                        </div>

                        <svg
                            class="h-4 w-4 text-slate-400"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="m6 9 6 6 6-6"/>
                        </svg>

                    </button>


                    {{-- Profile Dropdown --}}
                    <div
                        id="marketplace-profile-menu"
                        class="absolute right-0 top-[52px] hidden w-72 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-900/10"
                    >

                        <div class="border-b border-slate-100 bg-slate-50/70 p-4">
                            <div class="flex items-center gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-700">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </div>

                                <div class="min-w-0">
                                    <div class="truncate text-sm font-bold text-slate-900">
                                        {{ auth()->user()->name }}
                                    </div>

                                    <div class="truncate text-xs text-slate-500">
                                        {{ auth()->user()->email }}
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="p-2">

                            @if($role === 'client')

                                <a href="{{ $dashboardUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Dashboard
                                </a>

                                <a href="{{ $projectsUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Proyek Saya
                                </a>

                                <a href="{{ $ordersUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Pesanan
                                </a>

                                <a href="{{ $messagesUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Pesan
                                </a>

                                <a href="{{ $favoritesUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Favorit
                                </a>

                            @elseif($role === 'freelancer')

                                <a href="{{ $dashboardUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Dashboard
                                </a>

                                <a href="{{ $projectsUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Cari Job
                                </a>

                                <a href="{{ $servicesUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Layanan Saya
                                </a>

                                <a href="{{ $ordersUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Pesanan
                                </a>

                                <a href="{{ $messagesUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Pesan
                                </a>

                                <a href="{{ $walletUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Wallet
                                </a>

                                <a href="{{ $withdrawalsUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Penarikan
                                </a>

                                <a href="{{ $verificationUrl }}"
                                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Verifikasi
                                </a>

                            @elseif($role === 'admin')

                                <a href="{{ $adminDashboardUrl }}"
                                   class="flex items-center rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Admin Dashboard
                                </a>

                                <a href="{{ $adminUsersUrl }}"
                                   class="flex items-center rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Pengguna
                                </a>

                                <a href="{{ $adminServicesUrl }}"
                                   class="flex items-center rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Layanan
                                </a>

                                <a href="{{ $adminCategoriesUrl }}"
                                   class="flex items-center rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                    Kategori
                                </a>

                            @endif

                            <a href="{{ $profileUrl }}"
                               class="mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700">
                                Profil
                            </a>

                        </div>


                        <div class="border-t border-slate-100 p-2">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M10 17l5-5-5-5"/>
                                        <path d="M15 12H3"/>
                                        <path d="M21 19V5a2 2 0 0 0-2-2h-6"/>
                                    </svg>

                                    Keluar
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @else

                <a
                    href="{{ Route::has('login') ? route('login') : '#' }}"
                    class="rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900"
                >
                    Masuk
                </a>

                <a
                    href="{{ Route::has('register') ? route('register') : '#' }}"
                    class="rounded-xl bg-[#2563EB] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    Daftar
                </a>

            @endauth

        </div>

    </div>
</nav>


{{-- ============================================================
     MOBILE TOP NAVIGATION
============================================================ --}}

<nav
    class="fixed inset-x-0 top-0 z-50 flex h-16 items-center border-b border-slate-200/80 bg-white/95 px-4 backdrop-blur-xl lg:hidden"
>

    {{-- Logo --}}
    <a href="{{ $homeUrl }}" class="flex items-center gap-2">

        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#2563EB] text-white">
            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path d="M12 3v18"/>
                <path d="M5 8h14"/>
                <path d="M7 8c0 4 2 6 5 6s5-2 5-6"/>
                <path d="M5 18h14"/>
            </svg>
        </div>

        <span class="text-base font-extrabold tracking-tight text-slate-900">
            ProKerja
        </span>

    </a>


    <div class="ml-auto flex items-center gap-1">

        {{-- Quick JobBoard --}}
        <a
            href="{{ $jobsUrl }}"
            class="flex h-10 items-center rounded-xl px-3 text-xs font-bold text-slate-600 transition hover:bg-slate-50"
        >
            JobBoard
        </a>


        @auth

            {{-- Notification --}}
            <a
                href="{{ $notificationUrl }}"
                class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-500"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                    <path d="M10 21h4"/>
                </svg>

                <span
                    id="marketplace-mobile-notification-badge"
                    class="absolute right-1 top-1 hidden min-w-[17px] rounded-full bg-rose-500 px-1 text-center text-[9px] font-bold leading-[17px] text-white"
                ></span>
            </a>

        @endauth


        {{-- More --}}
        <button
            type="button"
            id="marketplace-mobile-menu-button"
            class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-50"
            aria-label="Menu"
        >
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <circle cx="5" cy="12" r="1"/>
                <circle cx="12" cy="12" r="1"/>
                <circle cx="19" cy="12" r="1"/>
            </svg>
        </button>

    </div>

</nav>


{{-- ============================================================
     MOBILE MORE MENU
============================================================ --}}

<div
    id="marketplace-mobile-menu"
    class="fixed inset-x-0 top-16 z-40 hidden border-b border-slate-200 bg-white shadow-xl lg:hidden"
>

    <div class="mx-auto max-w-7xl p-4">

        <div class="grid grid-cols-2 gap-2">

            <a
                href="{{ $homeUrl }}"
                class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
            >
                Beranda
            </a>

            <a
                href="{{ $searchUrl }}"
                class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
            >
                Cari Jasa
            </a>

            <a
                href="{{ $searchUrl }}#kategori"
                class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
            >
                Kategori
            </a>

            @auth

                @if($role === 'client')

                    <a
                        href="{{ $dashboardUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ $projectsUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Proyek Saya
                    </a>

                    <a
                        href="{{ $favoritesUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Favorit
                    </a>

                @elseif($role === 'freelancer')

                    <a
                        href="{{ $dashboardUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ $projectsUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Cari Job
                    </a>

                    <a
                        href="{{ $servicesUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Layanan Saya
                    </a>

                    <a
                        href="{{ $walletUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Wallet
                    </a>

                    <a
                        href="{{ $withdrawalsUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Penarikan
                    </a>

                    <a
                        href="{{ $verificationUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Verifikasi
                    </a>

                @elseif($role === 'admin')

                    <a
                        href="{{ $adminDashboardUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Admin Dashboard
                    </a>

                    <a
                        href="{{ $adminUsersUrl }}"
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                    >
                        Pengguna
                    </a>

                @endif

                <a
                    href="{{ $profileUrl }}"
                    class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                >
                    Profil
                </a>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="col-span-2"
                >
                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-2xl border border-rose-100 bg-rose-50 p-4 text-left text-sm font-semibold text-rose-600"
                    >
                        Keluar
                    </button>
                </form>

            @else

                <a
                    href="{{ Route::has('login') ? route('login') : '#' }}"
                    class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700"
                >
                    Masuk
                </a>

                <a
                    href="{{ Route::has('register') ? route('register') : '#' }}"
                    class="rounded-2xl bg-[#2563EB] p-4 text-sm font-semibold text-white"
                >
                    Daftar
                </a>

            @endauth

        </div>

    </div>

</div>


{{-- ============================================================
     MOBILE BOTTOM NAVIGATION
============================================================ --}}

<nav
    class="fixed inset-x-0 bottom-0 z-50 h-[72px] border-t border-slate-200/80 bg-white/95 px-3 pb-safe backdrop-blur-xl lg:hidden"
>

    <div class="mx-auto grid h-full max-w-lg grid-cols-5 items-center">

        {{-- Home --}}
        <a
            href="{{ $homeUrl }}"
            class="flex h-full flex-col items-center justify-center gap-1 text-[10px] font-semibold {{ $isHome ? 'text-[#2563EB]' : 'text-slate-400' }}"
        >
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path d="m3 10 9-7 9 7"/>
                <path d="M5 9v11h14V9"/>
                <path d="M9 20v-6h6v6"/>
            </svg>

            <span>Beranda</span>
        </a>


        {{-- Search --}}
        <a
            href="{{ $searchUrl }}"
            class="flex h-full flex-col items-center justify-center gap-1 text-[10px] font-semibold {{ $isSearch ? 'text-[#2563EB]' : 'text-slate-400' }}"
        >
            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <circle cx="11" cy="11" r="7"/>
                <path d="m20 20-4-4"/>
            </svg>

            <span>Cari</span>
        </a>


        @auth

            {{-- Messages --}}
            <a
                href="{{ $messagesUrl }}"
                class="flex h-full flex-col items-center justify-center gap-1 text-[10px] font-semibold {{ $isMessages ? 'text-[#2563EB]' : 'text-slate-400' }}"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H7l-4 2v-4.5A7.5 7.5 0 1 1 20 11.5Z"/>
                </svg>

                <span>Pesan</span>
            </a>


            {{-- Orders --}}
            <a
                href="{{ $ordersUrl }}"
                class="flex h-full flex-col items-center justify-center gap-1 text-[10px] font-semibold {{ $isOrders ? 'text-[#2563EB]' : 'text-slate-400' }}"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <rect x="4" y="4" width="16" height="16" rx="2"/>
                    <path d="M8 9h8"/>
                    <path d="M8 13h5"/>
                </svg>

                <span>Pesanan</span>
            </a>


            {{-- Profile --}}
            <a
                href="{{ $profileUrl }}"
                class="flex h-full flex-col items-center justify-center gap-1 text-[10px] font-semibold {{ $isProfile ? 'text-[#2563EB]' : 'text-slate-400' }}"
            >
                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-slate-100 text-[9px] font-bold text-slate-500">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>

                <span>Profil</span>
            </a>

        @else

            {{-- JobBoard --}}
            <a
                href="{{ $jobsUrl }}"
                class="flex h-full flex-col items-center justify-center gap-1 text-[10px] font-semibold {{ $isJobs ? 'text-[#2563EB]' : 'text-slate-400' }}"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <rect x="3" y="5" width="18" height="15" rx="2"/>
                    <path d="M8 5V3h8v2"/>
                    <path d="M3 10h18"/>
                </svg>

                <span>JobBoard</span>
            </a>


            {{-- Login --}}
            <a
                href="{{ Route::has('login') ? route('login') : '#' }}"
                class="flex h-full flex-col items-center justify-center gap-1 text-[10px] font-semibold text-slate-400"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M10 17l5-5-5-5"/>
                    <path d="M15 12H3"/>
                    <path d="M21 19V5a2 2 0 0 0-2-2h-6"/>
                </svg>

                <span>Masuk</span>
            </a>


            {{-- Register --}}
            <a
                href="{{ Route::has('register') ? route('register') : '#' }}"
                class="flex h-full flex-col items-center justify-center gap-1 text-[10px] font-semibold text-slate-400"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M5 21a7 7 0 0 1 14 0"/>
                </svg>

                <span>Daftar</span>
            </a>

        @endauth

    </div>

</nav>


{{-- ============================================================
     NAVBAR SPACER
     Ini yang memastikan konten halaman tidak tertutup navbar.
============================================================ --}}

<div
    class="h-16 w-full lg:h-[72px]"
    aria-hidden="true"
></div>


{{-- ============================================================
     JAVASCRIPT
============================================================ --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Desktop Profile Dropdown
    |--------------------------------------------------------------------------
    */
    const profileButton = document.getElementById(
        'marketplace-profile-button'
    );

    const profileMenu = document.getElementById(
        'marketplace-profile-menu'
    );

    if (profileButton && profileMenu) {

        profileButton.addEventListener('click', function (event) {

            event.stopPropagation();

            profileMenu.classList.toggle('hidden');

        });

        document.addEventListener('click', function (event) {

            if (
                !profileMenu.contains(event.target) &&
                !profileButton.contains(event.target)
            ) {
                profileMenu.classList.add('hidden');
            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Mobile More Menu
    |--------------------------------------------------------------------------
    */
    const mobileMenuButton = document.getElementById(
        'marketplace-mobile-menu-button'
    );

    const mobileMenu = document.getElementById(
        'marketplace-mobile-menu'
    );

    if (mobileMenuButton && mobileMenu) {

        mobileMenuButton.addEventListener('click', function () {

            mobileMenu.classList.toggle('hidden');

        });

        document.addEventListener('click', function (event) {

            if (
                !mobileMenu.contains(event.target) &&
                !mobileMenuButton.contains(event.target)
            ) {
                mobileMenu.classList.add('hidden');
            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Hide Mobile Bottom Navigation While Typing
    |--------------------------------------------------------------------------
    */
    const bottomNavigation = document.querySelector(
        'nav.fixed.bottom-0'
    );

    if (bottomNavigation) {

        document.addEventListener('focusin', function (event) {

            const target = event.target;

            if (
                target.matches('input, textarea, select')
            ) {
                bottomNavigation.classList.add('translate-y-full');
            }

        });

        document.addEventListener('focusout', function (event) {

            setTimeout(function () {

                const active = document.activeElement;

                if (
                    !active ||
                    !active.matches('input, textarea, select')
                ) {
                    bottomNavigation.classList.remove(
                        'translate-y-full'
                    );
                }

            }, 100);

        });

    }

});
</script>