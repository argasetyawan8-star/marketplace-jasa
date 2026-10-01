<x-layouts.admin title="Kategori">


<div class="mx-auto max-w-7xl space-y-5 sm:space-y-6">

    {{-- ==========================================================
         HEADER
    =========================================================== --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">

                <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-blue-600 dark:text-blue-400">
                    <i class="bi bi-grid"></i>
                    Marketplace
                </div>

                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                    Kategori
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Kelola kategori yang digunakan untuk mengelompokkan jasa di marketplace.
                </p>

            </div>


            <div class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 sm:flex">
                <i class="bi bi-grid text-xl"></i>
            </div>

        </div>

    </section>


    {{-- ==========================================================
         SUCCESS MESSAGE
    =========================================================== --}}
    @if(session('success'))

        <div class="flex items-start gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                <i class="bi bi-check-circle"></i>
            </div>

            <div class="min-w-0">
                <p class="font-semibold">
                    Berhasil
                </p>

                <p class="mt-0.5 leading-5">
                    {{ session('success') }}
                </p>
            </div>

        </div>

    @endif


    {{-- ==========================================================
         ERROR MESSAGE
    =========================================================== --}}
    @if(session('error'))

        <div class="flex items-start gap-3 rounded-2xl border border-rose-100 bg-rose-50 px-4 py-3.5 text-sm text-rose-700 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-400">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-rose-600 shadow-sm dark:bg-slate-900 dark:text-rose-400">
                <i class="bi bi-exclamation-circle"></i>
            </div>

            <div class="min-w-0">
                <p class="font-semibold">
                    Tidak dapat diproses
                </p>

                <p class="mt-0.5 leading-5">
                    {{ session('error') }}
                </p>
            </div>

        </div>

    @endif


    {{-- ==========================================================
         ADD CATEGORY
    =========================================================== --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- Section Header --}}
        <div class="border-b border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-6 sm:py-5">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="bi bi-plus-lg text-lg"></i>
                </div>

                <div>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                        Tambah Kategori
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400 sm:text-sm">
                        Buat kategori baru untuk marketplace.
                    </p>
                </div>

            </div>

        </div>


        {{-- Form --}}
        <form
            action="{{ route('admin.categories.store') }}"
            method="POST"
            class="space-y-5 p-4 sm:p-6"
        >

            @csrf


            {{-- ==================================================
                 NAME + SLUG
            =================================================== --}}
            <div class="grid gap-5 md:grid-cols-2">

                {{-- Name --}}
                <div>

                    <label
                        for="name"
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                    >
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Desain Grafis"
                        required
                        class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                    >

                    @error('name')
                        <p class="mt-2 text-xs font-medium text-rose-600 dark:text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Slug --}}
                <div>

                    <label
                        for="slug"
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                    >
                        Slug
                    </label>

                    <input
                        type="text"
                        id="slug"
                        name="slug"
                        value="{{ old('slug') }}"
                        placeholder="desain-grafis"
                        class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                    >

                    <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                        Kosongkan untuk membuat slug otomatis.
                    </p>

                    @error('slug')
                        <p class="mt-2 text-xs font-medium text-rose-600 dark:text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- ==================================================
                 DESCRIPTION
            =================================================== --}}
            <div>

                <label
                    for="description"
                    class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                >
                    Deskripsi
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Jelaskan kategori ini..."
                    class="mt-2 block w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                >{{ old('description') }}</textarea>

                @error('description')
                    <p class="mt-2 text-xs font-medium text-rose-600 dark:text-rose-400">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ==================================================
                 ICON + SORT
            =================================================== --}}
            <div class="grid gap-5 md:grid-cols-2">

                {{-- Icon --}}
                <div>

                    <label
                        for="icon"
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                    >
                        Icon
                    </label>

                    <div class="relative mt-2">

                        <i class="bi bi-palette pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500"></i>

                        <input
                            type="text"
                            id="icon"
                            name="icon"
                            value="{{ old('icon') }}"
                            placeholder="bi-palette"
                            class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                        >

                    </div>

                    <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                        Contoh class Bootstrap Icons: bi-palette.
                    </p>

                    @error('icon')
                        <p class="mt-2 text-xs font-medium text-rose-600 dark:text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Sort Order --}}
                <div>

                    <label
                        for="sort_order"
                        class="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                    >
                        Urutan
                    </label>

                    <input
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        value="{{ old('sort_order', 0) }}"
                        min="0"
                        max="9999"
                        class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                    >

                    @error('sort_order')
                        <p class="mt-2 text-xs font-medium text-rose-600 dark:text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- ==================================================
                 ACTIVE TOGGLE
            =================================================== --}}
            <div class="flex flex-col gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/60 sm:flex-row sm:items-center sm:justify-between sm:p-5">

                <div class="min-w-0">

                    <p class="text-sm font-semibold text-slate-900 dark:text-white">
                        Aktifkan kategori
                    </p>

                    <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400 sm:text-sm">
                        Kategori aktif dapat digunakan pada marketplace.
                    </p>

                </div>


                <label class="relative inline-flex shrink-0 cursor-pointer items-center">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="peer sr-only"
                        {{ old('is_active', true) ? 'checked' : '' }}
                    >

                    <div class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-500/10 dark:bg-slate-600"></div>

                    <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"></div>

                </label>

            </div>


            {{-- ==================================================
                 SUBMIT
            =================================================== --}}
            <div class="flex justify-end border-t border-slate-100 pt-5 dark:border-slate-800">

                <button
                    type="submit"
                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold !text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20 sm:w-auto"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Kategori
                </button>

            </div>

        </form>

    </section>


    {{-- ==========================================================
         CATEGORY LIST
    =========================================================== --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- List Header --}}
        <div class="border-b border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-6 sm:py-5">

            <div class="flex items-center justify-between gap-3">

                <div class="flex min-w-0 items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        <i class="bi bi-list-ul text-lg"></i>
                    </div>

                    <div class="min-w-0">

                        <div class="flex items-center gap-2">

                            <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                                Daftar Kategori
                            </h2>

                            <span class="rounded-md bg-blue-50 px-2 py-1 text-[11px] font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                {{ number_format($categories->total()) }}
                            </span>

                        </div>

                        <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                            Kategori yang tersedia di marketplace.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        @if($categories->count())

            {{-- ==================================================
                 DESKTOP TABLE
            =================================================== --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full">

                    <thead class="bg-slate-50 dark:bg-slate-800/70">

                        <tr class="border-b border-slate-100 dark:border-slate-800">

                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Kategori
                            </th>

                            <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Jasa
                            </th>

                            <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Subkategori
                            </th>

                            <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                        @foreach($categories as $category)

                            <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/50">

                                {{-- Category --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                            <i class="bi {{ $category->icon ?: 'bi-grid' }}"></i>
                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">
                                                {{ $category->name }}
                                            </p>

                                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                                {{ $category->slug }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Services --}}
                                <td class="px-6 py-4 text-center">

                                    <span class="inline-flex min-w-8 items-center justify-center rounded-lg bg-slate-100 px-2.5 py-1.5 text-sm font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                        {{ $category->services_count }}
                                    </span>

                                </td>


                                {{-- Subcategories --}}
                                <td class="px-6 py-4 text-center">

                                    <span class="inline-flex min-w-8 items-center justify-center rounded-lg bg-slate-100 px-2.5 py-1.5 text-sm font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                        {{ $category->subcategories_count }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">

                                    @if($category->is_active)

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Nonaktif
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.categories.edit', $category) }}"
                                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-blue-500/30 dark:hover:bg-blue-500/10 dark:hover:text-blue-400"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </a>


                                        @if($category->services_count === 0 && $category->subcategories_count === 0)

                                            <form
                                                action="{{ route('admin.categories.destroy', $category) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    onclick="return confirm('Hapus kategori ini?')"
                                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-rose-200 bg-white px-3.5 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/20 dark:bg-slate-900 dark:hover:bg-rose-500/10"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                    Hapus
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- ==================================================
                 MOBILE LIST
            =================================================== --}}
            <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">

                @foreach($categories as $category)

                    <div class="p-4 sm:p-5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                <i class="bi {{ $category->icon ?: 'bi-grid' }}"></i>
                            </div>


                            <div class="min-w-0 flex-1">

                                <p class="text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $category->name }}
                                </p>

                                <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                    {{ $category->slug }}
                                </p>


                                <div class="mt-3 grid grid-cols-2 gap-2">

                                    <div class="rounded-lg bg-slate-50 px-3 py-2.5 dark:bg-slate-800/70">

                                        <p class="text-[10px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                                            Jasa
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-slate-800 dark:text-white">
                                            {{ $category->services_count }}
                                        </p>

                                    </div>


                                    <div class="rounded-lg bg-slate-50 px-3 py-2.5 dark:bg-slate-800/70">

                                        <p class="text-[10px] font-medium uppercase tracking-wide text-slate-400 dark:text-slate-500">
                                            Subkategori
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-slate-800 dark:text-white">
                                            {{ $category->subcategories_count }}
                                        </p>

                                    </div>

                                </div>


                                <div class="mt-3">

                                    @if($category->is_active)

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Nonaktif
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Actions --}}
                        <div class="mt-4 flex gap-2">

                            <a
                                href="{{ route('admin.categories.edit', $category) }}"
                                class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-600 transition hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-blue-500/10 dark:hover:text-blue-400"
                            >
                                <i class="bi bi-pencil"></i>
                                Edit
                            </a>


                            @if($category->services_count === 0 && $category->subcategories_count === 0)

                                <form
                                    action="{{ route('admin.categories.destroy', $category) }}"
                                    method="POST"
                                    class="flex-1"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Hapus kategori ini?')"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-rose-200 bg-white px-4 py-2.5 text-xs font-semibold text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/20 dark:bg-slate-900 dark:hover:bg-rose-500/10"
                                    >
                                        <i class="bi bi-trash"></i>
                                        Hapus
                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- ==================================================
                 PAGINATION
            =================================================== --}}
            @if($categories->hasPages())

                <div class="border-t border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-6">
                    {{ $categories->links() }}
                </div>

            @endif


        @else

            {{-- ==================================================
                 EMPTY STATE
            =================================================== --}}
            <div class="px-5 py-16 text-center sm:px-8">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="bi bi-grid text-2xl"></i>
                </div>

                <h3 class="mt-5 text-sm font-bold text-slate-900 dark:text-white">
                    Belum ada kategori
                </h3>

                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Tambahkan kategori pertama untuk mulai mengelompokkan jasa di marketplace.
                </p>

            </div>

        @endif

    </section>

</div>


</x-layouts.admin>
