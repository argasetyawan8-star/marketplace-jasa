<x-layouts.freelancer title="Pembatalan Order">

    @php

        /*
        |--------------------------------------------------------------------------
        | Normalisasi variabel dari Controller
        |--------------------------------------------------------------------------
        |
        | Controller baru mengirim $latestRequest dan $pendingRequest.
        | View menggunakan satu variabel utama: $cancellationRequest.
        |
        */

        $cancellationRequest =
            $latestRequest
            ?? $pendingRequest
            ?? null;

        abort_unless(
            $cancellationRequest,
            404
        );

        $requestStatus = $cancellationRequest->status;

        $statusLabel = match ($requestStatus) {

            'pending_freelancer'
                => 'Menunggu tanggapan freelancer',

            'rejected_by_freelancer'
                => 'Ditolak freelancer',

            'mediation_pending'
                => 'Menunggu mediasi admin',

            'approved_by_freelancer'
                => 'Disetujui freelancer',

            'approved_by_admin'
                => 'Disetujui admin',

            'rejected_by_admin'
                => 'Ditolak admin',

            default
                => ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $requestStatus
                    )
                ),

        };

        $statusClass = match ($requestStatus) {

            'pending_freelancer'
                => 'border-[#E8D59E] bg-[#FFF9EA] text-[#8A620B]',

            'rejected_by_freelancer'
                => 'border-red-100 bg-red-50 text-red-700',

            'mediation_pending'
                => 'border-[#CFE0F1] bg-[#F3F8FC] text-[#315D87]',

            'approved_by_freelancer',
            'approved_by_admin'
                => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',

            'rejected_by_admin'
                => 'border-red-100 bg-red-50 text-red-700',

            default
                => 'border-[#DDE9E2] bg-[#F8FCF9] text-[#62766D]',

        };

        $isPendingFreelancer =
            $requestStatus === 'pending_freelancer';

    @endphp


    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- BACK --}}
        <a
            href="{{ route('freelancer.orders.show', $order) }}"
            class="inline-flex items-center gap-2 text-sm text-[#71837B] transition hover:text-[#0F6B3A]"
        >

            <i class="bi bi-arrow-left"></i>

            Kembali ke order

        </a>


        {{-- MAIN CARD --}}
        <div
            class="mt-6 overflow-hidden rounded-2xl border border-[#DDE9E2] bg-white shadow-[0_8px_26px_rgba(18,49,40,0.035)]"
        >

            {{-- =========================================================
                HEADER
            ========================================================== --}}

            <div class="border-b border-[#EDF2EF] px-6 py-6">

                <div
                    class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >

                    <div>

                        <p
                            class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]"
                        >
                            Pembatalan Order
                        </p>

                        <h1
                            class="mt-2 text-xl font-semibold tracking-[-0.02em] text-[#123128]"
                        >
                            {{ $order->order_number }}
                        </h1>

                        <p class="mt-1 text-sm text-[#71837B]">
                            Client mengajukan pembatalan pesanan.
                        </p>

                    </div>


                    {{-- STATUS --}}
                    <span
                        class="inline-flex w-fit items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $statusClass }}"
                    >

                        @if($requestStatus === 'pending_freelancer')

                            <i class="bi bi-hourglass-split"></i>

                        @elseif($requestStatus === 'rejected_by_freelancer')

                            <i class="bi bi-x-circle"></i>

                        @elseif($requestStatus === 'mediation_pending')

                            <i class="bi bi-shield-check"></i>

                        @elseif(
                            in_array(
                                $requestStatus,
                                [
                                    'approved_by_freelancer',
                                    'approved_by_admin',
                                ],
                                true
                            )
                        )

                            <i class="bi bi-check-circle"></i>

                        @elseif($requestStatus === 'rejected_by_admin')

                            <i class="bi bi-shield-x"></i>

                        @else

                            <i class="bi bi-info-circle"></i>

                        @endif

                        {{ $statusLabel }}

                    </span>

                </div>

            </div>


            {{-- =========================================================
                ALERT SUCCESS
            ========================================================== --}}

            @if(session('success'))

                <div class="mx-6 mt-5 rounded-xl border border-[#CDE8D7] bg-[#EAF7EF] px-4 py-3">

                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-[#1E9E5A] shadow-sm"
                        >
                            <i class="bi bi-check-lg text-sm"></i>
                        </div>

                        <p class="pt-1 text-sm text-[#168A4D]">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                ALERT ERROR
            ========================================================== --}}

            @if(session('error'))

                <div class="mx-6 mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3">

                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-red-600 shadow-sm"
                        >
                            <i class="bi bi-exclamation-lg text-sm"></i>
                        </div>

                        <p class="pt-1 text-sm text-red-700">
                            {{ session('error') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                VALIDATION ERRORS
            ========================================================== --}}

            @if($errors->any())

                <div class="mx-6 mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-4">

                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-red-600 shadow-sm"
                        >
                            <i class="bi bi-exclamation-triangle text-sm"></i>
                        </div>

                        <div class="min-w-0">

                            <p class="text-sm font-semibold text-red-700">
                                Ada data yang perlu diperbaiki
                            </p>

                            <div class="mt-2 space-y-1">

                                @foreach($errors->all() as $error)

                                    <p class="text-xs leading-5 text-red-600">
                                        {{ $error }}
                                    </p>

                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                CONTENT
            ========================================================== --}}

            <div class="space-y-6 px-6 py-6">


                {{-- =====================================================
                    REQUESTER
                ====================================================== --}}

                <section>

                    <p
                        class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#899991]"
                    >
                        Pemohon
                    </p>

                    <div
                        class="mt-3 rounded-xl border border-[#E7EEE9] bg-[#F8FCF9] p-4"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A]"
                            >

                                {{
                                    strtoupper(
                                        substr(
                                            $cancellationRequest->requester?->name
                                            ?? 'C',
                                            0,
                                            1
                                        )
                                    )
                                }}

                            </div>


                            <div class="min-w-0">

                                <p
                                    class="truncate text-sm font-semibold text-[#123128]"
                                >
                                    {{ $cancellationRequest->requester?->name ?? 'Client' }}
                                </p>

                                <p
                                    class="mt-0.5 truncate text-xs text-[#899991]"
                                >
                                    {{ $cancellationRequest->requester?->email ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- =====================================================
                    REASON
                ====================================================== --}}

                <section>

                    <p
                        class="text-xs font-semibold text-[#52675D]"
                    >
                        Alasan pembatalan
                    </p>

                    <div
                        class="mt-2 rounded-xl border border-[#E7EEE9] bg-[#F8FCF9] p-5"
                    >

                        <p
                            class="whitespace-pre-line text-sm leading-7 text-[#62766D]"
                        >
                            {{ $cancellationRequest->reason }}
                        </p>

                    </div>

                </section>


                {{-- =====================================================
                    PENDING RESPONSE
                ====================================================== --}}

                @if($requestStatus === 'pending_freelancer')

                    <section
                        class="rounded-xl border border-[#E8D59E] bg-[#FFF9EA] p-5"
                    >

                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#B7791F] shadow-sm"
                            >
                                <i class="bi bi-hourglass-split text-[15px]"></i>
                            </div>


                            <div>

                                <p
                                    class="text-sm font-semibold text-[#76520F]"
                                >
                                    Client meminta pembatalan
                                </p>

                                <p
                                    class="mt-1 text-xs leading-5 text-[#8C7144]"
                                >
                                    Tinjau alasan pembatalan sebelum menentukan apakah kamu menyetujui atau menolak pengajuan ini.
                                </p>

                            </div>

                        </div>

                    </section>

                @endif


                {{-- =====================================================
                    FREELANCER REJECTED
                ====================================================== --}}

                @if($requestStatus === 'rejected_by_freelancer')

                    <section
                        class="rounded-xl border border-red-100 bg-red-50 p-5"
                    >

                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm"
                            >
                                <i class="bi bi-x-circle text-[15px]"></i>
                            </div>


                            <div class="min-w-0">

                                <p
                                    class="text-sm font-semibold text-red-700"
                                >
                                    Kamu sudah menolak pembatalan ini.
                                </p>

                                @if($cancellationRequest->freelancer_note)

                                    <div class="mt-3 rounded-xl bg-white/80 px-4 py-3">

                                        <p
                                            class="whitespace-pre-line text-sm leading-6 text-red-700"
                                        >
                                            {{ $cancellationRequest->freelancer_note }}
                                        </p>

                                    </div>

                                @endif

                                <p
                                    class="mt-3 text-xs leading-5 text-red-600/80"
                                >
                                    Client dapat meneruskan pengajuan ini ke Admin melalui proses mediasi.
                                </p>

                            </div>

                        </div>

                    </section>

                @endif


                {{-- =====================================================
                    MEDIATION
                ====================================================== --}}

                @if($requestStatus === 'mediation_pending')

                    <section
                        class="rounded-xl border border-[#CFE0F1] bg-[#F3F8FC] p-5"
                    >

                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#315D87] shadow-sm"
                            >
                                <i class="bi bi-shield-check text-[15px]"></i>
                            </div>


                            <div class="min-w-0">

                                <p
                                    class="text-sm font-semibold text-[#315D87]"
                                >
                                    Pengajuan sedang dimediasi Admin
                                </p>

                                <p
                                    class="mt-1 text-xs leading-5 text-[#587593]"
                                >
                                    Client telah meneruskan pengajuan ini kepada Admin. Tunggu keputusan mediasi.
                                </p>

                            </div>

                        </div>


                        @if($cancellationRequest->mediation_reason)

                            <div
                                class="mt-4 rounded-xl bg-white/80 p-4"
                            >

                                <p
                                    class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#6D8498]"
                                >
                                    Alasan mediasi
                                </p>

                                <p
                                    class="mt-2 whitespace-pre-line text-sm leading-6 text-[#4F6678]"
                                >
                                    {{ $cancellationRequest->mediation_reason }}
                                </p>

                            </div>

                        @endif

                    </section>

                @endif


                {{-- =====================================================
                    APPROVED
                ====================================================== --}}

                @if(
                    in_array(
                        $requestStatus,
                        [
                            'approved_by_freelancer',
                            'approved_by_admin',
                        ],
                        true
                    )
                )

                    <section
                        class="rounded-xl border border-[#CDE7D7] bg-[#EAF7EF] p-5"
                    >

                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#168A4D] shadow-sm"
                            >
                                <i class="bi bi-check-circle text-[15px]"></i>
                            </div>


                            <div class="min-w-0">

                                <p
                                    class="text-sm font-semibold text-[#168A4D]"
                                >
                                    Pembatalan telah disetujui
                                </p>

                                <p
                                    class="mt-1 text-xs leading-5 text-[#587C68]"
                                >
                                    Order ini telah dibatalkan sesuai keputusan pembatalan.
                                </p>

                                @if($cancellationRequest->freelancer_note)

                                    <div
                                        class="mt-4 rounded-xl bg-white/80 p-4"
                                    >

                                        <p
                                            class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#63836F]"
                                        >
                                            Catatan freelancer
                                        </p>

                                        <p
                                            class="mt-2 whitespace-pre-line text-sm leading-6 text-[#52675D]"
                                        >
                                            {{ $cancellationRequest->freelancer_note }}
                                        </p>

                                    </div>

                                @endif


                                @if($cancellationRequest->admin_note)

                                    <div
                                        class="mt-4 rounded-xl bg-white/80 p-4"
                                    >

                                        <p
                                            class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#63836F]"
                                        >
                                            Catatan admin
                                        </p>

                                        <p
                                            class="mt-2 whitespace-pre-line text-sm leading-6 text-[#52675D]"
                                        >
                                            {{ $cancellationRequest->admin_note }}
                                        </p>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </section>

                @endif


                {{-- =====================================================
                    ADMIN REJECTED
                ====================================================== --}}

                @if($requestStatus === 'rejected_by_admin')

                    <section
                        class="rounded-xl border border-red-100 bg-red-50 p-5"
                    >

                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm"
                            >
                                <i class="bi bi-shield-x text-[15px]"></i>
                            </div>


                            <div class="min-w-0">

                                <p
                                    class="text-sm font-semibold text-red-700"
                                >
                                    Mediasi ditolak Admin
                                </p>

                                <p
                                    class="mt-1 text-xs leading-5 text-red-600/80"
                                >
                                    Pembatalan tidak disetujui melalui mediasi dan order tetap berjalan.
                                </p>

                                @if($cancellationRequest->admin_note)

                                    <div
                                        class="mt-4 rounded-xl bg-white/80 p-4"
                                    >

                                        <p
                                            class="text-[10px] font-semibold uppercase tracking-[0.15em] text-red-500"
                                        >
                                            Catatan admin
                                        </p>

                                        <p
                                            class="mt-2 whitespace-pre-line text-sm leading-6 text-[#7A5A5A]"
                                        >
                                            {{ $cancellationRequest->admin_note }}
                                        </p>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </section>

                @endif


                {{-- =====================================================
                    ACTIONS
                ====================================================== --}}

                @if($isPendingFreelancer)

                    <section class="grid gap-5 lg:grid-cols-2">


                        {{-- =================================================
                            APPROVE
                        ================================================== --}}

                        <form
                            action="{{ route('freelancer.orders.cancellation.approve', $order) }}"
                            method="POST"
                            class="rounded-2xl border border-[#CDE7D7] bg-[#F7FBF8] p-5"
                        >

                            @csrf


                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-[#168A4D]"
                                >
                                    <i class="bi bi-check-lg"></i>
                                </div>


                                <div>

                                    <p
                                        class="text-sm font-semibold text-[#168A4D]"
                                    >
                                        Setujui pembatalan
                                    </p>

                                    <p
                                        class="mt-1 text-xs leading-5 text-[#71837B]"
                                    >
                                        Order akan dibatalkan dan status pembayaran akan menyesuaikan proses transaksi.
                                    </p>

                                </div>

                            </div>


                            <label
                                for="approve-freelancer-note"
                                class="mt-4 block text-xs font-semibold text-[#52675D]"
                            >
                                Catatan freelancer
                            </label>

                            <textarea
                                id="approve-freelancer-note"
                                name="freelancer_note"
                                rows="4"
                                maxlength="2000"
                                class="mt-2 block w-full resize-none rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm leading-6 text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                                placeholder="Catatan persetujuan (opsional)..."
                            >{{ old('freelancer_note') }}</textarea>


                            <button
                                type="submit"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-sm font-semibold text-white shadow-sm transition hover:bg-[#1E9E5A]"
                            >

                                <i class="bi bi-check-lg"></i>

                                Setujui pembatalan

                            </button>

                        </form>


                        {{-- =================================================
                            REJECT
                        ================================================== --}}

                        <form
                            action="{{ route('freelancer.orders.cancellation.reject', $order) }}"
                            method="POST"
                            class="rounded-2xl border border-red-100 bg-red-50 p-5"
                        >

                            @csrf


                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white text-red-600 shadow-sm"
                                >
                                    <i class="bi bi-x-lg"></i>
                                </div>


                                <div>

                                    <p
                                        class="text-sm font-semibold text-red-700"
                                    >
                                        Tolak pembatalan
                                    </p>

                                    <p
                                        class="mt-1 text-xs leading-5 text-red-600/80"
                                    >
                                        Berikan alasan agar client memahami keputusanmu.
                                    </p>

                                </div>

                            </div>


                            <label
                                for="reject-freelancer-note"
                                class="mt-4 block text-xs font-semibold text-red-700"
                            >
                                Alasan penolakan
                            </label>

                            <textarea
                                id="reject-freelancer-note"
                                name="freelancer_note"
                                rows="4"
                                minlength="5"
                                maxlength="2000"
                                required
                                class="mt-2 block w-full resize-none rounded-xl border border-red-100 bg-white px-4 py-3 text-sm leading-6 text-[#123128] outline-none transition focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                placeholder="Jelaskan alasan penolakan..."
                            >{{ old('freelancer_note') }}</textarea>


                            <button
                                type="submit"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-red-600 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700"
                            >

                                <i class="bi bi-x-lg"></i>

                                Tolak pembatalan

                            </button>

                        </form>

                    </section>

                @endif


                {{-- =====================================================
                    ORDER INFORMATION
                ====================================================== --}}

                <section
                    class="rounded-xl border border-[#E7EEE9] bg-white"
                >

                    <div
                        class="border-b border-[#EDF2EF] px-5 py-4"
                    >

                        <p
                            class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#899991]"
                        >
                            Informasi Order
                        </p>

                    </div>


                    <div class="grid gap-4 px-5 py-5 sm:grid-cols-2">


                        <div>

                            <p class="text-[10px] text-[#98A49E]">
                                Nomor Order
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128]">
                                {{ $order->order_number }}
                            </p>

                        </div>


                        <div>

                            <p class="text-[10px] text-[#98A49E]">
                                Status Order
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128]">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </p>

                        </div>


                        <div>

                            <p class="text-[10px] text-[#98A49E]">
                                Nilai Order
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128]">
                                Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                            </p>

                        </div>


                        <div>

                            <p class="text-[10px] text-[#98A49E]">
                                Dibuat
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128]">
                                {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                            </p>

                        </div>

                    </div>

                </section>


                {{-- =====================================================
                    FOOTNOTE
                ====================================================== --}}

                <div
                    class="rounded-xl border border-[#E7EEE9] bg-[#F8FCF9] px-4 py-3"
                >

                    <div class="flex items-start gap-3">

                        <i
                            class="bi bi-info-circle mt-0.5 text-sm text-[#1E9E5A]"
                        ></i>

                        <p
                            class="text-[11px] leading-5 text-[#71837B]"
                        >
                            Pengajuan pembatalan perlu ditinjau berdasarkan alasan client dan kondisi order. Setelah keputusan dibuat, status pengajuan tidak dapat diubah kembali.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-layouts.freelancer>
