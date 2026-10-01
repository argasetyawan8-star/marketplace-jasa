<x-layouts.admin title="Detail Refund">


@php
    $statusConfig = [
        'pending' => [
            'label' => 'Menunggu diproses',
            'class' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-900/40 dark:bg-amber-950/30 dark:text-amber-300',
            'dot' => 'bg-amber-500',
            'icon' => 'bi-hourglass-split',
        ],
        'processing' => [
            'label' => 'Sedang diproses',
            'class' => 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-900/40 dark:bg-blue-950/30 dark:text-blue-300',
            'dot' => 'bg-blue-500',
            'icon' => 'bi-arrow-repeat',
        ],
        'refunded' => [
            'label' => 'Refund berhasil',
            'class' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900/40 dark:bg-emerald-950/30 dark:text-emerald-300',
            'dot' => 'bg-emerald-500',
            'icon' => 'bi-check-circle-fill',
        ],
        'rejected' => [
            'label' => 'Refund ditolak',
            'class' => 'border-red-200 bg-red-50 text-red-700 dark:border-red-900/40 dark:bg-red-950/30 dark:text-red-300',
            'dot' => 'bg-red-500',
            'icon' => 'bi-x-circle-fill',
        ],
    ];

    $status = $statusConfig[$refund->status]
        ?? [
            'label' => ucfirst($refund->status),
            'class' => 'border-slate-200 bg-slate-50 text-slate-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
            'dot' => 'bg-slate-400',
            'icon' => 'bi-info-circle',
        ];

    /* -------------------------------------------------------------
     * Client
     * ------------------------------------------------------------- */
    $client = $refund->order?->client;
    $clientProfile = $client?->profile;
    $clientAvatar = $clientProfile?->avatar;

    $clientAvatarUrl = null;

    if ($clientAvatar) {
        $clientAvatarUrl = str_starts_with($clientAvatar, 'http://')
            || str_starts_with($clientAvatar, 'https://')
            ? $clientAvatar
            : asset('storage/' . ltrim($clientAvatar, '/'));
    }

    $clientName = $client?->name ?? '-';

    $clientInitials = collect(explode(' ', trim($clientName)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->implode('');

    /* -------------------------------------------------------------
     * Freelancer
     * ------------------------------------------------------------- */
    $freelancerProfile = $refund->order?->freelancerProfile;
    $freelancerUser = $freelancerProfile?->user;
    $freelancerAvatar = $freelancerProfile?->avatar;

    $freelancerAvatarUrl = null;

    if ($freelancerAvatar) {
        $freelancerAvatarUrl = str_starts_with($freelancerAvatar, 'http://')
            || str_starts_with($freelancerAvatar, 'https://')
            ? $freelancerAvatar
            : asset('storage/' . ltrim($freelancerAvatar, '/'));
    }

    $freelancerName = $freelancerUser?->name ?? '-';

    $freelancerInitials = collect(explode(' ', trim($freelancerName)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->implode('');
@endphp

<div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

        <div class="min-w-0">

            <a
                href="{{ route('admin.refunds.index') }}"
                class="inline-flex items-center gap-2 text-[10px] font-semibold text-slate-400 transition hover:text-blue-600 dark:text-slate-500 dark:hover:text-blue-400"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke refund
            </a>

            <div class="mt-5 flex items-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">
                    Refund
                </p>
            </div>

            <h1 class="mt-1 break-all text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                {{ $refund->refund_number }}
            </h1>

            <p class="mt-1 text-sm leading-6 text-slate-500 dark:text-slate-400">
                Pengembalian dana untuk order
                <span class="font-semibold text-slate-700 dark:text-slate-200">
                    {{ $refund->order?->order_number ?? '-' }}
                </span>
            </p>
        </div>

        <span
            class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full border px-3 py-1.5 text-[10px] font-bold {{ $status['class'] }}"
        >
            <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
            <i class="bi {{ $status['icon'] }}"></i>
            {{ $status['label'] }}
        </span>

    </div>

    {{-- =========================================================
         FLASH SUCCESS
    ========================================================== --}}
    @if(session('success'))
        <div class="mt-6 overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50 dark:border-emerald-900/40 dark:bg-emerald-950/30">
            <div class="flex items-start gap-3 px-5 py-4">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                    <i class="bi bi-check-circle-fill text-sm"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-semibold text-emerald-800 dark:text-emerald-300">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-xs leading-5 text-emerald-700 dark:text-emerald-400">
                        {{ session('success') }}
                    </p>
                </div>

            </div>
        </div>
    @endif

    {{-- =========================================================
         VALIDATION ERROR
    ========================================================== --}}
    @if($errors->any())
        <div class="mt-6 overflow-hidden rounded-2xl border border-red-200 bg-red-50 dark:border-red-900/40 dark:bg-red-950/30">
            <div class="px-5 py-4">

                <div class="flex items-start gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm dark:bg-slate-900 dark:text-red-400">
                        <i class="bi bi-exclamation-circle-fill text-sm"></i>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-red-800 dark:text-red-300">
                            Periksa kembali data.
                        </p>

                        <div class="mt-2 space-y-1">
                            @foreach($errors->all() as $error)
                                <p class="text-xs leading-5 text-red-700 dark:text-red-400">
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
         CONTENT
    ========================================================== --}}
    <div class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_320px]">

        {{-- =====================================================
             MAIN
        ====================================================== --}}
        <div class="space-y-5">

            {{-- -------------------------------------------------
                 REFUND INFORMATION
            -------------------------------------------------- --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">
                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                            <i class="bi bi-arrow-counterclockwise text-sm"></i>
                        </div>

                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                                Informasi refund
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                                Detail pengembalian dana
                            </h2>
                        </div>

                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 px-5 py-5 sm:grid-cols-2 sm:px-6">

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Nomor refund
                        </p>

                        <p class="mt-2 break-all text-xs font-bold text-slate-700 dark:text-slate-200">
                            {{ $refund->refund_number }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Sumber
                        </p>

                        <p class="mt-2 text-xs font-bold capitalize text-slate-700 dark:text-slate-200">
                            {{ $refund->source_type ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900/30 dark:bg-blue-950/20">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-blue-600 dark:text-blue-400">
                            Nominal refund
                        </p>

                        <p class="mt-2 text-xl font-bold tracking-tight text-blue-700 dark:text-blue-300">
                            Rp {{ number_format((float) $refund->amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Dibuat
                        </p>

                        <p class="mt-2 text-xs font-bold text-slate-700 dark:text-slate-200">
                            {{ $refund->created_at?->format('d M Y, H:i') }}
                        </p>
                    </div>

                </div>

                @if($refund->reason)
                    <div class="border-t border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                        <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                            Alasan refund
                        </p>

                        <div class="mt-3 rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                            <p class="whitespace-pre-line text-xs leading-6 text-slate-600 dark:text-slate-300">
                                {{ $refund->reason }}
                            </p>
                        </div>

                    </div>
                @endif

            </section>

            {{-- -------------------------------------------------
                 CLIENT & FREELANCER
            -------------------------------------------------- --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                    <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                        Pihak terkait
                    </p>

                    <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                        Client & Freelancer
                    </h2>

                </div>

                <div class="grid grid-cols-1 gap-3 px-5 py-5 sm:px-6 lg:grid-cols-2">

                    {{-- CLIENT --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                        <p class="mb-3 text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Client
                        </p>

                        <div class="flex items-center gap-3">

                            <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-white bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">

                                @if($clientAvatarUrl)
                                    <img
                                        src="{{ $clientAvatarUrl }}"
                                        alt="{{ $clientName }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm font-bold text-slate-500 dark:text-slate-300">
                                        {{ $clientInitials ?: 'CL' }}
                                    </div>
                                @endif

                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-800 dark:text-slate-200">
                                    {{ $clientName }}
                                </p>

                                <p class="mt-0.5 truncate text-[10px] text-slate-400">
                                    {{ $client?->email ?? '-' }}
                                </p>

                                @if($clientProfile?->username)
                                    <p class="mt-1 truncate text-[10px] font-medium text-blue-600 dark:text-blue-400">
                                        {{ '@' . $clientProfile->username }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>

                    {{-- FREELANCER --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                        <p class="mb-3 text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Freelancer
                        </p>

                        <div class="flex items-center gap-3">

                            <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-white bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">

                                @if($freelancerAvatarUrl)
                                    <img
                                        src="{{ $freelancerAvatarUrl }}"
                                        alt="{{ $freelancerName }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm font-bold text-slate-500 dark:text-slate-300">
                                        {{ $freelancerInitials ?: 'FR' }}
                                    </div>
                                @endif

                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-800 dark:text-slate-200">
                                    {{ $freelancerName }}
                                </p>

                                <p class="mt-0.5 truncate text-[10px] text-slate-400">
                                    {{ $freelancerUser?->email ?? '-' }}
                                </p>

                                @if($freelancerProfile?->username)
                                    <p class="mt-1 truncate text-[10px] font-medium text-blue-600 dark:text-blue-400">
                                        {{ '@' . $freelancerProfile->username }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>

            </section>

            {{-- -------------------------------------------------
                 ORDER
            -------------------------------------------------- --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                            <i class="bi bi-bag-check text-sm"></i>
                        </div>

                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                                Order
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                                Transaksi terkait
                            </h2>
                        </div>

                    </div>

                </div>

                <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-2 sm:px-6">

                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Order
                        </p>

                        <p class="mt-2 text-xs font-bold text-slate-700 dark:text-slate-200">
                            {{ $refund->order?->order_number ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Status order
                        </p>

                        <p class="mt-2 text-xs font-bold capitalize text-slate-700 dark:text-slate-200">
                            {{ ucfirst(str_replace('_', ' ', $refund->order?->status ?? '-')) }}
                        </p>
                    </div>

                </div>

                @if($refund->order)
                    <div class="border-t border-slate-100 px-5 py-4 dark:border-slate-800 sm:px-6">

                        <a
                            href="{{ route('admin.orders.show', $refund->order) }}"
                            class="inline-flex items-center gap-2 text-[10px] font-semibold text-blue-600 transition hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                        >
                            Lihat detail order
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                @endif

            </section>

            {{-- -------------------------------------------------
                 PAYMENT
            -------------------------------------------------- --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                            <i class="bi bi-credit-card text-sm"></i>
                        </div>

                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                                Payment
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                                Status pembayaran
                            </h2>
                        </div>

                    </div>

                </div>

                <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-2 sm:px-6">

                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-950/50">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Status
                        </p>

                        <p class="mt-2 text-xs font-bold capitalize text-slate-700 dark:text-slate-200">
                            {{ str_replace('_', ' ', $refund->payment?->status ?? '-') }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-950/50">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Payment ID
                        </p>

                        <p class="mt-2 text-xs font-bold text-slate-700 dark:text-slate-200">
                            #{{ $refund->payment?->id ?? '-' }}
                        </p>
                    </div>

                </div>

                @if($refund->payment)
                    <div class="border-t border-slate-100 px-5 py-4 dark:border-slate-800 sm:px-6">

                        <a
                            href="{{ route('admin.payments.show', $refund->payment) }}"
                            class="inline-flex items-center gap-2 text-[10px] font-semibold text-blue-600 transition hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                        >
                            Lihat detail pembayaran
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>
                @endif

            </section>

            {{-- -------------------------------------------------
                 ADMIN NOTE
            -------------------------------------------------- --}}
            @if($refund->admin_note)
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                            <i class="bi bi-journal-text text-sm"></i>
                        </div>

                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-slate-400">
                                Catatan Admin
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                                Catatan proses
                            </h2>
                        </div>

                    </div>

                    <div class="mt-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                        <p class="whitespace-pre-line text-xs leading-6 text-slate-600 dark:text-slate-300">
                            {{ $refund->admin_note }}
                        </p>
                    </div>

                    @if($refund->processor)
                        <div class="mt-4 flex items-center gap-2 text-[10px] text-slate-400">
                            <i class="bi bi-person-check"></i>

                            <span>
                                Diproses oleh
                                <span class="font-semibold text-slate-600 dark:text-slate-300">
                                    {{ $refund->processor->name }}
                                </span>
                            </span>
                        </div>
                    @endif

                </section>
            @endif

        </div>

        {{-- =====================================================
             SIDEBAR
        ====================================================== --}}
        <aside class="space-y-5">

            {{-- -------------------------------------------------
                 ACTION
            -------------------------------------------------- --}}

            @if($refund->status === 'pending')

                <section class="rounded-2xl border border-blue-200 bg-blue-50 p-5 dark:border-blue-900/40 dark:bg-blue-950/20">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                        <i class="bi bi-arrow-counterclockwise text-[15px]"></i>
                    </div>

                    <h2 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">
                        Proses refund
                    </h2>

                    <p class="mt-1.5 text-xs leading-5 text-blue-800/70 dark:text-blue-300/70">
                        Refund ini menunggu diproses oleh Admin.
                    </p>

                    <form
                        action="{{ route('admin.refunds.process', $refund) }}"
                        method="POST"
                        class="mt-5"
                    >
                        @csrf

                        <label
                            for="admin_note"
                            class="block text-[10px] font-bold text-blue-800 dark:text-blue-300"
                        >
                            Catatan
                        </label>

                        <textarea
                            id="admin_note"
                            name="admin_note"
                            rows="4"
                            placeholder="Tambahkan catatan proses refund..."
                            class="mt-2 w-full rounded-xl border border-blue-200 bg-white px-3 py-3 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-blue-900/50 dark:bg-slate-900 dark:text-slate-200 dark:placeholder:text-slate-500"
                        ></textarea>

                        <button
                            type="submit"
                            class="mt-3 flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15"
                        >
                            <i class="bi bi-play-circle"></i>
                            Mulai Proses Refund
                        </button>
                    </form>

                    <form
                        action="{{ route('admin.refunds.reject', $refund) }}"
                        method="POST"
                        class="mt-3"
                        onsubmit="return confirm('Tolak refund ini?');"
                    >
                        @csrf

                        <input
                            type="hidden"
                            name="admin_note"
                            value="Refund ditolak setelah dilakukan pemeriksaan oleh Admin."
                        >

                        <button
                            type="submit"
                            class="flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-4 text-xs font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-900/40 dark:bg-slate-900 dark:text-red-400 dark:hover:bg-red-950/20"
                        >
                            <i class="bi bi-x-circle"></i>
                            Tolak Refund
                        </button>
                    </form>

                </section>

            @elseif($refund->status === 'processing')

                <section class="rounded-2xl border border-blue-200 bg-blue-50 p-5 dark:border-blue-900/40 dark:bg-blue-950/20">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                        <i class="bi bi-arrow-repeat text-[15px]"></i>
                    </div>

                    <h2 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">
                        Refund sedang diproses
                    </h2>

                    <p class="mt-1.5 text-xs leading-5 text-blue-800/70 dark:text-blue-300/70">
                        Setelah pengembalian dana benar-benar dilakukan, Admin dapat menandai refund sebagai selesai.
                    </p>

                    <form
                        action="{{ route('admin.refunds.complete', $refund) }}"
                        method="POST"
                        class="mt-5"
                    >
                        @csrf

                        <label
                            for="complete_note"
                            class="block text-[10px] font-bold text-blue-800 dark:text-blue-300"
                        >
                            Catatan penyelesaian
                        </label>

                        <textarea
                            id="complete_note"
                            name="admin_note"
                            rows="4"
                            placeholder="Contoh: Dana berhasil dikembalikan..."
                            class="mt-2 w-full rounded-xl border border-blue-200 bg-white px-3 py-3 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-500/10 dark:border-blue-900/50 dark:bg-slate-900 dark:text-slate-200 dark:placeholder:text-slate-500"
                        ></textarea>

                        <button
                            type="submit"
                            class="mt-3 flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15"
                        >
                            <i class="bi bi-check2-circle"></i>
                            Tandai Sudah Direfund
                        </button>
                    </form>

                </section>

            @elseif($refund->status === 'refunded')

                <section class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 dark:border-emerald-900/40 dark:bg-emerald-950/20">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                        <i class="bi bi-check-circle-fill text-[15px]"></i>
                    </div>

                    <h2 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">
                        Refund selesai
                    </h2>

                    <p class="mt-1.5 text-xs leading-5 text-emerald-800/70 dark:text-emerald-300/70">
                        Pengembalian dana telah ditandai sebagai berhasil.
                    </p>

                    @if($refund->completed_at)
                        <div class="mt-4 rounded-xl border border-emerald-200/70 bg-white/70 px-3 py-3 dark:border-emerald-900/30 dark:bg-slate-900/40">
                            <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-emerald-600 dark:text-emerald-400">
                                Selesai pada
                            </p>

                            <p class="mt-1.5 text-xs font-semibold text-emerald-800 dark:text-emerald-300">
                                {{ $refund->completed_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @endif

                </section>

            @elseif($refund->status === 'rejected')

                <section class="rounded-2xl border border-red-200 bg-red-50 p-5 dark:border-red-900/40 dark:bg-red-950/20">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm dark:bg-slate-900 dark:text-red-400">
                        <i class="bi bi-x-circle-fill text-[15px]"></i>
                    </div>

                    <h2 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">
                        Refund ditolak
                    </h2>

                    <p class="mt-1.5 text-xs leading-5 text-red-800/70 dark:text-red-300/70">
                        Pengajuan refund ini telah ditolak oleh Admin.
                    </p>

                </section>

            @endif

            {{-- -------------------------------------------------
                 SOURCE
            -------------------------------------------------- --}}
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                    <i class="bi bi-diagram-3 text-sm"></i>
                </div>

                <p class="mt-4 text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                    Sumber
                </p>

                <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                    Asal refund
                </h2>

                <div class="mt-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">

                    <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                        Tipe
                    </p>

                    <p class="mt-2 text-xs font-bold capitalize text-slate-700 dark:text-slate-200">
                        {{ $refund->source_type ?? '-' }}
                    </p>

                    <div class="mt-3 border-t border-slate-200 pt-3 dark:border-slate-800">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            ID sumber
                        </p>

                        <p class="mt-1 break-all text-[10px] font-medium text-slate-500 dark:text-slate-400">
                            {{ $refund->source_id ?? '-' }}
                        </p>
                    </div>

                </div>

            </section>

        </aside>

    </div>
</div>


</x-layouts.admin>
