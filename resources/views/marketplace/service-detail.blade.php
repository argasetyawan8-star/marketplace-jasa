<x-layouts.marketplace title="{{ $service->title }} - JASAIN">

    <style>
        @keyframes jasainServiceUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .jasain-service-up {
            animation: jasainServiceUp .45s ease-out both;
        }

        .jasain-service-up-delay {
            animation: jasainServiceUp .45s .08s ease-out both;
        }

        .jasain-service-up-delay-2 {
            animation: jasainServiceUp .45s .16s ease-out both;
        }

        @media (prefers-reduced-motion: reduce) {
            .jasain-service-up,
            .jasain-service-up-delay,
            .jasain-service-up-delay-2 {
                animation: none;
            }
        }
    </style>

    @php
        $freelancer = $service->freelancerProfile;
        $freelancerUser = $freelancer?->user;

        $serviceImage = $service->thumbnail
            ? asset('storage/' . $service->thumbnail)
            : null;

        $freelancerAvatar = $freelancer?->avatar
            ? asset('storage/' . $freelancer->avatar)
            : null;

        $isClient = auth()->check() && auth()->user()->role === 'client';

        $isOwner = auth()->check()
            && $freelancer?->user_id === auth()->id();

        $rating = (float) ($service->rating ?? 0);
        $reviewsCount = (int) ($service->reviews_count ?? 0);
        $ordersCount = (int) ($service->orders_count ?? 0);
        $deliveryDays = (int) ($service->delivery_days ?? 0);
        $startingPrice = (float) ($service->starting_price ?? 0);
    @endphp

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <section class="border-b border-[#E4ECE7] bg-[#F8FCF9] pt-[96px] sm:pt-[104px]">
        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 sm:py-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 text-[11px] text-[#8B9A94] sm:text-xs">

                <a
                    href="{{ route('marketplace.home') }}"
                    class="transition hover:text-[#0F6B3A]"
                >
                    Beranda
                </a>

                <i class="bi bi-chevron-right text-[8px]"></i>

                <a
                    href="{{ route('marketplace.search') }}"
                    class="transition hover:text-[#0F6B3A]"
                >
                    Cari Jasa
                </a>

                @if ($service->category)
                    <i class="bi bi-chevron-right text-[8px]"></i>

                    <span class="font-medium text-[#556960]">
                        {{ $service->category->name }}
                    </span>
                @endif
            </div>
        </div>
    </section>

    {{-- =========================================================
        MAIN
    ========================================================== --}}
    <main class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8 lg:py-10">

            <div class="grid gap-8 lg:grid-cols-[minmax(0,1.08fr)_minmax(360px,0.92fr)] lg:gap-10 xl:gap-12">

                {{-- =================================================
                    LEFT
                ================================================== --}}
                <div class="jasain-service-up min-w-0">

                    {{-- Main Image --}}
                    <div class="overflow-hidden rounded-[22px] border border-[#E1EBE5] bg-[#F2F8F4]">
                        <div class="aspect-[4/3] w-full">

                            @if ($serviceImage)
                                <img
                                    src="{{ $serviceImage }}"
                                    alt="{{ $service->title }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-[#EAF7EF]">
                                    <div
                                        class="flex h-20 w-20 items-center justify-center rounded-[22px] bg-white text-3xl text-[#0F6B3A] shadow-sm"
                                    >
                                        <i class="bi bi-briefcase"></i>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- Mobile Quick Info --}}
                    <div class="mt-4 grid grid-cols-3 rounded-2xl border border-[#E1EBE5] bg-[#F8FCF9] lg:hidden">

                        <div class="px-3 py-3 text-center">
                            <div class="text-sm font-semibold text-[#123128]">
                                {{ number_format($rating, 1) }}
                            </div>

                            <div class="mt-0.5 text-[10px] text-[#8B9A94]">
                                Rating
                            </div>
                        </div>

                        <div class="border-l border-[#E3ECE7] px-3 py-3 text-center">
                            <div class="text-sm font-semibold text-[#123128]">
                                {{ $reviewsCount }}
                            </div>

                            <div class="mt-0.5 text-[10px] text-[#8B9A94]">
                                Ulasan
                            </div>
                        </div>

                        <div class="border-l border-[#E3ECE7] px-3 py-3 text-center">
                            <div class="text-sm font-semibold text-[#123128]">
                                {{ $ordersCount }}
                            </div>

                            <div class="mt-0.5 text-[10px] text-[#8B9A94]">
                                Pesanan
                            </div>
                        </div>

                    </div>

                    {{-- =================================================
                        DESCRIPTION
                    ================================================== --}}
                    <div class="mt-8 lg:mt-10">

                        <div class="flex items-center gap-3">
                            <div class="h-5 w-1 rounded-full bg-[#1E9E5A]"></div>

                            <h2 class="text-lg font-semibold tracking-tight text-[#123128] sm:text-xl">
                                Tentang layanan
                            </h2>
                        </div>

                        <div class="mt-4 text-sm leading-7 text-[#5F746A] sm:text-[15px]">
                            {!! nl2br(e($service->description)) !!}
                        </div>

                    </div>

                    {{-- =================================================
                        SERVICE INFORMATION
                    ================================================== --}}
                    <div class="mt-8 border-t border-[#E8EFEA] pt-7 sm:mt-10 sm:pt-9">

                        <h2 class="text-lg font-semibold tracking-tight text-[#123128] sm:text-xl">
                            Detail layanan
                        </h2>

                        <div class="mt-5 grid gap-3 sm:grid-cols-2">

                            {{-- Category --}}
                            <div class="rounded-2xl border border-[#E2ECE6] bg-[#F8FCF9] p-4">
                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A] shadow-sm">
                                        <i class="bi bi-grid"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <div class="text-[11px] text-[#8A9B94]">
                                            Kategori
                                        </div>

                                        <div class="mt-1 truncate text-sm font-medium text-[#29483D]">
                                            {{ $service->category?->name ?? '-' }}
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Subcategory --}}
                            <div class="rounded-2xl border border-[#E2ECE6] bg-[#F8FCF9] p-4">
                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A] shadow-sm">
                                        <i class="bi bi-diagram-3"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <div class="text-[11px] text-[#8A9B94]">
                                            Subkategori
                                        </div>

                                        <div class="mt-1 truncate text-sm font-medium text-[#29483D]">
                                            {{ $service->subcategory?->name ?? '-' }}
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Delivery --}}
                            <div class="rounded-2xl border border-[#E2ECE6] bg-[#F8FCF9] p-4">
                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A] shadow-sm">
                                        <i class="bi bi-clock"></i>
                                    </div>

                                    <div>
                                        <div class="text-[11px] text-[#8A9B94]">
                                            Estimasi pengerjaan
                                        </div>

                                        <div class="mt-1 text-sm font-medium text-[#29483D]">
                                            {{ $deliveryDays > 0 ? $deliveryDays . ' hari' : '-' }}
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Orders --}}
                            <div class="rounded-2xl border border-[#E2ECE6] bg-[#F8FCF9] p-4">
                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A] shadow-sm">
                                        <i class="bi bi-bag-check"></i>
                                    </div>

                                    <div>
                                        <div class="text-[11px] text-[#8A9B94]">
                                            Pesanan selesai
                                        </div>

                                        <div class="mt-1 text-sm font-medium text-[#29483D]">
                                            {{ $ordersCount }} pesanan
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- =================================================
                    RIGHT SIDEBAR
                ================================================== --}}
                <aside class="jasain-service-up-delay">

                    <div class="sticky top-[92px]">

                        <div
                            class="rounded-[22px] border border-[#E0EBE4] bg-white p-5 shadow-[0_10px_30px_rgba(18,49,40,0.05)] sm:p-6"
                        >

                            {{-- Featured --}}
                            @if ($service->is_featured)
                                <div class="mb-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-[10px] font-semibold text-[#0F6B3A]"
                                    >
                                        <i class="bi bi-stars"></i>
                                        Pilihan JASAIN
                                    </span>
                                </div>
                            @endif

                            {{-- Category --}}
                            <div class="flex flex-wrap items-center gap-2 text-[11px] text-[#8A9B94]">

                                @if ($service->category)
                                    <span>
                                        {{ $service->category->name }}
                                    </span>
                                @endif

                                @if ($service->subcategory)
                                    <span>•</span>

                                    <span>
                                        {{ $service->subcategory->name }}
                                    </span>
                                @endif

                            </div>

                            {{-- Title --}}
                            <h1
                                class="mt-3 text-[24px] font-semibold leading-[1.2] tracking-[-0.035em] text-[#123128] sm:text-[28px]"
                            >
                                {{ $service->title }}
                            </h1>

                            {{-- Rating --}}
                            <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2">

                                <span
                                    class="inline-flex items-center gap-1.5 text-sm font-medium text-[#40564C]"
                                >
                                    <i class="bi bi-star-fill text-[#1E9E5A]"></i>
                                    {{ number_format($rating, 1) }}
                                </span>

                                <span class="text-sm text-[#81918A]">
                                    {{ $reviewsCount }} ulasan
                                </span>

                                <span class="text-sm text-[#81918A]">
                                    {{ $ordersCount }} pesanan
                                </span>

                            </div>

                            {{-- Divider --}}
                            <div class="my-6 border-t border-[#E9EFEB]"></div>

                            {{-- Freelancer --}}
                            <div>

                                <div
                                    class="text-[11px] font-medium uppercase tracking-[0.08em] text-[#8A9B94]"
                                >
                                    Freelancer
                                </div>

                                @if ($freelancer?->username)

                                    <a
                                        href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                                        class="mt-3 flex items-center gap-3 rounded-2xl border border-[#E3ECE7] bg-[#F8FCF9] p-3 transition hover:border-[#C6DED0] hover:bg-[#F4FAF6]"
                                    >

                                @else

                                    <div
                                        class="mt-3 flex items-center gap-3 rounded-2xl border border-[#E3ECE7] bg-[#F8FCF9] p-3"
                                    >

                                @endif

                                    @if ($freelancerAvatar)

                                        <img
                                            src="{{ $freelancerAvatar }}"
                                            alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                            class="h-12 w-12 shrink-0 rounded-full object-cover ring-2 ring-white"
                                        >

                                    @else

                                        <div
                                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#D8F0E2] text-sm font-semibold text-[#0F6B3A]"
                                        >
                                            {{ strtoupper(substr($freelancerUser?->name ?? 'F', 0, 1)) }}
                                        </div>

                                    @endif

                                    <div class="min-w-0 flex-1">

                                        <div class="flex items-center gap-1.5">

                                            <span
                                                class="truncate text-sm font-semibold text-[#234238]"
                                            >
                                                {{ $freelancerUser?->name ?? 'Freelancer' }}
                                            </span>

                                            @if ($freelancer?->is_verified)

                                                <i
                                                    class="bi bi-patch-check-fill shrink-0 text-[#1E9E5A]"
                                                    title="Terverifikasi"
                                                ></i>

                                            @endif

                                        </div>

                                        @if ($freelancer?->username)

                                            <div
                                                class="mt-0.5 truncate text-xs text-[#8B9A94]"
                                            >
                                                {{ '@' . $freelancer->username }}
                                            </div>

                                        @endif

                                    </div>

                                    @if ($freelancer?->username)

                                        <i
                                            class="bi bi-chevron-right shrink-0 text-xs text-[#9AAAA3]"
                                        ></i>

                                    @endif

                                @if ($freelancer?->username)

                                    </a>

                                @else

                                    </div>

                                @endif

                            </div>

                            {{-- Availability --}}
                            <div class="mt-3">

                                @if ($freelancer?->is_available)

                                    <span
                                        class="inline-flex items-center gap-1.5 text-xs font-medium text-[#0F6B3A]"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"
                                        ></span>

                                        Sedang tersedia
                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1.5 text-xs font-medium text-[#899890]"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full bg-[#AAB7B1]"
                                        ></span>

                                        Sedang offline
                                    </span>

                                @endif

                            </div>

                            {{-- =================================================
                                PRICE
                            ================================================== --}}
                            <div class="mt-6 rounded-2xl bg-[#F8FCF9] p-4">

                                <div class="text-[11px] text-[#8B9A94]">
                                    Mulai dari
                                </div>

                                <div
                                    class="mt-1 text-[26px] font-semibold tracking-tight text-[#123128]"
                                >
                                    Rp {{ number_format($startingPrice, 0, ',', '.') }}
                                </div>

                                @if ($deliveryDays > 0)
                                    <div class="mt-1 text-xs text-[#81918A]">
                                        Estimasi {{ $deliveryDays }} hari pengerjaan
                                    </div>
                                @endif

                            </div>

                            {{-- =================================================
                                ACTIONS
                            ================================================== --}}
                            <div class="mt-5 space-y-2.5">

                                {{-- GUEST --}}
                                @guest

                                    {{-- Masuk Untuk Memesan --}}
                                    <a
                                        href="{{ route('login') }}"
                                        class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                                    >
                                        <i class="bi bi-box-arrow-in-right text-[16px]"></i>

                                        <span>
                                            Masuk untuk memesan
                                        </span>
                                    </a>

                                    {{-- Buat Akun --}}
                                    <a
                                        href="{{ route('register') }}"
                                        class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl border border-[#D7E4DC] bg-white text-sm font-semibold text-[#40564C] transition hover:border-[#BFD8C8] hover:bg-[#F6FAF7]"
                                    >
                                        <i class="bi bi-person-plus text-[16px]"></i>

                                        <span>
                                            Buat akun
                                        </span>
                                    </a>

                                {{-- AUTHENTICATED --}}
                                @else

                                    {{-- Owner --}}
                                    @if ($isOwner)

                                        <a
                                            href="{{ route('freelancer.dashboard') }}"
                                            class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                                        >
                                            <i class="bi bi-speedometer2 text-[16px]"></i>

                                            <span>
                                                Buka dashboard
                                            </span>

                                            <i class="bi bi-arrow-right text-[14px]"></i>
                                        </a>

                                    {{-- Client --}}
                                    @elseif ($isClient)

                                        @if ($freelancer?->username)

                                            <form
                                                method="POST"
                                                action="{{ route('client.messages.start', $service) }}"
                                            >
                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                                                >
                                                    <i class="bi bi-chat-dots text-[16px]"></i>

                                                    <span>
                                                        Hubungi freelancer
                                                    </span>
                                                </button>
                                            </form>

                                        @endif

                                        {{-- Information --}}
                                        <div
                                            class="rounded-xl border border-[#E4ECE7] bg-[#FAFCFB] px-4 py-3 text-center text-xs leading-5 text-[#7C8D85]"
                                        >
                                            Diskusikan kebutuhanmu terlebih dahulu
                                            sebelum membuat pesanan.
                                        </div>

                                    {{-- Other Role --}}
                                    @else

                                        <a
                                            href="{{ route('login') }}"
                                            class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                                        >
                                            <i class="bi bi-person-check text-[16px]"></i>

                                            <span>
                                                Masuk sebagai client
                                            </span>

                                            <i class="bi bi-arrow-right text-[14px]"></i>
                                        </a>

                                    @endif

                                @endguest

                            </div>

                            {{-- =================================================
                                TRUST
                            ================================================== --}}
                            <div class="mt-5 border-t border-[#E9EFEB] pt-5">

                                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1 xl:grid-cols-3">

                                    <div class="flex items-center gap-2">

                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#0F6B3A]"
                                        >
                                            <i class="bi bi-shield-check text-sm"></i>
                                        </div>

                                        <span
                                            class="text-[10px] leading-4 text-[#71837B]"
                                        >
                                            Transaksi aman
                                        </span>

                                    </div>

                                    <div class="flex items-center gap-2">

                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#0F6B3A]"
                                        >
                                            <i class="bi bi-chat-square-text text-sm"></i>
                                        </div>

                                        <span
                                            class="text-[10px] leading-4 text-[#71837B]"
                                        >
                                            Diskusi langsung
                                        </span>

                                    </div>

                                    <div class="flex items-center gap-2">

                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#0F6B3A]"
                                        >
                                            <i class="bi bi-check-circle text-sm"></i>
                                        </div>

                                        <span
                                            class="text-[10px] leading-4 text-[#71837B]"
                                        >
                                            Alur terstruktur
                                        </span>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </aside>

            </div>

            {{-- =====================================================
                FREELANCER INTRO
            ====================================================== --}}
            <div
                class="jasain-service-up-delay-2 mt-12 border-t border-[#E7EEE9] pt-10 sm:mt-14 sm:pt-12"
            >

                <div
                    class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-start lg:gap-12"
                >

                    <div>

                        <div
                            class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1E9E5A]"
                        >
                            Tentang freelancer
                        </div>

                        <h2
                            class="mt-2 text-xl font-semibold tracking-tight text-[#123128]"
                        >
                            Kenali orang di balik layanan ini
                        </h2>

                    </div>

                    <div
                        class="rounded-2xl border border-[#E0EBE4] bg-[#F8FCF9] p-5 sm:p-6"
                    >

                        <div class="flex items-start gap-4">

                            @if ($freelancerAvatar)

                                <img
                                    src="{{ $freelancerAvatar }}"
                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                    class="h-14 w-14 shrink-0 rounded-full object-cover ring-4 ring-white"
                                >

                            @else

                                <div
                                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#D8F0E2] text-lg font-semibold text-[#0F6B3A]"
                                >
                                    {{ strtoupper(substr($freelancerUser?->name ?? 'F', 0, 1)) }}
                                </div>

                            @endif

                            <div class="min-w-0 flex-1">

                                <div class="flex flex-wrap items-center gap-2">

                                    <h3 class="text-sm font-semibold text-[#123128]">
                                        {{ $freelancerUser?->name ?? 'Freelancer' }}
                                    </h3>

                                    @if ($freelancer?->is_verified)

                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-[#EAF7EF] px-2 py-1 text-[9px] font-semibold text-[#0F6B3A]"
                                        >
                                            <i class="bi bi-patch-check-fill"></i>
                                            Terverifikasi
                                        </span>

                                    @endif

                                </div>

                                @if ($freelancer?->username)

                                    <div class="mt-1 text-xs text-[#8B9A94]">
                                        {{ '@' . $freelancer->username }}
                                    </div>

                                @endif

                                <p class="mt-3 text-sm leading-6 text-[#6B7E75]">
                                    {{ $freelancer?->headline ?: 'Freelancer profesional siap membantu kebutuhanmu.' }}
                                </p>

                                <div
                                    class="mt-4 flex flex-wrap gap-x-5 gap-y-2 text-xs text-[#6F8179]"
                                >

                                    <span class="inline-flex items-center gap-1.5">
                                        <i class="bi bi-star-fill text-[#1E9E5A]"></i>

                                        {{ number_format((float) ($freelancer->rating ?? 0), 1) }}
                                    </span>

                                    <span class="inline-flex items-center gap-1.5">
                                        <i class="bi bi-check2-circle text-[#1E9E5A]"></i>

                                        {{ $freelancer->completed_orders ?? 0 }} pesanan
                                    </span>

                                    @if ($freelancer?->location)

                                        <span class="inline-flex items-center gap-1.5">
                                            <i class="bi bi-geo-alt text-[#1E9E5A]"></i>

                                            {{ $freelancer->location }}
                                        </span>

                                    @endif

                                </div>

                                @if ($freelancer?->username)

                                    <a
                                        href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                                        class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#0F6B3A] transition hover:text-[#1E9E5A]"
                                    >
                                        Lihat profil freelancer

                                        <i class="bi bi-arrow-right"></i>
                                    </a>

                                @endif

                            </div>
                        </div>

                    </div>

                </div>

            </div>

            {{-- =====================================================
                RELATED SERVICES
            ====================================================== --}}
            @if ($relatedServices->isNotEmpty())

                <section class="mt-14 border-t border-[#E7EEE9] pt-10 sm:mt-16 sm:pt-12">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                        <div>
                            <div
                                class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1E9E5A]"
                            >
                                Jelajahi lebih banyak
                            </div>

                            <h2
                                class="mt-2 text-xl font-semibold tracking-tight text-[#123128] sm:text-2xl"
                            >
                                Jasa lainnya yang mungkin cocok
                            </h2>

                            <p class="mt-2 max-w-2xl text-sm leading-6 text-[#71837B]">
                                Temukan layanan lain dalam kategori yang sama
                                untuk membandingkan pilihan yang tersedia.
                            </p>
                        </div>

                        @if ($service->category?->slug)

                            <a
                                href="{{ route('marketplace.category', $service->category->slug) }}"
                                class="inline-flex shrink-0 items-center gap-2 text-sm font-semibold text-[#0F6B3A] transition hover:text-[#1E9E5A]"
                            >
                                Lihat semua
                                <i class="bi bi-arrow-right"></i>
                            </a>

                        @endif

                    </div>

                    <div class="mt-7 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                        @foreach ($relatedServices as $relatedService)

                            @php
                                $relatedFreelancer = $relatedService->freelancerProfile;
                                $relatedFreelancerUser = $relatedFreelancer?->user;

                                $relatedImage = $relatedService->thumbnail
                                    ? asset('storage/' . $relatedService->thumbnail)
                                    : null;

                                $relatedAvatar = $relatedFreelancer?->avatar
                                    ? asset('storage/' . $relatedFreelancer->avatar)
                                    : null;

                                $relatedRating = (float) ($relatedService->rating ?? 0);
                                $relatedReviews = (int) ($relatedService->reviews_count ?? 0);
                                $relatedOrders = (int) ($relatedService->orders_count ?? 0);
                                $relatedPrice = (float) ($relatedService->starting_price ?? 0);
                            @endphp

                            <a
                                href="{{ route('marketplace.service', $relatedService->slug) }}"
                                class="group overflow-hidden rounded-[20px] border border-[#E0EAE4] bg-white transition duration-300 hover:-translate-y-1 hover:border-[#C7DDD0] hover:shadow-[0_14px_35px_rgba(18,49,40,0.08)]"
                            >

                                {{-- Thumbnail --}}
                                <div class="relative overflow-hidden bg-[#F2F8F4]">

                                    <div class="aspect-[4/3] w-full">

                                        @if ($relatedImage)

                                            <img
                                                src="{{ $relatedImage }}"
                                                alt="{{ $relatedService->title }}"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                                loading="lazy"
                                            >

                                        @else

                                            <div
                                                class="flex h-full w-full items-center justify-center bg-[#EAF7EF]"
                                            >
                                                <div
                                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl text-[#0F6B3A] shadow-sm"
                                                >
                                                    <i class="bi bi-briefcase"></i>
                                                </div>
                                            </div>

                                        @endif

                                    </div>

                                    @if ($relatedService->is_featured)

                                        <div class="absolute left-3 top-3">

                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-white/95 px-2.5 py-1.5 text-[9px] font-semibold text-[#0F6B3A] shadow-sm backdrop-blur"
                                            >
                                                <i class="bi bi-stars"></i>
                                                Pilihan JASAIN
                                            </span>

                                        </div>

                                    @endif

                                </div>

                                {{-- Card Content --}}
                                <div class="p-4">

                                    {{-- Category --}}
                                    <div class="flex flex-wrap items-center gap-1.5 text-[10px] text-[#8B9A94]">

                                        @if ($relatedService->subcategory)
                                            <span>
                                                {{ $relatedService->subcategory->name }}
                                            </span>
                                        @elseif ($relatedService->category)
                                            <span>
                                                {{ $relatedService->category->name }}
                                            </span>
                                        @endif

                                    </div>

                                    {{-- Title --}}
                                    <h3
                                        class="mt-2 line-clamp-2 min-h-[42px] text-sm font-semibold leading-5 text-[#234238] transition group-hover:text-[#0F6B3A]"
                                    >
                                        {{ $relatedService->title }}
                                    </h3>

                                    {{-- Freelancer --}}
                                    <div class="mt-4 flex items-center gap-2.5">

                                        @if ($relatedAvatar)

                                            <img
                                                src="{{ $relatedAvatar }}"
                                                alt="{{ $relatedFreelancerUser?->name ?? 'Freelancer' }}"
                                                class="h-8 w-8 shrink-0 rounded-full object-cover"
                                                loading="lazy"
                                            >

                                        @else

                                            <div
                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#D8F0E2] text-[11px] font-semibold text-[#0F6B3A]"
                                            >
                                                {{ strtoupper(substr($relatedFreelancerUser?->name ?? 'F', 0, 1)) }}
                                            </div>

                                        @endif

                                        <div class="min-w-0">

                                            <div class="flex items-center gap-1">

                                                <span
                                                    class="truncate text-[11px] font-semibold text-[#40564C]"
                                                >
                                                    {{ $relatedFreelancerUser?->name ?? 'Freelancer' }}
                                                </span>

                                                @if ($relatedFreelancer?->is_verified)

                                                    <i
                                                        class="bi bi-patch-check-fill shrink-0 text-[10px] text-[#1E9E5A]"
                                                        title="Terverifikasi"
                                                    ></i>

                                                @endif

                                            </div>

                                            @if ($relatedFreelancer?->username)

                                                <div class="mt-0.5 truncate text-[10px] text-[#98A69F]">
                                                    {{ '@' . $relatedFreelancer->username }}
                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                    {{-- Stats --}}
                                    <div
                                        class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-1.5 text-[10px] text-[#7E8E87]"
                                    >

                                        <span class="inline-flex items-center gap-1">
                                            <i class="bi bi-star-fill text-[#1E9E5A]"></i>
                                            {{ number_format($relatedRating, 1) }}
                                        </span>

                                        <span>
                                            {{ $relatedReviews }} ulasan
                                        </span>

                                        <span>
                                            {{ $relatedOrders }} pesanan
                                        </span>

                                    </div>

                                    {{-- Price --}}
                                    <div class="mt-4 flex items-end justify-between gap-3">

                                        <div class="min-w-0">

                                            <div class="text-[10px] text-[#95A29C]">
                                                Mulai dari
                                            </div>

                                            <div
                                                class="mt-0.5 truncate text-base font-semibold tracking-tight text-[#123128]"
                                            >
                                                Rp {{ number_format($relatedPrice, 0, ',', '.') }}
                                            </div>

                                        </div>

                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F1F8F3] text-sm text-[#0F6B3A] transition group-hover:bg-[#0F6B3A] group-hover:text-white"
                                        >
                                            <i class="bi bi-arrow-up-right"></i>
                                        </div>

                                    </div>

                                </div>

                            </a>

                        @endforeach

                    </div>

                </section>

            @endif

        </div>
    </main>

</x-layouts.marketplace>