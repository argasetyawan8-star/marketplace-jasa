<x-layouts.marketplace :title="$job->title . ' - ProKerja'">


@php
    /*
    |--------------------------------------------------------------------------
    | BASIC DATA
    |--------------------------------------------------------------------------
    */

    $clientName = $job->client?->name ?? 'Client';

    $clientInitial = strtoupper(
        substr($clientName, 0, 1)
    );

    $publishedAt = $job->published_at
        ?? $job->created_at;

    $hasBudget = !is_null($job->budget_min)
        || !is_null($job->budget_max);

    $daysToDeadline = null;

    if ($job->deadline) {
        $daysToDeadline = today()->diffInDays(
            $job->deadline,
            false
        );
    }

    $isOwner = auth()->check()
        && auth()->id() === $job->client_id;

    $isFreelancer = auth()->check()
        && auth()->user()->role === 'freelancer';

    $isClient = auth()->check()
        && auth()->user()->role === 'client';

    $relatedJobs = $relatedJobs ?? collect();
@endphp


<main class="min-h-screen bg-[#F8FAFC] pt-[48px] md:pt-[52px]">


    {{-- ========================================================= --}}
    {{-- TOP HEADER --}}
    {{-- ========================================================= --}}

    <section class="border-b border-slate-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- Back --}}
            <a
                href="{{ route('marketplace.jobs.index') }}"
                class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 transition hover:text-[#2563EB]"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke Job Board
            </a>


            <div class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_220px] lg:items-start">


                {{-- TITLE --}}
                <div class="min-w-0">

                    {{-- Metadata --}}
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-slate-400">

                        @if ($job->category)

                            <a
                                href="{{ route('marketplace.category', $job->category->slug) }}"
                                class="font-semibold text-slate-600 transition hover:text-[#2563EB]"
                            >
                                {{ $job->category->name }}
                            </a>

                        @endif


                        @if ($job->subcategory)

                            <span class="text-slate-300">
                                •
                            </span>

                            <span>
                                {{ $job->subcategory->name }}
                            </span>

                        @endif


                        <span class="text-slate-300">
                            •
                        </span>

                        <span>
                            Diposting {{ $publishedAt?->diffForHumans() }}
                        </span>

                    </div>


                    {{-- Title --}}
                    <h1 class="mt-3 max-w-4xl text-2xl font-bold leading-tight tracking-tight text-[#0F172A] sm:text-3xl lg:text-[40px]">
                        {{ $job->title }}
                    </h1>


                    {{-- Meta --}}
                    <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-slate-500">

                        <span class="inline-flex items-center gap-1.5">
                            <i class="bi bi-briefcase text-[#2563EB]"></i>
                            Freelance project
                        </span>


                        @if ($job->location)

                            <span class="inline-flex items-center gap-1.5">
                                <i class="bi bi-geo-alt text-[#2563EB]"></i>
                                {{ $job->location }}
                            </span>

                        @endif


                        <span class="inline-flex items-center gap-1.5">
                            <i class="bi bi-people text-[#2563EB]"></i>
                            {{ number_format($job->proposals_count, 0, ',', '.') }}
                            proposal
                        </span>


                        @if ($job->duration_days)

                            <span class="inline-flex items-center gap-1.5">
                                <i class="bi bi-calendar3 text-[#2563EB]"></i>
                                {{ $job->duration_days }} hari
                            </span>

                        @endif

                    </div>

                </div>


                {{-- STATUS --}}
                <div class="lg:flex lg:justify-end">

                    @if ($job->status === 'open')

                        <span class="inline-flex w-fit items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-semibold text-[#2563EB]">

                            <span class="h-1.5 w-1.5 rounded-full bg-[#2563EB]"></span>

                            Project terbuka

                        </span>

                    @else

                        <span class="inline-flex w-fit items-center gap-2 rounded-full border border-slate-200 bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-500">

                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                            Project ditutup

                        </span>

                    @endif

                </div>

            </div>

        </div>

    </section>


    {{-- ========================================================= --}}
    {{-- FLASH MESSAGE --}}
    {{-- ========================================================= --}}

    @if (session('success'))

        <section class="mx-auto max-w-7xl px-4 pt-5 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-green-200 bg-white px-4 py-4 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-green-50 text-[#16A34A]">

                        <i class="bi bi-check-circle-fill"></i>

                    </div>

                    <div class="pt-0.5">

                        <p class="text-sm font-semibold text-slate-800">
                            Berhasil
                        </p>

                        <p class="mt-1 text-xs leading-5 text-slate-500">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            </div>

        </section>

    @endif


    @if (session('error'))

        <section class="mx-auto max-w-7xl px-4 pt-5 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-red-200 bg-white px-4 py-4 shadow-sm">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#DC2626]">

                        <i class="bi bi-exclamation-circle-fill"></i>

                    </div>

                    <div class="pt-0.5">

                        <p class="text-sm font-semibold text-slate-800">
                            Perhatian
                        </p>

                        <p class="mt-1 text-xs leading-5 text-slate-500">
                            {{ session('error') }}
                        </p>

                    </div>

                </div>

            </div>

        </section>

    @endif


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <section class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">

        <div class="grid items-start gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">


            {{-- ================================================= --}}
            {{-- LEFT --}}
            {{-- ================================================= --}}

            <div class="min-w-0 space-y-5">


                {{-- ================================================= --}}
                {{-- CLIENT --}}
                {{-- ================================================= --}}

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                                Posted by
                            </p>

                            <h2 class="mt-1 text-base font-bold text-[#0F172A]">
                                Client
                            </h2>

                        </div>


                        <span class="text-xs text-slate-400">
                            {{ $publishedAt?->diffForHumans() }}
                        </span>

                    </div>


                    <div class="mt-5 flex items-center gap-3">

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EFF6FF] text-sm font-bold text-[#2563EB]">

                            {{ $clientInitial }}

                        </div>


                        <div class="min-w-0">

                            <p class="truncate text-sm font-bold text-slate-800">
                                {{ $clientName }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Client ProKerja
                            </p>

                        </div>

                    </div>

                </section>


                {{-- ================================================= --}}
                {{-- BRIEF --}}
                {{-- ================================================= --}}

                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-100 px-5 py-5 sm:px-7">

                        <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                            Brief project
                        </p>

                        <h2 class="mt-1 text-lg font-bold tracking-tight text-[#0F172A] sm:text-xl">
                            Detail kebutuhan client
                        </h2>

                        <p class="mt-1 text-xs leading-5 text-slate-500">
                            Baca kebutuhan project sebelum mengajukan proposal.
                        </p>

                    </div>


                    <div class="px-5 py-6 sm:px-7 sm:py-8">

                        <div class="whitespace-pre-line text-sm leading-7 text-slate-600 sm:text-[15px]">
                            {{ $job->description }}
                        </div>

                    </div>

                </section>


                {{-- ================================================= --}}
                {{-- PROJECT DETAILS --}}
                {{-- ================================================= --}}

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">

                    <div>

                        <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                            Informasi project
                        </p>

                        <h2 class="mt-1 text-lg font-bold tracking-tight text-[#0F172A]">
                            Gambaran pekerjaan
                        </h2>

                    </div>


                    <div class="mt-6 divide-y divide-slate-100 rounded-xl border border-slate-200">


                        {{-- Budget --}}
                        <div class="flex flex-col gap-2 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                    <i class="bi bi-wallet2"></i>
                                </div>

                                <div>

                                    <p class="text-xs font-semibold text-slate-700">
                                        Budget
                                    </p>

                                    <p class="mt-0.5 text-[11px] text-slate-400">
                                        Estimasi anggaran project
                                    </p>

                                </div>

                            </div>


                            <div class="sm:text-right">

                                @if ($hasBudget)

                                    @if ($job->budget_min !== null && $job->budget_max !== null)

                                        <p class="text-sm font-bold text-[#0F172A]">
                                            Rp{{ number_format((float) $job->budget_min, 0, ',', '.') }}
                                            <span class="font-normal text-slate-400">
                                                –
                                            </span>
                                            Rp{{ number_format((float) $job->budget_max, 0, ',', '.') }}
                                        </p>

                                    @elseif ($job->budget_min !== null)

                                        <p class="text-sm font-bold text-[#0F172A]">
                                            Mulai Rp{{ number_format((float) $job->budget_min, 0, ',', '.') }}
                                        </p>

                                    @else

                                        <p class="text-sm font-bold text-[#0F172A]">
                                            Hingga Rp{{ number_format((float) $job->budget_max, 0, ',', '.') }}
                                        </p>

                                    @endif

                                @else

                                    <p class="text-sm font-semibold text-slate-500">
                                        Budget fleksibel
                                    </p>

                                @endif

                            </div>

                        </div>


                        {{-- Duration --}}
                        <div class="flex flex-col gap-2 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                    <i class="bi bi-calendar3"></i>
                                </div>

                                <div>

                                    <p class="text-xs font-semibold text-slate-700">
                                        Durasi
                                    </p>

                                    <p class="mt-0.5 text-[11px] text-slate-400">
                                        Perkiraan pengerjaan
                                    </p>

                                </div>

                            </div>


                            <p class="text-sm font-bold text-[#0F172A] sm:text-right">

                                {{ $job->duration_days
                                    ? $job->duration_days . ' hari'
                                    : 'Menyesuaikan' }}

                            </p>

                        </div>


                        {{-- Deadline --}}
                        <div class="flex flex-col gap-2 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">

                                    <i class="bi bi-calendar-event"></i>

                                </div>


                                <div>

                                    <p class="text-xs font-semibold text-slate-700">
                                        Deadline
                                    </p>

                                    <p class="mt-0.5 text-[11px] text-slate-400">
                                        Batas penyelesaian project
                                    </p>

                                </div>

                            </div>


                            <div class="sm:text-right">

                                @if ($job->deadline)

                                    <p class="text-sm font-bold text-[#0F172A]">
                                        {{ $job->deadline->format('d M Y') }}
                                    </p>


                                    @if ($daysToDeadline === 0)

                                        <p class="mt-1 text-[10px] font-semibold text-[#DC2626]">
                                            Deadline hari ini
                                        </p>

                                    @elseif ($daysToDeadline !== null && $daysToDeadline < 0)

                                        <p class="mt-1 text-[10px] font-semibold text-[#DC2626]">
                                            Deadline telah lewat
                                        </p>

                                    @elseif ($daysToDeadline !== null && $daysToDeadline <= 7)

                                        <p class="mt-1 text-[10px] font-semibold text-[#F59E0B]">
                                            {{ $daysToDeadline }} hari lagi
                                        </p>

                                    @else

                                        <p class="mt-1 text-[10px] text-slate-400">
                                            Masih terbuka
                                        </p>

                                    @endif

                                @else

                                    <p class="text-sm font-semibold text-slate-500">
                                        Tidak ditentukan
                                    </p>

                                @endif

                            </div>

                        </div>


                        {{-- Proposal --}}
                        <div class="flex flex-col gap-2 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                    <i class="bi bi-people"></i>
                                </div>

                                <div>

                                    <p class="text-xs font-semibold text-slate-700">
                                        Proposal
                                    </p>

                                    <p class="mt-0.5 text-[11px] text-slate-400">
                                        Freelancer yang sudah melamar
                                    </p>

                                </div>

                            </div>


                            <p class="text-sm font-bold text-[#0F172A] sm:text-right">

                                {{ number_format($job->proposals_count, 0, ',', '.') }}

                                <span class="font-normal text-slate-400">
                                    proposal
                                </span>

                            </p>

                        </div>


                        {{-- Location --}}
                        @if ($job->location)

                            <div class="flex flex-col gap-2 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>

                                    <div>

                                        <p class="text-xs font-semibold text-slate-700">
                                            Lokasi
                                        </p>

                                        <p class="mt-0.5 text-[11px] text-slate-400">
                                            Preferensi lokasi pekerjaan
                                        </p>

                                    </div>

                                </div>


                                <p class="text-sm font-bold text-[#0F172A] sm:text-right">
                                    {{ $job->location }}
                                </p>

                            </div>

                        @endif


                    </div>

                </section>


                {{-- ================================================= --}}
                {{-- CATEGORY --}}
                {{-- ================================================= --}}

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">

                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                        Kategori
                    </p>

                    <h2 class="mt-1 text-lg font-bold text-[#0F172A]">
                        Bidang pekerjaan
                    </h2>


                    <div class="mt-5 flex flex-wrap gap-2">

                        @if ($job->category)

                            <a
                                href="{{ route('marketplace.category', $job->category->slug) }}"
                                class="inline-flex items-center gap-2 rounded-full bg-[#EFF6FF] px-3.5 py-2 text-xs font-semibold text-[#2563EB] transition hover:bg-[#DBEAFE]"
                            >

                                <i class="bi bi-grid"></i>

                                {{ $job->category->name }}

                            </a>

                        @endif


                        @if ($job->subcategory)

                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3.5 py-2 text-xs font-medium text-slate-600">

                                <i class="bi bi-tag"></i>

                                {{ $job->subcategory->name }}

                            </span>

                        @endif


                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3.5 py-2 text-xs font-medium text-slate-600">

                            <i class="bi bi-briefcase"></i>

                            Freelance

                        </span>

                    </div>

                </section>


                {{-- ================================================= --}}
                {{-- HOW TO APPLY --}}
                {{-- ================================================= --}}

                <section class="rounded-2xl border border-[#DBEAFE] bg-[#EFF6FF] p-5 sm:p-6">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">

                            <i class="bi bi-lightbulb"></i>

                        </div>


                        <div>

                            <h2 class="text-sm font-bold text-[#1E3A8A]">
                                Tips untuk proposal
                            </h2>

                            <p class="mt-1 text-xs leading-6 text-slate-500">
                                Jelaskan pengalaman yang relevan, pendekatan kerja,
                                estimasi penyelesaian, dan penawaran yang sesuai
                                dengan kebutuhan project.
                            </p>

                        </div>

                    </div>

                </section>

            </div>


            {{-- ================================================= --}}
            {{-- RIGHT SIDEBAR --}}
            {{-- ================================================= --}}

            <aside class="lg:sticky lg:top-24">


                {{-- APPLY CARD --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                        Project
                    </p>


                    <h2 class="mt-1 text-lg font-bold leading-6 text-[#0F172A]">
                        Tertarik dengan project ini?
                    </h2>


                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        Siapkan proposal yang menjelaskan kemampuan dan pendekatanmu untuk project ini.
                    </p>


                    {{-- Budget --}}
                    <div class="mt-5 rounded-xl bg-[#F8FAFC] p-4">

                        <p class="text-[11px] text-slate-400">
                            Budget project
                        </p>


                        @if ($hasBudget)

                            @if ($job->budget_min !== null && $job->budget_max !== null)

                                <p class="mt-1 text-lg font-bold text-[#0F172A]">
                                    Rp{{ number_format((float) $job->budget_min, 0, ',', '.') }}
                                    <span class="font-normal text-slate-400">
                                        –
                                    </span>
                                    Rp{{ number_format((float) $job->budget_max, 0, ',', '.') }}
                                </p>

                            @elseif ($job->budget_min !== null)

                                <p class="mt-1 text-lg font-bold text-[#0F172A]">
                                    Mulai Rp{{ number_format((float) $job->budget_min, 0, ',', '.') }}
                                </p>

                            @else

                                <p class="mt-1 text-lg font-bold text-[#0F172A]">
                                    Hingga Rp{{ number_format((float) $job->budget_max, 0, ',', '.') }}
                                </p>

                            @endif

                        @else

                            <p class="mt-1 text-lg font-bold text-slate-500">
                                Budget fleksibel
                            </p>

                        @endif

                    </div>


                    {{-- CTA --}}
                    @if ($job->status === 'open')

                        @if ($isOwner)

                            <a
                                href="{{ route('client.jobs.show', $job) }}"
                                class="mt-5 inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#0F172A] px-4 text-sm font-semibold text-white transition hover:bg-slate-800"
                            >

                                <i class="bi bi-kanban"></i>

                                Kelola Project

                            </a>

                        @elseif ($isFreelancer)

                            <a
                                href="{{ route('freelancer.jobs.show', $job) }}"
                                class="mt-5 inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8]"
                            >

                                <i class="bi bi-send"></i>

                                Ajukan Proposal

                            </a>

                        @elseif (!$isClient)

                            <a
                                href="{{ route('login') }}"
                                class="mt-5 inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8]"
                            >

                                <i class="bi bi-box-arrow-in-right"></i>

                                Masuk untuk Melamar

                            </a>

                        @endif


                        @if ($isClient && !$isOwner)

                            <div class="mt-4 rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-3">

                                <div class="flex items-start gap-2">

                                    <i class="bi bi-info-circle mt-0.5 text-slate-400"></i>

                                    <p class="text-[11px] leading-5 text-slate-500">
                                        Kamu sedang menggunakan akun client.
                                        Gunakan akun freelancer untuk mengajukan proposal.
                                    </p>

                                </div>

                            </div>

                        @endif

                    @else

                        <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 px-4 py-4">

                            <div class="flex items-center gap-2">

                                <i class="bi bi-lock text-slate-400"></i>

                                <p class="text-xs font-semibold text-slate-600">
                                    Project sudah ditutup
                                </p>

                            </div>

                            <p class="mt-2 text-[11px] leading-5 text-slate-400">
                                Project ini sudah tidak menerima proposal baru.
                            </p>

                        </div>

                    @endif


                    {{-- Small summary --}}
                    <div class="mt-5 border-t border-slate-100 pt-5">

                        <div class="space-y-3">

                            <div class="flex items-center justify-between gap-3">

                                <span class="text-xs text-slate-400">
                                    Proposal
                                </span>

                                <span class="text-xs font-semibold text-slate-700">
                                    {{ number_format($job->proposals_count, 0, ',', '.') }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between gap-3">

                                <span class="text-xs text-slate-400">
                                    Durasi
                                </span>

                                <span class="text-xs font-semibold text-slate-700">
                                    {{ $job->duration_days ? $job->duration_days . ' hari' : 'Menyesuaikan' }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between gap-3">

                                <span class="text-xs text-slate-400">
                                    Deadline
                                </span>

                                <span class="text-right text-xs font-semibold text-slate-700">
                                    {{ $job->deadline?->format('d M Y') ?? 'Tidak ditentukan' }}
                                </span>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- CLIENT INFO --}}
                <section class="mt-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                        Tentang client
                    </p>


                    <div class="mt-4 flex items-center gap-3">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#EFF6FF] text-sm font-bold text-[#2563EB]">

                            {{ $clientInitial }}

                        </div>


                        <div class="min-w-0">

                            <p class="truncate text-sm font-bold text-slate-800">
                                {{ $clientName }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Member ProKerja
                            </p>

                        </div>

                    </div>


                    <div class="mt-4 rounded-xl bg-[#F8FAFC] px-4 py-3">

                        <div class="flex items-start gap-2">

                            <i class="bi bi-shield-check mt-0.5 text-[#2563EB]"></i>

                            <p class="text-[11px] leading-5 text-slate-500">
                                Gunakan fitur komunikasi dan transaksi ProKerja
                                agar proses project tetap terorganisir.
                            </p>

                        </div>

                    </div>

                </section>

            </aside>

        </div>


        {{-- ========================================================= --}}
        {{-- RELATED PROJECTS --}}
        {{-- ========================================================= --}}

        @if ($relatedJobs->count())

            <section class="mt-12 border-t border-slate-200 pt-9">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                            Explore
                        </p>

                        <h2 class="mt-1 text-xl font-bold tracking-tight text-[#0F172A]">
                            Project lain yang mungkin sesuai
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Beberapa project lain dari kategori yang sama.
                        </p>

                    </div>


                    <a
                        href="{{ route('marketplace.jobs.index', [
                            'category' => $job->category?->slug
                        ]) }}"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-[#2563EB] transition hover:text-[#1D4ED8]"
                    >

                        Lihat semua

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>


                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                    @foreach ($relatedJobs as $relatedJob)

                        @php
                            $relatedClientName = $relatedJob->client?->name
                                ?? 'Client';

                            $relatedPublishedAt = $relatedJob->published_at
                                ?? $relatedJob->created_at;
                        @endphp


                        <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-md">

                            <a
                                href="{{ route('marketplace.jobs.show', $relatedJob) }}"
                                class="block p-5"
                            >

                                <div class="flex items-start justify-between gap-3">

                                    @if ($relatedJob->category)

                                        <span class="max-w-[70%] truncate rounded-full bg-[#EFF6FF] px-2.5 py-1 text-[10px] font-semibold text-[#2563EB]">
                                            {{ $relatedJob->category->name }}
                                        </span>

                                    @else

                                        <span></span>

                                    @endif


                                    <span class="shrink-0 text-[10px] text-slate-400">
                                        {{ $relatedPublishedAt?->diffForHumans() }}
                                    </span>

                                </div>


                                <h3 class="mt-4 line-clamp-3 text-sm font-bold leading-6 text-[#0F172A] transition group-hover:text-[#2563EB]">
                                    {{ $relatedJob->title }}
                                </h3>


                                <p class="mt-2 line-clamp-3 text-xs leading-5 text-slate-500">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($relatedJob->description), 100) }}
                                </p>


                                <div class="mt-5 border-t border-slate-100 pt-4">

                                    <div class="flex items-end justify-between gap-3">

                                        <div>

                                            <p class="text-[10px] text-slate-400">
                                                Budget
                                            </p>


                                            @if ($relatedJob->budget_min !== null && $relatedJob->budget_max !== null)

                                                <p class="mt-1 text-xs font-bold text-slate-700">
                                                    Rp{{ number_format((float) $relatedJob->budget_min, 0, ',', '.') }}
                                                    –
                                                    Rp{{ number_format((float) $relatedJob->budget_max, 0, ',', '.') }}
                                                </p>

                                            @elseif ($relatedJob->budget_min !== null)

                                                <p class="mt-1 text-xs font-bold text-slate-700">
                                                    Mulai Rp{{ number_format((float) $relatedJob->budget_min, 0, ',', '.') }}
                                                </p>

                                            @elseif ($relatedJob->budget_max !== null)

                                                <p class="mt-1 text-xs font-bold text-slate-700">
                                                    Hingga Rp{{ number_format((float) $relatedJob->budget_max, 0, ',', '.') }}
                                                </p>

                                            @else

                                                <p class="mt-1 text-xs font-semibold text-slate-500">
                                                    Fleksibel
                                                </p>

                                            @endif

                                        </div>


                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#EFF6FF] text-[#2563EB] transition group-hover:bg-[#2563EB] group-hover:text-white">

                                            <i class="bi bi-arrow-up-right text-xs"></i>

                                        </div>

                                    </div>


                                    <div class="mt-4 flex items-center justify-between gap-3 text-[10px] text-slate-400">

                                        <span class="inline-flex min-w-0 items-center gap-1.5">

                                            <i class="bi bi-person"></i>

                                            <span class="truncate">
                                                {{ $relatedClientName }}
                                            </span>

                                        </span>


                                        <span class="inline-flex shrink-0 items-center gap-1.5">

                                            <i class="bi bi-people"></i>

                                            {{ number_format($relatedJob->proposals_count, 0, ',', '.') }}

                                        </span>

                                    </div>

                                </div>

                            </a>

                        </article>

                    @endforeach

                </div>

            </section>

        @endif


        {{-- ========================================================= --}}
        {{-- BOTTOM INFO --}}
        {{-- ========================================================= --}}

        <section class="mt-10 rounded-2xl border border-[#DBEAFE] bg-[#EFF6FF] px-5 py-5 sm:px-6">

            <div class="flex items-start gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">

                    <i class="bi bi-shield-check"></i>

                </div>


                <div>

                    <h3 class="text-sm font-bold text-[#1E3A8A]">
                        Tetap gunakan alur komunikasi ProKerja
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Diskusikan kebutuhan project, proposal, dan kesepakatan
                        melalui fitur yang tersedia di ProKerja agar proses kerja
                        lebih mudah dilacak.
                    </p>

                </div>

            </div>

        </section>

    </section>


    {{-- ========================================================= --}}
    {{-- MOBILE APPLY BAR --}}
    {{-- ========================================================= --}}

    @if ($job->status === 'open' && !$isOwner)

        <div class="fixed bottom-0 left-0 right-0 z-30 border-t border-slate-200 bg-white/95 p-3 pb-[calc(env(safe-area-inset-bottom)+0.75rem)] backdrop-blur lg:hidden">

            <div class="mx-auto max-w-7xl">

                @if ($isFreelancer)

                    <a
                        href="{{ route('freelancer.jobs.show', $job) }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8]"
                    >

                        <i class="bi bi-send"></i>

                        Ajukan Proposal

                    </a>

                @elseif (!$isClient)

                    <a
                        href="{{ route('login') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8]"
                    >

                        <i class="bi bi-box-arrow-in-right"></i>

                        Masuk untuk Melamar

                    </a>

                @endif

            </div>

        </div>

    @endif

</main>


</x-layouts.marketplace>
