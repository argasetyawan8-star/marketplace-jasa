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
    class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]"
>

    {{-- =========================================================
        FLASH MESSAGE
    ========================================================== --}}

    @if(session('success') || session('error'))
        <div class="mx-auto max-w-7xl px-4 pt-5 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="flex items-start gap-3 rounded-lg border border-[#CDE8D7] bg-white px-4 py-3 text-sm text-[#355248]">
                    <i class="bi bi-check-circle-fill mt-0.5 text-[#1E9E5A]"></i>

                    <span>
                        {{ session('success') }}
                    </span>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-start gap-3 rounded-lg border border-red-100 bg-white px-4 py-3 text-sm text-red-600">
                    <i class="bi bi-exclamation-circle-fill mt-0.5"></i>

                    <span>
                        {{ session('error') }}
                    </span>
                </div>
            @endif

        </div>
    @endif


    {{-- =========================================================
        CONTENT
    ========================================================== --}}

    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}

        <div class="mb-5 flex flex-wrap items-center gap-2 text-xs text-[#7E8F87]">

            <a
                href="{{ route('freelancer.jobs.index') }}"
                class="transition hover:text-[#0F6B3A]"
            >
                Job Board
            </a>

            <i class="bi bi-chevron-right text-[9px] text-[#A8B3AE]"></i>

            <span class="truncate text-[#53675E]">
                {{ $job->title }}
            </span>

        </div>


        <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_330px]">

            {{-- =================================================
                 LEFT
            ================================================== --}}

            <div class="min-w-0">

                {{-- JOB DETAIL --}}

                <article class="rounded-xl border border-[#DDE7E2] bg-white">

                    {{-- Header --}}

                    <div class="border-b border-[#E8EFEB] px-5 py-6 sm:px-7">

                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] text-[#84948D]">

                            @if($job->category)
                                <span>
                                    {{ $job->category->name }}
                                </span>
                            @endif

                            @if($job->subcategory)
                                <span class="text-[#B9C3BE]">
                                    •
                                </span>

                                <span>
                                    {{ $job->subcategory->name }}
                                </span>
                            @endif

                            <span class="text-[#B9C3BE]">
                                •
                            </span>

                            <span>
                                Posted
                                {{ optional($job->published_at)->format('d M Y') ?? optional($job->created_at)->format('d M Y') }}
                            </span>

                        </div>

                        <h1 class="mt-3 text-2xl font-semibold leading-tight tracking-tight text-[#123128] sm:text-[30px]">
                            {{ $job->title }}
                        </h1>

                        <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#71837B]">

                            <span class="inline-flex items-center gap-1.5">
                                <i class="bi bi-briefcase text-[#1E9E5A]"></i>
                                Freelance
                            </span>

                            @if($job->location)
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="bi bi-geo-alt text-[#1E9E5A]"></i>
                                    {{ $job->location }}
                                </span>
                            @endif

                            <span class="inline-flex items-center gap-1.5">
                                <i class="bi bi-people text-[#1E9E5A]"></i>
                                {{ $job->proposals_count }} applied
                            </span>

                        </div>

                    </div>


                    {{-- Description --}}

                    <div class="px-5 py-6 sm:px-7 sm:py-7">

                        <h2 class="text-sm font-semibold text-[#123128]">
                            Detail pekerjaan
                        </h2>

                        <div class="mt-4 whitespace-pre-line text-sm leading-7 text-[#53675E]">
                            {{ $job->description }}
                        </div>

                    </div>


                    {{-- Information --}}

                    <div class="border-t border-[#E8EFEB] px-5 py-6 sm:px-7">

                        <h2 class="text-sm font-semibold text-[#123128]">
                            Informasi pekerjaan
                        </h2>

                        <div class="mt-5 grid gap-x-8 gap-y-6 sm:grid-cols-2">

                            <div>
                                <p class="text-[11px] text-[#8A9993]">
                                    Kategori
                                </p>

                                <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                    {{ $job->category?->name ?? 'Lainnya' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[11px] text-[#8A9993]">
                                    Tipe pekerjaan
                                </p>

                                <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                    Freelance
                                </p>
                            </div>

                            <div>
                                <p class="text-[11px] text-[#8A9993]">
                                    Budget client
                                </p>

                                <p class="mt-1.5 text-sm font-semibold text-[#0F6B3A]">
                                    {{ $budget }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[11px] text-[#8A9993]">
                                    Deliver within
                                </p>

                                <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                    @if($job->duration_days)
                                        {{ $job->duration_days }} hari
                                    @else
                                        Menyesuaikan
                                    @endif
                                </p>
                            </div>

                            <div>
                                <p class="text-[11px] text-[#8A9993]">
                                    Deadline
                                </p>

                                <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                    {{ $job->deadline ? $job->deadline->format('d M Y') : 'Tidak ditentukan' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[11px] text-[#8A9993]">
                                    Freelancer tertarik
                                </p>

                                <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                    {{ $job->proposals_count }} orang
                                </p>
                            </div>

                        </div>

                    </div>

                </article>


                {{-- CLIENT --}}

                <article class="mt-5 rounded-xl border border-[#DDE7E2] bg-white px-5 py-5 sm:px-7">

                    <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#899790]">
                        Diposting oleh
                    </p>

                    <div class="mt-3 flex items-center gap-3">

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A]">

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

                            <p class="truncate text-sm font-semibold text-[#243F34]">
                                {{ $clientName }}
                            </p>

                            <p class="mt-0.5 text-xs text-[#899790]">
                                Client JASAIN
                            </p>

                        </div>

                    </div>

                </article>


                {{-- SECURITY --}}

                <article class="mt-5 rounded-xl border border-[#DDE7E2] bg-white px-5 py-5 sm:px-7">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#EDF8F1] text-[#1E9E5A]">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>

                            <h3 class="text-sm font-semibold text-[#123128]">
                                Bertransaksi melalui JASAIN
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                Jangan meminta atau menerima pembayaran di luar platform.
                                Pembayaran akan dilakukan melalui sistem JASAIN setelah
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

                <div class="rounded-xl border border-[#DDE7E2] bg-white">

                    {{-- SUMMARY --}}

                    <div class="px-5 py-5">

                        <p class="text-[11px] font-medium uppercase tracking-[0.06em] text-[#899790]">
                            Detail pekerjaan
                        </p>

                        <div class="mt-4 space-y-3">

                            <div class="flex items-start justify-between gap-4">

                                <span class="text-xs text-[#81918B]">
                                    Budget
                                </span>

                                <span class="text-right text-xs font-semibold text-[#304B40]">
                                    {{ $budget }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between gap-4">

                                <span class="text-xs text-[#81918B]">
                                    Type
                                </span>

                                <span class="text-xs font-medium text-[#304B40]">
                                    Freelance
                                </span>

                            </div>


                            @if($job->duration_days)

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#81918B]">
                                        Deliver within
                                    </span>

                                    <span class="text-xs font-medium text-[#304B40]">
                                        {{ $job->duration_days }} hari
                                    </span>

                                </div>

                            @endif


                            @if($job->deadline)

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#81918B]">
                                        Deadline
                                    </span>

                                    <span class="text-xs font-medium text-[#304B40]">
                                        {{ $job->deadline->format('d M Y') }}
                                    </span>

                                </div>

                            @endif


                            <div class="flex items-center justify-between gap-4">

                                <span class="text-xs text-[#81918B]">
                                    Applied
                                </span>

                                <span class="text-xs font-medium text-[#304B40]">
                                    {{ $job->proposals_count }}
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- OFFER CTA --}}

                    <div class="border-t border-[#E8EFEB] px-5 py-5">

                        @if($existingProposal)

                            {{-- PROPOSAL SUDAH TERKIRIM --}}

                            <div class="rounded-lg border border-[#CDE8D7] bg-[#F4FBF6] px-4 py-4">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#E3F4E9] text-[#0F6B3A]">
                                        <i class="bi bi-check-lg"></i>
                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-sm font-semibold text-[#123128]">
                                            Proposal sudah dikirim
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                            Client dapat melihat informasi proposal,
                                            pengalaman, dan portofoliomu.
                                        </p>

                                    </div>

                                </div>


                                <div class="mt-4 space-y-3">

                                    <div class="flex items-center justify-between gap-3">

                                        <span class="text-xs text-[#81918B]">
                                            Harga proposal
                                        </span>

                                        <span class="text-sm font-semibold text-[#0F6B3A]">
                                            Rp {{ number_format((float) $existingProposal->price, 0, ',', '.') }}
                                        </span>

                                    </div>


                                    <div class="flex items-center justify-between gap-3">

                                        <span class="text-xs text-[#81918B]">
                                            Durasi
                                        </span>

                                        <span class="text-sm font-semibold text-[#304B40]">
                                            {{ $existingProposal->delivery_days }} hari
                                        </span>

                                    </div>

                                </div>


                                {{-- QUOTATION BUTTON --}}

                                <div class="mt-4 border-t border-[#DCEBE1] pt-4">

                                    <a
                                        href="{{ route(
                                            'freelancer.jobs.proposals.offer.create',
                                            [$job, $existingProposal]
                                        ) }}"
                                        class="flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-[#0F6B3A] px-4 text-sm font-semibold text-white transition hover:bg-[#17894D]"
                                    >

                                        <i class="bi bi-receipt"></i>

                                        Buat Quotation

                                    </a>

                                    <p class="mt-2.5 text-center text-[11px] leading-5 text-[#899790]">
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
                                class="flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-[#0F6B3A] px-4 text-sm font-semibold text-white transition hover:bg-[#17894D]"
                            >

                                <i class="bi bi-send"></i>

                                Tawarkan pekerjaan

                            </button>

                            <p class="mt-2.5 text-center text-[11px] leading-5 text-[#899790]">
                                Tawarkan harga dan durasi yang sesuai dengan kebutuhan client.
                            </p>

                        @endif

                    </div>

                </div>


                {{-- BACK --}}

                <a
                    href="{{ route('freelancer.jobs.index') }}"
                    class="mt-4 flex h-10 items-center justify-center gap-2 rounded-lg border border-[#DDE7E2] bg-white text-xs font-medium text-[#71837B] transition hover:border-[#C8DDD1] hover:text-[#0F6B3A]"
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
            class="fixed inset-0 bg-[#10251C]/45 backdrop-blur-[2px]"
            @click="offerOpen = false"
        ></div>


        {{-- Dialog --}}

        <div class="relative flex min-h-full items-start justify-center p-4 sm:p-6">

            <div
                @click.stop
                class="relative my-4 w-full max-w-3xl overflow-hidden rounded-2xl border border-[#DCE8E1] bg-white shadow-xl"
            >

                {{-- Modal Header --}}

                <div class="border-b border-[#E7EFEB] px-5 py-5 sm:px-7">

                    <div class="flex items-start justify-between gap-4">

                        <div>

                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                                Job Proposal
                            </p>

                            <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-[#123128]">
                                Tawarkan pekerjaan
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                Lengkapi informasi berikut agar client dapat menilai proposalmu.
                            </p>

                        </div>


                        <button
                            type="button"
                            @click="offerOpen = false"
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-[#81918B] transition hover:bg-[#F1F6F3] hover:text-[#294B3D]"
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

                        <div class="rounded-xl border border-[#E1EAE5] bg-[#F8FBF9] px-4 py-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#0F6B3A]">
                                    <i class="bi bi-person-check"></i>
                                </div>

                                <div>

                                    <p class="text-sm font-semibold text-[#123128]">
                                        Tingkatkan peluang mendapatkan pekerjaan
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                        Gunakan informasi yang benar-benar relevan dengan kebutuhan client
                                        dan lampirkan portofolio terbaikmu.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- BASIC INFO --}}

                        <div>

                            <h3 class="text-sm font-semibold text-[#123128]">
                                Informasi dasar
                            </h3>

                            <p class="mt-1 text-xs text-[#81918B]">
                                Lengkapi informasi dasar sebelum mengirimkan proposal.
                            </p>


                            <div class="mt-4 grid gap-4 sm:grid-cols-2">

                                {{-- Display Name --}}

                                <div>

                                    <label
                                        for="display_name"
                                        class="text-[11px] font-semibold text-[#40564C]"
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
                                        class="mt-1.5 h-10 w-full rounded-lg border border-[#DDE7E2] px-3 text-sm text-[#233D33] outline-none transition placeholder:text-[#A0ADA7] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                                    >

                                    <p class="mt-1 text-[10px] text-[#94A29C]">
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
                                        class="text-[11px] font-semibold text-[#40564C]"
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
                                        class="mt-1.5 h-10 w-full rounded-lg border border-[#DDE7E2] px-3 text-sm text-[#233D33] outline-none transition placeholder:text-[#A0ADA7] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                                    >

                                    <p class="mt-1 text-[10px] text-[#94A29C]">
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

                            <h3 class="text-sm font-semibold text-[#123128]">
                                Informasi yang membuat client memilih Anda
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#81918B]">
                                Jelaskan pengalaman, kemampuan, metode kerja, atau hal lain
                                yang benar-benar relevan dengan pekerjaan ini.
                            </p>

                            <textarea
                                name="relevant_info"
                                rows="7"
                                required
                                minlength="100"
                                placeholder="Contoh: Saya memiliki pengalaman membuat website company profile untuk UMKM dan terbiasa menggunakan Laravel, Tailwind CSS, database MySQL, serta deployment..."
                                class="mt-3 w-full resize-y rounded-lg border border-[#DDE7E2] px-3 py-2.5 text-sm leading-6 text-[#233D33] outline-none transition placeholder:text-[#A0ADA7] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                            >{{ old('relevant_info') }}</textarea>

                            <div class="mt-1 flex items-center justify-between gap-4">

                                <p class="text-[10px] text-[#94A29C]">
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

                            <h3 class="text-sm font-semibold text-[#123128]">
                                Portofolio
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#81918B]">
                                Tambahkan URL portofolio dan file yang paling relevan.
                            </p>


                            <div class="mt-4 space-y-4">

                                {{-- Portfolio URL --}}

                                <div>

                                    <label
                                        for="portfolio_url"
                                        class="text-[11px] font-semibold text-[#40564C]"
                                    >
                                        URL Portofolio
                                    </label>

                                    <input
                                        id="portfolio_url"
                                        name="portfolio_url"
                                        type="url"
                                        value="{{ old('portfolio_url') }}"
                                        placeholder="https://portfolio-kamu.com"
                                        class="mt-1.5 h-10 w-full rounded-lg border border-[#DDE7E2] px-3 text-sm text-[#233D33] outline-none transition placeholder:text-[#A0ADA7] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
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
                                        class="text-[11px] font-semibold text-[#40564C]"
                                    >
                                        Portofolio
                                    </label>

                                    <div class="mt-1.5 rounded-lg border border-dashed border-[#CFE0D6] bg-[#FBFDFC] px-4 py-4">

                                        <input
                                            id="portfolios"
                                            name="portfolios[]"
                                            type="file"
                                            multiple
                                            accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx"
                                            class="block w-full text-xs text-[#71837B] file:mr-3 file:rounded-md file:border-0 file:bg-[#EAF7EF] file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-[#0F6B3A]"
                                        >

                                        <div class="mt-2 flex items-start gap-2 text-[10px] leading-4 text-[#94A29C]">

                                            <i class="bi bi-info-circle mt-0.5 shrink-0"></i>

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

                            <h3 class="text-sm font-semibold text-[#123128]">
                                Pilih pengalaman yang sesuai
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#81918B]">
                                Pilih pengalaman yang paling relevan dengan pekerjaan ini.
                            </p>


                            <select
                                name="selected_experience_id"
                                class="mt-3 h-10 w-full rounded-lg border border-[#DDE7E2] bg-white px-3 text-sm text-[#40564C] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
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

                                <p class="mt-1.5 text-[10px] text-[#94A29C]">
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

                            <h3 class="text-sm font-semibold text-[#123128]">
                                Tawaran Anda
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#81918B]">
                                Tentukan harga dan durasi awal yang kamu tawarkan kepada client.
                            </p>


                            <div class="mt-4 grid gap-4 sm:grid-cols-2">

                                {{-- Price --}}

                                <div>

                                    <label
                                        for="price"
                                        class="text-[11px] font-semibold text-[#40564C]"
                                    >
                                        Harga
                                    </label>

                                    <div class="relative mt-1.5">

                                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-[#91A099]">
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
                                            class="h-10 w-full rounded-lg border border-[#DDE7E2] pl-9 pr-3 text-sm text-[#233D33] outline-none transition placeholder:text-[#A0ADA7] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                                        >

                                    </div>

                                    <p class="mt-1.5 text-[10px] text-[#94A29C]">
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
                                        class="text-[11px] font-semibold text-[#40564C]"
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
                                            class="h-10 w-full rounded-lg border border-[#DDE7E2] px-3 pr-14 text-sm text-[#233D33] outline-none transition placeholder:text-[#A0ADA7] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                                        >

                                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[11px] text-[#8A9993]">
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

                        <div class="flex items-start gap-3 rounded-lg border border-[#E9E0C4] bg-[#FFFCF3] px-4 py-3">

                            <i class="bi bi-exclamation-triangle mt-0.5 text-[#B58B32]"></i>

                            <p class="text-[11px] leading-5 text-[#756845]">
                                Jangan meminta client melakukan pembayaran di luar JASAIN.
                                Komunikasi dan transaksi harus tetap dilakukan melalui platform.
                            </p>

                        </div>

                    </div>


                    {{-- Footer --}}

                    <div class="flex flex-col-reverse gap-2 border-t border-[#E7EFEB] px-5 py-4 sm:flex-row sm:justify-end sm:px-7">

                        <button
                            type="button"
                            @click="offerOpen = false"
                            class="h-10 rounded-lg border border-[#DDE7E2] bg-white px-4 text-sm font-medium text-[#71837B] transition hover:bg-[#F7FAF8]"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="flex h-10 items-center justify-center gap-2 rounded-lg bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#17894D]"
                        >
                            <i class="bi bi-send"></i>
                            Kirim proposal
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</main>


</x-layouts.freelancer>
