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


<main class="min-h-[calc(100vh-72px)] bg-[#F8FAFC]">

    <section class="mx-auto max-w-5xl px-4 py-5 sm:px-6 sm:py-6 lg:px-8">

        {{-- BACK --}}
        <a
            href="{{ route('freelancer.jobs.show', $job) }}"
            class="inline-flex items-center gap-2 text-xs font-medium text-[#64748B] transition hover:text-[#2563EB]"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke Job
        </a>


        {{-- CHAT CONTAINER --}}
        <div class="mt-4 overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-sm">

            {{-- =================================================
                 HEADER
            ================================================== --}}
            <div class="flex items-center justify-between gap-4 border-b border-[#E8EDF3] px-4 py-4 sm:px-6">

                <div class="flex min-w-0 items-center gap-3">

                    {{-- Avatar --}}
                    <div class="relative flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EFF6FF] text-sm font-bold text-[#2563EB] ring-2 ring-[#F8FAFC]">

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


                    {{-- Client --}}
                    <div class="min-w-0">

                        <div class="flex items-center gap-2">

                            <p class="truncate text-sm font-bold text-[#1E293B]">
                                {{ $clientName }}
                            </p>

                            <span class="hidden h-1.5 w-1.5 rounded-full bg-[#22C55E] sm:block"></span>

                        </div>

                        <p class="truncate text-[11px] text-[#94A3B8]">
                            {{ $job->title }}
                        </p>

                    </div>

                </div>


                {{-- Chat Badge --}}
                <span class="hidden shrink-0 items-center gap-1.5 rounded-full bg-[#EFF6FF] px-3 py-1.5 text-[10px] font-bold text-[#2563EB] sm:inline-flex">
                    <i class="bi bi-chat-dots-fill"></i>
                    Job Chat
                </span>

            </div>


            {{-- =================================================
                 PROPOSAL SUMMARY
            ================================================== --}}
            <div class="border-b border-[#E8EDF3] bg-[#F8FBFF] px-4 py-3.5 sm:px-6">

                <div class="flex flex-wrap items-center gap-x-6 gap-y-2.5 text-xs">

                    {{-- Price --}}
                    <div class="flex items-center gap-2">

                        <span class="text-[#94A3B8]">
                            Tawaran kamu
                        </span>

                        <span class="font-bold text-[#2563EB]">
                            Rp {{ number_format((float) $proposal->price, 0, ',', '.') }}
                        </span>

                    </div>


                    {{-- Divider --}}
                    <span class="hidden h-4 w-px bg-[#DBEAFE] sm:block"></span>


                    {{-- Duration --}}
                    <div class="flex items-center gap-2">

                        <span class="text-[#94A3B8]">
                            Durasi
                        </span>

                        <span class="font-semibold text-[#334155]">
                            {{ $proposal->delivery_days }} hari
                        </span>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 MESSAGES
            ================================================== --}}
            <div
                id="job-chat-messages"
                class="h-[55vh] min-h-[360px] space-y-4 overflow-y-auto bg-[#FCFDFE] px-4 py-5 sm:px-6"
            >

                @forelse($conversation->messages as $message)

                    @php
                        $mine = $message->user_id === auth()->id();
                    @endphp


                    <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }}">

                        <div class="max-w-[86%] sm:max-w-[70%]">

                            {{-- Message Bubble --}}
                            <div
                                class="
                                    rounded-2xl px-4 py-2.5 text-sm leading-6 shadow-sm
                                    {{
                                        $mine
                                            ? 'rounded-br-md bg-[#2563EB] text-white'
                                            : 'rounded-bl-md border border-[#E2E8F0] bg-white text-[#334155]'
                                    }}
                                "
                            >
                                {{ $message->body }}
                            </div>


                            {{-- Time --}}
                            <p
                                class="mt-1 px-1 text-[10px] text-[#A1ACB8] {{ $mine ? 'text-right' : '' }}"
                            >
                                {{ $message->created_at->format('H:i') }}
                            </p>

                        </div>

                    </div>

                @empty

                    {{-- Empty Chat --}}
                    <div class="flex h-full min-h-[320px] items-center justify-center px-6 text-center">

                        <div>

                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#EFF6FF] text-[#2563EB]">
                                <i class="bi bi-chat-dots text-lg"></i>
                            </div>

                            <p class="mt-3 text-sm font-bold text-[#1E293B]">
                                Mulai diskusi
                            </p>

                            <p class="mx-auto mt-1 max-w-xs text-xs leading-5 text-[#94A3B8]">
                                Diskusikan kebutuhan client sebelum melanjutkan ke quotation.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>


            {{-- =================================================
                 COMPOSER
            ================================================== --}}
            <div class="border-t border-[#E8EDF3] bg-white px-4 py-3.5 sm:px-6">

                @if(session('success'))

                    <div class="mb-3 flex items-center gap-2 rounded-lg bg-[#EFF6FF] px-3 py-2 text-xs font-medium text-[#2563EB]">

                        <i class="bi bi-check-circle-fill"></i>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('freelancer.jobs.chat.messages.store', [$job, $conversation]) }}"
                    class="flex items-end gap-2.5"
                >

                    @csrf


                    {{-- Message Input --}}
                    <textarea
                        name="body"
                        rows="2"
                        required
                        maxlength="5000"
                        placeholder="Tulis pesan..."
                        class="min-h-[44px] flex-1 resize-none rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-3 py-2.5 text-sm text-[#1E293B] outline-none transition placeholder:text-[#A8B2BF] focus:border-[#2563EB] focus:bg-white focus:ring-2 focus:ring-[#2563EB]/10"
                    ></textarea>


                    {{-- Send --}}
                    <button
                        type="submit"
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#2563EB] text-white shadow-sm transition hover:bg-[#1D4ED8] hover:shadow-md active:scale-95"
                        title="Kirim pesan"
                    >
                        <i class="bi bi-send-fill text-sm"></i>
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
