<x-layouts.admin title="Edit Kategori">

    <div class="mx-auto max-w-3xl space-y-6">

        {{-- Back --}}
        <a
            href="{{ route('admin.categories.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#0F6B3A] dark:text-[#9CB0A5] dark:hover:text-[#7AD8B5]"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke Kategori
        </a>

        {{-- Header --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 dark:border-[#263B31] dark:bg-[#111F18] sm:p-7">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                    <i class="bi bi-pencil"></i>
                </div>

                <div>
                    <h1 class="text-2xl font-semibold tracking-tight text-[#123128] dark:text-[#E7F2EC]">
                        Edit Kategori
                    </h1>

                    <p class="mt-1 text-sm text-[#8A9B94] dark:text-[#71877B]">
                        Perbarui informasi kategori marketplace.
                    </p>
                </div>

            </div>

        </div>

        {{-- Errors --}}
        @if($errors->any())
            <div class="rounded-xl border border-[#F2D0D0] bg-[#FEF0F0] p-4 dark:border-[#59312E] dark:bg-[#321B1B]">
                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#B42318] dark:bg-[#422321]">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-[#B42318] dark:text-[#F3A39D]">
                            Ada beberapa data yang perlu diperbaiki.
                        </p>

                        <ul class="mt-2 space-y-1 text-sm text-[#A64A43] dark:text-[#E89A92]">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endif

        {{-- Form --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white dark:border-[#263B31] dark:bg-[#111F18]">

            <form
                action="{{ route('admin.categories.update', $category) }}"
                method="POST"
                class="space-y-6 p-6 sm:p-7"
            >
                @csrf
                @method('PATCH')

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
                        value="{{ old('name', $category->name) }}"
                        class="mt-2 w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
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
                        value="{{ old('slug', $category->slug) }}"
                        class="mt-2 w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
                    >

                    @error('slug')
                        <p class="mt-2 text-sm text-[#B42318]">
                            {{ $message }}
                        </p>
                    @enderror
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
                        rows="5"
                        class="mt-2 w-full resize-none rounded-xl border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm leading-6 text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
                    >{{ old('description', $category->description) }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-[#B42318]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Icon + Sort --}}
                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label
                            for="icon"
                            class="block text-sm font-semibold text-[#345047] dark:text-[#C4D4CC]"
                        >
                            Icon
                        </label>

                        <input
                            type="text"
                            id="icon"
                            name="icon"
                            value="{{ old('icon', $category->icon) }}"
                            placeholder="bi-palette"
                            class="mt-2 w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
                        >

                        @error('icon')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

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
                            min="0"
                            max="9999"
                            value="{{ old('sort_order', $category->sort_order) }}"
                            class="mt-2 w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
                        >

                        @error('sort_order')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- Status --}}
                <div class="flex items-center justify-between gap-4 rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">

                    <div>
                        <p class="text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            Status kategori
                        </p>

                        <p class="mt-1 text-sm text-[#71837B] dark:text-[#8FA69A]">
                            Kategori aktif akan tersedia pada marketplace.
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

                        <div class="h-6 w-11 rounded-full bg-[#CAD6D0] transition peer-checked:bg-[#1E9E5A] peer-focus:ring-4 peer-focus:ring-[#EAF7EF] dark:bg-[#43564C] dark:peer-focus:ring-[#173B29]"></div>

                        <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"></div>

                    </label>

                </div>

                {{-- Usage --}}
                <div class="grid grid-cols-2 gap-4">

                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                        <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                            Jasa
                        </p>

                        <p class="mt-2 text-xl font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            {{ $category->services_count }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                        <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                            Subkategori
                        </p>

                        <p class="mt-2 text-xl font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            {{ $category->subcategories_count }}
                        </p>
                    </div>

                </div>

                {{-- Action --}}
                <div class="flex flex-col-reverse gap-3 border-t border-[#E7EFEA] pt-6 dark:border-[#263B31] sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E5DE] bg-white px-5 py-3 text-sm font-semibold text-[#526960] transition hover:bg-[#F8FCF9] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#B3C4BC] dark:hover:bg-[#1A3025]"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                    >
                        <i class="bi bi-check-lg"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.admin>