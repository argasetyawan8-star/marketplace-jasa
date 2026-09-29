
<x-layouts.freelancer title="Detail Jasa">

    <div class="mx-auto w-full max-w-6xl space-y-6 px-3 sm:space-y-8 sm:px-0">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">
                <a
                    href="{{ route('freelancer.services.index') }}"
                    class="inline-flex items-center gap-2 text-xs font-medium text-slate-500 transition hover:text-blue-600 sm:text-sm"
                >
                    <span
                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-white transition hover:border-blue-200 hover:bg-blue-50 sm:h-8 sm:w-8"
                    >
                        <i class="bi bi-arrow-left text-[11px] sm:text-xs"></i>
                    </span>

                    <span>Kembali ke Jasa Saya</span>
                </a>

                <div class="mt-5 sm:mt-6">
                    <div class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                        Kelola layanan
                    </div>

                    <h1
                        class="mt-2.5 text-[25px] font-bold tracking-tight text-slate-900 sm:text-3xl"
                    >
                        Detail Jasa
                    </h1>

                    <p class="mt-1.5 max-w-xl text-xs leading-5 text-slate-500 sm:text-sm sm:leading-6">
                        Lihat informasi lengkap dari jasa yang kamu tawarkan.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('freelancer.services.edit', $service) }}"
                class="inline-flex h-10 w-auto shrink-0 self-start items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 active:scale-[0.98] sm:h-11 sm:self-auto sm:px-5 sm:text-sm"
            >
                <i class="bi bi-pencil"></i>
                Edit Jasa
            </a>

        </div>


        {{-- =========================================================
            FLASH SUCCESS
        ========================================================== --}}
        @if (session('success'))
            <div
                class="flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3.5 text-xs text-blue-700 sm:text-sm"
            >
                <div
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm"
                >
                    <i class="bi bi-check-circle"></i>
                </div>

                <div class="min-w-0">
                    <p class="font-semibold">
                        Berhasil
                    </p>

                    <p class="mt-0.5 break-words text-blue-700/80">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif


        {{-- =========================================================
            FLASH INFO
        ========================================================== --}}
        @if (session('info'))
            <div
                class="flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3.5 text-xs text-blue-700 sm:text-sm"
            >
                <div
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm"
                >
                    <i class="bi bi-info-circle"></i>
                </div>

                <div class="min-w-0">
                    <p class="font-semibold">
                        Informasi
                    </p>

                    <p class="mt-0.5 break-words text-blue-700/80">
                        {{ session('info') }}
                    </p>
                </div>
            </div>
        @endif


        {{-- =========================================================
            VALIDATION ERROR
        ========================================================== --}}
        @if ($errors->any())
            <div
                class="rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-xs text-red-700 sm:text-sm"
            >
                <div class="flex items-start gap-3">

                    <i class="bi bi-exclamation-circle mt-0.5 shrink-0"></i>

                    <div class="min-w-0">
                        <p class="font-semibold">
                            Ada yang perlu diperbaiki
                        </p>

                        <ul class="mt-2 space-y-1 text-xs leading-5">
                            @foreach ($errors->all() as $error)
                                <li class="break-words">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endif


        {{-- =========================================================
            MODERATION NOTICE
        ========================================================== --}}
        @if ($service->status === 'pending')

            <div
                class="rounded-2xl border border-amber-200 bg-amber-50 p-4 sm:p-6"
            >
                <div class="flex items-start gap-3.5 sm:gap-4">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm sm:h-11 sm:w-11"
                    >
                        <i class="bi bi-hourglass-split text-base sm:text-lg"></i>
                    </div>

                    <div class="min-w-0">
                        <h2 class="text-sm font-semibold text-amber-800">
                            Jasa sedang diperiksa
                        </h2>

                        <p class="mt-1 text-xs leading-6 text-amber-700">
                            Jasa ini sudah diajukan untuk pemeriksaan Admin.
                            Selama proses review berlangsung, jasa belum dapat
                            dipublikasikan kembali sampai keputusan Admin selesai.
                        </p>

                        @if ($service->submitted_at)
                            <p class="mt-3 text-[11px] font-medium text-amber-600">
                                Diajukan:
                                {{ $service->submitted_at->format('d M Y, H\:i') }}
                            </p>
                        @endif
                    </div>

                </div>
            </div>

        @elseif ($service->status === 'rejected')

            <div
                class="rounded-2xl border border-red-200 bg-red-50 p-4 sm:p-6"
            >
                <div class="flex items-start gap-3.5 sm:gap-4">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm sm:h-11 sm:w-11"
                    >
                        <i class="bi bi-x-circle text-base sm:text-lg"></i>
                    </div>

                    <div class="min-w-0 flex-1">

                        <h2 class="text-sm font-semibold text-red-800">
                            Jasa perlu diperbaiki
                        </h2>

                        <p class="mt-1 text-xs leading-6 text-red-700">
                            Admin menolak pengajuan jasa ini. Silakan perbaiki
                            bagian yang diperlukan lalu ajukan review kembali.
                        </p>

                        @if ($service->rejection_reason)
                            <div
                                class="mt-4 rounded-xl border border-red-100 bg-white p-3.5 sm:p-4"
                            >
                                <p
                                    class="text-[10px] font-semibold uppercase tracking-[0.12em] text-red-500"
                                >
                                    Alasan Admin
                                </p>

                                <p
                                    class="mt-2 whitespace-pre-line break-words text-xs leading-6 text-red-900/70 sm:text-sm"
                                >
                                    {{ $service->rejection_reason }}
                                </p>
                            </div>
                        @endif

                        @if ($service->reviewed_at)
                            <p class="mt-3 text-[11px] font-medium text-red-500">
                                Direview:
                                {{ $service->reviewed_at->format('d M Y, H\:i') }}
                            </p>
                        @endif

                    </div>
                </div>
            </div>

        @elseif ($service->status === 'published')

            <div
                class="rounded-2xl border border-blue-100 bg-blue-50 p-4 sm:p-6"
            >
                <div class="flex items-start gap-3.5 sm:gap-4">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm sm:h-11 sm:w-11"
                    >
                        <i class="bi bi-check-circle-fill text-base sm:text-lg"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-sm font-semibold text-blue-800">
                            Jasa aktif di marketplace
                        </h2>

                        <p class="mt-1 text-xs leading-6 text-blue-700/80">
                            Jasa ini sudah lolos pemeriksaan Admin dan dapat
                            ditemukan oleh client di marketplace.
                        </p>

                    </div>
                </div>
            </div>

        @elseif ($service->status === 'draft')

            <div
                class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6"
            >
                <div class="flex items-start gap-3.5 sm:gap-4">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-11 sm:w-11"
                    >
                        <i class="bi bi-file-earmark-text text-base sm:text-lg"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-sm font-semibold text-slate-800">
                            Jasa masih dalam draft
                        </h2>

                        <p class="mt-1 text-xs leading-6 text-slate-500">
                            Periksa kembali informasi jasa sebelum mengajukannya
                            untuk pemeriksaan Admin.
                        </p>

                    </div>
                </div>
            </div>

        @endif


        {{-- =========================================================
            MAIN CARD
        ========================================================== --}}
        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_8px_30px_rgba(15,23,42,0.04)]"
        >

            {{-- =====================================================
                THUMBNAIL
            ====================================================== --}}
            <div
                class="relative h-56 bg-slate-100 sm:h-[400px]"
            >

                @if ($service->thumbnail)

                    <img
                        src="{{ asset('storage/' . $service->thumbnail) }}"
                        alt="{{ $service->title }}"
                        class="h-full w-full object-cover"
                    >

                @else

                    <div
                        class="flex h-full flex-col items-center justify-center px-4 text-center text-slate-400"
                    >
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-sm sm:h-16 sm:w-16"
                        >
                            <i class="bi bi-image text-2xl sm:text-3xl"></i>
                        </div>

                        <p class="mt-3 text-xs font-medium sm:text-sm">
                            Belum ada thumbnail
                        </p>
                    </div>

                @endif


                {{-- STATUS --}}
                <div
                    class="absolute left-3 top-3 flex max-w-[calc(100%-24px)] flex-wrap gap-1.5 sm:left-6 sm:top-6 sm:gap-2"
                >

                    @if ($service->status === 'published')

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-2.5 py-1.5 text-[10px] font-semibold text-blue-700 shadow-sm sm:px-3 sm:text-xs"
                        >
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                            Published
                        </span>

                    @elseif ($service->status === 'pending')

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-2.5 py-1.5 text-[10px] font-semibold text-amber-700 shadow-sm sm:px-3 sm:text-xs"
                        >
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                            Pending
                        </span>

                    @elseif ($service->status === 'rejected')

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-2.5 py-1.5 text-[10px] font-semibold text-red-700 shadow-sm sm:px-3 sm:text-xs"
                        >
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                            Rejected
                        </span>

                    @elseif ($service->status === 'archived')

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-2.5 py-1.5 text-[10px] font-semibold text-slate-600 shadow-sm sm:px-3 sm:text-xs"
                        >
                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                            Archived
                        </span>

                    @else

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-2.5 py-1.5 text-[10px] font-semibold text-slate-600 shadow-sm sm:px-3 sm:text-xs"
                        >
                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                            Draft
                        </span>

                    @endif


                    @if ($service->is_featured)

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-slate-900 px-2.5 py-1.5 text-[10px] font-semibold text-white shadow-sm sm:px-3 sm:text-xs"
                        >
                            <i class="bi bi-star-fill text-[9px] sm:text-[10px]"></i>
                            Featured
                        </span>

                    @endif

                </div>
            </div>


            {{-- =====================================================
                CONTENT
            ====================================================== --}}
            <div class="p-4 sm:p-8">

                {{-- CATEGORY --}}
                @if ($service->category || $service->subcategory)

                    <div class="flex flex-wrap gap-1.5 sm:gap-2">

                        @if ($service->category)

                            <span
                                class="inline-flex max-w-full items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1.5 text-[10px] font-medium text-slate-600 sm:gap-2 sm:px-3 sm:text-xs"
                            >
                                <i class="bi bi-folder2 shrink-0 text-blue-600"></i>

                                <span class="break-words">
                                    {{ $service->category->name }}
                                </span>
                            </span>

                        @endif


                        @if ($service->subcategory)

                            <span
                                class="inline-flex max-w-full items-center gap-1.5 rounded-lg bg-blue-100 px-2.5 py-1.5 text-[10px] font-semibold text-blue-700 sm:gap-2 sm:px-3 sm:text-xs"
                            >
                                <i class="bi bi-tag shrink-0"></i>

                                <span class="break-words">
                                    {{ $service->subcategory->name }}
                                </span>
                            </span>

                        @endif

                    </div>

                @endif


                {{-- TITLE --}}
                <h2
                    class="mt-4 max-w-4xl break-words text-xl font-bold leading-tight tracking-tight text-slate-900 sm:mt-5 sm:text-3xl"
                >
                    {{ $service->title }}
                </h2>


                {{-- =================================================
                    STATS
                ================================================== --}}
                <div
                    class="mt-5 grid grid-cols-2 gap-2.5 sm:mt-7 sm:gap-4 lg:grid-cols-4"
                >

                    {{-- PRICE --}}
                    <div
                        class="min-w-0 rounded-xl border border-blue-100 bg-blue-50 p-3 sm:p-4"
                    >
                        <div
                            class="flex min-w-0 items-center gap-1.5 text-[10px] font-medium text-slate-500 sm:gap-2 sm:text-xs"
                        >
                            <i class="bi bi-wallet2 shrink-0 text-blue-600"></i>
                            <span class="truncate">Harga mulai</span>
                        </div>

                        <p
                            class="mt-2 break-words text-sm font-bold text-slate-900 sm:text-lg"
                        >
                            Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                        </p>
                    </div>


                    {{-- DELIVERY --}}
                    <div
                        class="min-w-0 rounded-xl border border-slate-200 bg-slate-50 p-3 sm:p-4"
                    >
                        <div
                            class="flex min-w-0 items-center gap-1.5 text-[10px] font-medium text-slate-500 sm:gap-2 sm:text-xs"
                        >
                            <i class="bi bi-clock shrink-0 text-blue-600"></i>
                            <span class="truncate">Pengerjaan</span>
                        </div>

                        <p
                            class="mt-2 text-sm font-bold text-slate-900 sm:text-lg"
                        >
                            {{ $service->delivery_days }} hari
                        </p>
                    </div>


                    {{-- ORDERS --}}
                    <div
                        class="min-w-0 rounded-xl border border-slate-200 bg-slate-50 p-3 sm:p-4"
                    >
                        <div
                            class="flex min-w-0 items-center gap-1.5 text-[10px] font-medium text-slate-500 sm:gap-2 sm:text-xs"
                        >
                            <i class="bi bi-bag-check shrink-0 text-blue-600"></i>
                            <span class="truncate">Pesanan</span>
                        </div>

                        <p
                            class="mt-2 text-sm font-bold text-slate-900 sm:text-lg"
                        >
                            {{ number_format($service->orders_count) }}
                        </p>
                    </div>


                    {{-- RATING --}}
                    <div
                        class="min-w-0 rounded-xl border border-slate-200 bg-slate-50 p-3 sm:p-4"
                    >
                        <div
                            class="flex min-w-0 items-center gap-1.5 text-[10px] font-medium text-slate-500 sm:gap-2 sm:text-xs"
                        >
                            <i class="bi bi-star shrink-0 text-blue-600"></i>
                            <span class="truncate">Rating</span>
                        </div>

                        <p
                            class="mt-2 text-sm font-bold text-slate-900 sm:text-lg"
                        >
                            {{ number_format((float) $service->rating, 1) }}
                        </p>
                    </div>

                </div>


                {{-- =================================================
                    DESCRIPTION
                ================================================== --}}
                <div
                    class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:mt-8 sm:p-6"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 sm:h-10 sm:w-10"
                        >
                            <i class="bi bi-file-text"></i>
                        </div>

                        <div class="min-w-0">

                            <h3 class="text-sm font-semibold text-slate-900">
                                Deskripsi Jasa
                            </h3>

                            <p class="mt-0.5 text-[10px] text-slate-400 sm:text-xs">
                                Detail layanan yang kamu tawarkan
                            </p>

                        </div>

                    </div>

                    <p
                        class="mt-4 whitespace-pre-line break-words text-xs leading-6 text-slate-600 sm:mt-5 sm:text-sm sm:leading-7"
                    >
                        {{ $service->description }}
                    </p>

                </div>


                {{-- =================================================
                    CATEGORY DETAIL
                ================================================== --}}
                <div
                    class="mt-3.5 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:mt-4 sm:p-6"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 sm:h-10 sm:w-10"
                        >
                            <i class="bi bi-grid-3x3-gap"></i>
                        </div>

                        <div class="min-w-0">

                            <h3 class="text-sm font-semibold text-slate-900">
                                Kategori Jasa
                            </h3>

                            <p class="mt-0.5 text-[10px] text-slate-400 sm:text-xs">
                                Pengelompokan layanan
                            </p>

                        </div>

                    </div>


                    <div class="mt-4 flex flex-wrap gap-2 sm:mt-5">

                        @if ($service->category)

                            <span
                                class="inline-flex max-w-full items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-600 sm:px-3.5 sm:text-sm"
                            >
                                <i class="bi bi-folder shrink-0 text-blue-600"></i>

                                <span class="break-words">
                                    {{ $service->category->name }}
                                </span>
                            </span>

                        @endif


                        @if ($service->subcategory)

                            <span
                                class="inline-flex max-w-full items-center gap-2 rounded-lg border border-blue-100 bg-blue-50 px-3 py-2 text-xs font-medium text-blue-700 sm:px-3.5 sm:text-sm"
                            >
                                <i class="bi bi-tag"></i>

                                <span class="break-words">
                                    {{ $service->subcategory->name }}
                                </span>
                            </span>

                        @endif


                        @if (!$service->category && !$service->subcategory)

                            <span class="text-xs text-slate-400 sm:text-sm">
                                Kategori belum ditentukan.
                            </span>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    MODERATION TIMELINE
                ================================================== --}}
                @if (
                    $service->submitted_at ||
                    $service->reviewed_at ||
                    $service->rejection_reason
                )

                    <div
                        class="mt-3.5 rounded-xl border border-slate-200 bg-white p-4 sm:mt-4 sm:p-6"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 sm:h-10 sm:w-10"
                            >
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div class="min-w-0">

                                <h3 class="text-sm font-semibold text-slate-900">
                                    Riwayat Moderasi
                                </h3>

                                <p class="mt-0.5 text-[10px] text-slate-400 sm:text-xs">
                                    Informasi pengajuan dan pemeriksaan jasa
                                </p>

                            </div>

                        </div>


                        <div class="mt-4 space-y-4 sm:mt-5">

                            @if ($service->submitted_at)

                                <div class="flex items-start gap-3">

                                    <div
                                        class="mt-1 h-2 w-2 shrink-0 rounded-full bg-blue-500"
                                    ></div>

                                    <div class="min-w-0">

                                        <p class="text-xs font-semibold text-slate-700">
                                            Diajukan untuk review
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-400">
                                            {{ $service->submitted_at->format('d M Y, H\:i') }}
                                        </p>

                                    </div>

                                </div>

                            @endif


                            @if ($service->reviewed_at)

                                <div class="flex items-start gap-3">

                                    <div
                                        class="mt-1 h-2 w-2 shrink-0 rounded-full
                                            {{ $service->status === 'published'
                                                ? 'bg-blue-500'
                                                : 'bg-red-500' }}"
                                    ></div>

                                    <div class="min-w-0">

                                        <p class="text-xs font-semibold text-slate-700">
                                            Pemeriksaan Admin selesai
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-400">
                                            {{ $service->reviewed_at->format('d M Y, H\:i') }}
                                        </p>

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>

                @endif


                {{-- =================================================
                    BOTTOM ACTIONS
                ================================================== --}}
                <div
                    class="mt-6 flex flex-wrap items-center justify-end gap-2.5 border-t border-slate-200 pt-5 sm:mt-8 sm:gap-3 sm:pt-6"
                >

                    {{-- KEMBALI --}}
                    <a
                        href="{{ route('freelancer.services.index') }}"
                        class="inline-flex h-9 w-auto shrink-0 items-center justify-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3.5 text-[11px] font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 sm:h-10 sm:gap-2 sm:rounded-xl sm:px-5 sm:text-sm"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>


                    {{-- =================================================
                        SUBMIT REVIEW
                    ================================================== --}}
                    @if (in_array($service->status, ['draft', 'rejected'], true))

                        <form
                            method="POST"
                            action="{{ route(
                                'freelancer.services.submit-review',
                                $service
                            ) }}"
                            class="w-auto shrink-0"
                        >
                            @csrf

                            <button
                                type="submit"
                                onclick="return confirm('Ajukan jasa ini untuk diperiksa Admin?')"
                                class="inline-flex h-9 w-auto shrink-0 items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-3.5 text-[11px] font-semibold text-white shadow-sm transition hover:bg-blue-700 active:scale-[0.98] sm:h-10 sm:gap-2 sm:rounded-xl sm:px-5 sm:text-sm"
                            >
                                <i class="bi bi-send"></i>

                                <span class="sm:hidden">
                                    Ajukan
                                </span>

                                <span class="hidden sm:inline">
                                    Ajukan Review
                                </span>
                            </button>
                        </form>

                    @endif


                    {{-- =================================================
                        EDIT
                    ================================================== --}}
                    @if ($service->status !== 'pending')

                        <a
                            href="{{ route('freelancer.services.edit', $service) }}"
                            class="inline-flex h-9 w-auto shrink-0 items-center justify-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-3.5 text-[11px] font-semibold text-blue-700 transition hover:border-blue-300 hover:bg-blue-100 sm:h-10 sm:gap-2 sm:rounded-xl sm:px-5 sm:text-sm"
                        >
                            <i class="bi bi-pencil"></i>

                            <span class="sm:hidden">
                                Edit
                            </span>

                            <span class="hidden sm:inline">
                                Edit Jasa
                            </span>
                        </a>

                    @endif

                </div>

            </div>
        </div>

    </div>

</x-layouts.freelancer>
