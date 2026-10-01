<x-layouts.admin title="Detail Verifikasi Freelancer">


@php
    $statusConfig = [
        'pending' => [
            'label' => 'Menunggu Review',
            'class' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-900/40 dark:bg-amber-950/30 dark:text-amber-300',
            'dot' => 'bg-amber-500',
            'icon' => 'bi-hourglass-split',
        ],
        'verified' => [
            'label' => 'Terverifikasi',
            'class' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900/40 dark:bg-emerald-950/30 dark:text-emerald-300',
            'dot' => 'bg-emerald-500',
            'icon' => 'bi-patch-check-fill',
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'class' => 'border-red-200 bg-red-50 text-red-700 dark:border-red-900/40 dark:bg-red-950/30 dark:text-red-300',
            'dot' => 'bg-red-500',
            'icon' => 'bi-x-circle-fill',
        ],
    ];

    $status = $statusConfig[$verification->status] ?? [
        'label' => ucfirst($verification->status ?? 'Unknown'),
        'class' => 'border-slate-200 bg-slate-100 text-slate-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300',
        'dot' => 'bg-slate-400',
        'icon' => 'bi-question-circle',
    ];

    $user = $verification->freelancerProfile?->user;

    $displayName = $user?->name
        ?? $verification->full_name
        ?? 'Freelancer';

    $initials = collect(explode(' ', trim($displayName)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->implode('');
@endphp

<div class="mx-auto max-w-6xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

        <div class="min-w-0">

            <a
                href="{{ route('admin.verifications.index') }}"
                class="inline-flex items-center gap-2 text-[10px] font-semibold text-slate-400 transition hover:text-blue-600 dark:text-slate-500 dark:hover:text-blue-400 sm:text-xs"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke verifikasi
            </a>

            <div class="mt-5 flex flex-wrap items-center gap-2">

                <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 dark:border-blue-900/40 dark:bg-blue-950/30">
                    <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                    <span class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-700 dark:text-blue-300">
                        Manajemen Freelancer
                    </span>
                </div>

                <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-[9px] font-bold {{ $status['class'] }}">
                    <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                    <i class="bi {{ $status['icon'] }}"></i>
                    {{ $status['label'] }}
                </span>

            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Detail Verifikasi
            </h1>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Periksa data freelancer sebelum mengambil keputusan.
            </p>

        </div>

        <div class="hidden h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/20 sm:flex">
            <i class="bi bi-patch-check-fill text-lg"></i>
        </div>

    </div>

    {{-- =========================================================
         SUCCESS
    ========================================================== --}}
    @if (session('success'))
        <div class="overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50 dark:border-emerald-900/40 dark:bg-emerald-950/30">

            <div class="flex items-start gap-3 px-5 py-4">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                    <i class="bi bi-check-circle-fill"></i>
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
         ERRORS
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
         PROFILE
    ========================================================== --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                    <i class="bi bi-person-badge-fill"></i>
                </div>

                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                        Freelancer
                    </p>

                    <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                        Profil Pemohon
                    </h2>
                </div>

            </div>

        </div>

        <div class="p-5 sm:p-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                    {{ $initials ?: 'FR' }}
                </div>

                <div class="min-w-0">

                    <p class="truncate text-base font-bold text-slate-900 dark:text-white sm:text-lg">
                        {{ $displayName }}
                    </p>

                    <p class="mt-1 truncate text-xs text-slate-400">
                        {{ $user?->email ?? '-' }}
                    </p>

                    @if ($verification->freelancerProfile?->username)
                        <p class="mt-1 text-[10px] font-semibold text-blue-600 dark:text-blue-400">
                            {{ '@' . $verification->freelancerProfile->username }}
                        </p>
                    @endif

                </div>

            </div>

        </div>

    </section>

    {{-- =========================================================
         MAIN GRID
    ========================================================== --}}
    <div class="grid gap-5 lg:grid-cols-2">

        {{-- =====================================================
             IDENTITY
        ====================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                        <i class="bi bi-person-vcard"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                            Data Identitas
                        </h2>

                        <p class="mt-0.5 text-[10px] text-slate-400 dark:text-slate-500">
                            Data yang dikirim freelancer
                        </p>
                    </div>

                </div>

            </div>

            <dl class="divide-y divide-slate-100 dark:divide-slate-800">

                <div class="px-5 py-4 sm:px-6">
                    <dt class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                        Nama Lengkap
                    </dt>

                    <dd class="mt-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300">
                        {{ $verification->full_name }}
                    </dd>
                </div>

                <div class="px-5 py-4 sm:px-6">
                    <dt class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                        Jenis Identitas
                    </dt>

                    <dd class="mt-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300">
                        {{ $verification->identity_type }}
                    </dd>
                </div>

                <div class="px-5 py-4 sm:px-6">
                    <dt class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                        Nomor Identitas
                    </dt>

                    <dd class="mt-1.5 break-all text-xs font-semibold text-slate-700 dark:text-slate-300">
                        {{ $verification->identity_number }}
                    </dd>
                </div>

            </dl>

        </section>

        {{-- =====================================================
             BANK
        ====================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                        <i class="bi bi-bank2"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                            Rekening Bank
                        </h2>

                        <p class="mt-0.5 text-[10px] text-slate-400 dark:text-slate-500">
                            Data rekening untuk withdrawal
                        </p>
                    </div>

                </div>

            </div>

            <dl class="divide-y divide-slate-100 dark:divide-slate-800">

                <div class="px-5 py-4 sm:px-6">
                    <dt class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                        Bank
                    </dt>

                    <dd class="mt-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300">
                        {{ $verification->bank_name }}
                    </dd>
                </div>

                <div class="px-5 py-4 sm:px-6">
                    <dt class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                        Nama Pemilik
                    </dt>

                    <dd class="mt-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300">
                        {{ $verification->bank_account_name }}
                    </dd>
                </div>

                <div class="px-5 py-4 sm:px-6">
                    <dt class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                        Nomor Rekening
                    </dt>

                    <dd class="mt-1.5 break-all text-xs font-semibold text-slate-700 dark:text-slate-300">
                        {{ $verification->bank_account_number }}
                    </dd>
                </div>

            </dl>

        </section>

    </div>

    {{-- =========================================================
         DOCUMENT
    ========================================================== --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                        <i class="bi bi-file-earmark-image"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                            Dokumen Identitas
                        </h2>

                        <p class="mt-1 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                            Dokumen hanya dapat diakses Admin melalui route private.
                        </p>
                    </div>

                </div>

                @if ($verification->identity_document_path)

                    <a
                        href="{{ route('admin.verifications.document', $verification) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-xs font-semibold text-blue-600 transition hover:border-blue-200 hover:bg-blue-50 dark:border-slate-700 dark:bg-slate-900 dark:text-blue-400 dark:hover:border-blue-900 dark:hover:bg-blue-950/20 sm:w-auto"
                    >
                        <i class="bi bi-eye"></i>
                        Lihat Dokumen
                    </a>

                @endif

            </div>

        </div>

        <div class="p-5 sm:p-6">

            @if ($verification->identity_document_path)

                <div class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50 p-4 dark:border-blue-900/40 dark:bg-blue-950/20">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>

                    <div class="min-w-0">

                        <p class="text-xs font-semibold text-blue-800 dark:text-blue-300">
                            Dokumen tersedia
                        </p>

                        <p class="mt-0.5 truncate text-[10px] text-blue-700/70 dark:text-blue-400/70">
                            {{ $verification->identity_document_path }}
                        </p>

                    </div>

                </div>

            @else

                <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm dark:bg-slate-900 dark:text-slate-500">
                        <i class="bi bi-file-earmark-x"></i>
                    </div>

                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Dokumen identitas tidak tersedia.
                    </p>

                </div>

            @endif

            @if ($verification->rejection_reason)

                <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 p-4 dark:border-red-900/40 dark:bg-red-950/30">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm dark:bg-slate-900 dark:text-red-400">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>

                        <div class="min-w-0">

                            <p class="text-xs font-bold text-red-800 dark:text-red-300">
                                Alasan Penolakan
                            </p>

                            <p class="mt-1.5 whitespace-pre-line text-xs leading-6 text-red-700 dark:text-red-400">
                                {{ $verification->rejection_reason }}
                            </p>

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </section>

    {{-- =========================================================
         DECISION / REVIEW
    ========================================================== --}}
    @if ($verification->status === 'pending')

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                            Keputusan Admin
                        </h2>

                        <p class="mt-1 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                            Pilih tindakan setelah memeriksa data identitas dan rekening.
                        </p>
                    </div>

                </div>

            </div>

            <div class="grid gap-4 p-5 sm:p-6 lg:grid-cols-2">

                {{-- APPROVE --}}
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 dark:border-emerald-900/40 dark:bg-emerald-950/20">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">
                        Verifikasi Freelancer
                    </h3>

                    <p class="mt-1.5 text-xs leading-5 text-emerald-800/70 dark:text-emerald-300/70">
                        Tandai pengajuan sebagai terverifikasi setelah data dinyatakan sesuai.
                    </p>

                    <form
                        action="{{ route('admin.verifications.approve', $verification) }}"
                        method="POST"
                        class="mt-5"
                    >
                        @csrf

                        <button
                            type="submit"
                            onclick="return confirm('Verifikasi freelancer ini?')"
                            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15"
                        >
                            <i class="bi bi-patch-check"></i>
                            Verifikasi Freelancer
                        </button>

                    </form>

                </div>

                {{-- REJECT --}}
                <div class="rounded-2xl border border-red-200 bg-red-50 p-5 dark:border-red-900/40 dark:bg-red-950/20">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm dark:bg-slate-900 dark:text-red-400">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">
                        Tolak Pengajuan
                    </h3>

                    <p class="mt-1.5 text-xs leading-5 text-red-800/70 dark:text-red-300/70">
                        Berikan alasan yang jelas apabila data belum memenuhi persyaratan.
                    </p>

                    <form
                        action="{{ route('admin.verifications.reject', $verification) }}"
                        method="POST"
                        class="mt-5 space-y-3"
                    >
                        @csrf

                        <textarea
                            name="rejection_reason"
                            rows="4"
                            placeholder="Alasan penolakan..."
                            class="w-full rounded-xl border border-red-200 bg-white px-4 py-3 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-red-400 focus:ring-4 focus:ring-red-500/10 dark:border-red-900/40 dark:bg-slate-900 dark:text-slate-200 dark:placeholder:text-slate-500"
                            required
                        >{{ old('rejection_reason') }}</textarea>

                        <button
                            type="submit"
                            onclick="return confirm('Tolak pengajuan verifikasi ini?')"
                            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-5 text-xs font-semibold text-red-600 transition hover:bg-red-50 focus:outline-none focus:ring-4 focus:ring-red-500/10 dark:border-red-900/40 dark:bg-slate-900 dark:text-red-400 dark:hover:bg-red-950/20"
                        >
                            <i class="bi bi-x-circle"></i>
                            Tolak Pengajuan
                        </button>

                    </form>

                </div>

            </div>

        </section>

    @else

        {{-- REVIEW RESULT --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                        <i class="bi bi-clock-history"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                            Riwayat Review
                        </h2>

                        <p class="mt-0.5 text-[10px] text-slate-400 dark:text-slate-500">
                            Informasi keputusan verifikasi
                        </p>
                    </div>

                </div>

            </div>

            <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-6">

                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">

                    <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                        Direview Pada
                    </p>

                    <p class="mt-2 text-xs font-bold text-slate-700 dark:text-slate-300">
                        {{ $verification->reviewed_at?->format('d M Y H:i') ?? '-' }}
                    </p>

                </div>

                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">

                    <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                        Reviewer
                    </p>

                    <p class="mt-2 text-xs font-bold text-slate-700 dark:text-slate-300">
                        {{ $verification->reviewer?->name ?? '-' }}
                    </p>

                </div>

            </div>

        </section>

    @endif

</div>


</x-layouts.admin>
