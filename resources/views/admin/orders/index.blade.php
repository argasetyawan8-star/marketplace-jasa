<x-layouts.admin title="Kelola Pesanan">

    @php
        $statusMap = [
            'pending_payment' => [
                'label' => 'Menunggu Pembayaran',
                'class' => 'bg-[#FEF3C7] text-[#92400E] dark:bg-[#48391E] dark:text-[#E8C67A]',
                'icon' => 'bi-hourglass-split',
            ],
            'paid' => [
                'label' => 'Dibayar',
                'class' => 'bg-[#DBEAFE] text-[#1D4ED8] dark:bg-[#243A59] dark:text-[#9CC4FF]',
                'icon' => 'bi-credit-card-fill',
            ],
            'in_progress' => [
                'label' => 'Sedang Dikerjakan',
                'class' => 'bg-[#EAF7EF] text-[#166534] dark:bg-[#244732] dark:text-[#A0E8B7]',
                'icon' => 'bi-hourglass-bottom',
            ],
            'revision' => [
                'label' => 'Revisi',
                'class' => 'bg-[#FFF1E6] text-[#9A4D16] dark:bg-[#49311F] dark:text-[#F1B47B]',
                'icon' => 'bi-arrow-repeat',
            ],
            'completed' => [
                'label' => 'Selesai',
                'class' => 'bg-[#DCFCE7] text-[#166534] dark:bg-[#244732] dark:text-[#A0E8B7]',
                'icon' => 'bi-check-circle-fill',
            ],
            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] dark:bg-[#492727] dark:text-[#F0A3A3]',
                'icon' => 'bi-x-circle-fill',
            ],
        ];
    @endphp

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>
                <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                    Marketplace
                </p>

                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                    Kelola Pesanan
                </h1>

                <p class="mt-1 max-w-2xl text-sm text-[#667D73] dark:text-[#A9BCB2]">
                    Pantau seluruh transaksi antara client dan freelancer.
                </p>
            </div>

            <div class="rounded-xl border border-[#D6E4DD] bg-white px-4 py-3 dark:border-[#2E473A] dark:bg-[#13221A]">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                        <i class="bi bi-receipt-cutoff"></i>
                    </div>

                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                            Total Pesanan
                        </p>

                        <p class="mt-0.5 text-sm font-semibold text-[#123128] dark:text-white">
                            {{ $orders->total() }}
                        </p>
                    </div>
                </div>
            </div>

        </div>


        {{-- Flash Success --}}
        @if (session('success'))
            <div class="rounded-2xl border border-[#BFE7CE] bg-[#F0FBF4] px-4 py-3 dark:border-[#315C43] dark:bg-[#14271C]">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#DCFCE7] text-[#15803D] dark:bg-[#234632] dark:text-[#8FE2AB]">
                        <i class="bi bi-check-lg"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-[#166534] dark:text-[#9BE7B0]">
                            Berhasil
                        </p>

                        <p class="mt-0.5 text-sm text-[#47705A] dark:text-[#B0C5B9]">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif


        {{-- Filter --}}
        <div class="rounded-2xl border border-[#D6E4DD] bg-white p-5 dark:border-[#2E473A] dark:bg-[#13221A]">

            <div class="mb-4 flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                        Filter Pesanan
                    </h2>

                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                        Cari berdasarkan nomor order, client, atau freelancer.
                    </p>
                </div>

            </div>


            <form
                action="{{ route('admin.orders.index') }}"
                method="GET"
                class="grid gap-4 lg:grid-cols-[1fr_240px_auto]"
            >

                {{-- Search --}}
                <div>
                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                    >
                        Cari pesanan
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
                            placeholder="Nomor order, nama client, freelancer..."
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
                        <option value="">
                            Semua status
                        </option>

                        <option
                            value="pending_payment"
                            @selected($status === 'pending_payment')
                        >
                            Menunggu Pembayaran
                        </option>

                        <option
                            value="paid"
                            @selected($status === 'paid')
                        >
                            Dibayar
                        </option>

                        <option
                            value="in_progress"
                            @selected($status === 'in_progress')
                        >
                            Sedang Dikerjakan
                        </option>

                        <option
                            value="revision"
                            @selected($status === 'revision')
                        >
                            Revisi
                        </option>

                        <option
                            value="completed"
                            @selected($status === 'completed')
                        >
                            Selesai
                        </option>

                        <option
                            value="cancelled"
                            @selected($status === 'cancelled')
                        >
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
                            href="{{ route('admin.orders.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm font-medium text-[#355247] transition hover:border-[#AFC2B8] hover:bg-[#F6FAF8] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#C4D2CC] dark:hover:border-[#4C695B] dark:hover:bg-[#1A3024]"
                        >
                            Reset
                        </a>
                    @endif

                </div>

            </form>

        </div>


        {{-- Orders Table --}}
        <div class="overflow-hidden rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

            {{-- Table Header --}}
            <div class="flex flex-col gap-2 border-b border-[#D6E4DD] px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-[#2E473A]">

                <div>
                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                        Daftar Pesanan
                    </h2>

                    <p class="mt-0.5 text-xs text-[#71837B] dark:text-[#8FA59A]">
                        Menampilkan {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }}
                        dari {{ $orders->total() }} pesanan
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
                                Pesanan
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Client
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Freelancer
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Total
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

                        @forelse ($orders as $order)

                            @php
                                $orderStatus = $statusMap[$order->status] ?? [
                                    'label' => ucfirst(str_replace('_', ' ', $order->status ?? 'Unknown')),
                                    'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
                                    'icon' => 'bi-question-circle',
                                ];

                                $freelancerUser = $order->freelancerProfile?->user;
                            @endphp

                            <tr class="transition hover:bg-[#F8FCF9] dark:hover:bg-[#17271F]">

                                {{-- Order --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[190px]">

                                        <a
                                            href="{{ route('admin.orders.show', $order) }}"
                                            class="text-sm font-semibold text-[#123128] transition hover:text-[#1E9E5A] dark:text-white dark:hover:text-[#7AD8B5]"
                                        >
                                            #{{ $order->order_number }}
                                        </a>

                                        <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                            {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                                        </p>

                                    </div>

                                </td>


                                {{-- Client --}}
                                <td class="px-5 py-4">

                                    <div class="flex min-w-[190px] items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                            {{ strtoupper(substr($order->client?->name ?? 'C', 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                                {{ $order->client?->name ?? 'Client tidak tersedia' }}
                                            </p>

                                            @if ($order->client?->email)
                                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                    {{ $order->client->email }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Freelancer --}}
                                <td class="px-5 py-4">

                                    <div class="flex min-w-[190px] items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                            {{ strtoupper(substr($freelancerUser?->name ?? 'F', 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                                {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                            </p>

                                            @if ($order->freelancerProfile?->username)
                                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                    {{ '@' . $order->freelancerProfile->username }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Total --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[120px]">

                                        <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                            Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
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
                                        <i class="bi bi-receipt text-2xl"></i>
                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-[#123128] dark:text-white">
                                        Pesanan belum ditemukan
                                    </h3>

                                    <p class="mx-auto mt-1 max-w-md text-sm text-[#71837B] dark:text-[#8FA59A]">
                                        Tidak ada pesanan yang sesuai dengan pencarian atau filter yang dipilih.
                                    </p>

                                    @if ($search !== '' || $status)
                                        <a
                                            href="{{ route('admin.orders.index') }}"
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

                @forelse ($orders as $order)

                    @php
                        $orderStatus = $statusMap[$order->status] ?? [
                            'label' => ucfirst(str_replace('_', ' ', $order->status ?? 'Unknown')),
                            'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
                            'icon' => 'bi-question-circle',
                        ];

                        $freelancerUser = $order->freelancerProfile?->user;
                    @endphp

                    <div class="p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <a
                                    href="{{ route('admin.orders.show', $order) }}"
                                    class="text-sm font-semibold text-[#123128] hover:text-[#1E9E5A] dark:text-white dark:hover:text-[#7AD8B5]"
                                >
                                    #{{ $order->order_number }}
                                </a>

                                <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                                </p>

                            </div>

                            <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $orderStatus['class'] }}">
                                <i class="bi {{ $orderStatus['icon'] }}"></i>
                                {{ $orderStatus['label'] }}
                            </span>

                        </div>


                        <div class="mt-4 space-y-3">

                            {{-- Client --}}
                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-xs font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    {{ strtoupper(substr($order->client?->name ?? 'C', 0, 1)) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs font-medium uppercase tracking-wide text-[#879A91] dark:text-[#81968B]">
                                        Client
                                    </p>

                                    <p class="truncate text-sm text-[#355247] dark:text-[#D0DED8]">
                                        {{ $order->client?->name ?? 'Tidak tersedia' }}
                                    </p>

                                </div>

                            </div>


                            {{-- Freelancer --}}
                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-xs font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    {{ strtoupper(substr($freelancerUser?->name ?? 'F', 0, 1)) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs font-medium uppercase tracking-wide text-[#879A91] dark:text-[#81968B]">
                                        Freelancer
                                    </p>

                                    <p class="truncate text-sm text-[#355247] dark:text-[#D0DED8]">
                                        {{ $freelancerUser?->name ?? 'Tidak tersedia' }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="mt-4 flex items-center justify-between gap-4 border-t border-[#E5EEE9] pt-4 dark:border-[#294036]">

                            <div>

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Total
                                </p>

                                <p class="mt-0.5 text-sm font-semibold text-[#123128] dark:text-white">
                                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                </p>

                            </div>

                            <a
                                href="{{ route('admin.orders.show', $order) }}"
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
                            <i class="bi bi-receipt text-2xl"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-semibold text-[#123128] dark:text-white">
                            Pesanan belum ditemukan
                        </h3>

                        <p class="mt-1 text-sm text-[#71837B] dark:text-[#8FA59A]">
                            Belum ada pesanan yang sesuai.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($orders->hasPages())
                <div class="border-t border-[#D6E4DD] px-5 py-4 dark:border-[#2E473A]">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>

    </div>

</x-layouts.admin>