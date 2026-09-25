<x-layouts.marketplace :title="$category->name . ' - ProKerja'">

    <div
        x-data="{
            searching: false
        }"
        class="min-h-screen bg-[#F8FAFC] "
    >

        {{-- =========================================================
            CATEGORY HEADER
        ========================================================== --}}
        <section class="border-b border-[#E2E8F0] bg-white">

            <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 sm:py-6 lg:px-8">

                {{-- Breadcrumb --}}
                <nav
                    class="flex flex-wrap items-center gap-2 text-[10px] text-[#94A3B8] sm:text-xs"
                    aria-label="Breadcrumb"
                >

                    <a
                        href="{{ route('marketplace.home') }}"
                        class="
                            transition-colors duration-200
                            hover:text-[#2563EB]
                        "
                    >
                        Beranda
                    </a>

                    <i class="bi bi-chevron-right text-[8px] text-[#CBD5E1]"></i>

                    <span class="font-medium text-[#64748B]">
                        Kategori
                    </span>

                    <i class="bi bi-chevron-right text-[8px] text-[#CBD5E1]"></i>

                    <span class="font-semibold text-[#0F172A]">
                        {{ $category->name }}
                    </span>

                </nav>


                {{-- Heading --}}
                <div class="mt-5 max-w-3xl">

                    <span
                        class="
                            inline-flex items-center gap-2
                            text-[10px] font-bold uppercase
                            tracking-[0.15em]
                            text-[#2563EB]
                        "
                    >
                        <span
                            class="h-1.5 w-1.5 rounded-full bg-[#2563EB]"
                        ></span>

                        Kategori jasa
                    </span>


                    <h1
                        class="
                            mt-2
                            text-2xl font-bold
                            tracking-[-0.035em]
                            text-[#0F172A]
                            sm:text-3xl
                            lg:text-4xl
                        "
                    >
                        {{ $category->name }}
                    </h1>


                    <p
                        class="
                            mt-2.5 max-w-2xl
                            text-[11px] leading-5
                            text-[#64748B]
                            sm:text-sm sm:leading-6
                        "
                    >
                        Temukan layanan dari freelancer profesional
                        yang sesuai dengan kebutuhanmu di kategori
                        {{ $category->name }}.
                    </p>

                </div>


                {{-- Statistics --}}
                <div
                    class="
                        mt-6 grid max-w-2xl
                        grid-cols-2
                        border-t border-[#E2E8F0]
                        pt-4
                        sm:grid-cols-3
                    "
                >

                    <div
                        class="
                            border-r border-[#E2E8F0]
                            pr-4
                        "
                    >

                        <div
                            class="
                                text-lg font-bold
                                text-[#0F172A]
                                sm:text-xl
                            "
                        >
                            {{ number_format($totalServices, 0, ',', '.') }}
                        </div>

                        <div
                            class="
                                mt-0.5 text-[9px]
                                font-medium text-[#94A3B8]
                                sm:text-[10px]
                            "
                        >
                            Layanan tersedia
                        </div>

                    </div>


                    <div
                        class="
                            px-4
                            sm:border-r sm:border-[#E2E8F0]
                        "
                    >

                        <div
                            class="
                                text-lg font-bold
                                text-[#0F172A]
                                sm:text-xl
                            "
                        >
                            {{ number_format($totalSubcategories, 0, ',', '.') }}
                        </div>

                        <div
                            class="
                                mt-0.5 text-[9px]
                                font-medium text-[#94A3B8]
                                sm:text-[10px]
                            "
                        >
                            Subkategori
                        </div>

                    </div>


                    <div
                        class="
                            col-span-2
                            mt-3 border-t border-[#E2E8F0]
                            pt-3
                            sm:col-span-1
                            sm:mt-0
                            sm:border-t-0
                            sm:pl-4
                            sm:pt-0
                        "
                    >

                        <div
                            class="
                                text-lg font-bold
                                text-[#2563EB]
                                sm:text-xl
                            "
                        >
                            ProKerja
                        </div>

                        <div
                            class="
                                mt-0.5 text-[9px]
                                font-medium text-[#94A3B8]
                                sm:text-[10px]
                            "
                        >
                            Marketplace jasa
                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
            MAIN
        ========================================================== --}}
        <section
            class="
                py-5
                sm:py-6
                lg:py-7
            "
        >

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <div
                    class="
                        grid gap-5
                        lg:grid-cols-[220px_minmax(0,1fr)]
                        lg:gap-6
                    "
                >

                    {{-- =================================================
                        SIDEBAR DESKTOP
                    ================================================== --}}
                    <aside class="hidden lg:block">

                        <form
                            method="GET"
                            action="{{ route('marketplace.category', $category->slug) }}"
                            class="sticky top-24 space-y-4"
                            @submit="searching = true"
                        >

                            {{-- Search --}}
                            <div
                                class="
                                    rounded-2xl
                                    border border-[#E2E8F0]
                                    bg-white p-4
                                    shadow-sm
                                "
                            >

                                <label
                                    for="category-search"
                                    class="
                                        text-[11px]
                                        font-bold text-[#0F172A]
                                    "
                                >
                                    Cari dalam kategori
                                </label>


                                <div
                                    class="
                                        mt-2.5 flex items-center gap-2
                                        rounded-xl
                                        border border-[#E2E8F0]
                                        bg-[#F8FAFC]
                                        px-3
                                        transition-all duration-200
                                        focus-within:border-[#93C5FD]
                                        focus-within:bg-white
                                        focus-within:ring-2
                                        focus-within:ring-[#DBEAFE]
                                    "
                                >

                                    <i
                                        class="
                                            bi bi-search text-[12px]
                                            text-[#94A3B8]
                                        "
                                    ></i>

                                    <input
                                        id="category-search"
                                        type="text"
                                        name="q"
                                        value="{{ $keyword }}"
                                        autocomplete="off"
                                        placeholder="Cari layanan..."
                                        class="
                                            w-full border-0 bg-transparent
                                            py-2.5
                                            text-[10px] font-medium
                                            text-[#0F172A]
                                            outline-none
                                            placeholder:text-[#94A3B8]
                                            focus:ring-0
                                        "
                                    >

                                </div>

                            </div>


                            {{-- Subcategories --}}
                            <div
                                class="
                                    rounded-2xl
                                    border border-[#E2E8F0]
                                    bg-white p-4
                                    shadow-sm
                                "
                            >

                                <div class="flex items-center justify-between">

                                    <h2
                                        class="
                                            text-[11px]
                                            font-bold text-[#0F172A]
                                        "
                                    >
                                        Subkategori
                                    </h2>

                                    @if ($subcategorySlug || $keyword || $minPrice || $maxPrice || $sort !== 'relevance')

                                        <a
                                            href="{{ route('marketplace.category', $category->slug) }}"
                                            class="
                                                text-[9px]
                                                font-semibold text-[#2563EB]
                                                transition hover:text-[#1D4ED8]
                                            "
                                        >
                                            Reset
                                        </a>

                                    @endif

                                </div>


                                <div class="mt-3 space-y-1.5">

                                    <label
                                        class="
                                            flex cursor-pointer
                                            items-center justify-between gap-2
                                            rounded-lg px-1.5 py-1.5
                                            transition-colors duration-200
                                            hover:bg-[#F8FAFC]
                                        "
                                    >

                                        <span
                                            class="
                                                flex min-w-0
                                                items-center gap-2
                                            "
                                        >

                                            <input
                                                type="radio"
                                                name="subcategory"
                                                value=""
                                                onchange="this.form.submit()"
                                                @checked($subcategorySlug === '')
                                                class="
                                                    h-3.5 w-3.5
                                                    accent-[#2563EB]
                                                "
                                            >

                                            <span
                                                class="
                                                    truncate text-[10px]
                                                    font-medium text-[#64748B]
                                                "
                                            >
                                                Semua subkategori
                                            </span>

                                        </span>


                                        <span
                                            class="
                                                shrink-0
                                                text-[9px] text-[#94A3B8]
                                            "
                                        >
                                            {{ $totalServices }}
                                        </span>

                                    </label>


                                    @foreach ($subcategories as $subcategory)

                                        <label
                                            class="
                                                flex cursor-pointer
                                                items-center justify-between gap-2
                                                rounded-lg px-1.5 py-1.5
                                                transition-colors duration-200
                                                hover:bg-[#F8FAFC]
                                            "
                                        >

                                            <span
                                                class="
                                                    flex min-w-0
                                                    items-center gap-2
                                                "
                                            >

                                                <input
                                                    type="radio"
                                                    name="subcategory"
                                                    value="{{ $subcategory->slug }}"
                                                    onchange="this.form.submit()"
                                                    @checked($subcategorySlug === $subcategory->slug)
                                                    class="
                                                        h-3.5 w-3.5
                                                        accent-[#2563EB]
                                                    "
                                                >

                                                <span
                                                    class="
                                                        truncate text-[10px]
                                                        font-medium text-[#64748B]
                                                    "
                                                >
                                                    {{ $subcategory->name }}
                                                </span>

                                            </span>


                                            <span
                                                class="
                                                    shrink-0
                                                    text-[9px] text-[#94A3B8]
                                                "
                                            >
                                                {{ $subcategoryServiceCounts[$subcategory->id] ?? 0 }}
                                            </span>

                                        </label>

                                    @endforeach

                                </div>

                            </div>


                            {{-- Price --}}
                            <div
                                class="
                                    rounded-2xl
                                    border border-[#E2E8F0]
                                    bg-white p-4
                                    shadow-sm
                                "
                            >

                                <h2
                                    class="
                                        text-[11px]
                                        font-bold text-[#0F172A]
                                    "
                                >
                                    Rentang harga
                                </h2>


                                <div class="mt-3 grid grid-cols-2 gap-2">

                                    <div>

                                        <label
                                            for="min-price"
                                            class="
                                                mb-1 block
                                                text-[9px] font-medium
                                                text-[#94A3B8]
                                            "
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
                                            class="
                                                w-full rounded-xl
                                                border border-[#E2E8F0]
                                                bg-[#F8FAFC]
                                                px-2.5 py-2.5
                                                text-[10px] font-medium
                                                text-[#0F172A]
                                                outline-none
                                                placeholder:text-[#94A3B8]
                                                transition-all duration-200
                                                focus:border-[#93C5FD]
                                                focus:bg-white
                                                focus:ring-2
                                                focus:ring-[#DBEAFE]
                                            "
                                        >

                                    </div>


                                    <div>

                                        <label
                                            for="max-price"
                                            class="
                                                mb-1 block
                                                text-[9px] font-medium
                                                text-[#94A3B8]
                                            "
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
                                            class="
                                                w-full rounded-xl
                                                border border-[#E2E8F0]
                                                bg-[#F8FAFC]
                                                px-2.5 py-2.5
                                                text-[10px] font-medium
                                                text-[#0F172A]
                                                outline-none
                                                placeholder:text-[#94A3B8]
                                                transition-all duration-200
                                                focus:border-[#93C5FD]
                                                focus:bg-white
                                                focus:ring-2
                                                focus:ring-[#DBEAFE]
                                            "
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- Sorting --}}
                            <div
                                class="
                                    rounded-2xl
                                    border border-[#E2E8F0]
                                    bg-white p-4
                                    shadow-sm
                                "
                            >

                                <h2
                                    class="
                                        text-[11px]
                                        font-bold text-[#0F172A]
                                    "
                                >
                                    Urutkan
                                </h2>


                                <select
                                    name="sort"
                                    onchange="this.form.submit()"
                                    class="
                                        mt-2.5 w-full rounded-xl
                                        border border-[#E2E8F0]
                                        bg-[#F8FAFC]
                                        px-3 py-2.5
                                        text-[10px] font-medium
                                        text-[#64748B]
                                        outline-none
                                        transition-all duration-200
                                        focus:border-[#93C5FD]
                                        focus:bg-white
                                        focus:ring-2 focus:ring-[#DBEAFE]
                                    "
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
                                class="
                                    inline-flex h-10 w-full
                                    items-center justify-center gap-2
                                    rounded-xl
                                    bg-[#2563EB]
                                    text-[10px] font-bold text-white
                                    shadow-[0_5px_14px_rgba(37,99,235,0.14)]
                                    transition-all duration-200
                                    hover:-translate-y-0.5
                                    hover:bg-[#1D4ED8]
                                "
                            >
                                <i class="bi bi-funnel text-[10px]"></i>
                                Terapkan filter
                            </button>

                        </form>

                    </aside>


                    {{-- =================================================
                        CONTENT
                    ================================================== --}}
                    <main
                        class="min-w-0"
                        x-data="{ loaded: false }"
                        x-init="requestAnimationFrame(() => loaded = true)"
                        :class="loaded
                            ? 'opacity-100 translate-y-0'
                            : 'opacity-0 translate-y-1'"
                        class="transition-all duration-500 ease-out"
                    >

                        {{-- MOBILE SEARCH --}}
                        <div
                            class="
                                mb-4 rounded-2xl
                                border border-[#E2E8F0]
                                bg-white p-3.5
                                shadow-sm
                                lg:hidden
                            "
                        >

                            <form
                                method="GET"
                                action="{{ route('marketplace.category', $category->slug) }}"
                                @submit="searching = true"
                            >

                                <div
                                    class="
                                        flex items-center gap-2
                                        rounded-xl
                                        border border-[#E2E8F0]
                                        bg-[#F8FAFC]
                                        px-3
                                        transition-all duration-200
                                        focus-within:border-[#93C5FD]
                                        focus-within:bg-white
                                        focus-within:ring-2
                                        focus-within:ring-[#DBEAFE]
                                    "
                                >

                                    <i
                                        class="
                                            bi bi-search text-[12px]
                                            text-[#94A3B8]
                                        "
                                    ></i>

                                    <input
                                        type="text"
                                        name="q"
                                        value="{{ $keyword }}"
                                        autocomplete="off"
                                        placeholder="Cari layanan di {{ $category->name }}..."
                                        class="
                                            w-full border-0
                                            bg-transparent
                                            py-2.5
                                            text-[10px] font-medium
                                            text-[#0F172A]
                                            outline-none
                                            placeholder:text-[#94A3B8]
                                            focus:ring-0
                                        "
                                    >

                                </div>


                                <div
                                    class="
                                        mt-2.5 grid
                                        grid-cols-2 gap-2
                                    "
                                >

                                    <select
                                        name="subcategory"
                                        class="
                                            w-full rounded-xl
                                            border border-[#E2E8F0]
                                            bg-white
                                            px-2.5 py-2.5
                                            text-[9px] font-medium
                                            text-[#64748B]
                                            outline-none
                                            transition-all duration-200
                                            focus:border-[#93C5FD]
                                            focus:ring-2
                                            focus:ring-[#DBEAFE]
                                        "
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
                                        class="
                                            w-full rounded-xl
                                            border border-[#E2E8F0]
                                            bg-white
                                            px-2.5 py-2.5
                                            text-[9px] font-medium
                                            text-[#64748B]
                                            outline-none
                                            transition-all duration-200
                                            focus:border-[#93C5FD]
                                            focus:ring-2
                                            focus:ring-[#DBEAFE]
                                        "
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


                                <div
                                    class="
                                        mt-2 grid
                                        grid-cols-2 gap-2
                                    "
                                >

                                    <input
                                        type="number"
                                        min="0"
                                        name="min_price"
                                        value="{{ $minPrice !== null ? $minPrice : '' }}"
                                        placeholder="Harga minimum"
                                        class="
                                            w-full rounded-xl
                                            border border-[#E2E8F0]
                                            bg-white
                                            px-2.5 py-2.5
                                            text-[9px] font-medium
                                            text-[#0F172A]
                                            outline-none
                                            placeholder:text-[#94A3B8]
                                            transition-all duration-200
                                            focus:border-[#93C5FD]
                                            focus:ring-2
                                            focus:ring-[#DBEAFE]
                                        "
                                    >

                                    <input
                                        type="number"
                                        min="0"
                                        name="max_price"
                                        value="{{ $maxPrice !== null ? $maxPrice : '' }}"
                                        placeholder="Harga maksimum"
                                        class="
                                            w-full rounded-xl
                                            border border-[#E2E8F0]
                                            bg-white
                                            px-2.5 py-2.5
                                            text-[9px] font-medium
                                            text-[#0F172A]
                                            outline-none
                                            placeholder:text-[#94A3B8]
                                            transition-all duration-200
                                            focus:border-[#93C5FD]
                                            focus:ring-2
                                            focus:ring-[#DBEAFE]
                                        "
                                    >

                                </div>


                                <button
                                    type="submit"
                                    class="
                                        mt-2.5 inline-flex h-10 w-full
                                        items-center justify-center gap-2
                                        rounded-xl
                                        bg-[#2563EB]
                                        text-[10px] font-bold text-white
                                        shadow-[0_5px_14px_rgba(37,99,235,0.12)]
                                        transition-all duration-200
                                        hover:bg-[#1D4ED8]
                                    "
                                >

                                    <template x-if="!searching">
                                        <span class="inline-flex items-center gap-2">
                                            <i class="bi bi-funnel text-[10px]"></i>
                                            Terapkan filter
                                        </span>
                                    </template>

                                    <template x-if="searching">
                                        <span class="inline-flex items-center gap-2">
                                            <i class="bi bi-arrow-repeat animate-spin text-[10px]"></i>
                                            Memuat
                                        </span>
                                    </template>

                                </button>

                            </form>

                        </div>


                        {{-- RESULT HEADER --}}
                        <div
                            class="
                                flex flex-col gap-2
                                sm:flex-row
                                sm:items-end
                                sm:justify-between
                            "
                        >

                            <div class="min-w-0">

                                <p
                                    class="
                                        text-[9px] font-bold
                                        uppercase tracking-[0.14em]
                                        text-[#64748B]
                                    "
                                >
                                    {{ $category->name }}
                                </p>

                                <h2
                                    class="
                                        mt-1 text-lg font-bold
                                        tracking-[-0.025em]
                                        text-[#0F172A]
                                        sm:text-xl
                                    "
                                >
                                    {{ number_format($services->total(), 0, ',', '.') }}
                                    layanan
                                </h2>

                            </div>


                            <div
                                class="
                                    text-[9px] text-[#94A3B8]
                                    sm:text-right
                                "
                            >

                                @if ($keyword)

                                    Hasil pencarian untuk

                                    <span class="font-semibold text-[#475569]">
                                        "{{ $keyword }}"
                                    </span>

                                @elseif ($selectedSubcategory)

                                    Menampilkan subkategori

                                    <span class="font-semibold text-[#475569]">
                                        {{ $selectedSubcategory->name }}
                                    </span>

                                @else

                                    Semua layanan dalam kategori ini

                                @endif

                            </div>

                        </div>


                        {{-- ACTIVE FILTER --}}
                        @if (
                            $keyword ||
                            $subcategorySlug ||
                            $minPrice !== null ||
                            $maxPrice !== null ||
                            $sort !== 'relevance'
                        )

                            <div
                                class="
                                    mt-3 flex flex-wrap
                                    items-center gap-1.5
                                "
                            >

                                <span
                                    class="
                                        mr-1 text-[8px]
                                        font-semibold text-[#94A3B8]
                                    "
                                >
                                    Filter:
                                </span>


                                @if ($keyword)

                                    <span
                                        class="
                                            inline-flex items-center gap-1
                                            rounded-full
                                            bg-[#EFF6FF]
                                            px-2.5 py-1
                                            text-[8px] font-semibold
                                            text-[#2563EB]
                                        "
                                    >
                                        <i class="bi bi-search text-[8px]"></i>
                                        {{ $keyword }}
                                    </span>

                                @endif


                                @if ($selectedSubcategory)

                                    <span
                                        class="
                                            inline-flex items-center gap-1
                                            rounded-full
                                            bg-[#EFF6FF]
                                            px-2.5 py-1
                                            text-[8px] font-semibold
                                            text-[#2563EB]
                                        "
                                    >
                                        <i class="bi bi-grid text-[8px]"></i>
                                        {{ $selectedSubcategory->name }}
                                    </span>

                                @endif


                                @if ($minPrice !== null)

                                    <span
                                        class="
                                            inline-flex
                                            rounded-full
                                            bg-[#EFF6FF]
                                            px-2.5 py-1
                                            text-[8px] font-semibold
                                            text-[#2563EB]
                                        "
                                    >
                                        Min Rp {{ number_format($minPrice, 0, ',', '.') }}
                                    </span>

                                @endif


                                @if ($maxPrice !== null)

                                    <span
                                        class="
                                            inline-flex
                                            rounded-full
                                            bg-[#EFF6FF]
                                            px-2.5 py-1
                                            text-[8px] font-semibold
                                            text-[#2563EB]
                                        "
                                    >
                                        Max Rp {{ number_format($maxPrice, 0, ',', '.') }}
                                    </span>

                                @endif


                                @if ($sort !== 'relevance')

                                    <span
                                        class="
                                            inline-flex
                                            rounded-full
                                            bg-[#EFF6FF]
                                            px-2.5 py-1
                                            text-[8px] font-semibold
                                            text-[#2563EB]
                                        "
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
                                    class="
                                        text-[8px]
                                        font-semibold
                                        text-[#64748B]
                                        underline
                                        underline-offset-2
                                        transition-colors duration-200
                                        hover:text-[#2563EB]
                                    "
                                >
                                    Hapus semua
                                </a>

                            </div>

                        @endif


                        {{-- =================================================
                            SERVICES
                        ================================================== --}}
                        <div
                            class="
                                mt-4 grid
                                grid-cols-2
                                gap-3
                                sm:grid-cols-3 sm:gap-4
                                xl:grid-cols-4
                            "
                        >

                            @forelse ($services as $service)

                                @php

                                    $freelancer = $service->freelancerProfile;
                                    $freelancerUser = $freelancer?->user;

                                    $avatar = $freelancer?->avatar
                                        ? asset('storage/' . $freelancer->avatar)
                                        : null;

                                    $isFavorited = (bool) ($service->is_favorited ?? false);

                                    $freelancerName = $freelancerUser?->name ?? 'Freelancer';

                                    $freelancerInitial = strtoupper(
                                        substr($freelancerName, 0, 1)
                                    );

                                    $rating = (float) ($service->rating ?? 0);

                                    $reviewsCount = (int) ($service->reviews_count ?? 0);

                                    $ordersCount = (int) ($service->orders_count ?? 0);

                                    $startingPrice = (float) ($service->starting_price ?? 0);

                                    $thumbnail = $service->thumbnail
                                        ? asset('storage/' . $service->thumbnail)
                                        : null;

                                @endphp


                                {{-- SERVICE CARD --}}
                                <article
                                    class="
                                        group flex h-full min-w-0 flex-col
                                        overflow-hidden
                                        rounded-2xl
                                        border border-[#E2E8F0]
                                        bg-white
                                        shadow-[0_2px_10px_rgba(15,23,42,0.03)]
                                        transition-all duration-300 ease-out
                                        hover:-translate-y-1
                                        hover:border-[#BFDBFE]
                                        hover:shadow-[0_12px_28px_rgba(37,99,235,0.09)]
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
                                                        h-full w-full
                                                        object-cover
                                                        transition-transform
                                                        duration-500
                                                        ease-out
                                                        group-hover:scale-[1.04]
                                                    "
                                                >

                                            @else

                                                <div
                                                    class="
                                                        flex h-full w-full
                                                        items-center justify-center
                                                        bg-gradient-to-br
                                                        from-[#EFF6FF]
                                                        to-[#DBEAFE]
                                                    "
                                                >

                                                    <div
                                                        class="
                                                            flex h-10 w-10
                                                            items-center justify-center
                                                            rounded-xl
                                                            bg-white
                                                            text-[#2563EB]
                                                            shadow-sm
                                                        "
                                                    >
                                                        <i class="bi bi-briefcase text-sm"></i>
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
                                                        text-[7px] font-bold
                                                        text-white
                                                        shadow-sm
                                                        sm:text-[8px]
                                                    "
                                                >
                                                    Pilihan
                                                </span>

                                            @endif


                                            {{-- Subcategory --}}
                                            <div
                                                class="
                                                    absolute bottom-2.5
                                                    left-2.5
                                                    max-w-[70%]
                                                "
                                            >

                                                <span
                                                    class="
                                                        block truncate
                                                        rounded-full
                                                        bg-white/95
                                                        px-2 py-1
                                                        text-[7px] font-semibold
                                                        text-[#475569]
                                                        shadow-sm
                                                        backdrop-blur
                                                        sm:text-[8px]
                                                    "
                                                >
                                                    {{ $service->subcategory?->name ?? $category->name }}
                                                </span>

                                            </div>

                                        </div>

                                    </a>


                                    {{-- CARD CONTENT --}}
                                    <div
                                        class="
                                            flex flex-1 flex-col
                                            p-3
                                            sm:p-3.5
                                        "
                                    >

                                        {{-- TITLE + FAVORITE --}}
                                        <div
                                            class="
                                                flex items-start gap-2
                                            "
                                        >

                                            <a
                                                href="{{ route('marketplace.service', $service->slug) }}"
                                                class="min-w-0 flex-1"
                                            >

                                                <h3
                                                    class="
                                                        line-clamp-2
                                                        min-h-[34px]
                                                        text-[10px]
                                                        font-bold
                                                        leading-4
                                                        text-[#0F172A]
                                                        transition-colors
                                                        duration-200
                                                        group-hover:text-[#2563EB]
                                                        sm:min-h-[40px]
                                                        sm:text-[11px]
                                                        sm:leading-5
                                                    "
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
                                                                class="
                                                                    flex h-7 w-7
                                                                    items-center
                                                                    justify-center
                                                                    rounded-full
                                                                    border
                                                                    border-red-100
                                                                    bg-white
                                                                    text-red-500
                                                                    transition-all
                                                                    duration-200
                                                                    hover:scale-105
                                                                    hover:bg-red-50
                                                                "
                                                                title="Hapus dari favorit"
                                                            >
                                                                <i class="bi bi-heart-fill text-[10px]"></i>
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
                                                                class="
                                                                    flex h-7 w-7
                                                                    items-center
                                                                    justify-center
                                                                    rounded-full
                                                                    border border-[#E2E8F0]
                                                                    bg-white
                                                                    text-[#94A3B8]
                                                                    transition-all
                                                                    duration-200
                                                                    hover:scale-105
                                                                    hover:border-[#BFDBFE]
                                                                    hover:text-[#2563EB]
                                                                "
                                                                title="Tambah favorit"
                                                            >
                                                                <i class="bi bi-heart text-[10px]"></i>
                                                            </button>

                                                        </form>

                                                    @endif

                                                @endif

                                            @endauth

                                        </div>


                                        {{-- FREELANCER --}}
                                        <a
                                            href="{{
                                                $freelancer?->username
                                                    ? route(
                                                        'marketplace.freelancer',
                                                        $freelancer->username
                                                    )
                                                    : route(
                                                        'marketplace.service',
                                                        $service->slug
                                                    )
                                            }}"
                                            class="
                                                mt-2.5 flex min-w-0
                                                items-center gap-2
                                                transition-opacity
                                                duration-200
                                                hover:opacity-80
                                            "
                                        >

                                            <div
                                                class="
                                                    flex h-7 w-7 shrink-0
                                                    items-center justify-center
                                                    overflow-hidden rounded-full
                                                    bg-[#EFF6FF]
                                                    text-[8px] font-bold
                                                    text-[#2563EB]
                                                "
                                            >

                                                @if ($avatar)

                                                    <img
                                                        src="{{ $avatar }}"
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

                                                    <span
                                                        class="
                                                            truncate text-[8px]
                                                            font-semibold
                                                            text-[#334155]
                                                            sm:text-[9px]
                                                        "
                                                    >
                                                        {{ $freelancerName }}
                                                    </span>

                                                    @if ($freelancer?->is_verified)

                                                        <span
                                                            class="
                                                                inline-flex h-3.5 w-3.5
                                                                shrink-0
                                                                items-center justify-center
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


                                                @if ($freelancer?->username)

                                                    <p
                                                        class="
                                                            truncate text-[7px]
                                                            text-[#94A3B8]
                                                            sm:text-[8px]
                                                        "
                                                    >
                                                        @{{ $freelancer->username }}
                                                    </p>

                                                @endif

                                            </div>

                                        </a>


                                        {{-- STATS --}}
                                        <div
                                            class="
                                                mt-2.5 flex min-w-0
                                                items-center gap-1
                                                overflow-hidden
                                                text-[7px] text-[#94A3B8]
                                                sm:text-[8px]
                                            "
                                        >

                                            <span
                                                class="
                                                    shrink-0
                                                    font-semibold
                                                    text-[#334155]
                                                "
                                            >
                                                <i class="bi bi-star-fill text-[#F59E0B]"></i>
                                                {{ number_format($rating, 1) }}
                                            </span>


                                            <span class="text-[#CBD5E1]">
                                                •
                                            </span>


                                            <span class="truncate">
                                                {{ number_format($reviewsCount) }} ulasan
                                            </span>


                                            @if ($ordersCount > 0)

                                                <span class="text-[#CBD5E1]">
                                                    •
                                                </span>

                                                <span class="truncate">
                                                    {{ number_format($ordersCount) }} order
                                                </span>

                                            @endif

                                        </div>


                                        {{-- PRICE --}}
                                        <div
                                            class="
                                                mt-auto
                                                pt-3
                                            "
                                        >

                                            <div
                                                class="
                                                    border-t border-[#F1F5F9]
                                                    pt-2.5
                                                    sm:pt-3
                                                "
                                            >

                                                <p
                                                    class="
                                                        text-[7px]
                                                        font-medium
                                                        uppercase
                                                        tracking-[0.08em]
                                                        text-[#94A3B8]
                                                        sm:text-[8px]
                                                    "
                                                >
                                                    Mulai dari
                                                </p>


                                                <div
                                                    class="
                                                        mt-0.5
                                                        flex items-center
                                                        justify-between
                                                        gap-2
                                                    "
                                                >

                                                    <p
                                                        class="
                                                            truncate
                                                            text-[10px]
                                                            font-bold
                                                            text-[#0F172A]
                                                            sm:text-xs
                                                        "
                                                    >
                                                        Rp{{ number_format($startingPrice, 0, ',', '.') }}
                                                    </p>


                                                    <a
                                                        href="{{ route('marketplace.service', $service->slug) }}"
                                                        class="
                                                            inline-flex
                                                            h-6 w-6 shrink-0
                                                            items-center
                                                            justify-center
                                                            rounded-full
                                                            bg-[#EFF6FF]
                                                            text-[#2563EB]
                                                            transition-all
                                                            duration-200
                                                            group-hover:bg-[#2563EB]
                                                            group-hover:text-white
                                                            sm:h-7 sm:w-7
                                                        "
                                                        aria-label="Lihat detail jasa"
                                                    >
                                                        <i class="bi bi-arrow-up-right text-[8px]"></i>
                                                    </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </article>

                            @empty

                                {{-- EMPTY STATE --}}
                                <div
                                    class="
                                        col-span-full
                                        rounded-2xl
                                        border border-dashed
                                        border-[#CBD5E1]
                                        bg-white
                                        px-5 py-14
                                        text-center
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


                                    <h3
                                        class="
                                            mt-4 text-sm
                                            font-bold text-[#0F172A]
                                        "
                                    >
                                        Layanan tidak ditemukan
                                    </h3>


                                    <p
                                        class="
                                            mx-auto mt-2 max-w-md
                                            text-[10px] leading-5
                                            text-[#64748B]
                                        "
                                    >
                                        Tidak ada layanan yang sesuai dengan filter
                                        yang kamu pilih di kategori ini.
                                    </p>


                                    <a
                                        href="{{ route('marketplace.category', $category->slug) }}"
                                        class="
                                            mt-5 inline-flex
                                            items-center gap-2
                                            rounded-xl
                                            bg-[#2563EB]
                                            px-4 py-2.5
                                            text-[10px] font-semibold
                                            text-white
                                            shadow-[0_5px_14px_rgba(37,99,235,0.14)]
                                            transition-all duration-200
                                            hover:-translate-y-0.5
                                            hover:bg-[#1D4ED8]
                                        "
                                    >
                                        <i class="bi bi-arrow-counterclockwise text-[9px]"></i>
                                        Reset filter
                                    </a>

                                </div>

                            @endforelse

                        </div>


                        {{-- PAGINATION --}}
                        @if ($services->hasPages())

                            <div
                                class="
                                    mt-6
                                    border-t border-[#E2E8F0]
                                    pt-5
                                "
                            >
                                {{ $services->onEachSide(1)->links() }}
                            </div>

                        @endif


                        {{-- =================================================
                            OTHER CATEGORIES
                        ================================================== --}}
                        @if ($otherCategories->isNotEmpty())

                            <div
                                class="
                                    mt-10
                                    border-t border-[#E2E8F0]
                                    pt-6
                                "
                            >

                                <div>

                                    <p
                                        class="
                                            text-[8px]
                                            font-bold uppercase
                                            tracking-[0.15em]
                                            text-[#94A3B8]
                                        "
                                    >
                                        Eksplorasi lainnya
                                    </p>


                                    <h2
                                        class="
                                            mt-1.5 text-base
                                            font-bold text-[#0F172A]
                                            sm:text-lg
                                        "
                                    >
                                        Kategori lainnya
                                    </h2>

                                </div>


                                <div
                                    class="
                                        mt-4 grid
                                        grid-cols-2 gap-2.5
                                        sm:grid-cols-3 sm:gap-3
                                        xl:grid-cols-4
                                    "
                                >

                                    @foreach ($otherCategories as $otherCategory)

                                        <a
                                            href="{{ route('marketplace.category', $otherCategory->slug) }}"
                                            class="
                                                group
                                                rounded-2xl
                                                border border-[#E2E8F0]
                                                bg-white p-3.5
                                                shadow-[0_2px_10px_rgba(15,23,42,0.025)]
                                                transition-all duration-300
                                                hover:-translate-y-0.5
                                                hover:border-[#BFDBFE]
                                                hover:shadow-[0_10px_24px_rgba(37,99,235,0.08)]
                                            "
                                        >

                                            <div class="flex items-start justify-between gap-2">

                                                <div
                                                    class="
                                                        flex h-8 w-8
                                                        items-center justify-center
                                                        rounded-xl
                                                        bg-[#EFF6FF]
                                                        text-[10px]
                                                        font-bold
                                                        text-[#2563EB]
                                                        transition-all duration-200
                                                        group-hover:bg-[#2563EB]
                                                        group-hover:text-white
                                                    "
                                                >
                                                    {{ strtoupper(substr($otherCategory->name, 0, 1)) }}
                                                </div>


                                                <i
                                                    class="
                                                        bi bi-arrow-up-right
                                                        text-[9px]
                                                        text-[#94A3B8]
                                                        transition-all
                                                        duration-200
                                                        group-hover:-translate-y-0.5
                                                        group-hover:translate-x-0.5
                                                        group-hover:text-[#2563EB]
                                                    "
                                                ></i>

                                            </div>


                                            <h3
                                                class="
                                                    mt-3 line-clamp-2
                                                    text-[10px]
                                                    font-bold
                                                    leading-4
                                                    text-[#0F172A]
                                                    transition-colors
                                                    duration-200
                                                    group-hover:text-[#2563EB]
                                                    sm:text-[11px]
                                                "
                                            >
                                                {{ $otherCategory->name }}
                                            </h3>


                                            <div
                                                class="
                                                    mt-1.5 text-[8px]
                                                    font-medium text-[#94A3B8]
                                                "
                                            >
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


    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
        }
    </style>

</x-layouts.marketplace>