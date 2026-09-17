<x-layouts.freelancer title="Job Board">
    <div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">
        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
            <div>
                <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">Job Board</p>
                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-[#123128]">Cari Job</h1>
                <p class="mt-1 text-sm text-[#71837B]">Temukan kebutuhan client dan ajukan proposal.</p>
            </div>

            <form method="GET" class="mt-5 flex flex-col gap-3 sm:flex-row">
                <input name="q" value="{{ request('q') }}" placeholder="Cari pekerjaan..." class="h-11 flex-1 rounded-xl border border-[#DDE7E1] bg-white px-4 text-sm outline-none focus:border-[#1E9E5A]">
                <select name="category" class="h-11 rounded-xl border border-[#DDE7E1] bg-white px-3 text-sm outline-none focus:border-[#1E9E5A] sm:w-56">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)<option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>@endforeach
                </select>
                <button class="h-11 rounded-xl bg-[#0F6B3A] px-5 text-xs font-semibold text-white hover:bg-[#1E9E5A]">Cari</button>
            </form>

            <div class="mt-5 divide-y divide-[#E8EFEB] rounded-2xl border border-[#E0EBE4] bg-white">
                @forelse($jobs as $job)
                    <a href="{{ route('freelancer.jobs.show', $job) }}" class="block p-5 hover:bg-[#FBFDFC] sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex flex-wrap gap-2 text-[10px] text-[#8A9B94]">@if($job->category)<span>{{ $job->category->name }}</span>@endif @if($job->subcategory)<span>•</span><span>{{ $job->subcategory->name }}</span>@endif</div>
                                <h2 class="mt-1.5 text-sm font-semibold text-[#123128]">{{ $job->title }}</h2>
                                <p class="mt-1.5 line-clamp-2 text-xs leading-5 text-[#667D73]">{{ $job->description }}</p>
                                <div class="mt-3 flex flex-wrap gap-x-4 gap-y-2 text-[10px] text-[#81918B]">
                                    <span>{{ $job->budget_min !== null || $job->budget_max !== null ? 'Rp '.number_format((float)($job->budget_min ?? $job->budget_max),0,',','.') : 'Budget fleksibel' }}</span>
                                    @if($job->duration_days)<span>{{ $job->duration_days }} hari</span>@endif
                                    <span>{{ $job->proposals_count }} proposal</span>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right shrink-0 text-xs text-[#93A29B]"></i>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-14 text-center text-sm text-[#81918B]">Belum ada job yang tersedia.</div>
                @endforelse
            </div>
            <div class="mt-5">{{ $jobs->links() }}</div>
        </div>
    </div>
</x-layouts.freelancer>
