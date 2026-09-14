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
    | ORDER STATUS
    |--------------------------------------------------------------------------
    */

    $statusConfig = match($order->status) {

        'pending_payment' => [
            'label' => 'Menunggu pembayaran',
            'class' => 'border-[#F2DDAF] bg-[#FFF9EA] text-[#9A6800]',
            'dot' => 'bg-[#D99A19]',
            'icon' => 'bi-credit-card',
        ],

        'paid' => [
            'label' => 'Siap dikerjakan',
            'class' => 'border-[#CFE0F1] bg-[#F3F8FC] text-[#3C6F9F]',
            'dot' => 'bg-[#5B91C0]',
            'icon' => 'bi-check-circle',
        ],

        'in_progress' => [
            'label' => 'Sedang dikerjakan',
            'class' => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',
            'dot' => 'bg-[#35C978]',
            'icon' => 'bi-arrow-repeat',
        ],

        'delivered' => [
            'label' => 'Menunggu pemeriksaan client',
            'class' => 'border-[#E7D9C8] bg-[#FFF8EF] text-[#A96B20]',
            'dot' => 'bg-[#D48A32]',
            'icon' => 'bi-file-earmark-check',
        ],

        'revision' => [
            'label' => 'Dalam revisi',
            'class' => 'border-[#E8D8ED] bg-[#FAF4FC] text-[#895597]',
            'dot' => 'bg-[#B77BC7]',
            'icon' => 'bi-arrow-repeat',
        ],

        'completed' => [
            'label' => 'Selesai',
            'class' => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',
            'dot' => 'bg-[#35C978]',
            'icon' => 'bi-check-circle-fill',
        ],

        'cancelled' => [
            'label' => 'Dibatalkan',
            'class' => 'border-[#F0D5D5] bg-[#FFF6F6] text-[#B84E4E]',
            'dot' => 'bg-[#D16B6B]',
            'icon' => 'bi-x-circle',
        ],

        default => [
            'label' => ucfirst(str_replace('_', ' ', $order->status)),
            'class' => 'border-[#E1E7E3] bg-[#F7F9F8] text-[#66766E]',
            'dot' => 'bg-[#A3AEA9]',
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


<div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">

    <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">


        {{-- =========================================================
            TOP BAR
        ========================================================== --}}

        <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <a
                href="{{ route('freelancer.orders.index') }}"
                class="inline-flex w-fit items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
            >

                <i class="bi bi-arrow-left text-[12px]"></i>

                Kembali ke order

            </a>


            <span class="text-[10px] text-[#99A59F]">

                Order {{ $order->order_number }}

            </span>

        </div>


        {{-- =========================================================
            ALERT SUCCESS
        ========================================================== --}}

        @if(session('success'))

            <div class="mb-5 rounded-xl border border-[#CDE8D7] bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

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

            <div class="mb-5 rounded-xl border border-red-100 bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

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

            <div class="mb-5 rounded-xl border border-red-100 bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

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


                        <h1 class="mt-4 max-w-4xl text-xl font-semibold leading-8 tracking-[-0.03em] text-[#123128] sm:text-2xl">

                            {{ $serviceTitle }}

                        </h1>


                        <div class="mt-4 flex flex-wrap gap-x-5 gap-y-2">

                            <span class="inline-flex items-center gap-1.5 text-[10px] text-[#7F8F87]">

                                <i class="bi bi-person text-[#1E9E5A]"></i>

                                Client:
                                {{ $clientName }}

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
            WORKSPACE STATUS
        ========================================================== --}}

        <section class="mt-5 overflow-hidden rounded-2xl border border-[#DCE9E1] bg-white">

            <div class="px-5 py-5 sm:px-6">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">


                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">

                            <i class="bi bi-kanban text-[15px]"></i>

                        </div>


                        <div>

                            <p class="text-xs font-semibold text-[#123128]">
                                Workspace order
                            </p>


                            <p class="mt-1 max-w-2xl text-xs leading-5 text-[#71837B]">

                                {{ $workspaceMessage }}

                            </p>

                        </div>

                    </div>


                    @if($order->status === 'paid')

                        <span class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-4 py-2.5 text-[10px] font-semibold text-white">

                            <i class="bi bi-play-fill"></i>

                            Siap dikerjakan

                        </span>

                    @elseif($order->status === 'in_progress')

                        <span class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#CDE7D7] bg-[#F2FBF5] px-4 py-2.5 text-[10px] font-semibold text-[#168A4D]">

                            <i class="bi bi-arrow-repeat"></i>

                            Sedang dikerjakan

                        </span>

                    @elseif($order->status === 'delivered')

                        <span class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#F2DDB5] bg-[#FFF9EA] px-4 py-2.5 text-[10px] font-semibold text-[#9A6800]">

                            <i class="bi bi-hourglass-split"></i>

                            Menunggu client

                        </span>

                    @elseif($order->status === 'revision')

                        <span class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#E8D8ED] bg-[#FAF4FC] px-4 py-2.5 text-[10px] font-semibold text-[#895597]">

                            <i class="bi bi-arrow-repeat"></i>

                            Revisi diperlukan

                        </span>

                    @elseif($order->status === 'completed')

                        <span class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#CDE7D7] bg-[#F2FBF5] px-4 py-2.5 text-[10px] font-semibold text-[#168A4D]">

                            <i class="bi bi-check-circle-fill"></i>

                            Order selesai

                        </span>

                    @endif

                </div>

            </div>

        </section>


        {{-- =========================================================
            MAIN GRID
        ========================================================== --}}

        <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_340px]">


            {{-- =====================================================
                LEFT COLUMN
            ====================================================== --}}

            <div class="space-y-5">


                {{-- =================================================
                    CLIENT
                ================================================== --}}

                <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                Client
                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                Pemesan jasa
                            </h2>

                        </div>


                        <i class="bi bi-person-check text-[#A0ADA7]"></i>

                    </div>


                    <div class="mt-5 flex items-center justify-between gap-4">

                        <div class="flex min-w-0 items-center gap-3">

                            <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A]">

                                @if($clientAvatar)

                                    <img
                                        src="{{ $clientAvatar }}"
                                        alt="{{ $clientName }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    {{ $clientInitial }}

                                @endif

                            </div>


                            <div class="min-w-0">

                                <p class="truncate text-sm font-semibold text-[#18382E]">

                                    {{ $clientName }}

                                </p>


                                <p class="mt-0.5 text-[10px] text-[#8B9992]">

                                    Client JASAIN

                                </p>

                            </div>

                        </div>


                        <a
                            href="{{ route('freelancer.messages.index') }}"
                            class="inline-flex h-9 shrink-0 items-center gap-2 rounded-lg border border-[#DDE7E1] px-3 text-[10px] font-semibold text-[#52685F] transition hover:border-[#BBD9C6] hover:bg-[#F4FAF6] hover:text-[#1E9E5A]"
                        >

                            <i class="bi bi-chat-dots"></i>

                            Pesan

                        </a>

                    </div>

                </section>


                {{-- =================================================
                    ORDER DETAILS
                ================================================== --}}

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


                {{-- =================================================
                    BRIEF
                ================================================== --}}

                <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                    <div>

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                            Brief Client
                        </p>


                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                            Kebutuhan pekerjaan
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

                                Client belum menambahkan brief khusus.

                            </p>

                        </div>

                    @endif

                </section>


                {{-- =================================================
                    DELIVERY FORM
                ================================================== --}}

                @if(in_array($order->status, ['paid', 'in_progress', 'revision']))

                    <section class="overflow-hidden rounded-2xl border border-[#DCE9E1] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">


                        {{-- Header --}}
                        <div class="border-b border-[#E8EFEB] px-5 py-5 sm:px-6">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">

                                    @if($order->status === 'revision')

                                        <i class="bi bi-arrow-repeat text-[15px]"></i>

                                    @else

                                        <i class="bi bi-file-earmark-arrow-up text-[15px]"></i>

                                    @endif

                                </div>


                                <div>

                                    <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">

                                        @if($order->status === 'revision')

                                            Hasil Revisi

                                        @else

                                            Delivery

                                        @endif

                                    </p>


                                    <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                                        @if($order->status === 'revision')

                                            Kirim hasil revisi

                                        @else

                                            Kirim hasil pekerjaan

                                        @endif

                                    </h2>


                                    <p class="mt-1 text-xs leading-5 text-[#71837B]">

                                        @if($order->status === 'revision')

                                            Perbaiki pekerjaan sesuai permintaan client kemudian kirim hasil terbaru.

                                        @else

                                            Kirim hasil pekerjaan melalui file, link, atau catatan.

                                        @endif

                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Form --}}
                        <form
                            action="{{ route('freelancer.orders.delivery.store', $order) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="px-5 py-5 sm:px-6"
                        >

                            @csrf


                            {{-- Delivery General Error --}}
                            @if($errors->has('delivery'))

                                <div class="mb-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3">

                                    <div class="flex items-start gap-2.5">

                                        <i class="bi bi-exclamation-circle mt-0.5 text-sm text-red-500"></i>

                                        <p class="text-xs leading-5 text-red-600">

                                            {{ $errors->first('delivery') }}

                                        </p>

                                    </div>

                                </div>

                            @endif


                            {{-- Message --}}
                            <div>

                                <label
                                    for="delivery-message"
                                    class="text-xs font-semibold text-[#355248]"
                                >

                                    Catatan untuk client

                                    <span class="font-normal text-[#A0ADA7]">
                                        (opsional)
                                    </span>

                                </label>


                                <textarea
                                    id="delivery-message"
                                    name="message"
                                    rows="6"
                                    maxlength="5000"
                                    placeholder="Jelaskan hasil pekerjaan yang kamu kirim, bagian yang sudah dikerjakan, atau informasi penting lainnya..."
                                    class="mt-2 w-full rounded-xl border border-[#DCE7E1] bg-[#FAFCFB] px-4 py-3 text-sm leading-6 text-[#123128] outline-none placeholder:text-[#A0ADA7] transition focus:border-[#9ACCB0] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
                                >{{ old('message') }}</textarea>


                                @error('message')

                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror


                                <p class="mt-1.5 text-right text-[10px] text-[#A0ADA7]">
                                    Maksimal 5000 karakter
                                </p>

                            </div>


                            {{-- External Link --}}
                            <div class="mt-5">

                                <label
                                    for="delivery-link"
                                    class="text-xs font-semibold text-[#355248]"
                                >

                                    Link hasil pekerjaan

                                    <span class="font-normal text-[#A0ADA7]">
                                        (opsional)
                                    </span>

                                </label>


                                <div class="relative mt-2">

                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex w-11 items-center justify-center text-[#8C9B94]">

                                        <i class="bi bi-link-45deg"></i>

                                    </div>


                                    <input
                                        id="delivery-link"
                                        type="url"
                                        name="external_link"
                                        value="{{ old('external_link') }}"
                                        maxlength="2048"
                                        placeholder="https://drive.google.com/..."
                                        class="h-11 w-full rounded-xl border border-[#DCE7E1] bg-[#FAFCFB] pl-11 pr-4 text-xs text-[#123128] outline-none placeholder:text-[#A0ADA7] transition focus:border-[#9ACCB0] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
                                    >

                                </div>


                                @error('external_link')

                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- File Upload --}}
                            <div class="mt-5">

                                <label
                                    for="delivery-file"
                                    class="text-xs font-semibold text-[#355248]"
                                >

                                    File hasil pekerjaan

                                    <span class="font-normal text-[#A0ADA7]">
                                        (opsional)
                                    </span>

                                </label>


                                <label
                                    for="delivery-file"
                                    class="mt-2 flex cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed border-[#CBDDD2] bg-[#FAFCFB] px-5 py-8 text-center transition hover:border-[#9ACCB0] hover:bg-[#F5FBF7]"
                                >

                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">

                                        <i class="bi bi-cloud-arrow-up text-lg"></i>

                                    </div>


                                    <p class="mt-3 text-xs font-semibold text-[#355248]">

                                        Pilih file hasil

                                    </p>


                                    <p class="mt-1 text-[10px] text-[#91A099]">

                                        Maksimal 10 MB

                                    </p>


                                    <input
                                        id="delivery-file"
                                        type="file"
                                        name="file"
                                        class="hidden"
                                    >

                                </label>


                                <p
                                    id="selected-file"
                                    class="mt-2 hidden text-[10px] font-medium text-[#1E9E5A]"
                                ></p>


                                @error('file')

                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Required Info --}}
                            <div class="mt-5 rounded-xl border border-[#DCE9E1] bg-[#F5FBF7] px-4 py-3">

                                <div class="flex items-start gap-2.5">

                                    <i class="bi bi-info-circle mt-0.5 text-sm text-[#1E9E5A]"></i>


                                    <p class="text-[10px] leading-4 text-[#667D73]">

                                        Isi minimal salah satu:
                                        <span class="font-semibold text-[#4F685C]">
                                            catatan
                                        </span>,
                                        <span class="font-semibold text-[#4F685C]">
                                            link
                                        </span>,
                                        atau
                                        <span class="font-semibold text-[#4F685C]">
                                            file
                                        </span>.
                                        Setelah dikirim, client akan menerima hasil untuk diperiksa.

                                    </p>

                                </div>

                            </div>


                            {{-- Submit --}}
                            <div class="mt-6 flex justify-end">

                                <button
                                    type="submit"
                                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 text-xs font-semibold text-white shadow-sm transition hover:bg-[#0F6B3A]"
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

                    <section class="overflow-hidden rounded-2xl border border-[#E8DFC9] bg-[#FFF9EF] shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <div class="px-5 py-5 sm:px-6">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#B7791F] shadow-sm">

                                    <i class="bi bi-hourglass-split text-[15px]"></i>

                                </div>


                                <div>

                                    <p class="text-xs font-semibold text-[#7B5514]">

                                        Delivery sedang diperiksa client

                                    </p>


                                    <p class="mt-1 text-xs leading-5 text-[#866F4A]">

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

                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                        <div class="flex items-end justify-between gap-4">

                            <div>

                                <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                                    Riwayat

                                </p>


                                <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                                    Riwayat delivery

                                </h2>

                            </div>


                            <span class="text-[10px] text-[#98A49F]">

                                {{ $deliveryCount }} delivery

                            </span>

                        </div>


                        <div class="mt-5 space-y-3">

                            @foreach($order->deliveries as $delivery)

                                @php

                                    $deliveryLabel = match($delivery->status) {

                                        'submitted' => 'Menunggu pemeriksaan client',

                                        'approved' => 'Disetujui client',

                                        'revision' => 'Memerlukan revisi',

                                        'rejected' => 'Ditolak',

                                        default => ucfirst($delivery->status),

                                    };


                                    $deliveryClass = match($delivery->status) {

                                        'submitted' =>
                                            'bg-[#FFF9EA] text-[#9A6800]',

                                        'approved' =>
                                            'bg-[#EAF7EF] text-[#168A4D]',

                                        'revision' =>
                                            'bg-[#FAF4FC] text-[#895597]',

                                        'rejected' =>
                                            'bg-red-50 text-red-600',

                                        default =>
                                            'bg-gray-100 text-gray-600',

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


                                <div class="rounded-xl border border-[#E5ECE8] bg-[#FAFCFB] p-4">

                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">


                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#1E9E5A] shadow-sm">

                                                <i class="bi {{ $deliveryIcon }} text-[13px]"></i>

                                            </div>


                                            <div>

                                                <p class="text-xs font-semibold text-[#355248]">

                                                    Delivery #{{ $deliveryCount - $loop->index }}

                                                </p>


                                                <p class="mt-1 text-[10px] text-[#91A099]">

                                                    {{ $delivery->submitted_at?->format('d M Y, H:i') ?? $delivery->created_at?->format('d M Y, H:i') }}

                                                </p>

                                            </div>

                                        </div>


                                        <span class="inline-flex w-fit rounded-full px-2.5 py-1 text-[9px] font-semibold {{ $deliveryClass }}">

                                            {{ $deliveryLabel }}

                                        </span>

                                    </div>


                                    @if($delivery->message)

                                        <div class="mt-3 rounded-lg bg-white px-3 py-3">

                                            <p class="whitespace-pre-line text-xs leading-5 text-[#62766D]">

                                                {{ $delivery->message }}

                                            </p>

                                        </div>

                                    @endif


                                    <div class="mt-3 flex flex-wrap gap-2">


                                        @if($delivery->file_path)

                                            <a
                                                href="{{ asset('storage/' . $delivery->file_path) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex max-w-full items-center gap-1.5 rounded-lg border border-[#DCE7E1] bg-white px-3 py-2 text-[10px] font-semibold text-[#1E9E5A] transition hover:bg-[#F4FAF6]"
                                            >

                                                <i class="bi bi-file-earmark-arrow-down shrink-0"></i>

                                                <span class="max-w-[220px] truncate">

                                                    {{ $delivery->file_name ?? 'Lihat file' }}

                                                </span>

                                            </a>

                                        @endif


                                        @if($delivery->external_link)

                                            <a
                                                href="{{ $delivery->external_link }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-[#DCE7E1] bg-white px-3 py-2 text-[10px] font-semibold text-[#526960] transition hover:bg-[#F4FAF6] hover:text-[#1E9E5A]"
                                            >

                                                <i class="bi bi-box-arrow-up-right"></i>

                                                Buka link

                                            </a>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </section>

                @endif


                {{-- =================================================
                    TIMELINE
                ================================================== --}}

                <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                    <div>

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                            Timeline

                        </p>


                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                            Perjalanan order

                        </h2>

                    </div>


                    <div class="relative mt-6">

                        <div class="absolute bottom-5 left-[17px] top-5 w-px bg-[#E1EAE5]"></div>


                        <div class="space-y-6">

                            @foreach($timeline as $step)

                                <div class="relative flex gap-4">

                                    <div
                                        class="
                                            relative z-10 flex h-[35px] w-[35px] shrink-0
                                            items-center justify-center rounded-full border
                                            {{ $step['active']
                                                ? 'border-[#BFE0CC] bg-[#EAF7EF] text-[#1E9E5A]'
                                                : 'border-[#E3E9E5] bg-white text-[#A5B0AB]' }}
                                        "
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

            </div>


            {{-- =====================================================
                RIGHT COLUMN
            ====================================================== --}}

            <aside class="space-y-5">


                {{-- =================================================
                    PAYMENT SUMMARY
                ================================================== --}}

                <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                    <div>

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                            Nilai Order

                        </p>


                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                            Ringkasan pembayaran

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


                        <div class="flex items-center justify-between gap-4">

                            <span class="text-xs font-semibold text-[#52675E]">

                                Pendapatan freelancer

                            </span>


                            <span class="text-sm font-semibold text-[#1E9E5A]">

                                Rp {{ number_format((float) $order->freelancer_amount, 0, ',', '.') }}

                            </span>

                        </div>


                        <div class="border-t border-[#EDF2EF] pt-4">

                            <div class="flex items-end justify-between gap-4">

                                <span class="text-xs font-medium text-[#52675E]">

                                    Total order

                                </span>


                                <span class="text-lg font-semibold tracking-[-0.02em] text-[#123128]">

                                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}

                                </span>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    DEADLINE
                ================================================== --}}

                <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                    <div>

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                            Pengerjaan

                        </p>


                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                            Deadline order

                        </h2>

                    </div>


                    <div class="mt-5 space-y-4">


                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F3F8F5] text-[#1E9E5A]">

                                <i class="bi bi-calendar-event text-[13px]"></i>

                            </div>


                            <div>

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


                {{-- =================================================
                    PAYMENT STATUS
                ================================================== --}}

                <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                    <div>

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                            Pembayaran

                        </p>


                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                            Status pembayaran

                        </h2>

                    </div>


                    @if($order->payment)

                        <div class="mt-5 space-y-4">


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

                                        Menunggu pembayaran

                                    </span>

                                @else

                                    <span class="rounded-full bg-[#F4F6F5] px-2.5 py-1 text-[9px] font-semibold text-[#66766E]">

                                        {{ ucfirst($order->payment->status) }}

                                    </span>

                                @endif

                            </div>


                            <div class="flex items-center justify-between gap-3">

                                <span class="text-xs text-[#7D8D86]">

                                    Metode

                                </span>


                                <span class="max-w-[170px] truncate text-right text-[10px] font-semibold text-[#355248]">

                                    {{ strtoupper($order->payment->payment_type ?? '-') }}

                                </span>

                            </div>

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


                {{-- =================================================
                    QUICK ACTION
                ================================================== --}}

                <section class="rounded-2xl border border-[#DCE9E1] bg-[#EAF7EF] p-5">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">

                        <i class="bi bi-lightning-charge text-[15px]"></i>

                    </div>


                    <h2 class="mt-4 text-sm font-semibold text-[#123128]">

                        Aksi cepat

                    </h2>


                    <p class="mt-1.5 text-xs leading-5 text-[#63786E]">

                        Hubungi client untuk membahas detail brief, progres pekerjaan, atau hasil delivery.

                    </p>


                    <a
                        href="{{ route('freelancer.messages.index') }}"
                        class="mt-4 flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-white text-xs font-semibold text-[#355248] shadow-sm transition hover:text-[#1E9E5A]"
                    >

                        Buka pesan

                        <i class="bi bi-arrow-right text-[10px]"></i>

                    </a>

                </section>


                {{-- =================================================
                    REVIEW
                ================================================== --}}

                @if($order->review)

                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">

                            Review

                        </p>


                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">

                            Penilaian client

                        </h2>


                        <div class="mt-4 flex items-center gap-2">

                            <div class="flex items-center gap-1">

                                @for($i = 1; $i <= 5; $i++)

                                    <i
                                        class="bi bi-star-fill text-[12px] {{ $i <= $order->review->rating ? 'text-[#F2B93B]' : 'text-[#DDE4DF]' }}"
                                    ></i>

                                @endfor

                            </div>


                            <span class="text-xs font-semibold text-[#355248]">

                                {{ $order->review->rating }}/5

                            </span>

                        </div>


                        @if($order->review->comment)

                            <div class="mt-4 rounded-xl bg-[#F8FBF9] px-4 py-4">

                                <p class="whitespace-pre-line text-xs leading-6 text-[#62766D]">

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

        const fileInput = document.getElementById('delivery-file');

        const selectedFile = document.getElementById('selected-file');


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
                        'text-[#1E9E5A]'
                    );

                    selectedFile.classList.add(
                        'text-red-600'
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
                    'text-red-600'
                );

                selectedFile.classList.add(
                    'text-[#1E9E5A]'
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
