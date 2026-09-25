
@php
    $conversationCount = $conversations->count();

    $totalUnread = 0;

    foreach ($conversations as $conversation) {
        $totalUnread += $conversation->messages
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->count();
    }
@endphp

<x-layouts.marketplace title="Pesan - ProKerja">

    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="mx-auto w-full max-w-7xl px-4 py-5 pb-28 sm:px-6 sm:py-7 lg:px-8 lg:pb-10">

            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}
            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-2 rounded-full bg-[#EFF6FF] px-3 py-1.5 text-xs font-bold text-[#2563EB]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#2563EB]"></span>
                            Komunikasi
                        </span>

                        <span class="text-xs text-slate-400">
                            {{ $conversationCount }} percakapan
                        </span>
                    </div>

                    <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Pesan
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
                        Hubungi freelancer, diskusikan project, dan pantau komunikasi dalam satu tempat.
                    </p>
                </div>

                @if($totalUnread > 0)
                    <div class="inline-flex w-fit items-center gap-2 rounded-xl border border-blue-100 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm">
                        <span class="flex h-7 min-w-7 items-center justify-center rounded-full bg-[#2563EB] px-2 text-xs font-bold text-white">
                            {{ $totalUnread }}
                        </span>

                        pesan belum dibaca
                    </div>
                @endif

            </div>


            {{-- =========================================================
                MESSAGES WORKSPACE
            ========================================================== --}}
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="grid min-h-[650px] grid-cols-1 lg:grid-cols-[340px_minmax(0,1fr)]">

                    {{-- =================================================
                        CONVERSATION LIST
                    ================================================== --}}
                    <aside class="flex min-h-0 flex-col border-b border-slate-200 lg:border-b-0 lg:border-r">

                        {{-- list header --}}
                        <div class="border-b border-slate-100 p-4 sm:p-5">

                            <div class="flex items-center justify-between gap-3">

                                <div>
                                    <p class="text-sm font-bold text-slate-900">
                                        Percakapan
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        Chat dengan freelancer
                                    </p>
                                </div>

                                <span class="text-xs font-semibold text-slate-400">
                                    {{ $conversationCount }}
                                </span>

                            </div>


                            {{-- search --}}
                            <div class="relative mt-4">

                                <svg
                                    class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle cx="11" cy="11" r="7"/>
                                    <path d="m20 20-4-4"/>
                                </svg>

                                <input
                                    id="conversation-search"
                                    type="search"
                                    autocomplete="off"
                                    placeholder="Cari percakapan..."
                                    class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#93B4F8] focus:bg-white focus:ring-2 focus:ring-blue-100"
                                >

                            </div>

                        </div>


                        {{-- conversation list --}}
                        <div
                            id="conversation-list"
                            class="max-h-[570px] overflow-y-auto"
                        >

                            @forelse($conversations as $conversation)

                                @php
                                    $freelancer = $conversation->freelancerProfile?->user;

                                    $freelancerName = $freelancer?->name ?? 'Freelancer';
                                    $freelancerInitial = strtoupper(
                                        substr(trim($freelancerName), 0, 1)
                                    );

                                    $serviceTitle = $conversation->service?->title
                                        ?? 'Percakapan ProKerja';

                                    $lastMessage = $conversation->messages
                                        ->sortByDesc('created_at')
                                        ->first();

                                    $unreadCount = $conversation->messages
                                        ->where('sender_id', '!=', auth()->id())
                                        ->where('is_read', false)
                                        ->count();

                                    $lastMessagePreview = $lastMessage?->message
                                        ?? 'Belum ada pesan.';

                                    $lastMessageTime = $lastMessage?->created_at
                                        ?? $conversation->last_message_at
                                        ?? $conversation->updated_at;

                                    $freelancerAvatar = data_get($freelancer, 'avatar_url')
                                        ?? data_get($freelancer, 'profile_photo_url')
                                        ?? data_get($freelancer, 'avatar')
                                        ?? data_get($conversation->freelancerProfile, 'avatar');

                                    $freelancerAvatarUrl = null;

                                    if ($freelancerAvatar) {
                                        if (
                                            filter_var($freelancerAvatar, FILTER_VALIDATE_URL) ||
                                            str_starts_with($freelancerAvatar, 'data:image/')
                                        ) {
                                            $freelancerAvatarUrl = $freelancerAvatar;
                                        } elseif (str_starts_with($freelancerAvatar, '/')) {
                                            $freelancerAvatarUrl = asset(
                                                ltrim($freelancerAvatar, '/')
                                            );
                                        } elseif (
                                            str_starts_with($freelancerAvatar, 'storage/') ||
                                            str_starts_with($freelancerAvatar, 'uploads/')
                                        ) {
                                            $freelancerAvatarUrl = asset($freelancerAvatar);
                                        } else {
                                            $freelancerAvatarUrl = asset(
                                                'storage/' . ltrim($freelancerAvatar, '/')
                                            );
                                        }
                                    }

                                    $conversationSearchText = strtolower(
                                        $freelancerName . ' ' . $serviceTitle . ' ' . $lastMessagePreview
                                    );
                                @endphp


                                <a
                                    href="{{ route('client.messages.show', $conversation) }}"
                                    data-conversation
                                    data-search="{{ $conversationSearchText }}"
                                    class="group block border-b border-slate-100 px-4 py-4 transition hover:bg-slate-50 sm:px-5"
                                >

                                    <div class="flex items-start gap-3">

                                        {{-- avatar --}}
                                        <div class="relative h-11 w-11 shrink-0 overflow-hidden rounded-full bg-blue-100">

                                            @if($freelancerAvatarUrl)

                                                <img
                                                    src="{{ $freelancerAvatarUrl }}"
                                                    alt="{{ $freelancerName }}"
                                                    class="h-full w-full object-cover"
                                                    loading="lazy"
                                                >

                                            @else

                                                <div class="flex h-full w-full items-center justify-center text-sm font-bold text-blue-700">
                                                    {{ $freelancerInitial }}
                                                </div>

                                            @endif

                                            @if($unreadCount > 0)
                                                <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-[#2563EB]"></span>
                                            @endif

                                        </div>


                                        <div class="min-w-0 flex-1">

                                            <div class="flex items-start justify-between gap-3">

                                                <div class="min-w-0">

                                                    <p class="truncate text-sm font-bold text-slate-900">
                                                        {{ $freelancerName }}
                                                    </p>

                                                    <p class="mt-0.5 truncate text-xs text-slate-400">
                                                        {{ $serviceTitle }}
                                                    </p>

                                                </div>

                                                @if($lastMessageTime)

                                                    <time class="shrink-0 text-[10px] text-slate-400">
                                                        {{ $lastMessageTime->format('H:i') }}
                                                    </time>

                                                @endif

                                            </div>


                                            <div class="mt-2 flex items-center gap-2">

                                                <p
                                                    class="line-clamp-2 min-w-0 flex-1 text-xs leading-5 {{ $unreadCount > 0 ? 'font-semibold text-slate-700' : 'text-slate-500' }}"
                                                >
                                                    {{ $lastMessagePreview }}
                                                </p>

                                                @if($unreadCount > 0)

                                                    <span class="flex h-5 min-w-5 shrink-0 items-center justify-center rounded-full bg-[#2563EB] px-1.5 text-[10px] font-bold text-white">
                                                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </a>

                            @empty

                                <div class="px-6 py-16 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EFF6FF] text-[#2563EB]">

                                        <svg
                                            class="h-7 w-7"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                        >
                                            <path d="M20 11.5a7.5 7.5 0 0 1-8 7.5 8.5 8.5 0 0 1-4.2-1.1L4 19l1.2-3.2A7.4 7.4 0 0 1 4.5 8 7.5 7.5 0 0 1 12 4.5c4.1 0 8 2.4 8 7Z"/>
                                            <path d="M8 10.5h.01M12 10.5h.01M16 10.5h.01"/>
                                        </svg>

                                    </div>

                                    <h2 class="mt-4 text-base font-bold text-slate-900">
                                        Belum ada percakapan
                                    </h2>

                                    <p class="mx-auto mt-1.5 max-w-xs text-sm leading-6 text-slate-500">
                                        Percakapan dengan freelancer akan muncul di sini.
                                    </p>

                                    @if(Route::has('marketplace.search'))
                                        <a
                                            href="{{ route('marketplace.search') }}"
                                            class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#2563EB] px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700"
                                        >
                                            Cari Freelancer
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path d="M5 12h14"/>
                                                <path d="m13 6 6 6-6 6"/>
                                            </svg>
                                        </a>
                                    @endif

                                </div>

                            @endforelse


                            {{-- search empty --}}
                            <div
                                id="conversation-not-found"
                                class="hidden px-6 py-14 text-center"
                            >

                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <circle cx="11" cy="11" r="7"/>
                                        <path d="m20 20-4-4"/>
                                    </svg>

                                </div>

                                <p class="mt-3 text-sm font-semibold text-slate-700">
                                    Percakapan tidak ditemukan
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-400">
                                    Coba gunakan kata kunci lain.
                                </p>

                            </div>

                        </div>

                    </aside>


                    {{-- =================================================
                        RIGHT PREVIEW
                    ================================================== --}}
                    <main class="hidden min-w-0 lg:flex lg:flex-col">

                        {{-- workspace header --}}
                        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5 xl:px-7">

                            <div>

                                <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#2563EB]">
                                    Inbox Client
                                </p>

                                <h2 class="mt-1 text-lg font-bold text-slate-900">
                                    Komunikasi dengan freelancer
                                </h2>

                            </div>

                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">

                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M20 11.5a7.5 7.5 0 0 1-8 7.5 8.5 8.5 0 0 1-4.2-1.1L4 19l1.2-3.2A7.4 7.4 0 0 1 4.5 8 7.5 7.5 0 0 1 12 4.5c4.1 0 8 2.4 8 7Z"/>
                                    <path d="M8 10.5h.01M12 10.5h.01M16 10.5h.01"/>
                                </svg>

                            </div>

                        </div>


                        {{-- empty preview --}}
                        <div class="flex flex-1 items-center justify-center px-8 py-16">

                            <div class="max-w-md text-center">

                                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-[#EFF6FF] text-[#2563EB]">

                                    <svg
                                        class="h-9 w-9"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    >
                                        <path d="M20 11.5a7.5 7.5 0 0 1-8 7.5 8.5 8.5 0 0 1-4.2-1.1L4 19l1.2-3.2A7.4 7.4 0 0 1 4.5 8 7.5 7.5 0 0 1 12 4.5c4.1 0 8 2.4 8 7Z"/>
                                        <path d="M8 10.5h.01M12 10.5h.01M16 10.5h.01"/>
                                    </svg>

                                </div>

                                <h2 class="mt-6 text-xl font-bold tracking-tight text-slate-900">
                                    Pilih percakapan
                                </h2>

                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                    Pilih salah satu percakapan di sebelah kiri untuk mulai melihat pesan dan berdiskusi dengan freelancer.
                                </p>

                            </div>

                        </div>


                        {{-- workspace tips --}}
                        <div class="border-t border-slate-100 bg-slate-50/70 px-6 py-5 xl:px-7">

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 11v5"/>
                                        <path d="M12 8h.01"/>
                                    </svg>

                                </div>

                                <div>

                                    <p class="text-xs font-bold text-slate-700">
                                        Tips komunikasi
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Gunakan pesan untuk menjelaskan kebutuhan, memberikan referensi, dan menyepakati detail project bersama freelancer.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </main>

                </div>

            </section>

        </div>

    </div>


    {{-- =============================================================
        SEARCH SCRIPT
    ============================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('conversation-search');
            const items = Array.from(
                document.querySelectorAll('[data-conversation]')
            );
            const notFound = document.getElementById(
                'conversation-not-found'
            );

            if (!searchInput) {
                return;
            }

            searchInput.addEventListener('input', function () {
                const keyword = this.value
                    .trim()
                    .toLowerCase();

                let visibleCount = 0;

                items.forEach(function (item) {
                    const searchableText =
                        item.dataset.search || '';

                    const visible =
                        keyword === '' ||
                        searchableText.includes(keyword);

                    item.classList.toggle(
                        'hidden',
                        !visible
                    );

                    if (visible) {
                        visibleCount++;
                    }
                });

                if (notFound) {
                    notFound.classList.toggle(
                        'hidden',
                        visibleCount !== 0 || keyword === ''
                    );
                }
            });
        });
    </script>

</x-layouts.marketplace>
