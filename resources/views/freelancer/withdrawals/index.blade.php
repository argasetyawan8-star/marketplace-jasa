<x-layouts.freelancer title="Penarikan">


<div class="min-h-screen bg-slate-50/70">
    <div class="mx-auto w-full max-w-7xl px-3.5 py-4 pb-24 sm:px-5 sm:py-6 lg:px-8 lg:py-8">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <section class="mb-5 sm:mb-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div class="flex min-w-0 items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 ring-1 ring-blue-100 sm:h-11 sm:w-11 sm:rounded-2xl">
                        <i class="bi bi-arrow-down-circle text-base sm:text-lg"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-blue-600 sm:text-[10px]">
                            Keuangan
                        </p>

                        <h1 class="mt-0.5 text-xl font-bold tracking-[-0.03em] text-slate-900 sm:text-2xl lg:text-3xl">
                            Penarikan
                        </h1>

                        <p class="mt-1.5 hidden text-sm leading-6 text-slate-500 sm:block">
                            Kelola pengajuan penarikan saldo dari dompet kamu.
                        </p>
                    </div>

                </div>

                <a
                    href="{{ route('freelancer.withdrawals.create') }}"
                    class="inline-flex h-10 w-auto shrink-0 items-center justify-center gap-2 self-start rounded-xl bg-blue-600 px-4 text-xs font-semibold !text-white shadow-[0_5px_16px_rgba(37,99,235,0.16)] transition duration-200 hover:bg-blue-700 hover:shadow-[0_7px_20px_rgba(37,99,235,0.20)] sm:self-auto sm:px-4 sm:text-sm"
                >
                    <i class="bi bi-plus-lg"></i>
                    Ajukan Penarikan
                </a>

            </div>

        </section>

        {{-- =========================================================
            SUCCESS
        ========================================================== --}}
        @if (session('success'))
            <section class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 sm:mb-5 sm:px-5">

                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm ring-1 ring-emerald-100">
                        <i class="bi bi-check-circle-fill text-sm"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-bold text-emerald-900 sm:text-sm">
                            Berhasil
                        </p>

                        <p class="mt-0.5 break-words text-[11px] leading-5 text-emerald-700 sm:text-sm">
                            {{ session('success') }}
                        </p>
                    </div>

                </div>

            </section>
        @endif

        {{-- =========================================================
            WALLET SUMMARY
        ========================================================== --}}
        <section class="grid gap-3 sm:gap-4 lg:grid-cols-3">

            {{-- =====================================================
                AVAILABLE
            ====================================================== --}}
            <div class="relative overflow-hidden rounded-[22px] bg-blue-600 px-5 py-5 text-white shadow-[0_10px_30px_rgba(37,99,235,0.16)] sm:rounded-3xl sm:p-6 lg:p-7">

                <div class="pointer-events-none absolute -right-12 -top-12 h-36 w-36 rounded-full border border-white/10"></div>
                <div class="pointer-events-none absolute -bottom-16 right-8 h-28 w-28 rounded-full border border-white/10"></div>

                <div class="relative">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">
                            <p class="text-xs font-medium text-blue-100 sm:text-sm">
                                Saldo bisa ditarik
                            </p>

                            <p class="mt-2 break-words text-[25px] font-bold leading-tight tracking-[-0.035em] sm:text-3xl">
                                Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10 sm:h-12 sm:w-12 sm:rounded-2xl">
                            <i class="bi bi-wallet2 text-base sm:text-xl"></i>
                        </div>

                    </div>

                    <div class="mt-5 flex items-center gap-2 text-[11px] leading-5 text-blue-100 sm:text-xs">

                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-white/10">
                            <i class="bi bi-check text-[10px]"></i>
                        </span>

                        <span>
                            Saldo tersedia untuk penarikan
                        </span>

                    </div>

                </div>
            </div>

            {{-- =====================================================
                PENDING
            ====================================================== --}}
            <div class="min-w-0 rounded-[20px] border border-slate-200 bg-white p-4 shadow-[0_5px_20px_rgba(15,23,42,0.03)] sm:rounded-3xl sm:p-6">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="text-[11px] font-medium text-slate-500 sm:text-sm">
                            Saldo dalam proses
                        </p>

                        <p class="mt-2 break-words text-[16px] font-bold leading-5 tracking-[-0.02em] text-slate-900 sm:text-2xl">
                            Rp {{ number_format($wallet->pending_balance, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 sm:h-11 sm:w-11 sm:rounded-2xl">
                        <i class="bi bi-hourglass-split text-sm sm:text-lg"></i>
                    </div>

                </div>

                <p class="mt-4 border-t border-slate-100 pt-3 text-[10px] leading-4 text-slate-400 sm:mt-5 sm:pt-4 sm:text-xs sm:leading-5">
                    Dana yang sedang diproses oleh admin.
                </p>

            </div>

            {{-- =====================================================
                TOTAL WITHDRAWN
            ====================================================== --}}
            <div class="min-w-0 rounded-[20px] border border-slate-200 bg-white p-4 shadow-[0_5px_20px_rgba(15,23,42,0.03)] sm:rounded-3xl sm:p-6">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="text-[11px] font-medium text-slate-500 sm:text-sm">
                            Total berhasil ditarik
                        </p>

                        <p class="mt-2 break-words text-[16px] font-bold leading-5 tracking-[-0.02em] text-slate-900 sm:text-2xl">
                            Rp {{ number_format($wallet->total_withdrawn, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-11 sm:w-11 sm:rounded-2xl">
                        <i class="bi bi-arrow-up-right text-sm sm:text-lg"></i>
                    </div>

                </div>

                <p class="mt-4 border-t border-slate-100 pt-3 text-[10px] leading-4 text-slate-400 sm:mt-5 sm:pt-4 sm:text-xs sm:leading-5">
                    Akumulasi saldo yang sudah berhasil ditarik.
                </p>

            </div>

        </section>

        {{-- =========================================================
            INFO
        ========================================================== --}}
        <section class="mt-4 rounded-[20px] border border-blue-100 bg-blue-50/70 px-4 py-4 sm:mt-5 sm:rounded-3xl sm:px-5 sm:py-5">

            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm ring-1 ring-blue-100 sm:h-10 sm:w-10">
                    <i class="bi bi-info-circle text-sm sm:text-base"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-800 sm:text-sm">
                        Informasi Penarikan
                    </p>

                    <p class="mt-1 text-[11px] leading-5 text-slate-500 sm:text-sm sm:leading-6">
                        Setelah pengajuan dibuat, saldo akan dipindahkan ke saldo dalam proses sampai pengajuan selesai diproses oleh admin.
                    </p>
                </div>

            </div>

        </section>

        {{-- =========================================================
            WITHDRAWAL HISTORY
        ========================================================== --}}
        <section class="mt-5 overflow-hidden rounded-[22px] border border-slate-200 bg-white shadow-[0_8px_28px_rgba(15,23,42,0.035)] sm:mt-6 sm:rounded-3xl">

            {{-- Header --}}
            <div class="border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5 lg:px-7">

                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-10 sm:w-10">
                        <i class="bi bi-clock-history text-sm"></i>
                    </div>

                    <div class="min-w-0">
                        <h2 class="text-sm font-bold tracking-[-0.02em] text-slate-900 sm:text-base lg:text-lg">
                            Riwayat Penarikan
                        </h2>

                        <p class="mt-0.5 text-[10px] leading-4 text-slate-400 sm:text-xs sm:leading-5">
                            Daftar pengajuan penarikan saldo kamu.
                        </p>
                    </div>

                </div>

            </div>

            @if ($withdrawals->count())

                <div class="divide-y divide-slate-100">

                    @foreach ($withdrawals as $withdrawal)

                        <article class="px-4 py-4 transition duration-200 hover:bg-slate-50/70 sm:px-6 sm:py-5 lg:px-7">

                            {{-- =================================================
                                WITHDRAWAL TOP
                            ================================================== --}}
                            <div class="flex items-start gap-3">

                                {{-- Icon --}}
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-11 sm:w-11 sm:rounded-2xl">
                                    <i class="bi bi-bank text-sm sm:text-base"></i>
                                </div>

                                {{-- Main --}}
                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="min-w-0 flex-1">

                                            <p class="text-xs font-bold text-slate-800 sm:text-sm">
                                                {{ $withdrawal->method }}
                                            </p>

                                            <p class="mt-1 break-words text-[11px] leading-5 text-slate-500 sm:text-sm">
                                                {{ $withdrawal->account_name }}

                                                <span class="mx-1 text-slate-300">
                                                    ·
                                                </span>

                                                <span class="break-all">
                                                    {{ $withdrawal->account_number }}
                                                </span>
                                            </p>

                                        </div>

                                        {{-- Amount --}}
                                        <div class="shrink-0 text-right">

                                            <p class="whitespace-nowrap text-xs font-bold text-slate-900 sm:text-sm">
                                                Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                            </p>

                                        </div>

                                    </div>

                                    {{-- Date --}}
                                    <div class="mt-2.5 flex flex-wrap items-center gap-x-2 gap-y-1 text-[10px] text-slate-400 sm:text-xs">

                                        <span class="inline-flex items-center gap-1.5">
                                            <i class="bi bi-calendar3"></i>
                                            {{ $withdrawal->created_at->format('d M Y, H:i') }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                            {{-- =================================================
                                STATUS
                            ================================================== --}}
                            <div class="mt-3 ml-[52px] sm:ml-[59px]">

                                @switch($withdrawal->status)

                                    @case('pending')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700 sm:text-xs">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Menunggu
                                        </span>

                                        @break

                                    @case('processing')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1.5 text-[10px] font-semibold text-blue-700 sm:text-xs">
                                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                            Diproses
                                        </span>

                                        @break

                                    @case('completed')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1.5 text-[10px] font-semibold text-emerald-700 sm:text-xs">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Berhasil
                                        </span>

                                        @break

                                    @case('rejected')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-2.5 py-1.5 text-[10px] font-semibold text-red-700 sm:text-xs">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                            Ditolak
                                        </span>

                                        @break

                                @endswitch

                            </div>

                            {{-- =================================================
                                REJECTION REASON
                            ================================================== --}}
                            @if ($withdrawal->status === 'rejected' && $withdrawal->rejection_reason)

                                <div class="mt-4 ml-0 rounded-xl border border-red-100 bg-red-50 px-3.5 py-3.5 sm:ml-[59px] sm:rounded-2xl sm:px-4 sm:py-4">

                                    <div class="flex items-start gap-3">

                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-red-600">
                                            <i class="bi bi-exclamation-circle text-sm"></i>
                                        </div>

                                        <div class="min-w-0">

                                            <p class="text-[10px] font-bold uppercase tracking-[0.08em] text-red-600 sm:text-xs">
                                                Alasan penolakan
                                            </p>

                                            <p class="mt-1 break-words text-xs leading-5 text-red-700 sm:text-sm sm:leading-6">
                                                {{ $withdrawal->rejection_reason }}
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            @endif

                        </article>

                    @endforeach

                </div>

                {{-- =====================================================
                    PAGINATION
                ====================================================== --}}
                @if ($withdrawals->hasPages())

                    <div class="border-t border-slate-100 px-4 py-3 sm:px-6 sm:py-4 lg:px-7">
                        <div class="overflow-x-auto">
                            {{ $withdrawals->links() }}
                        </div>
                    </div>

                @endif

            @else

                {{-- =====================================================
                    EMPTY STATE
                ====================================================== --}}
                <div class="px-5 py-14 text-center sm:px-8 sm:py-20">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 sm:h-16 sm:w-16">
                        <i class="bi bi-bank text-xl sm:text-2xl"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-bold text-slate-900 sm:text-base">
                        Belum ada pengajuan
                    </h3>

                    <p class="mx-auto mt-2 max-w-xs text-[11px] leading-5 text-slate-400 sm:max-w-sm sm:text-sm sm:leading-6">
                        Pengajuan penarikan yang kamu buat akan muncul di sini.
                    </p>

                    <a
                        href="{{ route('freelancer.withdrawals.create') }}"
                        class="mt-5 inline-flex h-10 w-auto items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-xs font-semibold !text-white shadow-sm transition hover:bg-blue-700 sm:h-11 sm:px-5 sm:text-sm"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Ajukan Penarikan
                    </a>

                </div>

            @endif

        </section>

    </div>
</div>


</x-layouts.freelancer>
