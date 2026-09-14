<x-layouts.client>


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

    $statusMap = [
        'pending_payment' => [
            'label' => 'Menunggu pembayaran',
            'class' => 'bg-amber-50 text-amber-700',
        ],
        'paid' => [
            'label' => 'Sudah dibayar',
            'class' => 'bg-blue-50 text-blue-700',
        ],
        'in_progress' => [
            'label' => 'Sedang dikerjakan',
            'class' => 'bg-[#EAF7EF] text-[#166534]',
        ],
        'revision' => [
            'label' => 'Menunggu revisi',
            'class' => 'bg-orange-50 text-orange-700',
        ],
        'completed' => [
            'label' => 'Selesai',
            'class' => 'bg-emerald-50 text-emerald-700',
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'class' => 'bg-red-50 text-red-700',
        ],
    ];

    $currentStatus = $statusMap[$order->status] ?? [
        'label' => ucfirst(str_replace('_', ' ', $order->status)),
        'class' => 'bg-gray-100 text-gray-600',
    ];

    $canProcessDelivery =
        $delivery &&
        $delivery->status === 'submitted' &&
        in_array($order->status, ['in_progress', 'revision']);
@endphp


<div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">

    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

        {{-- Back --}}
        <a
            href="{{ route('client.orders.show', $order) }}"
            class="mb-5 inline-flex items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke detail order
        </a>


        {{-- Page Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                    Hasil pekerjaan
                </p>

                <h1 class="mt-1 text-xl font-semibold tracking-tight text-[#123128] sm:text-2xl">
                    Delivery Order
                </h1>

                <p class="mt-1 text-xs text-[#71837B]">
                    Periksa hasil pekerjaan dari freelancer sebelum menyetujui order.
                </p>

            </div>


            <div class="flex flex-wrap items-center gap-2">

                <span class="rounded-full px-3 py-1.5 text-[10px] font-semibold {{ $currentStatus['class'] }}">
                    {{ $currentStatus['label'] }}
                </span>

                <span class="rounded-full border border-[#DCE7E1] bg-white px-3 py-1.5 text-[10px] font-medium text-[#71837B]">
                    {{ $order->order_number }}
                </span>

            </div>

        </div>


        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">


            {{-- Main Delivery --}}
            <div class="space-y-5">


                {{-- Delivery Card --}}
                <div class="overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_8px_30px_rgba(18,49,40,0.05)]">

                    <div class="border-b border-[#E8EFEB] px-5 py-5 sm:px-6">

                        <div class="flex items-start gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                <i class="bi bi-box-seam text-lg"></i>
                            </div>


                            <div class="min-w-0">

                                <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                                    Delivery
                                </p>

                                <h2 class="mt-1 text-base font-semibold text-[#123128]">
                                    Hasil pekerjaan freelancer
                                </h2>

                                @if ($delivery?->created_at)

                                    <p class="mt-1 text-[11px] text-[#91A099]">
                                        Dikirim pada
                                        {{ $delivery->created_at->format('d M Y, H:i') }}
                                    </p>

                                @endif

                            </div>

                        </div>

                    </div>


                    @if ($delivery)

                        <div class="px-5 py-5 sm:px-6">


                            {{-- Delivery Status --}}
                            @php
                                $deliveryStatusMap = [
                                    'submitted' => [
                                        'label' => 'Menunggu persetujuan',
                                        'class' => 'bg-[#EAF7EF] text-[#166534]',
                                        'icon' => 'bi-hourglass-split',
                                    ],
                                    'approved' => [
                                        'label' => 'Disetujui',
                                        'class' => 'bg-emerald-50 text-emerald-700',
                                        'icon' => 'bi-check-circle-fill',
                                    ],
                                    'revision' => [
                                        'label' => 'Memerlukan revisi',
                                        'class' => 'bg-orange-50 text-orange-700',
                                        'icon' => 'bi-arrow-repeat',
                                    ],
                                    'rejected' => [
                                        'label' => 'Ditolak',
                                        'class' => 'bg-red-50 text-red-700',
                                        'icon' => 'bi-x-circle-fill',
                                    ],
                                ];

                                $deliveryStatus = $deliveryStatusMap[$delivery->status] ?? [
                                    'label' => ucfirst($delivery->status),
                                    'class' => 'bg-gray-100 text-gray-600',
                                    'icon' => 'bi-circle',
                                ];
                            @endphp


                            <div class="mb-5 flex items-center justify-between gap-3 rounded-xl border border-[#E3ECE7] bg-[#F8FBF9] px-4 py-3">

                                <div class="flex items-center gap-2">

                                    <i class="bi {{ $deliveryStatus['icon'] }} text-sm text-[#1E9E5A]"></i>

                                    <span class="text-xs font-medium text-[#355248]">
                                        Status delivery
                                    </span>

                                </div>

                                <span class="rounded-full px-2.5 py-1 text-[9px] font-semibold {{ $deliveryStatus['class'] }}">
                                    {{ $deliveryStatus['label'] }}
                                </span>

                            </div>


                            {{-- Delivery Note --}}
                            @if (!empty($delivery->message ?? null))

                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#91A099]">
                                        Catatan dari freelancer
                                    </p>

                                    <div class="mt-2 rounded-xl border border-[#E5ECE8] bg-[#FAFCFB] px-4 py-4">

                                        <p class="whitespace-pre-line text-sm leading-6 text-[#405B50]">
                                            {{ $delivery->message }}
                                        </p>

                                    </div>

                                </div>

                            @elseif (!empty($delivery->notes ?? null))

                                <div>

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#91A099]">
                                        Catatan dari freelancer
                                    </p>

                                    <div class="mt-2 rounded-xl border border-[#E5ECE8] bg-[#FAFCFB] px-4 py-4">

                                        <p class="whitespace-pre-line text-sm leading-6 text-[#405B50]">
                                            {{ $delivery->notes }}
                                        </p>

                                    </div>

                                </div>

                            @endif


                            {{-- Delivery File --}}
                            @if (!empty($delivery->file_path ?? null))

                                <div class="mt-5">

                                    <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#91A099]">
                                        File hasil pekerjaan
                                    </p>

                                    <div class="mt-2 flex items-center justify-between gap-3 rounded-xl border border-[#DCE9E1] bg-[#F8FCF9] px-4 py-3">

                                        <div class="flex min-w-0 items-center gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-[#1E9E5A] shadow-sm">

                                                <i class="bi bi-file-earmark-arrow-down"></i>

                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate text-xs font-semibold text-[#355248]">
                                                    {{ $delivery->file_name ?? 'File hasil pekerjaan' }}
                                                </p>

                                                <p class="mt-0.5 text-[10px] text-[#91A099]">
                                                    File delivery
                                                </p>

                                            </div>

                                        </div>


                                        <a
                                            href="{{ asset('storage/' . $delivery->file_path) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-[#D7E5DC] bg-white px-3 py-2 text-[10px] font-semibold text-[#1E9E5A] transition hover:border-[#BBD7C7] hover:bg-[#F5FBF7]"
                                        >
                                            <i class="bi bi-download"></i>
                                            Lihat file
                                        </a>

                                    </div>

                                </div>

                            @endif


                            {{-- Actions --}}
                            @if ($canProcessDelivery)

                                <div class="mt-6 border-t border-[#EDF2EF] pt-5">

                                    <div class="mb-4">

                                        <h3 class="text-sm font-semibold text-[#123128]">
                                            Periksa hasil pekerjaan
                                        </h3>

                                        <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                            Setujui jika hasil sudah sesuai. Bila masih ada bagian yang perlu diperbaiki, kirim permintaan revisi kepada freelancer.
                                        </p>

                                    </div>


                                    <div class="grid gap-3 sm:grid-cols-2">


                                        {{-- Approve --}}
                                        <form
                                            action="{{ route('client.delivery.approve', $order) }}"
                                            method="POST"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                onclick="return confirm('Apakah kamu yakin hasil pekerjaan ini sudah sesuai?')"
                                                class="flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] text-xs font-semibold text-white shadow-sm transition hover:bg-[#0F6B3A]"
                                            >
                                                <i class="bi bi-check-circle"></i>
                                                Setujui Hasil
                                            </button>

                                        </form>


                                        {{-- Revision --}}
                                        <button
                                            type="button"
                                            onclick="document.getElementById('revision-form').classList.toggle('hidden')"
                                            class="flex h-11 w-full items-center justify-center gap-2 rounded-xl border border-[#DDE7E1] bg-white text-xs font-semibold text-[#526960] transition hover:border-[#C9DDD1] hover:bg-[#F8FBF9]"
                                        >
                                            <i class="bi bi-arrow-repeat"></i>
                                            Minta Revisi
                                        </button>

                                    </div>


                                    {{-- Revision Form --}}
                                    <div
                                        id="revision-form"
                                        class="mt-4 hidden rounded-xl border border-[#E5ECE8] bg-[#FAFCFB] p-4"
                                    >

                                        <form
                                            action="{{ route('client.delivery.revision', $order) }}"
                                            method="POST"
                                        >

                                            @csrf

                                            <label
                                                for="revision_note"
                                                class="text-xs font-semibold text-[#355248]"
                                            >
                                                Jelaskan bagian yang perlu direvisi
                                            </label>

                                            <textarea
                                                id="revision_note"
                                                name="revision_note"
                                                rows="5"
                                                required
                                                minlength="10"
                                                maxlength="2000"
                                                placeholder="Contoh: Bagian halaman utama masih perlu disesuaikan dengan brief yang sudah dibahas..."
                                                class="mt-2 w-full rounded-xl border border-[#DCE7E1] bg-white px-4 py-3 text-sm leading-6 text-[#123128] outline-none placeholder:text-[#A0ADA7] focus:border-[#9ACCB0] focus:ring-2 focus:ring-[#EAF7EF]"
                                            >{{ old('revision_note') }}</textarea>


                                            @error('revision_note')

                                                <p class="mt-1.5 text-xs text-red-600">
                                                    {{ $message }}
                                                </p>

                                            @enderror


                                            <div class="mt-3 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                                                <button
                                                    type="button"
                                                    onclick="document.getElementById('revision-form').classList.add('hidden')"
                                                    class="h-10 rounded-lg px-4 text-xs font-medium text-[#71837B] transition hover:bg-[#F1F5F3]"
                                                >
                                                    Batal
                                                </button>

                                                <button
                                                    type="submit"
                                                    class="h-10 rounded-lg bg-[#1E9E5A] px-4 text-xs font-semibold text-white transition hover:bg-[#0F6B3A]"
                                                >
                                                    Kirim Permintaan Revisi
                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            @elseif ($delivery->status === 'approved')

                                <div class="mt-6 rounded-xl border border-[#CFE9D8] bg-[#F1FBF4] px-4 py-4">

                                    <div class="flex items-start gap-3">

                                        <i class="bi bi-check-circle-fill mt-0.5 text-[#1E9E5A]"></i>

                                        <div>

                                            <p class="text-xs font-semibold text-[#166534]">
                                                Hasil pekerjaan sudah disetujui
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-[#47705A]">
                                                Order ini telah selesai. Kamu dapat melanjutkan ke tahap memberikan review.
                                            </p>

                                            @if ($order->status === 'completed')

                                                <a
                                                    href="{{ route('client.orders.show', $order) }}"
                                                    class="mt-3 inline-flex items-center gap-2 text-[11px] font-semibold text-[#1E9E5A] hover:text-[#0F6B3A]"
                                                >
                                                    Lihat order
                                                    <i class="bi bi-arrow-right"></i>
                                                </a>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @elseif ($delivery->status === 'revision')

                                <div class="mt-6 rounded-xl border border-[#F2D8B0] bg-[#FFFBF5] px-4 py-4">

                                    <div class="flex items-start gap-3">

                                        <i class="bi bi-arrow-repeat mt-0.5 text-[#B7791F]"></i>

                                        <div>

                                            <p class="text-xs font-semibold text-[#925F0A]">
                                                Revisi sedang diproses
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-[#80644A]">
                                                Permintaan revisi sudah dikirim. Tunggu freelancer mengirim hasil revisi berikutnya.
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            @endif

                        </div>

                    @else

                        {{-- Empty Delivery --}}
                        <div class="px-5 py-14 text-center sm:px-6">

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A]">

                                <i class="bi bi-inbox text-2xl"></i>

                            </div>

                            <h2 class="mt-4 text-sm font-semibold text-[#123128]">
                                Belum ada delivery
                            </h2>

                            <p class="mx-auto mt-1 max-w-sm text-xs leading-5 text-[#87978F]">
                                Freelancer belum mengirimkan hasil pekerjaan untuk order ini.
                            </p>

                        </div>

                    @endif

                </div>


                {{-- Order Items --}}
                <div class="rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_6px_24px_rgba(18,49,40,0.04)]">

                    <div class="border-b border-[#E8EFEB] px-5 py-4 sm:px-6">

                        <h2 class="text-sm font-semibold text-[#123128]">
                            Detail pesanan
                        </h2>

                    </div>


                    <div class="divide-y divide-[#EDF2EF]">

                        @foreach ($order->items as $item)

                            <div class="flex items-start justify-between gap-4 px-5 py-4 sm:px-6">

                                <div class="min-w-0">

                                    <p class="text-xs font-medium text-[#355248]">
                                        {{ $item->service_title }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-[#91A099]">
                                        Qty {{ $item->quantity }}
                                    </p>

                                </div>

                                <p class="shrink-0 text-xs font-semibold text-[#123128]">
                                    Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                </p>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>


            {{-- Sidebar --}}
            <aside class="space-y-5">


                {{-- Freelancer --}}
                <div class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_6px_24px_rgba(18,49,40,0.04)]">

                    <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#91A099]">
                        Freelancer
                    </p>


                    <div class="mt-4 flex items-center gap-3">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF]">

                            @if ($freelancerAvatar)

                                <img
                                    src="{{ $freelancerAvatar }}"
                                    alt="{{ $freelancerName }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                <span class="text-sm font-semibold text-[#1E9E5A]">
                                    {{ $freelancerInitial }}
                                </span>

                            @endif

                        </div>


                        <div class="min-w-0">

                            <p class="truncate text-sm font-semibold text-[#123128]">
                                {{ $freelancerName }}
                            </p>

                            @if ($freelancer?->headline)

                                <p class="mt-0.5 line-clamp-2 text-[10px] leading-4 text-[#81918A]">
                                    {{ $freelancer->headline }}
                                </p>

                            @endif

                        </div>

                    </div>


                    @if ($freelancer?->username)

                        <a
                            href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                            class="mt-4 flex h-10 items-center justify-center gap-2 rounded-xl border border-[#DCE7E1] text-xs font-semibold text-[#526960] transition hover:bg-[#F7FAF8] hover:text-[#1E9E5A]"
                        >
                            <i class="bi bi-person"></i>
                            Lihat profil
                        </a>

                    @endif

                </div>


                {{-- Order Summary --}}
                <div class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_6px_24px_rgba(18,49,40,0.04)]">

                    <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#91A099]">
                        Ringkasan order
                    </p>


                    <div class="mt-4 space-y-3">

                        <div class="flex items-center justify-between gap-3">

                            <span class="text-[11px] text-[#81918A]">
                                Subtotal
                            </span>

                            <span class="text-xs font-medium text-[#355248]">
                                Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-3">

                            <span class="text-[11px] text-[#81918A]">
                                Total
                            </span>

                            <span class="text-sm font-semibold text-[#123128]">
                                Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-3">

                            <span class="text-[11px] text-[#81918A]">
                                Pengerjaan
                            </span>

                            <span class="text-xs font-medium text-[#355248]">
                                {{ $order->delivery_days }} hari
                            </span>

                        </div>

                    </div>


                    <div class="mt-4 border-t border-[#EDF2EF] pt-4">

                        <div class="flex items-start gap-2">

                            <i class="bi bi-shield-check mt-0.5 text-sm text-[#1E9E5A]"></i>

                            <p class="text-[10px] leading-4 text-[#71837B]">
                                Jangan menyelesaikan order sebelum hasil pekerjaan diperiksa dan sesuai dengan kebutuhanmu.
                            </p>

                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </div>

</div>


</x-layouts.client>
