
<x-layouts.admin title="Detail Pembayaran">

    @php
        /*
        |--------------------------------------------------------------------------
        | Payment Status
        |--------------------------------------------------------------------------
        */
        $statusMap = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/30 dark:text-amber-300 dark:border-amber-800',
                'icon' => 'bi-hourglass-split',
                'description' => 'Pembayaran belum dikonfirmasi sebagai pembayaran berhasil.',
            ],

            'paid' => [
                'label' => 'Berhasil',
                'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-300 dark:border-emerald-800',
                'icon' => 'bi-check-circle-fill',
                'description' => 'Pembayaran telah berhasil diterima.',
            ],

            'failed' => [
                'label' => 'Gagal',
                'class' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-950/30 dark:text-red-300 dark:border-red-800',
                'icon' => 'bi-x-circle-fill',
                'description' => 'Pembayaran mengalami kegagalan.',
            ],

            'expired' => [
                'label' => 'Kadaluarsa',
                'class' => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
                'icon' => 'bi-clock-history',
                'description' => 'Pembayaran telah melewati batas waktu.',
            ],

            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-950/30 dark:text-orange-300 dark:border-orange-800',
                'icon' => 'bi-slash-circle',
                'description' => 'Pembayaran telah dibatalkan.',
            ],
        ];

        $paymentStatus = $statusMap[$payment->status] ?? [
            'label' => ucfirst(
                str_replace(
                    '_',
                    ' ',
                    $payment->status ?? 'Unknown'
                )
            ),
            'class' => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
            'icon' => 'bi-question-circle',
            'description' => 'Status pembayaran tercatat di sistem.',
        ];

        /*
        |--------------------------------------------------------------------------
        | Relations
        |--------------------------------------------------------------------------
        */
        $order = $payment->order;

        $client = $order?->client;
        $clientProfile = $client?->profile;
        $clientAvatar = $clientProfile?->avatar;

        $freelancer = $order?->freelancerProfile;
        $freelancerUser = $freelancer?->user;
        $freelancerAvatar = $freelancer?->avatar;

        /*
        |--------------------------------------------------------------------------
        | Initials
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | Gateway Response
        |
        | Mendukung:
        | - Array
        | - Object
        | - JSON String
        |--------------------------------------------------------------------------
        */
        $gatewayResponse = $payment->gateway_response;

        if (is_string($gatewayResponse)) {
            $decodedGatewayResponse = json_decode(
                $gatewayResponse,
                true
            );

            $gatewayResponse = is_array($decodedGatewayResponse)
                ? $decodedGatewayResponse
                : [];
        } elseif (is_object($gatewayResponse)) {
            $gatewayResponse = (array) $gatewayResponse;
        } elseif (!is_array($gatewayResponse)) {
            $gatewayResponse = [];
        }

        $gatewayMode = $gatewayResponse['mode'] ?? null;

        $gatewayStatus = $gatewayResponse['status'] ?? null;

        $gatewayMessage = $gatewayResponse['message'] ?? null;

        $gatewayTransactionId = $gatewayResponse['transaction_id'] ?? null;

        $gatewayStatusMap = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/30 dark:text-amber-300 dark:border-amber-800',
                'icon' => 'bi-hourglass-split',
            ],

            'paid' => [
                'label' => 'Berhasil',
                'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-300 dark:border-emerald-800',
                'icon' => 'bi-check-circle-fill',
            ],

            'failed' => [
                'label' => 'Gagal',
                'class' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-950/30 dark:text-red-300 dark:border-red-800',
                'icon' => 'bi-x-circle-fill',
            ],

            'expired' => [
                'label' => 'Kadaluarsa',
                'class' => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
                'icon' => 'bi-clock-history',
            ],

            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-950/30 dark:text-orange-300 dark:border-orange-800',
                'icon' => 'bi-slash-circle',
            ],
        ];

        $gatewayStatusInfo = $gatewayStatusMap[$gatewayStatus] ?? null;

        $gatewayModeLabel = $gatewayMode
            ? ucfirst(str_replace('_', ' ', $gatewayMode))
            : null;
    @endphp


    <div class="min-h-screen bg-slate-50 dark:bg-slate-950">

        <div class="mx-auto max-w-7xl space-y-6 px-4 py-5 sm:px-6 lg:px-8 lg:py-7">

            {{-- =========================================================
                HEADER
            ========================================================== --}}
            <div class="flex flex-col gap-5">

                {{-- Back --}}
                <div>
                    <a
                        href="{{ route('admin.payments.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm font-medium text-slate-500 transition hover:bg-blue-50 hover:text-blue-600 dark:text-slate-400 dark:hover:bg-blue-950/40 dark:hover:text-blue-300"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke pembayaran
                    </a>
                </div>


                {{-- Main Header --}}
                <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-blue-700 ring-1 ring-inset ring-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:ring-blue-800">
                                <i class="bi bi-credit-card"></i>
                                Detail Pembayaran
                            </span>

                            <span class="text-xs text-slate-400 dark:text-slate-500">
                                Payment #{{ $payment->id }}
                            </span>

                        </div>


                        <h1 class="mt-3 break-all text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                            {{ $payment->transaction_id ?: 'Transaksi Belum Memiliki ID' }}
                        </h1>


                        <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">

                            Detail transaksi pembayaran

                            @if($order)

                                untuk order

                                <a
                                    href="{{ route('admin.orders.show', $order) }}"
                                    class="font-semibold text-blue-600 transition hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-200"
                                >
                                    #{{ $order->order_number }}
                                </a>

                            @else

                                yang terhubung dengan order.

                            @endif

                        </p>

                    </div>


                    {{-- Amount + Status --}}
                    <div class="grid gap-3 sm:grid-cols-2 xl:min-w-[430px]">

                        {{-- Nominal --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400">
                                Nominal
                            </p>

                            <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                                Rp {{ number_format((float) $payment->gross_amount, 0, ',', '.') }}
                            </p>

                        </div>


                        {{-- Status --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400">
                                Status
                            </p>

                            <span class="mt-2 inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $paymentStatus['class'] }}">
                                <i class="bi {{ $paymentStatus['icon'] }}"></i>
                                {{ $paymentStatus['label'] }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                CONTENT
            ========================================================== --}}
            <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">


                {{-- =====================================================
                    LEFT COLUMN
                ====================================================== --}}
                <div class="space-y-6">


                    {{-- Payment Information --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <div class="border-b border-slate-100 px-5 py-5 sm:px-6 dark:border-slate-800">

                            <div class="flex items-start gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                    <i class="bi bi-receipt-cutoff text-lg"></i>
                                </div>

                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                        Transaksi
                                    </p>

                                    <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                        Informasi Pembayaran
                                    </h2>

                                    <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                        Detail utama pembayaran yang tersimpan di sistem.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="grid gap-x-8 gap-y-6 px-5 py-6 sm:grid-cols-2 sm:px-6 lg:grid-cols-3">

                            {{-- Payment ID --}}
                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Payment ID
                                </p>

                                <p class="mt-1.5 text-sm font-bold text-slate-800 dark:text-slate-100">
                                    #{{ $payment->id }}
                                </p>

                            </div>


                            {{-- Transaction ID --}}
                            <div class="sm:col-span-2 lg:col-span-2">

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Transaction ID
                                </p>

                                <p class="mt-1.5 break-all text-sm font-semibold text-slate-800 dark:text-slate-100">
                                    {{ $payment->transaction_id ?: '-' }}
                                </p>

                            </div>


                            {{-- Order --}}
                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Order
                                </p>

                                @if($order)

                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="mt-1.5 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 transition hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-200"
                                    >
                                        #{{ $order->order_number }}
                                        <i class="bi bi-arrow-up-right text-xs"></i>
                                    </a>

                                @else

                                    <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                                        Order tidak tersedia
                                    </p>

                                @endif

                            </div>


                            {{-- Payment Type --}}
                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Payment Type
                                </p>

                                <p class="mt-1.5 text-sm font-medium capitalize text-slate-700 dark:text-slate-200">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_type ?? '-')) }}
                                </p>

                            </div>


                            {{-- Status --}}
                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Status
                                </p>

                                <span class="mt-1.5 inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $paymentStatus['class'] }}">
                                    <i class="bi {{ $paymentStatus['icon'] }}"></i>
                                    {{ $paymentStatus['label'] }}
                                </span>

                            </div>


                            {{-- Paid At --}}
                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Dibayar Pada
                                </p>

                                <p class="mt-1.5 text-sm font-medium text-slate-700 dark:text-slate-200">
                                    {{ $payment->paid_at?->format('d M Y, H:i') ?? '-' }}
                                </p>

                            </div>


                            {{-- Created --}}
                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Dibuat
                                </p>

                                <p class="mt-1.5 text-sm font-medium text-slate-700 dark:text-slate-200">
                                    {{ $payment->created_at?->format('d M Y, H:i') ?? '-' }}
                                </p>

                            </div>


                            {{-- Updated --}}
                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Diperbarui
                                </p>

                                <p class="mt-1.5 text-sm font-medium text-slate-700 dark:text-slate-200">
                                    {{ $payment->updated_at?->format('d M Y, H:i') ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        ORDER
                    ================================================== --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex flex-col gap-4 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-slate-800">

                            <div class="flex items-start gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                    <i class="bi bi-bag-check text-lg"></i>
                                </div>

                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                        Pesanan
                                    </p>

                                    <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                        Pesanan Terkait
                                    </h2>

                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        Informasi order yang menggunakan pembayaran ini.
                                    </p>

                                </div>

                            </div>


                            @if($order)

                                <a
                                    href="{{ route('admin.orders.show', $order) }}"
                                    class="inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 text-xs font-semibold text-blue-700 transition hover:bg-blue-100 sm:w-auto dark:border-blue-800 dark:bg-blue-950/30 dark:text-blue-300 dark:hover:bg-blue-950/50"
                                >
                                    Detail Order
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>

                            @endif

                        </div>


                        @if($order)

                            <div class="p-5 sm:p-6">

                                <div class="grid gap-3 sm:grid-cols-2">

                                    {{-- Order Number --}}
                                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">

                                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                            Nomor Order
                                        </p>

                                        <p class="mt-2 text-sm font-bold text-slate-800 dark:text-slate-100">
                                            #{{ $order->order_number }}
                                        </p>

                                    </div>


                                    {{-- Order Status --}}
                                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">

                                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                            Status Order
                                        </p>

                                        <p class="mt-2 text-sm font-semibold capitalize text-slate-700 dark:text-slate-200">
                                            {{ ucfirst(str_replace('_', ' ', $order->status ?? '-')) }}
                                        </p>

                                    </div>


                                    {{-- Subtotal --}}
                                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">

                                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                            Subtotal
                                        </p>

                                        <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-slate-100">
                                            Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}
                                        </p>

                                    </div>


                                    {{-- Platform Fee --}}
                                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">

                                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                            Platform Fee
                                        </p>

                                        <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-slate-100">
                                            Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Total --}}
                                <div class="mt-3 rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900 dark:bg-blue-950/30">

                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                        <div>

                                            <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-300">
                                                Total Order
                                            </p>

                                            <p class="mt-1 text-xs text-blue-600/70 dark:text-blue-300/70">
                                                Nilai total transaksi order
                                            </p>

                                        </div>

                                        <p class="text-xl font-bold text-slate-900 dark:text-white">
                                            Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Freelancer Amount --}}
                                <div class="mt-3 rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">

                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                        <div>

                                            <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                                Freelancer Amount
                                            </p>

                                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                                Nilai yang dialokasikan untuk freelancer
                                            </p>

                                        </div>

                                        <p class="text-sm font-bold text-slate-900 dark:text-white">
                                            Rp {{ number_format((float) $order->freelancer_amount, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @else

                            <div class="p-5 sm:p-6">

                                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-800 dark:bg-amber-950/30">

                                    <div class="flex items-start gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm dark:bg-slate-900 dark:text-amber-300">
                                            <i class="bi bi-exclamation-circle"></i>
                                        </div>

                                        <div>

                                            <p class="text-sm font-semibold text-amber-800 dark:text-amber-200">
                                                Order tidak ditemukan
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-amber-700 dark:text-amber-300">
                                                Order yang terhubung dengan pembayaran ini tidak tersedia.
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </section>


                    {{-- =================================================
                        PROFILES
                    ================================================== --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 dark:border-slate-800 dark:bg-slate-900">

                        <div class="mb-5">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                Pihak Transaksi
                            </p>

                            <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                Client & Freelancer
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                Pengguna yang terlibat dalam transaksi pembayaran ini.
                            </p>

                        </div>


                        <div class="grid gap-4 md:grid-cols-2">

                            {{-- Client --}}
                            <div class="rounded-2xl border border-blue-100 bg-blue-50/50 p-4 dark:border-blue-900 dark:bg-blue-950/20">

                                <div class="flex items-center gap-3">

                                    @if($clientAvatar)

                                        <img
                                            src="{{ asset('storage/' . $clientAvatar) }}"
                                            alt="{{ $client?->name ?? 'Client' }}"
                                            class="h-14 w-14 shrink-0 rounded-full object-cover shadow-sm ring-4 ring-white dark:ring-slate-900"
                                        >

                                    @else

                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-blue-100 text-lg font-bold text-blue-700 ring-4 ring-white dark:bg-blue-950/60 dark:text-blue-300 dark:ring-slate-900">
                                            {{ $clientInitial }}
                                        </div>

                                    @endif


                                    <div class="min-w-0">

                                        <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-[10px] font-semibold text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">
                                            Client
                                        </span>

                                        <p class="mt-1 truncate text-sm font-bold text-slate-900 dark:text-white">
                                            {{ $client?->name ?? 'Client tidak tersedia' }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                            {{ $client?->email ?? '-' }}
                                        </p>

                                    </div>

                                </div>


                                @if($clientProfile?->username)

                                    <div class="mt-4 rounded-xl border border-blue-100 bg-white px-4 py-3 dark:border-blue-900 dark:bg-slate-900">

                                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                            Username
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700 dark:text-slate-200">
                                            {{ '@' . $clientProfile->username }}
                                        </p>

                                    </div>

                                @endif

                            </div>


                            {{-- Freelancer --}}
                            <div class="rounded-2xl border border-violet-100 bg-violet-50/50 p-4 dark:border-violet-900 dark:bg-violet-950/20">

                                <div class="flex items-center gap-3">

                                    @if($freelancerAvatar)

                                        <img
                                            src="{{ asset('storage/' . $freelancerAvatar) }}"
                                            alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                            class="h-14 w-14 shrink-0 rounded-full object-cover shadow-sm ring-4 ring-white dark:ring-slate-900"
                                        >

                                    @else

                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-violet-100 text-lg font-bold text-violet-700 ring-4 ring-white dark:bg-violet-950/60 dark:text-violet-300 dark:ring-slate-900">
                                            {{ $freelancerInitial }}
                                        </div>

                                    @endif


                                    <div class="min-w-0">

                                        <span class="inline-flex rounded-full bg-violet-100 px-2 py-1 text-[10px] font-semibold text-violet-700 dark:bg-violet-900/50 dark:text-violet-300">
                                            Freelancer
                                        </span>

                                        <p class="mt-1 truncate text-sm font-bold text-slate-900 dark:text-white">
                                            {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                            {{ $freelancerUser?->email ?? '-' }}
                                        </p>

                                    </div>

                                </div>


                                @if($freelancer?->username)

                                    <div class="mt-4 rounded-xl border border-violet-100 bg-white px-4 py-3 dark:border-violet-900 dark:bg-slate-900">

                                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                            Username
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-slate-700 dark:text-slate-200">
                                            {{ '@' . $freelancer->username }}
                                        </p>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        GATEWAY
                    ================================================== --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <div class="border-b border-slate-100 px-5 py-5 sm:px-6 dark:border-slate-800">

                            <div class="flex items-start gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                    <i class="bi bi-hdd-network text-lg"></i>
                                </div>

                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                        Payment Gateway
                                    </p>

                                    <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                        Informasi Gateway
                                    </h2>

                                    <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                        Ringkasan data yang diterima dari sistem pembayaran.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="p-5 sm:p-6">

                            @if(!empty($gatewayResponse))

                                <div class="grid gap-3 sm:grid-cols-2">

                                    {{-- Mode --}}
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                                                <i class="bi bi-code-slash"></i>
                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                                    Mode
                                                </p>

                                                <p class="mt-1 text-sm font-bold text-slate-800 dark:text-slate-100">
                                                    {{ $gatewayModeLabel ?? '-' }}
                                                </p>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- Gateway Status --}}
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                                                <i class="bi bi-activity"></i>
                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                                    Gateway Status
                                                </p>

                                                @if($gatewayStatusInfo)

                                                    <span class="mt-1 inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-xs font-semibold {{ $gatewayStatusInfo['class'] }}">

                                                        <i class="bi {{ $gatewayStatusInfo['icon'] }}"></i>

                                                        {{ $gatewayStatusInfo['label'] }}

                                                    </span>

                                                @elseif($gatewayStatus)

                                                    <p class="mt-1 text-sm font-bold capitalize text-slate-800 dark:text-slate-100">
                                                        {{ ucfirst(str_replace('_', ' ', $gatewayStatus)) }}
                                                    </p>

                                                @else

                                                    <p class="mt-1 text-sm text-slate-400">
                                                        -

                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    </div>


                                    {{-- Gateway Transaction ID --}}
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:col-span-2 dark:border-slate-800 dark:bg-slate-800/60">

                                        <div class="flex items-start gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                                                <i class="bi bi-receipt"></i>
                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                                    Gateway Transaction ID
                                                </p>

                                                <p class="mt-1 break-all text-sm font-semibold text-slate-800 dark:text-slate-100">
                                                    {{ $gatewayTransactionId ?: '-' }}
                                                </p>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- Gateway Message --}}
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:col-span-2 dark:border-slate-800 dark:bg-slate-800/60">

                                        <div class="flex items-start gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                                                <i class="bi bi-chat-left-text"></i>
                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                                    Pesan Gateway
                                                </p>

                                                <p class="mt-1 text-sm leading-6 text-slate-700 dark:text-slate-200">
                                                    {{ $gatewayMessage ?: 'Tidak ada pesan dari gateway.' }}
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Gateway Notice --}}
                                @if($gatewayMode === 'development')

                                    <div class="mt-4 flex items-start gap-3 rounded-2xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-900 dark:bg-blue-950/30">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                                            <i class="bi bi-info-circle"></i>
                                        </div>

                                        <div>

                                            <p class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                                                Mode Development
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-blue-700 dark:text-blue-300">
                                                Transaksi ini menggunakan data pembayaran dari environment development/simulasi.
                                            </p>

                                        </div>

                                    </div>

                                @endif

                            @else

                                {{-- Empty Gateway --}}
                                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-5 py-10 text-center dark:border-slate-700 dark:bg-slate-800/50">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm dark:bg-slate-900 dark:text-slate-500">
                                        <i class="bi bi-hdd-network text-xl"></i>
                                    </div>

                                    <p class="mt-3 text-sm font-semibold text-slate-700 dark:text-slate-200">
                                        Belum ada data gateway
                                    </p>

                                    <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-slate-400 dark:text-slate-500">
                                        Respons dari payment gateway belum tersimpan pada transaksi ini.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </section>

                </div>


                {{-- =====================================================
                    RIGHT COLUMN
                ====================================================== --}}
                <aside class="space-y-6">


                    {{-- Payment Status --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex items-start gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                <i class="bi bi-shield-check text-lg"></i>
                            </div>

                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                    Monitoring
                                </p>

                                <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                    Status Pembayaran
                                </h2>

                                <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                    Kondisi transaksi saat ini.
                                </p>

                            </div>

                        </div>


                        <div class="mt-5 rounded-2xl border p-4 {{ $paymentStatus['class'] }}">

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/80 dark:bg-slate-900/60">
                                    <i class="bi {{ $paymentStatus['icon'] }}"></i>
                                </div>

                                <div class="min-w-0">

                                    <p class="text-sm font-bold">
                                        {{ $paymentStatus['label'] }}
                                    </p>

                                    <p class="mt-1 text-xs leading-5 opacity-90">
                                        {{ $paymentStatus['description'] }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="mt-4 rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">

                            <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                Nominal Transaksi
                            </p>

                            <p class="mt-1.5 text-2xl font-bold text-slate-900 dark:text-white">
                                Rp {{ number_format((float) $payment->gross_amount, 0, ',', '.') }}
                            </p>

                        </div>

                    </section>


                    {{-- Transaction Relations --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex items-start gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                <i class="bi bi-diagram-3 text-lg"></i>
                            </div>

                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                    Relasi
                                </p>

                                <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                    Relasi Transaksi
                                </h2>

                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    Koneksi pembayaran dengan order dan pengguna.
                                </p>

                            </div>

                        </div>


                        <div class="mt-5 space-y-3">

                            {{-- Order --}}
                            @if($order)

                                <a
                                    href="{{ route('admin.orders.show', $order) }}"
                                    class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 transition hover:border-blue-200 hover:bg-blue-50 dark:border-slate-800 dark:bg-slate-800/60 dark:hover:border-blue-800 dark:hover:bg-blue-950/30"
                                >

                                    <div class="min-w-0">

                                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                            Order
                                        </p>

                                        <p class="mt-1 truncate text-sm font-bold text-slate-800 dark:text-slate-100">
                                            #{{ $order->order_number }}
                                        </p>

                                    </div>

                                    <i class="bi bi-chevron-right shrink-0 text-slate-400"></i>

                                </a>

                            @endif


                            {{-- Client --}}
                            @if($client)

                                <div class="rounded-2xl border border-blue-100 bg-blue-50/50 p-4 dark:border-blue-900 dark:bg-blue-950/20">

                                    <div class="flex items-center gap-3">

                                        @if($clientAvatar)

                                            <img
                                                src="{{ asset('storage/' . $clientAvatar) }}"
                                                alt="{{ $client->name }}"
                                                class="h-10 w-10 shrink-0 rounded-full object-cover ring-2 ring-white dark:ring-slate-900"
                                            >

                                        @else

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700 dark:bg-blue-950/60 dark:text-blue-300">
                                                {{ $clientInitial }}
                                            </div>

                                        @endif


                                        <div class="min-w-0">

                                            <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-300">
                                                Client
                                            </p>

                                            <p class="truncate text-sm font-bold text-slate-800 dark:text-slate-100">
                                                {{ $client->name }}
                                            </p>

                                            @if($clientProfile?->username)

                                                <p class="mt-0.5 truncate text-[11px] text-slate-500 dark:text-slate-400">
                                                    {{ '@' . $clientProfile->username }}
                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endif


                            {{-- Freelancer --}}
                            @if($freelancerUser)

                                <div class="rounded-2xl border border-violet-100 bg-violet-50/50 p-4 dark:border-violet-900 dark:bg-violet-950/20">

                                    <div class="flex items-center gap-3">

                                        @if($freelancerAvatar)

                                            <img
                                                src="{{ asset('storage/' . $freelancerAvatar) }}"
                                                alt="{{ $freelancerUser->name }}"
                                                class="h-10 w-10 shrink-0 rounded-full object-cover ring-2 ring-white dark:ring-slate-900"
                                            >

                                        @else

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-violet-100 text-xs font-bold text-violet-700 dark:bg-violet-950/60 dark:text-violet-300">
                                                {{ $freelancerInitial }}
                                            </div>

                                        @endif


                                        <div class="min-w-0">

                                            <p class="text-[10px] font-semibold uppercase tracking-wide text-violet-600 dark:text-violet-300">
                                                Freelancer
                                            </p>

                                            <p class="truncate text-sm font-bold text-slate-800 dark:text-slate-100">
                                                {{ $freelancerUser->name }}
                                            </p>

                                            @if($freelancer?->username)

                                                <p class="mt-0.5 truncate text-[11px] text-slate-500 dark:text-slate-400">
                                                    {{ '@' . $freelancer->username }}
                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endif

                        </div>

                    </section>


                    {{-- Timeline --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex items-start gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                <i class="bi bi-clock-history text-lg"></i>
                            </div>

                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                    Aktivitas
                                </p>

                                <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                    Timeline Pembayaran
                                </h2>

                            </div>

                        </div>


                        <div class="mt-5">

                            {{-- Created --}}
                            <div class="relative flex gap-3 pb-5">

                                <div class="relative flex w-8 shrink-0 justify-center">

                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                        <i class="bi bi-plus-circle"></i>
                                    </div>

                                    <div class="absolute left-1/2 top-8 h-full w-px -translate-x-1/2 bg-slate-200 dark:bg-slate-700"></div>

                                </div>


                                <div class="pt-1">

                                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-100">
                                        Pembayaran dibuat
                                    </p>

                                    <p class="mt-1 text-[11px] text-slate-400">
                                        {{ $payment->created_at?->format('d M Y, H:i') ?? '-' }}
                                    </p>

                                </div>

                            </div>


                            {{-- Paid --}}
                            <div class="relative flex gap-3">

                                <div class="flex w-8 shrink-0 justify-center">

                                    <div class="flex h-8 w-8 items-center justify-center
                                        @if($payment->paid_at)
                                            bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-300
                                        @else
                                            bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500
                                        @endif
                                    ">

                                        <i class="bi bi-check-circle"></i>

                                    </div>

                                </div>


                                <div class="pt-1">

                                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-100">
                                        Pembayaran berhasil
                                    </p>

                                    <p class="mt-1 text-[11px] text-slate-400">
                                        {{ $payment->paid_at?->format('d M Y, H:i') ?? 'Belum dibayar' }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- System Note --}}
                    <section class="rounded-3xl border border-blue-100 bg-blue-50/70 p-5 sm:p-6 dark:border-blue-900 dark:bg-blue-950/20">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>

                            <div>

                                <p class="text-sm font-bold text-slate-900 dark:text-white">
                                    Catatan Sistem
                                </p>

                                <p class="mt-1.5 text-xs leading-6 text-slate-600 dark:text-slate-300">
                                    Status pembayaran sebaiknya diperbarui melalui proses pembayaran dan webhook payment gateway, bukan secara manual dari halaman admin.
                                </p>

                            </div>

                        </div>

                    </section>

                </aside>

            </div>

        </div>

    </div>

</x-layouts.admin>
