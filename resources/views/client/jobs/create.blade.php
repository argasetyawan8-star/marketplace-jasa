<x-layouts.marketplace>

    <div class="min-h-[calc(100vh-72px)] bg-[#F8FAFC]">
        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            {{-- Breadcrumb --}}
            <div class="mb-6">
                <a
                    href="{{ route('client.jobs.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#2563EB]"
                >
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm">
                        <i class="bi bi-arrow-left text-xs"></i>
                    </span>
                    Kembali ke Job Saya
                </a>
            </div>

            {{-- Page Header --}}
            <div class="mb-7">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5">
                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#2563EB] text-white">
                                <i class="bi bi-briefcase-fill text-[9px]"></i>
                            </span>
                            <span class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#2563EB]">
                                Job Board
                            </span>
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Buat Job Baru
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
                            Jelaskan kebutuhan pekerjaanmu secara detail agar freelancer dapat memahami
                            kebutuhan dan mengajukan proposal yang sesuai.
                        </p>
                    </div>

                    <div class="hidden shrink-0 sm:block">
                        <div class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                                <i class="bi bi-lightbulb"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-800">Tips</p>
                                <p class="text-[11px] text-slate-500">Tulis kebutuhan dengan jelas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Validation Error --}}
            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                            <i class="bi bi-exclamation-triangle-fill text-sm"></i>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-rose-800">
                                Ada beberapa data yang perlu diperiksa
                            </p>

                            <div class="mt-1.5 space-y-0.5 text-xs leading-5 text-rose-600">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form Layout --}}
            <form
                method="POST"
                action="{{ route('client.jobs.store') }}"
            >
                @csrf

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
                                        <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                                            Informasi pekerjaan
                                        </h2>
                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Berikan informasi utama mengenai pekerjaan yang ingin kamu buat.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-5 px-5 py-6 sm:px-7">

                                {{-- Title --}}
                                <div>
                                    <label
                                        for="title"
                                        class="text-sm font-semibold text-slate-800"
                                    >
                                        Judul pekerjaan
                                    </label>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Gunakan judul yang singkat dan langsung menjelaskan kebutuhanmu.
                                    </p>

                                    <input
                                        id="title"
                                        name="title"
                                        value="{{ old('title') }}"
                                        required
                                        placeholder="Contoh: Desain logo untuk brand baru"
                                        class="mt-3 h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                    >
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
                                            class="mt-3 h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm text-slate-700 shadow-sm outline-none transition hover:border-slate-300 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                        >
                                            <option value="">Pilih kategori</option>

                                            @foreach($categories as $category)
                                                <option
                                                    value="{{ $category->id }}"
                                                    @selected(old('category_id') == $category->id)
                                                >
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

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
                                            class="mt-3 h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm text-slate-700 shadow-sm outline-none transition hover:border-slate-300 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                        >
                                            <option value="">Pilih subkategori</option>

                                            @foreach($categories as $category)
                                                @foreach($category->subcategories as $subcategory)
                                                    <option
                                                        value="{{ $subcategory->id }}"
                                                        @selected(old('subcategory_id') == $subcategory->id)
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

                                    <p class="mt-1 text-xs text-slate-500">
                                        Jelaskan kebutuhan, target, referensi, ruang lingkup, dan hasil yang kamu harapkan.
                                    </p>

                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="8"
                                        required
                                        placeholder="Jelaskan kebutuhan, target, referensi, dan hasil yang diharapkan..."
                                        class="mt-3 w-full resize-y rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm leading-6 text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                    >{{ old('description') }}</textarea>
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
                                        <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                                            Budget & waktu pengerjaan
                                        </h2>
                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Tentukan kisaran budget dan waktu yang kamu butuhkan.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="px-5 py-6 sm:px-7">

                                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                                    {{-- Budget Min --}}
                                    <div>
                                        <label
                                            for="budget_min"
                                            class="text-sm font-semibold text-slate-800"
                                        >
                                            Budget minimum
                                        </label>

                                        <div class="relative mt-3">
                                            <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-xs font-medium text-slate-400">
                                                Rp
                                            </span>

                                            <input
                                                id="budget_min"
                                                type="number"
                                                name="budget_min"
                                                value="{{ old('budget_min') }}"
                                                min="0"
                                                placeholder="0"
                                                class="h-12 w-full rounded-2xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
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

                                        <div class="relative mt-3">
                                            <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-xs font-medium text-slate-400">
                                                Rp
                                            </span>

                                            <input
                                                id="budget_max"
                                                type="number"
                                                name="budget_max"
                                                value="{{ old('budget_max') }}"
                                                min="0"
                                                placeholder="0"
                                                class="h-12 w-full rounded-2xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
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

                                        <div class="relative mt-3">
                                            <input
                                                id="duration_days"
                                                type="number"
                                                name="duration_days"
                                                value="{{ old('duration_days') }}"
                                                min="1"
                                                placeholder="7"
                                                class="h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 pr-16 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                            >

                                            <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-xs text-slate-400">
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
                                            value="{{ old('deadline') }}"
                                            class="mt-3 h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 text-sm text-slate-700 shadow-sm outline-none transition hover:border-slate-300 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                        >
                                    </div>

                                </div>

                                {{-- Location --}}
                                <div class="mt-5">
                                    <label
                                        for="location"
                                        class="text-sm font-semibold text-slate-800"
                                    >
                                        Lokasi
                                        <span class="font-normal text-slate-400">(opsional)</span>
                                    </label>

                                    <div class="relative mt-3">
                                        <span class="pointer-events-none absolute left-4 top-1/2 flex -translate-y-1/2 text-slate-400">
                                            <i class="bi bi-geo-alt"></i>
                                        </span>

                                        <input
                                            id="location"
                                            name="location"
                                            value="{{ old('location') }}"
                                            placeholder="Contoh: Remote / Yogyakarta"
                                            class="h-12 w-full rounded-2xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                        >
                                    </div>
                                </div>

                            </div>
                        </section>

                        {{-- Actions --}}
                        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-start gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                                        <i class="bi bi-info-circle"></i>
                                    </div>

                                    <p class="max-w-lg text-xs leading-5 text-slate-500">
                                        Kamu bisa menyimpan job sebagai draft terlebih dahulu atau langsung
                                        mempublikasikannya agar freelancer dapat mengajukan proposal.
                                    </p>
                                </div>

                                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:shrink-0">

                                    <button
                                        type="submit"
                                        name="action"
                                        value="draft"
                                        class="inline-flex h-11 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 text-xs font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 active:scale-[0.98]"
                                    >
                                        <i class="bi bi-file-earmark"></i>
                                        Simpan Draft
                                    </button>

                                    <button
                                        type="submit"
                                        name="action"
                                        value="publish"
                                        class="inline-flex h-11 items-center justify-center gap-2 rounded-2xl bg-[#2563EB] px-5 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md active:scale-[0.98]"
                                    >
                                        <i class="bi bi-send-fill text-[11px]"></i>
                                        Publikasikan Job
                                    </button>

                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- Sidebar --}}
                    <aside class="space-y-5 lg:sticky lg:top-6 lg:self-start">

                        {{-- How it works --}}
                        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB]">
                                    <i class="bi bi-stars"></i>
                                </div>

                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">
                                        Tips membuat Job
                                    </h3>
                                    <p class="text-[11px] text-slate-500">
                                        Agar proposal yang masuk lebih relevan
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 space-y-4">

                                <div class="flex gap-3">
                                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-xs font-bold text-[#2563EB]">
                                        1
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold text-slate-800">
                                            Gunakan judul yang spesifik
                                        </p>
                                        <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                            Freelancer akan lebih mudah memahami pekerjaanmu.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-xs font-bold text-[#2563EB]">
                                        2
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold text-slate-800">
                                            Jelaskan kebutuhan secara detail
                                        </p>
                                        <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                            Sertakan target, referensi, dan hasil yang diharapkan.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-xs font-bold text-[#2563EB]">
                                        3
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold text-slate-800">
                                            Tentukan budget realistis
                                        </p>
                                        <p class="mt-1 text-[11px] leading-5 text-slate-500">
                                            Kisaran budget membantu freelancer mengirim proposal yang sesuai.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Marketplace Info --}}
                        <div class="overflow-hidden rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 via-white to-blue-50/60 p-5 shadow-sm">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#2563EB] text-white shadow-sm">
                                <i class="bi bi-people-fill"></i>
                            </div>

                            <h3 class="mt-4 text-sm font-bold text-slate-900">
                                Temukan freelancer yang tepat
                            </h3>

                            <p class="mt-2 text-xs leading-5 text-slate-500">
                                Setelah job dipublikasikan, freelancer dapat melihat kebutuhanmu
                                dan mengirimkan proposal sesuai kemampuan mereka.
                            </p>

                            <div class="mt-4 flex items-center gap-2 text-[11px] font-semibold text-[#2563EB]">
                                <i class="bi bi-check-circle-fill"></i>
                                Proposal masuk melalui Job Board
                            </div>
                        </div>

                    </aside>

                </div>

            </form>

        </div>
    </div>

</x-layouts.marketplace>