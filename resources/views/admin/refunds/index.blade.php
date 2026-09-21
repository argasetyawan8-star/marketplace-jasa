<x-layouts.admin title="Refund">

    @php
        $statusConfig = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'border-[#F2DDAF] bg-[#FFF9EA] text-[#9A6800]',
                'dot' => 'bg-[#D99A19]',
            ],
            'processing' => [
                'label' => 'Diproses',
                'class' => 'border-[#CFE0F1] bg-[#F3F8FC] text-[#3C6F9F]',
                'dot' => 'bg-[#5B91C0]',
            ],
            'refunded' => [
                'label' => 'Berhasil Refund',
                'class' => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',
                'dot' => 'bg-[#35C978]',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'class' => 'border-[#F0D5D5] bg-[#FFF6F6] text-[#B84E4E]',
                'dot' => 'bg-[#D16B6B]',
            ],
        ];
    @endphp

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">
            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                Keuangan
            </p>

            <h1 class="mt-1 text-2xl font-semibold tracking-[-0.02em] text-[#123128]">
                Refund
            </h1>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-[#7D8D86]">
                Kelola pengembalian dana dari order yang dibatalkan atau keputusan dispute.
            </p>
        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div class="mb-5 rounded-2xl border border-[#CDE7D7] bg-[#EAF7EF] px-5 py-4">
                <div class="flex items-start gap-3">
                    <i class="bi bi-check-circle-fill mt-0.5 text-[#1E9E5A]"></i>

                    <p class="text-xs leading-5 text-[#39664F]">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Summary --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">

            <a
                href="{{ route('admin.refunds.index') }}"
                class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] transition hover:-translate-y-0.5"
            >
                <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#8C9A94]">
                    Semua
                </p>

                <p class="mt-2 text-2xl font-semibold text-[#123128]">
                    {{ $counts['all'] }}
                </p>
            </a>

            <a
                href="{{ route('admin.refunds.index', ['status' => 'pending']) }}"
                class="rounded-2xl border border-[#F2DDAF] bg-[#FFF9EA] p-5"
            >
                <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#9A6800]">
                    Menunggu
                </p>

                <p class="mt-2 text-2xl font-semibold text-[#76520F]">
                    {{ $counts['pending'] }}
                </p>
            </a>

            <a
                href="{{ route('admin.refunds.index', ['status' => 'processing']) }}"
                class="rounded-2xl border border-[#CFE0F1] bg-[#F3F8FC] p-5"
            >
                <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#4D759C]">
                    Diproses
                </p>

                <p class="mt-2 text-2xl font-semibold text-[#315D87]">
                    {{ $counts['processing'] }}
                </p>
            </a>

            <a
                href="{{ route('admin.refunds.index', ['status' => 'refunded']) }}"
                class="rounded-2xl border border-[#CDE7D7] bg-[#EAF7EF] p-5"
            >
                <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#168A4D]">
                    Berhasil
                </p>

                <p class="mt-2 text-2xl font-semibold text-[#126B3D]">
                    {{ $counts['refunded'] }}
                </p>
            </a>

            <a
                href="{{ route('admin.refunds.index', ['status' => 'rejected']) }}"
                class="rounded-2xl border border-[#F0D5D5] bg-[#FFF6F6] p-5"
            >
                <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#B84E4E]">
                    Ditolak
                </p>

                <p class="mt-2 text-2xl font-semibold text-[#8E4141]">
                    {{ $counts['rejected'] }}
                </p>
            </a>

        </div>

        {{-- Filter --}}
        <section class="mt-6 rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

            <form
                action="{{ route('admin.refunds.index') }}"
                method="GET"
                class="grid grid-cols-1 gap-3 lg:grid-cols-[1fr_220px_auto]"
            >

                <div>
                    <label
                        for="search"
                        class="sr-only"
                    >
                        Cari refund
                    </label>

                    <div class="relative">
                        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-xs text-[#A2AEA8]"></i>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nomor refund, order, atau client..."
                            class="h-11 w-full rounded-xl border border-[#DCE6E1] bg-[#FBFDFC] pl-10 pr-4 text-xs text-[#355248] outline-none transition placeholder:text-[#A3AEA8] focus:border-[#9BCDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                        >
                    </div>
                </div>

                <div>
                    <label
                        for="status"
                        class="sr-only"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="h-11 w-full rounded-xl border border-[#DCE6E1] bg-[#FBFDFC] px-4 text-xs text-[#355248] outline-none transition focus:border-[#9BCDB0] focus:ring-2 focus:ring-[#EAF7EF]"
                    >
                        <option value="">Semua status</option>
                        <option value="pending" @selected(request('status') === 'pending')>
                            Menunggu
                        </option>
                        <option value="processing" @selected(request('status') === 'processing')>
                            Diproses
                        </option>
                        <option value="refunded" @selected(request('status') === 'refunded')>
                            Berhasil Refund
                        </option>
                        <option value="rejected" @selected(request('status') === 'rejected')>
                            Ditolak
                        </option>
                    </select>
                </div>

                <button
                    type="submit"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 text-xs font-semibold text-white transition hover:bg-[#0F6B3A]"
                >
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>

            </form>

        </section>

        {{-- Table --}}
        <section class="mt-6 overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

            <div class="border-b border-[#EDF2EF] px-5 py-5 sm:px-6">
                <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                    Daftar refund
                </p>

                <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                    Pengembalian dana
                </h2>
            </div>

            @if($refunds->count())

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-[#FAFCFB]">
                            <tr>
                                <th class="px-5 py-3 text-left text-[9px] font-semibold uppercase tracking-[0.12em] text-[#8B9992]">
                                    Refund
                                </th>

                                <th class="px-5 py-3 text-left text-[9px] font-semibold uppercase tracking-[0.12em] text-[#8B9992]">
                                    Order
                                </th>

                                <th class="px-5 py-3 text-left text-[9px] font-semibold uppercase tracking-[0.12em] text-[#8B9992]">
                                    Client
                                </th>

                                <th class="px-5 py-3 text-right text-[9px] font-semibold uppercase tracking-[0.12em] text-[#8B9992]">
                                    Nominal
                                </th>

                                <th class="px-5 py-3 text-left text-[9px] font-semibold uppercase tracking-[0.12em] text-[#8B9992]">
                                    Status
                                </th>

                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#EDF2EF]">

                            @foreach($refunds as $refund)

                                @php
                                    $status = $statusConfig[$refund->status]
                                        ?? [
                                            'label' => ucfirst($refund->status),
                                            'class' => 'border-gray-200 bg-gray-50 text-gray-600',
                                            'dot' => 'bg-gray-400',
                                        ];
                                @endphp

                                <tr class="transition hover:bg-[#FCFEFD]">

                                    <td class="px-5 py-4">
                                        <p class="text-xs font-semibold text-[#355248]">
                                            {{ $refund->refund_number }}
                                        </p>

                                        <p class="mt-1 text-[10px] text-[#98A49E]">
                                            {{ $refund->created_at?->format('d M Y, H:i') }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <p class="text-xs font-semibold text-[#355248]">
                                            {{ $refund->order?->order_number ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <p class="text-xs font-semibold text-[#355248]">
                                            {{ $refund->order?->client?->name ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-[10px] text-[#98A49E]">
                                            {{ $refund->order?->client?->email ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <p class="text-xs font-semibold text-[#123128]">
                                            Rp {{ number_format((float) $refund->amount, 0, ',', '.') }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-[9px] font-semibold {{ $status['class'] }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                            {{ $status['label'] }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <a
                                            href="{{ route('admin.refunds.show', $refund) }}"
                                            class="inline-flex h-9 items-center justify-center gap-2 rounded-lg border border-[#DCE6E1] bg-white px-3 text-[10px] font-semibold text-[#355248] transition hover:border-[#BFDACA] hover:text-[#1E9E5A]"
                                        >
                                            Detail
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="border-t border-[#EDF2EF] px-5 py-4 sm:px-6">
                    {{ $refunds->links() }}
                </div>

            @else

                <div class="px-6 py-14 text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F3F8F5] text-[#8FA199]">
                        <i class="bi bi-arrow-counterclockwise text-lg"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-[#355248]">
                        Belum ada refund
                    </h3>

                    <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-[#98A49E]">
                        Data refund akan muncul ketika pembayaran berstatus refund_pending dan proses pengembalian dana dibuat.
                    </p>

                </div>

            @endif

        </section>

    </div>

</x-layouts.admin>