<x-layouts.freelancer>

    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Back --}}
        <a
            href="{{ route('freelancer.messages.index') }}"
            class="inline-flex items-center gap-2 text-sm text-[#71837B] transition hover:text-[#0F6B3A]"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke pesan
        </a>

        {{-- Header --}}
        <div class="mt-6 overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

            <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">

                <div class="flex min-w-0 flex-1 items-center gap-4">

                    {{-- Client Avatar --}}
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A]"
                    >
                        {{ strtoupper(
                            substr(
                                $conversation->client?->name ?? 'C',
                                0,
                                1
                            )
                        ) }}
                    </div>

                    {{-- Client Info --}}
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h1 class="truncate text-base font-semibold text-[#123128]">
                                {{ $conversation->client?->name ?? 'Client' }}
                            </h1>

                            <span class="inline-flex items-center gap-1.5 text-[10px] font-medium text-[#1E9E5A]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>
                                Percakapan aktif
                            </span>
                        </div>

                        <p class="mt-1 truncate text-xs text-[#7C8D85]">
                            {{ $conversation->service?->title ?? 'Percakapan umum' }}
                        </p>
                    </div>

                </div>

                {{-- Header Actions --}}
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">

                    @if ($conversation->service)
                        <a
                            href="{{ route('marketplace.service', $conversation->service->slug) }}"
                            class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-[#D8E5DD] bg-white px-4 text-xs font-medium text-[#52675D] transition hover:border-[#C3D8CB] hover:bg-[#F8FCF9] hover:text-[#0F6B3A]"
                        >
                            <i class="bi bi-eye"></i>
                            Lihat jasa
                        </a>
                    @endif

                    <a
                        href="{{ route('freelancer.messages.offers.create', $conversation) }}"
                        class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-4 text-xs font-semibold text-white transition hover:bg-[#1E9E5A]"
                    >
                        <i class="bi bi-file-earmark-text"></i>
                        Kirim penawaran
                    </a>

                </div>

            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mt-4 rounded-2xl border border-[#CDE8D8] bg-[#F0FAF4] px-4 py-3">
                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#0F6B3A]">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <p class="pt-1 text-xs leading-5 text-[#256B46]">
                        {{ session('success') }}
                    </p>

                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mt-4 rounded-2xl border border-red-100 bg-red-50 px-4 py-3">
                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-red-600">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>

                    <p class="pt-1 text-xs leading-5 text-red-700">
                        {{ session('error') }}
                    </p>

                </div>
            </div>
        @endif

        {{-- Chat Workspace --}}
        <div class="mt-4 overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

            {{-- Messages --}}
            <div
                id="freelancer-chat"
                class="max-h-[580px] min-h-[440px] space-y-5 overflow-y-auto bg-[#FBFDFC] p-4 sm:p-6"
            >

                @php
                    $offers = $conversation->offers
                        ? $conversation->offers->sortBy('created_at')
                        : collect();
                @endphp

                @forelse ($conversation->messages as $message)

                    @php
                        $isMine = $message->sender_id === auth()->id();

                        $relatedOffer = null;

                        if ($message->type === 'offer') {
                            $relatedOffer = $offers->first(function ($offer) use ($message) {
                                return $offer->created_at->equalTo($message->created_at)
                                    || abs($offer->created_at->diffInSeconds($message->created_at, false)) <= 10;
                            });
                        }
                    @endphp

                    <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">

                        <div class="max-w-[92%] sm:max-w-[76%]">

                            {{-- Offer --}}
                            @if ($message->type === 'offer' && $relatedOffer)

                                <div class="overflow-hidden rounded-2xl border border-[#CDE8D8] bg-[#F0FAF4]">

                                    <div class="p-4 sm:p-5">

                                        <div class="flex items-start justify-between gap-4">

                                            <div class="min-w-0">

                                                <div class="inline-flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.08em] text-[#0F6B3A]">
                                                    <i class="bi bi-file-earmark-text text-sm"></i>
                                                    Penawaran
                                                </div>

                                                <h3 class="mt-2 text-base font-semibold leading-6 text-[#123128]">
                                                    {{ $relatedOffer->title }}
                                                </h3>

                                            </div>

                                            <span
                                                class="shrink-0 rounded-full bg-white px-2.5 py-1 text-[10px] font-semibold text-[#0F6B3A]"
                                            >
                                                {{ ucfirst($relatedOffer->status) }}
                                            </span>

                                        </div>

                                        @if ($relatedOffer->description)
                                            <p class="mt-3 whitespace-pre-line text-sm leading-6 text-[#5F746A]">
                                                {{ $relatedOffer->description }}
                                            </p>
                                        @endif

                                        {{-- Offer Stats --}}
                                        <div class="mt-4 grid gap-2 sm:grid-cols-3">

                                            <div class="rounded-xl bg-white p-3">
                                                <p class="text-[10px] text-[#8A9B94]">
                                                    Harga
                                                </p>

                                                <p class="mt-1 text-sm font-semibold text-[#123128]">
                                                    Rp {{ number_format($relatedOffer->price, 0, ',', '.') }}
                                                </p>
                                            </div>

                                            <div class="rounded-xl bg-white p-3">
                                                <p class="text-[10px] text-[#8A9B94]">
                                                    Pengerjaan
                                                </p>

                                                <p class="mt-1 text-sm font-semibold text-[#123128]">
                                                    {{ $relatedOffer->delivery_days }} hari
                                                </p>
                                            </div>

                                            <div class="rounded-xl bg-white p-3">
                                                <p class="text-[10px] text-[#8A9B94]">
                                                    Revisi
                                                </p>

                                                <p class="mt-1 text-sm font-semibold text-[#123128]">
                                                    {{ $relatedOffer->revision_count }} kali
                                                </p>
                                            </div>

                                        </div>

                                        @if ($relatedOffer->expires_at)
                                            <div class="mt-4 flex items-center gap-2 text-[11px] text-[#81918A]">
                                                <i class="bi bi-calendar3"></i>
                                                <span>
                                                    Berlaku sampai
                                                    {{ $relatedOffer->expires_at->format('d M Y H:i') }}
                                                </span>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="border-t border-[#D7EBDF] px-4 py-3 sm:px-5">
                                        <div class="flex items-center gap-2 text-xs text-[#71837B]">
                                            <i class="bi bi-info-circle text-[#1E9E5A]"></i>
                                            <span>
                                                Penawaran dikirim ke client untuk dipertimbangkan.
                                            </span>
                                        </div>
                                    </div>

                                </div>

                            {{-- Regular Message --}}
                            @else

                                <div
                                    class="rounded-2xl px-4 py-3 text-sm leading-6
                                        {{
                                            $isMine
                                                ? 'rounded-br-md bg-[#0F6B3A] text-white'
                                                : 'rounded-bl-md border border-[#E2ECE6] bg-white text-[#29483D]'
                                        }}"
                                >
                                    <div class="whitespace-pre-line break-words">
                                        {{ $message->message }}
                                    </div>
                                </div>

                            @endif

                            {{-- Time --}}
                            <p
                                class="mt-1.5 text-[9px] text-[#9AA8A2] {{
                                    $isMine ? 'text-right' : 'text-left'
                                }}"
                            >
                                {{ $message->created_at->format('H:i') }}
                            </p>

                        </div>

                    </div>

                @empty

                    <div class="flex min-h-[380px] items-center justify-center">
                        <div class="text-center">

                            <div
                                class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A]"
                            >
                                <i class="bi bi-chat-dots text-2xl"></i>
                            </div>

                            <h2 class="mt-5 text-base font-semibold text-[#123128]">
                                Belum ada pesan
                            </h2>

                            <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-[#87978F]">
                                Kirim pesan untuk memulai percakapan dengan client.
                            </p>

                        </div>
                    </div>

                @endforelse

            </div>

            {{-- Composer --}}
            <div class="border-t border-[#E4ECE7] bg-white p-4 sm:p-5">

                <div class="mb-3 flex items-center justify-between gap-4">

                    <div>
                        <p class="text-xs font-medium text-[#52675D]">
                            Balas client
                        </p>

                        <p class="mt-0.5 text-[10px] text-[#9AA8A2]">
                            Diskusikan kebutuhan sebelum mengirim penawaran.
                        </p>
                    </div>

                    <a
                        href="{{ route('freelancer.messages.offers.create', $conversation) }}"
                        class="hidden items-center gap-1.5 text-xs font-semibold text-[#0F6B3A] transition hover:text-[#1E9E5A] sm:inline-flex"
                    >
                        <i class="bi bi-file-earmark-text"></i>
                        Kirim penawaran
                    </a>

                </div>

                <form
                    action="{{ route('freelancer.messages.store', $conversation) }}"
                    method="POST"
                >
                    @csrf

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end">

                        <div class="min-w-0 flex-1">
                            <textarea
                                name="message"
                                rows="3"
                                required
                                maxlength="5000"
                                placeholder="Tulis balasan untuk client..."
                                class="block min-h-[82px] w-full resize-none rounded-2xl border border-[#D8E5DD] bg-[#F8FCF9] px-4 py-3 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#9BA9A2] focus:border-[#1E9E5A] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
                            ></textarea>

                            @error('message')
                                <p class="mt-1.5 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="inline-flex h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                        >
                            <i class="bi bi-send"></i>
                            Kirim
                        </button>

                    </div>
                </form>

            </div>

        </div>

    </div>

    {{-- Auto scroll to latest message --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chat = document.getElementById('freelancer-chat');

            if (chat) {
                chat.scrollTop = chat.scrollHeight;
            }
        });
    </script>

</x-layouts.freelancer>