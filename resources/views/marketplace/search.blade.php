<x-layouts.marketplace title="Cari Jasa - JASAIN">

    <style>
        /*
        |--------------------------------------------------------------------------
        | SEARCH PAGE ANIMATION
        |--------------------------------------------------------------------------
        */

        @keyframes jasainSearchFade {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .jasain-search-fade {
            animation: jasainSearchFade .45s ease-out both;
        }

        .jasain-search-fade-delay {
            animation: jasainSearchFade .45s .08s ease-out both;
        }

        /*
        |--------------------------------------------------------------------------
        | MOBILE FILTER
        |--------------------------------------------------------------------------
        */

        #mobile-filter-overlay {
            display: none;
        }

        #mobile-filter-overlay.is-open {
            display: block;
        }

        #mobile-filter-panel {
            transform: translateY(100%);
            transition: transform .25s ease-out;
        }

        #mobile-filter-overlay.is-open #mobile-filter-panel {
            transform: translateY(0);
        }

        /*
        |--------------------------------------------------------------------------
        | HORIZONTAL SCROLL
        |--------------------------------------------------------------------------
        */

        .jasain-scroll::-webkit-scrollbar {
            height: 4px;
        }

        .jasain-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .jasain-scroll::-webkit-scrollbar-thumb {
            background: #D8E5DD;
            border-radius: 999px;
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOM SELECT
        |--------------------------------------------------------------------------
        */

        .jasain-select {
            appearance: none;
            -webkit-appearance: none;
            background-image: none;
        }

        /*
        |--------------------------------------------------------------------------
        | REDUCED MOTION
        |--------------------------------------------------------------------------
        */

        @media (prefers-reduced-motion: reduce) {
            .jasain-search-fade,
            .jasain-search-fade-delay,
            #mobile-filter-panel {
                animation: none;
                transition: none;
            }
        }
    </style>


    {{-- =========================================================
        SEARCH HEADER
    ========================================================== --}}
    <section class="border-b border-[#E5ECE8] bg-white pt-[96px] sm:pt-[104px]">

        <div class="mx-auto max-w-7xl px-4 pb-7 sm:px-6 sm:pb-9 lg:px-8">

            {{-- Breadcrumb --}}
            <div
                class="jasain-search-fade flex items-center gap-2 text-[11px] text-[#96A49E] sm:text-xs"
            >

                <a
                    href="{{ route('marketplace.home') }}"
                    class="transition hover:text-[#0F6B3A]"
                >
                    Beranda
                </a>

                <i class="bi bi-chevron-right text-[8px]"></i>

                <span class="font-medium text-[#50635A]">
                    Cari Jasa
                </span>

            </div>


            {{-- Heading --}}
            <div class="jasain-search-fade mt-5">

                <h1
                    class="text-[28px] font-semibold tracking-[-0.035em] text-[#123128] sm:text-4xl"
                >
                    Cari jasa dan freelancer
                </h1>

                <p
                    class="mt-2 max-w-2xl text-sm leading-6 text-[#71837B] sm:text-[15px]"
                >
                    Temukan freelancer yang sesuai dengan kebutuhan,
                    budget, dan keahlian yang kamu cari.
                </p>

            </div>


            {{-- =====================================================
                BIG SEARCH
            ====================================================== --}}
            <form
                action="{{ route('marketplace.search') }}"
                method="GET"
                class="jasain-search-fade-delay mt-6"
            >

                <div
                    class="flex flex-col rounded-2xl border border-[#DCE7E0] bg-white p-2 shadow-[0_8px_24px_rgba(18,49,40,0.05)] sm:flex-row sm:items-center"
                >

                    <div
                        class="flex min-w-0 flex-1 items-center gap-3 px-3 sm:px-4"
                    >

                        <i
                            class="bi bi-search shrink-0 text-[18px] text-[#0F6B3A]"
                        ></i>

                        <input
                            type="text"
                            name="q"
                            value="{{ $query }}"
                            placeholder="Cari freelancer, jasa, keahlian..."
                            class="w-full border-0 bg-transparent py-3.5 text-sm text-[#123128] outline-none placeholder:text-[#9CAAA4] focus:border-0 focus:ring-0 sm:text-[15px]"
                        >

                    </div>


                    {{-- Preserve current filters --}}
                    @if ($categorySlug)
                        <input
                            type="hidden"
                            name="category"
                            value="{{ $categorySlug }}"
                        >
                    @endif

                    @if ($subcategorySlug)
                        <input
                            type="hidden"
                            name="subcategory"
                            value="{{ $subcategorySlug }}"
                        >
                    @endif

                    @if ($minPrice !== null && $minPrice !== '')
                        <input
                            type="hidden"
                            name="min_price"
                            value="{{ $minPrice }}"
                        >
                    @endif

                    @if ($maxPrice !== null && $maxPrice !== '')
                        <input
                            type="hidden"
                            name="max_price"
                            value="{{ $maxPrice }}"
                        >
                    @endif


                    <button
                        type="submit"
                        class="inline-flex h-12 w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-6 text-sm font-semibold text-white transition hover:bg-[#1E9E5A] sm:w-auto"
                    >
                        Cari

                        <i class="bi bi-search"></i>
                    </button>

                </div>

            </form>


            {{-- Popular search --}}
            <div class="jasain-scroll mt-4 overflow-x-auto pb-1">

                <div class="flex min-w-max items-center gap-2">

                    <span class="mr-1 text-[11px] font-medium text-[#96A49E] sm:text-xs">
                        Populer:
                    </span>

                    @foreach (['Logo', 'Website', 'UI/UX', 'Video Editing', 'SEO', 'Social Media'] as $keyword)

                        <a
                            href="{{ route('marketplace.search', ['q' => $keyword]) }}"
                            class="rounded-full border border-[#E1EAE4] bg-[#F8FBF9] px-3 py-1.5 text-[11px] font-medium text-[#63756C] transition hover:border-[#BFDCC9] hover:bg-[#EAF7EF] hover:text-[#0F6B3A] sm:text-xs"
                        >
                            {{ $keyword }}
                        </a>

                    @endforeach

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}
    <main class="bg-[#F8FCF9]">

        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8">

            {{-- =================================================
                MOBILE TOP BAR
            ================================================== --}}
            <div
                class="mb-5 flex items-center justify-between gap-3 lg:hidden"
            >

                <div class="min-w-0">

                    <div class="text-sm font-semibold text-[#123128]">
                        {{ $services->total() }} jasa
                    </div>

                    @if ($query !== '')

                        <div class="mt-0.5 truncate text-[11px] text-[#899B94]">
                            Hasil untuk "{{ $query }}"
                        </div>

                    @endif

                </div>


                <button
                    id="open-mobile-filter"
                    type="button"
                    class="inline-flex h-10 shrink-0 items-center gap-2 rounded-xl border border-[#D6E3DC] bg-white px-3.5 text-xs font-semibold text-[#40564C] shadow-sm transition hover:border-[#BBD5C4] hover:text-[#0F6B3A]"
                >
                    <i class="bi bi-sliders2"></i>
                    Filter
                </button>

            </div>


            {{-- =================================================
                ACTIVE FILTERS
            ================================================== --}}
            @if (
                $query !== '' ||
                $categorySlug ||
                $subcategorySlug ||
                ($minPrice !== null && $minPrice !== '') ||
                ($maxPrice !== null && $maxPrice !== '')
            )

                <div class="jasain-scroll mb-6 overflow-x-auto pb-1">

                    <div class="flex min-w-max items-center gap-2">

                        <span class="mr-1 text-[11px] font-medium text-[#8A9B94]">
                            Filter:
                        </span>


                        @if ($query !== '')

                            <a
                                href="{{ route('marketplace.search', array_filter([
                                    'category' => $categorySlug,
                                    'subcategory' => $subcategorySlug,
                                    'min_price' => $minPrice,
                                    'max_price' => $maxPrice,
                                    'sort' => $sort,
                                ])) }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-[11px] font-medium text-[#0F6B3A]"
                            >
                                {{ $query }}

                                <i class="bi bi-x text-[13px]"></i>
                            </a>

                        @endif


                        @if ($categorySlug)

                            @php
                                $activeCategory = $categories->firstWhere('slug', $categorySlug);
                            @endphp

                            @if ($activeCategory)

                                <a
                                    href="{{ route('marketplace.search', array_filter([
                                        'q' => $query,
                                        'subcategory' => $subcategorySlug,
                                        'min_price' => $minPrice,
                                        'max_price' => $maxPrice,
                                        'sort' => $sort,
                                    ])) }}"
                                    class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-[11px] font-medium text-[#0F6B3A]"
                                >
                                    {{ $activeCategory->name }}

                                    <i class="bi bi-x text-[13px]"></i>
                                </a>

                            @endif

                        @endif


                        @if ($subcategorySlug)

                            @php
                                $activeSubcategory = $subcategories->firstWhere('slug', $subcategorySlug);
                            @endphp

                            @if ($activeSubcategory)

                                <a
                                    href="{{ route('marketplace.search', array_filter([
                                        'q' => $query,
                                        'category' => $categorySlug,
                                        'min_price' => $minPrice,
                                        'max_price' => $maxPrice,
                                        'sort' => $sort,
                                    ])) }}"
                                    class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-[11px] font-medium text-[#0F6B3A]"
                                >
                                    {{ $activeSubcategory->name }}

                                    <i class="bi bi-x text-[13px]"></i>
                                </a>

                            @endif

                        @endif


                        @if ($minPrice !== null && $minPrice !== '')

                            <a
                                href="{{ route('marketplace.search', array_filter([
                                    'q' => $query,
                                    'category' => $categorySlug,
                                    'subcategory' => $subcategorySlug,
                                    'max_price' => $maxPrice,
                                    'sort' => $sort,
                                ])) }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-[11px] font-medium text-[#0F6B3A]"
                            >
                                Min Rp {{ number_format((float) $minPrice, 0, ',', '.') }}

                                <i class="bi bi-x text-[13px]"></i>
                            </a>

                        @endif


                        @if ($maxPrice !== null && $maxPrice !== '')

                            <a
                                href="{{ route('marketplace.search', array_filter([
                                    'q' => $query,
                                    'category' => $categorySlug,
                                    'subcategory' => $subcategorySlug,
                                    'min_price' => $minPrice,
                                    'sort' => $sort,
                                ])) }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-[11px] font-medium text-[#0F6B3A]"
                            >
                                Max Rp {{ number_format((float) $maxPrice, 0, ',', '.') }}

                                <i class="bi bi-x text-[13px]"></i>
                            </a>

                        @endif


                        <a
                            href="{{ route('marketplace.search') }}"
                            class="ml-1 text-[11px] font-semibold text-[#71837B] transition hover:text-[#0F6B3A]"
                        >
                            Reset
                        </a>

                    </div>

                </div>

            @endif


            {{-- =================================================
                RESULT HEADER DESKTOP
            ================================================== --}}
            <div
                class="mb-5 hidden items-center justify-between gap-4 lg:flex"
            >

                <div>

                    <h2 class="text-base font-semibold text-[#123128]">
                        Jasa yang tersedia
                    </h2>

                    <p class="mt-1 text-xs text-[#899B94]">
                        Menampilkan {{ $services->firstItem() ?? 0 }}
                        sampai {{ $services->lastItem() ?? 0 }}
                        dari {{ $services->total() }} jasa
                    </p>

                </div>


                {{-- Sort --}}
                <form
                    method="GET"
                    action="{{ route('marketplace.search') }}"
                    class="flex items-center gap-2"
                >

                    <input
                        type="hidden"
                        name="q"
                        value="{{ $query }}"
                    >

                    @if ($categorySlug)
                        <input
                            type="hidden"
                            name="category"
                            value="{{ $categorySlug }}"
                        >
                    @endif

                    @if ($subcategorySlug)
                        <input
                            type="hidden"
                            name="subcategory"
                            value="{{ $subcategorySlug }}"
                        >
                    @endif

                    @if ($minPrice !== null && $minPrice !== '')
                        <input
                            type="hidden"
                            name="min_price"
                            value="{{ $minPrice }}"
                        >
                    @endif

                    @if ($maxPrice !== null && $maxPrice !== '')
                        <input
                            type="hidden"
                            name="max_price"
                            value="{{ $maxPrice }}"
                        >
                    @endif


                    <label
                        for="desktop-sort"
                        class="text-xs text-[#899B94]"
                    >
                        Urutkan
                    </label>

                    <div class="relative">

                        <select
                            id="desktop-sort"
                            name="sort"
                            onchange="this.form.submit()"
                            class="jasain-select h-10 min-w-[165px] rounded-xl border border-[#D9E5DE] bg-white px-3 pr-8 text-xs font-medium text-[#40564C] outline-none focus:border-[#9ECDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                        >

                            <option value="relevance" @selected($sort === 'relevance')>
                                Paling relevan
                            </option>

                            <option value="popular" @selected($sort === 'popular')>
                                Paling populer
                            </option>

                            <option value="rating" @selected($sort === 'rating')>
                                Rating tertinggi
                            </option>

                            <option value="price_low" @selected($sort === 'price_low')>
                                Harga terendah
                            </option>

                            <option value="price_high" @selected($sort === 'price_high')>
                                Harga tertinggi
                            </option>

                        </select>

                        <i
                            class="bi bi-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-[#8A9B94]"
                        ></i>

                    </div>

                </form>

            </div>


            {{-- =================================================
                LAYOUT
            ================================================== --}}
            <div
                class="grid gap-6 lg:grid-cols-[220px_minmax(0,1fr)] xl:grid-cols-[235px_minmax(0,1fr)]"
            >

                {{-- =================================================
                    SIDEBAR CATEGORY
                ================================================== --}}
                <aside class="hidden lg:block">

                    <div class="sticky top-[92px]">

                        <div
                            class="rounded-2xl border border-[#DFEAE3] bg-white p-4"
                        >

                            <div class="flex items-center justify-between">

                                <h3 class="text-sm font-semibold text-[#123128]">
                                    Kategori jasa
                                </h3>

                                <a
                                    href="{{ route('marketplace.search') }}"
                                    class="text-[10px] font-semibold text-[#0F6B3A] hover:text-[#1E9E5A]"
                                >
                                    Reset
                                </a>

                            </div>


                            {{-- Category list --}}
                            <div class="mt-4 space-y-1">

                                @foreach ($categories as $category)

                                    <a
                                        href="{{ route('marketplace.search', array_filter([
                                            'q' => $query,
                                            'category' => $category->slug,
                                            'subcategory' => null,
                                            'min_price' => $minPrice,
                                            'max_price' => $maxPrice,
                                            'sort' => $sort,
                                        ])) }}"
                                        class="flex min-h-[40px] items-center justify-between gap-3 rounded-xl px-3 py-2 text-xs transition
                                        {{
                                            $categorySlug === $category->slug
                                                ? 'bg-[#EAF7EF] font-semibold text-[#0F6B3A]'
                                                : 'text-[#596C63] hover:bg-[#F5F9F6] hover:text-[#0F6B3A]'
                                        }}"
                                    >

                                        <span class="truncate">
                                            {{ $category->name }}
                                        </span>

                                        <span
                                            class="shrink-0 text-[10px] {{
                                                $categorySlug === $category->slug
                                                    ? 'text-[#5EA979]'
                                                    : 'text-[#A0AEA8]'
                                            }}"
                                        >
                                            {{ $category->subcategories_count ?? 0 }}
                                        </span>

                                    </a>

                                @endforeach

                            </div>


                            {{-- Subcategory --}}
                            <div
                                class="mt-5 border-t border-[#EDF2EF] pt-5"
                            >

                                <label
                                    for="sidebar-subcategory"
                                    class="text-xs font-semibold text-[#40564C]"
                                >
                                    Subkategori
                                </label>

                                <form
                                    action="{{ route('marketplace.search') }}"
                                    method="GET"
                                    class="mt-2"
                                >

                                    <input
                                        type="hidden"
                                        name="q"
                                        value="{{ $query }}"
                                    >

                                    @if ($categorySlug)

                                        <input
                                            type="hidden"
                                            name="category"
                                            value="{{ $categorySlug }}"
                                        >

                                    @endif


                                    @if ($minPrice !== null && $minPrice !== '')

                                        <input
                                            type="hidden"
                                            name="min_price"
                                            value="{{ $minPrice }}"
                                        >

                                    @endif


                                    @if ($maxPrice !== null && $maxPrice !== '')

                                        <input
                                            type="hidden"
                                            name="max_price"
                                            value="{{ $maxPrice }}"
                                        >

                                    @endif


                                    <input
                                        type="hidden"
                                        name="sort"
                                        value="{{ $sort }}"
                                    >


                                    <div class="relative">

                                        <select
                                            id="sidebar-subcategory"
                                            name="subcategory"
                                            onchange="this.form.submit()"
                                            class="jasain-select w-full rounded-xl border border-[#D8E5DD] bg-white px-3 py-2.5 pr-8 text-xs text-[#50635A] outline-none focus:border-[#9ECDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                                        >

                                            <option value="">
                                                Semua subkategori
                                            </option>

                                            @foreach ($subcategories as $subcategory)

                                                <option
                                                    value="{{ $subcategory->slug }}"
                                                    @selected($subcategorySlug === $subcategory->slug)
                                                >
                                                    {{ $subcategory->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                        <i
                                            class="bi bi-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-[#8A9B94]"
                                        ></i>

                                    </div>

                                </form>

                            </div>


                            {{-- Price --}}
                            <div
                                class="mt-5 border-t border-[#EDF2EF] pt-5"
                            >

                                <div class="text-xs font-semibold text-[#40564C]">
                                    Rentang harga
                                </div>

                                <form
                                    method="GET"
                                    action="{{ route('marketplace.search') }}"
                                    class="mt-2.5"
                                >

                                    <input
                                        type="hidden"
                                        name="q"
                                        value="{{ $query }}"
                                    >

                                    @if ($categorySlug)

                                        <input
                                            type="hidden"
                                            name="category"
                                            value="{{ $categorySlug }}"
                                        >

                                    @endif


                                    @if ($subcategorySlug)

                                        <input
                                            type="hidden"
                                            name="subcategory"
                                            value="{{ $subcategorySlug }}"
                                        >

                                    @endif


                                    <input
                                        type="hidden"
                                        name="sort"
                                        value="{{ $sort }}"
                                    >


                                    <div class="grid grid-cols-2 gap-2">

                                        <input
                                            type="number"
                                            name="min_price"
                                            min="0"
                                            value="{{ $minPrice }}"
                                            placeholder="Min"
                                            class="w-full rounded-xl border border-[#D8E5DD] bg-white px-3 py-2.5 text-xs text-[#50635A] outline-none placeholder:text-[#A0AEA8] focus:border-[#9ECDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                                        >

                                        <input
                                            type="number"
                                            name="max_price"
                                            min="0"
                                            value="{{ $maxPrice }}"
                                            placeholder="Max"
                                            class="w-full rounded-xl border border-[#D8E5DD] bg-white px-3 py-2.5 text-xs text-[#50635A] outline-none placeholder:text-[#A0AEA8] focus:border-[#9ECDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                                        >

                                    </div>


                                    <button
                                        type="submit"
                                        class="mt-2.5 inline-flex h-10 w-full items-center justify-center rounded-xl bg-[#0F6B3A] text-xs font-semibold text-white transition hover:bg-[#1E9E5A]"
                                    >
                                        Terapkan
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </aside>


                {{-- =================================================
                    RESULTS
                ================================================== --}}
                <section class="min-w-0">

                    {{-- Mobile Result / Sort --}}
                    <div
                        class="mb-5 flex items-center justify-between gap-3 lg:hidden"
                    >

                        <div class="text-[11px] text-[#899B94]">
                            Menampilkan

                            <span class="font-medium text-[#40564C]">
                                {{ $services->count() }}
                            </span>

                            dari

                            <span class="font-medium text-[#40564C]">
                                {{ $services->total() }}
                            </span>

                            jasa
                        </div>


                        <form
                            method="GET"
                            action="{{ route('marketplace.search') }}"
                        >

                            <input
                                type="hidden"
                                name="q"
                                value="{{ $query }}"
                            >

                            @if ($categorySlug)

                                <input
                                    type="hidden"
                                    name="category"
                                    value="{{ $categorySlug }}"
                                >

                            @endif


                            @if ($subcategorySlug)

                                <input
                                    type="hidden"
                                    name="subcategory"
                                    value="{{ $subcategorySlug }}"
                                >

                            @endif


                            @if ($minPrice !== null && $minPrice !== '')

                                <input
                                    type="hidden"
                                    name="min_price"
                                    value="{{ $minPrice }}"
                                >

                            @endif


                            @if ($maxPrice !== null && $maxPrice !== '')

                                <input
                                    type="hidden"
                                    name="max_price"
                                    value="{{ $maxPrice }}"
                                >

                            @endif


                            <div class="relative">

                                <select
                                    name="sort"
                                    onchange="this.form.submit()"
                                    class="jasain-select h-9 min-w-[105px] rounded-lg border border-[#D7E4DC] bg-white px-2.5 pr-7 text-[10px] font-medium text-[#50635A] outline-none"
                                >

                                    <option value="relevance" @selected($sort === 'relevance')>
                                        Relevan
                                    </option>

                                    <option value="popular" @selected($sort === 'popular')>
                                        Populer
                                    </option>

                                    <option value="rating" @selected($sort === 'rating')>
                                        Rating
                                    </option>

                                    <option value="price_low" @selected($sort === 'price_low')>
                                        Termurah
                                    </option>

                                    <option value="price_high" @selected($sort === 'price_high')>
                                        Termahal
                                    </option>

                                </select>

                                <i
                                    class="bi bi-chevron-down pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 text-[8px] text-[#8A9B94]"
                                ></i>

                            </div>

                        </form>

                    </div>


                    {{-- =================================================
                        SERVICE CARDS
                    ================================================== --}}
                    <div
                        class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3"
                    >

                        @forelse ($services as $service)

                            @php

                                $freelancer = $service->freelancerProfile;

                                $freelancerUser = $freelancer?->user;

                                $freelancerAvatar = $freelancer?->avatar
                                    ? asset('storage/' . $freelancer->avatar)
                                    : null;

                                $isFavorited = (bool) ($service->is_favorited ?? false);

                            @endphp


                            <article
                                class="group overflow-hidden rounded-2xl border border-[#DEEAE3] bg-white transition duration-300 hover:-translate-y-0.5 hover:border-[#BEDBC9] hover:shadow-[0_16px_32px_rgba(15,107,58,0.07)]"
                            >

                                {{-- =================================================
                                    IMAGE
                                ================================================== --}}
                                <a
                                    href="{{ route('marketplace.service', $service->slug) }}"
                                    class="block"
                                >

                                    <div
                                        class="relative aspect-[4/3] overflow-hidden bg-[#EAF7EF]"
                                    >

                                        @if ($service->thumbnail)

                                            <img
                                                src="{{ asset('storage/' . $service->thumbnail) }}"
                                                alt="{{ $service->title }}"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                            >

                                        @else

                                            <div
                                                class="flex h-full w-full items-center justify-center bg-[#EAF7EF]"
                                            >

                                                <div
                                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-xl text-[#0F6B3A] shadow-sm"
                                                >
                                                    <i class="bi bi-briefcase"></i>
                                                </div>

                                            </div>

                                        @endif


                                        @if ($service->is_featured)

                                            <span
                                                class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full bg-[#0F6B3A] px-2.5 py-1.5 text-[10px] font-semibold text-white shadow-sm"
                                            >
                                                <i class="bi bi-stars"></i>
                                                Pilihan
                                            </span>

                                        @endif

                                    </div>

                                </a>


                                {{-- =================================================
                                    CARD CONTENT
                                ================================================== --}}
                                <div class="p-4 sm:p-5">

                                    {{-- Category / delivery --}}
                                    <div
                                        class="flex items-center gap-2 text-[10px] text-[#8A9B94] sm:text-[11px]"
                                    >

                                        @if ($service->category)

                                            <span class="truncate">
                                                {{ $service->category->name }}
                                            </span>

                                        @endif


                                        @if ($service->delivery_days)

                                            <span>
                                                •
                                            </span>

                                            <span class="shrink-0">
                                                {{ $service->delivery_days }} hari
                                            </span>

                                        @endif

                                    </div>


                                    {{-- Title --}}
                                    <div class="mt-2 flex items-start gap-3">

                                        <a
                                            href="{{ route('marketplace.service', $service->slug) }}"
                                            class="min-w-0 flex-1"
                                        >

                                            <h3
                                                class="line-clamp-2 text-sm font-semibold leading-6 text-[#123128] transition group-hover:text-[#0F6B3A] sm:text-[15px]"
                                            >
                                                {{ $service->title }}
                                            </h3>

                                        </a>


                                        {{-- Favorite --}}
                                        @auth

                                            @if (auth()->user()->role === 'client')

                                                <form
                                                    method="POST"
                                                    action="{{ route('client.favorites.store', $service) }}"
                                                    class="shrink-0"
                                                    onclick="event.stopPropagation();"
                                                >

                                                    @csrf

                                                    <input
                                                        type="hidden"
                                                        name="service_id"
                                                        value="{{ $service->id }}"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="flex h-8 w-8 items-center justify-center rounded-full border border-[#DCE8E1] bg-white transition
                                                        {{
                                                            $isFavorited
                                                                ? 'border-red-100 text-red-500'
                                                                : 'text-[#879891] hover:border-[#B8DAC5] hover:text-[#0F6B3A]'
                                                        }}"
                                                        title="{{ $isFavorited ? 'Sudah difavoritkan' : 'Tambah favorit' }}"
                                                    >

                                                        <i
                                                            class="{{ $isFavorited ? 'bi bi-heart-fill' : 'bi bi-heart' }} text-[13px]"
                                                        ></i>

                                                    </button>

                                                </form>

                                            @endif

                                        @endauth

                                    </div>


                                    {{-- Freelancer --}}
                                    <div
                                        class="mt-4 flex items-center gap-3"
                                    >

                                        @if ($freelancerAvatar)

                                            <img
                                                src="{{ $freelancerAvatar }}"
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
                                                    class="truncate text-sm font-medium text-[#29483D]"
                                                >
                                                    {{ $freelancerUser?->name ?? 'Freelancer' }}
                                                </span>

                                                @if ($freelancer?->is_verified)

                                                    <i
                                                        class="bi bi-patch-check-fill shrink-0 text-[13px] text-[#1E9E5A]"
                                                        title="Terverifikasi"
                                                    ></i>

                                                @endif

                                            </div>


                                            @if ($freelancer?->username)

                                                <div
                                                    class="truncate text-[11px] text-[#8B9B95]"
                                                >
                                                    {{ '@' . $freelancer->username }}
                                                </div>

                                            @endif

                                        </div>

                                    </div>


                                    {{-- Stats --}}
                                    <div
                                        class="mt-4 flex items-center gap-3 text-[11px] text-[#7C8D86] sm:text-xs"
                                    >

                                        <span
                                            class="inline-flex items-center gap-1 font-medium text-[#40564C]"
                                        >
                                            <i class="bi bi-star-fill text-[#1E9E5A]"></i>

                                            {{ number_format((float) $service->rating, 1) }}
                                        </span>


                                        <span class="text-[#D1DAD5]">
                                            |
                                        </span>


                                        <span>
                                            {{ $service->reviews_count ?? 0 }} ulasan
                                        </span>


                                        <span class="text-[#D1DAD5]">
                                            |
                                        </span>


                                        <span>
                                            {{ $service->orders_count ?? 0 }} order
                                        </span>

                                    </div>


                                    {{-- Bottom --}}
                                    <div
                                        class="mt-4 flex items-end justify-between border-t border-[#EDF2EF] pt-4"
                                    >

                                        <div>

                                            <div
                                                class="text-[10px] text-[#8E9D97] sm:text-[11px]"
                                            >
                                                Mulai dari
                                            </div>

                                            <div
                                                class="mt-1 text-[15px] font-semibold text-[#123128] sm:text-base"
                                            >
                                                Rp
                                                {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                            </div>

                                        </div>


                                        <a
                                            href="{{ route('marketplace.service', $service->slug) }}"
                                            class="flex h-9 w-9 items-center justify-center rounded-full bg-[#EAF7EF] text-[#0F6B3A] transition hover:bg-[#0F6B3A] hover:text-white"
                                            aria-label="Lihat detail jasa"
                                        >
                                            <i class="bi bi-arrow-up-right text-sm"></i>
                                        </a>

                                    </div>

                                </div>

                            </article>

                        @empty

                            <div
                                class="col-span-full rounded-2xl border border-dashed border-[#CADDD1] bg-white px-6 py-16 text-center"
                            >

                                <div
                                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-xl text-[#0F6B3A]"
                                >
                                    <i class="bi bi-search"></i>
                                </div>


                                <h3
                                    class="mt-4 text-base font-semibold text-[#123128]"
                                >
                                    Jasa belum ditemukan
                                </h3>


                                <p
                                    class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#81918B]"
                                >
                                    Coba gunakan kata kunci lain atau
                                    ubah filter pencarianmu.
                                </p>


                                <a
                                    href="{{ route('marketplace.search') }}"
                                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                                >
                                    Reset pencarian

                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            </div>

                        @endforelse

                    </div>


                    {{-- =================================================
                        PAGINATION
                    ================================================== --}}
                    @if ($services->hasPages())

                        <div class="mt-8 border-t border-[#E2EBE5] pt-6">

                            {{ $services->onEachSide(1)->links() }}

                        </div>

                    @endif

                </section>

            </div>

        </div>

    </main>


    {{-- =========================================================
        MOBILE FILTER
    ========================================================== --}}
    <div
        id="mobile-filter-overlay"
        class="fixed inset-0 z-[70] lg:hidden"
    >

        {{-- Backdrop --}}
        <div
            id="mobile-filter-backdrop"
            class="absolute inset-0 bg-[#123128]/40"
        ></div>


        {{-- Bottom sheet --}}
        <div
            id="mobile-filter-panel"
            class="absolute inset-x-0 bottom-0 max-h-[88vh] overflow-y-auto rounded-t-[26px] bg-white shadow-[0_-15px_40px_rgba(18,49,40,0.15)]"
        >

            <div class="mx-auto max-w-xl px-4 pb-7 pt-4 sm:px-6">

                {{-- Handle --}}
                <div
                    class="mx-auto mb-4 h-1 w-10 rounded-full bg-[#DCE6E0]"
                ></div>


                {{-- Header --}}
                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="text-base font-semibold text-[#123128]">
                            Filter jasa
                        </h2>

                        <p class="mt-1 text-xs text-[#899B94]">
                            Pilih kategori dan rentang harga.
                        </p>

                    </div>


                    <button
                        id="close-mobile-filter"
                        type="button"
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-[#F3F7F4] text-[#50635A]"
                    >
                        <i class="bi bi-x-lg text-sm"></i>
                    </button>

                </div>


                {{-- Filter form --}}
                <form
                    method="GET"
                    action="{{ route('marketplace.search') }}"
                    class="mt-6 space-y-5"
                >

                    {{-- Query --}}
                    <div>

                        <label
                            for="mobile-query"
                            class="text-xs font-semibold text-[#40564C]"
                        >
                            Kata kunci
                        </label>

                        <input
                            id="mobile-query"
                            type="text"
                            name="q"
                            value="{{ $query }}"
                            placeholder="Cari jasa atau freelancer..."
                            class="mt-2 w-full rounded-xl border border-[#D8E5DD] bg-white px-3 py-3 text-sm text-[#40564C] outline-none placeholder:text-[#A0AEA8] focus:border-[#9DCDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                        >

                    </div>


                    {{-- Category --}}
                    <div>

                        <label
                            for="mobile-category"
                            class="text-xs font-semibold text-[#40564C]"
                        >
                            Kategori
                        </label>

                        <div class="relative">

                            <select
                                id="mobile-category"
                                name="category"
                                class="jasain-select mt-2 w-full rounded-xl border border-[#D8E5DD] bg-white px-3 py-3 pr-9 text-sm text-[#40564C] outline-none focus:border-[#9DCDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                            >

                                <option value="">
                                    Semua kategori
                                </option>

                                @foreach ($categories as $category)

                                    <option
                                        value="{{ $category->slug }}"
                                        @selected($categorySlug === $category->slug)
                                    >
                                        {{ $category->name }}
                                    </option>

                                @endforeach

                            </select>

                            <i
                                class="bi bi-chevron-down pointer-events-none absolute right-3 top-1/2 mt-1 -translate-y-1/2 text-[10px] text-[#8A9B94]"
                            ></i>

                        </div>

                    </div>


                    {{-- Subcategory --}}
                    <div>

                        <label
                            for="mobile-subcategory"
                            class="text-xs font-semibold text-[#40564C]"
                        >
                            Subkategori
                        </label>

                        <div class="relative">

                            <select
                                id="mobile-subcategory"
                                name="subcategory"
                                class="jasain-select mt-2 w-full rounded-xl border border-[#D8E5DD] bg-white px-3 py-3 pr-9 text-sm text-[#40564C] outline-none focus:border-[#9DCDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                            >

                                <option value="">
                                    Semua subkategori
                                </option>

                                @foreach ($subcategories as $subcategory)

                                    <option
                                        value="{{ $subcategory->slug }}"
                                        @selected($subcategorySlug === $subcategory->slug)
                                    >
                                        {{ $subcategory->name }}
                                    </option>

                                @endforeach

                            </select>

                            <i
                                class="bi bi-chevron-down pointer-events-none absolute right-3 top-1/2 mt-1 -translate-y-1/2 text-[10px] text-[#8A9B94]"
                            ></i>

                        </div>

                    </div>


                    {{-- Price --}}
                    <div>

                        <div class="text-xs font-semibold text-[#40564C]">
                            Rentang harga
                        </div>

                        <div class="mt-2 grid grid-cols-2 gap-2">

                            <input
                                type="number"
                                name="min_price"
                                min="0"
                                value="{{ $minPrice }}"
                                placeholder="Harga minimum"
                                class="w-full rounded-xl border border-[#D8E5DD] bg-white px-3 py-3 text-sm text-[#40564C] outline-none placeholder:text-[#A0AEA8] focus:border-[#9DCDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                            >

                            <input
                                type="number"
                                name="max_price"
                                min="0"
                                value="{{ $maxPrice }}"
                                placeholder="Harga maksimum"
                                class="w-full rounded-xl border border-[#D8E5DD] bg-white px-3 py-3 text-sm text-[#40564C] outline-none placeholder:text-[#A0AEA8] focus:border-[#9DCDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                            >

                        </div>

                    </div>


                    {{-- Sort --}}
                    <div>

                        <label
                            for="mobile-filter-sort"
                            class="text-xs font-semibold text-[#40564C]"
                        >
                            Urutkan
                        </label>

                        <div class="relative">

                            <select
                                id="mobile-filter-sort"
                                name="sort"
                                class="jasain-select mt-2 w-full rounded-xl border border-[#D8E5DD] bg-white px-3 py-3 pr-9 text-sm text-[#40564C] outline-none focus:border-[#9DCDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                            >

                                <option value="relevance" @selected($sort === 'relevance')>
                                    Paling relevan
                                </option>

                                <option value="popular" @selected($sort === 'popular')>
                                    Paling populer
                                </option>

                                <option value="rating" @selected($sort === 'rating')>
                                    Rating tertinggi
                                </option>

                                <option value="price_low" @selected($sort === 'price_low')>
                                    Harga terendah
                                </option>

                                <option value="price_high" @selected($sort === 'price_high')>
                                    Harga tertinggi
                                </option>

                            </select>

                            <i
                                class="bi bi-chevron-down pointer-events-none absolute right-3 top-1/2 mt-1 -translate-y-1/2 text-[10px] text-[#8A9B94]"
                            ></i>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="flex gap-2 pt-1">

                        <a
                            href="{{ route('marketplace.search') }}"
                            class="inline-flex h-12 flex-1 items-center justify-center rounded-xl border border-[#D7E4DC] bg-white text-sm font-semibold text-[#53675E] transition hover:bg-[#F5F8F6]"
                        >
                            Reset
                        </a>


                        <button
                            type="submit"
                            class="inline-flex h-12 flex-[1.5] items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                        >
                            Tampilkan jasa

                            <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MOBILE FILTER SCRIPT
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const overlay = document.getElementById('mobile-filter-overlay');
            const openButton = document.getElementById('open-mobile-filter');
            const closeButton = document.getElementById('close-mobile-filter');
            const backdrop = document.getElementById('mobile-filter-backdrop');

            if (!overlay || !openButton || !closeButton || !backdrop) {
                return;
            }

            function openFilter() {
                overlay.classList.add('is-open');
                document.body.classList.add('overflow-hidden');
            }

            function closeFilter() {
                overlay.classList.remove('is-open');
                document.body.classList.remove('overflow-hidden');
            }

            openButton.addEventListener('click', openFilter);

            closeButton.addEventListener('click', closeFilter);

            backdrop.addEventListener('click', closeFilter);

            document.addEventListener('keydown', function (event) {

                if (event.key === 'Escape') {
                    closeFilter();
                }

            });

            window.addEventListener('resize', function () {

                if (window.innerWidth >= 1024) {
                    closeFilter();
                }

            });

        });
    </script>

</x-layouts.marketplace>