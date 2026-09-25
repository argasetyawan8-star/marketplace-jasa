<x-layouts.marketplace title="Cari Jasa - ProKerja">

    
<div
    x-data="{
        filterOpen: false,
        searching: false
    }"
    class="min-h-screen bg-[#F8FAFC] "
>


        {{-- =========================================================
            SEARCH HEADER
        ========================================================== --}}
        <section class="border-b border-[#E2E8F0] bg-white">


            <div class="mx-auto max-w-7xl px-4 py-3.5 sm:px-6 sm:py-4 lg:px-8">


                <div class="max-w-3xl">

                    <p
                        class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#64748B]"
                    >
                        Jelajahi jasa
                    </p>

                    <h1
                        class="mt-1.5 text-xl font-bold tracking-[-0.025em] text-[#0F172A] sm:text-2xl"
                    >
                        @if ($query)
                            Hasil untuk "{{ $query }}"
                        @else
                            Temukan jasa yang kamu butuhkan
                        @endif
                    </h1>

                    <p class="mt-1.5 text-xs leading-5 text-[#64748B]">
                        Temukan freelancer dan layanan yang sesuai dengan kebutuhan project-mu.
                    </p>

                </div>


                {{-- SEARCH FORM --}}
                <form
                    action="{{ route('marketplace.search') }}"
                    method="GET"
                    class="mt-4"
                    @submit="searching = true"
                >

                    {{-- Preserve filters --}}
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

                    <div
                        class="
                            group flex flex-col gap-2 rounded-2xl
                            border border-[#E2E8F0]
                            bg-white p-1.5
                            shadow-[0_4px_18px_rgba(15,23,42,0.04)]
                            transition-all duration-300
                            focus-within:border-[#93C5FD]
                            focus-within:shadow-[0_8px_28px_rgba(37,99,235,0.10)]
                            sm:flex-row
                        "
                    >

                        {{-- Input --}}
                        <div class="relative min-w-0 flex-1">

                            <i
                                class="
                                    bi bi-search pointer-events-none absolute left-4 top-1/2
                                    -translate-y-1/2 text-sm text-[#94A3B8]
                                    transition-all duration-300
                                    group-focus-within:text-[#2563EB]
                                "
                            ></i>

                            <input
                                type="text"
                                name="q"
                                value="{{ $query }}"
                                autocomplete="off"
                                placeholder="Cari jasa, keahlian, atau freelancer..."
                                class="
                                    h-11 w-full rounded-xl border-0 bg-transparent
                                    pl-11 pr-4 text-xs font-medium text-[#0F172A]
                                    outline-none placeholder:text-[#94A3B8]
                                    transition-all duration-300
                                    focus:ring-0 sm:text-sm
                                "
                            >

                        </div>


                        {{-- Search Button --}}
                        <button
                            type="submit"
                            :disabled="searching"
                            class="
                                inline-flex h-11 shrink-0 items-center justify-center gap-2
                                rounded-xl bg-[#2563EB] px-6
                                text-xs font-semibold text-white
                                shadow-[0_5px_14px_rgba(37,99,235,0.16)]
                                transition-all duration-300
                                hover:-translate-y-0.5
                                hover:bg-[#1D4ED8]
                                hover:shadow-[0_8px_20px_rgba(37,99,235,0.20)]
                                active:translate-y-0
                                disabled:cursor-wait disabled:opacity-80
                                sm:px-7
                            "
                        >

                            <span
                                x-show="!searching"
                                x-transition:enter="transition duration-200"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                            >
                                Cari
                            </span>

                            <span
                                x-show="searching"
                                x-cloak
                                class="inline-flex items-center gap-2"
                                x-transition:enter="transition duration-200"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                            >
                                <i class="bi bi-arrow-repeat animate-spin text-[13px]"></i>
                                Mencari
                            </span>

                        </button>

                    </div>

                </form>


                {{-- POPULAR SEARCH --}}
                <div class="mt-3 flex flex-wrap items-center gap-2">

                    <span class="text-[10px] font-medium text-[#94A3B8]">
                        Populer:
                    </span>

                    @foreach (['Logo Design', 'Website', 'Video Editing', 'Social Media', 'Copywriting', 'AI Services'] as $keyword)

                        <a
                            href="{{ route('marketplace.search', ['q' => $keyword]) }}"
                            class="
                                rounded-full border border-[#E2E8F0]
                                bg-[#F8FAFC] px-3 py-1.5
                                text-[10px] font-medium text-[#64748B]
                                transition-all duration-200
                                hover:-translate-y-0.5
                                hover:border-[#BFDBFE]
                                hover:bg-[#EFF6FF]
                                hover:text-[#2563EB]
                            "
                        >
                            {{ $keyword }}
                        </a>

                    @endforeach

                </div>

            </div>

        </section>


        {{-- =========================================================
            MAIN CONTENT
        ========================================================== --}}
        <section class="mx-auto max-w-7xl px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-7">

            {{-- MOBILE TOOLBAR --}}
            <div class="flex items-center justify-between gap-3 lg:hidden">

                {{-- Filter button --}}
                <button
                    type="button"
                    @click="filterOpen = !filterOpen"
                    class="
                        inline-flex h-10 items-center gap-2 rounded-xl
                        border border-[#E2E8F0] bg-white px-4
                        text-xs font-semibold text-[#334155]
                        shadow-sm
                        transition-all duration-200
                        hover:border-[#BFDBFE]
                        hover:bg-[#EFF6FF]
                        hover:text-[#2563EB]
                    "
                >
                    <i class="bi bi-sliders2 text-[12px]"></i>
                    Filter
                </button>


                {{-- Mobile sorting --}}
                <form
                    method="GET"
                    action="{{ route('marketplace.search') }}"
                    class="min-w-0"
                >

                    @if ($query)
                        <input
                            type="hidden"
                            name="q"
                            value="{{ $query }}"
                        >
                    @endif

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

                    <select
                        name="sort"
                        onchange="this.form.submit()"
                        class="
                            h-10 max-w-[165px] rounded-xl
                            border border-[#E2E8F0]
                            bg-white px-3
                            text-[10px] font-medium text-[#475569]
                            outline-none
                            transition-all duration-200
                            focus:border-[#93C5FD]
                            focus:ring-2 focus:ring-[#DBEAFE]
                        "
                    >

                        <option
                            value="relevance"
                            {{ $sort === 'relevance' ? 'selected' : '' }}
                        >
                            Paling relevan
                        </option>

                        <option
                            value="popular"
                            {{ $sort === 'popular' ? 'selected' : '' }}
                        >
                            Terpopuler
                        </option>

                        <option
                            value="rating"
                            {{ $sort === 'rating' ? 'selected' : '' }}
                        >
                            Rating tertinggi
                        </option>

                        <option
                            value="price_low"
                            {{ $sort === 'price_low' ? 'selected' : '' }}
                        >
                            Harga terendah
                        </option>

                        <option
                            value="price_high"
                            {{ $sort === 'price_high' ? 'selected' : '' }}
                        >
                            Harga tertinggi
                        </option>

                    </select>

                </form>

            </div>


            {{-- =====================================================
                CONTENT GRID
            ====================================================== --}}
            <div class="mt-5 grid gap-5 lg:grid-cols-[220px_minmax(0,1fr)] lg:gap-6">


                {{-- =================================================
                    FILTER SIDEBAR
                ================================================== --}}
                <aside
                    class="
                        rounded-2xl border border-[#E2E8F0]
                        bg-white p-4 shadow-sm
                        lg:block
                    "
                    :class="filterOpen ? 'block' : 'hidden lg:block'"
                >

                    <form
                        action="{{ route('marketplace.search') }}"
                        method="GET"
                        class="space-y-6"
                    >

                        @if ($query)

                            <input
                                type="hidden"
                                name="q"
                                value="{{ $query }}"
                            >

                        @endif


                        {{-- CATEGORY --}}
                        <div>

                            <div class="flex items-center justify-between">

                                <h2 class="text-xs font-bold text-[#0F172A]">
                                    Kategori
                                </h2>

                                @if ($categorySlug || $subcategorySlug)

                                    <a
                                        href="{{ route('marketplace.search', ['q' => $query]) }}"
                                        class="
                                            text-[10px] font-medium text-[#94A3B8]
                                            transition-colors duration-200
                                            hover:text-[#2563EB]
                                        "
                                    >
                                        Reset
                                    </a>

                                @endif

                            </div>


                            <div class="mt-3 space-y-2.5">

                                <label
                                    class="
                                        flex cursor-pointer items-center gap-2.5
                                        rounded-lg px-2 py-1.5
                                        transition-colors duration-200
                                        hover:bg-[#F8FAFC]
                                    "
                                >

                                    <input
                                        type="radio"
                                        name="category"
                                        value=""
                                        onchange="this.form.submit()"
                                        class="
                                            h-3.5 w-3.5
                                            accent-[#2563EB]
                                        "
                                        {{ !$categorySlug ? 'checked' : '' }}
                                    >

                                    <span class="text-[11px] font-medium text-[#64748B]">
                                        Semua kategori
                                    </span>

                                </label>


                                @foreach ($categories as $category)

                                    <label
                                        class="
                                            flex cursor-pointer items-center gap-2.5
                                            rounded-lg px-2 py-1.5
                                            transition-colors duration-200
                                            hover:bg-[#F8FAFC]
                                        "
                                    >

                                        <input
                                            type="radio"
                                            name="category"
                                            value="{{ $category->slug }}"
                                            onchange="this.form.submit()"
                                            class="
                                                h-3.5 w-3.5
                                                accent-[#2563EB]
                                            "
                                            {{ $categorySlug === $category->slug ? 'checked' : '' }}
                                        >

                                        <span class="truncate text-[11px] font-medium text-[#64748B]">
                                            {{ $category->name }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>


                        {{-- SUBCATEGORY --}}
                        <div>

                            <h2 class="text-xs font-bold text-[#0F172A]">
                                Subkategori
                            </h2>

                            <select
                                name="subcategory"
                                onchange="this.form.submit()"
                                class="
                                    mt-3 h-10 w-full rounded-xl
                                    border border-[#E2E8F0]
                                    bg-white px-3
                                    text-[10px] font-medium text-[#64748B]
                                    outline-none
                                    transition-all duration-200
                                    focus:border-[#93C5FD]
                                    focus:ring-2 focus:ring-[#DBEAFE]
                                "
                            >

                                <option value="">
                                    Semua subkategori
                                </option>

                                @foreach ($subcategories as $subcategory)

                                    <option
                                        value="{{ $subcategory->slug }}"
                                        {{ $subcategorySlug === $subcategory->slug ? 'selected' : '' }}
                                    >
                                        {{ $subcategory->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- PRICE --}}
                        <div>

                            <h2 class="text-xs font-bold text-[#0F172A]">
                                Harga
                            </h2>

                            <div class="mt-3 grid grid-cols-2 gap-2">

                                <input
                                    type="number"
                                    name="min_price"
                                    value="{{ $minPrice }}"
                                    min="0"
                                    placeholder="Min"
                                    class="
                                        h-10 w-full rounded-xl
                                        border border-[#E2E8F0]
                                        bg-white px-3
                                        text-[10px] font-medium text-[#0F172A]
                                        outline-none
                                        placeholder:text-[#94A3B8]
                                        transition-all duration-200
                                        focus:border-[#93C5FD]
                                        focus:ring-2 focus:ring-[#DBEAFE]
                                    "
                                >

                                <input
                                    type="number"
                                    name="max_price"
                                    value="{{ $maxPrice }}"
                                    min="0"
                                    placeholder="Max"
                                    class="
                                        h-10 w-full rounded-xl
                                        border border-[#E2E8F0]
                                        bg-white px-3
                                        text-[10px] font-medium text-[#0F172A]
                                        outline-none
                                        placeholder:text-[#94A3B8]
                                        transition-all duration-200
                                        focus:border-[#93C5FD]
                                        focus:ring-2 focus:ring-[#DBEAFE]
                                    "
                                >

                            </div>


                            <button
                                type="submit"
                                class="
                                    mt-2.5 h-10 w-full rounded-xl
                                    bg-[#EFF6FF]
                                    text-[10px] font-semibold text-[#2563EB]
                                    transition-all duration-200
                                    hover:bg-[#DBEAFE]
                                "
                            >
                                Terapkan harga
                            </button>

                        </div>


                        {{-- DESKTOP SORT --}}
                        <div class="hidden lg:block">

                            <h2 class="text-xs font-bold text-[#0F172A]">
                                Urutkan
                            </h2>

                            <select
                                name="sort"
                                class="
                                    mt-3 h-10 w-full rounded-xl
                                    border border-[#E2E8F0]
                                    bg-white px-3
                                    text-[10px] font-medium text-[#64748B]
                                    outline-none
                                    transition-all duration-200
                                    focus:border-[#93C5FD]
                                    focus:ring-2 focus:ring-[#DBEAFE]
                                "
                            >

                                <option
                                    value="relevance"
                                    {{ $sort === 'relevance' ? 'selected' : '' }}
                                >
                                    Paling relevan
                                </option>

                                <option
                                    value="popular"
                                    {{ $sort === 'popular' ? 'selected' : '' }}
                                >
                                    Terpopuler
                                </option>

                                <option
                                    value="rating"
                                    {{ $sort === 'rating' ? 'selected' : '' }}
                                >
                                    Rating tertinggi
                                </option>

                                <option
                                    value="price_low"
                                    {{ $sort === 'price_low' ? 'selected' : '' }}
                                >
                                    Harga terendah
                                </option>

                                <option
                                    value="price_high"
                                    {{ $sort === 'price_high' ? 'selected' : '' }}
                                >
                                    Harga tertinggi
                                </option>

                            </select>

                        </div>

                    </form>

                </aside>


                {{-- =================================================
                    RESULTS
                ================================================== --}}
                <div
                    class="min-w-0"
                    x-data="{ loaded: false }"
                    x-init="requestAnimationFrame(() => loaded = true)"
                    :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-1'"
                    class="transition-all duration-500 ease-out"
                >

                    {{-- RESULTS HEADER --}}
                    <div class="flex items-end justify-between gap-4">

                        <div class="min-w-0">

                            <p class="text-xs font-bold text-[#0F172A]">
                                {{ $services->total() }} jasa ditemukan
                            </p>

                            @if ($query)

                                <p class="mt-1 truncate text-[10px] text-[#64748B]">
                                    Menampilkan hasil untuk "{{ $query }}"
                                </p>

                            @else

                                <p class="mt-1 text-[10px] text-[#94A3B8]">
                                    Pilih jasa yang paling sesuai dengan kebutuhanmu.
                                </p>

                            @endif

                        </div>


                        <span
                            class="
                                hidden shrink-0 rounded-full
                                bg-white px-3 py-1.5
                                text-[10px] font-medium text-[#64748B]
                                shadow-sm ring-1 ring-[#E2E8F0]
                                lg:block
                            "
                        >
                            Halaman {{ $services->currentPage() }}
                            / {{ $services->lastPage() }}
                        </span>

                    </div>


                    {{-- SERVICE GRID --}}
                    @if ($services->count())

                        <div
                            class="
                                mt-4 grid
                                grid-cols-2
                                gap-3
                                sm:grid-cols-3 sm:gap-4
                                xl:grid-cols-4
                            "
                        >

                            @foreach ($services as $service)

                                @php

                                    $freelancerProfile = $service->freelancerProfile;
                                    $freelancerUser = $freelancerProfile?->user;

                                    $thumbnail = $service->thumbnail
                                        ? asset('storage/' . $service->thumbnail)
                                        : null;

                                    $freelancerName = $freelancerUser?->name ?? 'Freelancer';
                                    $freelancerInitial = strtoupper(
                                        substr($freelancerName, 0, 1)
                                    );

                                    $headline = $freelancerProfile?->headline;

                                    $rating = (float) ($service->rating ?? 0);
                                    $reviewsCount = (int) ($service->reviews_count ?? 0);
                                    $startingPrice = (int) ($service->starting_price ?? 0);

                                @endphp


                                <article
                                    class="
                                        group flex h-full min-w-0 flex-col overflow-hidden
                                        rounded-2xl border border-[#E2E8F0]
                                        bg-white
                                        shadow-[0_2px_10px_rgba(15,23,42,0.03)]
                                        transition-all duration-300 ease-out
                                        hover:-translate-y-1
                                        hover:border-[#BFDBFE]
                                        hover:shadow-[0_12px_30px_rgba(37,99,235,0.10)]
                                    "
                                >

                                    {{-- IMAGE --}}
                                    <a
                                        href="{{ route('marketplace.service', $service->slug) }}"
                                        class="block"
                                    >

                                        <div
                                            class="
                                                relative aspect-[4/3]
                                                overflow-hidden
                                                bg-[#EFF6FF]
                                            "
                                        >

                                            @if ($thumbnail)

                                                <img
                                                    src="{{ $thumbnail }}"
                                                    alt="{{ $service->title }}"
                                                    loading="lazy"
                                                    class="
                                                        h-full w-full object-cover
                                                        transition-transform duration-500 ease-out
                                                        group-hover:scale-[1.04]
                                                    "
                                                >

                                            @else

                                                <div
                                                    class="
                                                        flex h-full w-full items-center
                                                        justify-center
                                                        bg-gradient-to-br
                                                        from-[#EFF6FF] to-[#DBEAFE]
                                                    "
                                                >

                                                    <div class="text-center">

                                                        <div
                                                            class="
                                                                mx-auto flex h-10 w-10
                                                                items-center justify-center
                                                                rounded-xl bg-white
                                                                text-[#2563EB]
                                                                shadow-sm
                                                            "
                                                        >
                                                            <i class="bi bi-briefcase text-sm"></i>
                                                        </div>

                                                        <p
                                                            class="
                                                                mt-2 max-w-[90px] truncate
                                                                text-[8px] font-semibold
                                                                uppercase tracking-[0.08em]
                                                                text-[#64748B]
                                                            "
                                                        >
                                                            {{ $service->category?->name ?? 'Jasa' }}
                                                        </p>

                                                    </div>

                                                </div>

                                            @endif


                                            {{-- Featured --}}
                                            @if ($service->is_featured)

                                                <span
                                                    class="
                                                        absolute left-2.5 top-2.5
                                                        rounded-full
                                                        bg-[#2563EB]
                                                        px-2 py-1
                                                        text-[8px] font-bold
                                                        text-white
                                                        shadow-sm
                                                    "
                                                >
                                                    Pilihan
                                                </span>

                                            @endif


                                            {{-- Favorite --}}
                                            <button
                                                type="button"
                                                class="
                                                    absolute right-2.5 top-2.5
                                                    flex h-7 w-7
                                                    items-center justify-center
                                                    rounded-full
                                                    bg-white/95
                                                    text-[#64748B]
                                                    shadow-sm
                                                    backdrop-blur
                                                    transition-all duration-200
                                                    hover:scale-105
                                                    hover:text-[#2563EB]
                                                "
                                                onclick="event.preventDefault(); event.stopPropagation();"
                                                aria-label="Favorit"
                                            >
                                                <i class="bi bi-heart text-[12px]"></i>
                                            </button>

                                        </div>

                                    </a>


                                    {{-- CONTENT --}}
                                    <div class="flex flex-1 flex-col p-3 sm:p-4">

                                        {{-- FREELANCER --}}
                                        @if ($freelancerProfile && $freelancerUser)

                                            <a
                                                href="{{ route('marketplace.freelancer', $freelancerProfile->username) }}"
                                                class="
                                                    flex min-w-0 items-center gap-2
                                                    rounded-lg
                                                    transition-opacity duration-200
                                                    hover:opacity-80
                                                "
                                            >

                                                <div
                                                    class="
                                                        flex h-7 w-7 shrink-0
                                                        items-center justify-center
                                                        overflow-hidden rounded-full
                                                        bg-[#EFF6FF]
                                                        text-[9px] font-bold
                                                        text-[#2563EB]
                                                    "
                                                >

                                                    @if ($freelancerProfile->avatar)

                                                        <img
                                                            src="{{ asset('storage/' . $freelancerProfile->avatar) }}"
                                                            alt="{{ $freelancerName }}"
                                                            loading="lazy"
                                                            class="h-full w-full object-cover"
                                                        >

                                                    @else

                                                        {{ $freelancerInitial }}

                                                    @endif

                                                </div>


                                                <div class="min-w-0">

                                                    <div class="flex min-w-0 items-center gap-1">

                                                        <p
                                                            class="
                                                                truncate text-[9px] font-semibold
                                                                text-[#0F172A]
                                                                sm:text-[10px]
                                                            "
                                                        >
                                                            {{ $freelancerName }}
                                                        </p>

                                                        @if ($freelancerProfile->is_verified)

                                                            <span
                                                                class="
                                                                    inline-flex h-3.5 w-3.5
                                                                    shrink-0 items-center justify-center
                                                                    rounded-full
                                                                    bg-[#DBEAFE]
                                                                    text-[7px] font-bold
                                                                    text-[#2563EB]
                                                                "
                                                                title="Terverifikasi"
                                                            >
                                                                ✓
                                                            </span>

                                                        @endif

                                                    </div>


                                                    @if ($headline)

                                                        <p
                                                            class="
                                                                mt-0.5 truncate
                                                                text-[8px] text-[#94A3B8]
                                                                sm:text-[9px]
                                                            "
                                                        >
                                                            {{ $headline }}
                                                        </p>

                                                    @else

                                                        <p
                                                            class="
                                                                mt-0.5 truncate
                                                                text-[8px] text-[#94A3B8]
                                                                sm:text-[9px]
                                                            "
                                                        >
                                                            Freelancer
                                                        </p>

                                                    @endif

                                                </div>

                                            </a>

                                        @else

                                            <div class="flex items-center gap-2">

                                                <div
                                                    class="
                                                        flex h-7 w-7 shrink-0
                                                        items-center justify-center
                                                        rounded-full bg-[#F1F5F9]
                                                        text-[9px] font-bold text-[#64748B]
                                                    "
                                                >
                                                    F
                                                </div>

                                                <div class="min-w-0">

                                                    <p
                                                        class="
                                                            truncate text-[9px] font-semibold
                                                            text-[#475569]
                                                            sm:text-[10px]
                                                        "
                                                    >
                                                        Freelancer
                                                    </p>

                                                    <p class="text-[8px] text-[#94A3B8]">
                                                        Profil belum tersedia
                                                    </p>

                                                </div>

                                            </div>

                                        @endif


                                        {{-- CATEGORY + DELIVERY --}}
                                        <div
                                            class="
                                                mt-2.5 flex min-w-0 items-center
                                                gap-1.5 overflow-hidden
                                            "
                                        >

                                            @if ($service->category)

                                                <span
                                                    class="
                                                        min-w-0 truncate
                                                        text-[8px] font-semibold
                                                        text-[#2563EB]
                                                        sm:text-[9px]
                                                    "
                                                >
                                                    {{ $service->category->name }}
                                                </span>

                                            @endif


                                            @if ($service->delivery_days)

                                                <span class="text-[8px] text-[#CBD5E1]">
                                                    •
                                                </span>

                                                <span
                                                    class="
                                                        shrink-0 text-[8px]
                                                        font-medium text-[#94A3B8]
                                                        sm:text-[9px]
                                                    "
                                                >
                                                    {{ $service->delivery_days }} hari
                                                </span>

                                            @endif

                                        </div>


                                        {{-- TITLE --}}
                                        <a
                                            href="{{ route('marketplace.service', $service->slug) }}"
                                            class="block"
                                        >

                                            <h3
                                                class="
                                                    mt-2.5 line-clamp-2
                                                    min-h-[36px]
                                                    text-[10px] font-bold leading-4
                                                    text-[#0F172A]
                                                    transition-colors duration-200
                                                    group-hover:text-[#2563EB]
                                                    sm:min-h-[40px]
                                                    sm:text-[11px] sm:leading-5
                                                "
                                            >
                                                {{ $service->title }}
                                            </h3>

                                        </a>


                                        {{-- STATS --}}
                                        <div
                                            class="
                                                mt-2 flex min-w-0 items-center
                                                gap-1 overflow-hidden
                                                text-[8px] sm:gap-1.5 sm:text-[9px]
                                            "
                                        >

                                            <span
                                                class="
                                                    shrink-0 font-semibold text-[#0F172A]
                                                "
                                            >
                                                <i class="bi bi-star-fill text-[#F59E0B]"></i>
                                                {{ number_format($rating, 1) }}
                                            </span>

                                            <span class="shrink-0 text-[#CBD5E1]">
                                                •
                                            </span>

                                            <span
                                                class="
                                                    truncate text-[#94A3B8]
                                                "
                                            >
                                                {{ number_format($reviewsCount) }} review
                                            </span>

                                        </div>


                                        {{-- PRICE --}}
                                        <div
                                            class="
                                                mt-auto pt-3
                                                sm:pt-4
                                            "
                                        >

                                            <div
                                                class="
                                                    border-t border-[#F1F5F9]
                                                    pt-3
                                                    sm:pt-3.5
                                                "
                                            >

                                                <p
                                                    class="
                                                        text-[7px] font-medium
                                                        uppercase tracking-[0.08em]
                                                        text-[#94A3B8]
                                                        sm:text-[8px]
                                                    "
                                                >
                                                    Mulai dari
                                                </p>

                                                <div class="mt-0.5 flex items-center justify-between gap-2">

                                                    <p
                                                        class="
                                                            truncate text-[11px]
                                                            font-bold text-[#0F172A]
                                                            sm:text-[13px]
                                                        "
                                                    >
                                                        Rp{{ number_format($startingPrice, 0, ',', '.') }}
                                                    </p>

                                                    <span
                                                        class="
                                                            inline-flex h-6 w-6 shrink-0
                                                            items-center justify-center
                                                            rounded-full
                                                            bg-[#EFF6FF]
                                                            text-[#2563EB]
                                                            transition-all duration-200
                                                            group-hover:bg-[#2563EB]
                                                            group-hover:text-white
                                                            sm:h-7 sm:w-7
                                                        "
                                                    >
                                                        <i class="bi bi-arrow-up-right text-[9px]"></i>
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </article>

                            @endforeach

                        </div>


                        {{-- PAGINATION --}}
                        <div
                            class="
                                mt-6 border-t border-[#E2E8F0]
                                pt-5
                            "
                        >
                            {{ $services->onEachSide(1)->links() }}
                        </div>

                    @else

                        {{-- EMPTY STATE --}}
                        <div
                            class="
                                mt-5 rounded-2xl
                                border border-dashed border-[#CBD5E1]
                                bg-white
                                px-5 py-14 text-center
                                shadow-sm
                            "
                        >

                            <div
                                class="
                                    mx-auto flex h-12 w-12
                                    items-center justify-center
                                    rounded-2xl
                                    bg-[#EFF6FF]
                                    text-[#2563EB]
                                "
                            >
                                <i class="bi bi-search text-lg"></i>
                            </div>


                            <h2
                                class="
                                    mt-4 text-sm font-bold
                                    text-[#0F172A]
                                "
                            >
                                Jasa tidak ditemukan
                            </h2>


                            <p
                                class="
                                    mx-auto mt-2 max-w-sm
                                    text-[11px] leading-5 text-[#64748B]
                                "
                            >
                                Coba gunakan kata kunci lain atau hapus beberapa filter
                                untuk melihat lebih banyak hasil.
                            </p>


                            <a
                                href="{{ route('marketplace.search') }}"
                                class="
                                    mt-5 inline-flex items-center gap-2
                                    rounded-xl
                                    bg-[#2563EB]
                                    px-4 py-2.5
                                    text-[10px] font-semibold text-white
                                    shadow-[0_5px_14px_rgba(37,99,235,0.14)]
                                    transition-all duration-200
                                    hover:-translate-y-0.5
                                    hover:bg-[#1D4ED8]
                                "
                            >
                                Reset pencarian
                                <i class="bi bi-arrow-right text-[9px]"></i>
                            </a>

                        </div>

                    @endif

                </div>

            </div>

        </section>

    </div>


    {{-- =========================================================
        EXTRA SMOOTHNESS
    ========================================================== --}}
    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

</x-layouts.marketplace>

