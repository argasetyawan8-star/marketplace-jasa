<x-layouts.admin title="Edit Kategori">


<div class="mx-auto max-w-3xl space-y-5 sm:space-y-6">

    {{-- ==========================================================
         BACK
    =========================================================== --}}
    <a
        href="{{ route('admin.categories.index') }}"
        class="group inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
    >
        <span
            class="flex h-8 w-8 items-center justify-center rounded-lg
                   bg-white ring-1 ring-slate-200
                   transition group-hover:bg-blue-50 group-hover:ring-blue-200
                   dark:bg-slate-900 dark:ring-slate-800
                   dark:group-hover:bg-blue-500/10 dark:group-hover:ring-blue-500/30"
        >
            <i class="bi bi-arrow-left text-sm transition group-hover:-translate-x-0.5"></i>
        </span>

        <span>Kembali ke Kategori</span>
    </a>


    {{-- ==========================================================
         HEADER
    =========================================================== --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                <i class="bi bi-pencil text-lg"></i>
            </div>

            <div class="min-w-0">
                <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-2xl">
                    Edit Kategori
                </h1>

                <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400 sm:text-sm">
                    Perbarui informasi kategori marketplace.
                </p>
            </div>

        </div>

    </section>


    {{-- ==========================================================
         VALIDATION ERRORS
    =========================================================== --}}
    @if($errors->any())

        <section class="rounded-2xl border border-rose-100 bg-rose-50 p-4 dark:border-rose-500/20 dark:bg-rose-500/10">

            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-rose-600 shadow-sm dark:bg-slate-900 dark:text-rose-400">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>

                <div class="min-w-0">

                    <p class="text-sm font-semibold text-rose-700 dark:text-rose-400">
                        Ada beberapa data yang perlu diperbaiki.
                    </p>

                    <ul class="mt-2 space-y-1 text-xs leading-5 text-rose-600 dark:text-rose-300 sm:text-sm">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </section>

    @endif


    {{-- ==========================================================
         FORM
    =========================================================== --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <form
            action="{{ route('admin.categories.update', $category) }}"
            method="POST"
            class="space-y-5 p-4 sm:space-y-6 sm:p-6"
        >

            @csrf
            @method('PATCH')


            {{-- ==================================================
                 NAME
            =================================================== --}}
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
                    value="{{ old('name', $category->name) }}"
                    required
                    class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                >

                @error('name')
                    <p class="mt-2 text-xs font-medium text-rose-600 dark:text-rose-400">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ==================================================
                 SLUG
            =================================================== --}}
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
                    value="{{ old('slug', $category->slug) }}"
                    class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                >

                <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                    Gunakan slug yang mudah dibaca dan konsisten dengan URL kategori.
                </p>

                @error('slug')
                    <p class="mt-2 text-xs font-medium text-rose-600 dark:text-rose-400">
                        {{ $message }}
                    </p>
                @enderror

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
                    rows="5"
                    class="mt-2 block w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                >{{ old('description', $category->description) }}</textarea>

                @error('description')
                    <p class="mt-2 text-xs font-medium text-rose-600 dark:text-rose-400">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ==================================================
                 ICON + SORT ORDER
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
                            value="{{ old('icon', $category->icon) }}"
                            placeholder="bi-palette"
                            class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                        >

                    </div>

                    <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                        Contoh Bootstrap Icons: <span class="font-medium text-slate-500 dark:text-slate-400">bi-palette</span>
                    </p>

                    @error('icon')
                        <p class="mt-2 text-xs font-medium text-rose-600 dark:text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Sort --}}
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
                        min="0"
                        max="9999"
                        value="{{ old('sort_order', $category->sort_order) }}"
                        class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm text-slate-900 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                    >

                    <p class="mt-2 text-xs text-slate-400 dark:text-slate-500">
                        Angka lebih kecil akan ditampilkan lebih awal.
                    </p>

                    @error('sort_order')
                        <p class="mt-2 text-xs font-medium text-rose-600 dark:text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- ==================================================
                 STATUS
            =================================================== --}}
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/60 sm:p-5">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="min-w-0">

                        <div class="flex items-center gap-2">

                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                                <i class="bi bi-toggle-on"></i>
                            </span>

                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                Status Kategori
                            </p>

                        </div>

                        <p class="mt-2 text-xs leading-5 text-slate-500 dark:text-slate-400 sm:pl-10 sm:text-sm">
                            Kategori aktif akan tersedia dan dapat digunakan pada marketplace.
                        </p>

                    </div>


                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="peer sr-only"
                            {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                        >

                        <div class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-500/10 dark:bg-slate-600"></div>

                        <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"></div>

                    </label>

                </div>

            </div>


            {{-- ==================================================
                 USAGE SUMMARY
            =================================================== --}}
            <div>

                <div class="mb-3 flex items-center gap-2">

                    <i class="bi bi-bar-chart text-sm text-blue-500"></i>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Penggunaan Kategori
                    </p>

                </div>


                <div class="grid grid-cols-2 gap-3">

                    {{-- Services --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">

                        <div class="flex items-center justify-between gap-2">

                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                Jasa
                            </p>

                            <i class="bi bi-briefcase text-blue-500"></i>

                        </div>

                        <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                            {{ number_format($category->services_count) }}
                        </p>

                    </div>


                    {{-- Subcategories --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/60">

                        <div class="flex items-center justify-between gap-2">

                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                Subkategori
                            </p>

                            <i class="bi bi-diagram-3 text-blue-500"></i>

                        </div>

                        <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                            {{ number_format($category->subcategories_count) }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- ==================================================
                 ACTION
            =================================================== --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 dark:border-slate-800 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('admin.categories.index') }}"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                >
                    <i class="bi bi-x-lg text-xs"></i>
                    Batal
                </a>


                <button
                    type="submit"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold !text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20"
                >
                    <i class="bi bi-check-lg"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </section>

</div>


</x-layouts.admin>
