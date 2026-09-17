<x-layouts.client>

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
    @endphp

    <main class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <section class="border-b border-[#E5ECE8] bg-white">

            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                <a
                    href="{{ route('client.jobs.index') }}"
                    class="inline-flex items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Job Saya
                </a>

                @if(session('success'))

                    <div class="mt-4 flex items-start gap-3 rounded-lg border border-[#CDE8D7] bg-white px-4 py-3 text-sm text-[#355248]">

                        <i class="bi bi-check-circle-fill mt-0.5 text-[#1E9E5A]"></i>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                @endif

                @if(session('error'))

                    <div class="mt-4 flex items-start gap-3 rounded-lg border border-red-100 bg-white px-4 py-3 text-sm text-red-600">

                        <i class="bi bi-exclamation-circle-fill mt-0.5"></i>

                        <span>
                            {{ session('error') }}
                        </span>

                    </div>

                @endif

            </div>

        </section>


        {{-- =========================================================
             CONTENT
        ========================================================== --}}
        <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_300px]">


                {{-- =================================================
                     MAIN CONTENT
                ================================================== --}}
                <div class="min-w-0">


                    {{-- =============================================
                         JOB DETAIL
                    ============================================== --}}
                    <article class="rounded-xl border border-[#DDE7E2] bg-white">

                        {{-- Heading --}}
                        <div class="border-b border-[#E8EFEB] px-5 py-6 sm:px-7">

                            <div class="flex flex-wrap items-center gap-2">

                                <span class="inline-flex items-center rounded-md bg-[#F0F7F3] px-2.5 py-1 text-[11px] font-semibold text-[#0F6B3A]">
                                    {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                                </span>

                                @if($job->category)

                                    <span class="text-xs text-[#71837B]">
                                        {{ $job->category->name }}
                                    </span>

                                @endif

                                @if($job->subcategory)

                                    <span class="text-xs text-[#B6C0BB]">
                                        •
                                    </span>

                                    <span class="text-xs text-[#71837B]">
                                        {{ $job->subcategory->name }}
                                    </span>

                                @endif

                            </div>


                            <h1 class="mt-3 text-2xl font-semibold leading-tight tracking-tight text-[#123128] sm:text-3xl">
                                {{ $job->title }}
                            </h1>


                            <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#81918B]">

                                <span class="inline-flex items-center gap-1.5">
                                    <i class="bi bi-calendar3 text-[#1E9E5A]"></i>

                                    @if($job->published_at)

                                        Dipublikasikan
                                        {{ $job->published_at->format('d M Y') }}

                                    @else

                                        Draft

                                    @endif
                                </span>


                                <span class="inline-flex items-center gap-1.5">
                                    <i class="bi bi-people text-[#1E9E5A]"></i>
                                    {{ $job->proposals->count() }} freelancer tertarik
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


                            <div class="mt-5 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">


                                <div>

                                    <p class="text-[10px] uppercase tracking-[0.05em] text-[#8A9993]">
                                        Budget
                                    </p>

                                    <p class="mt-1.5 text-sm font-semibold text-[#0F6B3A]">
                                        {{ $budget }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-[10px] uppercase tracking-[0.05em] text-[#8A9993]">
                                        Durasi
                                    </p>

                                    <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                        {{ $job->duration_days ? $job->duration_days . ' hari' : '-' }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-[10px] uppercase tracking-[0.05em] text-[#8A9993]">
                                        Deadline
                                    </p>

                                    <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                        {{ $job->deadline?->format('d M Y') ?? '-' }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-[10px] uppercase tracking-[0.05em] text-[#8A9993]">
                                        Freelancer tertarik
                                    </p>

                                    <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                        {{ $job->proposals->count() }} orang
                                    </p>

                                </div>

                            </div>

                        </div>

                    </article>


                    {{-- =============================================
                         PROPOSALS
                    ============================================== --}}
                    <section class="mt-5 rounded-xl border border-[#DDE7E2] bg-white">


                        {{-- Section heading --}}
                        <div class="border-b border-[#E8EFEB] px-5 py-5 sm:px-7">

                            <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">

                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                                        Freelancer
                                    </p>

                                    <h2 class="mt-1 text-lg font-semibold text-[#123128]">
                                        Tawaran yang masuk
                                    </h2>

                                </div>


                                <p class="text-xs text-[#81918B]">
                                    {{ $job->proposals->count() }} tawaran
                                </p>

                            </div>

                        </div>


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


                            <article class="border-b border-[#E8EFEB] px-5 py-6 last:border-b-0 sm:px-7">


                                {{-- Freelancer header --}}
                                <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">


                                    <div class="flex min-w-0 gap-3">


                                        {{-- Avatar --}}
                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A]">

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

                                                <h3 class="truncate text-sm font-semibold text-[#123128]">
                                                    {{ $freelancerName }}
                                                </h3>


                                                @if($proposal->status === 'accepted')

                                                    <span class="rounded-md bg-[#EAF7EF] px-2 py-1 text-[10px] font-semibold text-[#0F6B3A]">
                                                        Dipilih
                                                    </span>

                                                @elseif($proposal->status === 'rejected')

                                                    <span class="rounded-md bg-[#F8ECEC] px-2 py-1 text-[10px] font-semibold text-[#A34D4D]">
                                                        Ditolak
                                                    </span>

                                                @else

                                                    <span class="rounded-md bg-[#F3F6F4] px-2 py-1 text-[10px] font-semibold text-[#687B72]">
                                                        Menunggu
                                                    </span>

                                                @endif

                                            </div>


                                            <p class="mt-0.5 text-[11px] text-[#81918B]">
                                                {{ $freelancer?->username ? '@' . $freelancer->username : 'Freelancer JASAIN' }}
                                            </p>

                                        </div>

                                    </div>


                                    {{-- Price + duration --}}
                                    <div class="grid grid-cols-2 gap-6 xl:min-w-[260px]">

                                        <div>

                                            <p class="text-[10px] uppercase tracking-[0.05em] text-[#8A9993]">
                                                Harga
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-[#0F6B3A]">
                                                Rp {{ number_format((float) $proposal->price, 0, ',', '.') }}
                                            </p>

                                        </div>


                                        <div>

                                            <p class="text-[10px] uppercase tracking-[0.05em] text-[#8A9993]">
                                                Durasi
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-[#304B40]">
                                                {{ $proposal->delivery_days }} hari
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                {{-- Relevant information --}}
                                <div class="mt-5">

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-[#8A9993]">
                                        Informasi yang ditawarkan
                                    </p>


                                    <div class="mt-2 rounded-lg bg-[#F8FBF9] px-4 py-4 text-sm leading-6 text-[#53675E]">
                                        {{ $proposal->relevant_info ?: $proposal->message }}
                                    </div>

                                </div>


                                {{-- Experience --}}
                                @if($proposal->selectedExperience)

                                    <div class="mt-5">

                                        <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-[#8A9993]">
                                            Pengalaman relevan
                                        </p>


                                        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 rounded-lg border border-[#E5ECE8] bg-white px-4 py-3">

                                            <span class="text-sm font-semibold text-[#304B40]">
                                                {{ $proposal->selectedExperience->position }}
                                            </span>


                                            @if($proposal->selectedExperience->company)

                                                <span class="text-xs text-[#87958F]">
                                                    {{ $proposal->selectedExperience->company }}
                                                </span>

                                            @endif


                                            @if($proposal->selectedExperience->start_year)

                                                <span class="text-[11px] text-[#9AA7A1]">
                                                    {{ $proposal->selectedExperience->start_year }}
                                                    -
                                                    {{ $proposal->selectedExperience->end_year ?: 'Sekarang' }}
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                @endif


                                {{-- Portfolio --}}
                                <div class="mt-5">

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-[#8A9993]">
                                        Portofolio
                                    </p>


                                    <div class="mt-2 grid gap-2 sm:grid-cols-2">


                                        @if($proposal->portfolio_url)

                                            <a
                                                href="{{ $proposal->portfolio_url }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="flex items-center gap-2 rounded-lg border border-[#E5ECE8] px-3.5 py-3 text-xs font-medium text-[#0F6B3A] transition hover:bg-[#F7FBF8]"
                                            >

                                                <i class="bi bi-link-45deg text-base"></i>

                                                <span class="min-w-0 flex-1 truncate">
                                                    Lihat portfolio
                                                </span>

                                                <i class="bi bi-box-arrow-up-right text-[10px] text-[#9AA7A1]"></i>

                                            </a>

                                        @endif


                                        @foreach($proposal->portfolios as $portfolio)

                                            <a
                                                href="{{ asset('storage/' . $portfolio->file_path) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="flex items-center gap-2 rounded-lg border border-[#E5ECE8] px-3.5 py-3 text-xs text-[#4F675C] transition hover:bg-[#F7FBF8]"
                                            >

                                                @if(str_starts_with($portfolio->mime_type ?? '', 'image/'))

                                                    <i class="bi bi-image text-[#1E9E5A]"></i>

                                                @else

                                                    <i class="bi bi-file-earmark text-[#1E9E5A]"></i>

                                                @endif


                                                <span class="min-w-0 flex-1 truncate">
                                                    {{ $portfolio->original_name }}
                                                </span>


                                                <i class="bi bi-box-arrow-up-right text-[10px] text-[#9AA7A1]"></i>

                                            </a>

                                        @endforeach


                                        @if(!$proposal->portfolio_url && $proposal->portfolios->isEmpty())

                                            <div class="rounded-lg bg-[#F8FBF9] px-4 py-3 text-xs text-[#96A39E] sm:col-span-2">
                                                Tidak ada portofolio yang dilampirkan.
                                            </div>

                                        @endif

                                    </div>

                                </div>


                                {{-- Phone --}}
                                <div class="mt-5 rounded-lg border border-[#E7ECE9] bg-[#FBFDFC] px-4 py-3">

                                    <div class="flex items-center gap-2">

                                        <i class="bi bi-telephone text-[#1E9E5A]"></i>

                                        <div>

                                            <p class="text-[10px] uppercase tracking-[0.06em] text-[#8A9993]">
                                                Nomor telepon
                                            </p>

                                            <p class="mt-1 text-xs font-medium text-[#304B40]">
                                                {{ $proposal->phone ?: '-' }}
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                {{-- Actions --}}
                                @if($proposal->status === 'pending' && $job->status === 'open')

                                    <div class="mt-5 flex flex-col gap-2 border-t border-[#EDF2EF] pt-5 sm:flex-row sm:items-center sm:justify-between">


                                        {{-- Profile --}}
                                        @if($freelancer?->username)

                                            <a
                                                href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                                                target="_blank"
                                                class="inline-flex h-10 items-center justify-center gap-2 rounded-lg text-xs font-semibold text-[#0F6B3A] transition hover:bg-[#F3F9F5] sm:w-auto"
                                            >
                                                <i class="bi bi-person"></i>
                                                Lihat profil freelancer
                                            </a>

                                        @endif


                                        <div class="flex flex-col gap-2 sm:flex-row">

                                            <a
                                                href="{{ route('client.jobs.chat.start', [$job, $proposal]) }}"
                                                class="inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-[#DDE7E2] bg-white px-4 text-xs font-semibold text-[#53675E] transition hover:bg-[#F8FBF9]"
                                            >
                                                <i class="bi bi-chat-dots"></i>
                                                Chat
                                            </a>

                                            {{-- Tolak --}}
                                            <form
                                                method="POST"
                                                action="{{ route('client.jobs.proposals.reject', [$job, $proposal]) }}"
                                            >
                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="flex h-10 w-full items-center justify-center gap-2 rounded-lg border border-[#E3D5D5] bg-white px-4 text-xs font-semibold text-[#A34D4D] transition hover:bg-[#FCF7F7] sm:w-auto"
                                                >
                                                    <i class="bi bi-x-lg"></i>
                                                    Tolak
                                                </button>
                                            </form>

                                            {{-- Pilih --}}
                                            <form
                                                method="POST"
                                                action="{{ route('client.jobs.proposals.accept', [$job, $proposal]) }}"
                                            >
                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-[#0F6B3A] px-5 text-xs font-semibold text-white transition hover:bg-[#17894D] sm:w-auto"
                                                >
                                                    <i class="bi bi-check-lg"></i>
                                                    Pilih freelancer
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                                @elseif($proposal->status === 'accepted')

                                    <div class="mt-5 rounded-lg border border-[#CDE8D7] bg-[#F4FBF6] px-4 py-4">

                                        <div class="flex items-start gap-3">

                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#E3F4E9] text-[#0F6B3A]">
                                                <i class="bi bi-check-lg"></i>
                                            </div>


                                            <div>

                                                <p class="text-sm font-semibold text-[#123128]">
                                                    Freelancer ini sudah dipilih
                                                </p>

                                                <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                                    Selanjutnya client dan freelancer dapat menyelesaikan
                                                    detail pekerjaan sebelum dibuatkan Order JASAIN.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            </article>

                        @empty

                            <div class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-[#F1F6F3] text-[#80958A]">
                                    <i class="bi bi-people text-lg"></i>
                                </div>


                                <h3 class="mt-4 text-sm font-semibold text-[#123128]">
                                    Belum ada freelancer yang mengajukan
                                </h3>


                                <p class="mx-auto mt-1.5 max-w-md text-xs leading-5 text-[#81918B]">
                                    Freelancer yang tertarik dengan pekerjaan ini akan
                                    muncul di bagian ini setelah mengirimkan tawaran.
                                </p>

                            </div>

                        @endforelse

                    </section>


                </div>


                {{-- =================================================
                     SIDEBAR
                ================================================== --}}
                <aside class="lg:sticky lg:top-[90px] lg:self-start">


                    {{-- Job Summary --}}
                    <div class="rounded-xl border border-[#DDE7E2] bg-white">


                        <div class="px-5 py-5">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-[#899790]">
                                Ringkasan Job
                            </p>


                            <h2 class="mt-2 text-sm font-semibold leading-5 text-[#123128]">
                                {{ $job->title }}
                            </h2>


                            <div class="mt-4 space-y-3 border-t border-[#EDF2EF] pt-4">


                                <div class="flex items-start justify-between gap-4">

                                    <span class="text-xs text-[#81918B]">
                                        Budget
                                    </span>

                                    <span class="max-w-[170px] text-right text-xs font-semibold text-[#304B40]">
                                        {{ $budget }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#81918B]">
                                        Kategori
                                    </span>

                                    <span class="text-right text-xs font-medium text-[#304B40]">
                                        {{ $job->category?->name ?? 'Lainnya' }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#81918B]">
                                        Durasi
                                    </span>

                                    <span class="text-xs font-medium text-[#304B40]">
                                        {{ $job->duration_days ? $job->duration_days . ' hari' : '-' }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#81918B]">
                                        Deadline
                                    </span>

                                    <span class="text-xs font-medium text-[#304B40]">
                                        {{ $job->deadline?->format('d M Y') ?? '-' }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#81918B]">
                                        Freelancer
                                    </span>

                                    <span class="text-xs font-semibold text-[#0F6B3A]">
                                        {{ $job->proposals->count() }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- Job Management --}}
                        <div class="border-t border-[#E8EFEB] px-5 py-5">


                            @if(!in_array($job->status, ['closed', 'cancelled'], true))

                                <div class="space-y-2">


                                    <a
                                        href="{{ route('client.jobs.edit', $job) }}"
                                        class="flex h-10 w-full items-center justify-center gap-2 rounded-lg border border-[#DDE7E2] bg-white text-xs font-semibold text-[#53675E] transition hover:bg-[#F8FBF9]"
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
                                                class="flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-[#0F6B3A] text-xs font-semibold text-white transition hover:bg-[#17894D]"
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
                                                class="flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-[#F7EEE8] text-xs font-semibold text-[#9A5A2D] transition hover:bg-[#F2E4D9]"
                                            >
                                                <i class="bi bi-x-circle"></i>
                                                Tutup Job
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            @endif

                        </div>

                    </div>


                </aside>

            </div>

        </section>

    </main>

</x-layouts.client>