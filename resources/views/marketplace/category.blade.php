<x-layouts.marketplace :title="$category->name . ' - JASAIN'">


<div class="min-h-screen bg-[#F8FCF9]">

    {{-- =========================================================
        HEADER / CATEGORY HERO
    ========================================================== --}}
    <section class="border-b border-[#E2ECE6] bg-white">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

            {{-- Breadcrumb --}}
            <nav
                class="flex flex-wrap items-center gap-2 text-[11px] text-[#91A099] sm:text-xs"
                aria-label="Breadcrumb"
            >

                <a
                    href="{{ route('marketplace.home') }}"
                    class="transition hover:text-[#0F6B3A]"
                >
                    Beranda
                </a>

                <span>•</span>

                <span class="font-medium text-[#567066]">
                    Kategori
                </span>

                <span>•</span>

                <span class="font-medium text-[#123128]">
                    {{ $category->name }}
                </span>

            </nav>


            {{-- Heading --}}
            <div class="mt-7 max-w-3xl">

                <span class="inline-flex items-center gap-2 text-sm font-semibold text-[#1E9E5A]">

                    <span class="h-2 w-2 rounded-full bg-[#1E9E5A]"></span>

                    Kategori jasa

                </span>

                <h1
                    class="mt-3 text-3xl font-semibold tracking-[-0.035em] text-[#123128] sm:text-4xl lg:text-[42px]"
                >
                    {{ $category->name }}
                </h1>

                <p
                    class="mt-4 max-w-2xl text-sm leading-7 text-[#6D8178] sm:text-base"
                >
                    Temukan layanan dari freelancer profesional
                    yang sesuai dengan kebutuhanmu di kategori
                    {{ $category->name }}.
                </p>

            </div>


            {{-- Statistics --}}
            <div
                class="mt-8 grid max-w-2xl grid-cols-2 divide-x divide-[#E5EEE8] border-t border-[#E5EEE8] pt-6 sm:grid-cols-3"
            >

                <div class="pr-4">

                    <div class="text-xl font-semibold text-[#123128]">
                        {{ number_format($totalServices, 0, ',', '.') }}
                    </div>

                    <div class="mt-1 text-[11px] text-[#8A9B94] sm:text-xs">
                        Layanan tersedia
                    </div>

                </div>


                <div class="px-4">

                    <div class="text-xl font-semibold text-[#123128]">
                        {{ number_format($totalSubcategories, 0, ',', '.') }}
                    </div>

                    <div class="mt-1 text-[11px] text-[#8A9B94] sm:text-xs">
                        Subkategori
                    </div>

                </div>


                <div
                    class="col-span-2 mt-5 border-t border-[#E5EEE8] pt-5 sm:col-span-1 sm:mt-0 sm:border-t-0 sm:pt-0 sm:pl-4"
                >

                    <div class="text-xl font-semibold text-[#123128]">
                        JASAIN
                    </div>

                    <div class="mt-1 text-[11px] text-[#8A9B94] sm:text-xs">
                        Marketplace jasa
                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        MAIN
    ========================================================== --}}
    <section class="py-8 sm:py-10">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid gap-6 lg:grid-cols-[250px_minmax(0,1fr)]">

                {{-- =================================================
                    SIDEBAR
                ================================================== --}}
                <aside class="hidden lg:block">

                    <form
                        method="GET"
                        action="{{ route('marketplace.category', $category->slug) }}"
                        class="sticky top-24 space-y-5"
                    >

                        {{-- Search --}}
                        <div class="rounded-2xl border border-[#DCEDE3] bg-white p-4">

                            <label
                                for="category-search"
                                class="text-xs font-semibold text-[#123128]"
                            >
                                Cari dalam kategori
                            </label>

                            <div
                                class="mt-3 flex items-center gap-2 rounded-xl border border-[#DDE9E2] bg-[#FAFCFB] px-3"
                            >

                                <i class="bi bi-search text-sm text-[#84968E]"></i>

                                <input
                                    id="category-search"
                                    type="text"
                                    name="q"
                                    value="{{ $keyword }}"
                                    placeholder="Cari layanan..."
                                    class="w-full border-0 bg-transparent py-2.5 text-xs text-[#123128] outline-none placeholder:text-[#A2AEA9] focus:border-0 focus:ring-0"
                                >

                            </div>

                        </div>


                        {{-- Subcategories --}}
                        <div class="rounded-2xl border border-[#DCEDE3] bg-white p-4">

                            <div class="flex items-center justify-between">

                                <h2 class="text-xs font-semibold text-[#123128]">
                                    Subkategori
                                </h2>

                                @if ($subcategorySlug || $keyword || $minPrice || $maxPrice || $sort !== 'relevance')

                                    <a
                                        href="{{ route('marketplace.category', $category->slug) }}"
                                        class="text-[10px] font-medium text-[#1E9E5A] hover:text-[#0F6B3A]"
                                    >
                                        Reset
                                    </a>

                                @endif

                            </div>


                            <div class="mt-4 space-y-2.5">

                                <label class="flex cursor-pointer items-center justify-between gap-3">

                                    <span class="flex min-w-0 items-center gap-2.5">

                                        <input
                                            type="radio"
                                            name="subcategory"
                                            value=""
                                            onchange="this.form.submit()"
                                            @checked($subcategorySlug === '')
                                            class="h-3.5 w-3.5 border-[#CAD8D1] text-[#0F6B3A] focus:ring-[#0F6B3A]"
                                        >

                                        <span class="truncate text-xs text-[#5E7268]">
                                            Semua subkategori
                                        </span>

                                    </span>

                                    <span class="text-[10px] text-[#A0ADA7]">
                                        {{ $totalServices }}
                                    </span>

                                </label>


                                @foreach ($subcategories as $subcategory)

                                    <label class="flex cursor-pointer items-center justify-between gap-3">

                                        <span class="flex min-w-0 items-center gap-2.5">

                                            <input
                                                type="radio"
                                                name="subcategory"
                                                value="{{ $subcategory->slug }}"
                                                onchange="this.form.submit()"
                                                @checked($subcategorySlug === $subcategory->slug)
                                                class="h-3.5 w-3.5 border-[#CAD8D1] text-[#0F6B3A] focus:ring-[#0F6B3A]"
                                            >

                                            <span class="truncate text-xs text-[#5E7268]">
                                                {{ $subcategory->name }}
                                            </span>

                                        </span>

                                        <span class="text-[10px] text-[#A0ADA7]">
                                            {{ $subcategoryServiceCounts[$subcategory->id] ?? 0 }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>


                        {{-- Price --}}
                        <div class="rounded-2xl border border-[#DCEDE3] bg-white p-4">

                            <h2 class="text-xs font-semibold text-[#123128]">
                                Rentang harga
                            </h2>

                            <div class="mt-3 grid grid-cols-2 gap-2">

                                <div>

                                    <label
                                        for="min-price"
                                        class="mb-1 block text-[10px] text-[#91A099]"
                                    >
                                        Minimum
                                    </label>

                                    <input
                                        id="min-price"
                                        type="number"
                                        min="0"
                                        name="min_price"
                                        value="{{ $minPrice !== null ? $minPrice : '' }}"
                                        placeholder="Rp 0"
                                        class="w-full rounded-xl border border-[#DDE9E2] bg-[#FAFCFB] px-3 py-2.5 text-xs text-[#123128] outline-none focus:border-[#A8CFB8] focus:ring-2 focus:ring-[#DCEFE3]"
                                    >

                                </div>


                                <div>

                                    <label
                                        for="max-price"
                                        class="mb-1 block text-[10px] text-[#91A099]"
                                    >
                                        Maksimum
                                    </label>

                                    <input
                                        id="max-price"
                                        type="number"
                                        min="0"
                                        name="max_price"
                                        value="{{ $maxPrice !== null ? $maxPrice : '' }}"
                                        placeholder="Rp 0"
                                        class="w-full rounded-xl border border-[#DDE9E2] bg-[#FAFCFB] px-3 py-2.5 text-xs text-[#123128] outline-none focus:border-[#A8CFB8] focus:ring-2 focus:ring-[#DCEFE3]"
                                    >

                                </div>

                            </div>

                        </div>


                        {{-- Sorting --}}
                        <div class="rounded-2xl border border-[#DCEDE3] bg-white p-4">

                            <h2 class="text-xs font-semibold text-[#123128]">
                                Urutkan
                            </h2>

                            <select
                                name="sort"
                                onchange="this.form.submit()"
                                class="mt-3 w-full rounded-xl border border-[#DDE9E2] bg-[#FAFCFB] px-3 py-2.5 text-xs text-[#5E7268] outline-none focus:border-[#A8CFB8] focus:ring-2 focus:ring-[#DCEFE3]"
                            >

                                <option
                                    value="relevance"
                                    @selected($sort === 'relevance')
                                >
                                    Relevansi
                                </option>

                                <option
                                    value="popular"
                                    @selected($sort === 'popular')
                                >
                                    Paling populer
                                </option>

                                <option
                                    value="rating"
                                    @selected($sort === 'rating')
                                >
                                    Rating tertinggi
                                </option>

                                <option
                                    value="price_low"
                                    @selected($sort === 'price_low')
                                >
                                    Harga termurah
                                </option>

                                <option
                                    value="price_high"
                                    @selected($sort === 'price_high')
                                >
                                    Harga termahal
                                </option>

                                <option
                                    value="newest"
                                    @selected($sort === 'newest')
                                >
                                    Terbaru
                                </option>

                            </select>

                        </div>


                        {{-- Apply --}}
                        <button
                            type="submit"
                            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-4 text-xs font-semibold text-white transition hover:bg-[#1E9E5A]"
                        >
                            <i class="bi bi-funnel"></i>
                            Terapkan filter
                        </button>

                    </form>

                </aside>


                {{-- =================================================
                    CONTENT
                ================================================== --}}
                <main class="min-w-0">

                    {{-- Mobile filter/search --}}
                    <div
                        class="mb-5 rounded-2xl border border-[#DCEDE3] bg-white p-4 lg:hidden"
                    >

                        <form
                            method="GET"
                            action="{{ route('marketplace.category', $category->slug) }}"
                        >

                            <div
                                class="flex items-center gap-2 rounded-xl border border-[#DDE9E2] bg-[#FAFCFB] px-3"
                            >

                                <i class="bi bi-search text-sm text-[#84968E]"></i>

                                <input
                                    type="text"
                                    name="q"
                                    value="{{ $keyword }}"
                                    placeholder="Cari layanan di {{ $category->name }}..."
                                    class="w-full border-0 bg-transparent py-3 text-xs text-[#123128] outline-none placeholder:text-[#A2AEA9] focus:border-0 focus:ring-0"
                                >

                            </div>


                            <div class="mt-3 grid grid-cols-2 gap-2">

                                <select
                                    name="subcategory"
                                    class="w-full rounded-xl border border-[#DDE9E2] bg-white px-3 py-2.5 text-xs text-[#5E7268] outline-none focus:border-[#A8CFB8] focus:ring-2 focus:ring-[#DCEFE3]"
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


                                <select
                                    name="sort"
                                    class="w-full rounded-xl border border-[#DDE9E2] bg-white px-3 py-2.5 text-xs text-[#5E7268] outline-none focus:border-[#A8CFB8] focus:ring-2 focus:ring-[#DCEFE3]"
                                >

                                    <option
                                        value="relevance"
                                        @selected($sort === 'relevance')
                                    >
                                        Relevansi
                                    </option>

                                    <option
                                        value="popular"
                                        @selected($sort === 'popular')
                                    >
                                        Terpopuler
                                    </option>

                                    <option
                                        value="rating"
                                        @selected($sort === 'rating')
                                    >
                                        Rating
                                    </option>

                                    <option
                                        value="price_low"
                                        @selected($sort === 'price_low')
                                    >
                                        Termurah
                                    </option>

                                    <option
                                        value="price_high"
                                        @selected($sort === 'price_high')
                                    >
                                        Termahal
                                    </option>

                                    <option
                                        value="newest"
                                        @selected($sort === 'newest')
                                    >
                                        Terbaru
                                    </option>

                                </select>

                            </div>


                            <div class="mt-2 grid grid-cols-2 gap-2">

                                <input
                                    type="number"
                                    min="0"
                                    name="min_price"
                                    value="{{ $minPrice !== null ? $minPrice : '' }}"
                                    placeholder="Harga minimum"
                                    class="w-full rounded-xl border border-[#DDE9E2] bg-white px-3 py-2.5 text-xs text-[#123128] outline-none focus:border-[#A8CFB8] focus:ring-2 focus:ring-[#DCEFE3]"
                                >

                                <input
                                    type="number"
                                    min="0"
                                    name="max_price"
                                    value="{{ $maxPrice !== null ? $maxPrice : '' }}"
                                    placeholder="Harga maksimum"
                                    class="w-full rounded-xl border border-[#DDE9E2] bg-white px-3 py-2.5 text-xs text-[#123128] outline-none focus:border-[#A8CFB8] focus:ring-2 focus:ring-[#DCEFE3]"
                                >

                            </div>


                            <button
                                type="submit"
                                class="mt-3 inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-xs font-semibold text-white transition hover:bg-[#1E9E5A]"
                            >
                                <i class="bi bi-funnel"></i>
                                Terapkan filter
                            </button>

                        </form>

                    </div>


                    {{-- Result Header --}}
                    <div
                        class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"
                    >

                        <div>

                            <p class="text-[11px] font-medium uppercase tracking-[0.14em] text-[#8B9B94]">
                                {{ $category->name }}
                            </p>

                            <h2
                                class="mt-1 text-xl font-semibold tracking-[-0.025em] text-[#123128] sm:text-2xl"
                            >
                                {{ number_format($services->total(), 0, ',', '.') }}
                                layanan
                            </h2>

                        </div>


                        <div class="text-xs text-[#8B9B94]">

                            @if ($keyword)

                                Hasil pencarian untuk

                                <span class="font-medium text-[#40574D]">
                                    "{{ $keyword }}"
                                </span>

                            @elseif ($selectedSubcategory)

                                Menampilkan subkategori

                                <span class="font-medium text-[#40574D]">
                                    {{ $selectedSubcategory->name }}
                                </span>

                            @else

                                Semua layanan dalam kategori ini

                            @endif

                        </div>

                    </div>


                    {{-- Active Filter --}}
                    @if (
                        $keyword ||
                        $subcategorySlug ||
                        $minPrice !== null ||
                        $maxPrice !== null ||
                        $sort !== 'relevance'
                    )

                        <div class="mt-4 flex flex-wrap items-center gap-2">

                            <span class="text-[10px] font-medium text-[#8A9B94]">
                                Filter aktif:
                            </span>


                            @if ($keyword)

                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-[#EAF7EF] px-2.5 py-1 text-[10px] font-medium text-[#0F6B3A]"
                                >

                                    <i class="bi bi-search"></i>

                                    {{ $keyword }}

                                </span>

                            @endif


                            @if ($selectedSubcategory)

                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-[#EAF7EF] px-2.5 py-1 text-[10px] font-medium text-[#0F6B3A]"
                                >

                                    <i class="bi bi-grid"></i>

                                    {{ $selectedSubcategory->name }}

                                </span>

                            @endif


                            @if ($minPrice !== null)

                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-[#EAF7EF] px-2.5 py-1 text-[10px] font-medium text-[#0F6B3A]"
                                >
                                    Min Rp {{ number_format($minPrice, 0, ',', '.') }}
                                </span>

                            @endif


                            @if ($maxPrice !== null)

                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-[#EAF7EF] px-2.5 py-1 text-[10px] font-medium text-[#0F6B3A]"
                                >
                                    Max Rp {{ number_format($maxPrice, 0, ',', '.') }}
                                </span>

                            @endif


                            @if ($sort !== 'relevance')

                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-[#EAF7EF] px-2.5 py-1 text-[10px] font-medium text-[#0F6B3A]"
                                >

                                    @switch($sort)

                                        @case('popular')
                                            Terpopuler
                                            @break

                                        @case('rating')
                                            Rating tertinggi
                                            @break

                                        @case('price_low')
                                            Harga termurah
                                            @break

                                        @case('price_high')
                                            Harga termahal
                                            @break

                                        @case('newest')
                                            Terbaru
                                            @break

                                    @endswitch

                                </span>

                            @endif


                            <a
                                href="{{ route('marketplace.category', $category->slug) }}"
                                class="text-[10px] font-medium text-[#7D8D86] underline underline-offset-2 transition hover:text-[#0F6B3A]"
                            >
                                Hapus semua
                            </a>

                        </div>

                    @endif


                    {{-- =================================================
                        SERVICES GRID
                    ================================================== --}}
                    <div
                        class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3"
                    >

                        @forelse ($services as $service)

                            @php

                                $freelancer = $service->freelancerProfile;

                                $freelancerUser = $freelancer?->user;

                                $avatar = $freelancer?->avatar
                                    ? asset('storage/' . $freelancer->avatar)
                                    : null;

                                $isFavorited = (bool) ($service->is_favorited ?? false);

                            @endphp


                            {{-- Service Card --}}
                            <article
                                class="group overflow-hidden rounded-2xl border border-[#DEEAE3] bg-white transition duration-300 hover:-translate-y-0.5 hover:border-[#BEDBC9] hover:shadow-[0_16px_32px_rgba(15,107,58,0.07)]"
                            >

                                {{-- Thumbnail --}}
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


                                        {{-- Featured --}}
                                        @if ($service->is_featured)

                                            <span
                                                class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full bg-[#0F6B3A] px-2.5 py-1.5 text-[10px] font-semibold text-white shadow-sm"
                                            >

                                                <i class="bi bi-stars"></i>

                                                Pilihan

                                            </span>

                                        @endif


                                        {{-- Category --}}
                                        <div class="absolute bottom-3 left-3">

                                            <span
                                                class="rounded-full bg-white/90 px-2.5 py-1 text-[9px] font-medium text-[#40574D] shadow-sm backdrop-blur-sm"
                                            >
                                                {{ $service->subcategory?->name ?? $category->name }}
                                            </span>

                                        </div>

                                    </div>

                                </a>


                                {{-- Card Content --}}
                                <div class="p-4 sm:p-5">

                                    {{-- Title + Favorite --}}
                                    <div class="flex items-start gap-3">

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

                                                @if ($isFavorited)

                                                    <form
                                                        method="POST"
                                                        action="{{ route('client.favorites.destroy', $service) }}"
                                                        class="shrink-0"
                                                    >

                                                        @csrf

                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="flex h-8 w-8 items-center justify-center rounded-full border border-red-100 bg-white text-red-500 transition hover:border-red-200 hover:bg-red-50"
                                                            title="Hapus dari favorit"
                                                        >

                                                            <i class="bi bi-heart-fill text-[13px]"></i>

                                                        </button>

                                                    </form>

                                                @else

                                                    <form
                                                        method="POST"
                                                        action="{{ route('client.favorites.store', $service) }}"
                                                        class="shrink-0"
                                                    >

                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="flex h-8 w-8 items-center justify-center rounded-full border border-[#DCE8E1] bg-white text-[#879891] transition hover:border-[#B8DAC5] hover:text-[#0F6B3A]"
                                                            title="Tambah favorit"
                                                        >

                                                            <i class="bi bi-heart text-[13px]"></i>

                                                        </button>

                                                    </form>

                                                @endif

                                            @endif

                                        @endauth

                                    </div>


                                    {{-- Freelancer --}}
                                    <div class="mt-4 flex items-center gap-3">

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

                                                <div class="truncate text-[11px] text-[#8B9B95]">
                                                    {{ '@' . $freelancer->username }}
                                                </div>

                                            @endif

                                        </div>

                                    </div>


                                    {{-- Stats --}}
                                    <div
                                        class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-[#7C8D86] sm:text-xs"
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

                                            <div class="text-[10px] text-[#8E9D97]">
                                                Mulai dari
                                            </div>

                                            <div class="mt-1 text-[15px] font-semibold text-[#123128] sm:text-base">
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

                            {{-- Empty State --}}
                            <div
                                class="col-span-full rounded-2xl border border-dashed border-[#CFE1D6] bg-white px-6 py-16 text-center"
                            >

                                <div
                                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-xl text-[#0F6B3A]"
                                >
                                    <i class="bi bi-search"></i>
                                </div>


                                <h3
                                    class="mt-4 text-base font-semibold text-[#123128]"
                                >
                                    Layanan tidak ditemukan
                                </h3>


                                <p
                                    class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#81918B]"
                                >
                                    Tidak ada layanan yang sesuai dengan filter
                                    yang kamu pilih di kategori ini.
                                </p>


                                <a
                                    href="{{ route('marketplace.category', $category->slug) }}"
                                    class="mt-5 inline-flex items-center gap-2 rounded-xl border border-[#D7E5DD] bg-white px-4 py-2.5 text-xs font-semibold text-[#0F6B3A] transition hover:bg-[#F5FAF7]"
                                >

                                    <i class="bi bi-arrow-counterclockwise"></i>

                                    Reset filter

                                </a>

                            </div>

                        @endforelse

                    </div>


                    {{-- Pagination --}}
                    @if ($services->hasPages())

                        <div class="mt-8">

                            {{ $services->onEachSide(1)->links() }}

                        </div>

                    @endif


                    {{-- =================================================
                        OTHER CATEGORIES
                    ================================================== --}}
                    @if ($otherCategories->isNotEmpty())

                        <div class="mt-14 border-t border-[#DFEBE4] pt-8">

                            <div>

                                <p class="text-[10px] font-medium uppercase tracking-[0.15em] text-[#91A099]">
                                    Eksplorasi lainnya
                                </p>

                                <h2
                                    class="mt-2 text-lg font-semibold text-[#123128]"
                                >
                                    Kategori lainnya
                                </h2>

                            </div>


                            <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-4">

                                @foreach ($otherCategories as $otherCategory)

                                    <a
                                        href="{{ route('marketplace.category', $otherCategory->slug) }}"
                                        class="group rounded-2xl border border-[#DCEDE3] bg-white p-4 transition duration-300 hover:-translate-y-0.5 hover:border-[#B9DDC8] hover:shadow-[0_14px_30px_rgba(15,107,58,0.05)]"
                                    >

                                        <h3
                                            class="line-clamp-2 text-sm font-semibold text-[#123128] transition group-hover:text-[#0F6B3A]"
                                        >
                                            {{ $otherCategory->name }}
                                        </h3>

                                        <div class="mt-2 text-[10px] text-[#91A099]">
                                            {{ number_format($otherCategory->services_count, 0, ',', '.') }}
                                            layanan
                                        </div>

                                    </a>

                                @endforeach

                            </div>

                        </div>

                    @endif

                </main>

            </div>

        </div>

    </section>

</div>


</x-layouts.marketplace>
