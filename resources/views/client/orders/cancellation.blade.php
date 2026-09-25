<x-layouts.marketplace title="Ajukan Pembatalan">

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

        $statusStyle = match ($requestStatus) {
            'approved_by_freelancer',
            'approved_by_admin' => [
                'dot' => 'bg-emerald-500',
                'icon' => 'bi-check-circle',
                'bg' => 'bg-emerald-50',
                'border' => 'border-emerald-200',
                'text' => 'text-emerald-700',
            ],

            'rejected_by_freelancer',
            'rejected_by_admin' => [
                'dot' => 'bg-red-500',
                'icon' => 'bi-x-circle',
                'bg' => 'bg-red-50',
                'border' => 'border-red-200',
                'text' => 'text-red-700',
            ],

            'mediation_pending' => [
                'dot' => 'bg-blue-500',
                'icon' => 'bi-shield-check',
                'bg' => 'bg-blue-50',
                'border' => 'border-blue-200',
                'text' => 'text-blue-700',
            ],

            'pending_freelancer' => [
                'dot' => 'bg-amber-500',
                'icon' => 'bi-hourglass-split',
                'bg' => 'bg-amber-50',
                'border' => 'border-amber-200',
                'text' => 'text-amber-700',
            ],

            default => [
                'dot' => 'bg-slate-400',
                'icon' => 'bi-circle',
                'bg' => 'bg-slate-50',
                'border' => 'border-slate-200',
                'text' => 'text-slate-600',
            ],
        };
    @endphp


    <div
        id="prokerjaa-cancellation-page"
        class="min-h-[calc(100dvh-var(--pk-header-height,76px))] bg-[#F5F8FC] px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10"
    >

        <div class="mx-auto w-full max-w-5xl">


            {{-- =========================================================
                 TOP NAV
            ========================================================== --}}
            <div class="flex items-center justify-between gap-3">

                <a
                    href="{{ route('client.orders.show', $order) }}"
                    class="group inline-flex items-center gap-2 text-sm font-semibold text-slate-600 transition hover:text-[#2563EB]"
                >
                    <span
                        class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm transition group-hover:border-blue-200 group-hover:bg-blue-50"
                    >
                        <i class="bi bi-arrow-left text-sm transition-transform group-hover:-translate-x-0.5"></i>
                    </span>

                    <span class="hidden sm:inline">
                        Kembali ke order
                    </span>

                    <span class="sm:hidden">
                        Kembali
                    </span>
                </a>

            </div>


            {{-- =========================================================
                 PAGE HEADER
            ========================================================== --}}
            <div class="mt-6">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                    <div class="min-w-0">

                        <div class="flex items-center gap-2.5">

                            <span
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]"
                            >
                                <i class="bi bi-arrow-counterclockwise text-lg"></i>
                            </span>

                            <span
                                class="text-[11px] font-bold uppercase tracking-[0.16em] text-[#2563EB]"
                            >
                                Pembatalan Order
                            </span>

                        </div>


                        <h1
                            class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl"
                        >
                            Ajukan pembatalan
                        </h1>


                        <p class="mt-2 text-sm leading-6 text-slate-500">

                            Kelola pengajuan pembatalan untuk order

                            <span class="font-bold text-slate-700">
                                {{ $order->order_number }}
                            </span>

                        </p>

                    </div>


                    {{-- Current status --}}
                    @if($statusLabel)

                        <div
                            class="inline-flex w-fit items-center gap-2 rounded-full border {{ $statusStyle['border'] }} {{ $statusStyle['bg'] }} px-3.5 py-2 text-xs font-bold {{ $statusStyle['text'] }}"
                        >

                            <span
                                class="h-2 w-2 shrink-0 rounded-full {{ $statusStyle['dot'] }}"
                            ></span>

                            {{ $statusLabel }}

                        </div>

                    @endif

                </div>

            </div>


            {{-- =========================================================
                 ALERTS
            ========================================================== --}}
            @if(session('success') || session('error') || $errors->any())

                <div class="mt-6 space-y-3">

                    {{-- Success --}}
                    @if(session('success'))

                        <div
                            class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm text-emerald-700"
                        >

                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm"
                            >
                                <i class="bi bi-check-circle"></i>
                            </span>

                            <div class="pt-1 leading-6">
                                {{ session('success') }}
                            </div>

                        </div>

                    @endif


                    {{-- Error --}}
                    @if(session('error'))

                        <div
                            class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700"
                        >

                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm"
                            >
                                <i class="bi bi-exclamation-circle"></i>
                            </span>

                            <div class="pt-1 leading-6">
                                {{ session('error') }}
                            </div>

                        </div>

                    @endif


                    {{-- Validation --}}
                    @if($errors->any())

                        <div
                            class="rounded-2xl border border-red-200 bg-red-50 px-4 py-4"
                        >

                            <div class="flex items-start gap-3">

                                <span
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm"
                                >
                                    <i class="bi bi-exclamation-triangle"></i>
                                </span>


                                <div class="min-w-0">

                                    <p class="text-sm font-bold text-red-700">
                                        Ada data yang perlu diperbaiki
                                    </p>

                                    <ul class="mt-2 space-y-1 text-xs leading-5 text-red-600">

                                        @foreach($errors->all() as $error)

                                            <li class="flex gap-2">
                                                <span>•</span>
                                                <span>{{ $error }}</span>
                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        </div>

                    @endif

                </div>

            @endif


            {{-- =========================================================
                 MAIN CARD
            ========================================================== --}}
            <div
                class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_15px_45px_rgba(15,23,42,.06)]"
            >


                {{-- =====================================================
                     ORDER INFO
                ====================================================== --}}
                <div
                    class="border-b border-slate-100 bg-gradient-to-r from-[#F8FBFF] to-white px-5 py-5 sm:px-7"
                >

                    <div class="flex items-center justify-between gap-4">

                        <div class="flex min-w-0 items-center gap-3">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]"
                            >
                                <i class="bi bi-receipt text-lg"></i>
                            </div>


                            <div class="min-w-0">

                                <p
                                    class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400"
                                >
                                    Order
                                </p>

                                <p
                                    class="mt-0.5 truncate text-sm font-bold text-slate-800"
                                >
                                    {{ $order->order_number }}
                                </p>

                            </div>

                        </div>


                        <span
                            class="hidden shrink-0 rounded-full bg-slate-100 px-3 py-1.5 text-[11px] font-semibold text-slate-500 sm:inline-flex"
                        >
                            Pengajuan pembatalan
                        </span>

                    </div>

                </div>


                {{-- =====================================================
                     BELUM ADA PENGAJUAN
                ====================================================== --}}
                @if(!$latestRequest)

                    <div class="p-5 sm:p-7 lg:p-8">

                        {{-- Intro --}}
                        <div
                            class="rounded-2xl border border-blue-100 bg-blue-50/60 p-5 sm:p-6"
                        >

                            <div class="flex items-start gap-4">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm"
                                >
                                    <i class="bi bi-x-circle text-lg"></i>
                                </div>


                                <div class="min-w-0">

                                    <h2 class="text-base font-bold text-slate-900">
                                        Ajukan pembatalan pesanan
                                    </h2>

                                    <p class="mt-1.5 text-sm leading-6 text-slate-500">
                                        Pengajuan akan dikirim kepada freelancer terlebih dahulu
                                        untuk ditinjau dan ditanggapi.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Form --}}
                        <form
                            action="{{ route('client.orders.cancellation.store', $order) }}"
                            method="POST"
                            class="mt-7"
                        >

                            @csrf

                            <div>

                                <label
                                    for="reason"
                                    class="mb-2.5 block text-sm font-bold text-slate-800"
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
                                    class="block w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#2563EB] focus:bg-white focus:ring-4 focus:ring-blue-100"
                                    placeholder="Jelaskan alasan pembatalan order..."
                                >{{ old('reason') }}</textarea>


                                <div class="mt-2 flex items-start justify-between gap-4">

                                    <p class="text-xs leading-5 text-slate-400">
                                        Minimal 10 karakter. Freelancer akan menerima
                                        pengajuan ini untuk ditanggapi.
                                    </p>

                                    <span
                                        class="hidden shrink-0 text-[11px] font-medium text-slate-400 sm:block"
                                    >
                                        Maks. 2000 karakter
                                    </span>

                                </div>

                            </div>


                            {{-- Actions --}}
                            <div
                                class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"
                            >

                                <a
                                    href="{{ route('client.orders.show', $order) }}"
                                    class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-bold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50"
                                >
                                    Kembali
                                </a>


                                <button
                                    type="submit"
                                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-sm font-bold text-white shadow-[0_6px_18px_rgba(37,99,235,.20)] transition hover:-translate-y-0.5 hover:bg-[#1D4ED8] focus:outline-none focus:ring-4 focus:ring-blue-100 active:translate-y-0"
                                >
                                    <i class="bi bi-send"></i>
                                    Ajukan pembatalan
                                </button>

                            </div>

                        </form>

                    </div>


                {{-- =====================================================
                     MENUNGGU FREELANCER
                ====================================================== --}}
                @elseif($requestStatus === 'pending_freelancer')

                    <div class="p-5 sm:p-7 lg:p-8">

                        <div
                            class="rounded-2xl border border-amber-200 bg-amber-50 p-5 sm:p-6"
                        >

                            <div class="flex items-start gap-4">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm"
                                >
                                    <i class="bi bi-hourglass-split text-lg"></i>
                                </div>


                                <div class="min-w-0">

                                    <p class="text-base font-bold text-amber-800">
                                        Menunggu tanggapan freelancer
                                    </p>

                                    <p class="mt-1.5 text-sm leading-6 text-amber-700/80">
                                        Pengajuan pembatalan sudah dikirim.
                                        Freelancer perlu meninjau dan memberikan
                                        keputusan terlebih dahulu.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Reason --}}
                        <div
                            class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-5"
                        >

                            <p
                                class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400"
                            >
                                Alasan yang diajukan
                            </p>

                            <p
                                class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600"
                            >
                                {{ $latestRequest->reason }}
                            </p>

                        </div>

                    </div>


                {{-- =====================================================
                     DITOLAK FREELANCER
                ====================================================== --}}
                @elseif($requestStatus === 'rejected_by_freelancer')

                    <div class="p-5 sm:p-7 lg:p-8">

                        <div
                            class="rounded-2xl border border-red-200 bg-red-50 p-5 sm:p-6"
                        >

                            <div class="flex items-start gap-4">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm"
                                >
                                    <i class="bi bi-x-circle text-lg"></i>
                                </div>


                                <div class="min-w-0">

                                    <p class="text-base font-bold text-red-700">
                                        Pengajuan ditolak freelancer
                                    </p>

                                    <p class="mt-1.5 text-sm leading-6 text-red-600/80">
                                        Freelancer tidak menyetujui pembatalan.
                                        Kamu dapat membawa pengajuan ini ke Admin
                                        melalui proses mediasi.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="mt-5 space-y-4">

                            {{-- Initial reason --}}
                            <div
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-5"
                            >

                                <p
                                    class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400"
                                >
                                    Alasan pembatalan kamu
                                </p>

                                <p
                                    class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600"
                                >
                                    {{ $latestRequest->reason }}
                                </p>

                            </div>


                            {{-- Freelancer response --}}
                            @if($latestRequest->freelancer_note)

                                <div
                                    class="rounded-2xl border border-red-100 bg-red-50/60 p-5"
                                >

                                    <p
                                        class="text-[10px] font-bold uppercase tracking-[0.15em] text-red-500"
                                    >
                                        Tanggapan freelancer
                                    </p>

                                    <p
                                        class="mt-2 whitespace-pre-line text-sm leading-6 text-red-700"
                                    >
                                        {{ $latestRequest->freelancer_note }}
                                    </p>

                                    @if($latestRequest->freelancer_reviewed_at)

                                        <p class="mt-3 text-[10px] text-red-500/80">
                                            Ditinjau
                                            {{ $latestRequest->freelancer_reviewed_at->format('d M Y, H:i') }}
                                        </p>

                                    @endif

                                </div>

                            @endif

                        </div>


                        {{-- Mediation --}}
                        <form
                            action="{{ route('client.orders.cancellation.mediation', $order) }}"
                            method="POST"
                            class="mt-7"
                        >

                            @csrf

                            <label
                                for="mediation_reason"
                                class="mb-2.5 block text-sm font-bold text-slate-800"
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
                                class="block w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#2563EB] focus:bg-white focus:ring-4 focus:ring-blue-100"
                                placeholder="Jelaskan mengapa pembatalan ini perlu ditinjau oleh admin..."
                            >{{ old('mediation_reason') }}</textarea>


                            <p class="mt-2 text-xs leading-5 text-slate-400">
                                Jelaskan alasan mediasi secara jelas agar admin
                                dapat meninjau sengketa.
                            </p>


                            <div
                                class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"
                            >

                                <a
                                    href="{{ route('client.orders.show', $order) }}"
                                    class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-bold text-slate-600 transition hover:bg-slate-50"
                                >
                                    Kembali
                                </a>


                                <button
                                    type="submit"
                                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-sm font-bold text-white shadow-[0_6px_18px_rgba(37,99,235,.20)] transition hover:-translate-y-0.5 hover:bg-[#1D4ED8]"
                                >
                                    <i class="bi bi-shield-check"></i>
                                    Ajukan Mediasi ke Admin
                                </button>

                            </div>

                        </form>

                    </div>


                {{-- =====================================================
                     MENUNGGU ADMIN
                ====================================================== --}}
                @elseif($requestStatus === 'mediation_pending')

                    <div class="p-5 sm:p-7 lg:p-8">

                        <div
                            class="rounded-2xl border border-blue-200 bg-blue-50 p-5 sm:p-6"
                        >

                            <div class="flex items-start gap-4">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm"
                                >
                                    <i class="bi bi-shield-check text-lg"></i>
                                </div>


                                <div class="min-w-0">

                                    <p class="text-base font-bold text-blue-800">
                                        Mediasi sedang ditinjau Admin
                                    </p>

                                    <p class="mt-1.5 text-sm leading-6 text-blue-700/80">
                                        Pengajuan sudah diteruskan ke Admin.
                                        Tunggu sampai proses mediasi selesai.
                                    </p>

                                </div>

                            </div>

                        </div>


                        @if($latestRequest->mediation_reason)

                            <div
                                class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-5"
                            >

                                <p
                                    class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400"
                                >
                                    Alasan mediasi
                                </p>

                                <p
                                    class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600"
                                >
                                    {{ $latestRequest->mediation_reason }}
                                </p>

                            </div>

                        @endif

                    </div>


                {{-- =====================================================
                     FINAL STATUS
                ====================================================== --}}
                @elseif(in_array($requestStatus, [
                    'approved_by_admin',
                    'rejected_by_admin',
                    'approved_by_freelancer',
                ], true))

                    <div class="p-5 sm:p-7 lg:p-8">


                        {{-- Approved freelancer --}}
                        @if($requestStatus === 'approved_by_freelancer')

                            <div
                                class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 sm:p-6"
                            >

                                <div class="flex items-start gap-4">

                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm"
                                    >
                                        <i class="bi bi-check-circle text-lg"></i>
                                    </div>


                                    <div class="min-w-0">

                                        <p class="text-base font-bold text-emerald-700">
                                            Pembatalan disetujui freelancer
                                        </p>

                                        <p class="mt-1.5 text-sm leading-6 text-emerald-700/75">
                                            Order sudah dibatalkan setelah freelancer
                                            menyetujui pengajuan.
                                        </p>

                                    </div>

                                </div>

                            </div>


                        {{-- Approved admin --}}
                        @elseif($requestStatus === 'approved_by_admin')

                            <div
                                class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 sm:p-6"
                            >

                                <div class="flex items-start gap-4">

                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm"
                                    >
                                        <i class="bi bi-shield-check text-lg"></i>
                                    </div>


                                    <div class="min-w-0">

                                        <p class="text-base font-bold text-emerald-700">
                                            Mediasi disetujui Admin
                                        </p>

                                        <p class="mt-1.5 text-sm leading-6 text-emerald-700/75">
                                            Admin menyetujui pembatalan melalui
                                            proses mediasi dan order telah dibatalkan.
                                        </p>

                                    </div>

                                </div>

                            </div>


                        {{-- Rejected admin --}}
                        @else

                            <div
                                class="rounded-2xl border border-red-200 bg-red-50 p-5 sm:p-6"
                            >

                                <div class="flex items-start gap-4">

                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm"
                                    >
                                        <i class="bi bi-shield-x text-lg"></i>
                                    </div>


                                    <div class="min-w-0">

                                        <p class="text-base font-bold text-red-700">
                                            Mediasi ditolak Admin
                                        </p>

                                        <p class="mt-1.5 text-sm leading-6 text-red-600/80">
                                            Admin tidak menyetujui pembatalan.
                                            Order tetap berjalan.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endif


                        {{-- =================================================
                             REQUEST DETAILS
                        ================================================== --}}
                        <div class="mt-6 space-y-4">


                            {{-- Initial reason --}}
                            <div
                                class="rounded-2xl border border-slate-200 bg-slate-50 p-5"
                            >

                                <p
                                    class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400"
                                >
                                    Alasan awal
                                </p>

                                <p
                                    class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600"
                                >
                                    {{ $latestRequest->reason }}
                                </p>

                            </div>


                            {{-- Freelancer note --}}
                            @if($latestRequest->freelancer_note)

                                <div
                                    class="rounded-2xl border border-slate-200 bg-slate-50 p-5"
                                >

                                    <p
                                        class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400"
                                    >
                                        Tanggapan freelancer
                                    </p>

                                    <p
                                        class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600"
                                    >
                                        {{ $latestRequest->freelancer_note }}
                                    </p>

                                </div>

                            @endif


                            {{-- Mediation --}}
                            @if($latestRequest->mediation_reason)

                                <div
                                    class="rounded-2xl border border-slate-200 bg-slate-50 p-5"
                                >

                                    <p
                                        class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400"
                                    >
                                        Alasan mediasi
                                    </p>

                                    <p
                                        class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600"
                                    >
                                        {{ $latestRequest->mediation_reason }}
                                    </p>

                                </div>

                            @endif


                            {{-- Admin --}}
                            @if($latestRequest->admin_note)

                                <div
                                    class="rounded-2xl border border-blue-100 bg-blue-50/60 p-5"
                                >

                                    <p
                                        class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#2563EB]"
                                    >
                                        Catatan admin
                                    </p>

                                    <p
                                        class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700"
                                    >
                                        {{ $latestRequest->admin_note }}
                                    </p>

                                </div>

                            @endif


                            {{-- Reviewed --}}
                            @if($latestRequest->reviewed_at)

                                <div
                                    class="flex items-center gap-2 px-1 text-xs text-slate-400"
                                >
                                    <i class="bi bi-clock"></i>

                                    <span>
                                        Ditinjau
                                        {{ $latestRequest->reviewed_at->format('d M Y, H:i') }}
                                    </span>
                                </div>

                            @endif

                        </div>

                    </div>

                @endif

            </div>


            {{-- =========================================================
                 FOOT NOTE
            ========================================================== --}}
            <div class="mt-5 px-2 text-center">

                <p class="text-[11px] leading-5 text-slate-400">
                    ProKerjaa menyimpan riwayat proses pembatalan
                    pada order ini.
                </p>

            </div>

        </div>

    </div>


    {{-- =============================================================
         PAGE-SCOPED POLISH
    ============================================================= --}}
    <style>
        #prokerjaa-cancellation-page textarea {
            scrollbar-width: thin;
        }

        #prokerjaa-cancellation-page button,
        #prokerjaa-cancellation-page a {
            -webkit-tap-highlight-color: transparent;
        }

        @media (max-width: 640px) {
            #prokerjaa-cancellation-page {
                padding-top: 1rem;
                padding-bottom: 1.25rem;
            }

            #prokerjaa-cancellation-page h1 {
                line-height: 1.2;
            }
        }
    </style>

</x-layouts.marketplace>