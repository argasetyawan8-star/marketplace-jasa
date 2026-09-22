@php
    $user = auth()->user();

    $profile = $user?->profile;

    $avatarUrl = $profile?->avatar
        ? asset('storage/' . $profile->avatar)
        : null;

    $initial = strtoupper(
        substr($user?->name ?: 'U', 0, 1)
    );

    // Active states
    $isHome = request()->routeIs('marketplace.home');

    $isSearch =
        request()->routeIs('marketplace.search')
        || request()->routeIs('marketplace.category')
        || request()->routeIs('marketplace.service')
        || request()->routeIs('marketplace.freelancer');

    $isDashboard = request()->routeIs('client.dashboard');

    $isOrders = request()->routeIs('client.orders.*');

    $isFavorites = request()->routeIs('client.favorites.*');

    $isMessages = request()->routeIs('client.messages.*');

    $isProfile = request()->routeIs('profile.*');

    $isNotifications = request()->routeIs('notifications.*');
@endphp


<header
    x-data="{ mobileMenuOpen: false }"
    class="sticky top-0 z-50 border-b border-[#E4ECE7] bg-white/95 backdrop-blur-xl"
>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- NAVBAR --}}
        <div class="flex h-[68px] items-center justify-between">

            {{-- LEFT --}}
            <div class="flex min-w-0 items-center gap-7 lg:gap-9">

                {{-- BRAND --}}
                <a
                    href="{{ route('marketplace.home') }}"
                    class="group flex shrink-0 items-center gap-2.5"
                >

                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#1E9E5A] text-white shadow-[0_4px_12px_rgba(30,158,90,0.15)] transition duration-200 group-hover:bg-[#0F6B3A]"
                    >
                        <span class="text-[15px] font-semibold">
                            J
                        </span>
                    </div>

                    <div class="hidden sm:block">

                        <p class="text-[16px] font-semibold tracking-[-0.035em] text-[#123128]">
                            JASAIN
                        </p>

                        <p class="-mt-0.5 text-[8px] font-medium uppercase tracking-[0.16em] text-[#8A9992]">
                            Marketplace Jasa
                        </p>

                    </div>

                </a>


                {{-- DESKTOP NAVIGATION --}}
                <nav class="hidden items-center gap-1 lg:flex">

                    {{-- Beranda --}}
                    <a
                        href="{{ route('marketplace.home') }}"
                        class="
                            group flex h-9 items-center gap-2 rounded-lg px-3 text-xs font-medium transition duration-200
                            {{ $isHome
                                ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                                : 'text-[#697B73] hover:bg-[#F5F9F7] hover:text-[#123128]' }}
                        "
                    >
                        <i
                            class="bi bi-house{{ $isHome ? '-fill' : '' }} text-[12px] transition"
                        ></i>

                        Beranda
                    </a>


                    {{-- Cari Jasa --}}
                    <a
                        href="{{ route('marketplace.search') }}"
                        class="
                            group flex h-9 items-center gap-2 rounded-lg px-3 text-xs font-medium transition duration-200
                            {{ $isSearch
                                ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                                : 'text-[#697B73] hover:bg-[#F5F9F7] hover:text-[#123128]' }}
                        "
                    >
                        <i class="bi bi-search text-[12px]"></i>

                        Cari Jasa
                    </a>


                    {{-- Dashboard --}}
                    <a
                        href="{{ route('client.dashboard') }}"
                        class="
                            group flex h-9 items-center gap-2 rounded-lg px-3 text-xs font-medium transition duration-200
                            {{ $isDashboard
                                ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                                : 'text-[#697B73] hover:bg-[#F5F9F7] hover:text-[#123128]' }}
                        "
                    >
                        <i
                            class="bi bi-grid{{ $isDashboard ? '-fill' : '' }} text-[12px]"
                        ></i>

                        Dashboard
                    </a>


                    {{-- Pesanan --}}
                    <a
                        href="{{ route('client.orders.index') }}"
                        class="
                            group flex h-9 items-center gap-2 rounded-lg px-3 text-xs font-medium transition duration-200
                            {{ $isOrders
                                ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                                : 'text-[#697B73] hover:bg-[#F5F9F7] hover:text-[#123128]' }}
                        "
                    >
                        <i
                            class="bi bi-bag{{ $isOrders ? '-fill' : '' }} text-[12px]"
                        ></i>

                        Pesanan
                    </a>


                    {{-- Favorit --}}
                    <a
                        href="{{ route('client.favorites.index') }}"
                        class="
                            group flex h-9 items-center gap-2 rounded-lg px-3 text-xs font-medium transition duration-200
                            {{ $isFavorites
                                ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                                : 'text-[#697B73] hover:bg-[#F5F9F7] hover:text-[#123128]' }}
                        "
                    >
                        <i
                            class="bi bi-heart{{ $isFavorites ? '-fill' : '' }} text-[12px]"
                        ></i>

                        Favorit
                    </a>

                </nav>

            </div>


            {{-- RIGHT --}}
            <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">

                {{-- Search Button --}}
                <a
                    href="{{ route('marketplace.search') }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-[#71837B] transition duration-200 hover:bg-[#F3F8F5] hover:text-[#1E9E5A]"
                    title="Cari jasa"
                    aria-label="Cari jasa"
                >
                    <i class="bi bi-search text-[14px]"></i>
                </a>


                {{-- Message --}}
                <a
                    href="{{ route('client.messages.index') }}"
                    class="
                        relative flex h-9 w-9 items-center justify-center rounded-lg transition duration-200
                        {{ $isMessages
                            ? 'bg-[#EAF7EF] text-[#1E9E5A]'
                            : 'text-[#71837B] hover:bg-[#F3F8F5] hover:text-[#1E9E5A]' }}
                    "
                    title="Pesan"
                    aria-label="Pesan"
                >
                    <i
                        class="bi bi-chat-dots{{ $isMessages ? '-fill' : '' }} text-[15px]"
                    ></i>
                </a>


                {{-- Notification --}}
                <div
                    class="
                        rounded-lg
                        {{ $isNotifications
                            ? 'bg-[#EAF7EF] text-[#1E9E5A]'
                            : 'text-[#71837B]' }}
                    "
                >
                    <x-notification-bell />
                </div>


                {{-- Divider --}}
                <div class="mx-1 hidden h-7 w-px bg-[#E8EFEB] sm:block"></div>


                {{-- Profile --}}
                <a
                    href="{{ route('profile.show') }}"
                    class="
                        group flex items-center gap-2 rounded-xl px-1.5 py-1
                        transition duration-200 hover:bg-[#F6FAF8]
                    "
                >

                    {{-- Avatar --}}
                    <div class="relative shrink-0">

                        @if($avatarUrl)

                            <img
                                src="{{ $avatarUrl }}"
                                alt="{{ $user->name }}"
                                class="h-9 w-9 rounded-full object-cover ring-2 ring-white"
                            >

                        @else

                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-[#EAF7EF] text-[11px] font-semibold text-[#1E9E5A]"
                            >
                                {{ $initial }}
                            </div>

                        @endif

                        {{-- Online --}}
                        <span
                            class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full border-2 border-white bg-[#35C978]"
                        ></span>

                    </div>


                    {{-- User Info --}}
                    <div class="hidden max-w-[125px] sm:block">

                        <p class="truncate text-xs font-semibold text-[#18382E]">
                            {{ $user->name }}
                        </p>

                        <p class="mt-0.5 text-[9px] font-medium text-[#8A9992]">
                            Client
                        </p>

                    </div>


                    <i class="bi bi-chevron-down hidden text-[9px] text-[#A1AEA8] sm:block"></i>

                </a>


                {{-- Logout --}}
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="hidden sm:block"
                >
                    @csrf

                    <button
                        type="submit"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-[#899890] transition duration-200 hover:bg-red-50 hover:text-red-500"
                        title="Keluar"
                    >
                        <i class="bi bi-box-arrow-right text-[15px]"></i>
                    </button>
                </form>


                {{-- Mobile --}}
                <button
                    type="button"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-[#697B73] transition duration-200 hover:bg-[#F3F8F5] hover:text-[#1E9E5A] lg:hidden"
                    aria-label="Buka menu"
                >
                    <i
                        class="text-[17px]"
                        :class="mobileMenuOpen ? 'bi bi-x-lg' : 'bi bi-list'"
                    ></i>
                </button>

            </div>

        </div>


        {{-- MOBILE MENU --}}
        <div
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="border-t border-[#E9EFEB] py-3 lg:hidden"
        >

            <nav class="space-y-1">


                {{-- Beranda --}}
                <a
                    href="{{ route('marketplace.home') }}"
                    class="
                        flex h-11 items-center gap-3 rounded-xl px-3 text-sm font-medium transition
                        {{ $isHome
                            ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                            : 'text-[#355248] hover:bg-[#F5F9F7]' }}
                    "
                >
                    <i
                        class="bi bi-house{{ $isHome ? '-fill' : '' }} w-5 text-center text-[15px] {{ $isHome ? 'text-[#1E9E5A]' : 'text-[#899A92]' }}"
                    ></i>

                    <span>Beranda</span>
                </a>


                {{-- Cari Jasa --}}
                <a
                    href="{{ route('marketplace.search') }}"
                    class="
                        flex h-11 items-center gap-3 rounded-xl px-3 text-sm font-medium transition
                        {{ $isSearch
                            ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                            : 'text-[#355248] hover:bg-[#F5F9F7]' }}
                    "
                >
                    <i
                        class="bi bi-search w-5 text-center text-[15px] {{ $isSearch ? 'text-[#1E9E5A]' : 'text-[#899A92]' }}"
                    ></i>

                    <span>Cari Jasa</span>
                </a>


                {{-- Dashboard --}}
                <a
                    href="{{ route('client.dashboard') }}"
                    class="
                        flex h-11 items-center gap-3 rounded-xl px-3 text-sm font-medium transition
                        {{ $isDashboard
                            ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                            : 'text-[#355248] hover:bg-[#F5F9F7]' }}
                    "
                >
                    <i
                        class="bi bi-grid{{ $isDashboard ? '-fill' : '' }} w-5 text-center text-[15px] {{ $isDashboard ? 'text-[#1E9E5A]' : 'text-[#899A92]' }}"
                    ></i>

                    <span>Dashboard</span>
                </a>


                {{-- Pesanan --}}
                <a
                    href="{{ route('client.orders.index') }}"
                    class="
                        flex h-11 items-center gap-3 rounded-xl px-3 text-sm font-medium transition
                        {{ $isOrders
                            ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                            : 'text-[#355248] hover:bg-[#F5F9F7]' }}
                    "
                >
                    <i
                        class="bi bi-bag{{ $isOrders ? '-fill' : '' }} w-5 text-center text-[15px] {{ $isOrders ? 'text-[#1E9E5A]' : 'text-[#899A92]' }}"
                    ></i>

                    <span>Pesanan</span>
                </a>


                {{-- Pesan --}}
                <a
                    href="{{ route('client.messages.index') }}"
                    class="
                        flex h-11 items-center gap-3 rounded-xl px-3 text-sm font-medium transition
                        {{ $isMessages
                            ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                            : 'text-[#355248] hover:bg-[#F5F9F7]' }}
                    "
                >
                    <i
                        class="bi bi-chat-dots{{ $isMessages ? '-fill' : '' }} w-5 text-center text-[15px] {{ $isMessages ? 'text-[#1E9E5A]' : 'text-[#899A92]' }}"
                    ></i>

                    <span>Pesan</span>
                </a>


                {{-- Notifikasi --}}
                <a
                    href="{{ route('notifications.index') }}"
                    class="
                        flex h-11 items-center gap-3 rounded-xl px-3 text-sm font-medium transition
                        {{ $isNotifications
                            ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                            : 'text-[#355248] hover:bg-[#F5F9F7]' }}
                    "
                >
                    <i
                        class="bi bi-bell{{ $isNotifications ? '-fill' : '' }} w-5 text-center text-[15px] {{ $isNotifications ? 'text-[#1E9E5A]' : 'text-[#899A92]' }}"
                    ></i>

                    <span>Notifikasi</span>

                    @php
                        $mobileUnreadCount = $user?->unreadNotifications()->count() ?? 0;
                    @endphp

                    @if($mobileUnreadCount > 0)
                        <span class="ml-auto inline-flex min-w-[20px] items-center justify-center rounded-full bg-[#E5484D] px-1.5 py-0.5 text-[8px] font-bold leading-none text-white">
                            {{ $mobileUnreadCount > 99 ? '99+' : $mobileUnreadCount }}
                        </span>
                    @endif
                </a>


                {{-- Favorit --}}
                <a
                    href="{{ route('client.favorites.index') }}"
                    class="
                        flex h-11 items-center gap-3 rounded-xl px-3 text-sm font-medium transition
                        {{ $isFavorites
                            ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                            : 'text-[#355248] hover:bg-[#F5F9F7]' }}
                    "
                >
                    <i
                        class="bi bi-heart{{ $isFavorites ? '-fill' : '' }} w-5 text-center text-[15px] {{ $isFavorites ? 'text-[#1E9E5A]' : 'text-[#899A92]' }}"
                    ></i>

                    <span>Favorit</span>
                </a>


                {{-- Profile --}}
                <a
                    href="{{ route('profile.show') }}"
                    class="
                        flex h-11 items-center gap-3 rounded-xl px-3 text-sm font-medium transition
                        {{ $isProfile
                            ? 'bg-[#EAF7EF] text-[#0F6B3A]'
                            : 'text-[#355248] hover:bg-[#F5F9F7]' }}
                    "
                >
                    <i
                        class="bi bi-person{{ $isProfile ? '-fill' : '' }} w-5 text-center text-[15px] {{ $isProfile ? 'text-[#1E9E5A]' : 'text-[#899A92]' }}"
                    ></i>

                    <span>Profil</span>
                </a>


                {{-- User Info --}}
                <div class="mt-3 flex items-center gap-3 rounded-xl border border-[#E5ECE8] bg-[#F8FBF9] px-3 py-3">

                    <div class="relative shrink-0">

                        @if($avatarUrl)

                            <img
                                src="{{ $avatarUrl }}"
                                alt="{{ $user->name }}"
                                class="h-10 w-10 rounded-full object-cover"
                            >

                        @else

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-[#EAF7EF] text-xs font-semibold text-[#1E9E5A]"
                            >
                                {{ $initial }}
                            </div>

                        @endif

                        <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full border-2 border-[#F8FBF9] bg-[#35C978]"></span>

                    </div>

                    <div class="min-w-0">

                        <p class="truncate text-sm font-semibold text-[#18382E]">
                            {{ $user->name }}
                        </p>

                        <p class="mt-0.5 truncate text-[10px] text-[#899890]">
                            {{ $user->email }}
                        </p>

                    </div>

                </div>


                {{-- Logout --}}
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="pt-2"
                >
                    @csrf

                    <button
                        type="submit"
                        class="flex h-11 w-full items-center gap-3 rounded-xl px-3 text-left text-sm font-medium text-red-500 transition hover:bg-red-50"
                    >
                        <i class="bi bi-box-arrow-right w-5 text-center text-[15px]"></i>

                        <span>Keluar</span>
                    </button>
                </form>

            </nav>

        </div>

    </div>

</header>