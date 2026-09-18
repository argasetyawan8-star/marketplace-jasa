<x-layouts.freelancer title="Buat Penawaran">

    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">

            <a
                href="{{ route(
                    'freelancer.messages.show',
                    $conversation
                ) }}"
                class="inline-flex items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke percakapan
            </a>

            <div class="mt-5">

                <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                    Penawaran Jasa
                </p>

                <h1 class="mt-1 text-2xl font-semibold tracking-[-0.03em] text-[#123128]">
                    Buat Penawaran
                </h1>

                <p class="mt-2 text-sm leading-6 text-[#71837B]">
                    Buat quotation sesuai kebutuhan client sebelum order dibuat.
                </p>

            </div>

        </div>


        {{-- Error --}}
        @if ($errors->any())

            <div class="mb-5 rounded-2xl border border-red-100 bg-red-50 px-4 py-4">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-500">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>

                    <div>

                        <p class="text-xs font-semibold text-red-700">
                            Ada data yang perlu diperbaiki.
                        </p>

                        <ul class="mt-2 space-y-1 text-xs leading-5 text-red-600">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- Existing Active Offer --}}
        @if ($hasActiveOffer)

            <div class="mb-5 rounded-2xl border border-[#E8DDC3] bg-[#FFF9EA] px-4 py-4">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#9A6800]">
                        <i class="bi bi-hourglass-split"></i>
                    </div>

                    <div>

                        <p class="text-xs font-semibold text-[#815A08]">
                            Masih ada quotation aktif
                        </p>

                        <p class="mt-1 text-xs leading-5 text-[#94763A]">
                            Tunggu client menerima atau menolak quotation sebelumnya sebelum membuat penawaran baru.
                        </p>

                    </div>

                </div>

            </div>

        @endif


        {{-- Service Information --}}
        <div class="mb-5 rounded-2xl border border-[#DDE9E2] bg-white">

            <div class="border-b border-[#E7EEE9] px-5 py-5">

                <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                    Jasa
                </p>

                <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                    {{ $conversation->service->title }}
                </h2>

                <div class="mt-2 flex flex-wrap items-center gap-2 text-[10px] text-[#82928B]">

                    @if ($conversation->service->category)

                        <span>
                            {{ $conversation->service->category->name }}
                        </span>

                    @endif

                    @if ($conversation->service->subcategory)

                        <span class="text-[#C6D0CB]">
                            •
                        </span>

                        <span>
                            {{ $conversation->service->subcategory->name }}
                        </span>

                    @endif

                </div>

            </div>

            <div class="grid gap-3 px-5 py-5 sm:grid-cols-3">

                <div class="rounded-xl bg-[#F8FBF9] px-4 py-3">

                    <p class="text-[9px] text-[#8C9B95]">
                        Harga mulai
                    </p>

                    <p class="mt-1 text-sm font-semibold text-[#18382E]">
                        Rp {{ number_format(
                            (float) $conversation->service->starting_price,
                            0,
                            ',',
                            '.'
                        ) }}
                    </p>

                </div>

                <div class="rounded-xl bg-[#F8FBF9] px-4 py-3">

                    <p class="text-[9px] text-[#8C9B95]">
                        Estimasi
                    </p>

                    <p class="mt-1 text-sm font-semibold text-[#18382E]">
                        {{ $conversation->service->delivery_days }}
                        hari
                    </p>

                </div>

                <div class="rounded-xl bg-[#F8FBF9] px-4 py-3">

                    <p class="text-[9px] text-[#8C9B95]">
                        Client
                    </p>

                    <p class="mt-1 truncate text-sm font-semibold text-[#18382E]">
                        {{ $conversation->client?->name ?? 'Client' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Form --}}
        <div class="rounded-2xl border border-[#DDE9E2] bg-white">

            <div class="border-b border-[#E7EEE9] px-5 py-5">

                <h2 class="text-sm font-semibold text-[#123128]">
                    Detail penawaran
                </h2>

                <p class="mt-1 text-xs text-[#87978F]">
                    Tentukan isi quotation yang akan dikirim kepada client.
                </p>

            </div>


            <form
                action="{{ route(
                    'freelancer.messages.offers.store',
                    $conversation
                ) }}"
                method="POST"
                class="space-y-5 px-5 py-5"
            >

                @csrf


                {{-- Title --}}
                <div>

                    <label
                        for="title"
                        class="mb-2 block text-xs font-semibold text-[#52675D]"
                    >
                        Judul penawaran
                    </label>

                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="{{ old('title', 'Penawaran ' . $conversation->service->title) }}"
                        maxlength="255"
                        required
                        class="block w-full rounded-xl border border-[#D8E5DD] bg-[#F8FCF9] px-4 py-3 text-sm text-[#123128] outline-none transition placeholder:text-[#9BA9A2] focus:border-[#1E9E5A] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
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

                    <label
                        for="description"
                        class="mb-2 block text-xs font-semibold text-[#52675D]"
                    >
                        Deskripsi penawaran
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        maxlength="10000"
                        class="block w-full resize-none rounded-xl border border-[#D8E5DD] bg-[#F8FCF9] px-4 py-3 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#9BA9A2] focus:border-[#1E9E5A] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
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
                        class="mb-2 block text-xs font-semibold text-[#52675D]"
                    >
                        Harga penawaran
                    </label>

                    <div class="relative">

                        <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-xs font-semibold text-[#83928C]">
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
                            class="block w-full rounded-xl border border-[#D8E5DD] bg-[#F8FCF9] py-3 pl-11 pr-4 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
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

                    <div>

                        <label
                            for="delivery_days"
                            class="mb-2 block text-xs font-semibold text-[#52675D]"
                        >
                            Waktu pengerjaan
                        </label>

                        <div class="relative">

                            <input
                                id="delivery_days"
                                type="number"
                                name="delivery_days"
                                value="{{ old('delivery_days', $conversation->service->delivery_days) }}"
                                min="1"
                                max="365"
                                required
                                class="block w-full rounded-xl border border-[#D8E5DD] bg-[#F8FCF9] px-4 py-3 pr-16 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
                            >

                            <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-[10px] text-[#8A9992]">
                                hari
                            </span>

                        </div>

                        @error('delivery_days')

                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    <div>

                        <label
                            for="revision_count"
                            class="mb-2 block text-xs font-semibold text-[#52675D]"
                        >
                            Jumlah revisi
                        </label>

                        <div class="relative">

                            <input
                                id="revision_count"
                                type="number"
                                name="revision_count"
                                value="{{ old('revision_count', 1) }}"
                                min="0"
                                max="100"
                                required
                                class="block w-full rounded-xl border border-[#D8E5DD] bg-[#F8FCF9] px-4 py-3 pr-16 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
                            >

                            <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-[10px] text-[#8A9992]">
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

                    <label
                        for="expires_at"
                        class="mb-2 block text-xs font-semibold text-[#52675D]"
                    >
                        Berlaku sampai
                    </label>

                    <input
                        id="expires_at"
                        type="datetime-local"
                        name="expires_at"
                        value="{{ old('expires_at') }}"
                        class="block w-full rounded-xl border border-[#D8E5DD] bg-[#F8FCF9] px-4 py-3 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
                    >

                    <p class="mt-1.5 text-[10px] leading-5 text-[#8B9A94]">
                        Kosongkan jika quotation tidak memiliki batas waktu.
                    </p>

                    @error('expires_at')

                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Info --}}
                <div class="rounded-xl border border-[#DCEBE1] bg-[#F7FBF8] px-4 py-4">

                    <div class="flex items-start gap-3">

                        <i class="bi bi-info-circle mt-0.5 text-[#1E9E5A]"></i>

                        <p class="text-xs leading-5 text-[#698077]">
                            Setelah client menerima penawaran, sistem akan membuat order dan client dapat melanjutkan ke pembayaran.
                        </p>

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="flex flex-col-reverse gap-2 pt-2 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route(
                            'freelancer.messages.show',
                            $conversation
                        ) }}"
                        class="inline-flex h-11 items-center justify-center rounded-xl border border-[#D8E5DD] bg-white px-5 text-xs font-semibold text-[#52685F] transition hover:border-[#BBD9C6] hover:bg-[#F4FAF6]"
                    >
                        Batal
                    </a>


                    <button
                        type="submit"
                        @disabled($hasActiveOffer)
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 text-xs font-semibold text-white transition hover:bg-[#1E9E5A] disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <i class="bi bi-send"></i>
                        Kirim penawaran
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.freelancer>