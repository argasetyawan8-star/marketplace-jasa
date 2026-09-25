
@php
    $serviceItem = $order->items->first();
    $serviceTitle = $serviceItem?->service_title ?? 'Pesanan Jasa';

    $freelancerProfile = $order->freelancerProfile;
    $freelancer = $freelancerProfile?->user;

    $freelancerName = $freelancer?->name ?? 'Freelancer';
    $freelancerInitial = strtoupper(
        substr(trim($freelancerName), 0, 1)
    );

    /*
    |--------------------------------------------------------------------------
    | Freelancer avatar
    |--------------------------------------------------------------------------
    */
    $freelancerAvatar = data_get($freelancerProfile, 'avatar')
        ?? data_get($freelancer, 'avatar')
        ?? data_get($freelancer, 'avatar_url')
        ?? data_get($freelancer, 'profile_photo_url');

    $freelancerAvatarUrl = null;

    if ($freelancerAvatar) {
        if (
            filter_var($freelancerAvatar, FILTER_VALIDATE_URL) ||
            str_starts_with($freelancerAvatar, 'data:image/')
        ) {
            $freelancerAvatarUrl = $freelancerAvatar;
        } elseif (str_starts_with($freelancerAvatar, '/')) {
            $freelancerAvatarUrl = asset(
                ltrim($freelancerAvatar, '/')
            );
        } elseif (
            str_starts_with($freelancerAvatar, 'storage/') ||
            str_starts_with($freelancerAvatar, 'uploads/')
        ) {
            $freelancerAvatarUrl = asset($freelancerAvatar);
        } else {
            $freelancerAvatarUrl = asset(
                'storage/' . ltrim($freelancerAvatar, '/')
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Service image
    |--------------------------------------------------------------------------
    */
    $serviceImage = data_get($serviceItem?->service, 'image_url')
        ?? data_get($serviceItem?->service, 'image')
        ?? data_get($serviceItem?->service, 'thumbnail_url')
        ?? data_get($serviceItem?->service, 'thumbnail')
        ?? data_get($serviceItem?->service, 'cover');

    $serviceImageUrl = null;

    if ($serviceImage) {
        if (
            filter_var($serviceImage, FILTER_VALIDATE_URL) ||
            str_starts_with($serviceImage, 'data:image/')
        ) {
            $serviceImageUrl = $serviceImage;
        } elseif (str_starts_with($serviceImage, '/')) {
            $serviceImageUrl = asset(
                ltrim($serviceImage, '/')
            );
        } elseif (
            str_starts_with($serviceImage, 'storage/') ||
            str_starts_with($serviceImage, 'uploads/')
        ) {
            $serviceImageUrl = asset($serviceImage);
        } else {
            $serviceImageUrl = asset(
                'storage/' . ltrim($serviceImage, '/')
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */
    $statusConfig = match ($order->status) {
        'pending_payment' => [
            'label' => 'Menunggu pembayaran',
            'short' => 'Belum Bayar',
            'dot' => 'bg-amber-500',
            'badge' => 'border-amber-200 bg-amber-50 text-amber-700',
            'soft' => 'bg-amber-50',
            'accent' => 'text-amber-700',
        ],

        'paid' => [
            'label' => 'Pembayaran diterima',
            'short' => 'Dibayar',
            'dot' => 'bg-blue-500',
            'badge' => 'border-blue-200 bg-blue-50 text-blue-700',
            'soft' => 'bg-blue-50',
            'accent' => 'text-blue-700',
        ],

        'in_progress' => [
            'label' => 'Sedang dikerjakan',
            'short' => 'Dikerjakan',
            'dot' => 'bg-indigo-500',
            'badge' => 'border-indigo-200 bg-indigo-50 text-indigo-700',
            'soft' => 'bg-indigo-50',
            'accent' => 'text-indigo-700',
        ],

        'delivered' => [
            'label' => 'Menunggu pemeriksaan',
            'short' => 'Dikirim',
            'dot' => 'bg-violet-500',
            'badge' => 'border-violet-200 bg-violet-50 text-violet-700',
            'soft' => 'bg-violet-50',
            'accent' => 'text-violet-700',
        ],

        'revision' => [
            'label' => 'Sedang direvisi',
            'short' => 'Revisi',
            'dot' => 'bg-orange-500',
            'badge' => 'border-orange-200 bg-orange-50 text-orange-700',
            'soft' => 'bg-orange-50',
            'accent' => 'text-orange-700',
        ],

        'completed' => [
            'label' => 'Pesanan selesai',
            'short' => 'Selesai',
            'dot' => 'bg-emerald-500',
            'badge' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
            'soft' => 'bg-emerald-50',
            'accent' => 'text-emerald-700',
        ],

        'cancelled' => [
            'label' => 'Pesanan dibatalkan',
            'short' => 'Dibatalkan',
            'dot' => 'bg-rose-500',
            'badge' => 'border-rose-200 bg-rose-50 text-rose-700',
            'soft' => 'bg-rose-50',
            'accent' => 'text-rose-700',
        ],

        default => [
            'label' => ucfirst(
                str_replace('_', ' ', $order->status ?? 'Tidak diketahui')
            ),
            'short' => ucfirst(
                str_replace('_', ' ', $order->status ?? 'Unknown')
            ),
            'dot' => 'bg-slate-400',
            'badge' => 'border-slate-200 bg-slate-50 text-slate-700',
            'soft' => 'bg-slate-50',
            'accent' => 'text-slate-700',
        ],
    };

    /*
    |--------------------------------------------------------------------------
    | Cancellation
    |--------------------------------------------------------------------------
    */
    $cancelableStatuses = [
        'pending_payment',
        'paid',
        'in_progress',
        'revision',
    ];

    $canRequestCancellation = in_array(
        $order->status,
        $cancelableStatuses,
        true
    );

    $latestCancellationRequest = $order->latestCancellationRequest;
    $cancellationStatus = $latestCancellationRequest?->status;

    /*
    |--------------------------------------------------------------------------
    | Dispute
    |--------------------------------------------------------------------------
    */
    $activeDispute = $order->activeDispute;

    $disputableStatuses = [
        'paid',
        'in_progress',
        'delivered',
        'revision',
    ];

    $canRequestDispute = in_array(
        $order->status,
        $disputableStatuses,
        true
    );

    /*
    |--------------------------------------------------------------------------
    | Refund
    |--------------------------------------------------------------------------
    */
    $latestRefund = $order->latestRefund;
    $refundStatus = $latestRefund?->status;
    $refundAmount = (float) (
        $latestRefund?->amount
        ?? $order->total
        ?? 0
    );

    /*
    |--------------------------------------------------------------------------
    | Review
    |--------------------------------------------------------------------------
    */
    $hasReview = $order->review !== null;

    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */
    $paymentStatusLabel = match ($order->payment?->status) {
        'paid' => 'Lunas',
        'pending' => 'Belum dibayar',
        'refund_pending' => 'Menunggu refund',
        'refunded' => 'Dana dikembalikan',
        'cancelled' => 'Dibatalkan',
        default => $order->payment
            ? ucfirst(
                str_replace(
                    '_',
                    ' ',
                    $order->payment->status
                )
            )
            : 'Belum tersedia',
    };

    $paymentStatusClass = match ($order->payment?->status) {
        'paid', 'refunded'
            => 'border-emerald-200 bg-emerald-50 text-emerald-700',

        'pending'
            => 'border-amber-200 bg-amber-50 text-amber-700',

        'refund_pending'
            => 'border-blue-200 bg-blue-50 text-blue-700',

        'cancelled'
            => 'border-slate-200 bg-slate-50 text-slate-600',

        default
            => 'border-slate-200 bg-slate-50 text-slate-600',
    };

    /*
    |--------------------------------------------------------------------------
    | Project progress
    |--------------------------------------------------------------------------
    */
    $progress = [
        [
            'key' => 'created',
            'label' => 'Pesanan dibuat',
            'active' => true,
        ],

        [
            'key' => 'paid',
            'label' => 'Pembayaran',
            'active' => in_array(
                $order->status,
                [
                    'paid',
                    'in_progress',
                    'delivered',
                    'revision',
                    'completed',
                ],
                true
            ) || in_array(
                $order->payment?->status,
                [
                    'paid',
                    'refund_pending',
                    'refunded',
                ],
                true
            ),
        ],

        [
            'key' => 'working',
            'label' => 'Pengerjaan',
            'active' => in_array(
                $order->status,
                [
                    'in_progress',
                    'delivered',
                    'revision',
                    'completed',
                ],
                true
            ),
        ],

        [
            'key' => 'delivery',
            'label' => 'Delivery',
            'active' => in_array(
                $order->status,
                [
                    'delivered',
                    'revision',
                    'completed',
                ],
                true
            ),
        ],

        [
            'key' => 'done',
            'label' => 'Selesai',
            'active' => $order->status === 'completed',
        ],
    ];

    /*
    |--------------------------------------------------------------------------
    | Activity feed
    |--------------------------------------------------------------------------
    */
    $activities = [];

    $activities[] = [
        'title' => 'Pesanan dibuat',
        'description' => 'Pesanan berhasil dibuat dan masuk ke proses pembayaran.',
        'date' => $order->created_at,
        'tone' => 'blue',
        'icon' => 'order',
    ];

    if (
        $order->payment ||
        in_array(
            $order->status,
            [
                'paid',
                'in_progress',
                'delivered',
                'revision',
                'completed',
            ],
            true
        )
    ) {
        $activities[] = [
            'title' => $order->payment?->status === 'refunded'
                ? 'Pembayaran dikembalikan'
                : 'Pembayaran dikonfirmasi',
            'description' => $order->payment?->status === 'refunded'
                ? 'Pembayaran pada order ini sudah masuk ke proses pengembalian dana.'
                : 'Pembayaran telah tercatat dan pesanan dapat diproses.',
            'date' => $order->payment?->paid_at
                ?? $order->payment?->updated_at
                ?? $order->updated_at,
            'tone' => 'blue',
            'icon' => 'payment',
        ];
    }

    if (
        in_array(
            $order->status,
            [
                'in_progress',
                'delivered',
                'revision',
                'completed',
            ],
            true
        )
    ) {
        $activities[] = [
            'title' => 'Freelancer mulai mengerjakan',
            'description' => 'Project mulai dikerjakan berdasarkan brief dan kebutuhan pesanan.',
            'date' => $order->updated_at,
            'tone' => 'indigo',
            'icon' => 'work',
        ];
    }

    if (
        in_array(
            $order->status,
            [
                'delivered',
                'revision',
                'completed',
            ],
            true
        )
    ) {
        $activities[] = [
            'title' => 'Hasil pekerjaan dikirim',
            'description' => 'Freelancer telah mengirimkan hasil pekerjaan untuk diperiksa.',
            'date' => $order->updated_at,
            'tone' => 'violet',
            'icon' => 'delivery',
        ];
    }

    if ($order->status === 'revision') {
        $activities[] = [
            'title' => 'Revisi sedang diproses',
            'description' => 'Freelancer sedang mengerjakan permintaan revisi.',
            'date' => $order->updated_at,
            'tone' => 'orange',
            'icon' => 'revision',
        ];
    }

    if ($order->status === 'completed') {
        $activities[] = [
            'title' => 'Pesanan selesai',
            'description' => 'Project telah selesai dan order ditutup.',
            'date' => $order->updated_at,
            'tone' => 'emerald',
            'icon' => 'completed',
        ];
    }

    if ($order->status === 'cancelled') {
        $activities[] = [
            'title' => 'Pesanan dibatalkan',
            'description' => $order->cancel_reason
                ?: 'Pesanan ini telah dibatalkan.',
            'date' => $order->updated_at,
            'tone' => 'rose',
            'icon' => 'cancelled',
        ];

        if ($refundStatus) {
            $activities[] = [
                'title' => match ($refundStatus) {
                    'pending' => 'Refund menunggu proses',
                    'processing' => 'Refund sedang diproses',
                    'refunded' => 'Refund selesai',
                    'rejected' => 'Refund belum berhasil',
                    default => 'Status refund diperbarui',
                },
                'description' => match ($refundStatus) {
                    'pending' => 'Pengembalian dana sedang menunggu proses.',
                    'processing' => 'Pengembalian dana sedang diproses.',
                    'refunded' => 'Dana berhasil dikembalikan kepada client.',
                    'rejected' => 'Pengajuan refund belum berhasil diselesaikan.',
                    default => 'Status refund telah diperbarui.',
                },
                'date' => $latestRefund?->completed_at
                    ?? $latestRefund?->updated_at,
                'tone' => $refundStatus === 'refunded'
                    ? 'emerald'
                    : 'blue',
                'icon' => 'refund',
            ];
        }
    }

    $activityTone = [
        'blue' => [
            'icon' => 'border-blue-200 bg-blue-50 text-blue-600',
            'marker' => 'bg-blue-500',
        ],
        'indigo' => [
            'icon' => 'border-indigo-200 bg-indigo-50 text-indigo-600',
            'marker' => 'bg-indigo-500',
        ],
        'violet' => [
            'icon' => 'border-violet-200 bg-violet-50 text-violet-600',
            'marker' => 'bg-violet-500',
        ],
        'orange' => [
            'icon' => 'border-orange-200 bg-orange-50 text-orange-600',
            'marker' => 'bg-orange-500',
        ],
        'emerald' => [
            'icon' => 'border-emerald-200 bg-emerald-50 text-emerald-600',
            'marker' => 'bg-emerald-500',
        ],
        'rose' => [
            'icon' => 'border-rose-200 bg-rose-50 text-rose-600',
            'marker' => 'bg-rose-500',
        ],
    ];

    /*
    |--------------------------------------------------------------------------
    | Current action
    |--------------------------------------------------------------------------
    */
    $primaryAction = match ($order->status) {
        'pending_payment' => [
            'label' => 'Lanjutkan Pembayaran',
            'url' => route(
                'client.orders.checkout',
                $order
            ),
        ],

        'delivered' => [
            'label' => 'Periksa Hasil',
            'url' => route(
                'client.delivery.show',
                $order
            ),
        ],

        'revision' => [
            'label' => 'Lihat Progress Revisi',
            'url' => route(
                'client.delivery.show',
                $order
            ),
        ],

        'completed' => [
            'label' => $hasReview
                ? 'Lihat Pesanan'
                : 'Beri Review',
            'url' => $hasReview
                ? route(
                    'client.orders.show',
                    $order
                )
                : route(
                    'client.reviews.create',
                    $order
                ),
        ],

        default => [
            'label' => 'Kirim Pesan',
            'url' => route(
                'client.messages.index'
            ),
        ],
    };
@endphp

<x-layouts.marketplace title="Detail Pesanan - ProKerja">

    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="mx-auto w-full max-w-7xl px-4 py-5 pb-28 sm:px-6 sm:py-7 lg:px-8 lg:pb-10">

            {{-- =========================================================
                BACK / ACTION
            ========================================================== --}}
            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <a
                    href="{{ route('client.orders.index') }}"
                    class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-[#2563EB]"
                >
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                            <path d="M19 12H5"/>
                            <path d="m12 19-7-7 7-7"/>
                        </svg>
                    </span>

                    Kembali ke pesanan
                </a>

                <div class="flex flex-wrap items-center gap-2">

                    <span class="text-xs font-medium text-slate-400">
                        {{ $order->order_number }}
                    </span>

                    @if (Route::has('client.orders.invoice'))
                        <a
                            href="{{ route('client.orders.invoice', $order) }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                        >
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M6 3h12a2 2 0 0 1 2 2v14l-4-2-4 2-4-2-4 2V5a2 2 0 0 1 2-2Z"/>
                                <path d="M9 8h6M9 12h6"/>
                            </svg>

                            Invoice
                        </a>
                    @endif

                </div>

            </div>


            {{-- =========================================================
                ALERTS
            ========================================================== --}}
            @if(session('success'))
                <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 sm:px-5">
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m5 12 4 4L19 6"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-bold text-emerald-800">
                                Berhasil
                            </p>

                            <p class="mt-0.5 text-sm leading-6 text-emerald-700">
                                {{ session('success') }}
                            </p>
                        </div>

                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 sm:px-5">
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-rose-600">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m8 8 8 8M16 8 8 16"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-bold text-rose-800">
                                Terjadi masalah
                            </p>

                            <p class="mt-0.5 text-sm leading-6 text-rose-700">
                                {{ session('error') }}
                            </p>
                        </div>

                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 sm:px-5">
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-rose-600">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M12 8v5"/>
                                <path d="M12 16h.01"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-bold text-rose-800">
                                Periksa kembali informasi berikut.
                            </p>

                            <div class="mt-1 space-y-1">
                                @foreach($errors->all() as $error)
                                    <p class="text-sm leading-5 text-rose-700">
                                        {{ $error }}
                                    </p>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            @endif


            {{-- =========================================================
                MAIN ORDER HEADER
            ========================================================== --}}
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="p-5 sm:p-6 lg:p-7">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                        <div class="flex min-w-0 flex-1 gap-4 sm:gap-5">

                            {{-- service image --}}
                            <div class="h-20 w-20 shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 sm:h-24 sm:w-24">

                                @if($serviceImageUrl)

                                    <img
                                        src="{{ $serviceImageUrl }}"
                                        alt="{{ $serviceTitle }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center bg-[#EFF6FF] text-[#2563EB]">
                                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                            <rect x="3" y="4" width="18" height="17" rx="2"/>
                                            <path d="M7 8h10M7 12h7M7 16h5"/>
                                        </svg>
                                    </div>

                                @endif

                            </div>


                            <div class="min-w-0">

                                <div class="flex flex-wrap items-center gap-2">

                                    <span class="text-xs font-bold uppercase tracking-[0.12em] text-[#2563EB]">
                                        Pesanan
                                    </span>

                                    <span class="text-xs text-slate-300">
                                        •
                                    </span>

                                    <span class="text-xs text-slate-400">
                                        {{ $order->order_number }}
                                    </span>

                                </div>

                                <h1 class="mt-2 max-w-4xl text-xl font-bold leading-7 tracking-tight text-slate-900 sm:text-2xl sm:leading-8">
                                    {{ $serviceTitle }}
                                </h1>

                                <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-slate-500">

                                    <span class="inline-flex items-center gap-2">
                                        <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <circle cx="12" cy="7" r="4"/>
                                            <path d="M4 21a8 8 0 0 1 16 0"/>
                                        </svg>
                                        {{ $freelancerName }}
                                    </span>

                                    <span class="inline-flex items-center gap-2">
                                        <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M12 7v5l3 2"/>
                                        </svg>
                                        {{ $order->delivery_days }} hari
                                    </span>

                                    @if($order->due_at)
                                        <span class="inline-flex items-center gap-2">
                                            <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                                                <path d="M16 2v4M8 2v4M3 9h18"/>
                                            </svg>
                                            Deadline {{ $order->due_at->format('d M Y') }}
                                        </span>
                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- status --}}
                        <div class="shrink-0">

                            <span class="inline-flex items-center gap-2 rounded-full border px-3.5 py-2 text-sm font-bold {{ $statusConfig['badge'] }}">

                                <span class="h-2 w-2 rounded-full {{ $statusConfig['dot'] }}"></span>

                                {{ $statusConfig['short'] }}

                            </span>

                        </div>

                    </div>

                </div>


                {{-- progress --}}
                <div class="border-t border-slate-100 px-5 py-5 sm:px-6 lg:px-7">

                    <div class="overflow-x-auto">

                        <div class="flex min-w-[650px] items-center">

                            @foreach($progress as $step)

                                @php
                                    $isLast = $loop->last;
                                @endphp

                                <div class="flex flex-1 items-center">

                                    <div class="flex min-w-0 items-center gap-2.5">

                                        <span
                                            class="
                                                flex h-8 w-8 shrink-0 items-center justify-center rounded-full border-2
                                                {{ $step['active']
                                                    ? 'border-[#2563EB] bg-[#2563EB] text-white'
                                                    : 'border-slate-200 bg-white text-slate-300'
                                                }}
                                            "
                                        >
                                            @if($step['active'])
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                                    <path d="m5 12 4 4L19 6"/>
                                                </svg>
                                            @else
                                                <span class="h-2 w-2 rounded-full bg-current"></span>
                                            @endif
                                        </span>

                                        <span class="min-w-0 text-xs font-semibold {{ $step['active'] ? 'text-slate-800' : 'text-slate-400' }}">
                                            {{ $step['label'] }}
                                        </span>

                                    </div>

                                    @if(!$isLast)
                                        <div class="mx-3 h-px flex-1 {{ $step['active'] ? 'bg-blue-200' : 'bg-slate-200' }}"></div>
                                    @endif

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                MAIN WORKSPACE
            ========================================================== --}}
            <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_340px]">

                {{-- =====================================================
                    PRIMARY CONTENT
                ====================================================== --}}
                <main class="min-w-0">

                    {{-- -------------------------------------------------
                        ACTIVITY / UPDATE FEED
                    -------------------------------------------------- --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 px-5 py-5 sm:px-6 lg:px-7">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                                        Update Pesanan
                                    </p>

                                    <h2 class="mt-1 text-xl font-bold tracking-tight text-slate-900">
                                        Perkembangan project
                                    </h2>

                                    <p class="mt-1 text-sm leading-6 text-slate-500">
                                        Ikuti perubahan dan perkembangan order kamu dari awal sampai selesai.
                                    </p>
                                </div>

                                <span class="text-xs font-medium text-slate-400">
                                    {{ count($activities) }} aktivitas
                                </span>

                            </div>

                        </div>


                        <div class="px-5 py-6 sm:px-6 lg:px-7 lg:py-7">

                            <div class="relative">

                                {{-- timeline connector --}}
                                <div class="absolute bottom-7 left-4 top-7 w-px bg-slate-200"></div>

                                <div class="space-y-0">

                                    @foreach($activities as $activity)

                                        @php
                                            $tone = $activityTone[$activity['tone']]
                                                ?? $activityTone['blue'];
                                        @endphp

                                        <div class="relative flex gap-4 pb-8 last:pb-0 sm:gap-5">

                                            {{-- marker --}}
                                            <div class="relative z-10 shrink-0">

                                                <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white shadow-sm {{ $tone['icon'] }}">

                                                    @switch($activity['icon'])

                                                        @case('order')
                                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <rect x="6" y="4" width="12" height="17" rx="2"/>
                                                                <path d="M9 4a3 3 0 0 1 6 0"/>
                                                                <path d="M9 9h6M9 13h6M9 17h4"/>
                                                            </svg>
                                                            @break

                                                        @case('payment')
                                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                                                <path d="M3 10h18"/>
                                                            </svg>
                                                            @break

                                                        @case('work')
                                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <rect x="3" y="7" width="18" height="13" rx="2"/>
                                                                <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                            </svg>
                                                            @break

                                                        @case('delivery')
                                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <path d="m22 2-7 20-4-9-9-4 20-7Z"/>
                                                                <path d="M22 2 11 13"/>
                                                            </svg>
                                                            @break

                                                        @case('revision')
                                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <path d="M20 11a8 8 0 0 0-14.9-3"/>
                                                                <path d="M4 4v5h5"/>
                                                                <path d="M4 13a8 8 0 0 0 14.9 3"/>
                                                                <path d="M20 20v-5h-5"/>
                                                            </svg>
                                                            @break

                                                        @case('completed')
                                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <circle cx="12" cy="12" r="9"/>
                                                                <path d="m8 12 2.5 2.5L16 9"/>
                                                            </svg>
                                                            @break

                                                        @case('cancelled')
                                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <path d="m8 8 8 8M16 8 8 16"/>
                                                            </svg>
                                                            @break

                                                        @case('refund')
                                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                                <path d="M3 12a9 9 0 0 1 15.5-6.3L21 8"/>
                                                                <path d="M21 3v5h-5"/>
                                                                <path d="M21 12a9 9 0 0 1-15.5 6.3L3 16"/>
                                                                <path d="M3 21v-5h5"/>
                                                            </svg>
                                                            @break

                                                        @default
                                                            <span class="h-2 w-2 rounded-full bg-current"></span>

                                                    @endswitch

                                                </div>

                                            </div>


                                            {{-- activity content --}}
                                            <div class="min-w-0 flex-1">

                                                <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between sm:gap-4">

                                                    <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                                                        {{ $activity['title'] }}
                                                    </h3>

                                                    @if($activity['date'])
                                                        <time class="shrink-0 text-xs text-slate-400">
                                                            {{ $activity['date']->format('d M Y, H:i') }}
                                                        </time>
                                                    @endif

                                                </div>

                                                <p class="mt-1.5 max-w-3xl text-sm leading-6 text-slate-500">
                                                    {{ $activity['description'] }}
                                                </p>


                                                {{-- delivery CTA --}}
                                                @if($activity['icon'] === 'delivery')

                                                    <div class="mt-4 border-l-2 border-violet-100 pl-4">

                                                        <p class="text-xs font-semibold text-slate-700">
                                                            Hasil pekerjaan tersedia
                                                        </p>

                                                        <p class="mt-1 text-xs leading-5 text-slate-400">
                                                            Periksa file dan detail hasil kerja dari freelancer.
                                                        </p>

                                                        <a
                                                            href="{{ route('client.delivery.show', $order) }}"
                                                            class="mt-3 inline-flex items-center gap-2 text-xs font-bold text-violet-700 transition hover:text-violet-800"
                                                        >
                                                            Buka delivery
                                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                                                <path d="M5 12h14"/>
                                                                <path d="m13 6 6 6-6 6"/>
                                                            </svg>
                                                        </a>

                                                    </div>

                                                @endif


                                                {{-- revision --}}
                                                @if($activity['icon'] === 'revision')

                                                    <div class="mt-4 border-l-2 border-orange-100 pl-4">

                                                        <p class="text-xs font-semibold text-slate-700">
                                                            Revisi sedang diproses
                                                        </p>

                                                        <p class="mt-1 text-xs leading-5 text-slate-400">
                                                            Freelancer sedang menindaklanjuti permintaan revisi.
                                                        </p>

                                                        <a
                                                            href="{{ route('client.delivery.show', $order) }}"
                                                            class="mt-3 inline-flex items-center gap-2 text-xs font-bold text-orange-700 transition hover:text-orange-800"
                                                        >
                                                            Lihat progress
                                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                                                <path d="M5 12h14"/>
                                                                <path d="m13 6 6 6-6 6"/>
                                                            </svg>
                                                        </a>

                                                    </div>

                                                @endif


                                                {{-- completed --}}
                                                @if($activity['icon'] === 'completed')

                                                    <div class="mt-4 border-l-2 border-emerald-100 pl-4">

                                                        @if($hasReview)

                                                            <p class="text-xs font-semibold text-emerald-700">
                                                                Review sudah diberikan
                                                            </p>

                                                            <p class="mt-1 text-xs leading-5 text-slate-400">
                                                                Terima kasih sudah memberikan feedback kepada freelancer.
                                                            </p>

                                                        @else

                                                            <p class="text-xs font-semibold text-slate-700">
                                                                Bagikan pengalamanmu
                                                            </p>

                                                            <p class="mt-1 text-xs leading-5 text-slate-400">
                                                                Beri review untuk membantu freelancer meningkatkan layanannya.
                                                            </p>

                                                            <a
                                                                href="{{ route('client.reviews.create', $order) }}"
                                                                class="mt-3 inline-flex items-center gap-2 text-xs font-bold text-[#2563EB] transition hover:text-blue-700"
                                                            >
                                                                Beri review
                                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                                                    <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4-1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"/>
                                                                </svg>
                                                            </a>

                                                        @endif

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- -------------------------------------------------
                        PROJECT DETAILS
                    -------------------------------------------------- --}}
                    <section class="mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        {{-- service --}}
                        <div class="px-5 py-5 sm:px-6 lg:px-7">

                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                                Detail Project
                            </p>

                            <h2 class="mt-1 text-xl font-bold tracking-tight text-slate-900">
                                Pesanan kamu
                            </h2>

                            <div class="mt-5 divide-y divide-slate-100">

                                @foreach($order->items as $item)

                                    <div class="flex flex-col gap-3 py-4 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">

                                        <div class="flex min-w-0 items-start gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                                                    <path d="M7 9h10M7 13h7"/>
                                                </svg>
                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-sm font-bold leading-6 text-slate-900">
                                                    {{ $item->service_title }}
                                                </p>

                                                <p class="mt-1 text-xs text-slate-400">
                                                    {{ $item->quantity }}
                                                    ×
                                                    Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                                                </p>

                                            </div>

                                        </div>

                                        <p class="shrink-0 text-sm font-bold text-slate-900">
                                            Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                        </p>

                                    </div>

                                @endforeach

                            </div>

                        </div>


                        {{-- brief --}}
                        <div class="border-t border-slate-100 px-5 py-5 sm:px-6 lg:px-7">

                            <p class="text-sm font-bold text-slate-900">
                                Brief & kebutuhan
                            </p>

                            @if($order->requirements)

                                <div class="mt-4 rounded-2xl bg-slate-50 p-4 sm:p-5">

                                    <p class="whitespace-pre-line text-sm leading-7 text-slate-600">
                                        {{ $order->requirements }}
                                    </p>

                                </div>

                            @else

                                <div class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-center">

                                    <p class="text-sm font-semibold text-slate-600">
                                        Tidak ada kebutuhan tambahan.
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Tidak ada brief tambahan yang tercatat pada order ini.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </section>


                    {{-- -------------------------------------------------
                        CANCELLATION STATES
                    -------------------------------------------------- --}}
                    @if($order->status === 'cancelled')

                        <section class="mt-5 rounded-3xl border border-rose-200 bg-rose-50 p-5 sm:p-6">

                            <div class="flex items-start gap-4">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-rose-600 shadow-sm">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="m8 8 8 8M16 8 8 16"/>
                                    </svg>
                                </div>

                                <div class="min-w-0">

                                    <h2 class="text-base font-bold text-rose-800">
                                        Pesanan dibatalkan
                                    </h2>

                                    <p class="mt-1 text-sm leading-6 text-rose-700/80">
                                        Pesanan ini sudah ditutup dan tidak dapat dilanjutkan.
                                    </p>

                                    @if($order->cancel_reason)

                                        <div class="mt-4 border-l-2 border-rose-200 pl-4">

                                            <p class="text-xs font-bold text-rose-500">
                                                Alasan pembatalan
                                            </p>

                                            <p class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">
                                                {{ $order->cancel_reason }}
                                            </p>

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </section>

                    @elseif($cancellationStatus === 'pending_freelancer')

                        <section class="mt-5 rounded-3xl border border-amber-200 bg-amber-50 p-5 sm:p-6">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-start gap-4">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-amber-700 shadow-sm">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M12 7v5l3 2"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <h2 class="text-base font-bold text-amber-900">
                                            Menunggu tanggapan freelancer
                                        </h2>

                                        <p class="mt-1 text-sm leading-6 text-amber-800/75">
                                            Pengajuan pembatalan sudah dikirim.
                                        </p>
                                    </div>

                                </div>

                                <a
                                    href="{{ route('client.orders.cancellation.create', $order) }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-amber-200 bg-white px-4 py-3 text-sm font-semibold text-amber-800 transition hover:bg-amber-100"
                                >
                                    Lihat Pengajuan
                                </a>

                            </div>

                        </section>

                    @elseif($cancellationStatus === 'rejected_by_freelancer')

                        <section class="mt-5 rounded-3xl border border-rose-200 bg-rose-50 p-5 sm:p-6">

                            <div class="flex items-start gap-4">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-rose-600 shadow-sm">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="m8 8 8 8M16 8 8 16"/>
                                    </svg>
                                </div>

                                <div class="min-w-0">

                                    <h2 class="text-base font-bold text-rose-800">
                                        Pembatalan ditolak freelancer
                                    </h2>

                                    <p class="mt-1 text-sm leading-6 text-rose-700/80">
                                        Kamu dapat melanjutkan pengajuan melalui mediasi Admin.
                                    </p>

                                    @if($latestCancellationRequest?->freelancer_note)

                                        <div class="mt-4 border-l-2 border-rose-200 pl-4">

                                            <p class="text-xs font-bold text-rose-500">
                                                Tanggapan freelancer
                                            </p>

                                            <p class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">
                                                {{ $latestCancellationRequest->freelancer_note }}
                                            </p>

                                        </div>

                                    @endif

                                    <a
                                        href="{{ route('client.orders.cancellation.create', $order) }}"
                                        class="mt-4 inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-3 text-sm font-bold text-rose-700 shadow-sm transition hover:bg-rose-100"
                                    >
                                        Ajukan Mediasi
                                    </a>

                                </div>

                            </div>

                        </section>

                    @elseif($cancellationStatus === 'mediation_pending')

                        <section class="mt-5 rounded-3xl border border-blue-200 bg-blue-50 p-5 sm:p-6">

                            <div class="flex items-start gap-4">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-blue-700 shadow-sm">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M12 3 4 6v5c0 5 3.5 8.5 8 10 4.5-1.5 8-5 8-10V6l-8-3Z"/>
                                        <path d="m9 12 2 2 4-4"/>
                                    </svg>
                                </div>

                                <div>

                                    <h2 class="text-base font-bold text-blue-900">
                                        Mediasi sedang ditinjau Admin
                                    </h2>

                                    <p class="mt-1 text-sm leading-6 text-blue-800/75">
                                        Pengajuan pembatalan sedang ditinjau oleh Admin.
                                    </p>

                                    @if($latestCancellationRequest?->mediation_reason)

                                        <div class="mt-4 border-l-2 border-blue-200 pl-4">

                                            <p class="text-xs font-bold text-blue-500">
                                                Alasan mediasi
                                            </p>

                                            <p class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">
                                                {{ $latestCancellationRequest->mediation_reason }}
                                            </p>

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </section>

                    @elseif($cancellationStatus === 'rejected_by_admin')

                        <section class="mt-5 rounded-3xl border border-rose-200 bg-rose-50 p-5 sm:p-6">

                            <div class="flex items-start gap-4">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-rose-600 shadow-sm">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="m8 8 8 8M16 8 8 16"/>
                                    </svg>
                                </div>

                                <div>

                                    <h2 class="text-base font-bold text-rose-800">
                                        Mediasi ditolak Admin
                                    </h2>

                                    <p class="mt-1 text-sm leading-6 text-rose-700/80">
                                        Order tetap berjalan seperti biasa.
                                    </p>

                                    @if($latestCancellationRequest?->admin_note)

                                        <div class="mt-4 border-l-2 border-rose-200 pl-4">

                                            <p class="text-xs font-bold text-rose-500">
                                                Catatan Admin
                                            </p>

                                            <p class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">
                                                {{ $latestCancellationRequest->admin_note }}
                                            </p>

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </section>

                    @elseif(in_array($cancellationStatus, ['approved_by_freelancer', 'approved_by_admin'], true))

                        <section class="mt-5 rounded-3xl border border-emerald-200 bg-emerald-50 p-5 sm:p-6">

                            <div class="flex items-start gap-4">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-emerald-700 shadow-sm">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="m8 12 2.5 2.5L16 9"/>
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="text-base font-bold text-emerald-900">
                                        Pembatalan disetujui
                                    </h2>

                                    <p class="mt-1 text-sm leading-6 text-emerald-800/75">
                                        Pembatalan telah disetujui melalui proses yang berlaku.
                                    </p>
                                </div>

                            </div>

                        </section>

                    @elseif($canRequestCancellation)

                        <section class="mt-5 rounded-3xl border border-amber-200 bg-amber-50 p-5 sm:p-6">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-start gap-4">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-amber-700 shadow-sm">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M8 12h8"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <h2 class="text-base font-bold text-amber-900">
                                            Perlu membatalkan pesanan?
                                        </h2>

                                        <p class="mt-1 text-sm leading-6 text-amber-800/75">
                                            Kamu dapat mengajukan pembatalan pesanan.
                                        </p>
                                    </div>

                                </div>

                                <a
                                    href="{{ route('client.orders.cancellation.create', $order) }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-amber-200 bg-white px-4 py-3 text-sm font-semibold text-amber-800 transition hover:bg-amber-100"
                                >
                                    Ajukan Pembatalan
                                </a>

                            </div>

                        </section>

                    @endif

                </main>


                {{-- =====================================================
                    SIDEBAR
                ====================================================== --}}
                <aside class="min-w-0 space-y-5">

                    {{-- -------------------------------------------------
                        CURRENT ACTION
                    -------------------------------------------------- --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                            Aksi berikutnya
                        </p>

                        <h2 class="mt-1 text-lg font-bold text-slate-900">
                            {{ $statusConfig['label'] }}
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-500">

                            @switch($order->status)

                                @case('pending_payment')
                                    Selesaikan pembayaran agar freelancer dapat mulai mengerjakan.
                                    @break

                                @case('paid')
                                    Pesanan sudah dibayar dan menunggu proses pengerjaan.
                                    @break

                                @case('in_progress')
                                    Freelancer sedang mengerjakan project kamu.
                                    @break

                                @case('delivered')
                                    Periksa hasil pekerjaan yang sudah dikirim freelancer.
                                    @break

                                @case('revision')
                                    Freelancer sedang memproses revisi yang diminta.
                                    @break

                                @case('completed')
                                    Project sudah selesai diproses.
                                    @break

                                @case('cancelled')
                                    Pesanan sudah tidak aktif.
                                    @break

                                @default
                                    Lihat perkembangan terbaru pada aktivitas pesanan.
                            @endswitch

                        </p>

                        @if($order->status !== 'cancelled')

                            <a
                                href="{{ $primaryAction['url'] }}"
                                class="mt-5 inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-sm font-bold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700"
                            >
                                {{ $primaryAction['label'] }}

                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                    <path d="M5 12h14"/>
                                    <path d="m13 6 6 6-6 6"/>
                                </svg>
                            </a>

                        @endif

                        <a
                            href="{{ route('client.messages.index') }}"
                            class="mt-2 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                        >
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M20 11.5a7.5 7.5 0 0 1-8 7.5 8.5 8.5 0 0 1-4.2-1.1L4 19l1.2-3.2A7.4 7.4 0 0 1 4.5 8 7.5 7.5 0 0 1 12 4.5c4.1 0 8 2.4 8 7Z"/>
                                <path d="M8 10.5h.01M12 10.5h.01M16 10.5h.01"/>
                            </svg>

                            Pesan Freelancer
                        </a>

                    </section>


                    {{-- -------------------------------------------------
                        FREELANCER
                    -------------------------------------------------- --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                            Freelancer
                        </p>

                        <div class="mt-4 flex items-center gap-3">

                            <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-white bg-blue-100 shadow-sm">

                                @if($freelancerAvatarUrl)

                                    <img
                                        src="{{ $freelancerAvatarUrl }}"
                                        alt="{{ $freelancerName }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center text-sm font-bold text-blue-700">
                                        {{ $freelancerInitial }}
                                    </div>

                                @endif

                            </div>

                            <div class="min-w-0">

                                <p class="truncate text-sm font-bold text-slate-900">
                                    {{ $freelancerName }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">
                                    Freelancer ProKerja
                                </p>

                            </div>

                        </div>

                    </section>


                    {{-- -------------------------------------------------
                        PAYMENT SUMMARY
                    -------------------------------------------------- --}}
                    <section class="rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="p-5 sm:p-6">

                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                                Pembayaran
                            </p>

                            <h2 class="mt-1 text-lg font-bold text-slate-900">
                                Ringkasan biaya
                            </h2>

                            <div class="mt-5 space-y-4">

                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-sm text-slate-500">
                                        Subtotal
                                    </span>

                                    <span class="text-sm font-semibold text-slate-800">
                                        Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-sm text-slate-500">
                                        Biaya platform
                                    </span>

                                    <span class="text-sm font-semibold text-slate-800">
                                        Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="border-t border-slate-100 pt-4">

                                    <div class="flex items-end justify-between gap-4">

                                        <span class="text-sm font-bold text-slate-700">
                                            Total
                                        </span>

                                        <span class="text-xl font-bold tracking-tight text-slate-900">
                                            Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="border-t border-slate-100 px-5 py-5 sm:px-6">

                            <div class="flex items-center justify-between gap-3">

                                <span class="text-sm text-slate-500">
                                    Status
                                </span>

                                <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-bold {{ $paymentStatusClass }}">
                                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                    {{ $paymentStatusLabel }}
                                </span>

                            </div>

                            @if($order->payment)

                                <div class="mt-4 space-y-4">

                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-sm text-slate-500">
                                            Metode
                                        </span>

                                        <span class="max-w-[170px] truncate text-right text-sm font-semibold text-slate-800">
                                            {{ strtoupper($order->payment->payment_type ?? '-') }}
                                        </span>
                                    </div>

                                    @if($order->payment->transaction_id)

                                        <div class="flex items-start justify-between gap-4">
                                            <span class="text-sm text-slate-500">
                                                Transaksi
                                            </span>

                                            <span class="max-w-[170px] break-all text-right text-xs font-semibold text-slate-700">
                                                {{ $order->payment->transaction_id }}
                                            </span>
                                        </div>

                                    @endif

                                    @if($order->payment->paid_at)

                                        <div class="flex items-center justify-between gap-4">
                                            <span class="text-sm text-slate-500">
                                                Dibayar
                                            </span>

                                            <span class="text-right text-xs font-semibold text-slate-700">
                                                {{ $order->payment->paid_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>

                                    @endif

                                </div>

                            @endif

                            @if($latestRefund)

                                <div class="mt-5 rounded-2xl bg-slate-50 p-4">

                                    <div class="flex items-center justify-between gap-3">

                                        <span class="text-sm text-slate-500">
                                            Refund
                                        </span>

                                        <span class="text-sm font-bold text-slate-800">
                                            {{ match($refundStatus) {
                                                'pending' => 'Menunggu',
                                                'processing' => 'Diproses',
                                                'refunded' => 'Selesai',
                                                'rejected' => 'Ditolak',
                                                default => ucfirst(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $refundStatus ?? 'Tidak tersedia'
                                                    )
                                                ),
                                            } }}
                                        </span>

                                    </div>

                                    <div class="mt-3 flex items-center justify-between gap-3">

                                        <span class="text-sm text-slate-500">
                                            Nominal
                                        </span>

                                        <span class="text-sm font-bold text-emerald-700">
                                            Rp {{ number_format($refundAmount, 0, ',', '.') }}
                                        </span>

                                    </div>

                                </div>

                            @endif

                            @if($order->status === 'pending_payment')

                                <a
                                    href="{{ route('client.orders.checkout', $order) }}"
                                    class="mt-5 inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-sm font-bold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700"
                                >
                                    Lanjutkan Pembayaran

                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                        <path d="M5 12h14"/>
                                        <path d="m13 6 6 6-6 6"/>
                                    </svg>
                                </a>

                            @endif

                        </div>


                        @if(Route::has('client.orders.invoice'))

                            <div class="border-t border-slate-100 p-5 sm:p-6">

                                <a
                                    href="{{ route('client.orders.invoice', $order) }}"
                                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                                >
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M6 3h12a2 2 0 0 1 2 2v14l-4-2-4 2-4-2-4 2V5a2 2 0 0 1 2-2Z"/>
                                        <path d="M9 8h6M9 12h6"/>
                                    </svg>

                                    Lihat Invoice
                                </a>

                            </div>

                        @endif

                    </section>


                    {{-- -------------------------------------------------
                        DISPUTE
                    -------------------------------------------------- --}}
                    @if($activeDispute)

                        <section class="rounded-3xl border border-violet-200 bg-violet-50 p-5 sm:p-6">

                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-violet-700">
                                Perlindungan
                            </p>

                            <h2 class="mt-1 text-lg font-bold text-slate-900">
                                Dispute sedang berjalan
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Order ini sedang dalam proses penyelesaian sengketa.
                            </p>

                            <a
                                href="{{ route('client.disputes.show', $activeDispute) }}"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-white px-4 text-sm font-bold text-violet-700 shadow-sm transition hover:bg-violet-100"
                            >
                                Lihat Dispute

                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M5 12h14"/>
                                    <path d="m13 6 6 6-6 6"/>
                                </svg>
                            </a>

                        </section>

                    @elseif($canRequestDispute && !in_array($cancellationStatus, ['pending_freelancer', 'mediation_pending'], true))

                        <section class="rounded-3xl border border-violet-200 bg-violet-50 p-5 sm:p-6">

                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-violet-700">
                                Perlindungan
                            </p>

                            <h2 class="mt-1 text-lg font-bold text-slate-900">
                                Ada masalah dengan order?
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Ajukan dispute jika ada masalah dengan project.
                            </p>

                            <a
                                href="{{ route('client.orders.dispute.create', $order) }}"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-white px-4 text-sm font-bold text-violet-700 shadow-sm transition hover:bg-violet-100"
                            >
                                Ajukan Dispute

                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M5 12h14"/>
                                    <path d="m13 6 6 6-6 6"/>
                                </svg>
                            </a>

                        </section>

                    @endif


                    {{-- -------------------------------------------------
                        DEADLINE
                    -------------------------------------------------- --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                            Pengerjaan
                        </p>

                        <h2 class="mt-1 text-lg font-bold text-slate-900">
                            Waktu project
                        </h2>

                        <div class="mt-5 space-y-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="4" width="18" height="17" rx="2"/>
                                        <path d="M16 2v4M8 2v4M3 9h18"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs text-slate-400">
                                        Deadline
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-800">
                                        {{ $order->due_at?->format('d M Y, H:i') ?? '-' }}
                                    </p>
                                </div>

                            </div>

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs text-slate-400">
                                        Durasi
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-800">
                                        {{ $order->delivery_days }} hari
                                    </p>
                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- -------------------------------------------------
                        HELP
                    -------------------------------------------------- --}}
                    <section class="rounded-3xl border border-blue-100 bg-[#EFF6FF] p-5 sm:p-6">

                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                            Bantuan
                        </p>

                        <h2 class="mt-1 text-lg font-bold text-slate-900">
                            Butuh bantuan?
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            Gunakan pesan untuk berkomunikasi dengan freelancer terkait project.
                        </p>

                        <a
                            href="{{ route('client.messages.index') }}"
                            class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-white px-4 text-sm font-bold text-slate-700 shadow-sm transition hover:text-[#2563EB]"
                        >
                            Buka Pesan

                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M5 12h14"/>
                                <path d="m13 6 6 6-6 6"/>
                            </svg>
                        </a>

                    </section>

                </aside>

            </div>

        </div>


        {{-- =============================================================
            MOBILE ACTION BAR
        ============================================================= --}}
        <div class="fixed inset-x-0 bottom-0 z-40 border-t border-slate-200 bg-white/95 p-3 shadow-[0_-8px_30px_rgba(15,23,42,0.08)] backdrop-blur lg:hidden">

            <div class="mx-auto flex max-w-7xl gap-2">

                <a
                    href="{{ route('client.messages.index') }}"
                    aria-label="Pesan freelancer"
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M20 11.5a7.5 7.5 0 0 1-8 7.5 8.5 8.5 0 0 1-4.2-1.1L4 19l1.2-3.2A7.4 7.4 0 0 1 4.5 8 7.5 7.5 0 0 1 12 4.5c4.1 0 8 2.4 8 7Z"/>
                        <path d="M8 10.5h.01M12 10.5h.01M16 10.5h.01"/>
                    </svg>
                </a>

                @if($order->status !== 'cancelled')

                    <a
                        href="{{ $primaryAction['url'] }}"
                        class="flex h-12 flex-1 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-sm font-bold text-white shadow-sm shadow-blue-200"
                    >
                        {{ $primaryAction['label'] }}

                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                            <path d="M5 12h14"/>
                            <path d="m13 6 6 6-6 6"/>
                        </svg>
                    </a>

                @else

                    <a
                        href="{{ route('client.orders.index') }}"
                        class="flex h-12 flex-1 items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 text-sm font-bold text-white"
                    >
                        Kembali ke Pesanan

                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                            <path d="M5 12h14"/>
                            <path d="m13 6 6 6-6 6"/>
                        </svg>
                    </a>

                @endif

            </div>

        </div>

    </div>

</x-layouts.marketplace>
