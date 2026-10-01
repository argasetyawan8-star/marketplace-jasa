<x-layouts.admin title="Moderasi Jasa">


@php
    $statusMap = [
        'draft' => [
            'label' => 'Draft',
            'description' => 'Jasa masih dalam tahap penyusunan dan belum tampil sebagai jasa aktif.',
            'class' => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700',
            'icon' => 'bi-file-earmark',
        ],
        'published' => [
            'label' => 'Published',
            'description' => 'Jasa aktif dan dapat ditampilkan kepada client di marketplace.',
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/25 dark:text-emerald-300 dark:border-emerald-800',
            'icon' => 'bi-check-circle-fill',
        ],
        'paused' => [
            'label' => 'Paused',
            'description' => 'Jasa sementara tidak aktif dan tidak diprioritaskan untuk pemesanan baru.',
            'class' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/25 dark:text-amber-300 dark:border-amber-800',
            'icon' => 'bi-pause-circle-fill',
        ],
        'rejected' => [
            'label' => 'Rejected',
            'description' => 'Jasa ditolak karena belum memenuhi standar marketplace.',
            'class' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/25 dark:text-red-300 dark:border-red-800',
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
            class="group inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
        >
            <span class="flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 bg-white transition group-hover:border-blue-200 group-hover:bg-blue-50 dark:border-slate-700 dark:bg-slate-900 dark:group-hover:border-blue-900/50 dark:group-hover:bg-blue-900/20">
                <i class="bi bi-arrow-left"></i>
            </span>

            Kembali ke detail jasa
        </a>

        <div class="mt-4">
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:border-blue-900/50 dark:bg-blue-900/20 dark:text-blue-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                    Moderasi
                </span>

                <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $currentStatus['class'] }}">
                    <i class="bi {{ $currentStatus['icon'] }}"></i>
                    {{ $currentStatus['label'] }}
                </span>
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Moderasi Jasa
            </h1>

            <p class="mt-1.5 max-w-3xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Periksa informasi jasa dan tentukan status publikasinya di marketplace.
            </p>
        </div>
    </div>

    {{-- Validation Error --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 dark:border-red-900/50 dark:bg-red-900/15">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-300">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                        Ada data yang perlu diperbaiki
                    </p>

                    <ul class="mt-2 space-y-1 text-sm leading-6 text-red-700 dark:text-red-200/80">
                        @foreach ($errors->all() as $error)
                            <li class="flex gap-2">
                                <span class="shrink-0">•</span>
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
        <div class="min-w-0 space-y-6">

            {{-- Service Overview --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                {{-- Image --}}
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

                                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                                    Belum ada thumbnail
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Service Data --}}
                <div class="p-5 sm:p-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                                Judul Jasa
                            </p>

                            <h2 class="mt-1.5 text-xl font-bold leading-7 text-slate-900 dark:text-white">
                                {{ $service->title }}
                            </h2>
                        </div>

                        <div class="shrink-0 rounded-xl bg-blue-50 px-4 py-3 sm:min-w-[160px] sm:text-right dark:bg-blue-900/20">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-blue-500 dark:text-blue-300">
                                Harga Mulai
                            </p>

                            <p class="mt-1 text-lg font-bold text-blue-600 dark:text-blue-300 sm:text-xl">
                                Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-500 dark:bg-amber-900/20 dark:text-amber-300">
                                <i class="bi bi-star-fill text-xs"></i>
                            </div>

                            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                                Rating
                            </p>

                            <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                                {{ number_format((float) $service->rating, 1) }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                                <i class="bi bi-chat-square-text-fill text-xs"></i>
                            </div>

                            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                                Review
                            </p>

                            <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                                {{ $service->reviews_count }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-300">
                                <i class="bi bi-bag-check-fill text-xs"></i>
                            </div>

                            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                                Pesanan
                            </p>

                            <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">
                                {{ $service->orders_count }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50 text-violet-600 dark:bg-violet-900/20 dark:text-violet-300">
                                <i class="bi bi-clock-fill text-xs"></i>
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
                    <div class="mt-7 border-t border-slate-100 pt-6 dark:border-slate-800">
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Deskripsi Jasa
                        </h3>

                        <div class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-600 dark:text-slate-300">
                            {{ $service->description ?: 'Freelancer belum memberikan deskripsi jasa.' }}
                        </div>
                    </div>

                    {{-- Category --}}
                    <div class="mt-7 border-t border-slate-100 pt-6 dark:border-slate-800">
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Kategori
                        </h3>

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

            {{-- Freelancer --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Pemilik Jasa
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Informasi freelancer
                        </p>
                    </div>
                </div>

                <div class="mt-5 flex items-center gap-4">

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

                        @if ($freelancer?->headline)
                            <p class="mt-1.5 line-clamp-2 text-sm text-slate-600 dark:text-slate-300">
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
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Status Jasa
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
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
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-400 dark:focus:ring-blue-400/10"
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

                        <p class="mt-2 text-xs leading-5 text-slate-500 dark:text-slate-400">
                            Pilih status yang sesuai dengan hasil pemeriksaan jasa.
                        </p>
                    </div>

                    {{-- Current Status Info --}}
                    <div class="rounded-xl border px-4 py-3 {{ $currentStatus['class'] }}">
                        <div class="flex items-start gap-3">
                            <i class="bi {{ $currentStatus['icon'] }} mt-0.5"></i>

                            <div class="min-w-0">
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
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                        <label class="flex cursor-pointer items-start gap-3">
                            <input
                                type="checkbox"
                                name="is_featured"
                                value="1"
                                @checked(old('is_featured', $service->is_featured))
                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-600 dark:bg-slate-900 dark:focus:ring-blue-400/10"
                            >

                            <span class="min-w-0">
                                <span class="block text-sm font-medium text-slate-800 dark:text-slate-200">
                                    Jadikan Jasa Unggulan
                                </span>

                                <span class="mt-1 block text-xs leading-5 text-slate-500 dark:text-slate-400">
                                    Jasa dapat ditandai sebagai unggulan untuk membantu menampilkannya lebih menonjol di marketplace.
                                </span>
                            </span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15"
                    >
                        <i class="bi bi-check2-circle"></i>
                        Simpan Moderasi
                    </button>

                </form>
            </div>

            {{-- Checklist --}}
            <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-5 dark:border-blue-900/40 dark:bg-blue-900/10 sm:p-6">

                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                        <i class="bi bi-list-check"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Checklist Moderasi
                        </h2>

                        <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                            Gunakan poin berikut saat memeriksa jasa.
                        </p>
                    </div>
                </div>

                <div class="mt-5 space-y-3.5">

                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-300">
                            <i class="bi bi-check text-xs"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Judul jasa jelas dan sesuai layanan yang ditawarkan.
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-300">
                            <i class="bi bi-check text-xs"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Deskripsi menjelaskan layanan dengan informasi yang cukup.
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-300">
                            <i class="bi bi-check text-xs"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Kategori dan subkategori sesuai dengan jasa.
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-300">
                            <i class="bi bi-check text-xs"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Harga dan estimasi pengerjaan masuk akal.
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-300">
                            <i class="bi bi-check text-xs"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Thumbnail atau konten visual sesuai dengan layanan.
                        </p>
                    </div>

                </div>
            </div>

            {{-- Service ID --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                            ID Jasa
                        </p>

                        <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                            #{{ $service->id }}
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.services.show', $service) }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:border-blue-900/50 dark:hover:bg-blue-900/20 dark:hover:text-blue-300 sm:w-auto"
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
