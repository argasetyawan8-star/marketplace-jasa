<x-layouts.admin title="Kelola Penarikan">


@php
    $statusMap = [
        'pending' => [
            'label' => 'Menunggu',
            'class' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-300',
            'icon' => 'bi-hourglass-split',
        ],
        'processing' => [
            'label' => 'Diproses',
            'class' => 'bg-blue-50 text-blue-700 dark:bg-blue-950/30 dark:text-blue-300',
            'icon' => 'bi-arrow-repeat',
        ],
        'approved' => [
            'label' => 'Disetujui',
            'class' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300',
            'icon' => 'bi-check-circle-fill',
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'class' => 'bg-red-50 text-red-700 dark:bg-red-950/30 dark:text-red-300',
            'icon' => 'bi-x-circle-fill',
        ],
    ];
@endphp

<div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div class="min-w-0">
            <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 dark:border-blue-900/40 dark:bg-blue-950/30">
                <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                <span class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-700 dark:text-blue-300">
                    Keuangan
                </span>
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Kelola Penarikan
            </h1>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Kelola pengajuan penarikan saldo dari freelancer.
            </p>
        </div>

        {{-- TOTAL --}}
        <div class="w-full rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:w-auto sm:min-w-[220px]">
            <div class="flex items-center gap-3">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                    <i class="bi bi-bank2"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Total Pengajuan
                    </p>

                    <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                        {{ $withdrawals->total() }}
                    </p>
                </div>

            </div>
        </div>

    </div>

    {{-- =========================================================
         SUCCESS
    ========================================================== --}}
    @if (session('success'))
        <div class="overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50 dark:border-emerald-900/40 dark:bg-emerald-950/30">
            <div class="flex items-start gap-3 px-5 py-4">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold text-emerald-800 dark:text-emerald-300">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-xs leading-5 text-emerald-700 dark:text-emerald-400">
                        {{ session('success') }}
                    </p>
                </div>

            </div>
        </div>
    @endif

    {{-- =========================================================
         FILTER
    ========================================================== --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="mb-5 flex items-center gap-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                <i class="bi bi-funnel-fill"></i>
            </div>

            <div>
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                    Filter Penarikan
                </h2>

                <p class="mt-0.5 text-xs text-slate-400 dark:text-slate-500">
                    Cari freelancer, metode, atau informasi rekening.
                </p>
            </div>

        </div>

        <form
            action="{{ route('admin.withdrawals.index') }}"
            method="GET"
            class="grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1fr)_220px_auto]"
        >

            {{-- SEARCH --}}
            <div>
                <label
                    for="search"
                    class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                >
                    Cari pengajuan
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
                        placeholder="Nama freelancer, rekening, metode..."
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                    >
                </div>
            </div>

            {{-- STATUS --}}
            <div>
                <label
                    for="status"
                    class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs text-slate-700 outline-none transition hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                >
                    <option value="">
                        Semua status
                    </option>

                    <option value="pending" @selected($status === 'pending')>
                        Menunggu
                    </option>

                    <option value="processing" @selected($status === 'processing')>
                        Diproses
                    </option>

                    <option value="approved" @selected($status === 'approved')>
                        Disetujui
                    </option>

                    <option value="rejected" @selected($status === 'rejected')>
                        Ditolak
                    </option>
                </select>
            </div>

            {{-- BUTTONS --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15 lg:w-auto"
                >
                    <i class="bi bi-search"></i>
                    Cari
                </button>

                @if ($search !== '' || $status)
                    <a
                        href="{{ route('admin.withdrawals.index') }}"
                        class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-900 dark:hover:bg-blue-950/20 dark:hover:text-blue-400"
                    >
                        Reset
                    </a>
                @endif

            </div>

        </form>

    </section>

    {{-- =========================================================
         DATA TABLE
    ========================================================== --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- HEADER TABLE --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div>
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                    <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                        Penarikan
                    </p>
                </div>

                <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                    Daftar Penarikan
                </h2>

                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                    Menampilkan {{ $withdrawals->firstItem() ?? 0 }}–{{ $withdrawals->lastItem() ?? 0 }}
                    dari {{ $withdrawals->total() }} pengajuan
                </p>
            </div>

            <div class="hidden items-center gap-2 rounded-xl bg-blue-50 px-3 py-2 text-[10px] font-semibold text-blue-700 dark:bg-blue-950/30 dark:text-blue-300 sm:flex">
                <i class="bi bi-shield-check"></i>
                Pemeriksaan penarikan
            </div>

        </div>

        {{-- =====================================================
             DESKTOP
        ====================================================== --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="min-w-full">

                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 dark:border-slate-800 dark:bg-slate-950/60">

                        <th class="whitespace-nowrap px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Freelancer
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Metode
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Pengajuan
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Net Amount
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Status
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-right text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                    @forelse ($withdrawals as $withdrawal)

                        @php
                            $withdrawalStatus = $statusMap[$withdrawal->status] ?? [
                                'label' => ucfirst(str_replace('_', ' ', $withdrawal->status ?? 'Unknown')),
                                'class' => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
                                'icon' => 'bi-question-circle',
                            ];

                            $freelancer = $withdrawal->freelancerProfile;
                            $freelancerUser = $freelancer?->user;

                            $freelancerAvatar = $freelancer?->avatar;
                            $freelancerAvatarUrl = null;

                            if ($freelancerAvatar) {
                                $freelancerAvatarUrl =
                                    str_starts_with($freelancerAvatar, 'http://')
                                    || str_starts_with($freelancerAvatar, 'https://')
                                    ? $freelancerAvatar
                                    : asset('storage/' . ltrim($freelancerAvatar, '/'));
                            }

                            $freelancerName = $freelancerUser?->name ?? 'Freelancer tidak tersedia';

                            $freelancerInitials = collect(explode(' ', trim($freelancerName)))
                                ->filter()
                                ->take(2)
                                ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                                ->implode('');
                        @endphp

                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/40">

                            {{-- FREELANCER --}}
                            <td class="px-5 py-4">

                                <div class="flex min-w-[220px] items-center gap-3">

                                    <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-slate-200 bg-blue-50 dark:border-slate-700 dark:bg-blue-950/30">

                                        @if ($freelancerAvatarUrl)
                                            <img
                                                src="{{ $freelancerAvatarUrl }}"
                                                alt="{{ $freelancerName }}"
                                                class="h-full w-full object-cover"
                                            >
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-blue-600 dark:text-blue-400">
                                                {{ $freelancerInitials ?: 'FR' }}
                                            </div>
                                        @endif

                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-bold text-slate-800 dark:text-slate-200">
                                            {{ $freelancerName }}
                                        </p>

                                        @if ($freelancerUser?->email)
                                            <p class="mt-1 truncate text-[10px] text-slate-400">
                                                {{ $freelancerUser->email }}
                                            </p>
                                        @endif
                                    </div>

                                </div>

                            </td>

                            {{-- METHOD --}}
                            <td class="px-5 py-4">
                                <div class="min-w-[150px]">

                                    <div class="inline-flex items-center gap-2 rounded-lg bg-slate-50 px-2.5 py-2 dark:bg-slate-950/60">
                                        <i class="bi bi-credit-card text-[11px] text-blue-600 dark:text-blue-400"></i>

                                        <p class="text-[10px] font-bold uppercase text-slate-700 dark:text-slate-300">
                                            {{ strtoupper($withdrawal->method ?? '-') }}
                                        </p>
                                    </div>

                                    <p class="mt-1.5 text-[10px] text-slate-400">
                                        {{ $withdrawal->account_name ?: 'Nama rekening tidak tersedia' }}
                                    </p>

                                </div>
                            </td>

                            {{-- AMOUNT --}}
                            <td class="px-5 py-4">
                                <div class="min-w-[145px]">

                                    <p class="text-xs font-bold text-slate-900 dark:text-white">
                                        Rp {{ number_format((float) $withdrawal->amount, 0, ',', '.') }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-slate-400">
                                        Fee:
                                        Rp {{ number_format((float) $withdrawal->admin_fee, 0, ',', '.') }}
                                    </p>

                                </div>
                            </td>

                            {{-- NET --}}
                            <td class="px-5 py-4">

                                <div class="min-w-[145px]">

                                    <p class="text-xs font-bold text-blue-600 dark:text-blue-400">
                                        Rp {{ number_format((float) $withdrawal->net_amount, 0, ',', '.') }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-slate-400">
                                        Diterima freelancer
                                    </p>

                                </div>

                            </td>

                            {{-- STATUS --}}
                            <td class="px-5 py-4">

                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1.5 text-[9px] font-bold {{ $withdrawalStatus['class'] }}">
                                    <i class="bi {{ $withdrawalStatus['icon'] }}"></i>
                                    {{ $withdrawalStatus['label'] }}
                                </span>

                            </td>

                            {{-- ACTION --}}
                            <td class="px-5 py-4">

                                <div class="flex justify-end">

                                    <a
                                        href="{{ route('admin.withdrawals.show', $withdrawal) }}"
                                        class="inline-flex h-9 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-[10px] font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-900 dark:hover:bg-blue-950/20 dark:hover:text-blue-400"
                                        title="Lihat detail"
                                    >
                                        <i class="bi bi-eye"></i>
                                        Detail
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-950/30 dark:text-blue-400">
                                    <i class="bi bi-bank text-2xl"></i>
                                </div>

                                <h3 class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-200">
                                    Pengajuan belum ditemukan
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-slate-400 dark:text-slate-500">
                                    Tidak ada pengajuan penarikan yang sesuai dengan pencarian atau filter.
                                </p>

                                @if ($search !== '' || $status)
                                    <a
                                        href="{{ route('admin.withdrawals.index') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700"
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

        {{-- =====================================================
             MOBILE
        ====================================================== --}}
        <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">

            @forelse ($withdrawals as $withdrawal)

                @php
                    $withdrawalStatus = $statusMap[$withdrawal->status] ?? [
                        'label' => ucfirst(str_replace('_', ' ', $withdrawal->status ?? 'Unknown')),
                        'class' => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
                        'icon' => 'bi-question-circle',
                    ];

                    $freelancer = $withdrawal->freelancerProfile;
                    $freelancerUser = $freelancer?->user;

                    $freelancerAvatar = $freelancer?->avatar;
                    $freelancerAvatarUrl = null;

                    if ($freelancerAvatar) {
                        $freelancerAvatarUrl =
                            str_starts_with($freelancerAvatar, 'http://')
                            || str_starts_with($freelancerAvatar, 'https://')
                            ? $freelancerAvatar
                            : asset('storage/' . ltrim($freelancerAvatar, '/'));
                    }

                    $freelancerName = $freelancerUser?->name ?? 'Freelancer tidak tersedia';

                    $freelancerInitials = collect(explode(' ', trim($freelancerName)))
                        ->filter()
                        ->take(2)
                        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                        ->implode('');
                @endphp

                <article class="p-4 sm:p-5">

                    {{-- TOP --}}
                    <div class="flex items-start justify-between gap-3">

                        <div class="flex min-w-0 items-center gap-3">

                            <div class="h-11 w-11 shrink-0 overflow-hidden rounded-full border border-slate-200 bg-blue-50 dark:border-slate-700 dark:bg-blue-950/30">

                                @if ($freelancerAvatarUrl)
                                    <img
                                        src="{{ $freelancerAvatarUrl }}"
                                        alt="{{ $freelancerName }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-xs font-bold text-blue-600 dark:text-blue-400">
                                        {{ $freelancerInitials ?: 'FR' }}
                                    </div>
                                @endif

                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-xs font-bold text-slate-800 dark:text-slate-200">
                                    {{ $freelancerName }}
                                </p>

                                @if ($freelancerUser?->email)
                                    <p class="mt-0.5 truncate text-[10px] text-slate-400">
                                        {{ $freelancerUser->email }}
                                    </p>
                                @endif

                                <p class="mt-1 text-[10px] font-bold uppercase tracking-wide text-blue-600 dark:text-blue-400">
                                    {{ strtoupper($withdrawal->method ?? '-') }}
                                </p>
                            </div>

                        </div>

                        <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1.5 text-[9px] font-bold {{ $withdrawalStatus['class'] }}">
                            <i class="bi {{ $withdrawalStatus['icon'] }}"></i>
                            {{ $withdrawalStatus['label'] }}
                        </span>

                    </div>

                    {{-- FINANCIAL --}}
                    <div class="mt-4 grid grid-cols-2 gap-3">

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-950/50">
                            <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                Pengajuan
                            </p>

                            <p class="mt-1.5 text-xs font-bold text-slate-900 dark:text-white">
                                Rp {{ number_format((float) $withdrawal->amount, 0, ',', '.') }}
                            </p>

                            <p class="mt-1 text-[9px] text-slate-400">
                                Fee Rp {{ number_format((float) $withdrawal->admin_fee, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-3 dark:border-blue-900/30 dark:bg-blue-950/20">
                            <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-blue-600 dark:text-blue-400">
                                Net Amount
                            </p>

                            <p class="mt-1.5 text-xs font-bold text-blue-700 dark:text-blue-300">
                                Rp {{ number_format((float) $withdrawal->net_amount, 0, ',', '.') }}
                            </p>

                            <p class="mt-1 text-[9px] text-blue-600/70 dark:text-blue-400/70">
                                Diterima freelancer
                            </p>
                        </div>

                    </div>

                    {{-- ACCOUNT --}}
                    <div class="mt-3 rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                <i class="bi bi-credit-card text-sm"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                    Rekening
                                </p>

                                <p class="mt-1 truncate text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    {{ $withdrawal->account_name ?: '-' }}
                                </p>

                                <p class="mt-1 truncate text-[10px] text-slate-400">
                                    {{ $withdrawal->account_number ?: '-' }}
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- ACTION --}}
                    <a
                        href="{{ route('admin.withdrawals.show', $withdrawal) }}"
                        class="mt-3 inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15"
                    >
                        <i class="bi bi-eye"></i>
                        Lihat Detail Penarikan
                    </a>

                </article>

            @empty

                <div class="px-6 py-14 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-950/30 dark:text-blue-400">
                        <i class="bi bi-bank text-2xl"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-200">
                        Pengajuan belum ditemukan
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-slate-400 dark:text-slate-500">
                        Belum ada pengajuan penarikan.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- =====================================================
             PAGINATION
        ====================================================== --}}
        @if ($withdrawals->hasPages())
            <div class="border-t border-slate-100 px-5 py-4 dark:border-slate-800 sm:px-6">
                {{ $withdrawals->links() }}
            </div>
        @endif

    </section>

</div>


</x-layouts.admin>
