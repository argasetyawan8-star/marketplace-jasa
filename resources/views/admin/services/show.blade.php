<x-layouts.admin title="Detail Jasa">

    @php
        $freelancer = $service->freelancerProfile;
        $freelancerUser = $freelancer?->user;

        $statusMap = [
            'draft' => [
                'label' => 'Draft',
                'class' => 'bg-[#F3F4F6] text-[#4B5563] dark:bg-[#26352D] dark:text-[#C3CEC8]',
                'icon' => 'bi-file-earmark',
            ],
            'published' => [
                'label' => 'Published',
                'class' => 'bg-[#DCFCE7] text-[#166534] dark:bg-[#244732] dark:text-[#A0E8B7]',
                'icon' => 'bi-check-circle-fill',
            ],
            'paused' => [
                'label' => 'Paused',
                'class' => 'bg-[#FEF3C7] text-[#92400E] dark:bg-[#48391E] dark:text-[#E8C67A]',
                'icon' => 'bi-pause-circle-fill',
            ],
            'rejected' => [
                'label' => 'Rejected',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] dark:bg-[#492727] dark:text-[#F0A3A3]',
                'icon' => 'bi-x-circle-fill',
            ],
        ];

        $serviceStatus = $statusMap[$service->status] ?? [
            'label' => ucfirst($service->status ?? 'Unknown'),
            'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
            'icon' => 'bi-question-circle',
        ];
    @endphp


    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>
                <a
                    href="{{ route('admin.services.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#1E9E5A] dark:text-[#93A89F] dark:hover:text-[#7AD8B5]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke daftar jasa
                </a>

                <div class="mt-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                            Detail Jasa
                        </p>

                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $serviceStatus['class'] }}">
                            <i class="bi {{ $serviceStatus['icon'] }}"></i>
                            {{ $serviceStatus['label'] }}
                        </span>
                    </div>

                    <h1 class="mt-2 max-w-4xl text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                        {{ $service->title }}
                    </h1>

                    <p class="mt-2 text-sm text-[#667D73] dark:text-[#A9BCB2]">
                        Kelola informasi dan status publikasi jasa freelancer.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('admin.services.edit', $service) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#1E9E5A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#17844A] focus:outline-none focus:ring-4 focus:ring-[#D8F3E2] dark:focus:ring-[#28533B]"
                >
                    <i class="bi bi-pencil-square"></i>
                    Moderasi Jasa
                </a>

                <form
                    action="{{ route('admin.services.destroy', $service) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus jasa ini? Tindakan ini tidak dapat dibatalkan.')"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-xl border border-[#E1CACA] bg-white px-4 py-2.5 text-sm font-semibold text-[#A33A3A] transition hover:border-[#D59F9F] hover:bg-[#FFF7F7] dark:border-[#603838] dark:bg-[#16251D] dark:text-[#F0AAAA] dark:hover:border-[#774848] dark:hover:bg-[#251817]"
                    >
                        <i class="bi bi-trash3"></i>
                        Hapus
                    </button>
                </form>

            </div>
        </div>


        {{-- Success --}}
        @if (session('success'))
            <div class="rounded-2xl border border-[#BFE7CE] bg-[#F0FBF4] px-4 py-3 dark:border-[#315C43] dark:bg-[#14271C]">
                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#DCFCE7] text-[#15803D] dark:bg-[#234632] dark:text-[#8FE2AB]">
                        <i class="bi bi-check-lg"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-[#166534] dark:text-[#9BE7B0]">
                            Berhasil
                        </p>

                        <p class="mt-0.5 text-sm text-[#47705A] dark:text-[#B0C5B9]">
                            {{ session('success') }}
                        </p>
                    </div>

                </div>
            </div>
        @endif


        {{-- Main Content --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">


            {{-- Left --}}
            <div class="space-y-6">

                {{-- Service Preview --}}
                <div class="overflow-hidden rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

                    {{-- Thumbnail --}}
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

                                    <p class="mt-3 text-sm font-medium text-[#71837B] dark:text-[#91A69C]">
                                        Belum ada thumbnail
                                    </p>
                                </div>
                            </div>
                        @endif

                    </div>


                    {{-- Service Information --}}
                    <div class="p-6">

                        <div class="flex flex-wrap items-start justify-between gap-4">

                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                                    Mulai dari
                                </p>

                                <p class="mt-1 text-2xl font-semibold text-[#123128] dark:text-white">
                                    Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2">

                                @if ($service->is_featured)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-xs font-semibold text-[#166534] dark:bg-[#244732] dark:text-[#A0E8B7]">
                                        <i class="bi bi-star-fill"></i>
                                        Jasa Unggulan
                                    </span>
                                @endif

                            </div>

                        </div>


                        {{-- Stats --}}
                        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">

                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#2E473A] dark:bg-[#17271F]">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    <i class="bi bi-star-fill"></i>
                                </div>

                                <p class="mt-3 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Rating
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128] dark:text-white">
                                    {{ number_format((float) $service->rating, 1) }}
                                </p>
                            </div>


                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#2E473A] dark:bg-[#17271F]">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    <i class="bi bi-chat-square-text"></i>
                                </div>

                                <p class="mt-3 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Review
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128] dark:text-white">
                                    {{ $service->reviews_count }}
                                </p>
                            </div>


                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#2E473A] dark:bg-[#17271F]">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    <i class="bi bi-bag-check"></i>
                                </div>

                                <p class="mt-3 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Pesanan
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128] dark:text-white">
                                    {{ $service->orders_count }}
                                </p>
                            </div>


                            <div class="rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#2E473A] dark:bg-[#17271F]">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    <i class="bi bi-clock"></i>
                                </div>

                                <p class="mt-3 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Pengerjaan
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128] dark:text-white">
                                    {{ $service->delivery_days }} hari
                                </p>
                            </div>

                        </div>


                        {{-- Description --}}
                        <div class="mt-8">

                            <h2 class="text-base font-semibold text-[#123128] dark:text-white">
                                Deskripsi Jasa
                            </h2>

                            <div class="mt-3 whitespace-pre-line text-sm leading-7 text-[#536B60] dark:text-[#B7C7C0]">
                                {{ $service->description ?: 'Freelancer belum memberikan deskripsi jasa.' }}
                            </div>

                        </div>


                        {{-- Category --}}
                        <div class="mt-8 border-t border-[#E1EBE6] pt-6 dark:border-[#294036]">

                            <h2 class="text-base font-semibold text-[#123128] dark:text-white">
                                Kategori
                            </h2>

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


                {{-- Additional Info --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Informasi Sistem
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Informasi teknis jasa di marketplace.
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 grid gap-4 sm:grid-cols-2">

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                ID Jasa
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                #{{ $service->id }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Slug
                            </p>

                            <p class="mt-1 break-all text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $service->slug }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Dibuat
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $service->created_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Diperbarui
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $service->updated_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Right --}}
            <div class="space-y-6">

                {{-- Freelancer Card --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Freelancer
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Pemilik jasa
                            </p>
                        </div>

                    </div>


                    <div class="mt-5">

                        <div class="flex items-center gap-3">

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


                            <div class="min-w-0">

                                <p class="truncate text-sm font-semibold text-[#123128] dark:text-white">
                                    {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                </p>

                                @if ($freelancer?->username)
                                    <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        {{ '@' . $freelancer->username }}
                                    </p>
                                @endif

                            </div>

                        </div>


                        @if ($freelancer?->headline)
                            <p class="mt-4 text-sm leading-6 text-[#536B60] dark:text-[#B7C7C0]">
                                {{ $freelancer->headline }}
                            </p>
                        @endif


                        @if ($freelancer?->location)
                            <div class="mt-4 flex items-center gap-2 text-sm text-[#667D73] dark:text-[#A9BCB2]">
                                <i class="bi bi-geo-alt"></i>
                                {{ $freelancer->location }}
                            </div>
                        @endif


                        @if ($freelancer)
                            <div class="mt-5 grid grid-cols-2 gap-3">

                                <div class="rounded-xl bg-[#F8FCF9] p-3 dark:bg-[#17271F]">
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Rating
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                        {{ number_format((float) $freelancer->rating, 1) }}
                                    </p>
                                </div>

                                <div class="rounded-xl bg-[#F8FCF9] p-3 dark:bg-[#17271F]">
                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Pesanan selesai
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                        {{ $freelancer->completed_orders }}
                                    </p>
                                </div>

                            </div>
                        @endif

                    </div>

                </div>


                {{-- Moderation --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Moderasi
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Kelola status jasa
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 space-y-3">

                        <a
                            href="{{ route('admin.services.edit', $service) }}"
                            class="flex items-center justify-between rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] px-4 py-3 transition hover:border-[#AFC2B8] hover:bg-[#F2F8F4] dark:border-[#3A5245] dark:bg-[#17271F] dark:hover:border-[#4C695B] dark:hover:bg-[#1D3327]"
                        >
                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    <i class="bi bi-pencil-square"></i>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        Ubah status
                                    </p>

                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Publish, pause, reject, atau draft
                                    </p>
                                </div>

                            </div>

                            <i class="bi bi-chevron-right text-[#8AA096] dark:text-[#718A7E]"></i>
                        </a>


                        <a
                            href="{{ route('marketplace.service', $service->slug) }}"
                            target="_blank"
                            class="flex items-center justify-between rounded-xl border border-[#D6E4DD] bg-white px-4 py-3 transition hover:border-[#AFC2B8] hover:bg-[#F7FAF8] dark:border-[#3A5245] dark:bg-[#16251D] dark:hover:border-[#4C695B] dark:hover:bg-[#1D3327]"
                        >
                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F1F5F3] text-[#536B60] dark:bg-[#26352D] dark:text-[#AFC0B8]">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        Lihat di marketplace
                                    </p>

                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Buka halaman publik jasa
                                    </p>
                                </div>

                            </div>

                            <i class="bi bi-chevron-right text-[#8AA096] dark:text-[#718A7E]"></i>
                        </a>

                    </div>

                </div>


                {{-- Quick Status --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-[#F8FCF9] p-6 dark:border-[#2E473A] dark:bg-[#17271F]">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm dark:bg-[#1D3025] dark:text-[#7AD8B5]">
                            <i class="bi bi-lightbulb-fill"></i>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                Catatan moderasi
                            </p>

                            <p class="mt-1 text-sm leading-6 text-[#667D73] dark:text-[#A9BCB2]">
                                Pastikan judul, deskripsi, kategori, harga, dan konten jasa sesuai standar marketplace sebelum dipublikasikan.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-layouts.admin>