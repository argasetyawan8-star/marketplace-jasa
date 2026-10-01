<x-layouts.admin title="Detail Penarikan">


@php
    $statusMap = [
        'pending' => [
            'label' => 'Menunggu',
            'class' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-900/40 dark:bg-amber-950/30 dark:text-amber-300',
            'icon' => 'bi-hourglass-split',
        ],
        'processing' => [
            'label' => 'Diproses',
            'class' => 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-900/40 dark:bg-blue-950/30 dark:text-blue-300',
            'icon' => 'bi-arrow-repeat',
        ],
        'approved' => [
            'label' => 'Disetujui',
            'class' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900/40 dark:bg-emerald-950/30 dark:text-emerald-300',
            'icon' => 'bi-check-circle-fill',
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'class' => 'border-red-200 bg-red-50 text-red-700 dark:border-red-900/40 dark:bg-red-950/30 dark:text-red-300',
            'icon' => 'bi-x-circle-fill',
        ],
    ];

    $withdrawalStatus = $statusMap[$withdrawal->status] ?? [
        'label' => ucfirst(str_replace('_', ' ', $withdrawal->status ?? 'Unknown')),
        'class' => 'border-slate-200 bg-slate-100 text-slate-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
        'icon' => 'bi-question-circle',
    ];

    /* =========================================================
     * FREELANCER
     * ======================================================= */
    $freelancer = $withdrawal->freelancerProfile;
    $freelancerUser = $freelancer?->user;
    $freelancerAvatar = $freelancer?->avatar;

    $freelancerAvatarUrl = null;

    if ($freelancerAvatar) {
        $freelancerAvatarUrl =
            str_starts_with($freelancerAvatar, 'http://')
            || str_starts_with($freelancerAvatar, 'https://')
            ? $freelancerAvatar
            : asset('storage/' . ltrim($freelancerAvatar, '/'));
    }

    $freelancerName = $freelancerUser?->name ?? 'Freelancer tidak tersedia';

    $freelancerInitials = collect(explode(' ', trim($freelancerName)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->implode('');
@endphp

<div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div class="min-w-0">

            <a
                href="{{ route('admin.withdrawals.index') }}"
                class="inline-flex items-center gap-2 text-[10px] font-semibold text-slate-400 transition hover:text-blue-600 dark:text-slate-500 dark:hover:text-blue-400 sm:text-xs"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke penarikan
            </a>

            <div class="mt-5 flex flex-wrap items-center gap-2">

                <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 dark:border-blue-900/40 dark:bg-blue-950/30">
                    <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                    <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-700 dark:text-blue-300">
                        Detail Penarikan
                    </p>
                </div>

                <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-[9px] font-bold {{ $withdrawalStatus['class'] }}">
                    <i class="bi {{ $withdrawalStatus['icon'] }}"></i>
                    {{ $withdrawalStatus['label'] }}
                </span>

            </div>

            <h1 class="mt-3 break-all text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Penarikan #{{ $withdrawal->id }}
            </h1>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Pengajuan penarikan saldo freelancer.
            </p>

        </div>

        {{-- NET AMOUNT --}}
        <div class="w-full rounded-2xl border border-blue-100 bg-blue-50 p-4 shadow-sm dark:border-blue-900/40 dark:bg-blue-950/20 sm:w-auto sm:min-w-[250px] sm:p-5">

            <div class="flex items-center justify-between gap-4">

                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-blue-600 dark:text-blue-400">
                        Net Amount
                    </p>

                    <p class="mt-1 text-2xl font-bold tracking-tight text-blue-700 dark:text-blue-300">
                        Rp {{ number_format((float) $withdrawal->net_amount, 0, ',', '.') }}
                    </p>

                    <p class="mt-1 text-[10px] text-blue-600/70 dark:text-blue-400/70">
                        Dana yang diterima freelancer
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                    <i class="bi bi-wallet2 text-lg"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
         SUCCESS
    ========================================================== --}}
    @if (session('success'))
        <div class="overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50 dark:border-emerald-900/40 dark:bg-emerald-950/30">
            <div class="flex items-start gap-3 px-5 py-4">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold text-emerald-800 dark:text-emerald-300">
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
    @if ($errors->any())
        <div class="overflow-hidden rounded-2xl border border-red-200 bg-red-50 dark:border-red-900/40 dark:bg-red-950/30">
            <div class="flex items-start gap-3 px-5 py-4">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm dark:bg-slate-900 dark:text-red-400">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold text-red-800 dark:text-red-300">
                        Periksa kembali data
                    </p>

                    <ul class="mt-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-xs leading-5 text-red-700 dark:text-red-400">
                                • {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    @endif

    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">

        {{-- =====================================================
             LEFT
        ====================================================== --}}
        <div class="space-y-6">

            {{-- =================================================
                 FREELANCER
            ================================================== --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                                Freelancer
                            </h2>

                            <p class="mt-0.5 text-[10px] text-slate-400 dark:text-slate-500">
                                Pemilik saldo
                            </p>
                        </div>

                    </div>

                </div>

                <div class="p-5 sm:p-6">

                    <div class="flex items-center gap-4">

                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full border-2 border-white bg-blue-50 shadow-sm dark:border-slate-700 dark:bg-blue-950/30">

                            @if ($freelancerAvatarUrl)

                                <img
                                    src="{{ $freelancerAvatarUrl }}"
                                    alt="{{ $freelancerName }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                <div class="flex h-full w-full items-center justify-center text-sm font-bold text-blue-600 dark:text-blue-400">
                                    {{ $freelancerInitials ?: 'FR' }}
                                </div>

                            @endif

                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="truncate text-sm font-bold text-slate-900 dark:text-white">
                                {{ $freelancerName }}
                            </p>

                            @if ($freelancerUser?->email)
                                <p class="mt-1 truncate text-xs text-slate-400">
                                    {{ $freelancerUser->email }}
                                </p>
                            @endif

                            @if ($freelancer?->username)
                                <p class="mt-1 truncate text-[10px] font-semibold text-blue-600 dark:text-blue-400">
                                    {{ '@' . $freelancer->username }}
                                </p>
                            @endif

                        </div>

                    </div>

                </div>

            </section>

            {{-- =================================================
                 WITHDRAWAL INFORMATION
            ================================================== --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                            <i class="bi bi-bank2"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                                Informasi Penarikan
                            </h2>

                            <p class="mt-0.5 text-[10px] text-slate-400 dark:text-slate-500">
                                Detail rekening dan metode pencairan
                            </p>
                        </div>

                    </div>

                </div>

                <div class="grid grid-cols-1 gap-3 p-5 sm:grid-cols-2 sm:p-6">

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Metode
                        </p>

                        <div class="mt-2 flex items-center gap-2">

                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                                <i class="bi bi-credit-card text-xs"></i>
                            </div>

                            <p class="text-xs font-bold uppercase text-slate-700 dark:text-slate-200">
                                {{ strtoupper($withdrawal->method ?? '-') }}
                            </p>

                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Nama Rekening
                        </p>

                        <p class="mt-2 break-words text-xs font-bold text-slate-700 dark:text-slate-200">
                            {{ $withdrawal->account_name ?: '-' }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Nomor Rekening
                        </p>

                        <p class="mt-2 break-all text-xs font-bold text-slate-700 dark:text-slate-200">
                            {{ $withdrawal->account_number ?: '-' }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">
                        <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Diproses
                        </p>

                        <p class="mt-2 text-xs font-bold text-slate-700 dark:text-slate-200">
                            {{ $withdrawal->processed_at?->format('d M Y, H:i') ?? '-' }}
                        </p>
                    </div>

                </div>

            </section>

            {{-- =================================================
                 NOTE
            ================================================== --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                            <i class="bi bi-chat-square-text-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                                Catatan
                            </h2>

                            <p class="mt-0.5 text-[10px] text-slate-400 dark:text-slate-500">
                                Informasi tambahan dari freelancer
                            </p>
                        </div>

                    </div>

                </div>

                <div class="p-5 sm:p-6">

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">

                        @if ($withdrawal->note)

                            <p class="whitespace-pre-line text-xs leading-6 text-slate-600 dark:text-slate-300">
                                {{ $withdrawal->note }}
                            </p>

                        @else

                            <div class="flex items-center gap-3 text-slate-400 dark:text-slate-500">
                                <i class="bi bi-chat-square-dots"></i>

                                <p class="text-xs">
                                    Tidak ada catatan tambahan.
                                </p>
                            </div>

                        @endif

                    </div>

                </div>

            </section>

            {{-- =================================================
                 REJECTION
            ================================================== --}}
            @if ($withdrawal->rejection_reason)

                <section class="overflow-hidden rounded-2xl border border-red-200 bg-red-50 dark:border-red-900/40 dark:bg-red-950/30">

                    <div class="p-5 sm:p-6">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm dark:bg-slate-900 dark:text-red-400">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-xs font-bold text-red-800 dark:text-red-300">
                                    Alasan Penolakan
                                </p>

                                <p class="mt-2 whitespace-pre-line text-xs leading-6 text-red-700 dark:text-red-400">
                                    {{ $withdrawal->rejection_reason }}
                                </p>

                            </div>

                        </div>

                    </div>

                </section>

            @endif

        </div>

        {{-- =====================================================
             RIGHT SIDEBAR
        ====================================================== --}}
        <div class="space-y-6">

            {{-- =================================================
                 FINANCIAL SUMMARY
            ================================================== --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                            <i class="bi bi-calculator"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                                Rincian Nominal
                            </h2>

                            <p class="mt-0.5 text-[10px] text-slate-400 dark:text-slate-500">
                                Perhitungan pencairan
                            </p>
                        </div>

                    </div>

                </div>

                <div class="p-5 sm:p-6">

                    <div class="space-y-4">

                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs text-slate-400">
                                    Pengajuan
                                </p>

                                <p class="mt-1 text-[10px] text-slate-400">
                                    Jumlah yang diajukan
                                </p>
                            </div>

                            <p class="text-right text-xs font-bold text-slate-800 dark:text-slate-200">
                                Rp {{ number_format((float) $withdrawal->amount, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs text-slate-400">
                                    Fee Admin
                                </p>

                                <p class="mt-1 text-[10px] text-slate-400">
                                    Biaya administrasi
                                </p>
                            </div>

                            <p class="text-right text-xs font-bold text-slate-800 dark:text-slate-200">
                                Rp {{ number_format((float) $withdrawal->admin_fee, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900/40 dark:bg-blue-950/20">

                            <div class="flex items-center justify-between gap-4">

                                <div>
                                    <p class="text-xs font-bold text-blue-700 dark:text-blue-300">
                                        Net Amount
                                    </p>

                                    <p class="mt-1 text-[10px] text-blue-600/70 dark:text-blue-400/70">
                                        Diterima freelancer
                                    </p>
                                </div>

                                <p class="text-right text-base font-bold text-blue-700 dark:text-blue-300">
                                    Rp {{ number_format((float) $withdrawal->net_amount, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

            {{-- =================================================
                 PROCESSING
            ================================================== --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                                Proses Penarikan
                            </h2>

                            <p class="mt-0.5 text-[10px] text-slate-400 dark:text-slate-500">
                                Perbarui status pengajuan
                            </p>
                        </div>

                    </div>

                </div>

                <div class="p-5 sm:p-6">

                    <form
                        action="{{ route('admin.withdrawals.update', $withdrawal) }}"
                        method="POST"
                        class="space-y-5"
                    >
                        @csrf
                        @method('PATCH')

                        {{-- STATUS --}}
                        <div>

                            <label
                                for="status"
                                class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                            >
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs text-slate-700 outline-none transition hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                            >

                                <option value="pending" @selected(old('status', $withdrawal->status) === 'pending')>
                                    Menunggu
                                </option>

                                <option value="processing" @selected(old('status', $withdrawal->status) === 'processing')>
                                    Diproses
                                </option>

                                <option value="approved" @selected(old('status', $withdrawal->status) === 'approved')>
                                    Disetujui
                                </option>

                                <option value="rejected" @selected(old('status', $withdrawal->status) === 'rejected')>
                                    Ditolak
                                </option>

                            </select>

                        </div>

                        {{-- REJECTION --}}
                        <div>

                            <label
                                for="rejection_reason"
                                class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                            >
                                Alasan Penolakan
                                <span class="font-normal text-slate-400">
                                    (opsional)
                                </span>
                            </label>

                            <textarea
                                id="rejection_reason"
                                name="rejection_reason"
                                rows="4"
                                placeholder="Tulis alasan apabila pengajuan ditolak..."
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                            >{{ old('rejection_reason', $withdrawal->rejection_reason) }}</textarea>

                        </div>

                        {{-- BUTTON --}}
                        <button
                            type="submit"
                            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15"
                        >
                            <i class="bi bi-check2-circle"></i>
                            Simpan Status
                        </button>

                    </form>

                </div>

            </section>

            {{-- =================================================
                 WARNING
            ================================================== --}}
            <section class="overflow-hidden rounded-2xl border border-amber-200 bg-amber-50 dark:border-amber-900/40 dark:bg-amber-950/20">

                <div class="p-5 sm:p-6">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm dark:bg-slate-900 dark:text-amber-400">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>

                        <div class="min-w-0">

                            <p class="text-xs font-bold text-amber-800 dark:text-amber-300">
                                Perhatian
                            </p>

                            <p class="mt-1.5 text-xs leading-6 text-amber-800/70 dark:text-amber-300/70">
                                Persetujuan penarikan di halaman ini adalah pencatatan status. Proses transfer dana ke rekening freelancer akan dihubungkan ke sistem pembayaran pada tahap integrasi berikutnya.
                            </p>

                        </div>

                    </div>

                </div>

            </section>

            {{-- =================================================
                 SYSTEM INFORMATION
            ================================================== --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950/50">

                <div class="p-5 sm:p-6">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="text-xs font-bold text-slate-800 dark:text-slate-200">
                                Informasi Sistem
                            </p>

                            <div class="mt-4 space-y-3">

                                <div class="flex items-center justify-between gap-4 border-b border-slate-200 pb-3 dark:border-slate-800">
                                    <span class="text-[10px] text-slate-400">
                                        ID
                                    </span>

                                    <span class="break-all text-right text-[10px] font-semibold text-slate-600 dark:text-slate-300">
                                        #{{ $withdrawal->id }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-4 border-b border-slate-200 pb-3 dark:border-slate-800">
                                    <span class="text-[10px] text-slate-400">
                                        Dibuat
                                    </span>

                                    <span class="text-right text-[10px] font-semibold text-slate-600 dark:text-slate-300">
                                        {{ $withdrawal->created_at?->format('d M Y, H:i') ?? '-' }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-[10px] text-slate-400">
                                        Diperbarui
                                    </span>

                                    <span class="text-right text-[10px] font-semibold text-slate-600 dark:text-slate-300">
                                        {{ $withdrawal->updated_at?->format('d M Y, H:i') ?? '-' }}
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

    </div>

</div>


</x-layouts.admin>
