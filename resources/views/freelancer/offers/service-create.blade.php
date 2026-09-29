<x-layouts.freelancer title="Buat Penawaran">


<div class="min-h-screen bg-[#F8FAFC]">
    <div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">
            <a
                href="{{ route(
                    'freelancer.messages.show',
                    $conversation
                ) }}"
                class="group inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#2563EB]"
            >
                <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white transition group-hover:border-blue-200 group-hover:bg-blue-50">
                    <i class="bi bi-arrow-left text-xs"></i>
                </span>
                Kembali ke percakapan
            </a>

            <div class="mt-6">
                <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-[#2563EB]">
                    <i class="bi bi-file-earmark-text"></i>
                    Penawaran Jasa
                </div>

                <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-[30px]">
                    Buat Penawaran
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                    Buat quotation sesuai kebutuhan client sebelum order dibuat.
                </p>
            </div>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>

                    <div class="min-w-0">
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

        {{-- Existing Active Offer --}}
        @if ($hasActiveOffer)
            <div class="mb-5 rounded-2xl border border-amber-200 bg-amber-50 p-4">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm">
                        <i class="bi bi-hourglass-split"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-amber-800">
                            Masih ada quotation aktif
                        </p>

                        <p class="mt-1 text-xs leading-5 text-amber-700">
                            Tunggu client menerima atau menolak quotation sebelumnya
                            sebelum membuat penawaran baru.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Service Information --}}
        <div class="mb-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-5 sm:px-6">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                        <i class="bi bi-briefcase"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-[#2563EB]">
                            Jasa
                        </p>

                        <h2 class="mt-1 truncate text-base font-bold text-slate-900">
                            {{ $conversation->service->title }}
                        </h2>

                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-slate-400">
                            @if ($conversation->service->category)
                                <span>
                                    {{ $conversation->service->category->name }}
                                </span>
                            @endif

                            @if ($conversation->service->subcategory)
                                <span class="text-slate-300">•</span>

                                <span>
                                    {{ $conversation->service->subcategory->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-3 px-5 py-5 sm:grid-cols-3 sm:px-6">

                {{-- Starting Price --}}
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-[10px] font-medium text-slate-400">
                        Harga mulai
                    </p>

                    <p class="mt-1 text-sm font-bold text-slate-800">
                        Rp {{ number_format(
                            (float) $conversation->service->starting_price,
                            0,
                            ',',
                            '.'
                        ) }}
                    </p>
                </div>

                {{-- Delivery --}}
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-[10px] font-medium text-slate-400">
                        Estimasi
                    </p>

                    <p class="mt-1 text-sm font-bold text-slate-800">
                        {{ $conversation->service->delivery_days }}
                        hari
                    </p>
                </div>

                {{-- Client --}}
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-[10px] font-medium text-slate-400">
                        Client
                    </p>

                    <p class="mt-1 truncate text-sm font-bold text-slate-800">
                        {{ $conversation->client?->name ?? 'Client' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Form --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-5 sm:px-6">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-slate-900">
                            Detail penawaran
                        </h2>

                        <p class="mt-1 text-xs leading-5 text-slate-500">
                            Tentukan isi quotation yang akan dikirim kepada client.
                        </p>
                    </div>
                </div>
            </div>

            <form
                action="{{ route(
                    'freelancer.messages.offers.store',
                    $conversation
                ) }}"
                method="POST"
                class="space-y-6 p-5 sm:p-6"
            >
                @csrf

                {{-- Title --}}
                <div>
                    <label
                        for="title"
                        class="block text-sm font-semibold text-slate-800"
                    >
                        Judul penawaran
                    </label>

                    <p class="mt-1 text-xs text-slate-400">
                        Gunakan judul yang jelas dan mudah dipahami client.
                    </p>

                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="{{ old('title', 'Penawaran ' . $conversation->service->title) }}"
                        maxlength="255"
                        required
                        class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                        placeholder="Contoh: Penawaran jasa sesuai kebutuhan client"
                    >

                    @error('title')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <div class="flex items-center justify-between gap-3">
                        <label
                            for="description"
                            class="block text-sm font-semibold text-slate-800"
                        >
                            Deskripsi penawaran
                        </label>

                        <span class="text-[10px] text-slate-400">
                            Maks. 10000 karakter
                        </span>
                    </div>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        maxlength="10000"
                        class="mt-2 block w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                        placeholder="Jelaskan apa saja yang akan dikerjakan untuk client..."
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label
                        for="price"
                        class="block text-sm font-semibold text-slate-800"
                    >
                        Harga penawaran
                    </label>

                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-xs font-semibold text-slate-400">
                            Rp
                        </span>

                        <input
                            id="price"
                            type="number"
                            name="price"
                            value="{{ old('price', $conversation->service->starting_price) }}"
                            min="1"
                            step="1"
                            required
                            class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            placeholder="100000"
                        >
                    </div>

                    @error('price')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Delivery + Revision --}}
                <div class="grid gap-5 sm:grid-cols-2">

                    {{-- Delivery --}}
                    <div>
                        <label
                            for="delivery_days"
                            class="block text-sm font-semibold text-slate-800"
                        >
                            Waktu pengerjaan
                        </label>

                        <div class="relative mt-2">
                            <input
                                id="delivery_days"
                                type="number"
                                name="delivery_days"
                                value="{{ old('delivery_days', $conversation->service->delivery_days) }}"
                                min="1"
                                max="365"
                                required
                                class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-16 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            >

                            <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-xs text-slate-400">
                                hari
                            </span>
                        </div>

                        @error('delivery_days')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Revision --}}
                    <div>
                        <label
                            for="revision_count"
                            class="block text-sm font-semibold text-slate-800"
                        >
                            Jumlah revisi
                        </label>

                        <div class="relative mt-2">
                            <input
                                id="revision_count"
                                type="number"
                                name="revision_count"
                                value="{{ old('revision_count', 1) }}"
                                min="0"
                                max="100"
                                required
                                class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-16 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            >

                            <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-xs text-slate-400">
                                kali
                            </span>
                        </div>

                        @error('revision_count')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- Expiry --}}
                <div>
                    <div class="flex items-center justify-between gap-3">
                        <label
                            for="expires_at"
                            class="block text-sm font-semibold text-slate-800"
                        >
                            Berlaku sampai
                        </label>

                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-medium text-slate-500">
                            Opsional
                        </span>
                    </div>

                    <input
                        id="expires_at"
                        type="datetime-local"
                        name="expires_at"
                        value="{{ old('expires_at') }}"
                        class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                    >

                    <p class="mt-2 text-xs leading-5 text-slate-400">
                        Kosongkan jika quotation tidak memiliki batas waktu.
                    </p>

                    @error('expires_at')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Info --}}
                <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">
                            <i class="bi bi-info-circle"></i>
                        </div>

                        <p class="text-xs leading-5 text-slate-500">
                            Setelah client menerima penawaran, sistem akan membuat order
                            dan client dapat melanjutkan ke pembayaran.
                        </p>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route(
                            'freelancer.messages.show',
                            $conversation
                        ) }}"
                        class="inline-flex h-11 w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 sm:w-auto"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        @disabled($hasActiveOffer)
                        class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8] focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-50 sm:w-auto"
                    >
                        <i class="bi bi-send"></i>
                        Kirim penawaran
                    </button>

                </div>

            </form>
        </div>

    </div>
</div>


</x-layouts.freelancer>
