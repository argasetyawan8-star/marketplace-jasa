<x-layouts.marketplace>

    @php
        $freelancer = $order->freelancerProfile;
        $freelancerUser = $freelancer?->user;

        $freelancerName = $freelancerUser?->name ?? 'Freelancer';

        $freelancerAvatar = $freelancer?->avatar
            ? asset('storage/' . $freelancer->avatar)
            : null;

        $freelancerInitial = strtoupper(
            substr($freelancerName, 0, 1)
        );

        /*
        |--------------------------------------------------------------------------
        | ORDER STATUS
        |--------------------------------------------------------------------------
        */
        $statusMap = [
            'pending_payment' => [
                'label' => 'Menunggu pembayaran',
                'class' => 'bg-amber-50 text-amber-700 border-amber-200',
            ],
            'paid' => [
                'label' => 'Sudah dibayar',
                'class' => 'bg-blue-50 text-blue-700 border-blue-200',
            ],
            'in_progress' => [
                'label' => 'Sedang dikerjakan',
                'class' => 'bg-blue-50 text-blue-700 border-blue-200',
            ],
            'delivered' => [
                'label' => 'Menunggu pemeriksaan',
                'class' => 'bg-orange-50 text-orange-700 border-orange-200',
            ],
            'revision' => [
                'label' => 'Menunggu hasil revisi',
                'class' => 'bg-violet-50 text-violet-700 border-violet-200',
            ],
            'completed' => [
                'label' => 'Selesai',
                'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            ],
            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-red-50 text-red-700 border-red-200',
            ],
        ];

        $currentStatus = $statusMap[$order->status] ?? [
            'label' => ucfirst(str_replace('_', ' ', $order->status)),
            'class' => 'bg-slate-100 text-slate-600 border-slate-200',
        ];

        /*
        |--------------------------------------------------------------------------
        | DELIVERY STATUS
        |--------------------------------------------------------------------------
        */
        $deliveryStatusMap = [
            'submitted' => [
                'label' => 'Menunggu persetujuan',
                'class' => 'bg-amber-50 text-amber-700 border-amber-200',
                'icon' => 'bi-hourglass-split',
            ],
            'approved' => [
                'label' => 'Disetujui',
                'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'icon' => 'bi-check-circle-fill',
            ],
            'revision' => [
                'label' => 'Memerlukan revisi',
                'class' => 'bg-violet-50 text-violet-700 border-violet-200',
                'icon' => 'bi-arrow-repeat',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'class' => 'bg-red-50 text-red-700 border-red-200',
                'icon' => 'bi-x-circle-fill',
            ],
        ];

        $deliveryStatus = $delivery
            ? ($deliveryStatusMap[$delivery->status] ?? [
                'label' => ucfirst(str_replace('_', ' ', $delivery->status)),
                'class' => 'bg-slate-100 text-slate-600 border-slate-200',
                'icon' => 'bi-circle',
            ])
            : null;

        /*
        |--------------------------------------------------------------------------
        | CLIENT CAN PROCESS DELIVERY
        |--------------------------------------------------------------------------
        */
        $canProcessDelivery =
            $delivery &&
            $delivery->status === 'submitted' &&
            $order->status === 'delivered';
    @endphp


    <div
        id="prokerjaa-delivery-page"
        class="min-h-[calc(100vh-72px)] bg-[#F5F8FC]"
    >

        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8 lg:py-7">


            {{-- =========================================================
                BACK
            ========================================================== --}}
            <div class="mb-5">

                <a
                    href="{{ route('client.orders.show', $order) }}"
                    class="group inline-flex items-center gap-2 text-xs font-semibold text-slate-500 transition hover:text-[#2563EB]"
                >

                    <span
                        class="flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 shadow-sm transition group-hover:border-blue-200 group-hover:bg-blue-50 group-hover:text-[#2563EB]"
                    >
                        <i class="bi bi-arrow-left"></i>
                    </span>

                    <span>Kembali ke detail order</span>

                </a>

            </div>


            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}
            <div
                class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_8px_30px_rgba(15,23,42,0.04)] sm:p-6"
            >

                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                    <div class="flex min-w-0 items-start gap-4">

                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB]"
                        >
                            <i class="bi bi-box-seam text-xl"></i>
                        </div>

                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <span
                                    class="text-[10px] font-bold uppercase tracking-[0.16em] text-[#2563EB]"
                                >
                                    Delivery
                                </span>

                                <span class="h-1 w-1 rounded-full bg-slate-300"></span>

                                <span class="text-[10px] font-medium text-slate-400">
                                    {{ $order->order_number }}
                                </span>

                            </div>

                            <h1
                                class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl"
                            >
                                Hasil pekerjaan
                            </h1>

                            <p
                                class="mt-1 max-w-2xl text-xs leading-5 text-slate-500"
                            >
                                Periksa hasil pekerjaan dari freelancer sebelum
                                menyetujui dan menyelesaikan order.
                            </p>

                        </div>

                    </div>


                    <div class="flex flex-wrap items-center gap-2 lg:justify-end">

                        <span
                            class="inline-flex items-center rounded-full border px-3 py-1.5 text-[10px] font-semibold {{ $currentStatus['class'] }}"
                        >
                            {{ $currentStatus['label'] }}
                        </span>

                        <span
                            class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-[10px] font-medium text-slate-500"
                        >
                            <i class="bi bi-hash text-[9px]"></i>
                            {{ $order->order_number }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                MAIN GRID
            ========================================================== --}}
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_310px]">


                {{-- =====================================================
                    MAIN CONTENT
                ====================================================== --}}
                <main class="min-w-0 space-y-5">


                    {{-- =================================================
                        DELIVERY CARD
                    ================================================== --}}
                    <section
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_8px_30px_rgba(15,23,42,0.05)]"
                    >

                        {{-- HEADER --}}
                        <div class="border-b border-slate-100 px-5 py-5 sm:px-6">

                            <div class="flex items-center justify-between gap-4">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]"
                                    >
                                        <i class="bi bi-file-earmark-check text-lg"></i>
                                    </div>

                                    <div class="min-w-0">

                                        <h2 class="text-sm font-bold text-slate-900">
                                            Delivery freelancer
                                        </h2>

                                        @if ($delivery?->created_at)

                                            <p class="mt-0.5 text-[10px] text-slate-400">
                                                Dikirim
                                                {{ $delivery->created_at->format('d M Y, H:i') }}
                                            </p>

                                        @else

                                            <p class="mt-0.5 text-[10px] text-slate-400">
                                                Belum ada hasil yang dikirim
                                            </p>

                                        @endif

                                    </div>

                                </div>


                                @if ($deliveryStatus)

                                    <span
                                        class="inline-flex shrink-0 items-center gap-1.5 rounded-full border px-2.5 py-1.5 text-[9px] font-semibold {{ $deliveryStatus['class'] }}"
                                    >

                                        <i class="bi {{ $deliveryStatus['icon'] }}"></i>

                                        <span class="hidden sm:inline">
                                            {{ $deliveryStatus['label'] }}
                                        </span>

                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- DELIVERY CONTENT --}}
                        @if ($delivery)

                            <div class="px-5 py-5 sm:px-6">


                                {{-- STATUS --}}
                                <div
                                    class="mb-6 flex items-center gap-3 rounded-xl border border-blue-100 bg-blue-50/50 px-4 py-3"
                                >

                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#2563EB] shadow-sm"
                                    >
                                        <i class="bi {{ $deliveryStatus['icon'] }}"></i>
                                    </div>

                                    <div class="min-w-0 flex-1">

                                        <p
                                            class="text-[10px] font-semibold uppercase tracking-[0.1em] text-slate-400"
                                        >
                                            Status delivery
                                        </p>

                                        <p class="mt-0.5 text-xs font-semibold text-slate-700">
                                            {{ $deliveryStatus['label'] }}
                                        </p>

                                    </div>

                                </div>


                                {{-- =================================================
                                    DELIVERY NOTE
                                ================================================== --}}
                                @if (!empty($delivery->message ?? null))

                                    <div>

                                        <div class="mb-2 flex items-center gap-2">

                                            <i class="bi bi-chat-left-text text-xs text-[#2563EB]"></i>

                                            <p
                                                class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-500"
                                            >
                                                Catatan dari freelancer
                                            </p>

                                        </div>

                                        <div
                                            class="rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-4"
                                        >
                                            <p
                                                class="whitespace-pre-line text-sm leading-6 text-slate-600"
                                            >
                                                {{ $delivery->message }}
                                            </p>
                                        </div>

                                    </div>

                                @elseif (!empty($delivery->notes ?? null))

                                    <div>

                                        <div class="mb-2 flex items-center gap-2">

                                            <i class="bi bi-chat-left-text text-xs text-[#2563EB]"></i>

                                            <p
                                                class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-500"
                                            >
                                                Catatan dari freelancer
                                            </p>

                                        </div>

                                        <div
                                            class="rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-4"
                                        >
                                            <p
                                                class="whitespace-pre-line text-sm leading-6 text-slate-600"
                                            >
                                                {{ $delivery->notes }}
                                            </p>
                                        </div>

                                    </div>

                                @endif


                                {{-- =================================================
                                    FILE
                                ================================================== --}}
                                @if (!empty($delivery->file_path ?? null))

                                    <div class="mt-6">

                                        <div class="mb-2 flex items-center gap-2">

                                            <i class="bi bi-paperclip text-xs text-[#2563EB]"></i>

                                            <p
                                                class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-500"
                                            >
                                                File hasil pekerjaan
                                            </p>

                                        </div>


                                        <div
                                            class="group flex flex-col gap-3 rounded-xl border border-blue-100 bg-blue-50/40 p-3.5 transition hover:border-blue-200 hover:bg-blue-50 sm:flex-row sm:items-center sm:justify-between"
                                        >

                                            <div class="flex min-w-0 items-center gap-3">

                                                <div
                                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm"
                                                >
                                                    <i class="bi bi-file-earmark-arrow-down text-lg"></i>
                                                </div>

                                                <div class="min-w-0">

                                                    <p
                                                        class="truncate text-xs font-bold text-slate-700"
                                                    >
                                                        {{ $delivery->file_name ?? 'File hasil pekerjaan' }}
                                                    </p>

                                                    <p class="mt-1 text-[10px] text-slate-400">
                                                        File delivery
                                                    </p>

                                                </div>

                                            </div>


                                            <a
                                                href="{{ asset('storage/' . $delivery->file_path) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-lg bg-[#2563EB] px-3.5 text-[10px] font-bold text-white transition hover:bg-[#1D4ED8]"
                                            >
                                                <i class="bi bi-eye"></i>
                                                Lihat file
                                            </a>

                                        </div>

                                    </div>

                                @endif


                                {{-- =================================================
                                    EXTERNAL LINK
                                ================================================== --}}
                                @if (!empty($delivery->external_link ?? null))

                                    <div class="mt-6">

                                        <div class="mb-2 flex items-center gap-2">

                                            <i class="bi bi-link-45deg text-xs text-[#2563EB]"></i>

                                            <p
                                                class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-500"
                                            >
                                                Link hasil pekerjaan
                                            </p>

                                        </div>


                                        <a
                                            href="{{ $delivery->external_link }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="group flex items-center justify-between gap-3 rounded-xl border border-blue-100 bg-blue-50/40 px-4 py-3.5 transition hover:border-blue-200 hover:bg-blue-50"
                                        >

                                            <div class="flex min-w-0 items-center gap-3">

                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm"
                                                >
                                                    <i class="bi bi-globe2"></i>
                                                </div>

                                                <div class="min-w-0">

                                                    <p class="text-xs font-bold text-slate-700">
                                                        Buka hasil pekerjaan
                                                    </p>

                                                    <p
                                                        class="mt-0.5 truncate text-[10px] text-slate-400"
                                                    >
                                                        {{ $delivery->external_link }}
                                                    </p>

                                                </div>

                                            </div>

                                            <i
                                                class="bi bi-arrow-up-right shrink-0 text-sm text-[#2563EB] transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                                            ></i>

                                        </a>

                                    </div>

                                @endif


                                {{-- =================================================
                                    ACTION AREA
                                ================================================== --}}
                                @if ($canProcessDelivery)

                                    <div class="mt-7 border-t border-slate-100 pt-6">

                                        <div class="mb-4">

                                            <div class="flex items-center gap-2">

                                                <div
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]"
                                                >
                                                    <i class="bi bi-shield-check text-sm"></i>
                                                </div>

                                                <h3 class="text-sm font-bold text-slate-900">
                                                    Periksa hasil pekerjaan
                                                </h3>

                                            </div>

                                            <p class="mt-2 text-xs leading-5 text-slate-500">
                                                Pastikan hasil sudah sesuai dengan brief dan
                                                kebutuhanmu sebelum order diselesaikan.
                                            </p>

                                        </div>


                                        <div class="grid gap-3 sm:grid-cols-2">


                                            {{-- APPROVE --}}
                                            <form
                                                action="{{ route('client.delivery.approve', $order) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    onclick="return confirm('Apakah kamu yakin hasil pekerjaan ini sudah sesuai dan order dapat diselesaikan?')"
                                                    class="flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-xs font-bold text-white shadow-[0_5px_15px_rgba(37,99,235,0.18)] transition hover:bg-[#1D4ED8] hover:shadow-[0_7px_18px_rgba(37,99,235,0.24)]"
                                                >
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Setujui & Selesaikan
                                                </button>

                                            </form>


                                            {{-- REVISION --}}
                                            <button
                                                type="button"
                                                onclick="toggleRevisionForm()"
                                                class="flex h-12 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                                            >
                                                <i class="bi bi-arrow-repeat"></i>
                                                Minta Revisi
                                            </button>

                                        </div>


                                        {{-- REVISION FORM --}}
                                        <div
                                            id="revision-form"
                                            class="mt-4 hidden rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5"
                                        >

                                            <div class="mb-4">

                                                <div class="flex items-center gap-2">

                                                    <div
                                                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50 text-violet-600"
                                                    >
                                                        <i class="bi bi-arrow-repeat text-sm"></i>
                                                    </div>

                                                    <p class="text-xs font-bold text-slate-700">
                                                        Minta revisi
                                                    </p>

                                                </div>

                                                <p class="mt-2 text-[11px] leading-5 text-slate-500">
                                                    Jelaskan dengan jelas bagian yang perlu diperbaiki
                                                    agar freelancer dapat mengerjakannya sesuai
                                                    kebutuhanmu.
                                                </p>

                                            </div>


                                            <form
                                                action="{{ route('client.delivery.revision', $order) }}"
                                                method="POST"
                                            >

                                                @csrf


                                                <label
                                                    for="revision_note"
                                                    class="text-xs font-bold text-slate-700"
                                                >
                                                    Catatan revisi
                                                </label>


                                                <textarea
                                                    id="revision_note"
                                                    name="revision_note"
                                                    rows="5"
                                                    required
                                                    minlength="10"
                                                    maxlength="2000"
                                                    placeholder="Contoh: Bagian halaman utama masih perlu disesuaikan dengan brief yang sudah dibahas..."
                                                    class="mt-2 w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:ring-2 focus:ring-blue-100"
                                                >{{ old('revision_note') }}</textarea>


                                                @error('revision_note')

                                                    <div
                                                        class="mt-2 flex items-start gap-2 rounded-lg bg-red-50 px-3 py-2"
                                                    >

                                                        <i
                                                            class="bi bi-exclamation-circle mt-0.5 text-xs text-red-500"
                                                        ></i>

                                                        <p class="text-xs leading-5 text-red-600">
                                                            {{ $message }}
                                                        </p>

                                                    </div>

                                                @enderror


                                                <div
                                                    class="mt-2 flex items-center justify-between gap-3"
                                                >

                                                    <p class="text-[10px] text-slate-400">
                                                        Minimal 10 karakter
                                                    </p>

                                                    <p class="text-[10px] text-slate-400">
                                                        Maksimal 2000 karakter
                                                    </p>

                                                </div>


                                                <div
                                                    class="mt-4 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end"
                                                >

                                                    <button
                                                        type="button"
                                                        onclick="toggleRevisionForm()"
                                                        class="h-10 rounded-lg px-4 text-xs font-semibold text-slate-500 transition hover:bg-slate-200/60"
                                                    >
                                                        Batal
                                                    </button>


                                                    <button
                                                        type="submit"
                                                        onclick="return confirm('Kirim permintaan revisi kepada freelancer?')"
                                                        class="h-10 rounded-lg bg-[#2563EB] px-4 text-xs font-bold text-white transition hover:bg-[#1D4ED8]"
                                                    >
                                                        <i class="bi bi-send mr-1"></i>
                                                        Kirim Permintaan Revisi
                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>


                                @elseif ($order->status === 'delivered' && $delivery->status !== 'submitted')

                                    {{-- PROCESSED DELIVERY --}}
                                    <div
                                        class="mt-6 rounded-xl border border-slate-200 bg-slate-50 px-4 py-4"
                                    >

                                        <div class="flex items-start gap-3">

                                            <div
                                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#2563EB] shadow-sm"
                                            >
                                                <i class="bi bi-info-circle"></i>
                                            </div>

                                            <div>

                                                <p class="text-xs font-bold text-slate-700">
                                                    Delivery sudah diproses
                                                </p>

                                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                                    Delivery terbaru sudah tidak dapat diproses kembali.
                                                </p>

                                            </div>

                                        </div>

                                    </div>


                                @elseif ($order->status === 'completed' && $delivery->status === 'approved')

                                    {{-- APPROVED --}}
                                    <div
                                        class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-4"
                                    >

                                        <div class="flex items-start gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm"
                                            >
                                                <i class="bi bi-check-circle-fill"></i>
                                            </div>

                                            <div>

                                                <p class="text-xs font-bold text-emerald-700">
                                                    Hasil pekerjaan sudah disetujui
                                                </p>

                                                <p class="mt-1 text-xs leading-5 text-emerald-700/70">
                                                    Order ini telah selesai. Kamu dapat memberikan
                                                    review kepada freelancer.
                                                </p>

                                                <a
                                                    href="{{ route('client.orders.show', $order) }}"
                                                    class="mt-3 inline-flex items-center gap-2 text-[11px] font-bold text-[#2563EB] transition hover:text-[#1D4ED8]"
                                                >
                                                    Lihat order
                                                    <i class="bi bi-arrow-right"></i>
                                                </a>

                                            </div>

                                        </div>

                                    </div>


                                @elseif ($order->status === 'revision' && $delivery->status === 'revision')

                                    {{-- REVISION --}}
                                    <div
                                        class="mt-6 rounded-xl border border-violet-200 bg-violet-50 px-4 py-4"
                                    >

                                        <div class="flex items-start gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-violet-600 shadow-sm"
                                            >
                                                <i class="bi bi-arrow-repeat"></i>
                                            </div>

                                            <div>

                                                <p class="text-xs font-bold text-violet-700">
                                                    Permintaan revisi sudah dikirim
                                                </p>

                                                <p class="mt-1 text-xs leading-5 text-violet-700/70">
                                                    Freelancer sedang memperbaiki hasil pekerjaan
                                                    sesuai dengan catatan revisi yang kamu kirim.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            </div>


                        @else

                            {{-- =================================================
                                EMPTY DELIVERY
                            ================================================== --}}
                            <div class="px-5 py-16 text-center sm:px-6">

                                <div
                                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB]"
                                >
                                    <i class="bi bi-inbox text-2xl"></i>
                                </div>

                                <h2 class="mt-4 text-sm font-bold text-slate-900">
                                    Belum ada delivery
                                </h2>

                                <p
                                    class="mx-auto mt-2 max-w-sm text-xs leading-5 text-slate-500"
                                >
                                    Freelancer belum mengirimkan hasil pekerjaan
                                    untuk order ini.
                                </p>

                            </div>

                        @endif

                    </section>


                    {{-- =====================================================
                        ORDER ITEMS
                    ====================================================== --}}
                    <section
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_6px_24px_rgba(15,23,42,0.04)]"
                    >

                        <div
                            class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6"
                        >

                            <div>

                                <p
                                    class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400"
                                >
                                    Order
                                </p>

                                <h2 class="mt-1 text-sm font-bold text-slate-900">
                                    Detail pesanan
                                </h2>

                            </div>

                            <div
                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]"
                            >
                                <i class="bi bi-receipt"></i>
                            </div>

                        </div>


                        <div class="divide-y divide-slate-100">

                            @forelse ($order->items as $item)

                                <div
                                    class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6"
                                >

                                    <div class="flex min-w-0 items-start gap-3">

                                        <div
                                            class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-50 text-slate-400"
                                        >
                                            <i class="bi bi-file-text text-xs"></i>
                                        </div>

                                        <div class="min-w-0">

                                            <p class="text-xs font-semibold text-slate-700">
                                                {{ $item->service_title }}
                                            </p>

                                            <p class="mt-1 text-[10px] text-slate-400">
                                                Qty {{ $item->quantity }}
                                            </p>

                                        </div>

                                    </div>


                                    <p
                                        class="shrink-0 text-xs font-bold text-slate-900"
                                    >
                                        Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                    </p>

                                </div>

                            @empty

                                <div class="px-5 py-8 text-center">

                                    <p class="text-xs text-slate-400">
                                        Tidak ada item pesanan.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </section>

                </main>



                {{-- =========================================================
                    SIDEBAR
                ========================================================== --}}
                <aside class="space-y-5 lg:sticky lg:top-24 lg:self-start">


                    {{-- =====================================================
                        FREELANCER
                    ====================================================== --}}
                    <section
                        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_6px_24px_rgba(15,23,42,0.04)]"
                    >

                        <div class="flex items-center justify-between">

                            <p
                                class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400"
                            >
                                Freelancer
                            </p>

                            <i class="bi bi-person-check text-sm text-[#2563EB]"></i>

                        </div>


                        <div class="mt-4 flex items-center gap-3">

                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-blue-50"
                            >

                                @if ($freelancerAvatar)

                                    <img
                                        src="{{ $freelancerAvatar }}"
                                        alt="{{ $freelancerName }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    <span class="text-sm font-bold text-[#2563EB]">
                                        {{ $freelancerInitial }}
                                    </span>

                                @endif

                            </div>


                            <div class="min-w-0">

                                <p class="truncate text-sm font-bold text-slate-900">
                                    {{ $freelancerName }}
                                </p>

                                @if ($freelancer?->headline)

                                    <p
                                        class="mt-0.5 line-clamp-2 text-[10px] leading-4 text-slate-400"
                                    >
                                        {{ $freelancer->headline }}
                                    </p>

                                @else

                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        Freelancer ProKerjaa
                                    </p>

                                @endif

                            </div>

                        </div>


                        @if ($freelancer?->username)

                            <a
                                href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                                class="mt-4 flex h-10 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                            >
                                <i class="bi bi-person"></i>
                                Lihat profil
                            </a>

                        @endif

                    </section>



                    {{-- =====================================================
                        ORDER SUMMARY
                    ====================================================== --}}
                    <section
                        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_6px_24px_rgba(15,23,42,0.04)]"
                    >

                        <div class="flex items-center justify-between">

                            <p
                                class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400"
                            >
                                Ringkasan
                            </p>

                            <i class="bi bi-wallet2 text-sm text-[#2563EB]"></i>

                        </div>


                        <div class="mt-4 space-y-3">

                            {{-- SUBTOTAL --}}
                            <div class="flex items-center justify-between gap-3">

                                <span class="text-[11px] text-slate-400">
                                    Subtotal
                                </span>

                                <span class="text-xs font-semibold text-slate-700">
                                    Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}
                                </span>

                            </div>


                            {{-- PLATFORM FEE --}}
                            @if (isset($order->platform_fee))

                                <div class="flex items-center justify-between gap-3">

                                    <span class="text-[11px] text-slate-400">
                                        Biaya platform
                                    </span>

                                    <span class="text-xs font-semibold text-slate-700">
                                        Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                                    </span>

                                </div>

                            @endif


                            {{-- DELIVERY DAYS --}}
                            <div class="flex items-center justify-between gap-3">

                                <span class="text-[11px] text-slate-400">
                                    Pengerjaan
                                </span>

                                <span class="text-xs font-semibold text-slate-700">
                                    {{ $order->delivery_days }} hari
                                </span>

                            </div>


                            {{-- TOTAL --}}
                            <div class="border-t border-slate-100 pt-3">

                                <div class="flex items-end justify-between gap-3">

                                    <span class="text-xs font-semibold text-slate-600">
                                        Total
                                    </span>

                                    <span class="text-base font-bold text-slate-900">
                                        Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        <div
                            class="mt-5 rounded-xl border border-blue-100 bg-blue-50 px-3.5 py-3"
                        >

                            <div class="flex items-start gap-2">

                                <i
                                    class="bi bi-shield-check mt-0.5 text-sm text-[#2563EB]"
                                ></i>

                                <p class="text-[10px] leading-4 text-slate-500">
                                    Periksa hasil pekerjaan sebelum menyelesaikan order.
                                </p>

                            </div>

                        </div>

                    </section>



                    {{-- =====================================================
                        HELP
                    ====================================================== --}}
                    <section
                        class="rounded-2xl border border-blue-100 bg-blue-50 p-5"
                    >

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm"
                        >
                            <i class="bi bi-chat-dots"></i>
                        </div>


                        <h2 class="mt-4 text-sm font-bold text-slate-900">
                            Ada yang perlu ditanyakan?
                        </h2>


                        <p class="mt-1.5 text-xs leading-5 text-slate-500">
                            Hubungi freelancer melalui pesan jika ada detail
                            hasil pekerjaan yang ingin kamu tanyakan.
                        </p>


                        <a
                            href="{{ route('client.messages.index') }}"
                            class="mt-4 flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-white text-xs font-bold text-slate-700 shadow-sm transition hover:text-[#2563EB]"
                        >
                            Buka pesan
                            <i class="bi bi-arrow-right text-[10px]"></i>
                        </a>

                    </section>

                </aside>

            </div>

        </div>

    </div>


    {{-- =========================================================
        REVISION FORM SCRIPT
    ========================================================== --}}
    <script>
        function toggleRevisionForm() {
            const form = document.getElementById('revision-form');

            if (!form) {
                return;
            }

            form.classList.toggle('hidden');

            if (!form.classList.contains('hidden')) {
                const textarea = document.getElementById('revision_note');

                if (textarea) {
                    setTimeout(() => {
                        textarea.focus();
                    }, 100);
                }
            }
        }
    </script>

</x-layouts.marketplace>