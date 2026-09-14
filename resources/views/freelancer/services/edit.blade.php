<x-layouts.freelancer title="Edit Jasa">

    <div class="mx-auto max-w-4xl space-y-6">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <section>
            <a
                href="{{ route('freelancer.services.show', $service) }}"
                class="inline-flex items-center gap-2 text-sm text-[#71837B] transition hover:text-[#0F6B3A]"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke detail jasa
            </a>

            <div class="mt-5">
                <div class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1E9E5A]">
                    Kelola layanan
                </div>

                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-[28px]">
                    Edit jasa
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#6B7E75]">
                    Perbarui informasi layanan kamu agar tetap relevan dan mudah dipahami client.
                </p>
            </div>
        </section>


        {{-- =========================================================
            VALIDATION
        ========================================================== --}}
        @if ($errors->any())
            <div class="rounded-2xl border border-red-100 bg-red-50 p-4">
                <div class="flex items-start gap-3">

                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600"
                    >
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-red-700">
                            Ada data yang perlu diperbaiki.
                        </p>

                        <ul class="mt-2 space-y-1 text-xs leading-5 text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
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
            action="{{ route('freelancer.services.update', $service) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PATCH')

            <div class="space-y-5">

                {{-- =====================================================
                    INFORMASI JASA
                ====================================================== --}}
                <section class="overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

                    <div class="border-b border-[#E8EFEA] px-5 py-5 sm:px-6">
                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                            >
                                <i class="bi bi-briefcase"></i>
                            </div>

                            <div>
                                <h2 class="text-base font-semibold text-[#123128]">
                                    Informasi jasa
                                </h2>

                                <p class="mt-1 text-xs text-[#8A9B94]">
                                    Perbarui informasi utama layanan kamu.
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="space-y-6 p-5 sm:p-6">

                        {{-- Judul --}}
                        <div>
                            <label
                                for="title"
                                class="block text-sm font-medium text-[#29483D]"
                            >
                                Judul jasa
                            </label>

                            <input
                                id="title"
                                type="text"
                                name="title"
                                value="{{ old('title', $service->title) }}"
                                required
                                maxlength="255"
                                class="mt-2 block w-full rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition placeholder:text-[#A0AEA8] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                            >

                            @error('title')
                                <p class="mt-1.5 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Category / Subcategory --}}
                        <div class="grid gap-5 md:grid-cols-2">

                            <div>
                                <label
                                    for="category_id"
                                    class="block text-sm font-medium text-[#29483D]"
                                >
                                    Kategori
                                </label>

                                <select
                                    id="category_id"
                                    name="category_id"
                                    required
                                    class="mt-2 block w-full rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                                >

                                    @foreach ($categories as $category)
                                        <option
                                            value="{{ $category->id }}"
                                            @selected(
                                                old('category_id', $service->category_id) == $category->id
                                            )
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('category_id')
                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>


                            <div>
                                <label
                                    for="subcategory_id"
                                    class="block text-sm font-medium text-[#29483D]"
                                >
                                    Subkategori
                                </label>

                                <select
                                    id="subcategory_id"
                                    name="subcategory_id"
                                    class="mt-2 block w-full rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                                >

                                    <option value="">
                                        Tidak ada subkategori
                                    </option>

                                    @foreach ($subcategories as $subcategory)
                                        <option
                                            value="{{ $subcategory->id }}"
                                            @selected(
                                                old('subcategory_id', $service->subcategory_id) == $subcategory->id
                                            )
                                        >
                                            {{ $subcategory->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('subcategory_id')
                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>


                        {{-- Deskripsi --}}
                        <div>
                            <label
                                for="description"
                                class="block text-sm font-medium text-[#29483D]"
                            >
                                Deskripsi
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="7"
                                required
                                class="mt-2 block w-full resize-none rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#A0AEA8] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                            >{{ old('description', $service->description) }}</textarea>

                            @error('description')
                                <p class="mt-1.5 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                </section>


                {{-- =====================================================
                    HARGA DAN PENGERJAAN
                ====================================================== --}}
                <section class="overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

                    <div class="border-b border-[#E8EFEA] px-5 py-5 sm:px-6">
                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                            >
                                <i class="bi bi-cash-stack"></i>
                            </div>

                            <div>
                                <h2 class="text-base font-semibold text-[#123128]">
                                    Harga dan pengerjaan
                                </h2>

                                <p class="mt-1 text-xs text-[#8A9B94]">
                                    Sesuaikan harga dan estimasi pengerjaan layanan.
                                </p>
                            </div>

                        </div>
                    </div>


                    <div class="grid gap-5 p-5 sm:p-6 md:grid-cols-2">

                        {{-- Harga --}}
                        <div>
                            <label
                                for="starting_price"
                                class="block text-sm font-medium text-[#29483D]"
                            >
                                Harga mulai
                            </label>

                            <div class="relative mt-2">

                                <span
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-xs font-medium text-[#8A9B94]"
                                >
                                    Rp
                                </span>

                                <input
                                    id="starting_price"
                                    type="number"
                                    name="starting_price"
                                    value="{{ old('starting_price', $service->starting_price) }}"
                                    min="1"
                                    required
                                    class="block w-full rounded-xl border border-[#D8E5DD] bg-white py-3 pl-11 pr-4 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                                >

                            </div>

                            @error('starting_price')
                                <p class="mt-1.5 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Delivery --}}
                        <div>
                            <label
                                for="delivery_days"
                                class="block text-sm font-medium text-[#29483D]"
                            >
                                Lama pengerjaan
                            </label>

                            <div class="relative mt-2">

                                <input
                                    id="delivery_days"
                                    type="number"
                                    name="delivery_days"
                                    value="{{ old('delivery_days', $service->delivery_days) }}"
                                    min="1"
                                    max="365"
                                    required
                                    class="block w-full rounded-xl border border-[#D8E5DD] bg-white py-3 pl-4 pr-16 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                                >

                                <span
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-xs text-[#8A9B94]"
                                >
                                    hari
                                </span>

                            </div>

                            @error('delivery_days')
                                <p class="mt-1.5 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                </section>


                {{-- =====================================================
                    THUMBNAIL
                ====================================================== --}}
                <section class="overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

                    <div class="border-b border-[#E8EFEA] px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                            >
                                <i class="bi bi-image"></i>
                            </div>

                            <div>
                                <h2 class="text-base font-semibold text-[#123128]">
                                    Thumbnail jasa
                                </h2>

                                <p class="mt-1 text-xs text-[#8A9B94]">
                                    Gunakan gambar yang paling mewakili layanan kamu.
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="p-5 sm:p-6">

                        {{-- Current image --}}
                        @if ($service->thumbnail)

                            <div class="overflow-hidden rounded-2xl border border-[#E0EBE4] bg-[#F2F7F4]">

                                <div class="aspect-[16/9] max-h-[360px] w-full">

                                    <img
                                        src="{{ asset('storage/' . $service->thumbnail) }}"
                                        alt="{{ $service->title }}"
                                        class="block h-full w-full object-cover"
                                    >

                                </div>

                                <div class="flex items-center gap-2 border-t border-[#E1EBE5] bg-white px-4 py-3 text-xs text-[#71837B]">
                                    <i class="bi bi-image text-[#1E9E5A]"></i>
                                    Thumbnail saat ini
                                </div>

                            </div>

                        @endif


                        {{-- Upload --}}
                        <label
                            for="thumbnail"
                            class="group mt-5 flex min-h-48 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-[#D8E5DD] bg-[#FBFDFC] px-5 text-center transition hover:border-[#BFDCCA] hover:bg-[#F8FCF9]"
                        >

                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A] transition group-hover:bg-[#DDF3E6]"
                            >
                                <i class="bi bi-cloud-arrow-up text-xl"></i>
                            </div>

                            <p class="mt-4 text-sm font-semibold text-[#29483D]">
                                {{ $service->thumbnail ? 'Ganti thumbnail' : 'Pilih thumbnail' }}
                            </p>

                            <p class="mt-1.5 text-xs text-[#8A9B94]">
                                JPG, JPEG, PNG, atau WEBP
                            </p>

                            <p class="mt-1 text-[10px] text-[#A0AEA8]">
                                Maksimal 5 MB
                            </p>

                            <input
                                id="thumbnail"
                                type="file"
                                name="thumbnail"
                                accept="image/*"
                                class="hidden"
                            >

                        </label>

                        @error('thumbnail')
                            <p class="mt-2 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </section>


                {{-- =====================================================
                    STATUS
                ====================================================== --}}
                <section class="overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

                    <div class="border-b border-[#E8EFEA] px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                            >
                                <i class="bi bi-toggle-on"></i>
                            </div>

                            <div>
                                <h2 class="text-base font-semibold text-[#123128]">
                                    Status jasa
                                </h2>

                                <p class="mt-1 text-xs text-[#8A9B94]">
                                    Tentukan status layanan yang sedang kamu kelola.
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="p-5 sm:p-6">

                        <label
                            for="status"
                            class="block text-sm font-medium text-[#29483D]"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="mt-2 block w-full rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                        >

                            <option
                                value="draft"
                                @selected(old('status', $service->status) === 'draft')
                            >
                                Draft
                            </option>

                            <option
                                value="pending"
                                @selected(old('status', $service->status) === 'pending')
                            >
                                Pending
                            </option>

                            <option
                                value="published"
                                @selected(old('status', $service->status) === 'published')
                            >
                                Published
                            </option>

                            <option
                                value="rejected"
                                @selected(old('status', $service->status) === 'rejected')
                            >
                                Rejected
                            </option>

                            <option
                                value="archived"
                                @selected(old('status', $service->status) === 'archived')
                            >
                                Archived
                            </option>

                        </select>

                        <div class="mt-3 rounded-xl bg-[#F8FCF9] px-4 py-3 text-xs leading-5 text-[#71837B]">
                            <div class="flex items-start gap-2">
                                <i class="bi bi-info-circle mt-0.5 shrink-0 text-[#1E9E5A]"></i>
                                <p>
                                    Untuk sementara freelancer dapat mengubah status jasa.
                                    Aturan approval admin akan kita rapikan saat bagian Admin.
                                </p>
                            </div>
                        </div>

                        @error('status')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </section>


                {{-- =====================================================
                    ACTIONS
                ====================================================== --}}
                <div class="flex flex-col-reverse gap-3 pt-1 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('freelancer.services.show', $service) }}"
                        class="inline-flex h-11 items-center justify-center rounded-xl border border-[#D8E5DD] bg-white px-5 text-sm font-medium text-[#52675D] transition hover:bg-[#F8FCF9]"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-6 text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                    >
                        <i class="bi bi-check-lg"></i>
                        Simpan perubahan
                    </button>

                </div>

            </div>

        </form>

    </div>

</x-layouts.freelancer>