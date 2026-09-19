<x-layouts.client title="Ajukan Pembatalan">

    @php
        $requestStatus = $latestRequest?->status;

        $statusLabel = match ($requestStatus) {
            'pending_freelancer' => 'Menunggu tanggapan freelancer',
            'approved_by_freelancer' => 'Disetujui freelancer',
            'rejected_by_freelancer' => 'Ditolak freelancer',
            'mediation_pending' => 'Menunggu mediasi admin',
            'approved_by_admin' => 'Disetujui admin',
            'rejected_by_admin' => 'Ditolak admin',
            default => null,
        };
    @endphp

    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Back --}}
        <a
            href="{{ route('client.orders.show', $order) }}"
            class="inline-flex items-center gap-2 text-sm text-[#71837B] transition hover:text-[#0F6B3A]"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke order
        </a>

        {{-- Main Card --}}
        <div class="mt-6 overflow-hidden rounded-2xl border border-[#DDE9E2] bg-white shadow-sm">

            {{-- Header --}}
            <div class="border-b border-[#EDF2EF] px-6 py-6">

                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#1E9E5A]">
                    Pembatalan Order
                </p>

                <h1 class="mt-1 text-xl font-semibold text-[#123128]">
                    Ajukan pembatalan
                </h1>

                <p class="mt-2 text-sm leading-6 text-[#71837B]">
                    Order:
                    <span class="font-semibold text-[#123128]">
                        {{ $order->order_number }}
                    </span>
                </p>

            </div>

            {{-- Alerts --}}
            <div class="px-6">

                @if(session('success'))
                    <div class="mt-5 rounded-xl border border-[#CDE8D7] bg-[#EAF7EF] px-4 py-3 text-sm text-[#168A4D]">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-4">

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

            </div>

            {{-- =========================================================
                BELUM ADA PENGAJUAN
            ========================================================== --}}

            @if(!$latestRequest)

                <div class="px-6 py-6">

                    <div class="rounded-2xl border border-[#E7EEE9] bg-[#F8FCF9] p-5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">
                                <i class="bi bi-x-circle"></i>
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-[#123128]">
                                    Ajukan pembatalan pesanan
                                </p>

                                <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                    Pengajuan akan dikirim kepada freelancer terlebih dahulu untuk ditanggapi.
                                </p>
                            </div>

                        </div>

                    </div>

                    <form
                        action="{{ route('client.orders.cancellation.store', $order) }}"
                        method="POST"
                        class="mt-6"
                    >
                        @csrf

                        <label
                            for="reason"
                            class="mb-2 block text-sm font-semibold text-[#52675D]"
                        >
                            Alasan pembatalan
                        </label>

                        <textarea
                            id="reason"
                            name="reason"
                            rows="7"
                            minlength="10"
                            maxlength="2000"
                            required
                            class="block w-full resize-none rounded-xl border border-[#D8E5DD] bg-[#F8FCF9] px-4 py-3 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#A3B0AA] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                            placeholder="Jelaskan alasan pembatalan order..."
                        >{{ old('reason') }}</textarea>

                        <p class="mt-2 text-xs leading-5 text-[#899991]">
                            Minimal 10 karakter. Freelancer akan menerima pengajuan ini untuk ditanggapi.
                        </p>

                        <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                            <a
                                href="{{ route('client.orders.show', $order) }}"
                                class="inline-flex h-11 items-center justify-center rounded-xl border border-[#D8E5DD] bg-white px-5 text-sm font-semibold text-[#52675D] transition hover:bg-[#F7FAF8]"
                            >
                                Kembali
                            </a>

                            <button
                                type="submit"
                                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#1E9E5A] focus:outline-none focus:ring-2 focus:ring-[#BFE8CF] focus:ring-offset-2"
                            >
                                <i class="bi bi-send"></i>
                                Ajukan pembatalan
                            </button>

                        </div>

                    </form>

                </div>

            {{-- =========================================================
                MENUNGGU FREELANCER
            ========================================================== --}}

            @elseif($requestStatus === 'pending_freelancer')

                <div class="px-6 py-6">

                    <div class="rounded-2xl border border-[#E8DDC3] bg-[#FFF9EA] p-5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#B37A21] shadow-sm">
                                <i class="bi bi-hourglass-split"></i>
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-[#76520F]">
                                    Menunggu tanggapan freelancer
                                </p>

                                <p class="mt-1 text-xs leading-5 text-[#8C7144]">
                                    Pengajuan pembatalan sudah dikirim. Freelancer perlu meninjau dan memberikan keputusan terlebih dahulu.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="mt-5 rounded-xl bg-[#F8FCF9] p-4">

                        <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#899991]">
                            Alasan yang diajukan
                        </p>

                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#52675D]">
                            {{ $latestRequest->reason }}
                        </p>

                    </div>

                </div>

            {{-- =========================================================
                DITOLAK FREELANCER → MEDIASI
            ========================================================== --}}

            @elseif($requestStatus === 'rejected_by_freelancer')

                <div class="px-6 py-6">

                    <div class="rounded-2xl border border-red-100 bg-red-50 p-5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">
                                <i class="bi bi-x-circle"></i>
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-red-700">
                                    Pengajuan ditolak freelancer
                                </p>

                                <p class="mt-1 text-xs leading-5 text-red-600/80">
                                    Freelancer tidak menyetujui pembatalan. Kamu dapat membawa pengajuan ini ke Admin melalui mediasi.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="mt-5 space-y-4">

                        <div class="rounded-xl bg-[#F8FCF9] p-4">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#899991]">
                                Alasan pembatalan kamu
                            </p>

                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#52675D]">
                                {{ $latestRequest->reason }}
                            </p>

                        </div>

                        @if($latestRequest->freelancer_note)

                            <div class="rounded-xl border border-red-100 bg-red-50/60 p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-red-500">
                                    Tanggapan freelancer
                                </p>

                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-red-700">
                                    {{ $latestRequest->freelancer_note }}
                                </p>

                                @if($latestRequest->freelancer_reviewed_at)
                                    <p class="mt-2 text-[10px] text-red-500/80">
                                        Ditinjau {{ $latestRequest->freelancer_reviewed_at->format('d M Y, H:i') }}
                                    </p>
                                @endif

                            </div>

                        @endif

                    </div>

                    <form
                        action="{{ route('client.orders.cancellation.mediation', $order) }}"
                        method="POST"
                        class="mt-6"
                    >
                        @csrf

                        <label
                            for="mediation_reason"
                            class="mb-2 block text-sm font-semibold text-[#52675D]"
                        >
                            Alasan mengajukan mediasi
                        </label>

                        <textarea
                            id="mediation_reason"
                            name="mediation_reason"
                            rows="7"
                            minlength="10"
                            maxlength="2000"
                            required
                            class="block w-full resize-none rounded-xl border border-[#D8E5DD] bg-[#F8FCF9] px-4 py-3 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#A3B0AA] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                            placeholder="Jelaskan mengapa pembatalan ini perlu ditinjau oleh admin..."
                        >{{ old('mediation_reason') }}</textarea>

                        <p class="mt-2 text-xs leading-5 text-[#899991]">
                            Jelaskan alasan mediasi secara jelas agar admin dapat meninjau sengketa.
                        </p>

                        <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                            <a
                                href="{{ route('client.orders.show', $order) }}"
                                class="inline-flex h-11 items-center justify-center rounded-xl border border-[#D8E5DD] bg-white px-5 text-sm font-semibold text-[#52675D] transition hover:bg-[#F7FAF8]"
                            >
                                Kembali
                            </a>

                            <button
                                type="submit"
                                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                            >
                                <i class="bi bi-shield-check"></i>
                                Ajukan Mediasi ke Admin
                            </button>

                        </div>

                    </form>

                </div>

            {{-- =========================================================
                MENUNGGU ADMIN
            ========================================================== --}}

            @elseif($requestStatus === 'mediation_pending')

                <div class="px-6 py-6">

                    <div class="rounded-2xl border border-[#CFE0F1] bg-[#F3F8FC] p-5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#3C6F9F] shadow-sm">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-[#315D87]">
                                    Mediasi sedang ditinjau Admin
                                </p>

                                <p class="mt-1 text-xs leading-5 text-[#587593]">
                                    Pengajuan sudah diteruskan ke Admin. Tunggu sampai proses mediasi selesai.
                                </p>

                            </div>

                        </div>

                    </div>

                    @if($latestRequest->mediation_reason)

                        <div class="mt-5 rounded-xl bg-[#F8FCF9] p-4">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#899991]">
                                Alasan mediasi
                            </p>

                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#52675D]">
                                {{ $latestRequest->mediation_reason }}
                            </p>

                        </div>

                    @endif

                </div>

            {{-- =========================================================
                DISETUJUI / DITOLAK ADMIN
            ========================================================== --}}

            @elseif(in_array($requestStatus, [
                'approved_by_admin',
                'rejected_by_admin',
                'approved_by_freelancer',
            ], true))

                <div class="px-6 py-6">

                    @if($requestStatus === 'approved_by_freelancer')

                        <div class="rounded-2xl border border-[#CDE7D7] bg-[#EAF7EF] p-5">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#168A4D] shadow-sm">
                                    <i class="bi bi-check-circle"></i>
                                </div>

                                <div>

                                    <p class="text-sm font-semibold text-[#168A4D]">
                                        Pembatalan disetujui freelancer
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#587C68]">
                                        Order sudah dibatalkan setelah freelancer menyetujui pengajuan.
                                    </p>

                                </div>

                            </div>

                        </div>

                    @elseif($requestStatus === 'approved_by_admin')

                        <div class="rounded-2xl border border-[#CDE7D7] bg-[#EAF7EF] p-5">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#168A4D] shadow-sm">
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <div>

                                    <p class="text-sm font-semibold text-[#168A4D]">
                                        Mediasi disetujui Admin
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#587C68]">
                                        Admin menyetujui pembatalan melalui proses mediasi dan order telah dibatalkan.
                                    </p>

                                </div>

                            </div>

                        </div>

                    @else

                        <div class="rounded-2xl border border-red-100 bg-red-50 p-5">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">
                                    <i class="bi bi-shield-x"></i>
                                </div>

                                <div>

                                    <p class="text-sm font-semibold text-red-700">
                                        Mediasi ditolak Admin
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-red-600/80">
                                        Admin tidak menyetujui pembatalan. Order tetap berjalan.
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endif

                    <div class="mt-5 space-y-4">

                        <div class="rounded-xl bg-[#F8FCF9] p-4">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#899991]">
                                Alasan awal
                            </p>

                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#52675D]">
                                {{ $latestRequest->reason }}
                            </p>

                        </div>

                        @if($latestRequest->freelancer_note)

                            <div class="rounded-xl bg-[#F8FCF9] p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#899991]">
                                    Tanggapan freelancer
                                </p>

                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#52675D]">
                                    {{ $latestRequest->freelancer_note }}
                                </p>

                            </div>

                        @endif

                        @if($latestRequest->mediation_reason)

                            <div class="rounded-xl bg-[#F8FCF9] p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#899991]">
                                    Alasan mediasi
                                </p>

                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#52675D]">
                                    {{ $latestRequest->mediation_reason }}
                                </p>

                            </div>

                        @endif

                        @if($latestRequest->admin_note)

                            <div class="rounded-xl bg-[#F8FCF9] p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#899991]">
                                    Catatan admin
                                </p>

                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#52675D]">
                                    {{ $latestRequest->admin_note }}
                                </p>

                            </div>

                        @endif

                        @if($latestRequest->reviewed_at)

                            <p class="text-xs text-[#899991]">
                                Ditinjau {{ $latestRequest->reviewed_at->format('d M Y, H:i') }}
                            </p>

                        @endif

                    </div>

                </div>

            @endif

        </div>

    </div>

</x-layouts.client>