<x-layouts.marketplace title="Ajukan Dispute - ProKerja">

    <div class="min-h-screen bg-[#F8FAFC]">
        <div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">

            {{-- Back --}}
            <div class="mb-5 sm:mb-6">
                <a
                    href="{{ route('client.orders.show', $order) }}"
                    class="group inline-flex items-center gap-2 text-xs font-semibold text-slate-500 transition hover:text-[#2563EB]"
                >
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white transition group-hover:border-blue-100 group-hover:bg-blue-50">
                        <i class="bi bi-arrow-left text-[11px]"></i>
                    </span>

                    Kembali ke order
                </a>
            </div>

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="mb-5 overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-sm sm:mb-6">
                    <div class="flex items-start gap-3 px-4 py-4 sm:px-5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-500">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-rose-600">
                                Periksa kembali data yang kamu isi.
                            </p>

                            <div class="mt-1.5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <p class="text-xs leading-5 text-rose-500">
                                        {{ $error }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Main Card --}}
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                {{-- Header --}}
                <div class="border-b border-blue-100 bg-gradient-to-br from-blue-50 via-white to-blue-50/70 px-5 py-6 sm:px-7 sm:py-7">
                    <div class="flex items-start gap-4">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-[#2563EB] shadow-sm ring-1 ring-blue-100 sm:h-12 sm:w-12">
                            <i class="bi bi-shield-exclamation text-lg"></i>
                        </div>

                        <div class="min-w-0">
                            <div class="inline-flex items-center rounded-full border border-blue-100 bg-white/80 px-2.5 py-1 text-[9px] font-bold uppercase tracking-[0.16em] text-[#2563EB]">
                                Dispute
                            </div>

                            <h1 class="mt-2 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                                Ajukan sengketa
                            </h1>

                            <p class="mt-2 max-w-2xl text-xs leading-5 text-slate-500 sm:text-sm sm:leading-6">
                                Jelaskan masalah yang terjadi pada order ini secara jelas agar
                                freelancer dan admin dapat memahami situasinya.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Content --}}
                <div class="px-5 py-6 sm:px-7 sm:py-8">

                    {{-- Order Summary --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-4 sm:p-5">
                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm ring-1 ring-slate-200">
                                <i class="bi bi-receipt"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between sm:gap-3">
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-medium uppercase tracking-wide text-slate-400">
                                            Order
                                        </p>

                                        <p class="mt-1 truncate text-sm font-bold text-slate-800">
                                            {{ $order->order_number }}
                                        </p>
                                    </div>

                                    <span class="hidden shrink-0 rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-semibold text-blue-600 sm:inline-flex">
                                        Ajukan Dispute
                                    </span>
                                </div>

                                <p class="mt-1 truncate text-xs text-slate-500">
                                    {{ $order->items->first()?->service_title ?? 'Pesanan Jasa' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- Form --}}
                    <form
                        action="{{ route('client.orders.dispute.store', $order) }}"
                        method="POST"
                        class="mt-6 sm:mt-7"
                    >
                        @csrf

                        {{-- Category --}}
                        <div>
                            <label
                                for="category"
                                class="text-xs font-bold text-slate-700 sm:text-sm"
                            >
                                Jenis masalah
                            </label>

                            <p class="mt-1 text-[11px] leading-5 text-slate-400 sm:text-xs">
                                Pilih kategori yang paling sesuai dengan kendala pada order ini.
                            </p>

                            <div class="relative mt-2">
                                <select
                                    id="category"
                                    name="category"
                                    required
                                    class="h-11 w-full appearance-none rounded-xl border border-slate-200 bg-white px-4 pr-10 text-xs text-slate-800 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-50 sm:h-12 sm:text-sm"
                                >
                                    <option value="">
                                        Pilih jenis masalah
                                    </option>

                                    <option
                                        value="delivery_issue"
                                        @selected(old('category') === 'delivery_issue')
                                    >
                                        Masalah delivery
                                    </option>

                                    <option
                                        value="quality_issue"
                                        @selected(old('category') === 'quality_issue')
                                    >
                                        Kualitas hasil pekerjaan
                                    </option>

                                    <option
                                        value="scope_issue"
                                        @selected(old('category') === 'scope_issue')
                                    >
                                        Masalah scope pekerjaan
                                    </option>

                                    <option
                                        value="communication_issue"
                                        @selected(old('category') === 'communication_issue')
                                    >
                                        Masalah komunikasi
                                    </option>

                                    <option
                                        value="non_delivery"
                                        @selected(old('category') === 'non_delivery')
                                    >
                                        Pekerjaan belum dikirim
                                    </option>

                                    <option
                                        value="payment_issue"
                                        @selected(old('category') === 'payment_issue')
                                    >
                                        Masalah pembayaran
                                    </option>

                                    <option
                                        value="other"
                                        @selected(old('category') === 'other')
                                    >
                                        Masalah lainnya
                                    </option>
                                </select>

                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                    <i class="bi bi-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Reason --}}
                        <div class="mt-6 sm:mt-7">
                            <div class="flex items-end justify-between gap-3">
                                <div>
                                    <label
                                        for="reason"
                                        class="text-xs font-bold text-slate-700 sm:text-sm"
                                    >
                                        Jelaskan masalah
                                    </label>

                                    <p class="mt-1 text-[11px] leading-5 text-slate-400 sm:text-xs">
                                        Berikan informasi yang jelas agar kasus dapat ditinjau dengan tepat.
                                    </p>
                                </div>
                            </div>

                            <textarea
                                id="reason"
                                name="reason"
                                rows="8"
                                required
                                maxlength="5000"
                                placeholder="Jelaskan masalah secara detail, termasuk apa yang terjadi, bagian yang tidak sesuai, dan penyelesaian yang kamu harapkan..."
                                class="mt-3 w-full resize-y rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm leading-6 text-slate-800 outline-none placeholder:text-slate-400 transition focus:border-blue-400 focus:ring-4 focus:ring-blue-50"
                            >{{ old('reason') }}</textarea>

                            <div class="mt-1.5 flex justify-end">
                                <p class="text-[10px] text-slate-400 sm:text-xs">
                                    Maksimal 5000 karakter
                                </p>
                            </div>
                        </div>

                        {{-- Information --}}
                        <div class="mt-6 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-4 sm:mt-7 sm:px-5">
                            <div class="flex items-start gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">
                                    <i class="bi bi-info-circle text-sm"></i>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-slate-700">
                                        Bagaimana proses dispute?
                                    </p>

                                    <p class="mt-1 text-[11px] leading-5 text-slate-500 sm:text-xs sm:leading-5">
                                        Setelah dispute dikirim, freelancer akan mendapat kesempatan
                                        memberikan tanggapan sebelum kasus masuk ke tahap peninjauan admin.
                                    </p>
                                </div>

                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-6 flex flex-col-reverse gap-3 sm:mt-7 sm:flex-row sm:justify-end">

                            <a
                                href="{{ route('client.orders.show', $order) }}"
                                class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 sm:h-12"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md sm:h-12"
                            >
                                <i class="bi bi-shield-exclamation"></i>
                                Ajukan Dispute
                            </button>

                        </div>

                    </form>

                </div>
            </section>

            {{-- Bottom Note --}}
            <div class="mt-5 flex items-start gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm sm:mt-6 sm:px-5">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                    <i class="bi bi-lightbulb text-sm"></i>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-700">
                        Tips
                    </p>

                    <p class="mt-1 text-[11px] leading-5 text-slate-500 sm:text-xs">
                        Jelaskan kronologi secara singkat, sertakan bagian pekerjaan yang
                        bermasalah, dan tuliskan penyelesaian yang kamu harapkan.
                    </p>
                </div>

            </div>

        </div>
    </div>

</x-layouts.marketplace>