<x-layouts.freelancer>


<div class="min-h-screen bg-[#F8FAFC]">
    <div class="mx-auto w-full max-w-5xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

        {{-- Back --}}
        <a
            href="{{ route('freelancer.messages.show', $conversation) }}"
            class="group inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#2563EB]"
        >
            <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white transition group-hover:border-blue-200 group-hover:bg-blue-50">
                <i class="bi bi-arrow-left text-xs"></i>
            </span>
            Kembali ke chat
        </a>

        {{-- Header --}}
        <div class="mt-6 sm:mt-7">
            <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-[#2563EB]">
                <i class="bi bi-file-earmark-text"></i>
                Penawaran
            </div>

            <div class="mt-3">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-[30px]">
                    Kirim penawaran
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                    Buat penawaran berdasarkan hasil diskusi dengan client.
                    Tentukan harga, durasi pengerjaan, dan jumlah revisi yang disepakati.
                </p>
            </div>
        </div>

        {{-- Client / Service Context --}}
        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-4 px-4 py-4 sm:px-5">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                    <i class="bi bi-person text-lg"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                        Client
                    </div>

                    <div class="mt-1 truncate text-sm font-semibold text-slate-800">
                        {{ $conversation->client?->name ?? 'Client' }}
                    </div>

                    @if ($conversation->service)
                        <div class="mt-1 flex min-w-0 items-center gap-1.5 text-xs text-slate-500">
                            <i class="bi bi-briefcase shrink-0 text-[#2563EB]"></i>
                            <span class="truncate">
                                {{ $conversation->service->title }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="hidden shrink-0 sm:block">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-[10px] font-semibold text-emerald-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Diskusi aktif
                    </span>
                </div>
            </div>
        </div>

        {{-- Validation Error --}}
        @if ($errors->any())
            <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 p-4">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">
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
        <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Form Header --}}
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
                            Informasi berikut akan diterima client sebagai dasar persetujuan.
                        </p>
                    </div>
                </div>
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
                            class="block text-sm font-semibold text-slate-800"
                        >
                            Judul penawaran
                        </label>

                        <p class="mt-1 text-xs text-slate-400">
                            Gunakan judul yang singkat dan mudah dipahami client.
                        </p>

                        <input
                            id="title"
                            type="text"
                            name="title"
                            value="{{ old('title', $conversation->service?->title) }}"
                            required
                            maxlength="255"
                            placeholder="Contoh: Pembuatan Website Company Profile"
                            class="mt-2 block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
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
                                Maks. 5000 karakter
                            </span>
                        </div>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            maxlength="5000"
                            placeholder="Jelaskan ruang lingkup pekerjaan, hasil yang akan diberikan, atau kesepakatan penting lainnya..."
                            class="mt-2 block w-full resize-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
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
                                class="block text-sm font-semibold text-slate-800"
                            >
                                Harga
                            </label>

                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-xs font-semibold text-slate-400">
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
                                    class="block w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
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
                                class="block text-sm font-semibold text-slate-800"
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
                                    class="block w-full rounded-xl border border-slate-200 bg-white py-3 pl-4 pr-16 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                                >

                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-xs text-slate-400">
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
                                    class="block w-full rounded-xl border border-slate-200 bg-white py-3 pl-4 pr-16 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                                >

                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-xs text-slate-400">
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
                                class="block text-sm font-semibold text-slate-800"
                            >
                                Batas penawaran
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
                            class="mt-2 block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                        >

                        <p class="mt-2 text-xs leading-5 text-slate-400">
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
                <div class="mt-7 rounded-2xl border border-blue-100 bg-blue-50/60 p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">
                            <i class="bi bi-info-circle"></i>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-800">
                                Sebelum mengirim
                            </p>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Pastikan harga, durasi, dan jumlah revisi sudah sesuai
                                dengan hasil diskusi bersama client.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="mt-7 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:items-center sm:justify-end">

                    <a
                        href="{{ route('freelancer.messages.show', $conversation) }}"
                        class="inline-flex h-11 w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 sm:w-auto"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8] focus:outline-none focus:ring-4 focus:ring-blue-100 sm:w-auto"
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
