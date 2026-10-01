
<x-layouts.admin title="Detail Komisi">

    @php
        /*
        |--------------------------------------------------------------------------
        | Status Komisi
        |--------------------------------------------------------------------------
        */
        $statusMap = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/30 dark:text-amber-300 dark:border-amber-800',
                'icon' => 'bi-hourglass-split',
                'description' => 'Komisi tercatat tetapi masih menunggu proses lanjutan.',
            ],

            'earned' => [
                'label' => 'Diperoleh',
                'class' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/30 dark:text-blue-300 dark:border-blue-800',
                'icon' => 'bi-graph-up-arrow',
                'description' => 'Komisi telah tercatat sebagai pendapatan platform.',
            ],

            'paid' => [
                'label' => 'Sudah Dibayarkan',
                'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-300 dark:border-emerald-800',
                'icon' => 'bi-check-circle-fill',
                'description' => 'Komisi telah diproses sebagai pembayaran.',
            ],

            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-950/30 dark:text-red-300 dark:border-red-800',
                'icon' => 'bi-x-circle-fill',
                'description' => 'Komisi dibatalkan dan tidak menjadi pendapatan aktif.',
            ],
        ];

        $commissionStatus = $statusMap[$commission->status] ?? [
            'label' => ucfirst(
                str_replace(
                    '_',
                    ' ',
                    $commission->status ?? 'Unknown'
                )
            ),
            'class' => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
            'icon' => 'bi-question-circle',
            'description' => 'Status komisi tercatat di sistem.',
        ];

        /*
        |--------------------------------------------------------------------------
        | Relations
        |--------------------------------------------------------------------------
        */
        $order = $commission->order;

        $client = $order?->client;
        $clientProfile = $client?->profile;
        $clientAvatar = $clientProfile?->avatar;

        $freelancer = $commission->freelancerProfile;
        $freelancerUser = $freelancer?->user;
        $freelancerAvatar = $freelancer?->avatar;

        $payment = $order?->payment;

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
                        href="{{ route('admin.commissions.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm font-medium text-slate-500 transition hover:bg-blue-50 hover:text-blue-600 dark:text-slate-400 dark:hover:bg-blue-950/40 dark:hover:text-blue-300"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke komisi
                    </a>
                </div>


                {{-- Main Header --}}
                <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-blue-700 ring-1 ring-inset ring-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:ring-blue-800">
                                <i class="bi bi-wallet2"></i>
                                Detail Komisi
                            </span>

                            <span class="text-xs text-slate-400 dark:text-slate-500">
                                Commission #{{ $commission->id }}
                            </span>

                        </div>


                        <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                            Komisi #{{ $commission->id }}
                        </h1>


                        <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                            Pencatatan pendapatan platform dari satu transaksi marketplace.
                        </p>

                    </div>


                    {{-- Commission Amount --}}
                    <div class="grid gap-3 sm:grid-cols-2 xl:min-w-[430px]">

                        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 shadow-sm dark:border-blue-900 dark:bg-blue-950/30">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-blue-600 dark:text-blue-300">
                                Komisi Platform
                            </p>

                            <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                                Rp {{ number_format((float) $commission->commission_amount, 0, ',', '.') }}
                            </p>

                        </div>


                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-400">
                                Status
                            </p>

                            <span class="mt-2 inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $commissionStatus['class'] }}">
                                <i class="bi {{ $commissionStatus['icon'] }}"></i>
                                {{ $commissionStatus['label'] }}
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


                    {{-- Commission Summary --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <div class="border-b border-slate-100 px-5 py-5 sm:px-6 dark:border-slate-800">

                            <div class="flex items-start gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                    <i class="bi bi-bar-chart-line-fill text-lg"></i>
                                </div>

                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                        Keuangan
                                    </p>

                                    <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                        Rincian Komisi
                                    </h2>

                                    <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                        Pembagian nilai transaksi antara platform dan freelancer.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="p-5 sm:p-6">

                            <div class="space-y-4">

                                {{-- Order Total --}}
                                <div class="flex flex-col gap-1 rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60 sm:flex-row sm:items-center sm:justify-between">

                                    <div>
                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                            Total Order
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-400">
                                            Nilai transaksi yang menjadi dasar komisi
                                        </p>
                                    </div>

                                    <p class="text-base font-bold text-slate-900 dark:text-white">
                                        Rp {{ number_format((float) $commission->order_total, 0, ',', '.') }}
                                    </p>

                                </div>


                                {{-- Rate --}}
                                <div class="flex flex-col gap-1 rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60 sm:flex-row sm:items-center sm:justify-between">

                                    <div>
                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                            Persentase Komisi
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-400">
                                            Persentase yang dicatat sebagai komisi platform
                                        </p>
                                    </div>

                                    <span class="inline-flex w-fit rounded-full bg-blue-50 px-3 py-1.5 text-sm font-bold text-blue-700 dark:bg-blue-950/40 dark:text-blue-300">
                                        {{ number_format((float) $commission->commission_rate, 2, ',', '.') }}%
                                    </span>

                                </div>


                                {{-- Platform --}}
                                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900 dark:bg-blue-950/30">

                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                        <div>
                                            <p class="text-sm font-bold text-slate-900 dark:text-white">
                                                Komisi Platform
                                            </p>

                                            <p class="mt-0.5 text-xs text-blue-600/70 dark:text-blue-300/70">
                                                Pendapatan platform dari transaksi
                                            </p>
                                        </div>

                                        <p class="text-xl font-bold text-blue-700 dark:text-blue-300">
                                            Rp {{ number_format((float) $commission->commission_amount, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Freelancer --}}
                                <div class="rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">

                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                        <div>
                                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                                Pendapatan Freelancer
                                            </p>

                                            <p class="mt-0.5 text-xs text-slate-400">
                                                Bagian transaksi untuk freelancer
                                            </p>
                                        </div>

                                        <p class="text-lg font-bold text-slate-900 dark:text-white">
                                            Rp {{ number_format((float) $commission->freelancer_amount, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- Order --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex flex-col gap-4 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-slate-800">

                            <div class="flex items-start gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                    <i class="bi bi-receipt-cutoff text-lg"></i>
                                </div>

                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                        Pesanan
                                    </p>

                                    <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                        Pesanan Terkait
                                    </h2>

                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        Transaksi yang menghasilkan komisi ini.
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
                                            Platform Fee Order
                                        </p>

                                        <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-slate-100">
                                            Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Total --}}
                                <div class="mt-3 rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900 dark:bg-blue-950/30">

                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                        <div>
                                            <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-300">
                                                Total Order
                                            </p>

                                            <p class="mt-1 text-xs text-blue-600/70 dark:text-blue-300/70">
                                                Nilai akhir transaksi
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
                                                Nilai yang diterima freelancer dari order
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
                                                Order yang menjadi sumber komisi ini tidak tersedia.
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </section>


                    {{-- Profiles --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 dark:border-slate-800 dark:bg-slate-900">

                        <div class="mb-5">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                Pihak Transaksi
                            </p>

                            <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                Client & Freelancer
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                Profil pengguna yang terlibat dalam transaksi ini.
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


                    {{-- Payment --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-start gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                    <i class="bi bi-credit-card text-lg"></i>
                                </div>

                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-300">
                                        Pembayaran
                                    </p>

                                    <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                        Pembayaran Terkait
                                    </h2>

                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        Informasi pembayaran dari order ini.
                                    </p>

                                </div>

                            </div>


                            @if($payment)

                                <a
                                    href="{{ route('admin.payments.show', $payment) }}"
                                    class="inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 text-xs font-semibold text-blue-700 transition hover:bg-blue-100 sm:w-auto dark:border-blue-800 dark:bg-blue-950/30 dark:text-blue-300"
                                >
                                    Detail Pembayaran
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>

                            @endif

                        </div>


                        @if($payment)

                            <div class="mt-5 grid gap-3 sm:grid-cols-2">

                                {{-- Transaction --}}
                                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Transaction ID
                                    </p>

                                    <p class="mt-2 break-all text-sm font-semibold text-slate-800 dark:text-slate-100">
                                        {{ $payment->transaction_id ?: '-' }}
                                    </p>

                                </div>


                                {{-- Type --}}
                                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Payment Type
                                    </p>

                                    <p class="mt-2 text-sm font-semibold capitalize text-slate-800 dark:text-slate-100">
                                        {{ ucfirst(str_replace('_', ' ', $payment->payment_type ?? '-')) }}
                                    </p>

                                </div>


                                {{-- Status --}}
                                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Status Pembayaran
                                    </p>

                                    <p class="mt-2 inline-flex rounded-full bg-blue-50 px-2.5 py-1.5 text-xs font-semibold capitalize text-blue-700 dark:bg-blue-950/40 dark:text-blue-300">
                                        {{ ucfirst(str_replace('_', ' ', $payment->status ?? '-')) }}
                                    </p>

                                </div>


                                {{-- Paid At --}}
                                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/60">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Dibayar Pada
                                    </p>

                                    <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-slate-100">
                                        {{ $payment->paid_at?->format('d M Y, H:i') ?? '-' }}
                                    </p>

                                </div>

                            </div>

                        @else

                            <div class="mt-5 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-5 py-8 text-center dark:border-slate-700 dark:bg-slate-800/50">

                                <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm dark:bg-slate-900 dark:text-slate-500">
                                    <i class="bi bi-credit-card"></i>
                                </div>

                                <p class="mt-3 text-sm font-semibold text-slate-700 dark:text-slate-200">
                                    Pembayaran belum tersedia
                                </p>

                                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                                    Belum ada pembayaran yang terhubung dengan order ini.
                                </p>

                            </div>

                        @endif

                    </section>

                </div>


                {{-- =====================================================
                    RIGHT COLUMN
                ====================================================== --}}
                <aside class="space-y-6">


                    {{-- Status --}}
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
                                    Status Komisi
                                </h2>

                                <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                    Kondisi pencatatan komisi saat ini.
                                </p>

                            </div>

                        </div>


                        <div class="mt-5 rounded-2xl border p-4 {{ $commissionStatus['class'] }}">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/80 dark:bg-slate-900/60">
                                    <i class="bi {{ $commissionStatus['icon'] }}"></i>
                                </div>

                                <div class="min-w-0">

                                    <p class="text-sm font-bold">
                                        {{ $commissionStatus['label'] }}
                                    </p>

                                    <p class="mt-1 text-xs leading-5 opacity-90">
                                        {{ $commissionStatus['description'] }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="mt-4 rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900 dark:bg-blue-950/30">

                            <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-300">
                                Nilai Komisi
                            </p>

                            <p class="mt-1.5 text-2xl font-bold text-slate-900 dark:text-white">
                                Rp {{ number_format((float) $commission->commission_amount, 0, ',', '.') }}
                            </p>

                            <p class="mt-1 text-xs text-blue-600/70 dark:text-blue-300/70">
                                {{ number_format((float) $commission->commission_rate, 2, ',', '.') }}% dari nilai order
                            </p>

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
                                    Riwayat Waktu
                                </h2>

                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    Perjalanan pencatatan komisi.
                                </p>

                            </div>

                        </div>


                        <div class="mt-6">

                            {{-- Created --}}
                            <div class="relative flex gap-3 pb-6">

                                <div class="relative flex w-8 shrink-0 justify-center">

                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
                                        <i class="bi bi-plus-circle"></i>
                                    </div>

                                    <div class="absolute left-1/2 top-8 h-full w-px -translate-x-1/2 bg-slate-200 dark:bg-slate-700"></div>

                                </div>

                                <div class="pt-1">

                                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-100">
                                        Komisi dibuat
                                    </p>

                                    <p class="mt-1 text-[11px] text-slate-400">
                                        {{ $commission->created_at?->format('d M Y, H:i') ?? '-' }}
                                    </p>

                                </div>

                            </div>


                            {{-- Earned --}}
                            <div class="relative flex gap-3 pb-6">

                                <div class="relative flex w-8 shrink-0 justify-center">

                                    <div class="flex h-8 w-8 items-center justify-center
                                        @if($commission->earned_at)
                                            bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300
                                        @else
                                            bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500
                                        @endif
                                    ">
                                        <i class="bi bi-graph-up-arrow"></i>
                                    </div>

                                    <div class="absolute left-1/2 top-8 h-full w-px -translate-x-1/2 bg-slate-200 dark:bg-slate-700"></div>

                                </div>

                                <div class="pt-1">

                                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-100">
                                        Komisi diperoleh
                                    </p>

                                    <p class="mt-1 text-[11px] text-slate-400">
                                        {{ $commission->earned_at?->format('d M Y, H:i') ?? 'Belum diperoleh' }}
                                    </p>

                                </div>

                            </div>


                            {{-- Paid --}}
                            <div class="relative flex gap-3">

                                <div class="flex w-8 shrink-0 justify-center">

                                    <div class="flex h-8 w-8 items-center justify-center
                                        @if($commission->paid_at)
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
                                        Komisi dibayarkan
                                    </p>

                                    <p class="mt-1 text-[11px] text-slate-400">
                                        {{ $commission->paid_at?->format('d M Y, H:i') ?? 'Belum dibayarkan' }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- System Information --}}
                    <section class="rounded-3xl border border-blue-100 bg-blue-50/70 p-5 shadow-sm sm:p-6 dark:border-blue-900 dark:bg-blue-950/20">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>

                            <div>

                                <p class="text-sm font-bold text-slate-900 dark:text-white">
                                    Catatan Sistem
                                </p>

                                <p class="mt-1.5 text-xs leading-6 text-slate-600 dark:text-slate-300">
                                    Data komisi menjadi bagian dari pencatatan pendapatan platform dan pembagian hasil transaksi marketplace.
                                </p>

                            </div>

                        </div>

                    </section>


                    {{-- Technical Info --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                <i class="bi bi-database"></i>
                            </div>

                            <div>

                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">
                                    Sistem
                                </p>

                                <h2 class="mt-1 text-base font-bold text-slate-900 dark:text-white">
                                    Informasi Pencatatan
                                </h2>

                            </div>

                        </div>


                        <div class="mt-5 space-y-4">

                            <div class="flex items-start justify-between gap-4">

                                <span class="text-xs text-slate-400">
                                    Commission ID
                                </span>

                                <span class="text-right text-xs font-semibold text-slate-700 dark:text-slate-200">
                                    #{{ $commission->id }}
                                </span>

                            </div>


                            <div class="flex items-start justify-between gap-4">

                                <span class="text-xs text-slate-400">
                                    Dibuat
                                </span>

                                <span class="text-right text-xs font-semibold text-slate-700 dark:text-slate-200">
                                    {{ $commission->created_at?->format('d M Y, H:i') ?? '-' }}
                                </span>

                            </div>


                            <div class="flex items-start justify-between gap-4">

                                <span class="text-xs text-slate-400">
                                    Diperbarui
                                </span>

                                <span class="text-right text-xs font-semibold text-slate-700 dark:text-slate-200">
                                    {{ $commission->updated_at?->format('d M Y, H:i') ?? '-' }}
                                </span>

                            </div>

                        </div>

                    </section>

                </aside>

            </div>

        </div>

    </div>

</x-layouts.admin>

