<x-layouts.freelancer title="Job Chat">

    @php
        $proposal = $conversation->proposal;

        $client = $conversation->client;

        $clientName = $client?->name ?? 'Client';

        $clientAvatar = $client?->profile?->avatar
            ? asset('storage/' . $client->profile->avatar)
            : null;

        $clientInitial = strtoupper(
            mb_substr($clientName, 0, 1)
        );
    @endphp

    <main class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">

        <section class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">

            <a
                href="{{ route('freelancer.jobs.show', $job) }}"
                class="inline-flex items-center gap-2 text-xs text-[#71837B] hover:text-[#0F6B3A]"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke Job
            </a>

            <div class="mt-5 overflow-hidden rounded-xl border border-[#DDE7E2] bg-white">

                {{-- Header --}}
                <div class="flex items-center justify-between gap-4 border-b border-[#E8EFEB] px-5 py-4 sm:px-6">

                    <div class="flex min-w-0 items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A]">

                            @if($clientAvatar)

                                <img
                                    src="{{ $clientAvatar }}"
                                    alt="{{ $clientName }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                {{ $clientInitial }}

                            @endif

                        </div>

                        <div class="min-w-0">

                            <p class="truncate text-sm font-semibold text-[#123128]">
                                {{ $clientName }}
                            </p>

                            <p class="truncate text-[11px] text-[#81918B]">
                                {{ $job->title }}
                            </p>

                        </div>

                    </div>

                    <span class="hidden rounded-md bg-[#F1F7F3] px-2.5 py-1 text-[10px] font-semibold text-[#0F6B3A] sm:inline-flex">
                        Job Chat
                    </span>

                </div>


                {{-- Proposal --}}
                <div class="border-b border-[#E8EFEB] bg-[#FBFDFC] px-5 py-4 sm:px-6">

                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs">

                        <div>

                            <span class="text-[#899790]">
                                Tawaran kamu
                            </span>

                            <span class="ml-1.5 font-semibold text-[#0F6B3A]">
                                Rp {{ number_format((float) $proposal->price, 0, ',', '.') }}
                            </span>

                        </div>

                        <div>

                            <span class="text-[#899790]">
                                Durasi
                            </span>

                            <span class="ml-1.5 font-medium text-[#304B40]">
                                {{ $proposal->delivery_days }} hari
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Messages --}}
                <div
                    id="job-chat-messages"
                    class="h-[55vh] space-y-4 overflow-y-auto px-5 py-5 sm:px-6"
                >

                    @forelse($conversation->messages as $message)

                        @php
                            $mine = $message->user_id === auth()->id();
                        @endphp

                        <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }}">

                            <div class="max-w-[82%] sm:max-w-[70%]">

                                <div
                                    class="
                                        rounded-2xl px-4 py-3 text-sm leading-6
                                        {{ $mine
                                            ? 'rounded-br-md bg-[#0F6B3A] text-white'
                                            : 'rounded-bl-md bg-[#F1F5F3] text-[#304B40]'
                                        }}
                                    "
                                >
                                    {{ $message->body }}
                                </div>

                                <p class="mt-1 px-1 text-[10px] text-[#9AA7A1] {{ $mine ? 'text-right' : '' }}">
                                    {{ $message->created_at->format('H:i') }}
                                </p>

                            </div>

                        </div>

                    @empty

                        <div class="flex h-full items-center justify-center text-center">

                            <div>

                                <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg bg-[#F1F6F3] text-[#82958B]">
                                    <i class="bi bi-chat-dots"></i>
                                </div>

                                <p class="mt-3 text-sm font-semibold text-[#123128]">
                                    Mulai diskusi
                                </p>

                                <p class="mt-1 text-xs text-[#81918B]">
                                    Diskusikan kebutuhan client sebelum melanjutkan ke quotation.
                                </p>

                            </div>

                        </div>

                    @endforelse

                </div>


                {{-- Composer --}}
                <div class="border-t border-[#E8EFEB] px-5 py-4 sm:px-6">

                    @if(session('success'))

                        <div class="mb-3 text-xs text-[#0F6B3A]">
                            {{ session('success') }}
                        </div>

                    @endif

                    <form
                        method="POST"
                        action="{{ route('freelancer.jobs.chat.messages.store', [$job, $conversation]) }}"
                        class="flex items-end gap-3"
                    >

                        @csrf

                        <textarea
                            name="body"
                            rows="2"
                            required
                            maxlength="5000"
                            placeholder="Tulis pesan..."
                            class="min-h-[44px] flex-1 resize-none rounded-lg border border-[#DDE7E2] px-3 py-2.5 text-sm text-[#233D33] outline-none transition placeholder:text-[#A0ADA7] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                        ></textarea>

                        <button
                            type="submit"
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-[#0F6B3A] text-white transition hover:bg-[#17894D]"
                            title="Kirim pesan"
                        >
                            <i class="bi bi-send"></i>
                        </button>

                    </form>

                </div>

            </div>

        </section>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const box = document.getElementById('job-chat-messages');

            if (box) {
                box.scrollTop = box.scrollHeight;
            }
        });
    </script>

</x-layouts.freelancer>