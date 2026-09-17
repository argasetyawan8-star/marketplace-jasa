<x-layouts.marketplace title="{{ $job->title }} - JASAIN">

    <main class="bg-[#F8FCF9] pt-[92px] sm:pt-[100px]">
        <section class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-5 rounded-xl border border-[#CDE8D7] bg-white px-4 py-3 text-sm text-[#355248]">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 rounded-xl border border-red-100 bg-white px-4 py-3 text-sm text-red-600">
                    {{ session('error') }}
                </div>
            @endif

            <a href="{{ route('marketplace.jobs.index') }}" class="inline-flex items-center gap-2 text-xs font-medium text-[#71837B] hover:text-[#0F6B3A]">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Job Board
            </a>

            <div class="mt-5 overflow-hidden rounded-2xl border border-[#E0EBE4] bg-white">
                <div class="border-b border-[#E8EFEB] px-5 py-6 sm:px-7 sm:py-7">
                    <div class="flex flex-wrap items-center gap-2 text-[10px] text-[#8A9B94]">
                        @if($job->category)<span>{{ $job->category->name }}</span>@endif
                        @if($job->subcategory)<span>•</span><span>{{ $job->subcategory->name }}</span>@endif
                        <span>•</span><span>{{ optional($job->published_at)->format('d M Y') }}</span>
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        {{ $job->title }}
                    </h1>

                    <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-[#71837B]">
                        @if($job->budget_min !== null || $job->budget_max !== null)
                            <span><i class="bi bi-wallet2 mr-1 text-[#1E9E5A]"></i>
                                Rp {{ number_format((float) ($job->budget_min ?? $job->budget_max), 0, ',', '.') }}
                                @if($job->budget_min !== null && $job->budget_max !== null)
                                    - Rp {{ number_format((float) $job->budget_max, 0, ',', '.') }}
                                @endif
                            </span>
                        @endif
                        @if($job->duration_days)
                            <span><i class="bi bi-clock mr-1 text-[#1E9E5A]"></i>{{ $job->duration_days }} hari</span>
                        @endif
                        @if($job->deadline)
                            <span><i class="bi bi-calendar-event mr-1 text-[#1E9E5A]"></i>{{ $job->deadline->format('d M Y') }}</span>
                        @endif
                        @if($job->location)
                            <span><i class="bi bi-geo-alt mr-1 text-[#1E9E5A]"></i>{{ $job->location }}</span>
                        @endif
                    </div>
                </div>

                <div class="grid gap-0 lg:grid-cols-[minmax(0,1fr)_300px]">
                    <div class="px-5 py-6 sm:px-7">
                        <h2 class="text-sm font-semibold text-[#123128]">Brief pekerjaan</h2>
                        <div class="mt-4 whitespace-pre-line text-sm leading-7 text-[#60746B]">
                            {{ $job->description }}
                        </div>
                    </div>

                    <aside class="border-t border-[#E8EFEB] bg-[#FBFDFC] px-5 py-6 lg:border-l lg:border-t-0 sm:px-7">
                        <p class="text-[10px] font-semibold uppercase tracking-[.12em] text-[#96A39E]">Client</p>
                        <div class="mt-3 text-sm font-semibold text-[#123128]">
                            {{ $job->client?->name ?? 'Client' }}
                        </div>
                        <p class="mt-1 text-xs text-[#81918B]">Job dipublikasikan di JASAIN</p>

                        @auth
                            @if(auth()->user()->role === 'freelancer')
                                <a href="{{ route('freelancer.jobs.show', $job) }}" class="mt-5 inline-flex h-10 w-full items-center justify-center rounded-xl bg-[#0F6B3A] text-xs font-semibold text-white hover:bg-[#1E9E5A]">
                                    Ajukan proposal
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="mt-5 inline-flex h-10 w-full items-center justify-center rounded-xl bg-[#0F6B3A] text-xs font-semibold text-white hover:bg-[#1E9E5A]">
                                Masuk untuk melamar
                            </a>
                        @endauth
                    </aside>
                </div>
            </div>
        </section>
    </main>
</x-layouts.marketplace>
