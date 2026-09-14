<x-layouts.marketplace title="{{ $freelancerProfile->user?->name ?? 'Freelancer' }} - JASAIN">

    <style>
        @keyframes jasainFreelancerUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .jasain-freelancer-up {
            animation: jasainFreelancerUp .45s ease-out both;
        }

        .jasain-freelancer-up-delay {
            animation: jasainFreelancerUp .45s .08s ease-out both;
        }

        .jasain-freelancer-up-delay-2 {
            animation: jasainFreelancerUp .45s .16s ease-out both;
        }

        @media (prefers-reduced-motion: reduce) {
            .jasain-freelancer-up,
            .jasain-freelancer-up-delay,
            .jasain-freelancer-up-delay-2 {
                animation: none;
            }
        }
    </style>


    @php
        $user = $freelancerProfile->user;

        $avatarUrl = $freelancerProfile->avatar
            ? asset('storage/' . $freelancerProfile->avatar)
            : null;

        $services = $freelancerProfile->services ?? collect();

        $rating = (float) ($freelancerProfile->rating ?? 0);
        $completedOrders = (int) ($freelancerProfile->completed_orders ?? 0);

        $isAvailable = (bool) ($freelancerProfile->is_available ?? false);

        $isClient = auth()->check() && auth()->user()->role === 'client';
        $isOwner = auth()->check() && $freelancerProfile->user_id === auth()->id();
    @endphp


    {{-- =========================================================
        HEADER / BREADCRUMB
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

                <i class="bi bi-chevron-right text-[8px]"></i>

                <span class="font-medium text-[#556960]">
                    Freelancer
                </span>

            </div>

        </div>

    </section>


    {{-- =========================================================
        PROFILE HEADER
    ========================================================== --}}
    <section class="bg-white">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

            <div
                class="jasain-freelancer-up overflow-hidden rounded-[24px] border border-[#E0EBE4] bg-[#F8FCF9]"
            >

                <div class="px-5 py-6 sm:px-7 sm:py-8 lg:px-9">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                        {{-- =================================================
                            PROFILE
                        ================================================== --}}
                        <div class="flex min-w-0 items-start gap-4 sm:gap-5">

                            @if ($avatarUrl)

                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="{{ $user?->name ?? $freelancerProfile->username }}"
                                    class="h-20 w-20 shrink-0 rounded-full object-cover ring-4 ring-white shadow-sm sm:h-24 sm:w-24"
                                >

                            @else

                                <div
                                    class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-[#D8F0E2] text-2xl font-semibold text-[#0F6B3A] ring-4 ring-white sm:h-24 sm:w-24 sm:text-3xl"
                                >
                                    {{ strtoupper(substr($user?->name ?? 'F', 0, 1)) }}
                                </div>

                            @endif


                            <div class="min-w-0">

                                {{-- Name --}}
                                <div class="flex flex-wrap items-center gap-2">

                                    <h1
                                        class="text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl"
                                    >
                                        {{ $user?->name ?? $freelancerProfile->username }}
                                    </h1>

                                    @if ($freelancerProfile->is_verified)

                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-[#EAF7EF] px-2.5 py-1 text-[10px] font-semibold text-[#0F6B3A]"
                                        >
                                            <i class="bi bi-patch-check-fill"></i>
                                            Terverifikasi
                                        </span>

                                    @endif

                                </div>


                                {{-- Username --}}
                                <div class="mt-1 text-sm text-[#899B94]">
                                    {{ '@' . $freelancerProfile->username }}
                                </div>


                                {{-- Headline --}}
                                <p
                                    class="mt-3 max-w-2xl text-sm leading-6 text-[#667D73] sm:text-[15px]"
                                >
                                    {{ $freelancerProfile->headline ?: 'Freelancer profesional siap membantu kebutuhanmu.' }}
                                </p>


                                {{-- Meta --}}
                                <div
                                    class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#71837B]"
                                >

                                    <span class="inline-flex items-center gap-1.5">
                                        <i class="bi bi-star-fill text-[#1E9E5A]"></i>
                                        {{ number_format($rating, 1) }}
                                    </span>


                                    <span class="inline-flex items-center gap-1.5">
                                        <i class="bi bi-check2-circle text-[#1E9E5A]"></i>
                                        {{ $completedOrders }} pesanan selesai
                                    </span>


                                    @if ($freelancerProfile->location)

                                        <span class="inline-flex items-center gap-1.5">
                                            <i class="bi bi-geo-alt text-[#1E9E5A]"></i>
                                            {{ $freelancerProfile->location }}
                                        </span>

                                    @endif


                                    @if ($freelancerProfile->website)

                                        <a
                                            href="{{ $freelancerProfile->website }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center gap-1.5 transition hover:text-[#0F6B3A]"
                                        >
                                            <i class="bi bi-globe2 text-[#1E9E5A]"></i>
                                            Website
                                        </a>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            RIGHT ACTION
                        ================================================== --}}
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

                            @elseif (!auth()->check())

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
                    <div class="mt-6 border-t border-[#E2ECE7] pt-5">

                        @if ($isAvailable)

                            <span
                                class="inline-flex items-center gap-2 text-xs font-medium text-[#0F6B3A]"
                            >
                                <span class="h-2 w-2 rounded-full bg-[#1E9E5A]"></span>
                                Freelancer sedang tersedia
                            </span>

                        @else

                            <span
                                class="inline-flex items-center gap-2 text-xs font-medium text-[#8A9892]"
                            >
                                <span class="h-2 w-2 rounded-full bg-[#AAB6B0]"></span>
                                Freelancer sedang offline
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}
    <main class="bg-[#F8FCF9]">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

            <div class="grid gap-8 lg:grid-cols-[minmax(0,0.82fr)_minmax(0,1.18fr)] lg:gap-10 xl:gap-12">


                {{-- =================================================
                    LEFT / ABOUT
                ================================================== --}}
                <section class="jasain-freelancer-up min-w-0">

                    <div class="rounded-2xl border border-[#E0EBE4] bg-white p-5 sm:p-6">

                        <div
                            class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1E9E5A]"
                        >
                            Tentang freelancer
                        </div>


                        <h2
                            class="mt-2 text-xl font-semibold tracking-tight text-[#123128]"
                        >
                            Profil & pengalaman
                        </h2>


                        <div
                            class="mt-5 text-sm leading-7 text-[#667D73] sm:text-[15px]"
                        >

                            @if ($freelancerProfile->bio)

                                {!! nl2br(e($freelancerProfile->bio)) !!}

                            @else

                                <p>
                                    Freelancer ini belum menambahkan deskripsi
                                    profil.
                                </p>

                            @endif

                        </div>

                    </div>


                    {{-- Profile stats --}}
                    <div class="mt-4 grid grid-cols-2 gap-3">

                        <div
                            class="rounded-2xl border border-[#E0EBE4] bg-white p-4"
                        >

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                            >
                                <i class="bi bi-star-fill"></i>
                            </div>

                            <div class="mt-4 text-xl font-semibold text-[#123128]">
                                {{ number_format($rating, 1) }}
                            </div>

                            <div class="mt-1 text-xs text-[#899B94]">
                                Rating
                            </div>

                        </div>


                        <div
                            class="rounded-2xl border border-[#E0EBE4] bg-white p-4"
                        >

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                            >
                                <i class="bi bi-check2-circle"></i>
                            </div>

                            <div class="mt-4 text-xl font-semibold text-[#123128]">
                                {{ $completedOrders }}
                            </div>

                            <div class="mt-1 text-xs text-[#899B94]">
                                Pesanan selesai
                            </div>

                        </div>

                    </div>


                    {{-- Additional info --}}
                    <div
                        class="mt-4 rounded-2xl border border-[#E0EBE4] bg-white p-5 sm:p-6"
                    >

                        <h2 class="text-base font-semibold text-[#123128]">
                            Informasi
                        </h2>


                        <div class="mt-4 space-y-3">

                            @if ($freelancerProfile->location)

                                <div
                                    class="flex items-start gap-3 text-sm"
                                >

                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#0F6B3A]"
                                    >
                                        <i class="bi bi-geo-alt"></i>
                                    </div>

                                    <div>
                                        <div class="text-[10px] text-[#8A9B94]">
                                            Lokasi
                                        </div>

                                        <div class="mt-0.5 text-sm text-[#40564C]">
                                            {{ $freelancerProfile->location }}
                                        </div>
                                    </div>

                                </div>

                            @endif


                            @if ($freelancerProfile->website)

                                <div
                                    class="flex items-start gap-3 text-sm"
                                >

                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#0F6B3A]"
                                    >
                                        <i class="bi bi-globe2"></i>
                                    </div>

                                    <div class="min-w-0">

                                        <div class="text-[10px] text-[#8A9B94]">
                                            Website
                                        </div>

                                        <a
                                            href="{{ $freelancerProfile->website }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="mt-0.5 block truncate text-sm text-[#0F6B3A] hover:text-[#1E9E5A]"
                                        >
                                            {{ $freelancerProfile->website }}
                                        </a>

                                    </div>

                                </div>

                            @endif


                            <div
                                class="flex items-start gap-3 text-sm"
                            >

                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#0F6B3A]"
                                >
                                    <i class="bi bi-clock"></i>
                                </div>

                                <div>

                                    <div class="text-[10px] text-[#8A9B94]">
                                        Status
                                    </div>

                                    <div
                                        class="mt-0.5 text-sm {{ $isAvailable ? 'text-[#0F6B3A]' : 'text-[#7E8C86]' }}"
                                    >
                                        {{ $isAvailable ? 'Sedang menerima pekerjaan' : 'Sedang tidak menerima pekerjaan' }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    RIGHT / SERVICES
                ================================================== --}}
                <section class="jasain-freelancer-up-delay min-w-0">

                    <div class="flex items-end justify-between gap-4">

                        <div>

                            <div
                                class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1E9E5A]"
                            >
                                Layanan
                            </div>

                            <h2
                                class="mt-2 text-xl font-semibold tracking-tight text-[#123128] sm:text-2xl"
                            >
                                Jasa yang ditawarkan
                            </h2>

                            <p class="mt-1 text-sm text-[#899B94]">
                                {{ $services->count() }} layanan tersedia
                            </p>

                        </div>


                        <a
                            href="{{ route('marketplace.search') }}"
                            class="hidden items-center gap-2 text-sm font-semibold text-[#0F6B3A] hover:text-[#1E9E5A] sm:inline-flex"
                        >
                            Cari jasa lain

                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>


                    {{-- Services grid --}}
                    <div
                        class="mt-5 grid gap-4 sm:grid-cols-2"
                    >

                        @forelse ($services as $service)

                            @php
                                $serviceThumbnail = $service->thumbnail
                                    ? asset('storage/' . $service->thumbnail)
                                    : null;
                            @endphp


                            <article
                                class="group overflow-hidden rounded-2xl border border-[#E0EBE4] bg-white transition duration-300 hover:-translate-y-0.5 hover:border-[#C0DCCA] hover:shadow-[0_16px_32px_rgba(15,107,58,0.06)]"
                            >

                                {{-- Thumbnail --}}
                                <a
                                    href="{{ route('marketplace.service', $service->slug) }}"
                                    class="block"
                                >

                                    <div
                                        class="relative aspect-[4/3] overflow-hidden bg-[#EAF7EF]"
                                    >

                                        @if ($serviceThumbnail)

                                            <img
                                                src="{{ $serviceThumbnail }}"
                                                alt="{{ $service->title }}"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.035]"
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


                                {{-- Content --}}
                                <div class="p-4">

                                    <div class="flex items-center gap-2 text-[10px] text-[#8A9B94]">

                                        @if ($service->category)

                                            <span class="truncate">
                                                {{ $service->category->name }}
                                            </span>

                                        @endif


                                        @if ($service->delivery_days)

                                            <span>•</span>

                                            <span class="shrink-0">
                                                {{ $service->delivery_days }} hari
                                            </span>

                                        @endif

                                    </div>


                                    <a
                                        href="{{ route('marketplace.service', $service->slug) }}"
                                    >

                                        <h3
                                            class="mt-2 line-clamp-2 text-sm font-semibold leading-6 text-[#123128] transition group-hover:text-[#0F6B3A]"
                                        >
                                            {{ $service->title }}
                                        </h3>

                                    </a>


                                    <div
                                        class="mt-4 flex items-center justify-between border-t border-[#EDF2EF] pt-4"
                                    >

                                        <div>

                                            <div class="text-[10px] text-[#8A9B94]">
                                                Mulai dari
                                            </div>

                                            <div class="mt-1 text-sm font-semibold text-[#123128]">
                                                Rp
                                                {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                            </div>

                                        </div>


                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#EAF7EF] text-[#0F6B3A] transition group-hover:bg-[#0F6B3A] group-hover:text-white"
                                        >
                                            <i class="bi bi-arrow-up-right text-xs"></i>
                                        </div>

                                    </div>

                                </div>

                            </article>

                        @empty

                            <div
                                class="col-span-full rounded-2xl border border-dashed border-[#CFE1D6] bg-white px-6 py-14 text-center"
                            >

                                <div
                                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-xl text-[#0F6B3A]"
                                >
                                    <i class="bi bi-briefcase"></i>
                                </div>

                                <h3
                                    class="mt-4 text-base font-semibold text-[#123128]"
                                >
                                    Belum ada layanan
                                </h3>

                                <p
                                    class="mt-2 text-sm text-[#81918B]"
                                >
                                    Freelancer ini belum mempublikasikan layanan.
                                </p>

                            </div>

                        @endforelse

                    </div>


                    {{-- Mobile CTA --}}
                    @if ($isClient || !auth()->check())

                        <div class="mt-6 sm:hidden">

                            @if ($isClient)

                                <a
                                    href="{{ route('client.messages.start', $freelancerProfile->id) }}"
                                    class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                                >
                                    <i class="bi bi-chat-dots"></i>
                                    Hubungi freelancer
                                </a>

                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                                >
                                    <i class="bi bi-chat-dots"></i>
                                    Hubungi freelancer
                                </a>

                            @endif

                        </div>

                    @endif

                </section>

            </div>

        </div>

    </main>

</x-layouts.marketplace>