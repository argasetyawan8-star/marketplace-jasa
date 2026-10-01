<x-layouts.admin title="Detail Pengguna">


@php
    /*
     * Tentukan profile yang digunakan.
     * Freelancer menggunakan freelancerProfile.
     * Client/Admin menggunakan profile umum jika tersedia.
     */
    $profile = $user->role === 'freelancer'
        ? $user->freelancerProfile
        : $user->profile;

    /*
     * Avatar freelancer dikonfirmasi menggunakan field avatar.
     * Untuk pengguna umum, tetap menggunakan profile->avatar.
     */
    $avatarPath = $profile?->avatar ?? null;

    /*
     * Cover/banner:
     * Mendukung beberapa nama field agar halaman tetap kompatibel
     * apabila struktur profile menggunakan salah satu nama tersebut.
     */
    $coverPath = $profile?->cover_image
        ?? $profile?->cover
        ?? $profile?->banner
        ?? $profile?->background_image
        ?? $profile?->background_photo
        ?? null;

    $avatarUrl = $avatarPath
        ? asset('storage/' . $avatarPath)
        : null;

    $coverUrl = $coverPath
        ? asset('storage/' . $coverPath)
        : null;

    $initial = strtoupper(
        substr($user->name ?: 'U', 0, 1)
    );
@endphp


<div class="mx-auto max-w-5xl space-y-5 sm:space-y-6">


    {{-- ==========================================================
         BACK
    =========================================================== --}}
    <a
        href="{{ route('admin.users.index') }}"
        class="group inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
    >
        <span
            class="flex h-8 w-8 items-center justify-center rounded-lg
                   bg-white ring-1 ring-slate-200
                   transition group-hover:bg-blue-50 group-hover:ring-blue-200
                   dark:bg-slate-900 dark:ring-slate-800
                   dark:group-hover:bg-blue-500/10 dark:group-hover:ring-blue-500/30"
        >
            <i class="bi bi-arrow-left text-sm transition group-hover:-translate-x-0.5"></i>
        </span>

        <span>Kembali ke Pengguna</span>
    </a>


    {{-- ==========================================================
         PROFILE HEADER
    =========================================================== --}}
    <section
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm
               dark:border-slate-800 dark:bg-slate-900"
    >

        {{-- ======================================================
             COVER / BANNER
        ======================================================= --}}
        <div class="relative h-36 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-500 to-sky-400 sm:h-44 lg:h-48">

            @if($coverUrl)

                <img
                    src="{{ $coverUrl }}"
                    alt="Banner profil {{ $user->name }}"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-black/5"></div>

            @else

                {{-- Fallback apabila banner belum tersedia --}}
                <div class="absolute inset-0">

                    <div class="absolute -right-12 -top-20 h-56 w-56 rounded-full bg-white/10"></div>

                    <div class="absolute -bottom-28 left-1/3 h-64 w-64 rounded-full bg-white/10"></div>

                    <div class="absolute left-10 top-8 h-20 w-20 rounded-full bg-white/5"></div>

                </div>

            @endif

        </div>


        {{-- ======================================================
             PROFILE INFORMATION
             Avatar sengaja TIDAK overlap dengan banner.
        ======================================================= --}}
        <div class="px-4 pb-6 sm:px-6 sm:pb-7">

            {{-- Avatar --}}
            <div class="mt-4">

                @if($avatarUrl)

                    <img
                        src="{{ $avatarUrl }}"
                        alt="{{ $user->name }}"
                        class="h-20 w-20 rounded-full border-4 border-white object-cover shadow-md
                               dark:border-slate-900
                               sm:h-24 sm:w-24"
                    >

                @else

                    <div
                        class="flex h-20 w-20 items-center justify-center
                               rounded-full border-4 border-white
                               bg-blue-50 text-2xl font-bold text-blue-600 shadow-md
                               dark:border-slate-900 dark:bg-blue-500/10 dark:text-blue-400
                               sm:h-24 sm:w-24 sm:text-3xl"
                    >
                        {{ $initial }}
                    </div>

                @endif

            </div>


            {{-- Information --}}
            <div class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">

                <div class="min-w-0">

                    {{-- Name + Role --}}
                    <div class="flex flex-wrap items-center gap-2">

                        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-2xl">
                            {{ $user->name }}
                        </h1>


                        @if($user->role === 'admin')

                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-2.5 py-1.5 text-xs font-semibold !text-white">
                                <i class="bi bi-shield-check"></i>
                                Admin
                            </span>

                        @elseif($user->role === 'freelancer')

                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                <i class="bi bi-briefcase"></i>
                                Freelancer
                            </span>

                        @else

                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                <i class="bi bi-person"></i>
                                Client
                            </span>

                        @endif

                    </div>


                    {{-- Email --}}
                    <div class="mt-2 flex items-start gap-2 text-sm text-slate-500 dark:text-slate-400">

                        <i class="bi bi-envelope mt-0.5 shrink-0 text-slate-400"></i>

                        <span class="break-all">
                            {{ $user->email }}
                        </span>

                    </div>


                    {{-- Freelancer username --}}
                    @if($user->role === 'freelancer' && $user->freelancerProfile?->username)

                        <div class="mt-2 flex items-center gap-2 text-xs text-slate-400 dark:text-slate-500">

                            <i class="bi bi-at"></i>

                            <span>
                                {{ $user->freelancerProfile->username }}
                            </span>

                        </div>

                    @endif

                </div>


                {{-- Verification --}}
                @if($user->email_verified_at)

                    <span class="inline-flex w-fit shrink-0 items-center gap-2 rounded-xl bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <i class="bi bi-check-circle-fill"></i>
                        Email Terverifikasi
                    </span>

                @else

                    <span class="inline-flex w-fit shrink-0 items-center gap-2 rounded-xl bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                        <i class="bi bi-clock"></i>
                        Belum Terverifikasi
                    </span>

                @endif

            </div>

        </div>

    </section>


    {{-- ==========================================================
         ACCOUNT + PROFILE
    =========================================================== --}}
    <div class="grid gap-5 lg:grid-cols-2">


        {{-- ======================================================
             ACCOUNT
        ======================================================= --}}
        <section
            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm
                   dark:border-slate-800 dark:bg-slate-900 sm:p-5"
        >

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="bi bi-person-vcard text-lg"></i>
                </div>

                <div>

                    <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                        Informasi Akun
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Data dasar pengguna.
                    </p>

                </div>

            </div>


            <div class="mt-5 space-y-3">

                {{-- Nama --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3.5 dark:border-slate-800 dark:bg-slate-800/60">

                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                        Nama
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-900 dark:text-white">
                        {{ $user->name }}
                    </p>

                </div>


                {{-- Email --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3.5 dark:border-slate-800 dark:bg-slate-800/60">

                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                        Email
                    </p>

                    <p class="mt-1 break-all text-sm font-semibold text-slate-900 dark:text-white">
                        {{ $user->email }}
                    </p>

                </div>


                {{-- Role --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3.5 dark:border-slate-800 dark:bg-slate-800/60">

                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                        Role
                    </p>

                    <p class="mt-1 text-sm font-semibold capitalize text-slate-900 dark:text-white">
                        {{ $user->role }}
                    </p>

                </div>


                {{-- Bergabung --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3.5 dark:border-slate-800 dark:bg-slate-800/60">

                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                        Bergabung
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-900 dark:text-white">
                        {{ $user->created_at?->format('d M Y H:i') ?? '-' }}
                    </p>

                </div>

            </div>

        </section>


        {{-- ======================================================
             PROFILE
        ======================================================= --}}
        <section
            class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm
                   dark:border-slate-800 dark:bg-slate-900 sm:p-5"
        >

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="bi bi-person-lines-fill text-lg"></i>
                </div>

                <div>

                    <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                        Informasi Profil
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Informasi tambahan pengguna.
                    </p>

                </div>

            </div>


            {{-- ==================================================
                 FREELANCER
            =================================================== --}}
            @if($user->role === 'freelancer' && $user->freelancerProfile)

                <div class="mt-5 space-y-3">

                    {{-- Username --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3.5 dark:border-slate-800 dark:bg-slate-800/60">

                        <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                            Username Freelancer
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-900 dark:text-white">
                            {{ '@' . $user->freelancerProfile->username }}
                        </p>

                    </div>


                    {{-- Headline --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3.5 dark:border-slate-800 dark:bg-slate-800/60">

                        <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                            Headline
                        </p>

                        <p class="mt-1 text-sm font-semibold leading-6 text-slate-900 dark:text-white">
                            {{ $user->freelancerProfile->headline ?: 'Belum diisi' }}
                        </p>

                    </div>


                    {{-- Lokasi --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3.5 dark:border-slate-800 dark:bg-slate-800/60">

                        <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                            Lokasi
                        </p>

                        <div class="mt-1 flex items-center gap-2">

                            <i class="bi bi-geo-alt text-sm text-blue-500"></i>

                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $user->freelancerProfile->location ?: 'Belum diisi' }}
                            </p>

                        </div>

                    </div>


                    {{-- Statistics --}}
                    <div class="grid grid-cols-2 gap-3 pt-1">

                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">

                            <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                                Pesanan Selesai
                            </p>

                            <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                                {{ number_format($user->freelancerProfile->completed_orders) }}
                            </p>

                        </div>


                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">

                            <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                                Rating
                            </p>

                            <div class="mt-2 flex items-center gap-1.5">

                                <i class="bi bi-star-fill text-amber-400"></i>

                                <span class="text-xl font-bold text-slate-900 dark:text-white">
                                    {{ number_format((float) $user->freelancerProfile->rating, 2) }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


            {{-- ==================================================
                 GENERAL CLIENT PROFILE
            =================================================== --}}
            @elseif($user->profile)

                <div class="mt-5 space-y-3">

                    {{-- Lokasi --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3.5 dark:border-slate-800 dark:bg-slate-800/60">

                        <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                            Lokasi
                        </p>

                        <div class="mt-1 flex items-center gap-2">

                            <i class="bi bi-geo-alt text-sm text-blue-500"></i>

                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $user->profile->location ?: 'Belum diisi' }}
                            </p>

                        </div>

                    </div>


                    {{-- Bio --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3.5 dark:border-slate-800 dark:bg-slate-800/60">

                        <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                            Bio
                        </p>

                        <p class="mt-1.5 whitespace-pre-line text-sm leading-6 text-slate-600 dark:text-slate-300">
                            {{ $user->profile->bio ?: 'Belum diisi' }}
                        </p>

                    </div>

                </div>


            @else

                {{-- Empty --}}
                <div class="mt-5 flex min-h-[260px] flex-col items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 px-5 text-center dark:border-slate-700 dark:bg-slate-800/50">

                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-slate-400 shadow-sm dark:bg-slate-900 dark:text-slate-500">
                        <i class="bi bi-person text-xl"></i>
                    </div>

                    <p class="mt-3 text-sm font-medium text-slate-500 dark:text-slate-400">
                        Belum ada informasi profil tambahan.
                    </p>

                </div>

            @endif

        </section>

    </div>


    {{-- ==========================================================
         FREELANCER SERVICES
    =========================================================== --}}
    @if($user->role === 'freelancer' && $user->freelancerProfile)

        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm
                   dark:border-slate-800 dark:bg-slate-900"
        >

            {{-- Header --}}
            <div class="border-b border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-5 sm:py-5">

                <div class="flex items-center justify-between gap-3">

                    <div class="flex min-w-0 items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                            <i class="bi bi-briefcase text-lg"></i>
                        </div>

                        <div class="min-w-0">

                            <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                                Jasa Freelancer
                            </h2>

                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                Jasa yang dimiliki oleh freelancer ini.
                            </p>

                        </div>

                    </div>


                    <span class="shrink-0 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        {{ $user->freelancerProfile->services->count() }}
                    </span>

                </div>

            </div>


            @if($user->freelancerProfile->services->count())

                <div class="grid gap-4 p-4 sm:p-5 md:grid-cols-2 xl:grid-cols-3">

                    @foreach($user->freelancerProfile->services as $service)

                        <article
                            class="group overflow-hidden rounded-xl border border-slate-200 bg-white
                                   transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md
                                   dark:border-slate-700 dark:bg-slate-900 dark:hover:border-blue-500/30"
                        >

                            {{-- Thumbnail --}}
                            <div class="relative aspect-[16/9] overflow-hidden bg-slate-100 dark:bg-slate-800">

                                @if($service->thumbnail)

                                    <img
                                        src="{{ asset('storage/' . $service->thumbnail) }}"
                                        alt="{{ $service->title }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                                    >

                                @else

                                    <div class="flex h-full items-center justify-center text-slate-400 dark:text-slate-500">
                                        <i class="bi bi-image text-3xl"></i>
                                    </div>

                                @endif

                            </div>


                            {{-- Content --}}
                            <div class="p-4">

                                <h3 class="line-clamp-2 min-h-[40px] text-sm font-semibold leading-5 text-slate-900 dark:text-white">
                                    {{ $service->title }}
                                </h3>


                                <div class="mt-4 flex items-end justify-between gap-3">

                                    <div class="min-w-0">

                                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                            Mulai dari
                                        </p>

                                        <p class="mt-1 truncate text-sm font-bold text-blue-600 dark:text-blue-400">
                                            Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                        </p>

                                    </div>


                                    <span class="inline-flex shrink-0 items-center gap-1 rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                        <i class="bi bi-clock"></i>
                                        {{ $service->delivery_days }} hari
                                    </span>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


            @else

                <div class="p-4 sm:p-5">

                    <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 px-5 py-12 text-center dark:border-slate-700 dark:bg-slate-800/50">

                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-slate-400 shadow-sm dark:bg-slate-900 dark:text-slate-500">
                            <i class="bi bi-briefcase text-xl"></i>
                        </div>

                        <p class="mt-3 text-sm font-medium text-slate-500 dark:text-slate-400">
                            Freelancer ini belum memiliki jasa.
                        </p>

                    </div>

                </div>

            @endif

        </section>

    @endif

</div>


</x-layouts.admin>
