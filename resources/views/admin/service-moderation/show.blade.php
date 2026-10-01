<x-layouts.admin title="Detail Moderasi Jasa">


@php
    $freelancer = $service->freelancerProfile;
    $freelancerUser = $freelancer?->user;
    $freelancerName = $freelancerUser?->name ?? 'Freelancer';

    $freelancerAvatar = $freelancer?->avatar
        ? asset('storage/' . $freelancer->avatar)
        : null;

    $freelancerInitial = strtoupper(
        substr($freelancerName ?: 'F', 0, 1)
    );
@endphp


<div class="mx-auto max-w-6xl space-y-5 sm:space-y-6">


    {{-- ==========================================================
         HEADER
    =========================================================== --}}
    <section>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div class="min-w-0">

                {{-- Back --}}
                <a
                    href="{{ route('admin.service-moderation.index') }}"
                    class="group inline-flex items-center gap-2 text-xs font-semibold text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
                >
                    <span
                        class="flex h-8 w-8 items-center justify-center rounded-lg
                               bg-white ring-1 ring-slate-200 transition
                               group-hover:bg-blue-50 group-hover:ring-blue-200
                               dark:bg-slate-900 dark:ring-slate-800
                               dark:group-hover:bg-blue-500/10 dark:group-hover:ring-blue-500/30"
                    >
                        <i class="bi bi-arrow-left text-xs transition group-hover:-translate-x-0.5"></i>
                    </span>

                    Kembali ke Moderasi Jasa
                </a>


                <div class="mt-4">

                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                        Service Moderation
                    </p>

                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                        Detail Jasa
                    </h1>

                    <p class="mt-1.5 text-sm leading-6 text-slate-500 dark:text-slate-400">
                        Periksa informasi jasa sebelum menentukan keputusan moderasi.
                    </p>

                </div>

            </div>


            {{-- Status --}}
            <div class="shrink-0">

                @if ($service->status === 'pending')

                    <span class="inline-flex items-center gap-2 rounded-xl bg-amber-50 px-3.5 py-2.5 text-xs font-semibold text-amber-700 ring-1 ring-amber-100 dark:bg-amber-500/10 dark:text-amber-400 dark:ring-amber-500/20">
                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                        Menunggu Review
                    </span>

                @elseif ($service->status === 'published')

                    <span class="inline-flex items-center gap-2 rounded-xl bg-emerald-50 px-3.5 py-2.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Published
                    </span>

                @elseif ($service->status === 'rejected')

                    <span class="inline-flex items-center gap-2 rounded-xl bg-rose-50 px-3.5 py-2.5 text-xs font-semibold text-rose-700 ring-1 ring-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:ring-rose-500/20">
                        <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                        Rejected
                    </span>

                @else

                    <span class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3.5 py-2.5 text-xs font-semibold text-slate-600 ring-1 ring-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-700">
                        <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                        {{ ucfirst($service->status) }}
                    </span>

                @endif

            </div>

        </div>

    </section>


    {{-- ==========================================================
         FLASH SUCCESS
    =========================================================== --}}
    @if (session('success'))

        <div class="flex items-start gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                <i class="bi bi-check-circle"></i>
            </div>

            <div class="min-w-0">

                <p class="font-semibold">
                    Berhasil
                </p>

                <p class="mt-0.5 leading-5">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    {{-- ==========================================================
         VALIDATION ERRORS
    =========================================================== --}}
    @if ($errors->any())

        <div class="rounded-2xl border border-rose-100 bg-rose-50 p-4 dark:border-rose-500/20 dark:bg-rose-500/10 sm:p-5">

            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-rose-600 shadow-sm dark:bg-slate-900 dark:text-rose-400">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>

                <div class="min-w-0">

                    <p class="text-sm font-semibold text-rose-700 dark:text-rose-400">
                        Ada data yang perlu diperbaiki.
                    </p>

                    <ul class="mt-2 space-y-1 text-xs leading-5 text-rose-600 dark:text-rose-300 sm:text-sm">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- ==========================================================
         MAIN CONTENT
    =========================================================== --}}
    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_330px]">


        {{-- ======================================================
             LEFT CONTENT
        ======================================================= --}}
        <main class="min-w-0 space-y-5">


            {{-- ==================================================
                 SERVICE DETAIL
            =================================================== --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                {{-- Thumbnail --}}
                <div class="relative aspect-[16/8] overflow-hidden bg-slate-100 dark:bg-slate-800">

                    @if ($service->thumbnail)

                        <img
                            src="{{ asset('storage/' . $service->thumbnail) }}"
                            alt="{{ $service->title }}"
                            class="h-full w-full object-cover"
                        >

                    @else

                        <div class="flex h-full w-full items-center justify-center">

                            <div class="text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm dark:bg-slate-900 dark:text-slate-500">
                                    <i class="bi bi-image text-2xl"></i>
                                </div>

                                <p class="mt-3 text-xs font-medium text-slate-500 dark:text-slate-400">
                                    Tidak ada thumbnail
                                </p>

                            </div>

                        </div>

                    @endif

                </div>


                {{-- Service Information --}}
                <div class="p-4 sm:p-6 lg:p-7">

                    {{-- Category --}}
                    <div class="flex flex-wrap gap-2">

                        @if ($service->category)

                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                <i class="bi bi-folder2"></i>
                                {{ $service->category->name }}
                            </span>

                        @endif


                        @if ($service->subcategory)

                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                <i class="bi bi-tag"></i>
                                {{ $service->subcategory->name }}
                            </span>

                        @endif

                    </div>


                    {{-- Title --}}
                    <h2 class="mt-4 text-xl font-bold leading-tight tracking-tight text-slate-900 dark:text-white sm:mt-5 sm:text-2xl lg:text-3xl">
                        {{ $service->title }}
                    </h2>


                    {{-- Key Information --}}
                    <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3">

                        {{-- Price --}}
                        <div class="rounded-xl border border-blue-100 bg-blue-50/70 p-4 dark:border-blue-500/20 dark:bg-blue-500/10">

                            <div class="flex items-center gap-2">

                                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                                    <i class="bi bi-wallet2 text-xs"></i>
                                </div>

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">
                                    Harga mulai
                                </p>

                            </div>

                            <p class="mt-2 text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                                Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                            </p>

                        </div>


                        {{-- Delivery --}}
                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">

                            <div class="flex items-center gap-2">

                                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-white text-slate-500 shadow-sm dark:bg-slate-900 dark:text-slate-400">
                                    <i class="bi bi-clock text-xs"></i>
                                </div>

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400 dark:text-slate-500">
                                    Pengerjaan
                                </p>

                            </div>

                            <p class="mt-2 text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                                {{ $service->delivery_days }} hari
                            </p>

                        </div>


                        {{-- Rating --}}
                        <div class="col-span-2 rounded-xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60 sm:col-span-1">

                            <div class="flex items-center gap-2">

                                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-white text-amber-500 shadow-sm dark:bg-slate-900 dark:text-amber-400">
                                    <i class="bi bi-star-fill text-xs"></i>
                                </div>

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400 dark:text-slate-500">
                                    Rating
                                </p>

                            </div>

                            <p class="mt-2 text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                                {{ number_format((float) $service->rating, 1) }}
                            </p>

                        </div>

                    </div>

                </div>

            </section>


            {{-- ==================================================
                 DESCRIPTION
            =================================================== --}}
            <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        <i class="bi bi-file-text text-lg"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                            Deskripsi Jasa
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                            Isi layanan yang ditawarkan freelancer.
                        </p>

                    </div>

                </div>


                <div class="mt-5 rounded-xl bg-slate-50 p-4 dark:bg-slate-800/60 sm:p-5">

                    <p class="whitespace-pre-line text-sm leading-7 text-slate-600 dark:text-slate-300">
                        {{ $service->description }}
                    </p>

                </div>

            </section>


            {{-- ==================================================
                 MODERATION INFORMATION
            =================================================== --}}
            <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        <i class="bi bi-shield-check text-lg"></i>
                    </div>

                    <div>

                        <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                            Informasi Moderasi
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                            Riwayat pengajuan dan pemeriksaan jasa.
                        </p>

                    </div>

                </div>


                <div class="mt-5 divide-y divide-slate-100 rounded-xl border border-slate-100 dark:divide-slate-800 dark:border-slate-800">

                    {{-- Submitted --}}
                    <div class="flex items-center justify-between gap-4 px-4 py-3.5">

                        <div class="flex items-center gap-3">

                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-50 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                                <i class="bi bi-send text-xs"></i>
                            </span>

                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                Diajukan
                            </span>

                        </div>

                        <span class="text-right text-xs font-semibold text-slate-700 dark:text-slate-200">
                            {{ $service->submitted_at?->format('d M Y, H:i') ?? '-' }}
                        </span>

                    </div>


                    {{-- Reviewed --}}
                    <div class="flex items-center justify-between gap-4 px-4 py-3.5">

                        <div class="flex items-center gap-3">

                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-50 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                                <i class="bi bi-search text-xs"></i>
                            </span>

                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                Direview
                            </span>

                        </div>

                        <span class="text-right text-xs font-semibold text-slate-700 dark:text-slate-200">
                            {{ $service->reviewed_at?->format('d M Y, H:i') ?? '-' }}
                        </span>

                    </div>


                    {{-- Reviewer --}}
                    <div class="flex items-center justify-between gap-4 px-4 py-3.5">

                        <div class="flex items-center gap-3">

                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-50 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                                <i class="bi bi-person-check text-xs"></i>
                            </span>

                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                Reviewer
                            </span>

                        </div>

                        <span class="max-w-[55%] truncate text-right text-xs font-semibold text-slate-700 dark:text-slate-200">
                            {{ $service->reviewer?->name ?? '-' }}
                        </span>

                    </div>

                </div>


                {{-- Rejection --}}
                @if ($service->rejection_reason)

                    <div class="mt-4 rounded-xl border border-rose-100 bg-rose-50 p-4 dark:border-rose-500/20 dark:bg-rose-500/10">

                        <div class="flex items-start gap-3">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-rose-600 shadow-sm dark:bg-slate-900 dark:text-rose-400">
                                <i class="bi bi-x-circle"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-[10px] font-bold uppercase tracking-[0.1em] text-rose-600 dark:text-rose-400">
                                    Alasan Penolakan
                                </p>

                                <p class="mt-1.5 whitespace-pre-line text-sm leading-6 text-rose-800 dark:text-rose-200">
                                    {{ $service->rejection_reason }}
                                </p>

                            </div>

                        </div>

                    </div>

                @endif

            </section>

        </main>


        {{-- ======================================================
             RIGHT SIDEBAR
        ======================================================= --}}
        <aside class="space-y-5 lg:sticky lg:top-24 lg:self-start">


            {{-- ==================================================
                 FREELANCER
            =================================================== --}}
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-blue-600 dark:text-blue-400">
                    Freelancer
                </p>


                <div class="mt-4 flex items-start gap-3">

                    {{-- Avatar --}}
                    @if($freelancerAvatar)

                        <img
                            src="{{ $freelancerAvatar }}"
                            alt="{{ $freelancerName }}"
                            class="h-12 w-12 shrink-0 rounded-full object-cover ring-2 ring-blue-50 dark:ring-blue-500/10"
                        >

                    @else

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600 ring-2 ring-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-500/20">
                            {{ $freelancerInitial }}
                        </div>

                    @endif


                    <div class="min-w-0 flex-1">

                        <p class="truncate text-sm font-bold text-slate-900 dark:text-white">
                            {{ $freelancerName }}
                        </p>


                        @if ($freelancer?->username)

                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                {{ '@' . ltrim($freelancer->username, '@') }}
                            </p>

                        @endif


                        @if ($freelancer?->is_verified)

                            <span class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                <i class="bi bi-patch-check-fill"></i>
                                Terverifikasi
                            </span>

                        @endif

                    </div>

                </div>


                @if ($freelancer?->headline)

                    <div class="mt-4 rounded-xl bg-slate-50 p-3.5 dark:bg-slate-800/60">

                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400 dark:text-slate-500">
                            Headline
                        </p>

                        <p class="mt-1.5 text-xs leading-5 text-slate-600 dark:text-slate-300">
                            {{ $freelancer->headline }}
                        </p>

                    </div>

                @endif

            </section>


            {{-- ==================================================
                 DECISION
            =================================================== --}}
            @if ($service->status === 'pending')

                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                    {{-- Decision Header --}}
                    <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">

                        <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-blue-600 dark:text-blue-400">
                            Keputusan Admin
                        </p>

                        <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                            Review jasa
                        </h2>

                        <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                            Tentukan apakah jasa ini layak dipublikasikan.
                        </p>

                    </div>


                    <div class="p-5">

                        {{-- Publish --}}
                        <form
                            method="POST"
                            action="{{ route('admin.service-moderation.publish', $service) }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                onclick="return confirm('Publikasikan jasa ini ke marketplace?')"
                                class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-sm font-semibold !text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20"
                            >
                                <i class="bi bi-check-circle"></i>
                                Publikasikan Jasa
                            </button>

                        </form>


                        {{-- Divider --}}
                        <div class="my-5 flex items-center gap-3">

                            <div class="h-px flex-1 bg-slate-100 dark:bg-slate-800"></div>

                            <span class="text-[10px] font-medium text-slate-400">
                                atau
                            </span>

                            <div class="h-px flex-1 bg-slate-100 dark:bg-slate-800"></div>

                        </div>


                        {{-- Reject --}}
                        <form
                            method="POST"
                            action="{{ route('admin.service-moderation.reject', $service) }}"
                            class="space-y-4"
                        >

                            @csrf

                            <div>

                                <label
                                    for="rejection_reason"
                                    class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-200"
                                >
                                    Alasan penolakan
                                </label>

                                <textarea
                                    id="rejection_reason"
                                    name="rejection_reason"
                                    rows="5"
                                    placeholder="Jelaskan bagian yang perlu diperbaiki freelancer..."
                                    class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-rose-400 focus:bg-white focus:ring-4 focus:ring-rose-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-rose-500 dark:focus:bg-slate-800"
                                >{{ old('rejection_reason') }}</textarea>

                                <p class="mt-1.5 text-[10px] leading-4 text-slate-400 dark:text-slate-500">
                                    Minimal 10 karakter.
                                </p>

                            </div>


                            <button
                                type="submit"
                                onclick="return confirm('Tolak pengajuan jasa ini?')"
                                class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 text-sm font-semibold text-rose-700 transition hover:bg-rose-100 focus:outline-none focus:ring-4 focus:ring-rose-500/10 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400 dark:hover:bg-rose-500/20"
                            >
                                <i class="bi bi-x-circle"></i>
                                Tolak Jasa
                            </button>

                        </form>

                    </div>

                </section>


            @else

                {{-- Already processed --}}
                <section class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-800/50">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                            <i class="bi bi-info-circle"></i>
                        </div>

                        <div>

                            <p class="text-xs font-bold text-slate-700 dark:text-slate-200">
                                Tidak ada tindakan
                            </p>

                            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                Jasa ini sudah diproses dan tidak dapat dipublikasikan
                                atau ditolak kembali melalui moderasi.
                            </p>

                        </div>

                    </div>

                </section>

            @endif


            {{-- ==================================================
                 PUBLIC PREVIEW
            =================================================== --}}
            @if ($service->status === 'published')

                <a
                    href="{{ route('marketplace.service', $service->slug) }}"
                    target="_blank"
                    class="group inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-500/30 dark:hover:bg-blue-500/10 dark:hover:text-blue-400"
                >
                    <i class="bi bi-box-arrow-up-right transition group-hover:translate-x-0.5"></i>
                    Lihat di Marketplace
                </a>

            @endif

        </aside>

    </div>

</div>


</x-layouts.admin>
