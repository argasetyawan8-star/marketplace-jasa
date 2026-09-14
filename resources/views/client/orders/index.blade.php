<x-layouts.client title="Pesanan Saya">

    <div class="min-h-screen bg-[#F8FCF9]">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">


            {{-- =========================================================
                HEADER
            ========================================================== --}}
            <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <div class="flex items-center gap-2">

                        <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>

                        <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                            Workspace
                        </p>

                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-[-0.03em] text-[#123128] sm:text-[28px]">
                        Pesanan saya
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-[#7B8C84]">
                        Pantau proses pekerjaan, status pembayaran, dan hasil jasa yang sedang kamu pesan.
                    </p>

                </div>


                {{-- Search --}}
                <a
                    href="{{ route('marketplace.search') }}"
                    class="inline-flex h-10 shrink-0 items-center justify-center gap-2 rounded-xl border border-[#DCE8E1] bg-white px-4 text-xs font-semibold text-[#355248] shadow-[0_3px_12px_rgba(18,49,40,0.03)] transition duration-200 hover:border-[#BFDCCA] hover:bg-[#F9FCFA] hover:text-[#1E9E5A]"
                >
                    <i class="bi bi-search text-[13px]"></i>
                    Cari jasa lain
                </a>

            </div>


            {{-- =========================================================
                ALERTS
            ========================================================== --}}
            @if(session('success'))

                <div class="mb-6 overflow-hidden rounded-xl border border-[#CDE8D7] bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="flex items-center gap-3 px-4 py-3.5">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF]">
                            <i class="bi bi-check-lg text-sm font-semibold text-[#1E9E5A]"></i>
                        </div>

                        <p class="text-sm text-[#355248]">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            @if(session('error'))

                <div class="mb-6 overflow-hidden rounded-xl border border-red-100 bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="flex items-center gap-3 px-4 py-3.5">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-50">
                            <i class="bi bi-exclamation-lg text-sm font-semibold text-red-500"></i>
                        </div>

                        <p class="text-sm text-red-600">
                            {{ session('error') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                TOP SUMMARY
            ========================================================== --}}
            @if($orders->count())

                <div class="mb-5 flex flex-col gap-4 rounded-2xl border border-[#E1EAE5] bg-white p-4 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:flex-row sm:items-center sm:justify-between sm:px-5">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                            <i class="bi bi-bag-check text-[15px]"></i>
                        </div>

                        <div>

                            <p class="text-xs font-semibold text-[#18382E]">
                                Riwayat pesanan
                            </p>

                            <p class="mt-0.5 text-[10px] text-[#8A9992]">
                                Menampilkan {{ $orders->count() }} pesanan pada halaman ini
                            </p>

                        </div>

                    </div>


                    <div class="flex items-center gap-2 text-[10px] text-[#8A9992]">

                        <span class="flex h-2 w-2 rounded-full bg-[#35C978]"></span>

                        Semua aktivitas tersimpan di akunmu

                    </div>

                </div>


                {{-- =====================================================
                    ORDER LIST
                ====================================================== --}}
                <div class="space-y-4">

                    @foreach($orders as $order)

                        @php

                            $statusLabel = match($order->status) {

                                'pending_payment' => 'Menunggu pembayaran',

                                'paid' => 'Pembayaran diterima',

                                'in_progress' => 'Sedang dikerjakan',

                                'delivered' => 'Menunggu konfirmasi',

                                'revision' => 'Dalam revisi',

                                'completed' => 'Selesai',

                                'cancelled' => 'Dibatalkan',

                                default => ucfirst(
                                    str_replace('_', ' ', $order->status)
                                ),

                            };


                            $statusClass = match($order->status) {

                                'pending_payment' =>
                                    'border-[#F4E0B7] bg-[#FFF9EA] text-[#A56A00]',

                                'paid' =>
                                    'border-[#CFE1F5] bg-[#F2F7FC] text-[#3B6E9E]',

                                'in_progress' =>
                                    'border-[#CDE8D7] bg-[#EAF7EF] text-[#1E9E5A]',

                                'delivered' =>
                                    'border-[#F3DDC2] bg-[#FFF7ED] text-[#B86A1E]',

                                'revision' =>
                                    'border-[#E7D5ED] bg-[#FAF3FC] text-[#8A5599]',

                                'completed' =>
                                    'border-[#CDE8D7] bg-[#EAF7EF] text-[#168A4D]',

                                'cancelled' =>
                                    'border-[#F1D1D1] bg-[#FFF5F5] text-[#C05252]',

                                default =>
                                    'border-[#E1E7E3] bg-[#F7F9F8] text-[#65766E]',

                            };


                            $serviceItem = $order->items->first();

                            $serviceTitle = $serviceItem?->service_title ?? 'Order jasa';

                            $freelancerName =
                                $order->freelancerProfile?->user?->name
                                ?? 'Freelancer';

                        @endphp


                        {{-- ORDER CARD --}}
                        <article
                            class="group overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)] transition duration-200 hover:border-[#CFDFD6] hover:shadow-[0_10px_28px_rgba(18,49,40,0.06)]"
                        >

                            {{-- Top --}}
                            <div class="border-b border-[#EDF2EF] px-5 py-4 sm:px-6">

                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <span class="text-[10px] font-medium text-[#8B9A93]">
                                            {{ $order->order_number }}
                                        </span>

                                        <span class="h-1 w-1 rounded-full bg-[#C0CBC5]"></span>

                                        <span class="text-[10px] text-[#9AA6A0]">
                                            {{ $order->created_at->format('d M Y') }}
                                        </span>

                                    </div>


                                    <span
                                        class="inline-flex w-fit items-center rounded-full border px-2.5 py-1 text-[9px] font-semibold {{ $statusClass }}"
                                    >
                                        @if($order->status === 'completed')
                                            <i class="bi bi-check-circle-fill mr-1.5 text-[8px]"></i>
                                        @elseif($order->status === 'cancelled')
                                            <i class="bi bi-x-circle-fill mr-1.5 text-[8px]"></i>
                                        @elseif($order->status === 'in_progress')
                                            <i class="bi bi-arrow-repeat mr-1.5 text-[8px]"></i>
                                        @elseif($order->status === 'delivered')
                                            <i class="bi bi-box-seam mr-1.5 text-[8px]"></i>
                                        @elseif($order->status === 'pending_payment')
                                            <i class="bi bi-credit-card mr-1.5 text-[8px]"></i>
                                        @else
                                            <i class="bi bi-info-circle mr-1.5 text-[8px]"></i>
                                        @endif

                                        {{ $statusLabel }}
                                    </span>

                                </div>

                            </div>


                            {{-- Main content --}}
                            <div class="px-5 py-5 sm:px-6">

                                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                                    {{-- Service info --}}
                                    <div class="min-w-0 flex-1">

                                        <div class="flex items-start gap-4">

                                            {{-- Service icon --}}
                                            <div class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#F2F8F4] text-[#1E9E5A] sm:flex">
                                                <i class="bi bi-briefcase text-lg"></i>
                                            </div>


                                            <div class="min-w-0 flex-1">

                                                <h2 class="text-sm font-semibold leading-6 text-[#18382E] transition group-hover:text-[#0F6B3A] sm:text-[15px]">
                                                    {{ $serviceTitle }}
                                                </h2>


                                                {{-- Freelancer --}}
                                                <div class="mt-2 flex items-center gap-2">

                                                    <div class="flex h-6 w-6 items-center justify-center rounded-full bg-[#EAF7EF] text-[#1E9E5A]">
                                                        <i class="bi bi-person-fill text-[9px]"></i>
                                                    </div>

                                                    <span class="text-[11px] text-[#71837B]">
                                                        {{ $freelancerName }}
                                                    </span>

                                                </div>


                                                {{-- Metadata --}}
                                                <div class="mt-3 flex flex-wrap gap-x-4 gap-y-2">

                                                    <span class="inline-flex items-center gap-1.5 text-[10px] text-[#8A9992]">
                                                        <i class="bi bi-calendar3 text-[#9AA9A2]"></i>
                                                        {{ $order->created_at->format('d M Y') }}
                                                    </span>

                                                    <span class="inline-flex items-center gap-1.5 text-[10px] text-[#8A9992]">
                                                        <i class="bi bi-clock text-[#9AA9A2]"></i>
                                                        {{ $order->delivery_days }} hari pengerjaan
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- Total + action --}}
                                    <div class="flex shrink-0 flex-row items-center justify-between gap-5 border-t border-[#EEF2F0] pt-4 lg:min-w-[230px] lg:flex-col lg:items-end lg:border-t-0 lg:pt-0">

                                        <div class="lg:text-right">

                                            <p class="text-[9px] font-medium uppercase tracking-[0.12em] text-[#98A49F]">
                                                Total
                                            </p>

                                            <p class="mt-1 text-lg font-semibold tracking-[-0.02em] text-[#123128]">
                                                Rp {{ number_format($order->total, 0, ',', '.') }}
                                            </p>

                                        </div>


                                        <a
                                            href="{{ route('client.orders.show', $order) }}"
                                            class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-[#D8E4DD] bg-white px-4 text-[11px] font-semibold text-[#355248] transition duration-200 hover:border-[#AFCFBB] hover:bg-[#F4FAF6] hover:text-[#1E9E5A]"
                                        >
                                            Lihat detail

                                            <i class="bi bi-arrow-right text-[10px] transition-transform duration-200 group-hover:translate-x-0.5"></i>
                                        </a>

                                    </div>

                                </div>

                            </div>


                            {{-- Progress strip --}}
                            @if(in_array($order->status, ['paid', 'in_progress', 'delivered', 'revision']))

                                <div class="border-t border-[#EEF3F0] bg-[#FBFDFC] px-5 py-3.5 sm:px-6">

                                    <div class="flex items-center gap-3">

                                        <div class="flex-1">

                                            <div class="mb-1.5 flex items-center justify-between">

                                                <span class="text-[9px] font-medium text-[#889890]">
                                                    Progress pesanan
                                                </span>

                                                @php

                                                    $progress = match($order->status) {
                                                        'paid' => 25,
                                                        'in_progress' => 55,
                                                        'delivered' => 85,
                                                        'revision' => 70,
                                                        default => 0,
                                                    };

                                                @endphp

                                                <span class="text-[9px] font-semibold text-[#1E9E5A]">
                                                    {{ $progress }}%
                                                </span>

                                            </div>

                                            <div class="h-1.5 overflow-hidden rounded-full bg-[#E7EEE9]">

                                                <div
                                                    class="h-full rounded-full bg-[#1E9E5A] transition-all duration-500"
                                                    style="width: {{ $progress }}%"
                                                ></div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @elseif($order->status === 'completed')

                                <div class="border-t border-[#EEF3F0] bg-[#FBFDFC] px-5 py-3.5 sm:px-6">

                                    <div class="flex items-center gap-2 text-[10px] text-[#71837B]">

                                        <i class="bi bi-check-circle-fill text-[#1E9E5A]"></i>

                                        Pesanan telah selesai.

                                    </div>

                                </div>

                            @elseif($order->status === 'cancelled')

                                <div class="border-t border-[#F2E4E4] bg-[#FFFAFA] px-5 py-3.5 sm:px-6">

                                    <div class="flex items-center gap-2 text-[10px] text-[#9A6C6C]">

                                        <i class="bi bi-info-circle text-[#C05252]"></i>

                                        Pesanan ini telah dibatalkan.

                                    </div>

                                </div>

                            @endif

                        </article>

                    @endforeach

                </div>


                {{-- Pagination --}}
                @if($orders->hasPages())

                    <div class="mt-7">

                        {{ $orders->links() }}

                    </div>

                @endif


            @else

                {{-- =====================================================
                    EMPTY STATE
                ====================================================== --}}
                <div class="overflow-hidden rounded-3xl border border-[#E1EAE5] bg-white shadow-[0_8px_30px_rgba(18,49,40,0.04)]">

                    <div class="relative px-6 py-16 text-center sm:px-10 sm:py-20">

                        {{-- Decorative --}}
                        <div class="pointer-events-none absolute inset-0 overflow-hidden">

                            <div class="absolute left-1/2 top-10 h-32 w-32 -translate-x-1/2 rounded-full bg-[#EAF7EF] opacity-60 blur-3xl"></div>

                        </div>


                        <div class="relative">

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-[#D8EBDD] bg-[#F3FAF5] text-[#1E9E5A] shadow-sm">
                                <i class="bi bi-bag text-[23px]"></i>
                            </div>


                            <p class="mt-6 text-[9px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                                Belum ada aktivitas
                            </p>


                            <h2 class="mt-2 text-xl font-semibold tracking-[-0.025em] text-[#123128]">
                                Belum ada pesanan
                            </h2>


                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#7B8C84]">
                                Kamu belum memesan jasa apa pun. Jelajahi berbagai layanan
                                dan temukan freelancer yang sesuai dengan kebutuhanmu.
                            </p>


                            <a
                                href="{{ route('marketplace.search') }}"
                                class="mt-7 inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 text-xs font-semibold text-white shadow-[0_5px_18px_rgba(30,158,90,0.16)] transition duration-200 hover:bg-[#0F6B3A] hover:shadow-[0_7px_22px_rgba(30,158,90,0.20)]"
                            >
                                <i class="bi bi-search text-[12px]"></i>
                                Cari jasa
                                <i class="bi bi-arrow-right text-[11px]"></i>
                            </a>

                        </div>

                    </div>

                </div>

            @endif


        </div>

    </div>

</x-layouts.client>