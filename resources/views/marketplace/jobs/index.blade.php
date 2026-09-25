<x-layouts.marketplace :title="'Job Board - ProKerja'">


@php
    /*
    |--------------------------------------------------------------------------
    | Safe values
    |--------------------------------------------------------------------------
    */

    $search = $search ?? request('q', '');
    $categorySlug = $categorySlug ?? request('category', '');
    $sort = $sort ?? request('sort', 'relevance');
    $minBudget = $minBudget ?? request('min_budget', '');
    $maxBudget = $maxBudget ?? request('max_budget', '');

    $selectedCategory = $selectedCategory ?? null;

    $categories = $categories ?? collect();

    /*
    |--------------------------------------------------------------------------
    | Job count
    |--------------------------------------------------------------------------
    */

    $jobTotal = method_exists($jobs, 'total')
        ? $jobs->total()
        : $jobs->count();
@endphp


<div class="min-h-screen bg-[#F8FAFC]">


    {{-- ========================================================= --}}
    {{-- COMPACT HEADER --}}
    {{-- ========================================================= --}}

    <section class="border-b border-slate-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-8">

            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                <div class="max-w-2xl">

                    <div class="mb-3 flex items-center gap-2 text-xs font-semibold text-[#2563EB]">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#EFF6FF]">
                            <i class="bi bi-briefcase"></i>
                        </span>

                        Job Board
                    </div>


                    <h1 class="text-2xl font-bold tracking-tight text-[#0F172A] sm:text-3xl lg:text-4xl">
                        Temukan project yang cocok untukmu.
                    </h1>


                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500 sm:text-[15px]">
                        Jelajahi kebutuhan client dari berbagai kategori dan temukan
                        project yang sesuai dengan keahlianmu.
                    </p>

                </div>


                @auth

                    @if (auth()->user()->role === 'client')

                        <a
                            href="{{ route('client.jobs.create') }}"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8]"
                        >
                            <i class="bi bi-plus-lg"></i>
                            Posting project
                        </a>

                    @endif

                @endauth

            </div>

        </div>

    </section>


    {{-- ========================================================= --}}
    {{-- SEARCH + FILTER --}}
    {{-- ========================================================= --}}

    <section class="border-b border-slate-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">

            <form
                method="GET"
                action="{{ route('marketplace.jobs.index') }}"
            >

                {{-- Search --}}
                <div class="flex flex-col gap-3 lg:flex-row">

                    <div class="relative min-w-0 flex-1">

                        <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                        <input
                            type="text"
                            name="q"
                            value="{{ $search }}"
                            placeholder="Cari project, skill, kebutuhan client..."
                            class="h-12 w-full rounded-xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2563EB] focus:ring-2 focus:ring-[#DBEAFE]"
                        >

                    </div>


                    <button
                        type="submit"
                        class="inline-flex h-12 shrink-0 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-6 text-sm font-semibold text-white transition hover:bg-[#1D4ED8]"
                    >
                        <i class="bi bi-search"></i>
                        Cari project
                    </button>

                </div>


                {{-- Filters --}}
                <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">


                    {{-- Category --}}
                    <div>

                        <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                            Kategori
                        </label>

                        <select
                            name="category"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-600 outline-none transition focus:border-[#2563EB] focus:ring-2 focus:ring-[#DBEAFE]"
                        >

                            <option value="">
                                Semua kategori
                            </option>

                            @foreach ($categories as $category)

                                <option
                                    value="{{ $category->slug }}"
                                    @selected($categorySlug === $category->slug)
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Min Budget --}}
                    <div>

                        <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                            Minimum budget
                        </label>

                        <input
                            type="number"
                            name="min_budget"
                            min="0"
                            step="1000"
                            value="{{ $minBudget }}"
                            placeholder="Contoh: 500000"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-600 outline-none transition placeholder:text-slate-400 focus:border-[#2563EB] focus:ring-2 focus:ring-[#DBEAFE]"
                        >

                    </div>


                    {{-- Max Budget --}}
                    <div>

                        <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                            Maximum budget
                        </label>

                        <input
                            type="number"
                            name="max_budget"
                            min="0"
                            step="1000"
                            value="{{ $maxBudget }}"
                            placeholder="Contoh: 5000000"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-600 outline-none transition placeholder:text-slate-400 focus:border-[#2563EB] focus:ring-2 focus:ring-[#DBEAFE]"
                        >

                    </div>


                    {{-- Sort --}}
                    <div>

                        <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                            Urutkan
                        </label>

                        <select
                            name="sort"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-600 outline-none transition focus:border-[#2563EB] focus:ring-2 focus:ring-[#DBEAFE]"
                        >

                            <option
                                value="relevance"
                                @selected($sort === 'relevance')
                            >
                                Paling relevan
                            </option>

                            <option
                                value="newest"
                                @selected($sort === 'newest')
                            >
                                Paling baru
                            </option>

                            <option
                                value="deadline"
                                @selected($sort === 'deadline')
                            >
                                Deadline terdekat
                            </option>

                            <option
                                value="budget_low"
                                @selected($sort === 'budget_low')
                            >
                                Budget terendah
                            </option>

                            <option
                                value="budget_high"
                                @selected($sort === 'budget_high')
                            >
                                Budget tertinggi
                            </option>

                            <option
                                value="proposals"
                                @selected($sort === 'proposals')
                            >
                                Paling banyak dilamar
                            </option>

                        </select>

                    </div>

                </div>


                {{-- Active filter actions --}}
                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex flex-wrap items-center gap-2">

                        @if ($search !== '')

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EFF6FF] px-3 py-1.5 text-xs font-semibold text-[#2563EB]">

                                <i class="bi bi-search"></i>

                                {{ $search }}

                            </span>

                        @endif


                        @if ($selectedCategory)

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EFF6FF] px-3 py-1.5 text-xs font-semibold text-[#2563EB]">

                                <i class="bi bi-grid"></i>

                                {{ $selectedCategory->name }}

                            </span>

                        @endif


                        @if ($minBudget !== '')

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">

                                Min Rp{{ number_format($minBudget, 0, ',', '.') }}

                            </span>

                        @endif


                        @if ($maxBudget !== '')

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">

                                Max Rp{{ number_format($maxBudget, 0, ',', '.') }}

                            </span>

                        @endif


                        @if (
                            $search === ''
                            && !$selectedCategory
                            && $minBudget === ''
                            && $maxBudget === ''
                        )

                            <span class="text-xs text-slate-400">
                                Semua project
                            </span>

                        @endif

                    </div>


                    @if (
                        $search !== ''
                        || $selectedCategory
                        || $minBudget !== ''
                        || $maxBudget !== ''
                    )

                        <a
                            href="{{ route('marketplace.jobs.index') }}"
                            class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 transition hover:text-[#2563EB]"
                        >
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Reset filter
                        </a>

                    @endif

                </div>

            </form>

        </div>

    </section>


    {{-- ========================================================= --}}
    {{-- MAIN --}}
    {{-- ========================================================= --}}

    <main class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">


        {{-- Results header --}}
        <div class="flex flex-col gap-3 border-b border-slate-200 pb-5 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                    Project terbuka
                </p>

                <h2 class="mt-1 text-xl font-bold tracking-tight text-[#0F172A] sm:text-2xl">
                    Semua pekerjaan
                </h2>

                <p class="mt-1 text-sm text-slate-500">

                    Menampilkan
                    <span class="font-semibold text-slate-700">
                        {{ number_format($jobTotal, 0, ',', '.') }}
                    </span>
                    project

                    @if ($selectedCategory)
                        dalam {{ $selectedCategory->name }}
                    @endif

                </p>

            </div>


            <div class="text-xs text-slate-400">
                Freelancer dapat mengajukan proposal pada project yang tersedia.
            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- DESKTOP / TABLE-LIKE JOB LIST --}}
        {{-- ========================================================= --}}

        @if ($jobs->count())

            <div class="mt-5 hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm md:block">

                {{-- Table heading --}}
                <div class="grid grid-cols-[minmax(0,1.55fr)_170px_130px_125px_145px] border-b border-slate-200 bg-[#F8FAFC] px-5 py-3 text-[11px] font-semibold uppercase tracking-wide text-slate-400">

                    <div>
                        Project
                    </div>

                    <div>
                        Kategori
                    </div>

                    <div>
                        Tipe
                    </div>

                    <div>
                        Budget
                    </div>

                    <div>
                        Diposting
                    </div>

                </div>


                {{-- Jobs --}}
                <div>

                    @foreach ($jobs as $job)

                        @php
                            $clientName = $job->client?->name ?? 'Client';

                            $clientInitial = strtoupper(
                                substr($clientName, 0, 1)
                            );

                            $publishedAt = $job->published_at
                                ?? $job->created_at;

                            $proposalCount = (int) (
                                $job->proposals_count
                                ?? 0
                            );

                            $daysToDeadline = null;

                            if ($job->deadline) {
                                $daysToDeadline = now()->diffInDays(
                                    $job->deadline,
                                    false
                                );
                            }
                        @endphp


                        <article
                            class="group border-b border-slate-100 last:border-b-0 transition hover:bg-[#FAFCFF]"
                        >

                            <a
                                href="{{ route('marketplace.jobs.show', $job) }}"
                                class="grid grid-cols-[minmax(0,1.55fr)_170px_130px_125px_145px] gap-0 px-5 py-5"
                            >


                                {{-- PROJECT --}}
                                <div class="min-w-0 pr-6">

                                    <div class="flex items-start gap-3">

                                        <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB] transition group-hover:bg-[#DBEAFE]">

                                            <i class="bi bi-briefcase"></i>

                                        </div>


                                        <div class="min-w-0">

                                            <h3 class="line-clamp-2 text-sm font-bold leading-6 text-[#0F172A] transition group-hover:text-[#2563EB]">
                                                {{ $job->title }}
                                            </h3>


                                            <p class="mt-1 line-clamp-2 text-xs leading-5 text-slate-500">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($job->description), 145) }}
                                            </p>


                                            <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-slate-400">

                                                @if ($job->location)

                                                    <span class="inline-flex items-center gap-1">
                                                        <i class="bi bi-geo-alt"></i>
                                                        {{ $job->location }}
                                                    </span>

                                                @endif


                                                @if ($job->duration_days)

                                                    <span class="inline-flex items-center gap-1">
                                                        <i class="bi bi-calendar3"></i>
                                                        {{ $job->duration_days }} hari
                                                    </span>

                                                @endif


                                                <span class="inline-flex items-center gap-1">
                                                    <i class="bi bi-people"></i>
                                                    {{ number_format($proposalCount) }} proposal
                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- CATEGORY --}}
                                <div class="flex items-center pr-4">

                                    <div class="min-w-0">

                                        @if ($job->category)

                                            <p class="truncate text-xs font-semibold text-slate-600">
                                                {{ $job->category->name }}
                                            </p>

                                        @else

                                            <p class="text-xs text-slate-400">
                                                -
                                            </p>

                                        @endif


                                        @if ($job->subcategory)

                                            <p class="mt-1 truncate text-[11px] text-slate-400">
                                                {{ $job->subcategory->name }}
                                            </p>

                                        @endif

                                    </div>

                                </div>


                                {{-- TYPE --}}
                                <div class="flex items-center pr-4">

                                    <span class="inline-flex rounded-full bg-[#EFF6FF] px-2.5 py-1.5 text-[10px] font-semibold text-[#2563EB]">

                                        {{ $job->employment_type
                                            ?? $job->type
                                            ?? 'Freelance' }}

                                    </span>

                                </div>


                                {{-- BUDGET --}}
                                <div class="flex items-center pr-4">

                                    @if (!is_null($job->budget_min) || !is_null($job->budget_max))

                                        <div>

                                            @if ($job->budget_min && $job->budget_max)

                                                <p class="text-xs font-bold text-[#0F172A]">
                                                    Rp{{ number_format($job->budget_min, 0, ',', '.') }}
                                                </p>

                                                <p class="mt-0.5 text-[10px] text-slate-400">
                                                    sampai Rp{{ number_format($job->budget_max, 0, ',', '.') }}
                                                </p>

                                            @elseif ($job->budget_min)

                                                <p class="text-xs font-bold text-[#0F172A]">
                                                    Mulai Rp{{ number_format($job->budget_min, 0, ',', '.') }}
                                                </p>

                                            @else

                                                <p class="text-xs font-bold text-[#0F172A]">
                                                    Hingga Rp{{ number_format($job->budget_max, 0, ',', '.') }}
                                                </p>

                                            @endif

                                        </div>

                                    @else

                                        <span class="text-xs font-semibold text-slate-500">
                                            Fleksibel
                                        </span>

                                    @endif

                                </div>


                                {{-- POSTED --}}
                                <div class="flex items-center justify-between gap-3">

                                    <div>

                                        <p class="text-xs font-medium text-slate-500">
                                            {{ $publishedAt?->diffForHumans() }}
                                        </p>


                                        @if ($job->deadline)

                                            @if ($daysToDeadline !== null && $daysToDeadline < 0)

                                                <p class="mt-1 text-[10px] font-semibold text-[#DC2626]">
                                                    Deadline lewat
                                                </p>

                                            @elseif ($daysToDeadline === 0)

                                                <p class="mt-1 text-[10px] font-semibold text-[#DC2626]">
                                                    Deadline hari ini
                                                </p>

                                            @elseif ($daysToDeadline !== null && $daysToDeadline <= 7)

                                                <p class="mt-1 text-[10px] font-semibold text-[#F59E0B]">
                                                    {{ $daysToDeadline }} hari lagi
                                                </p>

                                            @else

                                                <p class="mt-1 text-[10px] text-slate-400">
                                                    Deadline {{ $job->deadline->format('d M Y') }}
                                                </p>

                                            @endif

                                        @endif

                                    </div>


                                    <i class="bi bi-chevron-right text-xs text-slate-300 transition group-hover:translate-x-1 group-hover:text-[#2563EB]"></i>

                                </div>

                            </a>

                        </article>

                    @endforeach

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- MOBILE JOB LIST --}}
            {{-- ========================================================= --}}

            <div class="mt-5 space-y-3 md:hidden">

                @foreach ($jobs as $job)

                    @php
                        $clientName = $job->client?->name ?? 'Client';

                        $clientInitial = strtoupper(
                            substr($clientName, 0, 1)
                        );

                        $publishedAt = $job->published_at
                            ?? $job->created_at;

                        $proposalCount = (int) (
                            $job->proposals_count
                            ?? 0
                        );

                        $daysToDeadline = null;

                        if ($job->deadline) {
                            $daysToDeadline = now()->diffInDays(
                                $job->deadline,
                                false
                            );
                        }
                    @endphp


                    <article
                        class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 active:scale-[0.995]"
                    >

                        <a
                            href="{{ route('marketplace.jobs.show', $job) }}"
                            class="block p-4"
                        >

                            {{-- Top --}}
                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                    <i class="bi bi-briefcase"></i>
                                </div>


                                <div class="min-w-0 flex-1">

                                    <div class="flex flex-wrap items-center gap-2">

                                        @if ($job->category)

                                            <span class="rounded-full bg-[#EFF6FF] px-2.5 py-1 text-[10px] font-semibold text-[#2563EB]">
                                                {{ $job->category->name }}
                                            </span>

                                        @endif


                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-medium text-slate-500">

                                            {{ $job->employment_type
                                                ?? $job->type
                                                ?? 'Freelance' }}

                                        </span>

                                    </div>


                                    <h3 class="mt-2 line-clamp-3 text-sm font-bold leading-6 text-[#0F172A] transition group-hover:text-[#2563EB]">
                                        {{ $job->title }}
                                    </h3>

                                </div>

                            </div>


                            {{-- Description --}}
                            <p class="mt-3 line-clamp-3 text-xs leading-5 text-slate-500">
                                {{ \Illuminate\Support\Str::limit(strip_tags($job->description), 170) }}
                            </p>


                            {{-- Metadata --}}
                            <div class="mt-4 flex flex-wrap gap-x-4 gap-y-2 text-[11px] text-slate-400">

                                @if ($job->location)

                                    <span class="inline-flex items-center gap-1">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $job->location }}
                                    </span>

                                @endif


                                @if ($job->duration_days)

                                    <span class="inline-flex items-center gap-1">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $job->duration_days }} hari
                                    </span>

                                @endif


                                <span class="inline-flex items-center gap-1">
                                    <i class="bi bi-people"></i>
                                    {{ number_format($proposalCount) }} proposal
                                </span>

                            </div>


                            {{-- Bottom --}}
                            <div class="mt-4 flex items-end justify-between gap-4 border-t border-slate-100 pt-4">

                                <div>

                                    <p class="text-[10px] font-medium text-slate-400">
                                        Budget
                                    </p>


                                    @if ($job->budget_min && $job->budget_max)

                                        <p class="mt-1 text-sm font-bold text-[#0F172A]">
                                            Rp{{ number_format($job->budget_min, 0, ',', '.') }}
                                            –
                                            Rp{{ number_format($job->budget_max, 0, ',', '.') }}
                                        </p>

                                    @elseif ($job->budget_min)

                                        <p class="mt-1 text-sm font-bold text-[#0F172A]">
                                            Mulai Rp{{ number_format($job->budget_min, 0, ',', '.') }}
                                        </p>

                                    @elseif ($job->budget_max)

                                        <p class="mt-1 text-sm font-bold text-[#0F172A]">
                                            Hingga Rp{{ number_format($job->budget_max, 0, ',', '.') }}
                                        </p>

                                    @else

                                        <p class="mt-1 text-sm font-bold text-slate-500">
                                            Budget fleksibel
                                        </p>

                                    @endif

                                </div>


                                <div class="text-right">

                                    <p class="text-[10px] text-slate-400">
                                        Diposting
                                    </p>

                                    <p class="mt-1 text-xs font-semibold text-slate-600">
                                        {{ $publishedAt?->diffForHumans() }}
                                    </p>

                                </div>

                            </div>


                            {{-- Deadline --}}
                            @if ($job->deadline)

                                <div class="mt-4">

                                    @if ($daysToDeadline !== null && $daysToDeadline < 0)

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1.5 text-[10px] font-semibold text-[#DC2626]">
                                            <i class="bi bi-exclamation-circle"></i>
                                            Deadline lewat
                                        </span>

                                    @elseif ($daysToDeadline === 0)

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1.5 text-[10px] font-semibold text-[#DC2626]">
                                            <i class="bi bi-exclamation-circle"></i>
                                            Deadline hari ini
                                        </span>

                                    @elseif ($daysToDeadline !== null && $daysToDeadline <= 7)

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-[10px] font-semibold text-[#F59E0B]">
                                            <i class="bi bi-clock"></i>
                                            Deadline {{ $job->deadline->format('d M Y') }}
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-[10px] font-medium text-slate-500">
                                            <i class="bi bi-calendar-check"></i>
                                            Deadline {{ $job->deadline->format('d M Y') }}
                                        </span>

                                    @endif

                                </div>

                            @endif


                            <div class="mt-4 flex items-center justify-between text-xs font-semibold text-[#2563EB]">

                                Lihat detail project

                                <i class="bi bi-arrow-right transition group-hover:translate-x-1"></i>

                            </div>

                        </a>

                    </article>

                @endforeach

            </div>


            {{-- ========================================================= --}}
            {{-- PAGINATION --}}
            {{-- ========================================================= --}}

            @if (method_exists($jobs, 'hasPages') && $jobs->hasPages())

                <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <p class="text-xs text-slate-500">

                            Menampilkan

                            <span class="font-semibold text-slate-700">
                                {{ $jobs->firstItem() ?? 0 }}
                            </span>

                            sampai

                            <span class="font-semibold text-slate-700">
                                {{ $jobs->lastItem() ?? 0 }}
                            </span>

                            dari

                            <span class="font-semibold text-slate-700">
                                {{ number_format($jobs->total(), 0, ',', '.') }}
                            </span>

                            project

                        </p>


                        <div>
                            {{ $jobs->onEachSide(1)->links() }}
                        </div>

                    </div>

                </div>

            @endif


        @else

            {{-- ========================================================= --}}
            {{-- EMPTY STATE --}}
            {{-- ========================================================= --}}

            <div class="mt-5 rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EFF6FF] text-[#2563EB]">

                    <i class="bi bi-search text-2xl"></i>

                </div>


                <h3 class="mt-5 text-lg font-bold text-[#0F172A]">
                    Project belum ditemukan
                </h3>


                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                    Belum ada project yang sesuai dengan pencarian atau filter saat ini.
                    Coba gunakan kata kunci lain atau reset filter.
                </p>


                <a
                    href="{{ route('marketplace.jobs.index') }}"
                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#1D4ED8]"
                >

                    <i class="bi bi-arrow-counterclockwise"></i>

                    Lihat semua project

                </a>

            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- TRUST / SAFETY INFO --}}
        {{-- ========================================================= --}}

        <div class="mt-7 rounded-2xl border border-[#DBEAFE] bg-[#EFF6FF] px-5 py-5 sm:px-6">

            <div class="flex items-start gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">

                    <i class="bi bi-shield-check"></i>

                </div>


                <div>

                    <h3 class="text-sm font-bold text-[#1E3A8A]">
                        Komunikasi dan transaksi tetap di ProKerja
                    </h3>


                    <p class="mt-1 text-xs leading-5 text-[#64748B]">
                        Gunakan fitur komunikasi dan transaksi ProKerja agar proses project
                        lebih mudah dilacak dan terorganisir.
                    </p>

                </div>

            </div>

        </div>

    </main>

</div>


</x-layouts.marketplace>
