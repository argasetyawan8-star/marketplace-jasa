<x-layouts.client title="Invoice & Detail Transaksi">

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
    @endphp

    <div class="min-h-screen bg-[#F8FCF9]">

        <div class="mx-auto max-w-5xl px-4 py-7 sm:px-6 lg:px-8 lg:py-10">

            {{-- TOP ACTION --}}
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between print:hidden">

                <a
                    href="{{ route('client.orders.show', $order) }}"
                    class="inline-flex w-fit items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
                >
                    <i class="bi bi-arrow-left text-[12px]"></i>
                    Kembali ke order
                </a>

                <button
                    type="button"
                    onclick="window.print()"
                    class="inline-flex w-fit items-center gap-2 rounded-xl border border-[#D8E5DD] bg-white px-4 py-2.5 text-xs font-semibold text-[#52685F] transition hover:border-[#BBD9C6] hover:bg-[#F4FAF6] hover:text-[#1E9E5A]"
                >
                    <i class="bi bi-printer"></i>
                    Cetak invoice
                </button>

            </div>

            {{-- INVOICE --}}
            <section class="overflow-hidden rounded-3xl border border-[#DCE8E1] bg-white shadow-[0_8px_30px_rgba(18,49,40,0.045)]">

                {{-- HEADER --}}
                <div class="border-b border-[#E5EDE8] px-5 py-6 sm:px-8 lg:px-10">

                    <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">

                        <div>

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                    <i class="bi bi-receipt-cutoff text-lg"></i>
                                </div>

                                <div>
                                    <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                        JASAIN
                                    </p>

                                    <h1 class="mt-0.5 text-lg font-semibold tracking-[-0.02em] text-[#123128]">
                                        Invoice
                                    </h1>
                                </div>

                            </div>

                            <p class="mt-4 text-xs leading-5 text-[#71837B]">
                                Dokumen ringkasan transaksi untuk pesanan jasa di JASAIN.
                            </p>

                        </div>

                        <div class="text-left sm:text-right">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#97A49E]">
                                Nomor Invoice
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128]">
                                {{ $invoiceNumber }}
                            </p>

                            <p class="mt-2 text-[10px] text-[#98A49E]">
                                Diterbitkan
                                {{ $order->created_at?->format('d M Y, H:i') }}
                            </p>

                        </div>

                    </div>

                </div>

                {{-- STATUS --}}
                <div class="px-5 pt-6 sm:px-8 lg:px-10">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                Status transaksi
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128]">
                                {{ $orderStatus }}
                            </p>

                        </div>

                        <span
                            class="inline-flex w-fit items-center gap-2 rounded-full border px-3 py-2 text-[10px] font-semibold {{ $paymentStatus['class'] }}"
                        >
                            <i class="bi {{ $paymentStatus['icon'] }}"></i>
                            {{ $paymentStatus['label'] }}
                        </span>

                    </div>

                </div>

                {{-- PARTIES --}}
                <div class="grid gap-5 px-5 py-6 sm:px-8 md:grid-cols-2 lg:px-10">

                    {{-- CLIENT --}}
                    <div class="rounded-2xl border border-[#E6EEE9] bg-[#FBFDFB] p-5">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#8F9D96]">
                            Client
                        </p>

                        <p class="mt-2 text-sm font-semibold text-[#18382E]">
                            {{ $clientName }}
                        </p>

                        <p class="mt-1 text-[10px] text-[#8D9A94]">
                            Pemesan jasa
                        </p>

                    </div>

                    {{-- FREELANCER --}}
                    <div class="rounded-2xl border border-[#E6EEE9] bg-[#FBFDFB] p-5">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#8F9D96]">
                            Freelancer
                        </p>

                        <p class="mt-2 text-sm font-semibold text-[#18382E]">
                            {{ $freelancerName }}
                        </p>

                        <p class="mt-1 text-[10px] text-[#8D9A94]">
                            Penyedia jasa
                        </p>

                    </div>

                </div>

                {{-- ORDER INFORMATION --}}
                <div class="border-t border-[#E5EDE8] px-5 py-6 sm:px-8 lg:px-10">

                    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                                Pesanan
                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                {{ $serviceTitle }}
                            </h2>

                        </div>

                        <div class="text-left sm:text-right">

                            <p class="text-[9px] text-[#98A49E]">
                                Nomor Order
                            </p>

                            <p class="mt-1 text-xs font-semibold text-[#355248]">
                                {{ $order->order_number }}
                            </p>

                        </div>

                    </div>

                    {{-- ITEMS --}}
                    <div class="mt-5 overflow-hidden rounded-2xl border border-[#E5EDE8]">

                        <div class="hidden grid-cols-[minmax(0,1fr)_100px_140px] gap-4 border-b border-[#E5EDE8] bg-[#F8FBF9] px-4 py-3 sm:grid">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.12em] text-[#87968F]">
                                Layanan
                            </p>

                            <p class="text-right text-[9px] font-semibold uppercase tracking-[0.12em] text-[#87968F]">
                                Qty
                            </p>

                            <p class="text-right text-[9px] font-semibold uppercase tracking-[0.12em] text-[#87968F]">
                                Subtotal
                            </p>

                        </div>

                        @foreach($order->items as $item)

                            <div class="grid grid-cols-1 gap-3 px-4 py-4 sm:grid-cols-[minmax(0,1fr)_100px_140px] sm:items-center sm:gap-4 {{ !$loop->last ? 'border-b border-[#EDF2EF]' : '' }}">

                                <div>

                                    <p class="text-xs font-semibold text-[#18382E]">
                                        {{ $item->service_title }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-[#8E9C96]">
                                        Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                                        / item
                                    </p>

                                </div>

                                <div class="flex items-center justify-between sm:block">

                                    <span class="text-[9px] text-[#98A49E] sm:hidden">
                                        Qty
                                    </span>

                                    <p class="text-xs font-medium text-[#52685F] sm:text-right">
                                        {{ $item->quantity }}
                                    </p>

                                </div>

                                <div class="flex items-center justify-between sm:block">

                                    <span class="text-[9px] text-[#98A49E] sm:hidden">
                                        Subtotal
                                    </span>

                                    <p class="text-xs font-semibold text-[#18382E] sm:text-right">
                                        Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                    </p>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

                {{-- PAYMENT DETAILS --}}
                <div class="border-t border-[#E5EDE8] px-5 py-6 sm:px-8 lg:px-10">

                    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_320px]">

                        {{-- TRANSACTION --}}
                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                                Detail transaksi
                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                Informasi pembayaran
                            </h2>

                            <div class="mt-5 space-y-4">

                                <div class="flex items-start justify-between gap-4">

                                    <span class="text-xs text-[#7B8B83]">
                                        Metode pembayaran
                                    </span>

                                    <span class="max-w-[60%] text-right text-xs font-semibold text-[#355248]">
                                        {{ ucfirst($paymentMethod) }}
                                    </span>

                                </div>

                                <div class="flex items-start justify-between gap-4">

                                    <span class="text-xs text-[#7B8B83]">
                                        Transaction ID
                                    </span>

                                    <span class="max-w-[60%] break-all text-right text-xs font-semibold text-[#355248]">
                                        {{ $transactionNumber }}
                                    </span>

                                </div>

                                <div class="flex items-start justify-between gap-4">

                                    <span class="text-xs text-[#7B8B83]">
                                        Waktu pembayaran
                                    </span>

                                    <span class="text-right text-xs font-semibold text-[#355248]">
                                        {{ $order->payment?->paid_at?->format('d M Y, H:i') ?? 'Belum dibayar' }}
                                    </span>

                                </div>

                                <div class="flex items-start justify-between gap-4">

                                    <span class="text-xs text-[#7B8B83]">
                                        Status order
                                    </span>

                                    <span class="text-right text-xs font-semibold text-[#355248]">
                                        {{ $orderStatus }}
                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- SUMMARY --}}
                        <div class="rounded-2xl border border-[#DDE9E2] bg-[#F8FBF9] p-5">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#8A9891]">
                                Ringkasan biaya
                            </p>

                            <div class="mt-5 space-y-3">

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#71837B]">
                                        Subtotal
                                    </span>

                                    <span class="text-xs font-medium text-[#355248]">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </span>

                                </div>

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#71837B]">
                                        Biaya platform
                                    </span>

                                    <span class="text-xs font-medium text-[#355248]">
                                        Rp {{ number_format($platformFee, 0, ',', '.') }}
                                    </span>

                                </div>

                                <div class="border-t border-[#DDE9E2] pt-4">

                                    <div class="flex items-end justify-between gap-4">

                                        <span class="text-xs font-semibold text-[#355248]">
                                            Total pembayaran
                                        </span>

                                        <span class="text-lg font-semibold tracking-[-0.02em] text-[#168A4D]">
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- REQUIREMENTS --}}
                @if($order->requirements)

                    <div class="border-t border-[#E5EDE8] px-5 py-6 sm:px-8 lg:px-10">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                            Brief pesanan
                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                            Kebutuhan client
                        </h2>

                        <div class="mt-4 rounded-2xl bg-[#F8FBF9] px-4 py-4">

                            <p class="whitespace-pre-line text-xs leading-6 text-[#62766D]">
                                {{ $order->requirements }}
                            </p>

                        </div>

                    </div>

                @endif

                {{-- FOOTER --}}
                <div class="border-t border-[#E5EDE8] px-5 py-5 sm:px-8 lg:px-10">

                    <div class="flex flex-col gap-2 text-[10px] text-[#97A49E] sm:flex-row sm:items-center sm:justify-between">

                        <p>
                            Invoice {{ $invoiceNumber }}
                        </p>

                        <p>
                            JASAIN — Marketplace Jasa
                        </p>

                    </div>

                </div>

            </section>

        </div>

    </div>

    <style>
        @media print {
            body {
                background: white !important;
            }

            .shadow-\[0_8px_30px_rgba\(18\,49\,40\,0\.045\)\] {
                box-shadow: none !important;
            }
        }
    </style>

</x-layouts.client>