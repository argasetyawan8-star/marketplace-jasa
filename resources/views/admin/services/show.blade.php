<x-layouts.admin title="Detail Jasa">


@php
    $freelancer = $service->freelancerProfile;
    $freelancerUser = $freelancer?->user;

    $statusMap = [
        'draft' => [
            'label' => 'Draft',
            'class' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
            'icon' => 'bi-file-earmark',
        ],
        'published' => [
            'label' => 'Published',
            'class' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/25 dark:text-emerald-300',
            'icon' => 'bi-check-circle-fill',
        ],
        'paused' => [
            'label' => 'Paused',
            'class' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/25 dark:text-amber-300',
            'icon' => 'bi-pause-circle-fill',
        ],
        'rejected' => [
            'label' => 'Rejected',
            'class' => 'bg-red-50 text-red-700 dark:bg-red-900/25 dark:text-red-300',
            'icon' => 'bi-x-circle-fill',
        ],
    ];

    $serviceStatus = $statusMap[$service->status] ?? [
        'label' => ucfirst($service->status ?? 'Unknown'),
        'class' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
        'icon' => 'bi-question-circle',
    ];
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div class="min-w-0">

            <a
                href="{{ route('admin.services.index') }}"
                class="group inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
            >
                <span class="flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 bg-white transition group-hover:border-blue-200 group-hover:bg-blue-50 dark:border-slate-700 dark:bg-slate-900 dark:group-hover:border-blue-900/50 dark:group-hover:bg-blue-900/20">
                    <i class="bi bi-arrow-left"></i>
                </span>

                Kembali ke daftar jasa
            </a>

            <div class="mt-4">

                <div class="flex flex-wrap items-center gap-2.5">

                    <span class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:border-blue-900/50 dark:bg-blue-900/20 dark:text-blue-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                        Detail Jasa
                    </span>

                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $serviceStatus['class'] }}">
                        <i class="bi {{ $serviceStatus['icon'] }}"></i>
                        {{ $serviceStatus['label'] }}
                    </span>

                </div>

                <h1 class="mt-3 max-w-4xl text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                    {{ $service->title }}
                </h1>

                <p class="mt-1.5 max-w-3xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Kelola informasi dan status publikasi jasa freelancer.
                </p>

            </div>

        </div>

        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">

            <a
                href="{{ route('admin.services.edit', $service) }}"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15 sm:w-auto"
            >
                <i class="bi bi-pencil-square"></i>
                Moderasi Jasa
            </a>

            <form
                action="{{ route('admin.services.destroy', $service) }}"
                method="POST"
                class="w-full sm:w-auto"
                onsubmit="return confirm('Yakin ingin menghapus jasa ini? Tindakan ini tidak dapat dibatalkan.')"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50 focus:outline-none focus:ring-4 focus:ring-red-500/10 dark:border-red-900/50 dark:bg-slate-900 dark:text-red-300 dark:hover:border-red-800 dark:hover:bg-red-900/20 sm:w-auto"
                >
                    <i class="bi bi-trash3"></i>
                    Hapus
                </button>
            </form>

        </div>
    </div>

    {{-- Success --}}
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

    {{-- Main Content --}}
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">

        {{-- Left --}}
        <div class="min-w-0 space-y-6">

            {{-- Service Preview --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                {{-- Thumbnail --}}
                <div class="aspect-[16/7] w-full bg-slate-100 dark:bg-slate-800">
                    @if ($service->thumbnail)

                        <img
                            src="{{ asset('storage/' . $service->thumbnail) }}"
                            alt="{{ $service->title }}"
                            class="h-full w-full object-cover"
                        >

                    @else

                        <div class="flex h-full w-full items-center justify-center">

                            <div class="text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                                    <i class="bi bi-image text-2xl"></i>
                                </div>

                                <p class="mt-3 text-sm font-medium text-slate-500 dark:text-slate-400">
                                    Belum ada thumbnail
                                </p>

                            </div>

                        </div>

                    @endif
                </div>

                {{-- Service Information --}}
                <div class="p-5 sm:p-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                                Mulai dari
                            </p>

                            <p class="mt-1.5 text-2xl font-bold text-slate-900 dark:text-white">
                                Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                            </p>
                        </div>

                        @if ($service->is_featured)
                            <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-900/20 dark:text-blue-300">
                                <i class="bi bi-star-fill"></i>
                                Jasa Unggulan
                            </span>
                        @endif

                    </div>

                    {{-- Stats --}}
                    <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">

                        {{-- Rating --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-500 dark:bg-amber-900/20 dark:text-amber-300">
                                <i class="bi bi-star-fill"></i>
                            </div>

                            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                                Rating
                            </p>

                            <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                                {{ number_format((float) $service->rating, 1) }}
                            </p>
                        </div>

                        {{-- Review --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                                <i class="bi bi-chat-square-text"></i>
                            </div>

                            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                                Review
                            </p>

                            <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                                {{ $service->reviews_count }}
                            </p>
                        </div>

                        {{-- Orders --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-300">
                                <i class="bi bi-bag-check"></i>
                            </div>

                            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                                Pesanan
                            </p>

                            <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                                {{ $service->orders_count }}
                            </p>
                        </div>

                        {{-- Delivery --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-900/20 dark:text-violet-300">
                                <i class="bi bi-clock"></i>
                            </div>

                            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                                Pengerjaan
                            </p>

                            <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                                {{ $service->delivery_days }} hari
                            </p>
                        </div>

                    </div>

                    {{-- Description --}}
                    <div class="mt-8 border-t border-slate-100 pt-6 dark:border-slate-800">

                        <h2 class="text-base font-semibold text-slate-900 dark:text-white">
                            Deskripsi Jasa
                        </h2>

                        <div class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-600 dark:text-slate-300">
                            {{ $service->description ?: 'Freelancer belum memberikan deskripsi jasa.' }}
                        </div>

                    </div>

                    {{-- Category --}}
                    <div class="mt-8 border-t border-slate-100 pt-6 dark:border-slate-800">

                        <h2 class="text-base font-semibold text-slate-900 dark:text-white">
                            Kategori
                        </h2>

                        <div class="mt-3 flex flex-wrap gap-2">

                            @if ($service->category)
                                <span class="inline-flex items-center gap-2 rounded-xl bg-blue-50 px-3.5 py-2 text-sm font-medium text-blue-700 dark:bg-blue-900/20 dark:text-blue-300">
                                    <i class="bi bi-grid-1x2-fill"></i>
                                    {{ $service->category->name }}
                                </span>
                            @endif

                            @if ($service->subcategory)
                                <span class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-slate-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300">
                                    <i class="bi bi-diagram-3"></i>
                                    {{ $service->subcategory->name }}
                                </span>
                            @endif

                            @if (!$service->category && !$service->subcategory)
                                <span class="text-sm text-slate-500 dark:text-slate-400">
                                    Belum memiliki kategori.
                                </span>
                            @endif

                        </div>

                    </div>

                </div>
            </div>

            {{-- Additional Info --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Informasi Sistem
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Informasi teknis jasa di marketplace.
                        </p>
                    </div>

                </div>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">

                    <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            ID Jasa
                        </p>

                        <p class="mt-1 break-all text-sm font-semibold text-slate-800 dark:text-slate-200">
                            #{{ $service->id }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Slug
                        </p>

                        <p class="mt-1 break-all text-sm font-semibold text-slate-800 dark:text-slate-200">
                            {{ $service->slug }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Dibuat
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                            {{ $service->created_at?->format('d M Y, H:i') ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Diperbarui
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                            {{ $service->updated_at?->format('d M Y, H:i') ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

        {{-- Right --}}
        <div class="space-y-6">

            {{-- Freelancer Card --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Freelancer
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Pemilik jasa
                        </p>
                    </div>

                </div>

                <div class="mt-5">

                    <div class="flex items-center gap-3">

                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full border border-blue-100 bg-blue-50 dark:border-blue-900/50 dark:bg-blue-900/20">

                            @if ($freelancer?->avatar)

                                <img
                                    src="{{ asset('storage/' . $freelancer->avatar) }}"
                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                    class="h-full w-full object-cover"
                                >

                            @elseif ($freelancerUser)

                                <div class="flex h-full w-full items-center justify-center text-lg font-bold text-blue-600 dark:text-blue-300">
                                    {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                </div>

                            @else

                                <div class="flex h-full w-full items-center justify-center">
                                    <i class="bi bi-person text-xl text-blue-500 dark:text-blue-300"></i>
                                </div>

                            @endif

                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                            </p>

                            @if ($freelancer?->username)
                                <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                    {{ '@' . $freelancer->username }}
                                </p>
                            @endif

                        </div>

                    </div>

                    @if ($freelancer?->headline)
                        <div class="mt-4 rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">
                            <p class="text-sm leading-6 text-slate-600 dark:text-slate-300">
                                {{ $freelancer->headline }}
                            </p>
                        </div>
                    @endif

                    @if ($freelancer?->location)
                        <div class="mt-4 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                            <i class="bi bi-geo-alt text-blue-500"></i>
                            {{ $freelancer->location }}
                        </div>
                    @endif

                    @if ($freelancer)
                        <div class="mt-5 grid grid-cols-2 gap-3">

                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Rating
                                </p>

                                <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                                    {{ number_format((float) $freelancer->rating, 1) }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Pesanan selesai
                                </p>

                                <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $freelancer->completed_orders }}
                                </p>
                            </div>

                        </div>
                    @endif

                </div>
            </div>

            {{-- Moderation --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Moderasi
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Kelola status jasa
                        </p>
                    </div>

                </div>

                <div class="mt-5 space-y-3">

                    {{-- Edit / Moderation --}}
                    <a
                        href="{{ route('admin.services.edit', $service) }}"
                        class="group flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 transition hover:border-blue-200 hover:bg-blue-50 dark:border-slate-800 dark:bg-slate-950/60 dark:hover:border-blue-900/50 dark:hover:bg-blue-900/15"
                    >
                        <div class="flex min-w-0 items-center gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-300">
                                <i class="bi bi-pencil-square"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                    Ubah status
                                </p>

                                <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                    Publish, pause, reject, atau draft
                                </p>
                            </div>

                        </div>

                        <i class="bi bi-chevron-right shrink-0 text-slate-400 transition group-hover:translate-x-0.5 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400"></i>
                    </a>

                    {{-- Marketplace --}}
                    <a
                        href="{{ route('marketplace.service', $service->slug) }}"
                        target="_blank"
                        class="group flex items-center justify-between rounded-xl border border-slate-200 bg-white px-4 py-3.5 transition hover:border-blue-200 hover:bg-blue-50 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-blue-900/50 dark:hover:bg-blue-900/15"
                    >
                        <div class="flex min-w-0 items-center gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                    Lihat di marketplace
                                </p>

                                <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                    Buka halaman publik jasa
                                </p>
                            </div>

                        </div>

                        <i class="bi bi-chevron-right shrink-0 text-slate-400 transition group-hover:translate-x-0.5 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400"></i>
                    </a>

                </div>
            </div>

            {{-- Quick Status --}}
            <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-5 dark:border-blue-900/40 dark:bg-blue-900/10 sm:p-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                        <i class="bi bi-lightbulb-fill"></i>
                    </div>

                    <div class="min-w-0">

                        <p class="text-sm font-semibold text-slate-900 dark:text-white">
                            Catatan moderasi
                        </p>

                        <p class="mt-1.5 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Pastikan judul, deskripsi, kategori, harga, dan konten jasa sesuai standar marketplace sebelum dipublikasikan.
                        </p>

                    </div>

                </div>

            </div>

            {{-- Current Status --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center justify-between gap-4">

                    <div>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                            Status saat ini
                        </p>

                        <div class="mt-2">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $serviceStatus['class'] }}">
                                <i class="bi {{ $serviceStatus['icon'] }}"></i>
                                {{ $serviceStatus['label'] }}
                            </span>
                        </div>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300">
                        <i class="bi bi-info-circle"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


</x-layouts.admin>
