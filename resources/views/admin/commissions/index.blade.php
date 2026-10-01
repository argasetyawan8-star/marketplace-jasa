
<x-layouts.admin title="Kelola Komisi">

    @php
        /*
        |--------------------------------------------------------------------------
        | Status Map
        |--------------------------------------------------------------------------
        */
        $statusMap = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200 dark:bg-amber-950/30 dark:text-amber-300 dark:ring-amber-800',
                'icon' => 'bi-hourglass-split',
            ],

            'earned' => [
                'label' => 'Diperoleh',
                'class' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200 dark:bg-blue-950/30 dark:text-blue-300 dark:ring-blue-800',
                'icon' => 'bi-graph-up-arrow',
            ],

            'paid' => [
                'label' => 'Sudah Dibayarkan',
                'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-300 dark:ring-emerald-800',
                'icon' => 'bi-check-circle-fill',
            ],

            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200 dark:bg-red-950/30 dark:text-red-300 dark:ring-red-800',
                'icon' => 'bi-x-circle-fill',
            ],
        ];
    @endphp


    <div class="min-h-screen bg-slate-50 dark:bg-slate-950">

        <div class="mx-auto max-w-7xl space-y-6 px-4 py-5 sm:px-6 lg:px-8 lg:py-7">

            {{-- =========================================================
                HEADER
            ========================================================== --}}
            <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">

                <div class="max-w-2xl">

                    <div class="flex flex-wrap items-center gap-2">

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-blue-700 ring-1 ring-inset ring-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:ring-blue-800">
                            <i class="bi bi-wallet2"></i>
                            Keuangan
                        </span>

                        <span class="text-xs text-slate-400 dark:text-slate-500">
                            Admin Panel
                        </span>

                    </div>

                    <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                        Kelola Komisi
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                        Pantau pendapatan platform dari setiap transaksi yang berhasil.
                    </p>

                </div>


                {{-- Total --}}
                <div class="w-full rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:w-auto sm:min-w-[220px] dark:border-slate-800 dark:bg-slate-900">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                            <i class="bi bi-wallet2 text-lg"></i>
                        </div>

                        <div>

                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400">
                                Total Komisi
                            </p>

                            <p class="mt-1 text-xl font-bold text-slate-900 dark:text-white">
                                {{ $commissions->total() }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                FILTER
            ========================================================== --}}
            <section class="rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-5 sm:px-6 dark:border-slate-800">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                            <i class="bi bi-funnel-fill"></i>
                        </div>

                        <div>

                            <h2 class="text-base font-bold text-slate-900 dark:text-white">
                                Filter Komisi
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                Cari berdasarkan order, client, atau freelancer.
                            </p>

                        </div>

                    </div>

                </div>


                <form
                    action="{{ route('admin.commissions.index') }}"
                    method="GET"
                    class="grid gap-4 px-5 py-5 sm:px-6 lg:grid-cols-[minmax(0,1fr)_220px_auto]"
                >

                    {{-- Search --}}
                    <div>

                        <label
                            for="search"
                            class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500"
                        >
                            Cari Komisi
                        </label>

                        <div class="relative">

                            <i class="bi bi-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Nomor order, nama client, freelancer..."
                                class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                            >

                        </div>

                    </div>


                    {{-- Status --}}
                    <div>

                        <label
                            for="status"
                            class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                        >

                            <option value="">
                                Semua status
                            </option>

                            <option value="pending" @selected($status === 'pending')>
                                Menunggu
                            </option>

                            <option value="earned" @selected($status === 'earned')>
                                Diperoleh
                            </option>

                            <option value="paid" @selected($status === 'paid')>
                                Sudah Dibayarkan
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
                            class="inline-flex h-11 flex-1 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 !text-white text-sm font-semibold shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-2 lg:flex-none"
                        >
                            <i class="bi bi-search"></i>
                            Cari
                        </button>

                        @if($search !== '' || $status)

                            <a
                                href="{{ route('admin.commissions.index') }}"
                                class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-medium text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-800 dark:hover:bg-blue-950/30 dark:hover:text-blue-300"
                            >
                                Reset
                            </a>

                        @endif

                    </div>

                </form>

            </section>


            {{-- =========================================================
                COMMISSION LIST
            ========================================================== --}}
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                {{-- List Header --}}
                <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-slate-800">

                    <div>

                        <h2 class="text-base font-bold text-slate-900 dark:text-white">
                            Daftar Komisi
                        </h2>

                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Menampilkan
                            {{ $commissions->firstItem() ?? 0 }}–{{ $commissions->lastItem() ?? 0 }}
                            dari
                            {{ $commissions->total() }}
                            komisi
                        </p>

                    </div>

                    <div class="inline-flex w-fit items-center gap-2 rounded-xl bg-blue-50 px-3 py-2 text-xs font-medium text-blue-700 dark:bg-blue-950/30 dark:text-blue-300">

                        <i class="bi bi-bar-chart-line"></i>

                        Monitoring pendapatan

                    </div>

                </div>


                {{-- =====================================================
                    DESKTOP TABLE
                ====================================================== --}}
                <div class="hidden overflow-x-auto lg:block">

                    <table class="w-full min-w-[1250px]">

                        <thead>

                            <tr class="border-b border-slate-100 bg-slate-50/80 text-left dark:border-slate-800 dark:bg-slate-800/60">

                                <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Order
                                </th>

                                <th class="px-5 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Client
                                </th>

                                <th class="px-5 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Freelancer
                                </th>

                                <th class="px-5 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Komisi Platform
                                </th>

                                <th class="px-5 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Pendapatan Freelancer
                                </th>

                                <th class="px-5 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                            @forelse($commissions as $commission)

                                @php
                                    $commissionStatus = $statusMap[$commission->status] ?? [
                                        'label' => ucfirst(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $commission->status ?? 'Unknown'
                                            )
                                        ),
                                        'class' => 'bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-700',
                                        'icon' => 'bi-question-circle',
                                    ];

                                    $order = $commission->order;

                                    $client = $order?->client;
                                    $clientProfile = $client?->profile;
                                    $clientAvatar = $clientProfile?->avatar;

                                    $freelancerProfile = $commission->freelancerProfile;
                                    $freelancerUser = $freelancerProfile?->user;
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
                                            $freelancerUser?->name ?? 'F',
                                            0,
                                            1
                                        )
                                    );
                                @endphp


                                <tr class="group transition hover:bg-blue-50/30 dark:hover:bg-blue-950/20">


                                    {{-- Order --}}
                                    <td class="px-6 py-5">

                                        <div class="min-w-[170px]">

                                            @if($order)

                                                <a
                                                    href="{{ route('admin.orders.show', $order) }}"
                                                    class="inline-flex items-center gap-1.5 text-sm font-bold text-slate-800 transition hover:text-blue-600 dark:text-slate-100 dark:hover:text-blue-300"
                                                >
                                                    #{{ $order->order_number }}

                                                    <i class="bi bi-arrow-up-right text-[10px]"></i>
                                                </a>

                                            @else

                                                <p class="text-sm text-slate-400">
                                                    Order tidak tersedia
                                                </p>

                                            @endif

                                            <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                                                Order Total
                                                <span class="font-semibold text-slate-500 dark:text-slate-400">
                                                    Rp {{ number_format((float) $commission->order_total, 0, ',', '.') }}
                                                </span>
                                            </p>

                                        </div>

                                    </td>


                                    {{-- Client --}}
                                    <td class="px-5 py-5">

                                        <div class="flex min-w-[220px] items-center gap-3">

                                            @if($clientAvatar)

                                                <img
                                                    src="{{ asset('storage/' . $clientAvatar) }}"
                                                    alt="{{ $client?->name ?? 'Client' }}"
                                                    class="h-10 w-10 shrink-0 rounded-full object-cover shadow-sm ring-2 ring-white dark:ring-slate-900"
                                                >

                                            @else

                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700 ring-2 ring-white dark:bg-blue-950/60 dark:text-blue-300 dark:ring-slate-900">
                                                    {{ $clientInitial }}
                                                </div>

                                            @endif

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-slate-700 dark:text-slate-200">
                                                    {{ $client?->name ?? 'Client tidak tersedia' }}
                                                </p>

                                                @if($client?->email)

                                                    <p class="mt-0.5 truncate text-xs text-slate-400 dark:text-slate-500">
                                                        {{ $client->email }}
                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Freelancer --}}
                                    <td class="px-5 py-5">

                                        <div class="flex min-w-[220px] items-center gap-3">

                                            @if($freelancerAvatar)

                                                <img
                                                    src="{{ asset('storage/' . $freelancerAvatar) }}"
                                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                                    class="h-10 w-10 shrink-0 rounded-full object-cover shadow-sm ring-2 ring-white dark:ring-slate-900"
                                                >

                                            @else

                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-violet-100 text-xs font-bold text-violet-700 ring-2 ring-white dark:bg-violet-950/60 dark:text-violet-300 dark:ring-slate-900">
                                                    {{ $freelancerInitial }}
                                                </div>

                                            @endif

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-slate-700 dark:text-slate-200">
                                                    {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                                </p>

                                                @if($freelancerProfile?->username)

                                                    <p class="mt-0.5 truncate text-xs text-slate-400 dark:text-slate-500">
                                                        {{ '@' . $freelancerProfile->username }}
                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Commission --}}
                                    <td class="px-5 py-5">

                                        <div class="min-w-[160px]">

                                            <p class="text-sm font-bold text-slate-900 dark:text-white">
                                                Rp {{ number_format((float) $commission->commission_amount, 0, ',', '.') }}
                                            </p>

                                            <div class="mt-1 flex items-center gap-2">

                                                <span class="rounded-full bg-blue-50 px-2 py-1 text-[10px] font-semibold text-blue-700 dark:bg-blue-950/30 dark:text-blue-300">
                                                    {{ number_format((float) $commission->commission_rate, 2, ',', '.') }}%
                                                </span>

                                                <span class="text-[10px] text-slate-400">
                                                    platform
                                                </span>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Freelancer Amount --}}
                                    <td class="px-5 py-5">

                                        <div class="min-w-[170px]">

                                            <p class="text-sm font-bold text-slate-900 dark:text-white">
                                                Rp {{ number_format((float) $commission->freelancer_amount, 0, ',', '.') }}
                                            </p>

                                            <p class="mt-1 text-[10px] text-slate-400 dark:text-slate-500">
                                                Bagian freelancer
                                            </p>

                                        </div>

                                    </td>


                                    {{-- Status --}}
                                    <td class="px-5 py-5">

                                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $commissionStatus['class'] }}">

                                            <i class="bi {{ $commissionStatus['icon'] }}"></i>

                                            {{ $commissionStatus['label'] }}

                                        </span>

                                    </td>


                                    {{-- Action --}}
                                    <td class="px-6 py-5">

                                        <div class="flex justify-end">

                                            <a
                                                href="{{ route('admin.commissions.show', $commission) }}"
                                                class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-800 dark:hover:bg-blue-950/30 dark:hover:text-blue-300"
                                                title="Lihat detail komisi"
                                            >
                                                <i class="bi bi-eye"></i>
                                                Detail
                                            </a>

                                        </div>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="7" class="px-6 py-16 text-center">

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                            <i class="bi bi-wallet2 text-2xl"></i>
                                        </div>

                                        <h3 class="mt-4 text-sm font-bold text-slate-800 dark:text-white">
                                            Komisi belum ditemukan
                                        </h3>

                                        <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-slate-400 dark:text-slate-500">
                                            Belum ada data komisi yang sesuai dengan pencarian atau filter yang dipilih.
                                        </p>

                                        @if($search !== '' || $status)

                                            <a
                                                href="{{ route('admin.commissions.index') }}"
                                                class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 !text-white text-sm font-semibold shadow-sm transition hover:bg-blue-700"
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
                <div class="divide-y divide-slate-100 lg:hidden dark:divide-slate-800">

                    @forelse($commissions as $commission)

                        @php
                            $commissionStatus = $statusMap[$commission->status] ?? [
                                'label' => ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $commission->status ?? 'Unknown'
                                    )
                                ),
                                'class' => 'bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-700',
                                'icon' => 'bi-question-circle',
                            ];

                            $order = $commission->order;

                            $client = $order?->client;
                            $clientProfile = $client?->profile;
                            $clientAvatar = $clientProfile?->avatar;

                            $freelancerProfile = $commission->freelancerProfile;
                            $freelancerUser = $freelancerProfile?->user;
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
                                    $freelancerUser?->name ?? 'F',
                                    0,
                                    1
                                )
                            );
                        @endphp


                        <div class="p-4 sm:p-5">

                            {{-- Card Header --}}
                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    @if($order)

                                        <a
                                            href="{{ route('admin.orders.show', $order) }}"
                                            class="inline-flex items-center gap-1.5 text-sm font-bold text-slate-800 hover:text-blue-600 dark:text-white dark:hover:text-blue-300"
                                        >
                                            #{{ $order->order_number }}
                                            <i class="bi bi-arrow-up-right text-[10px]"></i>
                                        </a>

                                    @else

                                        <p class="text-sm font-bold text-slate-800 dark:text-white">
                                            Order tidak tersedia
                                        </p>

                                    @endif

                                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                                        Order Total:
                                        <span class="font-semibold text-slate-600 dark:text-slate-300">
                                            Rp {{ number_format((float) $commission->order_total, 0, ',', '.') }}
                                        </span>
                                    </p>

                                </div>


                                <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1.5 text-[10px] font-semibold {{ $commissionStatus['class'] }}">

                                    <i class="bi {{ $commissionStatus['icon'] }}"></i>

                                    {{ $commissionStatus['label'] }}

                                </span>

                            </div>


                            {{-- Client --}}
                            <div class="mt-4 rounded-2xl border border-blue-100 bg-blue-50/50 p-4 dark:border-blue-900 dark:bg-blue-950/20">

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-300">
                                    Client
                                </p>

                                <div class="mt-3 flex items-center gap-3">

                                    @if($clientAvatar)

                                        <img
                                            src="{{ asset('storage/' . $clientAvatar) }}"
                                            alt="{{ $client?->name ?? 'Client' }}"
                                            class="h-12 w-12 shrink-0 rounded-full object-cover shadow-sm ring-2 ring-white dark:ring-slate-900"
                                        >

                                    @else

                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700 ring-2 ring-white dark:bg-blue-950/60 dark:text-blue-300 dark:ring-slate-900">
                                            {{ $clientInitial }}
                                        </div>

                                    @endif

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-bold text-slate-800 dark:text-white">
                                            {{ $client?->name ?? 'Client tidak tersedia' }}
                                        </p>

                                        @if($client?->email)

                                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                                {{ $client->email }}
                                            </p>

                                        @endif

                                        @if($clientProfile?->username)

                                            <p class="mt-1 truncate text-[11px] font-medium text-blue-600 dark:text-blue-300">
                                                {{ '@' . $clientProfile->username }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Freelancer --}}
                            <div class="mt-3 rounded-2xl border border-violet-100 bg-violet-50/50 p-4 dark:border-violet-900 dark:bg-violet-950/20">

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-violet-600 dark:text-violet-300">
                                    Freelancer
                                </p>

                                <div class="mt-3 flex items-center gap-3">

                                    @if($freelancerAvatar)

                                        <img
                                            src="{{ asset('storage/' . $freelancerAvatar) }}"
                                            alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                            class="h-12 w-12 shrink-0 rounded-full object-cover shadow-sm ring-2 ring-white dark:ring-slate-900"
                                        >

                                    @else

                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-violet-100 text-sm font-bold text-violet-700 ring-2 ring-white dark:bg-violet-950/60 dark:text-violet-300 dark:ring-slate-900">
                                            {{ $freelancerInitial }}
                                        </div>

                                    @endif

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-bold text-slate-800 dark:text-white">
                                            {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                        </p>

                                        @if($freelancerProfile?->username)

                                            <p class="mt-1 truncate text-[11px] font-medium text-violet-600 dark:text-violet-300">
                                                {{ '@' . $freelancerProfile->username }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Financial Summary --}}
                            <div class="mt-4 grid grid-cols-2 gap-3">

                                {{-- Commission --}}
                                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900 dark:bg-blue-950/20">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-300">
                                        Komisi Platform
                                    </p>

                                    <p class="mt-1.5 text-base font-bold text-slate-900 dark:text-white">
                                        Rp {{ number_format((float) $commission->commission_amount, 0, ',', '.') }}
                                    </p>

                                    <span class="mt-2 inline-flex rounded-full bg-white px-2 py-1 text-[10px] font-semibold text-blue-700 dark:bg-slate-900 dark:text-blue-300">
                                        {{ number_format((float) $commission->commission_rate, 2, ',', '.') }}%
                                    </span>

                                </div>


                                {{-- Freelancer Amount --}}
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Freelancer
                                    </p>

                                    <p class="mt-1.5 text-base font-bold text-slate-900 dark:text-white">
                                        Rp {{ number_format((float) $commission->freelancer_amount, 0, ',', '.') }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-slate-400">
                                        Pendapatan freelancer
                                    </p>

                                </div>

                            </div>


                            {{-- Action --}}
                            <a
                                href="{{ route('admin.commissions.show', $commission) }}"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 !text-white text-sm font-semibold shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-2"
                            >
                                <i class="bi bi-eye"></i>
                                Lihat Detail Komisi
                            </a>

                        </div>


                    @empty

                        <div class="px-5 py-14 text-center">

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                <i class="bi bi-wallet2 text-2xl"></i>
                            </div>

                            <h3 class="mt-4 text-sm font-bold text-slate-800 dark:text-white">
                                Komisi belum ditemukan
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-slate-400 dark:text-slate-500">
                                Belum ada komisi yang sesuai.
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- =====================================================
                    PAGINATION
                ====================================================== --}}
                @if($commissions->hasPages())

                    <div class="border-t border-slate-100 bg-slate-50/50 px-5 py-4 sm:px-6 dark:border-slate-800 dark:bg-slate-900/50">
                        {{ $commissions->links() }}
                    </div>

                @endif

            </section>

        </div>

    </div>

</x-layouts.admin>
