@php

use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Safe collections
|--------------------------------------------------------------------------
*/

$categories = collect($categories ?? []);
$featuredServices = collect($featuredServices ?? []);
$featuredFreelancers = collect($featuredFreelancers ?? []);
$testimonials = collect($testimonials ?? []);

/*
|--------------------------------------------------------------------------
| CMS Banners
| Existing banner system is preserved.
|--------------------------------------------------------------------------
*/

$cmsHeroBanners = collect();
$cmsMiddleBanners = collect();
$cmsBottomBanners = collect();

if (
    class_exists(\App\Models\Banner::class) &&
    Schema::hasTable('banners')
) {
    try {
        $today = now();

        $baseBannerQuery = \App\Models\Banner::query()
            ->where('is_active', true)
            ->where(function ($query) use ($today) {
                $query
                    ->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $today);
            })
            ->where(function ($query) use ($today) {
                $query
                    ->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $today);
            })
            ->orderBy('sort_order')
            ->orderByDesc('id');

        $cmsHeroBanners = (clone $baseBannerQuery)
            ->where('placement', 'hero')
            ->get();

        $cmsMiddleBanners = (clone $baseBannerQuery)
            ->where('placement', 'middle')
            ->get();

        $cmsBottomBanners = (clone $baseBannerQuery)
            ->where('placement', 'bottom')
            ->get();

    } catch (\Throwable $e) {
        $cmsHeroBanners = collect();
        $cmsMiddleBanners = collect();
        $cmsBottomBanners = collect();
    }
}

/*
|--------------------------------------------------------------------------
| Marketplace shortcuts
|--------------------------------------------------------------------------
*/

$popularSearches = [
    'Logo Design',
    'Website',
    'Video Editing',
    'Social Media',
    'Copywriting',
    'AI Services',
];

$categoryIcons = [
    'design' => 'bi-palette2',
    'kreatif' => 'bi-brush',
    'website' => 'bi-window',
    'web' => 'bi-window',
    'programming' => 'bi-code-slash',
    'teknologi' => 'bi-cpu',
    'video' => 'bi-camera-video',
    'animation' => 'bi-play-circle',
    'marketing' => 'bi-megaphone',
    'social' => 'bi-share',
    'writing' => 'bi-pencil-square',
    'translation' => 'bi-translate',
    'business' => 'bi-briefcase',
    'consulting' => 'bi-lightbulb',
    'ai' => 'bi-stars',
];

$defaultCategoryIcons = [
    'bi-grid',
    'bi-layers',
    'bi-stars',
    'bi-briefcase',
    'bi-palette2',
    'bi-code-slash',
    'bi-megaphone',
    'bi-camera-video',
    'bi-pencil-square',
    'bi-lightbulb',
    'bi-cpu',
    'bi-grid-3x3-gap',
];

$needShortcuts = [
    [
        'title' => 'Bangun Website',
        'description' => 'Landing page, company profile, toko online, dan lainnya.',
        'icon' => 'bi-window',
        'url' => route('marketplace.search', ['q' => 'website']),
    ],
    [
        'title' => 'Desain Kreatif',
        'description' => 'Logo, branding, poster, presentasi, dan visual lainnya.',
        'icon' => 'bi-palette2',
        'url' => route('marketplace.search', ['q' => 'desain']),
    ],
    [
        'title' => 'Video & Konten',
        'description' => 'Editing video, reels, motion, dan kebutuhan konten.',
        'icon' => 'bi-camera-video',
        'url' => route('marketplace.search', ['q' => 'video editing']),
    ],
    [
        'title' => 'Marketing',
        'description' => 'Social media, SEO, iklan, dan strategi digital.',
        'icon' => 'bi-megaphone',
        'url' => route('marketplace.search', ['q' => 'marketing']),
    ],
];

$howItWorks = [
    [
        'number' => '01',
        'icon' => 'bi-search',
        'title' => 'Cari kebutuhanmu',
        'description' => 'Telusuri jasa atau proyek berdasarkan kategori dan kebutuhan.',
    ],
    [
        'number' => '02',
        'icon' => 'bi-chat-dots',
        'title' => 'Diskusikan detail',
        'description' => 'Hubungi freelancer dan sepakati kebutuhan pekerjaan.',
    ],
    [
        'number' => '03',
        'icon' => 'bi-check2-circle',
        'title' => 'Kerja selesai',
        'description' => 'Pantau proses, terima hasil, lalu selesaikan transaksi.',
    ],
];

$benefits = [
    [
        'icon' => 'bi-grid-3x3-gap',
        'title' => 'Banyak pilihan',
        'description' => 'Beragam freelancer dan layanan dari berbagai bidang.',
    ],
    [
        'icon' => 'bi-shield-check',
        'title' => 'Transaksi lebih aman',
        'description' => 'Alur pembayaran dan pekerjaan dibuat terstruktur.',
    ],
    [
        'icon' => 'bi-chat-square-text',
        'title' => 'Komunikasi jelas',
        'description' => 'Diskusikan brief dan progres pekerjaan di dalam platform.',
    ],
];

/*
|--------------------------------------------------------------------------
| Featured category
|--------------------------------------------------------------------------
*/

$featuredCategory = $categories->first(function ($category) {

    $text = strtolower(
        trim(
            (string) data_get($category, 'name', '')
            . ' '
            . (string) data_get($category, 'slug', '')
        )
    );

    return str_contains($text, 'web')
        || str_contains($text, 'program')
        || str_contains($text, 'teknologi');

}) ?? $categories->first();

$featuredCategoryName = data_get(
    $featuredCategory,
    'name',
    'Jasa Profesional'
);

$featuredCategorySlug = data_get(
    $featuredCategory,
    'slug'
);

/*
|--------------------------------------------------------------------------
| Helpers for service/freelancer cards
|--------------------------------------------------------------------------
*/

$getMediaUrl = function ($path) {

    if (!$path) {
        return null;
    }

    $path = ltrim((string) $path, '/');

    if (
        str_starts_with($path, 'http://') ||
        str_starts_with($path, 'https://') ||
        str_starts_with($path, 'data:')
    ) {
        return $path;
    }

    return asset('storage/' . $path);
};

@endphp


<x-layouts.marketplace title="ProKerja - Marketplace Jasa">

<div class="min-h-screen bg-slate-50 text-slate-900">


    {{-- =========================================================
        SEARCH-FIRST INTRO
    ========================================================== --}}

    <section class="border-b border-slate-200 bg-white">

        <div class="mx-auto max-w-[1280px] px-4 pb-8 pt-7 sm:px-6 sm:pb-10 sm:pt-10 lg:px-8 lg:pb-12 lg:pt-12">

            <div class="mx-auto max-w-4xl text-center">

                <h4 class="pk-home-reveal text-xs font-medium uppercase tracking-[0.16em] text-blue-600 sm:text-sm">
                    Temukan Freelancer
                </h4>

                <h4 class="pk-home-reveal mt-3 min-h-[76px] text-[32px] font-medium leading-[1.12] tracking-[-0.035em] text-slate-900 sm:min-h-[96px] sm:text-5xl lg:min-h-[108px] lg:text-[56px]">
                    Temukan solusi untuk...
                    <span class="mt-1 block font-medium text-blue-600">
                        <span id="pk-typing-text" class="inline-block"></span><span
                            id="pk-typing-cursor"
                            class="ml-0.5 inline-block h-[0.82em] w-[2px] translate-y-[2px] bg-blue-600 align-middle"
                        ></span>
                    </span>
                </h2>

                <p class="pk-home-reveal mx-auto mt-3 max-w-2xl text-sm leading-6 text-slate-500 sm:text-[15px] sm:leading-7">
                    Temukan talenta terbaik untuk membantu mewujudkan ide dan pekerjaanmu.
                </p>

                <form
                    action="{{ route('marketplace.search') }}"
                    method="GET"
                    class="pk-home-reveal mx-auto mt-6 max-w-3xl"
                >

                    <div class="flex flex-col gap-2 rounded-2xl border border-slate-200 bg-white p-2 shadow-[0_10px_35px_rgba(15,23,42,0.07)] sm:flex-row sm:rounded-[18px]">

                        <div class="relative min-w-0 flex-1">

                            <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[17px] text-slate-400"></i>

                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                autocomplete="off"
                                placeholder="Cari jasa, keahlian, atau freelancer..."
                                class="h-12 w-full rounded-xl border-0 bg-slate-50 pl-11 pr-4 text-sm font-medium text-slate-800 outline-none ring-0 placeholder:text-slate-400 focus:bg-blue-50/60 focus:outline-none sm:h-[52px]"
                            >

                        </div>

                        <button
                            type="submit"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 text-sm font-semibold text-white transition duration-200 hover:bg-blue-700 active:scale-[0.99] sm:h-[52px] sm:min-w-[112px]"
                        >
                            Cari
                            <i class="bi bi-arrow-right text-xs"></i>
                        </button>

                    </div>

                </form>

                <div class="pk-home-reveal mt-5">

                    <div class="flex flex-col items-center gap-2 sm:flex-row sm:justify-center">

                        <span class="shrink-0 text-xs font-semibold text-slate-400">
                            Populer:
                        </span>

                        <div class="no-scrollbar flex w-full max-w-full gap-2 overflow-x-auto pb-1 sm:w-auto sm:flex-wrap sm:justify-center sm:overflow-visible">

                            @foreach ($popularSearches as $popular)

                                <a
                                    href="{{ route('marketplace.search', ['q' => $popular]) }}"
                                    class="shrink-0 rounded-full border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                >
                                    {{ $popular }}
                                </a>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
        CATEGORY
    ========================================================== --}}

    <section
        id="kategori"
        class="scroll-mt-24 bg-slate-50 py-8 sm:py-10 lg:py-12"
    >

        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

            <div class="flex items-end justify-between gap-4">

                <div class="pk-home-reveal min-w-0">

                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                        Jelajahi kategori
                    </p>

                    <h2 class="mt-1.5 text-[22px] font-bold tracking-[-0.025em] text-slate-900 sm:text-2xl">
                        Cari berdasarkan kebutuhan
                    </h2>

                    <p class="mt-1.5 max-w-2xl text-sm leading-6 text-slate-500">
                        Temukan layanan dari berbagai bidang dalam satu marketplace.
                    </p>

                </div>


                <a
                    href="{{ route('marketplace.search') }}"
                    class="hidden shrink-0 items-center gap-1.5 text-xs font-semibold text-blue-600 transition hover:text-blue-700 sm:inline-flex"
                >
                    Lihat semua
                    <i class="bi bi-arrow-right text-[10px]"></i>
                </a>

            </div>


            {{-- Mobile horizontal categories --}}

            <div class="pk-home-reveal mt-5 sm:hidden">

                <div class="no-scrollbar flex snap-x snap-mandatory gap-3 overflow-x-auto pb-2">

                    @forelse ($categories->take(12) as $index => $category)

                        @php

                            $categoryName = data_get(
                                $category,
                                'name',
                                'Kategori'
                            );

                            $categorySlug = data_get(
                                $category,
                                'slug'
                            );

                            $categoryKey = strtolower(
                                (string) $categoryName
                                . ' '
                                . (string) $categorySlug
                            );

                            $icon = 'bi-grid';

                            foreach ($categoryIcons as $keyword => $iconClass) {

                                if (
                                    str_contains(
                                        $categoryKey,
                                        $keyword
                                    )
                                ) {
                                    $icon = $iconClass;
                                    break;
                                }

                            }

                            if ($icon === 'bi-grid') {
                                $icon = $defaultCategoryIcons[
                                    $index % count($defaultCategoryIcons)
                                ];
                            }

                        @endphp


                        @if ($categorySlug)

                            <a
                                href="{{ route('marketplace.category', ['slug' => $categorySlug]) }}"
                                class="group min-w-[132px] snap-start rounded-2xl border border-slate-200 bg-white p-3.5 transition duration-200 active:scale-[0.98]"
                            >

                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi {{ $icon }} text-[16px]"></i>
                                </span>

                                <span class="mt-3 block truncate text-xs font-semibold text-slate-800">
                                    {{ $categoryName }}
                                </span>

                                <span class="mt-1 block text-[10px] text-slate-400">
                                    Jelajahi jasa
                                </span>

                            </a>

                        @endif

                    @empty

                        <div class="w-full rounded-2xl border border-dashed border-slate-200 bg-white p-6 text-center text-sm text-slate-400">
                            Belum ada kategori tersedia.
                        </div>

                    @endforelse

                </div>

            </div>


            {{-- Desktop / tablet category grid --}}

            <div class="pk-home-reveal mt-6 hidden grid-cols-3 gap-4 sm:grid md:grid-cols-4 lg:grid-cols-6">

                @forelse ($categories->take(12) as $index => $category)

                    @php

                        $categoryName = data_get(
                            $category,
                            'name',
                            'Kategori'
                        );

                        $categorySlug = data_get(
                            $category,
                            'slug'
                        );

                        $categoryKey = strtolower(
                            (string) $categoryName
                            . ' '
                            . (string) $categorySlug
                        );

                        $icon = 'bi-grid';

                        foreach ($categoryIcons as $keyword => $iconClass) {

                            if (
                                str_contains(
                                    $categoryKey,
                                    $keyword
                                )
                            ) {
                                $icon = $iconClass;
                                break;
                            }

                        }

                        if ($icon === 'bi-grid') {
                            $icon = $defaultCategoryIcons[
                                $index % count($defaultCategoryIcons)
                            ];
                        }

                    @endphp


                    @if ($categorySlug)

                        <a
                            href="{{ route('marketplace.category', ['slug' => $categorySlug]) }}"
                            class="group rounded-2xl border border-slate-200 bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-[0_10px_25px_rgba(15,23,42,0.06)]"
                        >

                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition group-hover:bg-blue-100">
                                <i class="bi {{ $icon }} text-[17px]"></i>
                            </span>

                            <span class="mt-4 block truncate text-sm font-semibold text-slate-800">
                                {{ $categoryName }}
                            </span>

                            <span class="mt-1 block text-xs text-slate-400">
                                Jelajahi jasa
                            </span>

                        </a>

                    @endif

                @empty

                    <div class="col-span-full rounded-2xl border border-dashed border-slate-200 bg-white p-8 text-center text-sm text-slate-400">
                        Belum ada kategori tersedia.
                    </div>

                @endforelse

            </div>


            <a
                href="{{ route('marketplace.search') }}"
                class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-xs font-semibold text-slate-600 sm:hidden"
            >
                Lihat semua kategori
                <i class="bi bi-arrow-right text-[10px]"></i>
            </a>

        </div>

    </section>



    {{-- =========================================================
    CMS HERO / PROMOTION BANNER
    Smooth cross-fade + natural uploaded image ratio
========================================================== --}}

@if ($cmsHeroBanners->isNotEmpty())

    <section class="bg-slate-50 pb-8 sm:pb-10 lg:pb-12">

        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

            <div
                x-data='{
                    active: 0,
                    paused: false,
                    count: {{ $cmsHeroBanners->count() }},
                    slideHeight: null,
                    timer: null,

                    measureHeight() {
                        const slide = this.$refs.slides?.children[this.active];

                        if (!slide) {
                            return;
                        }

                        const image = slide.querySelector("img");

                        if (image) {

                            const update = () => {

                                const height =
                                    image.getBoundingClientRect().height;

                                if (height > 0) {
                                    this.slideHeight =
                                        Math.round(height) + "px";
                                }

                            };

                            if (
                                image.complete &&
                                image.naturalWidth > 0
                            ) {
                                update();
                            } else {
                                image.addEventListener(
                                    "load",
                                    update,
                                    { once: true }
                                );
                            }

                            return;
                        }

                        const fallback =
                            slide.querySelector("[data-banner-fallback]");

                        if (fallback) {

                            const height =
                                fallback.getBoundingClientRect().height;

                            if (height > 0) {
                                this.slideHeight =
                                    Math.round(height) + "px";
                            }

                        }
                    },

                    goTo(index) {

                        if (
                            index < 0 ||
                            index >= this.count
                        ) {
                            return;
                        }

                        this.active = index;

                        this.$nextTick(() => {
                            this.measureHeight();
                        });
                    },

                    next() {
                        this.goTo(
                            (this.active + 1) % this.count
                        );
                    },

                    previous() {
                        this.goTo(
                            this.active === 0
                                ? this.count - 1
                                : this.active - 1
                        );
                    }
                }'

                x-init='
                    $nextTick(() => {

                        setTimeout(() => {
                            measureHeight();
                        }, 100);

                        window.addEventListener(
                            "resize",
                            () => measureHeight()
                        );

                    });

                    if (count > 1) {

                        timer = setInterval(() => {

                            if (!paused) {
                                next();
                            }

                        }, 6500);

                    }
                '

                @mouseenter="paused = true"
                @mouseleave="paused = false"

                class="pk-home-reveal relative overflow-hidden rounded-[22px] border border-slate-200 bg-white shadow-[0_12px_35px_rgba(15,23,42,0.06)] sm:rounded-3xl"
            >

                {{-- =================================================
                    DYNAMIC HEIGHT WRAPPER
                ================================================== --}}

                <div
                    x-ref="slider"
                    class="relative min-h-[120px] overflow-hidden transition-[height] duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] sm:min-h-[170px]"
                    :style="slideHeight ? { height: slideHeight } : null"
                >

                    {{-- =================================================
                        SLIDES
                    ================================================== --}}

                    <div
                        x-ref="slides"
                        class="absolute inset-0"
                    >

                        @foreach ($cmsHeroBanners as $index => $banner)

                            @php

                                $desktopImage =
                                    method_exists(
                                        $banner,
                                        'getImageUrlAttribute'
                                    )
                                        ? $banner->image_url
                                        : $getMediaUrl(
                                            $banner->image_path ?? null
                                        );

                                $mobileImage =
                                    method_exists(
                                        $banner,
                                        'getMobileImageUrlAttribute'
                                    )
                                        ? (
                                            $banner->mobile_image_url
                                            ?: $desktopImage
                                        )
                                        : $getMediaUrl(
                                            $banner->mobile_image_path ?? null
                                        );

                                $mobileImage =
                                    $mobileImage
                                    ?: $desktopImage;

                                $bannerLink =
                                    $banner->link_url ?? null;

                                $bannerAlt =
                                    $banner->alt_text
                                    ?? (
                                        $banner->name
                                        ?? 'Banner ProKerja'
                                    );

                                $bannerName =
                                    $banner->name
                                    ?? 'ProKerja';

                            @endphp


                            <div
                                class="absolute inset-x-0 top-0 w-full transform-gpu transition-[opacity,transform] duration-700 ease-[cubic-bezier(0.22,1,0.36,1)]"
                                :class="
                                    active === {{ $index }}
                                        ? 'z-10 translate-y-0 scale-100 opacity-100'
                                        : 'z-0 translate-y-0 scale-[1.008] opacity-0 pointer-events-none'
                                "
                                aria-hidden="{{ $index === 0 ? 'false' : 'true' }}"
                            >

                                @if ($bannerLink)

                                    <a
                                        href="{{ $bannerLink }}"
                                        @if ($banner->open_new_tab ?? false)
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        @endif
                                        class="block w-full"
                                    >

                                @endif


                                @if ($desktopImage)

                                    <picture class="block w-full">

                                        @if ($mobileImage)

                                            <source
                                                media="(max-width: 639px)"
                                                srcset="{{ $mobileImage }}"
                                            >

                                        @endif


                                        <img
                                            src="{{ $desktopImage }}"
                                            alt="{{ $bannerAlt }}"
                                            class="block h-auto w-full max-w-none object-contain"
                                            loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                            draggable="false"
                                            @load="
                                                if (active === {{ $index }}) {
                                                    measureHeight();
                                                }
                                            "
                                        >

                                    </picture>


                                @else

                                    <div
                                        data-banner-fallback
                                        class="flex min-h-[120px] w-full items-center bg-blue-50 px-5 py-10 sm:min-h-[170px] sm:px-10 sm:py-12"
                                    >

                                        <div class="max-w-xl">

                                            <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-blue-600">
                                                ProKerja
                                            </p>

                                            <h3 class="mt-2 text-xl font-bold text-slate-900 sm:text-3xl">
                                                {{ $bannerName }}
                                            </h3>

                                        </div>

                                    </div>

                                @endif


                                @if ($bannerLink)

                                    </a>

                                @endif

                            </div>

                        @endforeach

                    </div>


                    {{-- =================================================
                        CONTROLS
                    ================================================== --}}

                    @if ($cmsHeroBanners->count() > 1)

                        <div class="pointer-events-none absolute inset-x-0 bottom-0 z-30 flex items-end justify-between p-3 sm:p-4">

                            {{-- Previous --}}

                            <button
                                type="button"
                                @click="previous()"
                                class="pointer-events-auto flex h-9 w-9 items-center justify-center rounded-xl border border-white/60 bg-white/90 text-slate-700 shadow-sm backdrop-blur transition duration-200 hover:bg-white hover:shadow-md active:scale-95"
                                aria-label="Banner sebelumnya"
                            >
                                <i class="bi bi-chevron-left text-xs"></i>
                            </button>


                            {{-- Dots --}}

                            <div class="pointer-events-auto flex items-center gap-1.5 rounded-full bg-white/90 px-2.5 py-2 shadow-sm backdrop-blur">

                                @foreach ($cmsHeroBanners as $index => $banner)

                                    <button
                                        type="button"
                                        @click="goTo({{ $index }})"
                                        class="h-1.5 rounded-full transition-all duration-500"
                                        :class="
                                            active === {{ $index }}
                                                ? 'w-5 bg-blue-600'
                                                : 'w-1.5 bg-slate-300 hover:bg-slate-400'
                                        "
                                        aria-label="Ke banner {{ $index + 1 }}"
                                    ></button>

                                @endforeach

                            </div>


                            {{-- Next --}}

                            <button
                                type="button"
                                @click="next()"
                                class="pointer-events-auto flex h-9 w-9 items-center justify-center rounded-xl border border-white/60 bg-white/90 text-slate-700 shadow-sm backdrop-blur transition duration-200 hover:bg-white hover:shadow-md active:scale-95"
                                aria-label="Banner berikutnya"
                            >
                                <i class="bi bi-chevron-right text-xs"></i>
                            </button>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </section>

@endif



    {{-- =========================================================
        FEATURED SERVICES
    ========================================================== --}}

    <section
        id="layanan"
        class="bg-white py-9 sm:py-11 lg:py-14"
    >

        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

            <div class="flex items-end justify-between gap-4">

                <div class="pk-home-reveal min-w-0">

                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                        Layanan pilihan
                    </p>

                    <h2 class="mt-1.5 text-[22px] font-bold tracking-[-0.025em] text-slate-900 sm:text-2xl">
                        Jasa yang mungkin kamu butuhkan
                    </h2>

                    <p class="mt-1.5 max-w-2xl text-sm leading-6 text-slate-500">
                        Pilihan layanan untuk membantu menyelesaikan kebutuhan project-mu.
                    </p>

                </div>


                <a
                    href="{{ route('marketplace.search') }}"
                    class="hidden shrink-0 items-center gap-1.5 text-xs font-semibold text-blue-600 transition hover:text-blue-700 sm:inline-flex"
                >
                    Lihat semua
                    <i class="bi bi-arrow-right text-[10px]"></i>
                </a>

            </div>


            {{-- Mobile service cards --}}

            <div class="pk-home-reveal mt-6 sm:hidden">

                <div class="no-scrollbar flex snap-x snap-mandatory gap-3.5 overflow-x-auto pb-3">

                    @forelse ($featuredServices->take(8) as $service)

                        @php

                            $serviceTitle = data_get(
                                $service,
                                'title',
                                data_get(
                                    $service,
                                    'name',
                                    'Layanan Freelancer'
                                )
                            );

                            $serviceSlug = data_get(
                                $service,
                                'slug'
                            );

                            $sellerName = data_get(
                                $service,
                                'freelancerProfile.user.name',
                                data_get(
                                    $service,
                                    'user.name',
                                    'Freelancer'
                                )
                            );

                            $sellerUsername = data_get(
                                $service,
                                'freelancerProfile.user.username',
                                data_get(
                                    $service,
                                    'user.username'
                                )
                            );

                            $sellerAvatar = data_get(
                                $service,
                                'freelancerProfile.avatar',
                                data_get(
                                    $service,
                                    'freelancerProfile.user.avatar'
                                )
                            );

                            $serviceImage = data_get(
                                $service,
                                'thumbnail_url',
                                data_get(
                                    $service,
                                    'image_url',
                                    null
                                )
                            );

                            if (!$serviceImage) {

                                $serviceImage =
                                    $getMediaUrl(
                                        data_get(
                                            $service,
                                            'thumbnail',
                                            data_get(
                                                $service,
                                                'image_path',
                                                data_get(
                                                    $service,
                                                    'cover_image'
                                                )
                                            )
                                        )
                                    );

                            }

                            $price = data_get(
                                $service,
                                'price',
                                data_get(
                                    $service,
                                    'starting_price',
                                    0
                                )
                            );

                            $rating = data_get(
                                $service,
                                'rating',
                                data_get(
                                    $service,
                                    'average_rating'
                                )
                            );

                            $reviewCount = data_get(
                                $service,
                                'reviews_count',
                                data_get(
                                    $service,
                                    'review_count',
                                    0
                                )
                            );

                            $isVerified = (bool) data_get(
                                $service,
                                'freelancerProfile.is_verified',
                                data_get(
                                    $service,
                                    'freelancerProfile.verified',
                                    false
                                )
                            );

                        @endphp


                        @if ($serviceSlug)

                            <a
                                href="{{ route('marketplace.service', ['slug' => $serviceSlug]) }}"
                                class="group w-[238px] shrink-0 snap-start overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-200 active:scale-[0.99]"
                            >

                                <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">

                                    @if ($serviceImage)

                                        <img
                                            src="{{ $serviceImage }}"
                                            alt="{{ $serviceTitle }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                            loading="lazy"
                                        >

                                    @else

                                        <div class="flex h-full w-full items-center justify-center bg-blue-50 text-blue-500">
                                            <i class="bi bi-image text-2xl"></i>
                                        </div>

                                    @endif

                                </div>


                                <div class="p-3.5">

                                    <div class="flex items-center gap-2">

                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-blue-100 text-[11px] font-bold text-blue-700">

                                            @if ($sellerAvatar)

                                                <img
                                                    src="{{ $getMediaUrl($sellerAvatar) }}"
                                                    alt="{{ $sellerName }}"
                                                    class="h-full w-full object-cover"
                                                >

                                            @else

                                                {{ strtoupper(mb_substr($sellerName, 0, 1)) }}

                                            @endif

                                        </span>


                                        <span class="min-w-0 flex-1">

                                            <span class="flex items-center gap-1">

                                                <span class="truncate text-[11px] font-semibold text-slate-700">
                                                    {{ $sellerName }}
                                                </span>

                                                @if ($isVerified)

                                                    <i class="bi bi-patch-check-fill shrink-0 text-[10px] text-blue-500"></i>

                                                @endif

                                            </span>


                                            @if ($sellerUsername)

                                                <span class="mt-0.5 block truncate text-[10px] text-slate-400">
                                                    @{{ ltrim($sellerUsername, '@') }}
                                                </span>

                                            @endif

                                        </span>

                                    </div>


                                    <h3 class="mt-3 line-clamp-2 text-sm font-semibold leading-5 text-slate-900">
                                        {{ $serviceTitle }}
                                    </h3>


                                    <div class="mt-3 flex items-center justify-between gap-2">

                                        <div class="flex items-center gap-1 text-[11px]">

                                            <i class="bi bi-star-fill text-amber-400"></i>

                                            <span class="font-semibold text-slate-700">
                                                {{ $rating ? number_format((float) $rating, 1) : 'Baru' }}
                                            </span>


                                            @if ($reviewCount)

                                                <span class="text-slate-400">
                                                    ({{ $reviewCount }})
                                                </span>

                                            @endif

                                        </div>


                                        <div class="text-right">

                                            <span class="block text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                                                Mulai dari
                                            </span>

                                            <span class="mt-0.5 block text-sm font-bold text-slate-900">
                                                Rp {{ number_format((float) $price, 0, ',', '.') }}
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </a>

                        @endif

                    @empty

                        <div class="w-full rounded-2xl border border-dashed border-slate-200 p-8 text-center text-sm text-slate-400">
                            Belum ada layanan unggulan.
                        </div>

                    @endforelse

                </div>

            </div>


            {{-- Desktop service grid --}}

            <div class="pk-home-reveal mt-6 hidden grid-cols-2 gap-5 sm:grid lg:grid-cols-4">

                @forelse ($featuredServices->take(8) as $service)

                    @php

                        $serviceTitle = data_get(
                            $service,
                            'title',
                            data_get(
                                $service,
                                'name',
                                'Layanan Freelancer'
                            )
                        );

                        $serviceSlug = data_get(
                            $service,
                            'slug'
                        );

                        $sellerName = data_get(
                            $service,
                            'freelancerProfile.user.name',
                            data_get(
                                $service,
                                'user.name',
                                'Freelancer'
                            )
                        );

                        $sellerUsername = data_get(
                            $service,
                            'freelancerProfile.user.username',
                            data_get(
                                $service,
                                'user.username'
                            )
                        );

                        $sellerAvatar = data_get(
                            $service,
                            'freelancerProfile.avatar',
                            data_get(
                                $service,
                                'freelancerProfile.user.avatar'
                            )
                        );

                        $serviceImage = data_get(
                            $service,
                            'thumbnail_url',
                            data_get(
                                $service,
                                'image_url'
                            )
                        );

                        if (!$serviceImage) {

                            $serviceImage =
                                $getMediaUrl(
                                    data_get(
                                        $service,
                                        'thumbnail',
                                        data_get(
                                            $service,
                                            'image_path',
                                            data_get(
                                                $service,
                                                'cover_image'
                                            )
                                        )
                                    )
                                );

                        }

                        $price = data_get(
                            $service,
                            'price',
                            data_get(
                                $service,
                                'starting_price',
                                0
                            )
                        );

                        $rating = data_get(
                            $service,
                            'rating',
                            data_get(
                                $service,
                                'average_rating'
                            )
                        );

                        $reviewCount = data_get(
                            $service,
                            'reviews_count',
                            data_get(
                                $service,
                                'review_count',
                                0
                            )
                        );

                        $isVerified = (bool) data_get(
                            $service,
                            'freelancerProfile.is_verified',
                            data_get(
                                $service,
                                'freelancerProfile.verified',
                                false
                            )
                        );

                    @endphp


                    @if ($serviceSlug)

                        <a
                            href="{{ route('marketplace.service', ['slug' => $serviceSlug]) }}"
                            class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-[0_14px_32px_rgba(15,23,42,0.08)]"
                        >

                            <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">

                                @if ($serviceImage)

                                    <img
                                        src="{{ $serviceImage }}"
                                        alt="{{ $serviceTitle }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                        loading="lazy"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center bg-blue-50 text-blue-500">
                                        <i class="bi bi-image text-2xl"></i>
                                    </div>

                                @endif

                            </div>


                            <div class="p-4">

                                <div class="flex items-center gap-2">

                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-blue-100 text-[11px] font-bold text-blue-700">

                                        @if ($sellerAvatar)

                                            <img
                                                src="{{ $getMediaUrl($sellerAvatar) }}"
                                                alt="{{ $sellerName }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @else

                                            {{ strtoupper(mb_substr($sellerName, 0, 1)) }}

                                        @endif

                                    </span>


                                    <div class="min-w-0">

                                        <div class="flex items-center gap-1">

                                            <span class="truncate text-[11px] font-semibold text-slate-700">
                                                {{ $sellerName }}
                                            </span>

                                            @if ($isVerified)

                                                <i class="bi bi-patch-check-fill shrink-0 text-[10px] text-blue-500"></i>

                                            @endif

                                        </div>


                                        @if ($sellerUsername)

                                            <span class="mt-0.5 block truncate text-[10px] text-slate-400">
                                                @{{ ltrim($sellerUsername, '@') }}
                                            </span>

                                        @endif

                                    </div>

                                </div>


                                <h3 class="mt-3 line-clamp-2 min-h-[40px] text-sm font-semibold leading-5 text-slate-900">
                                    {{ $serviceTitle }}
                                </h3>


                                <div class="mt-4 flex items-end justify-between gap-3">

                                    <div class="flex items-center gap-1 text-[11px]">

                                        <i class="bi bi-star-fill text-amber-400"></i>

                                        <span class="font-semibold text-slate-700">
                                            {{ $rating ? number_format((float) $rating, 1) : 'Baru' }}
                                        </span>


                                        @if ($reviewCount)

                                            <span class="text-slate-400">
                                                ({{ $reviewCount }})
                                            </span>

                                        @endif

                                    </div>


                                    <div class="text-right">

                                        <span class="block text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                                            Mulai dari
                                        </span>

                                        <span class="mt-0.5 block text-sm font-bold text-slate-900">
                                            Rp {{ number_format((float) $price, 0, ',', '.') }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </a>

                    @endif

                @empty

                    <div class="col-span-full rounded-2xl border border-dashed border-slate-200 p-8 text-center text-sm text-slate-400">
                        Belum ada layanan unggulan.
                    </div>

                @endforelse

            </div>


            <a
                href="{{ route('marketplace.search') }}"
                class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-xs font-semibold text-slate-600 sm:hidden"
            >
                Lihat semua layanan
                <i class="bi bi-arrow-right text-[10px]"></i>
            </a>

        </div>

    </section>



    {{-- =========================================================
        FEATURED FREELANCERS
    ========================================================== --}}

    <section
        id="freelancer"
        class="scroll-mt-24 bg-slate-50 py-9 sm:py-11 lg:py-14"
    >

        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

            <div class="pk-home-reveal max-w-2xl">

                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                    Freelancer pilihan
                </p>

                <h2 class="mt-1.5 text-[22px] font-bold tracking-[-0.025em] text-slate-900 sm:text-2xl">
                    Temukan talenta untuk project-mu
                </h2>

                <p class="mt-1.5 text-sm leading-6 text-slate-500">
                    Jelajahi freelancer dari berbagai keahlian dan bidang.
                </p>

            </div>


            {{-- Mobile --}}

            <div class="pk-home-reveal mt-6 sm:hidden">

                <div class="no-scrollbar flex snap-x snap-mandatory gap-3 overflow-x-auto pb-3">

                    @forelse ($featuredFreelancers->take(8) as $freelancer)

                        @php

                            $freelancerName = data_get(
                                $freelancer,
                                'user.name',
                                data_get(
                                    $freelancer,
                                    'name',
                                    'Freelancer'
                                )
                            );

                            $freelancerUsername = data_get(
                                $freelancer,
                                'user.username',
                                data_get(
                                    $freelancer,
                                    'username'
                                )
                            );

                            $freelancerSlug =
                                $freelancerUsername;

                            $freelancerAvatar = data_get(
                                $freelancer,
                                'avatar',
                                data_get(
                                    $freelancer,
                                    'user.avatar'
                                )
                            );

                            $freelancerRating = data_get(
                                $freelancer,
                                'rating',
                                data_get(
                                    $freelancer,
                                    'average_rating'
                                )
                            );

                            $freelancerReviewCount = data_get(
                                $freelancer,
                                'reviews_count',
                                data_get(
                                    $freelancer,
                                    'review_count',
                                    0
                                )
                            );

                            $freelancerVerified = (bool) data_get(
                                $freelancer,
                                'is_verified',
                                data_get(
                                    $freelancer,
                                    'verified',
                                    false
                                )
                            );

                        @endphp


                        @if ($freelancerSlug)

                            <a
                                href="{{ route('marketplace.freelancer', ['username' => $freelancerSlug]) }}"
                                class="group w-[230px] shrink-0 snap-start rounded-2xl border border-slate-200 bg-white p-4 transition duration-200 active:scale-[0.99]"
                            >

                                <div class="flex items-center gap-3">

                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-blue-100 text-sm font-bold text-blue-700">

                                        @if ($freelancerAvatar)

                                            <img
                                                src="{{ $getMediaUrl($freelancerAvatar) }}"
                                                alt="{{ $freelancerName }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @else

                                            {{ strtoupper(mb_substr($freelancerName, 0, 1)) }}

                                        @endif

                                    </span>


                                    <div class="min-w-0">

                                        <div class="flex items-center gap-1">

                                            <h3 class="truncate text-sm font-semibold text-slate-900">
                                                {{ $freelancerName }}
                                            </h3>

                                            @if ($freelancerVerified)

                                                <i class="bi bi-patch-check-fill shrink-0 text-xs text-blue-500"></i>

                                            @endif

                                        </div>


                                        @if ($freelancerUsername)

                                            <p class="mt-0.5 truncate text-[10px] text-slate-400">
                                                @{{ ltrim($freelancerUsername, '@') }}
                                            </p>

                                        @endif

                                    </div>

                                </div>


                                <div class="mt-4 flex items-center gap-1 text-[11px]">

                                    <i class="bi bi-star-fill text-amber-400"></i>

                                    <span class="font-semibold text-slate-700">
                                        {{ $freelancerRating ? number_format((float) $freelancerRating, 1) : 'Baru' }}
                                    </span>


                                    @if ($freelancerReviewCount)

                                        <span class="text-slate-400">
                                            ({{ $freelancerReviewCount }})
                                        </span>

                                    @endif

                                </div>


                                <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-blue-600">
                                    Lihat profil
                                    <i class="bi bi-arrow-right text-[10px]"></i>
                                </span>

                            </a>

                        @endif

                    @empty

                        <div class="w-full rounded-2xl border border-dashed border-slate-200 bg-white p-8 text-center text-sm text-slate-400">
                            Belum ada freelancer pilihan.
                        </div>

                    @endforelse

                </div>

            </div>


            {{-- Desktop --}}

            <div class="pk-home-reveal mt-6 hidden grid-cols-2 gap-4 sm:grid lg:grid-cols-4">

                @forelse ($featuredFreelancers->take(8) as $freelancer)

                    @php

                        $freelancerName = data_get(
                            $freelancer,
                            'user.name',
                            data_get(
                                $freelancer,
                                'name',
                                'Freelancer'
                            )
                        );

                        $freelancerUsername = data_get(
                            $freelancer,
                            'user.username',
                            data_get(
                                $freelancer,
                                'username'
                            )
                        );

                        $freelancerSlug =
                            $freelancerUsername;

                        $freelancerAvatar = data_get(
                            $freelancer,
                            'avatar',
                            data_get(
                                $freelancer,
                                'user.avatar'
                            )
                        );

                        $freelancerRating = data_get(
                            $freelancer,
                            'rating',
                            data_get(
                                $freelancer,
                                'average_rating'
                            )
                        );

                        $freelancerReviewCount = data_get(
                            $freelancer,
                            'reviews_count',
                            data_get(
                                $freelancer,
                                'review_count',
                                0
                            )
                        );

                        $freelancerVerified = (bool) data_get(
                            $freelancer,
                            'is_verified',
                            data_get(
                                $freelancer,
                                'verified',
                                false
                            )
                        );

                    @endphp


                    @if ($freelancerSlug)

                        <a
                            href="{{ route('marketplace.freelancer', ['username' => $freelancerSlug]) }}"
                            class="group rounded-2xl border border-slate-200 bg-white p-5 transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-[0_12px_28px_rgba(15,23,42,0.06)]"
                        >

                            <div class="flex items-center gap-3">

                                <span class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-blue-100 text-sm font-bold text-blue-700">

                                    @if ($freelancerAvatar)

                                        <img
                                            src="{{ $getMediaUrl($freelancerAvatar) }}"
                                            alt="{{ $freelancerName }}"
                                            class="h-full w-full object-cover"
                                            loading="lazy"
                                        >

                                    @else

                                        {{ strtoupper(mb_substr($freelancerName, 0, 1)) }}

                                    @endif

                                </span>


                                <div class="min-w-0">

                                    <div class="flex items-center gap-1">

                                        <h3 class="truncate text-sm font-semibold text-slate-900">
                                            {{ $freelancerName }}
                                        </h3>

                                        @if ($freelancerVerified)

                                            <i class="bi bi-patch-check-fill shrink-0 text-xs text-blue-500"></i>

                                        @endif

                                    </div>


                                    @if ($freelancerUsername)

                                        <p class="mt-0.5 truncate text-[10px] text-slate-400">
                                            @{{ ltrim($freelancerUsername, '@') }}
                                        </p>

                                    @endif

                                </div>

                            </div>


                            <div class="mt-4 flex items-center gap-1 text-[11px]">

                                <i class="bi bi-star-fill text-amber-400"></i>

                                <span class="font-semibold text-slate-700">
                                    {{ $freelancerRating ? number_format((float) $freelancerRating, 1) : 'Baru' }}
                                </span>


                                @if ($freelancerReviewCount)

                                    <span class="text-slate-400">
                                        ({{ $freelancerReviewCount }})
                                    </span>

                                @endif

                            </div>


                            <span class="mt-5 inline-flex items-center gap-1 text-xs font-semibold text-blue-600">
                                Lihat profil
                                <i class="bi bi-arrow-right text-[10px]"></i>
                            </span>

                        </a>

                    @endif

                @empty

                    <div class="col-span-full rounded-2xl border border-dashed border-slate-200 bg-white p-8 text-center text-sm text-slate-400">
                        Belum ada freelancer pilihan.
                    </div>

                @endforelse

            </div>

        </div>

    </section>



    {{-- =========================================================
        FEATURED CATEGORY BANNER
    ========================================================== --}}

    @if ($featuredCategorySlug)

        <section class="bg-white py-9 sm:py-11 lg:py-14">

            <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

                <a
                    href="{{ route('marketplace.category', ['slug' => $featuredCategorySlug]) }}"
                    class="pk-home-reveal group block overflow-hidden rounded-[22px] border border-blue-100 bg-gradient-to-r from-blue-50 via-white to-white sm:rounded-3xl"
                >

                    <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-7 lg:p-9">

                        <div class="max-w-2xl">

                            <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.14em] text-blue-600 shadow-sm">
                                <i class="bi bi-stars text-[10px]"></i>
                                Kategori pilihan
                            </span>

                            <h2 class="mt-3 text-xl font-bold tracking-[-0.025em] text-slate-900 sm:text-2xl">
                                Jelajahi layanan {{ $featuredCategoryName }}
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Temukan freelancer dengan keahlian yang sesuai untuk kebutuhan project-mu.
                            </p>

                            <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-600">

                                Jelajahi kategori

                                <i class="bi bi-arrow-right text-xs transition group-hover:translate-x-0.5"></i>

                            </span>

                        </div>


                        <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-[22px] bg-blue-600 text-white shadow-lg shadow-blue-600/15 sm:h-28 sm:w-28">

                            <i class="bi bi-grid-3x3-gap text-3xl"></i>

                        </div>

                    </div>

                </a>

            </div>

        </section>

    @endif



    {{-- =========================================================
        NEED DISCOVERY
    ========================================================== --}}

    <section class="bg-slate-50 py-9 sm:py-11 lg:py-14">

        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

            <div class="pk-home-reveal max-w-2xl">

                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                    Butuh bantuan apa?
                </p>

                <h2 class="mt-1.5 text-[22px] font-bold tracking-[-0.025em] text-slate-900 sm:text-2xl">
                    Mulai dari kebutuhanmu
                </h2>

                <p class="mt-1.5 text-sm leading-6 text-slate-500">
                    Pilih kebutuhan yang paling dekat dengan project-mu.
                </p>

            </div>


            {{-- Mobile --}}

            <div class="pk-home-reveal mt-6 grid grid-cols-2 gap-3 sm:hidden">

                @foreach ($needShortcuts as $need)

                    <a
                        href="{{ $need['url'] }}"
                        class="group rounded-2xl border border-slate-200 bg-white p-4 transition active:scale-[0.99]"
                    >

                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <i class="bi {{ $need['icon'] }} text-[17px]"></i>
                        </span>

                        <h3 class="mt-3 text-sm font-semibold leading-5 text-slate-900">
                            {{ $need['title'] }}
                        </h3>

                        <p class="mt-1.5 line-clamp-3 text-[10px] leading-4.5 text-slate-400">
                            {{ $need['description'] }}
                        </p>

                        <span class="mt-3 inline-flex items-center gap-1 text-[10px] font-semibold text-blue-600">
                            Cari jasa
                            <i class="bi bi-arrow-right text-[9px]"></i>
                        </span>

                    </a>

                @endforeach

            </div>


            {{-- Desktop --}}

            <div class="pk-home-reveal mt-6 hidden grid-cols-4 gap-4 sm:grid">

                @foreach ($needShortcuts as $need)

                    <a
                        href="{{ $need['url'] }}"
                        class="group rounded-2xl border border-slate-200 bg-white p-5 transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-[0_12px_28px_rgba(15,23,42,0.06)]"
                    >

                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <i class="bi {{ $need['icon'] }} text-[18px]"></i>
                        </span>

                        <h3 class="mt-4 text-sm font-semibold text-slate-900">
                            {{ $need['title'] }}
                        </h3>

                        <p class="mt-1.5 text-xs leading-5 text-slate-500">
                            {{ $need['description'] }}
                        </p>

                        <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600">
                            Cari jasa
                            <i class="bi bi-arrow-right text-[10px] transition group-hover:translate-x-0.5"></i>
                        </span>

                    </a>

                @endforeach

            </div>

        </div>

    </section>



    {{-- =========================================================
        MIDDLE CMS BANNER
        Natural image ratio
    ========================================================== --}}

    @if ($cmsMiddleBanners->isNotEmpty())

        <section class="bg-slate-50 pb-9 sm:pb-11 lg:pb-14">

            <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

                @foreach ($cmsMiddleBanners->take(1) as $banner)

                    @php

                        $desktopImage = method_exists(
                            $banner,
                            'getImageUrlAttribute'
                        )
                            ? $banner->image_url
                            : $getMediaUrl(
                                $banner->image_path ?? null
                            );

                        $mobileImage = method_exists(
                            $banner,
                            'getMobileImageUrlAttribute'
                        )
                            ? (
                                $banner->mobile_image_url
                                ?: $desktopImage
                            )
                            : $getMediaUrl(
                                $banner->mobile_image_path ?? null
                            );

                        $mobileImage =
                            $mobileImage
                            ?: $desktopImage;

                        $bannerLink =
                            $banner->link_url
                            ?? null;

                        $bannerAlt =
                            $banner->alt_text
                            ?? (
                                $banner->name
                                ?? 'Banner ProKerja'
                            );

                    @endphp


                    <div class="pk-home-reveal overflow-hidden rounded-[22px] border border-slate-200 bg-white sm:rounded-3xl">

                        @if ($bannerLink)

                            <a
                                href="{{ $bannerLink }}"
                                @if ($banner->open_new_tab ?? false)
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                                class="block"
                            >

                        @endif


                        @if ($desktopImage)

                            <picture class="block w-full">

                                @if ($mobileImage)

                                    <source
                                        media="(max-width: 639px)"
                                        srcset="{{ $mobileImage }}"
                                    >

                                @endif


                                <img
                                    src="{{ $desktopImage }}"
                                    alt="{{ $bannerAlt }}"
                                    class="block h-auto w-full object-contain"
                                    loading="lazy"
                                    draggable="false"
                                >

                            </picture>

                        @else

                            <div class="flex min-h-[150px] items-center bg-blue-50 px-5 py-10 sm:px-10">
                                <p class="text-lg font-bold text-slate-900">
                                    {{ $banner->name ?? 'ProKerja' }}
                                </p>
                            </div>

                        @endif


                        @if ($bannerLink)

                            </a>

                        @endif

                    </div>

                @endforeach

            </div>

        </section>

    @endif



    {{-- =========================================================
        HOW IT WORKS
    ========================================================== --}}

    <section class="bg-white py-10 sm:py-12 lg:py-14">

        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

            <div class="pk-home-reveal text-center">

                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                    Cara kerja
                </p>

                <h2 class="mt-1.5 text-[22px] font-bold tracking-[-0.025em] text-slate-900 sm:text-2xl">
                    Mulai sampai selesai, lebih sederhana
                </h2>

                <p class="mx-auto mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                    Alur kerja ProKerja dibuat agar client dan freelancer mudah bekerja bersama.
                </p>

            </div>


            {{-- Mobile --}}

            <div class="mt-7 space-y-3 sm:hidden">

                @foreach ($howItWorks as $step)

                    <div class="pk-home-reveal flex gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">

                        <div class="relative shrink-0">

                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-white">
                                <i class="bi {{ $step['icon'] }} text-[16px]"></i>
                            </span>

                        </div>


                        <div class="min-w-0">

                            <div class="flex items-center gap-2">

                                <span class="text-[10px] font-bold tracking-[0.12em] text-blue-600">
                                    {{ $step['number'] }}
                                </span>

                                <h3 class="text-sm font-semibold text-slate-900">
                                    {{ $step['title'] }}
                                </h3>

                            </div>


                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                {{ $step['description'] }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Desktop --}}

            <div class="mt-8 hidden grid-cols-3 gap-5 sm:grid">

                @foreach ($howItWorks as $step)

                    <div class="pk-home-reveal relative rounded-2xl border border-slate-200 bg-slate-50 p-6">

                        <div class="flex items-center justify-between">

                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-white">
                                <i class="bi {{ $step['icon'] }} text-[17px]"></i>
                            </span>

                            <span class="text-xs font-bold tracking-[0.14em] text-blue-200">
                                {{ $step['number'] }}
                            </span>

                        </div>


                        <h3 class="mt-5 text-sm font-semibold text-slate-900">
                            {{ $step['title'] }}
                        </h3>

                        <p class="mt-2 text-xs leading-5 text-slate-500">
                            {{ $step['description'] }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>

    </section>



    {{-- =========================================================
        BENEFITS
    ========================================================== --}}

    <section class="bg-slate-50 py-10 sm:py-12 lg:py-14">

        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

            <div class="pk-home-reveal text-center">

                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                    Kenapa ProKerja?
                </p>

                <h2 class="mt-1.5 text-[22px] font-bold tracking-[-0.025em] text-slate-900 sm:text-2xl">
                    Dibuat untuk mempermudah pekerjaan
                </h2>

            </div>


            {{-- Mobile --}}

            <div class="mt-7 space-y-3 sm:hidden">

                @foreach ($benefits as $benefit)

                    <div class="pk-home-reveal flex gap-3 rounded-2xl border border-slate-200 bg-white p-4">

                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <i class="bi {{ $benefit['icon'] }} text-[17px]"></i>
                        </span>


                        <div class="min-w-0">

                            <h3 class="text-sm font-semibold text-slate-900">
                                {{ $benefit['title'] }}
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                {{ $benefit['description'] }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Desktop --}}

            <div class="mt-8 hidden grid-cols-3 gap-5 sm:grid">

                @foreach ($benefits as $benefit)

                    <div class="pk-home-reveal rounded-2xl border border-slate-200 bg-white p-6">

                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <i class="bi {{ $benefit['icon'] }} text-[18px]"></i>
                        </span>

                        <h3 class="mt-4 text-sm font-semibold text-slate-900">
                            {{ $benefit['title'] }}
                        </h3>

                        <p class="mt-2 text-xs leading-5 text-slate-500">
                            {{ $benefit['description'] }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>

    </section>



    {{-- =========================================================
        TESTIMONIALS
    ========================================================== --}}

    @if ($testimonials->isNotEmpty())

        <section class="bg-white py-10 sm:py-12 lg:py-14">

            <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

                <div class="pk-home-reveal">

                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                        Cerita pengguna
                    </p>

                    <h2 class="mt-1.5 text-[22px] font-bold tracking-[-0.025em] text-slate-900 sm:text-2xl">
                        Pengalaman dari pengguna ProKerja
                    </h2>

                </div>


                <div class="pk-home-reveal mt-6">

                    <div class="no-scrollbar flex gap-4 overflow-x-auto pb-3 sm:grid sm:grid-cols-2 sm:overflow-visible lg:grid-cols-3">

                        @foreach ($testimonials->take(6) as $testimonial)

                            @php

                                $testimonialName = data_get(
                                    $testimonial,
                                    'user.name',
                                    data_get(
                                        $testimonial,
                                        'name',
                                        'Pengguna ProKerja'
                                    )
                                );

                                $testimonialMessage = data_get(
                                    $testimonial,
                                    'comment',
                                    data_get(
                                        $testimonial,
                                        'message',
                                        data_get(
                                            $testimonial,
                                            'content',
                                            ''
                                        )
                                    )
                                );

                                $testimonialRating = data_get(
                                    $testimonial,
                                    'rating',
                                    5
                                );

                            @endphp


                            <article class="w-[285px] shrink-0 rounded-2xl border border-slate-200 bg-slate-50 p-5 sm:w-auto">

                                <div class="flex items-center gap-1">

                                    @for ($i = 1; $i <= 5; $i++)

                                        <i class="bi bi-star-fill text-[10px] {{ $i <= (int) $testimonialRating ? 'text-amber-400' : 'text-slate-300' }}"></i>

                                    @endfor

                                </div>


                                <p class="mt-4 line-clamp-4 text-xs leading-5 text-slate-600">
                                    “{{ $testimonialMessage }}”
                                </p>


                                <div class="mt-5 text-xs font-semibold text-slate-900">
                                    {{ $testimonialName }}
                                </div>

                            </article>

                        @endforeach

                    </div>

                </div>

            </div>

        </section>

    @endif



    {{-- =========================================================
        BOTTOM BANNER
        Natural image ratio
    ========================================================== --}}

    @if ($cmsBottomBanners->isNotEmpty())

        <section class="bg-slate-50 py-9 sm:py-11 lg:py-14">

            <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

                @foreach ($cmsBottomBanners->take(1) as $banner)

                    @php

                        $desktopImage = method_exists(
                            $banner,
                            'getImageUrlAttribute'
                        )
                            ? $banner->image_url
                            : $getMediaUrl(
                                $banner->image_path ?? null
                            );

                        $mobileImage = method_exists(
                            $banner,
                            'getMobileImageUrlAttribute'
                        )
                            ? (
                                $banner->mobile_image_url
                                ?: $desktopImage
                            )
                            : $getMediaUrl(
                                $banner->mobile_image_path ?? null
                            );

                        $mobileImage =
                            $mobileImage
                            ?: $desktopImage;

                        $bannerLink =
                            $banner->link_url
                            ?? null;

                        $bannerAlt =
                            $banner->alt_text
                            ?? (
                                $banner->name
                                ?? 'Banner ProKerja'
                            );

                    @endphp


                    <div class="pk-home-reveal overflow-hidden rounded-[22px] border border-slate-200 bg-white sm:rounded-3xl">

                        @if ($bannerLink)

                            <a
                                href="{{ $bannerLink }}"
                                @if ($banner->open_new_tab ?? false)
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                                class="block"
                            >

                        @endif


                        @if ($desktopImage)

                            <picture class="block w-full">

                                @if ($mobileImage)

                                    <source
                                        media="(max-width: 639px)"
                                        srcset="{{ $mobileImage }}"
                                    >

                                @endif


                                <img
                                    src="{{ $desktopImage }}"
                                    alt="{{ $bannerAlt }}"
                                    class="block h-auto w-full object-contain"
                                    loading="lazy"
                                    draggable="false"
                                >

                            </picture>

                        @else

                            <div class="flex min-h-[150px] items-center bg-blue-50 px-5 py-10 sm:px-10">

                                <p class="text-lg font-bold text-slate-900">
                                    {{ $banner->name ?? 'ProKerja' }}
                                </p>

                            </div>

                        @endif


                        @if ($bannerLink)

                            </a>

                        @endif

                    </div>

                @endforeach

            </div>

        </section>

    @endif



    {{-- =========================================================
        FINAL CTA
    ========================================================== --}}

    <section class="bg-white py-10 sm:py-12 lg:py-16">

        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

            <div class="pk-home-reveal overflow-hidden rounded-[24px] border border-blue-100 bg-blue-50">

                <div class="flex flex-col gap-5 p-6 sm:p-8 lg:flex-row lg:items-center lg:justify-between lg:p-10">

                    <div class="max-w-2xl">

                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                            Siap mulai?
                        </p>

                        <h2 class="mt-2 text-2xl font-bold tracking-[-0.03em] text-slate-900 sm:text-3xl">
                            Temukan talenta. Wujudkan kerja.
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Temukan layanan yang sesuai atau mulai jelajahi berbagai proyek yang tersedia.
                        </p>

                    </div>


                    <div class="flex w-full flex-col gap-2 sm:flex-row lg:w-auto">

                        <a
                            href="{{ route('marketplace.search') }}"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white transition hover:bg-blue-700"
                        >
                            Cari Jasa
                            <i class="bi bi-search text-xs"></i>
                        </a>


                        <a
                            href="{{ route('marketplace.jobs.index') }}"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-600"
                        >
                            Lihat Proyek
                            <i class="bi bi-arrow-right text-xs"></i>
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>


</x-layouts.marketplace>



{{-- ================================================================
HOMEPAGE INTERACTION
================================================================ --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const typingText = document.getElementById('pk-typing-text');
    const typingCursor = document.getElementById('pk-typing-cursor');

    if (typingText) {

        const words = [
            'Bisnis',
            'Kebutuhan',
            'Project',
            'Impian',
            'Pekerjaan',
        ];

        let wordIndex = 0;
        let charIndex = 0;
        let deleting = false;
        let timer = null;

        const typeLoop = function () {

            const currentWord = words[wordIndex];

            if (!deleting) {
                charIndex += 1;
                typingText.textContent = currentWord.substring(0, charIndex);

                if (charIndex >= currentWord.length) {
                    timer = setTimeout(function () {
                        deleting = true;
                        typeLoop();
                    }, 1800);
                    return;
                }

                timer = setTimeout(typeLoop, 90);
                return;
            }

            charIndex -= 1;
            typingText.textContent = currentWord.substring(0, charIndex);

            if (charIndex <= 0) {
                charIndex = 0;
                deleting = false;
                wordIndex = (wordIndex + 1) % words.length;

                timer = setTimeout(typeLoop, 400);
                return;
            }

            timer = setTimeout(typeLoop, 50);
        };

        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            typingText.textContent = words[0];
        } else {
            timer = setTimeout(typeLoop, 500);
        }
    }

    if (typingCursor) {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            typingCursor.style.display = 'none';
        } else {
            setInterval(function () {
                typingCursor.style.opacity = typingCursor.style.opacity === '0' ? '1' : '0';
            }, 550);
        }
    }

    const revealItems = document.querySelectorAll('.pk-home-reveal');

    if (!revealItems.length) {
        return;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        revealItems.forEach(function (item) {
            item.classList.add('pk-home-visible');
        });
        return;
    }

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('pk-home-visible');
                obs.unobserve(entry.target);
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -35px 0px'
        });

        revealItems.forEach(function (item) {
            observer.observe(item);
        });
    } else {
        revealItems.forEach(function (item) {
            item.classList.add('pk-home-visible');
        });
    }
});
</script>



<style>

.no-scrollbar {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.no-scrollbar::-webkit-scrollbar {
    display: none;
}


/*
|--------------------------------------------------------------------------
| Homepage reveal
|--------------------------------------------------------------------------
*/

.pk-home-reveal {
    opacity: 0;
    transform: translate3d(0, 24px, 0) scale(0.985);
    transition:
        opacity 650ms cubic-bezier(0.22, 1, 0.36, 1),
        transform 650ms cubic-bezier(0.22, 1, 0.36, 1);
    will-change: opacity, transform;
}

.pk-home-reveal.pk-home-visible {
    opacity: 1;
    transform: translate3d(0, 0, 0) scale(1);
}

.pk-home-reveal:nth-child(2) {
    transition-delay: 40ms;
}

.pk-home-reveal:nth-child(3) {
    transition-delay: 80ms;
}

.pk-home-reveal:nth-child(4) {
    transition-delay: 120ms;
}

.pk-home-reveal:nth-child(5) {
    transition-delay: 160ms;
}

.pk-home-reveal:nth-child(6) {
    transition-delay: 200ms;
}


/*
|--------------------------------------------------------------------------
| Banner transition
|--------------------------------------------------------------------------
*/

.pk-banner-slider {
    transition:
        height 700ms cubic-bezier(
            0.22,
            1,
            0.36,
            1
        );
}


/*
|--------------------------------------------------------------------------
| Mobile
|--------------------------------------------------------------------------
*/

@media (max-width: 639px) {

    body {
        overflow-x: hidden;
    }


    #kategori,
    #freelancer {
        scroll-margin-top: 84px;
    }


    main,
    body > div {
        max-width: 100%;
    }

}


/*
|--------------------------------------------------------------------------
| Reduced motion
|--------------------------------------------------------------------------
*/

@media (prefers-reduced-motion: reduce) {

    .pk-home-reveal {
        opacity: 1 !important;
        transform: none !important;
        transition: none !important;
    }

}

</style>