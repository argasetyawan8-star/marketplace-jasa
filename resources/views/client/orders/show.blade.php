<x-layouts.client title="Detail Pesanan">

    @php

        $serviceTitle =

            $order->items->first()?->service_title

            ?? 'Pesanan Jasa';

        $freelancer = $order->freelancerProfile;

        $freelancerName =

            $freelancer?->user?->name

            ?? 'Freelancer';

        $freelancerInitial = strtoupper(

            substr($freelancerName, 0, 1)

        );

        $freelancerAvatar = $freelancer?->avatar

            ? asset('storage/' . $freelancer->avatar)

            : null;


        $statusConfig = match ($order->status) {

            'pending_payment' => [

                'label' => 'Menunggu pembayaran',

                'icon' => 'bi-credit-card',

                'class' => 'border-[#F2DDAF] bg-[#FFF9EA] text-[#9A6800]',

                'dot' => 'bg-[#D99A19]',

            ],

            'paid' => [

                'label' => 'Pembayaran diterima',

                'icon' => 'bi-check-circle',

                'class' => 'border-[#CFE0F1] bg-[#F3F8FC] text-[#3C6F9F]',

                'dot' => 'bg-[#5B91C0]',

            ],

            'in_progress' => [

                'label' => 'Sedang dikerjakan',

                'icon' => 'bi-arrow-repeat',

                'class' => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',

                'dot' => 'bg-[#35C978]',

            ],

            'delivered' => [

                'label' => 'Menunggu pemeriksaan',

                'icon' => 'bi-file-earmark-check',

                'class' => 'border-[#E7D9C8] bg-[#FFF8EF] text-[#A96B20]',

                'dot' => 'bg-[#D48A32]',

            ],

            'revision' => [

                'label' => 'Dalam revisi',

                'icon' => 'bi-arrow-repeat',

                'class' => 'border-[#E8D8ED] bg-[#FAF4FC] text-[#895597]',

                'dot' => 'bg-[#B77BC7]',

            ],

            'completed' => [

                'label' => 'Selesai',

                'icon' => 'bi-check-circle-fill',

                'class' => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',

                'dot' => 'bg-[#35C978]',

            ],

            'cancelled' => [

                'label' => 'Dibatalkan',

                'icon' => 'bi-x-circle',

                'class' => 'border-[#F0D5D5] bg-[#FFF6F6] text-[#B84E4E]',

                'dot' => 'bg-[#D16B6B]',

            ],

            default => [

                'label' => ucfirst(

                    str_replace('_', ' ', $order->status)

                ),

                'icon' => 'bi-info-circle',

                'class' => 'border-[#E1E7E3] bg-[#F7F9F8] text-[#66766E]',

                'dot' => 'bg-[#A3AEA9]',

            ],

        };


        $cancelableStatuses = [

            'pending_payment',

            'paid',

            'in_progress',

            'revision',

        ];

        $canRequestCancellation = in_array(

            $order->status,

            $cancelableStatuses,

            true

        );


        $latestRefund = $order->latestRefund;
        $refundStatus = $latestRefund?->status;
        $refundAmount = (float) ($latestRefund?->amount ?? $order->total);

        $timeline = [
            [
                'label' => 'Pembayaran',
                'description' => $order->status === 'cancelled' && $order->payment?->status === 'refunded'
                    ? 'Pembayaran sebelumnya berhasil dilakukan dan dana telah dikembalikan.'
                    : 'Pesanan berhasil dibuat dan menunggu proses pembayaran.',
                'icon' => 'bi-credit-card',
                'active' => in_array($order->status, ['pending_payment', 'paid', 'in_progress', 'delivered', 'revision', 'completed'], true)
                    || in_array($order->payment?->status, ['paid', 'refund_pending', 'refunded'], true),
            ],
            [
                'label' => 'Pengerjaan',
                'description' => 'Freelancer mulai mengerjakan kebutuhan pesananmu.',
                'icon' => 'bi-briefcase',
                'active' => in_array($order->status, ['in_progress', 'delivered', 'revision', 'completed'], true),
            ],
            [
                'label' => 'Hasil pekerjaan',
                'description' => 'Freelancer mengirimkan hasil pekerjaan untuk diperiksa.',
                'icon' => 'bi-file-earmark-check',
                'active' => in_array($order->status, ['delivered', 'revision', 'completed'], true),
            ],
            [
                'label' => 'Pesanan selesai',
                'description' => 'Pekerjaan telah disetujui dan pesanan selesai.',
                'icon' => 'bi-check-lg',
                'active' => $order->status === 'completed',
            ],
        ];

        if ($order->status === 'cancelled') {
            $timeline[] = [
                'label' => 'Pembatalan',
                'description' => 'Pesanan telah dibatalkan dan tidak dapat diproses kembali.',
                'icon' => 'bi-x-circle',
                'active' => true,
            ];

            $timeline[] = [
                'label' => 'Refund',
                'description' => match ($refundStatus) {
                    'refunded' => 'Dana pembayaran telah berhasil dikembalikan kepada client.',
                    'pending', 'processing' => 'Pengembalian dana sedang diproses oleh admin.',
                    'rejected' => 'Pengembalian dana belum berhasil diselesaikan.',
                    default => 'Belum ada proses refund yang tercatat.',
                },
                'icon' => 'bi-arrow-counterclockwise',
                'active' => in_array($refundStatus, ['pending', 'processing', 'refunded', 'rejected'], true),
            ];
        }

        $hasReview = $order->review !== null;

    @endphp

    <div class="min-h-screen bg-[#F8FCF9]">

        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">

            {{-- =========================================================

                TOP BAR

            ========================================================== --}}

            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <a

                    href="{{ route('client.orders.index') }}"

                    class="inline-flex w-fit items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"

                >

                    <i class="bi bi-arrow-left text-[12px]"></i>

                    Kembali ke pesanan

                </a>

                <div class="flex flex-wrap items-center gap-2">

                    <span class="text-[10px] text-[#99A59F]">

                        Order {{ $order->order_number }}

                    </span>

                    <a

                        href="{{ route('client.orders.invoice', $order) }}"

                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E5DD] bg-white px-4 py-2.5 text-[10px] font-semibold text-[#52685F] transition hover:border-[#BBD9C6] hover:bg-[#F4FAF6] hover:text-[#1E9E5A]"

                    >

                        <i class="bi bi-receipt"></i>

                        Invoice

                    </a>

                </div>

            </div>

            {{-- =========================================================

                ALERT SUCCESS

            ========================================================== --}}

            @if(session('success'))

                <div class="mb-5 overflow-hidden rounded-xl border border-[#CDE8D7] bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="flex items-center gap-3 px-4 py-3.5">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF]">

                            <i class="bi bi-check-lg text-sm text-[#1E9E5A]"></i>

                        </div>

                        <p class="text-sm text-[#355248]">

                            {{ session('success') }}

                        </p>

                    </div>

                </div>

            @endif

            {{-- =========================================================

                ALERT ERROR

            ========================================================== --}}

            @if(session('error'))

                <div class="mb-5 overflow-hidden rounded-xl border border-red-100 bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="flex items-center gap-3 px-4 py-3.5">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-50">

                            <i class="bi bi-exclamation-lg text-sm text-red-500"></i>

                        </div>

                        <p class="text-sm text-red-600">

                            {{ session('error') }}

                        </p>

                    </div>

                </div>

            @endif

            {{-- =========================================================

                VALIDATION ERRORS

            ========================================================== --}}

            @if($errors->any())

                <div class="mb-5 overflow-hidden rounded-xl border border-red-100 bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="px-4 py-3.5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-50">

                                <i class="bi bi-exclamation-lg text-sm text-red-500"></i>

                            </div>

                            <div>

                                <p class="text-sm font-medium text-red-600">

                                    Terdapat kesalahan pada form.

                                </p>

                                <div class="mt-1 space-y-0.5">

                                    @foreach($errors->all() as $error)

                                        <p class="text-xs text-red-500">

                                            {{ $error }}

                                        </p>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endif

            {{-- =========================================================

                ORDER HEADER

            ========================================================== --}}

            <section class="overflow-hidden rounded-3xl border border-[#E1EAE5] bg-white shadow-[0_8px_28px_rgba(18,49,40,0.045)]">

                <div class="px-5 py-6 sm:px-7 lg:px-8 lg:py-7">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                        {{-- Information --}}

                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F3F7F5] px-2.5 py-1 text-[9px] font-medium text-[#7F8E87]">

                                    <i class="bi bi-hash text-[8px]"></i>

                                    {{ $order->order_number }}

                                </span>

                                <span class="text-[10px] text-[#A0AAA5]">

                                    Dibuat

                                    {{ $order->created_at?->format('d M Y, H:i') }}

                                </span>

                            </div>

                            <h1 class="mt-4 max-w-3xl text-xl font-semibold leading-8 tracking-[-0.03em] text-[#123128] sm:text-2xl">

                                {{ $serviceTitle }}

                            </h1>

                            <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2">

                                <span class="inline-flex items-center gap-1.5 text-[10px] text-[#7F8F87]">

                                    <i class="bi bi-person text-[#1E9E5A]"></i>

                                    {{ $freelancerName }}

                                </span>

                                <span class="inline-flex items-center gap-1.5 text-[10px] text-[#7F8F87]">

                                    <i class="bi bi-clock text-[#1E9E5A]"></i>

                                    {{ $order->delivery_days }} hari pengerjaan

                                </span>

                                @if($order->due_at)

                                    <span class="inline-flex items-center gap-1.5 text-[10px] text-[#7F8F87]">

                                        <i class="bi bi-calendar-event text-[#1E9E5A]"></i>

                                        Deadline

                                        {{ $order->due_at->format('d M Y') }}

                                    </span>

                                @endif

                            </div>

                        </div>

                        {{-- Status --}}

                        <div class="shrink-0">

                            <span

                                class="inline-flex items-center gap-2 rounded-full border px-3 py-2 text-[10px] font-semibold {{ $statusConfig['class'] }}"

                            >

                                <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>

                                <i class="bi {{ $statusConfig['icon'] }} text-[10px]"></i>

                                {{ $statusConfig['label'] }}

                            </span>

                        </div>

                    </div>

                </div>

            </section>

            {{-- =========================================================

                CANCELLATION STATUS / ACTION

            ========================================================== --}}

            @if($order->status === 'cancelled')

                <section class="mt-5 overflow-hidden rounded-2xl border border-[#F0D5D5] bg-[#FFF6F6]">

                    <div class="px-5 py-5 sm:px-6">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#B84E4E] shadow-sm">
                                <i class="bi bi-x-circle text-lg"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-[#8E4141]">Pesanan dibatalkan</p>
                                <p class="mt-1 text-xs leading-5 text-[#A26767]">Order ini sudah dibatalkan dan tidak dapat diproses kembali.</p>

                                @if($order->cancel_reason)
                                    <div class="mt-3 rounded-xl bg-white/80 px-4 py-3">
                                        <p class="text-[9px] font-semibold uppercase tracking-[0.15em] text-[#A26767]">Alasan pembatalan</p>
                                        <p class="mt-1 whitespace-pre-line text-xs leading-6 text-[#7D5A5A]">{{ $order->cancel_reason }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($refundStatus === 'refunded')
                            <div class="mt-5 rounded-2xl border border-[#CDE7D7] bg-white px-4 py-4 sm:px-5">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                        <i class="bi bi-arrow-counterclockwise text-[15px]"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-[#123128]">Refund selesai</p>
                                        <p class="mt-1 text-xs leading-5 text-[#527066]">
                                            Dana sebesar <span class="font-semibold text-[#168A4D]">Rp {{ number_format($refundAmount, 0, ',', '.') }}</span> telah berhasil dikembalikan.
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4 grid grid-cols-1 gap-3 rounded-xl bg-[#F8FBF9] px-4 py-3 sm:grid-cols-2">
                                    <div>
                                        <p class="text-[9px] uppercase tracking-[0.14em] text-[#97A39E]">Nomor refund</p>
                                        <p class="mt-1 break-all text-[10px] font-semibold text-[#355248]">{{ $latestRefund?->refund_number ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] uppercase tracking-[0.14em] text-[#97A39E]">Refund selesai</p>
                                        <p class="mt-1 text-[10px] font-semibold text-[#355248]">{{ $latestRefund?->completed_at?->format('d M Y, H:i') ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @elseif(in_array($refundStatus, ['pending', 'processing'], true))
                            <div class="mt-5 rounded-2xl border border-[#D6E3F2] bg-white px-4 py-4 sm:px-5">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EEF5FF] text-[#315A91]">
                                        <i class="bi bi-arrow-repeat text-[15px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-[#123128]">Refund sedang diproses</p>
                                        <p class="mt-1 text-xs leading-5 text-[#62766D]">
                                            Pengembalian dana sebesar <span class="font-semibold text-[#315A91]">Rp {{ number_format($refundAmount, 0, ',', '.') }}</span> sedang diproses oleh admin.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($refundStatus === 'rejected')
                            <div class="mt-5 rounded-2xl border border-red-100 bg-white px-4 py-4 sm:px-5">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-500">
                                        <i class="bi bi-exclamation-circle text-[15px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-[#8E4141]">Refund belum selesai</p>
                                        <p class="mt-1 text-xs leading-5 text-[#7D5A5A]">Pengajuan refund belum berhasil diselesaikan. Periksa informasi refund untuk detail lebih lanjut.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </section>

            @elseif($canRequestCancellation)

                <section class="mt-5 overflow-hidden rounded-2xl border border-[#E9DCC4] bg-[#FFF9EA]">

                    <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#B37A21] shadow-sm">

                                <i class="bi bi-x-circle text-lg"></i>

                            </div>

                            <div>

                                <p class="text-sm font-semibold text-[#76520F]">

                                    Ingin membatalkan pesanan?

                                </p>

                                <p class="mt-1 max-w-xl text-xs leading-5 text-[#987544]">

                                    Kamu dapat mengajukan pembatalan dan menjelaskan alasannya. Pengajuan akan ditinjau oleh admin.

                                </p>

                            </div>

                        </div>

                        <a

                            href="{{ route('client.orders.cancellation.create', $order) }}"

                            class="inline-flex h-10 shrink-0 items-center justify-center gap-2 rounded-xl border border-[#D9B96E] bg-white px-4 text-xs font-semibold text-[#76520F] transition hover:border-[#C89F42] hover:bg-[#FFF4D8]"

                        >

                            <i class="bi bi-x-circle text-[12px]"></i>

                            Ajukan Pembatalan

                        </a>

                    </div>

                </section>

            @endif

            {{-- =========================================================

                DELIVERY

            ========================================================== --}}

            @if(in_array($order->status, ['delivered', 'revision'], true))

                <section class="mt-5 overflow-hidden rounded-2xl border border-[#CFE7D7] bg-[#EAF7EF]">

                    <div class="flex flex-col gap-5 px-5 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">

                                <i class="bi bi-file-earmark-check text-lg"></i>

                            </div>

                            <div>

                                @if($order->status === 'revision')

                                    <p class="text-xs font-semibold text-[#123128]">

                                        Freelancer sedang mengerjakan revisi

                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#527066]">

                                        Tunggu freelancer mengirimkan hasil revisi berikutnya.

                                    </p>

                                @else

                                    <p class="text-xs font-semibold text-[#123128]">

                                        Hasil pekerjaan sudah dikirim

                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#527066]">

                                        Periksa hasil yang dikirim freelancer sebelum menyetujui pesanan.

                                    </p>

                                @endif

                            </div>

                        </div>

                        <a

                            href="{{ route('client.delivery.show', $order) }}"

                            class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-4 text-xs font-semibold text-white transition hover:bg-[#0F6B3A]"

                        >

                            <i class="bi bi-eye text-[12px]"></i>

                            Lihat Delivery

                        </a>

                    </div>

                </section>

            @endif

            {{-- =========================================================

                COMPLETED / REVIEW

            ========================================================== --}}

            @if($order->status === 'completed')

                <section class="mt-5 overflow-hidden rounded-2xl border border-[#CFE7D7] bg-[#EAF7EF]">

                    <div class="flex flex-col gap-5 px-5 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">

                                @if($hasReview)

                                    <i class="bi bi-star-fill text-lg"></i>

                                @else

                                    <i class="bi bi-check-circle-fill text-lg"></i>

                                @endif

                            </div>

                            <div>

                                @if($hasReview)

                                    <p class="text-xs font-semibold text-[#123128]">

                                        Order sudah selesai

                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#527066]">

                                        Review kamu sudah diberikan kepada freelancer.

                                    </p>

                                @else

                                    <p class="text-xs font-semibold text-[#123128]">

                                        Order sudah selesai

                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#527066]">

                                        Bagikan pengalamanmu setelah menggunakan jasa freelancer ini.

                                    </p>

                                @endif

                            </div>

                        </div>

                        @if(!$hasReview)

                            <a

                                href="{{ route('client.reviews.create', $order) }}"

                                class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-4 text-xs font-semibold text-white transition hover:bg-[#0F6B3A]"

                            >

                                <i class="bi bi-star-fill text-[11px]"></i>

                                Beri Review

                            </a>

                        @else

                            <span class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-white px-4 text-xs font-semibold text-[#1E9E5A]">

                                <i class="bi bi-check-circle-fill text-[11px]"></i>

                                Sudah direview

                            </span>

                        @endif

                    </div>

                </section>

            @endif

            {{-- =========================================================

                MAIN GRID

            ========================================================== --}}

            <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_340px]">

                {{-- =====================================================

                    LEFT

                ====================================================== --}}

                <div class="space-y-5">

                    {{-- Freelancer --}}

                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                                    Freelancer

                                </p>

                                <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                                    Dikerjakan oleh

                                </h2>

                            </div>

                            <i class="bi bi-person-check text-[#A0ADA7]"></i>

                        </div>

                        <div class="mt-5 flex items-center justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A]">

                                    @if($freelancerAvatar)

                                        <img

                                            src="{{ $freelancerAvatar }}"

                                            alt="{{ $freelancerName }}"

                                            class="h-full w-full object-cover"

                                        >

                                    @else

                                        {{ $freelancerInitial }}

                                    @endif

                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-[#18382E]">

                                        {{ $freelancerName }}

                                    </p>

                                    <p class="mt-0.5 text-[10px] text-[#8B9992]">

                                        Freelancer JASAIN

                                    </p>

                                </div>

                            </div>

                            <a

                                href="{{ route('client.messages.index') }}"

                                class="inline-flex h-9 shrink-0 items-center gap-2 rounded-lg border border-[#DDE7E1] px-3 text-[10px] font-semibold text-[#52685F] transition hover:border-[#BBD9C6] hover:bg-[#F4FAF6] hover:text-[#1E9E5A]"

                            >

                                <i class="bi bi-chat-dots text-[11px]"></i>

                                Pesan

                            </a>

                        </div>

                    </section>

                    {{-- Detail Pesanan --}}

                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                        <div class="flex items-end justify-between">

                            <div>

                                <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                                    Order

                                </p>

                                <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                                    Detail pesanan

                                </h2>

                            </div>

                            <span class="text-[10px] text-[#98A49F]">

                                {{ $order->items->count() }} item

                            </span>

                        </div>

                        <div class="mt-5 overflow-hidden rounded-xl border border-[#E7EEE9]">

                            @foreach($order->items as $item)

                                <div class="flex items-start justify-between gap-4 px-4 py-4 {{ !$loop->last ? 'border-b border-[#EDF2EF]' : '' }}">

                                    <div class="flex min-w-0 items-start gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F2F8F4] text-[#1E9E5A]">

                                            <i class="bi bi-briefcase text-[13px]"></i>

                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-xs font-semibold text-[#18382E]">

                                                {{ $item->service_title }}

                                            </p>

                                            <p class="mt-1 text-[10px] text-[#909E98]">

                                                {{ $item->quantity }}

                                                ×

                                                Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}

                                            </p>

                                        </div>

                                    </div>

                                    <p class="shrink-0 text-xs font-semibold text-[#18382E]">

                                        Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}

                                    </p>

                                </div>

                            @endforeach

                        </div>

                    </section>

                    {{-- Requirements --}}

                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                                Brief

                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                                Kebutuhan pesanan

                            </h2>

                        </div>

                        @if($order->requirements)

                            <div class="mt-5 rounded-xl bg-[#F8FBF9] px-4 py-4">

                                <p class="whitespace-pre-line text-xs leading-6 text-[#62766D]">

                                    {{ $order->requirements }}

                                </p>

                            </div>

                        @else

                            <div class="mt-5 rounded-xl border border-dashed border-[#DCE6E1] px-4 py-6 text-center">

                                <i class="bi bi-file-text text-lg text-[#A0ADA7]"></i>

                                <p class="mt-2 text-xs text-[#98A49E]">

                                    Belum ada kebutuhan khusus yang ditambahkan.

                                </p>

                            </div>

                        @endif

                    </section>

                    {{-- Timeline --}}

                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                                Timeline

                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                                Perjalanan pesanan

                            </h2>

                        </div>

                        <div class="relative mt-6">

                            <div class="absolute bottom-5 left-[17px] top-5 w-px bg-[#E1EAE5]"></div>

                            <div class="space-y-6">

                                @foreach($timeline as $step)

                                    <div class="relative flex gap-4">

                                        <div

                                            class="relative z-10 flex h-[35px] w-[35px] shrink-0 items-center justify-center rounded-full border {{ $step['active'] ? 'border-[#BFE0CC] bg-[#EAF7EF] text-[#1E9E5A]' : 'border-[#E3E9E5] bg-white text-[#A5B0AB]' }}"

                                        >

                                            <i class="bi {{ $step['icon'] }} text-[12px]"></i>

                                        </div>

                                        <div class="pt-0.5">

                                            <p

                                                class="text-xs font-semibold {{ $step['active'] ? 'text-[#18382E]' : 'text-[#9AA6A0]' }}"

                                            >

                                                {{ $step['label'] }}

                                            </p>

                                            <p class="mt-1 max-w-lg text-[10px] leading-5 text-[#8B9992]">

                                                {{ $step['description'] }}

                                            </p>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </section>

                    {{-- Review Summary --}}

                    @if($hasReview)

                        <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                            <div class="flex items-start justify-between gap-4">

                                <div>

                                    <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                                        Review

                                    </p>

                                    <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                                        Review kamu

                                    </h2>

                                </div>

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#FFF9EA] px-2.5 py-1 text-[10px] font-semibold text-[#9A6800]">

                                    <i class="bi bi-star-fill"></i>

                                    {{ $order->review->rating }}/5

                                </span>

                            </div>

                            @if($order->review->comment)

                                <div class="mt-5 rounded-xl bg-[#F8FBF9] px-4 py-4">

                                    <p class="whitespace-pre-line text-xs leading-6 text-[#62766D]">

                                        "{{ $order->review->comment }}"

                                    </p>

                                </div>

                            @endif

                            <p class="mt-3 text-[10px] text-[#A0ADA7]">

                                Diberikan pada

                                {{ $order->review->created_at?->format('d M Y, H:i') }}

                            </p>

                        </section>

                    @endif

                </div>

                {{-- =====================================================

                    RIGHT

                ====================================================== --}}

                <aside class="space-y-5">

                    {{-- Payment --}}

                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                                Pembayaran

                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                                Ringkasan biaya

                            </h2>

                        </div>

                        <div class="mt-5 space-y-3.5">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-xs text-[#7D8D86]">

                                    Subtotal

                                </span>

                                <span class="text-xs font-medium text-[#355248]">

                                    Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}

                                </span>

                            </div>

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-xs text-[#7D8D86]">

                                    Biaya platform

                                </span>

                                <span class="text-xs font-medium text-[#355248]">

                                    Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}

                                </span>

                            </div>

                            <div class="border-t border-[#EDF2EF] pt-4">

                                <div class="flex items-end justify-between gap-4">

                                    <span class="text-xs font-medium text-[#52675E]">

                                        Total pembayaran

                                    </span>

                                    <span class="text-lg font-semibold tracking-[-0.02em] text-[#123128]">

                                        Rp {{ number_format((float) $order->total, 0, ',', '.') }}

                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- Invoice --}}

                        <a

                            href="{{ route('client.orders.invoice', $order) }}"

                            class="mt-5 flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-[#D8E5DD] bg-[#F8FBF9] px-4 text-xs font-semibold text-[#52685F] transition hover:border-[#BBD9C6] hover:bg-[#EAF7EF] hover:text-[#1E9E5A]"

                        >

                            <i class="bi bi-receipt"></i>

                            Lihat Invoice

                        </a>

                    </section>

                    {{-- Payment Status --}}

                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                                Status

                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                                Pembayaran

                            </h2>

                        </div>

                        @if($order->payment)

                            <div class="mt-5">

                                <div class="flex items-center justify-between gap-3">

                                    <span class="text-xs text-[#7D8D86]">

                                        Status

                                    </span>

                                    @if($order->payment->status === 'paid')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-2.5 py-1 text-[9px] font-semibold text-[#1E9E5A]">

                                            <span class="h-1.5 w-1.5 rounded-full bg-[#35C978]"></span>

                                            Lunas

                                        </span>

                                    @elseif($order->payment->status === 'pending')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#FFF9EA] px-2.5 py-1 text-[9px] font-semibold text-[#9A6800]">

                                            <span class="h-1.5 w-1.5 rounded-full bg-[#D99A19]"></span>

                                            Belum dibayar

                                        </span>

                                    @elseif($order->payment->status === 'refund_pending')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EEF5FF] px-2.5 py-1 text-[9px] font-semibold text-[#315A91]">

                                            <span class="h-1.5 w-1.5 rounded-full bg-[#5B91C0]"></span>

                                            Menunggu refund

                                        </span>

                                    @elseif($order->payment->status === 'refunded')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-2.5 py-1 text-[9px] font-semibold text-[#168A4D]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#35C978]"></span>
                                            Dana dikembalikan
                                        </span>

                                    @elseif($order->payment->status === 'cancelled')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F4F6F5] px-2.5 py-1 text-[9px] font-semibold text-[#66766E]">

                                            <span class="h-1.5 w-1.5 rounded-full bg-[#A3AEA9]"></span>

                                            Dibatalkan

                                        </span>

                                    @else

                                        <span class="inline-flex items-center rounded-full bg-[#F4F6F5] px-2.5 py-1 text-[9px] font-semibold text-[#66766E]">

                                            {{ ucfirst(str_replace('_', ' ', $order->payment->status)) }}

                                        </span>

                                    @endif

                                </div>

                                <div class="mt-4 flex items-center justify-between gap-3">

                                    <span class="text-xs text-[#7D8D86]">

                                        Metode

                                    </span>

                                    <span class="max-w-[170px] truncate text-right text-[10px] font-semibold text-[#355248]">

                                        {{ strtoupper($order->payment->payment_type ?? '-') }}

                                    </span>

                                </div>

                                @if($order->payment->transaction_id)

                                    <div class="mt-4 flex items-start justify-between gap-3">

                                        <span class="text-xs text-[#7D8D86]">

                                            Transaksi

                                        </span>

                                        <span class="max-w-[170px] break-all text-right text-[10px] font-semibold text-[#355248]">

                                            {{ $order->payment->transaction_id }}

                                        </span>

                                    </div>

                                @endif

                                @if($order->payment->paid_at)

                                    <div class="mt-4 flex items-start justify-between gap-3">

                                        <span class="text-xs text-[#7D8D86]">

                                            Dibayar

                                        </span>

                                        <span class="text-right text-[10px] font-semibold text-[#355248]">

                                            {{ $order->payment->paid_at->format('d M Y, H:i') }}

                                        </span>

                                    </div>

                                @endif

                                @if($latestRefund)

                                    <div class="mt-4 overflow-hidden rounded-xl border border-[#DCE9E1] bg-[#F8FBF9]">
                                        <div class="px-4 py-3">
                                            <div class="flex items-center justify-between gap-3">
                                                <span class="text-xs text-[#7D8D86]">Refund</span>
                                                <span class="text-[10px] font-semibold text-[#355248]">
                                                    {{ match($refundStatus) {
                                                        'pending' => 'Menunggu diproses',
                                                        'processing' => 'Sedang diproses',
                                                        'refunded' => 'Selesai',
                                                        'rejected' => 'Ditolak',
                                                        default => ucfirst(str_replace('_', ' ', $refundStatus ?? 'Belum tersedia')),
                                                    } }}
                                                </span>
                                            </div>
                                            <div class="mt-2 flex items-center justify-between gap-3">
                                                <span class="text-xs text-[#7D8D86]">Nominal</span>
                                                <span class="text-xs font-semibold text-[#168A4D]">Rp {{ number_format($refundAmount, 0, ',', '.') }}</span>
                                            </div>
                                            @if($refundStatus === 'refunded' && $latestRefund->completed_at)
                                                <div class="mt-2 flex items-start justify-between gap-3">
                                                    <span class="text-xs text-[#7D8D86]">Selesai pada</span>
                                                    <span class="text-right text-[10px] font-semibold text-[#355248]">{{ $latestRefund->completed_at->format('d M Y, H:i') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                @endif

                                @if($order->status === 'pending_payment')

                                    <a

                                        href="{{ route('client.orders.checkout', $order) }}"

                                        class="mt-5 flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-4 text-xs font-semibold text-white shadow-[0_5px_15px_rgba(30,158,90,0.14)] transition hover:bg-[#0F6B3A]"

                                    >

                                        <i class="bi bi-credit-card text-[12px]"></i>

                                        Lanjutkan pembayaran

                                    </a>

                                @endif

                            </div>

                        @else

                            <div class="mt-5 rounded-xl border border-dashed border-[#DCE6E1] px-4 py-5 text-center">

                                <i class="bi bi-credit-card text-lg text-[#A3AEA8]"></i>

                                <p class="mt-2 text-xs text-[#98A49E]">

                                    Data pembayaran belum tersedia.

                                </p>

                            </div>

                        @endif

                    </section>

                    {{-- Cancellation --}}

                    @if($canRequestCancellation)

                        <section class="rounded-2xl border border-[#E7DDC8] bg-[#FFF9EA] p-5">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#B37A21] shadow-sm">

                                <i class="bi bi-x-circle text-[15px]"></i>

                            </div>

                            <h2 class="mt-4 text-sm font-semibold text-[#123128]">

                                Pembatalan pesanan

                            </h2>

                            <p class="mt-1.5 text-xs leading-5 text-[#7D6948]">

                                Ajukan pembatalan bila pesanan tidak dapat dilanjutkan. Admin akan meninjau pengajuanmu.

                            </p>

                            <a

                                href="{{ route('client.orders.cancellation.create', $order) }}"

                                class="mt-4 flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-white text-xs font-semibold text-[#76520F] shadow-sm transition hover:bg-[#FFF3D6] hover:text-[#9A6800]"

                            >

                                Ajukan Pembatalan

                                <i class="bi bi-arrow-right text-[10px]"></i>

                            </a>

                        </section>

                    @endif

                    {{-- Deadline --}}

                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                                Pengerjaan

                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                                Waktu pekerjaan

                            </h2>

                        </div>

                        <div class="mt-5 space-y-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F3F8F5] text-[#1E9E5A]">

                                    <i class="bi bi-calendar-event text-[13px]"></i>

                                </div>

                                <div class="min-w-0">

                                    <p class="text-[10px] text-[#97A39E]">

                                        Batas pengerjaan

                                    </p>

                                    <p class="mt-1 text-xs font-semibold text-[#355248]">

                                        {{ $order->due_at?->format('d M Y, H:i') ?? '-' }}

                                    </p>

                                </div>

                            </div>

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F3F8F5] text-[#1E9E5A]">

                                    <i class="bi bi-clock text-[13px]"></i>

                                </div>

                                <div>

                                    <p class="text-[10px] text-[#97A39E]">

                                        Durasi

                                    </p>

                                    <p class="mt-1 text-xs font-semibold text-[#355248]">

                                        {{ $order->delivery_days }} hari

                                    </p>

                                </div>

                            </div>

                        </div>

                    </section>

                    {{-- Help --}}

                    <section class="rounded-2xl border border-[#DCE9E1] bg-[#EAF7EF] p-5">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">

                            <i class="bi bi-chat-dots text-[15px]"></i>

                        </div>

                        <h2 class="mt-4 text-sm font-semibold text-[#123128]">

                            Butuh bantuan?

                        </h2>

                        @if($order->status === 'cancelled')

                            <p class="mt-1.5 text-xs leading-5 text-[#63786E]">

                                Pesanan ini sudah ditutup. Untuk informasi terkait pembatalan atau refund, gunakan nomor order sebagai referensi.

                            </p>

                        @else

                            <p class="mt-1.5 text-xs leading-5 text-[#63786E]">

                                Hubungi freelancer melalui pesan untuk membahas detail pekerjaanmu.

                            </p>

                            @if($freelancer)


                            <a

                                href="{{ route('client.messages.index') }}"

                                class="mt-4 flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-white text-xs font-semibold text-[#355248] shadow-sm transition hover:text-[#1E9E5A]"

                            >

                                Buka pesan

                                <i class="bi bi-arrow-right text-[10px]"></i>

                            </a>

                            @endif

                        @endif

                    </section>

                </aside>

            </div>

        </div>

    </div>

</x-layouts.client>