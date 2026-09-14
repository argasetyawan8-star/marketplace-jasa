<x-layouts.marketplace title="JASAIN - Marketplace Jasa">

    <style>
    @keyframes jasainHeroUp {
        from {
            opacity: 0;
            transform: translateY(18px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes jasainSoftFloat {
        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .jasain-hero-up {
        animation: jasainHeroUp .7s ease-out both;
    }

    .jasain-hero-up-delay {
        animation: jasainHeroUp .7s .12s ease-out both;
    }

    .jasain-hero-up-delay-2 {
        animation: jasainHeroUp .7s .24s ease-out both;
    }

    .jasain-soft-float {
        animation: jasainSoftFloat 4s ease-in-out infinite;
    }

    /*
    |--------------------------------------------------------------------------
    | HERO DESKTOP
    |--------------------------------------------------------------------------
    */

    .jasain-hero {
        position: relative;
        overflow: hidden;
        background: #0F6B3A;
    }

    .jasain-hero-image {
        position: absolute;
        inset: 0;
        z-index: 0;
        overflow: hidden;
    }

    .jasain-hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 72% center;
    }

    /*
    |--------------------------------------------------------------------------
    | GREEN BLEND
    |
    | Tidak ada lagi garis vertikal.
    | Hijau perlahan hilang menuju gambar.
    |--------------------------------------------------------------------------
    */

    .jasain-hero-image::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;

        background:
            linear-gradient(
                90deg,
                #0F6B3A 0%,
                #0F6B3A 22%,
                rgba(15, 107, 58, 0.98) 30%,
                rgba(15, 107, 58, 0.86) 38%,
                rgba(15, 107, 58, 0.58) 47%,
                rgba(15, 107, 58, 0.23) 58%,
                rgba(15, 107, 58, 0.03) 68%,
                transparent 76%
            );
    }

    /*
    |--------------------------------------------------------------------------
    | BOTTOM BLEND
    |--------------------------------------------------------------------------
    */

    .jasain-hero-bottom {
        position: absolute;
        inset-x: 0;
        bottom: 0;
        height: 24%;
        z-index: 2;
        pointer-events: none;

        background:
            linear-gradient(
                to top,
                rgba(15, 107, 58, 0.42),
                transparent
            );
    }

    /*
    |--------------------------------------------------------------------------
    | TABLET
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1023px) {

        .jasain-hero-image img {
            object-position: 68% center;
        }

        .jasain-hero-image::after {
            background:
                linear-gradient(
                    90deg,
                    #0F6B3A 0%,
                    #0F6B3A 19%,
                    rgba(15, 107, 58, 0.96) 29%,
                    rgba(15, 107, 58, 0.72) 41%,
                    rgba(15, 107, 58, 0.28) 56%,
                    transparent 70%
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 767px) {

        .jasain-hero {
            background: #0F6B3A;
        }

        .jasain-hero-image {
            position: relative;
            inset: auto;
            height: 360px;
            margin-top: 6px;
        }

        .jasain-hero-image img {
            height: 100%;
            object-position: 62% center;
        }

        .jasain-hero-image::after {
            background:
                linear-gradient(
                    to bottom,
                    #0F6B3A 0%,
                    #0F6B3A 5%,
                    rgba(15, 107, 58, 0.88) 18%,
                    rgba(15, 107, 58, 0.40) 35%,
                    rgba(15, 107, 58, 0.10) 52%,
                    rgba(15, 107, 58, 0.38) 72%,
                    #0F6B3A 100%
                );
        }

        .jasain-hero-bottom {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .jasain-hero-up,
        .jasain-hero-up-delay,
        .jasain-hero-up-delay-2,
        .jasain-soft-float {
            animation: none;
        }
    }
</style>


{{-- =========================================================
    HERO
========================================================== --}}
<section class="jasain-hero">

    {{-- =====================================================
        HERO BACKGROUND IMAGE
    ====================================================== --}}
    <div class="jasain-hero-image">

        <img
            src="{{ asset('images/ImagesHero.png') }}"
            alt="Freelancer JASAIN sedang bekerja"
        >

        <div class="jasain-hero-bottom"></div>

    </div>


    {{-- =====================================================
        DECORATIVE ELEMENTS
    ====================================================== --}}
    <div
        class="pointer-events-none absolute -left-40 -top-40 z-[1] h-[520px] w-[520px] rounded-full bg-[#1E9E5A]/20"
    ></div>

    <div
        class="pointer-events-none absolute -right-32 -top-28 z-[1] h-[380px] w-[380px] rounded-full border-[75px] border-[#7AD8B5]/10"
    ></div>


    {{-- =====================================================
        CONTENT
    ====================================================== --}}
    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div
            class="grid min-h-[calc(100vh-72px)] items-center pt-[96px] pb-8 sm:pt-[104px] lg:grid-cols-[0.92fr_1.08fr] lg:gap-6 lg:py-16"
        >

            {{-- =================================================
                LEFT CONTENT
            ================================================== --}}
            <div class="max-w-2xl">

                {{-- Badge --}}
                {{-- <div
                    class="jasain-hero-up inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3.5 py-2 text-[11px] font-medium text-white sm:px-4 sm:text-sm"
                >
                    <span
                        class="h-2 w-2 shrink-0 rounded-full bg-[#7AD8B5]"
                    ></span>

                    Marketplace jasa profesional
                </div> --}}


                {{-- Heading --}}
                <h1
                    class="jasain-hero-up mt-5 max-w-xl text-[38px] font-semibold leading-[1.07] tracking-[-0.045em] text-white sm:mt-6 sm:text-5xl lg:text-[58px]"
                >
                    Wujudkan ide,
                    <span class="block text-[#7AD8B5]">
                        temukan talent terbaik.
                    </span>
                </h1>


                {{-- Description --}}
                <p
                    class="jasain-hero-up-delay mt-5 max-w-xl text-sm leading-6 text-white/72 sm:mt-6 sm:text-base sm:leading-8"
                >
                    Temukan freelancer profesional dari berbagai bidang
                    untuk membantu kebutuhan personal, bisnis, maupun proyekmu.
                </p>


                {{-- =================================================
                    SEARCH
                ================================================== --}}
                <form
                    action="{{ route('marketplace.search') }}"
                    method="GET"
                    class="jasain-hero-up-delay-2 mt-7 sm:mt-8"
                >

                    <div
                        class="max-w-[650px] rounded-2xl bg-white p-2 shadow-[0_22px_60px_rgba(0,0,0,0.16)]"
                    >

                        <div
                            class="flex flex-col sm:flex-row sm:items-center"
                        >

                            {{-- Input --}}
                            <div
                                class="flex min-w-0 flex-1 items-center gap-3 px-3 sm:px-4"
                            >

                                <i
                                    class="bi bi-search shrink-0 text-lg text-[#0F6B3A]"
                                ></i>

                                <input
                                    type="text"
                                    name="q"
                                    value="{{ request('q') }}"
                                    placeholder="Cari jasa, keahlian, atau freelancer..."
                                    class="w-full border-0 bg-transparent py-3 text-sm text-[#123128] outline-none placeholder:text-slate-400 focus:border-0 focus:ring-0 sm:text-[15px]"
                                >

                            </div>


                            {{-- Search Button --}}
                            <button
                                type="submit"
                                class="mt-2 inline-flex h-12 w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-6 text-sm font-semibold text-white transition duration-200 hover:bg-[#0F6B3A] sm:mt-0 sm:w-auto"
                            >
                                Cari Sekarang

                                <i class="bi bi-arrow-right"></i>
                            </button>

                        </div>

                    </div>

                </form>


                {{-- =================================================
                    POPULAR KEYWORDS
                ================================================== --}}
                <div class="mt-5 overflow-x-auto pb-1">

                    <div class="flex min-w-max items-center gap-2">

                        <span class="mr-1 text-xs text-white/50 sm:text-sm">
                            Populer:
                        </span>

                        @foreach (['Logo', 'Website', 'UI/UX', 'Video Editing', 'SEO'] as $keyword)

                            <a
                                href="{{ route('marketplace.search', ['q' => $keyword]) }}"
                                class="rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-xs text-white/75 transition hover:border-white/20 hover:bg-white/15 hover:text-white sm:text-sm"
                            >
                                {{ $keyword }}
                            </a>

                        @endforeach

                    </div>

                </div>


                {{-- =================================================
                    STATS
                ================================================== --}}
                <div
                    class="mt-8 grid max-w-[650px] grid-cols-3 border-t border-white/10 pt-6 sm:mt-10 sm:pt-7"
                >

                    <div class="pr-3">

                        <div class="text-lg font-semibold text-white sm:text-2xl">
                            100+
                        </div>

                        <div
                            class="mt-1 text-[10px] leading-4 text-white/50 sm:text-xs"
                        >
                            Layanan tersedia
                        </div>

                    </div>


                    <div
                        class="border-l border-white/10 px-3"
                    >

                        <div class="text-lg font-semibold text-white sm:text-2xl">
                            50+
                        </div>

                        <div
                            class="mt-1 text-[10px] leading-4 text-white/50 sm:text-xs"
                        >
                            Freelancer
                        </div>

                    </div>


                    <div
                        class="border-l border-white/10 pl-3"
                    >

                        <div class="text-lg font-semibold text-white sm:text-2xl">
                            4.9/5
                        </div>

                        <div
                            class="mt-1 text-[10px] leading-4 text-white/50 sm:text-xs"
                        >
                            Rating pengguna
                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                EMPTY GRID COLUMN
                Background image sudah mengisi seluruh hero.
                Kolom ini hanya menjaga komposisi desktop.
            ================================================== --}}
            <div class="hidden lg:block"></div>

        </div>


        {{-- =====================================================
            FLOATING CARD 1
        ====================================================== --}}
        <div
            class="jasain-soft-float absolute right-[14%] top-[80px] z-20 hidden rounded-2xl border border-[#DCEFE4] bg-white px-4 py-3 shadow-[0_18px_40px_rgba(0,0,0,0.14)] lg:block"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                >
                    <i class="bi bi-shield-check text-lg"></i>
                </div>

                <div>

                    <div class="text-[11px] text-[#789088]">
                        Proses aman
                    </div>

                    <div class="mt-0.5 text-xs font-semibold text-[#123128]">
                        Transaksi terjamin
                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            FLOATING CARD 2
        ====================================================== --}}
        <div
            class="absolute bottom-[58px] right-[14%] z-20 hidden rounded-2xl border border-[#DCEFE4] bg-white px-4 py-3 shadow-[0_18px_40px_rgba(0,0,0,0.14)] lg:block"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#0F6B3A] text-white"
                >
                    <i class="bi bi-briefcase"></i>
                </div>

                <div>

                    <div class="text-[11px] text-[#789088]">
                        Banyak pilihan
                    </div>

                    <div class="mt-0.5 text-xs font-semibold text-[#123128]">
                        Berbagai kategori jasa
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


    {{-- =========================================================
        CATEGORY
    ========================================================== --}}
    <section class="bg-[#F8FCF9] py-14 sm:py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
            >

                <div>

                    <span class="text-sm font-semibold text-[#1E9E5A]">
                        Jelajahi kategori
                    </span>

                    <h2
                        class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl"
                    >
                        Cari jasa berdasarkan kebutuhan
                    </h2>

                    <p
                        class="mt-3 max-w-2xl text-sm leading-6 text-[#667D73] sm:text-base"
                    >
                        Temukan berbagai layanan dari freelancer
                        profesional dalam satu tempat.
                    </p>

                </div>


                <a
                    href="{{ route('marketplace.search') }}"
                    class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-[#0F6B3A] transition hover:text-[#1E9E5A]"
                >
                    Lihat semua

                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>


            <div
                class="mt-8 grid grid-cols-2 gap-3 sm:mt-10 sm:grid-cols-3 sm:gap-4 lg:grid-cols-6"
            >

                @foreach ($categories->take(6) as $category)

                    @php
                        $categoryIcons = [
                            'desain' => 'bi-palette2',
                            'website' => 'bi-window',
                            'teknologi' => 'bi-code-slash',
                            'video' => 'bi-camera-video',
                            'marketing' => 'bi-megaphone',
                            'penulisan' => 'bi-pencil',
                        ];

                        $categoryName = strtolower($category->name);

                        $icon = 'bi-grid';

                        foreach ($categoryIcons as $keyword => $categoryIcon) {
                            if (str_contains($categoryName, $keyword)) {
                                $icon = $categoryIcon;
                                break;
                            }
                        }
                    @endphp


                    <a
                        href="{{ route('marketplace.category', $category->slug) }}"
                        class="group rounded-2xl border border-[#DCEDE3] bg-white p-4 transition duration-300 hover:-translate-y-1 hover:border-[#B9DDC8] hover:shadow-[0_16px_32px_rgba(15,107,58,0.06)] sm:p-5"
                    >

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF7EF] text-lg text-[#0F6B3A] transition duration-300 group-hover:bg-[#0F6B3A] group-hover:text-white sm:h-12 sm:w-12"
                        >
                            <i class="bi {{ $icon }}"></i>
                        </div>


                        <h3
                            class="mt-4 line-clamp-2 text-sm font-semibold leading-5 text-[#123128]"
                        >
                            {{ $category->name }}
                        </h3>


                        <div
                            class="mt-1 text-[11px] text-[#8A9B94] sm:text-xs"
                        >
                            {{ $category->subcategories_count ?? 0 }} subkategori
                        </div>

                    </a>

                @endforeach

            </div>

        </div>

    </section>


    {{-- =========================================================
        FEATURED SERVICES
    ========================================================== --}}
    <section class="bg-white py-14 sm:py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
            >

                <div>

                    <span class="text-sm font-semibold text-[#1E9E5A]">
                        Layanan pilihan
                    </span>

                    <h2
                        class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl"
                    >
                        Jasa yang mungkin kamu butuhkan
                    </h2>

                    <p
                        class="mt-3 max-w-2xl text-sm leading-6 text-[#667D73] sm:text-base"
                    >
                        Pilihan layanan dari freelancer yang siap
                        membantu kebutuhanmu.
                    </p>

                </div>


                <a
                    href="{{ route('marketplace.search') }}"
                    class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-[#0F6B3A] transition hover:text-[#1E9E5A]"
                >
                    Lihat semua jasa

                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>


            <div
                class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 xl:grid-cols-4"
            >

                @forelse ($featuredServices as $service)

                    @php
                        $freelancer = $service->freelancerProfile;
                        $freelancerUser = $freelancer?->user;

                        $avatar = $freelancer?->avatar
                            ? asset('storage/' . $freelancer->avatar)
                            : null;
                    @endphp


                    <a
                        href="{{ route('marketplace.service', $service->slug) }}"
                        class="group overflow-hidden rounded-2xl border border-[#E1EDE6] bg-white transition duration-300 hover:-translate-y-1 hover:border-[#BFDCCA] hover:shadow-[0_18px_38px_rgba(15,107,58,0.07)]"
                    >

                        {{-- Thumbnail --}}
                        <div
                            class="relative aspect-[4/3] overflow-hidden bg-[#EAF7EF]"
                        >

                            @if ($service->thumbnail)

                                <img
                                    src="{{ asset('storage/' . $service->thumbnail) }}"
                                    alt="{{ $service->title }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.035]"
                                >

                            @else

                                <div
                                    class="flex h-full items-center justify-center bg-gradient-to-br from-[#EAF7EF] via-[#D7F2E3] to-[#C2E8D0]"
                                >
                                    <div
                                        class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/85 text-2xl text-[#0F6B3A] shadow-sm"
                                    >
                                        <i class="bi bi-briefcase"></i>
                                    </div>
                                </div>

                            @endif


                            @if ($service->is_featured)

                                <div class="absolute left-3 top-3">

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-[#0F6B3A] px-3 py-1.5 text-[10px] font-semibold text-white shadow-sm"
                                    >
                                        <i class="bi bi-stars"></i>
                                        Pilihan
                                    </span>

                                </div>

                            @endif

                        </div>


                        {{-- Content --}}
                        <div class="p-4 sm:p-5">

                            <div
                                class="flex items-start justify-between gap-3"
                            >

                                <div class="min-w-0">

                                    <div
                                        class="flex flex-wrap items-center gap-2 text-[10px] text-[#8A9B94] sm:text-[11px]"
                                    >

                                        @if ($service->category)

                                            <span>
                                                {{ $service->category->name }}
                                            </span>

                                        @endif


                                        @if ($service->delivery_days)

                                            <span>•</span>

                                            <span>
                                                {{ $service->delivery_days }} hari
                                            </span>

                                        @endif

                                    </div>


                                    <h3
                                        class="mt-2 line-clamp-2 text-sm font-semibold leading-6 text-[#123128] transition group-hover:text-[#0F6B3A] sm:text-[15px]"
                                    >
                                        {{ $service->title }}
                                    </h3>

                                </div>


                                @auth

                                    @if (auth()->user()->role === 'client')

                                        <form
                                            method="POST"
                                            action="{{ route('client.favorites.store', $service) }}"
                                            onclick="event.preventDefault(); event.stopPropagation();"
                                            class="shrink-0"
                                        >
                                            @csrf

                                            <input
                                                type="hidden"
                                                name="service_id"
                                                value="{{ $service->id }}"
                                            >

                                            <button
                                                type="submit"
                                                class="flex h-9 w-9 items-center justify-center rounded-full border border-[#DDEBE2] bg-white text-[#82958D] transition hover:border-[#B9DCC6] hover:text-[#0F6B3A]"
                                                title="Tambah favorit"
                                            >
                                                <i class="bi bi-heart"></i>
                                            </button>

                                        </form>

                                    @endif

                                @endauth

                            </div>


                            {{-- Freelancer --}}
                            <div class="mt-4 flex items-center gap-3 sm:mt-5">

                                @if ($avatar)

                                    <img
                                        src="{{ $avatar }}"
                                        alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                        class="h-9 w-9 shrink-0 rounded-full object-cover ring-2 ring-[#EAF7EF]"
                                    >

                                @else

                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#D8F0E2] text-xs font-semibold text-[#0F6B3A]"
                                    >
                                        {{ strtoupper(substr($freelancerUser?->name ?? 'F', 0, 1)) }}
                                    </div>

                                @endif


                                <div class="min-w-0">

                                    <div class="flex items-center gap-1.5">

                                        <span
                                            class="truncate text-sm font-medium text-[#234238]"
                                        >
                                            {{ $freelancerUser?->name ?? 'Freelancer' }}
                                        </span>

                                        @if ($freelancer?->is_verified)

                                            <i
                                                class="bi bi-patch-check-fill shrink-0 text-[#1E9E5A]"
                                            ></i>

                                        @endif

                                    </div>


                                    @if ($freelancer?->username)

                                        <div
                                            class="truncate text-xs text-[#899B94]"
                                        >
                                            {{ '@' . $freelancer->username }}
                                        </div>

                                    @endif

                                </div>

                            </div>


                            {{-- Rating --}}
                            <div
                                class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-[#71847C] sm:mt-5 sm:text-xs"
                            >

                                <span
                                    class="inline-flex items-center gap-1 font-medium text-[#425B51]"
                                >
                                    <i class="bi bi-star-fill text-[#1E9E5A]"></i>

                                    {{ number_format((float) $service->rating, 1) }}
                                </span>


                                <span>
                                    {{ $service->reviews_count ?? 0 }} ulasan
                                </span>


                                <span>
                                    {{ $service->orders_count ?? 0 }} order
                                </span>

                            </div>


                            {{-- Price --}}
                            <div
                                class="mt-4 flex items-end justify-between border-t border-[#EDF3EF] pt-4 sm:mt-5"
                            >

                                <div>

                                    <div
                                        class="text-[10px] text-[#899B94] sm:text-[11px]"
                                    >
                                        Mulai dari
                                    </div>

                                    <div
                                        class="mt-1 text-base font-semibold text-[#123128]"
                                    >
                                        Rp
                                        {{ number_format($service->starting_price, 0, ',', '.') }}
                                    </div>

                                </div>


                                <div
                                    class="flex h-9 w-9 items-center justify-center rounded-full bg-[#EAF7EF] text-[#0F6B3A] transition group-hover:bg-[#0F6B3A] group-hover:text-white"
                                >
                                    <i class="bi bi-arrow-up-right text-sm"></i>
                                </div>

                            </div>

                        </div>

                    </a>

                @empty

                    <div
                        class="col-span-full rounded-2xl border border-dashed border-[#CFE1D6] bg-[#F8FCF9] px-6 py-16 text-center"
                    >

                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-xl text-[#0F6B3A]"
                        >
                            <i class="bi bi-box"></i>
                        </div>

                        <h3
                            class="mt-4 text-base font-semibold text-[#123128]"
                        >
                            Belum ada layanan tersedia
                        </h3>

                        <p
                            class="mt-2 text-sm text-[#81918B]"
                        >
                            Layanan freelancer yang sudah dipublikasikan akan muncul di sini.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </section>


    {{-- =========================================================
        FEATURED FREELANCERS
    ========================================================== --}}
    <section class="bg-[#F8FCF9] py-14 sm:py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
            >

                <div>

                    <span class="text-sm font-semibold text-[#1E9E5A]">
                        Freelancer pilihan
                    </span>

                    <h2
                        class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl"
                    >
                        Kenalan dengan talenta terbaik
                    </h2>

                    <p
                        class="mt-3 max-w-2xl text-sm leading-6 text-[#667D73] sm:text-base"
                    >
                        Temukan freelancer berdasarkan keahlian,
                        rating, pengalaman, dan layanan mereka.
                    </p>

                </div>


                <a
                    href="{{ route('marketplace.search') }}"
                    class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-[#0F6B3A] transition hover:text-[#1E9E5A]"
                >
                    Cari freelancer

                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>


            <div
                class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3"
            >

                @forelse ($featuredFreelancers as $freelancer)

                    @php
                        $user = $freelancer->user;

                        $avatar = $freelancer->avatar
                            ? asset('storage/' . $freelancer->avatar)
                            : null;
                    @endphp


                    <a
                        href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                        class="group rounded-2xl border border-[#DCEDE3] bg-white p-4 transition duration-300 hover:-translate-y-1 hover:border-[#BEDCC9] hover:shadow-[0_18px_38px_rgba(15,107,58,0.06)] sm:p-5"
                    >

                        <div class="flex items-start justify-between gap-3">

                            <div
                                class="flex min-w-0 items-center gap-3 sm:gap-4"
                            >

                                @if ($avatar)

                                    <img
                                        src="{{ $avatar }}"
                                        alt="{{ $user?->name ?? $freelancer->username }}"
                                        class="h-12 w-12 shrink-0 rounded-full object-cover ring-4 ring-[#EAF7EF] sm:h-14 sm:w-14"
                                    >

                                @else

                                    <div
                                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#D8F0E2] text-base font-semibold text-[#0F6B3A] sm:h-14 sm:w-14 sm:text-lg"
                                    >
                                        {{ strtoupper(substr($user?->name ?? 'F', 0, 1)) }}
                                    </div>

                                @endif


                                <div class="min-w-0">

                                    <div class="flex items-center gap-1.5">

                                        <h3
                                            class="truncate text-sm font-semibold text-[#123128]"
                                        >
                                            {{ $user?->name ?? $freelancer->username }}
                                        </h3>

                                        @if ($freelancer->is_verified)

                                            <i
                                                class="bi bi-patch-check-fill shrink-0 text-[#1E9E5A]"
                                            ></i>

                                        @endif

                                    </div>


                                    @if ($freelancer->username)

                                        <p
                                            class="mt-1 truncate text-xs text-[#899B94]"
                                        >
                                            {{ '@' . $freelancer->username }}
                                        </p>

                                    @endif

                                </div>

                            </div>


                            @if ($freelancer->is_available)

                                <span
                                    class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-[#EAF7EF] px-2 py-1 text-[9px] font-semibold text-[#0F6B3A] sm:px-2.5 sm:py-1 sm:text-[11px]"
                                >
                                    <span
                                        class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"
                                    ></span>

                                    Tersedia
                                </span>

                            @else

                                <span
                                    class="inline-flex shrink-0 rounded-full bg-slate-100 px-2 py-1 text-[9px] font-medium text-slate-500 sm:px-2.5 sm:py-1 sm:text-[11px]"
                                >
                                    Offline
                                </span>

                            @endif

                        </div>


                        <p
                            class="mt-4 line-clamp-2 text-sm leading-6 text-[#667D73] sm:mt-5"
                        >
                            {{ $freelancer->headline ?: 'Freelancer profesional siap membantu kebutuhanmu.' }}
                        </p>


                        <div
                            class="mt-4 grid grid-cols-3 border-t border-[#EDF3EF] pt-4 sm:mt-5"
                        >

                            <div>

                                <div
                                    class="flex items-center gap-1 text-sm font-semibold text-[#234238]"
                                >
                                    <i class="bi bi-star-fill text-[#1E9E5A]"></i>

                                    {{ number_format((float) $freelancer->rating, 1) }}
                                </div>

                                <div
                                    class="mt-1 text-[10px] text-[#8A9B94] sm:text-[11px]"
                                >
                                    Rating
                                </div>

                            </div>


                            <div
                                class="border-l border-[#EDF3EF] pl-3"
                            >

                                <div class="text-sm font-semibold text-[#234238]">
                                    {{ $freelancer->completed_orders ?? 0 }}
                                </div>

                                <div
                                    class="mt-1 text-[10px] text-[#8A9B94] sm:text-[11px]"
                                >
                                    Pesanan
                                </div>

                            </div>


                            <div
                                class="border-l border-[#EDF3EF] pl-3"
                            >

                                <div
                                    class="truncate text-sm font-semibold text-[#234238]"
                                >
                                    {{ $freelancer->location ?: '-' }}
                                </div>

                                <div
                                    class="mt-1 text-[10px] text-[#8A9B94] sm:text-[11px]"
                                >
                                    Lokasi
                                </div>

                            </div>

                        </div>


                        <div
                            class="mt-4 flex items-center justify-between border-t border-[#EDF3EF] pt-4 text-sm font-semibold text-[#0F6B3A] sm:mt-5"
                        >

                            <span>
                                Lihat profil
                            </span>

                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-[#EAF7EF] transition group-hover:bg-[#0F6B3A] group-hover:text-white"
                            >
                                <i class="bi bi-arrow-up-right"></i>
                            </span>

                        </div>

                    </a>

                @empty

                    <div
                        class="col-span-full rounded-2xl border border-dashed border-[#CFE1D6] bg-white px-6 py-16 text-center"
                    >

                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-xl text-[#0F6B3A]"
                        >
                            <i class="bi bi-people"></i>
                        </div>

                        <h3
                            class="mt-4 text-base font-semibold text-[#123128]"
                        >
                            Belum ada freelancer pilihan
                        </h3>

                        <p
                            class="mt-2 text-sm text-[#81918B]"
                        >
                            Freelancer yang tersedia akan muncul di sini.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </section>


    {{-- =========================================================
        WHY JASAIN
    ========================================================== --}}
    <section class="bg-white py-14 sm:py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div
                class="grid items-center gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:gap-12"
            >

                <div class="max-w-xl">

                    <span class="text-sm font-semibold text-[#1E9E5A]">
                        Kenapa JASAIN?
                    </span>

                    <h2
                        class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl"
                    >
                        Temukan partner yang tepat untuk kebutuhanmu.
                    </h2>

                    <p
                        class="mt-4 text-sm leading-7 text-[#667D73] sm:text-base"
                    >
                        JASAIN membantu client menemukan freelancer,
                        berkomunikasi, melakukan pemesanan, hingga
                        menyelesaikan pekerjaan dalam satu alur.
                    </p>

                </div>


                <div class="grid gap-3 sm:grid-cols-2 sm:gap-4">

                    @php
                        $advantages = [
                            [
                                'icon' => 'bi-shield-check',
                                'title' => 'Transaksi lebih aman',
                                'description' => 'Alur pembayaran dan pemesanan dilakukan melalui sistem JASAIN.',
                            ],
                            [
                                'icon' => 'bi-patch-check',
                                'title' => 'Freelancer profesional',
                                'description' => 'Lihat profil, rating, layanan, dan pengalaman sebelum memilih.',
                            ],
                            [
                                'icon' => 'bi-chat-square-text',
                                'title' => 'Komunikasi langsung',
                                'description' => 'Diskusikan kebutuhanmu sebelum melakukan pemesanan.',
                            ],
                            [
                                'icon' => 'bi-grid',
                                'title' => 'Beragam layanan',
                                'description' => 'Berbagai kategori jasa dalam satu marketplace.',
                            ],
                        ];
                    @endphp


                    @foreach ($advantages as $advantage)

                        <div
                            class="rounded-2xl border border-[#DCEDE3] bg-[#F8FCF9] p-4 transition duration-300 hover:-translate-y-0.5 hover:border-[#C1DFCC] sm:p-5"
                        >

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-lg text-[#0F6B3A] shadow-sm sm:h-11 sm:w-11"
                            >
                                <i class="bi {{ $advantage['icon'] }}"></i>
                            </div>


                            <h3
                                class="mt-4 text-sm font-semibold text-[#123128]"
                            >
                                {{ $advantage['title'] }}
                            </h3>


                            <p
                                class="mt-2 text-sm leading-6 text-[#7A8D85]"
                            >
                                {{ $advantage['description'] }}
                            </p>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        HOW IT WORKS
    ========================================================== --}}
    <section class="bg-[#F8FCF9] py-14 sm:py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mx-auto max-w-2xl text-center">

                <span class="text-sm font-semibold text-[#1E9E5A]">
                    Cara kerja
                </span>

                <h2
                    class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl"
                >
                    Sederhana dari awal sampai selesai
                </h2>

                <p
                    class="mt-3 text-sm leading-6 text-[#667D73] sm:text-base"
                >
                    Cari jasa, diskusikan kebutuhan, lakukan pemesanan,
                    lalu terima hasil pekerjaan.
                </p>

            </div>


            <div
                class="mt-10 grid gap-8 sm:mt-12 sm:grid-cols-2 lg:grid-cols-4"
            >

                @php
                    $steps = [
                        [
                            'number' => '01',
                            'icon' => 'bi-search',
                            'title' => 'Cari jasa',
                            'description' => 'Temukan layanan yang sesuai dengan kebutuhanmu.',
                        ],
                        [
                            'number' => '02',
                            'icon' => 'bi-chat-dots',
                            'title' => 'Diskusikan',
                            'description' => 'Hubungi freelancer dan bahas detail pekerjaan.',
                        ],
                        [
                            'number' => '03',
                            'icon' => 'bi-credit-card',
                            'title' => 'Pesan',
                            'description' => 'Setujui penawaran dan lakukan pembayaran.',
                        ],
                        [
                            'number' => '04',
                            'icon' => 'bi-check2-circle',
                            'title' => 'Selesaikan',
                            'description' => 'Terima hasil pekerjaan dan selesaikan pesanan.',
                        ],
                    ];
                @endphp


                @foreach ($steps as $step)

                    <div class="relative">

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-lg text-[#0F6B3A] shadow-sm ring-1 ring-[#DCEDE3]"
                        >
                            <i class="bi {{ $step['icon'] }}"></i>
                        </div>


                        <div
                            class="mt-5 text-[11px] font-semibold tracking-[0.18em] text-[#1E9E5A]"
                        >
                            {{ $step['number'] }}
                        </div>


                        <h3
                            class="mt-2 text-base font-semibold text-[#123128]"
                        >
                            {{ $step['title'] }}
                        </h3>


                        <p
                            class="mt-2 max-w-xs text-sm leading-6 text-[#7A8D85]"
                        >
                            {{ $step['description'] }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>

    </section>


    {{-- =========================================================
        FREELANCER CTA
    ========================================================== --}}
    <section class="bg-white py-14 sm:py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div
                class="relative overflow-hidden rounded-[28px] bg-[#0F6B3A] px-5 py-10 sm:px-10 sm:py-14 lg:px-14"
            >

                <div
                    class="pointer-events-none absolute right-[-80px] top-[-80px] h-64 w-64 rounded-full bg-[#1E9E5A]/45"
                ></div>

                <div
                    class="pointer-events-none absolute bottom-[-100px] left-[38%] h-56 w-56 rounded-full bg-[#7AD8B5]/10"
                ></div>


                <div
                    class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between"
                >

                    <div class="max-w-2xl">

                        <span
                            class="text-sm font-medium text-[#7AD8B5]"
                        >
                            Untuk freelancer
                        </span>

                        <h2
                            class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl"
                        >
                            Ubah keahlianmu menjadi peluang.
                        </h2>

                        <p
                            class="mt-4 max-w-xl text-sm leading-7 text-white/65 sm:text-base"
                        >
                            Tawarkan jasamu di JASAIN, temukan client,
                            dan bangun reputasi profesionalmu.
                        </p>

                    </div>


                    <div class="shrink-0">

                        @guest

                            <a
                                href="{{ route('register') }}"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-white px-6 py-3.5 text-sm font-semibold text-[#0F6B3A] transition hover:bg-[#EAF7EF] sm:w-auto"
                            >
                                Mulai menjadi freelancer

                                <i class="bi bi-arrow-right"></i>
                            </a>

                        @else

                            @if (auth()->user()->role === 'freelancer')

                                <a
                                    href="{{ route('freelancer.dashboard') }}"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-white px-6 py-3.5 text-sm font-semibold text-[#0F6B3A] transition hover:bg-[#EAF7EF] sm:w-auto"
                                >
                                    Buka dashboard

                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            @else

                                <a
                                    href="{{ route('register') }}"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-white px-6 py-3.5 text-sm font-semibold text-[#0F6B3A] transition hover:bg-[#EAF7EF] sm:w-auto"
                                >
                                    Daftar sebagai freelancer

                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            @endif

                        @endguest

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        FINAL CTA
    ========================================================== --}}
    <section class="bg-[#F8FCF9] py-12 sm:py-16">

        <div
            class="mx-auto max-w-3xl px-4 text-center sm:px-6"
        >

            <div
                class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#EAF7EF] text-lg text-[#0F6B3A]"
            >
                <i class="bi bi-search"></i>
            </div>


            <h2
                class="mt-5 text-2xl font-semibold tracking-tight text-[#123128]"
            >
                Siap menemukan jasa yang tepat?
            </h2>


            <p
                class="mx-auto mt-3 max-w-xl text-sm leading-6 text-[#71847C] sm:text-base"
            >
                Jelajahi berbagai layanan dan temukan freelancer
                yang sesuai dengan kebutuhanmu.
            </p>


            <a
                href="{{ route('marketplace.search') }}"
                class="mt-6 inline-flex items-center gap-2 rounded-xl bg-[#0F6B3A] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
            >
                Jelajahi jasa

                <i class="bi bi-arrow-right"></i>
            </a>

        </div>

    </section>

</x-layouts.marketplace>