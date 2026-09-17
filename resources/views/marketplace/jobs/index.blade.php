<x-layouts.marketplace title="Job Board - JASAIN">

    @php
        $query = request('q');
        $selectedCategory = request('category');

        $formatBudget = function ($job) {
            if ($job->budget_min !== null && $job->budget_max !== null) {
                return 'Rp ' . number_format((float) $job->budget_min, 0, ',', '.') .
                    ' - Rp ' . number_format((float) $job->budget_max, 0, ',', '.');
            }

            if ($job->budget_min !== null) {
                return 'Rp ' . number_format((float) $job->budget_min, 0, ',', '.');
            }

            if ($job->budget_max !== null) {
                return 'Rp ' . number_format((float) $job->budget_max, 0, ',', '.');
            }

            return 'Negosiasi';
        };
    @endphp

    <main class="min-h-screen bg-[#F8FCF9] pt-[88px] sm:pt-[96px]">

        {{-- Header --}}
        <section class="border-b border-[#E5ECE8] bg-white">
            <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>
                        <div class="flex items-center gap-2 text-xs text-[#7A8A83]">
                            <span>JASAIN</span>
                            <i class="bi bi-chevron-right text-[9px]"></i>
                            <span class="text-[#123128]">Job Board</span>
                        </div>

                        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                            Semua pekerjaan
                        </h1>

                        <p class="mt-1.5 max-w-2xl text-sm leading-6 text-[#71837B]">
                            Temukan pekerjaan dari client dan tawarkan keahlianmu melalui JASAIN.
                        </p>
                    </div>

                    @auth
                        @if(auth()->user()->role === 'client')
                            <a
                                href="{{ route('client.jobs.create') }}"
                                class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#0F6B3A] px-4 text-sm font-semibold text-white transition hover:bg-[#17894D]"
                            >
                                <i class="bi bi-plus-lg"></i>
                                Post a Job
                            </a>
                        @endif
                    @endauth

                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            {{-- Search & Filter --}}
            <form
                method="GET"
                action="{{ route('marketplace.jobs.index') }}"
                class="rounded-xl border border-[#E1EAE5] bg-white p-4 sm:p-5"
            >
                <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_220px_auto]">

                    {{-- Search --}}
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-[#355248]">
                            Cari pekerjaan
                        </label>

                        <div class="relative">
                            <i class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#94A39D]"></i>

                            <input
                                type="text"
                                name="q"
                                value="{{ $query }}"
                                placeholder="Cari pekerjaan berdasarkan judul atau deskripsi..."
                                class="h-10 w-full rounded-lg border border-[#DCE6E1] bg-white pl-9 pr-3 text-sm text-[#233D33] outline-none transition placeholder:text-[#9AA8A2] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                            >
                        </div>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-[#355248]">
                            Job category
                        </label>

                        <select
                            name="category"
                            class="h-10 w-full rounded-lg border border-[#DCE6E1] bg-white px-3 text-sm text-[#355248] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                        >
                            <option value="">Semua kategori</option>

                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->slug }}"
                                    @selected($selectedCategory === $category->slug)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Submit --}}
                    <div class="flex items-end">
                        <button
                            type="submit"
                            class="h-10 w-full rounded-lg bg-[#F0F7F3] px-5 text-sm font-semibold text-[#0F6B3A] transition hover:bg-[#E3F1E9] lg:w-auto"
                        >
                            Cari
                        </button>
                    </div>

                </div>
            </form>

            {{-- Result Count --}}
            <div class="mt-6 flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-[#123128]">
                        All jobs
                    </h2>

                    <p class="mt-0.5 text-xs text-[#81918B]">
                        {{ $jobs->total() }} pekerjaan tersedia
                    </p>
                </div>
            </div>

            {{-- Desktop Table Header --}}
            <div class="mt-4 hidden overflow-hidden rounded-t-xl border border-[#DDE7E2] bg-white lg:block">
                <div class="grid grid-cols-[minmax(300px,1.8fr)_1.1fr_0.75fr_0.9fr_1fr_1fr_92px] items-center border-b border-[#E5ECE8] bg-[#F8FBF9] px-5 py-3 text-[11px] font-semibold uppercase tracking-[0.04em] text-[#75867E]">
                    <div>Jobs</div>
                    <div>Kategori</div>
                    <div>Type</div>
                    <div>Budget</div>
                    <div>Posted</div>
                    <div>Deliver Within</div>
                    <div></div>
                </div>

                @forelse($jobs as $job)
                    <a
                        href="{{ route('marketplace.jobs.show', $job) }}"
                        class="group grid grid-cols-[minmax(300px,1.8fr)_1.1fr_0.75fr_0.9fr_1fr_1fr_92px] items-center border-b border-[#E8EFEB] px-5 py-4 transition last:border-b-0 hover:bg-[#FBFDFC]"
                    >
                        {{-- Job --}}
                        <div class="min-w-0 pr-5">
                            <h3 class="truncate text-sm font-semibold text-[#1E342C] transition group-hover:text-[#0F6B3A]">
                                {{ $job->title }}
                            </h3>

                            <div class="mt-1.5 flex items-center gap-2 text-[11px] text-[#81918B]">
                                <span>
                                    {{ $job->proposals_count }} applied
                                </span>

                                @if($job->location)
                                    <span class="text-[#B4BDB8]">•</span>
                                    <span class="truncate">
                                        {{ $job->location }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="pr-4 text-xs text-[#536A60]">
                            {{ $job->category?->name ?? 'Lainnya' }}
                        </div>

                        {{-- Type --}}
                        <div class="pr-4">
                            <span class="inline-flex rounded-md bg-[#F1F6F3] px-2 py-1 text-[11px] font-medium text-[#355F4E]">
                                Freelance
                            </span>
                        </div>

                        {{-- Budget --}}
                        <div class="pr-4 text-xs font-medium text-[#253F35]">
                            {{ $formatBudget($job) }}
                        </div>

                        {{-- Posted --}}
                        <div class="pr-4 text-xs text-[#71837B]">
                            {{ optional($job->published_at)->format('d/m/Y H:i') ?? '-' }}
                        </div>

                        {{-- Deliver Within --}}
                        <div class="pr-4 text-xs text-[#71837B]">
                            @if($job->deadline)
                                {{ $job->deadline->format('d/m/Y') }}
                            @elseif($job->duration_days)
                                {{ $job->duration_days }} hari
                            @else
                                -
                            @endif
                        </div>

                        {{-- Action --}}
                        <div class="flex justify-end">
                            <span class="inline-flex h-8 min-w-[68px] items-center justify-center rounded-md border border-[#CFE1D7] bg-white px-3 text-xs font-semibold text-[#0F6B3A] transition group-hover:border-[#1E9E5A] group-hover:bg-[#F0F8F3]">
                                Apply
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg bg-[#F1F6F3] text-[#80958A]">
                            <i class="bi bi-search"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-semibold text-[#123128]">
                            Belum ada pekerjaan
                        </h3>

                        <p class="mt-1.5 text-xs text-[#81918B]">
                            Coba ubah kata kunci atau kategori pencarian.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Mobile List --}}
            <div class="mt-4 space-y-3 lg:hidden">
                @forelse($jobs as $job)
                    <a
                        href="{{ route('marketplace.jobs.show', $job) }}"
                        class="block rounded-xl border border-[#DDE7E2] bg-white p-4 transition hover:border-[#C8DDD1] hover:bg-[#FBFDFC]"
                    >
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="text-sm font-semibold leading-5 text-[#1E342C]">
                                    {{ $job->title }}
                                </h3>

                                <div class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] text-[#81918B]">
                                    <span>{{ $job->category?->name ?? 'Lainnya' }}</span>
                                    <span class="text-[#C0C9C4]">•</span>
                                    <span>Freelance</span>
                                </div>
                            </div>

                            <i class="bi bi-chevron-right shrink-0 pt-0.5 text-xs text-[#9AA8A2]"></i>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3 border-t border-[#EDF2EF] pt-3">
                            <div>
                                <p class="text-[10px] uppercase tracking-[0.04em] text-[#8A9993]">
                                    Budget
                                </p>
                                <p class="mt-1 text-xs font-semibold text-[#253F35]">
                                    {{ $formatBudget($job) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] uppercase tracking-[0.04em] text-[#8A9993]">
                                    Posted
                                </p>
                                <p class="mt-1 text-xs text-[#71837B]">
                                    {{ optional($job->published_at)->format('d/m/Y') ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] uppercase tracking-[0.04em] text-[#8A9993]">
                                    Deliver within
                                </p>
                                <p class="mt-1 text-xs text-[#71837B]">
                                    @if($job->deadline)
                                        {{ $job->deadline->format('d/m/Y') }}
                                    @elseif($job->duration_days)
                                        {{ $job->duration_days }} hari
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] uppercase tracking-[0.04em] text-[#8A9993]">
                                    Applied
                                </p>
                                <p class="mt-1 text-xs font-medium text-[#355F4E]">
                                    {{ $job->proposals_count }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <span class="inline-flex h-9 w-full items-center justify-center rounded-md border border-[#CFE1D7] bg-white text-xs font-semibold text-[#0F6B3A]">
                                Apply
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="rounded-xl border border-[#DDE7E2] bg-white px-6 py-16 text-center">
                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg bg-[#F1F6F3] text-[#80958A]">
                            <i class="bi bi-search"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-semibold text-[#123128]">
                            Belum ada pekerjaan
                        </h3>

                        <p class="mt-1.5 text-xs text-[#81918B]">
                            Coba ubah kata kunci atau kategori pencarian.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($jobs->hasPages())
                <div class="mt-5">
                    {{ $jobs->links() }}
                </div>
            @endif

        </section>

        {{-- Bottom Feedback --}}
        <section class="mx-auto max-w-7xl px-4 pb-10 sm:px-6 lg:px-8">
            <div class="border-t border-[#E5ECE8] pt-7 text-center">
                <p class="text-xs text-[#899790]">
                    Ada saran untuk meningkatkan Job Board JASAIN?
                    <a href="#" class="font-medium text-[#0F6B3A] hover:underline">
                        Beri masukan
                    </a>
                </p>
            </div>
        </section>

    </main>

</x-layouts.marketplace>