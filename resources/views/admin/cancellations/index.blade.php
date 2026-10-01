<x-layouts.admin title="Pembatalan Order">


@php
    $statusLabels = [
        'pending_freelancer' => 'Menunggu Freelancer',
        'approved_by_freelancer' => 'Disetujui Freelancer',
        'rejected_by_freelancer' => 'Ditolak Freelancer',
        'mediation_pending' => 'Menunggu Mediasi',
        'approved_by_admin' => 'Disetujui Admin',
        'rejected_by_admin' => 'Ditolak Admin',
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
                Pembatalan Order
            </h1>

            <p class="mt-1.5 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Tinjau proses pembatalan dan mediasi antara client dengan freelancer.
            </p>
        </div>

        <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                <i class="bi bi-arrow-counterclockwise"></i>
            </div>

            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                    Total Pengajuan
                </p>

                <p class="mt-0.5 text-lg font-bold text-slate-900 dark:text-white">
                    {{ $counts['all'] }}
                </p>
            </div>

        </div>

    </div>

    {{-- Statistics --}}
    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Semua --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                        Semua
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                        {{ $counts['all'] }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Seluruh pengajuan
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300">
                    <i class="bi bi-collection"></i>
                </div>

            </div>
        </div>

        {{-- Menunggu Mediasi --}}
        <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-5 dark:border-blue-900/40 dark:bg-blue-900/10">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-xs font-medium text-blue-600 dark:text-blue-300">
                        Menunggu Mediasi
                    </p>

                    <p class="mt-2 text-2xl font-bold text-blue-700 dark:text-blue-300">
                        {{ $counts['mediation_pending'] }}
                    </p>

                    <p class="mt-1 text-xs text-blue-500/80 dark:text-blue-300/70">
                        Perlu ditinjau admin
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                    <i class="bi bi-shield-exclamation"></i>
                </div>

            </div>
        </div>

        {{-- Disetujui Admin --}}
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-5 dark:border-emerald-900/40 dark:bg-emerald-900/10">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-xs font-medium text-emerald-600 dark:text-emerald-300">
                        Disetujui Admin
                    </p>

                    <p class="mt-2 text-2xl font-bold text-emerald-700 dark:text-emerald-300">
                        {{ $counts['approved_by_admin'] }}
                    </p>

                    <p class="mt-1 text-xs text-emerald-500/80 dark:text-emerald-300/70">
                        Pembatalan disetujui
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-300">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

            </div>
        </div>

        {{-- Ditolak Admin --}}
        <div class="rounded-2xl border border-red-100 bg-red-50/70 p-5 dark:border-red-900/40 dark:bg-red-900/10">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-xs font-medium text-red-600 dark:text-red-300">
                        Ditolak Admin
                    </p>

                    <p class="mt-2 text-2xl font-bold text-red-700 dark:text-red-300">
                        {{ $counts['rejected_by_admin'] }}
                    </p>

                    <p class="mt-1 text-xs text-red-500/80 dark:text-red-300/70">
                        Pengajuan ditolak
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm dark:bg-slate-900 dark:text-red-300">
                    <i class="bi bi-x-circle-fill"></i>
                </div>

            </div>
        </div>

    </div>

    {{-- Filter --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                        Filter Pembatalan
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Cari berdasarkan nomor order, nama, email, atau status proses.
                    </p>
                </div>

            </div>

        </div>

        <form
            method="GET"
            class="p-5"
        >

            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_280px_auto] lg:items-end">

                {{-- Search --}}
                <div>

                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
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
                            value="{{ request('search') }}"
                            placeholder="Cari nomor order, nama, atau email..."
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

                        <option value="">
                            Semua status
                        </option>

                        @foreach ($statusLabels as $value => $label)

                            <option
                                value="{{ $value }}"
                                @selected(request('status') === $value)
                            >
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Buttons --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15 lg:w-auto"
                    >
                        <i class="bi bi-search"></i>
                        Filter
                    </button>

                    @if (request('search') || request('status'))

                        <a
                            href="{{ url()->current() }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:border-slate-600 dark:hover:bg-slate-900 dark:hover:text-white"
                        >
                            Reset
                        </a>

                    @endif

                </div>

            </div>

        </form>

    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- Table Header --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-800">

            <div>
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                    Daftar Pembatalan
                </h2>

                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                    Data pengajuan pembatalan dan mediasi order.
                </p>
            </div>

            <div class="hidden items-center gap-2 text-xs text-slate-500 sm:flex dark:text-slate-400">
                <i class="bi bi-shield-check text-blue-600 dark:text-blue-400"></i>
                Monitoring pembatalan
            </div>

        </div>

        {{-- Desktop --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="min-w-full">

                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 dark:border-slate-800 dark:bg-slate-950/60">

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Order
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Pemohon
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Peran
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

                    @forelse($cancellations as $cancellation)

                        @php
                            $statusClass = match ($cancellation->status) {
                                'pending_freelancer' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/25 dark:text-amber-300',
                                'approved_by_freelancer' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/25 dark:text-emerald-300',
                                'rejected_by_freelancer' => 'bg-red-50 text-red-700 dark:bg-red-900/25 dark:text-red-300',
                                'mediation_pending' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/25 dark:text-blue-300',
                                'approved_by_admin' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/25 dark:text-emerald-300',
                                'rejected_by_admin' => 'bg-red-50 text-red-700 dark:bg-red-900/25 dark:text-red-300',
                                default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                            };

                            $statusIcon = match ($cancellation->status) {
                                'pending_freelancer' => 'bi-hourglass-split',
                                'approved_by_freelancer' => 'bi-check-circle-fill',
                                'rejected_by_freelancer' => 'bi-x-circle-fill',
                                'mediation_pending' => 'bi-shield-exclamation',
                                'approved_by_admin' => 'bi-check-circle-fill',
                                'rejected_by_admin' => 'bi-x-circle-fill',
                                default => 'bi-question-circle',
                            };

                            $roleClass = match ($cancellation->requester_role) {
                                'client' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-300',
                                'freelancer' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300',
                                default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                            };

                            $roleIcon = match ($cancellation->requester_role) {
                                'client' => 'bi-person',
                                'freelancer' => 'bi-person-badge',
                                default => 'bi-person',
                            };
                        @endphp

                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-950/40">

                            {{-- Order --}}
                            <td class="px-5 py-4 align-top">

                                <div class="min-w-[190px]">

                                    <a
                                        href="{{ $cancellation->order ? route('admin.orders.show', $cancellation->order) : '#' }}"
                                        class="text-sm font-bold text-slate-900 transition hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                    >
                                        #{{ $cancellation->order?->order_number ?? '-' }}
                                    </a>

                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        {{ $cancellation->created_at?->format('d M Y, H:i') ?? '-' }}
                                    </p>

                                </div>

                            </td>

                            {{-- Requester --}}
                            <td class="px-5 py-4 align-top">

                                <div class="flex min-w-[220px] items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                                        {{ strtoupper(substr($cancellation->requester?->name ?? 'U', 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $cancellation->requester?->name ?? '-' }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                            {{ $cancellation->requester?->email ?? '-' }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            {{-- Role --}}
                            <td class="px-5 py-4 align-top">

                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1.5 text-xs font-semibold {{ $roleClass }}">
                                    <i class="bi {{ $roleIcon }}"></i>
                                    {{ ucfirst($cancellation->requester_role) }}
                                </span>

                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4 align-top">

                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}">

                                    <i class="bi {{ $statusIcon }}"></i>

                                    {{ $statusLabels[$cancellation->status] ?? ucfirst(str_replace('_', ' ', $cancellation->status)) }}

                                </span>

                            </td>

                            {{-- Action --}}
                            <td class="px-5 py-4 text-right align-top">

                                <a
                                    href="{{ route('admin.cancellations.show', $cancellation) }}"
                                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:border-blue-900/50 dark:hover:bg-blue-900/20 dark:hover:text-blue-300"
                                >
                                    <i class="bi bi-eye"></i>
                                    Detail
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                                    <i class="bi bi-inbox text-2xl"></i>
                                </div>

                                <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">
                                    Belum ada data pembatalan
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500 dark:text-slate-400">
                                    Data pengajuan dan mediasi akan muncul di sini.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Mobile --}}
        <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">

            @forelse($cancellations as $cancellation)

                @php
                    $statusClass = match ($cancellation->status) {
                        'pending_freelancer' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/25 dark:text-amber-300',
                        'approved_by_freelancer' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/25 dark:text-emerald-300',
                        'rejected_by_freelancer' => 'bg-red-50 text-red-700 dark:bg-red-900/25 dark:text-red-300',
                        'mediation_pending' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/25 dark:text-blue-300',
                        'approved_by_admin' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/25 dark:text-emerald-300',
                        'rejected_by_admin' => 'bg-red-50 text-red-700 dark:bg-red-900/25 dark:text-red-300',
                        default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                    };

                    $statusIcon = match ($cancellation->status) {
                        'pending_freelancer' => 'bi-hourglass-split',
                        'approved_by_freelancer' => 'bi-check-circle-fill',
                        'rejected_by_freelancer' => 'bi-x-circle-fill',
                        'mediation_pending' => 'bi-shield-exclamation',
                        'approved_by_admin' => 'bi-check-circle-fill',
                        'rejected_by_admin' => 'bi-x-circle-fill',
                        default => 'bi-question-circle',
                    };

                    $roleClass = match ($cancellation->requester_role) {
                        'client' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-300',
                        'freelancer' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300',
                        default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                    };
                @endphp

                <div class="p-4 sm:p-5">

                    {{-- Card Header --}}
                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            @if ($cancellation->order)
                                <a
                                    href="{{ route('admin.orders.show', $cancellation->order) }}"
                                    class="text-sm font-bold text-slate-900 transition hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                >
                                    #{{ $cancellation->order->order_number }}
                                </a>
                            @else
                                <p class="text-sm font-bold text-slate-900 dark:text-white">
                                    -
                                </p>
                            @endif

                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                {{ $cancellation->created_at?->format('d M Y, H:i') ?? '-' }}
                            </p>

                        </div>

                        <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $statusClass }}">
                            <i class="bi {{ $statusIcon }}"></i>
                            {{ $statusLabels[$cancellation->status] ?? ucfirst(str_replace('_', ' ', $cancellation->status)) }}
                        </span>

                    </div>

                    {{-- Requester --}}
                    <div class="mt-4 rounded-2xl bg-slate-50 p-3.5 dark:bg-slate-950/60">

                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                                {{ strtoupper(substr($cancellation->requester?->name ?? 'U', 0, 1)) }}
                            </div>

                            <div class="min-w-0 flex-1">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                                    Pemohon
                                </p>

                                <p class="mt-0.5 truncate text-sm font-semibold text-slate-800 dark:text-slate-200">
                                    {{ $cancellation->requester?->name ?? '-' }}
                                </p>

                                <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                    {{ $cancellation->requester?->email ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Meta --}}
                    <div class="mt-3 grid grid-cols-2 gap-3">

                        <div class="rounded-xl border border-slate-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                Peran
                            </p>

                            <span class="mt-2 inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $roleClass }}">
                                <i class="bi {{ $cancellation->requester_role === 'client' ? 'bi-person' : 'bi-person-badge' }}"></i>
                                {{ ucfirst($cancellation->requester_role) }}
                            </span>

                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                Proses
                            </p>

                            <p class="mt-2 text-xs font-medium text-slate-600 dark:text-slate-300">
                                Pembatalan / Mediasi
                            </p>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="mt-4 flex items-center justify-end border-t border-slate-100 pt-4 dark:border-slate-800">

                        <a
                            href="{{ route('admin.cancellations.show', $cancellation) }}"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700"
                        >
                            <i class="bi bi-eye"></i>
                            Lihat Detail
                        </a>

                    </div>

                </div>

            @empty

                <div class="px-6 py-14 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-inbox text-2xl"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">
                        Belum ada data pembatalan
                    </h3>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Data pengajuan dan mediasi akan muncul di sini.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if($cancellations->hasPages())

            <div class="border-t border-slate-100 px-4 py-4 sm:px-5 dark:border-slate-800">
                {{ $cancellations->links() }}
            </div>

        @endif

    </div>

</div>


</x-layouts.admin>
