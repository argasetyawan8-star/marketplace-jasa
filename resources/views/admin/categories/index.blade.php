<x-layouts.admin title="Kategori">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl border border-[#D8E5DE] bg-white p-6 dark:border-[#2B4337] dark:bg-[#111F18] sm:p-7">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#1E9E5A] dark:text-[#7AD8B5]">
                        <i class="bi bi-grid"></i>
                        Marketplace
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] dark:text-[#E7F2EC] sm:text-3xl">
                        Kategori
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#71837B] dark:text-[#9CB0A5]">
                        Kelola kategori yang digunakan untuk mengelompokkan jasa di marketplace.
                    </p>
                </div>

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                    <i class="bi bi-grid text-xl"></i>
                </div>

            </div>
        </div>

        {{-- Success --}}
        @if(session('success'))
            <div class="flex items-start gap-3 rounded-xl border border-[#BFE3CE] bg-[#EAF7EF] px-4 py-3.5 text-sm text-[#17663D] dark:border-[#2A543E] dark:bg-[#173B29] dark:text-[#A8E5C2]">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#0F6B3A] dark:bg-[#1C402C] dark:text-[#7AD8B5]">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div>
                    <p class="font-semibold">
                        Berhasil
                    </p>

                    <p class="mt-0.5">
                        {{ session('success') }}
                    </p>
                </div>

            </div>
        @endif

        {{-- Error --}}
        @if(session('error'))
            <div class="flex items-start gap-3 rounded-xl border border-[#F0CCCC] bg-[#FEF1F1] px-4 py-3.5 text-sm text-[#B42318] dark:border-[#5A332F] dark:bg-[#321B1B] dark:text-[#F3A39D]">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#B42318] dark:bg-[#422321]">
                    <i class="bi bi-exclamation-circle"></i>
                </div>

                <div>
                    <p class="font-semibold">
                        Tidak dapat diproses
                    </p>

                    <p class="mt-0.5">
                        {{ session('error') }}
                    </p>
                </div>

            </div>
        @endif

        {{-- Add Category --}}
        <div class="rounded-2xl border border-[#D8E5DE] bg-white dark:border-[#2B4337] dark:bg-[#111F18]">

            {{-- Section Header --}}
            <div class="border-b border-[#E5EEE9] px-6 py-5 dark:border-[#263B31] sm:px-7">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                        <i class="bi bi-plus-lg"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            Tambah Kategori
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94] dark:text-[#71877B]">
                            Buat kategori baru untuk marketplace.
                        </p>
                    </div>

                </div>

            </div>

            {{-- Form --}}
            <form
                action="{{ route('admin.categories.store') }}"
                method="POST"
                class="space-y-6 p-6 sm:p-7"
            >
                @csrf

                {{-- Name + Slug --}}
                <div class="grid gap-5 md:grid-cols-2">

                    {{-- Name --}}
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-semibold text-[#345047] dark:text-[#C4D4CC]"
                        >
                            Nama Kategori
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Desain Grafis"
                            class="mt-2 block w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3.5 text-sm text-[#123128] shadow-none outline-none transition placeholder:text-[#9AA8A1] hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:placeholder:text-[#71877B] dark:hover:border-[#4B6658] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
                            required
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label
                            for="slug"
                            class="block text-sm font-semibold text-[#345047] dark:text-[#C4D4CC]"
                        >
                            Slug
                        </label>

                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            value="{{ old('slug') }}"
                            placeholder="desain-grafis"
                            class="mt-2 block w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3.5 text-sm text-[#123128] shadow-none outline-none transition placeholder:text-[#9AA8A1] hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:placeholder:text-[#71877B] dark:hover:border-[#4B6658] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
                        >

                        <p class="mt-2 text-xs text-[#8A9B94] dark:text-[#71877B]">
                            Kosongkan untuk membuat slug otomatis.
                        </p>

                        @error('slug')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- Description --}}
                <div>
                    <label
                        for="description"
                        class="block text-sm font-semibold text-[#345047] dark:text-[#C4D4CC]"
                    >
                        Deskripsi
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Jelaskan kategori ini..."
                        class="mt-2 block w-full resize-none rounded-xl border border-[#BFCFC7] bg-white px-4 py-3.5 text-sm leading-6 text-[#123128] shadow-none outline-none transition placeholder:text-[#9AA8A1] hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:placeholder:text-[#71877B] dark:hover:border-[#4B6658] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-[#B42318]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Icon + Sort --}}
                <div class="grid gap-5 md:grid-cols-2">

                    {{-- Icon --}}
                    <div>
                        <label
                            for="icon"
                            class="block text-sm font-semibold text-[#345047] dark:text-[#C4D4CC]"
                        >
                            Icon
                        </label>

                        <div class="relative mt-2">
                            <i class="bi bi-palette pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#8A9B94] dark:text-[#71877B]"></i>

                            <input
                                type="text"
                                id="icon"
                                name="icon"
                                value="{{ old('icon') }}"
                                placeholder="bi-palette"
                                class="block w-full rounded-xl border border-[#BFCFC7] bg-white py-3.5 pl-11 pr-4 text-sm text-[#123128] shadow-none outline-none transition placeholder:text-[#9AA8A1] hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:placeholder:text-[#71877B] dark:hover:border-[#4B6658] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
                            >
                        </div>

                        <p class="mt-2 text-xs text-[#8A9B94] dark:text-[#71877B]">
                            Contoh class Bootstrap Icons: bi-palette.
                        </p>

                        @error('icon')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Sort Order --}}
                    <div>
                        <label
                            for="sort_order"
                            class="block text-sm font-semibold text-[#345047] dark:text-[#C4D4CC]"
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
                            class="mt-2 block w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3.5 text-sm text-[#123128] shadow-none outline-none transition hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:hover:border-[#4B6658] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
                        >

                        @error('sort_order')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- Active --}}
                <div class="flex flex-col gap-4 rounded-xl border border-[#D8E5DE] bg-[#F8FCF9] p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5 dark:border-[#2B4337] dark:bg-[#16251D]">

                    <div>
                        <p class="text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            Aktifkan kategori
                        </p>

                        <p class="mt-1 text-sm leading-5 text-[#71837B] dark:text-[#8FA69A]">
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

                        <div class="h-6 w-11 rounded-full bg-[#C6D2CC] transition peer-checked:bg-[#1E9E5A] peer-focus:ring-4 peer-focus:ring-[#EAF7EF] dark:bg-[#465A50] dark:peer-focus:ring-[#173B29]"></div>

                        <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"></div>

                    </label>

                </div>

                {{-- Submit --}}
                <div class="flex justify-end border-t border-[#E5EEE9] pt-5 dark:border-[#263B31]">

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0B542D] focus:outline-none focus:ring-4 focus:ring-[#D9F3E3] dark:bg-[#1E9E5A] dark:hover:bg-[#18854A] dark:focus:ring-[#173B29]"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Tambah Kategori
                    </button>

                </div>

            </form>

        </div>

        {{-- Category List --}}
        <div class="overflow-hidden rounded-2xl border border-[#D8E5DE] bg-white dark:border-[#2B4337] dark:bg-[#111F18]">

            {{-- List Header --}}
            <div class="border-b border-[#E5EEE9] px-6 py-5 dark:border-[#263B31] sm:px-7">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                        <i class="bi bi-list-ul"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            Daftar Kategori
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94] dark:text-[#71877B]">
                            {{ $categories->total() }} kategori terdaftar.
                        </p>
                    </div>

                </div>

            </div>

            @if($categories->count())

                {{-- Desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="min-w-full">

                        <thead class="bg-[#F8FCF9] dark:bg-[#16251D]">
                            <tr class="border-b border-[#E5EEE9] dark:border-[#263B31]">

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-[#7C8F87] dark:text-[#71877B]">
                                    Kategori
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-[#7C8F87] dark:text-[#71877B]">
                                    Jasa
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-[#7C8F87] dark:text-[#71877B]">
                                    Subkategori
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide text-[#7C8F87] dark:text-[#71877B]">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-[#7C8F87] dark:text-[#71877B]">
                                    Aksi
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#E5EEE9] dark:divide-[#263B31]">

                            @foreach($categories as $category)

                                <tr class="transition hover:bg-[#FBFDFC] dark:hover:bg-[#16251D]">

                                    {{-- Category --}}
                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                                                <i class="bi {{ $category->icon ?: 'bi-grid' }}"></i>
                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                                    {{ $category->name }}
                                                </p>

                                                <p class="mt-0.5 truncate text-xs text-[#8A9B94] dark:text-[#71877B]">
                                                    {{ $category->slug }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- Services --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                            {{ $category->services_count }}
                                        </span>
                                    </td>

                                    {{-- Subcategories --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                            {{ $category->subcategories_count }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center">

                                        @if($category->is_active)

                                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#EAF7EF] px-2.5 py-1.5 text-xs font-semibold text-[#17663D] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>
                                                Aktif
                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#F3F5F4] px-2.5 py-1.5 text-xs font-semibold text-[#667D73] dark:bg-[#1A2B22] dark:text-[#B3C4BC]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#94A3A0]"></span>
                                                Nonaktif
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4 text-right">

                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('admin.categories.edit', $category) }}"
                                                class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#C9D8D1] bg-white px-3.5 py-2 text-xs font-semibold text-[#526960] transition hover:border-[#BFE7CF] hover:bg-[#EAF7EF] hover:text-[#0F6B3A] dark:border-[#365143] dark:bg-[#16251D] dark:text-[#B3C4BC] dark:hover:border-[#4A6857] dark:hover:bg-[#1A3025] dark:hover:text-[#7AD8B5]"
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
                                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#EBCACA] bg-white px-3.5 py-2 text-xs font-semibold text-[#B42318] transition hover:bg-[#FEF1F1] dark:border-[#59312E] dark:bg-[#16251D] dark:hover:bg-[#321B1B]"
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

                {{-- Mobile --}}
                <div class="divide-y divide-[#E5EEE9] dark:divide-[#263B31] md:hidden">

                    @foreach($categories as $category)

                        <div class="p-5">

                            <div class="flex items-start gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                                    <i class="bi {{ $category->icon ?: 'bi-grid' }}"></i>
                                </div>

                                <div class="min-w-0 flex-1">

                                    <p class="text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                        {{ $category->name }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-[#8A9B94] dark:text-[#71877B]">
                                        {{ $category->slug }}
                                    </p>

                                    <div class="mt-3 flex flex-wrap gap-2">

                                        @if($category->is_active)

                                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#EAF7EF] px-2.5 py-1 text-xs font-semibold text-[#17663D] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>
                                                Aktif
                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#F3F5F4] px-2.5 py-1 text-xs font-semibold text-[#667D73] dark:bg-[#1A2B22] dark:text-[#B3C4BC]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#94A3A0]"></span>
                                                Nonaktif
                                            </span>

                                        @endif

                                        <span class="rounded-lg bg-[#F3F8F5] px-2.5 py-1 text-xs font-medium text-[#667D73] dark:bg-[#1A2B22] dark:text-[#B3C4BC]">
                                            {{ $category->services_count }} jasa
                                        </span>

                                        <span class="rounded-lg bg-[#F3F8F5] px-2.5 py-1 text-xs font-medium text-[#667D73] dark:bg-[#1A2B22] dark:text-[#B3C4BC]">
                                            {{ $category->subcategories_count }} subkategori
                                        </span>

                                    </div>

                                </div>

                            </div>

                            <div class="mt-4 flex gap-2">

                                <a
                                    href="{{ route('admin.categories.edit', $category) }}"
                                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-[#C9D8D1] bg-white px-4 py-2.5 text-xs font-semibold text-[#526960] transition hover:bg-[#F8FCF9] dark:border-[#365143] dark:bg-[#16251D] dark:text-[#B3C4BC] dark:hover:bg-[#1A3025]"
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
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-[#EBCACA] bg-white px-4 py-2.5 text-xs font-semibold text-[#B42318] transition hover:bg-[#FEF1F1] dark:border-[#59312E] dark:bg-[#16251D] dark:hover:bg-[#321B1B]"
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

                {{-- Pagination --}}
                @if($categories->hasPages())
                    <div class="border-t border-[#E5EEE9] px-6 py-4 dark:border-[#263B31] sm:px-7">
                        {{ $categories->links() }}
                    </div>
                @endif

            @else

                {{-- Empty --}}
                <div class="px-6 py-16 text-center sm:px-8">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                        <i class="bi bi-grid text-2xl"></i>
                    </div>

                    <h3 class="mt-5 text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                        Belum ada kategori
                    </h3>

                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-[#8A9B94] dark:text-[#71877B]">
                        Tambahkan kategori pertama untuk mulai mengelompokkan jasa di marketplace.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-layouts.admin>