
<x-layouts.freelancer title="Job Board">

    <main class="min-h-[calc(100vh-72px)] bg-[#F8FAFC]">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <section class="border-b border-[#E5EAF2] bg-white">

            <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        {{-- Breadcrumb --}}
                        <div class="flex items-center gap-2 text-xs text-[#7B8798]">

                            <span>PROKERJA</span>

                            <i class="bi bi-chevron-right text-[9px]"></i>

                            <span class="font-medium text-[#172B4D]">
                                Job Board
                            </span>

                        </div>

                        {{-- Title --}}
                        <h1
                            class="mt-2 text-2xl font-semibold tracking-tight text-[#172B4D] sm:text-3xl"
                        >
                            Cari pekerjaan
                        </h1>

                        {{-- Description --}}
                        <p
                            class="mt-1.5 max-w-2xl text-sm leading-6 text-[#718096]"
                        >
                            Temukan project yang sesuai dengan keahlianmu dan
                            kirim proposal kepada client.
                        </p>

                    </div>

                    {{-- Job Counter --}}
                    <div
                        class="hidden items-center gap-2 rounded-lg bg-[#EFF6FF] px-3 py-2 text-xs text-[#486581] sm:flex"
                    >

                        <i class="bi bi-briefcase text-[#2563EB]"></i>

                        <span>
                            {{ $jobs->total() }} pekerjaan tersedia
                        </span>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
             CONTENT
        ========================================================== --}}
        <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">


            {{-- =====================================================
                 SEARCH
            ====================================================== --}}
            <form
                method="GET"
                action="{{ route('freelancer.jobs.index') }}"
                class="rounded-xl border border-[#E2E8F0] bg-white p-4 shadow-sm shadow-[#0F172A]/[0.02] sm:p-5"
            >

                <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_220px_90px]">


                    {{-- Search Input --}}
                    <div>

                        <label
                            class="mb-1.5 block text-xs font-semibold text-[#334155]"
                        >
                            Cari pekerjaan
                        </label>

                        <div class="relative">

                            <i
                                class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#94A3B8]"
                            ></i>

                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Cari berdasarkan judul atau deskripsi..."
                                class="h-10 w-full rounded-lg border border-[#DCE3ED] bg-white pl-9 pr-3 text-sm text-[#1E293B] outline-none transition duration-200 placeholder:text-[#9AA5B1] hover:border-[#C9D4E3] focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/10"
                            >

                        </div>

                    </div>


                    {{-- Category --}}
                    <div>

                        <label
                            class="mb-1.5 block text-xs font-semibold text-[#334155]"
                        >
                            Job category
                        </label>

                        <select
                            name="category"
                            class="h-10 w-full rounded-lg border border-[#DCE3ED] bg-white px-3 text-sm text-[#334155] outline-none transition duration-200 hover:border-[#C9D4E3] focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/10"
                        >

                            <option value="">
                                Semua kategori
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->slug }}"
                                    @selected(request('category') === $category->slug)
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Search Button --}}
                    <div class="flex items-end">

                        <button
                            type="submit"
                            class="h-10 w-full rounded-lg bg-[#2563EB] px-4 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#1D4ED8] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#2563EB]/20 active:scale-[0.98]"
                        >
                            Cari
                        </button>

                    </div>

                </div>

            </form>


            {{-- =====================================================
                 HEADING
            ====================================================== --}}
            <div class="mt-7 flex items-end justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-[#172B4D]">
                        Available jobs
                    </h2>

                    <p class="mt-0.5 text-xs text-[#8190A5]">
                        Pilih pekerjaan yang sesuai dengan kemampuanmu.
                    </p>

                </div>

            </div>


            {{-- =====================================================
                 DESKTOP LIST
            ====================================================== --}}
            <div
                class="mt-4 hidden overflow-hidden rounded-xl border border-[#E2E8F0] bg-white shadow-sm shadow-[#0F172A]/[0.02] lg:block"
            >

                {{-- Table Header --}}
                <div
                    class="grid grid-cols-[minmax(300px,1.8fr)_1.1fr_0.75fr_0.9fr_1fr_1fr_92px] items-center border-b border-[#E6EBF2] bg-[#F8FAFC] px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.04em] text-[#718096]"
                >

                    <div>
                        Jobs
                    </div>

                    <div>
                        Kategori
                    </div>

                    <div>
                        Type
                    </div>

                    <div>
                        Budget
                    </div>

                    <div>
                        Posted
                    </div>

                    <div>
                        Deliver Within
                    </div>

                    <div></div>

                </div>


                @forelse($jobs as $job)

                    @php

                        $budget = 'Negosiasi';

                        if (
                            $job->budget_min !== null &&
                            $job->budget_max !== null
                        ) {

                            $budget =
                                'Rp ' .
                                number_format(
                                    (float) $job->budget_min,
                                    0,
                                    ',',
                                    '.'
                                ) .
                                ' - Rp ' .
                                number_format(
                                    (float) $job->budget_max,
                                    0,
                                    ',',
                                    '.'
                                );

                        } elseif ($job->budget_min !== null) {

                            $budget =
                                'Rp ' .
                                number_format(
                                    (float) $job->budget_min,
                                    0,
                                    ',',
                                    '.'
                                );

                        } elseif ($job->budget_max !== null) {

                            $budget =
                                'Rp ' .
                                number_format(
                                    (float) $job->budget_max,
                                    0,
                                    ',',
                                    '.'
                                );

                        }

                    @endphp


                    {{-- Job Row --}}
                    <a
                        href="{{ route('freelancer.jobs.show', $job) }}"
                        class="group grid grid-cols-[minmax(300px,1.8fr)_1.1fr_0.75fr_0.9fr_1fr_1fr_92px] items-center border-b border-[#E8EDF3] px-5 py-4 transition duration-200 last:border-b-0 hover:bg-[#F8FBFF]"
                    >

                        {{-- Job --}}
                        <div class="min-w-0 pr-5">

                            <h3
                                class="truncate text-sm font-semibold text-[#1E293B] transition group-hover:text-[#2563EB]"
                            >
                                {{ $job->title }}
                            </h3>

                            <div
                                class="mt-1.5 flex items-center gap-2 text-[11px] text-[#8190A5]"
                            >

                                <span>
                                    {{ $job->proposals_count }} applied
                                </span>

                                @if($job->location)

                                    <span class="text-[#C1CBD8]">
                                        •
                                    </span>

                                    <span class="truncate">
                                        {{ $job->location }}
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Category --}}
                        <div class="pr-4 text-xs text-[#53657A]">

                            {{ $job->category?->name ?? 'Lainnya' }}

                        </div>


                        {{-- Type --}}
                        <div class="pr-4">

                            <span
                                class="inline-flex rounded-md bg-[#EFF6FF] px-2 py-1 text-[11px] font-medium text-[#2563EB]"
                            >
                                Freelance
                            </span>

                        </div>


                        {{-- Budget --}}
                        <div
                            class="pr-4 text-xs font-medium text-[#253B5B]"
                        >
                            {{ $budget }}
                        </div>


                        {{-- Posted --}}
                        <div
                            class="pr-4 text-xs text-[#718096]"
                        >
                            {{ optional($job->published_at)->format('d/m/Y H:i') ?? '-' }}
                        </div>


                        {{-- Deliver --}}
                        <div
                            class="pr-4 text-xs text-[#718096]"
                        >

                            @if($job->deadline)

                                {{ $job->deadline->format('d/m/Y') }}

                            @elseif($job->duration_days)

                                {{ $job->duration_days }} hari

                            @else

                                -

                            @endif

                        </div>


                        {{-- Apply --}}
                        <div class="flex justify-end">

                            <span
                                class="inline-flex h-8 min-w-[68px] items-center justify-center rounded-md border border-[#BFDBFE] bg-white px-3 text-xs font-semibold text-[#2563EB] transition duration-200 group-hover:border-[#2563EB] group-hover:bg-[#EFF6FF]"
                            >
                                Apply
                            </span>

                        </div>

                    </a>


                @empty

                    {{-- Empty --}}
                    <div class="px-6 py-16 text-center">

                        <div
                            class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg bg-[#EFF6FF] text-[#7C9BCF]"
                        >
                            <i class="bi bi-search"></i>
                        </div>

                        <h3
                            class="mt-4 text-sm font-semibold text-[#172B4D]"
                        >
                            Belum ada pekerjaan
                        </h3>

                        <p
                            class="mt-1.5 text-xs text-[#8190A5]"
                        >
                            Coba gunakan kata kunci atau kategori lain.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- =====================================================
                 MOBILE LIST
            ====================================================== --}}
            <div class="mt-4 space-y-3 lg:hidden">

                @forelse($jobs as $job)

                    @php

                        $budget = 'Negosiasi';

                        if (
                            $job->budget_min !== null &&
                            $job->budget_max !== null
                        ) {

                            $budget =
                                'Rp ' .
                                number_format(
                                    (float) $job->budget_min,
                                    0,
                                    ',',
                                    '.'
                                ) .
                                ' - Rp ' .
                                number_format(
                                    (float) $job->budget_max,
                                    0,
                                    ',',
                                    '.'
                                );

                        } elseif ($job->budget_min !== null) {

                            $budget =
                                'Rp ' .
                                number_format(
                                    (float) $job->budget_min,
                                    0,
                                    ',',
                                    '.'
                                );

                        } elseif ($job->budget_max !== null) {

                            $budget =
                                'Rp ' .
                                number_format(
                                    (float) $job->budget_max,
                                    0,
                                    ',',
                                    '.'
                                );

                        }

                    @endphp


                    {{-- Mobile Job Card --}}
                    <a
                        href="{{ route('freelancer.jobs.show', $job) }}"
                        class="group block rounded-xl border border-[#E2E8F0] bg-white p-4 shadow-sm shadow-[#0F172A]/[0.02] transition duration-200 hover:border-[#BFDBFE] hover:shadow-md hover:shadow-[#2563EB]/[0.04]"
                    >

                        <div
                            class="flex items-start justify-between gap-3"
                        >

                            <div class="min-w-0">

                                <h3
                                    class="text-sm font-semibold leading-5 text-[#1E293B] transition group-hover:text-[#2563EB]"
                                >
                                    {{ $job->title }}
                                </h3>

                                <div
                                    class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] text-[#8190A5]"
                                >

                                    <span>
                                        {{ $job->category?->name ?? 'Lainnya' }}
                                    </span>

                                    <span class="text-[#C4CDD8]">
                                        •
                                    </span>

                                    <span>
                                        Freelance
                                    </span>

                                </div>

                            </div>

                            <i
                                class="bi bi-chevron-right shrink-0 pt-1 text-xs text-[#9AA7B8] transition group-hover:translate-x-0.5 group-hover:text-[#2563EB]"
                            ></i>

                        </div>


                        {{-- Mobile Information --}}
                        <div
                            class="mt-4 grid grid-cols-2 gap-3 border-t border-[#EDF1F5] pt-3"
                        >

                            {{-- Budget --}}
                            <div>

                                <p
                                    class="text-[10px] uppercase tracking-[0.04em] text-[#8A97A8]"
                                >
                                    Budget
                                </p>

                                <p
                                    class="mt-1 text-xs font-semibold text-[#253B5B]"
                                >
                                    {{ $budget }}
                                </p>

                            </div>


                            {{-- Posted --}}
                            <div>

                                <p
                                    class="text-[10px] uppercase tracking-[0.04em] text-[#8A97A8]"
                                >
                                    Posted
                                </p>

                                <p
                                    class="mt-1 text-xs text-[#718096]"
                                >
                                    {{ optional($job->published_at)->format('d/m/Y') ?? '-' }}
                                </p>

                            </div>


                            {{-- Deliver --}}
                            <div>

                                <p
                                    class="text-[10px] uppercase tracking-[0.04em] text-[#8A97A8]"
                                >
                                    Deliver within
                                </p>

                                <p
                                    class="mt-1 text-xs text-[#718096]"
                                >

                                    @if($job->deadline)

                                        {{ $job->deadline->format('d/m/Y') }}

                                    @elseif($job->duration_days)

                                        {{ $job->duration_days }} hari

                                    @else

                                        -

                                    @endif

                                </p>

                            </div>


                            {{-- Applied --}}
                            <div>

                                <p
                                    class="text-[10px] uppercase tracking-[0.04em] text-[#8A97A8]"
                                >
                                    Applied
                                </p>

                                <p
                                    class="mt-1 text-xs font-medium text-[#2563EB]"
                                >
                                    {{ $job->proposals_count }}
                                </p>

                            </div>

                        </div>


                        {{-- Mobile CTA --}}
                        <div class="mt-4">

                            <span
                                class="inline-flex h-9 w-full items-center justify-center rounded-md border border-[#BFDBFE] bg-white text-xs font-semibold text-[#2563EB] transition duration-200 group-hover:bg-[#EFF6FF]"
                            >
                                Lihat & Ajukan Proposal
                            </span>

                        </div>

                    </a>


                @empty

                    {{-- Mobile Empty --}}
                    <div
                        class="rounded-xl border border-[#E2E8F0] bg-white px-6 py-16 text-center shadow-sm shadow-[#0F172A]/[0.02]"
                    >

                        <div
                            class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg bg-[#EFF6FF] text-[#7C9BCF]"
                        >
                            <i class="bi bi-search"></i>
                        </div>

                        <h3
                            class="mt-4 text-sm font-semibold text-[#172B4D]"
                        >
                            Belum ada pekerjaan
                        </h3>

                        <p
                            class="mt-1.5 text-xs text-[#8190A5]"
                        >
                            Coba gunakan kata kunci atau kategori lain.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- =====================================================
                 PAGINATION
            ====================================================== --}}
            @if($jobs->hasPages())

                <div class="mt-5">

                    {{ $jobs->links() }}

                </div>

            @endif

        </section>

    </main>

</x-layouts.freelancer>
