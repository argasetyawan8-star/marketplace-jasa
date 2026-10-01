<x-layouts.admin title="Refund">


@php
    $statusConfig = [
        'pending' => [
            'label' => 'Menunggu',
            'class' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-900/40 dark:bg-amber-950/30 dark:text-amber-300',
            'dot' => 'bg-amber-500',
            'icon' => 'bi-hourglass-split',
        ],
        'processing' => [
            'label' => 'Diproses',
            'class' => 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-900/40 dark:bg-blue-950/30 dark:text-blue-300',
            'dot' => 'bg-blue-500',
            'icon' => 'bi-arrow-repeat',
        ],
        'refunded' => [
            'label' => 'Berhasil Refund',
            'class' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900/40 dark:bg-emerald-950/30 dark:text-emerald-300',
            'dot' => 'bg-emerald-500',
            'icon' => 'bi-check-circle-fill',
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'class' => 'border-red-200 bg-red-50 text-red-700 dark:border-red-900/40 dark:bg-red-950/30 dark:text-red-300',
            'dot' => 'bg-red-500',
            'icon' => 'bi-x-circle-fill',
        ],
    ];
@endphp

<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    {{-- HEADER --}}
    <div class="mb-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 dark:border-blue-900/40 dark:bg-blue-950/30">
                    <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>
                    <span class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-700 dark:text-blue-300">
                        Keuangan
                    </span>
                </div>

                <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                    Refund
                </h1>

                <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Kelola pengembalian dana dari order yang dibatalkan atau keputusan dispute.
                </p>
            </div>

            <div class="hidden sm:flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20">
                <i class="bi bi-arrow-counterclockwise text-lg"></i>
            </div>
        </div>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-6 overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50 dark:border-emerald-900/40 dark:bg-emerald-950/30">
            <div class="flex items-start gap-3 px-5 py-4">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                    <i class="bi bi-check-circle-fill text-sm"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-semibold text-emerald-800 dark:text-emerald-300">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-xs leading-5 text-emerald-700 dark:text-emerald-400">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- SUMMARY --}}
    <div class="grid grid-cols-2 gap-3 xl:grid-cols-5">

        <a
            href="{{ route('admin.refunds.index') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-blue-900 sm:p-5"
        >
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Semua
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                        {{ $counts['all'] }}
                    </p>
                </div>

                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                    <i class="bi bi-collection text-sm"></i>
                </span>
            </div>
        </a>

        <a
            href="{{ route('admin.refunds.index', ['status' => 'pending']) }}"
            class="group rounded-2xl border border-amber-200 bg-amber-50 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-amber-900/40 dark:bg-amber-950/20 sm:p-5"
        >
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-amber-700 dark:text-amber-300">
                        Menunggu
                    </p>

                    <p class="mt-2 text-2xl font-bold text-amber-800 dark:text-amber-200">
                        {{ $counts['pending'] }}
                    </p>
                </div>

                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white/80 text-amber-600 dark:bg-slate-900 dark:text-amber-300">
                    <i class="bi bi-hourglass-split text-sm"></i>
                </span>
            </div>
        </a>

        <a
            href="{{ route('admin.refunds.index', ['status' => 'processing']) }}"
            class="group rounded-2xl border border-blue-200 bg-blue-50 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-blue-900/40 dark:bg-blue-950/20 sm:p-5"
        >
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-blue-700 dark:text-blue-300">
                        Diproses
                    </p>

                    <p class="mt-2 text-2xl font-bold text-blue-800 dark:text-blue-200">
                        {{ $counts['processing'] }}
                    </p>
                </div>

                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white/80 text-blue-600 dark:bg-slate-900 dark:text-blue-300">
                    <i class="bi bi-arrow-repeat text-sm"></i>
                </span>
            </div>
        </a>

        <a
            href="{{ route('admin.refunds.index', ['status' => 'refunded']) }}"
            class="group rounded-2xl border border-emerald-200 bg-emerald-50 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-emerald-900/40 dark:bg-emerald-950/20 sm:p-5"
        >
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                        Berhasil
                    </p>

                    <p class="mt-2 text-2xl font-bold text-emerald-800 dark:text-emerald-200">
                        {{ $counts['refunded'] }}
                    </p>
                </div>

                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white/80 text-emerald-600 dark:bg-slate-900 dark:text-emerald-300">
                    <i class="bi bi-check-circle-fill text-sm"></i>
                </span>
            </div>
        </a>

        <a
            href="{{ route('admin.refunds.index', ['status' => 'rejected']) }}"
            class="group col-span-2 rounded-2xl border border-red-200 bg-red-50 p-4 transition duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-red-900/40 dark:bg-red-950/20 xl:col-span-1 sm:p-5"
        >
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-red-700 dark:text-red-300">
                        Ditolak
                    </p>

                    <p class="mt-2 text-2xl font-bold text-red-800 dark:text-red-200">
                        {{ $counts['rejected'] }}
                    </p>
                </div>

                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white/80 text-red-600 dark:bg-slate-900 dark:text-red-300">
                    <i class="bi bi-x-circle-fill text-sm"></i>
                </span>
            </div>
        </a>

    </div>

    {{-- FILTER --}}
    <section class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">
        <div class="mb-4 flex items-center gap-3">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                <i class="bi bi-funnel text-sm"></i>
            </div>

            <div>
                <p class="text-xs font-semibold text-slate-900 dark:text-white">
                    Filter Refund
                </p>

                <p class="text-[10px] text-slate-400 dark:text-slate-500">
                    Cari berdasarkan data refund atau filter status.
                </p>
            </div>
        </div>

        <form
            action="{{ route('admin.refunds.index') }}"
            method="GET"
            class="grid grid-cols-1 gap-3 lg:grid-cols-[1fr_220px_auto]"
        >
            <div>
                <label for="search" class="sr-only">
                    Cari refund
                </label>

                <div class="relative">
                    <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nomor refund, order, atau client..."
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:placeholder:text-slate-500 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                    >
                </div>
            </div>

            <div>
                <label for="status" class="sr-only">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                >
                    <option value="">Semua status</option>

                    <option value="pending" @selected(request('status') === 'pending')>
                        Menunggu
                    </option>

                    <option value="processing" @selected(request('status') === 'processing')>
                        Diproses
                    </option>

                    <option value="refunded" @selected(request('status') === 'refunded')>
                        Berhasil Refund
                    </option>

                    <option value="rejected" @selected(request('status') === 'rejected')>
                        Ditolak
                    </option>
                </select>
            </div>

            <button
                type="submit"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15"
            >
                <i class="bi bi-funnel"></i>
                Filter
            </button>
        </form>
    </section>

    {{-- DATA --}}
    <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- SECTION HEADER --}}
        <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                        Daftar refund
                    </p>

                    <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                        Pengembalian Dana
                    </h2>
                </div>

                <div class="hidden h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400 sm:flex">
                    <i class="bi bi-wallet2 text-sm"></i>
                </div>
            </div>
        </div>

        @if($refunds->count())

            {{-- DESKTOP TABLE --}}
            <div class="hidden overflow-x-auto lg:block">
                <table class="min-w-full">
                    <thead class="bg-slate-50 dark:bg-slate-950/60">
                        <tr>
                            <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                Refund
                            </th>

                            <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                Order
                            </th>

                            <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                Client
                            </th>

                            <th class="px-5 py-3 text-right text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                Nominal
                            </th>

                            <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                Status
                            </th>

                            <th class="px-5 py-3 text-right text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($refunds as $refund)

                            @php
                                $status = $statusConfig[$refund->status]
                                    ?? [
                                        'label' => ucfirst($refund->status),
                                        'class' => 'border-slate-200 bg-slate-50 text-slate-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
                                        'dot' => 'bg-slate-400',
                                        'icon' => 'bi-circle-fill',
                                    ];

                                $client = $refund->order?->client;
                                $clientProfile = $client?->profile;
                                $clientAvatar = $clientProfile?->avatar;

                                $clientAvatarUrl = null;

                                if ($clientAvatar) {
                                    $clientAvatarUrl = str_starts_with($clientAvatar, 'http://')
                                        || str_starts_with($clientAvatar, 'https://')
                                        ? $clientAvatar
                                        : asset('storage/' . ltrim($clientAvatar, '/'));
                                }

                                $clientName = $client?->name ?? '-';
                                $clientInitials = collect(explode(' ', trim($clientName)))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                                    ->implode('');
                            @endphp

                            <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/40">

                                {{-- REFUND --}}
                                <td class="px-5 py-4">
                                    <p class="text-xs font-bold text-slate-800 dark:text-slate-200">
                                        {{ $refund->refund_number }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-slate-400">
                                        {{ $refund->created_at?->format('d M Y, H:i') }}
                                    </p>
                                </td>

                                {{-- ORDER --}}
                                <td class="px-5 py-4">
                                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                                        {{ $refund->order?->order_number ?? '-' }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-slate-400">
                                        Pesanan terkait
                                    </p>
                                </td>

                                {{-- CLIENT --}}
                                <td class="px-5 py-4">
                                    <div class="flex min-w-[200px] items-center gap-3">
                                        <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full border border-slate-200 bg-slate-100 dark:border-slate-700 dark:bg-slate-800">
                                            @if($clientAvatarUrl)
                                                <img
                                                    src="{{ $clientAvatarUrl }}"
                                                    alt="{{ $clientName }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-slate-500 dark:text-slate-300">
                                                    {{ $clientInitials ?: 'CL' }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <p class="truncate text-xs font-semibold text-slate-700 dark:text-slate-200">
                                                {{ $clientName }}
                                            </p>

                                            <p class="mt-1 truncate text-[10px] text-slate-400">
                                                {{ $client?->email ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- NOMINAL --}}
                                <td class="px-5 py-4 text-right">
                                    <p class="text-xs font-bold text-slate-900 dark:text-white">
                                        Rp {{ number_format((float) $refund->amount, 0, ',', '.') }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-slate-400">
                                        Nilai refund
                                    </p>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-[9px] font-bold {{ $status['class'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                        {{ $status['label'] }}
                                    </span>
                                </td>

                                {{-- ACTION --}}
                                <td class="px-5 py-4 text-right">
                                    <a
                                        href="{{ route('admin.refunds.show', $refund) }}"
                                        class="inline-flex h-9 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-[10px] font-semibold text-slate-600 transition hover:border-blue-200 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-900 dark:hover:text-blue-400"
                                    >
                                        Detail
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- MOBILE CARD --}}
            <div class="divide-y divide-slate-100 dark:divide-slate-800 lg:hidden">
                @foreach($refunds as $refund)

                    @php
                        $status = $statusConfig[$refund->status]
                            ?? [
                                'label' => ucfirst($refund->status),
                                'class' => 'border-slate-200 bg-slate-50 text-slate-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
                                'dot' => 'bg-slate-400',
                                'icon' => 'bi-circle-fill',
                            ];

                        $client = $refund->order?->client;
                        $clientProfile = $client?->profile;
                        $clientAvatar = $clientProfile?->avatar;

                        $clientAvatarUrl = null;

                        if ($clientAvatar) {
                            $clientAvatarUrl = str_starts_with($clientAvatar, 'http://')
                                || str_starts_with($clientAvatar, 'https://')
                                ? $clientAvatar
                                : asset('storage/' . ltrim($clientAvatar, '/'));
                        }

                        $clientName = $client?->name ?? '-';

                        $clientInitials = collect(explode(' ', trim($clientName)))
                            ->filter()
                            ->take(2)
                            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                            ->implode('');
                    @endphp

                    <div class="p-4 sm:p-5">

                        {{-- TOP --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 dark:text-white">
                                    {{ $refund->refund_number }}
                                </p>

                                <p class="mt-1 text-[10px] text-slate-400">
                                    {{ $refund->created_at?->format('d M Y, H:i') }}
                                </p>
                            </div>

                            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full border px-2.5 py-1 text-[9px] font-bold {{ $status['class'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                {{ $status['label'] }}
                            </span>
                        </div>

                        {{-- CLIENT --}}
                        <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-950/50">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900">
                                    @if($clientAvatarUrl)
                                        <img
                                            src="{{ $clientAvatarUrl }}"
                                            alt="{{ $clientName }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-slate-500 dark:text-slate-300">
                                            {{ $clientInitials ?: 'CL' }}
                                        </div>
                                    @endif
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                        Client
                                    </p>

                                    <p class="mt-0.5 truncate text-xs font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $clientName }}
                                    </p>

                                    <p class="mt-0.5 truncate text-[10px] text-slate-400">
                                        {{ $client?->email ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- ORDER + NOMINAL --}}
                        <div class="mt-3 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl border border-slate-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900">
                                <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                    Order
                                </p>

                                <p class="mt-1 truncate text-xs font-semibold text-slate-800 dark:text-slate-200">
                                    {{ $refund->order?->order_number ?? '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white p-3 text-right dark:border-slate-800 dark:bg-slate-900">
                                <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                    Nominal
                                </p>

                                <p class="mt-1 text-xs font-bold text-blue-600 dark:text-blue-400">
                                    Rp {{ number_format((float) $refund->amount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <a
                            href="{{ route('admin.refunds.show', $refund) }}"
                            class="mt-3 inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-[10px] font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700"
                        >
                            Lihat Detail Refund
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="border-t border-slate-100 px-5 py-4 dark:border-slate-800 sm:px-6">
                {{ $refunds->links() }}
            </div>

        @else

            {{-- EMPTY STATE --}}
            <div class="px-6 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-950/30 dark:text-blue-400">
                    <i class="bi bi-arrow-counterclockwise text-xl"></i>
                </div>

                <h3 class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-200">
                    Belum ada refund
                </h3>

                <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-slate-400 dark:text-slate-500">
                    Data refund akan muncul ketika pembayaran berstatus refund_pending dan proses pengembalian dana dibuat.
                </p>
            </div>

        @endif

    </section>
</div>


</x-layouts.admin>
