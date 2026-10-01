<x-layouts.admin title="Detail Pesanan">


@php
    $statusMap = [
        'pending_payment' => [
            'label' => 'Menunggu Pembayaran',
            'class' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/25 dark:text-amber-300 dark:border-amber-800',
            'icon' => 'bi-hourglass-split',
        ],
        'paid' => [
            'label' => 'Dibayar',
            'class' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/25 dark:text-blue-300 dark:border-blue-800',
            'icon' => 'bi-credit-card-fill',
        ],
        'in_progress' => [
            'label' => 'Sedang Dikerjakan',
            'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-900/25 dark:text-indigo-300 dark:border-indigo-800',
            'icon' => 'bi-hourglass-bottom',
        ],
        'revision' => [
            'label' => 'Revisi',
            'class' => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-900/25 dark:text-orange-300 dark:border-orange-800',
            'icon' => 'bi-arrow-repeat',
        ],
        'completed' => [
            'label' => 'Selesai',
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/25 dark:text-emerald-300 dark:border-emerald-800',
            'icon' => 'bi-check-circle-fill',
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'class' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/25 dark:text-red-300 dark:border-red-800',
            'icon' => 'bi-x-circle-fill',
        ],
    ];

    $orderStatus = $statusMap[$order->status] ?? [
        'label' => ucfirst(str_replace('_', ' ', $order->status ?? 'Unknown')),
        'class' => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700',
        'icon' => 'bi-question-circle',
    ];

    $client = $order->client;
    $clientProfile = $client?->profile;

    $freelancer = $order->freelancerProfile;
    $freelancerUser = $freelancer?->user;

    $payment = $order->payment;

    $clientAvatar = $clientProfile?->avatar;
    $freelancerAvatar = $freelancer?->avatar;

    $clientInitial = strtoupper(substr($client?->name ?? 'C', 0, 1));
    $freelancerInitial = strtoupper(substr($freelancerUser?->name ?? 'F', 0, 1));
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div class="min-w-0">

            <a
                href="{{ route('admin.orders.index') }}"
                class="group inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
            >
                <span class="flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 bg-white transition group-hover:border-blue-200 group-hover:bg-blue-50 dark:border-slate-700 dark:bg-slate-900 dark:group-hover:border-blue-900/50 dark:group-hover:bg-blue-900/20">
                    <i class="bi bi-arrow-left"></i>
                </span>

                Kembali ke daftar pesanan
            </a>

            <div class="mt-4">

                <div class="flex flex-wrap items-center gap-2.5">

                    <span class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:border-blue-900/50 dark:bg-blue-900/20 dark:text-blue-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                        Detail Pesanan
                    </span>

                    <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $orderStatus['class'] }}">
                        <i class="bi {{ $orderStatus['icon'] }}"></i>
                        {{ $orderStatus['label'] }}
                    </span>

                </div>

                <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                    #{{ $order->order_number }}
                </h1>

                <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                    Dibuat pada {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                </p>

            </div>

        </div>

        {{-- Transaction Total --}}
        <div class="rounded-2xl border border-blue-100 bg-blue-50/70 px-5 py-4 shadow-sm dark:border-blue-900/40 dark:bg-blue-900/10">

            <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-blue-500 dark:text-blue-300">
                Total Transaksi
            </p>

            <p class="mt-1 text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">
                Rp {{ number_format((float) $order->total, 0, ',', '.') }}
            </p>

        </div>

    </div>

    {{-- Main --}}
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">

        {{-- LEFT --}}
        <div class="min-w-0 space-y-6">

            {{-- Ringkasan Pesanan --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6 dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                                Ringkasan Pesanan
                            </h2>

                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                Informasi utama transaksi
                            </p>
                        </div>

                    </div>

                </div>

                <div class="p-5 sm:p-6">

                    <div class="grid gap-4 sm:grid-cols-2">

                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Nomor Pesanan
                            </p>

                            <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                                #{{ $order->order_number }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Status
                            </p>

                            <span class="mt-1.5 inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $orderStatus['class'] }}">
                                <i class="bi {{ $orderStatus['icon'] }}"></i>
                                {{ $orderStatus['label'] }}
                            </span>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Estimasi Pengerjaan
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                {{ $order->delivery_days }} hari
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Batas Pengerjaan
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                {{ $order->due_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            {{-- Client & Freelancer --}}
            <div class="grid gap-6 md:grid-cols-2">

                {{-- Client --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                            <i class="bi bi-person"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                                Client
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Pemesan jasa
                            </p>
                        </div>

                    </div>

                    <div class="mt-5 flex items-center gap-3">

                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full border-2 border-blue-100 bg-blue-50 dark:border-blue-900/50 dark:bg-blue-900/20">

                            @if ($clientAvatar)

                                <img
                                    src="{{ asset('storage/' . $clientAvatar) }}"
                                    alt="{{ $client?->name ?? 'Client' }}"
                                    class="h-full w-full object-cover"
                                >

                            @elseif ($client)

                                <div class="flex h-full w-full items-center justify-center text-lg font-bold text-blue-600 dark:text-blue-300">
                                    {{ $clientInitial }}
                                </div>

                            @else

                                <div class="flex h-full w-full items-center justify-center text-blue-500 dark:text-blue-300">
                                    <i class="bi bi-person text-xl"></i>
                                </div>

                            @endif

                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="truncate text-sm font-bold text-slate-900 dark:text-white">
                                {{ $client?->name ?? 'Client tidak tersedia' }}
                            </p>

                            @if ($client?->email)
                                <p class="mt-1 truncate text-xs text-slate-500 dark:text-slate-400">
                                    {{ $client->email }}
                                </p>
                            @endif

                        </div>

                    </div>

                </div>

                {{-- Freelancer --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-300">
                            <i class="bi bi-person-badge"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                                Freelancer
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Penyedia jasa
                            </p>
                        </div>

                    </div>

                    <div class="mt-5 flex items-center gap-3">

                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full border-2 border-indigo-100 bg-indigo-50 dark:border-indigo-900/50 dark:bg-indigo-900/20">

                            @if ($freelancerAvatar)

                                <img
                                    src="{{ asset('storage/' . $freelancerAvatar) }}"
                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                    class="h-full w-full object-cover"
                                >

                            @elseif ($freelancerUser)

                                <div class="flex h-full w-full items-center justify-center text-lg font-bold text-indigo-600 dark:text-indigo-300">
                                    {{ $freelancerInitial }}
                                </div>

                            @else

                                <div class="flex h-full w-full items-center justify-center text-indigo-500 dark:text-indigo-300">
                                    <i class="bi bi-person text-xl"></i>
                                </div>

                            @endif

                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="truncate text-sm font-bold text-slate-900 dark:text-white">
                                {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                            </p>

                            @if ($freelancer?->username)
                                <p class="mt-1 truncate text-xs text-slate-500 dark:text-slate-400">
                                    {{ '@' . $freelancer->username }}
                                </p>
                            @endif

                        </div>

                    </div>

                </div>

            </div>

            {{-- Item Pesanan --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6 dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                            <i class="bi bi-bag-check"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                                Item Pesanan
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Jasa yang dipesan client
                            </p>
                        </div>

                    </div>

                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">

                    @forelse ($order->items as $item)

                        <div class="px-5 py-5 sm:px-6">

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                <div class="min-w-0">

                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                        {{ $item->service_title ?? $item->title ?? 'Jasa' }}
                                    </p>

                                    @if (isset($item->quantity))
                                        <div class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                            <i class="bi bi-box-seam"></i>
                                            Jumlah {{ $item->quantity }}
                                        </div>
                                    @endif

                                </div>

                                <p class="shrink-0 text-base font-bold text-slate-900 dark:text-white">
                                    Rp {{ number_format((float) ($item->subtotal ?? $item->price ?? 0), 0, ',', '.') }}
                                </p>

                            </div>

                        </div>

                    @empty

                        <div class="px-6 py-10 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                                <i class="bi bi-bag-x text-xl"></i>
                            </div>

                            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                                Belum ada item pada pesanan ini.
                            </p>
                        </div>

                    @endforelse

                </div>

            </div>

            {{-- Requirements --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-card-text"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Requirements
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Kebutuhan atau catatan dari client
                        </p>
                    </div>

                </div>

                <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">

                    @if ($order->requirements)

                        <p class="whitespace-pre-line text-sm leading-7 text-slate-600 dark:text-slate-300">
                            {{ $order->requirements }}
                        </p>

                    @else

                        <div class="flex items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
                            <i class="bi bi-info-circle"></i>
                            Client tidak memberikan requirements tambahan.
                        </div>

                    @endif

                </div>

            </div>

            {{-- Deliveries --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6 dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-300">
                            <i class="bi bi-send-check"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                                Delivery
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Riwayat pengiriman pekerjaan
                            </p>
                        </div>

                    </div>

                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">

                    @forelse ($order->deliveries as $delivery)

                        <div class="px-5 py-5 sm:px-6">

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                <div class="min-w-0">

                                    <div class="flex items-center gap-2">

                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300">
                                            <i class="bi bi-send"></i>
                                        </span>

                                        <div>
                                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                                Delivery #{{ $delivery->id }}
                                            </p>

                                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                                {{ $delivery->created_at?->format('d M Y, H:i') ?? '-' }}
                                            </p>
                                        </div>

                                    </div>

                                </div>

                                @if ($delivery->status)
                                    <span class="inline-flex w-fit items-center rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-900/20 dark:text-blue-300">
                                        {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                                    </span>
                                @endif

                            </div>

                            @if ($delivery->message)

                                <div class="mt-4 rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">

                                    <p class="whitespace-pre-line text-sm leading-6 text-slate-600 dark:text-slate-300">
                                        {{ $delivery->message }}
                                    </p>

                                </div>

                            @endif

                        </div>

                    @empty

                        <div class="px-6 py-12 text-center">

                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                                <i class="bi bi-send text-xl"></i>
                            </div>

                            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                                Belum ada delivery.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            {{-- Financial Summary --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:sticky xl:top-24 dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Ringkasan Keuangan
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Rincian nilai transaksi
                        </p>
                    </div>

                </div>

                <div class="mt-6 space-y-4">

                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm text-slate-500 dark:text-slate-400">
                            Subtotal
                        </span>

                        <span class="text-sm font-medium text-slate-800 dark:text-slate-200">
                            Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm text-slate-500 dark:text-slate-400">
                            Platform fee
                        </span>

                        <span class="text-sm font-medium text-slate-800 dark:text-slate-200">
                            Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="border-t border-slate-100 pt-4 dark:border-slate-800">

                        <div class="flex items-center justify-between gap-4">

                            <span class="text-sm font-semibold text-slate-900 dark:text-white">
                                Total
                            </span>

                            <span class="text-lg font-bold text-blue-600 dark:text-blue-300">
                                Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                            </span>

                        </div>

                    </div>

                    <div class="rounded-xl border border-blue-100 bg-blue-50/70 p-4 dark:border-blue-900/40 dark:bg-blue-900/10">

                        <p class="text-xs font-medium text-blue-600 dark:text-blue-300">
                            Bagian Freelancer
                        </p>

                        <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                            Rp {{ number_format((float) $order->freelancer_amount, 0, ',', '.') }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- Payment --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-credit-card"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Pembayaran
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Informasi pembayaran pesanan
                        </p>
                    </div>

                </div>

                <div class="mt-5 space-y-4">

                    @if ($payment)

                        @if (isset($payment->payment_type))
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Metode
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                                </p>
                            </div>
                        @endif

                        @if (isset($payment->status))
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Status Pembayaran
                                </p>

                                <span class="mt-1.5 inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/25 dark:text-emerald-300">
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                                </span>
                            </div>
                        @endif

                        @if (isset($payment->paid_at))
                            <div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Dibayar
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-800 dark:text-slate-200">
                                    {{ $payment->paid_at?->format('d M Y, H:i') ?? '-' }}
                                </p>
                            </div>
                        @endif

                    @else

                        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-900/50 dark:bg-amber-900/15">

                            <div class="flex items-start gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-300">
                                    <i class="bi bi-exclamation-circle"></i>
                                </div>

                                <p class="text-sm leading-6 text-amber-800 dark:text-amber-200">
                                    Belum terdapat data pembayaran pada pesanan ini.
                                </p>

                            </div>

                        </div>

                    @endif

                </div>

            </div>

            {{-- Timeline --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-clock-history"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Timeline
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Perjalanan pesanan
                        </p>
                    </div>

                </div>

                <div class="mt-6">

                    {{-- Created --}}
                    <div class="relative flex gap-3 pb-6">

                        <div class="relative flex w-5 shrink-0 justify-center">

                            <div class="mt-1 h-3 w-3 rounded-full bg-blue-600 ring-4 ring-blue-100 dark:bg-blue-400 dark:ring-blue-900/30"></div>

                            @if ($order->paid_at || $order->completed_at)
                                <div class="absolute left-1/2 top-4 h-full w-px -translate-x-1/2 bg-slate-200 dark:bg-slate-700"></div>
                            @endif

                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                Pesanan dibuat
                            </p>

                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>

                    </div>

                    {{-- Paid --}}
                    @if ($order->paid_at)

                        <div class="relative flex gap-3 pb-6">

                            <div class="relative flex w-5 shrink-0 justify-center">

                                <div class="mt-1 h-3 w-3 rounded-full bg-blue-600 ring-4 ring-blue-100 dark:bg-blue-400 dark:ring-blue-900/30"></div>

                                @if ($order->completed_at)
                                    <div class="absolute left-1/2 top-4 h-full w-px -translate-x-1/2 bg-slate-200 dark:bg-slate-700"></div>
                                @endif

                            </div>

                            <div class="min-w-0">

                                <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                    Pembayaran diterima
                                </p>

                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    {{ $order->paid_at->format('d M Y, H:i') }}
                                </p>

                            </div>

                        </div>

                    @endif

                    {{-- Completed --}}
                    @if ($order->completed_at)

                        <div class="flex gap-3">

                            <div class="flex w-5 shrink-0 justify-center">

                                <div class="mt-1 h-3 w-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100 dark:bg-emerald-400 dark:ring-emerald-900/30"></div>

                            </div>

                            <div class="min-w-0">

                                <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                    Pesanan selesai
                                </p>

                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    {{ $order->completed_at->format('d M Y, H:i') }}
                                </p>

                            </div>

                        </div>

                    @endif

                    {{-- Cancelled --}}
                    @if ($order->cancel_reason)

                        <div class="mt-5 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-900/50 dark:bg-red-900/15">

                            <div class="flex items-start gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-300">
                                    <i class="bi bi-x-circle-fill"></i>
                                </div>

                                <div class="min-w-0">

                                    <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                                        Alasan Pembatalan
                                    </p>

                                    <p class="mt-1.5 whitespace-pre-line text-sm leading-6 text-red-700 dark:text-red-200/80">
                                        {{ $order->cancel_reason }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endif

                </div>

            </div>

            {{-- System Information --}}
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-950/60 sm:p-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div class="min-w-0 flex-1">

                        <p class="text-sm font-semibold text-slate-900 dark:text-white">
                            Informasi Sistem
                        </p>

                        <div class="mt-4 space-y-2.5 text-xs text-slate-500 dark:text-slate-400">

                            <div class="flex items-center justify-between gap-4">
                                <span>Order ID</span>

                                <span class="font-semibold text-slate-700 dark:text-slate-300">
                                    #{{ $order->id }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <span>Dibuat</span>

                                <span class="text-right font-medium text-slate-700 dark:text-slate-300">
                                    {{ $order->created_at?->format('d M Y, H:i:s') ?? '-' }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <span>Diperbarui</span>

                                <span class="text-right font-medium text-slate-700 dark:text-slate-300">
                                    {{ $order->updated_at?->format('d M Y, H:i:s') ?? '-' }}
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


</x-layouts.admin>
