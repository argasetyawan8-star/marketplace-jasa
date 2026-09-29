
<x-layouts.freelancer title="Tambah Jasa">

    <div class="mx-auto w-full max-w-5xl">

        {{-- HEADER --}}
        <section class="mb-6 pl-2 sm:mb-8 sm:pl-3">

            <a
                href="{{ route('freelancer.services.index') }}"
                class="group inline-flex items-center gap-2 text-xs font-medium text-slate-500 transition hover:text-blue-600 sm:text-sm"
            >
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm transition group-hover:border-blue-200 group-hover:bg-blue-50">
                    <i class="bi bi-arrow-left text-[11px] transition group-hover:-translate-x-0.5"></i>
                </span>

                <span>Kembali ke Jasa Saya</span>
            </a>

           <div class="mt-6 max-w-3xl pl-2 sm:mt-7 sm:pl-3">

                <div class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-blue-600 sm:text-[11px]">
                    Layanan baru
                </div>

                <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Tambah jasa
                </h1>

                <p class="mt-2.5 max-w-2xl text-xs leading-6 text-slate-500 sm:mt-3 sm:text-sm">
                    Buat layanan yang ingin kamu tawarkan kepada client di marketplace ProKerja.
                </p>

            </div>
        </section>


        {{-- VALIDATION --}}
        @if ($errors->any())
            <section class="mb-6 overflow-hidden rounded-2xl border border-red-200 bg-red-50 shadow-sm">

                <div class="flex items-start gap-3 px-4 py-4 sm:px-5 sm:py-5">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                        <i class="bi bi-exclamation-triangle text-sm"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-sm font-bold text-red-700">
                            Ada data yang perlu diperiksa
                        </h2>

                        <ul class="mt-2 space-y-1.5 text-xs leading-5 text-red-600 sm:text-sm">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-2">
                                    <span class="mt-[7px] h-1.5 w-1.5 shrink-0 rounded-full bg-red-500"></span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>

            </section>
        @endif


        {{-- FORM --}}
        <form
            action="{{ route('freelancer.services.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="space-y-5 sm:space-y-6">


                {{-- INFORMASI JASA --}}
                <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-[0_8px_30px_rgba(15,23,42,0.04)]">

                    {{-- HEADER --}}
                    <div class="border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-10 sm:w-10">
                                <i class="bi bi-briefcase text-sm sm:text-base"></i>
                            </div>

                            <div class="min-w-0">

                                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                                    Informasi jasa
                                </h2>

                                <p class="mt-0.5 text-[11px] leading-5 text-slate-500 sm:text-sm">
                                    Lengkapi informasi dasar tentang jasa yang kamu tawarkan.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- BODY --}}
                    <div class="space-y-5 px-4 py-5 sm:space-y-6 sm:px-6 sm:py-6">


                        {{-- JUDUL --}}
                        <div>

                            <label
                                for="title"
                                class="mb-2 block text-xs font-semibold text-slate-700 sm:text-sm"
                            >
                                Judul jasa
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                required
                                maxlength="255"
                                placeholder="Contoh: Desain logo profesional untuk bisnis"
                                class="block h-11 w-full rounded-xl border border-slate-200 bg-white px-3.5 text-xs text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 sm:h-12 sm:px-4 sm:text-sm"
                            >

                        </div>


                        {{-- CATEGORY --}}
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            <div>

                                <label
                                    for="category_id"
                                    class="mb-2 block text-xs font-semibold text-slate-700 sm:text-sm"
                                >
                                    Kategori
                                </label>

                                <select
                                    id="category_id"
                                    name="category_id"
                                    required
                                    class="block h-11 w-full rounded-xl border border-slate-200 bg-white px-3.5 text-xs text-slate-900 shadow-sm outline-none transition hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 sm:h-12 sm:px-4 sm:text-sm"
                                >

                                    <option value="">
                                        Pilih kategori
                                    </option>

                                    @foreach ($categories as $category)

                                        <option
                                            value="{{ $category->id }}"
                                            @selected(old('category_id') == $category->id)
                                        >
                                            {{ $category->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- SUBCATEGORY --}}
                            <div>

                                <label
                                    for="subcategory_id"
                                    class="mb-2 block text-xs font-semibold text-slate-700 sm:text-sm"
                                >
                                    Subkategori
                                    <span class="font-normal text-slate-400">
                                        (opsional)
                                    </span>
                                </label>

                                <select
                                    id="subcategory_id"
                                    name="subcategory_id"
                                    class="block h-11 w-full rounded-xl border border-slate-200 bg-white px-3.5 text-xs text-slate-900 shadow-sm outline-none transition hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 sm:h-12 sm:px-4 sm:text-sm"
                                >

                                    <option value="">
                                        Pilih subkategori
                                    </option>

                                    @foreach ($subcategories as $subcategory)

                                        <option
                                            value="{{ $subcategory->id }}"
                                            @selected(old('subcategory_id') == $subcategory->id)
                                        >
                                            {{ $subcategory->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>


                        {{-- DESCRIPTION --}}
                        <div>

                            <label
                                for="description"
                                class="mb-2 block text-xs font-semibold text-slate-700 sm:text-sm"
                            >
                                Deskripsi jasa
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="7"
                                required
                                placeholder="Jelaskan jasa yang kamu tawarkan, apa yang akan client dapatkan, proses pengerjaan, dan informasi penting lainnya."
                                class="block min-h-[165px] w-full resize-y rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-xs leading-6 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 sm:min-h-[190px] sm:px-4 sm:py-3.5 sm:text-sm"
                            >{{ old('description') }}</textarea>

                            <p class="mt-2 text-[10px] leading-5 text-slate-400 sm:text-xs">
                                Gunakan deskripsi yang jelas agar client memahami layanan yang kamu tawarkan.
                            </p>

                        </div>

                    </div>

                </section>


                {{-- HARGA --}}
                <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-[0_8px_30px_rgba(15,23,42,0.04)]">

                    <div class="border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-10 sm:w-10">
                                <i class="bi bi-wallet2 text-sm sm:text-base"></i>
                            </div>

                            <div class="min-w-0">

                                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                                    Harga & waktu pengerjaan
                                </h2>

                                <p class="mt-0.5 text-[11px] leading-5 text-slate-500 sm:text-sm">
                                    Tentukan harga awal dan estimasi waktu penyelesaian jasa.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 gap-5 px-4 py-5 sm:gap-6 sm:px-6 sm:py-6 md:grid-cols-2">


                        {{-- PRICE --}}
                        <div>

                            <label
                                for="starting_price"
                                class="mb-2 block text-xs font-semibold text-slate-700 sm:text-sm"
                            >
                                Harga mulai
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 sm:pl-4">
                                    <span class="text-xs font-semibold text-slate-500 sm:text-sm">
                                        Rp
                                    </span>
                                </div>

                                <input
                                    type="number"
                                    id="starting_price"
                                    name="starting_price"
                                    value="{{ old('starting_price') }}"
                                    min="1"
                                    required
                                    placeholder="0"
                                    class="block h-11 w-full rounded-xl border border-slate-200 bg-white pl-10 pr-3.5 text-xs text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 sm:h-12 sm:pl-11 sm:pr-4 sm:text-sm"
                                >

                            </div>

                        </div>


                        {{-- DELIVERY --}}
                        <div>

                            <label
                                for="delivery_days"
                                class="mb-2 block text-xs font-semibold text-slate-700 sm:text-sm"
                            >
                                Waktu pengerjaan
                            </label>

                            <div class="relative">

                                <input
                                    type="number"
                                    id="delivery_days"
                                    name="delivery_days"
                                    value="{{ old('delivery_days', 3) }}"
                                    min="1"
                                    max="365"
                                    required
                                    placeholder="3"
                                    class="block h-11 w-full rounded-xl border border-slate-200 bg-white px-3.5 pr-14 text-xs text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 sm:h-12 sm:px-4 sm:pr-16 sm:text-sm"
                                >

                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 sm:pr-4">

                                    <span class="text-xs text-slate-500 sm:text-sm">
                                        hari
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- THUMBNAIL --}}
                <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-[0_8px_30px_rgba(15,23,42,0.04)]">

                    <div class="border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-10 sm:w-10">
                                <i class="bi bi-image text-sm sm:text-base"></i>
                            </div>

                            <div class="min-w-0">

                                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                                    Thumbnail jasa
                                </h2>

                                <p class="mt-0.5 text-[11px] leading-5 text-slate-500 sm:text-sm">
                                    Gunakan gambar yang relevan agar jasa kamu lebih mudah dikenali.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="px-4 py-5 sm:px-6 sm:py-6">

                        <label
                            for="thumbnail"
                            class="group flex min-h-[180px] cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50/70 px-4 py-7 text-center transition duration-200 hover:border-blue-300 hover:bg-blue-50/60 sm:min-h-[220px] sm:px-8 sm:py-8"
                        >

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm ring-1 ring-slate-200 transition group-hover:-translate-y-0.5 sm:h-12 sm:w-12 sm:rounded-2xl">

                                <i class="bi bi-cloud-arrow-up text-base sm:text-lg"></i>

                            </div>


                            <div class="mt-3.5 sm:mt-4">

                                <p class="text-xs font-semibold text-slate-700 sm:text-sm">
                                    Upload thumbnail jasa
                                </p>

                                <p class="mt-1.5 text-[10px] leading-5 text-slate-400 sm:text-xs">
                                    JPG, JPEG, PNG atau WEBP · Maksimal 5 MB
                                </p>

                            </div>


                            <span class="mt-3.5 inline-flex h-9 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-[10px] font-semibold text-slate-600 shadow-sm transition group-hover:border-blue-200 group-hover:text-blue-600 sm:mt-4 sm:h-10 sm:text-xs">
                                Pilih gambar
                            </span>


                            <input
                                type="file"
                                id="thumbnail"
                                name="thumbnail"
                                accept="image/*"
                                class="sr-only"
                            >

                        </label>

                    </div>

                </section>


               
                {{-- ACTIONS --}}
                <div class="border-t border-slate-200 pt-5 sm:pt-6">

                    <div class="flex items-center justify-end gap-2.5 px-1 sm:px-0">

                        <a
                            href="{{ route('freelancer.services.index') }}"
                            class="inline-flex h-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-[11px] font-semibold text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 sm:h-11 sm:px-5 sm:text-xs"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="inline-flex h-10 shrink-0 items-center justify-center gap-1.5 rounded-xl bg-blue-600 px-4 text-[11px] font-semibold text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 active:scale-[0.98] sm:h-11 sm:px-5 sm:text-xs"
                        >
                            <i class="bi bi-check-lg text-[10px] sm:text-xs"></i>
                            <span>Simpan jasa</span>
                        </button>

                    </div>

                </div>


            </div>

        </form>

    </div>

</x-layouts.freelancer>
