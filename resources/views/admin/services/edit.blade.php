<x-layouts.admin title="Moderasi Jasa">

    @php
        $statusMap = [
            'draft' => [
                'label' => 'Draft',
                'description' => 'Jasa masih dalam tahap penyusunan dan belum tampil sebagai jasa aktif.',
                'class' => 'bg-[#F3F4F6] text-[#4B5563] border-[#D9DDE1] dark:bg-[#26352D] dark:text-[#C3CEC8] dark:border-[#3A4A42]',
                'icon' => 'bi-file-earmark',
            ],
            'published' => [
                'label' => 'Published',
                'description' => 'Jasa aktif dan dapat ditampilkan kepada client di marketplace.',
                'class' => 'bg-[#DCFCE7] text-[#166534] border-[#B8E6C8] dark:bg-[#244732] dark:text-[#A0E8B7] dark:border-[#315C43]',
                'icon' => 'bi-check-circle-fill',
            ],
            'paused' => [
                'label' => 'Paused',
                'description' => 'Jasa sementara tidak aktif dan tidak diprioritaskan untuk pemesanan baru.',
                'class' => 'bg-[#FEF3C7] text-[#92400E] border-[#F2D99B] dark:bg-[#48391E] dark:text-[#E8C67A] dark:border-[#665326]',
                'icon' => 'bi-pause-circle-fill',
            ],
            'rejected' => [
                'label' => 'Rejected',
                'description' => 'Jasa ditolak karena belum memenuhi standar marketplace.',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] border-[#F2C5C5] dark:bg-[#492727] dark:text-[#F0A3A3] dark:border-[#6A3B3B]',
                'icon' => 'bi-x-circle-fill',
            ],
        ];

        $currentStatus = $statusMap[$service->status] ?? $statusMap['draft'];

        $freelancer = $service->freelancerProfile;
        $freelancerUser = $freelancer?->user;
    @endphp


    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <a
                href="{{ route('admin.services.show', $service) }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#1E9E5A] dark:text-[#93A89F] dark:hover:text-[#7AD8B5]"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke detail jasa
            </a>

            <div class="mt-4">
                <div class="flex flex-wrap items-center gap-2">
                    <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                        Moderasi
                    </p>

                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $currentStatus['class'] }}">
                        <i class="bi {{ $currentStatus['icon'] }}"></i>
                        {{ $currentStatus['label'] }}
                    </span>
                </div>

                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                    Moderasi Jasa
                </h1>

                <p class="mt-1 max-w-3xl text-sm text-[#667D73] dark:text-[#A9BCB2]">
                    Periksa informasi jasa dan tentukan status publikasinya di marketplace.
                </p>
            </div>
        </div>


        {{-- Validation Error --}}
        @if ($errors->any())
            <div class="rounded-2xl border border-[#F0C8C8] bg-[#FFF5F5] px-4 py-4 dark:border-[#6A3B3B] dark:bg-[#2A1919]">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#FDE8E8] text-[#C62828] dark:bg-[#4A2525] dark:text-[#F39A9A]">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-[#991B1B] dark:text-[#FFAAAA]">
                            Ada data yang perlu diperbaiki
                        </p>

                        <ul class="mt-2 space-y-1 text-sm text-[#7F4B4B] dark:text-[#D0A7A7]">
                            @foreach ($errors->all() as $error)
                                <li class="flex gap-2">
                                    <span>•</span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif


        {{-- Main Layout --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">


            {{-- Left --}}
            <div class="space-y-6">

                {{-- Service Overview --}}
                <div class="overflow-hidden rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

                    {{-- Image --}}
                    <div class="aspect-[16/7] w-full bg-[#EEF6F1] dark:bg-[#1B3024]">

                        @if ($service->thumbnail)
                            <img
                                src="{{ asset('storage/' . $service->thumbnail) }}"
                                alt="{{ $service->title }}"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <div class="text-center">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#DDEDE4] text-[#1E9E5A] dark:bg-[#284536] dark:text-[#7AD8B5]">
                                        <i class="bi bi-image text-2xl"></i>
                                    </div>

                                    <p class="mt-3 text-sm text-[#71837B] dark:text-[#91A69C]">
                                        Belum ada thumbnail
                                    </p>
                                </div>
                            </div>
                        @endif

                    </div>


                    {{-- Service Data --}}
                    <div class="p-6">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                            <div class="min-w-0">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                                    Judul Jasa
                                </p>

                                <h2 class="mt-1 text-xl font-semibold leading-7 text-[#123128] dark:text-white">
                                    {{ $service->title }}
                                </h2>
                            </div>

                            <div class="shrink-0 text-left sm:text-right">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                                    Harga Mulai
                                </p>

                                <p class="mt-1 text-xl font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                    Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                </p>
                            </div>

                        </div>


                        {{-- Quick Stats --}}
                        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">

                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#2E473A] dark:bg-[#17271F]">
                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Rating
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128] dark:text-white">
                                    {{ number_format((float) $service->rating, 1) }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#2E473A] dark:bg-[#17271F]">
                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Review
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128] dark:text-white">
                                    {{ $service->reviews_count }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#2E473A] dark:bg-[#17271F]">
                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Pesanan
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128] dark:text-white">
                                    {{ $service->orders_count }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#2E473A] dark:bg-[#17271F]">
                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Pengerjaan
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128] dark:text-white">
                                    {{ $service->delivery_days }} hari
                                </p>
                            </div>

                        </div>


                        {{-- Description --}}
                        <div class="mt-7 border-t border-[#E1EBE6] pt-6 dark:border-[#294036]">

                            <h3 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Deskripsi Jasa
                            </h3>

                            <div class="mt-3 whitespace-pre-line text-sm leading-7 text-[#536B60] dark:text-[#B7C7C0]">
                                {{ $service->description ?: 'Freelancer belum memberikan deskripsi jasa.' }}
                            </div>

                        </div>


                        {{-- Category --}}
                        <div class="mt-7 border-t border-[#E1EBE6] pt-6 dark:border-[#294036]">

                            <h3 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Kategori
                            </h3>

                            <div class="mt-3 flex flex-wrap gap-2">

                                @if ($service->category)
                                    <span class="inline-flex items-center gap-2 rounded-xl bg-[#EAF7EF] px-3.5 py-2 text-sm font-medium text-[#1E7045] dark:bg-[#234632] dark:text-[#A4E5BA]">
                                        <i class="bi bi-grid-1x2-fill"></i>
                                        {{ $service->category->name }}
                                    </span>
                                @endif

                                @if ($service->subcategory)
                                    <span class="inline-flex items-center gap-2 rounded-xl border border-[#D6E4DD] bg-white px-3.5 py-2 text-sm font-medium text-[#536B60] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#C1CEC8]">
                                        <i class="bi bi-diagram-3"></i>
                                        {{ $service->subcategory->name }}
                                    </span>
                                @endif

                                @if (!$service->category && !$service->subcategory)
                                    <span class="text-sm text-[#71837B] dark:text-[#8FA59A]">
                                        Belum memiliki kategori.
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Freelancer --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Pemilik Jasa
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Informasi freelancer
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 flex items-center gap-4">

                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full border border-[#D6E4DD] bg-[#EAF7EF] dark:border-[#2E473A] dark:bg-[#234632]">

                            @if ($freelancer?->avatar)

                                <img
                                    src="{{ asset('storage/' . $freelancer->avatar) }}"
                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                    class="h-full w-full object-cover"
                                >

                            @elseif ($freelancerUser)

                                <div class="flex h-full w-full items-center justify-center text-lg font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                    {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                </div>

                            @else

                                <div class="flex h-full w-full items-center justify-center">
                                    <i class="bi bi-person text-xl text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                                </div>

                            @endif

                        </div>


                        <div class="min-w-0 flex-1">

                            <p class="truncate text-sm font-semibold text-[#123128] dark:text-white">
                                {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                            </p>

                            @if ($freelancer?->username)
                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    {{ '@' . $freelancer->username }}
                                </p>
                            @endif

                            @if ($freelancer?->headline)
                                <p class="mt-1 truncate text-sm text-[#536B60] dark:text-[#AFC0B8]">
                                    {{ $freelancer->headline }}
                                </p>
                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- Right --}}
            <div class="space-y-6">


                {{-- Moderation Form --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Status Jasa
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Tentukan status publikasi
                            </p>
                        </div>

                    </div>


                    <form
                        action="{{ route('admin.services.update', $service) }}"
                        method="POST"
                        class="mt-6 space-y-5"
                    >
                        @csrf
                        @method('PATCH')


                        {{-- Status --}}
                        <div>

                            <label
                                for="status"
                                class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                            >
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                            >
                                <option value="draft" @selected(old('status', $service->status) === 'draft')>
                                    Draft
                                </option>

                                <option value="published" @selected(old('status', $service->status) === 'published')>
                                    Published
                                </option>

                                <option value="paused" @selected(old('status', $service->status) === 'paused')>
                                    Paused
                                </option>

                                <option value="rejected" @selected(old('status', $service->status) === 'rejected')>
                                    Rejected
                                </option>
                            </select>

                            <p class="mt-2 text-xs leading-5 text-[#71837B] dark:text-[#8FA59A]">
                                Pilih status yang sesuai dengan hasil pemeriksaan jasa.
                            </p>

                        </div>


                        {{-- Current Status Info --}}
                        <div class="rounded-xl border {{ $currentStatus['class'] }} px-4 py-3">

                            <div class="flex items-start gap-3">

                                <i class="bi {{ $currentStatus['icon'] }} mt-0.5"></i>

                                <div>
                                    <p class="text-xs font-semibold">
                                        Status saat ini: {{ $currentStatus['label'] }}
                                    </p>

                                    <p class="mt-1 text-xs leading-5 opacity-90">
                                        {{ $currentStatus['description'] }}
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- Featured --}}
                        <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#3A5245] dark:bg-[#17271F]">

                            <label class="flex cursor-pointer items-start gap-3">

                                <input
                                    type="checkbox"
                                    name="is_featured"
                                    value="1"
                                    @checked(old('is_featured', $service->is_featured))
                                    class="mt-0.5 h-4 w-4 rounded border-[#AFC2B8] text-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#506B5E] dark:bg-[#16251D] dark:focus:ring-[#214532]"
                                >

                                <span>
                                    <span class="block text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        Jadikan Jasa Unggulan
                                    </span>

                                    <span class="mt-1 block text-xs leading-5 text-[#71837B] dark:text-[#8FA59A]">
                                        Jasa dapat ditandai sebagai unggulan untuk membantu menampilkannya lebih menonjol di marketplace.
                                    </span>
                                </span>

                            </label>

                        </div>


                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#17844A] focus:outline-none focus:ring-4 focus:ring-[#D8F3E2] dark:focus:ring-[#28533B]"
                        >
                            <i class="bi bi-check2-circle"></i>
                            Simpan Moderasi
                        </button>

                    </form>

                </div>


                {{-- Checklist --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-[#F8FCF9] p-6 dark:border-[#2E473A] dark:bg-[#17271F]">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm dark:bg-[#1D3025] dark:text-[#7AD8B5]">
                            <i class="bi bi-list-check"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Checklist Moderasi
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-[#71837B] dark:text-[#8FA59A]">
                                Gunakan poin berikut saat memeriksa jasa.
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 space-y-3">

                        <div class="flex items-start gap-3">
                            <i class="bi bi-check-circle mt-0.5 text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                            <p class="text-sm text-[#536B60] dark:text-[#B7C7C0]">
                                Judul jasa jelas dan sesuai layanan yang ditawarkan.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="bi bi-check-circle mt-0.5 text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                            <p class="text-sm text-[#536B60] dark:text-[#B7C7C0]">
                                Deskripsi menjelaskan layanan dengan informasi yang cukup.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="bi bi-check-circle mt-0.5 text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                            <p class="text-sm text-[#536B60] dark:text-[#B7C7C0]">
                                Kategori dan subkategori sesuai dengan jasa.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="bi bi-check-circle mt-0.5 text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                            <p class="text-sm text-[#536B60] dark:text-[#B7C7C0]">
                                Harga dan estimasi pengerjaan masuk akal.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="bi bi-check-circle mt-0.5 text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                            <p class="text-sm text-[#536B60] dark:text-[#B7C7C0]">
                                Thumbnail atau konten visual sesuai dengan layanan.
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Service ID --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                ID Jasa
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                #{{ $service->id }}
                            </p>
                        </div>

                        <a
                            href="{{ route('admin.services.show', $service) }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-[#BFCFC7] bg-white px-3.5 py-2.5 text-sm font-medium text-[#486258] transition hover:border-[#AFC2B8] hover:bg-[#F6FAF8] hover:text-[#1E9E5A] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#AFC0B8] dark:hover:border-[#4C695B] dark:hover:bg-[#1D3327] dark:hover:text-[#7AD8B5]"
                        >
                            <i class="bi bi-eye"></i>
                            Detail
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-layouts.admin>