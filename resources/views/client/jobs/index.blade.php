<x-layouts.marketplace>

    @php
        $statusFilter = request('status');

        $statusMeta = [
            'open' => [
                'label' => 'Open',
                'bg' => 'bg-emerald-50',
                'text' => 'text-emerald-700',
                'border' => 'border-emerald-200',
                'dot' => 'bg-emerald-500',
            ],
            'closed' => [
                'label' => 'Closed',
                'bg' => 'bg-slate-100',
                'text' => 'text-slate-600',
                'border' => 'border-slate-200',
                'dot' => 'bg-slate-400',
            ],
            'draft' => [
                'label' => 'Draft',
                'bg' => 'bg-amber-50',
                'text' => 'text-amber-700',
                'border' => 'border-amber-200',
                'dot' => 'bg-amber-500',
            ],
        ];

        $statusItems = [
            '' => 'Semua Job',
            'open' => 'Open',
            'closed' => 'Closed',
            'draft' => 'Draft',
        ];

        $totalJobs = method_exists($jobs, 'total')
            ? $jobs->total()
            : $jobs->count();
    @endphp

    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            {{-- =========================================================
                HEADER
            ========================================================== --}}
            <section class="mb-6 sm:mb-8">

                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                    <div class="max-w-2xl">

                        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">

                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-blue-600 text-white">
                                <svg
                                    class="h-3 w-3"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M4 5h16M4 12h16M4 19h10" />
                                </svg>
                            </span>

                            Job Board
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Job Saya
                        </h1>

                        <p class="mt-2 text-sm leading-6 text-slate-500 sm:text-base">
                            Kelola kebutuhan pekerjaan yang kamu publikasikan dan pantau proposal dari freelancer.
                        </p>

                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">

                        {{-- Total job --}}
                        <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">

                            <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-400">
                                Total Job
                            </p>

                            <p class="mt-1 text-xl font-bold text-slate-900">
                                {{ number_format($totalJobs) }}
                            </p>

                        </div>

                        {{-- Create job --}}
                        <a
                            href="{{ route('client.jobs.create') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M12 5v14" />
                                <path d="M5 12h14" />
                            </svg>

                            Buat Job
                        </a>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                SUCCESS MESSAGE
            ========================================================== --}}
            @if(session('success'))

                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-800 shadow-sm">

                    <div class="flex items-start gap-3">

                        <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="m5 12 4 4L19 6" />
                            </svg>

                        </span>

                        <div>
                            <p class="font-semibold">
                                Berhasil
                            </p>

                            <p class="mt-0.5 text-xs leading-5 text-emerald-700">
                                {{ session('success') }}
                            </p>
                        </div>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                QUICK INFO
            ========================================================== --}}
            <section class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-3">

                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9"
                            >
                                <path d="M4 5h16v14H4z" />
                                <path d="M8 9h8M8 13h5" />
                            </svg>

                        </div>

                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                Job Dipublikasikan
                            </p>

                            <p class="mt-0.5 text-lg font-bold text-slate-900">
                                {{ number_format($totalJobs) }}
                            </p>
                        </div>

                    </div>

                </div>


                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9"
                            >
                                <path d="M4 12h16" />
                                <path d="M12 4v16" />
                            </svg>

                        </div>

                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                Marketplace
                            </p>

                            <p class="mt-0.5 text-sm font-bold text-slate-900">
                                Cari Freelancer
                            </p>
                        </div>

                    </div>

                </div>


                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.9"
                            >
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 21a8 8 0 0 1 16 0" />
                            </svg>

                        </div>

                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                Tujuan
                            </p>

                            <p class="mt-0.5 text-sm font-bold text-slate-900">
                                Dapatkan Proposal
                            </p>
                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                FILTER
            ========================================================== --}}
            <section class="mb-6">

                <div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-sm">

                    <div class="flex gap-1 overflow-x-auto pb-1 scrollbar-none">

                        @foreach($statusItems as $key => $label)

                            @php
                                $isActive = ($statusFilter ?? '') === $key;

                                $filterUrl = $key !== ''
                                    ? route('client.jobs.index', ['status' => $key])
                                    : route('client.jobs.index');
                            @endphp

                            <a
                                href="{{ $filterUrl }}"
                                @class([
                                    'inline-flex shrink-0 items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition duration-200',
                                    'bg-[#EFF6FF] text-[#2563EB]' => $isActive,
                                    'text-slate-500 hover:bg-slate-50 hover:text-slate-800' => !$isActive,
                                ])
                            >

                                @if($key !== '')

                                    <span
                                        @class([
                                            'h-2 w-2 rounded-full',
                                            $statusMeta[$key]['dot'] ?? 'bg-slate-400',
                                        ])
                                    ></span>

                                @endif

                                {{ $label }}

                                @if($isActive)

                                    <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-bold text-blue-700">
                                        {{ $totalJobs }}
                                    </span>

                                @endif

                            </a>

                        @endforeach

                    </div>

                </div>

            </section>


            {{-- =========================================================
                CONTENT HEADER
            ========================================================== --}}
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="text-base font-bold text-slate-900 sm:text-lg">
                        {{ $statusFilter ? ($statusMeta[$statusFilter]['label'] ?? ucfirst($statusFilter)) : 'Semua Job' }}
                    </h2>

                    <p class="text-sm text-slate-500">
                        {{ $totalJobs }} job ditemukan
                    </p>

                </div>

                @if($statusFilter)

                    <a
                        href="{{ route('client.jobs.index') }}"
                        class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-[#2563EB] transition hover:text-blue-700"
                    >
                        Tampilkan semua

                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M5 12h14" />
                            <path d="m13 6 6 6-6 6" />
                        </svg>

                    </a>

                @endif

            </div>


            {{-- =========================================================
                JOB LIST
            ========================================================== --}}
            @if($jobs->count())

                <div class="space-y-4">

                    @foreach($jobs as $job)

                        @php

                            $statusKey = strtolower($job->status ?? '');

                            $meta = $statusMeta[$statusKey] ?? [
                                'label' => ucfirst(str_replace('_', ' ', $job->status ?? 'unknown')),
                                'bg' => 'bg-slate-50',
                                'text' => 'text-slate-700',
                                'border' => 'border-slate-200',
                                'dot' => 'bg-slate-400',
                            ];

                            $createdAt = $job->created_at;

                            $proposalCount = (int) ($job->proposals_count ?? 0);

                            $categoryName = $job->category?->name ?? 'Job';

                            $detailUrl = route('client.jobs.show', $job);

                        @endphp


                        <article
                            class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/60"
                        >

                            {{-- =================================================
                                TOP BAR
                            ================================================== --}}
                            <div class="flex flex-col gap-3 border-b border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-900 text-xs font-bold text-white">
                                        JOB
                                    </div>

                                    <div class="min-w-0">

                                        <div class="flex flex-wrap items-center gap-2">

                                            <p class="truncate text-sm font-bold text-slate-900">
                                                Job #{{ $job->id }}
                                            </p>

                                            @if($createdAt)

                                                <span class="hidden text-slate-300 sm:inline">
                                                    •
                                                </span>

                                                <p class="text-xs text-slate-500">
                                                    {{ $createdAt->format('d M Y') }}
                                                </p>

                                            @endif

                                        </div>

                                        <p class="mt-0.5 text-xs text-slate-400">
                                            Dipublikasikan di Job Board
                                        </p>

                                    </div>

                                </div>


                                <span
                                    class="{{ $meta['bg'] }} {{ $meta['text'] }} {{ $meta['border'] }} inline-flex w-fit items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-bold"
                                >

                                    <span class="{{ $meta['dot'] }} h-2 w-2 rounded-full"></span>

                                    {{ $meta['label'] }}

                                </span>

                            </div>


                            {{-- =================================================
                                MAIN BODY
                            ================================================== --}}
                            <div class="p-4 sm:p-5">

                                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                                    {{-- Main information --}}
                                    <div class="min-w-0 flex-1">

                                        <div class="mb-3 flex flex-wrap items-center gap-2">

                                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600">
                                                {{ $categoryName }}
                                            </span>

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-[11px] font-semibold text-blue-700">

                                                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>

                                                {{ $proposalCount }} proposal

                                            </span>

                                        </div>


                                        <h3 class="line-clamp-2 text-lg font-bold leading-7 text-slate-900 transition group-hover:text-[#2563EB] sm:text-xl">
                                            {{ $job->title }}
                                        </h3>


                                        <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">
                                            Kelola job ini untuk melihat proposal freelancer dan melanjutkan proses perekrutan.
                                        </p>


                                        <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-slate-500">

                                            @if($createdAt)

                                                <span class="inline-flex items-center gap-1.5">

                                                    <svg
                                                        class="h-3.5 w-3.5 text-slate-400"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <circle cx="12" cy="12" r="9" />
                                                        <path d="M12 7v5l3 2" />
                                                    </svg>

                                                    {{ $createdAt->diffForHumans() }}

                                                </span>

                                            @endif


                                            <span class="inline-flex items-center gap-1.5">

                                                <svg
                                                    class="h-3.5 w-3.5 text-slate-400"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                                    <circle cx="9" cy="7" r="4" />
                                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                </svg>

                                                {{ $proposalCount }} freelancer mengajukan proposal

                                            </span>

                                        </div>

                                    </div>


                                    {{-- Action panel --}}
                                    <div class="w-full shrink-0 border-t border-slate-100 pt-4 lg:w-56 lg:border-l lg:border-t-0 lg:pl-5 lg:pt-0">

                                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                            Job Board
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-slate-900">
                                            {{ $proposalCount }} Proposal
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Lihat kandidat dan detail job untuk melanjutkan proses.
                                        </p>


                                        <div class="mt-4 flex flex-col gap-2">

                                            <a
                                                href="{{ $detailUrl }}"
                                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700"
                                            >
                                                Lihat Detail

                                                <svg
                                                    class="h-4 w-4"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M5 12h14" />
                                                    <path d="m13 6 6 6-6 6" />
                                                </svg>

                                            </a>

                                        </div>

                                    </div>

                                </div>


                                {{-- =================================================
                                    BOTTOM INFO
                                ================================================== --}}
                                <div class="mt-5 flex flex-col gap-3 rounded-2xl bg-slate-50 px-4 py-3.5 sm:flex-row sm:items-center sm:justify-between">

                                    <div class="flex min-w-0 items-center gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">

                                            <svg
                                                class="h-4 w-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.9"
                                            >
                                                <path d="M4 5h16v14H4z" />
                                                <path d="M8 9h8M8 13h5" />
                                            </svg>

                                        </div>

                                        <div class="min-w-0">

                                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                                Status Job
                                            </p>

                                            <p class="mt-0.5 truncate text-sm font-bold text-slate-800">
                                                {{ $meta['label'] }}
                                            </p>

                                        </div>

                                    </div>


                                    <div class="flex items-center gap-2 text-xs text-slate-500">

                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-slate-500 shadow-sm">

                                            <svg
                                                class="h-4 w-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.9"
                                            >
                                                <circle cx="12" cy="12" r="9" />
                                                <path d="M12 7v5l3 2" />
                                            </svg>

                                        </span>

                                        <span>
                                            <span class="block font-semibold text-slate-700">
                                                Dibuat {{ $createdAt?->format('d M Y') ?? '-' }}
                                            </span>

                                            <span class="block text-[11px] text-slate-400">
                                                {{ $createdAt?->diffForHumans() ?? 'Tanggal tidak tersedia' }}
                                            </span>
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- =========================================================
                    PAGINATION
                ========================================================== --}}
                @if($jobs->hasPages())

                    <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm sm:mt-8 sm:px-5">

                        {{ $jobs->links() }}

                    </div>

                @endif


            @else

                {{-- =========================================================
                    EMPTY STATE
                ========================================================== --}}
                <section class="rounded-3xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center shadow-sm sm:px-8 sm:py-16">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB]">

                        <svg
                            class="h-8 w-8"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M4 5h16v14H4z" />
                            <path d="M8 9h8M8 13h5" />
                        </svg>

                    </div>


                    <h2 class="mt-5 text-xl font-bold text-slate-900">
                        Belum ada job
                    </h2>


                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">

                        @if($statusFilter)

                            Belum ada job dengan status
                            “{{ $statusMeta[$statusFilter]['label'] ?? ucfirst($statusFilter) }}”.

                            Coba lihat semua job atau buat job baru.

                        @else

                            Buat job pertama untuk mulai menerima proposal dari freelancer di ProKerja.

                        @endif

                    </p>


                    <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">

                        @if($statusFilter)

                            <a
                                href="{{ route('client.jobs.index') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Lihat Semua Job
                            </a>

                        @endif


                        <a
                            href="{{ route('client.jobs.create') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700"
                        >
                            Buat Job

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M5 12h14" />
                                <path d="m13 6 6 6-6 6" />
                            </svg>

                        </a>

                    </div>

                </section>

            @endif


            {{-- =========================================================
                BOTTOM INFORMATION
            ========================================================== --}}
            <section class="mt-6 sm:mt-8">

                <div class="rounded-3xl border border-blue-100 bg-gradient-to-r from-blue-50 via-white to-blue-50/60 p-5 sm:p-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="max-w-xl">

                            <div class="flex items-center gap-2">

                                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-100 text-blue-700">

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.9"
                                    >
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 11v5" />
                                        <path d="M12 8h.01" />
                                    </svg>

                                </span>

                                <p class="text-sm font-bold text-slate-800">
                                    Tips menggunakan Job Board
                                </p>

                            </div>

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Buat job dengan kebutuhan yang jelas agar freelancer lebih mudah memahami pekerjaan dan mengirimkan proposal yang sesuai.
                            </p>

                        </div>


                        <a
                            href="{{ route('client.jobs.create') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-white px-4 py-3 text-sm font-semibold text-blue-700 transition hover:border-blue-300 hover:bg-blue-50"
                        >
                            Buat Job Baru

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M5 12h14" />
                                <path d="m13 6 6 6-6 6" />
                            </svg>

                        </a>

                    </div>

                </div>

            </section>

        </div>

    </div>


    <style>
        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

</x-layouts.marketplace>
