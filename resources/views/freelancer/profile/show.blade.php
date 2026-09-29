<x-layouts.freelancer title="Profil Freelancer">


<style>
    [x-cloak] {
        display: none !important;
    }

    @keyframes jasainFadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
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
            transform: translateY(10px) scale(.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .jasain-fade-up {
        animation: jasainFadeUp .55s ease-out both;
    }

    .jasain-fade-in {
        animation: jasainFadeIn .45s ease-out both;
    }

    .jasain-avatar {
        animation: jasainAvatar .6s ease-out .08s both;
    }

    .jasain-delay-1 {
        animation-delay: .06s;
    }

    .jasain-delay-2 {
        animation-delay: .12s;
    }

    .jasain-delay-3 {
        animation-delay: .18s;
    }

    .jasain-delay-4 {
        animation-delay: .24s;
    }

    .jasain-service-card {
        transition:
            background-color .2s ease,
            transform .2s ease;
    }

    .jasain-service-card:hover {
        background-color: #F8FAFF;
    }

    .jasain-service-image {
        transition:
            transform .35s cubic-bezier(.2, .7, .2, 1),
            filter .35s ease;
    }

    .jasain-service-card:hover .jasain-service-image {
        transform: scale(1.04);
        filter: brightness(1.02);
    }

    .jasain-tab {
        position: relative;
        isolation: isolate;
    }

    .jasain-tab::after {
        content: "";
        position: absolute;
        left: 10px;
        right: 10px;
        bottom: -1px;
        height: 2px;
        border-radius: 999px;
        background: #2563EB;
        transform: scaleX(0);
        transform-origin: center;
        transition: transform .25s ease;
    }

    .jasain-tab.active::after {
        transform: scaleX(1);
    }

    .jasain-scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .jasain-scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    /*
    |--------------------------------------------------------------------------
    | SLIDER
    |--------------------------------------------------------------------------
    | Hanya satu panel yang terlihat dalam viewport.
    | Panel lain dipindahkan keluar menggunakan translateX.
    */
    .jasain-slider-viewport {
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .jasain-slider-panel {
        width: 100%;
        max-width: 100%;
        transition:
            transform .48s cubic-bezier(.2, .75, .2, 1),
            opacity .35s ease;
    }

    .jasain-panel-hidden-left {
        transform: translateX(-100%);
        opacity: 0;
        pointer-events: none;
    }

    .jasain-panel-active {
        transform: translateX(0);
        opacity: 1;
        pointer-events: auto;
    }

    .jasain-panel-hidden-right {
        transform: translateX(100%);
        opacity: 0;
        pointer-events: none;
    }

    @media (max-width: 640px) {
        .jasain-service-card:hover {
            background-color: transparent;
        }

        .jasain-service-card:hover .jasain-service-image {
            transform: none;
            filter: none;
        }

        .jasain-tab::after {
            left: 6px;
            right: 6px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .jasain-fade-up,
        .jasain-fade-in,
        .jasain-avatar {
            animation: none !important;
        }

        .jasain-service-card,
        .jasain-service-image,
        .jasain-tab::after,
        .jasain-slider-panel {
            transition: none !important;
        }
    }
</style>


<div
    x-data="{
        activeTab: 'layanan',
        activeIndex: 0,
        showAllServices: false,

        tabs: [
            'layanan',
            'tentang',
            'pengalaman'
        ],

        setTab(tab) {
            if (this.activeTab === tab) {
                return;
            }

            this.activeTab = tab;
            this.activeIndex = this.tabs.indexOf(tab);

            this.$nextTick(() => {
                this.centerActiveTab();
            });
        },

        centerActiveTab() {
            const tab = this.$refs['tab-' + this.activeTab];

            if (tab && window.innerWidth < 640) {
                tab.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }
        },

        panelClass(index) {
            if (index === this.activeIndex) {
                return 'jasain-panel-active absolute inset-0';
            }

            if (index < this.activeIndex) {
                return 'jasain-panel-hidden-left absolute inset-0';
            }

            return 'jasain-panel-hidden-right absolute inset-0';
        },

        toggleServices() {
            this.showAllServices = !this.showAllServices;
        }
    }"
    class="mx-auto w-full max-w-6xl space-y-4 px-3 pb-8 sm:space-y-6 sm:px-4 lg:px-0"
>


    {{-- ====================================================== --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ====================================================== --}}
    @if (session('success'))

        <div
            class="jasain-fade-in flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3.5 text-sm text-blue-700"
        >

            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm">
                <i class="bi bi-check-circle"></i>
            </div>

            <div class="min-w-0">

                <p class="font-semibold">
                    Berhasil
                </p>

                <p class="mt-0.5 break-words text-blue-600">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- PROFILE HEADER --}}
    {{-- ====================================================== --}}
    <section
        class="jasain-fade-up overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >

        {{-- COVER --}}
        <div class="relative h-36 overflow-hidden bg-blue-50 sm:h-52 lg:h-64">

            @if ($freelancerProfile->cover_image)

                <img
                    src="{{ asset('storage/' . $freelancerProfile->cover_image) }}"
                    alt="Cover {{ $user->name }}"
                    class="block h-full w-full object-cover transition duration-700 hover:scale-[1.015]"
                >

            @else

                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-100">

                    <div class="text-center">

                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-blue-600 shadow-sm ring-1 ring-blue-100 sm:h-14 sm:w-14">
                            <i class="bi bi-person-badge text-xl sm:text-2xl"></i>
                        </div>

                        <p class="mt-3 text-xs font-semibold text-blue-700 sm:text-sm">
                            Profil Freelancer
                        </p>

                    </div>

                </div>

            @endif

            <div class="absolute inset-0 bg-gradient-to-b from-black/5 via-transparent to-black/10"></div>

        </div>


        {{-- PROFILE BODY --}}
        <div class="px-4 pb-5 sm:px-6 sm:pb-6 lg:px-8">

            {{-- AVATAR --}}
            <div class="jasain-avatar relative -mt-11 sm:-mt-16">

                <div class="h-24 w-24 overflow-hidden rounded-full border-[5px] border-white bg-blue-50 shadow-md sm:h-32 sm:w-32">

                    @if ($freelancerProfile->avatar)

                        <img
                            src="{{ asset('storage/' . $freelancerProfile->avatar) }}"
                            alt="{{ $user->name }}"
                            class="block h-full w-full object-cover"
                        >

                    @else

                        <div class="flex h-full w-full items-center justify-center">

                            <span class="text-3xl font-semibold text-blue-600 sm:text-4xl">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>

                        </div>

                    @endif

                </div>

            </div>


            {{-- IDENTITY --}}
            <div class="mt-4 flex flex-col gap-5 lg:mt-5 lg:flex-row lg:items-start lg:justify-between">

                <div class="min-w-0">

                    {{-- NAME --}}
                    <div class="flex flex-wrap items-center gap-2">

                        <h1 class="text-xl font-semibold tracking-tight text-slate-900 sm:text-[30px]">
                            {{ $user->name }}
                        </h1>

                        @if ($freelancerProfile->is_verified)

                            <span class="inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1.5 text-[11px] font-semibold text-blue-700">
                                <i class="bi bi-patch-check-fill"></i>
                                Penjual Terverifikasi
                            </span>

                        @endif

                    </div>


                    {{-- USERNAME --}}
                    <p class="mt-1 break-words text-sm font-medium text-slate-500">
                        {{ '@' . $freelancerProfile->username }}
                    </p>


                    {{-- HEADLINE --}}
                    @if ($freelancerProfile->headline)

                        <p class="mt-3 max-w-3xl break-words text-sm leading-6 text-slate-600 sm:text-[15px]">
                            {{ $freelancerProfile->headline }}
                        </p>

                    @endif


                    {{-- META --}}
                    <div class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-2 text-xs sm:text-sm">

                        <span class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                            <i class="bi bi-star-fill text-amber-400"></i>
                            {{ number_format($freelancerProfile->rating, 1) }}
                        </span>

                        <span class="text-slate-300">
                            •
                        </span>

                        <span class="text-slate-500">
                            {{ number_format($freelancerProfile->completed_orders) }} Order
                        </span>

                        @if ($freelancerProfile->location)

                            <span class="text-slate-300">
                                •
                            </span>

                            <span class="inline-flex max-w-full items-center gap-1.5 break-words text-slate-500">
                                <i class="bi bi-geo-alt shrink-0"></i>
                                <span>{{ $freelancerProfile->location }}</span>
                            </span>

                        @endif

                    </div>

                </div>


                {{-- ACTIONS --}}
                <div class="flex shrink-0 flex-wrap gap-2">

                    <a
                        href="{{ route('freelancer.profile.edit') }}"
                        class="inline-flex w-auto items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 sm:px-4"
                    >
                        <i class="bi bi-pencil"></i>
                        Edit Profil
                    </a>

                   <a
                    href="{{ url('/freelancer/' . $freelancerProfile->username) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex w-auto items-center justify-center gap-2 rounded-xl bg-blue-600 px-3.5 py-2.5 text-sm font-semibold !text-white transition hover:bg-blue-700 sm:px-4"
                >
                    <i class="bi bi-box-arrow-up-right !text-white"></i>
                    <span class="!text-white">Lihat Profil Publik</span>
                </a>
                </div>

            </div>


            {{-- PROFILE STATS --}}
            <div class="mt-6 grid grid-cols-2 border-t border-slate-100 sm:mt-7 sm:grid-cols-4">

                <div class="border-b border-r border-slate-100 py-4 pr-4 sm:border-b-0 sm:py-6">

                    <p class="text-xs text-slate-400">
                        Order
                    </p>

                    <p class="mt-1.5 text-xl font-semibold text-slate-900">
                        {{ number_format($freelancerProfile->completed_orders) }}
                    </p>

                </div>


                <div class="border-b border-slate-100 px-4 py-4 sm:border-b-0 sm:border-r sm:py-6">

                    <p class="text-xs text-slate-400">
                        Rating
                    </p>

                    <div class="mt-1.5 flex items-center gap-1.5">

                        <i class="bi bi-star-fill text-sm text-amber-400"></i>

                        <p class="text-xl font-semibold text-slate-900">
                            {{ number_format($freelancerProfile->rating, 1) }}
                        </p>

                    </div>

                </div>


                <div class="border-r border-slate-100 py-4 pl-4 sm:border-b-0 sm:py-6">

                    <p class="text-xs text-slate-400">
                        Layanan
                    </p>

                    <p class="mt-1.5 text-xl font-semibold text-slate-900">
                        {{ $freelancerProfile->services->count() }}
                    </p>

                </div>


                <div class="py-4 pl-4 sm:py-6">

                    <p class="text-xs text-slate-400">
                        Status
                    </p>

                    <div class="mt-1.5 flex items-center gap-2">

                        <span
                            class="h-2 w-2 rounded-full {{ $freelancerProfile->is_available ? 'bg-blue-500' : 'bg-slate-400' }}"
                        ></span>

                        <p class="text-base font-semibold text-slate-900">
                            {{ $freelancerProfile->is_available ? 'Tersedia' : 'Offline' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ====================================================== --}}
    {{-- PROFILE TABS --}}
    {{-- ====================================================== --}}
    <nav
        class="jasain-fade-up jasain-delay-1 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >

        <div class="jasain-scrollbar-hide flex items-center overflow-x-auto px-2 sm:px-4">

            <button
                type="button"
                role="tab"
                x-ref="tab-layanan"
                @click="setTab('layanan')"
                :aria-selected="activeTab === 'layanan'"
                :class="activeTab === 'layanan'
                    ? 'active border-blue-600 text-blue-600'
                    : 'border-transparent text-slate-500 hover:text-slate-900'"
                class="jasain-tab min-w-max shrink-0 border-b-2 px-4 py-3.5 text-xs font-semibold transition sm:px-6 sm:py-4 sm:text-sm"
            >
                Layanan & Review
            </button>


            <button
                type="button"
                role="tab"
                x-ref="tab-tentang"
                @click="setTab('tentang')"
                :aria-selected="activeTab === 'tentang'"
                :class="activeTab === 'tentang'
                    ? 'active border-blue-600 text-blue-600'
                    : 'border-transparent text-slate-500 hover:text-slate-900'"
                class="jasain-tab min-w-max shrink-0 border-b-2 px-4 py-3.5 text-xs font-medium transition sm:px-6 sm:py-4 sm:text-sm"
            >
                Tentang
            </button>


            <button
                type="button"
                role="tab"
                x-ref="tab-pengalaman"
                @click="setTab('pengalaman')"
                :aria-selected="activeTab === 'pengalaman'"
                :class="activeTab === 'pengalaman'
                    ? 'active border-blue-600 text-blue-600'
                    : 'border-transparent text-slate-500 hover:text-slate-900'"
                class="jasain-tab min-w-max shrink-0 border-b-2 px-4 py-3.5 text-xs font-medium transition sm:px-6 sm:py-4 sm:text-sm"
            >
                Pengalaman
            </button>

        </div>

    </nav>


    {{-- ====================================================== --}}
    {{-- MAIN CONTENT --}}
    {{-- ====================================================== --}}
    <div
        class="grid items-start gap-5 lg:grid-cols-[minmax(0,1fr)_290px] lg:gap-6"
    >


        {{-- ================================================= --}}
        {{-- SLIDER AREA --}}
        {{-- ================================================= --}}
        <div class="min-w-0">

            <div
                class="jasain-slider-viewport"
                :style="'min-height:' + (activeIndex === 0
                    ? '720px'
                    : activeIndex === 1
                        ? '600px'
                        : '500px')"
            >


                {{-- ================================================= --}}
                {{-- PANEL 1 --}}
                {{-- ================================================= --}}
                <section
                    x-ref="panel-layanan"
                    :class="panelClass(0)"
                    class="jasain-slider-panel"
                >

                    <div class="space-y-5 sm:space-y-6">

                        {{-- SERVICES --}}
                        <section
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                        >

                            <div class="border-b border-slate-100 px-4 py-5 sm:px-6">

                                <div class="flex items-center justify-between gap-3">

                                    <div class="min-w-0">

                                        <h2 class="text-lg font-semibold text-slate-900">
                                            Layanan
                                        </h2>

                                        <p class="mt-1 text-sm text-slate-400">
                                            Layanan pilihan dari {{ $user->name }}.
                                        </p>

                                    </div>

                                    @if ($freelancerProfile->services->count() > 3)

                                        <span class="shrink-0 text-xs font-semibold text-blue-600">
                                            {{ $freelancerProfile->services->count() }} jasa
                                        </span>

                                    @endif

                                </div>

                            </div>


                            @if ($freelancerProfile->services->count())

                                <div class="divide-y divide-slate-100">

                                    @foreach ($freelancerProfile->services as $service)

                                        <a
                                            href="{{ url('/service/' . $service->slug) }}"
                                            x-show="{{ $loop->iteration <= 3 ? 'true' : 'showAllServices' }}"
                                            x-cloak
                                            class="jasain-service-card group flex items-center gap-3 px-4 py-4 sm:gap-4 sm:px-6"
                                        >

                                            {{-- IMAGE --}}
                                            <div class="h-16 w-20 shrink-0 overflow-hidden rounded-lg bg-slate-100 sm:h-[74px] sm:w-[92px]">

                                                @if ($service->thumbnail)

                                                    <img
                                                        src="{{ asset('storage/' . $service->thumbnail) }}"
                                                        alt="{{ $service->title }}"
                                                        class="jasain-service-image block h-full w-full object-cover"
                                                    >

                                                @else

                                                    <div class="flex h-full w-full items-center justify-center text-slate-300">
                                                        <i class="bi bi-image text-xl"></i>
                                                    </div>

                                                @endif

                                            </div>


                                            {{-- INFO --}}
                                            <div class="min-w-0 flex-1">

                                                <h3 class="line-clamp-2 break-words text-sm font-semibold leading-5 text-slate-900 transition group-hover:text-blue-600 sm:text-[15px]">
                                                    {{ $service->title }}
                                                </h3>

                                                <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1.5 text-xs">

                                                    <span class="font-semibold text-blue-600">
                                                        Rp {{ number_format($service->starting_price, 0, ',', '.') }}
                                                    </span>

                                                    <span class="inline-flex items-center gap-1 text-slate-400">
                                                        <i class="bi bi-clock"></i>
                                                        {{ $service->delivery_days }} hari
                                                    </span>

                                                </div>

                                            </div>


                                            {{-- ARROW --}}
                                            <div class="shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-blue-600">
                                                <i class="bi bi-chevron-right text-xs"></i>
                                            </div>

                                        </a>

                                    @endforeach

                                </div>


                                {{-- SEE ALL --}}
                                @if ($freelancerProfile->services->count() > 3)

                                    <div class="flex justify-center border-t border-slate-100 px-4 py-4 sm:px-6">

                                        <button
                                            type="button"
                                            @click="toggleServices()"
                                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-100 bg-blue-50 px-4 py-2.5 text-xs font-semibold text-blue-600 transition hover:border-blue-200 hover:bg-blue-100 sm:text-sm"
                                        >

                                            <span x-show="!showAllServices" x-cloak>
                                                Lihat semua jasa
                                            </span>

                                            <span x-show="showAllServices" x-cloak>
                                                Sembunyikan jasa
                                            </span>

                                            <i
                                                class="bi text-xs"
                                                :class="showAllServices
                                                    ? 'bi-chevron-up'
                                                    : 'bi-chevron-down'"
                                            ></i>

                                        </button>

                                    </div>

                                @endif


                            @else

                                <div class="px-4 py-12 text-center sm:px-6">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-500">
                                        <i class="bi bi-briefcase text-2xl"></i>
                                    </div>

                                    <p class="mt-4 text-sm font-semibold text-slate-700">
                                        Belum ada layanan
                                    </p>

                                    <p class="mx-auto mt-1 max-w-sm text-xs leading-5 text-slate-400">
                                        Tambahkan layanan agar client dapat menemukan jasa kamu.
                                    </p>

                                    <a
                                        href="{{ route('freelancer.services.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                                    >
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Layanan
                                    </a>

                                </div>

                            @endif

                        </section>


                        {{-- REVIEWS --}}
                        <section
                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                        >

                            <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-4 py-5 sm:items-center sm:px-6">

                                <div class="min-w-0">

                                    <h2 class="text-lg font-semibold text-slate-900">
                                        Ulasan dari Pembeli
                                    </h2>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Penilaian dari client yang pernah menggunakan jasa kamu.
                                    </p>

                                </div>

                                @if ($freelancerProfile->relationLoaded('reviews'))

                                    <div class="hidden shrink-0 items-center gap-1.5 sm:flex">

                                        <i class="bi bi-star-fill text-amber-400"></i>

                                        <span class="text-sm font-semibold text-slate-900">
                                            {{ number_format($freelancerProfile->rating, 1) }}
                                        </span>

                                    </div>

                                @endif

                            </div>


                            @if (
                                $freelancerProfile->relationLoaded('reviews') &&
                                $freelancerProfile->reviews->count()
                            )

                                <div class="divide-y divide-slate-100">

                                    @foreach (
                                        $freelancerProfile->reviews
                                            ->sortByDesc('created_at')
                                            ->take(5)
                                        as $review
                                    )

                                        <div class="px-4 py-5 sm:px-6">

                                            <div class="flex gap-3">

                                                <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full bg-blue-50">

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

                                                        <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-blue-600">
                                                            {{ strtoupper(substr($review->client->name ?? 'C', 0, 1)) }}
                                                        </div>

                                                    @endif

                                                </div>


                                                <div class="min-w-0 flex-1">

                                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                                        <div class="min-w-0">

                                                            <p class="break-words text-sm font-semibold text-slate-900">
                                                                {{ $review->client->name ?? 'Client' }}
                                                            </p>

                                                            <p class="mt-0.5 text-xs text-slate-400">
                                                                {{ $review->created_at?->format('d M Y') }}
                                                            </p>

                                                        </div>


                                                        <div class="flex shrink-0 items-center gap-1">

                                                            @for ($star = 1; $star <= 5; $star++)

                                                                <i
                                                                    class="bi bi-star{{ $star <= $review->rating ? '-fill' : '' }} text-xs {{ $star <= $review->rating ? 'text-amber-400' : 'text-slate-300' }}"
                                                                ></i>

                                                            @endfor

                                                            <span class="ml-1 text-xs font-semibold text-slate-600">
                                                                {{ number_format($review->rating, 1) }}
                                                            </span>

                                                        </div>

                                                    </div>


                                                    @if ($review->comment)

                                                        <p class="mt-3 break-words whitespace-pre-line text-sm leading-6 text-slate-600">
                                                            {{ $review->comment }}
                                                        </p>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="px-4 py-10 text-center sm:px-6">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-slate-400">
                                        <i class="bi bi-chat-square-text text-xl"></i>
                                    </div>

                                    <p class="mt-3 text-sm font-semibold text-slate-600">
                                        Belum ada review
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Review dari client akan tampil di bagian ini.
                                    </p>

                                </div>

                            @endif

                        </section>

                    </div>

                </section>


                {{-- ================================================= --}}
                {{-- PANEL 2 : TENTANG --}}
                {{-- ================================================= --}}
                <section
                    x-ref="panel-tentang"
                    :class="panelClass(1)"
                    class="jasain-slider-panel"
                >

                    <div class="space-y-5 sm:space-y-6">

                        {{-- ABOUT --}}
                        <section
                            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6"
                        >

                            <h2 class="text-lg font-semibold text-slate-900">
                                Tentang Saya
                            </h2>

                            <p class="mt-1 text-sm text-slate-400">
                                Informasi dan deskripsi freelancer.
                            </p>


                            @if ($freelancerProfile->bio)

                                <div class="mt-5">

                                    <p class="break-words whitespace-pre-line text-sm leading-7 text-slate-600">
                                        {{ $freelancerProfile->bio }}
                                    </p>

                                </div>

                            @else

                                <div class="mt-5 rounded-xl border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center">

                                    <i class="bi bi-file-text text-2xl text-slate-300"></i>

                                    <p class="mt-3 text-sm text-slate-400">
                                        Belum ada deskripsi profil.
                                    </p>

                                </div>

                            @endif

                        </section>


                        {{-- EDUCATION --}}
                        <section
                            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6"
                        >

                            <h2 class="text-lg font-semibold text-slate-900">
                                Pendidikan
                            </h2>

                            <p class="mt-1 text-sm text-slate-400">
                                Riwayat pendidikan freelancer.
                            </p>


                            @if ($freelancerProfile->educations->count())

                                <div class="mt-6 space-y-5">

                                    @foreach ($freelancerProfile->educations as $education)

                                        <div class="flex gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                                <i class="bi bi-mortarboard"></i>
                                            </div>

                                            <div class="min-w-0">

                                                <h3 class="break-words text-sm font-semibold text-slate-900">
                                                    {{ $education->institution }}
                                                </h3>

                                                @if ($education->field_of_study)

                                                    <p class="mt-1 break-words text-sm text-slate-600">
                                                        {{ $education->field_of_study }}
                                                    </p>

                                                @endif

                                                <p class="mt-1 text-xs text-slate-400">
                                                    {{ $education->start_year }}
                                                    -
                                                    {{ $education->end_year ?: 'Sekarang' }}
                                                </p>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <p class="mt-5 text-sm text-slate-400">
                                    Belum ada data pendidikan.
                                </p>

                            @endif

                        </section>


                        {{-- CERTIFICATES --}}
                        <section
                            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6"
                        >

                            <h2 class="text-lg font-semibold text-slate-900">
                                Sertifikat & Penghargaan
                            </h2>

                            <p class="mt-1 text-sm text-slate-400">
                                Sertifikat yang mendukung kompetensi freelancer.
                            </p>


                            @if ($freelancerProfile->certificates->count())

                                <div class="mt-6 grid gap-4 sm:grid-cols-2">

                                    @foreach ($freelancerProfile->certificates as $certificate)

                                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                                            <div class="flex gap-3">

                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                                                    <i class="bi bi-award"></i>
                                                </div>

                                                <div class="min-w-0">

                                                    <h3 class="break-words text-sm font-semibold text-slate-900">
                                                        {{ $certificate->name }}
                                                    </h3>

                                                    @if ($certificate->issuer)

                                                        <p class="mt-1 break-words text-sm text-slate-600">
                                                            {{ $certificate->issuer }}
                                                        </p>

                                                    @endif

                                                    @if ($certificate->year)

                                                        <p class="mt-1 text-xs text-slate-400">
                                                            Tahun {{ $certificate->year }}
                                                        </p>

                                                    @endif

                                                    @if ($certificate->credential_url)

                                                        <a
                                                            href="{{ $certificate->credential_url }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 transition hover:text-blue-700"
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

                                <p class="mt-5 text-sm text-slate-400">
                                    Belum ada sertifikat.
                                </p>

                            @endif

                        </section>


                        {{-- SKILLS --}}
                        <section
                            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6"
                        >

                            <h2 class="text-lg font-semibold text-slate-900">
                                Skills
                            </h2>

                            <p class="mt-1 text-sm text-slate-400">
                                Keahlian yang dikuasai freelancer.
                            </p>


                            @if ($freelancerProfile->skills->count())

                                <div class="mt-5 flex flex-wrap gap-2.5">

                                    @foreach ($freelancerProfile->skills as $skill)

                                        <span class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700">
                                            <i class="bi bi-check-circle text-blue-500"></i>
                                            {{ $skill->name }}
                                        </span>

                                    @endforeach

                                </div>

                            @else

                                <p class="mt-5 text-sm text-slate-400">
                                    Belum ada skill.
                                </p>

                            @endif

                        </section>


                        {{-- LANGUAGES --}}
                        <section
                            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6"
                        >

                            <h2 class="text-lg font-semibold text-slate-900">
                                Bahasa
                            </h2>

                            <p class="mt-1 text-sm text-slate-400">
                                Bahasa yang digunakan freelancer.
                            </p>


                            @if ($freelancerProfile->languages->count())

                                <div class="mt-5 grid gap-3 sm:grid-cols-2">

                                    @foreach ($freelancerProfile->languages as $language)

                                        <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                                                <i class="bi bi-translate"></i>
                                            </div>

                                            <div class="min-w-0">

                                                <p class="break-words text-sm font-semibold text-slate-900">
                                                    {{ $language->language }}
                                                </p>

                                                @if ($language->level)

                                                    <p class="mt-1 break-words text-xs text-slate-400">
                                                        {{ $language->level }}
                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <p class="mt-5 text-sm text-slate-400">
                                    Belum ada bahasa.
                                </p>

                            @endif

                        </section>

                    </div>

                </section>


                {{-- ================================================= --}}
                {{-- PANEL 3 : PENGALAMAN --}}
                {{-- ================================================= --}}
                <section
                    x-ref="panel-pengalaman"
                    :class="panelClass(2)"
                    class="jasain-slider-panel"
                >

                    <section
                        class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6"
                    >

                        <div class="border-b border-slate-100 pb-5">

                            <h2 class="text-lg font-semibold text-slate-900">
                                Pengalaman
                            </h2>

                            <p class="mt-1 text-sm text-slate-400">
                                Pengalaman profesional freelancer.
                            </p>

                        </div>


                        @if ($freelancerProfile->experiences->count())

                            <div class="pt-6">

                                <div class="space-y-7">

                                    @foreach ($freelancerProfile->experiences as $experience)

                                        <div class="flex gap-3 sm:gap-4">

                                            {{-- TIMELINE --}}
                                            <div class="flex shrink-0 flex-col items-center">

                                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                                    <i class="bi bi-briefcase"></i>
                                                </div>

                                                @unless ($loop->last)

                                                    <div class="mt-2 h-full w-px bg-slate-200"></div>

                                                @endunless

                                            </div>


                                            {{-- EXPERIENCE --}}
                                            <div class="min-w-0 flex-1 pb-1">

                                                <h3 class="break-words text-sm font-semibold text-slate-900 sm:text-[15px]">
                                                    {{ $experience->position }}
                                                </h3>

                                                @if ($experience->company)

                                                    <p class="mt-1 break-words text-sm font-medium text-slate-600">
                                                        {{ $experience->company }}
                                                    </p>

                                                @endif

                                                <p class="mt-1 text-xs text-slate-400">
                                                    {{ $experience->start_year }}
                                                    -
                                                    {{ $experience->end_year ?: 'Sekarang' }}
                                                </p>


                                                @if ($experience->description)

                                                    <p class="mt-3 break-words whitespace-pre-line text-sm leading-6 text-slate-600">
                                                        {{ $experience->description }}
                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @else

                            <div class="mt-6 rounded-xl border border-dashed border-slate-200 bg-slate-50 px-4 py-10 text-center">

                                <i class="bi bi-briefcase text-2xl text-slate-300"></i>

                                <p class="mt-3 text-sm font-semibold text-slate-600">
                                    Belum ada pengalaman profesional.
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    Pengalaman kerja akan ditampilkan di sini.
                                </p>

                            </div>

                        @endif

                    </section>

                </section>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- SINGLE SIDEBAR --}}
        {{-- ================================================= --}}
        <aside class="space-y-5 lg:sticky lg:top-6">

            {{-- PROFILE SUMMARY --}}
            <section
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
            >

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i class="bi bi-person-check"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-base font-semibold text-slate-900">
                            Profil Freelancer
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Ringkasan profil kamu
                        </p>

                    </div>

                </div>


                <div class="mt-5 space-y-4">

                    <div class="flex items-start justify-between gap-3">

                        <span class="text-sm text-slate-500">
                            Status
                        </span>

                        <span
                            class="inline-flex items-center gap-1.5 text-sm font-semibold {{ $freelancerProfile->is_available ? 'text-blue-600' : 'text-slate-500' }}"
                        >

                            <span
                                class="h-2 w-2 rounded-full {{ $freelancerProfile->is_available ? 'bg-blue-500' : 'bg-slate-400' }}"
                            ></span>

                            {{ $freelancerProfile->is_available ? 'Tersedia' : 'Offline' }}

                        </span>

                    </div>


                    <div class="flex items-start justify-between gap-3">

                        <span class="text-sm text-slate-500">
                            Rating
                        </span>

                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-900">

                            <i class="bi bi-star-fill text-amber-400"></i>

                            {{ number_format($freelancerProfile->rating, 1) }}

                        </span>

                    </div>


                    <div class="flex items-start justify-between gap-3">

                        <span class="text-sm text-slate-500">
                            Pesanan selesai
                        </span>

                        <span class="text-sm font-semibold text-slate-900">
                            {{ number_format($freelancerProfile->completed_orders) }}
                        </span>

                    </div>


                    <div class="flex items-start justify-between gap-3">

                        <span class="text-sm text-slate-500">
                            Total layanan
                        </span>

                        <span class="text-sm font-semibold text-slate-900">
                            {{ $freelancerProfile->services->count() }}
                        </span>

                    </div>

                </div>

            </section>


            {{-- INFORMATION --}}
            <section
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
            >

                <h2 class="text-base font-semibold text-slate-900">
                    Informasi
                </h2>


                <div class="mt-5 space-y-4">

                    {{-- LOCATION --}}
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i class="bi bi-geo-alt"></i>
                        </div>

                        <div class="min-w-0">

                            <p class="text-xs text-slate-400">
                                Lokasi
                            </p>

                            <p class="mt-1 break-words text-sm font-medium text-slate-700">
                                {{ $freelancerProfile->location ?: 'Belum diisi' }}
                            </p>

                        </div>

                    </div>


                    {{-- EMAIL --}}
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i class="bi bi-envelope"></i>
                        </div>

                        <div class="min-w-0">

                            <p class="text-xs text-slate-400">
                                Email
                            </p>

                            <p class="mt-1 break-all text-sm font-medium text-slate-700">
                                {{ $user->email }}
                            </p>

                        </div>

                    </div>


                    {{-- WEBSITE --}}
                    @if ($freelancerProfile->website)

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <i class="bi bi-globe2"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-xs text-slate-400">
                                    Website
                                </p>

                                <a
                                    href="{{ $freelancerProfile->website }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="mt-1 block truncate text-sm font-medium text-blue-600 hover:text-blue-700"
                                >
                                    {{ $freelancerProfile->website }}
                                </a>

                            </div>

                        </div>

                    @endif

                </div>

            </section>


            {{-- EDIT PROFILE --}}
            <section
                class="rounded-2xl border border-blue-100 bg-blue-50 p-5"
            >

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-sm font-semibold text-slate-900">
                            Perbarui Profil
                        </h2>

                        <p class="mt-1 break-words text-xs leading-5 text-slate-500">
                            Lengkapi informasi, pengalaman, skill, dan data profesional kamu.
                        </p>

                    </div>

                </div>


                <a
                    href="{{ route('freelancer.profile.edit') }}"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
                >
                    Edit profil
                    <i class="bi bi-arrow-right"></i>
                </a>

            </section>

        </aside>

    </div>

</div>


</x-layouts.freelancer>
