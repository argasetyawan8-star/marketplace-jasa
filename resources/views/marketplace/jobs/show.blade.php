<x-layouts.marketplace title="{{ $job->title }} - JASAIN">

    @php
        $clientName = $job->client?->name ?? 'Client';

        $clientAvatar = $job->client?->profile?->avatar
            ? asset('storage/' . $job->client->profile->avatar)
            : null;

        $clientInitial = strtoupper(
            mb_substr($clientName, 0, 1)
        );

        $budget = 'Negosiasi';

        if ($job->budget_min !== null && $job->budget_max !== null) {
            $budget =
                'Rp ' . number_format((float) $job->budget_min, 0, ',', '.')
                . ' - Rp ' . number_format((float) $job->budget_max, 0, ',', '.');
        } elseif ($job->budget_min !== null) {
            $budget =
                'Rp ' . number_format((float) $job->budget_min, 0, ',', '.');
        } elseif ($job->budget_max !== null) {
            $budget =
                'Rp ' . number_format((float) $job->budget_max, 0, ',', '.');
        }
    @endphp

    <main class="min-h-screen bg-[#F8FCF9] pt-[88px] sm:pt-[96px]">

        {{-- =========================================================
             FLASH
        ========================================================== --}}
        @if(session('success') || session('error'))

            <section class="mx-auto max-w-7xl px-4 pt-5 sm:px-6 lg:px-8">

                @if(session('success'))

                    <div class="flex items-start gap-3 rounded-lg border border-[#CDE8D7] bg-white px-4 py-3 text-sm text-[#355248]">
                        <i class="bi bi-check-circle-fill mt-0.5 text-[#1E9E5A]"></i>
                        <span>{{ session('success') }}</span>
                    </div>

                @endif

                @if(session('error'))

                    <div class="flex items-start gap-3 rounded-lg border border-red-100 bg-white px-4 py-3 text-sm text-red-600">
                        <i class="bi bi-exclamation-circle-fill mt-0.5"></i>
                        <span>{{ session('error') }}</span>
                    </div>

                @endif

            </section>

        @endif


        <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            {{-- =====================================================
                 BREADCRUMB
            ====================================================== --}}
            <div class="mb-5 flex flex-wrap items-center gap-2 text-xs text-[#7E8F87]">

                <a
                    href="{{ route('marketplace.jobs.index') }}"
                    class="transition hover:text-[#0F6B3A]"
                >
                    Job Board
                </a>

                <i class="bi bi-chevron-right text-[9px] text-[#A7B1AC]"></i>

                <span class="truncate text-[#53675E]">
                    {{ $job->title }}
                </span>

            </div>


            <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_300px]">


                {{-- =================================================
                     MAIN
                ================================================== --}}
                <div class="min-w-0">


                    {{-- =================================================
                         JOB DETAIL
                    ================================================== --}}
                    <article class="rounded-xl border border-[#DDE7E2] bg-white">

                        <div class="border-b border-[#E8EFEB] px-5 py-6 sm:px-7">

                            <div class="flex flex-wrap items-center gap-2 text-[11px] text-[#83938C]">

                                @if($job->category)
                                    <span>{{ $job->category->name }}</span>
                                @endif

                                @if($job->subcategory)

                                    <span class="text-[#BBC4C0]">
                                        •
                                    </span>

                                    <span>
                                        {{ $job->subcategory->name }}
                                    </span>

                                @endif

                                <span class="text-[#BBC4C0]">
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
                                    {{ $job->proposals->count() }}
                                    orang telah mengajukan penawaran
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


                        {{-- Job information --}}
                        <div class="border-t border-[#E8EFEB] px-5 py-6 sm:px-7">

                            <h2 class="text-sm font-semibold text-[#123128]">
                                Informasi pekerjaan
                            </h2>


                            <div class="mt-5 grid gap-5 sm:grid-cols-2">

                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.06em] text-[#8B9994]">
                                        Budget
                                    </p>

                                    <p class="mt-1.5 text-sm font-semibold text-[#0F6B3A]">
                                        {{ $budget }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.06em] text-[#8B9994]">
                                        Tipe pekerjaan
                                    </p>

                                    <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                        Freelance
                                    </p>
                                </div>


                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.06em] text-[#8B9994]">
                                        Deliver within
                                    </p>

                                    <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                        {{ $job->duration_days ? $job->duration_days . ' hari' : 'Menyesuaikan' }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.06em] text-[#8B9994]">
                                        Deadline
                                    </p>

                                    <p class="mt-1.5 text-sm font-medium text-[#304B40]">
                                        {{ $job->deadline?->format('d M Y') ?? 'Tidak ditentukan' }}
                                    </p>
                                </div>

                            </div>

                        </div>

                    </article>


                    {{-- =================================================
                         CLIENT
                    ================================================== --}}
                    <article class="mt-5 rounded-xl border border-[#DDE7E2] bg-white px-5 py-5 sm:px-7">

                        <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#899790]">
                            Diposting oleh
                        </p>


                        <div class="mt-3 flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A]">

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


                    {{-- =================================================
                         FREELANCERS INTERESTED
                    ================================================== --}}
                    <section class="mt-5 rounded-xl border border-[#DDE7E2] bg-white">

                        <div class="border-b border-[#E8EFEB] px-5 py-5 sm:px-7">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                                Freelancer
                            </p>

                            <h2 class="mt-1 text-lg font-semibold text-[#123128]">
                                Freelancer tertarik dengan {{ $job->title }}
                            </h2>

                            <p class="mt-1.5 text-xs text-[#81918B]">
                                {{ $job->proposals->count() }} orang telah mengajukan penawaran pekerjaan
                            </p>

                        </div>


                        @forelse($job->proposals as $proposal)

                            @php
                                $freelancer =
                                    $proposal->freelancerProfile;

                                $freelancerUser =
                                    $freelancer?->user;

                                $freelancerName =
                                    $proposal->display_name
                                    ?: $freelancerUser?->name
                                    ?: 'Freelancer';

                                $freelancerAvatar =
                                    $freelancer?->avatar
                                    ? asset(
                                        'storage/' . $freelancer->avatar
                                    )
                                    : null;

                                $freelancerInitial =
                                    strtoupper(
                                        mb_substr(
                                            $freelancerName,
                                            0,
                                            1
                                        )
                                    );
                            @endphp


                            <article class="border-b border-[#E8EFEB] px-5 py-6 last:border-b-0 sm:px-7">


                                {{-- Identity --}}
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">


                                    <div class="flex min-w-0 gap-3">

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


                                        <div class="min-w-0">

                                            <div class="flex flex-wrap items-center gap-2">

                                                <h3 class="text-sm font-semibold text-[#123128]">
                                                    {{ $freelancerName }}
                                                </h3>

                                                @if($proposal->status === 'accepted')

                                                    <span class="rounded-md bg-[#EAF7EF] px-2 py-1 text-[10px] font-semibold text-[#0F6B3A]">
                                                        Dipilih
                                                    </span>

                                                @endif

                                            </div>


                                            @if($freelancer?->username)
                                                <p class="mt-0.5 text-[11px] text-[#81918B]">
                                                    {{ '@' . ltrim($freelancer->username, '@') }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>


                                    {{-- Public CTA --}}
                                    <div class="flex shrink-0 gap-2">

                                        @if($freelancer?->username)

                                            <a
                                                href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                                                target="_blank"
                                                class="inline-flex h-9 items-center justify-center gap-1.5 rounded-lg border border-[#DDE7E2] bg-white px-3 text-[11px] font-semibold text-[#53675E] transition hover:bg-[#F8FBF9]"
                                            >
                                                <i class="bi bi-person"></i>
                                                Lihat profil
                                            </a>

                                        @endif


                                        @auth

                                            @if(auth()->user()->role === 'client')

                                                <a
                                                    href="{{ route('client.jobs.chat.start', [$job, $proposal]) }}"
                                                    class="inline-flex h-9 items-center justify-center gap-1.5 rounded-lg bg-[#0F6B3A] px-3 text-[11px] font-semibold text-white transition hover:bg-[#17894D]"
                                                >
                                                    <i class="bi bi-chat-dots"></i>
                                                    Chat
                                                </a>

                                            @elseif(auth()->user()->role === 'freelancer')

                                                @php
                                                    $myProfileId = auth()->user()->freelancerProfile?->id;
                                                @endphp

                                                @if($myProfileId && $myProfileId !== $proposal->freelancer_profile_id)

                                                    <a
                                                        href="{{ route('freelancer.jobs.chat.start', [$job, $proposal]) }}"
                                                        class="inline-flex h-9 items-center justify-center gap-1.5 rounded-lg border border-[#DDE7E2] bg-white px-3 text-[11px] font-semibold text-[#53675E] transition hover:bg-[#F8FBF9]"
                                                    >
                                                        <i class="bi bi-chat-dots"></i>
                                                        Chat
                                                    </a>

                                                @endif

                                            @else

                                                <a
                                                    href="{{ route('login') }}"
                                                    class="inline-flex h-9 items-center justify-center gap-1.5 rounded-lg border border-[#DDE7E2] bg-white px-3 text-[11px] font-semibold text-[#53675E] transition hover:bg-[#F8FBF9]"
                                                >
                                                    <i class="bi bi-chat-dots"></i>
                                                    Chat
                                                </a>

                                            @endif

                                        @endauth

                                    </div>

                                </div>


                                {{-- Why interested --}}
                                <div class="mt-5">

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-[#8A9993]">
                                        Mengapa freelancer tertarik
                                    </p>


                                    <div class="mt-2 text-sm leading-6 text-[#53675E]">

                                        {{ $proposal->relevant_info ?: $proposal->message }}

                                    </div>

                                </div>


                                {{-- Experience --}}
                                @if($proposal->selectedExperience)

                                    <div class="mt-5">

                                        <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-[#8A9993]">
                                            Pengalaman relevan
                                        </p>


                                        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1">

                                            <span class="text-xs font-semibold text-[#304B40]">
                                                {{ $proposal->selectedExperience->position }}
                                            </span>


                                            @if($proposal->selectedExperience->company)

                                                <span class="text-xs text-[#81918B]">
                                                    {{ $proposal->selectedExperience->company }}
                                                </span>

                                            @endif


                                            @if($proposal->selectedExperience->start_year)

                                                <span class="text-[10px] text-[#9AA7A1]">
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


                                    <div class="mt-2 flex flex-wrap gap-2">


                                        @if($proposal->portfolio_url)

                                            <a
                                                href="{{ $proposal->portfolio_url }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex h-9 items-center gap-2 rounded-lg border border-[#DDE7E2] bg-white px-3 text-[11px] font-medium text-[#0F6B3A] transition hover:bg-[#F7FBF8]"
                                            >
                                                <i class="bi bi-link-45deg"></i>
                                                Lihat portofolio
                                                <i class="bi bi-box-arrow-up-right text-[9px]"></i>
                                            </a>

                                        @endif


                                        @foreach($proposal->portfolios as $portfolio)

                                            <a
                                                href="{{ asset('storage/' . $portfolio->file_path) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex h-9 max-w-full items-center gap-2 rounded-lg border border-[#DDE7E2] bg-white px-3 text-[11px] text-[#53675E] transition hover:bg-[#F7FBF8]"
                                            >

                                                @if(
                                                    str_starts_with(
                                                        $portfolio->mime_type ?? '',
                                                        'image/'
                                                    )
                                                )

                                                    <i class="bi bi-image text-[#1E9E5A]"></i>

                                                @else

                                                    <i class="bi bi-file-earmark text-[#1E9E5A]"></i>

                                                @endif

                                                <span class="max-w-[210px] truncate">
                                                    {{ $portfolio->original_name }}
                                                </span>

                                                <i class="bi bi-box-arrow-up-right text-[9px] text-[#9AA7A1]"></i>

                                            </a>

                                        @endforeach


                                        @if(
                                            !$proposal->portfolio_url
                                            && $proposal->portfolios->isEmpty()
                                        )

                                            <span class="text-xs text-[#96A39E]">
                                                Belum ada portofolio yang dilampirkan.
                                            </span>

                                        @endif

                                    </div>

                                </div>


                            </article>

                        @empty

                            <div class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg bg-[#F1F6F3] text-[#81958A]">
                                    <i class="bi bi-people"></i>
                                </div>

                                <h3 class="mt-4 text-sm font-semibold text-[#123128]">
                                    Belum ada freelancer yang mengajukan
                                </h3>

                                <p class="mt-1.5 text-xs text-[#81918B]">
                                    Freelancer yang tertarik akan muncul di sini.
                                </p>

                            </div>

                        @endforelse

                    </section>


                    {{-- Security --}}
                    <div class="mt-5 rounded-xl border border-[#DDE7E2] bg-white px-5 py-5 sm:px-7">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#EDF8F1] text-[#1E9E5A]">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>

                                <h3 class="text-sm font-semibold text-[#123128]">
                                    Transaksi aman melalui JASAIN
                                </h3>

                                <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                    Komunikasi dan transaksi dilakukan melalui platform JASAIN.
                                    Jangan melakukan pembayaran di luar sistem.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     SIDEBAR
                ================================================== --}}
                <aside class="lg:sticky lg:top-[95px] lg:self-start">

                    <div class="rounded-xl border border-[#DDE7E2] bg-white">

                        <div class="px-5 py-5">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-[#899790]">
                                Ringkasan pekerjaan
                            </p>


                            <div class="mt-4 space-y-4">

                                <div>

                                    <p class="text-[10px] text-[#8A9993]">
                                        Budget
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#0F6B3A]">
                                        {{ $budget }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-[10px] text-[#8A9993]">
                                        Tipe
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-[#304B40]">
                                        Freelance
                                    </p>

                                </div>


                                <div>

                                    <p class="text-[10px] text-[#8A9993]">
                                        Freelancer tertarik
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#304B40]">
                                        {{ $job->proposals->count() }} orang
                                    </p>

                                </div>


                                @if($job->duration_days)

                                    <div>

                                        <p class="text-[10px] text-[#8A9993]">
                                            Deliver within
                                        </p>

                                        <p class="mt-1 text-sm font-medium text-[#304B40]">
                                            {{ $job->duration_days }} hari
                                        </p>

                                    </div>

                                @endif


                                @if($job->deadline)

                                    <div>

                                        <p class="text-[10px] text-[#8A9993]">
                                            Deadline
                                        </p>

                                        <p class="mt-1 text-sm font-medium text-[#304B40]">
                                            {{ $job->deadline->format('d M Y') }}
                                        </p>

                                    </div>

                                @endif

                            </div>

                        </div>


                        {{-- Guest / Freelancer CTA --}}
                        <div class="border-t border-[#E8EFEB] px-5 py-5">

                            @guest

                                <a
                                    href="{{ route('login') }}"
                                    class="flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-[#0F6B3A] text-xs font-semibold text-white transition hover:bg-[#17894D]"
                                >
                                    Masuk untuk melamar
                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            @elseauth

                                @if(auth()->user()->role === 'freelancer')

                                    @php
                                        $myProposal = $job->proposals
                                            ->firstWhere(
                                                'freelancerProfile.user_id',
                                                auth()->id()
                                            );
                                    @endphp

                                    @if($myProposal)

                                        <div class="rounded-lg border border-[#CDE8D7] bg-[#F4FBF6] px-4 py-3">

                                            <div class="flex items-center gap-2">

                                                <i class="bi bi-check-circle-fill text-[#1E9E5A]"></i>

                                                <div>

                                                    <p class="text-xs font-semibold text-[#123128]">
                                                        Kamu sudah mengajukan
                                                    </p>

                                                    <p class="mt-0.5 text-[10px] text-[#81918B]">
                                                        Tawaranmu sudah diterima sistem.
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    @else

                                        <a
                                            href="{{ route('freelancer.jobs.show', $job) }}"
                                            class="flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-[#0F6B3A] text-xs font-semibold text-white transition hover:bg-[#17894D]"
                                        >
                                            Tawarkan pekerjaan
                                            <i class="bi bi-arrow-right"></i>
                                        </a>

                                    @endif

                                @endif

                            @endguest

                        </div>

                    </div>


                    <a
                        href="{{ route('marketplace.jobs.index') }}"
                        class="mt-4 flex h-10 items-center justify-center gap-2 rounded-lg border border-[#DDE7E2] bg-white text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke Job Board
                    </a>

                </aside>

            </div>

        </section>

    </main>

</x-layouts.marketplace>