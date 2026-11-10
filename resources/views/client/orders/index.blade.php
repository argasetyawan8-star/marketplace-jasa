@php
    $statusFilter = request('status');

    $statusMeta = [
        'pending_payment' => [
            'label' => 'Belum Bayar',
            'short' => 'Belum Bayar',
            'icon' => 'card',
            'bg' => 'bg-amber-50',
            'text' => 'text-amber-700',
            'border' => 'border-amber-200',
            'dot' => 'bg-amber-500',
            'soft' => 'bg-amber-100',
        ],
        'paid' => [
            'label' => 'Dibayar',
            'short' => 'Dibayar',
            'icon' => 'check',
            'bg' => 'bg-blue-50',
            'text' => 'text-blue-700',
            'border' => 'border-blue-200',
            'dot' => 'bg-blue-500',
            'soft' => 'bg-blue-100',
        ],
        'in_progress' => [
            'label' => 'Dikerjakan',
            'short' => 'Dikerjakan',
            'icon' => 'work',
            'bg' => 'bg-indigo-50',
            'text' => 'text-indigo-700',
            'border' => 'border-indigo-200',
            'dot' => 'bg-indigo-500',
            'soft' => 'bg-indigo-100',
        ],
        'delivered' => [
            'label' => 'Dikirim',
            'short' => 'Dikirim',
            'icon' => 'send',
            'bg' => 'bg-violet-50',
            'text' => 'text-violet-700',
            'border' => 'border-violet-200',
            'dot' => 'bg-violet-500',
            'soft' => 'bg-violet-100',
        ],
        'revision' => [
            'label' => 'Revisi',
            'short' => 'Revisi',
            'icon' => 'refresh',
            'bg' => 'bg-orange-50',
            'text' => 'text-orange-700',
            'border' => 'border-orange-200',
            'dot' => 'bg-orange-500',
            'soft' => 'bg-orange-100',
        ],
        'completed' => [
            'label' => 'Selesai',
            'short' => 'Selesai',
            'icon' => 'completed',
            'bg' => 'bg-emerald-50',
            'text' => 'text-emerald-700',
            'border' => 'border-emerald-200',
            'dot' => 'bg-emerald-500',
            'soft' => 'bg-emerald-100',
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'short' => 'Dibatalkan',
            'icon' => 'x',
            'bg' => 'bg-rose-50',
            'text' => 'text-rose-700',
            'border' => 'border-rose-200',
            'dot' => 'bg-rose-500',
            'soft' => 'bg-rose-100',
        ],
    ];

    $filterItems = [
        '' => 'Semua Pesanan',
        'pending_payment' => 'Belum Bayar',
        'paid' => 'Dibayar',
        'in_progress' => 'Dikerjakan',
        'delivered' => 'Dikirim',
        'revision' => 'Revisi',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    $activeLabel = $filterItems[$statusFilter ?? ''] ?? 'Semua Pesanan';
    $totalOrders = $orders->total();
@endphp

<x-layouts.marketplace title="Pembelian Saya - ProKerja">
    <div class="min-h-screen bg-[#F8FAFC]">
        <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            {{-- Header --}}
            <section class="mb-6 sm:mb-8">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-2xl">
                        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-blue-600 text-white">
                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <path d="M8 6h13M8 12h13M8 18h13"/>
                                    <path d="M3 6h.01M3 12h.01M3 18h.01"/>
                                </svg>
                            </span>
                            Area Pembelian
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Pembelian Saya
                        </h1>

                        <p class="mt-2 text-sm leading-6 text-slate-500 sm:text-base">
                            Pantau semua project yang sedang kamu pesan, dari pembayaran hingga selesai.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-400">
                                Total pesanan
                            </p>
                            <p class="mt-1 text-xl font-bold text-slate-900">
                                {{ number_format($totalOrders) }}
                            </p>
                        </div>

                        @if (Route::has('marketplace.search'))
                            <a
                                href="{{ route('marketplace.search') }}"
                                class="hidden items-center gap-2 rounded-2xl bg-[#2563EB] px-4 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:-translate-y-0.5 hover:bg-blue-700 sm:inline-flex"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="7"/>
                                    <path d="m20 20-4-4"/>
                                </svg>
                                Cari Jasa Lagi
                            </a>
                        @endif
                    </div>
                </div>
            </section>

            {{-- Status filter --}}
            <section class="mb-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-sm">
                    <div class="flex gap-1 overflow-x-auto pb-1 scrollbar-none">
                        @foreach ($filterItems as $key => $label)
                            @php
                                $isActive = ($statusFilter ?? '') === $key;
                                $filterUrl = $key !== ''
                                    ? route('client.orders.index', ['status' => $key])
                                    : route('client.orders.index');
                            @endphp

                            <a
                                href="{{ $filterUrl }}"
                                @class([
                                    'inline-flex shrink-0 items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition duration-200',
                                    'bg-[#EFF6FF] text-[#2563EB]' => $isActive,
                                    'text-slate-500 hover:bg-slate-50 hover:text-slate-800' => !$isActive,
                                ])
                            >
                                @if ($key !== '')
                                    <span
                                        @class([
                                            'h-2 w-2 rounded-full',
                                            $statusMeta[$key]['dot'] => isset($statusMeta[$key]),
                                        ])
                                    ></span>
                                @endif

                                {{ $label }}

                                @if ($isActive)
                                    <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-bold text-blue-700">
                                        {{ $totalOrders }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Content --}}
            @if ($orders->count())
                <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 sm:text-lg">
                            {{ $activeLabel }}
                        </h2>
                        <p class="text-sm text-slate-500">
                            {{ $totalOrders }} pesanan ditemukan
                        </p>
                    </div>

                    @if ($statusFilter)
                        <a
                            href="{{ route('client.orders.index') }}"
                            class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-[#2563EB] transition hover:text-blue-700"
                        >
                            Tampilkan semua
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14"/>
                                <path d="m13 6 6 6-6 6"/>
                            </svg>
                        </a>
                    @endif
                </div>

                <div class="space-y-4">
                    @foreach ($orders as $order)
                        @php
                            $meta = $statusMeta[$order->status] ?? [
                                'label' => ucfirst(str_replace('_', ' ', $order->status ?? 'unknown')),
                                'short' => ucfirst(str_replace('_', ' ', $order->status ?? 'unknown')),
                                'icon' => 'work',
                                'bg' => 'bg-slate-50',
                                'text' => 'text-slate-700',
                                'border' => 'border-slate-200',
                                'dot' => 'bg-slate-400',
                                'soft' => 'bg-slate-100',
                            ];

                            $item = $order->items->first();
                            $service = $item?->service;
                            $freelancerProfile = $order->freelancerProfile;
                            $freelancer = $freelancerProfile?->user;

                            $serviceTitle = $item?->service_title
                                ?? $service?->title
                                ?? 'Layanan ProKerja';

                            $serviceSlug = $service?->slug;

                            $serviceImage = data_get($service, 'image_url')
                                ?? data_get($service, 'image')
                                ?? data_get($service, 'thumbnail_url')
                                ?? data_get($service, 'thumbnail')
                                ?? data_get($service, 'cover');

                            $serviceImageUrl = null;

                            if ($serviceImage) {
                                if (
                                    filter_var($serviceImage, FILTER_VALIDATE_URL) ||
                                    str_starts_with($serviceImage, 'data:image/')
                                ) {
                                    $serviceImageUrl = $serviceImage;
                                } elseif (str_starts_with($serviceImage, '/')) {
                                    $serviceImageUrl = asset(ltrim($serviceImage, '/'));
                                } elseif (
                                    str_starts_with($serviceImage, 'storage/') ||
                                    str_starts_with($serviceImage, 'uploads/')
                                ) {
                                    $serviceImageUrl = asset($serviceImage);
                                } else {
                                    $serviceImageUrl = asset('storage/' . ltrim($serviceImage, '/'));
                                }
                            }

                            $freelancerAvatar = data_get($freelancer, 'avatar_url')
                                ?? data_get($freelancer, 'profile_photo_url')
                                ?? data_get($freelancer, 'avatar')
                                ?? data_get($freelancer, 'photo');

                            $freelancerAvatarUrl = null;

                            if ($freelancerAvatar) {
                                if (
                                    filter_var($freelancerAvatar, FILTER_VALIDATE_URL) ||
                                    str_starts_with($freelancerAvatar, 'data:image/')
                                ) {
                                    $freelancerAvatarUrl = $freelancerAvatar;
                                } elseif (str_starts_with($freelancerAvatar, '/')) {
                                    $freelancerAvatarUrl = asset(ltrim($freelancerAvatar, '/'));
                                } elseif (
                                    str_starts_with($freelancerAvatar, 'storage/') ||
                                    str_starts_with($freelancerAvatar, 'uploads/')
                                ) {
                                    $freelancerAvatarUrl = asset($freelancerAvatar);
                                } else {
                                    $freelancerAvatarUrl = asset('storage/' . ltrim($freelancerAvatar, '/'));
                                }
                            }

                            $freelancerName = $freelancer?->name ?? 'Freelancer';
                            $freelancerInitial = strtoupper(substr(trim($freelancerName), 0, 1));

                            $categoryName = data_get($service, 'category.name')
                                ?? data_get($service, 'subcategory.name')
                                ?? 'Layanan';

                            $total = (float) ($order->total ?? 0);

                            $dueDate = null;
                            $dueHuman = null;

                            if ($order->due_at) {
                                $dueDate = \Illuminate\Support\Carbon::parse($order->due_at);
                                $dueHuman = $dueDate->diffForHumans();
                            }

                            $nextAction = match ($order->status) {
                                'pending_payment' => [
                                    'title' => 'Pesanan menunggu pembayaran',
                                    'description' => 'Lanjutkan pembayaran agar freelancer bisa mulai mengerjakan project.',
                                    'class' => 'border-amber-100 bg-amber-50/70',
                                    'iconClass' => 'bg-amber-100 text-amber-700',
                                ],
                                'paid' => [
                                    'title' => 'Pembayaran diterima',
                                    'description' => 'Pesanan sudah dibayar dan siap diproses oleh freelancer.',
                                    'class' => 'border-blue-100 bg-blue-50/60',
                                    'iconClass' => 'bg-blue-100 text-blue-700',
                                ],
                                'in_progress' => [
                                    'title' => 'Project sedang dikerjakan',
                                    'description' => 'Freelancer sedang mengerjakan project sesuai brief yang diberikan.',
                                    'class' => 'border-indigo-100 bg-indigo-50/60',
                                    'iconClass' => 'bg-indigo-100 text-indigo-700',
                                ],
                                'delivered' => [
                                    'title' => 'Hasil kerja sudah dikirim',
                                    'description' => 'Periksa hasil pekerjaan dan lanjutkan ke proses berikutnya dari detail order.',
                                    'class' => 'border-violet-100 bg-violet-50/60',
                                    'iconClass' => 'bg-violet-100 text-violet-700',
                                ],
                                'revision' => [
                                    'title' => 'Revisi sedang diproses',
                                    'description' => 'Freelancer sedang menindaklanjuti permintaan revisi dari kamu.',
                                    'class' => 'border-orange-100 bg-orange-50/60',
                                    'iconClass' => 'bg-orange-100 text-orange-700',
                                ],
                                'completed' => [
                                    'title' => 'Project selesai',
                                    'description' => 'Order ini sudah selesai. Kamu bisa melihat seluruh detail pekerjaan dari halaman detail.',
                                    'class' => 'border-emerald-100 bg-emerald-50/60',
                                    'iconClass' => 'bg-emerald-100 text-emerald-700',
                                ],
                                'cancelled' => [
                                    'title' => 'Order dibatalkan',
                                    'description' => 'Order ini sudah tidak aktif dan tidak dapat dilanjutkan.',
                                    'class' => 'border-rose-100 bg-rose-50/60',
                                    'iconClass' => 'bg-rose-100 text-rose-700',
                                ],
                                default => [
                                    'title' => 'Status order diperbarui',
                                    'description' => 'Buka detail untuk melihat perkembangan terbaru.',
                                    'class' => 'border-slate-100 bg-slate-50',
                                    'iconClass' => 'bg-slate-100 text-slate-700',
                                ],
                            };

                            $detailUrl = route('client.orders.show', $order);
                        @endphp

                        <article class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/60">

                            {{-- Top bar --}}
                            <div class="flex flex-col gap-3 border-b border-slate-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-900 text-xs font-bold text-white">
                                        PK
                                    </div>

                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="truncate text-sm font-bold text-slate-900">
                                                {{ $order->order_number }}
                                            </p>

                                            <span class="hidden text-slate-300 sm:inline">•</span>

                                            <p class="text-xs text-slate-500">
                                                {{ $order->created_at?->format('d M Y') }}
                                            </p>
                                        </div>

                                        <p class="mt-0.5 text-xs text-slate-400">
                                            Order #{{ $order->id }}
                                        </p>
                                    </div>
                                </div>

                                <span
                                    class="{{ $meta['bg'] }} {{ $meta['text'] }} {{ $meta['border'] }} inline-flex w-fit items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-bold"
                                >
                                    <span class="{{ $meta['dot'] }} h-2 w-2 rounded-full"></span>
                                    {{ $meta['label'] }}
                                </span>
                            </div>

                            {{-- Main order body --}}
                            <div class="p-4 sm:p-5">
                                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                                    {{-- Service --}}
                                    <div class="min-w-0 flex-1">
                                        <div class="flex gap-4">
                                            <div class="h-20 w-20 shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 sm:h-24 sm:w-24">
                                                @if ($serviceImageUrl)
                                                    <img
                                                        src="{{ $serviceImageUrl }}"
                                                        alt="{{ $serviceTitle }}"
                                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                                        loading="lazy"
                                                    >
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 to-slate-100">
                                                        <svg class="h-8 w-8 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                            <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H18a2 2 0 0 1 2 2v13a3 3 0 0 1-3 3H6.5A2.5 2.5 0 0 1 4 18.5v-13Z"/>
                                                            <path d="M8 8h8M8 12h6"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <div class="mb-2 flex flex-wrap items-center gap-2">
                                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600">
                                                        {{ $categoryName }}
                                                    </span>
                                                </div>

                                                <h3 class="line-clamp-2 text-base font-bold leading-6 text-slate-900 sm:text-lg">
                                                    {{ $serviceTitle }}
                                                </h3>

                                                <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500">
                                                    <span class="inline-flex items-center gap-1.5">
                                                        <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M20 21a8 8 0 0 0-16 0"/>
                                                            <circle cx="12" cy="7" r="4"/>
                                                        </svg>

                                                        {{ $freelancerName }}
                                                    </span>

                                                    @if ($order->delivery_days)
                                                        <span class="inline-flex items-center gap-1.5">
                                                            <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M6 2v4M18 2v4M3 9h18"/>
                                                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                                                            </svg>

                                                            {{ $order->delivery_days }} hari
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Price + action --}}
                                    <div class="w-full shrink-0 border-t border-slate-100 pt-4 lg:w-60 lg:border-l lg:border-t-0 lg:pl-5 lg:pt-0">
                                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                            Total
                                        </p>

                                        <p class="mt-1 text-xl font-bold tracking-tight text-slate-900">
                                            Rp{{ number_format($total, 0, ',', '.') }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">
                                            Harga akhir pada order ini
                                        </p>

                                        <div class="mt-4 flex flex-col gap-2">
                                            @if ($order->status === 'pending_payment')
                                                @if (Route::has('client.orders.checkout'))
                                                    <a
                                                        href="{{ route('client.orders.checkout', $order) }}"
                                                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700"
                                                    >
                                                        Lanjut Bayar
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M5 12h14"/>
                                                            <path d="m13 6 6 6-6 6"/>
                                                        </svg>
                                                    </a>
                                                @endif
                                            @endif

                                            <a
                                                href="{{ $detailUrl }}"
                                                class="{{ $order->status === 'pending_payment' ? 'border border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50' : 'bg-[#2563EB] text-white shadow-sm shadow-blue-200 hover:bg-blue-700' }} inline-flex w-full items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold transition"
                                            >
                                                Lihat Detail
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m9 18 6-6-6-6"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Freelancer --}}
                                <div class="mt-5 flex flex-col gap-3 rounded-2xl bg-slate-50 px-4 py-3.5 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full border-2 border-white bg-slate-200 shadow-sm">
                                            @if ($freelancerAvatarUrl)
                                                <img
                                                    src="{{ $freelancerAvatarUrl }}"
                                                    alt="{{ $freelancerName }}"
                                                    class="h-full w-full object-cover"
                                                    loading="lazy"
                                                >
                                            @else
                                                <div class="flex h-full w-full items-center justify-center bg-blue-100 text-sm font-bold text-blue-700">
                                                    {{ $freelancerInitial }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                                Freelancer
                                            </p>

                                            @if ($freelancerProfile?->username && Route::has('marketplace.freelancer'))
                                                <a
                                                    href="{{ route('marketplace.freelancer', ['username' => $freelancerProfile->username]) }}"
                                                    class="mt-0.5 block truncate text-sm font-bold text-slate-800 transition hover:text-[#2563EB]"
                                                >
                                                    {{ $freelancerName }}
                                                </a>
                                            @else
                                                <p class="mt-0.5 truncate text-sm font-bold text-slate-800">
                                                    {{ $freelancerName }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($dueDate)
                                        <div class="flex items-center gap-2 text-xs text-slate-500 sm:text-right">
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-slate-500 shadow-sm">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                                                    <path d="M16 2v4M8 2v4M3 9h18"/>
                                                </svg>
                                            </span>

                                            <span>
                                                <span class="block font-semibold text-slate-700">
                                                    Deadline {{ $dueDate->format('d M Y') }}
                                                </span>
                                                <span class="block text-[11px] text-slate-400">
                                                    {{ $dueHuman }}
                                                </span>
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Next action --}}
                                <div class="mt-4 rounded-2xl border px-4 py-3.5 {{ $nextAction['class'] }}">
                                    <div class="flex gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $nextAction['iconClass'] }}">
                                            @switch($meta['icon'])
                                                @case('card')
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                                        <path d="M3 10h18"/>
                                                    </svg>
                                                    @break

                                                @case('check')
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="m5 12 4 4L19 6"/>
                                                    </svg>
                                                    @break

                                                @case('send')
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="m22 2-7 20-4-9-9-4 20-7Z"/>
                                                        <path d="M22 2 11 13"/>
                                                    </svg>
                                                    @break

                                                @case('refresh')
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M20 11a8 8 0 0 0-14.9-3"/>
                                                        <path d="M4 4v5h5"/>
                                                        <path d="M4 13a8 8 0 0 0 14.9 3"/>
                                                        <path d="M20 20v-5h-5"/>
                                                    </svg>
                                                    @break

                                                @case('completed')
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="9"/>
                                                        <path d="m8 12 2.5 2.5L16 9"/>
                                                    </svg>
                                                    @break

                                                @case('x')
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="m8 8 8 8M16 8l-8 8"/>
                                                    </svg>
                                                    @break

                                                @default
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M12 8v8M8 12h8"/>
                                                    </svg>
                                            @endswitch
                                        </div>

                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-slate-800">
                                                {{ $nextAction['title'] }}
                                            </p>

                                            <p class="mt-0.5 text-xs leading-5 text-slate-500">
                                                {{ $nextAction['description'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($orders->hasPages())
                    <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm sm:mt-8 sm:px-5">
                        {{ $orders->links() }}
                    </div>
                @endif

            @else
                {{-- Empty state --}}
                <section class="rounded-3xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center shadow-sm sm:px-8 sm:py-16">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB]">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M7 3h10a2 2 0 0 1 2 2v14l-7-3-7 3V5a2 2 0 0 1 2-2Z"/>
                            <path d="M9 8h6M9 12h6"/>
                        </svg>
                    </div>

                    <h2 class="mt-5 text-xl font-bold text-slate-900">
                        Belum ada pesanan
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        @if ($statusFilter)
                            Belum ada pesanan dengan status “{{ $activeLabel }}”. Coba lihat semua pesanan atau cari layanan baru.
                        @else
                            Pesanan yang kamu buat akan muncul di sini setelah melakukan pemesanan jasa.
                        @endif
                    </p>

                    <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
                        @if ($statusFilter)
                            <a
                                href="{{ route('client.orders.index') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Lihat Semua Pesanan
                            </a>
                        @endif

                        @if (Route::has('marketplace.search'))
                            <a
                                href="{{ route('marketplace.search') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700"
                            >
                                Cari Jasa
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14"/>
                                    <path d="m13 6 6 6-6 6"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </section>
            @endif

            {{-- Bottom info --}}
            <section class="mt-6 sm:mt-8">
                <div class="rounded-3xl border border-blue-100 bg-gradient-to-r from-blue-50 via-white to-blue-50/60 p-5 sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="max-w-xl">
                            <div class="flex items-center gap-2">
                                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 11v5"/>
                                        <path d="M12 8h.01"/>
                                    </svg>
                                </span>

                                <p class="text-sm font-bold text-slate-800">
                                    Butuh bantuan dengan pesanan?
                                </p>
                            </div>

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Gunakan halaman detail order untuk melihat status, pembayaran, percakapan, delivery, revisi, dan proses penyelesaian project.
                            </p>
                        </div>

                        <a
                            href="{{ route('client.orders.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-white px-4 py-3 text-sm font-semibold text-blue-700 transition hover:border-blue-300 hover:bg-blue-50"
                        >
                            Refresh Pesanan
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 11a8 8 0 0 0-14.9-3"/>
                                <path d="M4 4v5h5"/>
                                <path d="M4 13a8 8 0 0 0 14.9 3"/>
                                <path d="M20 20v-5h-5"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <style>
        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layouts.marketplace>
