<x-layouts.admin title="Dispute Center">

    @php
        $statusLabels = [
            'open' => 'Dibuka',
            'pending_response' => 'Menunggu tanggapan',
            'under_review' => 'Perlu ditinjau',
            'resolved_client' => 'Selesai untuk Client',
            'resolved_freelancer' => 'Selesai untuk Freelancer',
            'resolved_partial' => 'Selesai sebagian',
            'closed' => 'Ditutup',
        ];

        $statusClasses = [
            'open' => 'bg-[#EEF6FC] text-[#3C6F9F]',
            'pending_response' => 'bg-[#FFF9EA] text-[#9A6800]',
            'under_review' => 'bg-[#F1EFFA] text-[#6D62A4]',
            'resolved_client' => 'bg-[#EAF7EF] text-[#168A4D]',
            'resolved_freelancer' => 'bg-red-50 text-red-600',
            'resolved_partial' => 'bg-[#FFF9EA] text-[#A56A1B]',
            'closed' => 'bg-[#F3F5F4] text-[#66766E]',
        ];
    @endphp

    <div class="min-h-screen bg-[#F8FCF9]">

        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">

            @if(session('success'))
                <div class="mb-5 rounded-xl border border-[#CDE8D7] bg-white shadow-sm">
                    <div class="flex items-center gap-3 px-4 py-3.5">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF]">
                            <i class="bi bi-check-lg text-sm text-[#1E9E5A]"></i>
                        </div>
                        <p class="text-sm text-[#355248]">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

                <div>
                    <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                        Support & Safety
                    </p>
                    <h1 class="mt-1 text-2xl font-semibold tracking-[-0.03em] text-[#123128]">
                        Dispute Center
                    </h1>
                    <p class="mt-2 max-w-2xl text-xs leading-5 text-[#71837B]">
                        Tinjau sengketa Client dan Freelancer berdasarkan order, tanggapan, serta bukti yang tersedia.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">

                    <div class="rounded-xl border border-[#E1EAE5] bg-white px-4 py-3">
                        <p class="text-[9px] text-[#97A39E]">Semua</p>
                        <p class="mt-1 text-lg font-semibold text-[#123128]">{{ $counts['all'] }}</p>
                    </div>

                    <div class="rounded-xl border border-[#E1EAE5] bg-white px-4 py-3">
                        <p class="text-[9px] text-[#97A39E]">Perlu respon</p>
                        <p class="mt-1 text-lg font-semibold text-[#123128]">{{ $counts['pending_response'] }}</p>
                    </div>

                    <div class="rounded-xl border border-[#D8D4EE] bg-[#F7F5FD] px-4 py-3">
                        <p class="text-[9px] text-[#8176B7]">Perlu ditinjau</p>
                        <p class="mt-1 text-lg font-semibold text-[#5F558D]">{{ $counts['under_review'] }}</p>
                    </div>

                    <div class="rounded-xl border border-[#E1EAE5] bg-white px-4 py-3">
                        <p class="text-[9px] text-[#97A39E]">Selesai</p>
                        <p class="mt-1 text-lg font-semibold text-[#123128]">{{ $counts['resolved'] }}</p>
                    </div>

                </div>

            </div>

            <section class="overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_6px_22px_rgba(18,49,40,0.035)]">

                <div class="border-b border-[#E8EFEB] px-5 py-5 sm:px-6">

                    <form method="GET" class="flex flex-col gap-3 lg:flex-row">

                        <div class="relative flex-1">
                            <i class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-[#9BA7A1]"></i>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nomor dispute, order, nama, atau masalah..."
                                class="h-11 w-full rounded-xl border border-[#DCE7E1] bg-[#FAFCFB] pl-9 pr-4 text-xs text-[#123128] outline-none placeholder:text-[#A0ADA7] focus:border-[#9ACCB0] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
                            >
                        </div>

                        <select
                            name="status"
                            class="h-11 rounded-xl border border-[#DCE7E1] bg-[#FAFCFB] px-4 text-xs text-[#355248] outline-none focus:border-[#9ACCB0] focus:ring-2 focus:ring-[#EAF7EF]"
                        >
                            <option value="">Semua status</option>
                            @foreach($statusLabels as $value => $label)
                                <option value="{{ $value }}" @selected(request('status') === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        <button
                            type="submit"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 text-xs font-semibold text-white transition hover:bg-[#0F6B3A]"
                        >
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>

                    </form>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-[980px] w-full">

                        <thead>
                            <tr class="border-b border-[#E8EFEB] bg-[#FAFCFB] text-left">
                                <th class="px-5 py-3 text-[9px] font-semibold uppercase tracking-[0.12em] text-[#8C9993]">Dispute</th>
                                <th class="px-5 py-3 text-[9px] font-semibold uppercase tracking-[0.12em] text-[#8C9993]">Order</th>
                                <th class="px-5 py-3 text-[9px] font-semibold uppercase tracking-[0.12em] text-[#8C9993]">Dibuka oleh</th>
                                <th class="px-5 py-3 text-[9px] font-semibold uppercase tracking-[0.12em] text-[#8C9993]">Kategori</th>
                                <th class="px-5 py-3 text-[9px] font-semibold uppercase tracking-[0.12em] text-[#8C9993]">Status</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#EEF2EF]">

                            @forelse($disputes as $dispute)

                                <tr class="transition hover:bg-[#FBFDFC]">

                                    <td class="px-5 py-4">
                                        <p class="text-xs font-semibold text-[#355248]">
                                            {{ $dispute->dispute_number }}
                                        </p>
                                        <p class="mt-1 max-w-[260px] truncate text-[10px] text-[#91A099]">
                                            {{ $dispute->reason }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <p class="text-xs font-semibold text-[#526960]">
                                            {{ $dispute->order?->order_number ?? '-' }}
                                        </p>
                                        <p class="mt-1 max-w-[220px] truncate text-[10px] text-[#98A49E]">
                                            {{ $dispute->order?->items?->first()?->service_title ?? 'Pesanan Jasa' }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <p class="text-xs font-medium text-[#355248]">
                                            {{ $dispute->opener?->name ?? '-' }}
                                        </p>
                                        <p class="mt-1 text-[10px] text-[#98A49E]">
                                            {{ ucfirst($dispute->opened_by_role) }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="inline-flex rounded-full bg-[#F3F7F5] px-2.5 py-1 text-[9px] font-semibold text-[#66776F]">
                                            {{ ucfirst(str_replace('_', ' ', $dispute->category)) }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-[9px] font-semibold {{ $statusClasses[$dispute->status] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ $statusLabels[$dispute->status] ?? ucfirst(str_replace('_', ' ', $dispute->status)) }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <a
                                            href="{{ route('admin.disputes.show', $dispute) }}"
                                            class="inline-flex h-9 items-center justify-center gap-2 rounded-lg border border-[#DCE7E1] bg-white px-3 text-[10px] font-semibold text-[#526960] transition hover:bg-[#F5FAF7] hover:text-[#1E9E5A]"
                                        >
                                            Lihat
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="px-5 py-12 text-center">
                                        <i class="bi bi-shield-check text-2xl text-[#A0ADA7]"></i>
                                        <p class="mt-3 text-sm font-semibold text-[#526960]">
                                            Belum ada dispute
                                        </p>
                                        <p class="mt-1 text-xs text-[#98A49E]">
                                            Kasus sengketa akan muncul di sini saat dibuat.
                                        </p>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if($disputes->hasPages())
                    <div class="border-t border-[#E8EFEB] px-5 py-4 sm:px-6">
                        {{ $disputes->links() }}
                    </div>
                @endif

            </section>

        </div>

    </div>

</x-layouts.admin>
