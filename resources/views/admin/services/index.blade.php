<x-layouts.admin title="Kelola Jasa">

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                    Marketplace
                </p>

                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                    Kelola Jasa
                </h1>

                <p class="mt-1 text-sm text-[#667D73] dark:text-[#A9BCB2]">
                    Kelola dan moderasi jasa yang dibuat oleh freelancer.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <div class="rounded-xl border border-[#D6E4DD] bg-white px-4 py-2.5 dark:border-[#2E473A] dark:bg-[#13221A]">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-briefcase-fill text-[#1E9E5A] dark:text-[#7AD8B5]"></i>

                        <div>
                            <p class="text-[11px] font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                                Total
                            </p>

                            <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                {{ $services->total() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Flash Success --}}
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


        {{-- Flash Error --}}
        @if (session('error'))
            <div class="rounded-2xl border border-[#F0C8C8] bg-[#FFF5F5] px-4 py-3 dark:border-[#6A3B3B] dark:bg-[#2A1919]">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#FDE8E8] text-[#C62828] dark:bg-[#4A2525] dark:text-[#F39A9A]">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-[#991B1B] dark:text-[#FFAAAA]">
                            Perhatian
                        </p>

                        <p class="mt-0.5 text-sm text-[#7F4B4B] dark:text-[#D0A7A7]">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif


        {{-- Filter --}}
        <div class="rounded-2xl border border-[#D6E4DD] bg-white p-5 dark:border-[#2E473A] dark:bg-[#13221A]">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                        Filter Jasa
                    </h2>

                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                        Cari jasa berdasarkan judul atau status.
                    </p>
                </div>
            </div>

            <form
                action="{{ route('admin.services.index') }}"
                method="GET"
                class="grid gap-4 lg:grid-cols-[1fr_220px_auto]"
            >

                {{-- Search --}}
                <div>
                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                    >
                        Cari jasa
                    </label>

                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <i class="bi bi-search text-[#80948A] dark:text-[#80988C]"></i>
                        </div>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari judul atau deskripsi jasa..."
                            class="w-full rounded-xl border border-[#BFCFC7] bg-white py-3 pl-10 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#95A79F] hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:placeholder:text-[#789086] dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                        >
                    </div>
                </div>

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
                        class="w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                    >
                        <option value="">Semua status</option>
                        <option value="draft" @selected($status === 'draft')>
                            Draft
                        </option>
                        <option value="published" @selected($status === 'published')>
                            Published
                        </option>
                        <option value="paused" @selected($status === 'paused')>
                            Paused
                        </option>
                        <option value="rejected" @selected($status === 'rejected')>
                            Rejected
                        </option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex items-end gap-2">
                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#17844A] focus:outline-none focus:ring-4 focus:ring-[#D8F3E2] dark:focus:ring-[#28533B] lg:w-auto"
                    >
                        <i class="bi bi-search"></i>
                        Cari
                    </button>

                    @if ($search !== '' || $status)
                        <a
                            href="{{ route('admin.services.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm font-medium text-[#355247] transition hover:border-[#AFC2B8] hover:bg-[#F6FAF8] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#C4D2CC] dark:hover:border-[#4C695B] dark:hover:bg-[#1A3024]"
                        >
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>


        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

            {{-- Table Header --}}
            <div class="flex flex-col gap-2 border-b border-[#D6E4DD] px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-[#2E473A]">
                <div>
                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                        Daftar Jasa
                    </h2>

                    <p class="mt-0.5 text-xs text-[#71837B] dark:text-[#8FA59A]">
                        Menampilkan {{ $services->firstItem() ?? 0 }}–{{ $services->lastItem() ?? 0 }}
                        dari {{ $services->total() }} jasa
                    </p>
                </div>

                <div class="hidden items-center gap-2 text-xs text-[#71837B] sm:flex dark:text-[#8FA59A]">
                    <i class="bi bi-shield-check text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                    Moderasi admin
                </div>
            </div>


            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-[#D6E4DD] bg-[#F8FCF9] dark:border-[#2E473A] dark:bg-[#17271F]">
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Jasa
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Freelancer
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Kategori
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Harga
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Status
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#E5EEE9] dark:divide-[#294036]">

                        @forelse ($services as $service)

                            <tr class="transition hover:bg-[#F8FCF9] dark:hover:bg-[#17271F]">

                                {{-- Service --}}
                                <td class="px-5 py-4">
                                    <div class="flex min-w-[290px] items-center gap-3">

                                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl border border-[#D6E4DD] bg-[#EEF6F1] dark:border-[#2E473A] dark:bg-[#1D3327]">
                                            @if ($service->thumbnail)
                                                <img
                                                    src="{{ asset('storage/' . $service->thumbnail) }}"
                                                    alt="{{ $service->title }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @else
                                                <div class="flex h-full w-full items-center justify-center">
                                                    <i class="bi bi-image text-xl text-[#8BA198] dark:text-[#779188]"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <a
                                                href="{{ route('admin.services.show', $service) }}"
                                                class="line-clamp-2 text-sm font-semibold text-[#123128] transition hover:text-[#1E9E5A] dark:text-white dark:hover:text-[#7AD8B5]"
                                            >
                                                {{ $service->title }}
                                            </a>

                                            <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                <span>
                                                    <i class="bi bi-star-fill mr-1 text-[#F0B429]"></i>
                                                    {{ number_format((float) $service->rating, 1) }}
                                                </span>

                                                <span>
                                                    <i class="bi bi-bag-check mr-1"></i>
                                                    {{ $service->orders_count }} order
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </td>


                                {{-- Freelancer --}}
                                <td class="px-5 py-4">
                                    @php
                                        $freelancer = $service->freelancerProfile;
                                        $freelancerUser = $freelancer?->user;
                                    @endphp

                                    <div class="flex min-w-[190px] items-center gap-3">

                                        <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-[#D6E4DD] bg-[#EAF7EF] dark:border-[#2E473A] dark:bg-[#234632]">
                                            @if ($freelancer?->avatar)
                                                <img
                                                    src="{{ asset('storage/' . $freelancer->avatar) }}"
                                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @elseif ($freelancerUser)
                                                <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                                    {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                                </div>
                                            @else
                                                <div class="flex h-full w-full items-center justify-center">
                                                    <i class="bi bi-person text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                                {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                            </p>

                                            @if ($freelancer?->username)
                                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                    {{ '@' . $freelancer->username }}
                                                </p>
                                            @endif
                                        </div>

                                    </div>
                                </td>


                                {{-- Category --}}
                                <td class="px-5 py-4">
                                    <div class="min-w-[150px]">
                                        <p class="text-sm font-medium text-[#355247] dark:text-[#D0DED8]">
                                            {{ $service->category?->name ?? 'Tanpa kategori' }}
                                        </p>

                                        @if ($service->subcategory?->name)
                                            <p class="mt-0.5 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                {{ $service->subcategory->name }}
                                            </p>
                                        @endif
                                    </div>
                                </td>


                                {{-- Price --}}
                                <td class="px-5 py-4">
                                    <div class="min-w-[120px]">
                                        <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                            Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                            {{ $service->delivery_days }} hari
                                        </p>
                                    </div>
                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">
                                    @php
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

                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $serviceStatus['class'] }}">
                                        <i class="bi {{ $serviceStatus['icon'] }}"></i>
                                        {{ $serviceStatus['label'] }}
                                    </span>
                                </td>


                                {{-- Action --}}
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.services.show', $service) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-[#D0DED8] bg-white text-[#486258] transition hover:border-[#9EB5AA] hover:bg-[#F4F8F5] hover:text-[#1E9E5A] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#AFC0B8] dark:hover:border-[#4C695B] dark:hover:bg-[#1D3327] dark:hover:text-[#7AD8B5]"
                                            title="Lihat detail"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a
                                            href="{{ route('admin.services.edit', $service) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-[#D0DED8] bg-white text-[#486258] transition hover:border-[#9EB5AA] hover:bg-[#F4F8F5] hover:text-[#1E9E5A] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#AFC0B8] dark:hover:border-[#4C695B] dark:hover:bg-[#1D3327] dark:hover:text-[#7AD8B5]"
                                            title="Moderasi jasa"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                        <i class="bi bi-briefcase text-2xl"></i>
                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-[#123128] dark:text-white">
                                        Jasa belum ditemukan
                                    </h3>

                                    <p class="mx-auto mt-1 max-w-md text-sm text-[#71837B] dark:text-[#8FA59A]">
                                        Belum ada jasa yang sesuai dengan pencarian atau filter yang dipilih.
                                    </p>

                                    @if ($search !== '' || $status)
                                        <a
                                            href="{{ route('admin.services.index') }}"
                                            class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#1E9E5A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#17844A]"
                                        >
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                            Tampilkan semua
                                        </a>
                                    @endif

                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>


            {{-- Mobile Cards --}}
            <div class="divide-y divide-[#E5EEE9] md:hidden dark:divide-[#294036]">

                @forelse ($services as $service)

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

                    <div class="p-5">

                        <div class="flex gap-3">

                            {{-- Thumbnail --}}
                            <div class="h-20 w-20 shrink-0 overflow-hidden rounded-xl border border-[#D6E4DD] bg-[#EEF6F1] dark:border-[#2E473A] dark:bg-[#1D3327]">
                                @if ($service->thumbnail)
                                    <img
                                        src="{{ asset('storage/' . $service->thumbnail) }}"
                                        alt="{{ $service->title }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <i class="bi bi-image text-xl text-[#8BA198] dark:text-[#779188]"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex items-start justify-between gap-3">
                                    <a
                                        href="{{ route('admin.services.show', $service) }}"
                                        class="line-clamp-2 text-sm font-semibold leading-5 text-[#123128] hover:text-[#1E9E5A] dark:text-white dark:hover:text-[#7AD8B5]"
                                    >
                                        {{ $service->title }}
                                    </a>

                                    <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $serviceStatus['class'] }}">
                                        <i class="bi {{ $serviceStatus['icon'] }}"></i>
                                        {{ $serviceStatus['label'] }}
                                    </span>
                                </div>

                                <div class="mt-2 space-y-1">

                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        <i class="bi bi-person mr-1"></i>
                                        {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                    </p>

                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        <i class="bi bi-grid mr-1"></i>
                                        {{ $service->category?->name ?? 'Tanpa kategori' }}
                                    </p>

                                    <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                        Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Mobile Footer --}}
                        <div class="mt-4 flex items-center justify-between gap-3 border-t border-[#E5EEE9] pt-4 dark:border-[#294036]">

                            <div class="flex items-center gap-3 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                <span>
                                    <i class="bi bi-star-fill mr-1 text-[#F0B429]"></i>
                                    {{ number_format((float) $service->rating, 1) }}
                                </span>

                                <span>
                                    <i class="bi bi-bag-check mr-1"></i>
                                    {{ $service->orders_count }} order
                                </span>
                            </div>

                            <div class="flex gap-2">
                                <a
                                    href="{{ route('admin.services.show', $service) }}"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-[#D0DED8] bg-white text-[#486258] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#AFC0B8]"
                                    title="Lihat detail"
                                >
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a
                                    href="{{ route('admin.services.edit', $service) }}"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]"
                                    title="Moderasi jasa"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="px-6 py-14 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-briefcase text-2xl"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-semibold text-[#123128] dark:text-white">
                            Jasa belum ditemukan
                        </h3>

                        <p class="mt-1 text-sm text-[#71837B] dark:text-[#8FA59A]">
                            Tidak ada jasa yang sesuai.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($services->hasPages())
                <div class="border-t border-[#D6E4DD] px-5 py-4 dark:border-[#2E473A]">
                    {{ $services->links() }}
                </div>
            @endif

        </div>

    </div>

</x-layouts.admin>