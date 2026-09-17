<x-layouts.freelancer title="Job Detail">
    <div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">
        <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
            <a href="{{ route('freelancer.jobs.index') }}" class="inline-flex items-center gap-2 text-xs text-[#71837B] hover:text-[#0F6B3A]"><i class="bi bi-arrow-left"></i> Kembali ke Job Board</a>

            @if(session('success'))<div class="mt-5 rounded-xl border border-[#CDE8D7] bg-white px-4 py-3 text-sm text-[#355248]">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mt-5 rounded-xl border border-red-100 bg-white px-4 py-3 text-sm text-red-600">{{ session('error') }}</div>@endif

            <div class="mt-5 overflow-hidden rounded-2xl border border-[#E0EBE4] bg-white">
                <div class="border-b border-[#E8EFEB] px-5 py-6 sm:px-7">
                    <div class="flex flex-wrap gap-2 text-[10px] text-[#8A9B94]">@if($job->category)<span>{{ $job->category->name }}</span>@endif @if($job->subcategory)<span>•</span><span>{{ $job->subcategory->name }}</span>@endif</div>
                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128]">{{ $job->title }}</h1>
                    <div class="mt-4 flex flex-wrap gap-4 text-xs text-[#71837B]">
                        @if($job->budget_min !== null || $job->budget_max !== null)<span><i class="bi bi-wallet2 mr-1 text-[#1E9E5A]"></i>Rp {{ number_format((float)($job->budget_min ?? $job->budget_max),0,',','.') }}@if($job->budget_min !== null && $job->budget_max !== null) - Rp {{ number_format((float)$job->budget_max,0,',','.') }}@endif</span>@endif
                        @if($job->duration_days)<span><i class="bi bi-clock mr-1 text-[#1E9E5A]"></i>{{ $job->duration_days }} hari</span>@endif
                        @if($job->deadline)<span><i class="bi bi-calendar-event mr-1 text-[#1E9E5A]"></i>{{ $job->deadline->format('d M Y') }}</span>@endif
                    </div>
                </div>

                <div class="grid gap-0 lg:grid-cols-[minmax(0,1fr)_340px]">
                    <div class="px-5 py-6 sm:px-7">
                        <h2 class="text-sm font-semibold text-[#123128]">Detail pekerjaan</h2>
                        <p class="mt-4 whitespace-pre-line text-sm leading-7 text-[#60746B]">{{ $job->description }}</p>
                    </div>

                    <aside class="border-t border-[#E8EFEB] bg-[#FBFDFC] px-5 py-6 lg:border-l lg:border-t-0 sm:px-7">
                        @if($existingProposal)
                            <p class="text-xs font-semibold text-[#123128]">Proposal kamu sudah dikirim</p>
                            <div class="mt-4 space-y-3 text-xs text-[#60746B]">
                                <div class="flex justify-between gap-3"><span>Harga</span><strong class="text-[#0F6B3A]">Rp {{ number_format((float)$existingProposal->price,0,',','.') }}</strong></div>
                                <div class="flex justify-between gap-3"><span>Durasi</span><strong>{{ $existingProposal->delivery_days }} hari</strong></div>
                                <div class="rounded-xl bg-white px-3 py-3 leading-5">{{ $existingProposal->message }}</div>
                            </div>
                        @else
                            <p class="text-xs font-semibold text-[#123128]">Ajukan proposal</p>
                            <p class="mt-1 text-xs leading-5 text-[#81918B]">Berikan penawaran harga dan estimasi waktu yang realistis.</p>

                            <form method="POST" action="{{ route('freelancer.jobs.proposals.store', $job) }}" class="mt-4 space-y-3">
                                @csrf
                                <div><label class="text-[11px] font-medium text-[#40564C]">Harga penawaran</label><input type="number" name="price" min="0" required class="mt-1.5 h-10 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm outline-none focus:border-[#1E9E5A]"></div>
                                <div><label class="text-[11px] font-medium text-[#40564C]">Estimasi pengerjaan (hari)</label><input type="number" name="delivery_days" min="1" required class="mt-1.5 h-10 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm outline-none focus:border-[#1E9E5A]"></div>
                                <div><label class="text-[11px] font-medium text-[#40564C]">Pesan proposal</label><textarea name="message" rows="6" required class="mt-1.5 w-full rounded-xl border border-[#DDE7E1] px-3 py-2.5 text-sm outline-none focus:border-[#1E9E5A]"></textarea></div>
                                <button class="h-10 w-full rounded-xl bg-[#0F6B3A] text-xs font-semibold text-white hover:bg-[#1E9E5A]">Kirim proposal</button>
                            </form>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </div>
</x-layouts.freelancer>
