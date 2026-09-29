<x-layouts.freelancer title="Order Saya">

    @php

        $statusConfig = [
            'pending_payment' => [
                'label' => 'Menunggu pembayaran',
                'class' => 'border-amber-200 bg-amber-50 text-amber-700',
                'dot' => 'bg-amber-500',
                'icon' => 'bi-credit-card',
            ],

            'paid' => [
                'label' => 'Siap dikerjakan',
                'class' => 'border-blue-200 bg-blue-50 text-blue-700',
                'dot' => 'bg-blue-500',
                'icon' => 'bi-check-circle',
            ],

            'in_progress' => [
                'label' => 'Sedang dikerjakan',
                'class' => 'border-indigo-200 bg-indigo-50 text-indigo-700',
                'dot' => 'bg-indigo-500',
                'icon' => 'bi-arrow-repeat',
            ],

            'delivered' => [
                'label' => 'Menunggu client',
                'class' => 'border-orange-200 bg-orange-50 text-orange-700',
                'dot' => 'bg-orange-500',
                'icon' => 'bi-file-earmark-check',
            ],

            'revision' => [
                'label' => 'Dalam revisi',
                'class' => 'border-violet-200 bg-violet-50 text-violet-700',
                'dot' => 'bg-violet-500',
                'icon' => 'bi-arrow-repeat',
            ],

            'completed' => [
                'label' => 'Selesai',
                'class' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                'dot' => 'bg-emerald-500',
                'icon' => 'bi-check-circle-fill',
            ],

            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'border-rose-200 bg-rose-50 text-rose-700',
                'dot' => 'bg-rose-500',
                'icon' => 'bi-x-circle',
            ],
        ];

        $cancellationConfig = [
            'pending_freelancer' => [
                'label' => 'Perlu ditinjau',
                'class' => 'bg-amber-50 text-amber-700',
                'icon' => 'bi-hourglass-split',
            ],

            'rejected_by_freelancer' => [
                'label' => 'Ditolak freelancer',
                'class' => 'bg-rose-50 text-rose-700',
                'icon' => 'bi-x-circle',
            ],

            'mediation_pending' => [
                'label' => 'Menunggu admin',
                'class' => 'bg-blue-50 text-blue-700',
                'icon' => 'bi-shield-exclamation',
            ],

            'approved_by_freelancer' => [
                'label' => 'Disetujui freelancer',
                'class' => 'bg-emerald-50 text-emerald-700',
                'icon' => 'bi-check-circle-fill',
            ],

            'approved_by_admin' => [
                'label' => 'Disetujui admin',
                'class' => 'bg-emerald-50 text-emerald-700',
                'icon' => 'bi-check-circle-fill',
            ],

            'rejected_by_admin' => [
                'label' => 'Ditolak admin',
                'class' => 'bg-rose-50 text-rose-700',
                'icon' => 'bi-shield-x',
            ],
        ];

    @endphp


    {{-- =========================================================
        PAGE
    ========================================================== --}}
    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 sm:py-7 lg:px-8 lg:py-8">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="mb-5 sm:mb-7">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div class="min-w-0">

                        <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-[10px] font-semibold text-blue-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                            Area Freelancer
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Order Saya
                        </h1>

                        <p class="mt-1.5 max-w-2xl text-xs leading-5 text-slate-500 sm:text-sm">
                            Kelola pesanan yang sedang dikerjakan hingga selesai.
                        </p>

                    </div>


                    {{-- Total --}}
                    <div class="flex w-fit items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3.5 py-3 shadow-sm">

                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <i class="bi bi-briefcase text-sm"></i>
                        </div>

                        <div>
                            <p class="text-[10px] font-medium text-slate-400">
                                Total order
                            </p>

                            <p class="text-sm font-bold text-slate-800">
                                {{ $orders->total() }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                ALERT SUCCESS
            ====================================================== --}}
            @if(session('success'))

                <div class="mb-4 rounded-2xl border border-emerald-200 bg-white shadow-sm">
                    <div class="flex items-center gap-3 px-4 py-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <i class="bi bi-check-lg text-sm"></i>
                        </div>

                        <p class="text-xs font-medium leading-5 text-slate-700 sm:text-sm">
                            {{ session('success') }}
                        </p>

                    </div>
                </div>

            @endif


            {{-- =====================================================
                ALERT ERROR
            ====================================================== --}}
            @if(session('error'))

                <div class="mb-4 rounded-2xl border border-rose-200 bg-white shadow-sm">
                    <div class="flex items-center gap-3 px-4 py-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                            <i class="bi bi-exclamation-lg text-sm"></i>
                        </div>

                        <p class="text-xs font-medium leading-5 text-rose-700 sm:text-sm">
                            {{ session('error') }}
                        </p>

                    </div>
                </div>

            @endif


            {{-- =====================================================
                ORDER LIST
            ====================================================== --}}
            @if($orders->count() > 0)

                <div class="space-y-3">

                    @foreach($orders as $order)

                        @php

                            $status = $statusConfig[$order->status] ?? [
                                'label' => ucfirst(str_replace('_', ' ', $order->status)),
                                'class' => 'border-slate-200 bg-slate-50 text-slate-600',
                                'dot' => 'bg-slate-400',
                                'icon' => 'bi-info-circle',
                            ];

                            $cancellationRequest = $order->latestCancellationRequest;

                            $cancellation = $cancellationRequest
                                ? ($cancellationConfig[$cancellationRequest->status] ?? null)
                                : null;

                            $serviceTitle = $order->items->first()?->service_title ?? 'Pesanan Jasa';

                            $clientName = $order->client?->name ?? 'Client';

                            $clientInitial = strtoupper(
                                substr($clientName, 0, 1)
                            );

                            $needsCancellationReview =
                                $cancellationRequest?->status === 'pending_freelancer';

                        @endphp


                        {{-- =================================================
                            ORDER CARD
                        ================================================== --}}
                        <article
                            class="overflow-hidden rounded-2xl border bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md
                            {{ $needsCancellationReview
                                ? 'border-amber-200 ring-1 ring-amber-100'
                                : 'border-slate-200' }}"
                        >

                            <div class="p-4 sm:p-5">


                                {{-- =================================================
                                    TOP ROW
                                ================================================== --}}
                                <div class="flex items-start gap-3">

                                    {{-- Client Avatar --}}
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-sm font-bold text-blue-700">
                                        {{ $clientInitial }}
                                    </div>


                                    <div class="min-w-0 flex-1">

                                        {{-- Order number + date --}}
                                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">

                                            <span class="text-[10px] font-semibold text-slate-400">
                                                #{{ $order->order_number }}
                                            </span>

                                            <span class="text-[10px] text-slate-300">
                                                •
                                            </span>

                                            <span class="text-[10px] text-slate-400">
                                                {{ $order->created_at?->format('d M Y, H:i') }}
                                            </span>

                                        </div>


                                        {{-- Service title --}}
                                        <h2 class="mt-1.5 line-clamp-2 text-sm font-bold leading-5 text-slate-900 sm:text-[15px]">
                                            {{ $serviceTitle }}
                                        </h2>


                                        {{-- Client --}}
                                        <p class="mt-1 text-[11px] text-slate-500">
                                            {{ $clientName }}
                                        </p>

                                    </div>


                                    {{-- Status --}}
                                    <div class="shrink-0">

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1.5 text-[9px] font-bold sm:px-3 sm:text-[10px] {{ $status['class'] }}"
                                        >

                                            <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>

                                            <span class="hidden sm:inline">
                                                {{ $status['label'] }}
                                            </span>

                                            <span class="sm:hidden">
                                                {{ match($order->status) {
                                                    'pending_payment' => 'Belum bayar',
                                                    'paid' => 'Siap',
                                                    'in_progress' => 'Proses',
                                                    'delivered' => 'Review',
                                                    'revision' => 'Revisi',
                                                    'completed' => 'Selesai',
                                                    'cancelled' => 'Batal',
                                                    default => $status['label'],
                                                } }}
                                            </span>

                                        </span>

                                    </div>

                                </div>


                                {{-- =================================================
                                    ORDER INFO
                                ================================================== --}}
                                <div class="mt-4 grid grid-cols-2 gap-2.5 sm:grid-cols-3">

                                    {{-- Deadline --}}
                                    <div class="rounded-xl bg-slate-50 px-3 py-2.5">

                                        <div class="flex items-center gap-1.5">

                                            <i class="bi bi-calendar-event text-[11px] text-blue-600"></i>

                                            <span class="text-[9px] font-medium text-slate-400">
                                                Deadline
                                            </span>

                                        </div>

                                        <p class="mt-1 truncate text-[10px] font-semibold text-slate-700 sm:text-xs">
                                            {{ $order->due_at?->format('d M Y, H:i') ?? '-' }}
                                        </p>

                                    </div>


                                    {{-- Duration --}}
                                    <div class="rounded-xl bg-slate-50 px-3 py-2.5">

                                        <div class="flex items-center gap-1.5">

                                            <i class="bi bi-clock text-[11px] text-blue-600"></i>

                                            <span class="text-[9px] font-medium text-slate-400">
                                                Durasi
                                            </span>

                                        </div>

                                        <p class="mt-1 text-[10px] font-semibold text-slate-700 sm:text-xs">
                                            {{ $order->delivery_days }} hari
                                        </p>

                                    </div>


                                    {{-- Pendapatan --}}
                                    <div class="col-span-2 rounded-xl bg-blue-50/70 px-3 py-2.5 sm:col-span-1">

                                        <div class="flex items-center gap-1.5">

                                            <i class="bi bi-wallet2 text-[11px] text-blue-600"></i>

                                            <span class="text-[9px] font-medium text-blue-500">
                                                Pendapatan
                                            </span>

                                        </div>

                                        <p class="mt-1 truncate text-[10px] font-bold text-blue-700 sm:text-xs">
                                            Rp {{ number_format((float) $order->freelancer_amount, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>


                                {{-- =================================================
                                    CANCELLATION
                                ================================================== --}}
                                @if($cancellationRequest && $cancellation)

                                    <div
                                        class="mt-3 rounded-xl border px-3 py-3
                                        {{ $needsCancellationReview
                                            ? 'border-amber-200 bg-amber-50/70'
                                            : 'border-slate-200 bg-slate-50/70' }}"
                                    >

                                        <div class="flex items-start gap-2.5">

                                            <div
                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white shadow-sm
                                                {{ $needsCancellationReview
                                                    ? 'text-amber-600'
                                                    : 'text-slate-500' }}"
                                            >
                                                <i class="bi {{ $cancellation['icon'] }} text-xs"></i>
                                            </div>


                                            <div class="min-w-0 flex-1">

                                                <div class="flex flex-wrap items-center gap-2">

                                                    <p
                                                        class="text-[9px] font-bold uppercase tracking-[0.14em]
                                                        {{ $needsCancellationReview
                                                            ? 'text-amber-700'
                                                            : 'text-slate-500' }}"
                                                    >
                                                        Pembatalan
                                                    </p>

                                                    <span
                                                        class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-[8px] font-bold {{ $cancellation['class'] }}"
                                                    >
                                                        {{ $cancellation['label'] }}
                                                    </span>

                                                </div>


                                                <p
                                                    class="mt-1 text-[10px] leading-4
                                                    {{ $needsCancellationReview
                                                        ? 'text-amber-800'
                                                        : 'text-slate-600' }}"
                                                >
                                                    {{ $needsCancellationReview
                                                        ? 'Client mengajukan pembatalan dan membutuhkan tanggapan kamu.'
                                                        : 'Pengajuan pembatalan sudah memiliki status terbaru.' }}
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                @endif


                                {{-- =================================================
                                    BOTTOM ACTION
                                ================================================== --}}
                                <div class="mt-4 flex items-center justify-between gap-3 border-t border-slate-100 pt-3">

                                    {{-- Total --}}
                                    <div class="min-w-0">

                                        <p class="text-[9px] font-medium text-slate-400">
                                            Total order
                                        </p>

                                        <p class="mt-0.5 truncate text-xs font-bold text-slate-800">
                                            Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                        </p>

                                    </div>


                                    {{-- Buttons --}}
                                    <div class="flex shrink-0 items-center gap-2">

                                        @if($needsCancellationReview)

                                            <a
                                                href="{{ route('freelancer.orders.cancellation.create', $order) }}"
                                                class="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl bg-amber-500 px-3 text-[10px] font-bold text-white transition hover:bg-amber-600 sm:px-3.5 sm:text-xs"
                                            >
                                                <i class="bi bi-shield-exclamation"></i>

                                                <span class="hidden xs:inline sm:inline">
                                                    Tinjau
                                                </span>
                                            </a>

                                        @endif


                                        <a
                                            href="{{ route('freelancer.orders.show', $order) }}"
                                            class="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 text-[10px] font-bold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 sm:px-3.5 sm:text-xs"
                                        >
                                            Detail

                                            <i class="bi bi-arrow-right text-[9px]"></i>
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- =====================================================
                    PAGINATION
                ====================================================== --}}
                @if($orders->hasPages())

                    <div class="mt-5">
                        {{ $orders->links() }}
                    </div>

                @endif


            @else

                {{-- =====================================================
                    EMPTY STATE
                ====================================================== --}}
                <section class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center shadow-sm sm:py-16">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                        <i class="bi bi-briefcase text-xl"></i>
                    </div>

                    <h2 class="mt-4 text-sm font-bold text-slate-900 sm:text-base">
                        Belum ada order
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-xs leading-5 text-slate-500 sm:text-sm sm:leading-6">
                        Saat ada client yang membeli layananmu, pesanan akan muncul di halaman ini.
                    </p>

                </section>

            @endif

        </div>

    </div>

</x-layouts.freelancer>