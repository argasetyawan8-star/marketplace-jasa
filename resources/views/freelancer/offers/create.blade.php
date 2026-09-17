<x-layouts.freelancer title="Buat Quotation">
    
<div class="min-h-screen bg-[#F8FCF9] py-8">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <a
                href="{{ route('freelancer.jobs.show', $job) }}"
                class="inline-flex items-center gap-2 text-sm text-[#667D73] hover:text-[#1E9E5A]"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke Job
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1fr_360px]">

            <div class="rounded-2xl border border-[#E3EEE8] bg-white p-6">
                <div class="mb-6">
                    <p class="text-sm font-medium text-[#1E9E5A]">
                        Quotation
                    </p>

                    <h1 class="mt-1 text-2xl font-semibold text-[#123128]">
                        Kirim Penawaran
                    </h1>

                    <p class="mt-2 text-sm text-[#667D73]">
                        Buat quotation berdasarkan kebutuhan client.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route(
                        'freelancer.jobs.proposals.offer.store',
                        [$job, $proposal]
                    ) }}"
                    class="space-y-5"
                >
                    @csrf

                    <div>
                        <label
                            for="title"
                            class="mb-2 block text-sm font-medium text-[#123128]"
                        >
                            Judul quotation
                        </label>

                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old(
                                'title',
                                'Penawaran untuk ' . $job->title
                            ) }}"
                            required
                            class="w-full rounded-xl border border-[#DCE9E2] px-4 py-3 text-sm outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                        >

                        @error('title')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="description"
                            class="mb-2 block text-sm font-medium text-[#123128]"
                        >
                            Detail pekerjaan
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            class="w-full rounded-xl border border-[#DCE9E2] px-4 py-3 text-sm outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                            placeholder="Jelaskan pekerjaan, output, dan ketentuan yang akan diberikan."
                        >{{ old(
                            'description',
                            $proposal->message
                        ) }}</textarea>

                        @error('description')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">

                        <div>
                            <label
                                for="price"
                                class="mb-2 block text-sm font-medium text-[#123128]"
                            >
                                Harga
                            </label>

                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-[#71837B]">
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
                                    class="w-full rounded-xl border border-[#DCE9E2] py-3 pl-12 pr-4 text-sm outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                                >
                            </div>

                            @error('price')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                            <p class="mt-1 text-xs text-[#71837B]">
                                Harga hanya dapat dilihat client.
                            </p>
                        </div>

                        <div>
                            <label
                                for="delivery_days"
                                class="mb-2 block text-sm font-medium text-[#123128]"
                            >
                                Estimasi pengerjaan
                            </label>

                            <div class="relative">
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
                                    class="w-full rounded-xl border border-[#DCE9E2] px-4 py-3 pr-20 text-sm outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                                >

                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-[#71837B]">
                                    hari
                                </span>
                            </div>

                            @error('delivery_days')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    <div>
                        <label
                            for="revision_count"
                            class="mb-2 block text-sm font-medium text-[#123128]"
                        >
                            Jumlah revisi
                        </label>

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
                            class="w-full rounded-xl border border-[#DCE9E2] px-4 py-3 text-sm outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                        >

                        @error('revision_count')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="expires_at"
                            class="mb-2 block text-sm font-medium text-[#123128]"
                        >
                            Berlaku sampai
                        </label>

                        <input
                            id="expires_at"
                            name="expires_at"
                            type="datetime-local"
                            value="{{ old('expires_at') }}"
                            class="w-full rounded-xl border border-[#DCE9E2] px-4 py-3 text-sm outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                        >

                        @error('expires_at')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="rounded-xl bg-[#EAF7EF] p-4">
                        <div class="flex gap-3">
                            <i class="bi bi-info-circle-fill mt-0.5 text-[#1E9E5A]"></i>

                            <div>
                                <p class="text-sm font-medium text-[#123128]">
                                    Setelah client menerima quotation
                                </p>

                                <p class="mt-1 text-xs leading-5 text-[#667D73]">
                                    Sistem akan membuat Order JASAIN secara otomatis
                                    dan client dapat melanjutkan ke checkout.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route(
                                'freelancer.jobs.show',
                                $job
                            ) }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#DCE9E2] px-5 py-3 text-sm font-medium text-[#123128] transition hover:bg-[#F8FCF9]"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#0F6B3A]"
                        >
                            <i class="bi bi-send"></i>
                            Kirim Quotation
                        </button>

                    </div>
                </form>
            </div>

            <aside class="h-fit rounded-2xl border border-[#E3EEE8] bg-white p-5">

                <p class="text-xs font-medium uppercase tracking-wide text-[#71837B]">
                    Job
                </p>

                <h2 class="mt-2 text-lg font-semibold text-[#123128]">
                    {{ $job->title }}
                </h2>

                <div class="mt-4 space-y-3 text-sm">

                    <div class="flex items-center justify-between gap-4">
                        <span class="text-[#71837B]">
                            Budget
                        </span>

                        <span class="font-medium text-[#123128]">
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

                    <div class="flex items-center justify-between gap-4">
                        <span class="text-[#71837B]">
                            Durasi job
                        </span>

                        <span class="font-medium text-[#123128]">
                            {{ $job->delivery_days }} hari
                        </span>
                    </div>

                    <div class="border-t border-[#EEF4F0] pt-3">
                        <p class="text-xs font-medium text-[#71837B]">
                            Kenapa freelancer tertarik
                        </p>

                        <p class="mt-1 text-sm leading-6 text-[#123128]">
                            {{ $proposal->message }}
                        </p>
                    </div>

                </div>

            </aside>

        </div>
    </div>
</div>
</x-layouts.freelancer>