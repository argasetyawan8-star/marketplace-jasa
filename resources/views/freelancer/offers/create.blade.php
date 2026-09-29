<x-layouts.freelancer title="Buat Quotation">


<div class="min-h-screen bg-[#F8FAFC]">
    <div class="mx-auto w-full max-w-6xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

        {{-- Back --}}
        <div class="mb-6">
            <a
                href="{{ route('freelancer.jobs.show', $job) }}"
                class="group inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#2563EB]"
            >
                <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white transition group-hover:border-blue-200 group-hover:bg-blue-50">
                    <i class="bi bi-arrow-left text-xs"></i>
                </span>
                Kembali ke Job
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">

            {{-- Main --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Header --}}
                <div class="border-b border-slate-100 px-5 py-5 sm:px-6 sm:py-6">
                    <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-[#2563EB]">
                        <i class="bi bi-file-earmark-text"></i>
                        Quotation
                    </div>

                    <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-[30px]">
                        Kirim Penawaran
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Buat quotation berdasarkan kebutuhan client dan detail pekerjaan pada job ini.
                    </p>
                </div>

                {{-- Form --}}
                <form
                    method="POST"
                    action="{{ route(
                        'freelancer.jobs.proposals.offer.store',
                        [$job, $proposal]
                    ) }}"
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
                                Judul quotation
                            </label>

                            <p class="mt-1 text-xs text-slate-400">
                                Gunakan judul yang jelas agar client mudah mengenali penawaran ini.
                            </p>

                            <input
                                id="title"
                                name="title"
                                type="text"
                                value="{{ old(
                                    'title',
                                    'Penawaran untuk ' . $job->title
                                ) }}"
                                required
                                maxlength="255"
                                class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
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
                                    Detail pekerjaan
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
                                class="mt-2 w-full resize-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                                placeholder="Jelaskan pekerjaan, output, dan ketentuan yang akan diberikan."
                            >{{ old(
                                'description',
                                $proposal->message
                            ) }}</textarea>

                            @error('description')
                                <p class="mt-1.5 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Price / Delivery --}}
                        <div class="grid gap-5 sm:grid-cols-2">

                            {{-- Price --}}
                            <div>
                                <label
                                    for="price"
                                    class="block text-sm font-semibold text-slate-800"
                                >
                                    Harga
                                </label>

                                <div class="relative mt-2">
                                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-400">
                                        Rp
                                    </span>

                                    <input
                                        id="price"
                                        name="price"
                                        type="number"
                                        min="1"
                                        step="0.01"
                                        value="{{ old(
                                            'price',
                                            $proposal->price
                                        ) }}"
                                        required
                                        class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                                    >
                                </div>

                                @error('price')
                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <p class="mt-1.5 text-xs text-slate-400">
                                    Harga hanya dapat dilihat client.
                                </p>
                            </div>

                            {{-- Delivery --}}
                            <div>
                                <label
                                    for="delivery_days"
                                    class="block text-sm font-semibold text-slate-800"
                                >
                                    Estimasi pengerjaan
                                </label>

                                <div class="relative mt-2">
                                    <input
                                        id="delivery_days"
                                        name="delivery_days"
                                        type="number"
                                        min="1"
                                        max="365"
                                        value="{{ old(
                                            'delivery_days',
                                            $proposal->delivery_days
                                        ) }}"
                                        required
                                        class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-4 pr-20 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                                    >

                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400">
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

                        {{-- Revisions --}}
                        <div>
                            <label
                                for="revision_count"
                                class="block text-sm font-semibold text-slate-800"
                            >
                                Jumlah revisi
                            </label>

                            <p class="mt-1 text-xs text-slate-400">
                                Tentukan jumlah revisi yang termasuk dalam quotation.
                            </p>

                            <div class="relative mt-2">
                                <input
                                    id="revision_count"
                                    name="revision_count"
                                    type="number"
                                    min="0"
                                    max="100"
                                    value="{{ old(
                                        'revision_count',
                                        1
                                    ) }}"
                                    required
                                    class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-4 pr-16 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                                >

                                <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400">
                                    kali
                                </span>
                            </div>

                            @error('revision_count')
                                <p class="mt-1.5 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Expiration --}}
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
                                name="expires_at"
                                type="datetime-local"
                                value="{{ old('expires_at') }}"
                                class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                            >

                            <p class="mt-2 text-xs leading-5 text-slate-400">
                                Kosongkan jika quotation tidak memiliki batas waktu khusus.
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
                                    <i class="bi bi-info-circle-fill"></i>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800">
                                        Setelah client menerima quotation
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Sistem akan membuat Order JASAIN secara otomatis
                                        dan client dapat melanjutkan ke checkout.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="mt-7 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route(
                                'freelancer.jobs.show',
                                $job
                            ) }}"
                            class="inline-flex h-11 w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 sm:w-auto"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8] focus:outline-none focus:ring-4 focus:ring-blue-100 sm:w-auto"
                        >
                            <i class="bi bi-send"></i>
                            Kirim Quotation
                        </button>

                    </div>
                </form>
            </div>

            {{-- Job Context --}}
            <aside class="h-fit overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-5 py-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                            <i class="bi bi-briefcase"></i>
                        </div>

                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                Job
                            </p>

                            <h2 class="mt-1 line-clamp-2 text-sm font-bold leading-5 text-slate-900">
                                {{ $job->title }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 p-5 text-sm">

                    {{-- Budget --}}
                    <div class="rounded-xl bg-slate-50 p-3.5">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-xs text-slate-500">
                                Budget
                            </span>

                            <span class="text-right text-xs font-semibold text-slate-800">
                                Rp{{ number_format(
                                    $job->budget_min,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                                -
                                Rp{{ number_format(
                                    $job->budget_max,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </span>
                        </div>
                    </div>

                    {{-- Duration --}}
                    <div class="rounded-xl bg-slate-50 p-3.5">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-xs text-slate-500">
                                Durasi job
                            </span>

                            <span class="text-xs font-semibold text-slate-800">
                                {{ $job->delivery_days }} hari
                            </span>
                        </div>
                    </div>

                    {{-- Proposal --}}
                    <div class="border-t border-slate-100 pt-4">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2563EB]">
                                <i class="bi bi-chat-quote text-xs"></i>
                            </div>

                            <p class="text-xs font-semibold text-slate-700">
                                Alasan freelancer tertarik
                            </p>
                        </div>

                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            {{ $proposal->message }}
                        </p>
                    </div>

                </div>
            </aside>

        </div>
    </div>
</div>


</x-layouts.freelancer>
