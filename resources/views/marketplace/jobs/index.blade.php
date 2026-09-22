<x-layouts.marketplace title="Job Board - JASAIN">

    <div class="min-h-screen bg-[#F8FBF9]">

        {{-- =========================================================
            HERO
        ========================================================== --}}

        <section class="border-b border-[#E4ECE7] bg-white">

            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8">

                <div class="max-w-3xl">

                    <div
                        class="inline-flex items-center gap-2 rounded-full border border-[#DCE9E2] bg-[#F5FAF7] px-3 py-1.5"
                    >
                        <span class="flex h-5 w-5 items-center justify-center rounded-md bg-[#EAF7EF] text-[#1E9E5A]">
                            <i class="bi bi-briefcase text-[10px]"></i>
                        </span>

                        <span class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#61736B]">
                            JASAIN Job Board
                        </span>
                    </div>

                    <h1
                        class="mt-5 text-3xl font-semibold tracking-[-0.045em] text-[#123128] sm:text-4xl lg:text-[44px]"
                    >
                        Temukan project yang sesuai dengan keahlianmu.
                    </h1>

                    <p class="mt-4 max-w-2xl text-sm leading-6 text-[#708079] sm:text-[15px]">
                        Jelajahi kebutuhan client dari berbagai bidang dan temukan
                        project yang cocok untuk skill, pengalaman, dan cara kerja kamu.
                    </p>

                </div>


                {{-- =================================================
                    SEARCH BAR
                ================================================== --}}

                <form
                    method="GET"
                    action="{{ route('marketplace.jobs.index') }}"
                    class="mt-8"
                >

                    <div
                        class="rounded-2xl border border-[#DCE7E1] bg-white p-2 shadow-[0_10px_30px_rgba(18,49,40,0.05)]"
                    >

                        <div class="flex flex-col gap-2 lg:flex-row">

                            {{-- Search --}}
                            <div class="relative min-w-0 flex-1">

                                <i
                                    class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[14px] text-[#91A19A]"
                                ></i>

                                <input
                                    type="text"
                                    name="q"
                                    value="{{ $search }}"
                                    placeholder="Cari kebutuhan, project, skill, atau kategori..."
                                    class="h-12 w-full rounded-xl border-0 bg-[#F7FAF8] pl-11 pr-4 text-xs text-[#18382E] outline-none ring-0 placeholder:text-[#9DA9A4] focus:bg-white focus:ring-2 focus:ring-[#1E9E5A]/10"
                                >

                            </div>


                            {{-- Category --}}
                            <div class="w-full lg:w-[220px]">

                                <select
                                    name="category"
                                    class="h-12 w-full rounded-xl border-0 bg-[#F7FAF8] px-4 text-xs text-[#52655D] outline-none focus:bg-white focus:ring-2 focus:ring-[#1E9E5A]/10"
                                >

                                    <option value="">
                                        Semua kategori
                                    </option>

                                    @foreach($categories as $category)

                                        <option
                                            value="{{ $category->slug }}"
                                            @selected($categorySlug === $category->slug)
                                        >
                                            {{ $category->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Sort --}}
                            <div class="w-full lg:w-[190px]">

                                <select
                                    name="sort"
                                    class="h-12 w-full rounded-xl border-0 bg-[#F7FAF8] px-4 text-xs text-[#52655D] outline-none focus:bg-white focus:ring-2 focus:ring-[#1E9E5A]/10"
                                >

                                    <option value="relevance" @selected($sort === 'relevance')}>
                                        Paling relevan
                                    </option>

                                    <option value="newest" @selected($sort === 'newest')}>
                                        Paling baru
                                    </option>

                                    <option value="deadline" @selected($sort === 'deadline')}>
                                        Deadline terdekat
                                    </option>

                                    <option value="budget_low" @selected($sort === 'budget_low')}>
                                        Budget terendah
                                    </option>

                                    <option value="budget_high" @selected($sort === 'budget_high')}>
                                        Budget tertinggi
                                    </option>

                                    <option value="proposals" @selected($sort === 'proposals')}>
                                        Paling banyak dilamar
                                    </option>

                                </select>

                            </div>


                            {{-- Button --}}
                            <button
                                type="submit"
                                class="h-12 shrink-0 rounded-xl bg-[#1E9E5A] px-6 text-xs font-semibold text-white transition duration-200 hover:bg-[#0F6B3A] active:scale-[0.99]"
                            >
                                <i class="bi bi-search mr-1.5"></i>
                                Cari project
                            </button>

                        </div>

                    </div>


                    {{-- Budget filter --}}

                    <div class="mt-3 flex flex-col gap-2 sm:flex-row sm:items-center">

                        <div class="flex items-center gap-2">

                            <span class="text-[10px] font-medium text-[#84928C]">
                                Budget:
                            </span>

                            <input
                                type="number"
                                name="min_budget"
                                min="0"
                                step="1000"
                                value="{{ $minBudget }}"
                                placeholder="Minimum"
                                class="h-10 w-full rounded-lg border border-[#DCE7E1] bg-white px-3 text-[11px] text-[#52655D] outline-none placeholder:text-[#A0ADA7] focus:border-[#BBDAC8] focus:ring-2 focus:ring-[#1E9E5A]/10 sm:w-[130px]"
                            >

                            <span class="text-[10px] text-[#A7B1AD]">
                                —
                            </span>

                            <input
                                type="number"
                                name="max_budget"
                                min="0"
                                step="1000"
                                value="{{ $maxBudget }}"
                                placeholder="Maksimum"
                                class="h-10 w-full rounded-lg border border-[#DCE7E1] bg-white px-3 text-[11px] text-[#52655D] outline-none placeholder:text-[#A0ADA7] focus:border-[#BBDAC8] focus:ring-2 focus:ring-[#1E9E5A]/10 sm:w-[130px]"
                            >

                        </div>


                        <a
                            href="{{ route('marketplace.jobs.index') }}"
                            class="inline-flex h-10 items-center justify-center rounded-lg border border-[#DCE7E1] bg-white px-4 text-[10px] font-medium text-[#6B7B74] transition hover:bg-[#F5F9F7] hover:text-[#123128]"
                        >
                            <i class="bi bi-arrow-counterclockwise mr-1.5"></i>
                            Reset filter
                        </a>

                    </div>

                </form>

            </div>

        </section>


        {{-- =========================================================
            MAIN CONTENT
        ========================================================== --}}

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">

            {{-- Header --}}

            <div class="flex flex-col gap-4 border-b border-[#E3EBE6] pb-5 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <p class="text-[9px] font-semibold uppercase tracking-[0.17em] text-[#1E9E5A]">
                        Project terbuka
                    </p>

                    <h2 class="mt-1 text-xl font-semibold tracking-[-0.025em] text-[#123128] sm:text-2xl">
                        Kebutuhan client
                    </h2>

                    <p class="mt-1.5 text-[11px] text-[#899791]">
                        Menampilkan
                        <span class="font-semibold text-[#5D6F67]">
                            {{ number_format($jobs->total(), 0, ',', '.') }}
                        </span>
                        project yang sesuai dengan filter saat ini.
                    </p>

                </div>


                {{-- Posting CTA --}}

                @auth

                    @if(auth()->user()->role === 'client')

                        <a
                            href="{{ route('client.jobs.create') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#CDE3D5] bg-white px-4 py-2.5 text-[11px] font-semibold text-[#166C42] transition hover:bg-[#F2F9F4]"
                        >
                            <i class="bi bi-plus-lg mr-1.5"></i>
                            Posting kebutuhan
                        </a>

                    @endif

                @endauth

            </div>


            {{-- Active filters --}}

            @if($search !== '' || $selectedCategory || $minBudget !== '' || $maxBudget !== '')

                <div class="mt-5 flex flex-wrap items-center gap-2">

                    <span class="mr-1 text-[10px] font-medium text-[#8C9993]">
                        Filter aktif:
                    </span>


                    @if($search !== '')

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-[10px] font-medium text-[#246F49]">

                            <i class="bi bi-search text-[9px]"></i>

                            {{ $search }}

                        </span>

                    @endif


                    @if($selectedCategory)

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F0F5F2] px-3 py-1.5 text-[10px] font-medium text-[#5A6A63]">

                            <i class="bi bi-grid text-[9px]"></i>

                            {{ $selectedCategory->name }}

                        </span>

                    @endif


                    @if($minBudget !== '')

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F0F5F2] px-3 py-1.5 text-[10px] font-medium text-[#5A6A63]">

                            Min Rp {{ number_format($minBudget, 0, ',', '.') }}

                        </span>

                    @endif


                    @if($maxBudget !== '')

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F0F5F2] px-3 py-1.5 text-[10px] font-medium text-[#5A6A63]">

                            Max Rp {{ number_format($maxBudget, 0, ',', '.') }}

                        </span>

                    @endif

                </div>

            @endif


            {{-- =================================================
                JOB LIST
            ================================================== --}}

            @if($jobs->count())

                <div class="mt-6 space-y-3">

                    @foreach($jobs as $job)

                        @php
                            $clientName = $job->client?->name ?? 'Client';
                            $clientInitial = strtoupper(
                                substr($clientName, 0, 1)
                            );

                            $hasBudget = ! is_null($job->budget_min)
                                || ! is_null($job->budget_max);

                            $publishedAt = $job->published_at
                                ?? $job->created_at;

                            $daysToDeadline = null;

                            if ($job->deadline) {
                                $daysToDeadline = today()->diffInDays(
                                    $job->deadline,
                                    false
                                );
                            }
                        @endphp


                        <article
                            class="group rounded-2xl border border-[#DFE8E3] bg-white transition duration-200 hover:-translate-y-0.5 hover:border-[#C9DDD1] hover:shadow-[0_12px_28px_rgba(18,49,40,0.06)]"
                        >

                            <div class="p-5 sm:p-6">

                                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                                    {{-- LEFT --}}

                                    <div class="min-w-0 flex-1">

                                        {{-- Meta --}}

                                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[10px] text-[#8B9892]">

                                            @if($job->category)

                                                <a
                                                    href="{{ route('marketplace.category', $job->category->slug) }}"
                                                    class="font-medium text-[#61736B] hover:text-[#1E9E5A]"
                                                >
                                                    {{ $job->category->name }}
                                                </a>

                                            @endif

                                            @if($job->subcategory)

                                                <span class="text-[#BEC7C2]">
                                                    •
                                                </span>

                                                <span>
                                                    {{ $job->subcategory->name }}
                                                </span>

                                            @endif

                                            <span class="text-[#BEC7C2]">
                                                •
                                            </span>

                                            <span>
                                                Diposting {{ $publishedAt?->diffForHumans() }}
                                            </span>

                                        </div>


                                        {{-- Title --}}

                                        <a
                                            href="{{ route('marketplace.jobs.show', $job) }}"
                                            class="mt-3 block max-w-3xl"
                                        >

                                            <h3
                                                class="text-lg font-semibold leading-6 tracking-[-0.02em] text-[#17382E] transition group-hover:text-[#0F6B3A] sm:text-xl"
                                            >
                                                {{ $job->title }}
                                            </h3>

                                        </a>


                                        {{-- Description --}}

                                        <p class="mt-2 max-w-3xl text-xs leading-5 text-[#788881] sm:text-[13px]">
                                            {{ \Illuminate\Support\Str::limit($job->description, 190) }}
                                        </p>


                                        {{-- Meta details --}}

                                        <div class="mt-4 flex flex-wrap gap-x-5 gap-y-2">

                                            @if($job->location)

                                                <span class="inline-flex items-center gap-1.5 text-[10px] text-[#718079]">

                                                    <i class="bi bi-geo-alt text-[#1E9E5A]"></i>

                                                    {{ $job->location }}

                                                </span>

                                            @endif


                                            @if($job->duration_days)

                                                <span class="inline-flex items-center gap-1.5 text-[10px] text-[#718079]">

                                                    <i class="bi bi-calendar3 text-[#1E9E5A]"></i>

                                                    {{ $job->duration_days }} hari

                                                </span>

                                            @endif


                                            <span class="inline-flex items-center gap-1.5 text-[10px] text-[#718079]">

                                                <i class="bi bi-people text-[#1E9E5A]"></i>

                                                {{ number_format($job->proposals_count, 0, ',', '.') }}
                                                proposal

                                            </span>

                                        </div>


                                        {{-- Deadline --}}

                                        @if($job->deadline)

                                            <div class="mt-4">

                                                @if($daysToDeadline === 0)

                                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[#F0D7C0] bg-[#FFF8F1] px-3 py-1.5 text-[10px] font-medium text-[#A96B20]">
                                                        <i class="bi bi-exclamation-circle"></i>
                                                        Deadline hari ini
                                                    </span>

                                                @elseif($daysToDeadline !== null && $daysToDeadline > 0 && $daysToDeadline <= 7)

                                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[#F0DCC8] bg-[#FFF9F3] px-3 py-1.5 text-[10px] font-medium text-[#A56B2C]">
                                                        <i class="bi bi-clock"></i>
                                                        Deadline {{ $job->deadline->format('d M Y') }}
                                                    </span>

                                                @else

                                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[#E2EAE5] bg-[#F7FAF8] px-3 py-1.5 text-[10px] font-medium text-[#6D7D76]">
                                                        <i class="bi bi-calendar-check"></i>
                                                        Deadline {{ $job->deadline->format('d M Y') }}
                                                    </span>

                                                @endif

                                            </div>

                                        @endif

                                    </div>


                                    {{-- RIGHT --}}

                                    <div class="w-full shrink-0 lg:w-[220px]">

                                        <div class="rounded-xl border border-[#E5ECE8] bg-[#FAFCFB] p-4">

                                            <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#94A09A]">
                                                Budget
                                            </p>


                                            @if($hasBudget)

                                                <div class="mt-1.5">

                                                    @if($job->budget_min && $job->budget_max)

                                                        <p class="text-lg font-semibold tracking-[-0.02em] text-[#123128]">

                                                            Rp {{ number_format($job->budget_min, 0, ',', '.') }}

                                                            <span class="text-xs font-normal text-[#97A39E]">
                                                                –
                                                            </span>

                                                            Rp {{ number_format($job->budget_max, 0, ',', '.') }}

                                                        </p>

                                                    @elseif($job->budget_min)

                                                        <p class="text-lg font-semibold tracking-[-0.02em] text-[#123128]">
                                                            Mulai Rp {{ number_format($job->budget_min, 0, ',', '.') }}
                                                        </p>

                                                    @else

                                                        <p class="text-lg font-semibold tracking-[-0.02em] text-[#123128]">
                                                            Hingga Rp {{ number_format($job->budget_max, 0, ',', '.') }}
                                                        </p>

                                                    @endif

                                                </div>

                                            @else

                                                <p class="mt-1.5 text-sm font-semibold text-[#5E7168]">
                                                    Budget fleksibel
                                                </p>

                                            @endif


                                            <div class="mt-4 border-t border-[#E8EEEA] pt-4">

                                                <div class="flex items-center gap-2.5">

                                                    <div
                                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-[11px] font-semibold text-[#1E9E5A]"
                                                    >
                                                        {{ $clientInitial }}
                                                    </div>

                                                    <div class="min-w-0">

                                                        <p class="truncate text-[11px] font-semibold text-[#3E564C]">
                                                            {{ $clientName }}
                                                        </p>

                                                        <p class="mt-0.5 text-[9px] text-[#9AA6A1]">
                                                            Client
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>


                                            <a
                                                href="{{ route('marketplace.jobs.show', $job) }}"
                                                class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#123128] px-4 py-2.5 text-[10px] font-semibold text-white transition duration-200 hover:bg-[#0F6B3A]"
                                            >
                                                Lihat detail
                                                <i class="bi bi-arrow-right"></i>
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- =================================================
                    PAGINATION
                ================================================== --}}

                @if($jobs->hasPages())

                    <div class="mt-8 rounded-2xl border border-[#DFE8E3] bg-white px-5 py-4">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            <p class="text-[10px] text-[#899690]">

                                Menampilkan

                                <span class="font-semibold text-[#566A60]">
                                    {{ $jobs->firstItem() ?? 0 }}
                                </span>

                                sampai

                                <span class="font-semibold text-[#566A60]">
                                    {{ $jobs->lastItem() ?? 0 }}
                                </span>

                                dari

                                <span class="font-semibold text-[#566A60]">
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

                {{-- =================================================
                    EMPTY STATE
                ================================================== --}}

                <div class="mt-6 rounded-2xl border border-dashed border-[#D5E2DB] bg-white px-6 py-16 text-center sm:px-10">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A]">
                        <i class="bi bi-search text-xl"></i>
                    </div>

                    <h3 class="mt-5 text-base font-semibold text-[#17382E]">
                        Project yang kamu cari belum ditemukan.
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-xs leading-5 text-[#88968F]">
                        Coba ubah kata kunci atau kurangi filter budget dan kategori
                        untuk melihat lebih banyak kebutuhan client.
                    </p>

                    <a
                        href="{{ route('marketplace.jobs.index') }}"
                        class="mt-5 inline-flex items-center rounded-xl bg-[#1E9E5A] px-5 py-2.5 text-[10px] font-semibold text-white transition hover:bg-[#0F6B3A]"
                    >
                        Lihat semua project
                    </a>

                </div>

            @endif


            {{-- =================================================
                FOOTNOTE
            ================================================== --}}

            <div class="mt-8 rounded-2xl border border-[#DDE9E2] bg-[#F2F8F4] px-5 py-4 sm:px-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">
                        <i class="bi bi-shield-check text-[14px]"></i>
                    </div>

                    <div>

                        <p class="text-[11px] font-semibold text-[#2C5143]">
                            Tetap aman saat berkomunikasi dengan client
                        </p>

                        <p class="mt-1 text-[10px] leading-5 text-[#7A8B83]">
                            Gunakan fitur komunikasi dan transaksi JASAIN untuk menjaga
                            proses kerja tetap terorganisir.
                        </p>

                    </div>

                </div>

            </div>

        </main>

    </div>

</x-layouts.marketplace>
