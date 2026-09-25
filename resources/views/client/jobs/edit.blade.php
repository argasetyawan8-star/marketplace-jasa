<x-layouts.marketplace>

    <div class="min-h-[calc(100vh-72px)] bg-[#F8FAFC]">

        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            {{-- Breadcrumb / Back --}}
            <div class="mb-6">
                <a
                    href="{{ route('client.jobs.show', $job) }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#2563EB]"
                >
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white text-slate-500 shadow-sm ring-1 ring-slate-200 transition group-hover:bg-blue-50">
                        <i class="bi bi-arrow-left"></i>
                    </span>
                    Kembali ke Job
                </a>
            </div>

            {{-- Page Header --}}
            <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#2563EB]"></span>
                        <span class="text-[11px] font-semibold uppercase tracking-[0.14em] text-[#2563EB]">
                            Job Board
                        </span>
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Edit Job
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                        Perbarui detail pekerjaan agar freelancer mendapatkan informasi
                        yang jelas dan sesuai kebutuhanmu.
                    </p>
                </div>

                <div class="hidden sm:flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                            Mode
                        </p>
                        <p class="text-xs font-semibold text-slate-700">
                            Edit Pekerjaan
                        </p>
                    </div>
                </div>
            </div>

            {{-- Validation Error --}}
            @if($errors->any())
                <div class="mb-6 overflow-hidden rounded-2xl border border-red-100 bg-white shadow-sm">
                    <div class="flex items-start gap-3 border-l-4 border-red-500 bg-red-50/70 px-4 py-4 sm:px-5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-red-800">
                                Ada beberapa bagian yang perlu diperbaiki
                            </p>

                            <div class="mt-1 space-y-0.5 text-xs leading-5 text-red-600">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('client.jobs.update', $job) }}"
            >
                @csrf
                @method('PATCH')

                <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_300px]">

                    {{-- Main Form --}}
                    <div class="space-y-6">

                        {{-- Basic Information --}}
                        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                            <div class="border-b border-slate-100 px-5 py-5 sm:px-7">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB]">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </div>

                                    <div>
                                        <h2 class="text-base font-bold text-slate-900">
                                            Informasi pekerjaan
                                        </h2>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Pastikan judul dan detail pekerjaan mudah dipahami freelancer.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-5 p-5 sm:p-7">

                                {{-- Title --}}
                                <div>
                                    <label
                                        for="title"
                                        class="text-sm font-semibold text-slate-800"
                                    >
                                        Judul pekerjaan
                                    </label>

                                    <input
                                        id="title"
                                        name="title"
                                        value="{{ old('title', $job->title) }}"
                                        required
                                        placeholder="Contoh: Dibutuhkan desain logo untuk brand baru"
                                        class="mt-2 h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                    >

                                    <p class="mt-2 text-[11px] text-slate-400">
                                        Gunakan judul yang singkat, spesifik, dan menggambarkan pekerjaan.
                                    </p>
                                </div>

                                {{-- Category --}}
                                <div class="grid gap-5 sm:grid-cols-2">

                                    <div>
                                        <label
                                            for="category_id"
                                            class="text-sm font-semibold text-slate-800"
                                        >
                                            Kategori
                                        </label>

                                        <select
                                            id="category_id"
                                            name="category_id"
                                            class="mt-2 h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm text-slate-700 outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                        >
                                            <option value="">Pilih kategori</option>

                                            @foreach($categories as $category)
                                                <option
                                                    value="{{ $category->id }}"
                                                    @selected(old('category_id', $job->category_id) == $category->id)
                                                >
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Subcategory --}}
                                    <div>
                                        <label
                                            for="subcategory_id"
                                            class="text-sm font-semibold text-slate-800"
                                        >
                                            Subkategori
                                        </label>

                                        <select
                                            id="subcategory_id"
                                            name="subcategory_id"
                                            class="mt-2 h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm text-slate-700 outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                        >
                                            <option value="">Pilih subkategori</option>

                                            @foreach($categories as $category)
                                                @foreach($category->subcategories as $subcategory)
                                                    <option
                                                        value="{{ $subcategory->id }}"
                                                        @selected(old('subcategory_id', $job->subcategory_id) == $subcategory->id)
                                                    >
                                                        {{ $category->name }} — {{ $subcategory->name }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                {{-- Description --}}
                                <div>
                                    <label
                                        for="description"
                                        class="text-sm font-semibold text-slate-800"
                                    >
                                        Detail pekerjaan
                                    </label>

                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="8"
                                        required
                                        placeholder="Jelaskan pekerjaan yang perlu dikerjakan, hasil yang diharapkan, dan informasi penting lainnya..."
                                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                    >{{ old('description', $job->description) }}</textarea>

                                    <p class="mt-2 text-[11px] text-slate-400">
                                        Semakin lengkap detail yang diberikan, semakin mudah freelancer memahami kebutuhanmu.
                                    </p>
                                </div>

                            </div>
                        </section>

                        {{-- Budget & Schedule --}}
                        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                            <div class="border-b border-slate-100 px-5 py-5 sm:px-7">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                                        <i class="bi bi-wallet2"></i>
                                    </div>

                                    <div>
                                        <h2 class="text-base font-bold text-slate-900">
                                            Budget & waktu
                                        </h2>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Atur kisaran budget dan target penyelesaian pekerjaan.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-5 sm:p-7">

                                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                                    {{-- Budget Min --}}
                                    <div>
                                        <label
                                            for="budget_min"
                                            class="text-sm font-semibold text-slate-800"
                                        >
                                            Budget minimum
                                        </label>

                                        <div class="relative mt-2">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-400">
                                                Rp
                                            </span>

                                            <input
                                                id="budget_min"
                                                type="number"
                                                name="budget_min"
                                                value="{{ old('budget_min', $job->budget_min) }}"
                                                min="0"
                                                placeholder="0"
                                                class="h-12 w-full rounded-2xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-800 outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                            >
                                        </div>
                                    </div>

                                    {{-- Budget Max --}}
                                    <div>
                                        <label
                                            for="budget_max"
                                            class="text-sm font-semibold text-slate-800"
                                        >
                                            Budget maksimum
                                        </label>

                                        <div class="relative mt-2">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-400">
                                                Rp
                                            </span>

                                            <input
                                                id="budget_max"
                                                type="number"
                                                name="budget_max"
                                                value="{{ old('budget_max', $job->budget_max) }}"
                                                min="0"
                                                placeholder="0"
                                                class="h-12 w-full rounded-2xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-800 outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                            >
                                        </div>
                                    </div>

                                    {{-- Duration --}}
                                    <div>
                                        <label
                                            for="duration_days"
                                            class="text-sm font-semibold text-slate-800"
                                        >
                                            Durasi
                                        </label>

                                        <div class="relative mt-2">
                                            <input
                                                id="duration_days"
                                                type="number"
                                                name="duration_days"
                                                value="{{ old('duration_days', $job->duration_days) }}"
                                                min="1"
                                                placeholder="7"
                                                class="h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 pr-16 text-sm text-slate-800 outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                            >

                                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-medium text-slate-400">
                                                hari
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Deadline --}}
                                    <div>
                                        <label
                                            for="deadline"
                                            class="text-sm font-semibold text-slate-800"
                                        >
                                            Deadline
                                        </label>

                                        <input
                                            id="deadline"
                                            type="date"
                                            name="deadline"
                                            value="{{ old('deadline', $job->deadline?->format('Y-m-d')) }}"
                                            class="mt-2 h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm text-slate-700 outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                        >
                                    </div>

                                </div>

                            </div>
                        </section>

                        {{-- Location --}}
                        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                            <div class="border-b border-slate-100 px-5 py-5 sm:px-7">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-sky-50 text-sky-600">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>

                                    <div>
                                        <h2 class="text-base font-bold text-slate-900">
                                            Lokasi pekerjaan
                                        </h2>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Tambahkan lokasi jika pekerjaan membutuhkan area tertentu.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-5 sm:p-7">
                                <label
                                    for="location"
                                    class="text-sm font-semibold text-slate-800"
                                >
                                    Lokasi
                                </label>

                                <div class="relative mt-2">
                                    <div class="pointer-events-none absolute left-4 top-1/2 flex -translate-y-1/2 items-center text-slate-400">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>

                                    <input
                                        id="location"
                                        name="location"
                                        value="{{ old('location', $job->location) }}"
                                        placeholder="Contoh: Yogyakarta atau Remote"
                                        class="h-12 w-full rounded-2xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                    >
                                </div>
                            </div>

                        </section>

                        {{-- Mobile Save Button --}}
                        <div class="lg:hidden">
                            <button
                                type="submit"
                                class="flex h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#2563EB] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-blue-100"
                            >
                                <i class="bi bi-check2-circle"></i>
                                Simpan Perubahan
                            </button>
                        </div>

                    </div>

                    {{-- Sidebar --}}
                    <aside class="space-y-5">

                        {{-- Action Card --}}
                        <div class="sticky top-24 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                            <div class="border-b border-slate-100 p-5">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-blue-600">
                                    Aksi
                                </p>

                                <h2 class="mt-1 text-base font-bold text-slate-900">
                                    Simpan perubahan
                                </h2>

                                <p class="mt-2 text-xs leading-5 text-slate-500">
                                    Pastikan informasi pekerjaan sudah sesuai sebelum menyimpan.
                                </p>
                            </div>

                            <div class="p-5">

                                <button
                                    type="submit"
                                    class="hidden h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#2563EB] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-blue-100 lg:flex"
                                >
                                    <i class="bi bi-check2-circle"></i>
                                    Simpan Perubahan
                                </button>

                                <a
                                    href="{{ route('client.jobs.show', $job) }}"
                                    class="mt-3 flex h-11 w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50"
                                >
                                    <i class="bi bi-arrow-left"></i>
                                    Batal
                                </a>

                            </div>
                        </div>

                        {{-- Tips --}}
                        <div class="overflow-hidden rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 via-white to-blue-50/60 p-5 shadow-sm">

                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-100 text-[#2563EB]">
                                <i class="bi bi-lightbulb"></i>
                            </div>

                            <h3 class="mt-4 text-sm font-bold text-slate-900">
                                Tips membuat Job
                            </h3>

                            <ul class="mt-3 space-y-3">

                                <li class="flex gap-2.5 text-xs leading-5 text-slate-600">
                                    <i class="bi bi-check2 mt-0.5 text-blue-600"></i>
                                    <span>Gunakan judul yang jelas dan langsung menjelaskan kebutuhan.</span>
                                </li>

                                <li class="flex gap-2.5 text-xs leading-5 text-slate-600">
                                    <i class="bi bi-check2 mt-0.5 text-blue-600"></i>
                                    <span>Jelaskan hasil akhir yang kamu harapkan dari freelancer.</span>
                                </li>

                                <li class="flex gap-2.5 text-xs leading-5 text-slate-600">
                                    <i class="bi bi-check2 mt-0.5 text-blue-600"></i>
                                    <span>Berikan budget dan deadline yang realistis.</span>
                                </li>

                            </ul>
                        </div>

                    </aside>

                </div>

            </form>

        </div>
    </div>

</x-layouts.marketplace>