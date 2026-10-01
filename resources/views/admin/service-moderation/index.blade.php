<x-layouts.admin title="Moderasi Jasa">


<div class="mx-auto max-w-7xl space-y-5 sm:space-y-6">

    {{-- ==========================================================
         HEADER
    =========================================================== --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">

                <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-blue-600 dark:text-blue-400">
                    <i class="bi bi-shield-check"></i>
                    Service Moderation
                </div>

                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                    Moderasi Jasa
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Periksa jasa freelancer sebelum dipublikasikan ke marketplace.
                </p>

            </div>


            <div class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 sm:flex">
                <i class="bi bi-shield-check text-xl"></i>
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
         STATISTICS
    =========================================================== --}}
    <section class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">

        {{-- Pending --}}
        <a
            href="{{ route('admin.service-moderation.index', ['status' => 'pending']) }}"
            class="group rounded-2xl border border-amber-100 bg-amber-50 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-200 hover:shadow-md dark:border-amber-500/20 dark:bg-amber-500/10 sm:p-5"
        >

            <div class="flex items-center justify-between gap-2">

                <span class="text-xs font-semibold text-amber-700 dark:text-amber-400">
                    Pending
                </span>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-amber-600 shadow-sm dark:bg-slate-900 dark:text-amber-400">
                    <i class="bi bi-hourglass-split"></i>
                </div>

            </div>

            <p class="mt-3 text-2xl font-bold text-amber-800 dark:text-amber-300">
                {{ $counts['pending'] }}
            </p>

            <p class="mt-1 text-[11px] text-amber-700/70 dark:text-amber-400/70">
                Menunggu moderasi
            </p>

        </a>


        {{-- Published --}}
        <a
            href="{{ route('admin.service-moderation.index', ['status' => 'published']) }}"
            class="group rounded-2xl border border-emerald-100 bg-emerald-50 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-md dark:border-emerald-500/20 dark:bg-emerald-500/10 sm:p-5"
        >

            <div class="flex items-center justify-between gap-2">

                <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                    Published
                </span>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                    <i class="bi bi-check-circle"></i>
                </div>

            </div>

            <p class="mt-3 text-2xl font-bold text-emerald-800 dark:text-emerald-300">
                {{ $counts['published'] }}
            </p>

            <p class="mt-1 text-[11px] text-emerald-700/70 dark:text-emerald-400/70">
                Aktif di marketplace
            </p>

        </a>


        {{-- Rejected --}}
        <a
            href="{{ route('admin.service-moderation.index', ['status' => 'rejected']) }}"
            class="group rounded-2xl border border-rose-100 bg-rose-50 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-200 hover:shadow-md dark:border-rose-500/20 dark:bg-rose-500/10 sm:p-5"
        >

            <div class="flex items-center justify-between gap-2">

                <span class="text-xs font-semibold text-rose-700 dark:text-rose-400">
                    Rejected
                </span>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-rose-600 shadow-sm dark:bg-slate-900 dark:text-rose-400">
                    <i class="bi bi-x-circle"></i>
                </div>

            </div>

            <p class="mt-3 text-2xl font-bold text-rose-800 dark:text-rose-300">
                {{ $counts['rejected'] }}
            </p>

            <p class="mt-1 text-[11px] text-rose-700/70 dark:text-rose-400/70">
                Perlu perbaikan
            </p>

        </a>


        {{-- Draft --}}
        <a
            href="{{ route('admin.service-moderation.index', ['status' => 'draft']) }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 sm:p-5"
        >

            <div class="flex items-center justify-between gap-2">

                <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                    Draft
                </span>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-50 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                    <i class="bi bi-file-earmark"></i>
                </div>

            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">
                {{ $counts['draft'] }}
            </p>

            <p class="mt-1 text-[11px] text-slate-400 dark:text-slate-500">
                Belum dipublikasikan
            </p>

        </a>


        {{-- All --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">

            <div class="flex items-center justify-between gap-2">

                <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                    Semua Jasa
                </span>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="bi bi-grid"></i>
                </div>

            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">
                {{ $counts['all'] }}
            </p>

            <p class="mt-1 text-[11px] text-slate-400 dark:text-slate-500">
                Total seluruh jasa
            </p>

        </div>

    </section>


    {{-- ==========================================================
         FILTER
    =========================================================== --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">

        <form
            method="GET"
            action="{{ route('admin.service-moderation.index') }}"
            class="grid gap-3 md:grid-cols-[minmax(0,1fr)_200px_auto]"
        >

            {{-- Search --}}
            <div>

                <label
                    for="search"
                    class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-200"
                >
                    Cari jasa
                </label>

                <div class="relative">

                    <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>

                    <input
                        id="search"
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Judul jasa, freelancer, email..."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                    >

                </div>

            </div>


            {{-- Status --}}
            <div>

                <label
                    for="status"
                    class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-200"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:border-blue-500"
                >

                    <option value="pending" @selected($status === 'pending')>
                        Pending
                    </option>

                    <option value="published" @selected($status === 'published')>
                        Published
                    </option>

                    <option value="rejected" @selected($status === 'rejected')>
                        Rejected
                    </option>

                    <option value="draft" @selected($status === 'draft')>
                        Draft
                    </option>

                    <option value="archived" @selected($status === 'archived')>
                        Archived
                    </option>

                    <option value="" @selected($status === null || $status === '')>
                        Semua
                    </option>

                </select>

            </div>


            {{-- Filter Button --}}
            <div class="flex items-end">

                <button
                    type="submit"
                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold !text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 md:w-auto"
                >
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>

            </div>

        </form>

    </section>


    {{-- ==========================================================
         SERVICE LIST
    =========================================================== --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- Header --}}
        <div class="border-b border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-6 sm:py-5">

            <div class="flex items-center justify-between gap-4">

                <div class="min-w-0">

                    <div class="flex items-center gap-2">

                        <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                            Daftar Jasa
                        </h2>

                        <span class="rounded-md bg-blue-50 px-2 py-1 text-[11px] font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                            {{ number_format($services->total()) }}
                        </span>

                    </div>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Jasa yang perlu dipantau atau dimoderasi.
                    </p>

                </div>

                <div class="hidden h-9 w-9 items-center justify-center rounded-lg bg-slate-50 text-slate-400 dark:bg-slate-800 dark:text-slate-500 sm:flex">
                    <i class="bi bi-briefcase"></i>
                </div>

            </div>

        </div>


        @if($services->count())

            {{-- ==================================================
                 DESKTOP TABLE
            =================================================== --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full">

                    <thead class="bg-slate-50 dark:bg-slate-800/70">

                        <tr class="border-b border-slate-100 dark:border-slate-800">

                            <th class="px-5 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Jasa
                            </th>

                            <th class="px-5 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Freelancer
                            </th>

                            <th class="px-5 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Kategori
                            </th>

                            <th class="px-5 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Status
                            </th>

                            <th class="px-5 py-4 text-right text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                        @foreach ($services as $service)

                            @php
                                $freelancer = $service->freelancerProfile;
                                $freelancerUser = $freelancer?->user;
                            @endphp


                            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/50">

                                {{-- SERVICE --}}
                                <td class="min-w-[300px] px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="h-14 w-20 shrink-0 overflow-hidden rounded-xl bg-slate-100 ring-1 ring-slate-200 dark:bg-slate-800 dark:ring-slate-700">

                                            @if ($service->thumbnail)

                                                <img
                                                    src="{{ asset('storage/' . $service->thumbnail) }}"
                                                    alt="{{ $service->title }}"
                                                    class="h-full w-full object-cover transition duration-300 hover:scale-105"
                                                >

                                            @else

                                                <div class="flex h-full w-full items-center justify-center text-slate-400 dark:text-slate-500">
                                                    <i class="bi bi-image"></i>
                                                </div>

                                            @endif

                                        </div>


                                        <div class="min-w-0">

                                            <p class="line-clamp-2 text-sm font-semibold leading-5 text-slate-900 dark:text-white">
                                                {{ $service->title }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                                Mulai Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- FREELANCER --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[180px]">

                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                            {{ $freelancerUser?->name ?? 'Freelancer' }}
                                        </p>

                                        @if ($freelancer?->username)

                                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                                {{ '@' . ltrim($freelancer->username, '@') }}
                                            </p>

                                        @endif

                                    </div>

                                </td>


                                {{-- CATEGORY --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[140px]">

                                        <p class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                                            {{ $service->category?->name ?? '-' }}
                                        </p>

                                        @if ($service->subcategory)

                                            <p class="mt-1 text-[11px] text-slate-400 dark:text-slate-500">
                                                {{ $service->subcategory->name }}
                                            </p>

                                        @endif

                                    </div>

                                </td>


                                {{-- STATUS --}}
                                <td class="px-5 py-4">

                                    @if ($service->status === 'pending')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>

                                    @elseif ($service->status === 'published')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1.5 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Published
                                        </span>

                                    @elseif ($service->status === 'rejected')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-rose-50 px-2.5 py-1.5 text-[10px] font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                            Rejected
                                        </span>

                                    @elseif ($service->status === 'draft')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1.5 text-[10px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Draft
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1.5 text-[10px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            {{ ucfirst($service->status) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}
                                <td class="px-5 py-4 text-right">

                                    <a
                                        href="{{ route('admin.service-moderation.show', $service) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-blue-500/30 dark:hover:bg-blue-500/10 dark:hover:text-blue-400"
                                    >
                                        <i class="bi bi-eye"></i>
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- ==================================================
                 MOBILE LIST
            =================================================== --}}
            <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">

                @foreach ($services as $service)

                    @php
                        $freelancer = $service->freelancerProfile;
                        $freelancerUser = $freelancer?->user;
                    @endphp


                    <article class="p-4 sm:p-5">

                        {{-- TOP --}}
                        <div class="flex items-start gap-3">

                            <div class="h-16 w-24 shrink-0 overflow-hidden rounded-xl bg-slate-100 ring-1 ring-slate-200 dark:bg-slate-800 dark:ring-slate-700">

                                @if ($service->thumbnail)

                                    <img
                                        src="{{ asset('storage/' . $service->thumbnail) }}"
                                        alt="{{ $service->title }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center text-slate-400 dark:text-slate-500">
                                        <i class="bi bi-image"></i>
                                    </div>

                                @endif

                            </div>


                            <div class="min-w-0 flex-1">

                                <h3 class="line-clamp-2 text-sm font-bold leading-5 text-slate-900 dark:text-white">
                                    {{ $service->title }}
                                </h3>

                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    Mulai Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>


                        {{-- INFO --}}
                        <div class="mt-4 space-y-2.5">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-xs text-slate-400 dark:text-slate-500">
                                    Freelancer
                                </span>

                                <span class="max-w-[60%] truncate text-right text-xs font-semibold text-slate-700 dark:text-slate-200">
                                    {{ $freelancerUser?->name ?? 'Freelancer' }}
                                </span>

                            </div>


                            @if ($freelancer?->username)

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-slate-400 dark:text-slate-500">
                                        Username
                                    </span>

                                    <span class="truncate text-right text-xs text-slate-600 dark:text-slate-300">
                                        {{ '@' . ltrim($freelancer->username, '@') }}
                                    </span>

                                </div>

                            @endif


                            <div class="flex items-center justify-between gap-4">

                                <span class="text-xs text-slate-400 dark:text-slate-500">
                                    Kategori
                                </span>

                                <span class="max-w-[60%] truncate text-right text-xs font-medium text-slate-600 dark:text-slate-300">
                                    {{ $service->category?->name ?? '-' }}
                                </span>

                            </div>


                            @if ($service->subcategory)

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-slate-400 dark:text-slate-500">
                                        Subkategori
                                    </span>

                                    <span class="max-w-[60%] truncate text-right text-xs text-slate-500 dark:text-slate-400">
                                        {{ $service->subcategory->name }}
                                    </span>

                                </div>

                            @endif


                            <div class="flex items-center justify-between gap-4">

                                <span class="text-xs text-slate-400 dark:text-slate-500">
                                    Status
                                </span>

                                <span>

                                    @if ($service->status === 'pending')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>

                                    @elseif ($service->status === 'published')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Published
                                        </span>

                                    @elseif ($service->status === 'rejected')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-rose-50 px-2.5 py-1 text-[10px] font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                            Rejected
                                        </span>

                                    @elseif ($service->status === 'draft')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1 text-[10px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Draft
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1 text-[10px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            {{ ucfirst($service->status) }}
                                        </span>

                                    @endif

                                </span>

                            </div>

                        </div>


                        {{-- ACTION --}}
                        <div class="mt-4">

                            <a
                                href="{{ route('admin.service-moderation.show', $service) }}"
                                class="inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-blue-500/30 dark:hover:bg-blue-500/10 dark:hover:text-blue-400"
                            >
                                <i class="bi bi-eye"></i>
                                Lihat Detail Jasa
                                <i class="bi bi-arrow-right text-[10px]"></i>
                            </a>

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- ==================================================
                 PAGINATION
            =================================================== --}}
            @if ($services->hasPages())

                <div class="border-t border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-5">
                    {{ $services->links() }}
                </div>

            @endif


        @else

            {{-- ==================================================
                 EMPTY STATE
            =================================================== --}}
            <div class="px-5 py-16 text-center sm:px-8">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="bi bi-inbox text-2xl"></i>
                </div>

                <h3 class="mt-5 text-sm font-bold text-slate-900 dark:text-white">
                    Tidak ada jasa
                </h3>

                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Belum ada data yang sesuai dengan filter yang dipilih.
                </p>

            </div>

        @endif

    </section>

</div>


</x-layouts.admin>
