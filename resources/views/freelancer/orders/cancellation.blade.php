<x-layouts.freelancer title="Pembatalan Order">

    @php
        $requestStatus = $cancellationRequest->status;

        $statusLabel = match ($requestStatus) {
            'pending_freelancer' => 'Menunggu tanggapan freelancer',
            'rejected_by_freelancer' => 'Ditolak freelancer',
            'mediation_pending' => 'Menunggu mediasi admin',
            'approved_by_freelancer' => 'Disetujui freelancer',
            'approved_by_admin' => 'Disetujui admin',
            'rejected_by_admin' => 'Ditolak admin',
            default => ucfirst(str_replace('_', ' ', $requestStatus)),
        };
    @endphp

    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">

        <a
            href="{{ route('freelancer.orders.show', $order) }}"
            class="inline-flex items-center gap-2 text-sm text-[#71837B] transition hover:text-[#0F6B3A]"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke order
        </a>

        <div class="mt-6 overflow-hidden rounded-2xl border border-[#DDE9E2] bg-white shadow-sm">

            {{-- Header --}}
            <div class="border-b border-[#EDF2EF] px-6 py-6">

                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#1E9E5A]">
                    Pembatalan Order
                </p>

                <div class="mt-2 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h1 class="text-xl font-semibold text-[#123128]">
                            {{ $order->order_number }}
                        </h1>

                        <p class="mt-1 text-sm text-[#71837B]">
                            Client mengajukan pembatalan pesanan.
                        </p>

                    </div>

                    <span class="inline-flex w-fit rounded-full bg-[#FFF9EA] px-3 py-1.5 text-xs font-semibold text-[#815A08]">
                        {{ $statusLabel }}
                    </span>

                </div>

            </div>

            @if(session('success'))
                <div class="mx-6 mt-5 rounded-xl border border-[#CDE8D7] bg-[#EAF7EF] px-4 py-3 text-sm text-[#168A4D]">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mx-6 mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-4">

                    <p class="mb-2 text-sm font-semibold text-red-700">
                        Ada data yang perlu diperbaiki:
                    </p>

                    <ul class="space-y-1 text-xs text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            {{-- Request Detail --}}
            <div class="space-y-5 px-6 py-6">

                {{-- Client --}}
                <div class="rounded-xl bg-[#F8FCF9] p-4">

                    <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#899991]">
                        Pemohon
                    </p>

                    <div class="mt-3 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A]">
                            {{ strtoupper(substr($cancellationRequest->requester?->name ?? 'C', 0, 1)) }}
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#123128]">
                                {{ $cancellationRequest->requester?->name ?? 'Client' }}
                            </p>

                            <p class="mt-0.5 text-xs text-[#899991]">
                                {{ $cancellationRequest->requester?->email ?? '-' }}
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Reason --}}
                <div>

                    <p class="text-xs font-semibold text-[#52675D]">
                        Alasan pembatalan
                    </p>

                    <div class="mt-2 rounded-xl bg-[#F8FCF9] p-5">

                        <p class="whitespace-pre-line text-sm leading-7 text-[#62766D]">
                            {{ $cancellationRequest->reason }}
                        </p>

                    </div>

                </div>

                {{-- Freelancer already rejected --}}
                @if($requestStatus === 'rejected_by_freelancer')

                    <div class="rounded-xl border border-red-100 bg-red-50 p-4">

                        <p class="text-sm font-semibold text-red-700">
                            Kamu sudah menolak pembatalan ini.
                        </p>

                        @if($cancellationRequest->freelancer_note)

                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-red-700">
                                {{ $cancellationRequest->freelancer_note }}
                            </p>

                        @endif

                        @if($cancellationRequest->freelancer_reviewed_at)

                            <p class="mt-2 text-xs text-red-500">
                                Ditinjau {{ $cancellationRequest->freelancer_reviewed_at->format('d M Y, H:i') }}
                            </p>

                        @endif

                        <p class="mt-3 text-xs leading-5 text-red-600/80">
                            Client dapat meneruskan permintaan ini ke Admin melalui mediasi.
                        </p>

                    </div>

                {{-- Mediation pending --}}
                @elseif($requestStatus === 'mediation_pending')

                    <div class="rounded-xl border border-[#CFE0F1] bg-[#F3F8FC] p-4">

                        <p class="text-sm font-semibold text-[#315D87]">
                            Pengajuan sedang dimediasi Admin
                        </p>

                        <p class="mt-1 text-xs leading-5 text-[#587593]">
                            Client telah meneruskan pengajuan ini kepada Admin. Tunggu keputusan mediasi.
                        </p>

                        @if($cancellationRequest->mediation_reason)

                            <div class="mt-4 rounded-xl bg-white/80 p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#6D8498]">
                                    Alasan mediasi
                                </p>

                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#4F6678]">
                                    {{ $cancellationRequest->mediation_reason }}
                                </p>

                            </div>

                        @endif

                    </div>

                {{-- Approved --}}
                @elseif(in_array($requestStatus, [
                    'approved_by_freelancer',
                    'approved_by_admin',
                ], true))

                    <div class="rounded-xl border border-[#CDE7D7] bg-[#EAF7EF] p-4">

                        <p class="text-sm font-semibold text-[#168A4D]">
                            Pembatalan telah disetujui
                        </p>

                        <p class="mt-1 text-xs leading-5 text-[#587C68]">
                            Order ini telah dibatalkan sesuai keputusan pembatalan.
                        </p>

                        @if($cancellationRequest->freelancer_note)

                            <p class="mt-3 whitespace-pre-line text-xs leading-5 text-[#587C68]">
                                {{ $cancellationRequest->freelancer_note }}
                            </p>

                        @endif

                        @if($cancellationRequest->admin_note)

                            <div class="mt-4 rounded-xl bg-white/80 p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#587C68]">
                                    Catatan admin
                                </p>

                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#52675D]">
                                    {{ $cancellationRequest->admin_note }}
                                </p>

                            </div>

                        @endif

                    </div>

                {{-- Admin rejected --}}
                @elseif($requestStatus === 'rejected_by_admin')

                    <div class="rounded-xl border border-red-100 bg-red-50 p-4">

                        <p class="text-sm font-semibold text-red-700">
                            Mediasi ditolak Admin
                        </p>

                        <p class="mt-1 text-xs leading-5 text-red-600/80">
                            Pembatalan tidak disetujui melalui mediasi dan order tetap berjalan.
                        </p>

                        @if($cancellationRequest->admin_note)

                            <div class="mt-4 rounded-xl bg-white/80 p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-red-500">
                                    Catatan admin
                                </p>

                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#7A5A5A]">
                                    {{ $cancellationRequest->admin_note }}
                                </p>

                            </div>

                        @endif

                    </div>

                {{-- Pending --}}
                @else

                    <div class="rounded-xl border border-[#E8DDC3] bg-[#FFF9EA] p-4">

                        <p class="text-sm font-semibold text-[#76520F]">
                            Client meminta pembatalan
                        </p>

                        <p class="mt-1 text-xs leading-5 text-[#8C7144]">
                            Tinjau alasan pembatalan sebelum menentukan apakah kamu menyetujuinya.
                        </p>

                    </div>

                    {{-- Actions --}}
                    <div class="grid gap-5 lg:grid-cols-2">

                        {{-- Approve --}}
                        <form
                            action="{{ route('freelancer.orders.cancellation.approve', $order) }}"
                            method="POST"
                            class="rounded-2xl border border-[#CDE7D7] bg-[#F7FBF8] p-5"
                        >
                            @csrf

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-[#168A4D]">
                                    <i class="bi bi-check-lg"></i>
                                </div>

                                <div>

                                    <p class="text-sm font-semibold text-[#168A4D]">
                                        Setujui pembatalan
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                        Order akan dibatalkan dan proses pembayaran akan menyesuaikan status transaksi.
                                    </p>

                                </div>

                            </div>

                            <textarea
                                name="freelancer_note"
                                rows="4"
                                maxlength="2000"
                                class="mt-4 block w-full resize-none rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm leading-6 text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                                placeholder="Catatan freelancer (opsional)..."
                            >{{ old('freelancer_note') }}</textarea>

                            <button
                                type="submit"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                            >
                                <i class="bi bi-check-lg"></i>
                                Setujui pembatalan
                            </button>

                        </form>

                        {{-- Reject --}}
                        <form
                            action="{{ route('freelancer.orders.cancellation.reject', $order) }}"
                            method="POST"
                            class="rounded-2xl border border-red-100 bg-red-50 p-5"
                        >
                            @csrf

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white text-red-600 shadow-sm">
                                    <i class="bi bi-x-lg"></i>
                                </div>

                                <div>

                                    <p class="text-sm font-semibold text-red-700">
                                        Tolak pembatalan
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-red-600/80">
                                        Berikan alasan agar client memahami keputusanmu.
                                    </p>

                                </div>

                            </div>

                            <textarea
                                name="freelancer_note"
                                rows="4"
                                minlength="5"
                                maxlength="2000"
                                required
                                class="mt-4 block w-full resize-none rounded-xl border border-red-100 bg-white px-4 py-3 text-sm leading-6 text-[#123128] outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                placeholder="Alasan penolakan..."
                            >{{ old('freelancer_note') }}</textarea>

                            <button
                                type="submit"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-red-600 text-sm font-semibold text-white transition hover:bg-red-700"
                            >
                                <i class="bi bi-x-lg"></i>
                                Tolak pembatalan
                            </button>

                        </form>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-layouts.freelancer>