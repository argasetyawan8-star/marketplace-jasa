<x-layouts.admin title="Detail Komisi">

    @php
        $statusMap = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-[#FEF3C7] text-[#92400E] border-[#F2D99B] dark:bg-[#48391E] dark:text-[#E8C67A] dark:border-[#665326]',
                'icon' => 'bi-hourglass-split',
            ],
            'earned' => [
                'label' => 'Diperoleh',
                'class' => 'bg-[#DBEAFE] text-[#1D4ED8] border-[#BFDBFE] dark:bg-[#243A59] dark:text-[#9CC4FF] dark:border-[#35547E]',
                'icon' => 'bi-graph-up-arrow',
            ],
            'paid' => [
                'label' => 'Sudah Dibayarkan',
                'class' => 'bg-[#DCFCE7] text-[#166534] border-[#B8E6C8] dark:bg-[#244732] dark:text-[#A0E8B7] dark:border-[#315C43]',
                'icon' => 'bi-check-circle-fill',
            ],
            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] border-[#F2C5C5] dark:bg-[#492727] dark:text-[#F0A3A3] dark:border-[#6A3B3B]',
                'icon' => 'bi-x-circle-fill',
            ],
        ];

        $commissionStatus = $statusMap[$commission->status] ?? [
            'label' => ucfirst(str_replace('_', ' ', $commission->status ?? 'Unknown')),
            'class' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600',
            'icon' => 'bi-question-circle',
        ];

        $order = $commission->order;
        $client = $order?->client;
        $freelancer = $commission->freelancerProfile;
        $freelancerUser = $freelancer?->user;
        $payment = $order?->payment;
    @endphp


    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <a
                    href="{{ route('admin.commissions.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#1E9E5A] dark:text-[#93A89F] dark:hover:text-[#7AD8B5]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke komisi
                </a>

                <div class="mt-4">

                    <div class="flex flex-wrap items-center gap-2">

                        <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                            Detail Komisi
                        </p>

                        <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $commissionStatus['class'] }}">
                            <i class="bi {{ $commissionStatus['icon'] }}"></i>
                            {{ $commissionStatus['label'] }}
                        </span>

                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                        Komisi #{{ $commission->id }}
                    </h1>

                    <p class="mt-1 text-sm text-[#667D73] dark:text-[#A9BCB2]">
                        Pencatatan pendapatan platform dari satu transaksi marketplace.
                    </p>

                </div>

            </div>


            {{-- Commission Amount --}}
            <div class="rounded-xl border border-[#D6E4DD] bg-white px-5 py-4 dark:border-[#2E473A] dark:bg-[#13221A]">

                <p class="text-[11px] font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                    Komisi Platform
                </p>

                <p class="mt-1 text-2xl font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                    Rp {{ number_format((float) $commission->commission_amount, 0, ',', '.') }}
                </p>

            </div>

        </div>


        {{-- Main --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">


            {{-- Left --}}
            <div class="space-y-6">

                {{-- Commission Summary --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-bar-chart-line-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Rincian Komisi
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Pembagian nilai transaksi
                            </p>
                        </div>

                    </div>


                    <div class="mt-6 space-y-4">

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-[#667D73] dark:text-[#A9BCB2]">
                                Total Order
                            </span>

                            <span class="text-sm font-semibold text-[#123128] dark:text-white">
                                Rp {{ number_format((float) $commission->order_total, 0, ',', '.') }}
                            </span>
                        </div>


                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-[#667D73] dark:text-[#A9BCB2]">
                                Persentase Komisi
                            </span>

                            <span class="text-sm font-semibold text-[#123128] dark:text-white">
                                {{ number_format((float) $commission->commission_rate, 2, ',', '.') }}%
                            </span>
                        </div>


                        <div class="border-t border-[#E1EBE6] pt-4 dark:border-[#294036]">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-sm font-semibold text-[#123128] dark:text-white">
                                    Komisi Platform
                                </span>

                                <span class="text-lg font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                    Rp {{ number_format((float) $commission->commission_amount, 0, ',', '.') }}
                                </span>

                            </div>

                        </div>


                        <div class="rounded-xl bg-[#F8FCF9] p-4 dark:bg-[#17271F]">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-sm text-[#667D73] dark:text-[#A9BCB2]">
                                    Bagian Freelancer
                                </span>

                                <span class="text-sm font-semibold text-[#123128] dark:text-white">
                                    Rp {{ number_format((float) $commission->freelancer_amount, 0, ',', '.') }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Order Information --}}
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
                                        Transaksi sumber komisi
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
                                        Platform Fee Order
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Total
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                        Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Freelancer Amount
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                        Rp {{ number_format((float) $order->freelancer_amount, 0, ',', '.') }}
                                    </p>
                                </div>

                            </div>

                        </div>

                    @else

                        <div class="p-6">

                            <div class="rounded-xl border border-[#F2C5C5] bg-[#FFF5F5] px-4 py-3 dark:border-[#6A3B3B] dark:bg-[#2A1919]">

                                <div class="flex items-start gap-3">

                                    <i class="bi bi-exclamation-circle mt-0.5 text-[#C62828] dark:text-[#F39A9A]"></i>

                                    <p class="text-sm text-[#7F4B4B] dark:text-[#D0A7A7]">
                                        Order terkait tidak ditemukan.
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endif

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
                                    Pemesan
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


                {{-- Payment --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-credit-card"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Pembayaran Terkait
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Informasi pembayaran order
                            </p>
                        </div>

                    </div>


                    @if ($payment)

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">

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
                                    Status Pembayaran
                                </p>

                                <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                    {{ ucfirst(str_replace('_', ' ', $payment->status ?? '-')) }}
                                </p>
                            </div>


                            <div>
                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Paid At
                                </p>

                                <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                    {{ $payment->paid_at?->format('d M Y, H:i') ?? '-' }}
                                </p>
                            </div>

                        </div>

                    @else

                        <div class="mt-5 rounded-xl border border-[#F2D99B] bg-[#FFF9E8] px-4 py-3 dark:border-[#665326] dark:bg-[#302818]">

                            <div class="flex items-start gap-3">

                                <i class="bi bi-exclamation-circle mt-0.5 text-[#A16207] dark:text-[#E8C67A]"></i>

                                <p class="text-sm text-[#825B12] dark:text-[#D9BE7E]">
                                    Belum terdapat pembayaran yang terhubung dengan order ini.
                                </p>

                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- Right --}}
            <div class="space-y-6">

                {{-- Status --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Status Komisi
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Kondisi pencatatan komisi
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 rounded-xl border px-4 py-4 {{ $commissionStatus['class'] }}">

                        <div class="flex items-start gap-3">

                            <i class="bi {{ $commissionStatus['icon'] }} mt-0.5"></i>

                            <div>

                                <p class="text-sm font-semibold">
                                    {{ $commissionStatus['label'] }}
                                </p>

                                <p class="mt-1 text-xs leading-5 opacity-90">

                                    @switch($commission->status)

                                        @case('pending')
                                            Komisi sudah dicatat tetapi belum menjadi pendapatan yang final.
                                            @break

                                        @case('earned')
                                            Komisi sudah menjadi pendapatan platform.
                                            @break

                                        @case('paid')
                                            Komisi telah dibayarkan atau diproses sebagai bagian dari pencatatan keuangan.
                                            @break

                                        @case('cancelled')
                                            Komisi dibatalkan dan tidak dihitung sebagai pendapatan aktif.
                                            @break

                                        @default
                                            Status komisi tersimpan di sistem.

                                    @endswitch

                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Dates --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-calendar3"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Riwayat Waktu
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Pencatatan komisi
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 space-y-4">

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Earned At
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $commission->earned_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Paid At
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $commission->paid_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Dibuat
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $commission->created_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Diperbarui
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $commission->updated_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>

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
                                Data komisi akan menjadi bagian dari perhitungan pendapatan platform dan saldo freelancer setelah alur transaksi diselesaikan.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-layouts.admin>