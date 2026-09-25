<x-layouts.marketplace title="Chat - ProKerja">


@php

    $freelancerProfile =
        $conversation->freelancerProfile;

    $freelancerUser =
        $freelancerProfile?->user;

    $freelancerName =
        $freelancerUser?->name
        ?? 'Freelancer';

    $freelancerInitial =
        strtoupper(
            substr(
                $freelancerName,
                0,
                1
            )
        );

    $freelancerAvatar =
        $freelancerProfile?->avatar
            ? asset(
                'storage/' .
                $freelancerProfile->avatar
            )
            : null;

    $service =
        $conversation->service;

    $order =
        $conversation->order;

    $messages =
        $conversation->messages
            ->sortBy('created_at')
            ->values();

    $offers =
        $conversation->offers
            ?->sortBy('created_at')
            ->values()
            ?? collect();

    /*
     * Gabungkan message + quotation
     * menjadi satu timeline.
     *
     * Message type "offer" tidak dirender
     * sebagai message terpisah agar tidak
     * terjadi quotation double.
     */
    $timeline = collect();

    foreach ($messages as $message) {

        if (
            $message->type !== 'offer'
        ) {
            $timeline->push([
                'kind' => 'message',
                'item' => $message,
                'time' =>
                    $message->created_at,
            ]);
        }
    }

    foreach ($offers as $offer) {

        $timeline->push([
            'kind' => 'offer',
            'item' => $offer,
            'time' =>
                $offer->created_at,
        ]);
    }

    $timeline =
        $timeline
            ->sortBy(
                fn ($item) =>
                    $item['time']
            )
            ->values();

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

    $offerStatusMap = [
        'sent' => [
            'label' =>
                'Menunggu respon',

            'class' =>
                'bg-blue-50 text-blue-700',
        ],

        'accepted' => [
            'label' =>
                'Diterima',

            'class' =>
                'bg-green-50 text-green-700',
        ],

        'rejected' => [
            'label' =>
                'Ditolak',

            'class' =>
                'bg-red-50 text-red-600',
        ],

        'expired' => [
            'label' =>
                'Kedaluwarsa',

            'class' =>
                'bg-slate-100 text-slate-500',
        ],
    ];

@endphp


<style>

    /*
     * =========================================================
     * CHAT PAGE
     * =========================================================
     */

    body:has(#prokerja-chat-page) {
        overflow: hidden;
    }

    body:has(#prokerja-chat-page) main {
        padding-bottom: 0 !important;
    }

    body:has(#prokerja-chat-page) footer {
        display: none !important;
    }


    /*
     * Scrollbar.
     */

    .prokerja-chat-scroll::-webkit-scrollbar {
        width: 7px;
    }

    .prokerja-chat-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .prokerja-chat-scroll::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 999px;
    }

    .prokerja-chat-scroll {
        scrollbar-width: thin;
        scrollbar-color: #CBD5E1 transparent;
    }


    /*
     * Voice note range.
     */

    .prokerja-audio-progress {
        accent-color: #2563EB;
    }


    /*
     * Mobile.
     */

    @media (max-width: 767px) {

        #prokerja-chat-page {
            height: calc(100dvh - 68px);
            min-height: 0;
        }

        #prokerja-chat-shell {
            height: calc(100dvh - 68px);
            min-height: 0;
        }

        #prokerja-chat-card {
            height: 100%;
            min-height: 0;
            border-radius: 0;
            border-left: 0;
            border-right: 0;
            box-shadow: none;
        }

        #prokerja-profile-panel {
            display: none;
        }

        #prokerja-chat-panel {
            min-height: 0;
            height: 100%;
        }

        #prokerja-message-area {
            min-height: 0;
        }

    }


    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            scroll-behavior: auto !important;
        }

    }

</style>


<div
    id="prokerja-chat-page"
    class="h-[calc(100dvh-68px)] min-h-0 bg-[#EEF2F7]"
>

    <div
        id="prokerja-chat-shell"
        class="mx-auto h-full w-full max-w-[1500px]"
    >

        <div
            id="prokerja-chat-card"
            class="flex h-full min-h-0 overflow-hidden border border-[#DCE3EB] bg-white shadow-[0_8px_35px_rgba(15,23,42,0.08)]"
        >

            {{-- =====================================================
                LEFT PROFILE PANEL
            ====================================================== --}}

            <aside
                id="prokerja-profile-panel"
                class="hidden w-[310px] shrink-0 flex-col border-r border-[#DCE3EB] bg-white lg:flex"
            >

                {{-- Profile cover --}}
                <div
                    class="relative h-32 shrink-0 overflow-hidden bg-[#EFF6FF]"
                >

                    @if($freelancerProfile?->cover_image)

                        <img
                            src="{{ asset('storage/' . $freelancerProfile->cover_image) }}"
                            alt="Cover {{ $freelancerName }}"
                            class="h-full w-full object-cover"
                        >

                    @else

                        <div class="h-full w-full bg-[#DBEAFE]"></div>

                    @endif

                </div>


                <div class="-mt-10 px-5">

                    {{-- Avatar --}}
                    <a
                        href="{{ route('marketplace.freelancer', $freelancerProfile->username) }}"
                        class="group block w-fit"
                    >

                        @if($freelancerAvatar)

                            <div class="h-20 w-20 overflow-hidden rounded-full border-4 border-white bg-[#EFF6FF] shadow-sm">

                                <img
                                    src="{{ $freelancerAvatar }}"
                                    alt="{{ $freelancerName }}"
                                    class="h-full w-full object-cover transition group-hover:scale-105"
                                >

                            </div>

                        @else

                            <div class="flex h-20 w-20 items-center justify-center rounded-full border-4 border-white bg-[#DBEAFE] text-2xl font-bold text-[#2563EB] shadow-sm">
                                {{ $freelancerInitial }}
                            </div>

                        @endif

                    </a>

                </div>


                {{-- Profile info --}}
                <div class="flex min-h-0 flex-1 flex-col px-5 pb-5 pt-3">

                    <a
                        href="{{ route('marketplace.freelancer', $freelancerProfile->username) }}"
                        class="group"
                    >

                        <div class="flex items-center gap-2">

                            <h2 class="truncate text-base font-bold text-[#0F172A] transition group-hover:text-[#2563EB]">
                                {{ $freelancerName }}
                            </h2>

                            @if($freelancerProfile?->is_verified)

                                <span
                                    class="shrink-0 text-[#2563EB]"
                                    title="Terverifikasi"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.93a.75.75 0 0 0-1.22-.87l-3.236 4.53-1.594-1.594a.75.75 0 0 0-1.06 1.061l2.212 2.212a.75.75 0 0 0 1.14-.095l3.758-5.242Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>

                                </span>

                            @endif

                        </div>

                        <p class="mt-1 text-[10px] text-[#64748B]">
                            {{ '@' . ($freelancerProfile->username ?? 'freelancer') }}
                        </p>

                    </a>


                    @if($freelancerProfile?->headline)

                        <p class="mt-4 text-[11px] leading-5 text-[#64748B]">
                            {{ $freelancerProfile->headline }}
                        </p>

                    @endif


                    <div class="mt-5 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] p-4">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#2563EB]">
                            Sedang dibahas
                        </p>

                        @if($service)

                            <a
                                href="{{ route('marketplace.service', $service->slug) }}"
                                class="mt-2 block"
                            >

                                <p class="line-clamp-3 text-xs font-semibold leading-5 text-[#0F172A] transition hover:text-[#2563EB]">
                                    {{ $service->title }}
                                </p>

                                @if(isset($service->price))

                                    <p class="mt-2 text-[10px] text-[#64748B]">
                                        Mulai dari
                                        <span class="font-semibold text-[#0F172A]">
                                            Rp {{ number_format((float) $service->price, 0, ',', '.') }}
                                        </span>
                                    </p>

                                @endif

                            </a>

                        @else

                            <p class="mt-2 text-xs text-[#64748B]">
                                Belum ada jasa spesifik.
                            </p>

                        @endif

                    </div>


                    <div class="mt-auto pt-5">

                        <a
                            href="{{ route('marketplace.freelancer', $freelancerProfile->username) }}"
                            class="flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] text-[11px] font-semibold text-white transition hover:bg-[#1D4ED8]"
                        >

                            Lihat profil freelancer

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-3.5 w-3.5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>

                        </a>

                    </div>

                </div>

            </aside>


            {{-- =====================================================
                CHAT PANEL
            ====================================================== --}}

            <section
                id="prokerja-chat-panel"
                class="flex min-w-0 flex-1 flex-col bg-white"
            >

                {{-- =================================================
                    CHAT HEADER
                ================================================== --}}

                <header
                    class="z-20 flex h-[68px] shrink-0 items-center gap-2 border-b border-[#DCE3EB] bg-white px-2.5 sm:px-4"
                >

                    {{-- Back --}}
                    <a
                        href="{{ route('client.messages.index') }}"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-[#64748B] transition hover:bg-[#F1F5F9] hover:text-[#2563EB]"
                        aria-label="Kembali"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>

                    </a>


                    {{-- Clickable Profile --}}
                    <a
                        href="{{ route('marketplace.freelancer', $freelancerProfile->username) }}"
                        class="group flex min-w-0 flex-1 items-center gap-2.5"
                    >

                        @if($freelancerAvatar)

                            <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full bg-[#DBEAFE]">

                                <img
                                    src="{{ $freelancerAvatar }}"
                                    alt="{{ $freelancerName }}"
                                    class="h-full w-full object-cover"
                                >

                            </div>

                        @else

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#DBEAFE] text-sm font-bold text-[#2563EB]">
                                {{ $freelancerInitial }}
                            </div>

                        @endif


                        <div class="min-w-0">

                            <div class="flex items-center gap-1.5">

                                <h1 class="truncate text-sm font-semibold text-[#111827] transition group-hover:text-[#2563EB]">
                                    {{ $freelancerName }}
                                </h1>

                                @if($freelancerProfile?->is_verified)

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5 shrink-0 text-[#2563EB]"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.93a.75.75 0 0 0-1.22-.87l-3.236 4.53-1.594-1.594a.75.75 0 0 0-1.06 1.061l2.212 2.212a.75.75 0 0 0 1.14-.095l3.758-5.242Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>

                                @endif

                            </div>

                            <p class="truncate text-[9px] text-[#64748B] sm:text-[10px]">
                                Klik untuk melihat profil freelancer
                            </p>

                        </div>

                    </a>


                    {{-- Header action --}}
                    @if($order)

                        <a
                            href="{{ route('client.orders.show', $order) }}"
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-[#64748B] transition hover:bg-[#F1F5F9] hover:text-[#2563EB]"
                            title="Lihat order"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.75 4.5h10.5A2.25 2.25 0 0 1 19.5 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H6.75a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 6.75 4.5Z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8.25 9h7.5m-7.5 3h7.5m-7.5 3h4"
                                />
                            </svg>

                        </a>

                    @endif

                </header>


                {{-- =================================================
                    FLASH
                ================================================== --}}

                @if(session('success'))

                    <div class="shrink-0 border-b border-[#D1FAE5] bg-[#F0FDF4] px-4 py-2">

                        <p class="text-center text-[10px] font-medium text-[#166534]">
                            {{ session('success') }}
                        </p>

                    </div>

                @endif


                @if(session('error'))

                    <div class="shrink-0 border-b border-red-100 bg-red-50 px-4 py-2">

                        <p class="text-center text-[10px] font-medium text-red-700">
                            {{ session('error') }}
                        </p>

                    </div>

                @endif


                {{-- =================================================
                    MESSAGE AREA
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

                            <div class="max-w-sm rounded-2xl border border-[#DCE6F2] bg-white px-4 py-3 text-center shadow-[0_1px_3px_rgba(15,23,42,0.04)]">

                                <p class="text-[9px] font-semibold text-[#2563EB]">
                                    ProKerja
                                </p>

                                <p class="mt-1 text-[10px] leading-5 text-[#64748B]">
                                    Percakapan ini menghubungkan kamu dengan
                                    {{ $freelancerName }}.
                                </p>

                            </div>

                        </div>


                        @php
                            $lastDateKey = null;
                        @endphp


                        @forelse($timeline as $entry)

                            @php

                                $item =
                                    $entry['item'];

                                $date =
                                    $entry['time'];

                                $date =
                                    $date
                                        ? $date->timezone(
                                            config(
                                                'app.timezone',
                                                'Asia/Jakarta'
                                            )
                                        )
                                        : null;

                                $dateKey =
                                    $date
                                        ? $date->format('Y-m-d')
                                        : null;

                                $dayName =
                                    $date
                                        ? $days[
                                            (int)
                                            $date->format('w')
                                        ]
                                        : '';

                                $monthName =
                                    $date
                                        ? $months[
                                            (int)
                                            $date->format('n')
                                        ]
                                        : '';

                                $fullDate =
                                    $date
                                        ? $dayName .
                                            ', ' .
                                            $date->format('d') .
                                            ' ' .
                                            $monthName .
                                            ' ' .
                                            $date->format('Y')
                                        : '';

                            @endphp


                            {{-- Date separator --}}
                            @if($dateKey !== $lastDateKey)

                                <div class="my-5 flex justify-center">

                                    <span class="rounded-full bg-white px-3 py-1.5 text-[9px] font-semibold text-[#64748B] shadow-sm ring-1 ring-[#E2E8F0]">

                                        {{ $fullDate }}

                                    </span>

                                </div>

                                @php
                                    $lastDateKey =
                                        $dateKey;
                                @endphp

                            @endif


                            {{-- =================================================
                                NORMAL MESSAGE
                            ================================================== --}}

                            @if($entry['kind'] === 'message')

                                @php

                                    $message =
                                        $item;

                                    $isMine =
                                        (int)
                                            $message->sender_id
                                        ===
                                        (int)
                                            auth()->id();

                                    $type =
                                        $message->type
                                        ?? 'text';

                                    $attachmentPath =
                                        $message->attachment_path
                                        ?? null;

                                    $attachmentUrl =
                                        $attachmentPath
                                            ? asset(
                                                'storage/' .
                                                $attachmentPath
                                            )
                                            : null;

                                @endphp


                                <div
                                    class="mb-1.5 flex {{ $isMine ? 'justify-end' : 'justify-start' }}"
                                >

                                    <div class="prokerja-message-content max-w-[88%] sm:max-w-[72%]">

                                        {{-- =============================
                                            IMAGE
                                        ============================== --}}

                                        @if(
                                            $type === 'image'
                                            && $attachmentUrl
                                        )

                                            <div
                                                class="overflow-hidden rounded-2xl {{ $isMine ? 'rounded-br-md' : 'rounded-bl-md' }} bg-white shadow-[0_1px_3px_rgba(15,23,42,0.08)]"
                                            >

                                                <a
                                                    href="{{ $attachmentUrl }}"
                                                    target="_blank"
                                                    class="block"
                                                >

                                                    <img
                                                        src="{{ $attachmentUrl }}"
                                                        alt="{{ $message->attachment_name ?? 'Foto' }}"
                                                        class="max-h-[360px] w-auto max-w-full object-cover"
                                                    >

                                                </a>


                                                @if($message->message)

                                                    <div class="px-3.5 py-2.5">

                                                        <p class="whitespace-pre-line break-words text-[12px] leading-5 text-[#334155]">
                                                            {{ $message->message }}
                                                        </p>

                                                    </div>

                                                @endif

                                            </div>


                                        {{-- =============================
                                            AUDIO / VOICE NOTE — WhatsApp style
                                        ============================== --}}

                                        @elseif(
                                            in_array($type, ['voice', 'voice_note', 'audio'], true)
                                            && $attachmentUrl
                                        )

                                            <div
                                                data-voice-player
                                                class="prokerja-wa-voice max-w-full rounded-2xl {{ $isMine ? 'rounded-br-md bg-[#2563EB]' : 'rounded-bl-md border border-[#E2E8F0] bg-white' }} px-3.5 py-3 shadow-[0_1px_3px_rgba(15,23,42,0.07)]"
                                            >

                                                <div class="flex items-center gap-3">

                                                    <button
                                                        type="button"
                                                        data-audio-button
                                                        data-audio="{{ $attachmentUrl }}"
                                                        aria-label="Putar voice note"
                                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full transition {{ $isMine ? 'bg-white/15 text-white hover:bg-white/25' : 'bg-[#EFF6FF] text-[#2563EB] hover:bg-[#DBEAFE]' }}"
                                                    >
                                                        <svg
                                                            data-play-icon
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4"
                                                            viewBox="0 0 24 24"
                                                            fill="currentColor"
                                                        >
                                                            <path d="M8.5 5.14A2 2 0 0 0 5.5 6.84v10.32a2 2 0 0 0 3 1.7l8.15-5.16a2 2 0 0 0 0-3.4L8.5 5.14Z"/>
                                                        </svg>

                                                        <svg
                                                            data-pause-icon
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="hidden h-4 w-4"
                                                            viewBox="0 0 24 24"
                                                            fill="currentColor"
                                                        >
                                                            <path d="M7 5.75A1.75 1.75 0 0 1 8.75 4h.5A1.75 1.75 0 0 1 11 5.75v12.5A1.75 1.75 0 0 1 9.25 20h-.5A1.75 1.75 0 0 1 7 18.25V5.75Zm6 0A1.75 1.75 0 0 1 14.75 4h.5A1.75 1.75 0 0 1 17 5.75v12.5A1.75 1.75 0 0 1 15.25 20h-.5A1.75 1.75 0 0 1 13 18.25V5.75Z"/>
                                                        </svg>
                                                    </button>

                                                    <div class="min-w-0 flex-1">

                                                        <div class="flex items-center gap-2">
                                                            <div class="prokerja-wa-waveform flex h-6 flex-1 items-center gap-[2px] overflow-hidden" aria-hidden="true">
                                                                @foreach([10,15,8,18,12,20,14,9,17,22,13,19,11,16,8,14,20,12,17,9,15,21,13,18,10,16,8,14,19,11,17,9,15,20,12,18,10,14,8,16,21,11,17,13,19,9,15,12] as $bar)
                                                                    <span class="prokerja-wa-wave-bar {{ $isMine ? 'bg-white/70' : 'bg-[#CBD5E1]' }}" style="height: {{ $bar }}px"></span>
                                                                @endforeach
                                                            </div>

                                                            <span
                                                                data-audio-time
                                                                class="shrink-0 text-[9px] tabular-nums {{ $isMine ? 'text-white/75' : 'text-[#94A3B8]' }}"
                                                            >0:00</span>
                                                        </div>

                                                        <div class="mt-1 flex items-center gap-2">
                                                            <span class="text-[9px] font-medium {{ $isMine ? 'text-white/75' : 'text-[#64748B]' }}">Voice note</span>
                                                        </div>

                                                        <input
                                                            type="range"
                                                            min="0"
                                                            max="100"
                                                            value="0"
                                                            data-audio-progress
                                                            aria-label="Progress voice note"
                                                            class="prokerja-audio-progress absolute h-0 w-0 opacity-0"
                                                        >

                                                    </div>

                                                </div>

                                                @if($message->message)
                                                    <p class="mt-2 whitespace-pre-line break-words text-[11px] leading-5 {{ $isMine ? 'text-white/90' : 'text-[#475569]' }}">
                                                        {{ $message->message }}
                                                    </p>
                                                @endif

                                            </div>


                                        {{-- =============================
                                            FILE
                                        ============================== --}}

                                        @elseif(
                                            $type === 'file'
                                            && $attachmentUrl
                                        )

                                            <div
                                                class="prokerja-message-bubble rounded-2xl {{ $isMine ? 'rounded-br-md bg-[#2563EB]' : 'rounded-bl-md border border-[#E2E8F0] bg-white' }} px-3.5 py-3 shadow-[0_1px_3px_rgba(15,23,42,0.07)]"
                                            >

                                                <a
                                                    href="{{ $attachmentUrl }}"
                                                    target="_blank"
                                                    class="flex items-center gap-3"
                                                >

                                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $isMine ? 'bg-white/15 text-white' : 'bg-[#EFF6FF] text-[#2563EB]' }}">

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="1.7"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M7.5 3.75h7.19c.398 0 .78.158 1.06.44l2.06 2.06c.282.281.44.663.44 1.06v12.94H5.25V3.75H7.5Z"
                                                            />
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M14.25 3.75v3h3"
                                                            />
                                                        </svg>

                                                    </div>


                                                    <div class="min-w-0 flex-1">

                                                        <p
                                                            class="truncate text-[11px] font-semibold {{ $isMine ? 'text-white' : 'text-[#334155]' }}"
                                                        >
                                                            {{ $message->attachment_name ?? 'File' }}
                                                        </p>

                                                        <p
                                                            class="mt-0.5 text-[9px] {{ $isMine ? 'text-white/70' : 'text-[#94A3B8]' }}"
                                                        >
                                                            @if($message->attachment_size)
                                                                {{ number_format($message->attachment_size / 1024, 0, ',', '.') }} KB
                                                            @else
                                                                Buka file
                                                            @endif
                                                        </p>

                                                    </div>


                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 shrink-0 {{ $isMine ? 'text-white/70' : 'text-[#94A3B8]' }}"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M12 4v11m0 0 4-4m-4 4-4-4M5 20h14"
                                                        />
                                                    </svg>

                                                </a>


                                                @if($message->message)

                                                    <p class="mt-2 whitespace-pre-line break-words text-[11px] leading-5 {{ $isMine ? 'text-white/90' : 'text-[#475569]' }}">
                                                        {{ $message->message }}
                                                    </p>

                                                @endif

                                            </div>


                                        {{-- =============================
                                            NORMAL TEXT
                                        ============================== --}}

                                        @else

                                            <div
                                                class="prokerja-message-bubble prokerja-text-bubble rounded-2xl px-3.5 py-2.5 shadow-[0_1px_3px_rgba(15,23,42,0.07)]
                                                {{
                                                    $isMine
                                                        ? 'rounded-br-md bg-[#2563EB] text-white'
                                                        : 'rounded-bl-md border border-[#E2E8F0] bg-white text-[#334155]'
                                                }}"
                                            >

                                                <p class="whitespace-pre-line break-words text-[12px] leading-5 sm:text-[13px] sm:leading-[21px]">
                                                    {{ $message->message }}
                                                </p>

                                            </div>

                                        @endif


                                        {{-- Time --}}
                                        @if($date)

                                            <div
                                                class="mt-1 px-1 text-[9px] {{ $isMine ? 'text-right' : 'text-left' }}"
                                            >

                                                <span class="text-[#94A3B8]">
                                                    {{ $date->format('H:i') }}
                                                </span>

                                            </div>

                                        @endif

                                    </div>

                                </div>


                            {{-- =================================================
                                QUOTATION
                            ================================================== --}}

                            @else

                                @php

                                    $offer =
                                        $item;

                                    $offerStatus =
                                        $offerStatusMap[
                                            $offer->status
                                        ]
                                        ?? [
                                            'label' =>
                                                ucfirst(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $offer->status
                                                    )
                                                ),

                                            'class' =>
                                                'bg-slate-100 text-slate-500',
                                        ];

                                @endphp


                                <div class="my-4 flex justify-start">

                                    <div class="w-full max-w-[520px]">

                                        {{-- Quotation time --}}
                                        <div class="mb-2 flex items-center gap-2">

                                            <div class="h-px flex-1 bg-[#DCE3EB]"></div>

                                            <span class="shrink-0 text-[9px] font-semibold text-[#94A3B8]">

                                                Quotation
                                                ·
                                                {{ $date?->format('d M Y, H:i') }}

                                            </span>

                                            <div class="h-px flex-1 bg-[#DCE3EB]"></div>

                                        </div>


                                        <div class="overflow-hidden rounded-2xl border border-[#CFE0F5] bg-white shadow-[0_3px_12px_rgba(15,23,42,0.05)]">

                                            {{-- Header --}}
                                            <div class="border-b border-[#E5EDF7] bg-[#EFF6FF] px-4 py-4 sm:px-5">

                                                <div class="flex items-start justify-between gap-3">

                                                    <div class="min-w-0">

                                                        <div class="flex items-center gap-2">

                                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-[#2563EB]">

                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-4 w-4"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="1.7"
                                                                >
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M7.5 3.75h7.19c.398 0 .78.158 1.06.44l2.06 2.06c.282.281.44.663.44 1.06v12.94H5.25V3.75H7.5Z"
                                                                    />
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M14.25 3.75v3h3"
                                                                    />
                                                                </svg>

                                                            </div>

                                                            <div>

                                                                <p class="text-[9px] font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                                                                    Penawaran jasa
                                                                </p>

                                                                <p class="mt-0.5 text-[10px] text-[#64748B]">
                                                                    {{ $freelancerName }}
                                                                </p>

                                                            </div>

                                                        </div>

                                                    </div>


                                                    <span class="shrink-0 rounded-full px-2.5 py-1 text-[9px] font-semibold {{ $offerStatus['class'] }}">
                                                        {{ $offerStatus['label'] }}
                                                    </span>

                                                </div>


                                                <h3 class="mt-4 text-sm font-bold leading-5 text-[#0F172A]">
                                                    {{ $offer->title }}
                                                </h3>

                                            </div>


                                            {{-- Body --}}
                                            <div class="px-4 py-4 sm:px-5">

                                                @if($offer->description)

                                                    <p class="whitespace-pre-line text-[11px] leading-5 text-[#64748B]">
                                                        {{ $offer->description }}
                                                    </p>

                                                @endif


                                                <div class="mt-4 grid grid-cols-3 divide-x divide-[#E2E8F0] overflow-hidden rounded-xl border border-[#E2E8F0]">

                                                    <div class="px-2.5 py-3 text-center sm:px-3">

                                                        <p class="text-[8px] uppercase tracking-[0.08em] text-[#94A3B8]">
                                                            Harga
                                                        </p>

                                                        <p class="mt-1 text-xs font-bold text-[#0F172A] sm:text-sm">
                                                            Rp {{ number_format((float) $offer->price, 0, ',', '.') }}
                                                        </p>

                                                    </div>


                                                    <div class="px-2.5 py-3 text-center sm:px-3">

                                                        <p class="text-[8px] uppercase tracking-[0.08em] text-[#94A3B8]">
                                                            Durasi
                                                        </p>

                                                        <p class="mt-1 text-xs font-bold text-[#0F172A] sm:text-sm">
                                                            {{ $offer->delivery_days }} hari
                                                        </p>

                                                    </div>


                                                    <div class="px-2.5 py-3 text-center sm:px-3">

                                                        <p class="text-[8px] uppercase tracking-[0.08em] text-[#94A3B8]">
                                                            Revisi
                                                        </p>

                                                        <p class="mt-1 text-xs font-bold text-[#0F172A] sm:text-sm">
                                                            {{ $offer->revision_count }}x
                                                        </p>

                                                    </div>

                                                </div>


                                                @if($offer->expires_at)

                                                    <p class="mt-3 text-[9px] text-[#94A3B8]">
                                                        Berlaku sampai
                                                        {{ $offer->expires_at->format('d M Y, H:i') }}
                                                    </p>

                                                @endif


                                                {{-- Actions --}}
                                                @if($offer->status === 'sent')

                                                    <div class="mt-4 grid grid-cols-2 gap-2">

                                                        <form
                                                            action="{{ route('client.offers.accept', $offer) }}"
                                                            method="POST"
                                                        >

                                                            @csrf

                                                            <button
                                                                type="submit"
                                                                class="flex h-10 w-full items-center justify-center gap-1.5 rounded-xl bg-[#2563EB] text-[10px] font-semibold text-white transition hover:bg-[#1D4ED8]"
                                                            >

                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3.5 w-3.5"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="2"
                                                                >
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m5 12 4 4L19 6"
                                                                    />
                                                                </svg>

                                                                Terima

                                                            </button>

                                                        </form>


                                                        <form
                                                            action="{{ route('client.offers.reject', $offer) }}"
                                                            method="POST"
                                                        >

                                                            @csrf

                                                            <button
                                                                type="submit"
                                                                class="flex h-10 w-full items-center justify-center gap-1.5 rounded-xl border border-red-200 bg-white text-[10px] font-semibold text-red-600 transition hover:bg-red-50"
                                                            >

                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3.5 w-3.5"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="2"
                                                                >
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M6 6l12 12M18 6 6 18"
                                                                    />
                                                                </svg>

                                                                Tolak

                                                            </button>

                                                        </form>

                                                    </div>

                                                @elseif($offer->status === 'accepted')

                                                    <div class="mt-4 rounded-xl bg-[#F0FDF4] px-3 py-2.5 text-center text-[10px] font-medium text-[#166534]">
                                                        Penawaran sudah diterima.
                                                    </div>

                                                @elseif($offer->status === 'rejected')

                                                    <div class="mt-4 rounded-xl bg-red-50 px-3 py-2.5 text-center text-[10px] font-medium text-red-700">
                                                        Penawaran sudah ditolak.
                                                    </div>

                                                @elseif($offer->status === 'expired')

                                                    <div class="mt-4 rounded-xl bg-slate-50 px-3 py-2.5 text-center text-[10px] font-medium text-slate-500">
                                                        Penawaran sudah kedaluwarsa.
                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endif

                        @empty

                            <div class="flex min-h-[55vh] items-center justify-center">

                                <div class="text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#DBEAFE] text-[#2563EB]">

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M7.5 8.25h9m-9 3.75h5.25m7.5 0c0 4.142-3.694 7.5-8.25 7.5a8.88 8.88 0 0 1-3.71-.8L3.75 19.5l.97-3.235A7.46 7.46 0 0 1 3 11.75c0-4.142 3.694-7.5 8.25-7.5S21 7.608 21 11.75Z"
                                            />
                                        </svg>

                                    </div>

                                    <h2 class="mt-3 text-sm font-semibold text-[#334155]">
                                        Belum ada pesan
                                    </h2>

                                    <p class="mt-1 text-[10px] text-[#94A3B8]">
                                        Kirim pesan untuk memulai percakapan.
                                    </p>

                                </div>

                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- =================================================
                    COMPOSER
                ================================================== --}}

                <div
                    id="prokerja-composer"
                    class="relative z-20 shrink-0 border-t border-[#DCE3EB] bg-white px-2.5 py-2.5 sm:px-4 sm:py-3"
                >

                    {{-- Attachment inputs --}}
                    <input
                        id="chat-file"
                        type="file"
                        name="attachment"
                        form="chat-form"
                        class="hidden"
                        accept=".jpg,.jpeg,.png,.webp,.pdf,.txt,.zip,.rar,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                    >

                    <input
                        id="chat-image"
                        type="file"
                        name="attachment"
                        form="chat-form"
                        class="hidden"
                        accept="image/jpeg,image/png,image/webp"
                    >


                    <form
                        id="chat-form"
                        action="{{ route('client.messages.store', $conversation) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mx-auto max-w-4xl"
                    >

                        @csrf


                        {{-- Selected file --}}
                        <div
                            id="selected-attachment"
                            class="mb-2 hidden rounded-xl border border-[#BFDBFE] bg-[#EFF6FF] px-3 py-2"
                        >

                            <div class="flex items-center justify-between gap-2">

                                <p
                                    id="selected-attachment-name"
                                    class="truncate text-[10px] font-medium text-[#2563EB]"
                                ></p>

                                <button
                                    type="button"
                                    id="remove-attachment"
                                    class="shrink-0 text-[10px] font-semibold text-[#64748B] hover:text-red-500"
                                >
                                    Hapus
                                </button>

                            </div>

                        </div>


                        {{-- Recording state --}}
                        <div
                            id="recording-bar"
                            class="mb-2 hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2"
                        >

                            <div class="flex items-center justify-between gap-3">

                                <div class="flex items-center gap-2">

                                    <span class="relative flex h-2.5 w-2.5">

                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>

                                        <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-red-500"></span>

                                    </span>

                                    <span class="text-[10px] font-semibold text-red-600">
                                        Merekam voice note
                                    </span>

                                </div>

                                <span
                                    id="recording-time"
                                    class="text-[10px] font-semibold tabular-nums text-red-600"
                                >
                                    0:00
                                </span>

                            </div>

                        </div>


                        <div class="flex items-end gap-2">

                            {{-- Attach button --}}
                            <button
                                type="button"
                                id="attachment-button"
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-[#64748B] transition hover:bg-[#F1F5F9] hover:text-[#2563EB]"
                                title="Lampirkan file"
                                aria-label="Lampirkan file"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-[18px] w-[18px]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m16.5 6.75-7.97 7.97a3 3 0 1 0 4.243 4.243l6.192-6.192a5.25 5.25 0 0 0-7.425-7.425L5.6 11.863a7.5 7.5 0 1 0 10.607 10.606l5.48-5.48"
                                    />
                                </svg>

                            </button>


                            {{-- Photo --}}
                            <button
                                type="button"
                                id="image-button"
                                class="hidden h-10 w-10 shrink-0 items-center justify-center rounded-full text-[#64748B] transition hover:bg-[#F1F5F9] hover:text-[#2563EB] sm:flex"
                                title="Kirim foto"
                                aria-label="Kirim foto"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-[18px] w-[18px]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <rect
                                        x="3.75"
                                        y="4.75"
                                        width="16.5"
                                        height="14.5"
                                        rx="2"
                                    />
                                    <circle
                                        cx="8.5"
                                        cy="9"
                                        r="1.25"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m5.5 16 3.5-3.5 2.75 2.75 2-2 4.75 4.75"
                                    />
                                </svg>

                            </button>


                            {{-- Text input --}}
                            <div class="min-w-0 flex-1 rounded-2xl border border-[#D7DEE7] bg-[#F8FAFC] px-3.5 py-2.5 focus-within:border-[#93C5FD] focus-within:bg-white focus-within:ring-2 focus-within:ring-[#DBEAFE]">

                                <textarea
                                    id="chat-input"
                                    name="message"
                                    rows="1"
                                    maxlength="5000"
                                    autocomplete="off"
                                    placeholder="Ketik pesan"
                                    class="block max-h-32 min-h-[24px] w-full resize-none border-0 bg-transparent p-0 text-[12px] leading-5 text-[#111827] outline-none placeholder:text-[#94A3B8] sm:text-[13px]"
                                >{{ old('message') }}</textarea>

                            </div>


                            {{-- Mic --}}
                            <button
                                type="button"
                                id="voice-button"
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-[#64748B] transition hover:bg-[#F1F5F9] hover:text-[#2563EB]"
                                title="Rekam voice note"
                                aria-label="Rekam voice note"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-[18px] w-[18px]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <rect
                                        x="8.25"
                                        y="3.75"
                                        width="7.5"
                                        height="11.5"
                                        rx="3.75"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5.25 11.75a6.75 6.75 0 0 0 13.5 0M12 18.5v2.75m-3 0h6"
                                    />
                                </svg>

                            </button>


                            {{-- Send --}}
                            <button
                                type="submit"
                                id="send-button"
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#2563EB] text-white shadow-sm transition hover:bg-[#1D4ED8] active:scale-95"
                                aria-label="Kirim pesan"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-[17px] w-[17px]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m4 12 16-8-5.5 16-3.25-7L4 12Zm0 0 7.25 1"
                                    />
                                </svg>

                            </button>

                        </div>


                        @error('message')

                            <p class="mt-1.5 px-2 text-[9px] text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                        <p
                            id="chat-error"
                            class="mt-1.5 hidden px-2 text-[9px] text-red-600"
                        ></p>

                    </form>

                </div>

            </section>

        </div>

    </div>

</div>


{{-- ==============================================================
    JAVASCRIPT
=============================================================== --}}

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
             * =====================================================
             * ELEMENTS
             * =====================================================
             */

            const messageArea =
                document.getElementById(
                    'prokerja-message-area'
                );

            const messageContent =
                document.getElementById(
                    'prokerja-message-content'
                );

            const chatForm =
                document.getElementById(
                    'chat-form'
                );

            const chatInput =
                document.getElementById(
                    'chat-input'
                );

            const chatFile =
                document.getElementById(
                    'chat-file'
                );

            const chatImage =
                document.getElementById(
                    'chat-image'
                );

            const attachmentButton =
                document.getElementById(
                    'attachment-button'
                );

            const imageButton =
                document.getElementById(
                    'image-button'
                );

            const selectedAttachment =
                document.getElementById(
                    'selected-attachment'
                );

            const selectedAttachmentName =
                document.getElementById(
                    'selected-attachment-name'
                );

            const removeAttachment =
                document.getElementById(
                    'remove-attachment'
                );

            const voiceButton =
                document.getElementById(
                    'voice-button'
                );

            const recordingBar =
                document.getElementById(
                    'recording-bar'
                );

            const recordingTime =
                document.getElementById(
                    'recording-time'
                );

            const chatError =
                document.getElementById(
                    'chat-error'
                );


            /*
             * =====================================================
             * SCROLL TO BOTTOM
             * =====================================================
             */

            if (messageArea) {

                requestAnimationFrame(
                    function () {

                        messageArea.scrollTop =
                            messageArea.scrollHeight;

                    }
                );

            }


            /*
             * =====================================================
             * TEXTAREA
             * =====================================================
             */

            function resizeTextarea() {

                if (!chatInput) {
                    return;
                }

                chatInput.style.height =
                    '24px';

                chatInput.style.height =
                    Math.min(
                        chatInput.scrollHeight,
                        128
                    ) + 'px';

            }


            if (chatInput) {

                chatInput.addEventListener(
                    'input',
                    resizeTextarea
                );

                resizeTextarea();


                chatInput.addEventListener(
                    'keydown',
                    function (event) {

                        /*
                         * Desktop:
                         * Enter = send
                         * Shift + Enter = new line
                         */
                        if (
                            event.key === 'Enter' &&
                            !event.shiftKey &&
                            window.innerWidth >= 768
                        ) {

                            event.preventDefault();

                            if (
                                chatInput.value.trim() !== ''
                            ) {

                                chatForm.requestSubmit();

                            }

                        }

                    }
                );

            }


            /*
             * =====================================================
             * ATTACHMENT
             * =====================================================
             */

            function clearAttachment() {

                if (chatFile) {
                    chatFile.value = '';
                }

                if (chatImage) {
                    chatImage.value = '';
                }

                if (selectedAttachment) {
                    selectedAttachment.classList.add(
                        'hidden'
                    );
                }

                if (selectedAttachmentName) {
                    selectedAttachmentName.textContent =
                        '';
                }

            }


            function showAttachment(
                file
            ) {

                if (
                    !file ||
                    !selectedAttachment ||
                    !selectedAttachmentName
                ) {
                    return;
                }

                selectedAttachmentName.textContent =
                    file.name;

                selectedAttachment.classList.remove(
                    'hidden'
                );

            }


            if (attachmentButton) {

                attachmentButton.addEventListener(
                    'click',
                    function () {

                        if (chatFile) {
                            chatFile.click();
                        }

                    }
                );

            }


            if (imageButton) {

                imageButton.addEventListener(
                    'click',
                    function () {

                        if (chatImage) {
                            chatImage.click();
                        }

                    }
                );

            }


            if (chatFile) {

                chatFile.addEventListener(
                    'change',
                    function () {

                        if (this.files.length) {

                            if (chatImage) {
                                chatImage.value = '';
                            }

                            showAttachment(
                                this.files[0]
                            );

                        }

                    }
                );

            }


            if (chatImage) {

                chatImage.addEventListener(
                    'change',
                    function () {

                        if (this.files.length) {

                            if (chatFile) {
                                chatFile.value = '';
                            }

                            showAttachment(
                                this.files[0]
                            );

                        }

                    }
                );

            }


            if (removeAttachment) {

                removeAttachment.addEventListener(
                    'click',
                    clearAttachment
                );

            }


            /*
             * =====================================================
             * VOICE NOTE RECORDER
             * =====================================================
             */

            let mediaRecorder =
                null;

            let audioChunks =
                [];

            let recordingStartedAt =
                null;

            let recordingInterval =
                null;


            function formatSeconds(
                seconds
            ) {

                const safe =
                    Math.max(
                        0,
                        Math.floor(seconds)
                    );

                const minutes =
                    Math.floor(
                        safe / 60
                    );

                const remainder =
                    String(
                        safe % 60
                    ).padStart(
                        2,
                        '0'
                    );

                return `${minutes}:${remainder}`;

            }


            function showChatError(
                message
            ) {

                if (!chatError) {
                    return;
                }

                chatError.textContent =
                    message;

                chatError.classList.remove(
                    'hidden'
                );

            }


            function hideChatError() {

                if (!chatError) {
                    return;
                }

                chatError.textContent =
                    '';

                chatError.classList.add(
                    'hidden'
                );

            }


            function setRecordingState(
                recording
            ) {

                if (
                    !voiceButton ||
                    !recordingBar
                ) {
                    return;
                }

                if (recording) {

                    voiceButton.classList.remove(
                        'text-[#64748B]',
                        'hover:bg-[#F1F5F9]',
                        'hover:text-[#2563EB]'
                    );

                    voiceButton.classList.add(
                        'bg-red-50',
                        'text-red-500'
                    );

                    recordingBar.classList.remove(
                        'hidden'
                    );

                } else {

                    voiceButton.classList.remove(
                        'bg-red-50',
                        'text-red-500'
                    );

                    voiceButton.classList.add(
                        'text-[#64748B]',
                        'hover:bg-[#F1F5F9]',
                        'hover:text-[#2563EB]'
                    );

                    recordingBar.classList.add(
                        'hidden'
                    );

                }

            }


            async function startVoiceRecording() {

                hideChatError();

                if (
                    !navigator.mediaDevices ||
                    !navigator.mediaDevices.getUserMedia
                ) {

                    showChatError(
                        'Browser kamu tidak mendukung perekaman suara.'
                    );

                    return;

                }


                try {

                    const stream =
                        await navigator.mediaDevices.getUserMedia(
                            {
                                audio: true
                            }
                        );


                    const preferredTypes = [
                        'audio/webm;codecs=opus',
                        'audio/webm',
                        'audio/ogg;codecs=opus',
                    ];

                    let mimeType =
                        '';

                    for (
                        const candidate
                        of preferredTypes
                    ) {

                        if (
                            window.MediaRecorder &&
                            MediaRecorder.isTypeSupported(
                                candidate
                            )
                        ) {

                            mimeType =
                                candidate;

                            break;

                        }

                    }


                    mediaRecorder =
                        mimeType
                            ? new MediaRecorder(
                                stream,
                                {
                                    mimeType
                                }
                            )
                            : new MediaRecorder(
                                stream
                            );


                    audioChunks =
                        [];

                    recordingStartedAt =
                        Date.now();


                    mediaRecorder.addEventListener(
                        'dataavailable',
                        function (event) {

                            if (
                                event.data &&
                                event.data.size > 0
                            ) {

                                audioChunks.push(
                                    event.data
                                );

                            }

                        }
                    );


                    mediaRecorder.addEventListener(
                        'stop',
                        async function () {

                            clearInterval(
                                recordingInterval
                            );

                            stream
                                .getTracks()
                                .forEach(
                                    track =>
                                        track.stop()
                                );


                            const durationSeconds =
                                Math.min(
                                    300,
                                    Math.round(
                                        (
                                            Date.now() -
                                            recordingStartedAt
                                        ) / 1000
                                    )
                                );


                            const blob =
                                new Blob(
                                    audioChunks,
                                    {
                                        type:
                                            mimeType ||
                                            'audio/webm'
                                    }
                                );


                            if (
                                blob.size >
                                10 * 1024 * 1024
                            ) {

                                setRecordingState(
                                    false
                                );

                                showChatError(
                                    'Voice note terlalu besar. Maksimal 10 MB.'
                                );

                                return;

                            }


                            if (
                                blob.size === 0
                            ) {

                                setRecordingState(
                                    false
                                );

                                showChatError(
                                    'Voice note kosong.'
                                );

                                return;

                            }


                            /*
                             * Buat File dari Blob.
                             */
                            let extension =
                                'webm';

                            if (
                                (mimeType || '')
                                    .includes(
                                        'ogg'
                                    )
                            ) {
                                extension =
                                    'ogg';
                            }


                            const voiceFile =
                                new File(
                                    [
                                        blob
                                    ],
                                    `voice-note-${Date.now()}.${extension}`,
                                    {
                                        type:
                                            blob.type ||
                                            'audio/webm',
                                    }
                                );


                            /*
                             * Tempel file ke form
                             * menggunakan DataTransfer.
                             */
                            const dataTransfer =
                                new DataTransfer();

                            dataTransfer.items.add(
                                voiceFile
                            );


                            /*
                             * Input sementara.
                             */
                            const voiceInput =
                                document.createElement(
                                    'input'
                                );

                            voiceInput.type =
                                'file';

                            voiceInput.name =
                                'voice_note';

                            voiceInput.className =
                                'hidden';

                            voiceInput.files =
                                dataTransfer.files;


                            chatForm.appendChild(
                                voiceInput
                            );


                            /*
                             * Voice note langsung dikirim.
                             */
                            setRecordingState(
                                false
                            );

                            if (recordingTime) {

                                recordingTime.textContent =
                                    formatSeconds(
                                        0
                                    );

                            }


                            chatForm.requestSubmit(
                                document.getElementById(
                                    'send-button'
                                )
                            );


                            /*
                             * durationSeconds tersedia
                             * di sisi client. Backend saat ini
                             * tetap menyimpan file audionya.
                             */
                            void durationSeconds;

                        }
                    );


                    mediaRecorder.start();

                    setRecordingState(
                        true
                    );


                    recordingInterval =
                        setInterval(
                            function () {

                                const seconds =
                                    (
                                        Date.now() -
                                        recordingStartedAt
                                    ) / 1000;

                                if (recordingTime) {

                                    recordingTime.textContent =
                                        formatSeconds(
                                            seconds
                                        );

                                }


                                /*
                                 * Maksimal 5 menit.
                                 */
                                if (
                                    seconds >= 300
                                ) {

                                    stopVoiceRecording();

                                }

                            },
                            200
                        );

                } catch (error) {

                    setRecordingState(
                        false
                    );

                    showChatError(
                        'Microphone tidak dapat digunakan. Pastikan izin microphone diberikan pada browser.'
                    );

                }

            }


            function stopVoiceRecording() {

                if (
                    mediaRecorder &&
                    mediaRecorder.state !== 'inactive'
                ) {

                    mediaRecorder.stop();

                }

            }


            if (voiceButton) {

                voiceButton.addEventListener(
                    'click',
                    function () {

                        if (
                            mediaRecorder &&
                            mediaRecorder.state ===
                                'recording'
                        ) {

                            stopVoiceRecording();

                        } else {

                            startVoiceRecording();

                        }

                    }
                );

            }


            /*
             * =====================================================
             * FORM SUBMIT PROTECTION
             * =====================================================
             */

            if (chatForm) {

                chatForm.addEventListener(
                    'submit',
                    function () {

                        hideChatError();

                    }
                );

            }


            /*
             * =====================================================
             * CUSTOM AUDIO PLAYER
             * =====================================================
             */

            const audioButtons =
                document.querySelectorAll(
                    '[data-audio-button]'
                );


            audioButtons.forEach(
                function (button) {

                    const url =
                        button.dataset.audio;

                    const container =
                        button.closest('[data-voice-player]');

                    const progress =
                        container?.querySelector(
                            '[data-audio-progress]'
                        );

                    const timeLabel =
                        container?.querySelector(
                            '[data-audio-time]'
                        );

                    const playIcon =
                        button.querySelector(
                            '[data-play-icon]'
                        );

                    const pauseIcon =
                        button.querySelector(
                            '[data-pause-icon]'
                        );


                    if (
                        !url ||
                        !container ||
                        !progress
                    ) {
                        return;
                    }


                    const audio =
                        new Audio(url);


                    function audioTime(
                        seconds
                    ) {

                        if (
                            !Number.isFinite(
                                seconds
                            )
                        ) {

                            return '0:00';

                        }

                        const minutes =
                            Math.floor(
                                seconds / 60
                            );

                        const remainder =
                            String(
                                Math.floor(
                                    seconds % 60
                                )
                            ).padStart(
                                2,
                                '0'
                            );

                        return `${minutes}:${remainder}`;

                    }


                    function setPlaying(
                        playing
                    ) {

                        if (playing) {

                            playIcon?.classList.add(
                                'hidden'
                            );

                            pauseIcon?.classList.remove(
                                'hidden'
                            );

                        } else {

                            playIcon?.classList.remove(
                                'hidden'
                            );

                            pauseIcon?.classList.add(
                                'hidden'
                            );

                        }

                    }


                    button.addEventListener(
                        'click',
                        function () {

                            document
                                .querySelectorAll(
                                    '[data-audio-button]'
                                )
                                .forEach(
                                    function (
                                        otherButton
                                    ) {

                                        if (
                                            otherButton !==
                                            button
                                        ) {

                                            otherButton.dispatchEvent(
                                                new Event(
                                                    'pause-audio'
                                                )
                                            );

                                        }

                                    }
                                );


                            if (
                                audio.paused
                            ) {

                                audio.play()
                                    .then(
                                        function () {
                                            setPlaying(
                                                true
                                            );
                                        }
                                    )
                                    .catch(
                                        function () {}
                                    );

                            } else {

                                audio.pause();

                                setPlaying(
                                    false
                                );

                            }

                        }
                    );


                    button.addEventListener(
                        'pause-audio',
                        function () {

                            audio.pause();

                            audio.currentTime =
                                0;

                            setPlaying(
                                false
                            );

                            progress.value =
                                0;

                            if (timeLabel) {

                                timeLabel.textContent =
                                    '0:00';

                            }

                        }
                    );


                    audio.addEventListener(
                        'loadedmetadata',
                        function () {

                            if (timeLabel) {

                                timeLabel.textContent =
                                    audioTime(
                                        audio.duration
                                    );

                            }

                        }
                    );


                    audio.addEventListener(
                        'timeupdate',
                        function () {

                            if (
                                !audio.duration
                            ) {
                                return;
                            }

                            progress.value =
                                (
                                    audio.currentTime /
                                    audio.duration
                                ) * 100;

                            if (timeLabel) {

                                timeLabel.textContent =
                                    audioTime(
                                        audio.currentTime
                                    ) +
                                    ' / ' +
                                    audioTime(
                                        audio.duration
                                    );

                            }

                        }
                    );


                    audio.addEventListener(
                        'ended',
                        function () {

                            setPlaying(
                                false
                            );

                            progress.value =
                                0;

                            if (timeLabel) {

                                timeLabel.textContent =
                                    audioTime(
                                        audio.duration
                                    );

                            }

                        }
                    );


                    progress.addEventListener(
                        'input',
                        function () {

                            if (
                                !audio.duration
                            ) {
                                return;
                            }

                            audio.currentTime =
                                (
                                    Number(
                                        progress.value
                                    ) / 100
                                ) *
                                audio.duration;

                        }
                    );

                }
            );

        }
    );

</script>




<style>
    /* ================================================================
       PROKERJA CHAT — FINAL OVERRIDES
       Final layout: single chat column, no left profile panel.
       Mobile composer stays above the fixed bottom navigation.
       ================================================================ */

    /* The mobile bottom navigation is fixed, so it must NOT add body
       padding on the message page. The nav itself is outside document flow. */
    body:has(#prokerja-chat-page) {
        overflow: hidden !important;
        padding-bottom: 0 !important;
    }

    body:has(#prokerja-chat-page) #prokerja-mobile-bottom-nav {
        position: fixed !important;
        inset-inline: 0 !important;
        bottom: 0 !important;
        z-index: 90 !important;
    }

    body:has(#prokerja-chat-page) main {
        min-height: 0 !important;
        padding-bottom: 0 !important;
    }

    body:has(#prokerja-chat-page) footer {
        display: none !important;
    }

    #prokerja-chat-page {
        height: calc(100dvh - var(--pk-header-height, 72px));
        min-height: 0;
        overflow: hidden;
        background: #F1F5F9;
    }

    #prokerja-chat-page #prokerja-chat-shell {
        width: min(100%, 1500px);
        height: 100%;
        min-height: 0;
        margin-inline: auto;
    }

    /* One column only — the freelancer sidebar is removed visually and
       does not take any width in the layout. */
    #prokerja-chat-page #prokerja-chat-card {
        display: flex !important;
        flex-direction: row !important;
        width: 100%;
        height: 100%;
        min-height: 0;
        overflow: hidden;
        border-radius: 18px;
    }

    #prokerja-chat-page #prokerja-profile-panel {
        display: none !important;
        width: 0 !important;
        min-width: 0 !important;
        max-width: 0 !important;
        flex: 0 0 0 !important;
        overflow: hidden !important;
        border: 0 !important;
    }

    #prokerja-chat-page #prokerja-chat-panel {
        display: flex !important;
        flex: 1 1 100% !important;
        width: 100% !important;
        min-width: 0 !important;
        min-height: 0 !important;
        height: 100% !important;
        flex-direction: column !important;
        overflow: hidden !important;
    }

    /* Message area is the ONLY scrolling region. */
    #prokerja-chat-page #prokerja-message-area {
        flex: 1 1 auto !important;
        width: 100% !important;
        min-width: 0 !important;
        min-height: 0 !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
    }

    #prokerja-chat-page #prokerja-message-content {
        width: 100%;
        max-width: 900px;
        min-width: 0;
        margin-inline: auto;
    }

    /* Message row: bubble width follows its content. */
    #prokerja-chat-page .prokerja-message-content {
        width: fit-content !important;
        max-width: min(76%, 620px) !important;
        min-width: 0 !important;
        flex: 0 0 auto !important;
    }

    #prokerja-chat-page #prokerja-message-content > div > div.max-w-\[88\%\] {
        width: fit-content;
        max-width: min(76%, 620px);
        min-width: 0;
    }

    #prokerja-chat-page .prokerja-message-bubble {
        display: block;
        width: fit-content;
        max-width: 100%;
        min-width: 0;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    #prokerja-chat-page .prokerja-text-bubble,
    #prokerja-chat-page .prokerja-file-bubble {
        width: fit-content !important;
        max-width: 100% !important;
    }

    /* Voice note */
    #prokerja-chat-page .prokerja-wa-voice {
        width: min(340px, 100%);
        max-width: 100%;
        min-width: 0;
        flex: 0 1 auto;
    }

    #prokerja-chat-page .prokerja-wa-waveform {
        min-width: 0;
        flex: 1 1 auto;
    }

    #prokerja-chat-page .prokerja-wa-wave-bar {
        display: block;
        width: 3px;
        min-width: 3px;
        flex: 0 0 3px;
        border-radius: 999px;
        opacity: .65;
        transition: opacity .12s ease, transform .12s ease;
    }

    #prokerja-chat-page [data-voice-player] {
        overflow: hidden;
    }

    #prokerja-chat-page [data-audio-button] {
        flex: 0 0 auto;
    }

    /* Composer is always visible and never joins message scrolling. */
    #prokerja-chat-page #prokerja-composer {
        display: block !important;
        margin: 0 !important;
        border-radius: 0 !important;
        flex: 0 0 auto !important;
        width: 100% !important;
        min-width: 0 !important;
        min-height: 0 !important;
        position: relative;
        z-index: 30;
        background: #FFFFFF;
        box-sizing: border-box;
    }

    #prokerja-chat-page #chat-form {
        display: flex;
        flex-direction: column;
        width: 100%;
        min-width: 0;
    }

    #prokerja-chat-page #chat-form > .flex.items-end {
        width: 100%;
        min-width: 0;
    }

    #prokerja-chat-page #chat-input {
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* Prevent global app.css SVG rule from breaking .hidden icons. */
    #prokerja-chat-page img,
    #prokerja-chat-page svg,
    #prokerja-chat-page video,
    #prokerja-chat-page canvas {
        max-width: 100%;
    }

    #prokerja-chat-page .prokerja-wa-voice [data-play-icon].hidden,
    #prokerja-chat-page .prokerja-wa-voice [data-pause-icon].hidden {
        display: none !important;
    }

    #prokerja-chat-page .prokerja-wa-voice [data-play-icon]:not(.hidden),
    #prokerja-chat-page .prokerja-wa-voice [data-pause-icon]:not(.hidden) {
        display: block !important;
    }

    /* Tablet */
    @media (max-width: 1023px) {
        #prokerja-chat-page #prokerja-chat-card {
            border-radius: 0 !important;
            border-left: 0 !important;
            border-right: 0 !important;
        }
    }

    /* Mobile: reserve the fixed bottom-navigation area so the composer
       is physically above it instead of being covered by it. */
    @media (max-width: 767px) {
        /*
         * IMPORTANT: the marketplace mobile header and bottom navigation
         * are outside this Blade's flex tree. Do not rely on main/body
         * height calculations. Pin the chat viewport between them.
         */
        :root {
            --pk-mobile-header-height: 68px;
            --pk-mobile-bottom-nav-height: 78px;
        }

        body:has(#prokerja-chat-page) {
            overflow: hidden !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        body:has(#prokerja-chat-page) main {
            padding: 0 !important;
            margin: 0 !important;
            min-height: 0 !important;
        }

        /*
         * This is the key fix: the chat page gets its own viewport.
         * Top = mobile marketplace header.
         * Bottom = fixed 5-item navigation.
         * Therefore the composer can never sit underneath the nav.
         */
        #prokerja-chat-page {
            position: fixed !important;
            top: var(--pk-mobile-header-height) !important;
            right: 0 !important;
            bottom: calc(
                var(--pk-mobile-bottom-nav-height) +
                env(safe-area-inset-bottom)
            ) !important;
            left: 0 !important;

            width: 100% !important;
            height: auto !important;
            max-height: none !important;
            min-height: 0 !important;

            margin: 0 !important;
            padding: 0 !important;

            overflow: hidden !important;
            z-index: 10 !important;
        }

        #prokerja-chat-page #prokerja-chat-shell,
        #prokerja-chat-page #prokerja-chat-card,
        #prokerja-chat-page #prokerja-chat-panel {
            width: 100% !important;
            height: 100% !important;
            min-height: 0 !important;
            max-height: 100% !important;
        }

        #prokerja-chat-page #prokerja-chat-panel {
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
        }

        #prokerja-chat-page #prokerja-message-area {
            flex: 1 1 0 !important;
            min-height: 0 !important;
            height: auto !important;
            overflow-y: auto !important;
        }

        #prokerja-chat-page #prokerja-composer {
            flex: 0 0 auto !important;
            position: relative !important;
            bottom: auto !important;
            width: 100% !important;
            z-index: 50 !important;
        }

        #prokerja-chat-page #prokerja-chat-shell {
            width: 100% !important;
            max-width: none !important;
        }

        #prokerja-chat-page #prokerja-chat-card {
            border-radius: 0 !important;
            border: 0 !important;
            box-shadow: none !important;
        }

        #prokerja-chat-page #prokerja-profile-panel {
            display: none !important;
        }

        #prokerja-chat-page #prokerja-chat-panel {
            width: 100% !important;
            flex: 1 1 100% !important;
        }

        #prokerja-chat-page #prokerja-message-content {
            max-width: none;
            padding-left: 10px;
            padding-right: 10px;
        }

        #prokerja-chat-page .prokerja-message-content,
        #prokerja-chat-page #prokerja-message-content > div > div.max-w-\[88\%\] {
            max-width: 88% !important;
        }

        #prokerja-chat-page .prokerja-wa-voice {
            width: min(320px, 82vw);
        }

        #prokerja-chat-page #prokerja-composer {
            flex: 0 0 auto !important;
            padding-bottom: calc(8px + env(safe-area-inset-bottom)) !important;
        }

        #prokerja-chat-page #chat-form {
            max-width: none !important;
        }

        #prokerja-chat-page #chat-form > .flex.items-end {
            gap: 6px !important;
        }

        #prokerja-chat-page #attachment-button,
        #prokerja-chat-page #voice-button,
        #prokerja-chat-page #send-button {
            width: 40px !important;
            min-width: 40px !important;
            height: 40px !important;
            flex: 0 0 40px !important;
        }

        #prokerja-chat-page #chat-input {
            min-height: 22px !important;
            max-height: 96px !important;
            font-size: 13px !important;
        }
    }

    @media (max-width: 420px) {
        #prokerja-chat-page .prokerja-message-content,
        #prokerja-chat-page #prokerja-message-content > div > div.max-w-\[88\%\] {
            max-width: 92% !important;
        }

        #prokerja-chat-page .prokerja-wa-voice {
            width: min(300px, 80vw);
        }

        #prokerja-chat-page #prokerja-composer {
            padding-left: 7px !important;
            padding-right: 7px !important;
        }
    }
</style>

</x-layouts.marketplace>
