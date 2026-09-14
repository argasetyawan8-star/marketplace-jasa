<x-layouts.client>

@php
    $freelancer = $conversation->freelancerProfile;
    $freelancerUser = $freelancer?->user;

    $freelancerName = $freelancerUser?->name ?? 'Freelancer';

    $freelancerAvatar = $freelancer?->avatar
        ? asset('storage/' . $freelancer->avatar)
        : null;

    $freelancerInitial = strtoupper(
        substr($freelancerName, 0, 1)
    );

    $offerStatusMap = [
        'sent' => [
            'label' => 'Menunggu respons',
            'class' => 'bg-[#FEF3C7] text-[#92400E]',
            'icon' => 'bi-hourglass-split',
        ],
        'accepted' => [
            'label' => 'Diterima',
            'class' => 'bg-[#EAF7EF] text-[#166534]',
            'icon' => 'bi-check-circle-fill',
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'class' => 'bg-[#FEE2E2] text-[#991B1B]',
            'icon' => 'bi-x-circle-fill',
        ],
        'expired' => [
            'label' => 'Kedaluwarsa',
            'class' => 'bg-[#F3F4F6] text-[#4B5563]',
            'icon' => 'bi-clock-history',
        ],
    ];
@endphp


<div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">

    <div class="mx-auto max-w-6xl px-4 py-5 sm:px-6 lg:px-8 lg:py-7">

        {{-- Back --}}
        <a
            href="{{ route('client.messages.index') }}"
            class="mb-4 inline-flex items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
        >
            <i class="bi bi-arrow-left text-[13px]"></i>
            Kembali ke pesan
        </a>


        {{-- Chat Container --}}
        <div class="flex h-[calc(100vh-145px)] min-h-[580px] flex-col overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_10px_35px_rgba(18,49,40,0.06)]">


            {{-- Header --}}
            <div class="flex shrink-0 items-center justify-between border-b border-[#E8EFEB] bg-white px-4 py-3.5 sm:px-5">

                <div class="flex min-w-0 items-center gap-3">

                    <div class="relative shrink-0">

                        <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF]">

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

                        <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-[#35C978]"></span>

                    </div>


                    <div class="min-w-0">

                        <h1 class="truncate text-sm font-semibold text-[#123128]">
                            {{ $freelancerName }}
                        </h1>

                        <div class="mt-0.5 flex items-center gap-1.5">

                            <span class="h-1.5 w-1.5 rounded-full bg-[#35C978]"></span>

                            <span class="text-[10px] font-medium text-[#87968F]">
                                Freelancer
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Header Right --}}
                <div class="flex items-center gap-2">

                    @if ($conversation->service?->title)

                        <div class="hidden max-w-[240px] rounded-lg border border-[#E4ECE7] bg-[#F8FBF9] px-3 py-2 sm:block">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.12em] text-[#91A099]">
                                Jasa
                            </p>

                            <p class="mt-0.5 truncate text-[11px] font-medium text-[#355248]">
                                {{ $conversation->service->title }}
                            </p>

                        </div>

                    @endif


                    <a
                        href="{{ $freelancer?->username ? route('marketplace.freelancer', $freelancer->username) : '#' }}"
                        @if (!$freelancer?->username) aria-disabled="true" @endif
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-[#71837B] transition hover:bg-[#F3F8F5] hover:text-[#1E9E5A]"
                        title="Profil freelancer"
                    >
                        <i class="bi bi-person text-[15px]"></i>
                    </a>

                </div>

            </div>


            {{-- Message Area --}}
            <div
                id="jasain-chat-body"
                class="relative flex-1 overflow-y-auto bg-[#F4F8F6] px-4 py-6 sm:px-6"
            >

                <div class="pointer-events-none absolute inset-0 opacity-40">

                    <div class="absolute left-10 top-12 h-24 w-24 rounded-full bg-[#EAF7EF] blur-3xl"></div>

                    <div class="absolute bottom-20 right-10 h-28 w-28 rounded-full bg-[#E7F5ED] blur-3xl"></div>

                </div>


                <div class="relative mx-auto max-w-3xl">

                    {{-- Date --}}
                    <div class="mb-6 flex justify-center">

                        <span class="rounded-full border border-[#DCE8E1] bg-white px-3 py-1 text-[10px] font-medium text-[#899891] shadow-sm">
                            Hari ini
                        </span>

                    </div>


                    {{-- Messages --}}
                    @forelse ($conversation->messages as $message)

                        @php
                            $isClient = $message->sender_id === auth()->id();
                        @endphp

                        <div class="mb-4 flex {{ $isClient ? 'justify-end' : 'justify-start' }}">

                            <div class="max-w-[82%] sm:max-w-[68%]">

                                <div
                                    class="px-4 py-3 text-sm leading-6 shadow-[0_2px_8px_rgba(18,49,40,0.04)] {{ $isClient
                                        ? 'rounded-2xl rounded-br-md bg-[#1E9E5A] text-white'
                                        : 'rounded-2xl rounded-bl-md border border-[#E2EAE5] bg-white text-[#355248]' }}"
                                >
                                    {{ $message->message }}
                                </div>


                                <div class="mt-1 flex items-center gap-1 px-1 {{ $isClient ? 'justify-end' : 'justify-start' }}">

                                    <span class="text-[9px] text-[#96A49E]">
                                        {{ $message->created_at->format('H:i') }}
                                    </span>

                                    @if ($isClient)

                                        <i class="bi bi-check2-all text-[11px] text-[#6FCF97]"></i>

                                    @endif

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="flex min-h-[300px] items-center justify-center">

                            <div class="text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-[#1E9E5A] shadow-sm">

                                    <i class="bi bi-chat-dots text-xl"></i>

                                </div>

                                <h2 class="mt-4 text-sm font-semibold text-[#123128]">
                                    Mulai percakapan
                                </h2>

                                <p class="mt-1 max-w-xs text-xs leading-5 text-[#87978F]">
                                    Sampaikan kebutuhan pekerjaanmu kepada freelancer.
                                </p>

                            </div>

                        </div>

                    @endforelse


                    {{-- Offers --}}
                    @if ($conversation->offers && $conversation->offers->count())

                        <div class="my-7">

                            <div class="mb-4 flex items-center gap-2">

                                <span class="h-px flex-1 bg-[#DCE8E1]"></span>

                                <span class="flex items-center gap-1.5 text-[9px] font-semibold uppercase tracking-[0.16em] text-[#91A099]">
                                    <i class="bi bi-receipt-cutoff"></i>
                                    Penawaran
                                </span>

                                <span class="h-px flex-1 bg-[#DCE8E1]"></span>

                            </div>


                            <div class="space-y-4">

                                @foreach ($conversation->offers->sortByDesc('created_at') as $offer)

                                    @php
                                        $offerStatus = $offerStatusMap[$offer->status] ?? [
                                            'label' => ucfirst($offer->status ?? 'Unknown'),
                                            'class' => 'bg-gray-100 text-gray-600',
                                            'icon' => 'bi-question-circle',
                                        ];

                                        $isActionable = $offer->status === 'sent'
                                            && (!$offer->expires_at || !$offer->expires_at->isPast());
                                    @endphp


                                    <div class="overflow-hidden rounded-2xl border border-[#D8E9DE] bg-white shadow-[0_4px_16px_rgba(18,49,40,0.05)]">


                                        {{-- Offer Header --}}
                                        <div class="border-b border-[#EDF3EF] px-4 py-4">

                                            <div class="flex items-start justify-between gap-3">

                                                <div class="min-w-0">

                                                    <div class="flex items-center gap-2">

                                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#1E9E5A]">
                                                            <i class="bi bi-file-earmark-text"></i>
                                                        </span>

                                                        <div class="min-w-0">

                                                            <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                                                                Penawaran jasa
                                                            </p>

                                                            <h3 class="mt-1 line-clamp-2 text-sm font-semibold text-[#123128]">
                                                                {{ $offer->title }}
                                                            </h3>

                                                        </div>

                                                    </div>

                                                </div>


                                                <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1.5 text-[9px] font-semibold {{ $offerStatus['class'] }}">

                                                    <i class="bi {{ $offerStatus['icon'] }}"></i>

                                                    {{ $offerStatus['label'] }}

                                                </span>

                                            </div>

                                        </div>


                                        {{-- Offer Body --}}
                                        <div class="px-4 py-5">

                                            @if ($offer->description)

                                                <div class="rounded-xl bg-[#F8FBF9] p-3.5">

                                                    <p class="text-xs leading-5 text-[#667D73]">
                                                        {{ $offer->description }}
                                                    </p>

                                                </div>

                                            @endif


                                            {{-- Offer Stats --}}
                                            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">

                                                <div class="rounded-xl border border-[#E3ECE7] bg-[#F9FCFA] px-3 py-3">

                                                    <p class="text-[9px] uppercase tracking-[0.1em] text-[#91A099]">
                                                        Harga
                                                    </p>

                                                    <p class="mt-1 text-sm font-semibold text-[#123128]">
                                                        Rp {{ number_format((float) $offer->price, 0, ',', '.') }}
                                                    </p>

                                                </div>


                                                <div class="rounded-xl border border-[#E3ECE7] bg-[#F9FCFA] px-3 py-3">

                                                    <p class="text-[9px] uppercase tracking-[0.1em] text-[#91A099]">
                                                        Pengerjaan
                                                    </p>

                                                    <p class="mt-1 text-sm font-semibold text-[#123128]">
                                                        {{ $offer->delivery_days }} hari
                                                    </p>

                                                </div>


                                                <div class="rounded-xl border border-[#E3ECE7] bg-[#F9FCFA] px-3 py-3">

                                                    <p class="text-[9px] uppercase tracking-[0.1em] text-[#91A099]">
                                                        Revisi
                                                    </p>

                                                    <p class="mt-1 text-sm font-semibold text-[#123128]">
                                                        {{ $offer->revision_count ?? 0 }}x
                                                    </p>

                                                </div>

                                            </div>


                                            {{-- Expiration --}}
                                            @if ($offer->expires_at)

                                                <div class="mt-4 flex items-center gap-2 text-[11px] text-[#81918A]">

                                                    <i class="bi bi-clock"></i>

                                                    @if ($offer->expires_at->isPast())

                                                        <span class="text-[#A05B5B]">
                                                            Penawaran sudah kedaluwarsa
                                                        </span>

                                                    @else

                                                        <span>
                                                            Berlaku sampai
                                                            {{ $offer->expires_at->format('d M Y, H:i') }}
                                                        </span>

                                                    @endif

                                                </div>

                                            @endif


                                            {{-- Action --}}
                                            @if ($isActionable)

                                                <div class="mt-5 border-t border-[#EDF3EF] pt-4">

                                                    <p class="mb-3 text-xs font-medium text-[#667D73]">
                                                        Apakah kamu ingin melanjutkan dengan penawaran ini?
                                                    </p>

                                                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">


                                                        {{-- Reject --}}
                                                        <form
                                                            action="{{ route('client.offers.reject', $offer) }}"
                                                            method="POST"
                                                        >

                                                            @csrf

                                                            <button
                                                                type="submit"
                                                                onclick="return confirm('Tolak penawaran ini?')"
                                                                class="flex h-11 w-full items-center justify-center gap-2 rounded-xl border border-[#E3E9E5] bg-white text-xs font-semibold text-[#6F8078] transition hover:border-[#D8B7B7] hover:bg-[#FFF8F8] hover:text-[#B54141]"
                                                            >
                                                                <i class="bi bi-x-lg"></i>
                                                                Tolak
                                                            </button>

                                                        </form>


                                                        {{-- Accept --}}
                                                        <form
                                                            action="{{ route('client.offers.accept', $offer) }}"
                                                            method="POST"
                                                        >

                                                            @csrf

                                                            <button
                                                                type="submit"
                                                                onclick="return confirm('Terima penawaran ini dan lanjut ke pembayaran?')"
                                                                class="flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] text-xs font-semibold text-white shadow-sm transition hover:bg-[#0F6B3A]"
                                                            >
                                                                <i class="bi bi-check-lg"></i>
                                                                Terima Penawaran
                                                            </button>

                                                        </form>

                                                    </div>

                                                </div>

                                            @elseif ($offer->status === 'accepted')

                                                <div class="mt-5 rounded-xl border border-[#CDE8D7] bg-[#F1FBF4] px-4 py-3">

                                                    <div class="flex items-start gap-3">

                                                        <i class="bi bi-check-circle-fill mt-0.5 text-[#1E9E5A]"></i>

                                                        <div>

                                                            <p class="text-xs font-semibold text-[#166534]">
                                                                Penawaran diterima
                                                            </p>

                                                            <p class="mt-1 text-xs leading-5 text-[#47705A]">
                                                                Penawaran ini sudah diterima dan pesanan telah dibuat.
                                                            </p>

                                                        </div>

                                                    </div>

                                                </div>

                                            @elseif ($offer->status === 'rejected')

                                                <div class="mt-5 rounded-xl border border-[#F0C8C8] bg-[#FFF7F7] px-4 py-3">

                                                    <div class="flex items-start gap-3">

                                                        <i class="bi bi-x-circle-fill mt-0.5 text-[#B54141]"></i>

                                                        <div>

                                                            <p class="text-xs font-semibold text-[#991B1B]">
                                                                Penawaran ditolak
                                                            </p>

                                                            <p class="mt-1 text-xs leading-5 text-[#7F4B4B]">
                                                                Penawaran ini tidak dilanjutkan.
                                                            </p>

                                                        </div>

                                                    </div>

                                                </div>

                                            @elseif ($offer->status === 'expired')

                                                <div class="mt-5 rounded-xl border border-[#E1E5E3] bg-[#F8FAF9] px-4 py-3">

                                                    <div class="flex items-start gap-3">

                                                        <i class="bi bi-clock-history mt-0.5 text-[#7D8C85]"></i>

                                                        <div>

                                                            <p class="text-xs font-semibold text-[#53635B]">
                                                                Penawaran kedaluwarsa
                                                            </p>

                                                            <p class="mt-1 text-xs leading-5 text-[#7B8982]">
                                                                Penawaran ini sudah tidak dapat diproses.
                                                            </p>

                                                        </div>

                                                    </div>

                                                </div>

                                            @endif


                                            {{-- Offer Dates --}}
                                            <div class="mt-4 flex flex-wrap gap-x-4 gap-y-1 border-t border-[#EDF3EF] pt-3 text-[9px] text-[#9AA8A2]">

                                                <span>
                                                    Dibuat {{ $offer->created_at->format('d M Y, H:i') }}
                                                </span>

                                                @if ($offer->accepted_at)

                                                    <span>
                                                        Diterima {{ $offer->accepted_at->format('d M Y, H:i') }}
                                                    </span>

                                                @endif

                                                @if ($offer->rejected_at)

                                                    <span>
                                                        Ditolak {{ $offer->rejected_at->format('d M Y, H:i') }}
                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- Message Input --}}
            <div class="shrink-0 border-t border-[#E4EBE7] bg-white p-3 sm:p-4">

                <form
                    action="{{ route('client.messages.store', $conversation) }}"
                    method="POST"
                    class="mx-auto flex max-w-3xl items-end gap-2"
                >

                    @csrf


                    {{-- Attachment --}}
                    <button
                        type="button"
                        class="hidden h-11 w-11 shrink-0 items-center justify-center rounded-xl text-[#7D8D86] transition hover:bg-[#F3F8F5] hover:text-[#1E9E5A] sm:flex"
                        title="Lampiran"
                    >
                        <i class="bi bi-paperclip text-[16px]"></i>
                    </button>


                    {{-- Input --}}
                    <div class="flex min-w-0 flex-1 items-center rounded-xl border border-[#DCE7E1] bg-[#F9FBFA] transition focus-within:border-[#9ACCB0] focus-within:bg-white focus-within:ring-2 focus-within:ring-[#EAF7EF]">

                        <input
                            type="text"
                            name="message"
                            required
                            autocomplete="off"
                            placeholder="Tulis pesan..."
                            class="h-11 min-w-0 flex-1 border-0 bg-transparent px-4 text-sm text-[#123128] outline-none placeholder:text-[#9AA9A2]"
                        >

                    </div>


                    {{-- Send --}}
                    <button
                        type="submit"
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#1E9E5A] text-white shadow-[0_4px_14px_rgba(30,158,90,0.18)] transition hover:bg-[#0F6B3A]"
                        title="Kirim pesan"
                    >
                        <i class="bi bi-send-fill text-[13px]"></i>
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


{{-- Auto scroll --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatBody = document.getElementById('jasain-chat-body');

        if (chatBody) {
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    });
</script>


</x-layouts.client>
