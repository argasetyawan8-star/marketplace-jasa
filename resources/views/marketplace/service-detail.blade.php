<x-layouts.marketplace :title="$service->title . ' - ProKerja'">

@php
    $freelancer = $service->freelancerProfile;
    $freelancerUser = $freelancer?->user;

    $serviceImage = $service->thumbnail
        ? asset('storage/' . ltrim($service->thumbnail, '/'))
        : null;

    $freelancerAvatar = $freelancer?->avatar
        ? asset('storage/' . ltrim($freelancer->avatar, '/'))
        : null;

    $freelancerName = $freelancerUser?->name ?? 'Freelancer';
    $freelancerUsername = $freelancer?->username;

    $isOwnService = auth()->check()
        && $freelancerUser
        && auth()->id() === $freelancerUser->id;

    /*
    |--------------------------------------------------------------------------
    | BUYER RULE
    |--------------------------------------------------------------------------
    | Client dan Freelancer sama-sama dapat membeli jasa freelancer lain.
    | Freelancer tetap memiliki role freelancer; konteksnya saja yang
    | berubah menjadi buyer ketika melakukan pembelian.
    */
    $canBuyService = auth()->check()
        && in_array(
            auth()->user()->role,
            ['client', 'freelancer'],
            true
        )
        && !$isOwnService;

    $isFavorited = (bool) ($service->is_favorited ?? false);

    $reviews = isset($reviews)
        ? collect($reviews)
        : collect();

    $relatedServices = isset($relatedServices)
        ? collect($relatedServices)
        : collect();

    $rating = (float) (
        $service->rating
        ?? $service->average_rating
        ?? 0
    );

    $reviewCount = (int) (
        $service->reviews_count
        ?? $service->review_count
        ?? $reviews->count()
    );

    $startingPrice = (float) (
        $service->starting_price
        ?? $service->price
        ?? 0
    );

    $deliveryDays = (int) (
        $service->delivery_days
        ?? 0
    );

    $categoryName = $service->category?->name ?? 'Layanan Profesional';
    $categorySlug = $service->category?->slug;

    $ratingLabel = $rating > 0
        ? number_format($rating, 1)
        : 'Baru';
@endphp

<style>
    .pk-service-page {
        background:
            linear-gradient(180deg, #F8FBFF 0%, #F8FAFC 28%, #F8FAFC 100%);
    }

    .pk-service-card {
        border: 1px solid #E2E8F0;
        background: #FFFFFF;
        box-shadow: 0 8px 28px rgba(15, 23, 42, 0.035);
    }

    .pk-service-soft-card {
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
    }

    .pk-hover-card {
        transition:
            transform .25s ease,
            box-shadow .25s ease,
            border-color .25s ease;
    }

    .pk-hover-card:hover {
        transform: translateY(-2px);
        border-color: #BFDBFE;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.07);
    }

    .pk-service-image {
        transition: transform .6s cubic-bezier(.22, 1, .36, 1);
    }

    .pk-service-media:hover .pk-service-image {
        transform: scale(1.025);
    }

    .pk-service-prose {
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    @media (max-width: 1023px) {
        .pk-service-page {
            padding-bottom: 2rem;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .pk-hover-card,
        .pk-service-image {
            transition: none !important;
        }

        .pk-hover-card:hover,
        .pk-service-media:hover .pk-service-image {
            transform: none !important;
        }
    }
</style>

<div class="pk-service-page min-h-screen text-slate-900">

    {{-- =========================================================
        BREADCRUMB
    ========================================================== --}}
    <div class="border-b border-slate-200/80 bg-white/90 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 py-3.5 sm:px-6 lg:px-8">
            <nav
                class="flex min-w-0 items-center gap-2 overflow-hidden text-[10px] sm:text-[11px]"
                aria-label="Breadcrumb"
            >
                <a
                    href="{{ route('marketplace.home') }}"
                    class="shrink-0 font-medium text-slate-400 transition hover:text-blue-600"
                >
                    Beranda
                </a>

                <i class="bi bi-chevron-right shrink-0 text-[7px] text-slate-300"></i>

                @if ($categorySlug)
                    <a
                        href="{{ route('marketplace.category', $categorySlug) }}"
                        class="max-w-[30vw] shrink-0 truncate font-medium text-slate-400 transition hover:text-blue-600 sm:max-w-none"
                    >
                        {{ $categoryName }}
                    </a>

                    <i class="bi bi-chevron-right shrink-0 text-[7px] text-slate-300"></i>
                @endif

                <span class="min-w-0 truncate font-semibold text-slate-600">
                    {{ $service->title }}
                </span>
            </nav>
        </div>
    </div>


    {{-- =========================================================
        MAIN
    ========================================================== --}}
    <main>
        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 sm:py-8 lg:px-8 lg:py-10">

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_360px] lg:items-start lg:gap-8">

                {{-- =====================================================
                    LEFT COLUMN
                ====================================================== --}}
                <div class="min-w-0 space-y-5 sm:space-y-6">

                    {{-- -------------------------------------------------
                        HERO MEDIA
                    -------------------------------------------------- --}}
                    <section class="pk-service-card pk-service-media overflow-hidden rounded-[24px] sm:rounded-[28px]">
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100 sm:aspect-[16/8.7]">

                            @if ($serviceImage)
                                <img
                                    src="{{ $serviceImage }}"
                                    alt="{{ $service->title }}"
                                    class="pk-service-image h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 to-slate-100 text-blue-500">
                                    <i class="bi bi-image text-4xl"></i>
                                </div>
                            @endif

                            <div class="pointer-events-none absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/15 to-transparent"></div>

                            <div class="absolute left-3 top-3 flex flex-wrap gap-2 sm:left-4 sm:top-4">
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-white/70 bg-white/92 px-3 py-1.5 text-[9px] font-bold text-slate-700 shadow-sm backdrop-blur">
                                    <i class="bi bi-grid text-blue-600"></i>
                                    {{ $categoryName }}
                                </span>

                                @if ($service->is_featured ?? false)
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-white/70 bg-white/92 px-3 py-1.5 text-[9px] font-bold text-blue-600 shadow-sm backdrop-blur">
                                        <i class="bi bi-stars"></i>
                                        Pilihan ProKerja
                                    </span>
                                @endif
                            </div>
                        </div>
                    </section>


                    {{-- -------------------------------------------------
                        SERVICE SUMMARY
                    -------------------------------------------------- --}}
                    <section class="pk-service-card rounded-[24px] p-5 sm:rounded-[28px] sm:p-7 lg:p-8">

                        <div class="flex flex-wrap items-center gap-2">
                            @if ($freelancer?->is_verified)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1.5 text-[9px] font-bold text-emerald-700">
                                    <i class="bi bi-patch-check-fill"></i>
                                    Freelancer terverifikasi
                                </span>
                            @endif

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1.5 text-[9px] font-bold text-blue-600">
                                <i class="bi bi-shield-check"></i>
                                Transaksi melalui ProKerja
                            </span>
                        </div>

                        <h1 class="mt-4 max-w-4xl text-[23px] font-extrabold leading-tight tracking-[-0.03em] text-slate-900 sm:text-3xl lg:text-[34px] lg:leading-[1.16]">
                            {{ $service->title }}
                        </h1>

                        {{-- Stats --}}
                        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2.5 text-[11px] text-slate-500 sm:text-xs">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="bi bi-star-fill text-amber-400"></i>
                                <strong class="font-bold text-slate-800">{{ $ratingLabel }}</strong>
                                @if ($reviewCount > 0)
                                    <span>({{ number_format($reviewCount) }} ulasan)</span>
                                @endif
                            </span>

                            <span class="hidden h-3.5 w-px bg-slate-200 sm:block"></span>

                            <span class="inline-flex items-center gap-1.5">
                                <i class="bi bi-bag-check text-slate-400"></i>
                                <span><strong class="font-semibold text-slate-700">{{ number_format((int) ($service->orders_count ?? 0)) }}</strong> order</span>
                            </span>

                            @if ($deliveryDays > 0)
                                <span class="hidden h-3.5 w-px bg-slate-200 sm:block"></span>

                                <span class="inline-flex items-center gap-1.5">
                                    <i class="bi bi-clock text-slate-400"></i>
                                    Maks. {{ $deliveryDays }} hari
                                </span>
                            @endif
                        </div>

                        <div class="my-6 h-px bg-slate-100"></div>

                        {{-- Description --}}
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi bi-file-text"></i>
                                </div>

                                <div>
                                    <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                                        Detail layanan
                                    </p>
                                    <h2 class="mt-0.5 text-base font-extrabold text-slate-900 sm:text-lg">
                                        Tentang jasa ini
                                    </h2>
                                </div>
                            </div>

                            <div class="pk-service-prose mt-4 whitespace-pre-line text-[13px] leading-7 text-slate-600 sm:text-sm sm:leading-7">
                                {{ $service->description ?: 'Belum ada deskripsi jasa.' }}
                            </div>
                        </div>
                    </section>


                    {{-- -------------------------------------------------
                        FREELANCER CARD
                    -------------------------------------------------- --}}
                    <section class="pk-service-card rounded-[24px] p-5 sm:rounded-[28px] sm:p-7">

                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                                    Penyedia jasa
                                </p>
                                <h2 class="mt-1 text-lg font-extrabold tracking-[-0.02em] text-slate-900">
                                    Freelancer
                                </h2>
                            </div>

                            @if ($freelancerUsername)
                                <a
                                    href="{{ route('marketplace.freelancer', $freelancerUsername) }}"
                                    class="hidden items-center gap-1.5 rounded-xl px-3 py-2 text-[10px] font-bold text-blue-600 transition hover:bg-blue-50 sm:inline-flex"
                                >
                                    Lihat profil
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>
                            @endif
                        </div>

                        <div class="mt-5 flex items-start gap-4">
                            <a
                                href="{{ $freelancerUsername ? route('marketplace.freelancer', $freelancerUsername) : '#' }}"
                                class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-blue-100 text-lg font-extrabold text-blue-700 ring-4 ring-blue-50 sm:h-[72px] sm:w-[72px] sm:rounded-3xl"
                            >
                                @if ($freelancerAvatar)
                                    <img
                                        src="{{ $freelancerAvatar }}"
                                        alt="{{ $freelancerName }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    {{ strtoupper(mb_substr($freelancerName, 0, 1)) }}
                                @endif
                            </a>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <a
                                        href="{{ $freelancerUsername ? route('marketplace.freelancer', $freelancerUsername) : '#' }}"
                                        class="truncate text-[15px] font-extrabold text-slate-900 transition hover:text-blue-600 sm:text-base"
                                    >
                                        {{ $freelancerName }}
                                    </a>

                                    @if ($freelancer?->is_verified)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-1 text-[8px] font-bold text-blue-600">
                                            <i class="bi bi-patch-check-fill"></i>
                                            Verified
                                        </span>
                                    @endif
                                </div>

                                @if ($freelancerUsername)
                                    <p class="mt-1 text-[10px] font-medium text-slate-400">
                                        @{{ ltrim($freelancerUsername, '@') }}
                                    </p>
                                @endif

                                @if ($freelancer?->headline)
                                    <p class="mt-2.5 line-clamp-2 max-w-2xl text-xs leading-5 text-slate-500">
                                        {{ $freelancer->headline }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-2.5 sm:grid-cols-3">
                            <div class="rounded-2xl bg-slate-50 px-3 py-3.5 text-center">
                                <p class="text-[8px] font-bold uppercase tracking-[0.1em] text-slate-400">Rating</p>
                                <div class="mt-1 inline-flex items-center gap-1 text-sm font-extrabold text-slate-900">
                                    <i class="bi bi-star-fill text-[10px] text-amber-400"></i>
                                    {{ number_format((float) ($freelancer?->rating ?? 0), 1) }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 px-3 py-3.5 text-center">
                                <p class="text-[8px] font-bold uppercase tracking-[0.1em] text-slate-400">Selesai</p>
                                <p class="mt-1 text-sm font-extrabold text-slate-900">
                                    {{ number_format((int) ($freelancer?->completed_orders ?? 0)) }}
                                </p>
                            </div>

                            <div class="col-span-2 rounded-2xl bg-slate-50 px-3 py-3.5 text-center sm:col-span-1">
                                <p class="text-[8px] font-bold uppercase tracking-[0.1em] text-slate-400">Status</p>
                                <p class="mt-1 text-xs font-bold text-emerald-700">
                                    <i class="bi bi-circle-fill mr-1 text-[6px]"></i>
                                    Aktif
                                </p>
                            </div>
                        </div>

                        @if ($freelancerUsername)
                            <a
                                href="{{ route('marketplace.freelancer', $freelancerUsername) }}"
                                class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-xs font-bold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 sm:hidden"
                            >
                                Lihat profil freelancer
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    </section>


                    {{-- -------------------------------------------------
                        REVIEWS
                    -------------------------------------------------- --}}
                    <section class="pk-service-card rounded-[24px] p-5 sm:rounded-[28px] sm:p-7">

                        <div class="flex items-start justify-between gap-5">
                            <div>
                                <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                                    Ulasan pembeli
                                </p>
                                <h2 class="mt-1 text-lg font-extrabold tracking-[-0.02em] text-slate-900 sm:text-xl">
                                    Apa kata mereka?
                                </h2>
                                <p class="mt-1 text-[11px] leading-5 text-slate-400">
                                    Pengalaman pengguna setelah menggunakan layanan ini.
                                </p>
                            </div>

                            <div class="shrink-0 rounded-2xl bg-slate-50 px-3.5 py-3 text-center sm:px-4">
                                <p class="text-lg font-extrabold text-slate-900">
                                    {{ $ratingLabel }}
                                </p>
                                <div class="mt-1 flex items-center justify-center gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill text-[8px] {{ $i <= round($rating) ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        @forelse ($reviews->take(6) as $review)
                            @php
                                $reviewUser = $review->user ?? null;
                                $reviewName = $reviewUser?->name ?? ($review->name ?? 'Pengguna ProKerja');
                                $reviewText = $review->comment ?? $review->message ?? $review->content ?? '';
                                $reviewRating = (int) ($review->rating ?? 5);
                                $reviewInitial = strtoupper(mb_substr($reviewName, 0, 1));
                                $reviewAvatar = $reviewUser?->avatar
                                    ? asset('storage/' . ltrim($reviewUser->avatar, '/'))
                                    : null;
                            @endphp

                            <article class="mt-5 border-t border-slate-100 pt-5">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-blue-100 text-xs font-extrabold text-blue-700">
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
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="min-w-0">
                                                <p class="truncate text-xs font-extrabold text-slate-900">
                                                    {{ $reviewName }}
                                                </p>

                                                <div class="mt-1 flex items-center gap-0.5">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star-fill text-[8px] {{ $i <= $reviewRating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>

                                            <span class="shrink-0 text-[9px] text-slate-400">
                                                {{ optional($review->created_at)->format('d M Y') }}
                                            </span>
                                        </div>

                                        @if ($reviewText)
                                            <p class="mt-3 whitespace-pre-line break-words text-xs leading-5 text-slate-600">
                                                “{{ $reviewText }}”
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="mt-5 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-5 py-9 text-center">
                                <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-white text-slate-300 shadow-sm">
                                    <i class="bi bi-chat-square-text"></i>
                                </div>
                                <p class="mt-3 text-xs font-semibold text-slate-500">
                                    Belum ada ulasan untuk jasa ini.
                                </p>
                                <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                    Ulasan akan muncul setelah pembeli menyelesaikan transaksi.
                                </p>
                            </div>
                        @endforelse
                    </section>

                </div>


                {{-- =====================================================
                    RIGHT COLUMN
                ====================================================== --}}
                <aside class="min-w-0 lg:sticky lg:top-24 lg:self-start">

                    <div class="space-y-4">

                        {{-- PURCHASE CARD --}}
                        <section class="overflow-hidden rounded-[24px] border border-blue-100 bg-white shadow-[0_16px_40px_rgba(37,99,235,0.09)] sm:rounded-[28px]">

                            <div class="border-b border-slate-100 bg-gradient-to-br from-blue-50 via-white to-white px-5 pb-5 pt-5 sm:px-6 sm:pt-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-[9px] font-bold uppercase tracking-[0.17em] text-blue-600">
                                            Harga layanan
                                        </p>
                                        <p class="mt-1 text-[11px] text-slate-400">
                                            Mulai dari paket dasar
                                        </p>
                                    </div>

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm ring-1 ring-blue-100">
                                        <i class="bi bi-bag-check"></i>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-wrap items-end justify-between gap-3">
                                    <p class="text-[27px] font-extrabold tracking-[-0.04em] text-slate-900 sm:text-[30px]">
                                        Rp {{ number_format($startingPrice, 0, ',', '.') }}
                                    </p>

                                    @if ($deliveryDays > 0)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1.5 text-[9px] font-bold text-slate-500 shadow-sm ring-1 ring-slate-100">
                                            <i class="bi bi-clock text-blue-500"></i>
                                            {{ $deliveryDays }} hari
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-5 sm:p-6">

                                @auth

                                    @if ($canBuyService)

                                        <form
                                            action="{{ route('client.messages.start', ['service' => $service]) }}"
                                            method="POST"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="group inline-flex w-full items-center justify-center gap-2.5 rounded-2xl bg-blue-600 px-5 py-3.5 text-sm font-extrabold text-white shadow-[0_10px_22px_rgba(37,99,235,0.22)] transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-[0_13px_25px_rgba(37,99,235,0.25)] active:translate-y-0"
                                            >
                                                <i class="bi bi-chat-dots-fill text-[15px] transition duration-200 group-hover:scale-110"></i>
                                                Pesan Jasa
                                                <i class="bi bi-arrow-right ml-auto text-xs opacity-75 transition group-hover:translate-x-0.5"></i>
                                            </button>
                                        </form>

                                        <div class="mt-3 flex items-start gap-2.5 rounded-2xl bg-slate-50 px-3.5 py-3">
                                            <i class="bi bi-chat-square-text mt-0.5 text-blue-500"></i>
                                            <p class="text-[10px] leading-4.5 text-slate-500">
                                                Diskusikan kebutuhan, detail pekerjaan, harga, dan waktu pengerjaan terlebih dahulu melalui chat.
                                            </p>
                                        </div>

                                    @elseif ($isOwnService)

                                        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4">
                                            <div class="flex items-start gap-3">
                                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm">
                                                    <i class="bi bi-exclamation-circle"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-extrabold text-amber-800">
                                                        Ini jasa milikmu
                                                    </p>
                                                    <p class="mt-1 text-[10px] leading-4 text-amber-700">
                                                        Jasa sendiri tidak dapat dibeli oleh pemiliknya.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    @else

                                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                                            <p class="text-xs font-extrabold text-slate-800">
                                                Akun belum dapat membeli jasa
                                            </p>
                                            <p class="mt-1 text-[10px] leading-4 text-slate-500">
                                                Gunakan akun Client atau Freelancer untuk melanjutkan.
                                            </p>
                                        </div>

                                    @endif

                                @else

                                    <a
                                        href="{{ route('login') }}"
                                        class="group inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-600 px-5 py-3.5 text-sm font-extrabold text-white shadow-[0_10px_22px_rgba(37,99,235,0.22)] transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700"
                                    >
                                        <i class="bi bi-chat-dots-fill"></i>
                                        Masuk untuk Pesan
                                        <i class="bi bi-arrow-right ml-auto text-xs opacity-75 transition group-hover:translate-x-0.5"></i>
                                    </a>

                                    <p class="mt-2.5 text-center text-[10px] leading-4 text-slate-400">
                                        Setelah masuk, kamu akan diarahkan ke chat dengan freelancer.
                                    </p>

                                @endauth

                                {{-- Trust points --}}
                                <div class="mt-5 grid grid-cols-3 gap-2">
                                    <div class="rounded-2xl border border-slate-100 bg-slate-50 px-2 py-3 text-center">
                                        <div class="mx-auto flex h-8 w-8 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                                            <i class="bi bi-chat-square-text text-xs"></i>
                                        </div>
                                        <p class="mt-2 text-[8px] font-bold text-slate-500">Diskusi</p>
                                    </div>

                                    <div class="rounded-2xl border border-slate-100 bg-slate-50 px-2 py-3 text-center">
                                        <div class="mx-auto flex h-8 w-8 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                                            <i class="bi bi-shield-check text-xs"></i>
                                        </div>
                                        <p class="mt-2 text-[8px] font-bold text-slate-500">Terstruktur</p>
                                    </div>

                                    <div class="rounded-2xl border border-slate-100 bg-slate-50 px-2 py-3 text-center">
                                        <div class="mx-auto flex h-8 w-8 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                                            <i class="bi bi-arrow-repeat text-xs"></i>
                                        </div>
                                        <p class="mt-2 text-[8px] font-bold text-slate-500">Revisi</p>
                                    </div>
                                </div>
                            </div>
                        </section>


                        {{-- FAVORITE --}}
                        @auth
                            @if (auth()->user()->role === 'client')
                                <section class="pk-service-card rounded-2xl p-3.5">
                                    @if ($isFavorited)
                                        <form
                                            action="{{ route('client.favorites.destroy', $service) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-50 px-4 py-3 text-xs font-bold text-red-600 transition hover:bg-red-100"
                                            >
                                                <i class="bi bi-heart-fill"></i>
                                                Hapus dari favorit
                                            </button>
                                        </form>
                                    @else
                                        <form
                                            action="{{ route('client.favorites.store', $service) }}"
                                            method="POST"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-xs font-bold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                            >
                                                <i class="bi bi-heart"></i>
                                                Simpan ke favorit
                                            </button>
                                        </form>
                                    @endif
                                </section>
                            @endif
                        @endauth


                        {{-- SERVICE INFO --}}
                        <section class="pk-service-card rounded-2xl p-5">
                            <div class="flex items-center gap-2">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi bi-info-circle"></i>
                                </div>

                                <div>
                                    <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-blue-600">
                                        Ringkasan
                                    </p>
                                    <h2 class="mt-0.5 text-sm font-extrabold text-slate-900">
                                        Informasi jasa
                                    </h2>
                                </div>
                            </div>

                            <div class="mt-4 divide-y divide-slate-100">
                                <div class="flex items-center justify-between gap-4 py-3 first:pt-0">
                                    <span class="text-[11px] text-slate-400">Harga mulai</span>
                                    <span class="text-xs font-extrabold text-slate-800">
                                        Rp {{ number_format($startingPrice, 0, ',', '.') }}
                                    </span>
                                </div>

                                @if ($deliveryDays > 0)
                                    <div class="flex items-center justify-between gap-4 py-3">
                                        <span class="text-[11px] text-slate-400">Pengerjaan</span>
                                        <span class="text-xs font-extrabold text-slate-800">
                                            {{ $deliveryDays }} hari
                                        </span>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between gap-4 py-3">
                                    <span class="text-[11px] text-slate-400">Rating</span>
                                    <span class="inline-flex items-center gap-1 text-xs font-extrabold text-slate-800">
                                        <i class="bi bi-star-fill text-[10px] text-amber-400"></i>
                                        {{ $ratingLabel }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-4 py-3 last:pb-0">
                                    <span class="text-[11px] text-slate-400">Jumlah order</span>
                                    <span class="text-xs font-extrabold text-slate-800">
                                        {{ number_format((int) ($service->orders_count ?? 0)) }}
                                    </span>
                                </div>
                            </div>
                        </section>


                        {{-- HOW IT WORKS --}}
                        <section class="rounded-2xl border border-blue-100 bg-blue-50/70 p-5">
                            <div class="flex items-start gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                </div>

                                <div>
                                    <h2 class="text-xs font-extrabold text-slate-900">
                                        Cara mulai
                                    </h2>
                                    <p class="mt-1 text-[10px] leading-4.5 text-slate-500">
                                        Pesan jasa dimulai dari diskusi. Setelah detail disepakati, freelancer dapat mengirim penawaran melalui chat.
                                    </p>
                                </div>
                            </div>
                        </section>

                    </div>
                </aside>

            </div>


            {{-- =====================================================
                RELATED SERVICES
            ====================================================== --}}
            @if ($relatedServices->isNotEmpty())
                <section class="mt-10 sm:mt-12">
                    <div class="flex items-end justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                                Rekomendasi
                            </p>
                            <h2 class="mt-1 text-xl font-extrabold tracking-[-0.025em] text-slate-900 sm:text-2xl">
                                Jasa serupa
                            </h2>
                            <p class="mt-1.5 text-xs leading-5 text-slate-400">
                                Layanan lain yang masih relevan dengan kebutuhanmu.
                            </p>
                        </div>

                        <a
                            href="{{ route('marketplace.search') }}"
                            class="hidden shrink-0 items-center gap-1.5 rounded-xl px-3 py-2 text-[10px] font-bold text-blue-600 transition hover:bg-blue-50 sm:inline-flex"
                        >
                            Lihat semua
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-3.5 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4">
                        @foreach ($relatedServices->take(8) as $related)
                            @php
                                $relatedImage = $related->thumbnail
                                    ? asset('storage/' . ltrim($related->thumbnail, '/'))
                                    : null;

                                $relatedFreelancer = $related->freelancerProfile?->user?->name
                                    ?? 'Freelancer';

                                $relatedRating = (float) ($related->rating ?? $related->average_rating ?? 0);
                                $relatedPrice = (float) ($related->starting_price ?? $related->price ?? 0);
                            @endphp

                            <a
                                href="{{ route('marketplace.service', $related->slug) }}"
                                class="pk-hover-card group overflow-hidden rounded-2xl border border-slate-200 bg-white"
                            >
                                <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                                    @if ($relatedImage)
                                        <img
                                            src="{{ $relatedImage }}"
                                            alt="{{ $related->title }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-blue-50 text-blue-500">
                                            <i class="bi bi-image text-2xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-3.5 sm:p-4">
                                    <p class="truncate text-[10px] font-semibold text-slate-400">
                                        {{ $relatedFreelancer }}
                                    </p>

                                    <h3 class="mt-2 line-clamp-2 text-[12px] font-extrabold leading-5 text-slate-900 transition group-hover:text-blue-600 sm:text-sm">
                                        {{ $related->title }}
                                    </h3>

                                    <div class="mt-3.5 flex items-center justify-between gap-2">
                                        <span class="inline-flex items-center gap-1 text-[9px] font-semibold text-slate-500 sm:text-[10px]">
                                            <i class="bi bi-star-fill text-amber-400"></i>
                                            {{ $relatedRating > 0 ? number_format($relatedRating, 1) : 'Baru' }}
                                        </span>

                                        <span class="truncate text-[11px] font-extrabold text-slate-900 sm:text-xs">
                                            Rp {{ number_format($relatedPrice, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <a
                        href="{{ route('marketplace.search') }}"
                        class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-xs font-bold text-slate-700 sm:hidden"
                    >
                        Lihat semua jasa
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </section>
            @endif

        </div>
    </main>

</div>

</x-layouts.marketplace>
