<x-layouts.marketplace title="Job Board - JASAIN">

    @php
        $query = request('q');
        $selectedCategory = request('category');
    @endphp

    <main class="bg-[#F8FCF9] pt-[92px] sm:pt-[100px]">

        <section class="border-b border-[#E3ECE7] bg-white">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <p class="text-[10px] font-semibold uppercase tracking-[.16em] text-[#1E9E5A]">
                    Job Board
                </p>
                <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                            Temukan pekerjaan yang sesuai keahlianmu
                        </h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-[#71837B]">
                            Lihat kebutuhan dari client dan kirim proposal untuk pekerjaan yang kamu inginkan.
                        </p>
                    </div>

                    @auth
                        @if(auth()->user()->role === 'client')
                            <a href="{{ route('client.jobs.create') }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-4 text-xs font-semibold text-white hover:bg-[#1E9E5A]">
                                <i class="bi bi-plus-lg"></i>
                                Buat Job
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-[220px_minmax(0,1fr)]">

                <aside class="rounded-2xl border border-[#E0EBE4] bg-white p-4">
                    <form method="GET" action="{{ route('marketplace.jobs.index') }}" class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-[#123128]">Cari job</label>
                            <input type="text" name="q" value="{{ $query }}" placeholder="Contoh: desain logo" class="mt-2 h-10 w-full rounded-xl border border-[#DDE7E1] px-3 text-xs text-[#355248] outline-none focus:border-[#1E9E5A]">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-[#123128]">Kategori</label>
                            <select name="category" class="mt-2 h-10 w-full rounded-xl border border-[#DDE7E1] bg-white px-3 text-xs text-[#355248] outline-none focus:border-[#1E9E5A]">
                                <option value="">Semua kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="h-10 w-full rounded-xl bg-[#F2F8F4] text-xs font-semibold text-[#0F6B3A] hover:bg-[#EAF7EF]">
                            Terapkan filter
                        </button>
                    </form>
                </aside>

                <div>
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-xs text-[#81918B]">
                            {{ $jobs->total() }} job tersedia
                        </p>
                    </div>

                    <div class="mt-4 divide-y divide-[#E8EFEB] rounded-2xl border border-[#E0EBE4] bg-white">
                        @forelse($jobs as $job)
                            <a href="{{ route('marketplace.jobs.show', $job) }}" class="block p-5 transition hover:bg-[#FBFDFC] sm:p-6">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 text-[10px] text-[#8A9B94]">
                                            @if($job->category)
                                                <span>{{ $job->category->name }}</span>
                                            @endif
                                            @if($job->subcategory)
                                                <span>•</span>
                                                <span>{{ $job->subcategory->name }}</span>
                                            @endif
                                            <span>•</span>
                                            <span>{{ optional($job->published_at)->diffForHumans() }}</span>
                                        </div>

                                        <h2 class="mt-1.5 text-base font-semibold text-[#123128] hover:text-[#0F6B3A]">
                                            {{ $job->title }}
                                        </h2>

                                        <p class="mt-2 line-clamp-2 text-sm leading-6 text-[#667D73]">
                                            {{ $job->description }}
                                        </p>

                                        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 text-[10px] text-[#81918B]">
                                            @if($job->budget_min !== null || $job->budget_max !== null)
                                                <span class="inline-flex items-center gap-1.5">
                                                    <i class="bi bi-wallet2"></i>
                                                    Rp {{ number_format((float) ($job->budget_min ?? $job->budget_max), 0, ',', '.') }}
                                                    @if($job->budget_min !== null && $job->budget_max !== null)
                                                        - Rp {{ number_format((float) $job->budget_max, 0, ',', '.') }}
                                                    @endif
                                                </span>
                                            @endif

                                            @if($job->duration_days)
                                                <span class="inline-flex items-center gap-1.5">
                                                    <i class="bi bi-clock"></i>
                                                    {{ $job->duration_days }} hari
                                                </span>
                                            @endif

                                            @if($job->deadline)
                                                <span class="inline-flex items-center gap-1.5">
                                                    <i class="bi bi-calendar-event"></i>
                                                    {{ $job->deadline->format('d M Y') }}
                                                </span>
                                            @endif

                                            <span class="inline-flex items-center gap-1.5">
                                                <i class="bi bi-people"></i>
                                                {{ $job->proposals_count }} proposal
                                            </span>
                                        </div>
                                    </div>

                                    <div class="hidden shrink-0 sm:flex sm:items-center">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#F2F8F4] text-[#0F6B3A]">
                                            <i class="bi bi-chevron-right text-[11px]"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="px-6 py-16 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F2F7F4] text-[#80958A]">
                                    <i class="bi bi-search"></i>
                                </div>
                                <h3 class="mt-4 text-sm font-semibold text-[#123128]">Belum ada job</h3>
                                <p class="mt-1.5 text-xs text-[#81918B]">Coba ubah kata kunci atau kategori.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-5">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.marketplace>
