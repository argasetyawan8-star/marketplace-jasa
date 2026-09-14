<x-layouts.freelancer title="Dompet">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">
            <div class="flex items-center justify-between gap-5">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                        <i class="bi bi-wallet2"></i>
                        Keuangan
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        Dompet
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-[#71837B]">
                        Kelola saldo dan lihat riwayat pendapatan dari pekerjaan kamu.
                    </p>
                </div>

                <div class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A] sm:flex">
                    <i class="bi bi-wallet2 text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Balance Cards --}}
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">

            {{-- Available Balance --}}
            <div class="rounded-2xl bg-[#0F6B3A] p-6 text-white">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-[#D9F3E3]">
                            Saldo Tersedia
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight">
                            Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10">
                        <i class="bi bi-wallet2 text-xl"></i>
                    </div>
                </div>

                <div class="mt-5 flex items-center gap-2 text-xs text-[#D9F3E3]">
                    <i class="bi bi-check-circle"></i>
                    Dapat digunakan untuk penarikan
                </div>
            </div>

            {{-- Pending --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-[#71837B]">
                            Saldo Tertahan
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-[#123128]">
                            Rp {{ number_format($wallet->pending_balance, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#FFF7E6] text-[#A06A00]">
                        <i class="bi bi-hourglass-split text-xl"></i>
                    </div>
                </div>

                <p class="mt-5 text-xs text-[#8A9B94]">
                    Dana yang masih dalam proses penyelesaian.
                </p>
            </div>

            {{-- Total Earned --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-[#71837B]">
                            Total Pendapatan
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-[#123128]">
                            Rp {{ number_format($wallet->total_earned, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-graph-up-arrow text-xl"></i>
                    </div>
                </div>

                <p class="mt-5 text-xs text-[#8A9B94]">
                    Akumulasi pendapatan dari pesanan.
                </p>
            </div>

            {{-- Withdrawn --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-[#71837B]">
                            Total Ditarik
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-[#123128]">
                            Rp {{ number_format($wallet->total_withdrawn, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                        <i class="bi bi-arrow-up-right text-xl"></i>
                    </div>
                </div>

                <p class="mt-5 text-xs text-[#8A9B94]">
                    Total saldo yang pernah ditarik.
                </p>
            </div>

        </div>

        {{-- Wallet Information --}}
        <div class="rounded-2xl border border-[#CBEAD8] bg-[#EAF7EF] p-5 sm:p-6">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                    <i class="bi bi-info-circle text-lg"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold text-[#17663D]">
                        Informasi Dompet
                    </p>

                    <p class="mt-1 max-w-4xl text-sm leading-6 text-[#557166]">
                        Pendapatan dari pesanan yang sudah selesai akan masuk ke saldo tersedia.
                        Saldo tersebut nantinya dapat digunakan untuk pengajuan penarikan.
                    </p>
                </div>
            </div>
        </div>

        {{-- Transactions --}}
        <div class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white">

            {{-- Header --}}
            <div class="border-b border-[#E7EFEA] px-6 py-5 sm:px-7">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#0F6B3A]">
                                <i class="bi bi-clock-history"></i>
                            </div>

                            <div>
                                <h2 class="text-base font-semibold text-[#123128]">
                                    Riwayat Transaksi
                                </h2>

                                <p class="mt-0.5 text-sm text-[#8A9B94]">
                                    Semua aktivitas saldo dompet kamu.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($transactions->count())

                <div class="divide-y divide-[#E7EFEA]">

                    @foreach ($transactions as $transaction)

                        <div class="px-6 py-5 transition hover:bg-[#FBFDFC] sm:px-7">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                {{-- Transaction Info --}}
                                <div class="flex min-w-0 items-center gap-4">

                                    {{-- Icon --}}
                                    @if ($transaction->type === 'credit')

                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                                            <i class="bi bi-arrow-down-left text-lg"></i>
                                        </div>

                                    @else

                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#FEF0F0] text-[#C2413A]">
                                            <i class="bi bi-arrow-up-right text-lg"></i>
                                        </div>

                                    @endif

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-[#123128]">
                                            {{ $transaction->description ?: ucfirst(str_replace('_', ' ', $transaction->category)) }}
                                        </p>

                                        <div class="mt-1.5 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-[#8A9B94]">
                                            <span>
                                                {{ $transaction->created_at->format('d M Y, H:i') }}
                                            </span>

                                            <span class="text-[#C7D3CE]">
                                                •
                                            </span>

                                            <span>
                                                Saldo Rp {{ number_format($transaction->balance_after, 0, ',', '.') }}
                                            </span>
                                        </div>

                                    </div>
                                </div>

                                {{-- Amount --}}
                                <div class="flex items-center justify-between gap-4 sm:block sm:text-right">

                                    @if ($transaction->type === 'credit')

                                        <p class="text-sm font-semibold text-[#0F8A4B]">
                                            + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </p>

                                    @else

                                        <p class="text-sm font-semibold text-[#C2413A]">
                                            - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </p>

                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                @if ($transactions->hasPages())
                    <div class="border-t border-[#E7EFEA] px-6 py-4 sm:px-7">
                        {{ $transactions->links() }}
                    </div>
                @endif

            @else

                {{-- Empty State --}}
                <div class="px-6 py-16 text-center sm:px-8">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-wallet2 text-2xl"></i>
                    </div>

                    <h3 class="mt-5 text-sm font-semibold text-[#123128]">
                        Belum ada transaksi
                    </h3>

                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-[#8A9B94]">
                        Riwayat pendapatan dan penarikan kamu akan muncul di sini.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-layouts.freelancer>