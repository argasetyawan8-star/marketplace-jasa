<x-layouts.marketplace title="Favorit - ProKerja">

    <div class="min-h-screen bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            {{-- Header --}}
            <div class="mb-6 sm:mb-8">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                    <svg
                        class="h-3.5 w-3.5"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M12 21s-7-4.35-9.33-8.28C.8 9.65 2.5 5 6.5 5c2.04 0 3.4 1.12 4.5 2.33C12.1 6.12 13.46 5 15.5 5c4 0 5.7 4.65 3.83 7.72C19 16.65 12 21 12 21z"/>
                    </svg>

                    Favorit
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Layanan Favorit
                        </h1>

                        <p class="mt-1.5 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
                            Simpan layanan yang menarik agar mudah ditemukan dan dipesan kembali.
                        </p>
                    </div>

                    <a
                        href="{{ route('marketplace.search') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[#2563EB] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md sm:w-auto"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>

                        Cari Layanan
                    </a>
                </div>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    <svg
                        class="mt-0.5 h-5 w-5 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($favorites->count())

                {{-- Summary --}}
                <div class="mb-5 flex items-center justify-between gap-3 sm:mb-6">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            {{ $favorites->total() }} layanan tersimpan
                        </p>

                        <p class="mt-0.5 text-xs text-slate-500 sm:text-sm">
                            Layanan yang kamu tandai sebagai favorit
                        </p>
                    </div>

                    <div class="hidden rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-500 shadow-sm sm:block">
                        Favorit saya
                    </div>
                </div>

                {{-- Service Grid --}}
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4">

                    @foreach ($favorites as $favorite)

                        @php
                            $service = $favorite->service;

                            $freelancer = $service?->freelancerProfile;

                            $freelancerUser = $freelancer?->user;

                            $freelancerName =
                                $freelancerUser?->name
                                ?? $freelancer?->display_name
                                ?? 'Freelancer';

                            $freelancerInitial = strtoupper(
                                substr($freelancerName, 0, 1)
                            );

                            $thumbnail = $service?->thumbnail
                                ? asset('storage/' . $service->thumbnail)
                                : null;
                        @endphp

                        @if ($service)

                            <article
                                class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg sm:rounded-3xl"
                            >

                                {{-- Thumbnail --}}
                                <a
                                    href="{{ route('marketplace.service', $service->slug) }}"
                                    class="relative block aspect-[4/3] overflow-hidden bg-slate-100"
                                >

                                    @if ($thumbnail)

                                        <img
                                            src="{{ $thumbnail }}"
                                            alt="{{ $service->title }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                        >

                                    @else

                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 to-slate-100">
                                            <svg
                                                class="h-8 w-8 text-blue-300 sm:h-10 sm:w-10"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 16l4.586-4.586a2 2 0 013.828 0L17 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                />
                                            </svg>
                                        </div>

                                    @endif

                                    {{-- Favorite Badge --}}
                                    <div class="absolute right-2 top-2 sm:right-3 sm:top-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/95 text-rose-500 shadow-sm backdrop-blur sm:h-9 sm:w-9">
                                            <svg
                                                class="h-4 w-4 sm:h-5 sm:w-5"
                                                fill="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path d="M12 21s-7-4.35-9.33-8.28C.8 9.65 2.5 5 6.5 5c2.04 0 3.4 1.12 4.5 2.33C12.1 6.12 13.46 5 15.5 5c4 0 5.7 4.65 3.83 7.72C19 16.65 12 21 12 21z"/>
                                            </svg>
                                        </div>
                                    </div>

                                </a>

                                {{-- Content --}}
                                <div class="flex flex-1 flex-col p-3 sm:p-5">

                                    {{-- Freelancer --}}
                                    <div class="mb-2 flex min-w-0 items-center gap-2">

                                        @if ($freelancer?->avatar)

                                            <img
                                                src="{{ asset('storage/' . $freelancer->avatar) }}"
                                                alt="{{ $freelancerName }}"
                                                class="h-6 w-6 shrink-0 rounded-full object-cover sm:h-8 sm:w-8"
                                            >

                                        @else

                                            <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 text-[10px] font-bold text-blue-700 sm:h-8 sm:w-8 sm:text-xs">
                                                {{ $freelancerInitial }}
                                            </div>

                                        @endif

                                        @if ($freelancer?->username)

                                            <a
                                                href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                                                class="min-w-0 truncate text-[11px] font-medium text-slate-600 transition hover:text-blue-600 sm:text-sm"
                                            >
                                                {{ $freelancerName }}
                                            </a>

                                        @else

                                            <span class="min-w-0 truncate text-[11px] font-medium text-slate-600 sm:text-sm">
                                                {{ $freelancerName }}
                                            </span>

                                        @endif

                                    </div>

                                    {{-- Service Title --}}
                                    <a
                                        href="{{ route('marketplace.service', $service->slug) }}"
                                        class="line-clamp-2 text-sm font-bold leading-snug text-slate-900 transition hover:text-blue-600 sm:text-base"
                                    >
                                        {{ $service->title }}
                                    </a>

                                    {{-- Rating --}}
                                    <div class="mt-2 flex items-center gap-1 text-[11px] sm:text-sm">

                                        <svg
                                            class="h-3.5 w-3.5 fill-amber-400 text-amber-400 sm:h-4 sm:w-4"
                                            viewBox="0 0 20 20"
                                        >
                                            <path d="M10 1.5l2.6 5.27 5.82.85-4.21 4.1.99 5.8L10 14.78 4.8 17.52l.99-5.8-4.21-4.1 5.82-.85L10 1.5z"/>
                                        </svg>

                                        <span class="font-semibold text-slate-700">
                                            {{ number_format((float) ($service->rating ?? 0), 1) }}
                                        </span>

                                        <span class="text-slate-400">
                                            ({{ $service->reviews_count ?? 0 }})
                                        </span>

                                    </div>

                                    {{-- Category --}}
                                    @if ($service->category)

                                        <div class="mt-2">
                                            <span class="inline-flex max-w-full truncate rounded-full bg-slate-100 px-2 py-1 text-[10px] font-medium text-slate-600 sm:px-2.5 sm:text-xs">
                                                {{ $service->category->name }}
                                            </span>
                                        </div>

                                    @endif

                                    {{-- Bottom --}}
                                    <div class="mt-auto pt-3 sm:pt-5">

                                        <div class="flex items-end justify-between gap-2">

                                            <div class="min-w-0">

                                                <p class="text-[10px] text-slate-400 sm:text-xs">
                                                    Mulai dari
                                                </p>

                                                <p class="truncate text-sm font-bold text-slate-900 sm:text-base">
                                                    Rp
                                                    {{ number_format($service->starting_price ?? $service->price ?? 0, 0, ',', '.') }}
                                                </p>

                                            </div>

                                            {{-- Remove Favorite --}}
                                            <form
                                                action="{{ route('client.favorites.destroy', $service) }}"
                                                method="POST"
                                                class="shrink-0"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    title="Hapus dari favorit"
                                                    class="flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 text-slate-400 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-500 sm:h-9 sm:w-9"
                                                >
                                                    <svg
                                                        class="h-4 w-4"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"
                                                        />
                                                    </svg>
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </article>

                        @endif

                    @endforeach

                </div>

                {{-- Pagination --}}
                @if ($favorites->hasPages())
                    <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm sm:mt-8 sm:rounded-3xl sm:px-6">
                        {{ $favorites->links() }}
                    </div>
                @endif

            @else

                {{-- Empty State --}}
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center shadow-sm sm:px-8 sm:py-16">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 sm:h-20 sm:w-20">
                        <svg
                            class="h-8 w-8 sm:h-10 sm:w-10"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 21s-7-4.35-9.33-8.28C.8 9.65 2.5 5 6.5 5c2.04 0 3.4 1.12 4.5 2.33C12.1 6.12 13.46 5 15.5 5c4 0 5.7 4.65 3.83 7.72C19 16.65 12 21 12 21z"
                            />
                        </svg>
                    </div>

                    <h2 class="mt-5 text-lg font-bold text-slate-900 sm:text-xl">
                        Belum ada layanan favorit
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Temukan layanan yang sesuai kebutuhanmu dan simpan sebagai favorit agar mudah ditemukan kembali.
                    </p>

                    <div class="mt-6">
                        <a
                            href="{{ route('marketplace.search') }}"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md sm:w-auto"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>

                            Jelajahi Layanan
                        </a>
                    </div>

                </div>

            @endif

            {{-- Bottom Information --}}
            @if ($favorites->count())
                <div class="mt-6 overflow-hidden rounded-3xl border border-blue-100 bg-gradient-to-r from-blue-50 via-white to-blue-50/60 p-5 sm:mt-8 sm:p-6">

                    <div class="flex items-start gap-3 sm:gap-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600 sm:h-11 sm:w-11">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-slate-900">
                                Tips memilih layanan
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-slate-500 sm:text-sm sm:leading-6">
                                Perhatikan rating, jumlah ulasan, harga, detail layanan, serta profil freelancer sebelum melakukan pemesanan.
                            </p>
                        </div>

                    </div>

                </div>
            @endif

        </div>
    </div>

</x-layouts.marketplace>