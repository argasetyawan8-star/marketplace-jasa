<x-layouts.admin title="CMS Banner">


<div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div class="min-w-0">

            <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 dark:border-blue-900/40 dark:bg-blue-950/30">
                <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                <span class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-700 dark:text-blue-300">
                    Content Management
                </span>
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                CMS Banner
            </h1>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Kelola banner homepage ProKerja untuk berbagai posisi tampilan.
            </p>

        </div>

        <a
            href="{{ route('admin.banners.create') }}"
            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-blue-500/15 sm:w-auto"
        >
            <i class="bi bi-plus-lg"></i>
            Tambah Banner
        </a>

    </div>

    {{-- =========================================================
         SUCCESS
    ========================================================== --}}
    @if (session('success'))
        <div class="overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50 dark:border-emerald-900/40 dark:bg-emerald-950/30">

            <div class="flex items-start gap-3 px-5 py-4">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                    <i class="bi bi-check-circle-fill text-sm"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold text-emerald-800 dark:text-emerald-300">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-xs leading-5 text-emerald-700 dark:text-emerald-400">
                        {{ session('success') }}
                    </p>
                </div>

            </div>

        </div>
    @endif

    {{-- =========================================================
         STATISTICS
    ========================================================== --}}
    <div class="grid grid-cols-2 gap-3 xl:grid-cols-4">

        {{-- TOTAL --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Total Banner
                    </p>

                    <p class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $banners->total() }}
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                    <i class="bi bi-images"></i>
                </div>

            </div>

            <p class="mt-2 text-[10px] text-slate-400">
                Semua banner yang tersimpan
            </p>

        </div>

        {{-- HERO --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Hero
                    </p>

                    <p class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $heroCount }}
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                    <i class="bi bi-display"></i>
                </div>

            </div>

            <p class="mt-2 text-[10px] text-slate-400">
                Posisi utama homepage
            </p>

        </div>

        {{-- MIDDLE --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Middle
                    </p>

                    <p class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $middleCount }}
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                    <i class="bi bi-layout-text-window"></i>
                </div>

            </div>

            <p class="mt-2 text-[10px] text-slate-400">
                Posisi tengah homepage
            </p>

        </div>

        {{-- ACTIVE --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Aktif
                    </p>

                    <p class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $activeCount }}
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

            </div>

            <p class="mt-2 text-[10px] text-slate-400">
                Banner yang sedang aktif
            </p>

        </div>

    </div>

    {{-- =========================================================
         DESKTOP TABLE
    ========================================================== --}}
    <section class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:block">

        {{-- TABLE HEADER --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div>
                <div class="flex items-center gap-2">

                    <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                    <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                        Content
                    </p>

                </div>

                <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                    Daftar Banner
                </h2>

                <p class="mt-1 text-xs leading-5 text-slate-400 dark:text-slate-500">
                    Banner ditampilkan berdasarkan posisi, urutan, status, dan jadwal tayang.
                </p>
            </div>

            <div class="hidden items-center gap-2 rounded-xl bg-blue-50 px-3 py-2 text-[10px] font-semibold text-blue-700 dark:bg-blue-950/30 dark:text-blue-300 sm:flex">
                <i class="bi bi-images"></i>
                Manajemen Banner
            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-50 dark:bg-slate-950/60">
                    <tr class="border-b border-slate-100 dark:border-slate-800">

                        <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Banner
                        </th>

                        <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Posisi
                        </th>

                        <th class="px-5 py-3 text-center text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Urutan
                        </th>

                        <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Status
                        </th>

                        <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Jadwal
                        </th>

                        <th class="px-5 py-3 text-right text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                    @forelse ($banners as $banner)

                        @php
                            $placementText = match ($banner->placement) {
                                'hero' => 'Hero',
                                'middle' => 'Middle',
                                'bottom' => 'Bottom',
                                default => ucfirst($banner->placement),
                            };
                        @endphp

                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/40">

                            {{-- BANNER --}}
                            <td class="px-5 py-4">

                                <div class="flex min-w-[290px] items-center gap-4">

                                    <div class="relative h-16 w-28 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-blue-50 dark:border-slate-700 dark:bg-blue-950/30">

                                        <img
                                            src="{{ $banner->image_url }}"
                                            alt="{{ $banner->alt_text ?: $banner->name }}"
                                            class="h-full w-full object-cover transition duration-300 hover:scale-105"
                                            loading="lazy"
                                        >

                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-xs font-bold text-slate-800 dark:text-slate-200">
                                            {{ $banner->name }}
                                        </p>

                                        <div class="mt-1.5 flex items-center gap-2">

                                            <span class="inline-flex items-center gap-1 text-[10px] text-slate-400">
                                                <i class="bi bi-phone"></i>
                                                {{ $banner->mobile_image_path ? 'Desktop + Mobile' : 'Desktop saja' }}
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </td>

                            {{-- PLACEMENT --}}
                            <td class="px-5 py-4">

                                <span class="inline-flex items-center gap-1.5 rounded-full border border-blue-100 bg-blue-50 px-2.5 py-1.5 text-[9px] font-bold text-blue-700 dark:border-blue-900/40 dark:bg-blue-950/30 dark:text-blue-300">
                                    <i class="bi bi-layout-text-window-reverse"></i>
                                    {{ $placementText }}
                                </span>

                            </td>

                            {{-- SORT --}}
                            <td class="px-5 py-4 text-center">

                                <span class="inline-flex h-8 min-w-8 items-center justify-center rounded-lg bg-slate-100 px-2 text-xs font-bold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    {{ $banner->sort_order }}
                                </span>

                            </td>

                            {{-- STATUS --}}
                            <td class="px-5 py-4">

                                <form
                                    action="{{ route('admin.banners.status', $banner) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 rounded-full px-2.5 py-1.5 text-[9px] font-bold transition {{ $banner->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/30 dark:text-emerald-300 dark:hover:bg-emerald-950/50' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-slate-700' }}"
                                        title="{{ $banner->is_active ? 'Nonaktifkan banner' : 'Aktifkan banner' }}"
                                    >

                                        <span class="h-1.5 w-1.5 rounded-full {{ $banner->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>

                                        {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}

                                    </button>

                                </form>

                            </td>

                            {{-- SCHEDULE --}}
                            <td class="px-5 py-4">

                                <div class="min-w-[170px] space-y-1">

                                    @if ($banner->starts_at)
                                        <div class="flex items-start gap-2">

                                            <i class="bi bi-calendar-event mt-0.5 text-[10px] text-blue-500"></i>

                                            <p class="text-[10px] leading-4 text-slate-500 dark:text-slate-400">
                                                Mulai:
                                                <span class="font-semibold text-slate-600 dark:text-slate-300">
                                                    {{ $banner->starts_at->format('d M Y H:i') }}
                                                </span>
                                            </p>

                                        </div>
                                    @endif

                                    @if ($banner->ends_at)
                                        <div class="flex items-start gap-2">

                                            <i class="bi bi-calendar-x mt-0.5 text-[10px] text-slate-400"></i>

                                            <p class="text-[10px] leading-4 text-slate-500 dark:text-slate-400">
                                                Selesai:
                                                <span class="font-semibold text-slate-600 dark:text-slate-300">
                                                    {{ $banner->ends_at->format('d M Y H:i') }}
                                                </span>
                                            </p>

                                        </div>
                                    @endif

                                    @if (!$banner->starts_at && !$banner->ends_at)
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold text-slate-500 dark:text-slate-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Selalu tayang
                                        </span>
                                    @endif

                                </div>

                            </td>

                            {{-- ACTION --}}
                            <td class="px-5 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.banners.edit', $banner) }}"
                                        class="inline-flex h-9 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-[10px] font-semibold text-blue-600 transition hover:border-blue-200 hover:bg-blue-50 dark:border-slate-700 dark:bg-slate-900 dark:text-blue-400 dark:hover:border-blue-900 dark:hover:bg-blue-950/20"
                                        title="Edit banner"
                                    >
                                        <i class="bi bi-pencil"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.banners.destroy', $banner) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus banner ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex h-9 items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-3 text-[10px] font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-900/40 dark:bg-slate-900 dark:text-red-400 dark:hover:bg-red-950/20"
                                            title="Hapus banner"
                                        >
                                            <i class="bi bi-trash3"></i>
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-950/30 dark:text-blue-400">
                                    <i class="bi bi-images text-2xl"></i>
                                </div>

                                <h3 class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-200">
                                    Belum ada banner
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-slate-400 dark:text-slate-500">
                                    Tambahkan banner pertama untuk homepage ProKerja.
                                </p>

                                <a
                                    href="{{ route('admin.banners.create') }}"
                                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700"
                                >
                                    <i class="bi bi-plus-lg"></i>
                                    Tambah Banner
                                </a>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

    {{-- =========================================================
         MOBILE CARDS
    ========================================================== --}}
    <div class="space-y-4 lg:hidden">

        @forelse ($banners as $banner)

            @php
                $placementText = match ($banner->placement) {
                    'hero' => 'Hero',
                    'middle' => 'Middle',
                    'bottom' => 'Bottom',
                    default => ucfirst($banner->placement),
                };
            @endphp

            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                {{-- IMAGE --}}
                <div class="relative aspect-[16/7] overflow-hidden bg-blue-50 dark:bg-blue-950/30">

                    <img
                        src="{{ $banner->image_url }}"
                        alt="{{ $banner->alt_text ?: $banner->name }}"
                        class="h-full w-full object-cover"
                        loading="lazy"
                    >

                    <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/50 to-transparent"></div>

                    <div class="absolute left-3 top-3">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/95 px-3 py-1.5 text-[9px] font-bold text-blue-700 shadow-sm backdrop-blur dark:bg-slate-900/95 dark:text-blue-300">
                            <i class="bi bi-layout-text-window-reverse"></i>
                            {{ $placementText }}
                        </span>
                    </div>

                    <div class="absolute bottom-3 left-3 right-3">

                        <p class="truncate text-sm font-bold text-white">
                            {{ $banner->name }}
                        </p>

                        <p class="mt-0.5 text-[10px] text-white/80">
                            {{ $banner->mobile_image_path ? 'Desktop + Mobile' : 'Desktop saja' }}
                        </p>

                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="p-4">

                    {{-- TOP --}}
                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                                Status Banner
                            </p>

                            <p class="mt-1 text-sm font-bold text-slate-800 dark:text-slate-200">
                                {{ $banner->is_active ? 'Banner Aktif' : 'Banner Nonaktif' }}
                            </p>

                        </div>

                        {{-- STATUS --}}
                        <form
                            action="{{ route('admin.banners.status', $banner) }}"
                            method="POST"
                            class="shrink-0"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1.5 text-[9px] font-bold transition {{ $banner->is_active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400' }}"
                            >
                                <span class="h-1.5 w-1.5 rounded-full {{ $banner->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>

                        </form>

                    </div>

                    {{-- INFO GRID --}}
                    <div class="mt-4 grid grid-cols-2 gap-3">

                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-950/50">

                            <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                Posisi
                            </p>

                            <p class="mt-1.5 text-xs font-bold text-slate-700 dark:text-slate-200">
                                {{ $placementText }}
                            </p>

                        </div>

                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-950/50">

                            <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                Urutan
                            </p>

                            <p class="mt-1.5 text-xs font-bold text-slate-700 dark:text-slate-200">
                                #{{ $banner->sort_order }}
                            </p>

                        </div>

                    </div>

                    {{-- SCHEDULE --}}
                    <div class="mt-3 rounded-xl border border-slate-100 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-950/50">

                        <div class="flex items-start gap-3">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                                <i class="bi bi-calendar3 text-xs"></i>
                            </div>

                            <div class="min-w-0 flex-1">

                                <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                    Jadwal Tayang
                                </p>

                                @if ($banner->starts_at || $banner->ends_at)

                                    <div class="mt-1 space-y-1">

                                        @if ($banner->starts_at)
                                            <p class="text-[10px] leading-4 text-slate-500 dark:text-slate-400">
                                                Mulai:
                                                <span class="font-semibold text-slate-700 dark:text-slate-300">
                                                    {{ $banner->starts_at->format('d M Y H:i') }}
                                                </span>
                                            </p>
                                        @endif

                                        @if ($banner->ends_at)
                                            <p class="text-[10px] leading-4 text-slate-500 dark:text-slate-400">
                                                Selesai:
                                                <span class="font-semibold text-slate-700 dark:text-slate-300">
                                                    {{ $banner->ends_at->format('d M Y H:i') }}
                                                </span>
                                            </p>
                                        @endif

                                    </div>

                                @else

                                    <p class="mt-1 text-[10px] font-semibold text-emerald-600 dark:text-emerald-400">
                                        Selalu tayang
                                    </p>

                                @endif

                            </div>

                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="mt-4 grid grid-cols-2 gap-2">

                        <a
                            href="{{ route('admin.banners.edit', $banner) }}"
                            class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-[10px] font-semibold text-blue-600 transition hover:border-blue-200 hover:bg-blue-50 dark:border-slate-700 dark:bg-slate-900 dark:text-blue-400 dark:hover:border-blue-900 dark:hover:bg-blue-950/20"
                        >
                            <i class="bi bi-pencil"></i>
                            Edit
                        </a>

                        <form
                            action="{{ route('admin.banners.destroy', $banner) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus banner ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-3 text-[10px] font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-900/40 dark:bg-slate-900 dark:text-red-400 dark:hover:bg-red-950/20"
                            >
                                <i class="bi bi-trash3"></i>
                                Hapus
                            </button>

                        </form>

                    </div>

                </div>

            </article>

        @empty

            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-14 text-center dark:border-slate-700 dark:bg-slate-900">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-950/30 dark:text-blue-400">
                    <i class="bi bi-images text-2xl"></i>
                </div>

                <h3 class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-200">
                    Belum ada banner
                </h3>

                <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-slate-400 dark:text-slate-500">
                    Tambahkan banner pertama untuk homepage ProKerja.
                </p>

                <a
                    href="{{ route('admin.banners.create') }}"
                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Banner
                </a>

            </div>

        @endforelse

    </div>

    {{-- =========================================================
         PAGINATION
    ========================================================== --}}
    @if ($banners->hasPages())
        <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            {{ $banners->links() }}
        </div>
    @endif

</div>


</x-layouts.admin>
