<x-layouts.admin title="Kelola Pembayaran">

    @php
        $statusMap = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-[#FEF3C7] text-[#92400E] dark:bg-[#48391E] dark:text-[#E8C67A]',
                'icon' => 'bi-hourglass-split',
            ],
            'paid' => [
                'label' => 'Berhasil',
                'class' => 'bg-[#DCFCE7] text-[#166534] dark:bg-[#244732] dark:text-[#A0E8B7]',
                'icon' => 'bi-check-circle-fill',
            ],
            'failed' => [
                'label' => 'Gagal',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] dark:bg-[#492727] dark:text-[#F0A3A3]',
                'icon' => 'bi-x-circle-fill',
            ],
            'expired' => [
                'label' => 'Kadaluarsa',
                'class' => 'bg-[#F3F4F6] text-[#4B5563] dark:bg-[#26352D] dark:text-[#C3CEC8]',
                'icon' => 'bi-clock-history',
            ],
            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-[#FFF1E6] text-[#9A4D16] dark:bg-[#49311F] dark:text-[#F1B47B]',
                'icon' => 'bi-slash-circle',
            ],
        ];
    @endphp

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>
                <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                    Transaksi
                </p>

                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                    Kelola Pembayaran
                </h1>

                <p class="mt-1 max-w-2xl text-sm text-[#667D73] dark:text-[#A9BCB2]">
                    Pantau status pembayaran dan transaksi marketplace JASAIN.
                </p>
            </div>

            <div class="rounded-xl border border-[#D6E4DD] bg-white px-4 py-3 dark:border-[#2E473A] dark:bg-[#13221A]">
                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                        <i class="bi bi-credit-card-fill"></i>
                    </div>

                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                            Total Pembayaran
                        </p>

                        <p class="mt-0.5 text-sm font-semibold text-[#123128] dark:text-white">
                            {{ $payments->total() }}
                        </p>
                    </div>

                </div>
            </div>

        </div>


        {{-- Filter --}}
        <div class="rounded-2xl border border-[#D6E4DD] bg-white p-5 dark:border-[#2E473A] dark:bg-[#13221A]">

            <div class="mb-4 flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                        Filter Pembayaran
                    </h2>

                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                        Cari berdasarkan transaksi, order, atau client.
                    </p>
                </div>

            </div>


            <form
                action="{{ route('admin.payments.index') }}"
                method="GET"
                class="grid gap-4 lg:grid-cols-[1fr_220px_auto]"
            >

                {{-- Search --}}
                <div>
                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                    >
                        Cari transaksi
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <i class="bi bi-search text-[#80948A] dark:text-[#80988C]"></i>
                        </div>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Transaction ID, nomor order, nama client..."
                            class="w-full rounded-xl border border-[#BFCFC7] bg-white py-3 pl-10 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#95A79F] hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:placeholder:text-[#789086] dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                        >

                    </div>
                </div>


                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
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


                {{-- Buttons --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#17844A] focus:outline-none focus:ring-4 focus:ring-[#D8F3E2] dark:focus:ring-[#28533B] lg:w-auto"
                    >
                        <i class="bi bi-search"></i>
                        Cari
                    </button>

                    @if ($search !== '' || $status)
                        <a
                            href="{{ route('admin.payments.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm font-medium text-[#355247] transition hover:border-[#AFC2B8] hover:bg-[#F6FAF8] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#C4D2CC] dark:hover:border-[#4C695B] dark:hover:bg-[#1A3024]"
                        >
                            Reset
                        </a>
                    @endif

                </div>

            </form>

        </div>


        {{-- Payments --}}
        <div class="overflow-hidden rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

            <div class="flex flex-col gap-2 border-b border-[#D6E4DD] px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-[#2E473A]">

                <div>
                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                        Daftar Pembayaran
                    </h2>

                    <p class="mt-0.5 text-xs text-[#71837B] dark:text-[#8FA59A]">
                        Menampilkan {{ $payments->firstItem() ?? 0 }}–{{ $payments->lastItem() ?? 0 }}
                        dari {{ $payments->total() }} pembayaran
                    </p>
                </div>

                <div class="hidden items-center gap-2 text-xs text-[#71837B] sm:flex dark:text-[#8FA59A]">
                    <i class="bi bi-shield-check text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                    Monitoring transaksi
                </div>

            </div>


            {{-- Desktop --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full">

                    <thead>
                        <tr class="border-b border-[#D6E4DD] bg-[#F8FCF9] dark:border-[#2E473A] dark:bg-[#17271F]">

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Pembayaran
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Order
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Client
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Nominal
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Status
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Aksi
                            </th>

                        </tr>
                    </thead>


                    <tbody class="divide-y divide-[#E5EEE9] dark:divide-[#294036]">

                        @forelse ($payments as $payment)

                            @php
                                $paymentStatus = $statusMap[$payment->status] ?? [
                                    'label' => ucfirst(str_replace('_', ' ', $payment->status ?? 'Unknown')),
                                    'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
                                    'icon' => 'bi-question-circle',
                                ];

                                $order = $payment->order;
                                $client = $order?->client;
                            @endphp

                            <tr class="transition hover:bg-[#F8FCF9] dark:hover:bg-[#17271F]">

                                {{-- Payment --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[210px]">

                                        <a
                                            href="{{ route('admin.payments.show', $payment) }}"
                                            class="text-sm font-semibold text-[#123128] transition hover:text-[#1E9E5A] dark:text-white dark:hover:text-[#7AD8B5]"
                                        >
                                            {{ $payment->transaction_id ?: 'Belum ada transaction ID' }}
                                        </a>

                                        <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                            {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                                        </p>

                                    </div>

                                </td>


                                {{-- Order --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[160px]">

                                        @if ($order)

                                            <a
                                                href="{{ route('admin.orders.show', $order) }}"
                                                class="text-sm font-medium text-[#355247] transition hover:text-[#1E9E5A] dark:text-[#D0DED8] dark:hover:text-[#7AD8B5]"
                                            >
                                                #{{ $order->order_number }}
                                            </a>

                                        @else

                                            <span class="text-sm text-[#71837B] dark:text-[#8FA59A]">
                                                Order tidak tersedia
                                            </span>

                                        @endif

                                    </div>

                                </td>


                                {{-- Client --}}
                                <td class="px-5 py-4">

                                    <div class="flex min-w-[190px] items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                            {{ strtoupper(substr($client?->name ?? 'C', 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                                {{ $client?->name ?? 'Client tidak tersedia' }}
                                            </p>

                                            @if ($client?->email)
                                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                    {{ $client->email }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Amount --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[130px]">

                                        <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                            Rp {{ number_format((float) $payment->gross_amount, 0, ',', '.') }}
                                        </p>

                                        @if ($payment->paid_at)
                                            <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                {{ $payment->paid_at->format('d M Y, H:i') }}
                                            </p>
                                        @else
                                            <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                Belum dibayar
                                            </p>
                                        @endif

                                    </div>

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $paymentStatus['class'] }}">
                                        <i class="bi {{ $paymentStatus['icon'] }}"></i>
                                        {{ $paymentStatus['label'] }}
                                    </span>

                                </td>


                                {{-- Action --}}
                                <td class="px-5 py-4">

                                    <div class="flex justify-end">

                                        <a
                                            href="{{ route('admin.payments.show', $payment) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-[#D0DED8] bg-white text-[#486258] transition hover:border-[#9EB5AA] hover:bg-[#F4F8F5] hover:text-[#1E9E5A] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#AFC0B8] dark:hover:border-[#4C695B] dark:hover:bg-[#1D3327] dark:hover:text-[#7AD8B5]"
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

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                        <i class="bi bi-credit-card text-2xl"></i>
                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-[#123128] dark:text-white">
                                        Pembayaran belum ditemukan
                                    </h3>

                                    <p class="mx-auto mt-1 max-w-md text-sm text-[#71837B] dark:text-[#8FA59A]">
                                        Tidak ada pembayaran yang sesuai dengan pencarian atau filter yang dipilih.
                                    </p>

                                    @if ($search !== '' || $status)

                                        <a
                                            href="{{ route('admin.payments.index') }}"
                                            class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#1E9E5A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#17844A]"
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
            <div class="divide-y divide-[#E5EEE9] md:hidden dark:divide-[#294036]">

                @forelse ($payments as $payment)

                    @php
                        $paymentStatus = $statusMap[$payment->status] ?? [
                            'label' => ucfirst(str_replace('_', ' ', $payment->status ?? 'Unknown')),
                            'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
                            'icon' => 'bi-question-circle',
                        ];

                        $order = $payment->order;
                        $client = $order?->client;
                    @endphp

                    <div class="p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <a
                                    href="{{ route('admin.payments.show', $payment) }}"
                                    class="break-all text-sm font-semibold text-[#123128] hover:text-[#1E9E5A] dark:text-white dark:hover:text-[#7AD8B5]"
                                >
                                    {{ $payment->transaction_id ?: 'Belum ada transaction ID' }}
                                </a>

                                <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                                </p>

                            </div>

                            <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $paymentStatus['class'] }}">
                                <i class="bi {{ $paymentStatus['icon'] }}"></i>
                                {{ $paymentStatus['label'] }}
                            </span>

                        </div>


                        <div class="mt-4 space-y-3">

                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-[#879A91] dark:text-[#81968B]">
                                    Order
                                </p>

                                @if ($order)
                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="mt-1 inline-block text-sm font-medium text-[#355247] hover:text-[#1E9E5A] dark:text-[#D0DED8] dark:hover:text-[#7AD8B5]"
                                    >
                                        #{{ $order->order_number }}
                                    </a>
                                @else
                                    <p class="mt-1 text-sm text-[#71837B] dark:text-[#8FA59A]">
                                        Tidak tersedia
                                    </p>
                                @endif
                            </div>


                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-xs font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    {{ strtoupper(substr($client?->name ?? 'C', 0, 1)) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs font-medium uppercase tracking-wide text-[#879A91] dark:text-[#81968B]">
                                        Client
                                    </p>

                                    <p class="truncate text-sm text-[#355247] dark:text-[#D0DED8]">
                                        {{ $client?->name ?? 'Client tidak tersedia' }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="mt-4 flex items-center justify-between gap-4 border-t border-[#E5EEE9] pt-4 dark:border-[#294036]">

                            <div>

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Nominal
                                </p>

                                <p class="mt-0.5 text-sm font-semibold text-[#123128] dark:text-white">
                                    Rp {{ number_format((float) $payment->gross_amount, 0, ',', '.') }}
                                </p>

                            </div>

                            <a
                                href="{{ route('admin.payments.show', $payment) }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-[#EAF7EF] px-4 py-2.5 text-sm font-semibold text-[#1E7045] transition hover:bg-[#DDF1E5] dark:bg-[#234632] dark:text-[#A4E5BA] dark:hover:bg-[#2B513B]"
                            >
                                <i class="bi bi-eye"></i>
                                Detail
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="px-6 py-14 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-credit-card text-2xl"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-semibold text-[#123128] dark:text-white">
                            Pembayaran belum ditemukan
                        </h3>

                        <p class="mt-1 text-sm text-[#71837B] dark:text-[#8FA59A]">
                            Belum ada pembayaran yang sesuai.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($payments->hasPages())
                <div class="border-t border-[#D6E4DD] px-5 py-4 dark:border-[#2E473A]">
                    {{ $payments->links() }}
                </div>
            @endif

        </div>

    </div>

</x-layouts.admin>