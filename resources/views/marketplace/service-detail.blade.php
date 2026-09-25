<x-layouts.marketplace :title="$service->title . ' - ProKerja'">


@php
    $freelancer = $service->freelancerProfile;
    $user = $freelancer?->user;

    $serviceImage = $service->thumbnail
        ? asset('storage/' . $service->thumbnail)
        : null;

    $freelancerAvatar = $freelancer?->avatar
        ? asset('storage/' . $freelancer->avatar)
        : null;

    $isOwnService = auth()->check()
        && $user
        && auth()->id() === $user->id;

    $isFavorited = (bool) ($service->is_favorited ?? false);
@endphp

<div
    x-data="{ favoriteLoading: false }"
    class="min-h-screen bg-white pt-[48px] md:pt-[52px]"
>

    {{-- =========================================================
        BREADCRUMB
    ========================================================== --}}
    <div class="border-b border-[#E2E8F0] bg-white">

        <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">

            <nav class="flex min-w-0 items-center gap-2 overflow-hidden text-[11px] text-[#64748B]">

                <a
                    href="{{ route('marketplace.home') }}"
                    class="shrink-0 transition hover:text-[#2563EB]"
                >
                    Beranda
                </a>

                <i class="bi bi-chevron-right shrink-0 text-[8px] text-[#94A3B8]"></i>

                @if ($service->category)

                    <a
                        href="{{ route('marketplace.category', $service->category->slug) }}"
                        class="max-w-[150px] shrink-0 truncate transition hover:text-[#2563EB]"
                    >
                        {{ $service->category->name }}
                    </a>

                @endif

                @if ($service->subcategory)

                    <i class="bi bi-chevron-right shrink-0 text-[8px] text-[#94A3B8]"></i>

                    <span class="max-w-[150px] shrink-0 truncate">
                        {{ $service->subcategory->name }}
                    </span>

                @endif

                <i class="bi bi-chevron-right shrink-0 text-[8px] text-[#94A3B8]"></i>

                <span class="min-w-0 truncate font-medium text-[#0F172A]">
                    {{ $service->title }}
                </span>

            </nav>

        </div>

    </div>


    {{-- =========================================================
        MAIN SERVICE
    ========================================================== --}}
    <main>

        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8 lg:py-10">

            <div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_330px] xl:gap-14">

                {{-- =================================================
                    LEFT
                ================================================== --}}
                <div class="min-w-0">

                    {{-- =================================================
                        SERVICE MEDIA
                    ================================================== --}}
                    <div class="relative">

                        @if ($serviceImage)

                            <div class="overflow-hidden rounded-xl bg-[#F1F5F9]">

                                <img
                                    src="{{ $serviceImage }}"
                                    alt="{{ $service->title }}"
                                    class="block aspect-[16/8] w-full object-cover"
                                >

                            </div>

                        @else

                            <div class="flex aspect-[16/8] items-center justify-center rounded-xl bg-[#EFF6FF]">

                                <div class="text-center">

                                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-[#2563EB] shadow-sm">
                                        <i class="bi bi-briefcase text-2xl"></i>
                                    </div>

                                    <p class="mt-3 text-xs font-semibold text-[#64748B]">
                                        {{ $service->category?->name ?? 'Jasa Profesional' }}
                                    </p>

                                </div>

                            </div>

                        @endif


                        @auth

                            @if (auth()->user()->role === 'client' && !$isOwnService)

                                @if ($isFavorited)

                                    <form
                                        action="{{ route('client.favorites.destroy', $service) }}"
                                        method="POST"
                                        class="absolute right-4 top-4"
                                        @submit="favoriteLoading = true"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            :disabled="favoriteLoading"
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-[#DC2626] shadow-md transition hover:bg-[#FEF2F2] disabled:opacity-60"
                                            aria-label="Hapus dari favorit"
                                        >
                                            <i class="bi bi-heart-fill"></i>
                                        </button>
                                    </form>

                                @else

                                    <form
                                        action="{{ route('client.favorites.store', $service) }}"
                                        method="POST"
                                        class="absolute right-4 top-4"
                                        @submit="favoriteLoading = true"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            :disabled="favoriteLoading"
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-[#475569] shadow-md transition hover:text-[#2563EB] disabled:opacity-60"
                                            aria-label="Tambah ke favorit"
                                        >
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </form>

                                @endif

                            @endif

                        @endauth

                    </div>


                    {{-- =================================================
                        SERVICE TITLE
                    ================================================== --}}
                    <section class="pt-7">

                        <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-[11px]">

                            <span class="inline-flex items-center gap-1.5 font-semibold text-[#0F172A]">
                                <i class="bi bi-star-fill text-[#F59E0B]"></i>
                                {{ number_format((float) $service->rating, 1) }}
                            </span>

                            <span class="text-[#CBD5E1]">•</span>

                            <span class="text-[#64748B]">
                                {{ $service->reviews_count }} review
                            </span>

                            <span class="text-[#CBD5E1]">•</span>

                            <span class="text-[#64748B]">
                                {{ $service->orders_count }} terjual
                            </span>

                            @if ($freelancer?->is_verified)

                                <span class="inline-flex items-center gap-1 text-[#2563EB]">
                                    <i class="bi bi-patch-check-fill"></i>
                                    Freelancer terverifikasi
                                </span>

                            @endif

                        </div>


                        <h1 class="mt-3 max-w-4xl text-[25px] font-bold leading-[1.3] tracking-[-0.025em] text-[#0F172A] sm:text-[32px]">
                            {{ $service->title }}
                        </h1>


                        <div class="mt-4 flex flex-wrap items-center gap-2">

                            @if ($service->category)

                                <a
                                    href="{{ route('marketplace.category', $service->category->slug) }}"
                                    class="text-[11px] font-medium text-[#2563EB] hover:underline"
                                >
                                    {{ $service->category->name }}
                                </a>

                            @endif

                            @if ($service->subcategory)

                                <span class="text-[#CBD5E1]">/</span>

                                <span class="text-[11px] text-[#64748B]">
                                    {{ $service->subcategory->name }}
                                </span>

                            @endif

                        </div>

                    </section>


                    {{-- =================================================
                        LOCAL NAV
                    ================================================== --}}
                    <div class="mt-7 border-y border-[#E2E8F0]">

                        <div class="flex items-center gap-6 overflow-x-auto whitespace-nowrap">

                            <a
                                href="#ringkasan"
                                class="border-b-2 border-[#2563EB] py-4 text-[12px] font-semibold text-[#2563EB]"
                            >
                                Ringkasan
                            </a>

                            <a
                                href="#paket"
                                class="py-4 text-[12px] font-medium text-[#64748B] transition hover:text-[#2563EB]"
                            >
                                Paket
                            </a>

                            <a
                                href="#freelancer"
                                class="py-4 text-[12px] font-medium text-[#64748B] transition hover:text-[#2563EB]"
                            >
                                Freelancer
                            </a>

                            <a
                                href="#ulasan"
                                class="py-4 text-[12px] font-medium text-[#64748B] transition hover:text-[#2563EB]"
                            >
                                Ulasan
                            </a>

                        </div>

                    </div>


                    {{-- =================================================
                        SUMMARY
                    ================================================== --}}
                    <section id="ringkasan" class="scroll-mt-28 pt-8">

                        <h2 class="text-lg font-bold text-[#0F172A]">
                            Tentang jasa ini
                        </h2>

                        <div class="mt-4 max-w-4xl whitespace-pre-line text-sm leading-7 text-[#475569]">
                            {{ $service->description }}
                        </div>

                    </section>


                    {{-- =================================================
                        PACKAGE
                    ================================================== --}}
                    <section id="paket" class="scroll-mt-28 border-t border-[#E2E8F0] pt-8 mt-9">

                        <div class="flex items-end justify-between gap-4">

                            <div>

                                <h2 class="text-lg font-bold text-[#0F172A]">
                                    Paket jasa
                                </h2>

                                <p class="mt-1 text-xs text-[#64748B]">
                                    Detail harga dan waktu pengerjaan layanan.
                                </p>

                            </div>

                        </div>


                        <div class="mt-5 border border-[#E2E8F0]">

                            <div class="border-b border-[#E2E8F0] bg-[#F8FAFC] px-5 py-4 sm:px-6">

                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                    <div>

                                        <p class="text-sm font-bold text-[#0F172A]">
                                            Paket layanan
                                        </p>

                                        <p class="mt-1 text-xs text-[#64748B]">
                                            Harga awal berdasarkan jasa yang ditawarkan freelancer.
                                        </p>

                                    </div>

                                    <p class="text-lg font-extrabold text-[#0F172A]">
                                        Rp{{ number_format($service->starting_price, 0, ',', '.') }}
                                    </p>

                                </div>

                            </div>


                            <div class="divide-y divide-[#E2E8F0]">

                                <div class="flex items-center justify-between gap-4 px-5 py-4 sm:px-6">

                                    <span class="text-xs text-[#64748B]">
                                        Waktu pengerjaan
                                    </span>

                                    <span class="text-xs font-semibold text-[#0F172A]">
                                        {{ $service->delivery_days }} hari
                                    </span>

                                </div>


                                <div class="flex items-center justify-between gap-4 px-5 py-4 sm:px-6">

                                    <span class="text-xs text-[#64748B]">
                                        Pesanan selesai
                                    </span>

                                    <span class="text-xs font-semibold text-[#0F172A]">
                                        {{ $service->orders_count }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between gap-4 px-5 py-4 sm:px-6">

                                    <span class="text-xs text-[#64748B]">
                                        Rating layanan
                                    </span>

                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-[#0F172A]">
                                        <i class="bi bi-star-fill text-[#F59E0B]"></i>
                                        {{ number_format((float) $service->rating, 1) }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        FREELANCER
                    ================================================== --}}
                    <section id="freelancer" class="scroll-mt-28 border-t border-[#E2E8F0] pt-8 mt-9">

                        <h2 class="text-lg font-bold text-[#0F172A]">
                            Freelancer
                        </h2>


                        @if ($freelancer && $user)

                            <div class="mt-5">

                                <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                                    <div class="flex min-w-0 items-start gap-4">

                                        @if ($freelancerAvatar)

                                            <img
                                                src="{{ $freelancerAvatar }}"
                                                alt="{{ $user->name }}"
                                                class="h-16 w-16 shrink-0 rounded-full object-cover"
                                            >

                                        @else

                                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#DBEAFE] text-lg font-bold text-[#2563EB]">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>

                                        @endif


                                        <div class="min-w-0">

                                            <div class="flex items-center gap-2">

                                                <h3 class="truncate text-base font-bold text-[#0F172A]">
                                                    {{ $user->name }}
                                                </h3>

                                                @if ($freelancer->is_verified)

                                                    <span class="text-[12px] text-[#2563EB]" title="Terverifikasi">
                                                        <i class="bi bi-patch-check-fill"></i>
                                                    </span>

                                                @endif

                                            </div>


                                            @if ($freelancer->headline)

                                                <p class="mt-1 text-xs text-[#64748B]">
                                                    {{ $freelancer->headline }}
                                                </p>

                                            @endif


                                            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-[11px] text-[#64748B]">

                                                <span>
                                                    <i class="bi bi-star-fill mr-1 text-[#F59E0B]"></i>
                                                    {{ number_format((float) $freelancer->rating, 1) }}
                                                </span>

                                                <span>
                                                    <i class="bi bi-bag-check mr-1"></i>
                                                    {{ $freelancer->completed_orders }} order selesai
                                                </span>

                                                @if ($freelancer->location)

                                                    <span>
                                                        <i class="bi bi-geo-alt mr-1"></i>
                                                        {{ $freelancer->location }}
                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                    </div>


                                    @if ($freelancer->username)

                                        <a
                                            href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                                            class="inline-flex h-9 shrink-0 items-center justify-center rounded-lg border border-[#CBD5E1] px-4 text-[11px] font-semibold text-[#334155] transition hover:border-[#93C5FD] hover:text-[#2563EB]"
                                        >
                                            Lihat profil
                                        </a>

                                    @endif

                                </div>


                                @if ($freelancer->bio)

                                    <div class="mt-5 max-w-3xl whitespace-pre-line text-sm leading-7 text-[#475569]">
                                        {{ $freelancer->bio }}
                                    </div>

                                @endif


                                <div class="mt-6 grid grid-cols-2 gap-5 border-t border-[#E2E8F0] pt-5 sm:grid-cols-3">

                                    <div>

                                        <p class="text-[10px] uppercase tracking-[0.1em] text-[#94A3B8]">
                                            Penyelesaian
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-[#0F172A]">
                                            {{ $freelancer->completed_orders ? 'Aktif' : 'Baru' }}
                                        </p>

                                    </div>


                                    <div>

                                        <p class="text-[10px] uppercase tracking-[0.1em] text-[#94A3B8]">
                                            Status
                                        </p>

                                        @if ($freelancer->is_available)

                                            <p class="mt-1 text-sm font-bold text-[#16A34A]">
                                                Tersedia
                                            </p>

                                        @else

                                            <p class="mt-1 text-sm font-bold text-[#DC2626]">
                                                Tidak tersedia
                                            </p>

                                        @endif

                                    </div>


                                    <div>

                                        <p class="text-[10px] uppercase tracking-[0.1em] text-[#94A3B8]">
                                            Order selesai
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-[#0F172A]">
                                            {{ $freelancer->completed_orders }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @else

                            <p class="mt-4 text-sm text-[#64748B]">
                                Informasi freelancer belum tersedia.
                            </p>

                        @endif

                    </section>


                    {{-- =================================================
                        REVIEWS
                    ================================================== --}}
                    <section id="ulasan" class="scroll-mt-28 border-t border-[#E2E8F0] pt-8 mt-9">

                        <h2 class="text-lg font-bold text-[#0F172A]">
                            Ulasan
                        </h2>


                        <div class="mt-5 flex flex-col gap-4 border-y border-[#E2E8F0] py-6 sm:flex-row sm:items-center sm:gap-10">

                            <div>

                                <p class="text-3xl font-extrabold text-[#0F172A]">
                                    {{ number_format((float) $service->rating, 1) }}
                                </p>

                                <div class="mt-1 flex items-center gap-1 text-[#F59E0B]">

                                    @for ($i = 1; $i <= 5; $i++)

                                        <i class="bi {{ $i <= round((float) $service->rating) ? 'bi-star-fill' : 'bi-star' }} text-[12px]"></i>

                                    @endfor

                                </div>

                                <p class="mt-1 text-[11px] text-[#64748B]">
                                    {{ $service->reviews_count }} ulasan
                                </p>

                            </div>


                            <div class="h-px w-full bg-[#E2E8F0] sm:h-12 sm:w-px"></div>


                            <p class="max-w-lg text-xs leading-5 text-[#64748B]">
                                Rating dan ulasan membantu client memahami pengalaman pengguna sebelumnya terhadap layanan ini.
                            </p>

                        </div>

                    </section>

                </div>


                {{-- =================================================
                    RIGHT PURCHASE AREA
                ================================================== --}}
                <aside>

                    <div class="lg:sticky lg:top-24">

                        <div class="border border-[#E2E8F0] bg-white">

                            {{-- PRICE --}}
                            <div class="p-5 sm:p-6">

                                <p class="text-[11px] font-medium text-[#64748B]">
                                    Harga awal
                                </p>

                                <p class="mt-1 text-[30px] font-extrabold tracking-tight text-[#0F172A]">
                                    Rp{{ number_format($service->starting_price, 0, ',', '.') }}
                                </p>


                                <div class="mt-3 flex items-center gap-2 text-[11px] text-[#64748B]">

                                    <i class="bi bi-clock"></i>

                                    <span>
                                        {{ $service->delivery_days }} hari pengerjaan
                                    </span>

                                </div>


                                <div class="mt-5 border-t border-[#E2E8F0] pt-5">

                                    <p class="text-xs leading-5 text-[#64748B]">
                                        Diskusikan kebutuhan project dengan freelancer sebelum melakukan pemesanan.
                                    </p>

                                </div>

                            </div>


                            {{-- ACTION --}}
                            <div class="border-t border-[#E2E8F0] p-5 sm:p-6">

                                @auth

                                    @if (auth()->user()->role === 'client')

                                        @if (!$isOwnService)

                                            <form
                                                action="{{ route('client.orders.store') }}"
                                                method="POST"
                                            >
                                                @csrf

                                                <input
                                                    type="hidden"
                                                    name="service_id"
                                                    value="{{ $service->id }}"
                                                >


                                                <label
                                                    for="requirements"
                                                    class="mb-2 block text-xs font-bold text-[#0F172A]"
                                                >
                                                    Detail kebutuhan
                                                </label>

                                                <textarea
                                                    id="requirements"
                                                    name="requirements"
                                                    rows="5"
                                                    placeholder="Jelaskan brief, kebutuhan, ukuran, format file, deadline, atau informasi penting lainnya..."
                                                    class="w-full resize-none rounded-lg border border-[#CBD5E1] px-3.5 py-3 text-xs leading-5 text-[#0F172A] outline-none transition placeholder:text-[#94A3B8] focus:border-[#93C5FD] focus:ring-2 focus:ring-[#DBEAFE]"
                                                >{{ old('requirements') }}</textarea>

                                                @error('requirements')

                                                    <p class="mt-1.5 text-[11px] text-[#DC2626]">
                                                        {{ $message }}
                                                    </p>

                                                @enderror


                                                <button
                                                    type="submit"
                                                    class="mt-3 flex h-12 w-full items-center justify-center gap-2 rounded-lg bg-[#2563EB] px-4 text-sm font-bold text-white transition hover:bg-[#1D4ED8]"
                                                >
                                                    Pesan jasa
                                                    <i class="bi bi-arrow-right"></i>
                                                </button>

                                            </form>

                                        @else

                                            <div class="border border-[#DBEAFE] bg-[#EFF6FF] p-4">

                                                <p class="text-xs font-bold text-[#1E3A8A]">
                                                    Ini jasa milikmu
                                                </p>

                                                <p class="mt-1 text-[11px] leading-5 text-[#64748B]">
                                                    Jasa milik sendiri tidak dapat dipesan.
                                                </p>

                                            </div>

                                        @endif

                                    @else

                                        <div class="border border-[#E2E8F0] bg-[#F8FAFC] p-4">

                                            <p class="text-xs font-bold text-[#0F172A]">
                                                Akun freelancer
                                            </p>

                                            <p class="mt-1 text-[11px] leading-5 text-[#64748B]">
                                                Akun freelancer tidak dapat memesan jasa.
                                            </p>

                                        </div>

                                    @endif

                                @else

                                    <div>

                                        <p class="text-xs font-bold text-[#0F172A]">
                                            Tertarik dengan jasa ini?
                                        </p>

                                        <p class="mt-1 text-[11px] leading-5 text-[#64748B]">
                                            Masuk ke akun untuk mulai memesan.
                                        </p>


                                        <a
                                            href="{{ route('login') }}"
                                            class="mt-4 flex h-11 w-full items-center justify-center rounded-lg bg-[#2563EB] px-4 text-xs font-bold text-white transition hover:bg-[#1D4ED8]"
                                        >
                                            Masuk untuk memesan
                                        </a>


                                        <a
                                            href="{{ route('register') }}"
                                            class="mt-2 flex h-10 w-full items-center justify-center rounded-lg border border-[#CBD5E1] text-xs font-semibold text-[#334155] transition hover:border-[#93C5FD] hover:text-[#2563EB]"
                                        >
                                            Buat akun
                                        </a>

                                    </div>

                                @endauth


                                <div class="mt-5 border-t border-[#E2E8F0] pt-4">

                                    <div class="flex items-start gap-2">

                                        <i class="bi bi-shield-check mt-0.5 text-sm text-[#16A34A]"></i>

                                        <p class="text-[10px] leading-5 text-[#64748B]">
                                            Transaksi diproses melalui ProKerja.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- SERVICE QUICK INFO --}}
                        <div class="mt-6">

                            <div class="border-b border-[#E2E8F0] pb-4">

                                <p class="text-xs font-bold text-[#0F172A]">
                                    Ringkasan layanan
                                </p>

                            </div>


                            <div class="divide-y divide-[#E2E8F0]">

                                <div class="flex items-center justify-between gap-4 py-4">

                                    <span class="text-xs text-[#64748B]">
                                        Waktu pengerjaan
                                    </span>

                                    <span class="text-xs font-semibold text-[#0F172A]">
                                        {{ $service->delivery_days }} hari
                                    </span>

                                </div>


                                <div class="flex items-center justify-between gap-4 py-4">

                                    <span class="text-xs text-[#64748B]">
                                        Rating
                                    </span>

                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-[#0F172A]">
                                        <i class="bi bi-star-fill text-[#F59E0B]"></i>
                                        {{ number_format((float) $service->rating, 1) }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between gap-4 py-4">

                                    <span class="text-xs text-[#64748B]">
                                        Terjual
                                    </span>

                                    <span class="text-xs font-semibold text-[#0F172A]">
                                        {{ $service->orders_count }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </main>


    {{-- =========================================================
        RELATED SERVICES
    ========================================================== --}}
    @if ($relatedServices->isNotEmpty())

        <section class="border-t border-[#E2E8F0] bg-[#F8FAFC]">

            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-12">

                <div>

                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#2563EB]">
                        Rekomendasi
                    </p>

                    <h2 class="mt-1 text-xl font-bold tracking-tight text-[#0F172A]">
                        Jasa lainnya
                    </h2>

                </div>


                <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-7 sm:grid-cols-3 lg:grid-cols-4">

                    @foreach ($relatedServices as $related)

                        @php
                            $relatedImage = $related->thumbnail
                                ? asset('storage/' . $related->thumbnail)
                                : null;

                            $relatedFreelancer = $related->freelancerProfile;
                            $relatedUser = $relatedFreelancer?->user;
                        @endphp

                        <article class="group min-w-0">

                            <a
                                href="{{ route('marketplace.service', $related->slug) }}"
                                class="block overflow-hidden rounded-xl bg-[#E2E8F0]"
                            >

                                <div class="aspect-[4/3] overflow-hidden bg-[#EFF6FF]">

                                    @if ($relatedImage)

                                        <img
                                            src="{{ $relatedImage }}"
                                            alt="{{ $related->title }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                        >

                                    @else

                                        <div class="flex h-full items-center justify-center">
                                            <i class="bi bi-briefcase text-xl text-[#2563EB]"></i>
                                        </div>

                                    @endif

                                </div>

                            </a>


                            @if ($relatedUser)

                                <p class="mt-3 truncate text-[10px] font-medium text-[#64748B]">
                                    {{ $relatedUser->name }}
                                </p>

                            @endif


                            <a
                                href="{{ route('marketplace.service', $related->slug) }}"
                                class="block"
                            >

                                <h3 class="mt-1.5 line-clamp-2 min-h-[36px] text-[12px] font-semibold leading-4.5 text-[#0F172A] transition group-hover:text-[#2563EB]">
                                    {{ $related->title }}
                                </h3>

                            </a>


                            <div class="mt-3 flex items-center justify-between gap-2">

                                <p class="text-sm font-extrabold text-[#0F172A]">
                                    Rp{{ number_format($related->starting_price, 0, ',', '.') }}
                                </p>

                                <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-[#475569]">
                                    <i class="bi bi-star-fill text-[9px] text-[#F59E0B]"></i>
                                    {{ number_format((float) $related->rating, 1) }}
                                </span>

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>

    @endif

</div>


</x-layouts.marketplace>
