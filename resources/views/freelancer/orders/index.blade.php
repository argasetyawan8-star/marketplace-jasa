<x-layouts.freelancer title="Order Saya">
    @php
        $statusConfig = [
            'pending_payment' => [
                'label' => 'Menunggu pembayaran',
                'class' => 'border-[#F2DDAF] bg-[#FFF9EA] text-[#9A6800]',
                'dot' => 'bg-[#D99A19]',
                'icon' => 'bi-credit-card',
            ],
            'paid' => [
                'label' => 'Siap dikerjakan',
                'class' => 'border-[#CFE0F1] bg-[#F3F8FC] text-[#3C6F9F]',
                'dot' => 'bg-[#5B91C0]',
                'icon' => 'bi-check-circle',
            ],
            'in_progress' => [
                'label' => 'Sedang dikerjakan',
                'class' => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',
                'dot' => 'bg-[#35C978]',
                'icon' => 'bi-arrow-repeat',
            ],
            'delivered' => [
                'label' => 'Menunggu client',
                'class' => 'border-[#E7D9C8] bg-[#FFF8EF] text-[#A96B20]',
                'dot' => 'bg-[#D48A32]',
                'icon' => 'bi-file-earmark-check',
            ],
            'revision' => [
                'label' => 'Dalam revisi',
                'class' => 'border-[#E8D8ED] bg-[#FAF4FC] text-[#895597]',
                'dot' => 'bg-[#B77BC7]',
                'icon' => 'bi-arrow-repeat',
            ],
            'completed' => [
                'label' => 'Selesai',
                'class' => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',
                'dot' => 'bg-[#35C978]',
                'icon' => 'bi-check-circle-fill',
            ],
            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'border-[#F0D5D5] bg-[#FFF6F6] text-[#B84E4E]',
                'dot' => 'bg-[#D16B6B]',
                'icon' => 'bi-x-circle',
            ],
        ];

        $cancellationConfig = [
            'pending_freelancer' => [
                'label' => 'Perlu ditinjau',
                'class' => 'bg-[#FFF6D9] text-[#966600]',
                'icon' => 'bi-hourglass-split',
            ],
            'rejected_by_freelancer' => [
                'label' => 'Ditolak freelancer',
                'class' => 'bg-[#FFF0F0] text-[#B84E4E]',
                'icon' => 'bi-x-circle',
            ],
            'mediation_pending' => [
                'label' => 'Menunggu admin',
                'class' => 'bg-[#EEF6FF] text-[#4676A8]',
                'icon' => 'bi-shield-exclamation',
            ],
            'approved_by_freelancer' => [
                'label' => 'Disetujui freelancer',
                'class' => 'bg-[#EAF7EF] text-[#168A4D]',
                'icon' => 'bi-check-circle-fill',
            ],
            'approved_by_admin' => [
                'label' => 'Disetujui admin',
                'class' => 'bg-[#EAF7EF] text-[#168A4D]',
                'icon' => 'bi-check-circle-fill',
            ],
            'rejected_by_admin' => [
                'label' => 'Ditolak admin',
                'class' => 'bg-[#FFF0F0] text-[#B84E4E]',
                'icon' => 'bi-shield-x',
            ],
        ];
    @endphp

    <div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">
        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">

            {{-- HEADER --}}
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                        Freelancer
                    </p>
                    <h1 class="mt-1 text-2xl font-semibold tracking-[-0.03em] text-[#123128]">
                        Order saya
                    </h1>
                    <p class="mt-1.5 max-w-2xl text-xs leading-5 text-[#71837B]">
                        Kelola semua pesanan yang sedang dikerjakan, menunggu client, sampai selesai.
                    </p>
                </div>

                <div class="flex items-center gap-2 rounded-xl border border-[#DCE9E1] bg-white px-3.5 py-2.5 shadow-[0_4px_14px_rgba(18,49,40,0.025)]">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#1E9E5A]">
                        <i class="bi bi-briefcase text-[13px]"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-[#98A49E]">Total order</p>
                        <p class="text-xs font-semibold text-[#355248]">
                            {{ $orders->total() }} order
                        </p>
                    </div>
                </div>
            </div>

            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="mb-5 rounded-xl border border-[#CDE8D7] bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">
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

            {{-- ALERT ERROR --}}
            @if(session('error'))
                <div class="mb-5 rounded-xl border border-red-100 bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">
                    <div class="flex items-center gap-3 px-4 py-3.5">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-50">
                            <i class="bi bi-exclamation-lg text-sm text-red-500"></i>
                        </div>
                        <p class="text-sm text-red-600">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- ORDER LIST --}}
            @if($orders->count() > 0)
                <div class="space-y-3">
                    @foreach($orders as $order)
                        @php
                            $status = $statusConfig[$order->status] ?? [
                                'label' => ucfirst(str_replace('_', ' ', $order->status)),
                                'class' => 'border-[#E1E7E3] bg-[#F7F9F8] text-[#66766E]',
                                'dot' => 'bg-[#A3AEA9]',
                                'icon' => 'bi-info-circle',
                            ];

                            $cancellationRequest = $order->latestCancellationRequest;
                            $cancellation = $cancellationRequest
                                ? ($cancellationConfig[$cancellationRequest->status] ?? null)
                                : null;

                            $serviceTitle = $order->items->first()?->service_title ?? 'Pesanan Jasa';
                            $clientName = $order->client?->name ?? 'Client';
                            $clientInitial = strtoupper(substr($clientName, 0, 1));

                            $needsCancellationReview = $cancellationRequest?->status === 'pending_freelancer';
                        @endphp

                        <article class="overflow-hidden rounded-2xl border {{ $needsCancellationReview ? 'border-[#E8D596]' : 'border-[#E1EAE5]' }} bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)] transition hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(18,49,40,0.055)]">
                            <div class="p-5 sm:p-6">
                                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F3F7F5] px-2.5 py-1 text-[9px] font-medium text-[#7F8E87]">
                                                <i class="bi bi-hash text-[8px]"></i>
                                                {{ $order->order_number }}
                                            </span>

                                            <span class="text-[10px] text-[#A0AAA5]">
                                                {{ $order->created_at?->format('d M Y, H:i') }}
                                            </span>
                                        </div>

                                        <h2 class="mt-3 text-sm font-semibold leading-6 text-[#18382E] sm:text-base">
                                            {{ $serviceTitle }}
                                        </h2>

                                        <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2">
                                            <span class="inline-flex items-center gap-1.5 text-[10px] text-[#7D8D86]">
                                                <i class="bi bi-person text-[#1E9E5A]"></i>
                                                {{ $clientName }}
                                            </span>

                                            <span class="inline-flex items-center gap-1.5 text-[10px] text-[#7D8D86]">
                                                <i class="bi bi-calendar-event text-[#1E9E5A]"></i>
                                                {{ $order->due_at?->format('d M Y, H:i') ?? '-' }}
                                            </span>

                                            <span class="inline-flex items-center gap-1.5 text-[10px] text-[#7D8D86]">
                                                <i class="bi bi-clock text-[#1E9E5A]"></i>
                                                {{ $order->delivery_days }} hari
                                            </span>
                                        </div>

                                        @if($cancellationRequest && $cancellation)
                                            <div class="mt-4 flex flex-col gap-2 rounded-xl border {{ $needsCancellationReview ? 'border-[#EADAA2] bg-[#FFFBEF]' : 'border-[#E5ECE8] bg-[#FAFCFB]' }} px-3.5 py-3 sm:flex-row sm:items-center sm:justify-between">
                                                <div class="flex min-w-0 items-start gap-2.5">
                                                    <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white text-[#8A9A92] shadow-sm">
                                                        <i class="bi {{ $cancellation['icon'] }} text-[11px]"></i>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-[9px] font-semibold uppercase tracking-[0.13em] {{ $needsCancellationReview ? 'text-[#9A6800]' : 'text-[#7A8982]' }}">
                                                            Pembatalan
                                                        </p>
                                                        <p class="mt-0.5 text-[10px] leading-4 {{ $needsCancellationReview ? 'text-[#76520F]' : 'text-[#62756D]' }}">
                                                            {{ $needsCancellationReview ? 'Client mengajukan pembatalan dan membutuhkan tanggapan kamu.' : 'Pengajuan pembatalan sudah memiliki status terbaru.' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="inline-flex w-fit shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1 text-[9px] font-semibold {{ $cancellation['class'] }}">
                                                    <i class="bi {{ $cancellation['icon'] }} text-[9px]"></i>
                                                    {{ $cancellation['label'] }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex shrink-0 flex-col items-start gap-3 lg:items-end">
                                        <span class="inline-flex items-center gap-2 rounded-full border px-3 py-2 text-[10px] font-semibold {{ $status['class'] }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                            <i class="bi {{ $status['icon'] }} text-[10px]"></i>
                                            {{ $status['label'] }}
                                        </span>

                                        <span class="text-[10px] text-[#98A49E]">
                                            Rp {{ number_format((float) $order->freelancer_amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-5 flex flex-col gap-3 border-t border-[#EDF2EF] pt-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div class="flex items-center gap-2">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#EAF7EF] text-[10px] font-semibold text-[#1E9E5A]">
                                                {{ $clientInitial }}
                                            </div>
                                            <div>
                                                <p class="text-[9px] text-[#98A49E]">Client</p>
                                                <p class="text-[10px] font-semibold text-[#52685F]">
                                                    {{ $clientName }}
                                                </p>
                                            </div>
                                        </div>

                                        <span class="hidden h-5 w-px bg-[#E5ECE8] sm:block"></span>

                                        <div>
                                            <p class="text-[9px] text-[#98A49E]">Total order</p>
                                            <p class="text-[10px] font-semibold text-[#355248]">
                                                Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                                        @if($needsCancellationReview)
                                            <a
                                                href="{{ route('freelancer.orders.cancellation.create', $order) }}"
                                                class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#D99A19] px-4 text-[10px] font-semibold text-white transition hover:bg-[#B77A0B]"
                                            >
                                                <i class="bi bi-shield-exclamation"></i>
                                                Tinjau Pembatalan
                                            </a>
                                        @endif

                                        <a
                                            href="{{ route('freelancer.orders.show', $order) }}"
                                            class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-[#DCE7E1] bg-white px-4 text-[10px] font-semibold text-[#52685F] transition hover:border-[#BBD9C6] hover:bg-[#F4FAF6] hover:text-[#1E9E5A]"
                                        >
                                            Lihat detail
                                            <i class="bi bi-arrow-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($orders->hasPages())
                    <div class="pt-3">
                        {{ $orders->links() }}
                    </div>
                @endif
            @else
                <section class="rounded-2xl border border-dashed border-[#DCE7E1] bg-white px-5 py-14 text-center shadow-[0_5px_18px_rgba(18,49,40,0.025)]">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A]">
                        <i class="bi bi-briefcase text-xl"></i>
                    </div>
                    <h2 class="mt-5 text-sm font-semibold text-[#123128]">
                        Belum ada order
                    </h2>
                    <p class="mx-auto mt-2 max-w-md text-xs leading-5 text-[#8B9992]">
                        Saat ada client yang membeli layananmu, pesanan akan muncul di halaman ini.
                    </p>
                </section>
            @endif
        </div>
    </div>
</x-layouts.freelancer>
