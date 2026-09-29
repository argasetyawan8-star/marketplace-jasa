
<x-layouts.marketplace>

    @php
        $conversation->loadMissing([
            'client',
            'service',
            'job',
            'job.category',
            'job.subcategory',
            'jobProposal',
            'messages.sender',
            'offers',
            'order.items',
        ]);

        $client = $conversation->client;
        $clientName = $client?->name ?? 'Client';
        $clientInitial = strtoupper(substr(trim($clientName), 0, 1));

        /*
        |--------------------------------------------------------------------------
        | Client Avatar
        |--------------------------------------------------------------------------
        */
        $clientAvatar = null;

        if ($client?->avatar) {
            $clientAvatar = asset('storage/' . $client->avatar);
        } elseif ($client?->profile_photo_url) {
            $clientAvatar = $client->profile_photo_url;
        } elseif ($client?->avatar_url) {
            $clientAvatar = $client->avatar_url;
        }

        /*
        |--------------------------------------------------------------------------
        | Conversation Context
        |--------------------------------------------------------------------------
        */
        $headerTitle = $conversation->service?->title
            ?? $conversation->job?->title
            ?? 'Percakapan umum';

        $headerType = $conversation->job
            ? 'Job Board'
            : ($conversation->service ? 'Jasa' : 'Percakapan umum');

        /*
        |--------------------------------------------------------------------------
        | Messages + Offers
        |--------------------------------------------------------------------------
        */
        $messages = $conversation->messages
            ->sortBy('created_at')
            ->values();

        $offers = $conversation->offers
            ? $conversation->offers->sortBy('created_at')->values()
            : collect();

        /*
        |--------------------------------------------------------------------------
        | Timeline
        |
        | Message type "offer" tidak ditampilkan sebagai message terpisah.
        | Offer dirender dari collection offers agar tidak double.
        |--------------------------------------------------------------------------
        */
        $timeline = collect();

        foreach ($messages as $message) {
            if ($message->type !== 'offer') {
                $timeline->push([
                    'kind' => 'message',
                    'item' => $message,
                    'time' => $message->created_at,
                ]);
            }
        }

        foreach ($offers as $offer) {
            $timeline->push([
                'kind' => 'offer',
                'item' => $offer,
                'time' => $offer->created_at,
            ]);
        }

        $timeline = $timeline
            ->sortBy(fn ($item) => $item['time'])
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Date Helpers
        |--------------------------------------------------------------------------
        */
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $days = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        /*
        |--------------------------------------------------------------------------
        | Offer Status
        |--------------------------------------------------------------------------
        */
        $offerStatusMap = [
            'sent' => [
                'label' => 'Menunggu respon',
                'class' => 'bg-blue-50 text-blue-700',
            ],
            'accepted' => [
                'label' => 'Diterima',
                'class' => 'bg-green-50 text-green-700',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'class' => 'bg-red-50 text-red-600',
            ],
            'expired' => [
                'label' => 'Kedaluwarsa',
                'class' => 'bg-slate-100 text-slate-500',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Offer Create URL
        |--------------------------------------------------------------------------
        */
        $offerCreateUrl = null;

        if ($conversation->job && $conversation->jobProposal) {
            $offerCreateUrl = route(
                'freelancer.jobs.proposals.offer.create',
                [
                    $conversation->job,
                    $conversation->jobProposal,
                ]
            );
        } elseif ($conversation->service) {
            $offerCreateUrl = route(
                'freelancer.messages.offers.create',
                $conversation
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Related Order Status
        |--------------------------------------------------------------------------
        */
        $orderStatus = [
            'pending_payment' => [
                'label' => 'Menunggu pembayaran',
                'class' => 'bg-amber-50 text-amber-700',
            ],
            'paid' => [
                'label' => 'Sudah dibayar',
                'class' => 'bg-green-50 text-green-700',
            ],
            'in_progress' => [
                'label' => 'Sedang dikerjakan',
                'class' => 'bg-blue-50 text-blue-700',
            ],
            'delivered' => [
                'label' => 'Menunggu client',
                'class' => 'bg-amber-50 text-amber-700',
            ],
            'revision' => [
                'label' => 'Revisi diperlukan',
                'class' => 'bg-amber-50 text-amber-700',
            ],
            'completed' => [
                'label' => 'Selesai',
                'class' => 'bg-green-50 text-green-700',
            ],
            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-red-50 text-red-600',
            ],
        ];

        $currentOrderStatus = null;

        if ($conversation->order) {
            $currentOrderStatus =
                $orderStatus[$conversation->order->status]
                ?? [
                    'label' => ucfirst(
                        str_replace(
                            '_',
                            ' ',
                            $conversation->order->status
                        )
                    ),
                    'class' => 'bg-slate-100 text-slate-600',
                ];
        }
    @endphp


    <style>
        /* =========================================================
         * PROKERJA CHAT
         * ========================================================= */

        body:has(#prokerja-chat-page) {
            overflow: hidden;
        }

        body:has(#prokerja-chat-page) main {
            padding-bottom: 0 !important;
        }

        body:has(#prokerja-chat-page) footer {
            display: none !important;
        }

        #prokerja-chat-page {
            height: calc(100dvh - 68px);
            min-height: 0;
            background: #eef2f7;
        }

        #prokerja-chat-shell {
            height: 100%;
            width: 100%;
            max-width: 1500px;
            margin: 0 auto;
        }

        #prokerja-chat-card {
            display: flex;
            height: 100%;
            min-height: 0;
            overflow: hidden;
            border: 1px solid #dce3eb;
            background: #fff;
            box-shadow: 0 8px 35px rgba(15, 23, 42, .08);
        }

        #prokerja-message-area {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        #prokerja-message-area::-webkit-scrollbar {
            width: 6px;
        }

        #prokerja-message-area::-webkit-scrollbar-track {
            background: transparent;
        }

        #prokerja-message-area::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        .prokerja-chat-scroll {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .prokerja-chat-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .prokerja-chat-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .prokerja-chat-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        .prokerja-message-bubble {
            width: fit-content;
            max-width: min(680px, 88%);
        }

        .prokerja-message-bubble img {
            max-height: 420px;
        }

        .prokerja-voice-range {
            accent-color: #2563eb;
        }

        .prokerja-wave-bar {
            width: 3px;
            border-radius: 999px;
            background: #94a3b8;
            transition: background-color .15s ease;
        }

        .prokerja-voice-wrap.is-playing .prokerja-wave-bar {
            background: #2563eb;
        }

        .prokerja-attachment-preview {
            animation: prokerjaAttachmentIn .18s ease-out;
        }

        @keyframes prokerjaAttachmentIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .prokerja-send-button {
            transition:
                transform .15s ease,
                background-color .2s ease,
                box-shadow .2s ease;
        }

        .prokerja-send-button:hover {
            transform: translateY(-1px);
        }

        .prokerja-send-button:active {
            transform: translateY(0);
        }

        @media (max-width: 1023px) {
            #prokerja-chat-page {
                position: fixed;
                top: 68px;
                right: 0;
                bottom: 78px;
                left: 0;
                height: auto;
                z-index: 30;
            }

            #prokerja-chat-shell,
            #prokerja-chat-card {
                height: 100%;
            }
        }

        @media (max-width: 639px) {
            #prokerja-message-area {
                padding: 12px 10px 14px;
            }

            .prokerja-message-bubble {
                max-width: 92%;
            }

            #prokerja-chat-composer {
                padding:
                    10px
                    10px
                    calc(10px + env(safe-area-inset-bottom));
            }
        }
    </style>


    <div id="prokerja-chat-page">

        <div id="prokerja-chat-shell">

            <div id="prokerja-chat-card">

                {{-- =====================================================
                     CHAT PANEL
                ====================================================== --}}
                <section class="flex min-w-0 flex-1 flex-col">

                    {{-- =================================================
                         Header
                    ================================================== --}}
                    <header class="shrink-0 border-b border-slate-200 bg-white">

                        <div class="flex min-h-[68px] items-center gap-3 px-3 py-2.5 sm:px-5">

                            {{-- Back --}}
                            <a
                                href="{{ route('freelancer.messages.index') }}"
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-blue-600"
                                aria-label="Kembali ke pesan"
                            >
                                <i class="bi bi-arrow-left text-sm"></i>
                            </a>


                            {{-- Client Avatar --}}
                            <div class="relative shrink-0">

                                @if ($clientAvatar)
                                    <img
                                        src="{{ $clientAvatar }}"
                                        alt="{{ $clientName }}"
                                        class="h-10 w-10 rounded-full object-cover ring-2 ring-slate-100"
                                    >
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-700 ring-2 ring-slate-100">
                                        {{ $clientInitial }}
                                    </div>
                                @endif

                                <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full border-2 border-white bg-green-500"></span>

                            </div>


                            {{-- Client Info --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex min-w-0 items-center gap-2">

                                    <h1 class="truncate text-sm font-semibold text-slate-900 sm:text-[15px]">
                                        {{ $clientName }}
                                    </h1>

                                    <span class="hidden shrink-0 items-center gap-1 text-[9px] font-medium text-green-600 sm:inline-flex">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                        Percakapan aktif
                                    </span>

                                </div>

                                <p class="mt-0.5 truncate text-[10px] text-slate-500 sm:text-[11px]">
                                    {{ $headerType }}

                                    <span class="mx-1 text-slate-300">
                                        •
                                    </span>

                                    {{ $headerTitle }}
                                </p>

                            </div>


                            {{-- Header Actions --}}
                            <div class="flex shrink-0 items-center gap-1.5">

                                @if ($conversation->service)
                                    <a
                                        href="{{ route('marketplace.service', $conversation->service->slug) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 sm:h-9 sm:w-auto sm:gap-2 sm:px-3"
                                    >
                                        <i class="bi bi-eye text-xs"></i>

                                        <span class="hidden text-[11px] font-semibold sm:inline">
                                            Lihat jasa
                                        </span>
                                    </a>
                                @endif

                                @if ($conversation->job)
                                    <a
                                        href="{{ route('freelancer.jobs.show', $conversation->job) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 sm:h-9 sm:w-auto sm:gap-2 sm:px-3"
                                    >
                                        <i class="bi bi-briefcase text-xs"></i>

                                        <span class="hidden text-[11px] font-semibold sm:inline">
                                            Lihat job
                                        </span>
                                    </a>
                                @endif

                                @if ($offerCreateUrl)
                                    <a
                                        href="{{ $offerCreateUrl }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white transition hover:bg-blue-700 sm:h-9 sm:w-auto sm:gap-2 sm:px-3"
                                    >
                                        <i class="bi bi-file-earmark-text text-xs"></i>

                                        <span class="hidden text-[11px] font-semibold sm:inline">
                                            Kirim penawaran
                                        </span>
                                    </a>
                                @endif

                            </div>

                        </div>

                    </header>


                    {{-- =================================================
                         Flash Messages
                    ================================================== --}}
                    @if (session('success'))
                        <div class="shrink-0 border-b border-green-100 bg-green-50 px-4 py-2.5 sm:px-5">

                            <div class="flex items-center gap-2.5">

                                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white text-green-600">
                                    <i class="bi bi-check-circle text-xs"></i>
                                </div>

                                <p class="text-[11px] leading-5 text-green-700">
                                    {{ session('success') }}
                                </p>

                            </div>

                        </div>
                    @endif


                    @if (session('error'))
                        <div class="shrink-0 border-b border-red-100 bg-red-50 px-4 py-2.5 sm:px-5">

                            <div class="flex items-center gap-2.5">

                                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white text-red-600">
                                    <i class="bi bi-exclamation-circle text-xs"></i>
                                </div>

                                <p class="text-[11px] leading-5 text-red-700">
                                    {{ session('error') }}
                                </p>

                            </div>

                        </div>
                    @endif


                    {{-- =================================================
                         Context — Order / Job
                    ================================================== --}}
                    @if ($conversation->order || $conversation->job)

                        <div class="shrink-0 border-b border-slate-200 bg-white">

                            @if ($conversation->order)

                                <div class="bg-slate-50 px-4 py-3 sm:px-5">

                                    <div class="flex flex-wrap items-center justify-between gap-3">

                                        <div class="flex min-w-0 items-center gap-2.5">

                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                                <i class="bi bi-briefcase text-xs"></i>
                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-[8px] font-bold uppercase tracking-[0.15em] text-slate-400">
                                                    Order terkait
                                                </p>

                                                <p class="mt-0.5 truncate text-[11px] font-semibold text-slate-800">
                                                    {{ $conversation->order->order_number }}
                                                </p>

                                            </div>

                                        </div>


                                        <div class="flex flex-wrap items-center gap-2">

                                            <span
                                                class="rounded-full px-2.5 py-1 text-[9px] font-semibold {{ $currentOrderStatus['class'] }}"
                                            >
                                                {{ $currentOrderStatus['label'] }}
                                            </span>

                                            <a
                                                href="{{ route('freelancer.orders.show', $conversation->order) }}"
                                                class="inline-flex h-7 items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 text-[9px] font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                            >
                                                Lihat order

                                                <i class="bi bi-arrow-right text-[8px]"></i>
                                            </a>

                                        </div>

                                    </div>

                                    <p class="mt-1 ml-10 truncate text-[9px] text-slate-400">
                                        {{ $conversation->order->items->first()?->service_title ?? 'Pesanan jasa' }}
                                    </p>

                                </div>

                            @endif


                            @if ($conversation->job)

                                <div class="bg-white px-4 py-3 sm:px-5">

                                    <div class="flex items-start gap-2.5">

                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                            <i class="bi bi-kanban text-xs"></i>
                                        </div>

                                        <div class="min-w-0">

                                            <p class="text-[8px] font-bold uppercase tracking-[0.15em] text-slate-400">
                                                Job Board
                                            </p>

                                            <p class="mt-0.5 truncate text-xs font-semibold text-slate-800">
                                                {{ $conversation->job->title }}
                                            </p>

                                            <div class="mt-0.5 flex flex-wrap items-center gap-x-2 text-[9px] text-slate-400">

                                                @if ($conversation->job->category)
                                                    <span>
                                                        {{ $conversation->job->category->name }}
                                                    </span>
                                                @endif

                                                @if ($conversation->job->subcategory)
                                                    <span class="text-slate-300">
                                                        •
                                                    </span>

                                                    <span>
                                                        {{ $conversation->job->subcategory->name }}
                                                    </span>
                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endif

                        </div>

                    @endif


                    {{-- =================================================
                         Message Area
                    ================================================== --}}
                    <div
                        id="prokerja-message-area"
                        class="prokerja-chat-scroll min-h-0 flex-1 overflow-y-auto bg-[#F1F5F9] px-3 py-4 sm:px-6 sm:py-5"
                    >

                        <div
                            id="prokerja-message-content"
                            class="mx-auto w-full max-w-4xl pb-3"
                        >

                            {{-- Intro --}}
                            <div class="mb-5 flex justify-center">

                                <div class="max-w-md rounded-2xl border border-slate-200 bg-white px-4 py-3 text-center shadow-sm">

                                    <div class="mx-auto flex h-8 w-8 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                        <i class="bi bi-shield-check text-xs"></i>
                                    </div>

                                    <p class="mt-2 text-[11px] font-semibold text-slate-700">
                                        ProKerja
                                    </p>

                                    <p class="mt-1 text-[10px] leading-5 text-slate-500">
                                        Percakapan ini menghubungkan kamu dengan
                                        {{ $clientName }}.
                                    </p>

                                </div>

                            </div>


                            @if ($timeline->count())

                                @php
                                    $previousDate = null;
                                @endphp

                                @foreach ($timeline as $entry)

                                    @php
                                        $item = $entry['item'];
                                        $kind = $entry['kind'];
                                        $entryTime = $entry['time'];

                                        $dateKey = $entryTime
                                            ? $entryTime->format('Y-m-d')
                                            : null;
                                    @endphp


                                    {{-- Date Separator --}}
                                    @if ($dateKey !== $previousDate)

                                        @php
                                            $previousDate = $dateKey;

                                            if ($entryTime) {
                                                $dayName = $days[$entryTime->dayOfWeek] ?? '';
                                                $dateLabel =
                                                    $dayName . ', ' .
                                                    $entryTime->format('d') . ' ' .
                                                    ($months[(int) $entryTime->format('m')] ?? '') . ' ' .
                                                    $entryTime->format('Y');
                                            } else {
                                                $dateLabel = '';
                                            }
                                        @endphp

                                        @if ($dateLabel)
                                            <div class="my-5 flex items-center gap-3">

                                                <div class="h-px flex-1 bg-slate-200"></div>

                                                <span class="shrink-0 rounded-full border border-slate-200 bg-white px-3 py-1 text-[9px] font-semibold text-slate-400 shadow-sm">
                                                    {{ $dateLabel }}
                                                </span>

                                                <div class="h-px flex-1 bg-slate-200"></div>

                                            </div>
                                        @endif

                                    @endif


                                    {{-- =================================================
                                         MESSAGE
                                    ================================================== --}}
                                    @if ($kind === 'message')

                                        @php
                                            $message = $item;

                                            $isMine = (int) $message->sender_id === (int) auth()->id();

                                            $messageType = $message->type ?? 'text';

                                            $attachmentPath =
                                                $message->attachment_path
                                                ?? $message->file_path
                                                ?? $message->attachment
                                                ?? null;

                                            $attachmentUrl = $attachmentPath
                                                ? asset('storage/' . ltrim($attachmentPath, '/'))
                                                : null;

                                            $attachmentName =
                                                $message->attachment_name
                                                ?? $message->file_name
                                                ?? ($attachmentPath ? basename($attachmentPath) : 'Lampiran');

                                            $attachmentSize = $message->attachment_size ?? null;
                                        @endphp


                                        <div class="mb-3 flex {{ $isMine ? 'justify-end' : 'justify-start' }}">

                                            <div class="prokerja-message-bubble">

                                                {{-- IMAGE --}}
                                                @if (
                                                    $messageType === 'image'
                                                    || (
                                                        $attachmentUrl
                                                        && isset($message->attachment_mime)
                                                        && str_starts_with($message->attachment_mime, 'image/')
                                                    )
                                                )

                                                    <div class="overflow-hidden rounded-2xl border {{ $isMine ? 'border-blue-500 bg-blue-600' : 'border-slate-200 bg-white' }} shadow-sm">

                                                        <a
                                                            href="{{ $attachmentUrl }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="block"
                                                        >
                                                            <img
                                                                src="{{ $attachmentUrl }}"
                                                                alt="{{ $attachmentName }}"
                                                                class="block w-full max-w-[420px] object-cover"
                                                                loading="lazy"
                                                            >
                                                        </a>

                                                        @if ($message->message)
                                                            <div class="whitespace-pre-line break-words px-4 py-2.5 text-[12px] leading-5 {{ $isMine ? 'text-white' : 'text-slate-700' }}">
                                                                {{ $message->message }}
                                                            </div>
                                                        @endif

                                                    </div>


                                                {{-- VOICE --}}
                                                @elseif (
                                                    in_array($messageType, ['voice', 'voice_note', 'audio'])
                                                    && $attachmentUrl
                                                )

                                                    <div
                                                        class="prokerja-voice-wrap rounded-2xl border {{ $isMine ? 'border-blue-500 bg-blue-600' : 'border-slate-200 bg-white' }} px-3.5 py-3 shadow-sm"
                                                    >

                                                        <audio
                                                            class="prokerja-audio hidden"
                                                            preload="metadata"
                                                            src="{{ $attachmentUrl }}"
                                                        ></audio>

                                                        <div class="flex min-w-[230px] max-w-[340px] items-center gap-3">

                                                            <button
                                                                type="button"
                                                                class="prokerja-audio-button flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $isMine ? 'bg-white/15 text-white hover:bg-white/20' : 'bg-blue-50 text-blue-600 hover:bg-blue-100' }} transition"
                                                                aria-label="Putar voice note"
                                                            >
                                                                <i class="bi bi-play-fill text-sm"></i>
                                                            </button>


                                                            <div class="min-w-0 flex-1">

                                                                <div class="flex h-7 items-center gap-[2px] overflow-hidden">

                                                                    @for ($wave = 0; $wave < 34; $wave++)
                                                                        <span
                                                                            class="prokerja-wave-bar"
                                                                            style="height: {{ rand(25, 100) }}%;"
                                                                        ></span>
                                                                    @endfor

                                                                </div>

                                                                <div class="mt-0.5 flex items-center justify-between text-[9px] {{ $isMine ? 'text-blue-100' : 'text-slate-400' }}">

                                                                    <span class="prokerja-audio-current">
                                                                        0:00
                                                                    </span>

                                                                    <span class="prokerja-audio-duration">
                                                                        0:00
                                                                    </span>

                                                                </div>

                                                            </div>

                                                        </div>


                                                        @if ($message->message)
                                                            <p class="mt-2 whitespace-pre-line break-words text-[11px] leading-5 {{ $isMine ? 'text-white' : 'text-slate-600' }}">
                                                                {{ $message->message }}
                                                            </p>
                                                        @endif

                                                    </div>


                                                {{-- FILE --}}
                                                @elseif ($attachmentUrl)

                                                    <div class="rounded-2xl border {{ $isMine ? 'border-blue-500 bg-blue-600' : 'border-slate-200 bg-white' }} p-3 shadow-sm">

                                                        <div class="flex items-center gap-3">

                                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $isMine ? 'bg-white/15 text-white' : 'bg-blue-50 text-blue-600' }}">
                                                                <i class="bi bi-file-earmark text-base"></i>
                                                            </div>

                                                            <div class="min-w-0 flex-1">

                                                                <p class="truncate text-xs font-semibold {{ $isMine ? 'text-white' : 'text-slate-700' }}">
                                                                    {{ $attachmentName }}
                                                                </p>

                                                                @if ($attachmentSize)
                                                                    <p class="mt-0.5 text-[9px] {{ $isMine ? 'text-blue-100' : 'text-slate-400' }}">
                                                                        {{ number_format($attachmentSize / 1024, 1) }} KB
                                                                    </p>
                                                                @else
                                                                    <p class="mt-0.5 text-[9px] {{ $isMine ? 'text-blue-100' : 'text-slate-400' }}">
                                                                        Lampiran
                                                                    </p>
                                                                @endif

                                                            </div>

                                                            <a
                                                                href="{{ $attachmentUrl }}"
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $isMine ? 'bg-white/15 text-white hover:bg-white/20' : 'bg-slate-100 text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}"
                                                                aria-label="Buka lampiran"
                                                            >
                                                                <i class="bi bi-download text-xs"></i>
                                                            </a>

                                                        </div>


                                                        @if ($message->message)
                                                            <p class="mt-2 whitespace-pre-line break-words text-[11px] leading-5 {{ $isMine ? 'text-white' : 'text-slate-600' }}">
                                                                {{ $message->message }}
                                                            </p>
                                                        @endif

                                                    </div>


                                                {{-- TEXT --}}
                                                @else

                                                    <div
                                                        class="rounded-2xl px-3.5 py-2.5 text-[13px] leading-5 shadow-sm {{ $isMine
                                                            ? 'rounded-br-md bg-blue-600 text-white'
                                                            : 'rounded-bl-md border border-slate-200 bg-white text-slate-700' }}"
                                                    >
                                                        <div class="whitespace-pre-line break-words">
                                                            {{ $message->message }}
                                                        </div>
                                                    </div>

                                                @endif


                                                {{-- Time --}}
                                                <div class="mt-1 flex items-center gap-1 {{ $isMine ? 'justify-end' : 'justify-start' }}">

                                                    <span class="text-[9px] text-slate-400">
                                                        {{ $message->created_at?->format('H:i') }}
                                                    </span>

                                                    @if ($isMine)
                                                        <i class="bi bi-check2-all text-[10px] text-blue-500"></i>
                                                    @endif

                                                </div>

                                            </div>

                                        </div>


                                    {{-- =================================================
                                         OFFER
                                    ================================================== --}}
                                    @elseif ($kind === 'offer')

                                        @php
                                            $offer = $item;

                                            $status = $offerStatusMap[$offer->status]
                                                ?? [
                                                    'label' => ucfirst($offer->status ?? 'Status'),
                                                    'class' => 'bg-slate-100 text-slate-500',
                                                ];
                                        @endphp


                                        <div class="mb-4 flex justify-end">

                                            <div class="w-full max-w-[680px]">

                                                <div class="overflow-hidden rounded-3xl border border-blue-100 bg-white shadow-sm">

                                                    {{-- Offer Header --}}
                                                    <div class="border-b border-blue-100 bg-blue-50/70 px-4 py-4 sm:px-5">

                                                        <div class="flex items-start justify-between gap-3">

                                                            <div class="min-w-0">

                                                                <div class="inline-flex items-center gap-1.5 text-[9px] font-bold uppercase tracking-[0.1em] text-blue-700">

                                                                    <i class="bi bi-file-earmark-text text-sm"></i>

                                                                    Penawaran jasa

                                                                </div>

                                                                <h3 class="mt-1.5 text-sm font-bold leading-5 text-slate-900">
                                                                    {{ $offer->title }}
                                                                </h3>

                                                            </div>

                                                            <span class="shrink-0 rounded-full px-2.5 py-1 text-[9px] font-semibold {{ $status['class'] }}">
                                                                {{ $status['label'] }}
                                                            </span>

                                                        </div>

                                                    </div>


                                                    {{-- Offer Body --}}
                                                    <div class="p-4 sm:p-5">

                                                        @if ($offer->description)

                                                            <p class="whitespace-pre-line text-[12px] leading-5 text-slate-600">
                                                                {{ $offer->description }}
                                                            </p>

                                                        @endif


                                                        <div class="mt-4 grid gap-2 sm:grid-cols-3">

                                                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-3">

                                                                <p class="text-[9px] text-slate-400">
                                                                    Harga
                                                                </p>

                                                                <p class="mt-1 text-sm font-bold text-slate-900">
                                                                    Rp {{ number_format((float) $offer->price, 0, ',', '.') }}
                                                                </p>

                                                            </div>


                                                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-3">

                                                                <p class="text-[9px] text-slate-400">
                                                                    Pengerjaan
                                                                </p>

                                                                <p class="mt-1 text-sm font-bold text-slate-900">
                                                                    {{ $offer->delivery_days }}
                                                                    hari
                                                                </p>

                                                            </div>


                                                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-3">

                                                                <p class="text-[9px] text-slate-400">
                                                                    Revisi
                                                                </p>

                                                                <p class="mt-1 text-sm font-bold text-slate-900">
                                                                    {{ $offer->revision_count }}
                                                                    kali
                                                                </p>

                                                            </div>

                                                        </div>


                                                        @if ($offer->expires_at)

                                                            <div class="mt-4 flex items-center gap-2 text-[10px] text-slate-400">

                                                                <i class="bi bi-calendar3"></i>

                                                                <span>
                                                                    Berlaku sampai
                                                                    {{ $offer->expires_at->format('d M Y H:i') }}
                                                                </span>

                                                            </div>

                                                        @endif

                                                    </div>


                                                    {{-- Offer Footer --}}
                                                    <div class="border-t border-slate-100 bg-slate-50/60 px-4 py-3 sm:px-5">

                                                        <div class="flex items-center gap-2 text-[10px] text-slate-400">

                                                            <i class="bi bi-info-circle text-blue-500"></i>

                                                            <span>
                                                                Penawaran dikirim kepada client melalui ProKerja.
                                                            </span>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    @endif

                                @endforeach

                            @else

                                {{-- Empty --}}
                                <div class="flex min-h-[380px] items-center justify-center">

                                    <div class="text-center">

                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                            <i class="bi bi-chat-dots text-2xl"></i>
                                        </div>

                                        <h2 class="mt-5 text-base font-semibold text-slate-900">
                                            Belum ada pesan
                                        </h2>

                                        <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
                                            Kirim pesan untuk memulai percakapan dengan client.
                                        </p>

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                         Composer
                    ================================================== --}}
                    <div
                        id="prokerja-chat-composer"
                        class="shrink-0 border-t border-slate-200 bg-white p-3 sm:p-4"
                    >

                        <div class="mx-auto w-full max-w-4xl">

                            <div class="mb-2.5 flex items-center justify-between gap-3">

                                <div class="min-w-0">

                                    <p class="text-[11px] font-semibold text-slate-700">
                                        Balas {{ $clientName }}
                                    </p>

                                    <p class="mt-0.5 hidden text-[9px] text-slate-400 sm:block">
                                        Diskusikan kebutuhan project sebelum mengirim quotation.
                                    </p>

                                </div>

                                @if ($offerCreateUrl)

                                    <a
                                        href="{{ $offerCreateUrl }}"
                                        class="inline-flex w-auto shrink-0 items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-[10px] font-semibold text-blue-600 transition hover:bg-blue-50 hover:text-blue-700"
                                    >
                                        <i class="bi bi-file-earmark-text"></i>
                                        <span class="hidden sm:inline">
                                            Kirim quotation
                                        </span>
                                    </a>

                                @endif

                            </div>


                            {{-- Attachment Preview --}}
                            <div
                                id="attachment-preview"
                                class="prokerja-attachment-preview mb-2 hidden"
                            >
                                <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 p-2.5">

                                    <div
                                        id="attachment-preview-icon"
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm"
                                    >
                                        <i class="bi bi-paperclip text-sm"></i>
                                    </div>

                                    <div class="min-w-0 flex-1">

                                        <p
                                            id="attachment-preview-name"
                                            class="truncate text-[10px] font-semibold text-slate-700"
                                        >
                                            Lampiran
                                        </p>

                                        <p
                                            id="attachment-preview-size"
                                            class="mt-0.5 text-[9px] text-slate-400"
                                        >
                                            -
                                        </p>

                                    </div>

                                    <button
                                        id="attachment-remove"
                                        type="button"
                                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-600"
                                    >
                                        <i class="bi bi-x-lg text-[10px]"></i>
                                    </button>

                                </div>
                            </div>


                            {{-- Recording Bar --}}
                            <div
                                id="recording-bar"
                                class="mb-2 hidden items-center gap-3 rounded-xl border border-red-100 bg-red-50 px-3 py-2.5"
                            >

                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                                    <i class="bi bi-mic-fill text-xs"></i>
                                </span>

                                <div class="min-w-0 flex-1">

                                    <p class="text-[10px] font-semibold text-red-700">
                                        Merekam voice note...
                                    </p>

                                    <p
                                        id="recording-time"
                                        class="mt-0.5 text-[9px] text-red-500"
                                    >
                                        0:00
                                    </p>

                                </div>

                                <button
                                    id="recording-stop"
                                    type="button"
                                    class="inline-flex h-8 w-auto shrink-0 items-center gap-1.5 rounded-lg bg-red-600 px-3 text-[10px] font-semibold text-white transition hover:bg-red-700"
                                >
                                    <i class="bi bi-stop-fill"></i>
                                    Stop
                                </button>

                            </div>


                            <form
                                id="chat-form"
                                action="{{ route('freelancer.messages.store', $conversation) }}"
                                method="POST"
                                enctype="multipart/form-data"
                            >
                                @csrf

                                <input
                                    id="chat-file"
                                    type="file"
                                    name="attachment"
                                    class="hidden"
                                >

                                <input
                                    id="chat-image"
                                    type="file"
                                    name="image"
                                    accept="image/*"
                                    class="hidden"
                                >


                                <div class="flex items-end gap-2">

                                    {{-- Attachment --}}
                                    <button
                                        id="chat-attachment-button"
                                        type="button"
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                        title="Lampirkan file"
                                    >
                                        <i class="bi bi-paperclip text-sm"></i>
                                    </button>


                                    {{-- Image --}}
                                    <button
                                        id="chat-image-button"
                                        type="button"
                                        class="hidden h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 sm:flex"
                                        title="Kirim gambar"
                                    >
                                        <i class="bi bi-image text-sm"></i>
                                    </button>


                                    {{-- Textarea --}}
                                    <div class="min-w-0 flex-1">

                                        <textarea
                                            id="chat-message"
                                            name="message"
                                            rows="1"
                                            maxlength="5000"
                                            placeholder="Tulis pesan untuk client..."
                                            class="block max-h-32 min-h-[40px] w-full resize-none overflow-y-auto rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-[12px] leading-5 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-300 focus:bg-white focus:ring-2 focus:ring-blue-100"
                                        ></textarea>

                                    </div>


                                    {{-- Voice --}}
                                    <button
                                        id="voice-button"
                                        type="button"
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                        title="Rekam voice note"
                                    >
                                        <i class="bi bi-mic text-sm"></i>
                                    </button>


                                    {{-- Send --}}
                                    <button
                                        id="send-button"
                                        type="submit"
                                        class="prokerja-send-button flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm hover:bg-blue-700"
                                        title="Kirim pesan"
                                    >
                                        <i class="bi bi-send-fill text-xs"></i>
                                    </button>

                                </div>


                                <p
                                    id="chat-js-error"
                                    class="mt-1.5 hidden text-[10px] text-red-600"
                                ></p>


                                @error('message')
                                    <p class="mt-1.5 text-[10px] text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </form>

                        </div>

                    </div>

                </section>

            </div>

        </div>

    </div>


    {{-- =============================================================
         CHAT JAVASCRIPT
    ============================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const chatArea = document.getElementById('prokerja-message-area');
            const messageInput = document.getElementById('chat-message');
            const chatForm = document.getElementById('chat-form');

            const fileInput = document.getElementById('chat-file');
            const imageInput = document.getElementById('chat-image');

            const fileButton = document.getElementById('chat-attachment-button');
            const imageButton = document.getElementById('chat-image-button');

            const attachmentPreview =
                document.getElementById('attachment-preview');

            const attachmentPreviewName =
                document.getElementById('attachment-preview-name');

            const attachmentPreviewSize =
                document.getElementById('attachment-preview-size');

            const attachmentPreviewIcon =
                document.getElementById('attachment-preview-icon');

            const attachmentRemove =
                document.getElementById('attachment-remove');

            const voiceButton =
                document.getElementById('voice-button');

            const recordingBar =
                document.getElementById('recording-bar');

            const recordingStop =
                document.getElementById('recording-stop');

            const recordingTime =
                document.getElementById('recording-time');

            const jsError =
                document.getElementById('chat-js-error');


            /* =========================================================
             * Scroll Bottom
             * ========================================================= */

            function scrollToBottom() {
                if (!chatArea) {
                    return;
                }

                requestAnimationFrame(function () {
                    chatArea.scrollTop = chatArea.scrollHeight;
                });
            }

            scrollToBottom();


            /* =========================================================
             * Auto Resize
             * ========================================================= */

            function resizeTextarea() {
                if (!messageInput) {
                    return;
                }

                messageInput.style.height = 'auto';

                const maxHeight = 128;
                const newHeight = Math.min(
                    messageInput.scrollHeight,
                    maxHeight
                );

                messageInput.style.height = newHeight + 'px';
            }

            if (messageInput) {
                messageInput.addEventListener(
                    'input',
                    resizeTextarea
                );

                resizeTextarea();
            }


            /* =========================================================
             * Enter To Send
             * ========================================================= */

            if (messageInput && chatForm) {

                messageInput.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Enter'
                            && !event.shiftKey
                            && !event.isComposing
                        ) {
                            event.preventDefault();

                            if (messageInput.value.trim()) {
                                chatForm.requestSubmit();
                            }
                        }

                    }
                );

            }


            /* =========================================================
             * Attachment
             * ========================================================= */

            function formatFileSize(bytes) {

                if (!bytes) {
                    return '-';
                }

                if (bytes < 1024) {
                    return bytes + ' B';
                }

                if (bytes < 1024 * 1024) {
                    return (bytes / 1024).toFixed(1) + ' KB';
                }

                return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
            }


            function showAttachmentPreview(file) {

                if (
                    !file
                    || !attachmentPreview
                ) {
                    return;
                }

                attachmentPreviewName.textContent =
                    file.name;

                attachmentPreviewSize.textContent =
                    formatFileSize(file.size);

                const isImage =
                    file.type &&
                    file.type.startsWith('image/');

                attachmentPreviewIcon.innerHTML =
                    isImage
                        ? '<i class="bi bi-image text-sm"></i>'
                        : '<i class="bi bi-file-earmark text-sm"></i>';

                attachmentPreview.classList.remove('hidden');
                attachmentPreview.classList.add('block');
            }


            function clearAttachments() {

                if (fileInput) {
                    fileInput.value = '';
                }

                if (imageInput) {
                    imageInput.value = '';
                }

                if (attachmentPreview) {
                    attachmentPreview.classList.add('hidden');
                    attachmentPreview.classList.remove('block');
                }

            }


            if (fileButton && fileInput) {
                fileButton.addEventListener(
                    'click',
                    function () {
                        fileInput.click();
                    }
                );

                fileInput.addEventListener(
                    'change',
                    function () {

                        if (fileInput.files.length) {
                            showAttachmentPreview(
                                fileInput.files[0]
                            );
                        }

                    }
                );
            }


            if (imageButton && imageInput) {
                imageButton.addEventListener(
                    'click',
                    function () {
                        imageInput.click();
                    }
                );

                imageInput.addEventListener(
                    'change',
                    function () {

                        if (imageInput.files.length) {
                            showAttachmentPreview(
                                imageInput.files[0]
                            );
                        }

                    }
                );
            }


            if (attachmentRemove) {
                attachmentRemove.addEventListener(
                    'click',
                    clearAttachments
                );
            }


            /* =========================================================
             * Voice Recorder
             * ========================================================= */

            let mediaRecorder = null;
            let recordedChunks = [];
            let recordingTimer = null;
            let recordingSeconds = 0;
            let recordingStream = null;


            function formatTime(seconds) {

                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);

                return (
                    mins +
                    ':' +
                    String(secs).padStart(2, '0')
                );
            }


            function showError(message) {

                if (!jsError) {
                    return;
                }

                jsError.textContent = message;
                jsError.classList.remove('hidden');
            }


            function clearError() {

                if (!jsError) {
                    return;
                }

                jsError.textContent = '';
                jsError.classList.add('hidden');
            }


            function stopTracks() {

                if (recordingStream) {

                    recordingStream
                        .getTracks()
                        .forEach(function (track) {
                            track.stop();
                        });

                    recordingStream = null;
                }

            }


            function stopRecording() {

                if (
                    mediaRecorder
                    && mediaRecorder.state !== 'inactive'
                ) {
                    mediaRecorder.stop();
                }

                clearInterval(recordingTimer);
                recordingTimer = null;

                if (recordingBar) {
                    recordingBar.classList.add('hidden');
                    recordingBar.classList.remove('flex');
                }

                if (voiceButton) {
                    voiceButton.classList.remove(
                        'bg-red-50',
                        'text-red-600',
                        'border-red-200'
                    );
                }

            }


            if (voiceButton) {

                voiceButton.addEventListener(
                    'click',
                    async function () {

                        clearError();

                        if (
                            mediaRecorder
                            && mediaRecorder.state !== 'inactive'
                        ) {
                            stopRecording();
                            return;
                        }

                        if (
                            !navigator.mediaDevices
                            || !navigator.mediaDevices.getUserMedia
                        ) {
                            showError(
                                'Browser tidak mendukung perekaman suara.'
                            );

                            return;
                        }

                        try {

                            recordingStream =
                                await navigator.mediaDevices.getUserMedia({
                                    audio: true
                                });

                            recordedChunks = [];

                            let mimeType = '';

                            if (
                                MediaRecorder.isTypeSupported(
                                    'audio/webm;codecs=opus'
                                )
                            ) {
                                mimeType =
                                    'audio/webm;codecs=opus';
                            } else if (
                                MediaRecorder.isTypeSupported(
                                    'audio/webm'
                                )
                            ) {
                                mimeType = 'audio/webm';
                            }

                            mediaRecorder = mimeType
                                ? new MediaRecorder(
                                    recordingStream,
                                    { mimeType }
                                )
                                : new MediaRecorder(
                                    recordingStream
                                );

                            mediaRecorder.addEventListener(
                                'dataavailable',
                                function (event) {

                                    if (event.data.size > 0) {
                                        recordedChunks.push(
                                            event.data
                                        );
                                    }

                                }
                            );


                            mediaRecorder.addEventListener(
                                'stop',
                                function () {

                                    stopTracks();

                                    if (!recordedChunks.length) {
                                        return;
                                    }

                                    const blob =
                                        new Blob(
                                            recordedChunks,
                                            {
                                                type:
                                                    mediaRecorder.mimeType
                                                    || 'audio/webm'
                                            }
                                        );

                                    const maxSize =
                                        10 * 1024 * 1024;

                                    if (blob.size > maxSize) {

                                        showError(
                                            'Voice note terlalu besar. Maksimal 10MB.'
                                        );

                                        return;
                                    }

                                    const file =
                                        new File(
                                            [blob],
                                            'voice-note-' +
                                            Date.now() +
                                            '.webm',
                                            {
                                                type:
                                                    blob.type
                                                    || 'audio/webm'
                                            }
                                        );

                                    const dataTransfer =
                                        new DataTransfer();

                                    dataTransfer.items.add(file);

                                    if (fileInput) {
                                        fileInput.files =
                                            dataTransfer.files;
                                    }

                                    if (messageInput) {
                                        messageInput.value =
                                            messageInput.value.trim();
                                    }

                                    showAttachmentPreview(file);

                                    if (chatForm) {
                                        const voiceField =
                                            document.createElement('input');

                                        voiceField.type = 'hidden';
                                        voiceField.name = 'type';
                                        voiceField.value = 'voice_note';
                                        voiceField.id = 'voice-type-field';

                                        const oldField =
                                            document.getElementById(
                                                'voice-type-field'
                                            );

                                        if (oldField) {
                                            oldField.remove();
                                        }

                                        chatForm.appendChild(
                                            voiceField
                                        );

                                        chatForm.requestSubmit();
                                    }

                                }
                            );


                            mediaRecorder.start();

                            recordingSeconds = 0;

                            if (recordingTime) {
                                recordingTime.textContent =
                                    '0:00';
                            }

                            if (recordingBar) {
                                recordingBar.classList.remove('hidden');
                                recordingBar.classList.add('flex');
                            }

                            if (voiceButton) {
                                voiceButton.classList.add(
                                    'border-red-200',
                                    'bg-red-50',
                                    'text-red-600'
                                );
                            }

                            recordingTimer =
                                setInterval(
                                    function () {

                                        recordingSeconds++;

                                        if (recordingTime) {
                                            recordingTime.textContent =
                                                formatTime(
                                                    recordingSeconds
                                                );
                                        }

                                        if (
                                            recordingSeconds >= 300
                                        ) {
                                            stopRecording();
                                        }

                                    },
                                    1000
                                );

                        } catch (error) {

                            stopTracks();

                            showError(
                                'Akses mikrofon ditolak atau tidak tersedia.'
                            );

                        }

                    }
                );

            }


            if (recordingStop) {
                recordingStop.addEventListener(
                    'click',
                    stopRecording
                );
            }


            /* =========================================================
             * Custom Audio Players
             * ========================================================= */

            const voicePlayers =
                document.querySelectorAll(
                    '.prokerja-voice-wrap'
                );

            voicePlayers.forEach(function (wrapper) {

                const audio =
                    wrapper.querySelector(
                        '.prokerja-audio'
                    );

                const button =
                    wrapper.querySelector(
                        '.prokerja-audio-button'
                    );

                const icon =
                    button?.querySelector('i');

                const current =
                    wrapper.querySelector(
                        '.prokerja-audio-current'
                    );

                const duration =
                    wrapper.querySelector(
                        '.prokerja-audio-duration'
                    );


                if (!audio || !button) {
                    return;
                }


                function updateTime() {

                    if (current) {
                        current.textContent =
                            formatTime(
                                audio.currentTime || 0
                            );
                    }

                    if (
                        duration
                        && Number.isFinite(
                            audio.duration
                        )
                    ) {
                        duration.textContent =
                            formatTime(
                                audio.duration
                            );
                    }

                }


                audio.addEventListener(
                    'loadedmetadata',
                    updateTime
                );

                audio.addEventListener(
                    'timeupdate',
                    updateTime
                );


                button.addEventListener(
                    'click',
                    function () {

                        document
                            .querySelectorAll(
                                '.prokerja-audio'
                            )
                            .forEach(function (otherAudio) {

                                if (
                                    otherAudio !== audio
                                    && !otherAudio.paused
                                ) {
                                    otherAudio.pause();
                                }

                            });


                        if (audio.paused) {

                            audio.play();

                            wrapper.classList.add(
                                'is-playing'
                            );

                            if (icon) {
                                icon.className =
                                    'bi bi-pause-fill text-sm';
                            }

                        } else {

                            audio.pause();

                            wrapper.classList.remove(
                                'is-playing'
                            );

                            if (icon) {
                                icon.className =
                                    'bi bi-play-fill text-sm';
                            }

                        }

                    }
                );


                audio.addEventListener(
                    'play',
                    function () {

                        wrapper.classList.add(
                            'is-playing'
                        );

                        if (icon) {
                            icon.className =
                                'bi bi-pause-fill text-sm';
                        }

                    }
                );


                audio.addEventListener(
                    'pause',
                    function () {

                        wrapper.classList.remove(
                            'is-playing'
                        );

                        if (icon) {
                            icon.className =
                                'bi bi-play-fill text-sm';
                        }

                    }
                );


                audio.addEventListener(
                    'ended',
                    function () {

                        wrapper.classList.remove(
                            'is-playing'
                        );

                        if (icon) {
                            icon.className =
                                'bi bi-play-fill text-sm';
                        }

                        if (current) {
                            current.textContent =
                                '0:00';
                        }

                    }
                );

            });


            /* =========================================================
             * Form Submit State
             * ========================================================= */

            if (chatForm) {

                chatForm.addEventListener(
                    'submit',
                    function () {

                        if (
                            mediaRecorder
                            && mediaRecorder.state !== 'inactive'
                        ) {
                            stopRecording();
                        }

                        const sendButton =
                            document.getElementById(
                                'send-button'
                            );

                        if (sendButton) {

                            sendButton.disabled = true;

                            sendButton.classList.add(
                                'opacity-70',
                                'cursor-not-allowed'
                            );

                        }

                    }
                );

            }

        });
    </script>

</x-layouts.marketplace>

