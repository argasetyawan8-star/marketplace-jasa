<x-layouts.marketplace>
    <div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">
        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">Job Board</p>
                    <h1 class="mt-1 text-2xl font-semibold tracking-tight text-[#123128]">Job Saya</h1>
                    <p class="mt-1 text-sm text-[#71837B]">Kelola kebutuhan pekerjaan yang kamu publikasikan.</p>
                </div>
                <a href="{{ route('client.jobs.create') }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-4 text-xs font-semibold text-white hover:bg-[#1E9E5A]"><i class="bi bi-plus-lg"></i>Buat Job</a>
            </div>

            @if(session('success'))
                <div class="mt-5 rounded-xl border border-[#CDE8D7] bg-white px-4 py-3 text-sm text-[#355248]">{{ session('success') }}</div>
            @endif

            <div class="mt-6 divide-y divide-[#E8EFEB] rounded-2xl border border-[#E0EBE4] bg-white">
                @forelse($jobs as $job)
                    <a href="{{ route('client.jobs.show', $job) }}" class="block p-5 hover:bg-[#FBFDFC] sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2 text-[10px] text-[#8A9B94]">
                                    <span class="rounded-full bg-[#F2F8F4] px-2 py-1 font-semibold text-[#0F6B3A]">{{ ucfirst(str_replace('_',' ', $job->status)) }}</span>
                                    @if($job->category)<span>{{ $job->category->name }}</span>@endif
                                </div>
                                <h2 class="mt-2 text-sm font-semibold text-[#123128]">{{ $job->title }}</h2>
                                <p class="mt-1.5 text-xs text-[#81918B]">{{ $job->proposals_count }} proposal · {{ optional($job->created_at)->format('d M Y') }}</p>
                            </div>
                            <i class="bi bi-chevron-right shrink-0 text-xs text-[#93A29B]"></i>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-14 text-center">
                        <p class="text-sm font-semibold text-[#123128]">Belum ada job</p>
                        <p class="mt-1 text-xs text-[#81918B]">Buat job pertama untuk mulai menerima proposal freelancer.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-5">{{ $jobs->links() }}</div>
        </div>
    </div>
</x-layouts.marketplace>
