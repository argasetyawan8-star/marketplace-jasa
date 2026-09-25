<x-layouts.marketplace title="Invoice & Detail Transaksi">

    @php
        $clientName = $order->client?->name ?? 'Client';

        $freelancerName =
            $order->freelancerProfile?->user?->name
            ?? 'Freelancer';

        $serviceTitle =
            $order->items->first()?->service_title
            ?? 'Pesanan Jasa';

        $transactionNumber =
            $order->payment?->transaction_id
            ?? 'Belum tersedia';

        $paymentMethod =
            $order->payment?->payment_type
            ?? 'Belum tersedia';

        $subtotal = (float) $order->subtotal;
        $platformFee = (float) $order->platform_fee;
        $total = (float) $order->total;

        $paymentStatusData = $paymentStatus ?? [
            'label' => 'Belum tersedia',
            'class' => 'border-slate-200 bg-slate-50 text-slate-600',
            'icon' => 'bi-circle'
        ];

        $orderStatusClass = match (strtolower((string) $orderStatus)) {
            'selesai', 'completed' =>
                'border-emerald-200 bg-emerald-50 text-emerald-700',

            'dibatalkan', 'cancelled' =>
                'border-red-200 bg-red-50 text-red-700',

            'sedang dikerjakan', 'in_progress' =>
                'border-blue-200 bg-blue-50 text-blue-700',

            'menunggu pembayaran', 'pending_payment' =>
                'border-amber-200 bg-amber-50 text-amber-700',

            default =>
                'border-slate-200 bg-slate-50 text-slate-600',
        };
    @endphp

    <div
        id="prokerjaa-invoice-page"
        class="min-h-screen bg-[#F5F8FC] py-6 sm:py-8"
    >

        {{-- =========================================================
             TOP NAV
        ========================================================== --}}
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="mb-5 flex items-center justify-between gap-3">

                <a
                    href="{{ url()->previous() }}"
                    class="group inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-[#2563EB] hover:text-[#2563EB]"
                >
                    <i class="bi bi-arrow-left text-base transition-transform group-hover:-translate-x-0.5"></i>
                    <span>Kembali</span>
                </a>

                <button
                    type="button"
                    onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#2563EB] px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-[#1D4ED8] active:scale-[.98]"
                >
                    <i class="bi bi-printer"></i>
                    <span class="hidden sm:inline">Cetak Invoice</span>
                    <span class="sm:hidden">Cetak</span>
                </button>

            </div>


            {{-- =====================================================
                 INVOICE CONTAINER
            ====================================================== --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_15px_45px_rgba(15,23,42,.06)]">

                {{-- =================================================
                     HEADER
                ================================================== --}}
                <div class="relative overflow-hidden border-b border-slate-100 px-5 py-6 sm:px-8 sm:py-8">

                    {{-- Decorative background --}}
                    <div class="pointer-events-none absolute -right-20 -top-24 h-64 w-64 rounded-full bg-blue-50"></div>
                    <div class="pointer-events-none absolute -right-10 top-16 h-32 w-32 rounded-full bg-blue-100/40"></div>

                    <div class="relative flex flex-col justify-between gap-6 sm:flex-row sm:items-start">

                        <div>

                            {{-- Logo / Brand --}}
                            <div class="mb-4 flex items-center gap-3">

                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#2563EB] text-white shadow-lg shadow-blue-200">
                                    <i class="bi bi-briefcase-fill text-xl"></i>
                                </div>

                                <div>
                                    <div class="text-xl font-extrabold tracking-tight text-slate-900">
                                        ProKerjaa
                                    </div>

                                    <div class="text-xs font-medium text-slate-500">
                                        Marketplace Jasa Profesional
                                    </div>
                                </div>

                            </div>

                            <div class="mt-5">

                                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                                    Invoice & Detail Transaksi
                                </h1>

                                <p class="mt-1.5 max-w-xl text-sm leading-6 text-slate-500">
                                    Detail pembayaran dan informasi pesanan Anda di ProKerjaa.
                                </p>

                            </div>

                        </div>


                        {{-- Invoice number --}}
                        <div class="relative sm:text-right">

                            <div class="text-[11px] font-bold uppercase tracking-[.16em] text-slate-400">
                                Nomor Invoice
                            </div>

                            <div class="mt-1 break-all text-sm font-bold text-slate-800 sm:text-base">
                                #{{ $order->id }}
                            </div>

                            <div class="mt-2 text-xs text-slate-500">
                                {{ $order->created_at?->format('d F Y, H:i') ?? '-' }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     STATUS
                ================================================== --}}
                <div class="border-b border-slate-100 bg-slate-50/70 px-5 py-5 sm:px-8">

                    <div class="grid gap-3 md:grid-cols-2">

                        {{-- Order status --}}
                        <div class="rounded-xl border bg-white p-4 {{ $orderStatusClass }}">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/80">
                                    <i class="bi bi-box-seam text-lg"></i>
                                </div>

                                <div class="min-w-0">
                                    <div class="text-[11px] font-bold uppercase tracking-wider opacity-70">
                                        Status Pesanan
                                    </div>

                                    <div class="mt-0.5 truncate text-sm font-bold">
                                        {{ $orderStatus ?: 'Belum tersedia' }}
                                    </div>
                                </div>

                            </div>

                        </div>


                        {{-- Payment status --}}
                        <div class="rounded-xl border bg-white p-4 {{ $paymentStatusData['class'] }}">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/80">
                                    <i class="bi {{ $paymentStatusData['icon'] }} text-lg"></i>
                                </div>

                                <div class="min-w-0">
                                    <div class="text-[11px] font-bold uppercase tracking-wider opacity-70">
                                        Status Pembayaran
                                    </div>

                                    <div class="mt-0.5 truncate text-sm font-bold">
                                        {{ $paymentStatusData['label'] }}
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     CLIENT / FREELANCER
                ================================================== --}}
                <div class="border-b border-slate-100 px-5 py-6 sm:px-8">

                    <div class="grid gap-4 md:grid-cols-2">

                        {{-- Client --}}
                        <div class="rounded-xl border border-slate-200 bg-white p-4">

                            <div class="mb-3 flex items-center gap-2">

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]">
                                    <i class="bi bi-person"></i>
                                </div>

                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                    Client
                                </span>

                            </div>

                            <div class="text-sm font-bold text-slate-900">
                                {{ $clientName }}
                            </div>

                            <div class="mt-1 text-xs text-slate-500">
                                Pemesan jasa
                            </div>

                        </div>


                        {{-- Freelancer --}}
                        <div class="rounded-xl border border-slate-200 bg-white p-4">

                            <div class="mb-3 flex items-center gap-2">

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]">
                                    <i class="bi bi-person-workspace"></i>
                                </div>

                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                    Freelancer
                                </span>

                            </div>

                            <div class="text-sm font-bold text-slate-900">
                                {{ $freelancerName }}
                            </div>

                            <div class="mt-1 text-xs text-slate-500">
                                Penyedia jasa
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     ORDER INFORMATION
                ================================================== --}}
                <div class="border-b border-slate-100 px-5 py-6 sm:px-8">

                    <div class="mb-5">

                        <div class="flex items-center gap-2">

                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]">
                                <i class="bi bi-receipt"></i>
                            </div>

                            <div>
                                <h2 class="text-base font-bold text-slate-900">
                                    Detail Pesanan
                                </h2>

                                <p class="text-xs text-slate-500">
                                    Informasi jasa yang dipesan
                                </p>
                            </div>

                        </div>

                    </div>


                    {{-- Service --}}
                    <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">
                                <i class="bi bi-briefcase text-lg"></i>
                            </div>

                            <div class="min-w-0">

                                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                    Jasa
                                </div>

                                <div class="mt-1 text-sm font-bold leading-5 text-slate-900 sm:text-base">
                                    {{ $serviceTitle }}
                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Additional information --}}
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">

                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                Order ID
                            </div>

                            <div class="mt-1 text-sm font-bold text-slate-800">
                                #{{ $order->id }}
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                Transaksi
                            </div>

                            <div class="mt-1 break-all text-sm font-bold text-slate-800">
                                {{ $transactionNumber }}
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                Metode Pembayaran
                            </div>

                            <div class="mt-1 text-sm font-bold text-slate-800">
                                {{ $paymentMethod }}
                            </div>
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     ITEM TABLE
                ================================================== --}}
                <div class="border-b border-slate-100 px-5 py-6 sm:px-8">

                    <div class="mb-4">

                        <h2 class="text-base font-bold text-slate-900">
                            Rincian Tagihan
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Rincian biaya dari pesanan ini
                        </p>

                    </div>


                    <div class="overflow-hidden rounded-xl border border-slate-200">

                        {{-- Desktop header --}}
                        <div class="hidden grid-cols-[1fr_auto] gap-4 border-b border-slate-200 bg-slate-50 px-4 py-3 sm:grid">

                            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                Item
                            </div>

                            <div class="text-right text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                Harga
                            </div>

                        </div>


                        {{-- Items --}}
                        <div class="divide-y divide-slate-100">

                            @forelse($order->items as $item)

                                <div class="grid gap-2 px-4 py-4 sm:grid-cols-[1fr_auto] sm:items-center sm:gap-4">

                                    <div class="min-w-0">

                                        <div class="text-sm font-semibold text-slate-800">
                                            {{ $item->service_title ?? 'Item Jasa' }}
                                        </div>

                                        @if(!empty($item->description))
                                            <div class="mt-1 text-xs leading-5 text-slate-500">
                                                {{ $item->description }}
                                            </div>
                                        @endif

                                    </div>

                                    <div class="text-sm font-bold text-slate-900 sm:text-right">
                                        Rp {{ number_format((float) ($item->price ?? 0), 0, ',', '.') }}
                                    </div>

                                </div>

                            @empty

                                <div class="px-4 py-8 text-center text-sm text-slate-500">
                                    Tidak ada rincian item.
                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     PAYMENT + SUMMARY
                ================================================== --}}
                <div class="border-b border-slate-100 px-5 py-6 sm:px-8">

                    <div class="grid gap-6 lg:grid-cols-[1fr_360px]">

                        {{-- Payment information --}}
                        <div>

                            <div class="mb-4">

                                <h2 class="text-base font-bold text-slate-900">
                                    Informasi Pembayaran
                                </h2>

                                <p class="mt-1 text-xs text-slate-500">
                                    Informasi transaksi pembayaran Anda
                                </p>

                            </div>


                            <div class="space-y-3 rounded-xl border border-slate-200 p-4">

                                <div class="flex items-start justify-between gap-4">

                                    <span class="text-sm text-slate-500">
                                        ID Transaksi
                                    </span>

                                    <span class="max-w-[60%] break-all text-right text-sm font-semibold text-slate-800">
                                        {{ $transactionNumber }}
                                    </span>

                                </div>

                                <div class="h-px bg-slate-100"></div>

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-sm text-slate-500">
                                        Metode Pembayaran
                                    </span>

                                    <span class="text-right text-sm font-semibold text-slate-800">
                                        {{ $paymentMethod }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- Summary --}}
                        <div class="rounded-2xl bg-[#0F172A] p-5 text-white shadow-xl shadow-slate-200">

                            <div class="mb-4 flex items-center justify-between">

                                <div>
                                    <div class="text-sm font-bold">
                                        Ringkasan Pembayaran
                                    </div>

                                    <div class="mt-0.5 text-[11px] text-slate-400">
                                        Total transaksi
                                    </div>
                                </div>

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                                    <i class="bi bi-wallet2"></i>
                                </div>

                            </div>


                            <div class="space-y-3 text-sm">

                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-slate-400">
                                        Subtotal
                                    </span>

                                    <span class="font-semibold">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-slate-400">
                                        Biaya platform
                                    </span>

                                    <span class="font-semibold">
                                        Rp {{ number_format($platformFee, 0, ',', '.') }}
                                    </span>
                                </div>

                            </div>


                            <div class="my-5 h-px bg-white/10"></div>


                            <div class="flex items-end justify-between gap-4">

                                <div>
                                    <div class="text-xs font-medium text-slate-400">
                                        Total Pembayaran
                                    </div>

                                    <div class="mt-1 text-2xl font-extrabold tracking-tight">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div class="mb-1 rounded-lg bg-blue-500/15 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-blue-300">
                                    IDR
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     REQUIREMENTS / BRIEF
                ================================================== --}}
                @if(!empty($order->requirements) || !empty($order->brief))

                    <div class="border-b border-slate-100 px-5 py-6 sm:px-8">

                        <div class="mb-4 flex items-center gap-2">

                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>

                            <div>
                                <h2 class="text-base font-bold text-slate-900">
                                    Brief & Requirements
                                </h2>

                                <p class="text-xs text-slate-500">
                                    Informasi kebutuhan dari client
                                </p>
                            </div>

                        </div>


                        <div class="rounded-xl border border-blue-100 bg-blue-50/50 p-4">

                            <div class="whitespace-pre-line text-sm leading-6 text-slate-700">
                                {{ $order->requirements ?? $order->brief }}
                            </div>

                        </div>

                    </div>

                @endif


                {{-- =================================================
                     FOOTER
                ================================================== --}}
                <div class="bg-slate-50 px-5 py-6 sm:px-8">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <div class="flex items-center gap-2">

                                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#2563EB] text-white">
                                    <i class="bi bi-briefcase-fill text-xs"></i>
                                </div>

                                <span class="text-sm font-extrabold text-slate-900">
                                    ProKerjaa
                                </span>

                            </div>

                            <p class="mt-2 max-w-md text-xs leading-5 text-slate-500">
                                Platform untuk menghubungkan client dengan freelancer profesional untuk berbagai kebutuhan digital.
                            </p>

                        </div>


                        <div class="text-left sm:text-right">

                            <div class="text-xs font-semibold text-slate-600">
                                Terima kasih telah menggunakan ProKerjaa.
                            </div>

                            <div class="mt-1 text-[11px] text-slate-400">
                                Invoice ini dibuat secara otomatis oleh sistem.
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Bottom note --}}
            <div class="px-2 py-5 text-center">

                <p class="text-[11px] leading-5 text-slate-400">
                    Simpan invoice ini sebagai bukti transaksi Anda di ProKerjaa.
                </p>

            </div>

        </div>

    </div>


    {{-- =============================================================
         PRINT STYLE
    ============================================================= --}}
    <style>
        @media print {

            @page {
                size: A4;
                margin: 12mm;
            }

            body {
                background: #fff !important;
            }

            #prokerjaa-invoice-page {
                min-height: auto !important;
                padding: 0 !important;
                background: #fff !important;
            }

            #prokerjaa-invoice-page > div {
                max-width: none !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            #prokerjaa-invoice-page .shadow-\[0_15px_45px_rgba\(15\,23\,42\,\.06\)\] {
                box-shadow: none !important;
            }

            #prokerjaa-invoice-page button,
            #prokerjaa-invoice-page > div > div:first-child a,
            #prokerjaa-invoice-page > div > div:last-child {
                display: none !important;
            }

            #prokerjaa-invoice-page .rounded-2xl {
                border-radius: 0 !important;
            }

            #prokerjaa-invoice-page .rounded-xl {
                break-inside: avoid;
            }

            #prokerjaa-invoice-page .border-b {
                break-inside: avoid;
            }

        }

        @media (max-width: 640px) {

            #prokerjaa-invoice-page {
                padding-top: 1rem;
                padding-bottom: 1rem;
            }

            #prokerjaa-invoice-page h1 {
                line-height: 1.25;
            }

        }
    </style>

</x-layouts.marketplace>