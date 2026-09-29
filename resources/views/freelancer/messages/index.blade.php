
<x-layouts.freelancer>

    @php
        $totalConversations = $conversations->count();
    @endphp

    <style>
        /* =========================================================
         * ProKerja Freelancer Messages Index
         * ========================================================= */

        #prokerja-freelancer-messages {
            min-height: calc(100dvh - 68px);
        }

        #prokerja-freelancer-messages .conversation-scroll {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        #prokerja-freelancer-messages .conversation-scroll::-webkit-scrollbar {
            width: 6px;
        }

        #prokerja-freelancer-messages .conversation-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        #prokerja-freelancer-messages .conversation-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        #prokerja-freelancer-messages .conversation-item {
            transition:
                background-color .2s ease,
                transform .2s ease,
                border-color .2s ease;
        }

        #prokerja-freelancer-messages .conversation-item:hover {
            transform: translateX(1px);
        }

        #prokerja-freelancer-messages .conversation-avatar {
            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        #prokerja-freelancer-messages .conversation-item:hover .conversation-avatar {
            transform: scale(1.04);
            box-shadow: 0 5px 14px rgba(15, 23, 42, .08);
        }

        #prokerja-freelancer-messages .search-icon {
            transition: color .2s ease;
        }

        #prokerja-freelancer-messages .search-wrap:focus-within .search-icon {
            color: #2563eb;
        }

        @media (max-width: 1023px) {
            #prokerja-freelancer-messages {
                min-height: auto;
            }

            #prokerja-freelancer-messages .conversation-scroll {
                max-height: none;
                overflow: visible;
            }
        }
    </style>

    <div
        id="prokerja-freelancer-messages"
        class="bg-[#F8FAFC]"
    >
        <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            {{-- =====================================================
                 Header
            ====================================================== --}}
            <div class="mb-6 sm:mb-7">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div class="min-w-0">
                        <div class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.08em] text-blue-700">
                            Komunikasi
                        </div>

                        <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-[28px]">
                            Pesan
                        </h1>

                        <p class="mt-1.5 max-w-2xl text-sm leading-6 text-slate-500">
                            Kelola percakapan dengan client dan lanjutkan diskusi pekerjaan dalam satu tempat.
                        </p>
                    </div>

                    @if ($totalConversations)
                        <div class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-blue-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>
                            {{ $totalConversations }} percakapan
                        </div>
                    @endif

                </div>
            </div>


            {{-- =====================================================
                 Main Workspace
            ====================================================== --}}
            @if ($totalConversations)

                <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                    <div class="grid min-h-[650px] grid-cols-1 lg:grid-cols-[340px_minmax(0,1fr)]">

                        {{-- =================================================
                             LEFT — Conversation List
                        ================================================== --}}
                        <aside class="flex min-h-0 flex-col border-b border-slate-200 bg-white lg:border-b-0 lg:border-r">

                            {{-- Header --}}
                            <div class="shrink-0 border-b border-slate-200 px-5 py-4 sm:px-6">

                                <div class="flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <h2 class="text-sm font-semibold text-slate-900">
                                            Percakapan
                                        </h2>

                                        <p class="mt-1 text-[11px] text-slate-500">
                                            Chat dengan client
                                        </p>
                                    </div>

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                        <i class="bi bi-chat-dots text-sm"></i>
                                    </div>
                                </div>

                                {{-- Search --}}
                                <div class="search-wrap relative mt-4">
                                    <i
                                        class="search-icon bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"
                                    ></i>

                                    <input
                                        id="conversation-search"
                                        type="search"
                                        placeholder="Cari percakapan..."
                                        autocomplete="off"
                                        class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50 pl-9 pr-3 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:bg-white focus:ring-2 focus:ring-blue-100"
                                    >
                                </div>

                            </div>


                            {{-- Conversation List --}}
                            <div
                                id="conversation-list"
                                class="conversation-scroll min-h-0 flex-1 overflow-y-auto"
                            >

                                @foreach ($conversations as $conversation)

                                    @php
                                        $client = $conversation->client;
                                        $clientName = $client?->name ?? 'Client';

                                        $clientInitial = strtoupper(
                                            substr(trim($clientName), 0, 1)
                                        );

                                        $avatar = $client?->avatar
                                            ? asset('storage/' . $client->avatar)
                                            : ($client?->profile_photo_url ?? null);

                                        $serviceTitle = $conversation->service?->title
                                            ?? 'Percakapan umum';

                                        $lastMessage = $conversation->last_message?->message
                                            ?? $conversation->lastMessage?->message
                                            ?? '';

                                        $searchText = strtolower(
                                            $clientName . ' ' .
                                            $serviceTitle . ' ' .
                                            $lastMessage
                                        );
                                    @endphp

                                    <a
                                        href="{{ route('freelancer.messages.show', $conversation) }}"
                                        data-conversation
                                        data-search="{{ $searchText }}"
                                        class="conversation-item group block border-b border-slate-100 px-4 py-3.5 transition hover:bg-slate-50 sm:px-5"
                                    >
                                        <div class="flex gap-3">

                                            {{-- Avatar --}}
                                            <div class="relative shrink-0">

                                                @if ($avatar)
                                                    <img
                                                        src="{{ $avatar }}"
                                                        alt="{{ $clientName }}"
                                                        class="conversation-avatar h-11 w-11 rounded-full object-cover ring-2 ring-white"
                                                        loading="lazy"
                                                    >
                                                @else
                                                    <div class="conversation-avatar flex h-11 w-11 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-700 ring-2 ring-white">
                                                        {{ $clientInitial }}
                                                    </div>
                                                @endif

                                                @if ($conversation->unread_messages_count > 0)
                                                    <span class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full border-2 border-white bg-blue-600 px-1 text-[8px] font-bold text-white">
                                                        {{ $conversation->unread_messages_count > 9 ? '9+' : $conversation->unread_messages_count }}
                                                    </span>
                                                @endif

                                            </div>


                                            {{-- Content --}}
                                            <div class="min-w-0 flex-1">

                                                <div class="flex items-start justify-between gap-3">

                                                    <div class="min-w-0 flex-1">
                                                        <div class="flex min-w-0 items-center gap-1.5">

                                                            <h3
                                                                class="truncate text-sm font-semibold text-slate-800 transition group-hover:text-blue-700"
                                                            >
                                                                {{ $clientName }}
                                                            </h3>

                                                        </div>

                                                        <p class="mt-0.5 truncate text-[11px] text-slate-500">
                                                            {{ $serviceTitle }}
                                                        </p>
                                                    </div>

                                                    @if ($conversation->last_message_at)
                                                        <span class="shrink-0 whitespace-nowrap text-[10px] text-slate-400">
                                                            {{ $conversation->last_message_at->diffForHumans() }}
                                                        </span>
                                                    @endif

                                                </div>


                                                <div class="mt-2 flex items-center justify-between gap-3">

                                                    @if ($conversation->unread_messages_count > 0)

                                                        <span class="inline-flex min-w-0 items-center gap-1.5 truncate text-[11px] font-semibold text-blue-700">
                                                            <i class="bi bi-envelope-fill shrink-0 text-[10px]"></i>
                                                            <span class="truncate">
                                                                {{ $conversation->unread_messages_count }} pesan baru
                                                            </span>
                                                        </span>

                                                    @elseif ($lastMessage)

                                                        <span class="block min-w-0 truncate text-[11px] text-slate-400">
                                                            {{ $lastMessage }}
                                                        </span>

                                                    @else

                                                        <span class="text-[11px] text-slate-400">
                                                            Belum ada pesan
                                                        </span>

                                                    @endif

                                                    <span
                                                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-slate-300 transition group-hover:bg-blue-50 group-hover:text-blue-600"
                                                    >
                                                        <i class="bi bi-chevron-right text-[10px]"></i>
                                                    </span>

                                                </div>

                                            </div>

                                        </div>
                                    </a>

                                @endforeach


                                {{-- Search Empty State --}}
                                <div
                                    id="conversation-search-empty"
                                    class="hidden px-6 py-12 text-center"
                                >
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <i class="bi bi-search text-lg"></i>
                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-slate-800">
                                        Percakapan tidak ditemukan
                                    </h3>

                                    <p class="mx-auto mt-1.5 max-w-xs text-xs leading-5 text-slate-500">
                                        Coba gunakan nama client atau judul layanan yang berbeda.
                                    </p>
                                </div>

                            </div>

                        </aside>


                        {{-- =================================================
                             RIGHT — Inbox Preview
                        ================================================== --}}
                        <div class="hidden min-w-0 bg-[#F8FAFC] lg:flex lg:flex-col">

                            {{-- Preview Header --}}
                            <div class="flex shrink-0 items-center justify-between border-b border-slate-200 bg-white px-6 py-4">

                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-blue-600">
                                        Inbox Freelancer
                                    </p>

                                    <h2 class="mt-1 text-sm font-semibold text-slate-900">
                                        Komunikasi dengan client
                                    </h2>
                                </div>

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi bi-chat-square-text"></i>
                                </div>

                            </div>


                            {{-- Preview Empty --}}
                            <div class="flex min-h-0 flex-1 items-center justify-center px-6 py-12">

                                <div class="w-full max-w-md text-center">

                                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-blue-600 shadow-sm">
                                        <i class="bi bi-chat-dots text-3xl"></i>
                                    </div>

                                    <h3 class="mt-6 text-lg font-semibold tracking-tight text-slate-900">
                                        Pilih percakapan
                                    </h3>

                                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
                                        Pilih salah satu percakapan di sebelah kiri untuk melihat pesan dan melanjutkan komunikasi dengan client.
                                    </p>


                                    <div class="mt-6 grid gap-3 text-left sm:grid-cols-3">

                                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                                <i class="bi bi-chat-text text-sm"></i>
                                            </div>

                                            <p class="mt-3 text-xs font-semibold text-slate-800">
                                                Diskusi
                                            </p>

                                            <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                                Bahas kebutuhan project dengan client.
                                            </p>
                                        </div>


                                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                                <i class="bi bi-file-earmark-text text-sm"></i>
                                            </div>

                                            <p class="mt-3 text-xs font-semibold text-slate-800">
                                                Project
                                            </p>

                                            <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                                Pantau pembahasan pekerjaan.
                                            </p>
                                        </div>


                                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                                <i class="bi bi-bell text-sm"></i>
                                            </div>

                                            <p class="mt-3 text-xs font-semibold text-slate-800">
                                                Notifikasi
                                            </p>

                                            <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                                Pesan baru akan ditandai otomatis.
                                            </p>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

            @else

                {{-- =====================================================
                     Empty State
                ====================================================== --}}
                <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex min-h-[520px] items-center justify-center px-6 py-16">

                        <div class="w-full max-w-md text-center">

                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-blue-600 shadow-sm">
                                <i class="bi bi-chat-dots text-3xl"></i>
                            </div>

                            <h2 class="mt-6 text-xl font-bold tracking-tight text-slate-900">
                                Belum ada percakapan
                            </h2>

                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                                Percakapan dengan client akan muncul di sini setelah ada client yang menghubungi atau membuat pesanan.
                            </p>

                            <div class="mx-auto mt-7 grid max-w-sm gap-3 text-left sm:grid-cols-2">

                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                                        <i class="bi bi-chat-text"></i>
                                    </div>

                                    <p class="mt-3 text-xs font-semibold text-slate-800">
                                        Komunikasi
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                        Balas pesan dari client dengan mudah.
                                    </p>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                                        <i class="bi bi-briefcase"></i>
                                    </div>

                                    <p class="mt-3 text-xs font-semibold text-slate-800">
                                        Project
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                        Diskusikan kebutuhan pekerjaan.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </section>

            @endif

        </div>
    </div>


    {{-- =============================================================
         Search Script
    ============================================================= --}}
    @if ($totalConversations)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('conversation-search');
                const list = document.getElementById('conversation-list');
                const emptyState = document.getElementById('conversation-search-empty');

                if (!searchInput || !list) {
                    return;
                }

                const items = Array.from(
                    list.querySelectorAll('[data-conversation]')
                );

                function filterConversations() {
                    const query = searchInput.value
                        .trim()
                        .toLowerCase();

                    let visibleCount = 0;

                    items.forEach(function (item) {
                        const searchText = (
                            item.dataset.search || ''
                        ).toLowerCase();

                        const matched = !query || searchText.includes(query);

                        item.classList.toggle('hidden', !matched);

                        if (matched) {
                            visibleCount++;
                        }
                    });

                    if (emptyState) {
                        emptyState.classList.toggle(
                            'hidden',
                            visibleCount !== 0
                        );
                    }
                }

                searchInput.addEventListener(
                    'input',
                    filterConversations
                );
            });
        </script>
    @endif

</x-layouts.freelancer>
