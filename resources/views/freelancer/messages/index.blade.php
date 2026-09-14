<x-layouts.freelancer>

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-7 sm:mb-8">
            <div class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1E9E5A]">
                Komunikasi
            </div>

            <div class="mt-2 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight text-[#123128] sm:text-[28px]">
                        Pesan
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-[#6B7E75]">
                        Kelola percakapan dengan client dan lanjutkan diskusi pekerjaan.
                    </p>
                </div>

                @if ($conversations->count())
                    <div
                        class="inline-flex w-fit items-center gap-2 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-[11px] font-medium text-[#0F6B3A]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>
                        {{ $conversations->count() }} percakapan
                    </div>
                @endif
            </div>
        </div>

        @if ($conversations->count())

            {{-- Conversation List --}}
            <div class="overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

                <div class="border-b border-[#E8EFEA] px-5 py-4 sm:px-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-sm font-semibold text-[#29483D]">
                                Percakapan terbaru
                            </h2>

                            <p class="mt-1 text-[11px] text-[#8A9B94]">
                                Diskusi dengan client tersimpan di sini.
                            </p>
                        </div>

                        <div
                            class="hidden h-9 w-9 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] sm:flex"
                        >
                            <i class="bi bi-chat-dots"></i>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-[#E9EFEB]">

                    @foreach ($conversations as $conversation)

                        <a
                            href="{{ route('freelancer.messages.show', $conversation) }}"
                            class="group flex gap-4 px-5 py-4 transition hover:bg-[#F8FCF9] sm:px-6 sm:py-5"
                        >

                            {{-- Avatar --}}
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

                            {{-- Content --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex items-start justify-between gap-4">

                                    <div class="min-w-0">
                                        <div class="flex min-w-0 items-center gap-2">
                                            <h3
                                                class="truncate text-sm font-semibold text-[#29483D] transition group-hover:text-[#0F6B3A]"
                                            >
                                                {{ $conversation->client?->name ?? 'Client' }}
                                            </h3>

                                            @if ($conversation->unread_messages_count > 0)
                                                <span
                                                    class="h-1.5 w-1.5 shrink-0 rounded-full bg-[#1E9E5A]"
                                                ></span>
                                            @endif
                                        </div>

                                        <p class="mt-1 truncate text-xs text-[#7C8D85]">
                                            {{ $conversation->service?->title ?? 'Percakapan umum' }}
                                        </p>
                                    </div>

                                    @if ($conversation->last_message_at)
                                        <span class="shrink-0 whitespace-nowrap text-[10px] text-[#99A7A1]">
                                            {{ $conversation->last_message_at->diffForHumans() }}
                                        </span>
                                    @endif

                                </div>

                                <div class="mt-3 flex items-center justify-between gap-4">

                                    @if ($conversation->unread_messages_count > 0)

                                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-[#0F6B3A]">
                                            <i class="bi bi-envelope-fill text-[11px]"></i>
                                            {{ $conversation->unread_messages_count }} pesan baru
                                        </span>

                                    @else

                                        <span class="text-xs text-[#9AA8A2]">
                                            Tidak ada pesan baru
                                        </span>

                                    @endif

                                    <div
                                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-[#9AA8A2] transition group-hover:bg-[#EAF7EF] group-hover:text-[#0F6B3A]"
                                    >
                                        <i class="bi bi-chevron-right text-[11px]"></i>
                                    </div>

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>
            </div>

        @else

            {{-- Empty State --}}
            <div class="rounded-[22px] border border-dashed border-[#D5E3DB] bg-white px-6 py-16 text-center">

                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A]"
                >
                    <i class="bi bi-chat-dots text-2xl"></i>
                </div>

                <div class="mx-auto mt-5 max-w-md">
                    <h2 class="text-lg font-semibold tracking-tight text-[#123128]">
                        Belum ada percakapan
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-[#7C8D85]">
                        Percakapan dengan client akan muncul di sini setelah ada
                        client yang menghubungi atau membuat pesanan.
                    </p>
                </div>

            </div>

        @endif

    </div>

</x-layouts.freelancer>