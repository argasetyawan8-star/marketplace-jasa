<x-layouts.admin title="Kelola Pesanan">


@php
    $statusMap = [
        'pending_payment' => [
            'label' => 'Menunggu Pembayaran',
            'class' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/25 dark:text-amber-300',
            'icon' => 'bi-hourglass-split',
        ],
        'paid' => [
            'label' => 'Dibayar',
            'class' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/25 dark:text-blue-300',
            'icon' => 'bi-credit-card-fill',
        ],
        'in_progress' => [
            'label' => 'Sedang Dikerjakan',
            'class' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/25 dark:text-indigo-300',
            'icon' => 'bi-hourglass-bottom',
        ],
        'revision' => [
            'label' => 'Revisi',
            'class' => 'bg-orange-50 text-orange-700 dark:bg-orange-900/25 dark:text-orange-300',
            'icon' => 'bi-arrow-repeat',
        ],
        'completed' => [
            'label' => 'Selesai',
            'class' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/25 dark:text-emerald-300',
            'icon' => 'bi-check-circle-fill',
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'class' => 'bg-red-50 text-red-700 dark:bg-red-900/25 dark:text-red-300',
            'icon' => 'bi-x-circle-fill',
        ],
    ];
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:border-blue-900/50 dark:bg-blue-900/20 dark:text-blue-300">
                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                Marketplace
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Kelola Pesanan
            </h1>

            <p class="mt-1.5 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Pantau seluruh transaksi antara client dan freelancer.
            </p>
        </div>

        <div class="flex items-center">
            <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>

                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                        Total Pesanan
                    </p>

                    <p class="mt-0.5 text-lg font-bold text-slate-900 dark:text-white">
                        {{ $orders->total() }}
                    </p>
                </div>

            </div>
        </div>

    </div>

    {{-- Flash Success --}}
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-900/50 dark:bg-emerald-900/15">
            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-sm leading-6 text-emerald-700 dark:text-emerald-200/80">
                        {{ session('success') }}
                    </p>
                </div>

            </div>
        </div>
    @endif

    {{-- Filter --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">
            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                        Filter Pesanan
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Cari berdasarkan nomor order, client, atau freelancer.
                    </p>
                </div>

            </div>
        </div>

        <form
            action="{{ route('admin.orders.index') }}"
            method="GET"
            class="p-5"
        >

            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_240px_auto] lg:items-end">

                {{-- Search --}}
                <div>
                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                    >
                        Cari pesanan
                    </label>

                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <i class="bi bi-search text-slate-400"></i>
                        </div>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Nomor order, nama client, freelancer..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-400 dark:focus:ring-blue-400/10"
                        >
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-400 dark:focus:ring-blue-400/10"
                    >
                        <option value="">Semua status</option>

                        <option value="pending_payment" @selected($status === 'pending_payment')>
                            Menunggu Pembayaran
                        </option>

                        <option value="paid" @selected($status === 'paid')>
                            Dibayar
                        </option>

                        <option value="in_progress" @selected($status === 'in_progress')>
                            Sedang Dikerjakan
                        </option>

                        <option value="revision" @selected($status === 'revision')>
                            Revisi
                        </option>

                        <option value="completed" @selected($status === 'completed')>
                            Selesai
                        </option>

                        <option value="cancelled" @selected($status === 'cancelled')>
                            Dibatalkan
                        </option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15 lg:w-auto"
                    >
                        <i class="bi bi-search"></i>
                        Cari
                    </button>

                    @if ($search !== '' || $status)
                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:border-slate-600 dark:hover:bg-slate-900 dark:hover:text-white"
                        >
                            Reset
                        </a>
                    @endif

                </div>

            </div>

        </form>
    </div>

    {{-- Orders --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- Table Header --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-800">

            <div>
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                    Daftar Pesanan
                </h2>

                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                    Menampilkan {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }}
                    dari {{ $orders->total() }} pesanan
                </p>
            </div>

            <div class="hidden items-center gap-2 text-xs text-slate-500 sm:flex dark:text-slate-400">
                <i class="bi bi-shield-check text-blue-600 dark:text-blue-400"></i>
                Monitoring transaksi
            </div>

        </div>

        {{-- Desktop --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="min-w-full">

                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 dark:border-slate-800 dark:bg-slate-950/60">

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Pesanan
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Client
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Freelancer
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Total
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Status
                        </th>

                        <th class="px-5 py-3.5 text-right text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                    @forelse ($orders as $order)

                        @php
                            $orderStatus = $statusMap[$order->status] ?? [
                                'label' => ucfirst(str_replace('_', ' ', $order->status ?? 'Unknown')),
                                'class' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
                                'icon' => 'bi-question-circle',
                            ];

                            $clientProfile = $order->client?->profile;
                            $freelancerProfile = $order->freelancerProfile;
                            $freelancerUser = $freelancerProfile?->user;

                            $clientAvatar = $clientProfile?->avatar;
                            $freelancerAvatar = $freelancerProfile?->avatar;
                        @endphp

                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-950/40">

                            {{-- Order --}}
                            <td class="px-5 py-4">
                                <div class="min-w-[190px]">
                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="text-sm font-semibold text-slate-900 transition hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                    >
                                        #{{ $order->order_number }}
                                    </a>

                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                                    </p>
                                </div>
                            </td>

                            {{-- Client --}}
                            <td class="px-5 py-4">
                                <div class="flex min-w-[220px] items-center gap-3">

                                    <div class="h-11 w-11 shrink-0 overflow-hidden rounded-full border border-blue-100 bg-blue-50 dark:border-blue-900/50 dark:bg-blue-900/20">
                                        @if ($clientAvatar)
                                            <img
                                                src="{{ asset('storage/' . $clientAvatar) }}"
                                                alt="{{ $order->client?->name ?? 'Client' }}"
                                                class="h-full w-full object-cover"
                                            >
                                        @elseif ($order->client)
                                            <div class="flex h-full w-full items-center justify-center text-sm font-bold text-blue-600 dark:text-blue-300">
                                                {{ strtoupper(substr($order->client->name, 0, 1)) }}
                                            </div>
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-blue-500 dark:text-blue-300">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $order->client?->name ?? 'Client tidak tersedia' }}
                                        </p>

                                        @if ($order->client?->email)
                                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                                {{ $order->client->email }}
                                            </p>
                                        @endif
                                    </div>

                                </div>
                            </td>

                            {{-- Freelancer --}}
                            <td class="px-5 py-4">
                                <div class="flex min-w-[220px] items-center gap-3">

                                    <div class="h-11 w-11 shrink-0 overflow-hidden rounded-full border border-indigo-100 bg-indigo-50 dark:border-indigo-900/50 dark:bg-indigo-900/20">

                                        @if ($freelancerAvatar)

                                            <img
                                                src="{{ asset('storage/' . $freelancerAvatar) }}"
                                                alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @elseif ($freelancerUser)

                                            <div class="flex h-full w-full items-center justify-center text-sm font-bold text-indigo-600 dark:text-indigo-300">
                                                {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                            </div>

                                        @else

                                            <div class="flex h-full w-full items-center justify-center text-indigo-500 dark:text-indigo-300">
                                                <i class="bi bi-person"></i>
                                            </div>

                                        @endif

                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                        </p>

                                        @if ($freelancerProfile?->username)
                                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                                {{ '@' . $freelancerProfile->username }}
                                            </p>
                                        @endif

                                    </div>

                                </div>
                            </td>

                            {{-- Total --}}
                            <td class="px-5 py-4">
                                <div class="min-w-[130px]">

                                    <p class="text-sm font-bold text-slate-900 dark:text-white">
                                        Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        Fee: Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                                    </p>

                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">

                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $orderStatus['class'] }}">
                                    <i class="bi {{ $orderStatus['icon'] }}"></i>
                                    {{ $orderStatus['label'] }}
                                </span>

                            </td>

                            {{-- Action --}}
                            <td class="px-5 py-4">

                                <div class="flex justify-end">

                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-400 dark:hover:border-blue-900/50 dark:hover:bg-blue-900/20 dark:hover:text-blue-300"
                                        title="Lihat detail"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                                    <i class="bi bi-receipt text-2xl"></i>
                                </div>

                                <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">
                                    Pesanan belum ditemukan
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500 dark:text-slate-400">
                                    Tidak ada pesanan yang sesuai dengan pencarian atau filter yang dipilih.
                                </p>

                                @if ($search !== '' || $status)
                                    <a
                                        href="{{ route('admin.orders.index') }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700"
                                    >
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                        Tampilkan semua
                                    </a>
                                @endif

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Mobile --}}
        <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">

            @forelse ($orders as $order)

                @php
                    $orderStatus = $statusMap[$order->status] ?? [
                        'label' => ucfirst(str_replace('_', ' ', $order->status ?? 'Unknown')),
                        'class' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
                        'icon' => 'bi-question-circle',
                    ];

                    $clientProfile = $order->client?->profile;
                    $freelancerProfile = $order->freelancerProfile;
                    $freelancerUser = $freelancerProfile?->user;

                    $clientAvatar = $clientProfile?->avatar;
                    $freelancerAvatar = $freelancerProfile?->avatar;
                @endphp

                <div class="p-4 sm:p-5">

                    {{-- Order Header --}}
                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <a
                                href="{{ route('admin.orders.show', $order) }}"
                                class="text-sm font-bold text-slate-900 transition hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                            >
                                #{{ $order->order_number }}
                            </a>

                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                            </p>

                        </div>

                        <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $orderStatus['class'] }}">
                            <i class="bi {{ $orderStatus['icon'] }}"></i>
                            {{ $orderStatus['label'] }}
                        </span>

                    </div>

                    {{-- Client --}}
                    <div class="mt-5 rounded-2xl border border-blue-100 bg-blue-50/50 p-3.5 dark:border-blue-900/40 dark:bg-blue-900/10">

                        <div class="flex items-center gap-3">

                            <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-white bg-blue-100 shadow-sm dark:border-slate-800 dark:bg-blue-900/30">

                                @if ($clientAvatar)

                                    <img
                                        src="{{ asset('storage/' . $clientAvatar) }}"
                                        alt="{{ $order->client?->name ?? 'Client' }}"
                                        class="h-full w-full object-cover"
                                    >

                                @elseif ($order->client)

                                    <div class="flex h-full w-full items-center justify-center text-base font-bold text-blue-600 dark:text-blue-300">
                                        {{ strtoupper(substr($order->client->name, 0, 1)) }}
                                    </div>

                                @else

                                    <div class="flex h-full w-full items-center justify-center text-blue-500">
                                        <i class="bi bi-person"></i>
                                    </div>

                                @endif

                            </div>

                            <div class="min-w-0 flex-1">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-blue-500 dark:text-blue-300">
                                    Client
                                </p>

                                <p class="mt-0.5 truncate text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $order->client?->name ?? 'Tidak tersedia' }}
                                </p>

                                @if ($order->client?->email)
                                    <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                        {{ $order->client->email }}
                                    </p>
                                @endif

                            </div>

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-blue-500 dark:bg-slate-900 dark:text-blue-300">
                                <i class="bi bi-person"></i>
                            </div>

                        </div>

                    </div>

                    {{-- Freelancer --}}
                    <div class="mt-3 rounded-2xl border border-indigo-100 bg-indigo-50/50 p-3.5 dark:border-indigo-900/40 dark:bg-indigo-900/10">

                        <div class="flex items-center gap-3">

                            <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-white bg-indigo-100 shadow-sm dark:border-slate-800 dark:bg-indigo-900/30">

                                @if ($freelancerAvatar)

                                    <img
                                        src="{{ asset('storage/' . $freelancerAvatar) }}"
                                        alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                        class="h-full w-full object-cover"
                                    >

                                @elseif ($freelancerUser)

                                    <div class="flex h-full w-full items-center justify-center text-base font-bold text-indigo-600 dark:text-indigo-300">
                                        {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                    </div>

                                @else

                                    <div class="flex h-full w-full items-center justify-center text-indigo-500">
                                        <i class="bi bi-person"></i>
                                    </div>

                                @endif

                            </div>

                            <div class="min-w-0 flex-1">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-indigo-500 dark:text-indigo-300">
                                    Freelancer
                                </p>

                                <p class="mt-0.5 truncate text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $freelancerUser?->name ?? 'Tidak tersedia' }}
                                </p>

                                @if ($freelancerProfile?->username)
                                    <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                        {{ '@' . $freelancerProfile->username }}
                                    </p>
                                @endif

                            </div>

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-indigo-500 dark:bg-slate-900 dark:text-indigo-300">
                                <i class="bi bi-person-badge"></i>
                            </div>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="mt-4 flex items-center justify-between gap-3 border-t border-slate-100 pt-4 dark:border-slate-800">

                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Total
                            </p>

                            <p class="mt-0.5 text-base font-bold text-slate-900 dark:text-white">
                                Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                            </p>

                            <p class="mt-0.5 text-[11px] text-slate-400">
                                Fee: Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                            </p>
                        </div>

                        <a
                            href="{{ route('admin.orders.show', $order) }}"
                            class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700"
                        >
                            <i class="bi bi-eye"></i>
                            Detail
                        </a>

                    </div>

                </div>

            @empty

                <div class="px-6 py-14 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-receipt text-2xl"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">
                        Pesanan belum ditemukan
                    </h3>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Belum ada pesanan yang sesuai.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($orders->hasPages())

            <div class="border-t border-slate-100 px-4 py-4 sm:px-5 dark:border-slate-800">
                {{ $orders->links() }}
            </div>

        @endif

    </div>

</div>


</x-layouts.admin>
