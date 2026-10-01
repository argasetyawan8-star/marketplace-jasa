<x-layouts.admin title="Kelola Jasa">


@php
    $statusMap = [
        'draft' => [
            'label' => 'Draft',
            'class' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
            'icon' => 'bi-file-earmark',
        ],
        'published' => [
            'label' => 'Published',
            'class' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
            'icon' => 'bi-check-circle-fill',
        ],
        'paused' => [
            'label' => 'Paused',
            'class' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
            'icon' => 'bi-pause-circle-fill',
        ],
        'rejected' => [
            'label' => 'Rejected',
            'class' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300',
            'icon' => 'bi-x-circle-fill',
        ],
    ];
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:border-blue-900/50 dark:bg-blue-900/20 dark:text-blue-300">
                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                Marketplace
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Kelola Jasa
            </h1>

            <p class="mt-1.5 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Kelola, pantau, dan moderasi jasa yang dibuat oleh freelancer di ProKerja.
            </p>
        </div>

        <div class="flex items-center">
            <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                    <i class="bi bi-briefcase-fill"></i>
                </div>

                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400">
                        Total Jasa
                    </p>

                    <p class="mt-0.5 text-lg font-bold text-slate-900 dark:text-white">
                        {{ $services->total() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Flash Success --}}
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-900/50 dark:bg-emerald-900/15">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-sm leading-6 text-emerald-700 dark:text-emerald-200/80">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Flash Error --}}
    @if (session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 dark:border-red-900/50 dark:bg-red-900/15">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-300">
                    <i class="bi bi-exclamation-circle"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                        Perhatian
                    </p>

                    <p class="mt-0.5 text-sm leading-6 text-red-700 dark:text-red-200/80">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Filter --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                        Filter Jasa
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Cari jasa berdasarkan judul, deskripsi, atau status.
                    </p>
                </div>
            </div>
        </div>

        <form
            action="{{ route('admin.services.index') }}"
            method="GET"
            class="p-5"
        >
            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_220px_auto] lg:items-end">

                {{-- Search --}}
                <div>
                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                    >
                        Cari jasa
                    </label>

                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <i class="bi bi-search text-slate-400"></i>
                        </div>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari judul atau deskripsi jasa..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-400 dark:focus:ring-blue-400/10"
                        >
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-400 dark:focus:ring-blue-400/10"
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
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15 lg:w-auto"
                    >
                        <i class="bi bi-search"></i>
                        Cari
                    </button>

                    @if ($search !== '' || $status)
                        <a
                            href="{{ route('admin.services.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:border-slate-600 dark:hover:bg-slate-900 dark:hover:text-white"
                        >
                            Reset
                        </a>
                    @endif
                </div>

            </div>
        </form>
    </div>

    {{-- Table / List --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- Table Header --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-800">
            <div>
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                    Daftar Jasa
                </h2>

                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                    Menampilkan {{ $services->firstItem() ?? 0 }}–{{ $services->lastItem() ?? 0 }}
                    dari {{ $services->total() }} jasa
                </p>
            </div>

            <div class="hidden items-center gap-2 text-xs text-slate-500 sm:flex dark:text-slate-400">
                <i class="bi bi-shield-check text-blue-600 dark:text-blue-400"></i>
                Moderasi admin
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto md:block">
            <table class="min-w-full">

                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 dark:border-slate-800 dark:bg-slate-950/60">
                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Jasa
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Freelancer
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Kategori
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Harga
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Status
                        </th>

                        <th class="px-5 py-3.5 text-right text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($services as $service)

                        @php
                            $freelancer = $service->freelancerProfile;
                            $freelancerUser = $freelancer?->user;

                            $serviceStatus = $statusMap[$service->status] ?? [
                                'label' => ucfirst($service->status ?? 'Unknown'),
                                'class' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
                                'icon' => 'bi-question-circle',
                            ];
                        @endphp

                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-950/40">

                            {{-- Service --}}
                            <td class="px-5 py-4">
                                <div class="flex min-w-[290px] items-center gap-3.5">

                                    <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-100 dark:border-slate-700 dark:bg-slate-800">
                                        @if ($service->thumbnail)
                                            <img
                                                src="{{ asset('storage/' . $service->thumbnail) }}"
                                                alt="{{ $service->title }}"
                                                class="h-full w-full object-cover"
                                            >
                                        @else
                                            <div class="flex h-full w-full items-center justify-center">
                                                <i class="bi bi-image text-xl text-slate-400"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <a
                                            href="{{ route('admin.services.show', $service) }}"
                                            class="line-clamp-2 text-sm font-semibold text-slate-900 transition hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                        >
                                            {{ $service->title }}
                                        </a>

                                        <div class="mt-1.5 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                                            <span class="inline-flex items-center">
                                                <i class="bi bi-star-fill mr-1 text-amber-400"></i>
                                                {{ number_format((float) $service->rating, 1) }}
                                            </span>

                                            <span class="inline-flex items-center">
                                                <i class="bi bi-bag-check mr-1"></i>
                                                {{ $service->orders_count }} order
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Freelancer --}}
                            <td class="px-5 py-4">
                                <div class="flex min-w-[190px] items-center gap-3">

                                    <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-blue-100 bg-blue-50 dark:border-blue-900/50 dark:bg-blue-900/20">
                                        @if ($freelancer?->avatar)
                                            <img
                                                src="{{ asset('storage/' . $freelancer->avatar) }}"
                                                alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                                class="h-full w-full object-cover"
                                            >
                                        @elseif ($freelancerUser)
                                            <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-blue-600 dark:text-blue-300">
                                                {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                            </div>
                                        @else
                                            <div class="flex h-full w-full items-center justify-center">
                                                <i class="bi bi-person text-blue-500 dark:text-blue-300"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-200">
                                            {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                        </p>

                                        @if ($freelancer?->username)
                                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                                {{ '@' . $freelancer->username }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-5 py-4">
                                <div class="min-w-[150px]">
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                        {{ $service->category?->name ?? 'Tanpa kategori' }}
                                    </p>

                                    @if ($service->subcategory?->name)
                                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                            {{ $service->subcategory->name }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            {{-- Price --}}
                            <td class="px-5 py-4">
                                <div class="min-w-[120px]">
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">
                                        Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                        {{ $service->delivery_days }} hari
                                    </p>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">
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
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-400 dark:hover:border-blue-900/50 dark:hover:bg-blue-900/20 dark:hover:text-blue-300"
                                        title="Lihat detail"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a
                                        href="{{ route('admin.services.edit', $service) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-300 dark:hover:bg-blue-900/35"
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

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                                    <i class="bi bi-briefcase text-2xl"></i>
                                </div>

                                <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">
                                    Jasa belum ditemukan
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500 dark:text-slate-400">
                                    Belum ada jasa yang sesuai dengan pencarian atau filter yang dipilih.
                                </p>

                                @if ($search !== '' || $status)
                                    <a
                                        href="{{ route('admin.services.index') }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700"
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
        <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">

            @forelse ($services as $service)

                @php
                    $freelancer = $service->freelancerProfile;
                    $freelancerUser = $freelancer?->user;

                    $serviceStatus = $statusMap[$service->status] ?? [
                        'label' => ucfirst($service->status ?? 'Unknown'),
                        'class' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
                        'icon' => 'bi-question-circle',
                    ];
                @endphp

                <div class="p-4 sm:p-5">

                    <div class="flex gap-3.5">

                        {{-- Thumbnail --}}
                        <div class="h-20 w-20 shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 dark:border-slate-700 dark:bg-slate-800">
                            @if ($service->thumbnail)
                                <img
                                    src="{{ asset('storage/' . $service->thumbnail) }}"
                                    alt="{{ $service->title }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center">
                                    <i class="bi bi-image text-xl text-slate-400"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="min-w-0 flex-1">

                            <div class="flex items-start justify-between gap-3">
                                <a
                                    href="{{ route('admin.services.show', $service) }}"
                                    class="line-clamp-2 text-sm font-semibold leading-5 text-slate-900 transition hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                >
                                    {{ $service->title }}
                                </a>

                                <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $serviceStatus['class'] }}">
                                    <i class="bi {{ $serviceStatus['icon'] }}"></i>
                                    {{ $serviceStatus['label'] }}
                                </span>
                            </div>

                            <div class="mt-2.5 space-y-1.5">

                                <p class="truncate text-xs text-slate-500 dark:text-slate-400">
                                    <i class="bi bi-person mr-1"></i>
                                    {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                </p>

                                <p class="truncate text-xs text-slate-500 dark:text-slate-400">
                                    <i class="bi bi-grid mr-1"></i>
                                    {{ $service->category?->name ?? 'Tanpa kategori' }}
                                </p>

                                <p class="text-sm font-bold text-slate-900 dark:text-white">
                                    Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>
                    </div>

                    {{-- Mobile Footer --}}
                    <div class="mt-4 flex items-center justify-between gap-3 border-t border-slate-100 pt-4 dark:border-slate-800">

                        <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                            <span class="inline-flex items-center">
                                <i class="bi bi-star-fill mr-1 text-amber-400"></i>
                                {{ number_format((float) $service->rating, 1) }}
                            </span>

                            <span class="inline-flex items-center">
                                <i class="bi bi-bag-check mr-1"></i>
                                {{ $service->orders_count }} order
                            </span>
                        </div>

                        <div class="flex shrink-0 gap-2">

                            <a
                                href="{{ route('admin.services.show', $service) }}"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-400 dark:hover:border-blue-900/50 dark:hover:bg-blue-900/20 dark:hover:text-blue-300"
                                title="Lihat detail"
                            >
                                <i class="bi bi-eye"></i>
                            </a>

                            <a
                                href="{{ route('admin.services.edit', $service) }}"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-300 dark:hover:bg-blue-900/35"
                                title="Moderasi jasa"
                            >
                                <i class="bi bi-pencil-square"></i>
                            </a>

                        </div>

                    </div>
                </div>

            @empty

                <div class="px-6 py-14 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-briefcase text-2xl"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">
                        Jasa belum ditemukan
                    </h3>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Tidak ada jasa yang sesuai.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($services->hasPages())
            <div class="border-t border-slate-100 px-4 py-4 sm:px-5 dark:border-slate-800">
                {{ $services->links() }}
            </div>
        @endif

    </div>

</div>


</x-layouts.admin>
