<x-layouts.freelancer title="Detail Order">

    @php

        /*
        |--------------------------------------------------------------------------
        | BASIC DATA
        |--------------------------------------------------------------------------
        */

        $clientName = $order->client?->name ?? 'Client';

        $clientAvatar = $order->client?->profile?->avatar
            ? asset('storage/' . $order->client->profile->avatar)
            : null;

        $clientInitial = strtoupper(
            substr($clientName, 0, 1)
        );

        $serviceTitle = $order->items->first()?->service_title
            ?? 'Pesanan Jasa';


        /*
        |--------------------------------------------------------------------------
        | DISPUTE
        |--------------------------------------------------------------------------
        */

        $activeDispute = $order->activeDispute;


        /*
        |--------------------------------------------------------------------------
        | ORDER STATUS
        |--------------------------------------------------------------------------
        */

        $statusConfig = match($order->status) {

            'pending_payment' => [
                'label' => 'Menunggu pembayaran',
                'class' => 'border-amber-200 bg-amber-50 text-amber-700',
                'dot' => 'bg-amber-500',
                'icon' => 'bi-credit-card',
            ],

            'paid' => [
                'label' => 'Siap dikerjakan',
                'class' => 'border-blue-200 bg-blue-50 text-blue-700',
                'dot' => 'bg-blue-500',
                'icon' => 'bi-check-circle',
            ],

            'in_progress' => [
                'label' => 'Sedang dikerjakan',
                'class' => 'border-indigo-200 bg-indigo-50 text-indigo-700',
                'dot' => 'bg-indigo-500',
                'icon' => 'bi-arrow-repeat',
            ],

            'delivered' => [
                'label' => 'Menunggu pemeriksaan client',
                'class' => 'border-orange-200 bg-orange-50 text-orange-700',
                'dot' => 'bg-orange-500',
                'icon' => 'bi-file-earmark-check',
            ],

            'revision' => [
                'label' => 'Dalam revisi',
                'class' => 'border-violet-200 bg-violet-50 text-violet-700',
                'dot' => 'bg-violet-500',
                'icon' => 'bi-arrow-repeat',
            ],

            'completed' => [
                'label' => 'Selesai',
                'class' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                'dot' => 'bg-emerald-500',
                'icon' => 'bi-check-circle-fill',
            ],

            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'border-rose-200 bg-rose-50 text-rose-700',
                'dot' => 'bg-rose-500',
                'icon' => 'bi-x-circle',
            ],

            default => [
                'label' => ucfirst(str_replace('_', ' ', $order->status)),
                'class' => 'border-slate-200 bg-slate-50 text-slate-600',
                'dot' => 'bg-slate-400',
                'icon' => 'bi-info-circle',
            ],

        };


        /*
        |--------------------------------------------------------------------------
        | TIMELINE
        |--------------------------------------------------------------------------
        */

        $timeline = [

            [
                'label' => 'Pembayaran',
                'description' => 'Client membuat order dan menyelesaikan pembayaran.',
                'icon' => 'bi-credit-card',
                'active' => in_array($order->status, [
                    'paid',
                    'in_progress',
                    'delivered',
                    'revision',
                    'completed',
                ]),
            ],

            [
                'label' => 'Pengerjaan',
                'description' => 'Freelancer mengerjakan kebutuhan sesuai brief client.',
                'icon' => 'bi-briefcase',
                'active' => in_array($order->status, [
                    'in_progress',
                    'delivered',
                    'revision',
                    'completed',
                ]),
            ],

            [
                'label' => 'Delivery',
                'description' => 'Hasil pekerjaan dikirim kepada client untuk diperiksa.',
                'icon' => 'bi-file-earmark-check',
                'active' => in_array($order->status, [
                    'delivered',
                    'revision',
                    'completed',
                ]),
            ],

            [
                'label' => 'Selesai',
                'description' => 'Client menyetujui hasil pekerjaan dan order selesai.',
                'icon' => 'bi-check-lg',
                'active' => $order->status === 'completed',
            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | WORKSPACE MESSAGE
        |--------------------------------------------------------------------------
        */

        $workspaceMessage = match($order->status) {

            'pending_payment' =>
                'Order ini belum dapat dikerjakan karena pembayaran client belum selesai.',

            'paid' =>
                'Pembayaran sudah diterima. Kamu dapat mulai mengerjakan pesanan ini.',

            'in_progress' =>
                'Kerjakan pesanan sesuai brief client dan deadline yang tersedia.',

            'delivered' =>
                'Hasil pekerjaan sudah dikirim dan sedang menunggu pemeriksaan client.',

            'revision' =>
                'Client meminta revisi. Perbaiki hasil pekerjaan lalu kirim kembali delivery terbaru.',

            'completed' =>
                'Order ini sudah selesai. Terima kasih sudah menyelesaikan pekerjaan.',

            'cancelled' =>
                'Order ini sudah dibatalkan.',

            default =>
                'Periksa detail order sebelum melanjutkan.',

        };


        /*
        |--------------------------------------------------------------------------
        | DELIVERY HISTORY
        |--------------------------------------------------------------------------
        */

        $deliveryCount = $order->deliveries?->count() ?? 0;

    @endphp


    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 sm:py-7 lg:px-8 lg:py-8">


            {{-- =========================================================
                TOP BAR
            ========================================================== --}}
            <div class="mb-5 flex items-center justify-between gap-3">

                <a
                    href="{{ route('freelancer.orders.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl px-2 py-2 text-xs font-semibold text-slate-500 transition hover:bg-white hover:text-blue-600"
                >
                    <i class="bi bi-arrow-left text-xs"></i>
                    <span>Kembali ke order</span>
                </a>

                <span class="truncate text-[10px] font-medium text-slate-400">
                    #{{ $order->order_number }}
                </span>

            </div>


            {{-- =========================================================
                ALERT SUCCESS
            ========================================================== --}}
            @if(session('success'))

                <div class="mb-4 rounded-2xl border border-emerald-200 bg-white shadow-sm">

                    <div class="flex items-center gap-3 px-4 py-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <i class="bi bi-check-lg text-sm"></i>
                        </div>

                        <p class="text-xs font-medium text-slate-700 sm:text-sm">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                ALERT ERROR
            ========================================================== --}}
            @if(session('error'))

                <div class="mb-4 rounded-2xl border border-rose-200 bg-white shadow-sm">

                    <div class="flex items-center gap-3 px-4 py-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                            <i class="bi bi-exclamation-lg text-sm"></i>
                        </div>

                        <p class="text-xs font-medium text-rose-700 sm:text-sm">
                            {{ session('error') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                VALIDATION ERRORS
            ========================================================== --}}
            @if($errors->any())

                <div class="mb-4 rounded-2xl border border-rose-200 bg-white shadow-sm">

                    <div class="px-4 py-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                                <i class="bi bi-exclamation-lg text-sm"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-xs font-bold text-rose-700">
                                    Terdapat kesalahan pada form.
                                </p>

                                <div class="mt-1 space-y-0.5">

                                    @foreach($errors->all() as $error)

                                        <p class="text-[11px] leading-5 text-rose-600">
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
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="p-4 sm:p-5 lg:p-6">

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Information --}}
                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-[9px] font-semibold text-slate-500">
                                    <i class="bi bi-hash text-[8px]"></i>
                                    {{ $order->order_number }}
                                </span>

                                <span class="text-[10px] text-slate-400">
                                    {{ $order->created_at?->format('d M Y, H:i') }}
                                </span>

                            </div>

                            <h1 class="mt-2 text-lg font-bold leading-6 tracking-tight text-slate-900 sm:text-xl">
                                {{ $serviceTitle }}
                            </h1>

                            <div class="mt-3 flex flex-wrap gap-x-4 gap-y-2">

                                <span class="inline-flex items-center gap-1.5 text-[10px] text-slate-500">
                                    <i class="bi bi-person text-blue-600"></i>
                                    {{ $clientName }}
                                </span>

                                <span class="inline-flex items-center gap-1.5 text-[10px] text-slate-500">
                                    <i class="bi bi-clock text-blue-600"></i>
                                    {{ $order->delivery_days }} hari
                                </span>

                                @if($order->due_at)

                                    <span class="inline-flex items-center gap-1.5 text-[10px] text-slate-500">
                                        <i class="bi bi-calendar-event text-blue-600"></i>
                                        {{ $order->due_at->format('d M Y') }}
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="shrink-0 self-start lg:self-center">

                            <span
                                class="inline-flex items-center gap-1.5 rounded-full border px-3 py-2 text-[9px] font-bold sm:text-[10px] {{ $statusConfig['class'] }}"
                            >
                                <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>

                                <i class="bi {{ $statusConfig['icon'] }} text-[9px]"></i>

                                {{ $statusConfig['label'] }}
                            </span>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                WORKSPACE STATUS
            ========================================================== --}}
            <section class="mt-3 rounded-2xl border border-blue-100 bg-blue-50/60">

                <div class="p-4 sm:p-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                            <i class="bi bi-kanban text-sm"></i>
                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex flex-wrap items-center gap-2">

                                <p class="text-xs font-bold text-slate-800">
                                    Workspace order
                                </p>

                                @if($order->status === 'paid')

                                    <span class="rounded-full bg-blue-100 px-2.5 py-1 text-[9px] font-bold text-blue-700">
                                        Siap dikerjakan
                                    </span>

                                @elseif($order->status === 'in_progress')

                                    <span class="rounded-full bg-indigo-100 px-2.5 py-1 text-[9px] font-bold text-indigo-700">
                                        Sedang dikerjakan
                                    </span>

                                @elseif($order->status === 'delivered')

                                    <span class="rounded-full bg-orange-100 px-2.5 py-1 text-[9px] font-bold text-orange-700">
                                        Menunggu client
                                    </span>

                                @elseif($order->status === 'revision')

                                    <span class="rounded-full bg-violet-100 px-2.5 py-1 text-[9px] font-bold text-violet-700">
                                        Revisi diperlukan
                                    </span>

                                @elseif($order->status === 'completed')

                                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[9px] font-bold text-emerald-700">
                                        Order selesai
                                    </span>

                                @endif

                            </div>

                            <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                {{ $workspaceMessage }}
                            </p>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                DISPUTE
            ========================================================== --}}
            @if($activeDispute)

                <section class="mt-3 rounded-2xl border border-violet-200 bg-violet-50/60">

                    <div class="p-4 sm:p-5">

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex min-w-0 items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-violet-600 shadow-sm">
                                    <i class="bi bi-shield-exclamation text-sm"></i>
                                </div>

                                <div class="min-w-0">

                                    <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-violet-600">
                                        Dispute Order
                                    </p>

                                    @if($activeDispute->opened_by_role === 'client')

                                        <h2 class="mt-1 text-xs font-bold text-slate-800 sm:text-sm">
                                            Client mengajukan dispute
                                        </h2>

                                        <p class="mt-1 text-[11px] leading-5 text-violet-700/80">
                                            Ada pengajuan sengketa yang perlu kamu tanggapi.
                                        </p>

                                    @else

                                        <h2 class="mt-1 text-xs font-bold text-slate-800 sm:text-sm">
                                            Dispute sedang diproses
                                        </h2>

                                        <p class="mt-1 text-[11px] leading-5 text-violet-700/80">
                                            Proses penyelesaian sengketa sedang berjalan.
                                        </p>

                                    @endif

                                </div>

                            </div>


                            <a
                                href="{{ route('freelancer.disputes.show', $activeDispute) }}"
                                class="inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-xl bg-white px-3.5 text-[10px] font-bold text-violet-700 shadow-sm ring-1 ring-violet-200 transition hover:bg-violet-50"
                            >
                                <i class="bi bi-eye"></i>

                                @if($activeDispute->opened_by_role === 'client')
                                    Tinjau Dispute
                                @else
                                    Lihat Dispute
                                @endif

                                <i class="bi bi-arrow-right text-[9px]"></i>
                            </a>

                        </div>

                    </div>

                </section>

            @elseif(
                in_array(
                    $order->status,
                    ['paid', 'in_progress', 'delivered', 'revision'],
                    true
                )
            )

                <section class="mt-3 rounded-2xl border border-amber-200 bg-amber-50/60">

                    <div class="p-4 sm:p-5">

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex min-w-0 items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm">
                                    <i class="bi bi-shield-plus text-sm"></i>
                                </div>

                                <div class="min-w-0">

                                    <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-amber-600">
                                        Bantuan Sengketa
                                    </p>

                                    <h2 class="mt-1 text-xs font-bold text-slate-800 sm:text-sm">
                                        Ada masalah dengan order?
                                    </h2>

                                    <p class="mt-1 text-[11px] leading-5 text-amber-800/75">
                                        Kamu dapat mengajukan dispute jika ada masalah dengan order.
                                    </p>

                                </div>

                            </div>


                            <a
                                href="{{ route('freelancer.orders.dispute.create', $order) }}"
                                class="inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-xl border border-amber-200 bg-white px-3.5 text-[10px] font-bold text-amber-700 transition hover:bg-amber-50"
                            >
                                <i class="bi bi-shield-exclamation"></i>
                                Ajukan Dispute
                            </a>

                        </div>

                    </div>

                </section>

            @endif


            {{-- =========================================================
                MAIN GRID
            ========================================================== --}}
            <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1fr)_300px]">


                {{-- =====================================================
                    LEFT COLUMN
                ====================================================== --}}
                <div class="min-w-0 space-y-4">


                    {{-- =================================================
                        ORDER ITEMS
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="flex items-center justify-between border-b border-slate-100 px-4 py-4 sm:px-5">

                            <div>

                                <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                                    Order
                                </p>

                                <h2 class="mt-1 text-sm font-bold text-slate-900">
                                    Detail pesanan
                                </h2>

                            </div>

                            <span class="text-[10px] font-medium text-slate-400">
                                {{ $order->items->count() }} item
                            </span>

                        </div>


                        <div class="divide-y divide-slate-100">

                            @foreach($order->items as $item)

                                <div class="flex items-center gap-3 px-4 py-3.5 sm:px-5">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                        <i class="bi bi-briefcase text-xs"></i>
                                    </div>

                                    <div class="min-w-0 flex-1">

                                        <p class="truncate text-xs font-bold text-slate-800">
                                            {{ $item->service_title }}
                                        </p>

                                        <p class="mt-0.5 text-[10px] text-slate-400">
                                            {{ $item->quantity }} ×
                                            Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                                        </p>

                                    </div>

                                    <p class="shrink-0 text-xs font-bold text-slate-800">
                                        Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                    </p>

                                </div>

                            @endforeach

                        </div>

                    </section>


                    {{-- =================================================
                        BRIEF
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

                        <div>

                            <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                                Brief Client
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-slate-900">
                                Kebutuhan pekerjaan
                            </h2>

                        </div>


                        @if($order->requirements)

                            <div class="mt-4 rounded-xl bg-slate-50 px-3.5 py-3.5">

                                <p class="whitespace-pre-line text-xs leading-6 text-slate-600">
                                    {{ $order->requirements }}
                                </p>

                            </div>

                        @else

                            <div class="mt-4 rounded-xl border border-dashed border-slate-200 px-4 py-6 text-center">

                                <i class="bi bi-file-text text-lg text-slate-300"></i>

                                <p class="mt-2 text-[11px] text-slate-400">
                                    Client belum menambahkan brief khusus.
                                </p>

                            </div>

                        @endif

                    </section>


                    {{-- =================================================
                        REVISION REQUEST
                    ================================================== --}}
                    @if($order->status === 'revision')

                        @php

                            $revisionDelivery =
                                $order->deliveries?->firstWhere('status', 'revision');

                            $revisionText =
                                $revisionDelivery?->message;

                            if (
                                $revisionText &&
                                str_starts_with(
                                    $revisionText,
                                    'PERMINTAAN REVISI CLIENT:'
                                )
                            ) {
                                $revisionText = trim(
                                    str_replace(
                                        'PERMINTAAN REVISI CLIENT:',
                                        '',
                                        $revisionText
                                    )
                                );
                            }

                        @endphp

                        @if($revisionDelivery)

                            <section class="rounded-2xl border border-violet-200 bg-violet-50/60">

                                <div class="p-4 sm:p-5">

                                    <div class="flex items-start gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-violet-600 shadow-sm">
                                            <i class="bi bi-arrow-repeat text-sm"></i>
                                        </div>

                                        <div class="min-w-0 flex-1">

                                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                                <div>

                                                    <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-violet-600">
                                                        Permintaan revisi
                                                    </p>

                                                    <h2 class="mt-1 text-sm font-bold text-slate-900">
                                                        Client meminta perbaikan
                                                    </h2>

                                                </div>

                                                <span class="inline-flex w-fit rounded-full bg-violet-100 px-2.5 py-1 text-[9px] font-bold text-violet-700">
                                                    Perlu revisi
                                                </span>

                                            </div>


                                            <div class="mt-3 rounded-xl border border-violet-100 bg-white px-3.5 py-3.5">

                                                <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                                    Catatan client
                                                </p>

                                                @if($revisionText)

                                                    <p class="mt-2 whitespace-pre-line text-xs leading-6 text-slate-600">
                                                        {{ $revisionText }}
                                                    </p>

                                                @else

                                                    <p class="mt-2 text-[11px] text-slate-400">
                                                        Client belum menambahkan catatan revisi.
                                                    </p>

                                                @endif

                                            </div>


                                            <p class="mt-2 text-[10px] text-slate-400">
                                                <i class="bi bi-calendar-event mr-1"></i>
                                                Diperbarui
                                                {{ $revisionDelivery->updated_at?->format('d M Y, H:i') ?? $revisionDelivery->created_at?->format('d M Y, H:i') }}
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </section>

                        @endif

                    @endif


                    {{-- =================================================
                        DELIVERY FORM
                    ================================================== --}}
                    @if(in_array($order->status, ['paid', 'in_progress', 'revision']))

                        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                            <div class="border-b border-slate-100 px-4 py-4 sm:px-5">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                                        @if($order->status === 'revision')
                                            <i class="bi bi-arrow-repeat text-sm"></i>
                                        @else
                                            <i class="bi bi-file-earmark-arrow-up text-sm"></i>
                                        @endif

                                    </div>

                                    <div>

                                        <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-blue-600">

                                            @if($order->status === 'revision')
                                                Hasil Revisi
                                            @else
                                                Delivery
                                            @endif

                                        </p>

                                        <h2 class="mt-1 text-sm font-bold text-slate-900">

                                            @if($order->status === 'revision')
                                                Kirim hasil revisi
                                            @else
                                                Kirim hasil pekerjaan
                                            @endif

                                        </h2>

                                        <p class="mt-1 text-[11px] leading-5 text-slate-500">

                                            @if($order->status === 'revision')
                                                Perbaiki pekerjaan sesuai permintaan client kemudian kirim hasil terbaru.
                                            @else
                                                Kirim hasil pekerjaan melalui file, link, atau catatan.
                                            @endif

                                        </p>

                                    </div>

                                </div>

                            </div>


                            <form
                                action="{{ route('freelancer.orders.delivery.store', $order) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                class="p-4 sm:p-5"
                            >

                                @csrf


                                {{-- DELIVERY ERROR --}}
                                @if($errors->has('delivery'))

                                    <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-3.5 py-3">

                                        <div class="flex items-start gap-2.5">

                                            <i class="bi bi-exclamation-circle mt-0.5 text-sm text-rose-500"></i>

                                            <p class="text-[11px] leading-5 text-rose-600">
                                                {{ $errors->first('delivery') }}
                                            </p>

                                        </div>

                                    </div>

                                @endif


                                {{-- MESSAGE --}}
                                <div>

                                    <label
                                        for="delivery-message"
                                        class="text-xs font-bold text-slate-700"
                                    >
                                        Catatan untuk client
                                        <span class="font-normal text-slate-400">
                                            (opsional)
                                        </span>
                                    </label>

                                    <textarea
                                        id="delivery-message"
                                        name="message"
                                        rows="5"
                                        maxlength="5000"
                                        placeholder="Jelaskan hasil pekerjaan yang kamu kirim..."
                                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-3 text-xs leading-6 text-slate-700 outline-none placeholder:text-slate-400 transition focus:border-blue-300 focus:bg-white focus:ring-2 focus:ring-blue-100"
                                    >{{ old('message') }}</textarea>

                                    @error('message')

                                        <p class="mt-1.5 text-[11px] text-rose-600">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                    <p class="mt-1 text-right text-[9px] text-slate-400">
                                        Maksimal 5000 karakter
                                    </p>

                                </div>


                                {{-- EXTERNAL LINK --}}
                                <div class="mt-4">

                                    <label
                                        for="delivery-link"
                                        class="text-xs font-bold text-slate-700"
                                    >
                                        Link hasil pekerjaan
                                        <span class="font-normal text-slate-400">
                                            (opsional)
                                        </span>
                                    </label>

                                    <div class="relative mt-2">

                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex w-10 items-center justify-center text-slate-400">
                                            <i class="bi bi-link-45deg"></i>
                                        </div>

                                        <input
                                            id="delivery-link"
                                            type="url"
                                            name="external_link"
                                            value="{{ old('external_link') }}"
                                            maxlength="2048"
                                            placeholder="https://drive.google.com/..."
                                            class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3 text-xs text-slate-700 outline-none placeholder:text-slate-400 transition focus:border-blue-300 focus:bg-white focus:ring-2 focus:ring-blue-100"
                                        >

                                    </div>

                                    @error('external_link')

                                        <p class="mt-1.5 text-[11px] text-rose-600">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- FILE --}}
                                <div class="mt-4">

                                    <label
                                        for="delivery-file"
                                        class="text-xs font-bold text-slate-700"
                                    >
                                        File hasil pekerjaan
                                        <span class="font-normal text-slate-400">
                                            (opsional)
                                        </span>
                                    </label>


                                    <label
                                        for="delivery-file"
                                        class="mt-2 flex cursor-pointer items-center gap-3 rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-4 transition hover:border-blue-300 hover:bg-blue-50/50"
                                    >

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                            <i class="bi bi-cloud-arrow-up text-base"></i>
                                        </div>

                                        <div class="min-w-0">

                                            <p class="text-xs font-bold text-slate-700">
                                                Pilih file hasil
                                            </p>

                                            <p class="mt-0.5 text-[10px] text-slate-400">
                                                Maksimal 10 MB
                                            </p>

                                        </div>

                                        <input
                                            id="delivery-file"
                                            type="file"
                                            name="file"
                                            class="hidden"
                                        >

                                    </label>


                                    <p
                                        id="selected-file"
                                        class="mt-2 hidden break-all text-[10px] font-medium text-blue-600"
                                    ></p>


                                    @error('file')

                                        <p class="mt-1.5 text-[11px] text-rose-600">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- INFO --}}
                                <div class="mt-4 rounded-xl border border-blue-100 bg-blue-50/60 px-3.5 py-3">

                                    <div class="flex items-start gap-2.5">

                                        <i class="bi bi-info-circle mt-0.5 text-sm text-blue-600"></i>

                                        <p class="text-[10px] leading-5 text-slate-600">

                                            Isi minimal salah satu:
                                            <span class="font-bold text-slate-700">catatan</span>,
                                            <span class="font-bold text-slate-700">link</span>,
                                            atau
                                            <span class="font-bold text-slate-700">file</span>.

                                            Setelah dikirim, client akan menerima hasil untuk diperiksa.

                                        </p>

                                    </div>

                                </div>


                                {{-- SUBMIT --}}
                                <div class="mt-5">

                                    <button
                                        type="submit"
                                        class="inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-xs font-bold text-white shadow-sm transition hover:bg-blue-700 sm:w-auto sm:min-w-[150px]"
                                    >

                                        @if($order->status === 'revision')

                                            <i class="bi bi-arrow-repeat"></i>
                                            Kirim Hasil Revisi

                                        @else

                                            <i class="bi bi-send"></i>
                                            Kirim Delivery

                                        @endif

                                    </button>

                                </div>

                            </form>

                        </section>

                    @endif


                    {{-- =================================================
                        DELIVERY WAITING CLIENT
                    ================================================== --}}
                    @if($order->status === 'delivered')

                        <section class="rounded-2xl border border-orange-200 bg-orange-50/70">

                            <div class="p-4 sm:p-5">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-orange-600 shadow-sm">
                                        <i class="bi bi-hourglass-split text-sm"></i>
                                    </div>

                                    <div>

                                        <p class="text-xs font-bold text-orange-800">
                                            Delivery sedang diperiksa client
                                        </p>

                                        <p class="mt-1 text-[11px] leading-5 text-orange-900/70">
                                            Hasil pekerjaan sudah dikirim. Tunggu client menyetujui hasil atau mengirim permintaan revisi.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </section>

                    @endif


                    {{-- =================================================
                        DELIVERY HISTORY
                    ================================================== --}}
                    @if($deliveryCount > 0)

                        <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

                            <div class="flex items-center justify-between gap-3">

                                <div>

                                    <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                                        Riwayat
                                    </p>

                                    <h2 class="mt-1 text-sm font-bold text-slate-900">
                                        Riwayat delivery
                                    </h2>

                                </div>

                                <span class="text-[10px] font-medium text-slate-400">
                                    {{ $deliveryCount }} delivery
                                </span>

                            </div>


                            <div class="mt-4 space-y-2.5">

                                @foreach($order->deliveries as $delivery)

                                    @php

                                        $deliveryLabel = match($delivery->status) {

                                            'submitted' =>
                                                'Menunggu pemeriksaan client',

                                            'approved' =>
                                                'Disetujui client',

                                            'revision' =>
                                                'Memerlukan revisi',

                                            'rejected' =>
                                                'Ditolak',

                                            default =>
                                                ucfirst($delivery->status),

                                        };


                                        $deliveryClass = match($delivery->status) {

                                            'submitted' =>
                                                'bg-amber-50 text-amber-700',

                                            'approved' =>
                                                'bg-emerald-50 text-emerald-700',

                                            'revision' =>
                                                'bg-violet-50 text-violet-700',

                                            'rejected' =>
                                                'bg-rose-50 text-rose-700',

                                            default =>
                                                'bg-slate-100 text-slate-600',

                                        };


                                        $deliveryIcon = match($delivery->status) {

                                            'submitted' =>
                                                'bi-hourglass-split',

                                            'approved' =>
                                                'bi-check-circle-fill',

                                            'revision' =>
                                                'bi-arrow-repeat',

                                            'rejected' =>
                                                'bi-x-circle-fill',

                                            default =>
                                                'bi-file-earmark',

                                        };

                                    @endphp


                                    <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-3">

                                        <div class="flex items-start gap-3">

                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm">
                                                <i class="bi {{ $deliveryIcon }} text-xs"></i>
                                            </div>

                                            <div class="min-w-0 flex-1">

                                                <div class="flex flex-col gap-1.5 sm:flex-row sm:items-center sm:justify-between">

                                                    <div>

                                                        <p class="text-xs font-bold text-slate-700">
                                                            Delivery #{{ $deliveryCount - $loop->index }}
                                                        </p>

                                                        <p class="mt-0.5 text-[10px] text-slate-400">
                                                            {{ $delivery->submitted_at?->format('d M Y, H:i') ?? $delivery->created_at?->format('d M Y, H:i') }}
                                                        </p>

                                                    </div>


                                                    <span class="inline-flex w-fit rounded-full px-2 py-1 text-[8px] font-bold {{ $deliveryClass }}">
                                                        {{ $deliveryLabel }}
                                                    </span>

                                                </div>


                                                @if($delivery->message)

                                                    <div class="mt-2 rounded-lg bg-white px-3 py-2.5">

                                                        <p class="whitespace-pre-line text-[11px] leading-5 text-slate-600">
                                                            {{ $delivery->message }}
                                                        </p>

                                                    </div>

                                                @endif


                                                <div class="mt-2 flex flex-wrap gap-2">

                                                    @if($delivery->file_path)

                                                        <a
                                                            href="{{ asset('storage/' . $delivery->file_path) }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="inline-flex max-w-full items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-[9px] font-bold text-blue-600 transition hover:bg-blue-50"
                                                        >

                                                            <i class="bi bi-file-earmark-arrow-down shrink-0"></i>

                                                            <span class="max-w-[200px] truncate">
                                                                {{ $delivery->file_name ?? 'Lihat file' }}
                                                            </span>

                                                        </a>

                                                    @endif


                                                    @if($delivery->external_link)

                                                        <a
                                                            href="{{ $delivery->external_link }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-[9px] font-bold text-slate-600 transition hover:bg-slate-100"
                                                        >

                                                            <i class="bi bi-box-arrow-up-right"></i>
                                                            Buka link

                                                        </a>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </section>

                    @endif


                    {{-- =================================================
                        TIMELINE
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

                        <div>

                            <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                                Timeline
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-slate-900">
                                Perjalanan order
                            </h2>

                        </div>


                        <div class="relative mt-5">

                            <div class="absolute bottom-5 left-4 top-5 w-px bg-slate-200"></div>


                            <div class="space-y-5">

                                @foreach($timeline as $step)

                                    <div class="relative flex gap-3.5">

                                        <div
                                            class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full border
                                            {{ $step['active']
                                                ? 'border-blue-200 bg-blue-50 text-blue-600'
                                                : 'border-slate-200 bg-white text-slate-300' }}"
                                        >
                                            <i class="bi {{ $step['icon'] }} text-[11px]"></i>
                                        </div>


                                        <div class="pt-0.5">

                                            <p
                                                class="text-xs font-bold
                                                {{ $step['active']
                                                    ? 'text-slate-800'
                                                    : 'text-slate-400' }}"
                                            >
                                                {{ $step['label'] }}
                                            </p>

                                            <p class="mt-1 max-w-lg text-[10px] leading-5 text-slate-400">
                                                {{ $step['description'] }}
                                            </p>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </section>

                </div>


                {{-- =====================================================
                    RIGHT COLUMN
                ====================================================== --}}
                <aside class="space-y-4">


                    {{-- =================================================
                        QUICK ACTION
                    ================================================== --}}
                    <section class="rounded-2xl border border-blue-100 bg-blue-50/70 p-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                                <i class="bi bi-chat-dots text-sm"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-blue-600">
                                    Komunikasi
                                </p>

                                <h2 class="mt-1 text-xs font-bold text-slate-800">
                                    Hubungi client
                                </h2>

                            </div>

                        </div>


                        <p class="mt-3 text-[10px] leading-5 text-slate-500">
                            Bahas brief, progres pekerjaan, atau hasil delivery bersama client.
                        </p>


                        @if($order->conversation)

                            <a
                                href="{{ route('freelancer.messages.show', $order->conversation) }}"
                                class="mt-3 flex h-9 w-full items-center justify-center gap-2 rounded-xl bg-white px-3 text-[10px] font-bold text-blue-700 shadow-sm transition hover:bg-blue-100"
                            >
                                Chat terkait order
                                <i class="bi bi-arrow-right text-[9px]"></i>
                            </a>

                        @else

                            <a
                                href="{{ route('freelancer.messages.index') }}"
                                class="mt-3 flex h-9 w-full items-center justify-center gap-2 rounded-xl bg-white px-3 text-[10px] font-bold text-blue-700 shadow-sm transition hover:bg-blue-100"
                            >
                                Buka pesan
                                <i class="bi bi-arrow-right text-[9px]"></i>
                            </a>

                        @endif

                    </section>


                    {{-- =================================================
                        PAYMENT SUMMARY
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

                        <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                            Nilai Order
                        </p>

                        <h2 class="mt-1 text-sm font-bold text-slate-900">
                            Ringkasan pembayaran
                        </h2>


                        <div class="mt-4 space-y-3">

                            <div class="flex items-center justify-between gap-3">

                                <span class="text-[11px] text-slate-500">
                                    Subtotal
                                </span>

                                <span class="text-xs font-semibold text-slate-700">
                                    Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between gap-3">

                                <span class="text-[11px] text-slate-500">
                                    Biaya platform
                                </span>

                                <span class="text-xs font-semibold text-slate-700">
                                    Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between gap-3">

                                <span class="text-[11px] font-semibold text-slate-600">
                                    Pendapatan freelancer
                                </span>

                                <span class="text-xs font-bold text-blue-600">
                                    Rp {{ number_format((float) $order->freelancer_amount, 0, ',', '.') }}
                                </span>

                            </div>


                            <div class="border-t border-slate-100 pt-3">

                                <div class="flex items-center justify-between gap-3">

                                    <span class="text-xs font-bold text-slate-700">
                                        Total order
                                    </span>

                                    <span class="text-base font-bold text-slate-900">
                                        Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        DEADLINE
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

                        <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                            Pengerjaan
                        </p>

                        <h2 class="mt-1 text-sm font-bold text-slate-900">
                            Deadline order
                        </h2>


                        <div class="mt-4 space-y-3">

                            <div class="flex items-center gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi bi-calendar-event text-xs"></i>
                                </div>

                                <div class="min-w-0">

                                    <p class="text-[10px] text-slate-400">
                                        Batas pengerjaan
                                    </p>

                                    <p class="mt-0.5 truncate text-xs font-bold text-slate-700">
                                        {{ $order->due_at?->format('d M Y, H:i') ?? '-' }}
                                    </p>

                                </div>

                            </div>


                            <div class="flex items-center gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi bi-clock text-xs"></i>
                                </div>

                                <div>

                                    <p class="text-[10px] text-slate-400">
                                        Durasi
                                    </p>

                                    <p class="mt-0.5 text-xs font-bold text-slate-700">
                                        {{ $order->delivery_days }} hari
                                    </p>

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        PAYMENT STATUS
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

                        <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                            Pembayaran
                        </p>

                        <h2 class="mt-1 text-sm font-bold text-slate-900">
                            Status pembayaran
                        </h2>


                        @if($order->payment)

                            <div class="mt-4 space-y-3">

                                <div class="flex items-center justify-between gap-3">

                                    <span class="text-[11px] text-slate-500">
                                        Status
                                    </span>


                                    @if($order->payment->status === 'paid')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[9px] font-bold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Lunas
                                        </span>

                                    @elseif($order->payment->status === 'pending')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[9px] font-bold text-amber-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Menunggu pembayaran
                                        </span>

                                    @else

                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[9px] font-bold text-slate-600">
                                            {{ ucfirst($order->payment->status) }}
                                        </span>

                                    @endif

                                </div>


                                <div class="flex items-center justify-between gap-3">

                                    <span class="text-[11px] text-slate-500">
                                        Metode
                                    </span>

                                    <span class="max-w-[150px] truncate text-right text-[10px] font-bold text-slate-700">
                                        {{ strtoupper($order->payment->payment_type ?? '-') }}
                                    </span>

                                </div>

                            </div>

                        @else

                            <div class="mt-4 rounded-xl border border-dashed border-slate-200 px-4 py-5 text-center">

                                <i class="bi bi-credit-card text-lg text-slate-300"></i>

                                <p class="mt-2 text-[10px] text-slate-400">
                                    Data pembayaran belum tersedia.
                                </p>

                            </div>

                        @endif

                    </section>


                    {{-- =================================================
                        REVIEW
                    ================================================== --}}
                    @if($order->review)

                        <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

                            <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600">
                                Review
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-slate-900">
                                Penilaian client
                            </h2>


                            <div class="mt-3 flex items-center gap-2">

                                <div class="flex items-center gap-0.5">

                                    @for($i = 1; $i <= 5; $i++)

                                        <i
                                            class="bi bi-star-fill text-[11px]
                                            {{ $i <= $order->review->rating
                                                ? 'text-amber-400'
                                                : 'text-slate-200' }}"
                                        ></i>

                                    @endfor

                                </div>


                                <span class="text-xs font-bold text-slate-700">
                                    {{ $order->review->rating }}/5
                                </span>

                            </div>


                            @if($order->review->comment)

                                <div class="mt-3 rounded-xl bg-slate-50 px-3.5 py-3">

                                    <p class="whitespace-pre-line text-[11px] leading-5 text-slate-600">
                                        "{{ $order->review->comment }}"
                                    </p>

                                </div>

                            @endif

                        </section>

                    @endif

                </aside>

            </div>

        </div>

    </div>


    {{-- ==============================================================
        FILE PICKER SCRIPT
    ============================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const fileInput =
                document.getElementById('delivery-file');

            const selectedFile =
                document.getElementById('selected-file');


            if (!fileInput || !selectedFile) {
                return;
            }


            fileInput.addEventListener('change', function () {

                if (this.files && this.files.length > 0) {

                    const file = this.files[0];

                    const sizeInMb =
                        file.size / (1024 * 1024);


                    if (sizeInMb > 10) {

                        selectedFile.textContent =
                            'File terlalu besar. Maksimal 10 MB.';

                        selectedFile.classList.remove(
                            'hidden'
                        );

                        selectedFile.classList.remove(
                            'text-blue-600'
                        );

                        selectedFile.classList.add(
                            'text-rose-600'
                        );

                        this.value = '';

                        return;
                    }


                    selectedFile.textContent =
                        'File dipilih: ' + file.name;

                    selectedFile.classList.remove(
                        'hidden'
                    );

                    selectedFile.classList.remove(
                        'text-rose-600'
                    );

                    selectedFile.classList.add(
                        'text-blue-600'
                    );

                } else {

                    selectedFile.textContent = '';

                    selectedFile.classList.add(
                        'hidden'
                    );

                }

            });

        });

    </script>

</x-layouts.freelancer>