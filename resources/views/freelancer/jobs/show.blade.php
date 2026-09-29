<x-layouts.freelancer title="{{ $job->title }}">

@php
$budget = 'Negosiasi';


if ($job->budget_min !== null && $job->budget_max !== null) {
    $budget =
        'Rp ' .
        number_format((float) $job->budget_min, 0, ',', '.') .
        ' - Rp ' .
        number_format((float) $job->budget_max, 0, ',', '.');
} elseif ($job->budget_min !== null) {
    $budget =
        'Rp ' .
        number_format((float) $job->budget_min, 0, ',', '.');
} elseif ($job->budget_max !== null) {
    $budget =
        'Rp ' .
        number_format((float) $job->budget_max, 0, ',', '.');
}

$clientName = $job->client?->name ?? 'Client';

$clientAvatar = $job->client?->profile?->avatar
    ? asset('storage/' . $job->client->profile->avatar)
    : null;

$clientInitial = strtoupper(
    mb_substr($clientName, 0, 1)
);

$existingProposal = $existingProposal ?? null;

$freelancer = auth()->user()->freelancerProfile ?? null;

$experiences = $freelancer
    ? $freelancer->experiences()->latest()->get()
    : collect();


@endphp

<main
    x-data="{ offerOpen: false }"
    class="min-h-[calc(100vh-72px)] bg-[#F8FAFC]"
>


{{-- =========================================================
    FLASH MESSAGE
========================================================== --}}
@if(session('success') || session('error'))
    <div class="mx-auto max-w-7xl px-4 pt-5 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="flex items-start gap-3 rounded-xl border border-[#BFDBFE] bg-white px-4 py-3 text-sm text-[#334155] shadow-sm">
                <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#EFF6FF] text-[#2563EB]">
                    <i class="bi bi-check-lg text-xs"></i>
                </div>

                <span class="pt-0.5">
                    {{ session('success') }}
                </span>
            </div>
        @endif

        @if(session('error'))
            <div class="mt-3 flex items-start gap-3 rounded-xl border border-red-100 bg-white px-4 py-3 text-sm text-red-600 shadow-sm">
                <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-50">
                    <i class="bi bi-exclamation-lg text-xs"></i>
                </div>

                <span class="pt-0.5">
                    {{ session('error') }}
                </span>
            </div>
        @endif
    </div>
@endif


{{-- =========================================================
    CONTENT
========================================================== --}}
<section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

    {{-- Breadcrumb --}}
    <div class="mb-5 flex min-w-0 items-center gap-2 text-xs text-[#94A3B8]">
        <a
            href="{{ route('freelancer.jobs.index') }}"
            class="shrink-0 font-medium transition hover:text-[#2563EB]"
        >
            Job Board
        </a>

        <i class="bi bi-chevron-right shrink-0 text-[9px] text-[#CBD5E1]"></i>

        <span class="truncate text-[#64748B]">
            {{ $job->title }}
        </span>
    </div>


    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_330px]">

        {{-- =================================================
             LEFT
        ================================================== --}}
        <div class="min-w-0">

            {{-- JOB DETAIL --}}
            <article class="overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-sm">

                {{-- Header --}}
                <div class="border-b border-[#E8EDF3] px-5 py-6 sm:px-7 sm:py-7">

                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] text-[#94A3B8]">
                        @if($job->category)
                            <span class="font-medium text-[#64748B]">
                                {{ $job->category->name }}
                            </span>
                        @endif

                        @if($job->subcategory)
                            <span class="text-[#CBD5E1]">•</span>

                            <span>
                                {{ $job->subcategory->name }}
                            </span>
                        @endif

                        <span class="text-[#CBD5E1]">•</span>

                        <span>
                            Posted
                            {{ optional($job->published_at)->format('d M Y') ?? optional($job->created_at)->format('d M Y') }}
                        </span>
                    </div>


                    <h1 class="mt-3 text-2xl font-bold leading-tight tracking-tight text-[#172B4D] sm:text-[30px]">
                        {{ $job->title }}
                    </h1>


                    <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#64748B]">

                        <span class="inline-flex items-center gap-1.5">
                            <i class="bi bi-briefcase-fill text-[#2563EB]"></i>
                            Freelance
                        </span>

                        @if($job->location)
                            <span class="inline-flex items-center gap-1.5">
                                <i class="bi bi-geo-alt-fill text-[#2563EB]"></i>
                                {{ $job->location }}
                            </span>
                        @endif

                        <span class="inline-flex items-center gap-1.5">
                            <i class="bi bi-people-fill text-[#2563EB]"></i>
                            {{ $job->proposals_count }} applied
                        </span>

                    </div>
                </div>


                {{-- Description --}}
                <div class="px-5 py-6 sm:px-7 sm:py-7">

                    <h2 class="text-sm font-bold text-[#172B4D]">
                        Detail pekerjaan
                    </h2>

                    <div class="mt-4 whitespace-pre-line text-sm leading-7 text-[#475569]">
                        {{ $job->description }}
                    </div>

                </div>


                {{-- Information --}}
                <div class="border-t border-[#E8EDF3] px-5 py-6 sm:px-7 sm:py-7">

                    <h2 class="text-sm font-bold text-[#172B4D]">
                        Informasi pekerjaan
                    </h2>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                        <div class="rounded-xl bg-[#F8FAFC] p-4">
                            <p class="text-[11px] font-medium text-[#94A3B8]">
                                Kategori
                            </p>

                            <p class="mt-1.5 text-sm font-semibold text-[#334155]">
                                {{ $job->category?->name ?? 'Lainnya' }}
                            </p>
                        </div>


                        <div class="rounded-xl bg-[#F8FAFC] p-4">
                            <p class="text-[11px] font-medium text-[#94A3B8]">
                                Tipe pekerjaan
                            </p>

                            <p class="mt-1.5 text-sm font-semibold text-[#334155]">
                                Freelance
                            </p>
                        </div>


                        <div class="rounded-xl bg-[#EFF6FF] p-4">
                            <p class="text-[11px] font-medium text-[#64748B]">
                                Budget client
                            </p>

                            <p class="mt-1.5 text-sm font-bold text-[#2563EB]">
                                {{ $budget }}
                            </p>
                        </div>


                        <div class="rounded-xl bg-[#F8FAFC] p-4">
                            <p class="text-[11px] font-medium text-[#94A3B8]">
                                Deliver within
                            </p>

                            <p class="mt-1.5 text-sm font-semibold text-[#334155]">
                                @if($job->duration_days)
                                    {{ $job->duration_days }} hari
                                @else
                                    Menyesuaikan
                                @endif
                            </p>
                        </div>


                        <div class="rounded-xl bg-[#F8FAFC] p-4">
                            <p class="text-[11px] font-medium text-[#94A3B8]">
                                Deadline
                            </p>

                            <p class="mt-1.5 text-sm font-semibold text-[#334155]">
                                {{ $job->deadline ? $job->deadline->format('d M Y') : 'Tidak ditentukan' }}
                            </p>
                        </div>


                        <div class="rounded-xl bg-[#F8FAFC] p-4">
                            <p class="text-[11px] font-medium text-[#94A3B8]">
                                Freelancer tertarik
                            </p>

                            <p class="mt-1.5 text-sm font-semibold text-[#334155]">
                                {{ $job->proposals_count }} orang
                            </p>
                        </div>

                    </div>
                </div>

            </article>


            {{-- CLIENT --}}
            <article class="mt-5 rounded-2xl border border-[#E2E8F0] bg-white px-5 py-5 shadow-sm sm:px-7">

                <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-[#94A3B8]">
                    Diposting oleh
                </p>

                <div class="mt-3 flex items-center gap-3">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EFF6FF] text-sm font-bold text-[#2563EB] ring-4 ring-[#F8FAFC]">

                        @if($clientAvatar)
                            <img
                                src="{{ $clientAvatar }}"
                                alt="{{ $clientName }}"
                                class="h-full w-full object-cover"
                            >
                        @else
                            {{ $clientInitial }}
                        @endif

                    </div>

                    <div class="min-w-0">

                        <p class="truncate text-sm font-bold text-[#1E293B]">
                            {{ $clientName }}
                        </p>

                        <p class="mt-0.5 text-xs text-[#94A3B8]">
                            Client ProKerja
                        </p>

                    </div>
                </div>

            </article>


            {{-- SECURITY --}}
            <article class="mt-5 rounded-2xl border border-[#DBEAFE] bg-[#F8FBFF] px-5 py-5 shadow-sm sm:px-7">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>

                        <h3 class="text-sm font-bold text-[#172B4D]">
                            Bertransaksi melalui ProKerja
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-[#64748B]">
                            Jangan meminta atau menerima pembayaran di luar platform.
                            Pembayaran akan dilakukan melalui sistem ProKerja setelah
                            client memilih freelancer dan menyetujui penawaran.
                        </p>

                    </div>

                </div>

            </article>

        </div>


        {{-- =================================================
             RIGHT SIDEBAR
        ================================================== --}}
        <aside class="lg:sticky lg:top-[90px] lg:self-start">

            <div class="overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-sm">

                {{-- SUMMARY --}}
                <div class="px-5 py-5">

                    <div class="flex items-center justify-between">
                        <p class="text-[11px] font-bold uppercase tracking-[0.06em] text-[#94A3B8]">
                            Detail pekerjaan
                        </p>

                        <span class="rounded-full bg-[#EFF6FF] px-2.5 py-1 text-[10px] font-bold text-[#2563EB]">
                            Freelance
                        </span>
                    </div>


                    <div class="mt-5 space-y-3.5">

                        <div class="flex items-start justify-between gap-4">
                            <span class="text-xs text-[#94A3B8]">
                                Budget
                            </span>

                            <span class="text-right text-xs font-bold text-[#334155]">
                                {{ $budget }}
                            </span>
                        </div>


                        <div class="flex items-center justify-between gap-4">
                            <span class="text-xs text-[#94A3B8]">
                                Type
                            </span>

                            <span class="text-xs font-semibold text-[#334155]">
                                Freelance
                            </span>
                        </div>


                        @if($job->duration_days)
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-xs text-[#94A3B8]">
                                    Deliver within
                                </span>

                                <span class="text-xs font-semibold text-[#334155]">
                                    {{ $job->duration_days }} hari
                                </span>
                            </div>
                        @endif


                        @if($job->deadline)
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-xs text-[#94A3B8]">
                                    Deadline
                                </span>

                                <span class="text-xs font-semibold text-[#334155]">
                                    {{ $job->deadline->format('d M Y') }}
                                </span>
                            </div>
                        @endif


                        <div class="flex items-center justify-between gap-4">
                            <span class="text-xs text-[#94A3B8]">
                                Applied
                            </span>

                            <span class="text-xs font-semibold text-[#334155]">
                                {{ $job->proposals_count }}
                            </span>
                        </div>

                    </div>
                </div>


                {{-- OFFER CTA --}}
                <div class="border-t border-[#E8EDF3] px-5 py-5">

                    @if($existingProposal)

                        {{-- PROPOSAL SUDAH TERKIRIM --}}
                        <div class="rounded-xl border border-[#BFDBFE] bg-[#F8FBFF] px-4 py-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#EFF6FF] text-[#2563EB]">
                                    <i class="bi bi-check-lg"></i>
                                </div>

                                <div class="min-w-0">

                                    <p class="text-sm font-bold text-[#172B4D]">
                                        Proposal sudah dikirim
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#64748B]">
                                        Client dapat melihat informasi proposal,
                                        pengalaman, dan portofoliomu.
                                    </p>

                                </div>

                            </div>


                            <div class="mt-4 space-y-3">

                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-xs text-[#94A3B8]">
                                        Harga proposal
                                    </span>

                                    <span class="text-sm font-bold text-[#2563EB]">
                                        Rp {{ number_format((float) $existingProposal->price, 0, ',', '.') }}
                                    </span>
                                </div>


                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-xs text-[#94A3B8]">
                                        Durasi
                                    </span>

                                    <span class="text-sm font-semibold text-[#334155]">
                                        {{ $existingProposal->delivery_days }} hari
                                    </span>
                                </div>

                            </div>


                            {{-- QUOTATION BUTTON --}}
                            <div class="mt-4 border-t border-[#DBEAFE] pt-4">

                                <a
                                    href="{{ route(
                                        'freelancer.jobs.proposals.offer.create',
                                        [$job, $existingProposal]
                                    ) }}"
                                    class="flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-sm font-bold text-white shadow-sm transition hover:bg-[#1D4ED8] hover:shadow-md active:scale-[0.99]"
                                >
                                    <i class="bi bi-receipt"></i>
                                    Buat Quotation
                                </a>

                                <p class="mt-2.5 text-center text-[11px] leading-5 text-[#94A3B8]">
                                    Buat penawaran resmi setelah proposalmu
                                    sudah dikirim kepada client.
                                </p>

                            </div>

                        </div>

                    @else

                        {{-- BELUM KIRIM PROPOSAL --}}
                        <button
                            type="button"
                            @click="offerOpen = true"
                            class="flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-sm font-bold text-white shadow-sm transition hover:bg-[#1D4ED8] hover:shadow-md active:scale-[0.99]"
                        >
                            <i class="bi bi-send-fill"></i>
                            Tawarkan pekerjaan
                        </button>

                        <p class="mt-2.5 text-center text-[11px] leading-5 text-[#94A3B8]">
                            Tawarkan harga dan durasi yang sesuai dengan kebutuhan client.
                        </p>

                    @endif

                </div>

            </div>


            {{-- BACK --}}
            <a
                href="{{ route('freelancer.jobs.index') }}"
                class="mt-4 flex h-10 items-center justify-center gap-2 rounded-xl border border-[#E2E8F0] bg-white text-xs font-semibold text-[#64748B] shadow-sm transition hover:border-[#BFDBFE] hover:text-[#2563EB]"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke Job Board
            </a>

        </aside>

    </div>

</section>


{{-- =========================================================
    PROPOSAL MODAL
========================================================== --}}
<div
    x-show="offerOpen"
    x-transition.opacity
    @keydown.escape.window="offerOpen = false"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>

    {{-- Overlay --}}
    <div
        class="fixed inset-0 bg-[#0F172A]/50 backdrop-blur-[3px]"
        @click="offerOpen = false"
    ></div>


    {{-- Dialog --}}
    <div class="relative flex min-h-full items-start justify-center p-3 sm:p-6">

        <div
            @click.stop
            class="relative my-3 w-full max-w-3xl overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-2xl sm:my-6"
        >

            {{-- Modal Header --}}
            <div class="border-b border-[#E8EDF3] px-5 py-5 sm:px-7">

                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">

                        <div class="inline-flex items-center gap-2 rounded-full bg-[#EFF6FF] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.12em] text-[#2563EB]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#2563EB]"></span>
                            Job Proposal
                        </div>

                        <h2 class="mt-2 text-xl font-bold tracking-tight text-[#172B4D]">
                            Tawarkan pekerjaan
                        </h2>

                        <p class="mt-1 text-xs leading-5 text-[#64748B]">
                            Lengkapi informasi berikut agar client dapat menilai proposalmu.
                        </p>

                    </div>


                    <button
                        type="button"
                        @click="offerOpen = false"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-[#94A3B8] transition hover:bg-[#F1F5F9] hover:text-[#334155]"
                    >
                        <i class="bi bi-x-lg text-sm"></i>
                    </button>

                </div>

            </div>


            {{-- Form Proposal --}}
            <form
                method="POST"
                action="{{ route('freelancer.jobs.proposals.store', $job) }}"
                enctype="multipart/form-data"
            >
                @csrf


                <div class="max-h-[calc(100vh-180px)] space-y-7 overflow-y-auto px-5 py-6 sm:px-7">

                    {{-- Notice --}}
                    <div class="rounded-xl border border-[#DBEAFE] bg-[#F8FBFF] px-4 py-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">
                                <i class="bi bi-person-check"></i>
                            </div>

                            <div>

                                <p class="text-sm font-bold text-[#172B4D]">
                                    Tingkatkan peluang mendapatkan pekerjaan
                                </p>

                                <p class="mt-1 text-xs leading-5 text-[#64748B]">
                                    Gunakan informasi yang benar-benar relevan dengan kebutuhan client
                                    dan lampirkan portofolio terbaikmu.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- BASIC INFO --}}
                    <div>

                        <h3 class="text-sm font-bold text-[#172B4D]">
                            Informasi dasar
                        </h3>

                        <p class="mt-1 text-xs text-[#94A3B8]">
                            Lengkapi informasi dasar sebelum mengirimkan proposal.
                        </p>


                        <div class="mt-4 grid gap-4 sm:grid-cols-2">

                            {{-- Display Name --}}
                            <div>

                                <label
                                    for="display_name"
                                    class="text-[11px] font-semibold text-[#475569]"
                                >
                                    Nama tampilan
                                </label>

                                <input
                                    id="display_name"
                                    name="display_name"
                                    type="text"
                                    value="{{ old('display_name', auth()->user()->name) }}"
                                    required
                                    placeholder="Nama profesional"
                                    class="mt-1.5 h-10 w-full rounded-xl border border-[#E2E8F0] bg-white px-3 text-sm text-[#1E293B] outline-none transition placeholder:text-[#A8B2BF] focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/10"
                                >

                                <p class="mt-1 text-[10px] text-[#94A3B8]">
                                    Nama ini akan ditampilkan kepada client.
                                </p>

                                @error('display_name')
                                    <p class="mt-1 text-[11px] text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Phone --}}
                            <div>

                                <label
                                    for="phone"
                                    class="text-[11px] font-semibold text-[#475569]"
                                >
                                    Nomor telepon
                                </label>

                                <input
                                    id="phone"
                                    name="phone"
                                    type="text"
                                    value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                    required
                                    placeholder="08xxxxxxxxxx"
                                    class="mt-1.5 h-10 w-full rounded-xl border border-[#E2E8F0] bg-white px-3 text-sm text-[#1E293B] outline-none transition placeholder:text-[#A8B2BF] focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/10"
                                >

                                <p class="mt-1 text-[10px] text-[#94A3B8]">
                                    Digunakan untuk kebutuhan notifikasi.
                                </p>

                                @error('phone')
                                    <p class="mt-1 text-[11px] text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- RELEVANT INFO --}}
                    <div>

                        <h3 class="text-sm font-bold text-[#172B4D]">
                            Informasi yang membuat client memilih Anda
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-[#94A3B8]">
                            Jelaskan pengalaman, kemampuan, metode kerja, atau hal lain
                            yang benar-benar relevan dengan pekerjaan ini.
                        </p>


                        <textarea
                            name="relevant_info"
                            rows="7"
                            required
                            minlength="100"
                            placeholder="Contoh: Saya memiliki pengalaman membuat website company profile untuk UMKM dan terbiasa menggunakan Laravel, Tailwind CSS, database MySQL, serta deployment..."
                            class="mt-3 w-full resize-y rounded-xl border border-[#E2E8F0] px-3 py-2.5 text-sm leading-6 text-[#1E293B] outline-none transition placeholder:text-[#A8B2BF] focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/10"
                        >{{ old('relevant_info') }}</textarea>


                        <div class="mt-1 flex items-center justify-between gap-4">

                            <p class="text-[10px] text-[#94A3B8]">
                                Minimal 100 karakter.
                            </p>

                            @error('relevant_info')
                                <p class="text-right text-[11px] text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    {{-- PORTFOLIO --}}
                    <div>

                        <h3 class="text-sm font-bold text-[#172B4D]">
                            Portofolio
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-[#94A3B8]">
                            Tambahkan URL portofolio dan file yang paling relevan.
                        </p>


                        <div class="mt-4 space-y-4">

                            {{-- Portfolio URL --}}
                            <div>

                                <label
                                    for="portfolio_url"
                                    class="text-[11px] font-semibold text-[#475569]"
                                >
                                    URL Portofolio
                                </label>

                                <input
                                    id="portfolio_url"
                                    name="portfolio_url"
                                    type="url"
                                    value="{{ old('portfolio_url') }}"
                                    placeholder="https://portfolio-kamu.com"
                                    class="mt-1.5 h-10 w-full rounded-xl border border-[#E2E8F0] px-3 text-sm text-[#1E293B] outline-none transition placeholder:text-[#A8B2BF] focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/10"
                                >

                                @error('portfolio_url')
                                    <p class="mt-1 text-[11px] text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Portfolio Files --}}
                            <div>

                                <label
                                    for="portfolios"
                                    class="text-[11px] font-semibold text-[#475569]"
                                >
                                    Portofolio
                                </label>

                                <div class="mt-1.5 rounded-xl border border-dashed border-[#BFDBFE] bg-[#F8FBFF] px-4 py-4">

                                    <input
                                        id="portfolios"
                                        name="portfolios[]"
                                        type="file"
                                        multiple
                                        accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx"
                                        class="block w-full text-xs text-[#64748B] file:mr-3 file:rounded-lg file:border-0 file:bg-[#EFF6FF] file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-[#2563EB]"
                                    >

                                    <div class="mt-2 flex items-start gap-2 text-[10px] leading-4 text-[#94A3B8]">

                                        <i class="bi bi-info-circle mt-0.5 shrink-0 text-[#2563EB]"></i>

                                        <span>
                                            Maksimal 10 file, masing-masing maksimal 25 MB.
                                            Format JPG, PNG, WEBP, PDF, DOC, DOCX.
                                        </span>

                                    </div>

                                </div>

                                @error('portfolios')
                                    <p class="mt-1 text-[11px] text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                                @error('portfolios.*')
                                    <p class="mt-1 text-[11px] text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- EXPERIENCE --}}
                    <div>

                        <h3 class="text-sm font-bold text-[#172B4D]">
                            Pilih pengalaman yang sesuai
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-[#94A3B8]">
                            Pilih pengalaman yang paling relevan dengan pekerjaan ini.
                        </p>


                        <select
                            name="selected_experience_id"
                            class="mt-3 h-10 w-full rounded-xl border border-[#E2E8F0] bg-white px-3 text-sm text-[#475569] outline-none transition focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/10"
                        >

                            <option value="">
                                Tidak memilih pengalaman tertentu
                            </option>

                            @foreach($experiences as $experience)

                                <option
                                    value="{{ $experience->id }}"
                                    @selected(
                                        (string) old('selected_experience_id') ===
                                        (string) $experience->id
                                    )
                                >
                                    {{ $experience->position }}

                                    @if($experience->company)
                                        — {{ $experience->company }}
                                    @endif

                                </option>

                            @endforeach

                        </select>


                        @if($experiences->isEmpty())
                            <p class="mt-1.5 text-[10px] text-[#94A3B8]">
                                Belum ada pengalaman yang tersimpan di profilmu.
                                Kamu tetap dapat mengirim proposal.
                            </p>
                        @endif


                        @error('selected_experience_id')
                            <p class="mt-1 text-[11px] text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- OFFER --}}
                    <div>

                        <h3 class="text-sm font-bold text-[#172B4D]">
                            Tawaran Anda
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-[#94A3B8]">
                            Tentukan harga dan durasi awal yang kamu tawarkan kepada client.
                        </p>


                        <div class="mt-4 grid gap-4 sm:grid-cols-2">

                            {{-- Price --}}
                            <div>

                                <label
                                    for="price"
                                    class="text-[11px] font-semibold text-[#475569]"
                                >
                                    Harga
                                </label>

                                <div class="relative mt-1.5">

                                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs font-medium text-[#94A3B8]">
                                        Rp
                                    </span>

                                    <input
                                        id="price"
                                        name="price"
                                        type="number"
                                        min="0"
                                        step="1000"
                                        value="{{ old('price') }}"
                                        placeholder="2000000"
                                        required
                                        class="h-10 w-full rounded-xl border border-[#E2E8F0] pl-9 pr-3 text-sm text-[#1E293B] outline-none transition placeholder:text-[#A8B2BF] focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/10"
                                    >

                                </div>

                                <p class="mt-1.5 text-[10px] text-[#94A3B8]">
                                    Harga proposal dapat dilihat oleh client.
                                </p>

                                @error('price')
                                    <p class="mt-1 text-[11px] text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Duration --}}
                            <div>

                                <label
                                    for="delivery_days"
                                    class="text-[11px] font-semibold text-[#475569]"
                                >
                                    Durasi kerja
                                </label>

                                <div class="relative mt-1.5">

                                    <input
                                        id="delivery_days"
                                        name="delivery_days"
                                        type="number"
                                        min="1"
                                        value="{{ old('delivery_days') }}"
                                        placeholder="7"
                                        required
                                        class="h-10 w-full rounded-xl border border-[#E2E8F0] px-3 pr-14 text-sm text-[#1E293B] outline-none transition placeholder:text-[#A8B2BF] focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/10"
                                    >

                                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[11px] text-[#94A3B8]">
                                        hari
                                    </span>

                                </div>

                                @error('delivery_days')
                                    <p class="mt-1 text-[11px] text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- WARNING --}}
                    <div class="flex items-start gap-3 rounded-xl border border-[#FDE68A] bg-[#FFFBEB] px-4 py-3">

                        <i class="bi bi-exclamation-triangle mt-0.5 shrink-0 text-[#D97706]"></i>

                        <p class="text-[11px] leading-5 text-[#785B16]">
                            Jangan meminta client melakukan pembayaran di luar ProKerja.
                            Komunikasi dan transaksi harus tetap dilakukan melalui platform.
                        </p>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="flex flex-col-reverse gap-2 border-t border-[#E8EDF3] bg-[#FCFDFE] px-5 py-4 sm:flex-row sm:justify-end sm:px-7">

                    <button
                        type="button"
                        @click="offerOpen = false"
                        class="h-10 rounded-xl border border-[#E2E8F0] bg-white px-4 text-sm font-semibold text-[#64748B] transition hover:bg-[#F8FAFC] hover:text-[#334155]"
                    >
                        Batal
                    </button>


                    <button
                        type="submit"
                        class="flex h-10 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-sm font-bold text-white shadow-sm transition hover:bg-[#1D4ED8] hover:shadow-md active:scale-[0.99]"
                    >
                        <i class="bi bi-send-fill"></i>
                        Kirim proposal
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


</main>

</x-layouts.freelancer>
