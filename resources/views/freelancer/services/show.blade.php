<x-layouts.freelancer title="Detail Jasa">

    <div class="mx-auto max-w-6xl space-y-6">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <a
                    href="{{ route('freelancer.services.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#0F6B3A]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Jasa Saya
                </a>

                <div class="mt-4">

                    <h1
                        class="text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl"
                    >
                        Detail Jasa
                    </h1>

                    <p class="mt-1 text-sm text-[#71837B]">
                        Lihat informasi lengkap dari jasa yang kamu tawarkan.
                    </p>

                </div>

            </div>

            <a
                href="{{ route('freelancer.services.edit', $service) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
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
                class="flex items-start gap-3 rounded-xl border border-[#CBEAD8] bg-[#EAF7EF] px-4 py-3.5 text-sm text-[#17663D]"
            >

                <div
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white"
                >
                    <i class="bi bi-check-circle"></i>
                </div>

                <div>

                    <p class="font-semibold">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-[#557166]">
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
                class="flex items-start gap-3 rounded-xl border border-[#E8DFC2] bg-[#FFFBEF] px-4 py-3.5 text-sm text-[#7A5A00]"
            >

                <div
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white"
                >
                    <i class="bi bi-info-circle"></i>
                </div>

                <div>

                    <p class="font-semibold">
                        Informasi
                    </p>

                    <p class="mt-0.5 text-[#806B38]">
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
                class="rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700"
            >

                <div class="flex items-start gap-3">

                    <i class="bi bi-exclamation-circle mt-0.5"></i>

                    <div>

                        <p class="font-semibold">
                            Ada yang perlu diperbaiki
                        </p>

                        <ul class="mt-2 space-y-1 text-xs leading-5">
                            @foreach ($errors->all() as $error)
                                <li>
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
                class="rounded-2xl border border-[#EADDB8] bg-[#FFFBEF] p-5 sm:p-6"
            >

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#B7791F]"
                    >
                        <i class="bi bi-hourglass-split text-lg"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-sm font-semibold text-[#6F560E]">
                            Jasa sedang diperiksa
                        </h2>

                        <p class="mt-1 text-xs leading-6 text-[#806F3D]">
                            Jasa ini sudah diajukan untuk pemeriksaan Admin.
                            Selama proses review berlangsung, jasa belum dapat
                            dipublikasikan kembali sampai keputusan Admin selesai.
                        </p>

                        @if ($service->submitted_at)

                            <p class="mt-3 text-[11px] font-medium text-[#9A8650]">
                                Diajukan:
                                {{ $service->submitted_at->format('d M Y, H:i') }}
                            </p>

                        @endif

                    </div>

                </div>

            </div>

        @elseif ($service->status === 'rejected')

            <div
                class="rounded-2xl border border-red-200 bg-red-50 p-5 sm:p-6"
            >

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-red-600"
                    >
                        <i class="bi bi-x-circle text-lg"></i>
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

                            <div class="mt-4 rounded-xl border border-red-100 bg-white p-4">

                                <p
                                    class="text-[10px] font-semibold uppercase tracking-[0.12em] text-red-500"
                                >
                                    Alasan Admin
                                </p>

                                <p
                                    class="mt-2 whitespace-pre-line text-sm leading-6 text-[#5F3B38]"
                                >
                                    {{ $service->rejection_reason }}
                                </p>

                            </div>

                        @endif

                        @if ($service->reviewed_at)

                            <p class="mt-3 text-[11px] font-medium text-red-500">
                                Direview:
                                {{ $service->reviewed_at->format('d M Y, H:i') }}
                            </p>

                        @endif

                    </div>

                </div>

            </div>

        @elseif ($service->status === 'published')

            <div
                class="rounded-2xl border border-[#CBEAD8] bg-[#EAF7EF] p-5 sm:p-6"
            >

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A]"
                    >
                        <i class="bi bi-check-circle-fill text-lg"></i>
                    </div>

                    <div>

                        <h2 class="text-sm font-semibold text-[#17663D]">
                            Jasa aktif di marketplace
                        </h2>

                        <p class="mt-1 text-xs leading-6 text-[#557166]">
                            Jasa ini sudah lolos pemeriksaan Admin dan dapat
                            ditemukan oleh client di marketplace.
                        </p>

                    </div>

                </div>

            </div>

        @elseif ($service->status === 'draft')

            <div
                class="rounded-2xl border border-[#DCE9E2] bg-white p-5 sm:p-6"
            >

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F3F8F5] text-[#667D73]"
                    >
                        <i class="bi bi-file-earmark-text text-lg"></i>
                    </div>

                    <div>

                        <h2 class="text-sm font-semibold text-[#355248]">
                            Jasa masih dalam draft
                        </h2>

                        <p class="mt-1 text-xs leading-6 text-[#71837B]">
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
            class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white"
        >

            {{-- =====================================================
                THUMBNAIL
            ====================================================== --}}
            <div
                class="relative h-72 bg-[#F3F8F5] sm:h-[400px]"
            >

                @if ($service->thumbnail)

                    <img
                        src="{{ asset('storage/' . $service->thumbnail) }}"
                        alt="{{ $service->title }}"
                        class="h-full w-full object-cover"
                    >

                @else

                    <div
                        class="flex h-full flex-col items-center justify-center text-[#90A39A]"
                    >

                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white"
                        >
                            <i class="bi bi-image text-3xl"></i>
                        </div>

                        <p class="mt-3 text-sm font-medium">
                            Belum ada thumbnail
                        </p>

                    </div>

                @endif


                {{-- =================================================
                    STATUS
                ================================================== --}}
                <div
                    class="absolute left-4 top-4 flex flex-wrap gap-2 sm:left-6 sm:top-6"
                >

                    @if ($service->status === 'published')

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#17663D]"
                        >
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"
                            ></span>

                            Published
                        </span>

                    @elseif ($service->status === 'pending')

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#9A6700]"
                        >
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-[#D9A441]"
                            ></span>

                            Pending
                        </span>

                    @elseif ($service->status === 'rejected')

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#B42318]"
                        >
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-[#D92D20]"
                            ></span>

                            Rejected
                        </span>

                    @elseif ($service->status === 'archived')

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#667D73]"
                        >
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-[#94A3A0]"
                            ></span>

                            Archived
                        </span>

                    @else

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#667D73]"
                        >
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-[#94A3A0]"
                            ></span>

                            Draft
                        </span>

                    @endif


                    @if ($service->is_featured)

                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-[#123128] px-3 py-1.5 text-xs font-semibold text-white"
                        >
                            <i class="bi bi-star-fill text-[10px]"></i>
                            Featured
                        </span>

                    @endif

                </div>

            </div>


            {{-- =====================================================
                CONTENT
            ====================================================== --}}
            <div class="p-6 sm:p-8">

                {{-- Category --}}
                @if ($service->category || $service->subcategory)

                    <div class="flex flex-wrap gap-2">

                        @if ($service->category)

                            <span
                                class="inline-flex items-center gap-2 rounded-lg bg-[#F3F8F5] px-3 py-1.5 text-xs font-medium text-[#667D73]"
                            >
                                <i class="bi bi-folder2"></i>
                                {{ $service->category->name }}
                            </span>

                        @endif


                        @if ($service->subcategory)

                            <span
                                class="inline-flex items-center gap-2 rounded-lg bg-[#EAF7EF] px-3 py-1.5 text-xs font-semibold text-[#17663D]"
                            >
                                <i class="bi bi-tag"></i>
                                {{ $service->subcategory->name }}
                            </span>

                        @endif

                    </div>

                @endif


                {{-- Title --}}
                <h2
                    class="mt-5 max-w-4xl text-2xl font-semibold leading-tight text-[#123128] sm:text-3xl"
                >
                    {{ $service->title }}
                </h2>


                {{-- =================================================
                    STATS
                ================================================== --}}
                <div
                    class="mt-7 grid grid-cols-2 gap-4 lg:grid-cols-4"
                >

                    {{-- Price --}}
                    <div
                        class="rounded-xl border border-[#CBEAD8] bg-[#EAF7EF] p-4"
                    >

                        <div
                            class="flex items-center gap-2 text-xs font-medium text-[#557166]"
                        >
                            <i class="bi bi-wallet2 text-[#1E9E5A]"></i>
                            Harga mulai
                        </div>

                        <p
                            class="mt-2 text-lg font-semibold text-[#123128]"
                        >
                            Rp
                            {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                        </p>

                    </div>


                    {{-- Delivery --}}
                    <div
                        class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4"
                    >

                        <div
                            class="flex items-center gap-2 text-xs font-medium text-[#71837B]"
                        >
                            <i class="bi bi-clock text-[#1E9E5A]"></i>
                            Pengerjaan
                        </div>

                        <p
                            class="mt-2 text-lg font-semibold text-[#123128]"
                        >
                            {{ $service->delivery_days }} hari
                        </p>

                    </div>


                    {{-- Orders --}}
                    <div
                        class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4"
                    >

                        <div
                            class="flex items-center gap-2 text-xs font-medium text-[#71837B]"
                        >
                            <i class="bi bi-bag-check text-[#1E9E5A]"></i>
                            Pesanan
                        </div>

                        <p
                            class="mt-2 text-lg font-semibold text-[#123128]"
                        >
                            {{ number_format($service->orders_count) }}
                        </p>

                    </div>


                    {{-- Rating --}}
                    <div
                        class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4"
                    >

                        <div
                            class="flex items-center gap-2 text-xs font-medium text-[#71837B]"
                        >
                            <i class="bi bi-star text-[#1E9E5A]"></i>
                            Rating
                        </div>

                        <p
                            class="mt-2 text-lg font-semibold text-[#123128]"
                        >
                            {{ number_format((float) $service->rating, 1) }}
                        </p>

                    </div>

                </div>


                {{-- =================================================
                    DESCRIPTION
                ================================================== --}}
                <div
                    class="mt-8 rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-5 sm:p-6"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                        >
                            <i class="bi bi-file-text"></i>
                        </div>

                        <div>

                            <h3
                                class="text-sm font-semibold text-[#123128]"
                            >
                                Deskripsi Jasa
                            </h3>

                            <p class="mt-0.5 text-xs text-[#8A9B94]">
                                Detail layanan yang kamu tawarkan
                            </p>

                        </div>

                    </div>

                    <p
                        class="mt-5 whitespace-pre-line text-sm leading-7 text-[#5F7169]"
                    >
                        {{ $service->description }}
                    </p>

                </div>


                {{-- =================================================
                    CATEGORY DETAIL
                ================================================== --}}
                <div
                    class="mt-4 rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-5 sm:p-6"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                        >
                            <i class="bi bi-grid-3x3-gap"></i>
                        </div>

                        <div>

                            <h3
                                class="text-sm font-semibold text-[#123128]"
                            >
                                Kategori Jasa
                            </h3>

                            <p class="mt-0.5 text-xs text-[#8A9B94]">
                                Pengelompokan layanan
                            </p>

                        </div>

                    </div>


                    <div class="mt-5 flex flex-wrap gap-2">

                        @if ($service->category)

                            <span
                                class="inline-flex items-center gap-2 rounded-lg border border-[#DDEAE2] bg-white px-3.5 py-2 text-sm font-medium text-[#526960]"
                            >
                                <i class="bi bi-folder text-[#1E9E5A]"></i>

                                {{ $service->category->name }}
                            </span>

                        @endif


                        @if ($service->subcategory)

                            <span
                                class="inline-flex items-center gap-2 rounded-lg border border-[#BFE7CF] bg-[#EAF7EF] px-3.5 py-2 text-sm font-medium text-[#17663D]"
                            >
                                <i class="bi bi-tag"></i>

                                {{ $service->subcategory->name }}
                            </span>

                        @endif


                        @if (!$service->category && !$service->subcategory)

                            <span class="text-sm text-[#8A9B94]">
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
                        class="mt-4 rounded-xl border border-[#E2ECE7] bg-white p-5 sm:p-6"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                            >
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>

                                <h3
                                    class="text-sm font-semibold text-[#123128]"
                                >
                                    Riwayat Moderasi
                                </h3>

                                <p
                                    class="mt-0.5 text-xs text-[#8A9B94]"
                                >
                                    Informasi pengajuan dan pemeriksaan jasa
                                </p>

                            </div>

                        </div>


                        <div class="mt-5 space-y-4">

                            @if ($service->submitted_at)

                                <div
                                    class="flex items-start gap-3"
                                >

                                    <div
                                        class="mt-1 h-2 w-2 shrink-0 rounded-full bg-[#D9A441]"
                                    ></div>

                                    <div>

                                        <p
                                            class="text-xs font-semibold text-[#355248]"
                                        >
                                            Diajukan untuk review
                                        </p>

                                        <p
                                            class="mt-0.5 text-xs text-[#8A9B94]"
                                        >
                                            {{ $service->submitted_at->format('d M Y, H:i') }}
                                        </p>

                                    </div>

                                </div>

                            @endif


                            @if ($service->reviewed_at)

                                <div
                                    class="flex items-start gap-3"
                                >

                                    <div
                                        class="mt-1 h-2 w-2 shrink-0 rounded-full
                                            {{ $service->status === 'published'
                                                ? 'bg-[#1E9E5A]'
                                                : 'bg-[#D92D20]' }}"
                                    ></div>

                                    <div>

                                        <p
                                            class="text-xs font-semibold text-[#355248]"
                                        >
                                            Pemeriksaan Admin selesai
                                        </p>

                                        <p
                                            class="mt-0.5 text-xs text-[#8A9B94]"
                                        >
                                            {{ $service->reviewed_at->format('d M Y, H:i') }}
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
                    class="mt-8 flex flex-col gap-3 border-t border-[#E7EFEA] pt-6 sm:flex-row sm:flex-wrap sm:justify-end"
                >

                    <a
                        href="{{ route('freelancer.services.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E8DF] bg-white px-5 py-2.5 text-sm font-semibold text-[#526960] transition hover:bg-[#F8FCF9] hover:text-[#123128]"
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
                        >

                            @csrf

                            <button
                                type="submit"
                                onclick="return confirm('Ajukan jasa ini untuk diperiksa Admin?')"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D] sm:w-auto"
                            >
                                <i class="bi bi-send"></i>
                                Ajukan Review
                            </button>

                        </form>

                    @endif


                    {{-- =================================================
                        EDIT
                    ================================================== --}}
                    @if ($service->status !== 'pending')

                        <a
                            href="{{ route('freelancer.services.edit', $service) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#BFE7CF] bg-[#EAF7EF] px-5 py-2.5 text-sm font-semibold text-[#17663D] transition hover:bg-[#DDF3E6]"
                        >
                            <i class="bi bi-pencil"></i>
                            Edit Jasa
                        </a>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-layouts.freelancer>