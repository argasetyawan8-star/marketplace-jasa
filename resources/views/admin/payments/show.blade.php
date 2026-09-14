<x-layouts.admin title="Detail Pembayaran">

    @php
        $statusMap = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-[#FEF3C7] text-[#92400E] border-[#F2D99B] dark:bg-[#48391E] dark:text-[#E8C67A] dark:border-[#665326]',
                'icon' => 'bi-hourglass-split',
            ],
            'paid' => [
                'label' => 'Berhasil',
                'class' => 'bg-[#DCFCE7] text-[#166534] border-[#B8E6C8] dark:bg-[#244732] dark:text-[#A0E8B7] dark:border-[#315C43]',
                'icon' => 'bi-check-circle-fill',
            ],
            'failed' => [
                'label' => 'Gagal',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] border-[#F2C5C5] dark:bg-[#492727] dark:text-[#F0A3A3] dark:border-[#6A3B3B]',
                'icon' => 'bi-x-circle-fill',
            ],
            'expired' => [
                'label' => 'Kadaluarsa',
                'class' => 'bg-[#F3F4F6] text-[#4B5563] border-[#D9DDE1] dark:bg-[#26352D] dark:text-[#C3CEC8] dark:border-[#3A4A42]',
                'icon' => 'bi-clock-history',
            ],
            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-[#FFF1E6] text-[#9A4D16] border-[#F1D1B5] dark:bg-[#49311F] dark:text-[#F1B47B] dark:border-[#69462E]',
                'icon' => 'bi-slash-circle',
            ],
        ];

        $paymentStatus = $statusMap[$payment->status] ?? [
            'label' => ucfirst(str_replace('_', ' ', $payment->status ?? 'Unknown')),
            'class' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600',
            'icon' => 'bi-question-circle',
        ];

        $order = $payment->order;
        $client = $order?->client;
        $freelancer = $order?->freelancerProfile;
        $freelancerUser = $freelancer?->user;
    @endphp


    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <a
                    href="{{ route('admin.payments.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#1E9E5A] dark:text-[#93A89F] dark:hover:text-[#7AD8B5]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke pembayaran
                </a>

                <div class="mt-4">

                    <div class="flex flex-wrap items-center gap-2">

                        <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                            Detail Pembayaran
                        </p>

                        <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $paymentStatus['class'] }}">
                            <i class="bi {{ $paymentStatus['icon'] }}"></i>
                            {{ $paymentStatus['label'] }}
                        </span>

                    </div>

                    <h1 class="mt-2 break-all text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                        {{ $payment->transaction_id ?: 'Transaksi belum memiliki ID' }}
                    </h1>

                    <p class="mt-1 text-sm text-[#667D73] dark:text-[#A9BCB2]">
                        Detail transaksi pembayaran untuk pesanan
                        @if ($order)
                            <span class="font-medium text-[#355247] dark:text-[#D0DED8]">
                                #{{ $order->order_number }}
                            </span>
                        @else
                            yang terhubung dengan order.
                        @endif
                    </p>

                </div>

            </div>


            {{-- Amount --}}
            <div class="rounded-xl border border-[#D6E4DD] bg-white px-5 py-4 dark:border-[#2E473A] dark:bg-[#13221A]">

                <p class="text-[11px] font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                    Nominal
                </p>

                <p class="mt-1 text-2xl font-semibold text-[#123128] dark:text-white">
                    Rp {{ number_format((float) $payment->gross_amount, 0, ',', '.') }}
                </p>

            </div>

        </div>


        {{-- Main --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">


            {{-- Left --}}
            <div class="space-y-6">


                {{-- Payment Information --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-credit-card-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Informasi Pembayaran
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Data transaksi yang tersimpan di sistem
                            </p>
                        </div>

                    </div>


                    <div class="mt-6 grid gap-5 sm:grid-cols-2">

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Payment ID
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                #{{ $payment->id }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Order ID
                            </p>

                            @if ($order)
                                <a
                                    href="{{ route('admin.orders.show', $order) }}"
                                    class="mt-1 inline-block text-sm font-semibold text-[#1E9E5A] hover:text-[#17844A] dark:text-[#7AD8B5] dark:hover:text-[#9CE7C0]"
                                >
                                    #{{ $order->order_number }}
                                </a>
                            @else
                                <p class="mt-1 text-sm font-medium text-[#71837B] dark:text-[#8FA59A]">
                                    Order tidak tersedia
                                </p>
                            @endif
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Transaction ID
                            </p>

                            <p class="mt-1 break-all text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $payment->transaction_id ?: '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Payment Type
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_type ?? '-')) }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Status
                            </p>

                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $paymentStatus['class'] }}">
                                <i class="bi {{ $paymentStatus['icon'] }}"></i>
                                {{ $paymentStatus['label'] }}
                            </span>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Dibayar Pada
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $payment->paid_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Dibuat
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $payment->created_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Diperbarui
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $payment->updated_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Order --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="border-b border-[#D6E4DD] px-6 py-4 dark:border-[#2E473A]">

                        <div class="flex items-center justify-between gap-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    <i class="bi bi-receipt-cutoff"></i>
                                </div>

                                <div>
                                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                        Pesanan Terkait
                                    </h2>

                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Order yang dibayar
                                    </p>
                                </div>

                            </div>

                            @if ($order)
                                <a
                                    href="{{ route('admin.orders.show', $order) }}"
                                    class="inline-flex items-center gap-2 rounded-xl border border-[#BFCFC7] bg-white px-3.5 py-2.5 text-sm font-medium text-[#486258] transition hover:border-[#AFC2B8] hover:bg-[#F6FAF8] hover:text-[#1E9E5A] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#AFC0B8] dark:hover:border-[#4C695B] dark:hover:bg-[#1D3327] dark:hover:text-[#7AD8B5]"
                                >
                                    Detail Order
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>
                            @endif

                        </div>

                    </div>


                    @if ($order)

                        <div class="p-6">

                            <div class="grid gap-5 sm:grid-cols-2">

                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Nomor Order
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                        #{{ $order->order_number }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Status Order
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        {{ ucfirst(str_replace('_', ' ', $order->status ?? '-')) }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Subtotal
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Platform Fee
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Total Order
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                        Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Freelancer Amount
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                        Rp {{ number_format((float) $order->freelancer_amount, 0, ',', '.') }}
                                    </p>
                                </div>

                            </div>

                        </div>

                    @else

                        <div class="p-6">

                            <div class="rounded-xl border border-[#F2D99B] bg-[#FFF9E8] px-4 py-3 dark:border-[#665326] dark:bg-[#302818]">
                                <div class="flex items-start gap-3">
                                    <i class="bi bi-exclamation-circle mt-0.5 text-[#A16207] dark:text-[#E8C67A]"></i>

                                    <p class="text-sm text-[#825B12] dark:text-[#D9BE7E]">
                                        Order yang terhubung dengan pembayaran ini tidak ditemukan.
                                    </p>
                                </div>
                            </div>

                        </div>

                    @endif

                </div>


                {{-- Users --}}
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
                                    Pemilik pembayaran
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
                                    Penerima hasil transaksi
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


                {{-- Gateway Response --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="border-b border-[#D6E4DD] px-6 py-4 dark:border-[#2E473A]">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                <i class="bi bi-code-square"></i>
                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                    Gateway Response
                                </h2>

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Data respons dari payment gateway
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="p-6">

                        @if ($payment->gateway_response)

                            <pre class="max-h-[420px] overflow-auto rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 text-xs leading-6 text-[#355247] dark:border-[#3A5245] dark:bg-[#0F1B15] dark:text-[#B7C7C0]">{{ json_encode($payment->gateway_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>

                        @else

                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-5 text-center dark:border-[#3A5245] dark:bg-[#17271F]">

                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-[#71837B] dark:bg-[#1D3025] dark:text-[#8FA59A]">
                                    <i class="bi bi-braces text-xl"></i>
                                </div>

                                <p class="mt-3 text-sm font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                    Belum ada gateway response
                                </p>

                                <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Data dari payment gateway belum tersimpan.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- Right --}}
            <div class="space-y-6">


                {{-- Payment Status --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Status Pembayaran
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Status transaksi saat ini
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 rounded-xl border px-4 py-4 {{ $paymentStatus['class'] }}">

                        <div class="flex items-start gap-3">

                            <i class="bi {{ $paymentStatus['icon'] }} mt-0.5"></i>

                            <div>

                                <p class="text-sm font-semibold">
                                    {{ $paymentStatus['label'] }}
                                </p>

                                <p class="mt-1 text-xs leading-5 opacity-90">

                                    @switch($payment->status)

                                        @case('pending')
                                            Pembayaran belum dikonfirmasi sebagai pembayaran berhasil.
                                            @break

                                        @case('paid')
                                            Pembayaran telah berhasil diterima.
                                            @break

                                        @case('failed')
                                            Pembayaran mengalami kegagalan.
                                            @break

                                        @case('expired')
                                            Pembayaran telah melewati batas waktu.
                                            @break

                                        @case('cancelled')
                                            Pembayaran dibatalkan.
                                            @break

                                        @default
                                            Status pembayaran tercatat di sistem.

                                    @endswitch

                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="mt-5 rounded-xl bg-[#F8FCF9] p-4 dark:bg-[#17271F]">

                        <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                            Nominal transaksi
                        </p>

                        <p class="mt-1 text-xl font-semibold text-[#123128] dark:text-white">
                            Rp {{ number_format((float) $payment->gross_amount, 0, ',', '.') }}
                        </p>

                    </div>

                </div>


                {{-- Related Order --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-link-45deg"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Relasi Transaksi
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Koneksi pembayaran
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 space-y-3">

                        @if ($order)

                            <a
                                href="{{ route('admin.orders.show', $order) }}"
                                class="flex items-center justify-between rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] px-4 py-3 transition hover:border-[#AFC2B8] hover:bg-[#F2F8F4] dark:border-[#3A5245] dark:bg-[#17271F] dark:hover:border-[#4C695B] dark:hover:bg-[#1D3327]"
                            >
                                <div>

                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Order
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#263F35] dark:text-[#D7E3DE]">
                                        #{{ $order->order_number }}
                                    </p>

                                </div>

                                <i class="bi bi-chevron-right text-[#8AA096] dark:text-[#718A7E]"></i>
                            </a>

                        @endif


                        @if ($client)

                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] px-4 py-3 dark:border-[#3A5245] dark:bg-[#17271F]">

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Client
                                </p>

                                <p class="mt-1 text-sm font-semibold text-[#263F35] dark:text-[#D7E3DE]">
                                    {{ $client->name }}
                                </p>

                            </div>

                        @endif


                        @if ($freelancerUser)

                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] px-4 py-3 dark:border-[#3A5245] dark:bg-[#17271F]">

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Freelancer
                                </p>

                                <p class="mt-1 text-sm font-semibold text-[#263F35] dark:text-[#D7E3DE]">
                                    {{ $freelancerUser->name }}
                                </p>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- System Note --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-[#F8FCF9] p-6 dark:border-[#2E473A] dark:bg-[#17271F]">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm dark:bg-[#1D3025] dark:text-[#7AD8B5]">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                Catatan Sistem
                            </p>

                            <p class="mt-1 text-sm leading-6 text-[#667D73] dark:text-[#A9BCB2]">
                                Status pembayaran sebaiknya diperbarui melalui proses pembayaran dan webhook payment gateway, bukan secara manual dari halaman admin.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-layouts.admin>