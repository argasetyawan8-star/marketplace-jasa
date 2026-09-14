@php
    $user = auth()->user();

    $isHome = request()->routeIs('marketplace.home');

    $isClient = $user?->role === 'client';
    $isFreelancer = $user?->role === 'freelancer';

    $profile = $user?->profile;
    $freelancerProfile = $user?->freelancerProfile;

    /*
    |--------------------------------------------------------------------------
    | Profile / Avatar
    |--------------------------------------------------------------------------
    */

    if ($isFreelancer) {
        $avatarPath = $freelancerProfile?->avatar;
        $profileRoute = route('freelancer.profile.show');
        $displayName = $user?->name ?? 'Freelancer';
    } else {
        $avatarPath = $profile?->avatar;

        $profileRoute = auth()->check()
            ? route('profile.show')
            : '#';

        $displayName = $user?->name ?? 'Profil';
    }

    $avatarUrl = $avatarPath
        ? asset('storage/' . $avatarPath)
        : null;
@endphp

<nav
    id="jasain-navbar"
    class="fixed inset-x-0 top-0 z-50 border-b border-[#E7EEEA] bg-white shadow-[0_2px_14px_rgba(18,49,40,0.05)]"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-[72px] items-center justify-between">

            {{-- =====================================================
                LOGO
            ====================================================== --}}
            <a
                href="{{ route('marketplace.home') }}"
                class="group flex shrink-0 items-center gap-2.5"
            >
                {{-- Logo --}}
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#0F6B3A] text-sm font-bold text-white transition duration-200 group-hover:scale-[1.03]"
                >
                    J
                </div>

                {{-- Brand --}}
                <div class="leading-none">

                    <div
                        class="text-[17px] font-semibold tracking-[-0.03em] text-[#123128]"
                    >
                        JASAIN
                    </div>

                    <div
                        class="mt-1 text-[8px] font-medium uppercase tracking-[0.09em] text-[#8B9B94]"
                    >
                        Marketplace Jasa
                    </div>

                </div>
            </a>


            {{-- =====================================================
                DESKTOP NAVIGATION
            ====================================================== --}}
            <div class="hidden items-center gap-7 lg:flex">

                {{-- Beranda --}}
                <a
                    href="{{ route('marketplace.home') }}"
                    class="jasain-nav-link relative py-2 text-[13px] font-medium transition-colors duration-200
                    {{ $isHome ? 'text-[#0F6B3A]' : 'text-[#40564C] hover:text-[#0F6B3A]' }}"
                >
                    <span>
                        Beranda
                    </span>

                    @if ($isHome)
                        <span
                            class="absolute -bottom-1 left-1/2 h-0.5 w-5 -translate-x-1/2 rounded-full bg-[#1E9E5A]"
                        ></span>
                    @endif
                </a>


                {{-- Cari Jasa --}}
                <a
                    href="{{ route('marketplace.search') }}"
                    class="jasain-nav-link relative py-2 text-[13px] font-medium transition-colors duration-200
                    {{
                        request()->routeIs('marketplace.search') ||
                        request()->routeIs('marketplace.category')
                            ? 'text-[#0F6B3A]'
                            : 'text-[#40564C] hover:text-[#0F6B3A]'
                    }}"
                >
                    <span>
                        Cari Jasa
                    </span>

                    @if (
                        request()->routeIs('marketplace.search') ||
                        request()->routeIs('marketplace.category')
                    )
                        <span
                            class="absolute -bottom-1 left-1/2 h-0.5 w-5 -translate-x-1/2 rounded-full bg-[#1E9E5A]"
                        ></span>
                    @endif
                </a>


                {{-- =================================================
                    CLIENT MENU
                ================================================== --}}
                @auth
                    @if ($isClient)

                        {{-- Dashboard --}}
                        <a
                            href="{{ route('client.dashboard') }}"
                            class="relative py-2 text-[13px] font-medium transition-colors duration-200
                            {{
                                request()->routeIs('client.dashboard')
                                    ? 'text-[#0F6B3A]'
                                    : 'text-[#40564C] hover:text-[#0F6B3A]'
                            }}"
                        >
                            <span>
                                Dashboard
                            </span>

                            @if (request()->routeIs('client.dashboard'))
                                <span
                                    class="absolute -bottom-1 left-1/2 h-0.5 w-5 -translate-x-1/2 rounded-full bg-[#1E9E5A]"
                                ></span>
                            @endif
                        </a>


                        {{-- Pesanan --}}
                        <a
                            href="{{ route('client.orders.index') }}"
                            class="relative py-2 text-[13px] font-medium transition-colors duration-200
                            {{
                                request()->routeIs('client.orders.*')
                                    ? 'text-[#0F6B3A]'
                                    : 'text-[#40564C] hover:text-[#0F6B3A]'
                            }}"
                        >
                            <span>
                                Pesanan
                            </span>

                            @if (request()->routeIs('client.orders.*'))
                                <span
                                    class="absolute -bottom-1 left-1/2 h-0.5 w-5 -translate-x-1/2 rounded-full bg-[#1E9E5A]"
                                ></span>
                            @endif
                        </a>


                        {{-- Favorit --}}
                        <a
                            href="{{ route('client.favorites.index') }}"
                            class="relative py-2 text-[13px] font-medium transition-colors duration-200
                            {{
                                request()->routeIs('client.favorites.*')
                                    ? 'text-[#0F6B3A]'
                                    : 'text-[#40564C] hover:text-[#0F6B3A]'
                            }}"
                        >
                            <span>
                                Favorit
                            </span>

                            @if (request()->routeIs('client.favorites.*'))
                                <span
                                    class="absolute -bottom-1 left-1/2 h-0.5 w-5 -translate-x-1/2 rounded-full bg-[#1E9E5A]"
                                ></span>
                            @endif
                        </a>


                    @elseif ($isFreelancer)

                        {{-- =================================================
                            FREELANCER MENU
                        ================================================== --}}

                        {{-- Dashboard --}}
                        <a
                            href="{{ route('freelancer.dashboard') }}"
                            class="relative py-2 text-[13px] font-medium transition-colors duration-200
                            {{
                                request()->routeIs('freelancer.dashboard')
                                    ? 'text-[#0F6B3A]'
                                    : 'text-[#40564C] hover:text-[#0F6B3A]'
                            }}"
                        >
                            <span>
                                Dashboard
                            </span>

                            @if (request()->routeIs('freelancer.dashboard'))
                                <span
                                    class="absolute -bottom-1 left-1/2 h-0.5 w-5 -translate-x-1/2 rounded-full bg-[#1E9E5A]"
                                ></span>
                            @endif
                        </a>


                        {{-- Jasa Saya --}}
                        <a
                            href="{{ route('freelancer.services.index') }}"
                            class="relative py-2 text-[13px] font-medium transition-colors duration-200
                            {{
                                request()->routeIs('freelancer.services.*')
                                    ? 'text-[#0F6B3A]'
                                    : 'text-[#40564C] hover:text-[#0F6B3A]'
                            }}"
                        >
                            <span>
                                Jasa Saya
                            </span>

                            @if (request()->routeIs('freelancer.services.*'))
                                <span
                                    class="absolute -bottom-1 left-1/2 h-0.5 w-5 -translate-x-1/2 rounded-full bg-[#1E9E5A]"
                                ></span>
                            @endif
                        </a>

                    @endif
                @endauth

            </div>


            {{-- =====================================================
                DESKTOP RIGHT SIDE
            ====================================================== --}}
            <div class="hidden items-center gap-2.5 lg:flex">

                @guest

                    {{-- Search --}}
                    <a
                        href="{{ route('marketplace.search') }}"
                        class="flex h-9 w-9 items-center justify-center rounded-full text-[#61736A] transition duration-200 hover:bg-[#F2F7F4] hover:text-[#0F6B3A]"
                        aria-label="Cari jasa"
                        title="Cari jasa"
                    >
                        <i class="bi bi-search text-[16px]"></i>
                    </a>


                    {{-- Masuk --}}
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex h-9 items-center justify-center rounded-full border border-[#D5E1DB] px-4 text-[12px] font-medium text-[#3F5149] transition duration-200 hover:border-[#BBD3C4] hover:bg-[#F4F8F5] hover:text-[#0F6B3A]"
                    >
                        Masuk
                    </a>


                    {{-- Daftar --}}
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex h-9 items-center justify-center rounded-full bg-[#1E9E5A] px-5 text-[12px] font-semibold text-white transition duration-200 hover:bg-[#178C4F]"
                    >
                        Daftar
                    </a>


                @else

                    {{-- Message --}}
                    @if ($isClient)

                        <a
                            href="{{ route('client.messages.index') }}"
                            class="flex h-9 w-9 items-center justify-center rounded-full text-[#60736A] transition duration-200 hover:bg-[#F2F7F4] hover:text-[#0F6B3A]"
                            title="Pesan"
                            aria-label="Pesan"
                        >
                            <i class="bi bi-chat-dots text-[16px]"></i>
                        </a>

                    @elseif ($isFreelancer)

                        <a
                            href="{{ route('freelancer.messages.index') }}"
                            class="flex h-9 w-9 items-center justify-center rounded-full text-[#60736A] transition duration-200 hover:bg-[#F2F7F4] hover:text-[#0F6B3A]"
                            title="Pesan"
                            aria-label="Pesan"
                        >
                            <i class="bi bi-chat-dots text-[16px]"></i>
                        </a>

                    @endif


                    {{-- Divider --}}
                    <div class="mx-1 h-5 w-px bg-[#E0E8E3]"></div>


                    {{-- Profile --}}
                    <a
                        href="{{ $profileRoute }}"
                        class="flex items-center rounded-full px-1 py-1 transition duration-200 hover:bg-[#F3F7F4]"
                        title="{{ $displayName }}"
                    >
                        @if ($avatarUrl)

                            <img
                                src="{{ $avatarUrl }}"
                                alt="{{ $displayName }}"
                                class="h-8 w-8 rounded-full object-cover ring-2 ring-[#E4EEE8]"
                            >

                        @else

                            <div
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-[#EAF7EF] text-xs font-semibold text-[#0F6B3A]"
                            >
                                {{ strtoupper(substr($displayName, 0, 1)) }}
                            </div>

                        @endif
                    </a>


                    {{-- Logout --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="flex h-9 w-9 items-center justify-center rounded-full text-[#84928C] transition duration-200 hover:bg-red-50 hover:text-red-500"
                            title="Keluar"
                            aria-label="Keluar"
                        >
                            <i class="bi bi-box-arrow-right text-[16px]"></i>
                        </button>
                    </form>

                @endguest

            </div>


            {{-- =====================================================
                MOBILE RIGHT SIDE
            ====================================================== --}}
            <div class="flex items-center gap-2 lg:hidden">

                @guest

                    {{-- Mobile Login --}}
                    <a
                        href="{{ route('login') }}"
                        class="hidden min-[400px]:inline-flex h-9 items-center rounded-full px-2.5 text-[12px] font-medium text-[#40564C] transition hover:bg-[#F3F7F4] hover:text-[#0F6B3A]"
                    >
                        Masuk
                    </a>


                    {{-- Mobile Register --}}
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex h-9 items-center rounded-full bg-[#1E9E5A] px-3.5 text-[12px] font-semibold text-white transition hover:bg-[#178C4F]"
                    >
                        Daftar
                    </a>

                @else

                    {{-- Mobile Profile --}}
                    <a
                        href="{{ $profileRoute }}"
                        class="flex items-center"
                        aria-label="Profil"
                    >
                        @if ($avatarUrl)

                            <img
                                src="{{ $avatarUrl }}"
                                alt="{{ $displayName }}"
                                class="h-8 w-8 rounded-full object-cover ring-2 ring-[#E4EEE8]"
                            >

                        @else

                            <div
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-[#EAF7EF] text-xs font-semibold text-[#0F6B3A]"
                            >
                                {{ strtoupper(substr($displayName, 0, 1)) }}
                            </div>

                        @endif
                    </a>

                @endguest


                {{-- Mobile Menu Button --}}
                <button
                    id="jasain-mobile-menu-button"
                    type="button"
                    class="flex h-9 w-9 items-center justify-center rounded-full border border-[#DDE7E1] bg-white text-[#40564C] transition hover:border-[#BFD6C7] hover:bg-[#F2F7F4] hover:text-[#0F6B3A]"
                    aria-label="Buka menu"
                    aria-expanded="false"
                >
                    <i
                        id="jasain-mobile-menu-icon"
                        class="bi bi-list text-[19px]"
                    ></i>
                </button>

            </div>

        </div>
    </div>


    {{-- =========================================================
        MOBILE MENU
    ========================================================== --}}
    <div
        id="mobile-marketplace-menu"
        class="hidden border-t border-[#E7EEEA] bg-white lg:hidden"
    >

        <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6">

            <div class="space-y-1">

                {{-- Beranda --}}
                <a
                    href="{{ route('marketplace.home') }}"
                    class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium transition
                    {{
                        $isHome
                            ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                            : 'text-[#40564C] hover:bg-[#F5F8F6] hover:text-[#0F6B3A]'
                    }}"
                >
                    <i class="bi bi-house-door text-[16px]"></i>

                    <span>
                        Beranda
                    </span>
                </a>


                {{-- Cari Jasa --}}
                <a
                    href="{{ route('marketplace.search') }}"
                    class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium transition
                    {{
                        request()->routeIs('marketplace.search') ||
                        request()->routeIs('marketplace.category')
                            ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                            : 'text-[#40564C] hover:bg-[#F5F8F6] hover:text-[#0F6B3A]'
                    }}"
                >
                    <i class="bi bi-search text-[16px]"></i>

                    <span>
                        Cari Jasa
                    </span>
                </a>


                @auth

                    <div class="my-2 border-t border-[#EDF2EF]"></div>

                    {{-- CLIENT --}}
                    @if ($isClient)

                        {{-- Dashboard --}}
                        <a
                            href="{{ route('client.dashboard') }}"
                            class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium text-[#40564C] transition hover:bg-[#F5F8F6] hover:text-[#0F6B3A]"
                        >
                            <i class="bi bi-grid text-[16px]"></i>

                            <span>
                                Dashboard
                            </span>
                        </a>


                        {{-- Pesanan --}}
                        <a
                            href="{{ route('client.orders.index') }}"
                            class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium text-[#40564C] transition hover:bg-[#F5F8F6] hover:text-[#0F6B3A]"
                        >
                            <i class="bi bi-bag text-[16px]"></i>

                            <span>
                                Pesanan
                            </span>
                        </a>


                        {{-- Favorit --}}
                        <a
                            href="{{ route('client.favorites.index') }}"
                            class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium text-[#40564C] transition hover:bg-[#F5F8F6] hover:text-[#0F6B3A]"
                        >
                            <i class="bi bi-heart text-[16px]"></i>

                            <span>
                                Favorit
                            </span>
                        </a>


                        {{-- Pesan --}}
                        <a
                            href="{{ route('client.messages.index') }}"
                            class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium text-[#40564C] transition hover:bg-[#F5F8F6] hover:text-[#0F6B3A]"
                        >
                            <i class="bi bi-chat-dots text-[16px]"></i>

                            <span>
                                Pesan
                            </span>
                        </a>


                    {{-- FREELANCER --}}
                    @elseif ($isFreelancer)

                        {{-- Dashboard --}}
                        <a
                            href="{{ route('freelancer.dashboard') }}"
                            class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium text-[#40564C] transition hover:bg-[#F5F8F6] hover:text-[#0F6B3A]"
                        >
                            <i class="bi bi-grid text-[16px]"></i>

                            <span>
                                Dashboard
                            </span>
                        </a>


                        {{-- Jasa Saya --}}
                        <a
                            href="{{ route('freelancer.services.index') }}"
                            class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium text-[#40564C] transition hover:bg-[#F5F8F6] hover:text-[#0F6B3A]"
                        >
                            <i class="bi bi-briefcase text-[16px]"></i>

                            <span>
                                Jasa Saya
                            </span>
                        </a>


                        {{-- Pesan --}}
                        <a
                            href="{{ route('freelancer.messages.index') }}"
                            class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium text-[#40564C] transition hover:bg-[#F5F8F6] hover:text-[#0F6B3A]"
                        >
                            <i class="bi bi-chat-dots text-[16px]"></i>

                            <span>
                                Pesan
                            </span>
                        </a>

                    @endif


                    {{-- Profile --}}
                    <a
                        href="{{ $profileRoute }}"
                        class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium text-[#40564C] transition hover:bg-[#F5F8F6] hover:text-[#0F6B3A]"
                    >
                        <i class="bi bi-person text-[16px]"></i>

                        <span>
                            Profil
                        </span>
                    </a>


                    {{-- Logout --}}
                    <div class="my-2 border-t border-[#EDF2EF]"></div>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="flex min-h-[44px] w-full items-center gap-3 rounded-xl px-3 text-left text-[13px] font-medium text-red-500 transition hover:bg-red-50"
                        >
                            <i class="bi bi-box-arrow-right text-[16px]"></i>

                            <span>
                                Keluar
                            </span>
                        </button>
                    </form>

                @else

                    {{-- Guest additional menu --}}
                    <div class="my-2 border-t border-[#EDF2EF]"></div>

                    {{-- Mobile Login --}}
                    <a
                        href="{{ route('login') }}"
                        class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium text-[#40564C] transition hover:bg-[#F5F8F6] hover:text-[#0F6B3A]"
                    >
                        <i class="bi bi-box-arrow-in-right text-[16px]"></i>

                        <span>
                            Masuk
                        </span>
                    </a>


                    {{-- Mobile Register --}}
                    <a
                        href="{{ route('register') }}"
                        class="flex min-h-[44px] items-center gap-3 rounded-xl px-3 text-[13px] font-medium text-[#40564C] transition hover:bg-[#F5F8F6] hover:text-[#0F6B3A]"
                    >
                        <i class="bi bi-person-plus text-[16px]"></i>

                        <span>
                            Daftar
                        </span>
                    </a>

                @endauth

            </div>
        </div>
    </div>
</nav>


{{-- ==========================================================
    MOBILE MENU SCRIPT
=========================================================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('jasain-mobile-menu-button');
        const menu = document.getElementById('mobile-marketplace-menu');
        const icon = document.getElementById('jasain-mobile-menu-icon');

        if (!button || !menu || !icon) {
            return;
        }

        function openMenu() {
            menu.classList.remove('hidden');

            button.setAttribute('aria-expanded', 'true');

            button.setAttribute('aria-label', 'Tutup menu');

            icon.classList.remove('bi-list');
            icon.classList.add('bi-x-lg');
        }

        function closeMenu() {
            menu.classList.add('hidden');

            button.setAttribute('aria-expanded', 'false');

            button.setAttribute('aria-label', 'Buka menu');

            icon.classList.remove('bi-x-lg');
            icon.classList.add('bi-list');
        }

        button.addEventListener('click', function () {
            const isOpen = button.getAttribute('aria-expanded') === 'true';

            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Close mobile menu when clicking a menu link
        |--------------------------------------------------------------------------
        */

        menu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                closeMenu();
            });
        });

        /*
        |--------------------------------------------------------------------------
        | Reset mobile menu when switching to desktop
        |--------------------------------------------------------------------------
        */

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024) {
                closeMenu();
            }
        });
    });
</script>