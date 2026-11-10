<x-layouts.marketplace>
    <div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">
        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
            <a href="{{ route('client.jobs.index') }}" class="inline-flex items-center gap-2 text-xs text-[#71837B] hover:text-[#0F6B3A]"><i class="bi bi-arrow-left"></i>Kembali ke Job Saya</a>

            @if(session('success'))
                <div class="mt-5 rounded-xl border border-[#CDE8D7] bg-white px-4 py-3 text-sm text-[#355248]">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mt-5 rounded-xl border border-red-100 bg-white px-4 py-3 text-sm text-red-600">{{ session('error') }}</div>
            @endif

            <div class="mt-5 overflow-hidden rounded-2xl border border-[#E0EBE4] bg-white">
                <div class="border-b border-[#E8EFEB] px-5 py-6 sm:px-7">
                    <div class="flex flex-wrap items-center gap-2 text-[10px] text-[#8A9B94]">
                        <span class="rounded-full bg-[#F2F8F4] px-2.5 py-1 font-semibold text-[#0F6B3A]">{{ ucfirst(str_replace('_', ' ', $job->status)) }}</span>
                        @if($job->category)<span>{{ $job->category->name }}</span>@endif
                        @if($job->subcategory)<span>•</span><span>{{ $job->subcategory->name }}</span>@endif
                    </div>
                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128]">{{ $job->title }}</h1>
                    <p class="mt-2 text-xs text-[#81918B]">Dipublikasikan {{ optional($job->published_at)->format('d M Y, H:i') ?? 'sebagai draft' }}</p>
                </div>

                <div class="grid gap-0 lg:grid-cols-[minmax(0,1fr)_320px]">
                    <div class="px-5 py-6 sm:px-7">
                        <h2 class="text-sm font-semibold text-[#123128]">Detail pekerjaan</h2>
                        <p class="mt-4 whitespace-pre-line text-sm leading-7 text-[#60746B]">{{ $job->description }}</p>

                        <div class="mt-6 grid gap-4 border-t border-[#EDF2EF] pt-5 sm:grid-cols-3">
                            <div><p class="text-[10px] uppercase tracking-[.08em] text-[#96A39E]">Budget</p><p class="mt-1 text-sm font-semibold text-[#123128]">@if($job->budget_min !== null || $job->budget_max !== null)Rp {{ number_format((float)($job->budget_min ?? $job->budget_max),0,',','.') }}@if($job->budget_min !== null && $job->budget_max !== null) - Rp {{ number_format((float)$job->budget_max,0,',','.') }}@endif @else Fleksibel @endif</p></div>
                            <div><p class="text-[10px] uppercase tracking-[.08em] text-[#96A39E]">Durasi</p><p class="mt-1 text-sm font-semibold text-[#123128]">{{ $job->duration_days ? $job->duration_days.' hari' : '-' }}</p></div>
                            <div><p class="text-[10px] uppercase tracking-[.08em] text-[#96A39E]">Deadline</p><p class="mt-1 text-sm font-semibold text-[#123128]">{{ $job->deadline?->format('d M Y') ?? '-' }}</p></div>
                        </div>
                    </div>

                    <aside class="border-t border-[#E8EFEB] bg-[#FBFDFC] px-5 py-6 lg:border-l lg:border-t-0 sm:px-7">
                        <div class="flex gap-2">
                            @if(!in_array($job->status, ['closed', 'cancelled'], true))
                                <a href="{{ route('client.jobs.edit', $job) }}" class="inline-flex h-10 flex-1 items-center justify-center gap-2 rounded-xl border border-[#DDE7E1] bg-white text-xs font-semibold text-[#355248] hover:bg-[#F8FCF9]"><i class="bi bi-pencil"></i>Edit</a>
                                @if($job->status === 'draft')
                                    <form method="POST" action="{{ route('client.jobs.publish', $job) }}" class="flex-1">@csrf<button class="h-10 w-full rounded-xl bg-[#0F6B3A] text-xs font-semibold text-white hover:bg-[#1E9E5A]">Publikasikan</button></form>
                                @elseif($job->status === 'open')
                                    <form method="POST" action="{{ route('client.jobs.close', $job) }}" class="flex-1">@csrf<button class="h-10 w-full rounded-xl bg-[#F7EEE8] text-xs font-semibold text-[#9A5A2D] hover:bg-[#F2E4D9]">Tutup Job</button></form>
                                @endif
                            @endif
                        </div>
                    </aside>
                </div>

                <section class="border-t border-[#E8EFEB] px-5 py-6 sm:px-7">
                    <div class="flex items-end justify-between gap-4">
                        <div><p class="text-[10px] font-semibold uppercase tracking-[.14em] text-[#1E9E5A]">Proposal</p><h2 class="mt-1 text-lg font-semibold text-[#123128]">Proposal freelancer</h2></div>
                        <span class="text-xs text-[#81918B]">{{ $job->proposals->count() }} proposal</span>
                    </div>

                    @if($job->proposals->count())
                        <div class="mt-5 divide-y divide-[#EDF2EF] border-y border-[#EDF2EF]">
                            @foreach($job->proposals as $proposal)
                                @php
                                    $freelancer = $proposal->freelancerProfile;
                                    $freelancerUser = $freelancer?->user;
                                @endphp
                                <div class="py-5">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                        <div class="flex min-w-0 gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A]">
                                                @if($freelancer?->avatar)<img src="{{ asset('storage/'.$freelancer->avatar) }}" alt="{{ $freelancerUser?->name }}" class="h-full w-full object-cover">@else{{ strtoupper(mb_substr($freelancerUser?->name ?? 'F',0,1)) }}@endif
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-[#123128]">{{ $freelancerUser?->name ?? 'Freelancer' }}</p>
                                                <p class="mt-0.5 text-[11px] text-[#81918B]">{{ '@'.($freelancer?->username ?? 'freelancer') }}</p>
                                                <p class="mt-2 text-sm leading-6 text-[#60746B]">{{ $proposal->message }}</p>
                                            </div>
                                        </div>
                                        <div class="shrink-0 text-left sm:text-right">
                                            <p class="text-[10px] text-[#96A39E]">Penawaran</p>
                                            <p class="mt-1 text-sm font-semibold text-[#0F6B3A]">Rp {{ number_format((float)$proposal->price,0,',','.') }}</p>
                                            <p class="mt-1 text-[11px] text-[#81918B]">{{ $proposal->delivery_days }} hari · {{ ucfirst($proposal->status) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-5 rounded-xl border border-dashed border-[#CFDFD5] px-5 py-10 text-center text-sm text-[#81918B]">Belum ada freelancer yang mengirim proposal.</div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</x-layouts.marketplace>
