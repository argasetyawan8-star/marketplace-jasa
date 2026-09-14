<x-layouts.freelancer title="Penarikan">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                        <i class="bi bi-arrow-down-circle"></i>
                        Keuangan
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        Penarikan
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-[#71837B]">
                        Kelola pengajuan penarikan saldo dari dompet kamu.
                    </p>
                </div>

                <a
                    href="{{ route('freelancer.withdrawals.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                >
                    <i class="bi bi-plus-lg"></i>
                    Ajukan Penarikan
                </a>

            </div>
        </div>

        {{-- Success --}}
        @if (session('success'))
            <div class="flex items-start gap-3 rounded-xl border border-[#CBEAD8] bg-[#EAF7EF] px-4 py-3.5 text-sm text-[#17663D]">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div>
                    <p class="font-semibold">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-[#557166]">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Wallet Summary --}}
        <div class="grid gap-4 md:grid-cols-3">

            {{-- Available --}}
            <div class="rounded-2xl bg-[#0F6B3A] p-6 text-white">
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm text-[#D9F3E3]">
                            Saldo Bisa Ditarik
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
                    Saldo tersedia untuk penarikan
                </div>
            </div>

            {{-- Pending --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6">
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm text-[#71837B]">
                            Saldo Dalam Proses
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
                    Dana yang sedang diproses oleh admin.
                </p>
            </div>

            {{-- Total Withdrawn --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6">
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm text-[#71837B]">
                            Total Berhasil Ditarik
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-[#123128]">
                            Rp {{ number_format($wallet->total_withdrawn, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-arrow-up-right text-xl"></i>
                    </div>

                </div>

                <p class="mt-5 text-xs text-[#8A9B94]">
                    Akumulasi saldo yang sudah berhasil ditarik.
                </p>
            </div>

        </div>

        {{-- Info --}}
        <div class="rounded-2xl border border-[#CBEAD8] bg-[#EAF7EF] p-5 sm:p-6">
            <div class="flex items-start gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                    <i class="bi bi-info-circle text-lg"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold text-[#17663D]">
                        Informasi Penarikan
                    </p>

                    <p class="mt-1 max-w-4xl text-sm leading-6 text-[#557166]">
                        Setelah pengajuan dibuat, saldo akan dipindahkan ke saldo dalam proses
                        sampai pengajuan selesai diproses oleh admin.
                    </p>
                </div>

            </div>
        </div>

        {{-- Withdrawal History --}}
        <div class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white">

            {{-- Header --}}
            <div class="border-b border-[#E7EFEA] px-6 py-5 sm:px-7">
                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-clock-history"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Riwayat Penarikan
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Daftar pengajuan penarikan saldo kamu.
                        </p>
                    </div>

                </div>
            </div>

            @if ($withdrawals->count())

                <div class="divide-y divide-[#E7EFEA]">

                    @foreach ($withdrawals as $withdrawal)

                        <div class="px-6 py-5 transition hover:bg-[#FBFDFC] sm:px-7">

                            <div class="flex flex-col justify-between gap-5 md:flex-row md:items-center">

                                {{-- Left --}}
                                <div class="flex min-w-0 items-start gap-4">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F3F8F5] text-[#0F6B3A]">
                                        <i class="bi bi-bank text-lg"></i>
                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-sm font-semibold text-[#123128]">
                                            {{ $withdrawal->method }}
                                        </p>

                                        <p class="mt-1 text-sm text-[#667D73]">
                                            {{ $withdrawal->account_name }}
                                            <span class="mx-1 text-[#C7D3CE]">·</span>
                                            {{ $withdrawal->account_number }}
                                        </p>

                                        <p class="mt-2 inline-flex items-center gap-1.5 text-xs text-[#8A9B94]">
                                            <i class="bi bi-calendar3"></i>
                                            {{ $withdrawal->created_at->format('d M Y, H:i') }}
                                        </p>

                                    </div>

                                </div>

                                {{-- Right --}}
                                <div class="flex flex-row items-center justify-between gap-5 md:block md:text-right">

                                    <p class="text-base font-semibold text-[#123128]">
                                        Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                    </p>

                                    @switch($withdrawal->status)

                                        @case('pending')
                                            <span class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-[#FFF7E6] px-3 py-1.5 text-xs font-semibold text-[#9A6700]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#D9A441]"></span>
                                                Menunggu
                                            </span>
                                            @break

                                        @case('processing')
                                            <span class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-[#EFF6FF] px-3 py-1.5 text-xs font-semibold text-[#2563EB]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#3B82F6]"></span>
                                                Diproses
                                            </span>
                                            @break

                                        @case('completed')
                                            <span class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-[#DCFCE7] px-3 py-1.5 text-xs font-semibold text-[#166534]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#22C55E]"></span>
                                                Berhasil
                                            </span>
                                            @break

                                        @case('rejected')
                                            <span class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-[#FEF0F0] px-3 py-1.5 text-xs font-semibold text-[#B42318]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#D92D20]"></span>
                                                Ditolak
                                            </span>
                                            @break

                                    @endswitch

                                </div>

                            </div>

                            {{-- Rejection Reason --}}
                            @if ($withdrawal->status === 'rejected' && $withdrawal->rejection_reason)

                                <div class="mt-4 rounded-xl border border-[#F2D0D0] bg-[#FEF0F0] p-4">

                                    <div class="flex items-start gap-3">

                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#B42318]">
                                            <i class="bi bi-exclamation-circle"></i>
                                        </div>

                                        <div>
                                            <p class="text-xs font-semibold text-[#B42318]">
                                                Alasan penolakan
                                            </p>

                                            <p class="mt-1 text-sm leading-6 text-[#A64A43]">
                                                {{ $withdrawal->rejection_reason }}
                                            </p>
                                        </div>

                                    </div>

                                </div>

                            @endif

                        </div>

                    @endforeach

                </div>

                @if ($withdrawals->hasPages())

                    <div class="border-t border-[#E7EFEA] px-6 py-4 sm:px-7">
                        {{ $withdrawals->links() }}
                    </div>

                @endif

            @else

                {{-- Empty State --}}
                <div class="px-6 py-16 text-center sm:px-8">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-bank text-2xl"></i>
                    </div>

                    <h3 class="mt-5 text-sm font-semibold text-[#123128]">
                        Belum ada pengajuan
                    </h3>

                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-[#8A9B94]">
                        Pengajuan penarikan yang kamu buat akan muncul di sini.
                    </p>

                    <a
                        href="{{ route('freelancer.withdrawals.create') }}"
                        class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Ajukan Penarikan
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-layouts.freelancer>