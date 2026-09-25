
@php
    $serviceItem = $order->items->first();
    $service = $serviceItem?->service;

    $serviceTitle = $serviceItem?->service_title
        ?? $service?->title
        ?? 'Layanan ProKerja';

    $freelancerProfile = $order->freelancerProfile;
    $freelancer = $freelancerProfile?->user;

    $freelancerName = $freelancer?->name ?? 'Freelancer';
    $freelancerInitial = strtoupper(
        substr(trim($freelancerName), 0, 1)
    );

    /*
    |--------------------------------------------------------------------------
    | Service image
    |--------------------------------------------------------------------------
    */
    $serviceImage = data_get($service, 'thumbnail')
        ?? data_get($service, 'image')
        ?? data_get($service, 'image_url')
        ?? data_get($service, 'thumbnail_url')
        ?? data_get($service, 'cover');

    $serviceImageUrl = null;

    if ($serviceImage) {
        if (
            filter_var($serviceImage, FILTER_VALIDATE_URL) ||
            str_starts_with($serviceImage, 'data:image/')
        ) {
            $serviceImageUrl = $serviceImage;
        } elseif (str_starts_with($serviceImage, '/')) {
            $serviceImageUrl = asset(
                ltrim($serviceImage, '/')
            );
        } elseif (
            str_starts_with($serviceImage, 'storage/') ||
            str_starts_with($serviceImage, 'uploads/')
        ) {
            $serviceImageUrl = asset($serviceImage);
        } else {
            $serviceImageUrl = asset(
                'storage/' . ltrim($serviceImage, '/')
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Freelancer avatar
    |--------------------------------------------------------------------------
    */
    $freelancerAvatar = data_get($freelancerProfile, 'avatar')
        ?? data_get($freelancer, 'avatar')
        ?? data_get($freelancer, 'avatar_url')
        ?? data_get($freelancer, 'profile_photo_url');

    $freelancerAvatarUrl = null;

    if ($freelancerAvatar) {
        if (
            filter_var($freelancerAvatar, FILTER_VALIDATE_URL) ||
            str_starts_with($freelancerAvatar, 'data:image/')
        ) {
            $freelancerAvatarUrl = $freelancerAvatar;
        } elseif (str_starts_with($freelancerAvatar, '/')) {
            $freelancerAvatarUrl = asset(
                ltrim($freelancerAvatar, '/')
            );
        } elseif (
            str_starts_with($freelancerAvatar, 'storage/') ||
            str_starts_with($freelancerAvatar, 'uploads/')
        ) {
            $freelancerAvatarUrl = asset($freelancerAvatar);
        } else {
            $freelancerAvatarUrl = asset(
                'storage/' . ltrim($freelancerAvatar, '/')
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Payment status
    |--------------------------------------------------------------------------
    */
    $paymentStatus = $order->payment?->status;

    $paymentLabel = match ($paymentStatus) {
        'paid' => 'Sudah dibayar',
        'pending' => 'Menunggu pembayaran',
        'refund_pending' => 'Menunggu refund',
        'refunded' => 'Dana dikembalikan',
        'cancelled' => 'Dibatalkan',
        default => $order->payment
            ? ucfirst(
                str_replace(
                    '_',
                    ' ',
                    $paymentStatus
                )
            )
            : 'Belum tersedia',
    };

    $paymentBadge = match ($paymentStatus) {
        'paid', 'refunded'
            => 'border-emerald-200 bg-emerald-50 text-emerald-700',

        'pending'
            => 'border-amber-200 bg-amber-50 text-amber-700',

        'refund_pending'
            => 'border-blue-200 bg-blue-50 text-blue-700',

        'cancelled'
            => 'border-slate-200 bg-slate-50 text-slate-600',

        default
            => 'border-slate-200 bg-slate-50 text-slate-600',
    };

    /*
    |--------------------------------------------------------------------------
    | Current checkout state
    |--------------------------------------------------------------------------
    */
    $isWaitingPayment = $order->status === 'pending_payment';
    $isPaid = $order->status === 'paid';
    $isCancelled = $order->status === 'cancelled';

    $total = (float) ($order->total ?? 0);
    $subtotal = (float) ($order->subtotal ?? 0);
    $platformFee = (float) ($order->platform_fee ?? 0);
@endphp

<x-layouts.marketplace title="Checkout - ProKerja">

    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="mx-auto w-full max-w-6xl px-4 py-5 pb-28 sm:px-6 sm:py-7 lg:px-8 lg:pb-10">

            {{-- =========================================================
                TOP NAVIGATION
            ========================================================== --}}
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <a
                    href="{{ route('client.orders.show', $order) }}"
                    class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-[#2563EB]"
                >
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                            <path d="M19 12H5"/>
                            <path d="m12 19-7-7 7-7"/>
                        </svg>
                    </span>

                    Kembali ke order
                </a>

                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <span>Order</span>
                    <span>•</span>
                    <span class="font-semibold text-slate-600">
                        {{ $order->order_number }}
                    </span>
                </div>

            </div>


            {{-- =========================================================
                ALERTS
            ========================================================== --}}
            @if(session('success'))

                <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 sm:px-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m5 12 4 4L19 6"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-bold text-emerald-800">
                                Berhasil
                            </p>

                            <p class="mt-0.5 text-sm leading-6 text-emerald-700">
                                {{ session('success') }}
                            </p>
                        </div>

                    </div>

                </div>

            @endif


            @if(session('error'))

                <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 sm:px-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-rose-600">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m8 8 8 8M16 8 8 16"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-bold text-rose-800">
                                Pembayaran belum berhasil
                            </p>

                            <p class="mt-0.5 text-sm leading-6 text-rose-700">
                                {{ session('error') }}
                            </p>
                        </div>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}
            <div class="mb-6">

                <div class="flex flex-wrap items-center gap-2">

                    <span class="inline-flex items-center gap-2 rounded-full bg-[#EFF6FF] px-3 py-1.5 text-xs font-bold text-[#2563EB]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#2563EB]"></span>
                        Checkout
                    </span>

                    <span class="text-xs text-slate-400">
                        Langkah terakhir sebelum project dimulai
                    </span>

                </div>

                <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Konfirmasi pesanan
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
                    Periksa kembali layanan, freelancer, kebutuhan project, dan total pembayaran sebelum menyelesaikan pesanan.
                </p>

            </div>


            {{-- =========================================================
                CHECKOUT LAYOUT
            ========================================================== --}}
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_360px]">


                {{-- =====================================================
                    LEFT CONTENT
                ====================================================== --}}
                <main class="min-w-0 space-y-5">


                    {{-- -------------------------------------------------
                        SERVICE
                    -------------------------------------------------- --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 px-5 py-5 sm:px-6">

                            <div class="flex items-center justify-between gap-4">

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                                        Pesanan
                                    </p>

                                    <h2 class="mt-1 text-lg font-bold text-slate-900">
                                        Jasa yang kamu pesan
                                    </h2>
                                </div>

                                <span class="text-xs font-medium text-slate-400">
                                    {{ $order->items->count() }} item
                                </span>

                            </div>

                        </div>


                        <div class="p-5 sm:p-6">

                            @foreach($order->items as $item)

                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start">

                                    <div class="h-24 w-full shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 sm:h-24 sm:w-24">

                                        @if($serviceImageUrl && $loop->first)

                                            <img
                                                src="{{ $serviceImageUrl }}"
                                                alt="{{ $item->service_title }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @else

                                            <div class="flex h-full w-full items-center justify-center bg-[#EFF6FF] text-[#2563EB]">
                                                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                                                    <path d="M7 8h10M7 12h7M7 16h5"/>
                                                </svg>
                                            </div>

                                        @endif

                                    </div>


                                    <div class="min-w-0 flex-1">

                                        <p class="text-base font-bold leading-6 text-slate-900 sm:text-lg">
                                            {{ $item->service_title }}
                                        </p>

                                        <div class="mt-2 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-slate-500">

                                            <span>
                                                Qty {{ $item->quantity }}
                                            </span>

                                            <span>
                                                {{ $item->delivery_days }} hari pengerjaan
                                            </span>

                                            <span>
                                                Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}/item
                                            </span>

                                        </div>

                                    </div>


                                    <div class="shrink-0 sm:text-right">

                                        <p class="text-xs text-slate-400">
                                            Subtotal
                                        </p>

                                        <p class="mt-1 text-lg font-bold text-slate-900">
                                            Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </section>


                    {{-- -------------------------------------------------
                        FREELANCER
                    -------------------------------------------------- --}}
                    <section class="border-b border-slate-200 bg-white px-5 py-5 shadow-sm sm:px-6">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-white bg-blue-100 shadow-sm">

                                    @if($freelancerAvatarUrl)

                                        <img
                                            src="{{ $freelancerAvatarUrl }}"
                                            alt="{{ $freelancerName }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-full w-full items-center justify-center text-sm font-bold text-blue-700">
                                            {{ $freelancerInitial }}
                                        </div>

                                    @endif

                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs text-slate-400">
                                        Freelancer
                                    </p>

                                    <p class="mt-0.5 truncate text-sm font-bold text-slate-900">
                                        {{ $freelancerName }}
                                    </p>

                                </div>

                            </div>

                            <div class="flex items-center gap-2 rounded-xl bg-slate-50 px-3 py-2">

                                <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="m5 12 4 4L19 6"/>
                                </svg>

                                <span class="text-xs font-semibold text-slate-600">
                                    Freelancer pilihanmu
                                </span>

                            </div>

                        </div>

                    </section>


                    {{-- -------------------------------------------------
                        REQUIREMENTS
                    -------------------------------------------------- --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 px-5 py-5 sm:px-6">

                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                                Project
                            </p>

                            <h2 class="mt-1 text-lg font-bold text-slate-900">
                                Detail kebutuhan
                            </h2>

                        </div>


                        <div class="p-5 sm:p-6">

                            @if($order->requirements)

                                <div class="rounded-2xl bg-slate-50 p-4 sm:p-5">

                                    <p class="whitespace-pre-line text-sm leading-7 text-slate-600">
                                        {{ $order->requirements }}
                                    </p>

                                </div>

                            @else

                                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-9 text-center">

                                    <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M7 3h10a2 2 0 0 1 2 2v14l-7-3-7 3V5a2 2 0 0 1 2-2Z"/>
                                            <path d="M9 8h6M9 12h6"/>
                                        </svg>
                                    </div>

                                    <p class="mt-3 text-sm font-semibold text-slate-600">
                                        Tidak ada kebutuhan tambahan.
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-400">
                                        Freelancer akan menggunakan detail layanan sebagai acuan pengerjaan.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </section>


                    {{-- -------------------------------------------------
                        SERVICE DELIVERY INFO
                    -------------------------------------------------- --}}
                    <section class="rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="px-5 py-5 sm:px-6">

                            <div class="flex items-center justify-between gap-3">

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                                        Informasi
                                    </p>

                                    <h2 class="mt-1 text-lg font-bold text-slate-900">
                                        Ketentuan pengerjaan
                                    </h2>
                                </div>

                            </div>


                            <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">

                                <div class="rounded-2xl bg-slate-50 p-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <circle cx="12" cy="12" r="9"/>
                                                <path d="M12 7v5l3 2"/>
                                            </svg>
                                        </div>

                                        <div>
                                            <p class="text-xs text-slate-400">
                                                Durasi pengerjaan
                                            </p>

                                            <p class="mt-1 text-sm font-bold text-slate-900">
                                                {{ $order->delivery_days }} hari
                                            </p>
                                        </div>

                                    </div>

                                </div>


                                <div class="rounded-2xl bg-slate-50 p-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                                                <path d="M16 2v4M8 2v4M3 9h18"/>
                                            </svg>
                                        </div>

                                        <div>
                                            <p class="text-xs text-slate-400">
                                                Estimasi selesai
                                            </p>

                                            <p class="mt-1 text-sm font-bold text-slate-900">
                                                {{ $order->due_at?->format('d M Y') ?? '-' }}
                                            </p>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>

                </main>


                {{-- =====================================================
                    PAYMENT SIDEBAR
                ====================================================== --}}
                <aside class="min-w-0">

                    <div class="space-y-5 lg:sticky lg:top-24">

                        {{-- -------------------------------------------------
                            ORDER SUMMARY
                        -------------------------------------------------- --}}
                        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                            <div class="border-b border-slate-100 px-5 py-5 sm:px-6">

                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                                    Ringkasan
                                </p>

                                <h2 class="mt-1 text-xl font-bold text-slate-900">
                                    Total pembayaran
                                </h2>

                            </div>


                            <div class="p-5 sm:p-6">

                                <div class="space-y-4">

                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-sm text-slate-500">
                                            Subtotal
                                        </span>

                                        <span class="text-sm font-semibold text-slate-800">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </span>
                                    </div>


                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-sm text-slate-500">
                                            Biaya platform
                                        </span>

                                        <span class="text-sm font-semibold text-slate-800">
                                            Rp {{ number_format($platformFee, 0, ',', '.') }}
                                        </span>
                                    </div>


                                    <div class="border-t border-slate-100 pt-4">

                                        <div class="flex items-end justify-between gap-4">

                                            <span class="text-sm font-bold text-slate-700">
                                                Total
                                            </span>

                                            <span class="text-2xl font-bold tracking-tight text-slate-900">
                                                Rp {{ number_format($total, 0, ',', '.') }}
                                            </span>

                                        </div>

                                    </div>

                                </div>


                                {{-- payment status --}}
                                <div class="mt-5 rounded-2xl border px-4 py-4 {{ $paymentBadge }}">

                                    <div class="flex items-start gap-3">

                                        <div class="mt-0.5">

                                            @if($paymentStatus === 'paid')

                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path d="m8 12 2.5 2.5L16 9"/>
                                                </svg>

                                            @elseif($paymentStatus === 'pending')

                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path d="M12 7v5l3 2"/>
                                                </svg>

                                            @else

                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path d="M12 11v5"/>
                                                    <path d="M12 8h.01"/>
                                                </svg>

                                            @endif

                                        </div>


                                        <div>

                                            <p class="text-sm font-bold">
                                                {{ $paymentLabel }}
                                            </p>

                                            <p class="mt-1 text-xs leading-5 opacity-80">

                                                @if($isWaitingPayment)
                                                    Selesaikan pembayaran agar freelancer dapat mulai mengerjakan project.

                                                @elseif($isPaid)
                                                    Pembayaran sudah diterima dan order siap diproses freelancer.

                                                @elseif($isCancelled)
                                                    Order ini sudah dibatalkan.

                                                @else
                                                    Status pembayaran akan diperbarui setelah proses selesai.
                                                @endif

                                            </p>

                                        </div>

                                    </div>

                                </div>


                                {{-- =================================================
                                    DEVELOPMENT PAYMENT SIMULATOR
                                ================================================== --}}
                                @if($isWaitingPayment)

                                    <div class="mt-5">

                                        <form
                                            action="{{ route('client.orders.payment.simulate', $order) }}"
                                            method="POST"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="group inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-sm font-bold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 active:scale-[0.99]"
                                            >

                                                <svg class="h-4 w-4 transition group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                                                    <path d="M3 10h18"/>
                                                </svg>

                                                Selesaikan Pembayaran

                                                <svg class="h-4 w-4 transition group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                                    <path d="M5 12h14"/>
                                                    <path d="m13 6 6 6-6 6"/>
                                                </svg>

                                            </button>

                                        </form>

                                        <div class="mt-3 flex items-start gap-2">

                                            <svg class="mt-0.5 h-3.5 w-3.5 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <circle cx="12" cy="12" r="9"/>
                                                <path d="M12 11v5"/>
                                                <path d="M12 8h.01"/>
                                            </svg>

                                            <p class="text-xs leading-5 text-slate-400">
                                                Mode pembayaran pengembangan. Gateway pembayaran ProKerja akan menggunakan Xendit pada tahap integrasi final.
                                            </p>

                                        </div>

                                    </div>

                                @elseif($isPaid)

                                    <div class="mt-5 rounded-2xl border border-emerald-200 bg-emerald-50 p-4">

                                        <div class="flex items-start gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="m5 12 4 4L19 6"/>
                                                </svg>
                                            </div>

                                            <div>

                                                <p class="text-sm font-bold text-emerald-800">
                                                    Pembayaran berhasil
                                                </p>

                                                <p class="mt-1 text-xs leading-5 text-emerald-700">
                                                    Order sudah dibayar. Freelancer dapat mulai mengerjakan project.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                @endif


                                {{-- secure information --}}
                                <div class="mt-5 space-y-3">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-50 text-slate-500">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path d="M12 3 4 6v5c0 5 3.5 8.5 8 10 4.5-1.5 8-5 8-10V6l-8-3Z"/>
                                                <path d="m9 12 2 2 4-4"/>
                                            </svg>
                                        </div>

                                        <p class="text-xs leading-5 text-slate-500">
                                            Transaksi dilindungi oleh sistem ProKerja.
                                        </p>

                                    </div>

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-50 text-slate-500">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path d="M20 12a8 8 0 1 1-2.34-5.66"/>
                                                <path d="M20 4v6h-6"/>
                                            </svg>
                                        </div>

                                        <p class="text-xs leading-5 text-slate-500">
                                            Riwayat order dapat dilihat kapan saja dari detail pesanan.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </section>


                        {{-- -------------------------------------------------
                            FREELANCER
                        -------------------------------------------------- --}}
                        <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                                Freelancer
                            </p>

                            <div class="mt-4 flex items-center gap-3">

                                <div class="h-11 w-11 shrink-0 overflow-hidden rounded-full bg-blue-100">

                                    @if($freelancerAvatarUrl)

                                        <img
                                            src="{{ $freelancerAvatarUrl }}"
                                            alt="{{ $freelancerName }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-full w-full items-center justify-center text-sm font-bold text-blue-700">
                                            {{ $freelancerInitial }}
                                        </div>

                                    @endif

                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-bold text-slate-900">
                                        {{ $freelancerName }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        Freelancer ProKerja
                                    </p>

                                </div>

                            </div>

                        </section>


                        {{-- -------------------------------------------------
                            ORDER ID
                        -------------------------------------------------- --}}
                        <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                                Referensi
                            </p>

                            <div class="mt-4 space-y-4">

                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-sm text-slate-500">
                                        Nomor order
                                    </span>

                                    <span class="text-right text-xs font-bold text-slate-800">
                                        {{ $order->order_number }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-sm text-slate-500">
                                        Dibuat
                                    </span>

                                    <span class="text-right text-xs font-semibold text-slate-700">
                                        {{ $order->created_at?->format('d M Y, H:i') }}
                                    </span>
                                </div>

                            </div>

                        </section>

                    </div>

                </aside>

            </div>

        </div>

    </div>

</x-layouts.marketplace>
