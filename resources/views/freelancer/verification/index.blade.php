<x-layouts.freelancer title="Verifikasi Freelancer">


@php
    $verificationStatus = $verification?->status;
@endphp

<div class="min-h-screen bg-slate-50/70">
    <div class="mx-auto max-w-6xl px-4 py-5 pb-24 sm:px-6 sm:py-7 lg:px-8 lg:py-8">

        {{-- =========================================================
            PAGE HEADER
        ========================================================== --}}
        <div class="mb-6 lg:mb-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="min-w-0">
                    <div class="flex items-start gap-3.5">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                            <i class="bi bi-patch-check-fill text-lg"></i>
                        </div>

                        <div class="min-w-0">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-blue-600 sm:text-[11px]">
                                Keamanan akun
                            </p>

                            <h1 class="mt-1 text-xl font-bold tracking-[-0.03em] text-slate-900 sm:text-2xl">
                                Verifikasi Freelancer
                            </h1>

                            <p class="mt-1.5 max-w-2xl text-sm leading-6 text-slate-500">
                                Verifikasi identitas dan rekening agar akun freelancer kamu lebih terpercaya di ProKerja.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="shrink-0">
                    <a
                        href="{{ route('freelancer.dashboard') }}"
                        class="inline-flex h-10 w-auto shrink-0 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-600 shadow-sm transition duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                    >
                        <i class="bi bi-arrow-left text-xs"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        {{-- =========================================================
            FLASH / VALIDATION
        ========================================================== --}}
        <div class="space-y-3">

            @if (session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 sm:px-5">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm ring-1 ring-emerald-100">
                            <i class="bi bi-check-circle-fill text-sm"></i>
                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-emerald-900">
                                Berhasil
                            </p>

                            <p class="mt-0.5 text-xs leading-5 text-emerald-700 sm:text-sm">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3.5 sm:px-5">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm ring-1 ring-blue-100">
                            <i class="bi bi-info-circle-fill text-sm"></i>
                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-blue-900">
                                Informasi
                            </p>

                            <p class="mt-0.5 text-xs leading-5 text-blue-700 sm:text-sm">
                                {{ session('info') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-4 sm:px-5">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm ring-1 ring-red-100">
                            <i class="bi bi-exclamation-triangle-fill text-sm"></i>
                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-red-900">
                                Periksa kembali data yang kamu masukkan.
                            </p>

                            <ul class="mt-2 space-y-1.5 text-xs leading-5 text-red-700 sm:text-sm">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-[7px] h-1 w-1 shrink-0 rounded-full bg-red-500"></span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        {{-- =========================================================
            STATUS
        ========================================================== --}}
        @if ($verification)
            <section class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_10px_35px_rgba(15,23,42,0.04)]">

                <div class="border-b border-slate-100 px-5 py-5 sm:px-6 lg:px-7">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">
                                    Status verifikasi
                                </p>

                                @if ($verificationStatus === 'verified')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>

                                @elseif ($verificationStatus === 'pending')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Dalam proses
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-[10px] font-semibold text-red-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        Perlu diperbaiki
                                    </span>

                                @endif
                            </div>

                            <div class="mt-2">
                                @if ($verificationStatus === 'verified')

                                    <h2 class="text-base font-bold tracking-[-0.02em] text-slate-900 sm:text-lg">
                                        Akun kamu sudah terverifikasi
                                    </h2>

                                    <p class="mt-1 text-xs leading-5 text-slate-500 sm:text-sm">
                                        Identitas dan rekening kamu telah berhasil diperiksa oleh Admin ProKerja.
                                    </p>

                                @elseif ($verificationStatus === 'pending')

                                    <h2 class="text-base font-bold tracking-[-0.02em] text-slate-900 sm:text-lg">
                                        Pengajuan sedang ditinjau
                                    </h2>

                                    <p class="mt-1 text-xs leading-5 text-slate-500 sm:text-sm">
                                        Data yang kamu kirim sedang diperiksa. Tunggu sampai proses review selesai.
                                    </p>

                                @else

                                    <h2 class="text-base font-bold tracking-[-0.02em] text-slate-900 sm:text-lg">
                                        Pengajuan belum disetujui
                                    </h2>

                                    <p class="mt-1 text-xs leading-5 text-slate-500 sm:text-sm">
                                        Periksa alasan penolakan di bawah, lalu lakukan pengajuan kembali dengan data yang sesuai.
                                    </p>

                                @endif
                            </div>
                        </div>

                        <div class="shrink-0">
                            @if ($verificationStatus === 'verified')
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100 sm:h-14 sm:w-14">
                                    <i class="bi bi-shield-check text-xl sm:text-2xl"></i>
                                </div>

                            @elseif ($verificationStatus === 'pending')
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 ring-1 ring-amber-100 sm:h-14 sm:w-14">
                                    <i class="bi bi-hourglass-split text-xl sm:text-2xl"></i>
                                </div>

                            @else
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-600 ring-1 ring-red-100 sm:h-14 sm:w-14">
                                    <i class="bi bi-arrow-repeat text-xl sm:text-2xl"></i>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                @if ($verificationStatus === 'rejected')
                    <div class="bg-red-50/80 px-5 py-5 sm:px-6 lg:px-7">
                        <div class="rounded-2xl border border-red-100 bg-white px-4 py-4 shadow-sm sm:px-5">
                            <div class="flex items-start gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
                                    <i class="bi bi-chat-left-text-fill text-sm"></i>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-[0.12em] text-red-500">
                                        Alasan penolakan
                                    </p>

                                    <p class="mt-1.5 text-sm leading-6 text-slate-700">
                                        {{ $verification->rejection_reason ?: 'Tidak ada alasan yang diberikan.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </section>
        @endif

        {{-- =========================================================
            VERIFIED
        ========================================================== --}}
        @if ($verificationStatus === 'verified')

            <section class="mt-6 rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 via-white to-white p-5 shadow-[0_10px_35px_rgba(37,99,235,0.05)] sm:p-6 lg:p-7">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-start">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-sm shadow-blue-200">
                        <i class="bi bi-shield-check text-xl"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600">
                            Verifikasi berhasil
                        </p>

                        <h2 class="mt-1.5 text-lg font-bold tracking-[-0.02em] text-slate-900 sm:text-xl">
                            Profil freelancer kamu sudah lebih terpercaya.
                        </h2>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                            Data identitas dan rekening telah diverifikasi oleh Admin. Status ini membantu memberikan kepercayaan lebih saat client melihat profil kamu di ProKerja.
                        </p>
                    </div>

                </div>
            </section>

        @elseif ($verificationStatus === 'pending')

            <section class="mt-6 rounded-3xl border border-amber-100 bg-gradient-to-br from-amber-50 via-white to-white p-5 shadow-[0_10px_35px_rgba(245,158,11,0.04)] sm:p-6 lg:p-7">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-start">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-500 text-white shadow-sm shadow-amber-200">
                        <i class="bi bi-clock-history text-xl"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-amber-600">
                            Sedang diproses
                        </p>

                        <h2 class="mt-1.5 text-lg font-bold tracking-[-0.02em] text-slate-900 sm:text-xl">
                            Tidak perlu mengirim ulang untuk saat ini.
                        </h2>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                            Pengajuanmu sudah diterima dan sedang diperiksa oleh Admin. Cek kembali halaman ini setelah proses review selesai.
                        </p>
                    </div>

                </div>
            </section>

        @else

            {{-- =====================================================
                FORM LAYOUT
            ====================================================== --}}
            <div class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_290px] lg:items-start">

                {{-- =================================================
                    MAIN FORM
                ================================================== --}}
                <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_10px_35px_rgba(15,23,42,0.04)]">

                    <div class="border-b border-slate-100 px-5 py-5 sm:px-6 lg:px-7">
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <i class="bi bi-file-earmark-lock2 text-base"></i>
                            </div>

                            <div class="min-w-0">
                                <h2 class="text-base font-bold tracking-[-0.02em] text-slate-900 sm:text-lg">
                                    Data Verifikasi
                                </h2>

                                <p class="mt-1 text-xs leading-5 text-slate-500 sm:text-sm">
                                    Isi data sesuai identitas resmi dan rekening yang benar-benar kamu gunakan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form
                        action="{{ route('freelancer.verification.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="divide-y divide-slate-100"
                    >
                        @csrf

                        {{-- =========================================
                            IDENTITAS
                        ========================================== --}}
                        <section class="px-5 py-6 sm:px-6 lg:px-7 lg:py-7">
                            <div class="mb-5">
                                <div class="flex items-center gap-2.5">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-[11px] font-bold text-blue-600">
                                        01
                                    </span>

                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                                            Identitas
                                        </h3>

                                        <p class="mt-0.5 text-[11px] leading-5 text-slate-400 sm:text-xs">
                                            Data harus sesuai dengan dokumen resmi yang kamu unggah.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">

                                {{-- Full Name --}}
                                <div class="md:col-span-2">
                                    <label
                                        for="full_name"
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                    >
                                        Nama lengkap
                                    </label>

                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex w-11 items-center justify-center text-slate-400">
                                            <i class="bi bi-person text-sm"></i>
                                        </span>

                                        <input
                                            id="full_name"
                                            name="full_name"
                                            type="text"
                                            value="{{ old('full_name') }}"
                                            placeholder="Nama sesuai identitas"
                                            class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50"
                                            required
                                        >
                                    </div>

                                    @error('full_name')
                                        <p class="mt-2 text-xs font-medium text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Identity Type --}}
                                <div>
                                    <label
                                        for="identity_type"
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                    >
                                        Jenis identitas
                                    </label>

                                    <div class="relative">
                                        <select
                                            id="identity_type"
                                            name="identity_type"
                                            class="h-12 w-full appearance-none rounded-xl border border-slate-200 bg-slate-50/70 px-4 pr-10 text-sm text-slate-900 outline-none transition hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50"
                                            required
                                        >
                                            <option value="KTP">
                                                KTP
                                            </option>
                                        </select>

                                        <i class="bi bi-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                    </div>

                                    @error('identity_type')
                                        <p class="mt-2 text-xs font-medium text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Identity Number --}}
                                <div>
                                    <label
                                        for="identity_number"
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                    >
                                        Nomor identitas
                                    </label>

                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex w-11 items-center justify-center text-slate-400">
                                            <i class="bi bi-credit-card-2-front text-sm"></i>
                                        </span>

                                        <input
                                            id="identity_number"
                                            name="identity_number"
                                            type="text"
                                            inputmode="numeric"
                                            value="{{ old('identity_number') }}"
                                            placeholder="Masukkan nomor KTP"
                                            class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50"
                                            required
                                        >
                                    </div>

                                    <p class="mt-2 flex items-start gap-1.5 text-[11px] leading-5 text-slate-400">
                                        <i class="bi bi-lock-fill mt-[2px] shrink-0"></i>
                                        Nomor identitas disimpan dalam bentuk terenkripsi.
                                    </p>

                                    @error('identity_number')
                                        <p class="mt-2 text-xs font-medium text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Identity Document --}}
                                <div class="md:col-span-2">
                                    <label
                                        for="identity_document"
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                    >
                                        Foto dokumen identitas
                                    </label>

                                    <label
                                        for="identity_document"
                                        class="group flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-blue-200 bg-blue-50/40 px-5 py-8 text-center transition duration-200 hover:border-blue-400 hover:bg-blue-50 sm:py-10"
                                    >
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-blue-600 shadow-sm ring-1 ring-blue-100 transition duration-200 group-hover:-translate-y-0.5 group-hover:shadow-md">
                                            <i class="bi bi-cloud-arrow-up text-xl"></i>
                                        </div>

                                        <p class="mt-3 text-sm font-bold text-slate-800">
                                            Klik untuk memilih foto KTP
                                        </p>

                                        <p class="mt-1 max-w-sm text-xs leading-5 text-slate-400">
                                            Gunakan foto yang jelas, tidak blur, dan seluruh bagian dokumen terlihat.
                                        </p>

                                        <span class="mt-3 inline-flex items-center rounded-lg bg-white px-3 py-1.5 text-[10px] font-semibold text-blue-600 shadow-sm ring-1 ring-slate-200">
                                            JPG · JPEG · PNG · Maks. 4 MB
                                        </span>

                                        <input
                                            id="identity_document"
                                            name="identity_document"
                                            type="file"
                                            accept=".jpg,.jpeg,.png"
                                            class="hidden"
                                            required
                                        >
                                    </label>

                                    <p
                                        id="identity-file-name"
                                        class="mt-2 hidden break-all text-[11px] font-medium text-blue-600"
                                    ></p>

                                    @error('identity_document')
                                        <p class="mt-2 text-xs font-medium text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                            </div>
                        </section>

                        {{-- =========================================
                            BANK
                        ========================================== --}}
                        <section class="px-5 py-6 sm:px-6 lg:px-7 lg:py-7">
                            <div class="mb-5">
                                <div class="flex items-center gap-2.5">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-[11px] font-bold text-blue-600">
                                        02
                                    </span>

                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                                            Rekening Bank
                                        </h3>

                                        <p class="mt-0.5 text-[11px] leading-5 text-slate-400 sm:text-xs">
                                            Gunakan rekening yang sesuai dengan nama pemilik akun.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-5 md:grid-cols-2">

                                {{-- Bank Name --}}
                                <div>
                                    <label
                                        for="bank_name"
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                    >
                                        Nama bank
                                    </label>

                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex w-11 items-center justify-center text-slate-400">
                                            <i class="bi bi-bank text-sm"></i>
                                        </span>

                                        <input
                                            id="bank_name"
                                            name="bank_name"
                                            type="text"
                                            value="{{ old('bank_name') }}"
                                            placeholder="Contoh: BCA"
                                            class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50"
                                            required
                                        >
                                    </div>

                                    @error('bank_name')
                                        <p class="mt-2 text-xs font-medium text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Bank Account Name --}}
                                <div>
                                    <label
                                        for="bank_account_name"
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                    >
                                        Nama pemilik rekening
                                    </label>

                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex w-11 items-center justify-center text-slate-400">
                                            <i class="bi bi-person-vcard text-sm"></i>
                                        </span>

                                        <input
                                            id="bank_account_name"
                                            name="bank_account_name"
                                            type="text"
                                            value="{{ old('bank_account_name') }}"
                                            placeholder="Nama sesuai rekening"
                                            class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50"
                                            required
                                        >
                                    </div>

                                    @error('bank_account_name')
                                        <p class="mt-2 text-xs font-medium text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Account Number --}}
                                <div class="md:col-span-2">
                                    <label
                                        for="bank_account_number"
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                    >
                                        Nomor rekening
                                    </label>

                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex w-11 items-center justify-center text-slate-400">
                                            <i class="bi bi-wallet2 text-sm"></i>
                                        </span>

                                        <input
                                            id="bank_account_number"
                                            name="bank_account_number"
                                            type="text"
                                            inputmode="numeric"
                                            value="{{ old('bank_account_number') }}"
                                            placeholder="Masukkan nomor rekening"
                                            class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50"
                                            required
                                        >
                                    </div>

                                    <p class="mt-2 flex items-start gap-1.5 text-[11px] leading-5 text-slate-400">
                                        <i class="bi bi-lock-fill mt-[2px] shrink-0"></i>
                                        Nomor rekening disimpan dalam bentuk terenkripsi.
                                    </p>

                                    @error('bank_account_number')
                                        <p class="mt-2 text-xs font-medium text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                            </div>
                        </section>

                        {{-- =========================================
                            PRIVACY NOTICE
                        ========================================== --}}
                        <section class="bg-slate-50/70 px-5 py-5 sm:px-6 lg:px-7">
                            <div class="rounded-2xl border border-blue-100 bg-white px-4 py-4 sm:px-5">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                        <i class="bi bi-shield-lock-fill text-sm"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-slate-800">
                                            Data verifikasi bersifat privat
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-slate-500 sm:text-sm">
                                            Dokumen identitas dan nomor sensitif tidak ditampilkan sebagai file publik.
                                            Data hanya digunakan untuk proses pemeriksaan akun freelancer.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        {{-- =========================================
                            ACTION
                        ========================================== --}}
                        <section class="px-5 py-5 sm:px-6 lg:px-7">
                            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                                <a
                                    href="{{ route('freelancer.dashboard') }}"
                                    class="inline-flex h-11 w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-600 transition duration-200 hover:bg-slate-50 sm:w-auto"
                                >
                                    Batal
                                </a>

                                <button
                                    type="submit"
                                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 text-sm font-semibold !text-white shadow-[0_6px_18px_rgba(37,99,235,0.16)] transition duration-200 hover:bg-blue-700 hover:shadow-[0_8px_24px_rgba(37,99,235,0.20)] active:scale-[0.99] sm:w-auto"
                                >
                                    <i class="bi bi-send"></i>
                                    Kirim Verifikasi
                                </button>

                            </div>
                        </section>

                    </form>
                </section>

                {{-- =================================================
                    SIDE INFORMATION
                ================================================== --}}
                <aside class="space-y-4 lg:sticky lg:top-24">

                    {{-- Steps --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-[0_10px_35px_rgba(15,23,42,0.04)]">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600">
                            Checklist
                        </p>

                        <h3 class="mt-1 text-base font-bold tracking-[-0.02em] text-slate-900">
                            Sebelum mengirim
                        </h3>

                        <div class="mt-5 space-y-4">

                            <div class="flex items-start gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                                    <i class="bi bi-person-check text-xs"></i>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-800">
                                        Identitas sesuai dokumen
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-slate-400">
                                        Pastikan nama dan nomor identitas sesuai KTP.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                                    <i class="bi bi-image text-xs"></i>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-800">
                                        Foto KTP jelas
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-slate-400">
                                        Hindari foto buram, terlalu gelap, atau terpotong.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                                    <i class="bi bi-bank text-xs"></i>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-800">
                                        Rekening aktif
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-slate-400">
                                        Gunakan rekening yang benar-benar kamu gunakan untuk menerima pembayaran.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                                    <i class="bi bi-check2-circle text-xs"></i>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-800">
                                        Cek ulang sebelum kirim
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-slate-400">
                                        Pastikan semua data sudah benar agar review berjalan lancar.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </section>

                    {{-- Privacy --}}
                    <section class="rounded-3xl border border-blue-100 bg-blue-50/70 p-5">
                        <div class="flex items-start gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm ring-1 ring-blue-100">
                                <i class="bi bi-lock-fill text-sm"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800">
                                    Privasi terjaga
                                </p>

                                <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                    Data sensitif hanya digunakan untuk kebutuhan verifikasi akun dan tidak ditampilkan di profil publik.
                                </p>
                            </div>
                        </div>
                    </section>

                </aside>

            </div>

        @endif

    </div>
</div>

{{-- =============================================================
    FILE NAME PREVIEW
============================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const identityInput = document.getElementById('identity_document');
        const identityFileName = document.getElementById('identity-file-name');

        if (identityInput && identityFileName) {
            identityInput.addEventListener('change', function () {
                if (this.files && this.files.length > 0) {
                    identityFileName.textContent = 'File dipilih: ' + this.files[0].name;
                    identityFileName.classList.remove('hidden');
                } else {
                    identityFileName.textContent = '';
                    identityFileName.classList.add('hidden');
                }
            });
        }
    });
</script>


</x-layouts.freelancer>
