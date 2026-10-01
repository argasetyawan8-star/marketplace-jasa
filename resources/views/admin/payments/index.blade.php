
<x-layouts.admin title="Kelola Pembayaran">

    @php
        $statusMap = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',
                'icon' => 'bi-hourglass-split',
            ],

            'paid' => [
                'label' => 'Berhasil',
                'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200',
                'icon' => 'bi-check-circle-fill',
            ],

            'failed' => [
                'label' => 'Gagal',
                'class' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200',
                'icon' => 'bi-x-circle-fill',
            ],

            'expired' => [
                'label' => 'Kadaluarsa',
                'class' => 'bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-200',
                'icon' => 'bi-clock-history',
            ],

            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-orange-50 text-orange-700 ring-1 ring-inset ring-orange-200',
                'icon' => 'bi-slash-circle',
            ],
        ];
    @endphp

    <div class="min-h-screen bg-slate-50">

        <div class="mx-auto max-w-7xl space-y-6 px-4 py-5 sm:px-6 lg:px-8 lg:py-7">

            {{-- Header --}}
            <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">

                <div class="max-w-2xl">

                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-[11px] font-semibold text-blue-700 ring-1 ring-inset ring-blue-200">
                            <i class="bi bi-credit-card"></i>
                            Transaksi
                        </span>

                        <span class="text-xs text-slate-400">
                            Admin Panel
                        </span>
                    </div>

                    <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Kelola Pembayaran
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Pantau status pembayaran dan transaksi marketplace ProKerja.
                    </p>

                </div>

                {{-- Total --}}
                <div class="w-full rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:w-auto sm:min-w-[210px]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <i class="bi bi-credit-card-fill text-lg"></i>
                        </div>

                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400">
                                Total Pembayaran
                            </p>

                            <p class="mt-1 text-xl font-bold text-slate-900">
                                {{ $payments->total() }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Filter --}}
            <section class="rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-5 py-5 sm:px-6">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <i class="bi bi-funnel-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-base font-bold text-slate-900">
                                Filter Pembayaran
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Cari berdasarkan transaksi, order, atau client.
                            </p>
                        </div>

                    </div>

                </div>

                <form
                    action="{{ route('admin.payments.index') }}"
                    method="GET"
                    class="grid gap-4 px-5 py-5 sm:px-6 lg:grid-cols-[minmax(0,1fr)_220px_auto]"
                >

                    {{-- Search --}}
                    <div>

                        <label
                            for="search"
                            class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500"
                        >
                            Cari transaksi
                        </label>

                        <div class="relative">

                            <i class="bi bi-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Transaction ID, nomor order, nama client..."
                                class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100"
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
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        >

                            <option value="pending" @selected($status === 'pending')>
                                Menunggu
                            </option>

                            <option value="paid" @selected($status === 'paid')>
                                Berhasil
                            </option>

                            <option value="failed" @selected($status === 'failed')>
                                Gagal
                            </option>

                            <option value="expired" @selected($status === 'expired')>
                                Kadaluarsa
                            </option>

                            <option value="cancelled" @selected($status === 'cancelled')>
                                Dibatalkan
                            </option>

                        </select>

                    </div>

                    {{-- Actions --}}
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
                                href="{{ route('admin.payments.index') }}"
                                class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-medium text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                            >
                                Reset
                            </a>
                        @endif

                    </div>

                </form>

            </section>

            {{-- Payments --}}
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                {{-- List Header --}}
                <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                    <div>
                        <h2 class="text-base font-bold text-slate-900">
                            Daftar Pembayaran
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Menampilkan
                            {{ $payments->firstItem() ?? 0 }}–{{ $payments->lastItem() ?? 0 }}
                            dari
                            {{ $payments->total() }}
                            pembayaran
                        </p>
                    </div>

                    <div class="inline-flex w-fit items-center gap-2 rounded-xl bg-blue-50 px-3 py-2 text-xs font-medium text-blue-700">
                        <i class="bi bi-shield-check"></i>
                        Monitoring transaksi
                    </div>

                </div>

                {{-- Desktop Table --}}
                <div class="hidden overflow-x-auto lg:block">

                    <table class="w-full min-w-[1080px]">

                        <thead>

                            <tr class="border-b border-slate-100 bg-slate-50/80 text-left">

                                <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Pembayaran
                                </th>

                                <th class="px-5 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Order
                                </th>

                                <th class="px-5 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Client
                                </th>

                                <th class="px-5 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Nominal
                                </th>

                                <th class="px-5 py-4 text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-[10px] font-semibold uppercase tracking-[0.13em] text-slate-400">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($payments as $payment)

                                @php
                                    $paymentStatus = $statusMap[$payment->status] ?? [
                                        'label' => ucfirst(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $payment->status ?? 'Unknown'
                                            )
                                        ),
                                        'class' => 'bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-200',
                                        'icon' => 'bi-question-circle',
                                    ];

                                    $order = $payment->order;
                                    $client = $order?->client;
                                    $clientProfile = $client?->profile;
                                    $clientAvatar = $clientProfile?->avatar;

                                    $clientInitial = strtoupper(
                                        substr(
                                            $client?->name ?? 'C',
                                            0,
                                            1
                                        )
                                    );
                                @endphp

                                <tr class="group transition hover:bg-blue-50/30">

                                    {{-- Payment --}}
                                    <td class="px-6 py-5">

                                        <div class="min-w-[220px]">

                                            <a
                                                href="{{ route('admin.payments.show', $payment) }}"
                                                class="block truncate text-sm font-bold text-slate-800 transition hover:text-blue-600"
                                            >
                                                {{ $payment->transaction_id ?: 'Belum ada transaction ID' }}
                                            </a>

                                            <p class="mt-1 text-xs text-slate-400">
                                                {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                                            </p>

                                        </div>

                                    </td>

                                    {{-- Order --}}
                                    <td class="px-5 py-5">

                                        <div class="min-w-[170px]">

                                            @if($order)

                                                <a
                                                    href="{{ route('admin.orders.show', $order) }}"
                                                    class="text-sm font-semibold text-slate-700 transition hover:text-blue-600"
                                                >
                                                    #{{ $order->order_number }}
                                                </a>

                                            @else

                                                <span class="text-sm text-slate-400">
                                                    Order tidak tersedia
                                                </span>

                                            @endif

                                        </div>

                                    </td>

                                    {{-- Client --}}
                                    <td class="px-5 py-5">

                                        <div class="flex min-w-[230px] items-center gap-3">

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
                                                    {{ $client?->name ?? 'Client tidak tersedia' }}
                                                </p>

                                                @if($client?->email)

                                                    <p class="mt-0.5 truncate text-xs text-slate-400">
                                                        {{ $client->email }}
                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    </td>

                                    {{-- Amount --}}
                                    <td class="px-5 py-5">

                                        <div class="min-w-[140px]">

                                            <p class="text-sm font-bold text-slate-900">
                                                Rp {{ number_format((float) $payment->gross_amount, 0, ',', '.') }}
                                            </p>

                                            @if($payment->paid_at)

                                                <p class="mt-1 text-xs text-slate-400">
                                                    {{ $payment->paid_at->format('d M Y, H:i') }}
                                                </p>

                                            @else

                                                <p class="mt-1 text-xs text-slate-400">
                                                    Belum dibayar
                                                </p>

                                            @endif

                                        </div>

                                    </td>

                                    {{-- Status --}}
                                    <td class="px-5 py-5">

                                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $paymentStatus['class'] }}">

                                            <i class="bi {{ $paymentStatus['icon'] }}"></i>

                                            {{ $paymentStatus['label'] }}

                                        </span>

                                    </td>

                                    {{-- Action --}}
                                    <td class="px-6 py-5">

                                        <div class="flex justify-end">

                                            <a
                                                href="{{ route('admin.payments.show', $payment) }}"
                                                class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                                title="Lihat detail pembayaran"
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

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                            <i class="bi bi-credit-card text-2xl"></i>
                                        </div>

                                        <h3 class="mt-4 text-sm font-bold text-slate-800">
                                            Pembayaran belum ditemukan
                                        </h3>

                                        <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-slate-400">
                                            Tidak ada pembayaran yang sesuai dengan pencarian atau filter yang dipilih.
                                        </p>

                                        @if($search !== '' || $status)

                                            <a
                                                href="{{ route('admin.payments.index') }}"
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

                {{-- Mobile --}}
                <div class="divide-y divide-slate-100 lg:hidden">

                    @forelse($payments as $payment)

                        @php
                            $paymentStatus = $statusMap[$payment->status] ?? [
                                'label' => ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $payment->status ?? 'Unknown'
                                    )
                                ),
                                'class' => 'bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-200',
                                'icon' => 'bi-question-circle',
                            ];

                            $order = $payment->order;
                            $client = $order?->client;
                            $clientProfile = $client?->profile;
                            $clientAvatar = $clientProfile?->avatar;

                            $clientInitial = strtoupper(
                                substr(
                                    $client?->name ?? 'C',
                                    0,
                                    1
                                )
                            );
                        @endphp

                        <div class="p-4 sm:p-5">

                            {{-- Top --}}
                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <a
                                        href="{{ route('admin.payments.show', $payment) }}"
                                        class="block break-all text-sm font-bold text-slate-800 transition hover:text-blue-600"
                                    >
                                        {{ $payment->transaction_id ?: 'Belum ada transaction ID' }}
                                    </a>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                                    </p>

                                </div>

                                <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1.5 text-[10px] font-semibold {{ $paymentStatus['class'] }}">

                                    <i class="bi {{ $paymentStatus['icon'] }}"></i>

                                    {{ $paymentStatus['label'] }}

                                </span>

                            </div>

                            {{-- Order --}}
                            <div class="mt-4 rounded-2xl bg-slate-50 p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Order
                                </p>

                                @if($order)

                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="mt-1 inline-block text-sm font-semibold text-slate-700 transition hover:text-blue-600"
                                    >
                                        #{{ $order->order_number }}
                                    </a>

                                @else

                                    <p class="mt-1 text-sm text-slate-400">
                                        Order tidak tersedia
                                    </p>

                                @endif

                            </div>

                            {{-- Client --}}
                            <div class="mt-3 rounded-2xl border border-blue-100 bg-blue-50/50 p-4">

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
                                            {{ $client?->name ?? 'Client tidak tersedia' }}
                                        </p>

                                        @if($client?->email)

                                            <p class="mt-0.5 truncate text-xs text-slate-500">
                                                {{ $client->email }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                                @if($clientProfile?->username)

                                    <div class="mt-3 border-t border-blue-100 pt-3">

                                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                            Username
                                        </p>

                                        <p class="mt-1 text-xs font-semibold text-slate-700">
                                            {{ '@' . $clientProfile->username }}
                                        </p>

                                    </div>

                                @endif

                            </div>

                            {{-- Amount + Action --}}
                            <div class="mt-4 flex items-center justify-between gap-4 border-t border-slate-100 pt-4">

                                <div>

                                    <p class="text-xs text-slate-400">
                                        Nominal
                                    </p>

                                    <p class="mt-0.5 text-base font-bold text-slate-900">
                                        Rp {{ number_format((float) $payment->gross_amount, 0, ',', '.') }}
                                    </p>

                                    @if($payment->paid_at)

                                        <p class="mt-1 text-[10px] text-slate-400">
                                            {{ $payment->paid_at->format('d M Y, H:i') }}
                                        </p>

                                    @else

                                        <p class="mt-1 text-[10px] text-slate-400">
                                            Belum dibayar
                                        </p>

                                    @endif

                                </div>

                                <a
                                    href="{{ route('admin.payments.show', $payment) }}"
                                    class="inline-flex h-10 shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 !text-white text-xs font-semibold shadow-sm transition hover:bg-blue-700"
                                >
                                    <i class="bi bi-eye"></i>
                                    Detail
                                </a>

                            </div>

                        </div>

                    @empty

                        <div class="px-5 py-14 text-center">

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                <i class="bi bi-credit-card text-2xl"></i>
                            </div>

                            <h3 class="mt-4 text-sm font-bold text-slate-800">
                                Pembayaran belum ditemukan
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-slate-400">
                                Belum ada pembayaran yang sesuai.
                            </p>

                        </div>

                    @endforelse

                </div>

                {{-- Pagination --}}
                @if($payments->hasPages())

                    <div class="border-t border-slate-100 bg-slate-50/50 px-5 py-4 sm:px-6">
                        {{ $payments->links() }}
                    </div>

                @endif

            </section>

        </div>

    </div>

</x-layouts.admin>
