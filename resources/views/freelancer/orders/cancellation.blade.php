<x-layouts.freelancer title="Pembatalan Order">

    @php

        /*
        |--------------------------------------------------------------------------
        | Normalisasi variabel dari Controller
        |--------------------------------------------------------------------------
        */

        $cancellationRequest =
            $latestRequest
            ?? $pendingRequest
            ?? null;

        abort_unless(
            $cancellationRequest,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        $requestStatus =
            $cancellationRequest->status;


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


        /*
        |--------------------------------------------------------------------------
        | Status visual - mengikuti visual language ProKerja
        |--------------------------------------------------------------------------
        */

        $statusClass = match ($requestStatus) {

            'pending_freelancer'
                => 'border-amber-200 bg-amber-50 text-amber-700',

            'rejected_by_freelancer'
                => 'border-red-100 bg-red-50 text-red-700',

            'mediation_pending'
                => 'border-blue-100 bg-blue-50 text-blue-700',

            'approved_by_freelancer',
            'approved_by_admin'
                => 'border-emerald-100 bg-emerald-50 text-emerald-700',

            'rejected_by_admin'
                => 'border-red-100 bg-red-50 text-red-700',

            default
                => 'border-slate-200 bg-slate-50 text-slate-600',

        };


        /*
        |--------------------------------------------------------------------------
        | Status icon
        |--------------------------------------------------------------------------
        */

        $statusIcon = match ($requestStatus) {

            'pending_freelancer'
                => 'bi-hourglass-split',

            'rejected_by_freelancer'
                => 'bi-x-circle',

            'mediation_pending'
                => 'bi-shield-check',

            'approved_by_freelancer',
            'approved_by_admin'
                => 'bi-check-circle',

            'rejected_by_admin'
                => 'bi-shield-x',

            default
                => 'bi-info-circle',

        };


        $isPendingFreelancer =
            $requestStatus === 'pending_freelancer';

    @endphp



    <div class="min-h-full bg-slate-50">

        <div class="mx-auto max-w-5xl px-4 py-5 sm:px-6 sm:py-7 lg:px-8">


            {{-- =========================================================
                BACK
            ========================================================== --}}

            <a
                href="{{ route('freelancer.orders.show', $order) }}"
                class="group inline-flex items-center gap-2 text-xs font-medium text-slate-500 transition duration-200 hover:text-blue-600"
            >

                <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition group-hover:border-blue-100 group-hover:bg-blue-50 group-hover:text-blue-600">
                    <i class="bi bi-arrow-left text-[11px]"></i>
                </span>

                <span>
                    Kembali ke order
                </span>

            </a>



            {{-- =========================================================
                MAIN
            ========================================================== --}}

            <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_10px_30px_rgba(15,23,42,0.045)]">


                {{-- =====================================================
                    HEADER
                ====================================================== --}}

                <div class="border-b border-slate-100 px-4 py-5 sm:px-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">


                        <div class="min-w-0">

                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600">
                                Pembatalan Order
                            </p>

                            <h1 class="mt-1.5 truncate text-lg font-bold tracking-[-0.02em] text-slate-900 sm:text-xl">
                                {{ $order->order_number }}
                            </h1>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Client mengajukan pembatalan pesanan.
                            </p>

                        </div>


                        {{-- STATUS --}}

                        <span
                            class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full border px-3 py-1.5 text-[10px] font-semibold sm:text-xs {{ $statusClass }}"
                        >

                            <i class="bi {{ $statusIcon }} text-[10px] sm:text-[11px]"></i>

                            {{ $statusLabel }}

                        </span>

                    </div>

                </div>



                {{-- =====================================================
                    ALERTS
                ====================================================== --}}

                @if(session('success'))

                    <div class="mx-4 mt-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 sm:mx-6">

                        <div class="flex items-start gap-3">

                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-emerald-600 shadow-sm">

                                <i class="bi bi-check-lg text-sm"></i>

                            </span>


                            <div class="min-w-0">

                                <p class="text-xs font-semibold text-emerald-700">
                                    Berhasil
                                </p>

                                <p class="mt-0.5 text-xs leading-5 text-emerald-700/80">
                                    {{ session('success') }}
                                </p>

                            </div>

                        </div>

                    </div>

                @endif



                @if(session('error'))

                    <div class="mx-4 mt-4 rounded-xl border border-red-100 bg-red-50 px-4 py-3 sm:mx-6">

                        <div class="flex items-start gap-3">

                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-red-600 shadow-sm">

                                <i class="bi bi-exclamation-lg text-sm"></i>

                            </span>


                            <div class="min-w-0">

                                <p class="text-xs font-semibold text-red-700">
                                    Tidak dapat diproses
                                </p>

                                <p class="mt-0.5 text-xs leading-5 text-red-700/80">
                                    {{ session('error') }}
                                </p>

                            </div>

                        </div>

                    </div>

                @endif



                @if($errors->any())

                    <div class="mx-4 mt-4 rounded-xl border border-red-100 bg-red-50 px-4 py-4 sm:mx-6">

                        <div class="flex items-start gap-3">

                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-red-600 shadow-sm">

                                <i class="bi bi-exclamation-triangle text-sm"></i>

                            </span>


                            <div class="min-w-0">

                                <p class="text-xs font-semibold text-red-700">
                                    Ada data yang perlu diperbaiki
                                </p>

                                <div class="mt-2 space-y-1">

                                    @foreach($errors->all() as $error)

                                        <p class="text-[11px] leading-5 text-red-600">
                                            {{ $error }}
                                        </p>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                @endif



                {{-- =====================================================
                    CONTENT
                ====================================================== --}}

                <div class="space-y-5 px-4 py-5 sm:px-6 sm:py-6">


                    {{-- =================================================
                        REQUESTER
                    ================================================== --}}

                    <section>

                        <div class="flex items-center gap-2">

                            <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                            <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">
                                Pemohon
                            </p>

                        </div>


                        <div class="mt-3 rounded-xl border border-slate-200 bg-slate-50/70 p-3.5 sm:p-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-600 sm:h-11 sm:w-11 sm:text-sm">

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

                                    <p class="truncate text-xs font-semibold text-slate-900 sm:text-sm">

                                        {{ $cancellationRequest->requester?->name ?? 'Client' }}

                                    </p>

                                    <p class="mt-0.5 truncate text-[10px] text-slate-400 sm:text-xs">

                                        {{ $cancellationRequest->requester?->email ?? '-' }}

                                    </p>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- =================================================
                        REASON
                    ================================================== --}}

                    <section>

                        <div class="flex items-center gap-2">

                            <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                            <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">
                                Alasan Pembatalan
                            </p>

                        </div>


                        <div class="mt-3 rounded-xl border border-slate-200 bg-white">

                            <div class="px-4 py-4 sm:px-5">

                                <p class="whitespace-pre-line text-xs leading-6 text-slate-600 sm:text-sm sm:leading-7">
                                    {{ $cancellationRequest->reason }}
                                </p>

                            </div>

                        </div>

                    </section>



                    {{-- =================================================
                        PENDING
                    ================================================== --}}

                    @if($requestStatus === 'pending_freelancer')

                        <section class="rounded-2xl border border-amber-200 bg-amber-50/70 p-4 sm:p-5">

                            <div class="flex items-start gap-3">

                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm">

                                    <i class="bi bi-hourglass-split text-[14px]"></i>

                                </span>


                                <div class="min-w-0">

                                    <p class="text-xs font-semibold text-amber-800 sm:text-sm">
                                        Client meminta pembatalan
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-amber-800/75 sm:text-xs">
                                        Tinjau alasan pembatalan sebelum menentukan apakah kamu menyetujui atau menolak pengajuan ini.
                                    </p>

                                </div>

                            </div>

                        </section>

                    @endif



                    {{-- =================================================
                        REJECTED BY FREELANCER
                    ================================================== --}}

                    @if($requestStatus === 'rejected_by_freelancer')

                        <section class="rounded-2xl border border-red-100 bg-red-50 p-4 sm:p-5">

                            <div class="flex items-start gap-3">

                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">

                                    <i class="bi bi-x-circle text-[14px]"></i>

                                </span>


                                <div class="min-w-0 flex-1">

                                    <p class="text-xs font-semibold text-red-700 sm:text-sm">
                                        Kamu sudah menolak pembatalan ini.
                                    </p>


                                    @if($cancellationRequest->freelancer_note)

                                        <div class="mt-3 rounded-xl border border-red-100 bg-white/80 px-4 py-3">

                                            <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-red-500">
                                                Catatan freelancer
                                            </p>

                                            <p class="mt-1.5 whitespace-pre-line text-xs leading-6 text-red-700">
                                                {{ $cancellationRequest->freelancer_note }}
                                            </p>

                                        </div>

                                    @endif


                                    <p class="mt-3 text-[11px] leading-5 text-red-600/75">
                                        Client dapat meneruskan pengajuan ini ke Admin melalui proses mediasi.
                                    </p>

                                </div>

                            </div>

                        </section>

                    @endif



                    {{-- =================================================
                        MEDIATION
                    ================================================== --}}

                    @if($requestStatus === 'mediation_pending')

                        <section class="rounded-2xl border border-blue-100 bg-blue-50/80 p-4 sm:p-5">

                            <div class="flex items-start gap-3">

                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">

                                    <i class="bi bi-shield-check text-[14px]"></i>

                                </span>


                                <div class="min-w-0">

                                    <p class="text-xs font-semibold text-blue-700 sm:text-sm">
                                        Pengajuan sedang dimediasi Admin
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-blue-700/75 sm:text-xs">
                                        Client telah meneruskan pengajuan ini kepada Admin. Tunggu keputusan mediasi.
                                    </p>

                                </div>

                            </div>


                            @if($cancellationRequest->mediation_reason)

                                <div class="mt-4 rounded-xl border border-blue-100 bg-white/80 px-4 py-3.5">

                                    <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-blue-500">
                                        Alasan mediasi
                                    </p>

                                    <p class="mt-1.5 whitespace-pre-line text-xs leading-6 text-slate-600">
                                        {{ $cancellationRequest->mediation_reason }}
                                    </p>

                                </div>

                            @endif

                        </section>

                    @endif



                    {{-- =================================================
                        APPROVED
                    ================================================== --}}

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

                        <section class="rounded-2xl border border-emerald-100 bg-emerald-50/80 p-4 sm:p-5">

                            <div class="flex items-start gap-3">

                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm">

                                    <i class="bi bi-check-circle text-[14px]"></i>

                                </span>


                                <div class="min-w-0 flex-1">

                                    <p class="text-xs font-semibold text-emerald-700 sm:text-sm">
                                        Pembatalan telah disetujui
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-emerald-700/75 sm:text-xs">
                                        Order ini telah dibatalkan sesuai keputusan pembatalan.
                                    </p>


                                    @if($cancellationRequest->freelancer_note)

                                        <div class="mt-4 rounded-xl border border-emerald-100 bg-white/80 px-4 py-3.5">

                                            <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-slate-400">
                                                Catatan freelancer
                                            </p>

                                            <p class="mt-1.5 whitespace-pre-line text-xs leading-6 text-slate-600">
                                                {{ $cancellationRequest->freelancer_note }}
                                            </p>

                                        </div>

                                    @endif


                                    @if($cancellationRequest->admin_note)

                                        <div class="mt-3 rounded-xl border border-emerald-100 bg-white/80 px-4 py-3.5">

                                            <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-slate-400">
                                                Catatan admin
                                            </p>

                                            <p class="mt-1.5 whitespace-pre-line text-xs leading-6 text-slate-600">
                                                {{ $cancellationRequest->admin_note }}
                                            </p>

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </section>

                    @endif



                    {{-- =================================================
                        REJECTED ADMIN
                    ================================================== --}}

                    @if($requestStatus === 'rejected_by_admin')

                        <section class="rounded-2xl border border-red-100 bg-red-50 p-4 sm:p-5">

                            <div class="flex items-start gap-3">

                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">

                                    <i class="bi bi-shield-x text-[14px]"></i>

                                </span>


                                <div class="min-w-0 flex-1">

                                    <p class="text-xs font-semibold text-red-700 sm:text-sm">
                                        Mediasi ditolak Admin
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-red-600/75 sm:text-xs">
                                        Pembatalan tidak disetujui melalui mediasi dan order tetap berjalan.
                                    </p>


                                    @if($cancellationRequest->admin_note)

                                        <div class="mt-4 rounded-xl border border-red-100 bg-white/80 px-4 py-3.5">

                                            <p class="text-[9px] font-bold uppercase tracking-[0.15em] text-red-500">
                                                Catatan admin
                                            </p>

                                            <p class="mt-1.5 whitespace-pre-line text-xs leading-6 text-slate-600">
                                                {{ $cancellationRequest->admin_note }}
                                            </p>

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </section>

                    @endif



                    {{-- =================================================
                        ACTIONS
                    ================================================== --}}

                    @if($isPendingFreelancer)

                        <section class="grid gap-4 lg:grid-cols-2">


                            {{-- =================================================
                                APPROVE
                            ================================================== --}}

                            <form
                                action="{{ route('freelancer.orders.cancellation.approve', $order) }}"
                                method="POST"
                                class="rounded-2xl border border-slate-200 bg-white p-4 shadow-[0_4px_14px_rgba(15,23,42,0.025)] sm:p-5"
                            >

                                @csrf


                                <div class="flex items-start gap-3">

                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                                        <i class="bi bi-check-lg text-[14px]"></i>

                                    </span>


                                    <div class="min-w-0">

                                        <p class="text-xs font-bold text-slate-900 sm:text-sm">
                                            Setujui pembatalan
                                        </p>

                                        <p class="mt-1 text-[11px] leading-5 text-slate-500 sm:text-xs">
                                            Order akan dibatalkan dan status pembayaran akan menyesuaikan proses transaksi.
                                        </p>

                                    </div>

                                </div>


                                <label
                                    for="approve-freelancer-note"
                                    class="mt-4 block text-[10px] font-semibold text-slate-600 sm:text-xs"
                                >
                                    Catatan freelancer
                                </label>


                                <textarea
                                    id="approve-freelancer-note"
                                    name="freelancer_note"
                                    rows="4"
                                    maxlength="2000"
                                    class="mt-2 block w-full resize-none rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-3 text-xs leading-6 text-slate-800 outline-none transition duration-200 placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50 sm:text-sm"
                                    placeholder="Catatan persetujuan (opsional)..."
                                >{{ old('freelancer_note') }}</textarea>


                                <button
                                    type="submit"
                                    class="mt-3 inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-xs font-semibold text-white transition duration-200 hover:bg-blue-700 active:scale-[0.99] sm:h-11 sm:text-sm"
                                >

                                    <i class="bi bi-check-lg text-[11px]"></i>

                                    Setujui pembatalan

                                </button>

                            </form>



                            {{-- =================================================
                                REJECT
                            ================================================== --}}

                            <form
                                action="{{ route('freelancer.orders.cancellation.reject', $order) }}"
                                method="POST"
                                class="rounded-2xl border border-red-100 bg-red-50/55 p-4 sm:p-5"
                            >

                                @csrf


                                <div class="flex items-start gap-3">

                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">

                                        <i class="bi bi-x-lg text-[13px]"></i>

                                    </span>


                                    <div class="min-w-0">

                                        <p class="text-xs font-bold text-red-700 sm:text-sm">
                                            Tolak pembatalan
                                        </p>

                                        <p class="mt-1 text-[11px] leading-5 text-red-600/75 sm:text-xs">
                                            Berikan alasan agar client memahami keputusanmu.
                                        </p>

                                    </div>

                                </div>


                                <label
                                    for="reject-freelancer-note"
                                    class="mt-4 block text-[10px] font-semibold text-red-700 sm:text-xs"
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
                                    class="mt-2 block w-full resize-none rounded-xl border border-red-100 bg-white px-3.5 py-3 text-xs leading-6 text-slate-800 outline-none transition duration-200 placeholder:text-slate-400 focus:border-red-300 focus:ring-4 focus:ring-red-50 sm:text-sm"
                                    placeholder="Jelaskan alasan penolakan..."
                                >{{ old('freelancer_note') }}</textarea>


                                <button
                                    type="submit"
                                    class="mt-3 inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-4 text-xs font-semibold text-white transition duration-200 hover:bg-red-700 active:scale-[0.99] sm:h-11 sm:text-sm"
                                >

                                    <i class="bi bi-x-lg text-[11px]"></i>

                                    Tolak pembatalan

                                </button>

                            </form>

                        </section>

                    @endif



                    {{-- =================================================
                        ORDER INFORMATION
                    ================================================== --}}

                    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white">

                        <div class="border-b border-slate-100 px-4 py-3.5 sm:px-5">

                            <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">
                                Informasi Order
                            </p>

                        </div>


                        <div class="grid grid-cols-2 divide-x divide-y divide-slate-100 sm:grid-cols-4 sm:divide-y-0">

                            <div class="px-4 py-4 sm:px-5">

                                <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                                    Nomor Order
                                </p>

                                <p class="mt-1.5 truncate text-xs font-semibold text-slate-900 sm:text-sm">
                                    {{ $order->order_number }}
                                </p>

                            </div>


                            <div class="px-4 py-4 sm:px-5 sm:pl-5">

                                <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                                    Status Order
                                </p>

                                <p class="mt-1.5 text-xs font-semibold capitalize text-slate-900 sm:text-sm">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </p>

                            </div>


                            <div class="px-4 py-4 sm:px-5">

                                <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                                    Nilai Order
                                </p>

                                <p class="mt-1.5 text-xs font-semibold text-slate-900 sm:text-sm">
                                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                </p>

                            </div>


                            <div class="px-4 py-4 sm:px-5">

                                <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                                    Dibuat
                                </p>

                                <p class="mt-1.5 text-xs font-semibold text-slate-900 sm:text-sm">
                                    {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </section>



                    {{-- =================================================
                        FOOTNOTE
                    ================================================== --}}

                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5">

                        <div class="flex items-start gap-3">

                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white text-blue-600">

                                <i class="bi bi-info-circle text-xs"></i>

                            </span>


                            <p class="text-[10px] leading-5 text-slate-500 sm:text-[11px]">

                                Pengajuan pembatalan perlu ditinjau berdasarkan alasan client dan kondisi order. Setelah keputusan dibuat, status pengajuan tidak dapat diubah kembali.

                            </p>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>


</x-layouts.freelancer>