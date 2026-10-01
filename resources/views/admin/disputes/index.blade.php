
<x-layouts.admin title="Dispute Center">

    @php
        $statusLabels = [
            'open' => 'Dibuka',
            'pending_response' => 'Menunggu Tanggapan',
            'under_review' => 'Perlu Ditinjau',
            'resolved_client' => 'Selesai untuk Client',
            'resolved_freelancer' => 'Selesai untuk Freelancer',
            'resolved_partial' => 'Selesai Sebagian',
            'closed' => 'Ditutup',
        ];

        $statusClasses = [
            'open' =>
                'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200',

            'pending_response' =>
                'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',

            'under_review' =>
                'bg-violet-50 text-violet-700 ring-1 ring-inset ring-violet-200',

            'resolved_client' =>
                'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200',

            'resolved_freelancer' =>
                'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200',

            'resolved_partial' =>
                'bg-orange-50 text-orange-700 ring-1 ring-inset ring-orange-200',

            'closed' =>
                'bg-slate-50 text-slate-600 ring-1 ring-inset ring-slate-200',
        ];
    @endphp

    <div class="min-h-screen bg-slate-50">

        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8 lg:py-7">

            {{-- Success Alert --}}
            @if(session('success'))
                <div class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-white px-4 py-4 shadow-sm">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-900">
                            Berhasil
                        </p>

                        <p class="mt-0.5 text-sm leading-6 text-slate-600">
                            {{ session('success') }}
                        </p>
                    </div>

                </div>
            @endif

            {{-- Page Header --}}
            <div class="mb-6">
                <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">

                    <div class="max-w-2xl">

                        <div class="flex flex-wrap items-center gap-2">

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-[11px] font-semibold text-blue-700 ring-1 ring-inset ring-blue-200">
                                <i class="bi bi-shield-check"></i>
                                Support & Safety
                            </span>

                            <span class="text-xs text-slate-400">
                                Admin Panel
                            </span>

                        </div>

                        <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Dispute Center
                        </h1>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Tinjau sengketa Client dan Freelancer berdasarkan order,
                            tanggapan, serta bukti yang tersedia.
                        </p>

                    </div>

                    {{-- Summary Stats --}}
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 xl:min-w-[600px]">

                        {{-- All --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                            <div class="flex items-center justify-between gap-2">

                                <span class="text-xs font-medium text-slate-500">
                                    Semua
                                </span>

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                    <i class="bi bi-collection"></i>
                                </div>

                            </div>

                            <p class="mt-3 text-2xl font-bold text-slate-900">
                                {{ $counts['all'] }}
                            </p>

                            <p class="mt-1 text-[11px] text-slate-400">
                                Total dispute
                            </p>

                        </div>

                        {{-- Pending Response --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                            <div class="flex items-center justify-between gap-2">

                                <span class="text-xs font-medium text-slate-500">
                                    Perlu Respon
                                </span>

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>

                            </div>

                            <p class="mt-3 text-2xl font-bold text-slate-900">
                                {{ $counts['pending_response'] }}
                            </p>

                            <p class="mt-1 text-[11px] text-slate-400">
                                Menunggu tanggapan
                            </p>

                        </div>

                        {{-- Under Review --}}
                        <div class="rounded-2xl border border-violet-200 bg-violet-50/70 p-4 shadow-sm">

                            <div class="flex items-center justify-between gap-2">

                                <span class="text-xs font-medium text-violet-700">
                                    Perlu Ditinjau
                                </span>

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-violet-600 shadow-sm">
                                    <i class="bi bi-search"></i>
                                </div>

                            </div>

                            <p class="mt-3 text-2xl font-bold text-violet-900">
                                {{ $counts['under_review'] }}
                            </p>

                            <p class="mt-1 text-[11px] text-violet-600/70">
                                Perlu tindakan admin
                            </p>

                        </div>

                        {{-- Resolved --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                            <div class="flex items-center justify-between gap-2">

                                <span class="text-xs font-medium text-slate-500">
                                    Selesai
                                </span>

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                    <i class="bi bi-check2-circle"></i>
                                </div>

                            </div>

                            <p class="mt-3 text-2xl font-bold text-slate-900">
                                {{ $counts['resolved'] }}
                            </p>

                            <p class="mt-1 text-[11px] text-slate-400">
                                Dispute terselesaikan
                            </p>

                        </div>

                    </div>

                </div>
            </div>

            {{-- Main Card --}}
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                {{-- Filter --}}
                <div class="border-b border-slate-100 bg-white px-5 py-5 sm:px-6">

                    <div class="mb-4 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <h2 class="text-base font-bold text-slate-900">
                                Daftar Dispute
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Gunakan pencarian atau status untuk menemukan kasus tertentu.
                            </p>
                        </div>

                        <div class="hidden rounded-lg bg-slate-50 px-3 py-2 text-xs text-slate-500 sm:block">
                            {{ $counts['all'] }} kasus
                        </div>

                    </div>

                    <form
                        method="GET"
                        class="grid gap-3 lg:grid-cols-[minmax(0,1fr)_220px_auto]"
                    >

                        {{-- Search --}}
                        <div class="relative">

                            <i class="bi bi-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nomor dispute, order, nama, atau masalah..."
                                class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100"
                            >

                        </div>

                        {{-- Status --}}
                        <select
                            name="status"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        >

                            <option value="">
                                Semua status
                            </option>

                            @foreach($statusLabels as $value => $label)

                                <option
                                    value="{{ $value }}"
                                    @selected(request('status') === $value)
                                >
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                        {{-- Filter --}}
                        <button
                            type="submit"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 !text-white text-sm font-semibold shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-2"
                        >
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>

                    </form>

                </div>

                {{-- Desktop Table --}}
                <div class="hidden overflow-x-auto lg:block">

                    <table class="w-full min-w-[1180px]">

                        <thead>

                            <tr class="border-b border-slate-100 bg-slate-50/80 text-left">

                                <th class="px-6 py-3.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                    Dispute
                                </th>

                                <th class="px-5 py-3.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                    Order
                                </th>

                                <th class="px-5 py-3.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                    Client
                                </th>

                                <th class="px-5 py-3.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                    Freelancer
                                </th>

                                <th class="px-5 py-3.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                    Dibuka Oleh
                                </th>

                                <th class="px-5 py-3.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                    Kategori
                                </th>

                                <th class="px-5 py-3.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                                    Status
                                </th>

                                <th class="px-6 py-3.5"></th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($disputes as $dispute)

                                @php
                                    $client = $dispute->order?->client;
                                    $clientProfile = $client?->profile;
                                    $clientAvatar = $clientProfile?->avatar;

                                    $freelancerProfile = $dispute->order?->freelancerProfile;
                                    $freelancer = $freelancerProfile?->user;
                                    $freelancerAvatar = $freelancerProfile?->avatar;

                                    $clientInitial = strtoupper(
                                        substr(
                                            $client?->name ?? 'C',
                                            0,
                                            1
                                        )
                                    );

                                    $freelancerInitial = strtoupper(
                                        substr(
                                            $freelancer?->name ?? 'F',
                                            0,
                                            1
                                        )
                                    );
                                @endphp

                                <tr class="group transition hover:bg-blue-50/30">

                                    {{-- Dispute --}}
                                    <td class="px-6 py-5">

                                        <div class="flex items-start gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                                <i class="bi bi-shield-exclamation"></i>
                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-sm font-bold text-slate-800">
                                                    {{ $dispute->dispute_number }}
                                                </p>

                                                <p class="mt-1 max-w-[230px] truncate text-xs text-slate-400">
                                                    {{ $dispute->reason }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- Order --}}
                                    <td class="px-5 py-5">

                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ $dispute->order?->order_number ?? '-' }}
                                        </p>

                                        <p class="mt-1 max-w-[190px] truncate text-xs text-slate-400">
                                            {{ $dispute->order?->items?->first()?->service_title ?? 'Pesanan Jasa' }}
                                        </p>

                                    </td>

                                    {{-- Client --}}
                                    <td class="px-5 py-5">

                                        <div class="flex items-center gap-3">

                                            @if($clientAvatar)

                                                <img
                                                    src="{{ asset('storage/' . $clientAvatar) }}"
                                                    alt="{{ $client?->name ?? 'Client' }}"
                                                    class="h-10 w-10 shrink-0 rounded-full object-cover shadow-sm ring-2 ring-white"
                                                >

                                            @else

                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700 ring-2 ring-white">
                                                    {{ $clientInitial }}
                                                </div>

                                            @endif

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-slate-700">
                                                    {{ $client?->name ?? '-' }}
                                                </p>

                                                <p class="mt-0.5 truncate text-[11px] text-slate-400">
                                                    {{ $client?->email ?? 'Client' }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- Freelancer --}}
                                    <td class="px-5 py-5">

                                        <div class="flex items-center gap-3">

                                            @if($freelancerAvatar)

                                                <img
                                                    src="{{ asset('storage/' . $freelancerAvatar) }}"
                                                    alt="{{ $freelancer?->name ?? 'Freelancer' }}"
                                                    class="h-10 w-10 shrink-0 rounded-full object-cover shadow-sm ring-2 ring-white"
                                                >

                                            @else

                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-violet-100 text-xs font-bold text-violet-700 ring-2 ring-white">
                                                    {{ $freelancerInitial }}
                                                </div>

                                            @endif

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-slate-700">
                                                    {{ $freelancer?->name ?? '-' }}
                                                </p>

                                                <p class="mt-0.5 truncate text-[11px] text-slate-400">

                                                    @if($freelancerProfile?->username)
                                                        {{ '@' . $freelancerProfile->username }}
                                                    @else
                                                        Freelancer
                                                    @endif

                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- Opener --}}
                                    <td class="px-5 py-5">

                                        <p class="text-sm font-medium text-slate-700">
                                            {{ $dispute->opener?->name ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ ucfirst($dispute->opened_by_role) }}
                                        </p>

                                    </td>

                                    {{-- Category --}}
                                    <td class="px-5 py-5">

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1.5 text-[11px] font-semibold text-slate-600">

                                            <i class="bi bi-tag"></i>

                                            {{ ucfirst(str_replace('_', ' ', $dispute->category)) }}

                                        </span>

                                    </td>

                                    {{-- Status --}}
                                    <td class="px-5 py-5">

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1.5 text-[11px] font-semibold {{ $statusClasses[$dispute->status] ?? 'bg-slate-100 text-slate-600' }}"
                                        >

                                            @if($dispute->status === 'open')

                                                <i class="bi bi-folder2-open"></i>

                                            @elseif($dispute->status === 'pending_response')

                                                <i class="bi bi-clock"></i>

                                            @elseif($dispute->status === 'under_review')

                                                <i class="bi bi-search"></i>

                                            @elseif(
                                                in_array(
                                                    $dispute->status,
                                                    [
                                                        'resolved_client',
                                                        'resolved_freelancer',
                                                        'resolved_partial',
                                                    ],
                                                    true
                                                )
                                            )

                                                <i class="bi bi-check-circle"></i>

                                            @elseif($dispute->status === 'closed')

                                                <i class="bi bi-lock"></i>

                                            @endif

                                            {{ $statusLabels[$dispute->status] ?? ucfirst(str_replace('_', ' ', $dispute->status)) }}

                                        </span>

                                    </td>

                                    {{-- Action --}}
                                    <td class="px-6 py-5 text-right">

                                        <a
                                            href="{{ route('admin.disputes.show', $dispute) }}"
                                            class="inline-flex h-9 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                        >
                                            Lihat Detail
                                            <i class="bi bi-arrow-right"></i>
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8" class="px-6 py-16 text-center">

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                            <i class="bi bi-shield-check text-2xl"></i>
                                        </div>

                                        <p class="mt-4 text-sm font-bold text-slate-800">
                                            Belum ada dispute
                                        </p>

                                        <p class="mx-auto mt-1 max-w-sm text-xs leading-5 text-slate-400">
                                            Kasus sengketa akan muncul di sini saat dibuat.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Mobile --}}
                <div class="divide-y divide-slate-100 lg:hidden">

                    @forelse($disputes as $dispute)

                        @php
                            $client = $dispute->order?->client;
                            $clientProfile = $client?->profile;
                            $clientAvatar = $clientProfile?->avatar;

                            $freelancerProfile = $dispute->order?->freelancerProfile;
                            $freelancer = $freelancerProfile?->user;
                            $freelancerAvatar = $freelancerProfile?->avatar;

                            $clientInitial = strtoupper(
                                substr(
                                    $client?->name ?? 'C',
                                    0,
                                    1
                                )
                            );

                            $freelancerInitial = strtoupper(
                                substr(
                                    $freelancer?->name ?? 'F',
                                    0,
                                    1
                                )
                            );
                        @endphp

                        <div class="p-4 sm:p-5">

                            {{-- Header --}}
                            <div class="flex items-start justify-between gap-3">

                                <div class="flex min-w-0 items-start gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                        <i class="bi bi-shield-exclamation"></i>
                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-bold text-slate-800">
                                            {{ $dispute->dispute_number }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $dispute->order?->order_number ?? '-' }}
                                        </p>

                                    </div>

                                </div>

                                <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1.5 text-[10px] font-semibold {{ $statusClasses[$dispute->status] ?? 'bg-slate-100 text-slate-600' }}">

                                    @if($dispute->status === 'open')

                                        <i class="bi bi-folder2-open"></i>

                                    @elseif($dispute->status === 'pending_response')

                                        <i class="bi bi-clock"></i>

                                    @elseif($dispute->status === 'under_review')

                                        <i class="bi bi-search"></i>

                                    @elseif(
                                        in_array(
                                            $dispute->status,
                                            [
                                                'resolved_client',
                                                'resolved_freelancer',
                                                'resolved_partial',
                                            ],
                                            true
                                        )
                                    )

                                        <i class="bi bi-check-circle"></i>

                                    @elseif($dispute->status === 'closed')

                                        <i class="bi bi-lock"></i>

                                    @endif

                                    {{ $statusLabels[$dispute->status] ?? ucfirst(str_replace('_', ' ', $dispute->status)) }}

                                </span>

                            </div>

                            {{-- Reason --}}
                            <div class="mt-4 rounded-xl bg-slate-50 p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Masalah
                                </p>

                                <p class="mt-1 text-sm leading-6 text-slate-600">
                                    {{ $dispute->reason }}
                                </p>

                            </div>

                            {{-- Client --}}
                            <div class="mt-4 rounded-2xl border border-blue-100 bg-blue-50/40 p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-600">
                                    Client
                                </p>

                                <div class="mt-3 flex items-center gap-3">

                                    @if($clientAvatar)

                                        <img
                                            src="{{ asset('storage/' . $clientAvatar) }}"
                                            alt="{{ $client?->name ?? 'Client' }}"
                                            class="h-12 w-12 shrink-0 rounded-full object-cover shadow-sm ring-2 ring-white"
                                        >

                                    @else

                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700 ring-2 ring-white">
                                            {{ $clientInitial }}
                                        </div>

                                    @endif

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-bold text-slate-800">
                                            {{ $client?->name ?? '-' }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-slate-500">
                                            {{ $client?->email ?? 'Client' }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                            {{-- Freelancer --}}
                            <div class="mt-3 rounded-2xl border border-violet-100 bg-violet-50/40 p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-violet-600">
                                    Freelancer
                                </p>

                                <div class="mt-3 flex items-center gap-3">

                                    @if($freelancerAvatar)

                                        <img
                                            src="{{ asset('storage/' . $freelancerAvatar) }}"
                                            alt="{{ $freelancer?->name ?? 'Freelancer' }}"
                                            class="h-12 w-12 shrink-0 rounded-full object-cover shadow-sm ring-2 ring-white"
                                        >

                                    @else

                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-violet-100 text-sm font-bold text-violet-700 ring-2 ring-white">
                                            {{ $freelancerInitial }}
                                        </div>

                                    @endif

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-bold text-slate-800">
                                            {{ $freelancer?->name ?? '-' }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-slate-500">

                                            @if($freelancerProfile?->username)
                                                {{ '@' . $freelancerProfile->username }}
                                            @else
                                                Freelancer
                                            @endif

                                        </p>

                                    </div>

                                </div>

                            </div>

                            {{-- Opener + Category --}}
                            <div class="mt-3 grid grid-cols-2 gap-3">

                                {{-- Opener --}}
                                <div class="rounded-xl border border-slate-200 p-3.5">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Dibuka Oleh
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                                        {{ $dispute->opener?->name ?? '-' }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        {{ ucfirst($dispute->opened_by_role) }}
                                    </p>

                                </div>

                                {{-- Category --}}
                                <div class="rounded-xl border border-slate-200 p-3.5">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Kategori
                                    </p>

                                    <span class="mt-2 inline-flex max-w-full items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1.5 text-[10px] font-semibold text-slate-600">

                                        <i class="bi bi-tag"></i>

                                        <span class="truncate">
                                            {{ ucfirst(str_replace('_', ' ', $dispute->category)) }}
                                        </span>

                                    </span>

                                </div>

                            </div>

                            {{-- Service --}}
                            <div class="mt-3 rounded-xl border border-slate-200 p-3.5">

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Pesanan Jasa
                                </p>

                                <p class="mt-1 truncate text-sm font-medium text-slate-700">
                                    {{ $dispute->order?->items?->first()?->service_title ?? 'Pesanan Jasa' }}
                                </p>

                            </div>

                            {{-- Action --}}
                            <a
                                href="{{ route('admin.disputes.show', $dispute) }}"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 !text-white text-sm font-semibold shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-2"
                            >
                                Lihat Detail Dispute
                                <i class="bi bi-arrow-right"></i>
                            </a>

                        </div>

                    @empty

                        <div class="px-5 py-16 text-center">

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                <i class="bi bi-shield-check text-2xl"></i>
                            </div>

                            <p class="mt-4 text-sm font-bold text-slate-800">
                                Belum ada dispute
                            </p>

                            <p class="mx-auto mt-1 max-w-sm text-xs leading-5 text-slate-400">
                                Kasus sengketa akan muncul di sini saat dibuat.
                            </p>

                        </div>

                    @endforelse

                </div>

                {{-- Pagination --}}
                @if($disputes->hasPages())

                    <div class="border-t border-slate-100 bg-slate-50/50 px-5 py-4 sm:px-6">
                        {{ $disputes->links() }}
                    </div>

                @endif

            </section>

        </div>

    </div>

</x-layouts.admin>
