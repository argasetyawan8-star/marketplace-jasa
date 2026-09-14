<x-layouts.freelancer>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Back --}}
        <a
            href="{{ route('freelancer.messages.show', $conversation) }}"
            class="inline-flex items-center gap-2 text-sm text-[#71837B] transition hover:text-[#0F6B3A]"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke chat
        </a>

        {{-- Header --}}
        <div class="mt-6">
            <div class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1E9E5A]">
                Penawaran
            </div>

            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-[28px]">
                Kirim penawaran
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-[#6B7E75]">
                Buat penawaran berdasarkan hasil diskusi dengan client.
                Tentukan harga, durasi pengerjaan, dan jumlah revisi yang disepakati.
            </p>
        </div>

        {{-- Client / Service Context --}}
        <div class="mt-7 rounded-2xl border border-[#DDE9E2] bg-[#F8FCF9] p-4 sm:p-5">
            <div class="flex items-center gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                >
                    <i class="bi bi-person text-lg"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="text-[11px] font-medium uppercase tracking-[0.06em] text-[#8A9B94]">
                        Client
                    </div>

                    <div class="mt-1 truncate text-sm font-semibold text-[#29483D]">
                        {{ $conversation->client?->name ?? 'Client' }}
                    </div>

                    @if ($conversation->service)
                        <div class="mt-1 flex items-center gap-1.5 text-xs text-[#71837B]">
                            <i class="bi bi-briefcase text-[#1E9E5A]"></i>
                            <span class="truncate">
                                {{ $conversation->service->title }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="hidden shrink-0 sm:block">
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1.5 text-[10px] font-semibold text-[#0F6B3A]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>
                        Diskusi aktif
                    </span>
                </div>

            </div>
        </div>

        {{-- Validation Error --}}
        @if ($errors->any())
            <div class="mt-5 rounded-2xl border border-red-100 bg-red-50 p-4">
                <div class="flex items-start gap-3">

                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600"
                    >
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-red-700">
                            Periksa kembali data penawaran
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

        {{-- Main Form --}}
        <div class="mt-5 overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

            <div class="border-b border-[#E8EFEA] px-5 py-5 sm:px-6">
                <h2 class="text-base font-semibold text-[#123128]">
                    Detail penawaran
                </h2>

                <p class="mt-1 text-xs text-[#8A9B94]">
                    Informasi berikut akan diterima client sebagai dasar persetujuan.
                </p>
            </div>

            <form
                action="{{ route('freelancer.messages.offers.store', $conversation) }}"
                method="POST"
                class="p-5 sm:p-6 lg:p-7"
            >
                @csrf

                <div class="space-y-6">

                    {{-- Title --}}
                    <div>
                        <label
                            for="title"
                            class="block text-sm font-medium text-[#29483D]"
                        >
                            Judul penawaran
                        </label>

                        <input
                            id="title"
                            type="text"
                            name="title"
                            value="{{ old('title', $conversation->service?->title) }}"
                            required
                            maxlength="255"
                            placeholder="Contoh: Pembuatan Website Company Profile"
                            class="mt-2 block w-full rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition placeholder:text-[#A0AEA8] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
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
                            class="block text-sm font-medium text-[#29483D]"
                        >
                            Deskripsi penawaran
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            maxlength="5000"
                            placeholder="Jelaskan ruang lingkup pekerjaan, hasil yang akan diberikan, atau kesepakatan penting lainnya..."
                            class="mt-2 block w-full resize-none rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#A0AEA8] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Pricing / Delivery / Revision --}}
                    <div class="grid gap-5 md:grid-cols-3">

                        {{-- Price --}}
                        <div>
                            <label
                                for="price"
                                class="block text-sm font-medium text-[#29483D]"
                            >
                                Harga
                            </label>

                            <div class="relative mt-2">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-xs font-medium text-[#8A9B94]"
                                >
                                    Rp
                                </div>

                                <input
                                    id="price"
                                    type="number"
                                    name="price"
                                    value="{{ old('price') }}"
                                    min="1"
                                    step="1"
                                    required
                                    placeholder="500000"
                                    class="block w-full rounded-xl border border-[#D8E5DD] bg-white py-3 pl-11 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#A0AEA8] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                                >
                            </div>

                            @error('price')
                                <p class="mt-1.5 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Delivery Days --}}
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
                                    value="{{ old('delivery_days', 3) }}"
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

                        {{-- Revisions --}}
                        <div>
                            <label
                                for="revision_count"
                                class="block text-sm font-medium text-[#29483D]"
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
                                    class="block w-full rounded-xl border border-[#D8E5DD] bg-white py-3 pl-4 pr-16 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                                >

                                <span
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-xs text-[#8A9B94]"
                                >
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

                    {{-- Expiration --}}
                    <div>
                        <div class="flex items-center justify-between gap-3">
                            <label
                                for="expires_at"
                                class="block text-sm font-medium text-[#29483D]"
                            >
                                Batas penawaran
                            </label>

                            <span class="text-[11px] text-[#98A7A0]">
                                Opsional
                            </span>
                        </div>

                        <input
                            id="expires_at"
                            type="datetime-local"
                            name="expires_at"
                            value="{{ old('expires_at') }}"
                            class="mt-2 block w-full rounded-xl border border-[#D8E5DD] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
                        >

                        <p class="mt-2 text-xs leading-5 text-[#8A9B94]">
                            Kosongkan apabila penawaran tidak memiliki batas waktu khusus.
                        </p>

                        @error('expires_at')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- Bottom Note --}}
                <div class="mt-7 rounded-2xl border border-[#E0EBE4] bg-[#F8FCF9] p-4">
                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]"
                        >
                            <i class="bi bi-info-circle"></i>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-[#29483D]">
                                Sebelum mengirim
                            </p>

                            <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                Pastikan harga, durasi, dan jumlah revisi sudah sesuai
                                dengan hasil diskusi bersama client.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Actions --}}
                <div class="mt-7 flex flex-col-reverse gap-3 border-t border-[#E8EFEA] pt-6 sm:flex-row sm:items-center sm:justify-end">

                    <a
                        href="{{ route('freelancer.messages.show', $conversation) }}"
                        class="inline-flex h-11 items-center justify-center rounded-xl border border-[#D8E5DD] bg-white px-5 text-sm font-medium text-[#52675D] transition hover:border-[#C3D8CB] hover:bg-[#F8FCF9]"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-6 text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                    >
                        <i class="bi bi-send"></i>
                        Kirim penawaran
                    </button>

                </div>

            </form>
        </div>

    </div>

</x-layouts.freelancer>