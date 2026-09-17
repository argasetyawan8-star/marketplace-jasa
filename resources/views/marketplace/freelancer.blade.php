<x-layouts.marketplace title="{{ $freelancerProfile->user?->name ?? 'Freelancer' }} - JASAIN">

    <style>
        @keyframes jasainPublicProfileIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .jasain-public-profile-in {
            animation: jasainPublicProfileIn .45s ease-out both;
        }

        .jasain-public-profile-delay {
            animation-delay: .08s;
        }

        .jasain-public-profile-delay-2 {
            animation-delay: .16s;
        }

        .jasain-service-card {
            transition:
                transform .22s ease,
                border-color .22s ease,
                background-color .22s ease;
        }

        .jasain-service-card:hover {
            transform: translateY(-1px);
            border-color: #C6DFCF;
            background-color: #FCFEFD;
        }

        .jasain-service-image {
            transition: transform .35s ease;
        }

        .jasain-service-card:hover .jasain-service-image {
            transform: scale(1.035);
        }

        .jasain-profile-tab {
            transition:
                color .2s ease,
                background-color .2s ease;
        }

        .jasain-profile-tab:hover {
            color: #0F6B3A;
            background-color: #F5F9F6;
        }

        @media (prefers-reduced-motion: reduce) {
            .jasain-public-profile-in {
                animation: none;
            }

            .jasain-service-card,
            .jasain-service-image,
            .jasain-profile-tab {
                transition: none;
            }
        }
    </style>


    @php
        $user = $freelancerProfile->user;

        $freelancerName = $user?->name
            ?? $freelancerProfile->username
            ?? 'Freelancer';

        $initial = strtoupper(
            mb_substr($freelancerName, 0, 1)
        );

        $avatarUrl = $freelancerProfile->avatar
            ? asset('storage/' . $freelancerProfile->avatar)
            : null;

        $coverUrl = $freelancerProfile->cover_image
            ? asset('storage/' . $freelancerProfile->cover_image)
            : null;

        $services = $freelancerProfile->services ?? collect();

        $reviews = $freelancerProfile->reviews ?? collect();

        $experiences = $freelancerProfile->experiences ?? collect();

        $educations = $freelancerProfile->educations ?? collect();

        $certificates = $freelancerProfile->certificates ?? collect();

        $skills = $freelancerProfile->skills ?? collect();

        $languages = $freelancerProfile->languages ?? collect();

        $rating = (float) ($freelancerProfile->rating ?? 0);

        $completedOrders = (int) ($freelancerProfile->completed_orders ?? 0);

        $isAvailable = (bool) ($freelancerProfile->is_available ?? false);

        $isClient = auth()->check()
            && auth()->user()->role === 'client';

        $isOwner = auth()->check()
            && $freelancerProfile->user_id === auth()->id();

        $customerCount = (int) ($freelancerProfile->customer_count ?? 0);

        $rehiredCount = (int) ($freelancerProfile->rehired_count ?? 0);
    @endphp


    {{-- =========================================================
        BREADCRUMB
    ========================================================== --}}

    <section class="border-b border-[#E5ECE8] bg-[#F8FCF9] pt-[92px] sm:pt-[100px]">

        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">

            <div class="flex flex-wrap items-center gap-2 text-[11px] text-[#8C9A94] sm:text-xs">

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

                <i class="bi bi-chevron-right text-[8px]"></i>

                <span class="font-medium text-[#556960]">
                    Profil Freelancer
                </span>

            </div>

        </div>

    </section>


    {{-- =========================================================
        MAIN PROFILE WRAPPER
    ========================================================== --}}

    <main class="bg-[#F8FCF9]">

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            <div class="jasain-public-profile-in overflow-hidden rounded-[26px] border border-[#DDE9E2] bg-white">


                {{-- =================================================
                    COVER
                ================================================== --}}

                <div class="relative h-48 overflow-hidden bg-[#EAF7EF] sm:h-60">

                    @if ($coverUrl)

                        <img
                            src="{{ $coverUrl }}"
                            alt="Cover {{ $freelancerName }}"
                            class="h-full w-full object-cover"
                        >

                    @else

                        <div class="relative h-full w-full bg-[#EAF7EF]">

                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_12%_24%,rgba(34,197,94,.12),transparent_26%),radial-gradient(circle_at_82%_20%,rgba(15,107,58,.09),transparent_25%),radial-gradient(circle_at_56%_100%,rgba(122,216,181,.14),transparent_29%)]"></div>

                            <div class="absolute bottom-5 left-5 text-[10px] font-semibold uppercase tracking-[.16em] text-[#0F6B3A]/35 sm:left-8">
                                JASAIN
                            </div>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    PROFILE HEADER
                ================================================== --}}

                <div class="relative px-5 pb-7 sm:px-8 sm:pb-8 lg:px-10">

                    <div class="-mt-16 sm:-mt-16">

                        {{-- Avatar --}}
                        <div class="flex h-32 w-32 items-center justify-center overflow-hidden rounded-full border-4 border-white bg-[#EAF7EF] shadow-sm sm:h-36 sm:w-36">

                            @if ($avatarUrl)

                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="{{ $freelancerName }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                <span class="text-4xl font-semibold text-[#0F6B3A]">
                                    {{ $initial }}
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="mt-5 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

                        {{-- Identity --}}
                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <h1 class="text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                                    {{ $freelancerName }}
                                </h1>

                                @if ($freelancerProfile->is_verified)

                                    <span class="inline-flex items-center gap-1 rounded-full bg-[#EAF7EF] px-2.5 py-1 text-[10px] font-semibold text-[#0F6B3A]">
                                        <i class="bi bi-patch-check-fill"></i>
                                        Terverifikasi
                                    </span>

                                @endif

                            </div>


                            @if ($freelancerProfile->username)

                                <p class="mt-1 text-sm text-[#8A9B94]">
                                    {{ '@' . $freelancerProfile->username }}
                                </p>

                            @endif


                            <p class="mt-3 max-w-3xl text-sm leading-6 text-[#667D73] sm:text-[15px]">
                                {{ $freelancerProfile->headline ?: 'Freelancer profesional siap membantu kebutuhanmu.' }}
                            </p>


                            <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#71837B]">

                                <span class="inline-flex items-center gap-1.5">

                                    <i class="bi bi-star-fill text-[#F2B93B]"></i>

                                    <span class="font-semibold text-[#40564C]">
                                        {{ number_format($rating, 1) }}
                                    </span>

                                    <span>
                                        ({{ $reviews->count() }} review)
                                    </span>

                                </span>


                                <span class="inline-flex items-center gap-1.5">

                                    <i class="bi bi-check2-circle text-[#1E9E5A]"></i>

                                    {{ number_format($completedOrders) }} pesanan selesai

                                </span>


                                @if ($freelancerProfile->location)

                                    <span class="inline-flex items-center gap-1.5">

                                        <i class="bi bi-geo-alt text-[#1E9E5A]"></i>

                                        {{ $freelancerProfile->location }}

                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Action --}}
                        <div class="shrink-0">

                            @if ($isOwner)

                                <a
                                    href="{{ route('freelancer.profile.edit') }}"
                                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#1E9E5A] sm:w-auto"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                    Edit profil
                                </a>

                            @elseif ($isClient)

                                <a
                                    href="{{ route('client.messages.start', $freelancerProfile->id) }}"
                                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#1E9E5A] sm:w-auto"
                                >
                                    <i class="bi bi-chat-dots"></i>
                                    Hubungi freelancer
                                </a>

                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#1E9E5A] sm:w-auto"
                                >
                                    <i class="bi bi-chat-dots"></i>
                                    Hubungi freelancer
                                </a>

                            @endif

                        </div>

                    </div>


                    {{-- Availability --}}
                    <div class="mt-6 border-t border-[#E7EFEB] pt-5">

                        @if ($isAvailable)

                            <span class="inline-flex items-center gap-2 text-xs font-medium text-[#0F6B3A]">

                                <span class="h-2 w-2 rounded-full bg-[#1E9E5A]"></span>

                                Freelancer sedang tersedia

                            </span>

                        @else

                            <span class="inline-flex items-center gap-2 text-xs font-medium text-[#899892]">

                                <span class="h-2 w-2 rounded-full bg-[#AAB7B0]"></span>

                                Freelancer sedang offline

                            </span>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    STATS
                ================================================== --}}

                <div class="border-t border-[#E7EFEB]">

                    <div class="grid grid-cols-2 sm:grid-cols-4">

                        <div class="border-b border-r border-[#EDF2EF] px-5 py-5 sm:border-b-0">

                            <div class="text-[10px] font-medium uppercase tracking-[.08em] text-[#96A39E]">
                                Pesanan
                            </div>

                            <div class="mt-1.5 text-xl font-semibold text-[#123128]">
                                {{ number_format($completedOrders) }}
                            </div>

                        </div>


                        <div class="border-b border-[#EDF2EF] px-5 py-5 sm:border-b-0 sm:border-r">

                            <div class="text-[10px] font-medium uppercase tracking-[.08em] text-[#96A39E]">
                                Pelanggan
                            </div>

                            <div class="mt-1.5 text-xl font-semibold text-[#123128]">
                                {{ number_format($customerCount) }}
                            </div>

                        </div>


                        <div class="border-r border-[#EDF2EF] px-5 py-5">

                            <div class="text-[10px] font-medium uppercase tracking-[.08em] text-[#96A39E]">
                                Dipekerjakan ulang
                            </div>

                            <div class="mt-1.5 text-xl font-semibold text-[#123128]">
                                {{ number_format($rehiredCount) }}
                            </div>

                        </div>


                        <div class="px-5 py-5">

                            <div class="text-[10px] font-medium uppercase tracking-[.08em] text-[#96A39E]">
                                Rating
                            </div>

                            <div class="mt-1.5 flex items-center gap-1.5 text-xl font-semibold text-[#123128]">

                                {{ number_format($rating, 1) }}

                                <i class="bi bi-star-fill text-sm text-[#F2B93B]"></i>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    TABS
                ================================================== --}}

                <div class="border-y border-[#E7EFEB] bg-white">

                    <div class="flex items-center gap-1 overflow-x-auto px-4 sm:px-7 lg:px-9">

                        <a
                            href="#layanan"
                            class="jasain-profile-tab whitespace-nowrap rounded-lg px-3 py-3.5 text-xs font-semibold text-[#123128]"
                        >
                            Layanan
                        </a>

                        <a
                            href="#review"
                            class="jasain-profile-tab whitespace-nowrap rounded-lg px-3 py-3.5 text-xs font-medium text-[#667D73]"
                        >
                            Review
                        </a>

                        <a
                            href="#tentang"
                            class="jasain-profile-tab whitespace-nowrap rounded-lg px-3 py-3.5 text-xs font-medium text-[#667D73]"
                        >
                            Tentang
                        </a>

                        <a
                            href="#pengalaman"
                            class="jasain-profile-tab whitespace-nowrap rounded-lg px-3 py-3.5 text-xs font-medium text-[#667D73]"
                        >
                            Pengalaman
                        </a>

                        <a
                            href="#pendidikan"
                            class="jasain-profile-tab whitespace-nowrap rounded-lg px-3 py-3.5 text-xs font-medium text-[#667D73]"
                        >
                            Pendidikan
                        </a>

                        <a
                            href="#sertifikat"
                            class="jasain-profile-tab whitespace-nowrap rounded-lg px-3 py-3.5 text-xs font-medium text-[#667D73]"
                        >
                            Sertifikat
                        </a>

                    </div>

                </div>


                {{-- =================================================
                    CONTENT
                ================================================== --}}

                <div class="px-5 py-8 sm:px-8 lg:px-10">

                    <div class="max-w-5xl space-y-10">


                        {{-- =================================================
                            SERVICES
                        ================================================== --}}

                        <section
                            id="layanan"
                            class="scroll-mt-24"
                        >

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">

                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">
                                        Layanan
                                    </p>

                                    <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-[#123128] sm:text-2xl">
                                        Jasa yang ditawarkan
                                    </h2>

                                </div>

                                <span class="text-xs text-[#8A9A93]">
                                    {{ $services->count() }} layanan tersedia
                                </span>

                            </div>


                            {{-- SERVICE LIST --}}
                            @if ($services->count())

                                <div class="mt-5 divide-y divide-[#EDF2EF] border-y border-[#EDF2EF]">

                                    @foreach ($services as $service)

                                        @php
                                            $serviceThumbnail = $service->thumbnail
                                                ? asset('storage/' . $service->thumbnail)
                                                : null;

                                            $servicePrice = $service->starting_price
                                                ?? $service->price
                                                ?? 0;
                                        @endphp


                                        <a
                                            href="{{ route('marketplace.service', $service->slug) }}"
                                            class="jasain-service-card group flex gap-4 py-4 sm:gap-5 sm:py-5"
                                        >

                                            {{-- SMALL BANNER --}}
                                            <div class="relative h-[82px] w-[116px] shrink-0 overflow-hidden rounded-xl bg-[#EAF7EF] sm:h-[92px] sm:w-[132px]">

                                                @if ($serviceThumbnail)

                                                    <img
                                                        src="{{ $serviceThumbnail }}"
                                                        alt="{{ $service->title }}"
                                                        loading="lazy"
                                                        class="jasain-service-image h-full w-full object-cover"
                                                    >

                                                @else

                                                    <div class="flex h-full w-full items-center justify-center">

                                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">

                                                            <i class="bi bi-briefcase text-base"></i>

                                                        </div>

                                                    </div>

                                                @endif


                                                @if ($service->is_featured)

                                                    <span class="absolute left-2 top-2 inline-flex items-center gap-1 rounded-full bg-[#0F6B3A] px-2 py-1 text-[8px] font-semibold text-white">

                                                        <i class="bi bi-stars"></i>

                                                        Pilihan

                                                    </span>

                                                @endif

                                            </div>


                                            {{-- SERVICE INFORMATION --}}
                                            <div class="min-w-0 flex-1">

                                                <div class="flex items-start justify-between gap-4">

                                                    <div class="min-w-0">

                                                        <div class="flex flex-wrap items-center gap-2 text-[10px] text-[#899892]">

                                                            @if ($service->category)

                                                                <span class="truncate">
                                                                    {{ $service->category->name }}
                                                                </span>

                                                            @endif


                                                            @if ($service->subcategory)

                                                                <span>
                                                                    •
                                                                </span>

                                                                <span class="truncate">
                                                                    {{ $service->subcategory->name }}
                                                                </span>

                                                            @endif

                                                        </div>


                                                        <h3 class="mt-1.5 line-clamp-2 text-sm font-semibold leading-5 text-[#123128] transition group-hover:text-[#0F6B3A] sm:text-[15px]">

                                                            {{ $service->title }}

                                                        </h3>

                                                    </div>


                                                    {{-- PRICE --}}
                                                    <div class="hidden shrink-0 text-right sm:block">

                                                        <div class="text-[9px] text-[#96A39E]">
                                                            Mulai dari
                                                        </div>

                                                        <div class="mt-1 text-sm font-semibold text-[#0F6B3A]">
                                                            Rp {{ number_format((float) $servicePrice, 0, ',', '.') }}
                                                        </div>

                                                    </div>

                                                </div>


                                                {{-- META --}}
                                                <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1.5 text-[10px] text-[#8A9B94]">

                                                    @if ($service->delivery_days)

                                                        <span class="inline-flex items-center gap-1">

                                                            <i class="bi bi-clock"></i>

                                                            {{ $service->delivery_days }} hari

                                                        </span>

                                                    @endif


                                                    @if ($service->orders_count ?? false)

                                                        <span class="inline-flex items-center gap-1">

                                                            <i class="bi bi-bag-check"></i>

                                                            {{ $service->orders_count }} pesanan

                                                        </span>

                                                    @endif

                                                </div>


                                                {{-- MOBILE PRICE --}}
                                                <div class="mt-3 flex items-center justify-between sm:hidden">

                                                    <div>

                                                        <div class="text-[9px] text-[#96A39E]">
                                                            Mulai dari
                                                        </div>

                                                        <div class="mt-0.5 text-xs font-semibold text-[#0F6B3A]">
                                                            Rp {{ number_format((float) $servicePrice, 0, ',', '.') }}
                                                        </div>

                                                    </div>


                                                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-[#EAF7EF] text-[#0F6B3A]">

                                                        <i class="bi bi-arrow-up-right text-[10px]"></i>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- DESKTOP ARROW --}}
                                            <div class="hidden shrink-0 items-center sm:flex">

                                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#F2F8F4] text-[#0F6B3A] transition group-hover:bg-[#EAF7EF]">

                                                    <i class="bi bi-chevron-right text-[11px]"></i>

                                                </div>

                                            </div>

                                        </a>

                                    @endforeach

                                </div>

                            @else

                                <div class="mt-5 rounded-2xl border border-dashed border-[#CFDFD5] px-6 py-12 text-center">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F2F7F4] text-lg text-[#80958A]">

                                        <i class="bi bi-briefcase"></i>

                                    </div>

                                    <h3 class="mt-3 text-sm font-semibold text-[#123128]">
                                        Belum ada layanan
                                    </h3>

                                    <p class="mt-1.5 text-xs text-[#81918B]">
                                        Freelancer ini belum mempublikasikan layanan.
                                    </p>

                                </div>

                            @endif

                        </section>


                        {{-- =================================================
                            REVIEW
                        ================================================== --}}

                        <section
                            id="review"
                            class="scroll-mt-24 border-t border-[#E8EFEB] pt-10"
                        >

                            <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">
                                Review
                            </p>

                            <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-[#123128] sm:text-2xl">
                                Pengalaman pelanggan
                            </h2>


                            @if ($reviews->count())

                                <div class="mt-5 divide-y divide-[#EDF2EF] border-y border-[#EDF2EF]">

                                    @foreach ($reviews as $review)

                                        @php
                                            $reviewClient = $review->client;

                                            $reviewName = $reviewClient?->name ?? 'Client';

                                            $reviewAvatar = $reviewClient?->profile?->avatar
                                                ? asset('storage/' . $reviewClient->profile->avatar)
                                                : null;

                                            $reviewInitial = strtoupper(
                                                mb_substr($reviewName, 0, 1)
                                            );
                                        @endphp

                                        <article class="py-5">

                                            <div class="flex items-start gap-3">

                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A]">

                                                    @if ($reviewAvatar)

                                                        <img
                                                            src="{{ $reviewAvatar }}"
                                                            alt="{{ $reviewName }}"
                                                            class="h-full w-full object-cover"
                                                        >

                                                    @else

                                                        {{ $reviewInitial }}

                                                    @endif

                                                </div>


                                                <div class="min-w-0 flex-1">

                                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                                        <div>

                                                            <p class="text-sm font-semibold text-[#123128]">
                                                                {{ $reviewName }}
                                                            </p>

                                                            <p class="mt-1 text-[11px] text-[#8A9B94]">
                                                                {{ optional($review->created_at)->translatedFormat('d M Y') }}
                                                            </p>

                                                        </div>


                                                        <div class="flex items-center gap-1">

                                                            @for ($star = 1; $star <= 5; $star++)

                                                                <i class="bi bi-star-fill text-[11px] {{ $star <= (int) $review->rating ? 'text-[#F2B93B]' : 'text-[#DDE5DF]' }}"></i>

                                                            @endfor

                                                        </div>

                                                    </div>


                                                    @if ($review->comment)

                                                        <p class="mt-3 max-w-3xl text-sm leading-6 text-[#60746B]">
                                                            {{ $review->comment }}
                                                        </p>

                                                    @endif

                                                </div>

                                            </div>

                                        </article>

                                    @endforeach

                                </div>

                            @else

                                <div class="mt-5 rounded-2xl border border-dashed border-[#CFDFD5] px-6 py-10 text-center">

                                    <p class="text-sm text-[#81918B]">
                                        Belum ada review dari pelanggan.
                                    </p>

                                </div>

                            @endif

                        </section>


                        {{-- =================================================
                            ABOUT
                        ================================================== --}}

                        <section
                            id="tentang"
                            class="scroll-mt-24 border-t border-[#E8EFEB] pt-10"
                        >

                            <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">
                                Tentang freelancer
                            </p>

                            <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-[#123128] sm:text-2xl">
                                Tentang
                            </h2>


                            @if ($freelancerProfile->bio)

                                <div class="mt-5 max-w-4xl text-sm leading-7 text-[#60746B] sm:text-[15px]">
                                    {!! nl2br(e($freelancerProfile->bio)) !!}
                                </div>

                            @else

                                <p class="mt-5 text-sm text-[#81918B]">
                                    Freelancer ini belum menambahkan deskripsi profil.
                                </p>

                            @endif


                            <div class="mt-6 grid gap-5 border-t border-[#EDF2EF] pt-6 sm:grid-cols-2">

                                <div>

                                    <p class="text-[10px] font-medium uppercase tracking-[.08em] text-[#96A39E]">
                                        Lokasi
                                    </p>

                                    <p class="mt-1.5 flex items-center gap-2 text-sm font-medium text-[#40564C]">

                                        <i class="bi bi-geo-alt text-[#1E9E5A]"></i>

                                        {{ $freelancerProfile->location ?: 'Indonesia' }}

                                    </p>

                                </div>


                                <div>

                                    <p class="text-[10px] font-medium uppercase tracking-[.08em] text-[#96A39E]">
                                        Status
                                    </p>

                                    <p class="mt-1.5 flex items-center gap-2 text-sm font-medium {{ $isAvailable ? 'text-[#0F6B3A]' : 'text-[#7E8C86]' }}">

                                        <span class="h-2 w-2 rounded-full {{ $isAvailable ? 'bg-[#1E9E5A]' : 'bg-[#AAB6B0]' }}"></span>

                                        {{ $isAvailable ? 'Sedang menerima pekerjaan' : 'Sedang tidak menerima pekerjaan' }}

                                    </p>

                                </div>


                                @if ($freelancerProfile->website)

                                    <div class="sm:col-span-2">

                                        <p class="text-[10px] font-medium uppercase tracking-[.08em] text-[#96A39E]">
                                            Website
                                        </p>

                                        <a
                                            href="{{ $freelancerProfile->website }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="mt-1.5 inline-flex items-center gap-2 break-all text-sm font-medium text-[#0F6B3A] hover:text-[#1E9E5A]"
                                        >
                                            <i class="bi bi-globe2"></i>
                                            {{ $freelancerProfile->website }}
                                        </a>

                                    </div>

                                @endif

                            </div>

                        </section>


                        {{-- =================================================
                            EXPERIENCE
                        ================================================== --}}

                        <section
                            id="pengalaman"
                            class="scroll-mt-24 border-t border-[#E8EFEB] pt-10"
                        >

                            <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">
                                Riwayat profesional
                            </p>

                            <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-[#123128] sm:text-2xl">
                                Pengalaman
                            </h2>

                            <p class="mt-1.5 text-sm text-[#8A9B94]">
                                Pengalaman kerja dan aktivitas profesional freelancer.
                            </p>


                            @if ($experiences->count())

                                <div class="mt-6 divide-y divide-[#EDF2EF] border-y border-[#EDF2EF]">

                                    @foreach ($experiences as $experience)

                                        <article class="py-6">

                                            <div class="flex gap-4">

                                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">

                                                    <i class="bi bi-briefcase"></i>

                                                </div>


                                                <div class="min-w-0 flex-1">

                                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                                        <div>

                                                            <h3 class="text-base font-semibold text-[#123128]">
                                                                {{ $experience->position }}
                                                            </h3>


                                                            @if ($experience->company)

                                                                <p class="mt-1 text-sm font-medium text-[#5D7269]">
                                                                    {{ $experience->company }}
                                                                </p>

                                                            @endif

                                                        </div>


                                                        @if ($experience->start_year || $experience->end_year)

                                                            <span class="shrink-0 text-xs font-medium text-[#8A9B94]">

                                                                {{ $experience->start_year ?: '—' }}

                                                                -

                                                                {{ $experience->end_year ?: 'Sekarang' }}

                                                            </span>

                                                        @endif

                                                    </div>


                                                    @if ($experience->description)

                                                        <p class="mt-3 max-w-3xl text-sm leading-6 text-[#667D73]">
                                                            {!! nl2br(e($experience->description)) !!}
                                                        </p>

                                                    @endif

                                                </div>

                                            </div>

                                        </article>

                                    @endforeach

                                </div>

                            @else

                                <div class="mt-5 rounded-2xl border border-dashed border-[#CFDFD5] px-6 py-10 text-center">

                                    <p class="text-sm text-[#81918B]">
                                        Belum ada pengalaman yang ditambahkan.
                                    </p>

                                </div>

                            @endif

                        </section>


                        {{-- =================================================
                            EDUCATION
                        ================================================== --}}

                        <section
                            id="pendidikan"
                            class="scroll-mt-24 border-t border-[#E8EFEB] pt-10"
                        >

                            <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">
                                Pendidikan
                            </p>

                            <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-[#123128] sm:text-2xl">
                                Pendidikan
                            </h2>


                            @if ($educations->count())

                                <div class="mt-5 divide-y divide-[#EDF2EF] border-y border-[#EDF2EF]">

                                    @foreach ($educations as $education)

                                        <article class="py-5">

                                            <div class="flex gap-4">

                                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                                                    <i class="bi bi-mortarboard-fill"></i>
                                                </div>


                                                <div>

                                                    <h3 class="text-base font-semibold text-[#123128]">
                                                        {{ $education->institution }}
                                                    </h3>


                                                    @if ($education->field_of_study)

                                                        <p class="mt-1 text-sm text-[#60746B]">
                                                            {{ $education->field_of_study }}
                                                        </p>

                                                    @endif


                                                    @if ($education->start_year || $education->end_year)

                                                        <p class="mt-2 text-xs text-[#8A9B94]">
                                                            {{ $education->start_year ?: '—' }}
                                                            -
                                                            {{ $education->end_year ?: 'Sekarang' }}
                                                        </p>

                                                    @endif

                                                </div>

                                            </div>

                                        </article>

                                    @endforeach

                                </div>

                            @else

                                <p class="mt-5 text-sm text-[#81918B]">
                                    Belum ada pendidikan yang ditambahkan.
                                </p>

                            @endif

                        </section>


                        {{-- =================================================
                            CERTIFICATES
                        ================================================== --}}

                        <section
                            id="sertifikat"
                            class="scroll-mt-24 border-t border-[#E8EFEB] pt-10"
                        >

                            <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">
                                Kredensial
                            </p>

                            <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-[#123128] sm:text-2xl">
                                Sertifikat
                            </h2>


                            @if ($certificates->count())

                                <div class="mt-5 grid gap-4 sm:grid-cols-2">

                                    @foreach ($certificates as $certificate)

                                        <article class="border-b border-[#EDF2EF] pb-5 sm:border-b-0 sm:pb-0">

                                            <div class="flex gap-4">

                                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                                                    <i class="bi bi-award-fill"></i>
                                                </div>


                                                <div class="min-w-0">

                                                    <h3 class="text-sm font-semibold leading-5 text-[#123128]">
                                                        {{ $certificate->name }}
                                                    </h3>


                                                    @if ($certificate->issuer)

                                                        <p class="mt-1 text-xs text-[#667D73]">
                                                            {{ $certificate->issuer }}
                                                        </p>

                                                    @endif


                                                    @if ($certificate->year)

                                                        <p class="mt-2 text-[11px] text-[#8A9B94]">
                                                            {{ $certificate->year }}
                                                        </p>

                                                    @endif


                                                    @if ($certificate->credential_url)

                                                        <a
                                                            href="{{ $certificate->credential_url }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="mt-3 inline-flex items-center gap-1.5 text-[11px] font-semibold text-[#0F6B3A] hover:text-[#1E9E5A]"
                                                        >
                                                            Lihat kredensial
                                                            <i class="bi bi-box-arrow-up-right"></i>
                                                        </a>

                                                    @endif

                                                </div>

                                            </div>

                                        </article>

                                    @endforeach

                                </div>

                            @else

                                <p class="mt-5 text-sm text-[#81918B]">
                                    Belum ada sertifikat yang ditambahkan.
                                </p>

                            @endif

                        </section>


                        {{-- =================================================
                            SKILLS & LANGUAGES
                        ================================================== --}}

                        <section class="border-t border-[#E8EFEB] pt-10">

                            <div class="grid gap-8 lg:grid-cols-2">

                                {{-- Skills --}}
                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">
                                        Keahlian
                                    </p>

                                    <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-[#123128]">
                                        Keahlian
                                    </h2>


                                    @if ($skills->count())

                                        <div class="mt-5 flex flex-wrap gap-2">

                                            @foreach ($skills as $skill)

                                                <span class="inline-flex items-center gap-2 rounded-full border border-[#CEE2D6] bg-[#F8FCF9] px-3.5 py-2 text-xs font-medium text-[#355A4A]">

                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#22C55E]"></span>

                                                    {{ $skill->name }}

                                                </span>

                                            @endforeach

                                        </div>

                                    @else

                                        <p class="mt-5 text-sm text-[#81918B]">
                                            Belum ada keahlian yang ditambahkan.
                                        </p>

                                    @endif

                                </div>


                                {{-- Languages --}}
                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">
                                        Bahasa
                                    </p>

                                    <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-[#123128]">
                                        Bahasa
                                    </h2>


                                    @if ($languages->count())

                                        <div class="mt-5 space-y-2.5">

                                            @foreach ($languages as $language)

                                                <div class="flex items-center justify-between gap-4 border-b border-[#EDF2EF] pb-3 last:border-b-0">

                                                    <div class="flex items-center gap-3">

                                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#0F6B3A]">
                                                            <i class="bi bi-translate"></i>
                                                        </div>

                                                        <span class="text-sm font-medium text-[#40564C]">
                                                            {{ $language->language }}
                                                        </span>

                                                    </div>


                                                    @if ($language->level)

                                                        <span class="text-xs text-[#81918B]">
                                                            {{ $language->level }}
                                                        </span>

                                                    @endif

                                                </div>

                                            @endforeach

                                        </div>

                                    @else

                                        <p class="mt-5 text-sm text-[#81918B]">
                                            Belum ada bahasa yang ditambahkan.
                                        </p>

                                    @endif

                                </div>

                            </div>

                        </section>

                    </div>

                </div>

            </div>

        </div>

    </main>


    {{-- =========================================================
        FOOTER
    ========================================================== --}}

    <footer class="border-t border-[#E3ECE7] bg-white">

        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-6 text-xs text-[#81918B] sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">

            <span>
                © {{ date('Y') }} JASAIN
            </span>

            <span>
                Marketplace jasa untuk kebutuhan profesionalmu.
            </span>

        </div>

    </footer>

</x-layouts.marketplace>
