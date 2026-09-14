<x-layouts.admin title="Detail Pesanan">

    @php
        $statusMap = [
            'pending_payment' => [
                'label' => 'Menunggu Pembayaran',
                'class' => 'bg-[#FEF3C7] text-[#92400E] border-[#F2D99B] dark:bg-[#48391E] dark:text-[#E8C67A] dark:border-[#665326]',
                'icon' => 'bi-hourglass-split',
            ],
            'paid' => [
                'label' => 'Dibayar',
                'class' => 'bg-[#DBEAFE] text-[#1D4ED8] border-[#BFDBFE] dark:bg-[#243A59] dark:text-[#9CC4FF] dark:border-[#35547E]',
                'icon' => 'bi-credit-card-fill',
            ],
            'in_progress' => [
                'label' => 'Sedang Dikerjakan',
                'class' => 'bg-[#EAF7EF] text-[#166534] border-[#BFE7CE] dark:bg-[#244732] dark:text-[#A0E8B7] dark:border-[#315C43]',
                'icon' => 'bi-hourglass-bottom',
            ],
            'revision' => [
                'label' => 'Revisi',
                'class' => 'bg-[#FFF1E6] text-[#9A4D16] border-[#F1D1B5] dark:bg-[#49311F] dark:text-[#F1B47B] dark:border-[#69462E]',
                'icon' => 'bi-arrow-repeat',
            ],
            'completed' => [
                'label' => 'Selesai',
                'class' => 'bg-[#DCFCE7] text-[#166534] border-[#B8E6C8] dark:bg-[#244732] dark:text-[#A0E8B7] dark:border-[#315C43]',
                'icon' => 'bi-check-circle-fill',
            ],
            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] border-[#F2C5C5] dark:bg-[#492727] dark:text-[#F0A3A3] dark:border-[#6A3B3B]',
                'icon' => 'bi-x-circle-fill',
            ],
        ];

        $orderStatus = $statusMap[$order->status] ?? [
            'label' => ucfirst(str_replace('_', ' ', $order->status ?? 'Unknown')),
            'class' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600',
            'icon' => 'bi-question-circle',
        ];

        $client = $order->client;
        $freelancer = $order->freelancerProfile;
        $freelancerUser = $freelancer?->user;
        $payment = $order->payment;
    @endphp


    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>
                <a
                    href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#1E9E5A] dark:text-[#93A89F] dark:hover:text-[#7AD8B5]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke daftar pesanan
                </a>

                <div class="mt-4">

                    <div class="flex flex-wrap items-center gap-2">

                        <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                            Detail Pesanan
                        </p>

                        <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $orderStatus['class'] }}">
                            <i class="bi {{ $orderStatus['icon'] }}"></i>
                            {{ $orderStatus['label'] }}
                        </span>

                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                        #{{ $order->order_number }}
                    </h1>

                    <p class="mt-1 text-sm text-[#667D73] dark:text-[#A9BCB2]">
                        Dibuat pada {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                    </p>

                </div>
            </div>


            {{-- Status --}}
            <div class="rounded-xl border border-[#D6E4DD] bg-white px-4 py-3 dark:border-[#2E473A] dark:bg-[#13221A]">

                <p class="text-[11px] font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                    Total Transaksi
                </p>

                <p class="mt-1 text-xl font-semibold text-[#123128] dark:text-white">
                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                </p>

            </div>

        </div>


        {{-- Main --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">


            {{-- Left --}}
            <div class="space-y-6">

                {{-- Order Summary --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Ringkasan Pesanan
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Informasi utama transaksi
                            </p>
                        </div>

                    </div>


                    <div class="mt-6 grid gap-4 sm:grid-cols-2">

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Nomor Pesanan
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                #{{ $order->order_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Status
                            </p>

                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $orderStatus['class'] }}">
                                <i class="bi {{ $orderStatus['icon'] }}"></i>
                                {{ $orderStatus['label'] }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Estimasi Pengerjaan
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $order->delivery_days }} hari
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Batas Pengerjaan
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $order->due_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Client & Freelancer --}}
                <div class="grid gap-6 md:grid-cols-2">

                    {{-- Client --}}
                    <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                <i class="bi bi-person"></i>
                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                    Client
                                </h2>

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Pemesan jasa
                                </p>
                            </div>

                        </div>


                        <div class="mt-5 flex items-center gap-3">

                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-lg font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                {{ strtoupper(substr($client?->name ?? 'C', 0, 1)) }}
                            </div>

                            <div class="min-w-0">

                                <p class="truncate text-sm font-semibold text-[#123128] dark:text-white">
                                    {{ $client?->name ?? 'Client tidak tersedia' }}
                                </p>

                                @if ($client?->email)
                                    <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        {{ $client->email }}
                                    </p>
                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- Freelancer --}}
                    <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                <i class="bi bi-person-badge"></i>
                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                    Freelancer
                                </h2>

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Penyedia jasa
                                </p>
                            </div>

                        </div>


                        <div class="mt-5 flex items-center gap-3">

                            <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border border-[#D6E4DD] bg-[#EAF7EF] dark:border-[#2E473A] dark:bg-[#234632]">

                                @if ($freelancer?->avatar)

                                    <img
                                        src="{{ asset('storage/' . $freelancer->avatar) }}"
                                        alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                        class="h-full w-full object-cover"
                                    >

                                @elseif ($freelancerUser)

                                    <div class="flex h-full w-full items-center justify-center text-lg font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                        {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                    </div>

                                @else

                                    <div class="flex h-full w-full items-center justify-center">
                                        <i class="bi bi-person text-xl text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                                    </div>

                                @endif

                            </div>


                            <div class="min-w-0">

                                <p class="truncate text-sm font-semibold text-[#123128] dark:text-white">
                                    {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                </p>

                                @if ($freelancer?->username)
                                    <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        {{ '@' . $freelancer->username }}
                                    </p>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Order Items --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="border-b border-[#D6E4DD] px-6 py-4 dark:border-[#2E473A]">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                <i class="bi bi-bag-check"></i>
                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                    Item Pesanan
                                </h2>

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Jasa yang dipesan client
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="divide-y divide-[#E5EEE9] dark:divide-[#294036]">

                        @forelse ($order->items as $item)

                            <div class="flex flex-col gap-3 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                                <div class="min-w-0">

                                    <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                        {{ $item->service_title ?? $item->title ?? 'Jasa' }}
                                    </p>

                                    @if (isset($item->quantity))
                                        <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                            Jumlah: {{ $item->quantity }}
                                        </p>
                                    @endif

                                </div>

                                <div class="shrink-0">

                                    <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                        Rp {{ number_format((float) ($item->subtotal ?? $item->price ?? 0), 0, ',', '.') }}
                                    </p>

                                </div>

                            </div>

                        @empty

                            <div class="px-6 py-10 text-center">
                                <p class="text-sm text-[#71837B] dark:text-[#8FA59A]">
                                    Belum ada item pada pesanan ini.
                                </p>
                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- Requirements --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-card-text"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Requirements
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Kebutuhan atau catatan dari client
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#3A5245] dark:bg-[#17271F]">

                        @if ($order->requirements)
                            <p class="whitespace-pre-line text-sm leading-7 text-[#536B60] dark:text-[#B7C7C0]">
                                {{ $order->requirements }}
                            </p>
                        @else
                            <p class="text-sm text-[#71837B] dark:text-[#8FA59A]">
                                Client tidak memberikan requirements tambahan.
                            </p>
                        @endif

                    </div>

                </div>


                {{-- Deliveries --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="border-b border-[#D6E4DD] px-6 py-4 dark:border-[#2E473A]">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                <i class="bi bi-send-check"></i>
                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                    Delivery
                                </h2>

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Riwayat pengiriman pekerjaan
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="divide-y divide-[#E5EEE9] dark:divide-[#294036]">

                        @forelse ($order->deliveries as $delivery)

                            <div class="px-6 py-5">

                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                    <div>
                                        <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                            Delivery #{{ $delivery->id }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                            {{ $delivery->created_at?->format('d M Y, H:i') ?? '-' }}
                                        </p>
                                    </div>

                                    @if ($delivery->status)
                                        <span class="inline-flex w-fit rounded-full bg-[#EAF7EF] px-3 py-1.5 text-xs font-semibold text-[#166534] dark:bg-[#244732] dark:text-[#A0E8B7]">
                                            {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                                        </span>
                                    @endif

                                </div>

                                @if ($delivery->message)
                                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-[#536B60] dark:text-[#B7C7C0]">
                                        {{ $delivery->message }}
                                    </p>
                                @endif

                            </div>

                        @empty

                            <div class="px-6 py-10 text-center">

                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    <i class="bi bi-send"></i>
                                </div>

                                <p class="mt-3 text-sm text-[#71837B] dark:text-[#8FA59A]">
                                    Belum ada delivery.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- Right --}}
            <div class="space-y-6">

                {{-- Financial Summary --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Ringkasan Keuangan
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Rincian nilai transaksi
                            </p>
                        </div>

                    </div>


                    <div class="mt-6 space-y-4">

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-[#667D73] dark:text-[#A9BCB2]">
                                Subtotal
                            </span>

                            <span class="text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-[#667D73] dark:text-[#A9BCB2]">
                                Platform fee
                            </span>

                            <span class="text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="border-t border-[#E1EBE6] pt-4 dark:border-[#294036]">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-sm font-semibold text-[#123128] dark:text-white">
                                    Total
                                </span>

                                <span class="text-lg font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                </span>

                            </div>

                        </div>


                        <div class="rounded-xl bg-[#F8FCF9] p-4 dark:bg-[#17271F]">

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Bagian Freelancer
                            </p>

                            <p class="mt-1 text-base font-semibold text-[#123128] dark:text-white">
                                Rp {{ number_format((float) $order->freelancer_amount, 0, ',', '.') }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Payment --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-credit-card"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Pembayaran
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Informasi pembayaran pesanan
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 space-y-4">

                        @if ($payment)

                            @if (isset($payment->payment_type))
                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Metode
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                                    </p>
                                </div>
                            @endif

                            @if (isset($payment->status))
                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Status Pembayaran
                                    </p>

                                    <span class="mt-1 inline-flex rounded-full bg-[#EAF7EF] px-3 py-1.5 text-xs font-semibold text-[#166534] dark:bg-[#244732] dark:text-[#A0E8B7]">
                                        {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                                    </span>
                                </div>
                            @endif

                            @if (isset($payment->paid_at))
                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Dibayar
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        {{ $payment->paid_at?->format('d M Y, H:i') ?? '-' }}
                                    </p>
                                </div>
                            @endif

                        @else

                            <div class="rounded-xl border border-[#F2D99B] bg-[#FFF9E8] px-4 py-3 dark:border-[#665326] dark:bg-[#302818]">

                                <div class="flex items-start gap-3">

                                    <i class="bi bi-exclamation-circle mt-0.5 text-[#A16207] dark:text-[#E8C67A]"></i>

                                    <p class="text-sm text-[#825B12] dark:text-[#D9BE7E]">
                                        Belum terdapat data pembayaran pada pesanan ini.
                                    </p>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- Timeline --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Timeline
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Perjalanan pesanan
                            </p>
                        </div>

                    </div>


                    <div class="mt-6 space-y-5">

                        {{-- Created --}}
                        <div class="flex gap-3">

                            <div class="relative flex w-5 justify-center">

                                <div class="mt-1.5 h-3 w-3 rounded-full bg-[#1E9E5A]"></div>

                                @if ($order->paid_at || $order->completed_at)
                                    <div class="absolute left-1/2 top-4 h-full w-px -translate-x-1/2 bg-[#D6E4DD] dark:bg-[#3A5245]"></div>
                                @endif

                            </div>

                            <div class="min-w-0">

                                <p class="text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                    Pesanan dibuat
                                </p>

                                <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                                </p>

                            </div>

                        </div>


                        {{-- Paid --}}
                        @if ($order->paid_at)

                            <div class="flex gap-3">

                                <div class="relative flex w-5 justify-center">

                                    <div class="mt-1.5 h-3 w-3 rounded-full bg-[#1E9E5A]"></div>

                                    @if ($order->completed_at)
                                        <div class="absolute left-1/2 top-4 h-full w-px -translate-x-1/2 bg-[#D6E4DD] dark:bg-[#3A5245]"></div>
                                    @endif

                                </div>

                                <div class="min-w-0">

                                    <p class="text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        Pembayaran diterima
                                    </p>

                                    <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        {{ $order->paid_at->format('d M Y, H:i') }}
                                    </p>

                                </div>

                            </div>

                        @endif


                        {{-- Completed --}}
                        @if ($order->completed_at)

                            <div class="flex gap-3">

                                <div class="flex w-5 justify-center">

                                    <div class="mt-1.5 h-3 w-3 rounded-full bg-[#1E9E5A]"></div>

                                </div>

                                <div class="min-w-0">

                                    <p class="text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        Pesanan selesai
                                    </p>

                                    <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        {{ $order->completed_at->format('d M Y, H:i') }}
                                    </p>

                                </div>

                            </div>

                        @endif


                        @if ($order->cancel_reason)

                            <div class="rounded-xl border border-[#F2C5C5] bg-[#FFF5F5] p-4 dark:border-[#6A3B3B] dark:bg-[#2A1919]">

                                <div class="flex items-start gap-3">

                                    <i class="bi bi-x-circle-fill mt-0.5 text-[#C62828] dark:text-[#F39A9A]"></i>

                                    <div>

                                        <p class="text-sm font-semibold text-[#991B1B] dark:text-[#FFAAAA]">
                                            Alasan Pembatalan
                                        </p>

                                        <p class="mt-1 whitespace-pre-line text-sm leading-6 text-[#7F4B4B] dark:text-[#D0A7A7]">
                                            {{ $order->cancel_reason }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- System Information --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-[#F8FCF9] p-6 dark:border-[#2E473A] dark:bg-[#17271F]">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm dark:bg-[#1D3025] dark:text-[#7AD8B5]">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>

                        <div class="min-w-0">

                            <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                Informasi Sistem
                            </p>

                            <div class="mt-3 space-y-2 text-xs text-[#71837B] dark:text-[#8FA59A]">

                                <p>
                                    Order ID:
                                    <span class="font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                        #{{ $order->id }}
                                    </span>
                                </p>

                                <p>
                                    Dibuat:
                                    <span class="font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                        {{ $order->created_at?->format('d M Y, H:i:s') ?? '-' }}
                                    </span>
                                </p>

                                <p>
                                    Diperbarui:
                                    <span class="font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                        {{ $order->updated_at?->format('d M Y, H:i:s') ?? '-' }}
                                    </span>
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-layouts.admin>