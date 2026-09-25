@php
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| DATA UTAMA
|--------------------------------------------------------------------------
*/

$user = $freelancerProfile->user;

$freelancerName = $user?->name
    ?? $freelancerProfile->username
    ?? 'Freelancer';

$username = $freelancerProfile->username ?? '';

/*
|--------------------------------------------------------------------------
| AVATAR
|--------------------------------------------------------------------------
*/

$avatarUrl = !empty($freelancerProfile->avatar)
    ? asset('storage/' . $freelancerProfile->avatar)
    : null;

/*
|--------------------------------------------------------------------------
| COVER
|--------------------------------------------------------------------------
*/

$coverUrl = !empty($freelancerProfile->cover_image)
    ? asset('storage/' . $freelancerProfile->cover_image)
    : null;


/*
|--------------------------------------------------------------------------
| SERVICES
|--------------------------------------------------------------------------
*/

$services = isset($services)
    ? collect($services)
    : (
        method_exists($freelancerProfile, 'services')
            ? collect($freelancerProfile->services)
            : collect()
    );


/*
|--------------------------------------------------------------------------
| REVIEWS
|--------------------------------------------------------------------------
*/

$reviews = isset($reviews)
    ? collect($reviews)
    : (
        method_exists($freelancerProfile, 'reviews')
            ? collect($freelancerProfile->reviews)
            : collect()
    );


/*
|--------------------------------------------------------------------------
| EXPERIENCES
|--------------------------------------------------------------------------
*/

$experiences = isset($experiences)
    ? collect($experiences)
    : (
        method_exists($freelancerProfile, 'experiences')
            ? collect($freelancerProfile->experiences)
            : collect()
    );


/*
|--------------------------------------------------------------------------
| EDUCATIONS
|--------------------------------------------------------------------------
*/

$educations = isset($educations)
    ? collect($educations)
    : (
        method_exists($freelancerProfile, 'educations')
            ? collect($freelancerProfile->educations)
            : collect()
    );


/*
|--------------------------------------------------------------------------
| CERTIFICATES
|--------------------------------------------------------------------------
*/

$certificates = isset($certificates)
    ? collect($certificates)
    : (
        method_exists($freelancerProfile, 'certificates')
            ? collect($freelancerProfile->certificates)
            : collect()
    );


/*
|--------------------------------------------------------------------------
| SKILLS
|--------------------------------------------------------------------------
*/

$skills = isset($skills)
    ? collect($skills)
    : (
        method_exists($freelancerProfile, 'skills')
            ? collect($freelancerProfile->skills)
            : collect()
    );


/*
|--------------------------------------------------------------------------
| LANGUAGES
|--------------------------------------------------------------------------
*/

$languages = isset($languages)
    ? collect($languages)
    : (
        method_exists($freelancerProfile, 'languages')
            ? collect($freelancerProfile->languages)
            : collect()
    );


/*
|--------------------------------------------------------------------------
| SERVICE CATEGORIES
|--------------------------------------------------------------------------
*/

$serviceCategories = isset($serviceCategories)
    ? collect($serviceCategories)
    : collect();


/*
|--------------------------------------------------------------------------
| FILTER
|--------------------------------------------------------------------------
*/

$search = request('q', '');

$selectedCategorySlug = request(
    'category',
    ''
);

$sort = request(
    'sort',
    'relevance'
);

$selectedCategory = $selectedCategory ?? null;


/*
|--------------------------------------------------------------------------
| STATS
|--------------------------------------------------------------------------
*/

$rating = (float) (
    $rating
    ?? $freelancerProfile->rating
    ?? 0
);

$completedOrders = (int) (
    $completedOrders
    ?? $freelancerProfile->completed_orders
    ?? 0
);

$serviceCount = (int) (
    $serviceCount
    ?? $services->count()
);

$reviewCount = (int) (
    $reviewCount
    ?? $reviews->count()
);

$customerCount = (int) (
    $customerCount
    ?? 0
);

$rehiredCount = (int) (
    $rehiredCount
    ?? 0
);

$totalOrders = (int) (
    $totalOrders
    ?? 0
);

$minimumPrice = (float) (
    $minimumPrice
    ?? $services->min('starting_price')
    ?? 0
);


/*
|--------------------------------------------------------------------------
| USER STATUS
|--------------------------------------------------------------------------
*/

$isAvailable = (bool) (
    $isAvailable
    ?? $freelancerProfile->is_available
    ?? false
);

$isClient = auth()->check()
    && auth()->user()->role === 'client';

$isOwner = auth()->check()
    && $freelancerProfile->user_id === auth()->id();


/*
|--------------------------------------------------------------------------
| CONTACT SERVICE
|--------------------------------------------------------------------------
*/

$contactService = $contactService
    ?? $services->first();


@endphp

<x-layouts.marketplace
:title="$freelancerName . ' - ProKerja'"

>


<style>
    [data-profile-slider] {
        overflow: hidden;
    }

    [data-profile-track] {
        display: flex;
        width: 200%;
        align-items: flex-start;
        transition:
            transform 500ms cubic-bezier(.22, 1, .36, 1);
        will-change: transform;
    }

    [data-profile-panel] {
        width: 50%;
        flex: 0 0 50%;
    }

    [data-profile-height] {
        overflow: hidden;
        transition:
            height 500ms cubic-bezier(.22, 1, .36, 1);
    }

    [data-profile-tab] {
        position: relative;
    }

    [data-profile-tab].is-active {
        color: #2563EB;
    }

    [data-profile-tab].is-active::after {
        content: "";
        position: absolute;
        left: 14px;
        right: 14px;
        bottom: 0;
        height: 2px;
        border-radius: 999px;
        background: #2563EB;
    }

    @media (max-width: 640px) {
        [data-profile-tab].is-active::after {
            left: 12px;
            right: 12px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        [data-profile-track],
        [data-profile-height] {
            transition: none !important;
        }
    }
</style>


{{-- ========================================================= --}}
{{-- HEADER / BREADCRUMB --}}
{{-- ========================================================= --}}

<section class="border-b border-slate-100 bg-white pt-[48px] md:pt-[52px]">

    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">

        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 sm:text-sm">

            <a
                href="{{ route('marketplace.home') }}"
                class="transition hover:text-[#2563EB]"
            >
                Beranda
            </a>

            <i class="bi bi-chevron-right text-[10px]"></i>

            <a
                href="{{ route('marketplace.search') }}"
                class="transition hover:text-[#2563EB]"
            >
                Cari Jasa
            </a>

            <i class="bi bi-chevron-right text-[10px]"></i>

            <span class="font-medium text-slate-700">
                Freelancer
            </span>

        </div>

    </div>

</section>


{{-- ========================================================= --}}
{{-- PROFILE HEADER --}}
{{-- ========================================================= --}}

<section class="bg-white">

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

        <div class="overflow-hidden rounded-[26px] border border-slate-200 bg-white shadow-sm">


            {{-- COVER --}}
            <div class="relative h-36 overflow-hidden bg-[#EFF6FF] sm:h-48 lg:h-56">

                @if ($coverUrl)

                    <img
                        src="{{ $coverUrl }}"
                        alt="Cover {{ $freelancerName }}"
                        class="h-full w-full object-cover"
                    >

                    <div class="absolute inset-0 bg-black/5"></div>

                @else

                    <div class="absolute inset-0 bg-gradient-to-r from-[#EFF6FF] via-[#DBEAFE] to-white"></div>

                    <div class="absolute -left-10 -top-14 h-44 w-44 rounded-full bg-[#3B82F6]/10 blur-3xl"></div>

                    <div class="absolute right-0 top-2 h-52 w-52 rounded-full bg-[#2563EB]/10 blur-3xl"></div>

                    <div class="absolute bottom-[-80px] left-1/3 h-48 w-48 rounded-full bg-white/90 blur-3xl"></div>

                @endif

            </div>


            {{-- PROFILE INFORMATION --}}
            <div class="px-5 pb-6 sm:px-8 sm:pb-8">

                <div class="-mt-14 flex flex-col gap-6 sm:-mt-16 lg:flex-row lg:items-end lg:justify-between">


                    {{-- LEFT PROFILE --}}
                    <div class="flex min-w-0 flex-col gap-5 sm:flex-row sm:items-end">

                        {{-- AVATAR --}}
                        <div class="relative shrink-0">

                            <div class="h-28 w-28 overflow-hidden rounded-full border-4 border-white bg-[#EFF6FF] shadow-lg sm:h-32 sm:w-32">

                                @if ($avatarUrl)

                                    <img
                                        src="{{ $avatarUrl }}"
                                        alt="{{ $freelancerName }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center text-3xl font-bold text-[#2563EB]">
                                        {{ strtoupper(substr($freelancerName, 0, 1)) }}
                                    </div>

                                @endif

                            </div>


                            @if ($isAvailable)

                                <span class="absolute bottom-1 right-1 flex h-7 w-7 items-center justify-center rounded-full border-4 border-white bg-[#16A34A]">

                                    <span class="h-2.5 w-2.5 rounded-full bg-white"></span>

                                </span>

                            @endif

                        </div>


                        {{-- PROFILE TEXT --}}
                        <div class="min-w-0 pb-1">

                            <div class="flex flex-wrap items-center gap-2">

                                <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] sm:text-3xl">
                                    {{ $freelancerName }}
                                </h1>


                                @if ($freelancerProfile->is_verified ?? false)

                                    <span class="inline-flex items-center gap-1 rounded-full bg-[#EFF6FF] px-2.5 py-1 text-[11px] font-semibold text-[#2563EB]">

                                        <i class="bi bi-patch-check-fill"></i>

                                        Terverifikasi

                                    </span>

                                @endif

                            </div>


                            <p class="mt-1 text-sm text-slate-500">
                                {{ '@' . $username }}
                            </p>


                            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600 sm:text-base">
                                {{ $freelancerProfile->headline ?: 'Freelancer profesional siap membantu kebutuhanmu.' }}
                            </p>


                            <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-slate-500 sm:text-sm">

                                @if ($rating > 0)

                                    <span class="inline-flex items-center gap-1.5">

                                        <i class="bi bi-star-fill text-[#F59E0B]"></i>

                                        <strong class="text-slate-700">
                                            {{ number_format($rating, 1) }}
                                        </strong>

                                    </span>

                                @endif


                                <span class="inline-flex items-center gap-1.5">

                                    <i class="bi bi-check2-circle"></i>

                                    {{ number_format($completedOrders) }} pesanan selesai

                                </span>


                                @if (!empty($freelancerProfile->location))

                                    <span class="inline-flex items-center gap-1.5">

                                        <i class="bi bi-geo-alt"></i>

                                        {{ $freelancerProfile->location }}

                                    </span>

                                @endif


                                @if (!empty($freelancerProfile->website))

                                    <a
                                        href="{{ Str::startsWith($freelancerProfile->website, ['http://', 'https://'])
                                            ? $freelancerProfile->website
                                            : 'https://' . $freelancerProfile->website }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 transition hover:text-[#2563EB]"
                                    >

                                        <i class="bi bi-globe2"></i>

                                        Website

                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- ACTION --}}
                    <div class="shrink-0">

                        @if ($isOwner)

                            <a
                                href="{{ route('freelancer.profile.edit') }}"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#2563EB] hover:text-[#2563EB] sm:w-auto"
                            >

                                <i class="bi bi-pencil"></i>

                                Edit Profil

                            </a>

                        @elseif ($isClient && $contactService)

                            <form
                                method="POST"
                                action="{{ route('client.messages.start', $contactService) }}"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8] sm:w-auto"
                                >

                                    <i class="bi bi-chat-dots"></i>

                                    Hubungi Freelancer

                                </button>

                            </form>

                        @elseif (!$isClient)

                            <a
                                href="{{ route('login') }}"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8] sm:w-auto"
                            >

                                <i class="bi bi-chat-dots"></i>

                                Hubungi Freelancer

                            </a>

                        @endif

                    </div>

                </div>


                {{-- AVAILABILITY --}}
                <div class="mt-6 border-t border-slate-100 pt-5">

                    @if ($isAvailable)

                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-[#16A34A]">

                            <span class="h-2 w-2 rounded-full bg-[#16A34A]"></span>

                            Freelancer sedang tersedia

                        </span>

                    @else

                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500">

                            <span class="h-2 w-2 rounded-full bg-slate-300"></span>

                            Freelancer sedang tidak tersedia

                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ========================================================= --}}
{{-- STATS --}}
{{-- ========================================================= --}}

<section class="border-y border-slate-100 bg-[#F8FAFC]">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-2 divide-x divide-slate-200 sm:grid-cols-4">

            <div class="px-3 py-5 text-center sm:py-6">

                <p class="text-2xl font-bold text-[#0F172A]">
                    {{ number_format($completedOrders) }}
                </p>

                <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                    Pesanan Selesai
                </p>

            </div>


            <div class="px-3 py-5 text-center sm:py-6">

                <p class="text-2xl font-bold text-[#0F172A]">
                    {{ number_format($customerCount) }}
                </p>

                <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                    Klien
                </p>

            </div>


            <div class="border-t border-slate-200 px-3 py-5 text-center sm:border-t-0 sm:py-6">

                <p class="text-2xl font-bold text-[#0F172A]">
                    {{ number_format($rehiredCount) }}
                </p>

                <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                    Repeat Client
                </p>

            </div>


            <div class="border-t border-slate-200 px-3 py-5 text-center sm:border-t-0 sm:py-6">

                <p class="text-2xl font-bold text-[#2563EB]">

                    @if ($minimumPrice > 0)

                        Rp{{ number_format($minimumPrice, 0, ',', '.') }}

                    @else

                        -

                    @endif

                </p>

                <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                    Mulai dari
                </p>

            </div>

        </div>

    </div>

</section>


{{-- ========================================================= --}}
{{-- PROFILE TABS --}}
{{-- ========================================================= --}}

<section class="sticky top-[48px] z-20 border-b border-slate-200 bg-white/95 backdrop-blur md:top-[52px]">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex overflow-x-auto">

            <button
                type="button"
                data-profile-tab="0"
                class="is-active relative flex shrink-0 items-center gap-2 px-4 py-4 text-sm font-semibold text-[#2563EB] transition sm:px-5"
            >

                <i class="bi bi-briefcase"></i>

                Layanan & Review

            </button>


            <button
                type="button"
                data-profile-tab="1"
                class="relative flex shrink-0 items-center gap-2 px-4 py-4 text-sm font-semibold text-slate-500 transition hover:text-slate-800 sm:px-5"
            >

                <i class="bi bi-person-workspace"></i>

                Pengalaman

            </button>

        </div>

    </div>

</section>


{{-- ========================================================= --}}
{{-- MAIN CONTENT --}}
{{-- ========================================================= --}}

<section class="bg-[#F8FAFC]">

    <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-10">

        <div class="grid items-start gap-6 lg:grid-cols-[minmax(0,1fr)_320px] xl:grid-cols-[minmax(0,1fr)_340px]">


            {{-- ================================================= --}}
            {{-- SLIDING LEFT CONTENT --}}
            {{-- ================================================= --}}

            <div
                data-profile-height
                style="height:auto;"
            >

                <div data-profile-slider>

                    <div
                        data-profile-track
                        style="transform:translate3d(0,0,0);"
                    >


                        {{-- ================================================= --}}
                        {{-- PANEL 1: LAYANAN + REVIEW --}}
                        {{-- ================================================= --}}

                        <section
                            data-profile-panel
                            class="w-1/2 shrink-0"
                        >

                            {{-- Heading --}}
                            <div class="mb-5">

                                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">

                                    <div>

                                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#2563EB]">
                                            Marketplace
                                        </p>

                                        <h2 class="mt-1 text-xl font-bold text-[#0F172A] sm:text-2xl">
                                            Layanan & Review
                                        </h2>

                                        <p class="mt-1 text-sm leading-6 text-slate-500">
                                            Layanan yang ditawarkan dan pengalaman klien sebelumnya.
                                        </p>

                                    </div>


                                    <span class="text-sm text-slate-500">
                                        {{ number_format($serviceCount) }} layanan
                                    </span>

                                </div>

                            </div>


                            {{-- Filter --}}
                            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                                <form
                                    method="GET"
                                    action="{{ route('marketplace.freelancer', ['username' => $username]) }}"
                                    class="grid gap-3 md:grid-cols-[minmax(0,1fr)_190px_160px_auto]"
                                >

                                    <div class="relative">

                                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>

                                        <input
                                            type="text"
                                            name="q"
                                            value="{{ $search }}"
                                            placeholder="Cari layanan..."
                                            class="h-11 w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2563EB] focus:ring-2 focus:ring-[#DBEAFE]"
                                        >

                                    </div>


                                    <select
                                        name="category"
                                        class="h-11 rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-700 outline-none transition focus:border-[#2563EB] focus:ring-2 focus:ring-[#DBEAFE]"
                                    >

                                        <option value="">
                                            Semua Kategori
                                        </option>

                                        @foreach ($serviceCategories as $category)

                                            <option
                                                value="{{ $category->slug }}"
                                                @selected($selectedCategorySlug === $category->slug)
                                            >
                                                {{ $category->name }}
                                            </option>

                                        @endforeach

                                    </select>


                                    <select
                                        name="sort"
                                        class="h-11 rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-700 outline-none transition focus:border-[#2563EB] focus:ring-2 focus:ring-[#DBEAFE]"
                                    >

                                        <option
                                            value="relevance"
                                            @selected($sort === 'relevance')
                                        >
                                            Relevan
                                        </option>

                                        <option
                                            value="latest"
                                            @selected($sort === 'latest')
                                        >
                                            Terbaru
                                        </option>

                                        <option
                                            value="price_low"
                                            @selected($sort === 'price_low')
                                        >
                                            Harga Terendah
                                        </option>

                                        <option
                                            value="price_high"
                                            @selected($sort === 'price_high')
                                        >
                                            Harga Tertinggi
                                        </option>

                                        <option
                                            value="popular"
                                            @selected($sort === 'popular')
                                        >
                                            Terpopuler
                                        </option>

                                    </select>


                                    <button
                                        type="submit"
                                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-sm font-semibold text-white transition hover:bg-[#1D4ED8]"
                                    >

                                        <i class="bi bi-search"></i>

                                        Cari

                                    </button>

                                </form>

                            </div>


                            {{-- Category Pills --}}
                            @if ($serviceCategories->count())

                                <div class="mb-6 flex gap-2 overflow-x-auto pb-1">

                                    <a
                                        href="{{ route('marketplace.freelancer', ['username' => $username]) }}"
                                        class="shrink-0 rounded-full px-4 py-2 text-xs font-semibold transition
                                            {{ !$selectedCategorySlug
                                                ? 'bg-[#2563EB] text-white'
                                                : 'border border-slate-200 bg-white text-slate-600 hover:border-[#2563EB] hover:text-[#2563EB]' }}"
                                    >
                                        Semua
                                    </a>


                                    @foreach ($serviceCategories as $category)

                                        <a
                                            href="{{ route('marketplace.freelancer', [
                                                'username' => $username,
                                                'category' => $category->slug,
                                                'q' => $search,
                                                'sort' => $sort,
                                            ]) }}"
                                            class="shrink-0 rounded-full px-4 py-2 text-xs font-semibold transition
                                                {{ $selectedCategorySlug === $category->slug
                                                    ? 'bg-[#2563EB] text-white'
                                                    : 'border border-slate-200 bg-white text-slate-600 hover:border-[#2563EB] hover:text-[#2563EB]' }}"
                                        >
                                            {{ $category->name }}
                                        </a>

                                    @endforeach

                                </div>

                            @endif


                            {{-- SERVICES --}}
                            <div class="space-y-4">

                                @forelse ($services as $service)

                                    @php
                                        $serviceTitle = $service->title
                                            ?? $service->name
                                            ?? 'Layanan';

                                        $serviceImage = null;

                                        if (!empty($service->thumbnail)) {
                                            $serviceImage = asset(
                                                'storage/' . $service->thumbnail
                                            );
                                        } elseif (!empty($service->image_path)) {
                                            $serviceImage = asset(
                                                'storage/' . $service->image_path
                                            );
                                        } elseif (!empty($service->image)) {
                                            $serviceImage = asset(
                                                'storage/' . $service->image
                                            );
                                        }

                                        $servicePrice = (float) (
                                            $service->starting_price
                                            ?? $service->price
                                            ?? 0
                                        );

                                        $serviceCategoryName = $service->category?->name
                                            ?? null;

                                        $serviceRating = (float) (
                                            $service->rating
                                            ?? 0
                                        );

                                        $serviceOrders = (int) (
                                            $service->orders_count
                                            ?? 0
                                        );
                                    @endphp


                                    <a
                                        href="{{ route('marketplace.service', $service->slug) }}"
                                        class="group flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-md sm:flex-row"
                                    >

                                        {{-- Image --}}
                                        <div class="h-44 w-full shrink-0 overflow-hidden rounded-xl bg-[#EFF6FF] sm:h-32 sm:w-44">

                                            @if ($serviceImage)

                                                <img
                                                    src="{{ $serviceImage }}"
                                                    alt="{{ $serviceTitle }}"
                                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                                >

                                            @else

                                                <div class="flex h-full w-full items-center justify-center">

                                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-[#2563EB] shadow-sm">
                                                        <i class="bi bi-briefcase text-xl"></i>
                                                    </div>

                                                </div>

                                            @endif

                                        </div>


                                        {{-- Information --}}
                                        <div class="flex min-w-0 flex-1 flex-col justify-between">

                                            <div>

                                                <div class="mb-2 flex flex-wrap items-center gap-2">

                                                    @if ($serviceCategoryName)

                                                        <span class="rounded-full bg-[#EFF6FF] px-2.5 py-1 text-[11px] font-semibold text-[#2563EB]">
                                                            {{ $serviceCategoryName }}
                                                        </span>

                                                    @endif


                                                    @if ($service->is_featured ?? false)

                                                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700">
                                                            Pilihan
                                                        </span>

                                                    @endif

                                                </div>


                                                <h3 class="line-clamp-2 text-base font-bold leading-6 text-[#0F172A] transition group-hover:text-[#2563EB]">
                                                    {{ $serviceTitle }}
                                                </h3>


                                                @if (!empty($service->short_description))

                                                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">
                                                        {{ $service->short_description }}
                                                    </p>

                                                @elseif (!empty($service->description))

                                                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">
                                                        {{ Str::limit(strip_tags($service->description), 140) }}
                                                    </p>

                                                @endif

                                            </div>


                                            <div class="mt-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">

                                                <div class="flex items-center gap-3 text-xs text-slate-500">

                                                    @if ($serviceRating > 0)

                                                        <span class="inline-flex items-center gap-1">

                                                            <i class="bi bi-star-fill text-[#F59E0B]"></i>

                                                            {{ number_format($serviceRating, 1) }}

                                                        </span>

                                                    @elseif ($rating > 0)

                                                        <span class="inline-flex items-center gap-1">

                                                            <i class="bi bi-star-fill text-[#F59E0B]"></i>

                                                            {{ number_format($rating, 1) }}

                                                        </span>

                                                    @endif


                                                    @if ($serviceOrders > 0)

                                                        <span class="inline-flex items-center gap-1">

                                                            <i class="bi bi-check2-circle"></i>

                                                            {{ number_format($serviceOrders) }} pesanan

                                                        </span>

                                                    @endif

                                                </div>


                                                <div class="text-left sm:text-right">

                                                    <p class="text-[11px] font-medium text-slate-400">
                                                        Mulai dari
                                                    </p>

                                                    <p class="text-lg font-bold text-[#2563EB]">

                                                        @if ($servicePrice > 0)

                                                            Rp{{ number_format($servicePrice, 0, ',', '.') }}

                                                        @else

                                                            Hubungi

                                                        @endif

                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </a>

                                @empty

                                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EFF6FF] text-[#2563EB]">

                                            <i class="bi bi-briefcase text-xl"></i>

                                        </div>

                                        <h3 class="mt-4 text-base font-bold text-slate-800">
                                            Belum ada layanan
                                        </h3>

                                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                                            Freelancer ini belum mempublikasikan layanan.
                                        </p>

                                    </div>

                                @endforelse

                            </div>


                            {{-- ================================================= --}}
                            {{-- REVIEW --}}
                            {{-- ================================================= --}}

                            <div class="mt-12 border-t border-slate-200 pt-10">

                                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                                    <div>

                                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#2563EB]">
                                            Client feedback
                                        </p>

                                        <h2 class="mt-1 text-xl font-bold text-[#0F172A]">
                                            Review Klien
                                        </h2>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Pengalaman klien setelah menggunakan layanan.
                                        </p>

                                    </div>


                                    <div class="inline-flex items-center gap-2 text-sm">

                                        <i class="bi bi-star-fill text-[#F59E0B]"></i>

                                        <strong class="text-slate-800">
                                            {{ number_format($rating, 1) }}
                                        </strong>

                                        <span class="text-slate-500">
                                            {{ number_format($reviewCount) }} review
                                        </span>

                                    </div>

                                </div>


                                <div class="space-y-4">

                                    @forelse ($reviews as $review)

                                        @php
                                            $reviewClient = $review->client ?? null;

                                            $reviewClientName = $reviewClient?->name
                                                ?? 'Client';

                                            $reviewAvatar = null;

                                            if ($reviewClient?->profile?->avatar) {
                                                $reviewAvatar = asset(
                                                    'storage/' . $reviewClient->profile->avatar
                                                );
                                            } elseif ($reviewClient?->avatar) {
                                                $reviewAvatar = asset(
                                                    'storage/' . $reviewClient->avatar
                                                );
                                            }

                                            $reviewRating = (int) (
                                                $review->rating
                                                ?? 0
                                            );

                                            $reviewComment = $review->comment
                                                ?? $review->review
                                                ?? $review->message
                                                ?? null;
                                        @endphp


                                        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                                            <div class="flex items-start justify-between gap-4">

                                                <div class="flex min-w-0 items-center gap-3">

                                                    <div class="h-11 w-11 shrink-0 overflow-hidden rounded-full bg-[#EFF6FF]">

                                                        @if ($reviewAvatar)

                                                            <img
                                                                src="{{ $reviewAvatar }}"
                                                                alt="{{ $reviewClientName }}"
                                                                class="h-full w-full object-cover"
                                                            >

                                                        @else

                                                            <div class="flex h-full w-full items-center justify-center text-sm font-bold text-[#2563EB]">
                                                                {{ strtoupper(substr($reviewClientName, 0, 1)) }}
                                                            </div>

                                                        @endif

                                                    </div>


                                                    <div class="min-w-0">

                                                        <p class="truncate text-sm font-bold text-slate-800">
                                                            {{ $reviewClientName }}
                                                        </p>


                                                        <div class="mt-1 flex items-center gap-1">

                                                            @for ($star = 1; $star <= 5; $star++)

                                                                <i class="bi bi-star-fill text-xs {{ $star <= $reviewRating ? 'text-[#F59E0B]' : 'text-slate-200' }}"></i>

                                                            @endfor

                                                        </div>

                                                    </div>

                                                </div>


                                                @if ($review->created_at ?? false)

                                                    <span class="shrink-0 text-xs text-slate-400">
                                                        {{ $review->created_at->diffForHumans() }}
                                                    </span>

                                                @endif

                                            </div>


                                            @if ($reviewComment)

                                                <p class="mt-4 text-sm leading-7 text-slate-600">
                                                    “{{ $reviewComment }}”
                                                </p>

                                            @endif

                                        </article>

                                    @empty

                                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">

                                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EFF6FF] text-[#2563EB]">

                                                <i class="bi bi-chat-quote text-xl"></i>

                                            </div>


                                            <h3 class="mt-4 text-base font-bold text-slate-800">
                                                Belum ada review
                                            </h3>


                                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                                                Review dari klien akan tampil di sini setelah tersedia.
                                            </p>

                                        </div>

                                    @endforelse

                                </div>

                            </div>

                        </section>


                        {{-- ================================================= --}}
                        {{-- PANEL 2: PENGALAMAN --}}
                        {{-- ================================================= --}}

                        <section
                            data-profile-panel
                            class="w-1/2 shrink-0"
                        >

                            <div class="mb-6">

                                <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#2563EB]">
                                    Profile
                                </p>

                                <h2 class="mt-1 text-xl font-bold text-[#0F172A] sm:text-2xl">
                                    Pengalaman
                                </h2>

                                <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
                                    Latar belakang profesional dan informasi lengkap freelancer.
                                </p>

                            </div>


                            {{-- ================================================= --}}
                            {{-- TENTANG SAYA --}}
                            {{-- ================================================= --}}

                            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                        <i class="bi bi-person text-lg"></i>
                                    </div>


                                    <div>

                                        <h3 class="text-base font-bold text-slate-800">
                                            Tentang Saya
                                        </h3>

                                        <p class="text-xs text-slate-500">
                                            Profil singkat freelancer
                                        </p>

                                    </div>

                                </div>


                                @if (!empty($freelancerProfile->bio))

                                    <div class="mt-5 text-sm leading-7 text-slate-600">
                                        {!! nl2br(e($freelancerProfile->bio)) !!}
                                    </div>

                                @else

                                    <p class="mt-5 text-sm leading-7 text-slate-500">
                                        Freelancer belum menambahkan deskripsi profil.
                                    </p>

                                @endif


                                <div class="mt-6 grid gap-4 sm:grid-cols-2">

                                    @if (!empty($freelancerProfile->location))

                                        <div class="rounded-xl bg-[#F8FAFC] p-4">

                                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">

                                                <i class="bi bi-geo-alt"></i>

                                                Lokasi

                                            </div>

                                            <p class="mt-2 text-sm font-semibold text-slate-700">
                                                {{ $freelancerProfile->location }}
                                            </p>

                                        </div>

                                    @endif


                                    <div class="rounded-xl bg-[#F8FAFC] p-4">

                                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">

                                            <span class="h-2 w-2 rounded-full {{ $isAvailable ? 'bg-[#16A34A]' : 'bg-slate-300' }}"></span>

                                            Status

                                        </div>

                                        <p class="mt-2 text-sm font-semibold {{ $isAvailable ? 'text-[#16A34A]' : 'text-slate-700' }}">
                                            {{ $isAvailable ? 'Tersedia untuk pekerjaan' : 'Sedang tidak tersedia' }}
                                        </p>

                                    </div>


                                    @if (!empty($freelancerProfile->website))

                                        <div class="rounded-xl bg-[#F8FAFC] p-4 sm:col-span-2">

                                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">

                                                <i class="bi bi-globe2"></i>

                                                Website

                                            </div>


                                            <a
                                                href="{{ Str::startsWith($freelancerProfile->website, ['http://', 'https://'])
                                                    ? $freelancerProfile->website
                                                    : 'https://' . $freelancerProfile->website }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="mt-2 inline-flex items-center gap-2 text-sm font-semibold text-[#2563EB] hover:underline"
                                            >

                                                {{ $freelancerProfile->website }}

                                                <i class="bi bi-box-arrow-up-right text-xs"></i>

                                            </a>

                                        </div>

                                    @endif

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- PENGALAMAN KERJA --}}
                            {{-- ================================================= --}}

                            <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">

                                        <i class="bi bi-briefcase text-lg"></i>

                                    </div>


                                    <div>

                                        <h3 class="text-base font-bold text-slate-800">
                                            Pengalaman Kerja
                                        </h3>

                                        <p class="text-xs text-slate-500">
                                            Riwayat profesional
                                        </p>

                                    </div>

                                </div>


                                <div class="mt-6">

                                    @forelse ($experiences as $experience)

                                        <div class="relative pl-8 {{ !$loop->last ? 'pb-8' : '' }}">

                                            @if (!$loop->last)

                                                <div class="absolute bottom-0 left-[7px] top-5 w-px bg-slate-200"></div>

                                            @endif


                                            <div class="absolute left-0 top-1 h-4 w-4 rounded-full border-4 border-[#DBEAFE] bg-[#2563EB]"></div>


                                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between sm:gap-4">

                                                <div>

                                                    <h4 class="text-sm font-bold text-slate-800 sm:text-base">
                                                        {{ $experience->position ?? '-' }}
                                                    </h4>


                                                    @if (!empty($experience->company))

                                                        <p class="mt-1 text-sm font-medium text-[#2563EB]">
                                                            {{ $experience->company }}
                                                        </p>

                                                    @endif

                                                </div>


                                                @if (
                                                    !empty($experience->start_year)
                                                    || !empty($experience->end_year)
                                                )

                                                    <span class="shrink-0 text-xs font-medium text-slate-400">

                                                        {{ $experience->start_year ?? '-' }}

                                                        -

                                                        {{ $experience->end_year ?? 'Sekarang' }}

                                                    </span>

                                                @endif

                                            </div>


                                            @if (!empty($experience->description))

                                                <p class="mt-3 text-sm leading-7 text-slate-600">

                                                    {!! nl2br(e($experience->description)) !!}

                                                </p>

                                            @endif

                                        </div>

                                    @empty

                                        <div class="rounded-xl bg-[#F8FAFC] px-5 py-8 text-center">

                                            <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm">
                                                <i class="bi bi-briefcase"></i>
                                            </div>

                                            <p class="mt-3 text-sm text-slate-500">
                                                Belum ada pengalaman kerja yang ditambahkan.
                                            </p>

                                        </div>

                                    @endforelse

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- PENDIDIKAN --}}
                            {{-- ================================================= --}}

                            <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                        <i class="bi bi-mortarboard text-lg"></i>
                                    </div>


                                    <div>

                                        <h3 class="text-base font-bold text-slate-800">
                                            Pendidikan
                                        </h3>

                                        <p class="text-xs text-slate-500">
                                            Latar belakang pendidikan
                                        </p>

                                    </div>

                                </div>


                                <div class="mt-6 space-y-4">

                                    @forelse ($educations as $education)

                                        <div class="rounded-xl bg-[#F8FAFC] p-4">

                                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                                <div>

                                                    <h4 class="text-sm font-bold text-slate-800">

                                                        {{ $education->institution ?? '-' }}

                                                    </h4>


                                                    @if (!empty($education->field_of_study))

                                                        <p class="mt-1 text-sm text-[#2563EB]">
                                                            {{ $education->field_of_study }}
                                                        </p>

                                                    @endif

                                                </div>


                                                @if (
                                                    !empty($education->start_year)
                                                    || !empty($education->end_year)
                                                )

                                                    <span class="text-xs font-medium text-slate-400">

                                                        {{ $education->start_year ?? '-' }}

                                                        -

                                                        {{ $education->end_year ?? 'Sekarang' }}

                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                    @empty

                                        <div class="rounded-xl bg-[#F8FAFC] px-5 py-8 text-center">

                                            <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm">
                                                <i class="bi bi-mortarboard"></i>
                                            </div>

                                            <p class="mt-3 text-sm text-slate-500">
                                                Belum ada data pendidikan.
                                            </p>

                                        </div>

                                    @endforelse

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- SKILL + BAHASA --}}
                            {{-- ================================================= --}}

                            <div class="mt-6 grid gap-6 md:grid-cols-2">


                                {{-- SKILLS --}}
                                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">

                                            <i class="bi bi-stars text-lg"></i>

                                        </div>


                                        <div>

                                            <h3 class="text-base font-bold text-slate-800">
                                                Keahlian
                                            </h3>

                                            <p class="text-xs text-slate-500">
                                                Skill yang dikuasai
                                            </p>

                                        </div>

                                    </div>


                                    <div class="mt-5 flex flex-wrap gap-2">

                                        @forelse ($skills as $skill)

                                            @php
                                                $skillName = is_string($skill)
                                                    ? $skill
                                                    : (
                                                        $skill->name
                                                        ?? $skill->skill_name
                                                        ?? null
                                                    );
                                            @endphp


                                            @if ($skillName)

                                                <span class="rounded-full bg-[#EFF6FF] px-3 py-2 text-xs font-semibold text-[#2563EB]">
                                                    {{ $skillName }}
                                                </span>

                                            @endif

                                        @empty

                                            <p class="text-sm text-slate-500">
                                                Belum ada keahlian yang ditambahkan.
                                            </p>

                                        @endforelse

                                    </div>

                                </div>


                                {{-- LANGUAGES --}}
                                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">

                                            <i class="bi bi-translate text-lg"></i>

                                        </div>


                                        <div>

                                            <h3 class="text-base font-bold text-slate-800">
                                                Bahasa
                                            </h3>

                                            <p class="text-xs text-slate-500">
                                                Bahasa yang digunakan
                                            </p>

                                        </div>

                                    </div>


                                    <div class="mt-5 space-y-3">

                                        @forelse ($languages as $language)

                                            @php
                                                $languageName = is_string($language)
                                                    ? $language
                                                    : (
                                                        $language->name
                                                        ?? $language->language_name
                                                        ?? null
                                                    );

                                                $languageLevel = is_string($language)
                                                    ? null
                                                    : (
                                                        $language->level
                                                        ?? $language->proficiency
                                                        ?? null
                                                    );
                                            @endphp


                                            @if ($languageName)

                                                <div class="flex items-center justify-between gap-4 rounded-xl bg-[#F8FAFC] px-4 py-3">

                                                    <span class="text-sm font-semibold text-slate-700">
                                                        {{ $languageName }}
                                                    </span>


                                                    @if ($languageLevel)

                                                        <span class="text-xs font-medium text-slate-400">
                                                            {{ $languageLevel }}
                                                        </span>

                                                    @endif

                                                </div>

                                            @endif

                                        @empty

                                            <p class="text-sm text-slate-500">
                                                Belum ada bahasa yang ditambahkan.
                                            </p>

                                        @endforelse

                                    </div>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- CERTIFICATES --}}
                            {{-- ================================================= --}}

                            <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">

                                        <i class="bi bi-award text-lg"></i>

                                    </div>


                                    <div>

                                        <h3 class="text-base font-bold text-slate-800">
                                            Sertifikat
                                        </h3>

                                        <p class="text-xs text-slate-500">
                                            Sertifikasi dan pencapaian
                                        </p>

                                    </div>

                                </div>


                                <div class="mt-6 grid gap-4 md:grid-cols-2">

                                    @forelse ($certificates as $certificate)

                                        <div class="rounded-xl bg-[#F8FAFC] p-4">

                                            <div class="flex items-start gap-3">

                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">

                                                    <i class="bi bi-patch-check"></i>

                                                </div>


                                                <div class="min-w-0">

                                                    <h4 class="text-sm font-bold text-slate-800">

                                                        {{ $certificate->name ?? '-' }}

                                                    </h4>


                                                    @if (!empty($certificate->issuer))

                                                        <p class="mt-1 text-xs text-slate-500">
                                                            {{ $certificate->issuer }}
                                                        </p>

                                                    @endif


                                                    @if (!empty($certificate->issued_year))

                                                        <p class="mt-2 text-xs font-medium text-[#2563EB]">
                                                            {{ $certificate->issued_year }}
                                                        </p>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                    @empty

                                        <div class="md:col-span-2 rounded-xl bg-[#F8FAFC] px-5 py-8 text-center">

                                            <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm">

                                                <i class="bi bi-award"></i>

                                            </div>

                                            <p class="mt-3 text-sm text-slate-500">
                                                Belum ada sertifikat yang ditambahkan.
                                            </p>

                                        </div>

                                    @endforelse

                                </div>

                            </div>

                        </section>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- SIDEBAR --}}
            {{-- ================================================= --}}

            <aside class="hidden lg:block">

                <div class="sticky top-[125px] space-y-4">


                    {{-- CONTACT --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Mulai bekerja bersama
                        </p>


                        <h3 class="mt-2 text-lg font-bold text-slate-800">
                            Butuh bantuan untuk project?
                        </h3>


                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Hubungi freelancer untuk mendiskusikan kebutuhan project sebelum memesan layanan.
                        </p>


                        <div class="mt-5">

                            @if ($isOwner)

                                <a
                                    href="{{ route('freelancer.profile.edit') }}"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#2563EB] hover:text-[#2563EB]"
                                >

                                    <i class="bi bi-pencil"></i>

                                    Kelola Profil

                                </a>

                            @elseif ($isClient && $contactService)

                                <form
                                    method="POST"
                                    action="{{ route('client.messages.start', $contactService) }}"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#1D4ED8]"
                                    >

                                        <i class="bi bi-chat-dots"></i>

                                        Hubungi Freelancer

                                    </button>

                                </form>

                            @elseif (!$isClient)

                                <a
                                    href="{{ route('login') }}"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#1D4ED8]"
                                >

                                    <i class="bi bi-box-arrow-in-right"></i>

                                    Masuk untuk Menghubungi

                                </a>

                            @endif

                        </div>

                    </div>


                    {{-- QUICK INFORMATION --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <h3 class="text-sm font-bold text-slate-800">
                            Informasi Freelancer
                        </h3>


                        <div class="mt-4 space-y-4">


                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                    <i class="bi bi-briefcase"></i>
                                </div>


                                <div>

                                    <p class="text-xs text-slate-400">
                                        Layanan
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                        {{ number_format($serviceCount) }} layanan aktif
                                    </p>

                                </div>

                            </div>


                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                    <i class="bi bi-check2-circle"></i>
                                </div>


                                <div>

                                    <p class="text-xs text-slate-400">
                                        Pesanan
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                        {{ number_format($completedOrders) }} selesai
                                    </p>

                                </div>

                            </div>


                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                    <i class="bi bi-star"></i>
                                </div>


                                <div>

                                    <p class="text-xs text-slate-400">
                                        Rating
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                        {{ number_format($rating, 1) }} / 5
                                    </p>

                                </div>

                            </div>


                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                    <i class="bi bi-people"></i>
                                </div>


                                <div>

                                    <p class="text-xs text-slate-400">
                                        Klien
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                        {{ number_format($customerCount) }} klien
                                    </p>

                                </div>

                            </div>


                            <div class="border-t border-slate-100 pt-4">

                                <div class="flex items-center justify-between gap-3">

                                    <span class="text-xs text-slate-400">
                                        Status
                                    </span>


                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold {{ $isAvailable ? 'text-[#16A34A]' : 'text-slate-500' }}">

                                        <span class="h-2 w-2 rounded-full {{ $isAvailable ? 'bg-[#16A34A]' : 'bg-slate-300' }}"></span>

                                        {{ $isAvailable ? 'Tersedia' : 'Tidak tersedia' }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </div>

</section>


{{-- ========================================================= --}}
{{-- MOBILE CONTACT --}}
{{-- ========================================================= --}}

@if (!$isOwner)

    <div class="fixed bottom-0 left-0 right-0 z-30 border-t border-slate-200 bg-white/95 p-3 pb-[calc(env(safe-area-inset-bottom)+0.75rem)] backdrop-blur lg:hidden">

        <div class="mx-auto max-w-7xl">

            @if ($isClient && $contactService)

                <form
                    method="POST"
                    action="{{ route('client.messages.start', $contactService) }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8]"
                    >

                        <i class="bi bi-chat-dots"></i>

                        Hubungi Freelancer

                    </button>

                </form>

            @elseif (!$isClient)

                <a
                    href="{{ route('login') }}"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8]"
                >

                    <i class="bi bi-box-arrow-in-right"></i>

                    Masuk untuk Menghubungi

                </a>

            @endif

        </div>

    </div>

@endif


{{-- ========================================================= --}}
{{-- TAB ANIMATION --}}
{{-- ========================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = Array.from(
            document.querySelectorAll('[data-profile-tab]')
        );

        const track = document.querySelector(
            '[data-profile-track]'
        );

        const heightWrapper = document.querySelector(
            '[data-profile-height]'
        );

        const panels = Array.from(
            document.querySelectorAll('[data-profile-panel]')
        );

        if (
            !tabs.length ||
            !track ||
            !heightWrapper ||
            !panels.length
        ) {
            return;
        }


        let activeIndex = 0;


        function updateHeight() {
            const activePanel = panels[activeIndex];

            if (!activePanel) {
                return;
            }

            heightWrapper.style.height =
                activePanel.offsetHeight + 'px';
        }


        function activateTab(index) {
            if (
                index < 0 ||
                index >= panels.length
            ) {
                return;
            }


            activeIndex = index;


            if (activeIndex === 0) {
                track.style.transform =
                    'translate3d(0, 0, 0)';
            } else {
                track.style.transform =
                    'translate3d(-50%, 0, 0)';
            }


            tabs.forEach(function (tab, tabIndex) {
                const isActive =
                    tabIndex === activeIndex;

                tab.classList.toggle(
                    'is-active',
                    isActive
                );

                if (isActive) {
                    tab.classList.remove(
                        'text-slate-500'
                    );

                    tab.classList.add(
                        'text-[#2563EB]'
                    );
                } else {
                    tab.classList.remove(
                        'text-[#2563EB]'
                    );

                    tab.classList.add(
                        'text-slate-500'
                    );
                }
            });


            updateHeight();


            window.setTimeout(
                updateHeight,
                200
            );

            window.setTimeout(
                updateHeight,
                550
            );
        }


        tabs.forEach(function (tab, index) {
            tab.addEventListener(
                'click',
                function (event) {
                    event.preventDefault();
                    activateTab(index);
                }
            );
        });


        window.addEventListener(
            'resize',
            updateHeight
        );


        window.setTimeout(
            updateHeight,
            100
        );


        activateTab(0);
    });
</script>


</x-layouts.marketplace>
