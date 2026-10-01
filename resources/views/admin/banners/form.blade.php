<x-layouts.admin :title="$mode === 'create' ? 'Tambah Banner' : 'Edit Banner'">


@php
    $isCreate = $mode === 'create';

    $startsAt = old(
        'starts_at',
        $banner->starts_at?->format('Y-m-d\TH:i')
    );

    $endsAt = old(
        'ends_at',
        $banner->ends_at?->format('Y-m-d\TH:i')
    );
@endphp

<div class="mx-auto max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div>

        <div class="flex flex-wrap items-center gap-2 text-[10px] font-semibold text-slate-400 dark:text-slate-500 sm:text-xs">

            <a
                href="{{ route('admin.banners.index') }}"
                class="transition hover:text-blue-600 dark:hover:text-blue-400"
            >
                CMS Banner
            </a>

            <i class="bi bi-chevron-right text-[9px]"></i>

            <span class="text-slate-700 dark:text-slate-300">
                {{ $isCreate ? 'Tambah Banner' : 'Edit Banner' }}
            </span>

        </div>

        <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

            <div class="min-w-0">

                <div class="flex items-center gap-2">

                    <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                    <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                        Content Management
                    </p>

                </div>

                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                    {{ $isCreate ? 'Tambah Banner' : 'Edit Banner' }}
                </h1>

                <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                    {{ $isCreate
                        ? 'Tambahkan banner baru untuk memperkaya tampilan homepage ProKerja.'
                        : 'Perbarui informasi, gambar, posisi, atau jadwal banner.'
                    }}
                </p>

            </div>

            <div class="hidden h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/20 sm:flex">
                <i class="bi bi-images text-lg"></i>
            </div>

        </div>

    </div>

    {{-- =========================================================
         ERROR
    ========================================================== --}}
    @if ($errors->any())
        <div class="overflow-hidden rounded-2xl border border-red-200 bg-red-50 dark:border-red-900/40 dark:bg-red-950/30">

            <div class="flex items-start gap-3 px-5 py-4">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm dark:bg-slate-900 dark:text-red-400">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <div class="min-w-0">

                    <p class="text-xs font-bold text-red-800 dark:text-red-300">
                        Periksa kembali data yang dimasukkan.
                    </p>

                    <ul class="mt-2 space-y-1.5">
                        @foreach ($errors->all() as $error)
                            <li class="text-xs leading-5 text-red-700 dark:text-red-400">
                                • {{ $error }}
                            </li>
                        @endforeach
                    </ul>

                </div>

            </div>

        </div>
    @endif

    {{-- =========================================================
         FORM
    ========================================================== --}}
    <form
        action="{{ $isCreate
            ? route('admin.banners.store')
            : route('admin.banners.update', $banner)
        }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf

        @if (!$isCreate)
            @method('PUT')
        @endif

        {{-- =====================================================
             INFORMATION
        ====================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                        <i class="bi bi-info-circle"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                            Informasi Banner
                        </h2>

                        <p class="mt-1 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                            Informasi dasar untuk mengatur identitas dan posisi banner.
                        </p>
                    </div>

                </div>

            </div>

            <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">

                {{-- NAME --}}
                <div class="sm:col-span-2">

                    <label
                        for="name"
                        class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                    >
                        Nama Banner
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $banner->name) }}"
                        maxlength="150"
                        required
                        placeholder="Contoh: Promo Website UMKM"
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                    >

                    <p class="mt-2 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                        Nama ini digunakan untuk memudahkan pengelolaan banner di CMS.
                    </p>

                </div>

                {{-- PLACEMENT --}}
                <div>

                    <label
                        for="placement"
                        class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                    >
                        Posisi Banner
                    </label>

                    <select
                        id="placement"
                        name="placement"
                        required
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                    >

                        <option
                            value="hero"
                            @selected(old('placement', $banner->placement) === 'hero')
                        >
                            Hero
                        </option>

                        <option
                            value="middle"
                            @selected(old('placement', $banner->placement) === 'middle')
                        >
                            Middle
                        </option>

                        <option
                            value="bottom"
                            @selected(old('placement', $banner->placement) === 'bottom')
                        >
                            Bottom
                        </option>

                    </select>

                    <p class="mt-2 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                        Menentukan lokasi banner pada homepage.
                    </p>

                </div>

                {{-- SORT --}}
                <div>

                    <label
                        for="sort_order"
                        class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                    >
                        Urutan
                    </label>

                    <input
                        id="sort_order"
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', $banner->sort_order ?? 0) }}"
                        min="0"
                        max="9999"
                        required
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                    >

                    <p class="mt-2 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                        Angka lebih kecil akan ditampilkan lebih dahulu.
                    </p>

                </div>

            </div>

        </section>

        {{-- =====================================================
             MEDIA
        ====================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                        <i class="bi bi-image"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                            Media Banner
                        </h2>

                        <p class="mt-1 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                            Gunakan gambar desktop dan mobile agar banner tetap proporsional di semua perangkat.
                        </p>
                    </div>

                </div>

            </div>

            <div class="grid gap-6 p-5 sm:p-6 lg:grid-cols-2">

                {{-- DESKTOP --}}
                <div>

                    <div class="mb-2 flex items-center justify-between gap-3">

                        <label
                            for="image"
                            class="block text-xs font-semibold text-slate-700 dark:text-slate-300"
                        >
                            Gambar Desktop

                            @if ($isCreate)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>

                        <span class="text-[9px] font-medium text-slate-400">
                            Desktop
                        </span>

                    </div>

                    @if (!$isCreate && $banner->image_path)

                        <div class="mb-3 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-950">

                            <div class="relative aspect-[16/7]">

                                <img
                                    src="{{ $banner->image_url }}"
                                    alt="{{ $banner->alt_text ?: $banner->name }}"
                                    class="h-full w-full object-cover"
                                >

                                <div class="absolute left-3 top-3 rounded-full bg-black/50 px-2.5 py-1 text-[9px] font-semibold text-white backdrop-blur">
                                    Gambar saat ini
                                </div>

                            </div>

                        </div>

                    @endif

                    <label class="block cursor-pointer">

                        <span class="flex min-h-28 flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 text-center transition hover:border-blue-300 hover:bg-blue-50/50 dark:border-slate-700 dark:bg-slate-950/50 dark:hover:border-blue-800 dark:hover:bg-blue-950/20">

                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </span>

                            <span class="mt-2 text-[10px] font-semibold text-slate-600 dark:text-slate-300">
                                Pilih gambar desktop
                            </span>

                            <span class="mt-1 text-[9px] text-slate-400">
                                JPG, PNG, WebP · Maks. 10 MB
                            </span>

                        </span>

                        <input
                            id="image"
                            type="file"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            {{ $isCreate ? 'required' : '' }}
                            class="sr-only"
                        >

                    </label>

                </div>

                {{-- MOBILE --}}
                <div>

                    <div class="mb-2 flex items-center justify-between gap-3">

                        <label
                            for="mobile_image"
                            class="block text-xs font-semibold text-slate-700 dark:text-slate-300"
                        >
                            Gambar Mobile
                        </label>

                        <span class="text-[9px] font-medium text-slate-400">
                            Opsional
                        </span>

                    </div>

                    @if (!$isCreate && $banner->mobile_image_url)

                        <div class="mb-3 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-950">

                            <div class="relative aspect-[4/3]">

                                <img
                                    src="{{ $banner->mobile_image_url }}"
                                    alt="{{ $banner->alt_text ?: $banner->name }}"
                                    class="h-full w-full object-cover"
                                >

                                <div class="absolute left-3 top-3 rounded-full bg-black/50 px-2.5 py-1 text-[9px] font-semibold text-white backdrop-blur">
                                    Gambar mobile saat ini
                                </div>

                            </div>

                        </div>

                    @endif

                    <label class="block cursor-pointer">

                        <span class="flex min-h-28 flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 text-center transition hover:border-blue-300 hover:bg-blue-50/50 dark:border-slate-700 dark:bg-slate-950/50 dark:hover:border-blue-800 dark:hover:bg-blue-950/20">

                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400">
                                <i class="bi bi-phone"></i>
                            </span>

                            <span class="mt-2 text-[10px] font-semibold text-slate-600 dark:text-slate-300">
                                Pilih gambar mobile
                            </span>

                            <span class="mt-1 text-[9px] text-slate-400">
                                Disarankan komposisi khusus mobile
                            </span>

                        </span>

                        <input
                            id="mobile_image"
                            type="file"
                            name="mobile_image"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="sr-only"
                        >

                    </label>

                </div>

                {{-- ALT TEXT --}}
                <div class="lg:col-span-2">

                    <label
                        for="alt_text"
                        class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                    >
                        Alt Text
                    </label>

                    <input
                        id="alt_text"
                        type="text"
                        name="alt_text"
                        value="{{ old('alt_text', $banner->alt_text) }}"
                        maxlength="255"
                        placeholder="Contoh: Promo jasa pembuatan website ProKerja"
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:placeholder:text-slate-500 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                    >

                    <p class="mt-2 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                        Teks alternatif untuk aksesibilitas dan konteks gambar.
                    </p>

                </div>

            </div>

        </section>

        {{-- =====================================================
             LINK
        ====================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                        <i class="bi bi-link-45deg"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                            Tautan Banner
                        </h2>

                        <p class="mt-1 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                            Tentukan halaman yang dibuka ketika banner diklik.
                        </p>
                    </div>

                </div>

            </div>

            <div class="space-y-5 p-5 sm:p-6">

                {{-- URL --}}
                <div>

                    <label
                        for="link_url"
                        class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                    >
                        URL Tujuan
                    </label>

                    <div class="relative">

                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i class="bi bi-link-45deg"></i>
                        </span>

                        <input
                            id="link_url"
                            type="text"
                            name="link_url"
                            value="{{ old('link_url', $banner->link_url) }}"
                            maxlength="2048"
                            placeholder="/search atau https://example.com"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:placeholder:text-slate-500 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                        >

                    </div>

                    <p class="mt-2 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                        Bisa menggunakan URL internal seperti
                        <span class="font-semibold text-slate-500 dark:text-slate-400">/search</span>
                        atau URL eksternal dengan
                        <span class="font-semibold text-slate-500 dark:text-slate-400">https://</span>.
                    </p>

                </div>

                {{-- OPEN NEW TAB --}}
                <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-blue-200 dark:border-slate-700 dark:bg-slate-950/50 dark:hover:border-blue-900">

                    <input
                        type="checkbox"
                        name="open_new_tab"
                        value="1"
                        class="mt-0.5 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                        @checked(old('open_new_tab', $banner->open_new_tab))
                    >

                    <span class="min-w-0">

                        <span class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                            Buka di tab baru
                        </span>

                        <span class="mt-1 block text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                            Cocok digunakan untuk tautan ke website atau halaman eksternal.
                        </span>

                    </span>

                </label>

            </div>

        </section>

        {{-- =====================================================
             SCHEDULE & STATUS
        ====================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:px-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                        <i class="bi bi-calendar-event"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                            Jadwal & Status
                        </h2>

                        <p class="mt-1 text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                            Atur kapan banner mulai tayang dan kapan berhenti ditampilkan.
                        </p>
                    </div>

                </div>

            </div>

            <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">

                {{-- START --}}
                <div>

                    <label
                        for="starts_at"
                        class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                    >
                        Mulai Tayang
                    </label>

                    <div class="relative">

                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i class="bi bi-calendar-plus"></i>
                        </span>

                        <input
                            id="starts_at"
                            type="datetime-local"
                            name="starts_at"
                            value="{{ $startsAt }}"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-xs text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                        >

                    </div>

                    <p class="mt-2 text-[10px] text-slate-400">
                        Kosongkan untuk langsung tayang.
                    </p>

                </div>

                {{-- END --}}
                <div>

                    <label
                        for="ends_at"
                        class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                    >
                        Selesai Tayang
                    </label>

                    <div class="relative">

                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i class="bi bi-calendar-x"></i>
                        </span>

                        <input
                            id="ends_at"
                            type="datetime-local"
                            name="ends_at"
                            value="{{ $endsAt }}"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-xs text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                        >

                    </div>

                    <p class="mt-2 text-[10px] text-slate-400">
                        Kosongkan agar banner tidak memiliki tanggal akhir.
                    </p>

                </div>

                {{-- STATUS --}}
                <div class="sm:col-span-2">

                    <label class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-blue-200 dark:border-slate-700 dark:bg-slate-950/50 dark:hover:border-blue-900">

                        <span class="min-w-0">

                            <span class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">

                                <i class="bi bi-broadcast text-blue-600 dark:text-blue-400"></i>

                                Aktifkan Banner

                            </span>

                            <span class="mt-1 block text-[10px] leading-5 text-slate-400 dark:text-slate-500">
                                Banner aktif dapat ditampilkan apabila berada dalam jadwal tayang.
                            </span>

                        </span>

                        <span class="relative inline-flex shrink-0">

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="peer sr-only"
                                @checked(old('is_active', $banner->is_active))
                            >

                            <span class="relative h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-500/10 dark:bg-slate-700">

                                <span class="absolute left-[3px] top-[3px] h-5 w-5 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"></span>

                            </span>

                        </span>

                    </label>

                </div>

            </div>

        </section>

        {{-- =====================================================
             FORM ACTION
        ====================================================== --}}
        <div class="sticky bottom-0 z-20 -mx-4 border-t border-slate-200 bg-white/95 px-4 py-4 backdrop-blur sm:static sm:mx-0 sm:border-0 sm:bg-transparent sm:px-0 sm:py-0 dark:border-slate-800 dark:bg-slate-900/95 sm:dark:bg-transparent">

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">

                <a
                    href="{{ route('admin.banners.index') }}"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

                <button
                    type="submit"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-blue-500/15"
                >
                    <i class="bi bi-check2"></i>

                    {{ $isCreate ? 'Simpan Banner' : 'Simpan Perubahan' }}
                </button>

            </div>

        </div>

    </form>

</div>


</x-layouts.admin>
