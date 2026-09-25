@php
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | AUTH & ROLE
    |--------------------------------------------------------------------------
    */

    $isAuthenticated = auth()->check();
    $user = $isAuthenticated ? auth()->user() : null;
    $role = $user?->role;


    /*
    |--------------------------------------------------------------------------
    | PUBLIC / MARKETPLACE URL
    |--------------------------------------------------------------------------
    */

    $homeUrl = Route::has('marketplace.home')
        ? route('marketplace.home')
        : url('/');

    $searchUrl = Route::has('marketplace.search')
        ? route('marketplace.search')
        : $homeUrl;

    $jobsUrl = Route::has('marketplace.jobs.index')
        ? route('marketplace.jobs.index')
        : $homeUrl . '#jobboard';

    $categoryUrl = $homeUrl . '#kategori';
    $freelancerUrl = $homeUrl . '#freelancer';


    /*
    |--------------------------------------------------------------------------
    | ROLE URL
    |--------------------------------------------------------------------------
    */

    $dashboardUrl = null;
    $ordersUrl = null;
    $messagesUrl = null;
    $profileUrl = null;
    $projectsUrl = null;

    if ($role === 'client') {
        $dashboardUrl = Route::has('client.dashboard')
            ? route('client.dashboard')
            : null;

        $ordersUrl = Route::has('client.orders.index')
            ? route('client.orders.index')
            : null;

        $messagesUrl = Route::has('client.messages.index')
            ? route('client.messages.index')
            : null;

        $profileUrl = Route::has('profile.show')
            ? route('profile.show')
            : null;

        $projectsUrl = Route::has('client.jobs.index')
            ? route('client.jobs.index')
            : null;
    }

    if ($role === 'freelancer') {
        $dashboardUrl = Route::has('freelancer.dashboard')
            ? route('freelancer.dashboard')
            : null;

        $ordersUrl = Route::has('freelancer.orders.index')
            ? route('freelancer.orders.index')
            : null;

        $messagesUrl = Route::has('freelancer.messages.index')
            ? route('freelancer.messages.index')
            : null;

        $profileUrl = Route::has('freelancer.profile.show')
            ? route('freelancer.profile.show')
            : null;

        $projectsUrl = Route::has('freelancer.jobs.index')
            ? route('freelancer.jobs.index')
            : null;
    }

    if ($role === 'admin') {
        $dashboardUrl = Route::has('admin.dashboard')
            ? route('admin.dashboard')
            : null;
    }


    /*
    |--------------------------------------------------------------------------
    | CURRENT PAGE
    |--------------------------------------------------------------------------
    */

    $isHome = request()->routeIs('marketplace.home');

    $isSearch = request()->routeIs('marketplace.search');

    $isCategory = request()->routeIs('marketplace.category');

    $isService = request()->routeIs('marketplace.service');

    $isJobs = request()->routeIs('marketplace.jobs.*');

    $isClientArea = request()->routeIs('client.*');

    $isFreelancerArea = request()->routeIs('freelancer.*');

    $isAdminArea = request()->routeIs('admin.*');

    $isNotifications = request()->routeIs('notifications.*');

    $isProfile =
        request()->routeIs('profile.*') ||
        request()->routeIs('freelancer.profile.*');


    /*
    |--------------------------------------------------------------------------
    | OPTIONAL ROLE ROUTES
    |--------------------------------------------------------------------------
    */

    $favoriteUrl = Route::has('client.favorites.index')
        ? route('client.favorites.index')
        : null;

    $clientProjectsUrl = Route::has('client.jobs.index')
        ? route('client.jobs.index')
        : null;

    $freelancerServicesUrl = Route::has('freelancer.services.index')
        ? route('freelancer.services.index')
        : null;

    $freelancerWalletUrl = Route::has('freelancer.wallet.index')
        ? route('freelancer.wallet.index')
        : null;

    $freelancerWithdrawalsUrl = Route::has('freelancer.withdrawals.index')
        ? route('freelancer.withdrawals.index')
        : null;

    $freelancerVerificationUrl = Route::has('freelancer.verification.index')
        ? route('freelancer.verification.index')
        : null;

    $adminUsersUrl = Route::has('admin.users.index')
        ? route('admin.users.index')
        : null;

    $adminServicesUrl = Route::has('admin.services.index')
        ? route('admin.services.index')
        : null;

    $adminBannerUrl = Route::has('admin.banners.index')
        ? route('admin.banners.index')
        : null;

    $adminCategoriesUrl = Route::has('admin.categories.index')
        ? route('admin.categories.index')
        : null;

    $notificationUrl = Route::has('notifications.index')
        ? route('notifications.index')
        : null;
@endphp


<div
    x-data="{
        moreOpen: false,
        profileOpen: false,
        categoryOpen: false,
        mobileProfileOpen: false,

        closeMenus() {
            this.moreOpen = false;
            this.profileOpen = false;
            this.categoryOpen = false;
            this.mobileProfileOpen = false;
        }
    }"
    @keydown.escape.window="closeMenus()"
    @click.outside="closeMenus()"
    class="relative z-50"
>

    {{-- ========================================================= --}}
    {{-- DESKTOP NAVBAR --}}
    {{-- ========================================================= --}}

    <header
        class="hidden lg:block fixed top-0 inset-x-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur-xl"
    >
        <div class="mx-auto flex h-[72px] max-w-7xl items-center px-6">

            {{-- LOGO --}}
            <a
                href="{{ $homeUrl }}"
                class="group flex shrink-0 items-center gap-3"
            >
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#2563EB] text-lg font-black text-white shadow-sm transition duration-200 group-hover:-translate-y-0.5 group-hover:shadow-md"
                >
                    P
                </div>

                <div class="leading-none">
                    <div class="text-[17px] font-extrabold tracking-tight text-slate-900">
                        ProKerja
                    </div>

                    <div class="mt-1 text-[10px] font-medium tracking-wide text-slate-400">
                        Marketplace Jasa Profesional
                    </div>
                </div>
            </a>


            {{-- MAIN NAV --}}
            <nav class="ml-10 flex h-full items-center gap-1">

                {{-- HOME --}}
                <a
                    href="{{ $homeUrl }}"
                    class="relative flex h-full items-center px-4 text-sm font-semibold transition
                        {{ $isHome
                            ? 'text-[#2563EB]'
                            : 'text-slate-600 hover:text-[#2563EB]' }}"
                >
                    Beranda

                    @if ($isHome)
                        <span class="absolute bottom-0 left-4 right-4 h-0.5 rounded-full bg-[#2563EB]"></span>
                    @endif
                </a>


                {{-- CARI JASA --}}
                <a
                    href="{{ $searchUrl }}"
                    class="relative flex h-full items-center px-4 text-sm font-semibold transition
                        {{ $isSearch || $isService || $isCategory
                            ? 'text-[#2563EB]'
                            : 'text-slate-600 hover:text-[#2563EB]' }}"
                >
                    Cari Jasa

                    @if ($isSearch || $isService || $isCategory)
                        <span class="absolute bottom-0 left-4 right-4 h-0.5 rounded-full bg-[#2563EB]"></span>
                    @endif
                </a>


                {{-- KATEGORI --}}
                <div class="relative h-full flex items-center">

                    <button
                        type="button"
                        @click.stop="categoryOpen = !categoryOpen; profileOpen = false"
                        class="flex h-full items-center gap-1 px-4 text-sm font-semibold text-slate-600 transition hover:text-[#2563EB]"
                    >
                        Kategori

                        <svg
                            class="h-4 w-4 transition-transform duration-200"
                            :class="{ 'rotate-180': categoryOpen }"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m19 9-7 7-7-7"
                            />
                        </svg>
                    </button>


                    <div
                        x-show="categoryOpen"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute left-0 top-[68px] w-64 overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-xl"
                        style="display: none;"
                    >

                        <a
                            href="{{ $categoryUrl }}"
                            class="flex items-start gap-3 rounded-xl px-3 py-3 transition hover:bg-blue-50"
                        >
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </span>

                            <span>
                                <span class="block text-sm font-bold text-slate-800">
                                    Semua Kategori
                                </span>

                                <span class="mt-0.5 block text-xs text-slate-500">
                                    Lihat seluruh kategori jasa
                                </span>
                            </span>
                        </a>


                        <a
                            href="{{ $searchUrl }}"
                            class="flex items-start gap-3 rounded-xl px-3 py-3 transition hover:bg-blue-50"
                        >
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="11" cy="11" r="6"/>
                                    <path stroke-linecap="round" d="m16 16 4 4"/>
                                </svg>
                            </span>

                            <span>
                                <span class="block text-sm font-bold text-slate-800">
                                    Cari Berdasarkan Kategori
                                </span>

                                <span class="mt-0.5 block text-xs text-slate-500">
                                    Temukan jasa sesuai kebutuhan
                                </span>
                            </span>
                        </a>

                    </div>
                </div>


                {{-- JOB BOARD --}}
                <a
                    href="{{ $jobsUrl }}"
                    class="relative flex h-full items-center px-4 text-sm font-semibold transition
                        {{ $isJobs
                            ? 'text-[#2563EB]'
                            : 'text-slate-600 hover:text-[#2563EB]' }}"
                >
                    JobBoard

                    @if ($isJobs)
                        <span class="absolute bottom-0 left-4 right-4 h-0.5 rounded-full bg-[#2563EB]"></span>
                    @endif
                </a>

            </nav>


            {{-- RIGHT SIDE --}}
            <div class="ml-auto flex items-center gap-2">

                @if ($isAuthenticated)

                    {{-- NOTIFICATION --}}
                    @if ($notificationUrl)
                        <a
                            href="{{ $notificationUrl }}"
                            class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-[#2563EB]"
                            title="Notifikasi"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 17h5l-1.5-1.7A2 2 0 0 1 18 14V10a6 6 0 1 0-12 0v4a2 2 0 0 1-.5 1.3L4 17h5"
                                />
                                <path
                                    stroke-linecap="round"
                                    d="M9.5 20a2.5 2.5 0 0 0 5 0"
                                />
                            </svg>

                            <span
                                id="desktop-notification-badge"
                                class="absolute right-1.5 top-1.5 hidden min-w-[17px] rounded-full bg-rose-500 px-1 text-center text-[9px] font-bold leading-[17px] text-white"
                            >
                                0
                            </span>
                        </a>
                    @endif


                    {{-- ADMIN PANEL --}}
                    @if ($role === 'admin' && $dashboardUrl)
                        <a
                            href="{{ $dashboardUrl }}"
                            class="hidden xl:flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-bold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M12 3v18"/>
                            </svg>

                            Admin Panel
                        </a>
                    @endif


                    {{-- PROFILE DROPDOWN --}}
                    <div class="relative">

                        <button
                            type="button"
                            @click.stop="profileOpen = !profileOpen; categoryOpen = false"
                            class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white py-1.5 pl-1.5 pr-3 transition hover:border-blue-200 hover:bg-blue-50/50"
                        >

                            <div class="flex h-8 w-8 items-center justify-center overflow-hidden rounded-xl bg-blue-100 text-xs font-bold text-[#2563EB]">
                                @if ($user?->avatar)
                                    <img
                                        src="{{ asset('storage/' . $user->avatar) }}"
                                        alt="{{ $user->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                                @endif
                            </div>

                            <div class="hidden xl:block text-left">
                                <div class="max-w-[120px] truncate text-xs font-bold text-slate-800">
                                    {{ $user?->name ?? 'Pengguna' }}
                                </div>

                                <div class="text-[10px] capitalize text-slate-400">
                                    {{ $role ?? 'user' }}
                                </div>
                            </div>

                            <svg
                                class="h-4 w-4 text-slate-400 transition"
                                :class="{ 'rotate-180': profileOpen }"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                            </svg>

                        </button>


                        {{-- PROFILE MENU --}}
                        <div
                            x-show="profileOpen"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            class="absolute right-0 top-[54px] w-72 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl"
                            style="display: none;"
                        >

                            {{-- USER HEADER --}}
                            <div class="border-b border-slate-100 bg-slate-50/80 px-4 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-blue-100 text-sm font-bold text-[#2563EB]">
                                        @if ($user?->avatar)
                                            <img
                                                src="{{ asset('storage/' . $user->avatar) }}"
                                                alt="{{ $user->name }}"
                                                class="h-full w-full object-cover"
                                            >
                                        @else
                                            {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <div class="truncate text-sm font-bold text-slate-900">
                                            {{ $user?->name ?? 'Pengguna' }}
                                        </div>

                                        <div class="mt-0.5 truncate text-xs text-slate-500">
                                            {{ $user?->email ?? '' }}
                                        </div>

                                        <span class="mt-1 inline-flex rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-bold capitalize text-[#2563EB]">
                                            {{ $role ?? 'user' }}
                                        </span>
                                    </div>

                                </div>

                            </div>


                            {{-- CLIENT --}}
                            @if ($role === 'client')

                                <div class="p-2">

                                    @if ($dashboardUrl)
                                        <a
                                            href="{{ $dashboardUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold {{ $isClientArea && request()->routeIs('client.dashboard') ? 'bg-blue-50 text-[#2563EB]' : 'text-slate-700 hover:bg-slate-50' }}"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10Zm10 8h8V11h-8v10ZM3 21h8v-6H3v6Zm10-12h8V3h-8v6Z"/>
                                                </svg>
                                            </span>
                                            Dashboard
                                        </a>
                                    @endif


                                    @if ($favoriteUrl)
                                        <a
                                            href="{{ $favoriteUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-500">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m12 20-1.4-1.3C5.4 14 2 10.9 2 7.2A5.2 5.2 0 0 1 7.2 2c1.8 0 3.6.8 4.8 2.1A6.5 6.5 0 0 1 16.8 2 5.2 5.2 0 0 1 22 7.2c0 3.7-3.4 6.8-8.6 11.5L12 20Z"/>
                                                </svg>
                                            </span>
                                            Favorit
                                        </a>
                                    @endif


                                    @if ($ordersUrl)
                                        <a
                                            href="{{ $ordersUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12v18H6z"/>
                                                    <path stroke-linecap="round" d="M9 7h6M9 11h6M9 15h4"/>
                                                </svg>
                                            </span>
                                            Pesanan
                                        </a>
                                    @endif


                                    @if ($messagesUrl)
                                        <a
                                            href="{{ $messagesUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 11.5a7.5 7.5 0 0 1-8 7.5 8.5 8.5 0 0 1-4-.9L4 19l.9-3.2A7.4 7.4 0 0 1 4 11.5 7.5 7.5 0 0 1 20 11.5Z"/>
                                                </svg>
                                            </span>
                                            Pesan
                                        </a>
                                    @endif


                                    @if ($clientProjectsUrl)
                                        <a
                                            href="{{ $clientProjectsUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16v13H4z"/>
                                                    <path stroke-linecap="round" d="M8 7V5h8v2"/>
                                                </svg>
                                            </span>
                                            Proyek Saya
                                        </a>
                                    @endif


                                    @if ($profileUrl)
                                        <a
                                            href="{{ $profileUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"/>
                                                </svg>
                                            </span>
                                            Profil
                                        </a>
                                    @endif

                                </div>

                            @endif


                            {{-- FREELANCER --}}
                            @if ($role === 'freelancer')

                                <div class="p-2">

                                    @if ($dashboardUrl)
                                        <a
                                            href="{{ $dashboardUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10Zm10 8h8V11h-8v10ZM3 21h8v-6H3v6Zm10-12h8V3h-8v6Z"/>
                                                </svg>
                                            </span>
                                            Dashboard
                                        </a>
                                    @endif


                                    @if ($freelancerServicesUrl)
                                        <a
                                            href="{{ $freelancerServicesUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v14H4z"/>
                                                    <path stroke-linecap="round" d="M8 6V4h8v2M8 11h8M8 15h5"/>
                                                </svg>
                                            </span>
                                            Layanan Saya
                                        </a>
                                    @endif


                                    @if ($ordersUrl)
                                        <a
                                            href="{{ $ordersUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12v18H6z"/>
                                                    <path stroke-linecap="round" d="M9 7h6M9 11h6M9 15h4"/>
                                                </svg>
                                            </span>
                                            Pesanan
                                        </a>
                                    @endif


                                    @if ($messagesUrl)
                                        <a
                                            href="{{ $messagesUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 11.5a7.5 7.5 0 0 1-8 7.5 8.5 8.5 0 0 1-4-.9L4 19l.9-3.2A7.4 7.4 0 0 1 4 11.5 7.5 7.5 0 0 1 20 11.5Z"/>
                                                </svg>
                                            </span>
                                            Pesan
                                        </a>
                                    @endif


                                    @if ($projectsUrl)
                                        <a
                                            href="{{ $projectsUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16v13H4z"/>
                                                    <path stroke-linecap="round" d="M8 7V5h8v2"/>
                                                </svg>
                                            </span>
                                            Cari Job
                                        </a>
                                    @endif


                                    @if ($freelancerWalletUrl)
                                        <a
                                            href="{{ $freelancerWalletUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-50 text-cyan-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18v12H3z"/>
                                                    <path stroke-linecap="round" d="M16 13h2"/>
                                                    <path stroke-linecap="round" d="M3 7V5h14v2"/>
                                                </svg>
                                            </span>
                                            Wallet
                                        </a>
                                    @endif


                                    @if ($freelancerWithdrawalsUrl)
                                        <a
                                            href="{{ $freelancerWithdrawalsUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v13"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m7 11 5 5 5-5"/>
                                                    <path stroke-linecap="round" d="M4 21h16"/>
                                                </svg>
                                            </span>
                                            Penarikan
                                        </a>
                                    @endif


                                    @if ($freelancerVerificationUrl)
                                        <a
                                            href="{{ $freelancerVerificationUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 4h14v16H5z"/>
                                                </svg>
                                            </span>
                                            Verifikasi
                                        </a>
                                    @endif


                                    @if ($profileUrl)
                                        <a
                                            href="{{ $profileUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"/>
                                                </svg>
                                            </span>
                                            Profil
                                        </a>
                                    @endif

                                </div>

                            @endif


                            {{-- ADMIN --}}
                            @if ($role === 'admin')

                                <div class="p-2">

                                    @if ($dashboardUrl)
                                        <a
                                            href="{{ $dashboardUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10Zm10 8h8V11h-8v10ZM3 21h8v-6H3v6Zm10-12h8V3h-8v6Z"/>
                                                </svg>
                                            </span>
                                            Dashboard Admin
                                        </a>
                                    @endif


                                    @if ($adminUsersUrl)
                                        <a
                                            href="{{ $adminUsersUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                                                </svg>
                                            </span>
                                            Pengguna
                                        </a>
                                    @endif


                                    @if ($adminServicesUrl)
                                        <a
                                            href="{{ $adminServicesUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v14H4z"/>
                                                    <path stroke-linecap="round" d="M8 6V4h8v2"/>
                                                </svg>
                                            </span>
                                            Layanan
                                        </a>
                                    @endif


                                    @if ($adminCategoriesUrl)
                                        <a
                                            href="{{ $adminCategoriesUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16v14H4z"/>
                                                    <path stroke-linecap="round" d="M8 9h8M8 13h5"/>
                                                </svg>
                                            </span>
                                            Kategori
                                        </a>
                                    @endif


                                    @if ($adminBannerUrl)
                                        <a
                                            href="{{ $adminBannerUrl }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                                        >
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-500">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16v14H4z"/>
                                                    <circle cx="9" cy="10" r="1.5"/>
                                                    <path stroke-linecap="round" d="m5 17 4-4 3 3 3-5 4 6"/>
                                                </svg>
                                            </span>
                                            Banner
                                        </a>
                                    @endif

                                </div>

                            @endif


                            {{-- LOGOUT --}}
                            <div class="border-t border-slate-100 p-2">

                                <form
                                    method="POST"
                                    action="{{ route('logout') }}"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-rose-600 transition hover:bg-rose-50"
                                    >
                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" d="M10 17l5-5-5-5M15 12H3"/>
                                                <path stroke-linecap="round" d="M21 19V5a2 2 0 0 0-2-2h-6"/>
                                            </svg>
                                        </span>

                                        Keluar
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                @else

                    {{-- GUEST --}}
                    <a
                        href="{{ route('login') }}"
                        class="rounded-xl px-4 py-2 text-sm font-bold text-slate-600 transition hover:bg-slate-100 hover:text-[#2563EB]"
                    >
                        Masuk
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="rounded-xl bg-[#2563EB] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md"
                    >
                        Daftar
                    </a>

                @endif

            </div>

        </div>
    </header>



    {{-- ========================================================= --}}
    {{-- MOBILE TOP NAVBAR --}}
    {{-- ========================================================= --}}

    <header
        class="fixed inset-x-0 top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur-xl lg:hidden"
    >
        <div class="flex h-16 items-center justify-between px-4">

            {{-- LOGO --}}
            <a
                href="{{ $homeUrl }}"
                class="flex items-center gap-2.5"
            >
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#2563EB] text-sm font-black text-white">
                    P
                </div>

                <div class="leading-none">
                    <div class="text-[15px] font-extrabold tracking-tight text-slate-900">
                        ProKerja
                    </div>

                    <div class="mt-0.5 text-[8px] font-medium tracking-wide text-slate-400">
                        Marketplace Jasa
                    </div>
                </div>
            </a>


            {{-- MOBILE ACTIONS --}}
            <div class="flex items-center gap-1">

                @if ($isAuthenticated)

                    {{-- QUICK JOB --}}
                    <a
                        href="{{ $jobsUrl }}"
                        class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-[#2563EB]"
                        title="JobBoard"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16v13H4z"/>
                            <path stroke-linecap="round" d="M8 7V5h8v2"/>
                        </svg>
                    </a>


                    {{-- NOTIFICATION --}}
                    @if ($notificationUrl)
                        <a
                            href="{{ $notificationUrl }}"
                            class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-[#2563EB]"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.5-1.7A2 2 0 0 1 18 14V10a6 6 0 1 0-12 0v4a2 2 0 0 1-.5 1.3L4 17h5"/>
                                <path stroke-linecap="round" d="M9.5 20a2.5 2.5 0 0 0 5 0"/>
                            </svg>

                            <span
                                id="mobile-notification-badge"
                                class="absolute right-1.5 top-1.5 hidden min-w-[17px] rounded-full bg-rose-500 px-1 text-center text-[9px] font-bold leading-[17px] text-white"
                            >
                                0
                            </span>
                        </a>
                    @endif

                @endif


                {{-- MORE --}}
                <button
                    type="button"
                    @click.stop="moreOpen = !moreOpen"
                    class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-100"
                    aria-label="Menu"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="5" cy="12" r="1"/>
                        <circle cx="12" cy="12" r="1"/>
                        <circle cx="19" cy="12" r="1"/>
                    </svg>
                </button>

            </div>

        </div>


        {{-- MOBILE MORE MENU --}}
        <div
            x-show="moreOpen"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="absolute inset-x-0 top-16 border-b border-slate-200 bg-white shadow-xl"
            style="display: none;"
        >

            <div class="max-h-[calc(100vh-64px)] overflow-y-auto p-4">

                {{-- GUEST --}}
                @guest

                    <div class="grid grid-cols-2 gap-3">

                        <a
                            href="{{ route('login') }}"
                            class="flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-700"
                        >
                            Masuk
                        </a>

                        <a
                            href="{{ route('register') }}"
                            class="flex items-center justify-center rounded-2xl bg-[#2563EB] px-4 py-3 text-sm font-bold text-white"
                        >
                            Daftar
                        </a>

                    </div>

                @endguest


                {{-- CLIENT --}}
                @if ($role === 'client')

                    <div class="mb-4 rounded-2xl bg-blue-50 p-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl bg-blue-100 text-sm font-bold text-[#2563EB]">
                                @if ($user?->avatar)
                                    <img
                                        src="{{ asset('storage/' . $user->avatar) }}"
                                        alt="{{ $user->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                                @endif
                            </div>

                            <div class="min-w-0">
                                <div class="truncate text-sm font-bold text-slate-900">
                                    {{ $user?->name }}
                                </div>

                                <div class="text-xs text-blue-600">
                                    Area Client
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="space-y-1">

                        @if ($dashboardUrl)
                            <a href="{{ $dashboardUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-[#2563EB]">⌂</span>
                                Dashboard
                            </a>
                        @endif

                        @if ($favoriteUrl)
                            <a href="{{ $favoriteUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-rose-500">♡</span>
                                Favorit
                            </a>
                        @endif

                        @if ($clientProjectsUrl)
                            <a href="{{ $clientProjectsUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-amber-600">▣</span>
                                Proyek Saya
                            </a>
                        @endif

                        @if ($notificationUrl)
                            <a href="{{ $notificationUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-rose-500">●</span>
                                Notifikasi
                            </a>
                        @endif

                    </div>

                @endif


                {{-- FREELANCER --}}
                @if ($role === 'freelancer')

                    <div class="mb-4 rounded-2xl bg-blue-50 p-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl bg-blue-100 text-sm font-bold text-[#2563EB]">
                                @if ($user?->avatar)
                                    <img
                                        src="{{ asset('storage/' . $user->avatar) }}"
                                        alt="{{ $user->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                                @endif
                            </div>

                            <div class="min-w-0">
                                <div class="truncate text-sm font-bold text-slate-900">
                                    {{ $user?->name }}
                                </div>

                                <div class="text-xs text-blue-600">
                                    Area Freelancer
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="space-y-1">

                        @if ($dashboardUrl)
                            <a href="{{ $dashboardUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-[#2563EB]">⌂</span>
                                Dashboard
                            </a>
                        @endif

                        @if ($freelancerServicesUrl)
                            <a href="{{ $freelancerServicesUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-emerald-600">▣</span>
                                Layanan Saya
                            </a>
                        @endif

                        @if ($freelancerWalletUrl)
                            <a href="{{ $freelancerWalletUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-cyan-600">◉</span>
                                Wallet
                            </a>
                        @endif

                        @if ($freelancerWithdrawalsUrl)
                            <a href="{{ $freelancerWithdrawalsUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-orange-600">↓</span>
                                Penarikan
                            </a>
                        @endif

                        @if ($freelancerVerificationUrl)
                            <a href="{{ $freelancerVerificationUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-emerald-600">✓</span>
                                Verifikasi
                            </a>
                        @endif

                        @if ($notificationUrl)
                            <a href="{{ $notificationUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-rose-500">●</span>
                                Notifikasi
                            </a>
                        @endif

                    </div>

                @endif


                {{-- ADMIN --}}
                @if ($role === 'admin')

                    <div class="mb-4 rounded-2xl bg-slate-900 p-4">

                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Admin
                        </div>

                        <div class="mt-1 text-sm font-bold text-white">
                            Panel Administrasi ProKerja
                        </div>

                    </div>


                    <div class="space-y-1">

                        @if ($dashboardUrl)
                            <a href="{{ $dashboardUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-[#2563EB]">⌂</span>
                                Dashboard Admin
                            </a>
                        @endif

                        @if ($adminUsersUrl)
                            <a href="{{ $adminUsersUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-violet-600">●</span>
                                Pengguna
                            </a>
                        @endif

                        @if ($adminServicesUrl)
                            <a href="{{ $adminServicesUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-emerald-600">▣</span>
                                Layanan
                            </a>
                        @endif

                        @if ($adminBannerUrl)
                            <a href="{{ $adminBannerUrl }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="text-rose-500">▣</span>
                                Banner
                            </a>
                        @endif

                    </div>

                @endif


                {{-- LOGOUT --}}
                @auth

                    <div class="mt-4 border-t border-slate-100 pt-4">

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-bold text-rose-600 hover:bg-rose-50"
                            >
                                <span>↪</span>
                                Keluar
                            </button>

                        </form>

                    </div>

                @endauth

            </div>

        </div>

    </header>



    {{-- ========================================================= --}}
    {{-- MOBILE BOTTOM NAVIGATION --}}
    {{-- ========================================================= --}}

    <nav
        id="mobile-bottom-navigation"
        class="fixed inset-x-0 bottom-0 z-50 border-t border-slate-200 bg-white/95 shadow-[0_-6px_25px_rgba(15,23,42,0.06)] backdrop-blur-xl lg:hidden"
    >
        <div
            class="mx-auto grid h-[72px] max-w-md grid-cols-5 px-2 pb-[env(safe-area-inset-bottom)]"
        >

            {{-- HOME --}}
            <a
                href="{{ $homeUrl }}"
                class="group flex flex-col items-center justify-center gap-1 text-[10px] font-semibold
                    {{ $isHome ? 'text-[#2563EB]' : 'text-slate-500' }}"
            >
                <span
                    class="flex h-8 w-10 items-center justify-center rounded-xl transition
                        {{ $isHome ? 'bg-blue-50' : 'group-hover:bg-slate-50' }}"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V10Z"/>
                    </svg>
                </span>

                Beranda
            </a>


            {{-- SEARCH --}}
            <a
                href="{{ $searchUrl }}"
                class="group flex flex-col items-center justify-center gap-1 text-[10px] font-semibold
                    {{ $isSearch || $isService || $isCategory ? 'text-[#2563EB]' : 'text-slate-500' }}"
            >
                <span
                    class="flex h-8 w-10 items-center justify-center rounded-xl transition
                        {{ $isSearch || $isService || $isCategory ? 'bg-blue-50' : 'group-hover:bg-slate-50' }}"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="11" cy="11" r="6"/>
                        <path stroke-linecap="round" d="m16 16 4 4"/>
                    </svg>
                </span>

                Cari
            </a>


            {{-- THIRD ITEM --}}
            @if ($isAuthenticated && $messagesUrl)

                <a
                    href="{{ $messagesUrl }}"
                    class="group flex flex-col items-center justify-center gap-1 text-[10px] font-semibold
                        {{ request()->routeIs('client.messages.*') || request()->routeIs('freelancer.messages.*')
                            ? 'text-[#2563EB]'
                            : 'text-slate-500' }}"
                >
                    <span
                        class="flex h-8 w-10 items-center justify-center rounded-xl transition
                            {{ request()->routeIs('client.messages.*') || request()->routeIs('freelancer.messages.*')
                                ? 'bg-blue-50'
                                : 'group-hover:bg-slate-50' }}"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 11.5a7.5 7.5 0 0 1-8 7.5 8.5 8.5 0 0 1-4-.9L4 19l.9-3.2A7.4 7.4 0 0 1 4 11.5 7.5 7.5 0 0 1 20 11.5Z"/>
                        </svg>
                    </span>

                    Pesan
                </a>

            @else

                <a
                    href="{{ $jobsUrl }}"
                    class="group flex flex-col items-center justify-center gap-1 text-[10px] font-semibold
                        {{ $isJobs ? 'text-[#2563EB]' : 'text-slate-500' }}"
                >
                    <span
                        class="flex h-8 w-10 items-center justify-center rounded-xl transition
                            {{ $isJobs ? 'bg-blue-50' : 'group-hover:bg-slate-50' }}"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16v13H4z"/>
                            <path stroke-linecap="round" d="M8 7V5h8v2"/>
                        </svg>
                    </span>

                    JobBoard
                </a>

            @endif


            {{-- FOURTH --}}
            @if ($isAuthenticated && $ordersUrl)

                <a
                    href="{{ $ordersUrl }}"
                    class="group flex flex-col items-center justify-center gap-1 text-[10px] font-semibold
                        {{ request()->routeIs('client.orders.*') || request()->routeIs('freelancer.orders.*')
                            ? 'text-[#2563EB]'
                            : 'text-slate-500' }}"
                >
                    <span
                        class="flex h-8 w-10 items-center justify-center rounded-xl transition
                            {{ request()->routeIs('client.orders.*') || request()->routeIs('freelancer.orders.*')
                                ? 'bg-blue-50'
                                : 'group-hover:bg-slate-50' }}"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12v18H6z"/>
                            <path stroke-linecap="round" d="M9 7h6M9 11h6M9 15h4"/>
                        </svg>
                    </span>

                    Pesanan
                </a>

            @else

                <a
                    href="{{ route('login') }}"
                    class="group flex flex-col items-center justify-center gap-1 text-[10px] font-semibold text-slate-500"
                >
                    <span class="flex h-8 w-10 items-center justify-center rounded-xl group-hover:bg-slate-50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" d="M10 17l5-5-5-5M15 12H3"/>
                            <path stroke-linecap="round" d="M21 19V5a2 2 0 0 0-2-2h-6"/>
                        </svg>
                    </span>

                    Masuk
                </a>

            @endif


            {{-- FIFTH --}}
            @if ($isAuthenticated && $profileUrl)

                <a
                    href="{{ $profileUrl }}"
                    class="group flex flex-col items-center justify-center gap-1 text-[10px] font-semibold
                        {{ $isProfile ? 'text-[#2563EB]' : 'text-slate-500' }}"
                >
                    <span
                        class="flex h-8 w-10 items-center justify-center rounded-xl transition
                            {{ $isProfile ? 'bg-blue-50' : 'group-hover:bg-slate-50' }}"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"/>
                        </svg>
                    </span>

                    Profil
                </a>

            @else

                <a
                    href="{{ route('register') }}"
                    class="group flex flex-col items-center justify-center gap-1 text-[10px] font-semibold text-slate-500"
                >
                    <span class="flex h-8 w-10 items-center justify-center rounded-xl group-hover:bg-slate-50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16M4 12h16"/>
                        </svg>
                    </span>

                    Daftar
                </a>

            @endif

        </div>
    </nav>

</div>


{{-- ============================================================= --}}
{{-- NOTIFICATION BADGE SCRIPT --}}
{{-- ============================================================= --}}

@auth

<script>
document.addEventListener('DOMContentLoaded', function () {

    const desktopBadge = document.getElementById('desktop-notification-badge');
    const mobileBadge = document.getElementById('mobile-notification-badge');

    function updateNotificationBadge(count) {

        const badges = [
            desktopBadge,
            mobileBadge
        ];

        badges.forEach(function (badge) {

            if (!badge) {
                return;
            }

            if (count > 0) {

                badge.textContent = count > 99
                    ? '99+'
                    : count;

                badge.classList.remove('hidden');

            } else {

                badge.classList.add('hidden');

            }

        });
    }


    async function loadNotificationCount() {

        try {

            const response = await fetch(
                "{{ $notificationUrl ?? '#' }}",
                {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                }
            );

            if (!response.ok) {
                return;
            }

            const data = await response.json();

            if (typeof data.unread_count !== 'undefined') {
                updateNotificationBadge(
                    Number(data.unread_count)
                );
            }

        } catch (error) {
            // Silent fail.
        }

    }


    @if ($notificationUrl)
        loadNotificationCount();
    @endif

});
</script>

@endauth


{{-- ============================================================= --}}
{{-- MOBILE KEYBOARD HANDLING --}}
{{-- ============================================================= --}}

<script>
(function () {

    const navigation =
        document.getElementById('mobile-bottom-navigation');

    if (!navigation) {
        return;
    }


    function isInputFocused() {

        const active = document.activeElement;

        if (!active) {
            return false;
        }

        const tag = active.tagName;

        return (
            tag === 'INPUT' ||
            tag === 'TEXTAREA' ||
            tag === 'SELECT' ||
            active.isContentEditable
        );
    }


    function updateNavigationVisibility() {

        if (window.innerWidth >= 1024) {

            navigation.style.transform = '';

            return;
        }


        if (isInputFocused()) {

            navigation.style.transform =
                'translateY(110%)';

        } else {

            navigation.style.transform =
                'translateY(0)';

        }

    }


    navigation.style.transition =
        'transform 180ms ease';


    document.addEventListener(
        'focusin',
        updateNavigationVisibility
    );

    document.addEventListener(
        'focusout',
        function () {

            setTimeout(
                updateNavigationVisibility,
                80
            );

        }
    );


    if (window.visualViewport) {

        window.visualViewport.addEventListener(
            'resize',
            updateNavigationVisibility
        );

    }


    window.addEventListener(
        'resize',
        updateNavigationVisibility
    );

    window.addEventListener(
        'orientationchange',
        updateNavigationVisibility
    );


    updateNavigationVisibility();

})();
</script>