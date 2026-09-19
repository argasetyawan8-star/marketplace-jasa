<x-layouts.admin title="Detail Pembatalan">

    @php
        $statusClass = match ($cancellationRequest->status) {
            'pending_freelancer' =>
                'bg-[#FFF9EA] text-[#815A08]',

            'approved_by_freelancer' =>
                'bg-[#EAF7EF] text-[#168A4D]',

            'rejected_by_freelancer' =>
                'bg-red-50 text-red-700',

            'mediation_pending' =>
                'bg-[#F3F8FC] text-[#315D87]',

            'approved_by_admin' =>
                'bg-[#EAF7EF] text-[#168A4D]',

            'rejected_by_admin' =>
                'bg-red-50 text-red-700',

            default =>
                'bg-gray-50 text-gray-600',
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

        $paymentStatus =
            $cancellationRequest->order?->payment?->status;

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
                'bg-[#FFF9EA] text-[#815A08]',

            'paid' =>
                'bg-[#EAF7EF] text-[#168A4D]',

            'refund_pending' =>
                'bg-[#EEF5FF] text-[#315A91]',

            'cancelled' =>
                'bg-gray-50 text-gray-600',

            default =>
                'bg-gray-50 text-gray-600',
        };
    @endphp

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

        {{-- Back --}}
        <a
            href="{{ route('admin.cancellations.index') }}"
            class="inline-flex items-center gap-2 text-sm text-[#71837B] transition hover:text-[#0F6B3A]"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke pembatalan
        </a>

        {{-- Main Card --}}
        <div class="overflow-hidden rounded-2xl border border-[#DDE9E2] bg-white shadow-sm">

            {{-- Header --}}
            <div class="border-b border-[#EDF2EF] px-6 py-6">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#1E9E5A]">
                            Detail Pembatalan
                        </p>

                        <h1 class="mt-2 text-xl font-semibold text-[#123128]">
                            {{ $cancellationRequest->order?->order_number ?? '-' }}
                        </h1>

                        <p class="mt-1 text-sm text-[#899991]">
                            Diajukan
                            {{ $cancellationRequest->created_at?->format('d M Y, H:i') ?? '-' }}
                        </p>

                    </div>

                    <span
                        class="inline-flex w-fit rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}"
                    >
                        {{ $statusLabel }}
                    </span>

                </div>

            </div>

            {{-- Flash Message --}}
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

            {{-- Summary --}}
            <div class="grid gap-4 border-b border-[#EDF2EF] px-6 py-6 sm:grid-cols-2">

                {{-- Client --}}
                <div class="rounded-xl bg-[#F8FCF9] p-4">

                    <div class="flex items-center gap-2">

                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-[#0F6B3A] shadow-sm">
                            <i class="bi bi-person"></i>
                        </div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-[#899991]">
                            Client / Pemohon
                        </p>

                    </div>

                    <p class="mt-3 font-semibold text-[#123128]">
                        {{ $cancellationRequest->requester?->name ?? '-' }}
                    </p>

                    <p class="mt-1 text-sm text-[#71837B]">
                        {{ $cancellationRequest->requester?->email ?? '-' }}
                    </p>

                </div>

                {{-- Freelancer --}}
                <div class="rounded-xl bg-[#F8FCF9] p-4">

                    <div class="flex items-center gap-2">

                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-[#0F6B3A] shadow-sm">
                            <i class="bi bi-briefcase"></i>
                        </div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-[#899991]">
                            Freelancer
                        </p>

                    </div>

                    <p class="mt-3 font-semibold text-[#123128]">
                        {{ $cancellationRequest->order?->freelancerProfile?->user?->name ?? '-' }}
                    </p>

                </div>

                {{-- Order Status --}}
                <div class="rounded-xl bg-[#F8FCF9] p-4">

                    <div class="flex items-center gap-2">

                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-[#0F6B3A] shadow-sm">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-[#899991]">
                            Status Order
                        </p>

                    </div>

                    <p class="mt-3 font-semibold text-[#123128]">
                        {{ ucfirst(str_replace('_', ' ', $cancellationRequest->order?->status ?? '-')) }}
                    </p>

                </div>

                {{-- Payment --}}
                <div class="rounded-xl bg-[#F8FCF9] p-4">

                    <div class="flex items-center gap-2">

                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-[#0F6B3A] shadow-sm">
                            <i class="bi bi-credit-card"></i>
                        </div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-[#899991]">
                            Status Pembayaran
                        </p>

                    </div>

                    <div class="mt-3 flex flex-wrap items-center justify-between gap-3">

                        <p class="font-semibold text-[#123128]">
                            {{ $paymentLabel }}
                        </p>

                        <span
                            class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $paymentClass }}"
                        >
                            {{ $paymentLabel }}
                        </span>

                    </div>

                    @if($cancellationRequest->order?->total !== null)

                        <p class="mt-2 text-sm text-[#71837B]">

                            Total:

                            <span class="font-semibold text-[#123128]">
                                Rp {{ number_format((float) $cancellationRequest->order->total, 0, ',', '.') }}
                            </span>

                        </p>

                    @endif

                </div>

            </div>

            {{-- Original Reason --}}
            <div class="px-6 py-6">

                <p class="text-xs font-semibold uppercase tracking-wide text-[#52675D]">
                    Alasan Pembatalan Client
                </p>

                <div class="mt-3 rounded-xl bg-[#F8FCF9] p-5">

                    <p class="whitespace-pre-line text-sm leading-7 text-[#62766D]">
                        {{ $cancellationRequest->reason }}
                    </p>

                </div>

            </div>

            {{-- Freelancer Response --}}
            @if(
                $cancellationRequest->freelancer_note ||
                $cancellationRequest->freelancer_reviewed_at
            )

                <div class="border-t border-[#EDF2EF] px-6 py-6">

                    <p class="text-xs font-semibold uppercase tracking-wide text-[#52675D]">
                        Tanggapan Freelancer
                    </p>

                    <div class="mt-3 rounded-xl border border-red-100 bg-red-50 p-5">

                        @if($cancellationRequest->freelancer_note)

                            <p class="whitespace-pre-line text-sm leading-7 text-red-700">
                                {{ $cancellationRequest->freelancer_note }}
                            </p>

                        @else

                            <p class="text-sm text-red-700">
                                Freelancer memberikan keputusan tanpa catatan.
                            </p>

                        @endif

                        @if($cancellationRequest->freelancer_reviewed_at)

                            <p class="mt-3 text-xs text-red-500">
                                Ditinjau
                                {{ $cancellationRequest->freelancer_reviewed_at->format('d M Y, H:i') }}
                            </p>

                        @endif

                    </div>

                </div>

            @endif

            {{-- Mediation Reason --}}
            @if($cancellationRequest->mediation_reason)

                <div class="border-t border-[#EDF2EF] px-6 py-6">

                    <p class="text-xs font-semibold uppercase tracking-wide text-[#52675D]">
                        Alasan Mediasi Client
                    </p>

                    <div class="mt-3 rounded-xl border border-[#CFE0F1] bg-[#F3F8FC] p-5">

                        <p class="whitespace-pre-line text-sm leading-7 text-[#4F6678]">
                            {{ $cancellationRequest->mediation_reason }}
                        </p>

                        @if($cancellationRequest->mediation_requested_at)

                            <p class="mt-3 text-xs text-[#6D8498]">

                                Diajukan untuk mediasi

                                {{ $cancellationRequest->mediation_requested_at->format('d M Y, H:i') }}

                            </p>

                        @endif

                    </div>

                </div>

            @endif

            {{-- Admin Decision --}}
            @if($cancellationRequest->status === 'mediation_pending')

                <div class="border-t border-[#EDF2EF] px-6 py-6">

                    <div class="mb-5">

                        <p class="text-sm font-semibold text-[#123128]">
                            Keputusan Mediasi Admin
                        </p>

                        <p class="mt-1 text-xs leading-5 text-[#71837B]">
                            Tinjau alasan client, tanggapan freelancer, dan kondisi order sebelum mengambil keputusan.
                        </p>

                    </div>

                    <div class="grid gap-5 lg:grid-cols-2">

                        {{-- Approve --}}
                        <form
                            action="{{ route('admin.cancellations.approve', $cancellationRequest) }}"
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
                                        Setujui Mediasi
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                        Order akan dibatalkan. Payment yang sudah dibayar akan masuk ke status refund pending.
                                    </p>

                                </div>

                            </div>

                            <textarea
                                name="admin_note"
                                rows="5"
                                maxlength="2000"
                                class="mt-4 block w-full resize-none rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#A3B0AA] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                                placeholder="Catatan keputusan admin (opsional)..."
                            >{{ old('admin_note') }}</textarea>

                            <button
                                type="submit"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] text-sm font-semibold text-white transition hover:bg-[#1E9E5A] focus:outline-none focus:ring-2 focus:ring-[#BFE8CF] focus:ring-offset-2"
                            >
                                <i class="bi bi-check-lg"></i>
                                Setujui Mediasi
                            </button>

                        </form>

                        {{-- Reject --}}
                        <form
                            action="{{ route('admin.cancellations.reject', $cancellationRequest) }}"
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
                                        Tolak Mediasi
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-red-600/80">
                                        Order tetap berjalan setelah mediasi ditolak.
                                    </p>

                                </div>

                            </div>

                            <textarea
                                name="admin_note"
                                rows="5"
                                minlength="5"
                                maxlength="2000"
                                required
                                class="mt-4 block w-full resize-none rounded-xl border border-red-100 bg-white px-4 py-3 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#B89595] focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                placeholder="Alasan penolakan mediasi..."
                            >{{ old('admin_note') }}</textarea>

                            <button
                                type="submit"
                                class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-red-600 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-200 focus:ring-offset-2"
                            >
                                <i class="bi bi-x-lg"></i>
                                Tolak Mediasi
                            </button>

                        </form>

                    </div>

                </div>

            @else

                {{-- Final Result --}}
                <div class="border-t border-[#EDF2EF] px-6 py-6">

                    <div class="rounded-2xl border border-[#E7EEE9] bg-[#F8FCF9] p-5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white shadow-sm">

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

                                    <i class="bi bi-check-lg text-[#168A4D]"></i>

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

                                    <i class="bi bi-x-lg text-red-600"></i>

                                @else

                                    <i class="bi bi-hourglass-split text-[#815A08]"></i>

                                @endif

                            </div>

                            <div class="min-w-0">

                                <p class="text-sm font-semibold text-[#123128]">
                                    {{ $statusLabel }}
                                </p>

                                @if($cancellationRequest->admin_note)

                                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#71837B]">
                                        {{ $cancellationRequest->admin_note }}
                                    </p>

                                @endif

                                @if($cancellationRequest->reviewed_at)

                                    <p class="mt-3 text-xs text-[#899991]">

                                        Ditinjau:
                                        {{ $cancellationRequest->reviewed_at->format('d M Y, H:i') }}

                                        @if($cancellationRequest->reviewer)

                                            oleh {{ $cancellationRequest->reviewer->name }}

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