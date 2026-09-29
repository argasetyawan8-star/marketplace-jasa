<x-layouts.freelancer title="Dompet">


<div class="min-h-screen bg-slate-50/70">
    <div class="mx-auto w-full max-w-7xl px-3.5 py-4 pb-24 sm:px-5 sm:py-6 lg:px-8 lg:py-8">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <section class="mb-5 sm:mb-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 ring-1 ring-blue-100 sm:h-11 sm:w-11 sm:rounded-2xl">
                    <i class="bi bi-wallet2 text-base sm:text-lg"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-blue-600 sm:text-[10px]">
                        Keuangan
                    </p>

                    <h1 class="mt-0.5 text-xl font-bold tracking-[-0.03em] text-slate-900 sm:text-2xl">
                        Dompet
                    </h1>

                    <p class="mt-1 hidden text-sm leading-6 text-slate-500 sm:block">
                        Kelola saldo dan lihat riwayat pendapatan dari pekerjaan kamu.
                    </p>
                </div>

            </div>

        </section>

        {{-- =========================================================
            AVAILABLE BALANCE
        ========================================================== --}}
        <section class="relative overflow-hidden rounded-[22px] bg-blue-600 px-5 py-5 text-white shadow-[0_10px_30px_rgba(37,99,235,0.16)] sm:rounded-3xl sm:px-6 sm:py-6">

            <div class="pointer-events-none absolute -right-12 -top-12 h-36 w-36 rounded-full border border-white/10"></div>
            <div class="pointer-events-none absolute -bottom-16 right-8 h-28 w-28 rounded-full border border-white/10"></div>

            <div class="relative">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="text-xs font-medium text-blue-100 sm:text-sm">
                            Saldo tersedia
                        </p>

                        <p class="mt-2 break-words text-[25px] font-bold leading-tight tracking-[-0.035em] sm:text-3xl">
                            Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10 sm:h-12 sm:w-12 sm:rounded-2xl">
                        <i class="bi bi-wallet2 text-base sm:text-xl"></i>
                    </div>

                </div>

                <div class="mt-5 flex items-center gap-2 text-[11px] text-blue-100 sm:text-xs">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-white/10">
                        <i class="bi bi-check text-[10px]"></i>
                    </span>

                    <span class="leading-5">
                        Dapat digunakan untuk penarikan
                    </span>
                </div>

            </div>

        </section>

        {{-- =========================================================
            SMALL BALANCE STATS
        ========================================================== --}}
        <section class="mt-3 grid grid-cols-2 gap-3 sm:mt-4 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Pending --}}
            <div class="min-w-0 rounded-[20px] border border-slate-200 bg-white p-4 shadow-[0_5px_20px_rgba(15,23,42,0.03)] sm:rounded-3xl sm:p-5">

                <div class="flex items-center justify-between gap-2">
                    <p class="truncate text-[11px] font-medium text-slate-500 sm:text-xs sm:text-sm">
                        Saldo tertahan
                    </p>

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 sm:h-9 sm:w-9">
                        <i class="bi bi-hourglass-split text-xs sm:text-sm"></i>
                    </div>
                </div>

                <p class="mt-3 break-words text-[15px] font-bold leading-5 tracking-[-0.02em] text-slate-900 sm:text-xl">
                    Rp {{ number_format($wallet->pending_balance, 0, ',', '.') }}
                </p>

                <p class="mt-1.5 text-[10px] leading-4 text-slate-400 sm:text-xs sm:leading-5">
                    Masih dalam proses penyelesaian.
                </p>

            </div>

            {{-- Total Earned --}}
            <div class="min-w-0 rounded-[20px] border border-slate-200 bg-white p-4 shadow-[0_5px_20px_rgba(15,23,42,0.03)] sm:rounded-3xl sm:p-5">

                <div class="flex items-center justify-between gap-2">
                    <p class="truncate text-[11px] font-medium text-slate-500 sm:text-xs sm:text-sm">
                        Total pendapatan
                    </p>

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-9 sm:w-9">
                        <i class="bi bi-graph-up-arrow text-xs sm:text-sm"></i>
                    </div>
                </div>

                <p class="mt-3 break-words text-[15px] font-bold leading-5 tracking-[-0.02em] text-slate-900 sm:text-xl">
                    Rp {{ number_format($wallet->total_earned, 0, ',', '.') }}
                </p>

                <p class="mt-1.5 text-[10px] leading-4 text-slate-400 sm:text-xs sm:leading-5">
                    Akumulasi dari pesanan.
                </p>

            </div>

            {{-- Total Withdrawn --}}
            <div class="col-span-2 min-w-0 rounded-[20px] border border-slate-200 bg-white p-4 shadow-[0_5px_20px_rgba(15,23,42,0.03)] sm:col-span-2 sm:rounded-3xl sm:p-5 lg:col-span-1">

                <div class="flex items-center justify-between gap-2">
                    <p class="truncate text-[11px] font-medium text-slate-500 sm:text-xs sm:text-sm">
                        Total ditarik
                    </p>

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600 sm:h-9 sm:w-9">
                        <i class="bi bi-arrow-up-right text-xs sm:text-sm"></i>
                    </div>
                </div>

                <p class="mt-3 break-words text-[15px] font-bold leading-5 tracking-[-0.02em] text-slate-900 sm:text-xl">
                    Rp {{ number_format($wallet->total_withdrawn, 0, ',', '.') }}
                </p>

                <p class="mt-1.5 text-[10px] leading-4 text-slate-400 sm:text-xs sm:leading-5">
                    Total saldo yang pernah ditarik.
                </p>

            </div>

        </section>

        {{-- =========================================================
            WALLET INFO
        ========================================================== --}}
        <section class="mt-4 rounded-[20px] border border-blue-100 bg-blue-50/70 px-4 py-4 sm:rounded-3xl sm:px-5 sm:py-5">

            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm ring-1 ring-blue-100 sm:h-10 sm:w-10">
                    <i class="bi bi-info-circle text-sm"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-800 sm:text-sm">
                        Informasi Dompet
                    </p>

                    <p class="mt-1 text-[11px] leading-5 text-slate-500 sm:text-sm sm:leading-6">
                        Pendapatan dari pesanan yang sudah selesai akan masuk ke saldo tersedia dan dapat digunakan untuk pengajuan penarikan.
                    </p>
                </div>

            </div>

        </section>

        {{-- =========================================================
            TRANSACTIONS
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
                            Riwayat Transaksi
                        </h2>

                        <p class="mt-0.5 text-[10px] leading-4 text-slate-400 sm:text-xs sm:leading-5">
                            Semua aktivitas saldo dompet kamu.
                        </p>
                    </div>

                </div>

            </div>

            @if ($transactions->count())

                <div class="divide-y divide-slate-100">

                    @foreach ($transactions as $transaction)

                        <div class="px-4 py-4 transition hover:bg-slate-50/70 sm:px-6 sm:py-5 lg:px-7">

                            {{-- ================================
                                MOBILE / DESKTOP TRANSACTION
                            ================================= --}}
                            <div class="flex items-start gap-3">

                                {{-- Icon --}}
                                @if ($transaction->type === 'credit')

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 sm:h-11 sm:w-11">
                                        <i class="bi bi-arrow-down-left text-sm sm:text-base"></i>
                                    </div>

                                @else

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600 sm:h-11 sm:w-11">
                                        <i class="bi bi-arrow-up-right text-sm sm:text-base"></i>
                                    </div>

                                @endif

                                {{-- Main --}}
                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="min-w-0 flex-1">

                                            <p class="break-words text-xs font-semibold leading-5 text-slate-800 sm:text-sm">
                                                {{ $transaction->description ?: ucfirst(str_replace('_', ' ', $transaction->category)) }}
                                            </p>

                                            <div class="mt-1.5 flex flex-wrap items-center gap-x-1.5 gap-y-1 text-[9px] leading-4 text-slate-400 sm:text-xs sm:leading-5">

                                                <span>
                                                    {{ $transaction->created_at->format('d M Y, H:i') }}
                                                </span>

                                                <span class="text-slate-300">
                                                    •
                                                </span>

                                                <span>
                                                    Saldo Rp {{ number_format($transaction->balance_after, 0, ',', '.') }}
                                                </span>

                                            </div>

                                        </div>

                                        {{-- Amount --}}
                                        <div class="shrink-0 text-right">

                                            @if ($transaction->type === 'credit')

                                                <p class="whitespace-nowrap text-[11px] font-bold text-emerald-600 sm:text-sm">
                                                    + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                                </p>

                                            @else

                                                <p class="whitespace-nowrap text-[11px] font-bold text-red-600 sm:text-sm">
                                                    - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                {{-- Pagination --}}
                @if ($transactions->hasPages())
                    <div class="border-t border-slate-100 px-4 py-3 sm:px-6 sm:py-4 lg:px-7">
                        <div class="overflow-x-auto">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                @endif

            @else

                {{-- Empty State --}}
                <div class="px-5 py-14 text-center sm:px-8 sm:py-20">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 sm:h-16 sm:w-16">
                        <i class="bi bi-wallet2 text-xl sm:text-2xl"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-bold text-slate-900 sm:text-base">
                        Belum ada transaksi
                    </h3>

                    <p class="mx-auto mt-2 max-w-xs text-[11px] leading-5 text-slate-400 sm:max-w-sm sm:text-sm sm:leading-6">
                        Riwayat pendapatan dan penarikan kamu akan muncul di sini.
                    </p>

                </div>

            @endif

        </section>

    </div>
</div>


</x-layouts.freelancer>
