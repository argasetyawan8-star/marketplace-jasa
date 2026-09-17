<x-layouts.freelancer title="Profil Freelancer">

    <style>
        @keyframes jasainFadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes jasainFadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes jasainAvatar {
            from {
                opacity: 0;
                transform: translateY(12px) scale(.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .jasain-fade-up {
            animation: jasainFadeUp .6s ease-out both;
        }

        .jasain-fade-in {
            animation: jasainFadeIn .6s ease-out both;
        }

        .jasain-avatar {
            animation: jasainAvatar .65s ease-out .1s both;
        }

        .jasain-delay-1 {
            animation-delay: .08s;
        }

        .jasain-delay-2 {
            animation-delay: .16s;
        }

        .jasain-delay-3 {
            animation-delay: .24s;
        }

        .jasain-delay-4 {
            animation-delay: .32s;
        }

        .jasain-delay-5 {
            animation-delay: .40s;
        }

        .jasain-service-image {
            transition:
                transform .45s cubic-bezier(.2,.7,.2,1),
                filter .45s ease;
        }

        .jasain-service-card:hover .jasain-service-image {
            transform: scale(1.035);
            filter: brightness(1.02);
        }

        .jasain-service-card {
            transition:
                transform .35s ease,
                border-color .35s ease,
                background-color .35s ease;
        }

        .jasain-service-card:hover {
            transform: translateY(-3px);
        }

        .jasain-tab {
            position: relative;
        }

        .jasain-tab::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 2px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .3s ease;
            background: #0F6B3A;
        }

        .jasain-tab:hover::after {
            transform: scaleX(1);
        }
    </style>


    <div class="mx-auto max-w-6xl space-y-5 sm:space-y-6">

        {{-- ====================================================== --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ====================================================== --}}
        @if (session('success'))
            <div class="jasain-fade-in flex items-start gap-3 rounded-xl border border-[#CBEAD8] bg-[#EAF7EF] px-4 py-3.5 text-sm text-[#17663D]">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div>
                    <p class="font-semibold">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-[#557166]">
                        {{ session('success') }}
                    </p>
                </div>

            </div>
        @endif


        {{-- ====================================================== --}}
        {{-- PROFILE HEADER --}}
        {{-- ====================================================== --}}
        <section class="jasain-fade-up overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white">

            {{-- Cover --}}
            <div class="relative h-44 overflow-hidden bg-[#EAF7EF] sm:h-56 lg:h-64">

                @if ($freelancerProfile->cover_image)

                    <img
                        src="{{ asset('storage/' . $freelancerProfile->cover_image) }}"
                        alt="Cover {{ $user->name }}"
                        class="block h-full w-full object-cover transition duration-700 hover:scale-[1.015]"
                    >

                @else

                    <div class="flex h-full w-full items-center justify-center bg-[#EAF7EF]">

                        <div class="text-center">

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-[#0F6B3A]">
                                <i class="bi bi-person-badge text-2xl"></i>
                            </div>

                            <p class="mt-3 text-sm font-medium text-[#17663D]">
                                Profil Freelancer
                            </p>

                        </div>

                    </div>

                @endif

                <div class="absolute inset-0 bg-gradient-to-b from-black/5 via-transparent to-black/10"></div>

            </div>


            {{-- Profile Body --}}
            <div class="px-5 pb-6 sm:px-7 lg:px-8">

                {{-- Avatar --}}
                <div class="jasain-avatar relative -mt-14 sm:-mt-16">

                    <div class="h-28 w-28 overflow-hidden rounded-full border-[5px] border-white bg-[#EAF7EF] shadow-sm sm:h-32 sm:w-32">

                        @if ($freelancerProfile->avatar)

                            <img
                                src="{{ asset('storage/' . $freelancerProfile->avatar) }}"
                                alt="{{ $user->name }}"
                                class="block h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full w-full items-center justify-center">
                                <span class="text-4xl font-semibold text-[#0F6B3A]">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>

                        @endif

                    </div>

                </div>


                {{-- Identity --}}
                <div class="mt-5 flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                    <div class="min-w-0">

                        {{-- Name --}}
                        <div class="flex flex-wrap items-center gap-2">

                            <h1 class="text-2xl font-semibold tracking-tight text-[#123128] sm:text-[30px]">
                                {{ $user->name }}
                            </h1>

                            @if ($freelancerProfile->is_verified)

                                <span class="inline-flex items-center gap-1.5 rounded-md bg-[#EAF7EF] px-2.5 py-1.5 text-xs font-semibold text-[#17663D]">
                                    <i class="bi bi-patch-check-fill"></i>
                                    Penjual Terverifikasi
                                </span>

                            @endif

                        </div>


                        {{-- Username --}}
                        <p class="mt-1 text-sm font-medium text-[#7A8E86]">
                            {{ '@' . $freelancerProfile->username }}
                        </p>


                        {{-- Headline --}}
                        @if ($freelancerProfile->headline)

                            <p class="mt-3 max-w-3xl text-[15px] leading-6 text-[#526960]">
                                {{ $freelancerProfile->headline }}
                            </p>

                        @endif


                        {{-- Tags / Meta --}}
                        <div class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm">

                            <span class="inline-flex items-center gap-1.5 font-semibold text-[#345047]">

                                <i class="bi bi-star-fill text-[#D9A441]"></i>

                                {{ number_format($freelancerProfile->rating, 1) }}

                            </span>

                            <span class="text-[#D4DFDA]">
                                •
                            </span>

                            <span class="text-[#71837B]">
                                {{ number_format($freelancerProfile->completed_orders) }} Order
                            </span>

                            @if ($freelancerProfile->location)

                                <span class="text-[#D4DFDA]">
                                    •
                                </span>

                                <span class="inline-flex items-center gap-1.5 text-[#71837B]">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $freelancerProfile->location }}
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="flex shrink-0 flex-wrap gap-2.5">

                        <a
                            href="{{ route('freelancer.profile.edit') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E5DE] bg-white px-4 py-2.5 text-sm font-semibold text-[#526960] transition hover:border-[#BFDCCB] hover:bg-[#F8FCF9] hover:text-[#123128]"
                        >
                            <i class="bi bi-pencil"></i>
                            Edit Profil
                        </a>

                        <a
                            href="{{ url('/freelancer/' . $freelancerProfile->username) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                            Lihat Profil Publik
                        </a>

                    </div>

                </div>


                {{-- ================================================== --}}
                {{-- FASTWORK STYLE STATS --}}
                {{-- ================================================== --}}
                <div class="mt-7 grid grid-cols-2 border-t border-[#E7EFEA] sm:grid-cols-4">

                    <div class="border-b border-[#E7EFEA] py-5 pr-4 sm:border-b-0 sm:border-r sm:py-6">

                        <p class="text-xs text-[#8A9B94]">
                            Order
                        </p>

                        <p class="mt-1.5 text-xl font-semibold text-[#123128]">
                            {{ number_format($freelancerProfile->completed_orders) }}
                        </p>

                    </div>


                    <div class="border-b border-[#E7EFEA] px-4 py-5 sm:border-b-0 sm:border-r sm:py-6">

                        <p class="text-xs text-[#8A9B94]">
                            Rating
                        </p>

                        <div class="mt-1.5 flex items-center gap-1.5">

                            <i class="bi bi-star-fill text-sm text-[#D9A441]"></i>

                            <p class="text-xl font-semibold text-[#123128]">
                                {{ number_format($freelancerProfile->rating, 1) }}
                            </p>

                        </div>

                    </div>


                    <div class="border-r border-[#E7EFEA] py-5 pl-4 sm:border-b-0 sm:py-6">

                        <p class="text-xs text-[#8A9B94]">
                            Layanan
                        </p>

                        <p class="mt-1.5 text-xl font-semibold text-[#123128]">
                            {{ $freelancerProfile->services->count() }}
                        </p>

                    </div>


                    <div class="py-5 pl-4 sm:py-6">

                        <p class="text-xs text-[#8A9B94]">
                            Status
                        </p>

                        <div class="mt-1.5 flex items-center gap-2">

                            <span class="h-2 w-2 rounded-full {{ $freelancerProfile->is_available ? 'bg-[#1E9E5A]' : 'bg-[#94A3A0]' }}"></span>

                            <p class="text-base font-semibold text-[#123128]">
                                {{ $freelancerProfile->is_available ? 'Tersedia' : 'Offline' }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ====================================================== --}}
        {{-- TABS --}}
        {{-- ====================================================== --}}
        <nav
            class="jasain-fade-up jasain-delay-1 rounded-2xl border border-[#DCE9E2] bg-white px-5 sm:px-7"
        >

            <div class="flex items-center gap-7 overflow-x-auto">

                <a
                    href="#layanan"
                    class="jasain-tab whitespace-nowrap border-b-2 border-[#0F6B3A] py-4 text-sm font-semibold text-[#0F6B3A]"
                >
                    Layanan & Review
                </a>

                <a
                    href="#tentang"
                    class="jasain-tab whitespace-nowrap py-4 text-sm font-medium text-[#71837B] hover:text-[#123128]"
                >
                    Tentang
                </a>

                <a
                    href="#pengalaman"
                    class="jasain-tab whitespace-nowrap py-4 text-sm font-medium text-[#71837B] hover:text-[#123128]"
                >
                    Pengalaman
                </a>

            </div>

        </nav>


        {{-- ====================================================== --}}
        {{-- MAIN CONTENT --}}
        {{-- ====================================================== --}}
        <div class="grid items-start gap-6 lg:grid-cols-[minmax(0,1fr)_290px]">

            {{-- ================================================== --}}
            {{-- LEFT --}}
            {{-- ================================================== --}}
            <main class="min-w-0 space-y-6">


                {{-- ================================================= --}}
                {{-- SERVICES --}}
                {{-- ================================================= --}}
                <section
                    id="layanan"
                    class="jasain-fade-up jasain-delay-2 rounded-2xl border border-[#DCE9E2] bg-white"
                >

                    <div class="border-b border-[#E7EFEA] px-5 py-5 sm:px-6">

                        <h2 class="text-lg font-semibold text-[#123128]">
                            Layanan
                        </h2>

                        <p class="mt-1 text-sm text-[#8A9B94]">
                            Temukan layanan yang tersedia dari {{ $user->name }}.
                        </p>

                    </div>


                    @if ($freelancerProfile->services->count())

                        <div class="divide-y divide-[#E7EFEA]">

                            @foreach ($freelancerProfile->services as $service)

                                <a
                                    href="{{ url('/service/' . $service->slug) }}"
                                    class="jasain-service-card group block px-5 py-5 sm:px-6"
                                >

                                    <div class="flex flex-col gap-4 sm:flex-row">

                                        {{-- Thumbnail --}}
                                        <div class="h-44 w-full shrink-0 overflow-hidden rounded-xl bg-[#F3F8F5] sm:h-[125px] sm:w-[185px]">

                                            @if ($service->thumbnail)

                                                <img
                                                    src="{{ asset('storage/' . $service->thumbnail) }}"
                                                    alt="{{ $service->title }}"
                                                    class="jasain-service-image block h-full w-full object-cover"
                                                >

                                            @else

                                                <div class="flex h-full w-full items-center justify-center text-[#9AA9A2]">
                                                    <i class="bi bi-image text-3xl"></i>
                                                </div>

                                            @endif

                                        </div>


                                        {{-- Service info --}}
                                        <div class="flex min-w-0 flex-1 flex-col justify-between">

                                            <div>

                                                <h3 class="line-clamp-2 text-[15px] font-semibold leading-6 text-[#123128] transition group-hover:text-[#0F6B3A]">
                                                    {{ $service->title }}
                                                </h3>

                                                @if ($service->short_description ?? false)

                                                    <p class="mt-2 line-clamp-2 text-sm leading-5 text-[#71837B]">
                                                        {{ $service->short_description }}
                                                    </p>

                                                @endif

                                            </div>


                                            <div class="mt-4 flex flex-wrap items-end justify-between gap-4">

                                                <div>

                                                    <p class="text-xs text-[#8A9B94]">
                                                        Mulai dari
                                                    </p>

                                                    <p class="mt-1 text-base font-semibold text-[#0F6B3A]">
                                                        Rp {{ number_format($service->starting_price, 0, ',', '.') }}
                                                    </p>

                                                </div>


                                                <div class="flex items-center gap-4 text-xs text-[#8A9B94]">

                                                    <span class="inline-flex items-center gap-1.5">
                                                        <i class="bi bi-clock"></i>
                                                        {{ $service->delivery_days }} hari
                                                    </span>

                                                    <span class="font-semibold text-[#0F6B3A]">
                                                        Lihat jasa
                                                        <i class="bi bi-arrow-right ml-1"></i>
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </a>

                            @endforeach

                        </div>

                    @else

                        <div class="px-5 py-12 text-center sm:px-6">

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F3F8F5] text-[#8A9B94]">
                                <i class="bi bi-briefcase text-2xl"></i>
                            </div>

                            <p class="mt-4 text-sm font-semibold text-[#526960]">
                                Belum ada layanan
                            </p>

                            <p class="mt-1 text-xs text-[#8A9B94]">
                                Tambahkan layanan agar client dapat menemukan jasa kamu.
                            </p>

                            <a
                                href="{{ route('freelancer.services.create') }}"
                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#0F6B3A] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0B542D]"
                            >
                                <i class="bi bi-plus-lg"></i>
                                Tambah Layanan
                            </a>

                        </div>

                    @endif

                </section>


                {{-- ================================================= --}}
                {{-- REVIEWS --}}
                {{-- ================================================= --}}
                <section class="jasain-fade-up jasain-delay-3 rounded-2xl border border-[#DCE9E2] bg-white">

                    <div class="flex items-center justify-between border-b border-[#E7EFEA] px-5 py-5 sm:px-6">

                        <div>

                            <h2 class="text-lg font-semibold text-[#123128]">
                                Ulasan dari Pembeli
                            </h2>

                            <p class="mt-1 text-sm text-[#8A9B94]">
                                Penilaian dari client yang pernah menggunakan jasa kamu.
                            </p>

                        </div>

                        @if ($freelancerProfile->relationLoaded('reviews'))

                            <div class="hidden items-center gap-1.5 sm:flex">

                                <i class="bi bi-star-fill text-[#D9A441]"></i>

                                <span class="text-sm font-semibold text-[#123128]">
                                    {{ number_format($freelancerProfile->rating, 1) }}
                                </span>

                            </div>

                        @endif

                    </div>


                    @if (
                        $freelancerProfile->relationLoaded('reviews') &&
                        $freelancerProfile->reviews->count()
                    )

                        <div class="divide-y divide-[#E7EFEA]">

                            @foreach (
                                $freelancerProfile->reviews
                                    ->sortByDesc('created_at')
                                    ->take(5)
                                as $review
                            )

                                <div class="px-5 py-5 sm:px-6">

                                    <div class="flex gap-3">

                                        {{-- Client Avatar --}}
                                        <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full bg-[#EAF7EF]">

                                            @if (
                                                $review->client &&
                                                $review->client->profile &&
                                                $review->client->profile->avatar
                                            )

                                                <img
                                                    src="{{ asset('storage/' . $review->client->profile->avatar) }}"
                                                    alt="{{ $review->client->name }}"
                                                    class="block h-full w-full object-cover"
                                                >

                                            @else

                                                <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-[#0F6B3A]">
                                                    {{ strtoupper(substr($review->client->name ?? 'C', 0, 1)) }}
                                                </div>

                                            @endif

                                        </div>


                                        {{-- Review --}}
                                        <div class="min-w-0 flex-1">

                                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                                <div>

                                                    <p class="text-sm font-semibold text-[#123128]">
                                                        {{ $review->client->name ?? 'Client' }}
                                                    </p>

                                                    <p class="mt-0.5 text-xs text-[#8A9B94]">
                                                        {{ $review->created_at?->format('d M Y') }}
                                                    </p>

                                                </div>


                                                <div class="flex items-center gap-1">

                                                    @for ($star = 1; $star <= 5; $star++)

                                                        <i
                                                            class="bi bi-star{{ $star <= $review->rating ? '-fill' : '' }} text-xs {{ $star <= $review->rating ? 'text-[#D9A441]' : 'text-[#D0D9D5]' }}"
                                                        ></i>

                                                    @endfor

                                                    <span class="ml-1 text-xs font-semibold text-[#526960]">
                                                        {{ number_format($review->rating, 1) }}
                                                    </span>

                                                </div>

                                            </div>


                                            @if ($review->comment)

                                                <p class="mt-3 text-sm leading-6 text-[#5F7169]">
                                                    {{ $review->comment }}
                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="px-5 py-10 text-center sm:px-6">

                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#F3F8F5] text-[#8A9B94]">
                                <i class="bi bi-chat-square-text text-xl"></i>
                            </div>

                            <p class="mt-3 text-sm font-semibold text-[#526960]">
                                Belum ada review
                            </p>

                            <p class="mt-1 text-xs text-[#8A9B94]">
                                Review dari client akan tampil di bagian ini.
                            </p>

                        </div>

                    @endif

                </section>


                {{-- ================================================= --}}
                {{-- ABOUT --}}
                {{-- ================================================= --}}
                <section
                    id="tentang"
                    class="jasain-fade-up jasain-delay-4 rounded-2xl border border-[#DCE9E2] bg-white p-5 sm:p-6"
                >

                    <h2 class="text-lg font-semibold text-[#123128]">
                        Tentang Saya
                    </h2>

                    <p class="mt-1 text-sm text-[#8A9B94]">
                        Informasi dan deskripsi freelancer.
                    </p>


                    @if ($freelancerProfile->bio)

                        <div class="mt-5">

                            <p class="whitespace-pre-line text-sm leading-7 text-[#526960]">
                                {{ $freelancerProfile->bio }}
                            </p>

                        </div>

                    @else

                        <div class="mt-5 rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] px-5 py-8 text-center">

                            <i class="bi bi-file-text text-2xl text-[#A0AEA8]"></i>

                            <p class="mt-3 text-sm text-[#8A9B94]">
                                Belum ada deskripsi profil.
                            </p>

                        </div>

                    @endif

                </section>


                {{-- ================================================= --}}
                {{-- EXPERIENCE --}}
                {{-- ================================================= --}}
                <section
                    id="pengalaman"
                    class="jasain-fade-up rounded-2xl border border-[#DCE9E2] bg-white p-5 sm:p-6"
                >

                    <h2 class="text-lg font-semibold text-[#123128]">
                        Pengalaman
                    </h2>

                    <p class="mt-1 text-sm text-[#8A9B94]">
                        Pengalaman profesional freelancer.
                    </p>


                    @if ($freelancerProfile->experiences->count())

                        <div class="mt-6 space-y-6">

                            @foreach ($freelancerProfile->experiences as $experience)

                                <div class="flex gap-4">

                                    <div class="flex shrink-0 flex-col items-center">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                                            <i class="bi bi-briefcase"></i>
                                        </div>

                                        @unless ($loop->last)
                                            <div class="mt-2 h-full w-px bg-[#DCE9E2]"></div>
                                        @endunless

                                    </div>


                                    <div class="min-w-0 flex-1">

                                        <h3 class="text-sm font-semibold text-[#123128]">
                                            {{ $experience->position }}
                                        </h3>

                                        @if ($experience->company)

                                            <p class="mt-1 text-sm font-medium text-[#526960]">
                                                {{ $experience->company }}
                                            </p>

                                        @endif

                                        <p class="mt-1 text-xs text-[#8A9B94]">
                                            {{ $experience->start_year }}
                                            -
                                            {{ $experience->end_year ?: 'Sekarang' }}
                                        </p>

                                        @if ($experience->description)

                                            <p class="mt-3 whitespace-pre-line text-sm leading-6 text-[#5F7169]">
                                                {{ $experience->description }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="mt-6 rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] px-5 py-8 text-center">

                            <i class="bi bi-briefcase text-2xl text-[#A0AEA8]"></i>

                            <p class="mt-3 text-sm text-[#8A9B94]">
                                Belum ada pengalaman profesional.
                            </p>

                        </div>

                    @endif

                </section>


                {{-- ================================================= --}}
                {{-- EDUCATION --}}
                {{-- ================================================= --}}
                <section class="rounded-2xl border border-[#DCE9E2] bg-white p-5 sm:p-6">

                    <h2 class="text-lg font-semibold text-[#123128]">
                        Pendidikan
                    </h2>

                    <p class="mt-1 text-sm text-[#8A9B94]">
                        Riwayat pendidikan freelancer.
                    </p>


                    @if ($freelancerProfile->educations->count())

                        <div class="mt-6 space-y-5">

                            @foreach ($freelancerProfile->educations as $education)

                                <div class="flex gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                                        <i class="bi bi-mortarboard"></i>
                                    </div>

                                    <div>

                                        <h3 class="text-sm font-semibold text-[#123128]">
                                            {{ $education->institution }}
                                        </h3>

                                        @if ($education->field_of_study)

                                            <p class="mt-1 text-sm text-[#526960]">
                                                {{ $education->field_of_study }}
                                            </p>

                                        @endif

                                        <p class="mt-1 text-xs text-[#8A9B94]">
                                            {{ $education->start_year }}
                                            -
                                            {{ $education->end_year ?: 'Sekarang' }}
                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <p class="mt-5 text-sm text-[#8A9B94]">
                            Belum ada data pendidikan.
                        </p>

                    @endif

                </section>


                {{-- ================================================= --}}
                {{-- CERTIFICATES --}}
                {{-- ================================================= --}}
                <section class="rounded-2xl border border-[#DCE9E2] bg-white p-5 sm:p-6">

                    <h2 class="text-lg font-semibold text-[#123128]">
                        Sertifikat & Penghargaan
                    </h2>

                    <p class="mt-1 text-sm text-[#8A9B94]">
                        Sertifikat yang mendukung kompetensi freelancer.
                    </p>


                    @if ($freelancerProfile->certificates->count())

                        <div class="mt-6 grid gap-4 sm:grid-cols-2">

                            @foreach ($freelancerProfile->certificates as $certificate)

                                <div class="rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-4">

                                    <div class="flex gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                                            <i class="bi bi-award"></i>
                                        </div>

                                        <div class="min-w-0">

                                            <h3 class="text-sm font-semibold text-[#123128]">
                                                {{ $certificate->name }}
                                            </h3>

                                            @if ($certificate->issuer)

                                                <p class="mt-1 text-sm text-[#526960]">
                                                    {{ $certificate->issuer }}
                                                </p>

                                            @endif

                                            @if ($certificate->year)

                                                <p class="mt-1 text-xs text-[#8A9B94]">
                                                    Tahun {{ $certificate->year }}
                                                </p>

                                            @endif

                                            @if ($certificate->credential_url)

                                                <a
                                                    href="{{ $certificate->credential_url }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-[#0F6B3A] hover:text-[#0B542D]"
                                                >
                                                    Lihat sertifikat
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </a>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <p class="mt-5 text-sm text-[#8A9B94]">
                            Belum ada sertifikat.
                        </p>

                    @endif

                </section>


                {{-- ================================================= --}}
                {{-- SKILLS --}}
                {{-- ================================================= --}}
                <section class="rounded-2xl border border-[#DCE9E2] bg-white p-5 sm:p-6">

                    <h2 class="text-lg font-semibold text-[#123128]">
                        Skills
                    </h2>

                    <p class="mt-1 text-sm text-[#8A9B94]">
                        Keahlian yang dikuasai freelancer.
                    </p>


                    @if ($freelancerProfile->skills->count())

                        <div class="mt-5 flex flex-wrap gap-2.5">

                            @foreach ($freelancerProfile->skills as $skill)

                                <span class="inline-flex items-center gap-2 rounded-lg border border-[#DCE9E2] bg-[#F8FCF9] px-3 py-2 text-sm font-medium text-[#345047]">

                                    <i class="bi bi-check-circle text-[#1E9E5A]"></i>

                                    {{ $skill->name }}

                                </span>

                            @endforeach

                        </div>

                    @else

                        <p class="mt-5 text-sm text-[#8A9B94]">
                            Belum ada skill.
                        </p>

                    @endif

                </section>


                {{-- ================================================= --}}
                {{-- LANGUAGES --}}
                {{-- ================================================= --}}
                <section class="rounded-2xl border border-[#DCE9E2] bg-white p-5 sm:p-6">

                    <h2 class="text-lg font-semibold text-[#123128]">
                        Bahasa
                    </h2>

                    <p class="mt-1 text-sm text-[#8A9B94]">
                        Bahasa yang digunakan freelancer.
                    </p>


                    @if ($freelancerProfile->languages->count())

                        <div class="mt-5 grid gap-3 sm:grid-cols-2">

                            @foreach ($freelancerProfile->languages as $language)

                                <div class="flex items-center gap-3 rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-4">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                                        <i class="bi bi-translate"></i>
                                    </div>

                                    <div>

                                        <p class="text-sm font-semibold text-[#123128]">
                                            {{ $language->language }}
                                        </p>

                                        @if ($language->level)

                                            <p class="mt-1 text-xs text-[#8A9B94]">
                                                {{ $language->level }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <p class="mt-5 text-sm text-[#8A9B94]">
                            Belum ada bahasa.
                        </p>

                    @endif

                </section>

            </main>


            {{-- ================================================== --}}
            {{-- RIGHT SIDEBAR --}}
            {{-- ================================================== --}}
            <aside class="space-y-5 lg:sticky lg:top-6">

                {{-- Profile Summary --}}
                <section class="jasain-fade-up jasain-delay-2 rounded-2xl border border-[#DCE9E2] bg-white p-5">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                            <i class="bi bi-person-check"></i>
                        </div>

                        <div>

                            <h2 class="text-base font-semibold text-[#123128]">
                                Profil Freelancer
                            </h2>

                            <p class="mt-0.5 text-xs text-[#8A9B94]">
                                Ringkasan profil kamu
                            </p>

                        </div>

                    </div>


                    <div class="mt-5 space-y-4">

                        <div class="flex items-start justify-between gap-3">

                            <span class="text-sm text-[#71837B]">
                                Status
                            </span>

                            <span class="inline-flex items-center gap-1.5 text-sm font-semibold {{ $freelancerProfile->is_available ? 'text-[#17663D]' : 'text-[#71837B]' }}">

                                <span class="h-2 w-2 rounded-full {{ $freelancerProfile->is_available ? 'bg-[#1E9E5A]' : 'bg-[#94A3A0]' }}"></span>

                                {{ $freelancerProfile->is_available ? 'Tersedia' : 'Offline' }}

                            </span>

                        </div>


                        <div class="flex items-start justify-between gap-3">

                            <span class="text-sm text-[#71837B]">
                                Rating
                            </span>

                            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#123128]">

                                <i class="bi bi-star-fill text-[#D9A441]"></i>

                                {{ number_format($freelancerProfile->rating, 1) }}

                            </span>

                        </div>


                        <div class="flex items-start justify-between gap-3">

                            <span class="text-sm text-[#71837B]">
                                Pesanan selesai
                            </span>

                            <span class="text-sm font-semibold text-[#123128]">
                                {{ number_format($freelancerProfile->completed_orders) }}
                            </span>

                        </div>


                        <div class="flex items-start justify-between gap-3">

                            <span class="text-sm text-[#71837B]">
                                Total layanan
                            </span>

                            <span class="text-sm font-semibold text-[#123128]">
                                {{ $freelancerProfile->services->count() }}
                            </span>

                        </div>

                    </div>

                </section>


                {{-- Contact --}}
                <section class="rounded-2xl border border-[#DCE9E2] bg-white p-5">

                    <h2 class="text-base font-semibold text-[#123128]">
                        Informasi
                    </h2>


                    <div class="mt-5 space-y-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F3F8F5] text-[#0F6B3A]">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-xs text-[#8A9B94]">
                                    Lokasi
                                </p>

                                <p class="mt-1 text-sm font-medium text-[#345047]">
                                    {{ $freelancerProfile->location ?: 'Belum diisi' }}
                                </p>

                            </div>

                        </div>


                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F3F8F5] text-[#0F6B3A]">
                                <i class="bi bi-envelope"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-xs text-[#8A9B94]">
                                    Email
                                </p>

                                <p class="mt-1 break-all text-sm font-medium text-[#345047]">
                                    {{ $user->email }}
                                </p>

                            </div>

                        </div>


                        @if ($freelancerProfile->website)

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F3F8F5] text-[#0F6B3A]">
                                    <i class="bi bi-globe2"></i>
                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs text-[#8A9B94]">
                                        Website
                                    </p>

                                    <a
                                        href="{{ $freelancerProfile->website }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="mt-1 block truncate text-sm font-medium text-[#0F6B3A] hover:text-[#0B542D]"
                                    >
                                        {{ $freelancerProfile->website }}
                                    </a>

                                </div>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- Edit Card --}}
                <section class="rounded-2xl border border-[#CBEAD8] bg-[#EAF7EF] p-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                            <i class="bi bi-pencil-square"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128]">
                                Perbarui Profil
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-[#557166]">
                                Lengkapi informasi, pengalaman, skill, dan data profesional kamu.
                            </p>

                        </div>

                    </div>


                    <a
                        href="{{ route('freelancer.profile.edit') }}"
                        class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-[#0F6B3A] hover:text-[#0B542D]"
                    >
                        Edit profil
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </section>

            </aside>

        </div>

    </div>

</x-layouts.freelancer>