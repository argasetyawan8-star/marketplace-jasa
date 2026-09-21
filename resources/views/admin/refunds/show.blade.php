<x-layouts.admin title="Detail Refund">

    @php
        $statusConfig = [
            'pending' => [
                'label' => 'Menunggu diproses',
                'class' => 'border-[#F2DDAF] bg-[#FFF9EA] text-[#9A6800]',
                'dot' => 'bg-[#D99A19]',
                'icon' => 'bi-hourglass-split',
            ],

            'processing' => [
                'label' => 'Sedang diproses',
                'class' => 'border-[#CFE0F1] bg-[#F3F8FC] text-[#3C6F9F]',
                'dot' => 'bg-[#5B91C0]',
                'icon' => 'bi-arrow-repeat',
            ],

            'refunded' => [
                'label' => 'Refund berhasil',
                'class' => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',
                'dot' => 'bg-[#35C978]',
                'icon' => 'bi-check-circle-fill',
            ],

            'rejected' => [
                'label' => 'Refund ditolak',
                'class' => 'border-[#F0D5D5] bg-[#FFF6F6] text-[#B84E4E]',
                'dot' => 'bg-[#D16B6B]',
                'icon' => 'bi-x-circle-fill',
            ],
        ];

        $status = $statusConfig[$refund->status]
            ?? [
                'label' => ucfirst($refund->status),
                'class' => 'border-gray-200 bg-gray-50 text-gray-600',
                'dot' => 'bg-gray-400',
                'icon' => 'bi-info-circle',
            ];
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

            <div>
                <a
                    href="{{ route('admin.refunds.index') }}"
                    class="inline-flex items-center gap-2 text-[10px] font-semibold text-[#7D8D86] transition hover:text-[#1E9E5A]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke refund
                </a>

                <p class="mt-5 text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                    Refund
                </p>

                <h1 class="mt-1 text-2xl font-semibold tracking-[-0.02em] text-[#123128]">
                    {{ $refund->refund_number }}
                </h1>

                <p class="mt-1 text-sm text-[#7D8D86]">
                    Pengembalian dana untuk order
                    <span class="font-semibold text-[#355248]">
                        {{ $refund->order?->order_number ?? '-' }}
                    </span>
                </p>
            </div>

            <span class="inline-flex w-fit items-center gap-2 rounded-full border px-3 py-1.5 text-[10px] font-semibold {{ $status['class'] }}">
                <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                <i class="bi {{ $status['icon'] }}"></i>
                {{ $status['label'] }}
            </span>

        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div class="mt-6 rounded-2xl border border-[#CDE7D7] bg-[#EAF7EF] px-5 py-4">
                <div class="flex items-start gap-3">
                    <i class="bi bi-check-circle-fill mt-0.5 text-[#1E9E5A]"></i>

                    <p class="text-xs leading-5 text-[#39664F]">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mt-6 rounded-2xl border border-[#F0D5D5] bg-[#FFF6F6] px-5 py-4">
                <p class="text-xs font-semibold text-[#8E4141]">
                    Periksa kembali data.
                </p>

                <div class="mt-2 space-y-1">
                    @foreach($errors->all() as $error)
                        <p class="text-xs text-[#A26767]">
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-6 grid grid-cols-1 gap-5 lg:grid-cols-[1fr_320px]">

            {{-- Main --}}
            <div class="space-y-5">

                {{-- Refund Information --}}
                <section class="overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                    <div class="border-b border-[#EDF2EF] px-5 py-5 sm:px-6">
                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                            Informasi refund
                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                            Detail pengembalian dana
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-2 sm:px-6">

                        <div class="rounded-xl bg-[#FAFCFB] px-4 py-4">
                            <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                                Nomor refund
                            </p>

                            <p class="mt-2 break-all text-xs font-semibold text-[#355248]">
                                {{ $refund->refund_number }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-[#FAFCFB] px-4 py-4">
                            <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                                Sumber
                            </p>

                            <p class="mt-2 text-xs font-semibold capitalize text-[#355248]">
                                {{ $refund->source_type ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-[#FAFCFB] px-4 py-4">
                            <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                                Nominal
                            </p>

                            <p class="mt-2 text-lg font-semibold text-[#123128]">
                                Rp {{ number_format((float) $refund->amount, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-[#FAFCFB] px-4 py-4">
                            <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                                Dibuat
                            </p>

                            <p class="mt-2 text-xs font-semibold text-[#355248]">
                                {{ $refund->created_at?->format('d M Y, H:i') }}
                            </p>
                        </div>

                    </div>

                    @if($refund->reason)
                        <div class="border-t border-[#EDF2EF] px-5 py-5 sm:px-6">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#8D9B94]">
                                Alasan
                            </p>

                            <div class="mt-3 rounded-xl bg-[#F8FBF9] px-4 py-4">
                                <p class="whitespace-pre-line text-xs leading-6 text-[#62766D]">
                                    {{ $refund->reason }}
                                </p>
                            </div>

                        </div>
                    @endif

                </section>

                {{-- Order --}}
                <section class="overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                    <div class="border-b border-[#EDF2EF] px-5 py-5 sm:px-6">
                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                            Order
                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                            Transaksi terkait
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-2 sm:px-6">

                        <div>
                            <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                                Order
                            </p>

                            <p class="mt-2 text-xs font-semibold text-[#355248]">
                                {{ $refund->order?->order_number ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                                Status order
                            </p>

                            <p class="mt-2 text-xs font-semibold text-[#355248]">
                                {{ ucfirst(str_replace('_', ' ', $refund->order?->status ?? '-')) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                                Client
                            </p>

                            <p class="mt-2 text-xs font-semibold text-[#355248]">
                                {{ $refund->order?->client?->name ?? '-' }}
                            </p>

                            <p class="mt-1 text-[10px] text-[#98A49E]">
                                {{ $refund->order?->client?->email ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                                Freelancer
                            </p>

                            <p class="mt-2 text-xs font-semibold text-[#355248]">
                                {{ $refund->order?->freelancerProfile?->user?->name ?? '-' }}
                            </p>
                        </div>

                    </div>

                </section>

                {{-- Payment --}}
                <section class="overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                    <div class="border-b border-[#EDF2EF] px-5 py-5 sm:px-6">
                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                            Payment
                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                            Status pembayaran
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-2 sm:px-6">

                        <div>
                            <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                                Status
                            </p>

                            <p class="mt-2 text-xs font-semibold capitalize text-[#355248]">
                                {{ str_replace('_', ' ', $refund->payment?->status ?? '-') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                                Payment ID
                            </p>

                            <p class="mt-2 text-xs font-semibold text-[#355248]">
                                #{{ $refund->payment?->id ?? '-' }}
                            </p>
                        </div>

                    </div>

                </section>

                {{-- Admin Note --}}
                @if($refund->admin_note)

                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                            Catatan Admin
                        </p>

                        <div class="mt-3 rounded-xl bg-[#F8FBF9] px-4 py-4">
                            <p class="whitespace-pre-line text-xs leading-6 text-[#62766D]">
                                {{ $refund->admin_note }}
                            </p>
                        </div>

                        @if($refund->processor)

                            <p class="mt-3 text-[10px] text-[#98A49E]">
                                Diproses oleh
                                <span class="font-semibold text-[#61776C]">
                                    {{ $refund->processor->name }}
                                </span>
                            </p>

                        @endif

                    </section>

                @endif

            </div>

            {{-- Sidebar --}}
            <aside class="space-y-5">

                {{-- Action --}}
                @if($refund->status === 'pending')

                    <section class="rounded-2xl border border-[#F2DDAF] bg-[#FFF9EA] p-5">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#B37A21] shadow-sm">
                            <i class="bi bi-arrow-counterclockwise text-[15px]"></i>
                        </div>

                        <h2 class="mt-4 text-sm font-semibold text-[#123128]">
                            Proses refund
                        </h2>

                        <p class="mt-1.5 text-xs leading-5 text-[#7D6948]">
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
                                class="block text-[10px] font-semibold text-[#76520F]"
                            >
                                Catatan
                            </label>

                            <textarea
                                id="admin_note"
                                name="admin_note"
                                rows="4"
                                placeholder="Tambahkan catatan proses refund..."
                                class="mt-2 w-full rounded-xl border border-[#E5D8B8] bg-white px-3 py-3 text-xs text-[#355248] outline-none transition placeholder:text-[#B2A484] focus:border-[#D6B96E] focus:ring-2 focus:ring-[#FFF1C9]"
                            ></textarea>

                            <button
                                type="submit"
                                class="mt-3 flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-[#B7791F] px-4 text-xs font-semibold text-white transition hover:bg-[#976217]"
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
                                class="flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-[#E8CACA] bg-white px-4 text-xs font-semibold text-[#B84E4E] transition hover:bg-[#FFF1F1]"
                            >
                                <i class="bi bi-x-circle"></i>
                                Tolak Refund
                            </button>
                        </form>

                    </section>

                @elseif($refund->status === 'processing')

                    <section class="rounded-2xl border border-[#CFE0F1] bg-[#F3F8FC] p-5">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#3C6F9F] shadow-sm">
                            <i class="bi bi-arrow-repeat text-[15px]"></i>
                        </div>

                        <h2 class="mt-4 text-sm font-semibold text-[#123128]">
                            Refund sedang diproses
                        </h2>

                        <p class="mt-1.5 text-xs leading-5 text-[#587593]">
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
                                class="block text-[10px] font-semibold text-[#315D87]"
                            >
                                Catatan penyelesaian
                            </label>

                            <textarea
                                id="complete_note"
                                name="admin_note"
                                rows="4"
                                placeholder="Contoh: Dana berhasil dikembalikan..."
                                class="mt-2 w-full rounded-xl border border-[#D3E2EE] bg-white px-3 py-3 text-xs text-[#355248] outline-none transition placeholder:text-[#A0B0BD] focus:border-[#9DBED7] focus:ring-2 focus:ring-[#EEF6FC]"
                            ></textarea>

                            <button
                                type="submit"
                                class="mt-3 flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-[#3C6F9F] px-4 text-xs font-semibold text-white transition hover:bg-[#315D87]"
                            >
                                <i class="bi bi-check2-circle"></i>
                                Tandai Sudah Direfund
                            </button>

                        </form>

                    </section>

                @elseif($refund->status === 'refunded')

                    <section class="rounded-2xl border border-[#CDE7D7] bg-[#EAF7EF] p-5">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#168A4D] shadow-sm">
                            <i class="bi bi-check-circle-fill text-[15px]"></i>
                        </div>

                        <h2 class="mt-4 text-sm font-semibold text-[#123128]">
                            Refund selesai
                        </h2>

                        <p class="mt-1.5 text-xs leading-5 text-[#587C68]">
                            Pengembalian dana telah ditandai sebagai berhasil.
                        </p>

                        @if($refund->completed_at)

                            <p class="mt-4 text-[10px] text-[#7D9789]">
                                Selesai pada
                                <span class="font-semibold text-[#587C68]">
                                    {{ $refund->completed_at->format('d M Y, H:i') }}
                                </span>
                            </p>

                        @endif

                    </section>

                @elseif($refund->status === 'rejected')

                    <section class="rounded-2xl border border-[#F0D5D5] bg-[#FFF6F6] p-5">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#B84E4E] shadow-sm">
                            <i class="bi bi-x-circle-fill text-[15px]"></i>
                        </div>

                        <h2 class="mt-4 text-sm font-semibold text-[#123128]">
                            Refund ditolak
                        </h2>

                        <p class="mt-1.5 text-xs leading-5 text-[#A26767]">
                            Pengajuan refund ini telah ditolak oleh Admin.
                        </p>

                    </section>

                @endif

                {{-- Source --}}
                <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                    <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                        Sumber
                    </p>

                    <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                        Asal refund
                    </h2>

                    <div class="mt-4 rounded-xl bg-[#F8FBF9] px-4 py-4">

                        <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">
                            Tipe
                        </p>

                        <p class="mt-2 text-xs font-semibold capitalize text-[#355248]">
                            {{ $refund->source_type ?? '-' }}
                        </p>

                        <p class="mt-1 text-[10px] text-[#98A49E]">
                            ID sumber:
                            {{ $refund->source_id ?? '-' }}
                        </p>

                    </div>

                </section>

            </aside>

        </div>

    </div>

</x-layouts.admin>