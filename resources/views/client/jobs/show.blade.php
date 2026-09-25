<x-layouts.marketplace>

    @php
        $budget = 'Fleksibel';

        if ($job->budget_min !== null && $job->budget_max !== null) {
            $budget = 'Rp ' . number_format((float) $job->budget_min, 0, ',', '.')
                . ' - Rp ' . number_format((float) $job->budget_max, 0, ',', '.');
        } elseif ($job->budget_min !== null) {
            $budget = 'Rp ' . number_format((float) $job->budget_min, 0, ',', '.');
        } elseif ($job->budget_max !== null) {
            $budget = 'Rp ' . number_format((float) $job->budget_max, 0, ',', '.');
        }

        $statusLabel = ucfirst(str_replace('_', ' ', $job->status));

        $statusClass = match ($job->status) {
            'open' => 'bg-blue-50 text-blue-700 border-blue-100',
            'draft' => 'bg-slate-100 text-slate-600 border-slate-200',
            'closed' => 'bg-slate-100 text-slate-600 border-slate-200',
            'cancelled' => 'bg-rose-50 text-rose-700 border-rose-100',
            default => 'bg-blue-50 text-blue-700 border-blue-100',
        };
    @endphp

    <main class="min-h-[calc(100vh-72px)] bg-[#F8FAFC]">

        {{-- =========================================================
            TOP BAR
        ========================================================== --}}
        <section class="border-b border-slate-200 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <a
                        href="{{ route('client.jobs.index') }}"
                        class="inline-flex w-fit items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#2563EB]"
                    >
                        <span class="flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm">
                            <i class="bi bi-arrow-left text-xs"></i>
                        </span>
                        Kembali ke Job Saya
                    </a>

                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <i class="bi bi-briefcase"></i>
                        Job Board
                    </div>

                </div>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mt-4 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-700">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <span class="pt-1">
                            {{ session('success') }}
                        </span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mt-4 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm text-rose-700">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-rose-100 text-rose-600">
                            <i class="bi bi-exclamation-lg"></i>
                        </div>

                        <span class="pt-1">
                            {{ session('error') }}
                        </span>
                    </div>
                @endif

            </div>
        </section>


        {{-- =========================================================
            MAIN CONTENT
        ========================================================== --}}
        <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">

                {{-- =================================================
                    LEFT CONTENT
                ================================================== --}}
                <div class="min-w-0 space-y-6">

                    {{-- =================================================
                        JOB HEADER / DETAIL
                    ================================================== --}}
                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 px-5 py-6 sm:px-7 sm:py-7">

                            {{-- Meta --}}
                            <div class="flex flex-wrap items-center gap-2">

                                <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-[11px] font-semibold {{ $statusClass }}">
                                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                    {{ $statusLabel }}
                                </span>

                                @if($job->category)
                                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-[11px] font-medium text-slate-600">
                                        {{ $job->category->name }}
                                    </span>
                                @endif

                                @if($job->subcategory)
                                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-[11px] font-medium text-slate-600">
                                        {{ $job->subcategory->name }}
                                    </span>
                                @endif

                            </div>

                            {{-- Title --}}
                            <h1 class="mt-4 text-2xl font-bold leading-tight tracking-tight text-slate-900 sm:text-3xl">
                                {{ $job->title }}
                            </h1>

                            {{-- Meta Info --}}
                            <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-3 text-xs text-slate-500">

                                <span class="inline-flex items-center gap-2">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]">
                                        <i class="bi bi-calendar3"></i>
                                    </span>

                                    <span>
                                        @if($job->published_at)
                                            Dipublikasikan {{ $job->published_at->format('d M Y') }}
                                        @else
                                            Draft
                                        @endif
                                    </span>
                                </span>

                                <span class="inline-flex items-center gap-2">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                        <i class="bi bi-people"></i>
                                    </span>

                                    <span>
                                        {{ $job->proposals->count() }} freelancer tertarik
                                    </span>
                                </span>

                            </div>

                        </div>


                        {{-- Description --}}
                        <div class="px-5 py-6 sm:px-7 sm:py-7">

                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>

                                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                                    Detail pekerjaan
                                </h2>
                            </div>

                            <div class="mt-5 whitespace-pre-line text-sm leading-7 text-slate-600">
                                {{ $job->description }}
                            </div>

                        </div>


                        {{-- Information --}}
                        <div class="border-t border-slate-100 bg-slate-50/50 px-5 py-6 sm:px-7">

                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                    <i class="bi bi-bar-chart"></i>
                                </div>

                                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                                    Informasi pekerjaan
                                </h2>
                            </div>

                            <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">

                                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                        Budget
                                    </p>

                                    <p class="mt-2 text-sm font-bold text-[#2563EB]">
                                        {{ $budget }}
                                    </p>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                        Durasi
                                    </p>

                                    <p class="mt-2 text-sm font-semibold text-slate-800">
                                        {{ $job->duration_days ? $job->duration_days . ' hari' : '-' }}
                                    </p>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                        Deadline
                                    </p>

                                    <p class="mt-2 text-sm font-semibold text-slate-800">
                                        {{ $job->deadline?->format('d M Y') ?? '-' }}
                                    </p>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                        Freelancer
                                    </p>

                                    <p class="mt-2 text-sm font-semibold text-slate-800">
                                        {{ $job->proposals->count() }} orang
                                    </p>
                                </div>

                            </div>

                        </div>

                    </article>


                    {{-- =================================================
                        PROPOSALS HEADER
                    ================================================== --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 px-5 py-5 sm:px-7">

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB]">
                                        <i class="bi bi-people-fill"></i>
                                    </div>

                                    <div>
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                                            Freelancer
                                        </p>

                                        <h2 class="mt-0.5 text-base font-bold text-slate-900 sm:text-lg">
                                            Tawaran yang masuk
                                        </h2>
                                    </div>
                                </div>

                                <span class="w-fit rounded-full bg-slate-100 px-3 py-1.5 text-[11px] font-semibold text-slate-600">
                                    {{ $job->proposals->count() }} tawaran
                                </span>

                            </div>

                        </div>


                        {{-- =================================================
                            PROPOSALS
                        ================================================== --}}
                        @forelse($job->proposals as $proposal)

                            @php
                                $freelancer = $proposal->freelancerProfile;
                                $freelancerUser = $freelancer?->user;

                                $freelancerName =
                                    $proposal->display_name
                                    ?: $freelancerUser?->name
                                    ?: 'Freelancer';

                                $freelancerAvatar = $freelancer?->avatar
                                    ? asset('storage/' . $freelancer->avatar)
                                    : null;

                                $freelancerInitial = strtoupper(
                                    mb_substr($freelancerName, 0, 1)
                                );
                            @endphp

                            <article class="border-b border-slate-100 px-5 py-6 last:border-b-0 sm:px-7 sm:py-7">

                                {{-- Freelancer Header --}}
                                <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">

                                    <div class="flex min-w-0 gap-3.5">

                                        {{-- Avatar --}}
                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-blue-50 text-sm font-bold text-[#2563EB] ring-1 ring-blue-100">

                                            @if($freelancerAvatar)
                                                <img
                                                    src="{{ $freelancerAvatar }}"
                                                    alt="{{ $freelancerName }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @else
                                                {{ $freelancerInitial }}
                                            @endif

                                        </div>


                                        {{-- Identity --}}
                                        <div class="min-w-0">

                                            <div class="flex flex-wrap items-center gap-2">

                                                <h3 class="truncate text-sm font-bold text-slate-900">
                                                    {{ $freelancerName }}
                                                </h3>

                                                @if($proposal->status === 'accepted')
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        Dipilih
                                                    </span>
                                                @elseif($proposal->status === 'rejected')
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-[10px] font-semibold text-rose-700">
                                                        <i class="bi bi-x-circle-fill"></i>
                                                        Ditolak
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-700">
                                                        <i class="bi bi-hourglass-split"></i>
                                                        Menunggu
                                                    </span>
                                                @endif

                                            </div>

                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $freelancer?->username ? '@' . $freelancer->username : 'Freelancer ProKerja' }}
                                            </p>

                                        </div>

                                    </div>


                                    {{-- Price + Duration --}}
                                    <div class="grid grid-cols-2 gap-3 sm:min-w-[280px]">

                                        <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-3.5">
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-blue-500">
                                                Harga
                                            </p>

                                            <p class="mt-1.5 text-sm font-bold text-[#2563EB]">
                                                Rp {{ number_format((float) $proposal->price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3.5">
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                                Durasi
                                            </p>

                                            <p class="mt-1.5 text-sm font-bold text-slate-800">
                                                {{ $proposal->delivery_days }} hari
                                            </p>
                                        </div>

                                    </div>

                                </div>


                                {{-- Relevant Information --}}
                                <div class="mt-6">

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                                        Informasi yang ditawarkan
                                    </p>

                                    <div class="mt-2 rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-4 text-sm leading-6 text-slate-600">
                                        {{ $proposal->relevant_info ?: $proposal->message }}
                                    </div>

                                </div>


                                {{-- Experience --}}
                                @if($proposal->selectedExperience)

                                    <div class="mt-6">

                                        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                                            Pengalaman relevan
                                        </p>

                                        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-2 rounded-2xl border border-slate-200 bg-white px-4 py-3.5">

                                            <span class="inline-flex items-center gap-2 text-sm font-semibold text-slate-800">
                                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                                    <i class="bi bi-briefcase"></i>
                                                </span>

                                                {{ $proposal->selectedExperience->position }}
                                            </span>

                                            @if($proposal->selectedExperience->company)
                                                <span class="text-xs text-slate-500">
                                                    {{ $proposal->selectedExperience->company }}
                                                </span>
                                            @endif

                                            @if($proposal->selectedExperience->start_year)
                                                <span class="text-[11px] text-slate-400">
                                                    {{ $proposal->selectedExperience->start_year }}
                                                    -
                                                    {{ $proposal->selectedExperience->end_year ?: 'Sekarang' }}
                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                @endif


                                {{-- Portfolio --}}
                                <div class="mt-6">

                                    <div class="flex items-center justify-between gap-3">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                                            Portofolio
                                        </p>

                                        @if($proposal->portfolio_url || $proposal->portfolios->isNotEmpty())
                                            <span class="text-[10px] text-slate-400">
                                                {{ ($proposal->portfolio_url ? 1 : 0) + $proposal->portfolios->count() }} lampiran
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mt-2 grid gap-2 sm:grid-cols-2">

                                        @if($proposal->portfolio_url)

                                            <a
                                                href="{{ $proposal->portfolio_url }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="group flex min-w-0 items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3.5 py-3.5 text-xs font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50/50"
                                            >
                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                                                    <i class="bi bi-link-45deg text-base"></i>
                                                </span>

                                                <span class="min-w-0 flex-1 truncate">
                                                    Lihat portfolio
                                                </span>

                                                <i class="bi bi-box-arrow-up-right shrink-0 text-[10px] text-slate-400 transition group-hover:text-[#2563EB]"></i>
                                            </a>

                                        @endif


                                        @foreach($proposal->portfolios as $portfolio)

                                            <a
                                                href="{{ asset('storage/' . $portfolio->file_path) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="group flex min-w-0 items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3.5 py-3.5 text-xs text-slate-600 transition hover:border-blue-200 hover:bg-blue-50/50"
                                            >

                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">

                                                    @if(str_starts_with($portfolio->mime_type ?? '', 'image/'))
                                                        <i class="bi bi-image"></i>
                                                    @else
                                                        <i class="bi bi-file-earmark"></i>
                                                    @endif

                                                </span>

                                                <span class="min-w-0 flex-1 truncate">
                                                    {{ $portfolio->original_name }}
                                                </span>

                                                <i class="bi bi-box-arrow-up-right shrink-0 text-[10px] text-slate-400 transition group-hover:text-[#2563EB]"></i>

                                            </a>

                                        @endforeach


                                        @if(!$proposal->portfolio_url && $proposal->portfolios->isEmpty())

                                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-4 text-xs text-slate-400 sm:col-span-2">
                                                Tidak ada portofolio yang dilampirkan.
                                            </div>

                                        @endif

                                    </div>

                                </div>


                                {{-- Phone --}}
                                <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                                            <i class="bi bi-telephone"></i>
                                        </div>

                                        <div>
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                                Nomor telepon
                                            </p>

                                            <p class="mt-1 text-xs font-semibold text-slate-700">
                                                {{ $proposal->phone ?: '-' }}
                                            </p>
                                        </div>

                                    </div>

                                </div>


                                {{-- =================================================
                                    ACTIONS
                                ================================================== --}}
                                @if($proposal->status === 'pending' && $job->status === 'open')

                                    <div class="mt-6 border-t border-slate-100 pt-5">

                                        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

                                            {{-- Profile --}}
                                            @if($freelancer?->username)

                                                <a
                                                    href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                                                    target="_blank"
                                                    class="inline-flex h-10 items-center justify-center gap-2 rounded-2xl px-4 text-xs font-semibold text-[#2563EB] transition hover:bg-blue-50"
                                                >
                                                    <i class="bi bi-person"></i>
                                                    Lihat profil freelancer
                                                </a>

                                            @endif


                                            <div class="grid grid-cols-1 gap-2 sm:grid-cols-3">

                                                {{-- Chat --}}
                                                <a
                                                    href="{{ route('client.jobs.chat.start', [$job, $proposal]) }}"
                                                    class="inline-flex h-10 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
                                                >
                                                    <i class="bi bi-chat-dots"></i>
                                                    Chat
                                                </a>


                                                {{-- Reject --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('client.jobs.proposals.reject', [$job, $proposal]) }}"
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="flex h-10 w-full items-center justify-center gap-2 rounded-2xl border border-rose-200 bg-white px-4 text-xs font-semibold text-rose-600 transition hover:bg-rose-50"
                                                    >
                                                        <i class="bi bi-x-lg"></i>
                                                        Tolak
                                                    </button>
                                                </form>


                                                {{-- Accept --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('client.jobs.proposals.accept', [$job, $proposal]) }}"
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="flex h-10 w-full items-center justify-center gap-2 rounded-2xl bg-[#2563EB] px-5 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md active:scale-[0.98]"
                                                    >
                                                        <i class="bi bi-check-lg"></i>
                                                        Pilih freelancer
                                                    </button>
                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                @elseif($proposal->status === 'accepted')

                                    <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4">

                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                                                <i class="bi bi-check-lg"></i>
                                            </div>

                                            <div>
                                                <p class="text-sm font-bold text-emerald-800">
                                                    Freelancer ini sudah dipilih
                                                </p>

                                                <p class="mt-1 text-xs leading-5 text-emerald-700/80">
                                                    Selanjutnya client dan freelancer dapat menyelesaikan
                                                    detail pekerjaan sebelum dibuatkan Order JASAIN.
                                                </p>
                                            </div>

                                        </div>

                                    </div>

                                @endif

                            </article>

                        @empty

                            <div class="px-6 py-16 text-center sm:py-20">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB]">
                                    <i class="bi bi-people text-xl"></i>
                                </div>

                                <h3 class="mt-5 text-sm font-bold text-slate-900">
                                    Belum ada freelancer yang mengajukan
                                </h3>

                                <p class="mx-auto mt-2 max-w-md text-xs leading-5 text-slate-500">
                                    Freelancer yang tertarik dengan pekerjaan ini akan muncul
                                    di bagian ini setelah mengirimkan tawaran.
                                </p>

                            </div>

                        @endforelse

                    </section>

                </div>


                {{-- =================================================
                    RIGHT SIDEBAR
                ================================================== --}}
                <aside class="lg:sticky lg:top-[90px] lg:self-start">

                    <div class="space-y-5">

                        {{-- Job Summary --}}
                        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                            <div class="bg-gradient-to-br from-blue-50 via-white to-white px-5 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#2563EB] text-white shadow-sm">
                                        <i class="bi bi-briefcase-fill"></i>
                                    </div>

                                    <div>
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-blue-600">
                                            Ringkasan Job
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-500">
                                            Detail pekerjaan
                                        </p>
                                    </div>

                                </div>

                                <h2 class="mt-4 text-sm font-bold leading-5 text-slate-900">
                                    {{ $job->title }}
                                </h2>

                            </div>


                            <div class="border-t border-slate-100 px-5 py-5">

                                <div class="space-y-3.5">

                                    <div class="flex items-start justify-between gap-4">
                                        <span class="text-xs text-slate-500">
                                            Budget
                                        </span>

                                        <span class="max-w-[180px] text-right text-xs font-bold text-[#2563EB]">
                                            {{ $budget }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-xs text-slate-500">
                                            Kategori
                                        </span>

                                        <span class="text-right text-xs font-semibold text-slate-700">
                                            {{ $job->category?->name ?? 'Lainnya' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-xs text-slate-500">
                                            Durasi
                                        </span>

                                        <span class="text-xs font-semibold text-slate-700">
                                            {{ $job->duration_days ? $job->duration_days . ' hari' : '-' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-xs text-slate-500">
                                            Deadline
                                        </span>

                                        <span class="text-xs font-semibold text-slate-700">
                                            {{ $job->deadline?->format('d M Y') ?? '-' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-xs text-slate-500">
                                            Freelancer
                                        </span>

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-bold text-[#2563EB]">
                                            <i class="bi bi-people"></i>
                                            {{ $job->proposals->count() }}
                                        </span>
                                    </div>

                                </div>

                            </div>


                            {{-- Management --}}
                            @if(!in_array($job->status, ['closed', 'cancelled'], true))

                                <div class="border-t border-slate-100 bg-slate-50/50 px-5 py-5">

                                    <p class="mb-3 text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                        Kelola Job
                                    </p>

                                    <div class="space-y-2">

                                        <a
                                            href="{{ route('client.jobs.edit', $job) }}"
                                            class="flex h-10 w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            Edit Job
                                        </a>


                                        @if($job->status === 'draft')

                                            <form
                                                method="POST"
                                                action="{{ route('client.jobs.publish', $job) }}"
                                            >
                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="flex h-10 w-full items-center justify-center gap-2 rounded-2xl bg-[#2563EB] text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700"
                                                >
                                                    <i class="bi bi-send"></i>
                                                    Publikasikan
                                                </button>
                                            </form>

                                        @elseif($job->status === 'open')

                                            <form
                                                method="POST"
                                                action="{{ route('client.jobs.close', $job) }}"
                                            >
                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="flex h-10 w-full items-center justify-center gap-2 rounded-2xl bg-amber-50 text-xs font-semibold text-amber-700 transition hover:bg-amber-100"
                                                >
                                                    <i class="bi bi-x-circle"></i>
                                                    Tutup Job
                                                </button>
                                            </form>

                                        @endif

                                    </div>

                                </div>

                            @endif

                        </div>


                        {{-- Marketplace Tips --}}
                        <div class="rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 via-white to-blue-50/60 p-5 shadow-sm">

                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#2563EB] text-white shadow-sm">
                                <i class="bi bi-lightbulb-fill"></i>
                            </div>

                            <h3 class="mt-4 text-sm font-bold text-slate-900">
                                Tips memilih freelancer
                            </h3>

                            <div class="mt-3 space-y-2.5">

                                <div class="flex gap-2.5">
                                    <i class="bi bi-check-circle-fill mt-0.5 text-xs text-[#2563EB]"></i>
                                    <p class="text-[11px] leading-5 text-slate-500">
                                        Perhatikan pengalaman yang relevan dengan kebutuhanmu.
                                    </p>
                                </div>

                                <div class="flex gap-2.5">
                                    <i class="bi bi-check-circle-fill mt-0.5 text-xs text-[#2563EB]"></i>
                                    <p class="text-[11px] leading-5 text-slate-500">
                                        Cek portofolio sebelum memilih freelancer.
                                    </p>
                                </div>

                                <div class="flex gap-2.5">
                                    <i class="bi bi-check-circle-fill mt-0.5 text-xs text-[#2563EB]"></i>
                                    <p class="text-[11px] leading-5 text-slate-500">
                                        Gunakan fitur chat untuk mendiskusikan kebutuhan pekerjaan.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </aside>

            </div>

        </section>

    </main>

</x-layouts.marketplace>