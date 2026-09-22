<x-layouts.marketplace title="{{ $job->title }} - JASAIN">

    @php
        $clientName = $job->client?->name ?? 'Client';

        $clientInitial = strtoupper(
            substr($clientName, 0, 1)
        );

        $publishedAt = $job->published_at
            ?? $job->created_at;

        $hasBudget = ! is_null($job->budget_min)
            || ! is_null($job->budget_max);

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
    @endphp


    <main class="min-h-screen bg-[#F8FBF9]">

        {{-- =========================================================
            TOP AREA
        ========================================================== --}}

        <section class="border-b border-[#E3EBE6] bg-white">

            <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8">

                <a
                    href="{{ route('marketplace.jobs.index') }}"
                    class="inline-flex items-center gap-2 text-[11px] font-medium text-[#7B8B84] transition hover:text-[#0F6B3A]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Job Board
                </a>


                <div class="mt-6">

                    {{-- Meta --}}

                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[10px] text-[#8B9993]">

                        @if($job->category)

                            <a
                                href="{{ route('marketplace.category', $job->category->slug) }}"
                                class="font-medium text-[#5E7168] transition hover:text-[#1E9E5A]"
                            >
                                {{ $job->category->name }}
                            </a>

                        @endif

                        @if($job->subcategory)

                            <span class="text-[#BDC6C1]">
                                •
                            </span>

                            <span>
                                {{ $job->subcategory->name }}
                            </span>

                        @endif

                        <span class="text-[#BDC6C1]">
                            •
                        </span>

                        <span>
                            Diposting {{ $publishedAt?->diffForHumans() }}
                        </span>

                    </div>


                    <div class="mt-3 flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                        <div class="min-w-0 max-w-4xl">

                            <h1
                                class="text-2xl font-semibold leading-tight tracking-[-0.04em] text-[#123128] sm:text-3xl lg:text-[38px]"
                            >
                                {{ $job->title }}
                            </h1>


                            <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2">

                                <span class="inline-flex items-center gap-1.5 text-[10px] text-[#73837B]">

                                    <i class="bi bi-briefcase text-[#1E9E5A]"></i>

                                    Freelance project

                                </span>


                                @if($job->location)

                                    <span class="inline-flex items-center gap-1.5 text-[10px] text-[#73837B]">

                                        <i class="bi bi-geo-alt text-[#1E9E5A]"></i>

                                        {{ $job->location }}

                                    </span>

                                @endif


                                <span class="inline-flex items-center gap-1.5 text-[10px] text-[#73837B]">

                                    <i class="bi bi-people text-[#1E9E5A]"></i>

                                    {{ number_format($job->proposals_count, 0, ',', '.') }}
                                    proposal

                                </span>


                                @if($job->duration_days)

                                    <span class="inline-flex items-center gap-1.5 text-[10px] text-[#73837B]">

                                        <i class="bi bi-calendar3 text-[#1E9E5A]"></i>

                                        {{ $job->duration_days }} hari

                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Status --}}

                        <div class="shrink-0">

                            @if($job->status === 'open')

                                <span class="inline-flex items-center gap-2 rounded-full border border-[#CDE6D6] bg-[#F1FAF4] px-3 py-1.5 text-[10px] font-semibold text-[#267247]">

                                    <span class="h-1.5 w-1.5 rounded-full bg-[#35C978]"></span>

                                    Project terbuka

                                </span>

                            @else

                                <span class="inline-flex items-center gap-2 rounded-full border border-[#E1E7E3] bg-[#F6F8F7] px-3 py-1.5 text-[10px] font-semibold text-[#6E7C76]">

                                    Project ditutup

                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
            CONTENT
        ========================================================== --}}

        <section class="mx-auto max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8">

            {{-- Flash message --}}

            @if(session('success'))

                <div class="mb-5 rounded-xl border border-[#CDE7D7] bg-white px-4 py-3">

                    <div class="flex items-center gap-2.5">

                        <i class="bi bi-check-circle-fill text-[#1E9E5A]"></i>

                        <p class="text-[11px] font-medium text-[#426056]">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            @if(session('error'))

                <div class="mb-5 rounded-xl border border-[#F0D4D4] bg-white px-4 py-3">

                    <div class="flex items-center gap-2.5">

                        <i class="bi bi-exclamation-circle text-[#B84E4E]"></i>

                        <p class="text-[11px] font-medium text-[#8F4C4C]">
                            {{ session('error') }}
                        </p>

                    </div>

                </div>

            @endif


            <div class="grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start">

                {{-- =================================================
                    LEFT
                ================================================== --}}

                <div class="space-y-5">

                    {{-- Brief --}}

                    <section
                        class="overflow-hidden rounded-2xl border border-[#DEE8E2] bg-white shadow-[0_6px_20px_rgba(18,49,40,0.035)]"
                    >

                        <div class="border-b border-[#E8EFEB] px-5 py-5 sm:px-7">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.17em] text-[#1E9E5A]">
                                Brief pekerjaan
                            </p>

                            <h2 class="mt-1 text-base font-semibold tracking-[-0.015em] text-[#123128]">
                                Detail kebutuhan client
                            </h2>

                        </div>


                        <div class="px-5 py-6 sm:px-7 sm:py-7">

                            <div class="whitespace-pre-line text-sm leading-7 text-[#5E7168]">
                                {{ $job->description }}
                            </div>

                        </div>

                    </section>


                    {{-- Project information --}}

                    <section
                        class="rounded-2xl border border-[#DEE8E2] bg-white p-5 shadow-[0_6px_20px_rgba(18,49,40,0.035)] sm:p-7"
                    >

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.17em] text-[#1E9E5A]">
                                Informasi project
                            </p>

                            <h2 class="mt-1 text-base font-semibold tracking-[-0.015em] text-[#123128]">
                                Gambaran pekerjaan
                            </h2>

                        </div>


                        <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">

                            {{-- Budget --}}

                            <div class="rounded-xl border border-[#E6ECE8] bg-[#FAFCFB] px-4 py-4">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                        <i class="bi bi-wallet2 text-[14px]"></i>
                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-[9px] font-semibold uppercase tracking-[0.12em] text-[#96A29C]">
                                            Budget
                                        </p>

                                        @if($hasBudget)

                                            @if($job->budget_min !== null && $job->budget_max !== null)

                                                <p class="mt-1 text-sm font-semibold text-[#18382E]">

                                                    Rp {{ number_format((float) $job->budget_min, 0, ',', '.') }}

                                                    <span class="font-normal text-[#9AA6A1]">
                                                        —
                                                    </span>

                                                    Rp {{ number_format((float) $job->budget_max, 0, ',', '.') }}

                                                </p>

                                            @elseif($job->budget_min !== null)

                                                <p class="mt-1 text-sm font-semibold text-[#18382E]">
                                                    Mulai Rp {{ number_format((float) $job->budget_min, 0, ',', '.') }}
                                                </p>

                                            @else

                                                <p class="mt-1 text-sm font-semibold text-[#18382E]">
                                                    Hingga Rp {{ number_format((float) $job->budget_max, 0, ',', '.') }}
                                                </p>

                                            @endif

                                        @else

                                            <p class="mt-1 text-sm font-semibold text-[#53675E]">
                                                Budget fleksibel
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Duration --}}

                            <div class="rounded-xl border border-[#E6ECE8] bg-[#FAFCFB] px-4 py-4">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                        <i class="bi bi-calendar3 text-[14px]"></i>
                                    </div>

                                    <div>

                                        <p class="text-[9px] font-semibold uppercase tracking-[0.12em] text-[#96A29C]">
                                            Durasi
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-[#18382E]">
                                            {{ $job->duration_days ? $job->duration_days . ' hari' : 'Menyesuaikan' }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Deadline --}}

                            <div class="rounded-xl border border-[#E6ECE8] bg-[#FAFCFB] px-4 py-4">

                                <div class="flex items-start gap-3">

                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl
                                        {{ $daysToDeadline !== null && $daysToDeadline <= 3
                                            ? 'bg-[#FFF5EA] text-[#B26A25]'
                                            : 'bg-[#EAF7EF] text-[#1E9E5A]' }}"
                                    >
                                        <i class="bi bi-calendar-event text-[14px]"></i>
                                    </div>

                                    <div>

                                        <p class="text-[9px] font-semibold uppercase tracking-[0.12em] text-[#96A29C]">
                                            Deadline
                                        </p>

                                        @if($job->deadline)

                                            <p class="mt-1 text-sm font-semibold text-[#18382E]">
                                                {{ $job->deadline->format('d M Y') }}
                                            </p>

                                            @if($daysToDeadline === 0)

                                                <p class="mt-1 text-[9px] font-medium text-[#B26A25]">
                                                    Deadline hari ini
                                                </p>

                                            @elseif($daysToDeadline !== null && $daysToDeadline > 0 && $daysToDeadline <= 7)

                                                <p class="mt-1 text-[9px] font-medium text-[#B26A25]">
                                                    {{ $daysToDeadline }} hari lagi
                                                </p>

                                            @elseif($daysToDeadline !== null && $daysToDeadline > 7)

                                                <p class="mt-1 text-[9px] text-[#8D9A94]">
                                                    Masih terbuka
                                                </p>

                                            @endif

                                        @else

                                            <p class="mt-1 text-sm font-semibold text-[#53675E]">
                                                Tidak ditentukan
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Proposals --}}

                            <div class="rounded-xl border border-[#E6ECE8] bg-[#FAFCFB] px-4 py-4">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                        <i class="bi bi-people text-[14px]"></i>
                                    </div>

                                    <div>

                                        <p class="text-[9px] font-semibold uppercase tracking-[0.12em] text-[#96A29C]">
                                            Proposal
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-[#18382E]">
                                            {{ number_format($job->proposals_count, 0, ',', '.') }}
                                        </p>

                                        <p class="mt-1 text-[9px] text-[#8D9A94]">
                                            Freelancer yang melamar
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- Category / skills --}}

                    <section
                        class="rounded-2xl border border-[#DEE8E2] bg-white p-5 shadow-[0_6px_20px_rgba(18,49,40,0.035)] sm:p-7"
                    >

                        <p class="text-[9px] font-semibold uppercase tracking-[0.17em] text-[#1E9E5A]">
                            Kategori
                        </p>

                        <h2 class="mt-1 text-base font-semibold text-[#123128]">
                            Bidang pekerjaan
                        </h2>


                        <div class="mt-4 flex flex-wrap gap-2">

                            @if($job->category)

                                <a
                                    href="{{ route('marketplace.category', $job->category->slug) }}"
                                    class="inline-flex items-center gap-1.5 rounded-full border border-[#CDE5D6] bg-[#F1FAF4] px-3 py-1.5 text-[10px] font-medium text-[#267247] transition hover:bg-[#E6F6EB]"
                                >
                                    <i class="bi bi-grid text-[9px]"></i>
                                    {{ $job->category->name }}
                                </a>

                            @endif


                            @if($job->subcategory)

                                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#E1E9E5] bg-[#F8FAF9] px-3 py-1.5 text-[10px] font-medium text-[#64766E]">

                                    <i class="bi bi-tag text-[9px]"></i>

                                    {{ $job->subcategory->name }}

                                </span>

                            @endif

                        </div>

                    </section>


                    {{-- Safety / workflow note --}}

                    <section
                        class="rounded-2xl border border-[#DCE9E2] bg-[#F1F8F4] px-5 py-5 sm:px-7"
                    >

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">
                                <i class="bi bi-shield-check text-[14px]"></i>
                            </div>

                            <div>

                                <p class="text-[11px] font-semibold text-[#2C5143]">
                                    Gunakan alur komunikasi JASAIN
                                </p>

                                <p class="mt-1 text-[10px] leading-5 text-[#789087]">
                                    Diskusikan kebutuhan, proposal, dan kesepakatan pekerjaan
                                    melalui fitur yang tersedia di JASAIN agar proses tetap terorganisir.
                                </p>

                            </div>

                        </div>

                    </section>

                </div>


                {{-- =================================================
                    RIGHT SIDEBAR
                ================================================== --}}

                <aside class="space-y-4 lg:sticky lg:top-24">

                    {{-- Client card --}}

                    <section
                        class="rounded-2xl border border-[#DEE8E2] bg-white p-5 shadow-[0_6px_20px_rgba(18,49,40,0.035)]"
                    >

                        <p class="text-[9px] font-semibold uppercase tracking-[0.17em] text-[#1E9E5A]">
                            Client
                        </p>

                        <div class="mt-4 flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A]">
                                {{ $clientInitial }}
                            </div>

                            <div class="min-w-0">

                                <p class="truncate text-sm font-semibold text-[#18382E]">
                                    {{ $clientName }}
                                </p>

                                <p class="mt-1 text-[10px] text-[#8B9993]">
                                    Member JASAIN
                                </p>

                            </div>

                        </div>


                        <div class="mt-5 grid grid-cols-2 gap-2">

                            <div class="rounded-xl bg-[#FAFCFB] px-3 py-3">

                                <p class="text-[9px] uppercase tracking-[0.1em] text-[#98A49E]">
                                    Proposal
                                </p>

                                <p class="mt-1 text-xs font-semibold text-[#496157]">
                                    {{ number_format($job->proposals_count, 0, ',', '.') }}
                                </p>

                            </div>


                            <div class="rounded-xl bg-[#FAFCFB] px-3 py-3">

                                <p class="text-[9px] uppercase tracking-[0.1em] text-[#98A49E]">
                                    Diposting
                                </p>

                                <p class="mt-1 text-xs font-semibold text-[#496157]">
                                    {{ $publishedAt?->format('d M Y') }}
                                </p>

                            </div>

                        </div>

                    </section>


                    {{-- CTA --}}

                    <section
                        class="rounded-2xl border border-[#D7E8DE] bg-white p-5 shadow-[0_8px_24px_rgba(18,49,40,0.045)]"
                    >

                        <p class="text-[9px] font-semibold uppercase tracking-[0.17em] text-[#1E9E5A]">
                            Tertarik dengan project ini?
                        </p>

                        <h2 class="mt-1.5 text-base font-semibold leading-5 text-[#123128]">
                            Siapkan proposal terbaikmu.
                        </h2>

                        <p class="mt-2 text-[10px] leading-5 text-[#87958F]">
                            Jelaskan pengalaman, pendekatan kerja, estimasi waktu,
                            dan penawaran yang sesuai dengan kebutuhan client.
                        </p>


                        @if($isOwner)

                            <a
                                href="{{ route('client.jobs.show', $job) }}"
                                class="mt-5 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#123128] px-4 text-[11px] font-semibold text-white transition hover:bg-[#0F6B3A]"
                            >
                                <i class="bi bi-kanban"></i>
                                Kelola project
                            </a>

                        @elseif($isFreelancer)

                            <a
                                href="{{ route('freelancer.jobs.show', $job) }}"
                                class="mt-5 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-4 text-[11px] font-semibold text-white transition duration-200 hover:bg-[#0F6B3A]"
                            >
                                <i class="bi bi-send"></i>
                                Ajukan proposal
                            </a>

                        @elseif(!$isClient)

                            <a
                                href="{{ route('login') }}"
                                class="mt-5 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-4 text-[11px] font-semibold text-white transition duration-200 hover:bg-[#0F6B3A]"
                            >
                                <i class="bi bi-box-arrow-in-right"></i>
                                Masuk untuk melamar
                            </a>

                        @endif


                        @if($isClient && !$isOwner)

                            <div class="mt-5 rounded-xl border border-[#E4EBE7] bg-[#F8FAF9] px-4 py-3">

                                <div class="flex items-start gap-2">

                                    <i class="bi bi-info-circle mt-0.5 text-[#8D9A94]"></i>

                                    <p class="text-[10px] leading-5 text-[#7A8982]">
                                        Kamu sedang masuk sebagai client. Gunakan akun freelancer
                                        untuk mengajukan proposal ke project ini.
                                    </p>

                                </div>

                            </div>

                        @endif

                    </section>


                    {{-- Project summary --}}

                    <section
                        class="rounded-2xl border border-[#DEE8E2] bg-white p-5 shadow-[0_6px_20px_rgba(18,49,40,0.035)]"
                    >

                        <p class="text-[9px] font-semibold uppercase tracking-[0.17em] text-[#1E9E5A]">
                            Ringkasan
                        </p>

                        <div class="mt-4 space-y-3">

                            <div class="flex items-start justify-between gap-4">

                                <span class="text-[10px] text-[#8A9992]">
                                    Budget
                                </span>

                                <span class="text-right text-[10px] font-semibold text-[#41584F]">

                                    @if($job->budget_min !== null && $job->budget_max !== null)

                                        Rp {{ number_format((float) $job->budget_min, 0, ',', '.') }}
                                        —
                                        Rp {{ number_format((float) $job->budget_max, 0, ',', '.') }}

                                    @elseif($job->budget_min !== null)

                                        Mulai Rp {{ number_format((float) $job->budget_min, 0, ',', '.') }}

                                    @elseif($job->budget_max !== null)

                                        Hingga Rp {{ number_format((float) $job->budget_max, 0, ',', '.') }}

                                    @else

                                        Fleksibel

                                    @endif

                                </span>

                            </div>


                            <div class="flex items-start justify-between gap-4">

                                <span class="text-[10px] text-[#8A9992]">
                                    Durasi
                                </span>

                                <span class="text-right text-[10px] font-semibold text-[#41584F]">
                                    {{ $job->duration_days ? $job->duration_days . ' hari' : 'Menyesuaikan' }}
                                </span>

                            </div>


                            <div class="flex items-start justify-between gap-4">

                                <span class="text-[10px] text-[#8A9992]">
                                    Deadline
                                </span>

                                <span class="text-right text-[10px] font-semibold text-[#41584F]">
                                    {{ $job->deadline?->format('d M Y') ?? 'Tidak ditentukan' }}
                                </span>

                            </div>


                            <div class="flex items-start justify-between gap-4">

                                <span class="text-[10px] text-[#8A9992]">
                                    Proposal
                                </span>

                                <span class="text-right text-[10px] font-semibold text-[#41584F]">
                                    {{ number_format($job->proposals_count, 0, ',', '.') }}
                                </span>

                            </div>

                        </div>

                    </section>

                </aside>

            </div>


            {{-- =================================================
                RELATED JOBS
            ================================================== --}}

            @if($relatedJobs->count())

                <section class="mt-10 border-t border-[#E2EAE5] pt-9">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.17em] text-[#1E9E5A]">
                                Explore
                            </p>

                            <h2 class="mt-1 text-xl font-semibold tracking-[-0.025em] text-[#123128]">
                                Project lain yang mungkin sesuai
                            </h2>

                            <p class="mt-1 text-[11px] text-[#8A9993]">
                                Beberapa kebutuhan lain dari kategori yang sama.
                            </p>

                        </div>


                        <a
                            href="{{ route('marketplace.jobs.index', ['category' => $job->category?->slug]) }}"
                            class="inline-flex items-center gap-1.5 text-[10px] font-semibold text-[#1E9E5A] hover:text-[#0F6B3A]"
                        >
                            Lihat semua
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>


                    <div class="mt-5 grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">

                        @foreach($relatedJobs as $relatedJob)

                            @php
                                $relatedClientName = $relatedJob->client?->name ?? 'Client';
                            @endphp

                            <article
                                class="group rounded-2xl border border-[#DFE8E3] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-[#C9DDD1] hover:shadow-[0_12px_26px_rgba(18,49,40,0.05)]"
                            >

                                <div class="flex items-center justify-between gap-2">

                                    @if($relatedJob->category)

                                        <span class="truncate rounded-full bg-[#F1F8F4] px-2.5 py-1 text-[9px] font-medium text-[#537066]">
                                            {{ $relatedJob->category->name }}
                                        </span>

                                    @endif

                                    <span class="shrink-0 text-[9px] text-[#97A39D]">
                                        {{ $relatedJob->published_at?->diffForHumans() }}
                                    </span>

                                </div>


                                <a
                                    href="{{ route('marketplace.jobs.show', $relatedJob) }}"
                                    class="mt-3 block"
                                >

                                    <h3
                                        class="line-clamp-2 text-sm font-semibold leading-5 text-[#17382E] transition group-hover:text-[#0F6B3A]"
                                    >
                                        {{ $relatedJob->title }}
                                    </h3>

                                </a>


                                <p class="mt-2 line-clamp-2 text-[10px] leading-5 text-[#83918B]">
                                    {{ \Illuminate\Support\Str::limit($relatedJob->description, 95) }}
                                </p>


                                <div class="mt-4 flex items-center justify-between gap-3 border-t border-[#EDF1EE] pt-3">

                                    <div>

                                        <p class="text-[9px] text-[#98A49E]">
                                            Budget
                                        </p>

                                        <p class="mt-0.5 text-[10px] font-semibold text-[#50655B]">

                                            @if($relatedJob->budget_min !== null && $relatedJob->budget_max !== null)

                                                Rp {{ number_format((float) $relatedJob->budget_min, 0, ',', '.') }}

                                                <span class="font-normal text-[#A1AAA6]">
                                                    —
                                                </span>

                                                Rp {{ number_format((float) $relatedJob->budget_max, 0, ',', '.') }}

                                            @elseif($relatedJob->budget_min !== null)

                                                Mulai Rp {{ number_format((float) $relatedJob->budget_min, 0, ',', '.') }}

                                            @elseif($relatedJob->budget_max !== null)

                                                Hingga Rp {{ number_format((float) $relatedJob->budget_max, 0, ',', '.') }}

                                            @else

                                                Fleksibel

                                            @endif

                                        </p>

                                    </div>


                                    <div class="text-right">

                                        <p class="text-[9px] text-[#98A49E]">
                                            Proposal
                                        </p>

                                        <p class="mt-0.5 text-[10px] font-semibold text-[#50655B]">
                                            {{ number_format($relatedJob->proposals_count, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>


                                <p class="mt-3 truncate text-[9px] text-[#98A49E]">
                                    <i class="bi bi-person mr-1"></i>
                                    {{ $relatedClientName }}
                                </p>

                            </article>

                        @endforeach

                    </div>

                </section>

            @endif

        </section>

    </main>

</x-layouts.marketplace>
