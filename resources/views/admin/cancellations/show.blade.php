
<x-layouts.admin title="Detail Pembatalan">

    @php
        $statusClass = match ($cancellationRequest->status) {
            'pending_freelancer' =>
                'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',

            'approved_by_freelancer' =>
                'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200',

            'rejected_by_freelancer' =>
                'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200',

            'mediation_pending' =>
                'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200',

            'approved_by_admin' =>
                'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200',

            'rejected_by_admin' =>
                'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200',

            default =>
                'bg-slate-50 text-slate-600 ring-1 ring-inset ring-slate-200',
        };

        $statusLabel = match ($cancellationRequest->status) {
            'pending_freelancer' =>
                'Menunggu Freelancer',

            'approved_by_freelancer' =>
                'Disetujui Freelancer',

            'rejected_by_freelancer' =>
                'Ditolak Freelancer',

            'mediation_pending' =>
                'Menunggu Mediasi',

            'approved_by_admin' =>
                'Disetujui Admin',

            'rejected_by_admin' =>
                'Ditolak Admin',

            default =>
                ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $cancellationRequest->status
                    )
                ),
        };

        $paymentStatus = $cancellationRequest->order?->payment?->status;

        $paymentLabel = match ($paymentStatus) {
            'pending' =>
                'Menunggu Pembayaran',

            'paid' =>
                'Sudah Dibayar',

            'refund_pending' =>
                'Menunggu Refund',

            'cancelled' =>
                'Dibatalkan',

            default =>
                $paymentStatus
                    ? ucfirst(
                        str_replace(
                            '_',
                            ' ',
                            $paymentStatus
                        )
                    )
                    : 'Belum tersedia',
        };

        $paymentClass = match ($paymentStatus) {
            'pending' =>
                'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',

            'paid' =>
                'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200',

            'refund_pending' =>
                'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200',

            'cancelled' =>
                'bg-slate-50 text-slate-600 ring-1 ring-inset ring-slate-200',

            default =>
                'bg-slate-50 text-slate-600 ring-1 ring-inset ring-slate-200',
        };

        $orderStatus = $cancellationRequest->order?->status;

        $orderStatusLabel = $orderStatus
            ? ucfirst(str_replace('_', ' ', $orderStatus))
            : '-';

        $requesterProfile = $cancellationRequest->requester?->profile;
        $requesterAvatar = $requesterProfile?->avatar;

        $freelancerProfile = $cancellationRequest->order?->freelancerProfile;
        $freelancerUser = $freelancerProfile?->user;
        $freelancerAvatar = $freelancerProfile?->avatar;

        $requesterInitial = strtoupper(
            substr(
                $cancellationRequest->requester?->name ?? 'P',
                0,
                1
            )
        );

        $freelancerInitial = strtoupper(
            substr(
                $freelancerUser?->name ?? 'F',
                0,
                1
            )
        );
    @endphp

    <div class="mx-auto max-w-6xl space-y-6 px-4 py-5 sm:px-6 lg:px-8 lg:py-7">

        {{-- Breadcrumb / Back --}}
        <div>
            <a
                href="{{ route('admin.cancellations.index') }}"
                class="inline-flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm font-medium text-slate-500 transition hover:bg-blue-50 hover:text-blue-600"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke pembatalan
            </a>
        </div>

        {{-- Page Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2">
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-200"
                    >
                        <i class="bi bi-shield-check"></i>
                        Admin Panel
                    </span>

                    <span class="text-xs text-slate-400">
                        Detail Pembatalan
                    </span>
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Detail Pembatalan
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Tinjau alasan, respons freelancer, status pembayaran, dan keputusan mediasi.
                </p>
            </div>

            <span
                class="inline-flex w-fit items-center gap-2 rounded-full px-3.5 py-2 text-xs font-semibold {{ $statusClass }}"
            >
                @if($cancellationRequest->status === 'mediation_pending')
                    <i class="bi bi-hourglass-split"></i>
                @elseif(
                    in_array(
                        $cancellationRequest->status,
                        [
                            'approved_by_freelancer',
                            'approved_by_admin',
                        ],
                        true
                    )
                )
                    <i class="bi bi-check-circle-fill"></i>
                @elseif(
                    in_array(
                        $cancellationRequest->status,
                        [
                            'rejected_by_freelancer',
                            'rejected_by_admin',
                        ],
                        true
                    )
                )
                    <i class="bi bi-x-circle-fill"></i>
                @else
                    <i class="bi bi-clock-fill"></i>
                @endif

                {{ $statusLabel }}
            </span>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm text-emerald-700">
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white shadow-sm">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div>
                    <p class="font-semibold">Berhasil</p>
                    <p class="mt-0.5 leading-6">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700">
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <div>
                    <p class="font-semibold">Terjadi kesalahan</p>
                    <p class="mt-0.5 leading-6">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Main Content --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

            {{-- Main Header --}}
            <div class="border-b border-slate-100 bg-gradient-to-br from-white via-white to-blue-50/60 px-5 py-6 sm:px-7 sm:py-7">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-600">
                            Permintaan Pembatalan
                        </p>

                        <div class="mt-2 flex flex-wrap items-center gap-2.5">
                            <h2 class="break-all text-xl font-bold text-slate-900 sm:text-2xl">
                                {{ $cancellationRequest->order?->order_number ?? '-' }}
                            </h2>

                            @if($cancellationRequest->order)
                                <a
                                    href="{{ route('admin.orders.show', $cancellationRequest->order) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1.5 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"
                                >
                                    Lihat Order
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>
                            @endif
                        </div>

                        <p class="mt-2 text-sm text-slate-500">
                            Diajukan
                            {{ $cancellationRequest->created_at?->format('d M Y, H:i') ?? '-' }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                            <i class="bi bi-calendar3"></i>
                        </div>

                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-wide text-blue-600">
                                Waktu Pengajuan
                            </p>
                            <p class="mt-0.5 text-sm font-semibold text-slate-800">
                                {{ $cancellationRequest->created_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Summary Grid --}}
            <div class="border-b border-slate-100 px-5 py-6 sm:px-7">

                <div class="mb-5">
                    <h3 class="text-base font-bold text-slate-900">
                        Ringkasan Pembatalan
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Informasi utama pihak yang terlibat dan kondisi order saat ini.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                    {{-- Client / Requester --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                        <div class="flex items-center gap-3">

                            @if($requesterAvatar)
                                <img
                                    src="{{ asset('storage/' . $requesterAvatar) }}"
                                    alt="{{ $cancellationRequest->requester?->name ?? 'Pemohon' }}"
                                    class="h-11 w-11 shrink-0 rounded-xl object-cover ring-2 ring-white"
                                >
                            @else
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-700 ring-2 ring-white">
                                    {{ $requesterInitial }}
                                </div>
                            @endif

                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                    Client / Pemohon
                                </p>

                                <p class="mt-1 truncate font-semibold text-slate-900">
                                    {{ $cancellationRequest->requester?->name ?? '-' }}
                                </p>

                                <p class="mt-0.5 truncate text-xs text-slate-500">
                                    {{ $cancellationRequest->requester?->email ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Freelancer --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                        <div class="flex items-center gap-3">

                            @if($freelancerAvatar)
                                <img
                                    src="{{ asset('storage/' . $freelancerAvatar) }}"
                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                    class="h-11 w-11 shrink-0 rounded-xl object-cover ring-2 ring-white"
                                >
                            @else
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-100 text-sm font-bold text-violet-700 ring-2 ring-white">
                                    {{ $freelancerInitial }}
                                </div>
                            @endif

                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                    Freelancer
                                </p>

                                <p class="mt-1 truncate font-semibold text-slate-900">
                                    {{ $freelancerUser?->name ?? '-' }}
                                </p>

                                <p class="mt-0.5 truncate text-xs text-slate-500">
                                    {{ $freelancerProfile?->username ? '@' . $freelancerProfile->username : 'Freelancer ProKerja' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Order Status --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <i class="bi bi-receipt text-lg"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                    Status Order
                                </p>

                                <p class="mt-1 truncate font-semibold capitalize text-slate-900">
                                    {{ $orderStatusLabel }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    Kondisi order saat pengajuan
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Payment --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <i class="bi bi-credit-card text-lg"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                    Status Pembayaran
                                </p>

                                <span
                                    class="mt-1 inline-flex max-w-full truncate rounded-full px-2.5 py-1 text-xs font-semibold {{ $paymentClass }}"
                                >
                                    {{ $paymentLabel }}
                                </span>

                                @if($cancellationRequest->order?->total !== null)
                                    <p class="mt-2 text-xs text-slate-500">
                                        Total:
                                        <span class="font-semibold text-slate-800">
                                            Rp {{ number_format((float) $cancellationRequest->order->total, 0, ',', '.') }}
                                        </span>
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            {{-- Reason --}}
            <div class="px-5 py-6 sm:px-7">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                        <i class="bi bi-chat-left-text"></i>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-slate-900">
                            Alasan Pembatalan
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Alasan yang disampaikan oleh
                            {{ ucfirst($cancellationRequest->requester_role ?? 'pengguna') }}.
                        </p>
                    </div>
                </div>

                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-5 sm:p-6">
                    <p class="whitespace-pre-line text-sm leading-7 text-slate-700">
                        {{ $cancellationRequest->reason }}
                    </p>
                </div>
            </div>

            {{-- Freelancer Response --}}
            @if(
                $cancellationRequest->freelancer_note ||
                $cancellationRequest->freelancer_reviewed_at
            )
                <div class="border-t border-slate-100 px-5 py-6 sm:px-7">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-100 text-violet-600">
                            <i class="bi bi-person-check"></i>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-slate-900">
                                Tanggapan Freelancer
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Respons freelancer terhadap permintaan pembatalan.
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-2xl border border-violet-100 bg-violet-50/60 p-5 sm:p-6">

                        @if($cancellationRequest->freelancer_note)
                            <p class="whitespace-pre-line text-sm leading-7 text-slate-700">
                                {{ $cancellationRequest->freelancer_note }}
                            </p>
                        @else
                            <div class="flex items-center gap-3 text-sm text-violet-700">
                                <i class="bi bi-info-circle"></i>
                                Freelancer memberikan keputusan tanpa catatan.
                            </div>
                        @endif

                        @if($cancellationRequest->freelancer_reviewed_at)
                            <div class="mt-4 border-t border-violet-100 pt-3">
                                <p class="text-xs text-violet-600">
                                    <i class="bi bi-clock mr-1"></i>
                                    Ditinjau
                                    {{ $cancellationRequest->freelancer_reviewed_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        @endif

                    </div>
                </div>
            @endif

            {{-- Mediation Reason --}}
            @if($cancellationRequest->mediation_reason)
                <div class="border-t border-slate-100 px-5 py-6 sm:px-7">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                            <i class="bi bi-people"></i>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-slate-900">
                                Alasan Mediasi Client
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Informasi tambahan yang diajukan saat proses mediasi.
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-2xl border border-blue-200 bg-blue-50/70 p-5 sm:p-6">
                        <p class="whitespace-pre-line text-sm leading-7 text-slate-700">
                            {{ $cancellationRequest->mediation_reason }}
                        </p>

                        @if($cancellationRequest->mediation_requested_at)
                            <div class="mt-4 border-t border-blue-100 pt-3">
                                <p class="text-xs text-blue-600">
                                    <i class="bi bi-clock mr-1"></i>
                                    Diajukan untuk mediasi
                                    {{ $cancellationRequest->mediation_requested_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Admin Decision --}}
            @if($cancellationRequest->status === 'mediation_pending')

                <div class="border-t border-slate-100 bg-slate-50/50 px-5 py-6 sm:px-7 sm:py-7">

                    <div class="mb-6">
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <h3 class="text-base font-bold text-slate-900">
                                    Keputusan Mediasi Admin
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-slate-500">
                                    Tinjau alasan client, tanggapan freelancer, dan kondisi order sebelum mengambil keputusan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-5 lg:grid-cols-2">

                        {{-- Approve --}}
                        <form
                            action="{{ route('admin.cancellations.approve', $cancellationRequest) }}"
                            method="POST"
                            class="rounded-2xl border border-emerald-200 bg-white p-5 shadow-sm sm:p-6"
                        >
                            @csrf

                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                                    <i class="bi bi-check-lg text-lg"></i>
                                </div>

                                <div>
                                    <p class="text-sm font-bold text-slate-900">
                                        Setujui Mediasi
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Order akan dibatalkan. Payment yang sudah dibayar akan masuk ke status refund pending.
                                    </p>
                                </div>
                            </div>

                            <label class="mt-5 block">
                                <span class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Catatan Admin
                                </span>

                                <textarea
                                    name="admin_note"
                                    rows="5"
                                    maxlength="2000"
                                    class="block w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100"
                                    placeholder="Catatan keputusan admin (opsional)..."
                                >{{ old('admin_note') }}</textarea>
                            </label>

                            <button
                                type="submit"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 !text-white text-sm font-semibold shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-2"
                            >
                                <i class="bi bi-check-lg"></i>
                                Setujui Mediasi
                            </button>
                        </form>

                        {{-- Reject --}}
                        <form
                            action="{{ route('admin.cancellations.reject', $cancellationRequest) }}"
                            method="POST"
                            class="rounded-2xl border border-red-200 bg-white p-5 shadow-sm sm:p-6"
                        >
                            @csrf

                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                                    <i class="bi bi-x-lg text-lg"></i>
                                </div>

                                <div>
                                    <p class="text-sm font-bold text-slate-900">
                                        Tolak Mediasi
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Order tetap berjalan setelah mediasi ditolak.
                                    </p>
                                </div>
                            </div>

                            <label class="mt-5 block">
                                <span class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Alasan Penolakan
                                </span>

                                <textarea
                                    name="admin_note"
                                    rows="5"
                                    minlength="5"
                                    maxlength="2000"
                                    required
                                    class="block w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-red-400 focus:bg-white focus:ring-2 focus:ring-red-100"
                                    placeholder="Alasan penolakan mediasi..."
                                >{{ old('admin_note') }}</textarea>
                            </label>

                            <button
                                type="submit"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-red-600 !text-white text-sm font-semibold shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-200 focus:ring-offset-2"
                            >
                                <i class="bi bi-x-lg"></i>
                                Tolak Mediasi
                            </button>
                        </form>

                    </div>
                </div>

            @else

                {{-- Final Result --}}
                <div class="border-t border-slate-100 px-5 py-6 sm:px-7">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 sm:p-6">

                        <div class="flex items-start gap-4">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                                @if(
                                    in_array(
                                        $cancellationRequest->status,
                                        [
                                            'approved_by_freelancer',
                                            'approved_by_admin',
                                        ],
                                        true
                                    )
                                )
                                    bg-emerald-100 text-emerald-600
                                @elseif(
                                    in_array(
                                        $cancellationRequest->status,
                                        [
                                            'rejected_by_freelancer',
                                            'rejected_by_admin',
                                        ],
                                        true
                                    )
                                )
                                    bg-red-100 text-red-600
                                @elseif($cancellationRequest->status === 'mediation_pending')
                                    bg-blue-100 text-blue-600
                                @else
                                    bg-amber-100 text-amber-600
                                @endif
                                "
                            >
                                @if(
                                    in_array(
                                        $cancellationRequest->status,
                                        [
                                            'approved_by_freelancer',
                                            'approved_by_admin',
                                        ],
                                        true
                                    )
                                )
                                    <i class="bi bi-check-lg text-lg"></i>

                                @elseif(
                                    in_array(
                                        $cancellationRequest->status,
                                        [
                                            'rejected_by_freelancer',
                                            'rejected_by_admin',
                                        ],
                                        true
                                    )
                                )
                                    <i class="bi bi-x-lg text-lg"></i>

                                @elseif($cancellationRequest->status === 'mediation_pending')
                                    <i class="bi bi-people text-lg"></i>

                                @else
                                    <i class="bi bi-hourglass-split text-lg"></i>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="text-sm font-bold text-slate-900">
                                        {{ $statusLabel }}
                                    </p>

                                    <span
                                        class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $statusClass }}"
                                    >
                                        Status Akhir
                                    </span>
                                </div>

                                @if($cancellationRequest->admin_note)
                                    <div class="mt-3 rounded-xl border border-white bg-white p-4">
                                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                            Catatan Admin
                                        </p>

                                        <p class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-700">
                                            {{ $cancellationRequest->admin_note }}
                                        </p>
                                    </div>
                                @endif

                                @if($cancellationRequest->reviewed_at)
                                    <p class="mt-4 text-xs text-slate-500">
                                        <i class="bi bi-clock mr-1"></i>
                                        Ditinjau:
                                        {{ $cancellationRequest->reviewed_at->format('d M Y, H:i') }}

                                        @if($cancellationRequest->reviewer)
                                            <span class="mx-1 text-slate-300">•</span>
                                            oleh
                                            <span class="font-semibold text-slate-700">
                                                {{ $cancellationRequest->reviewer->name }}
                                            </span>
                                        @endif
                                    </p>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>

            @endif

        </div>

    </div>

</x-layouts.admin>

