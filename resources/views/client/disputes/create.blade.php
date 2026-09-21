<x-layouts.client title="Ajukan Dispute">

    <div class="min-h-screen bg-[#F8FCF9]">

        <div class="mx-auto max-w-4xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">

            <div class="mb-5">
                <a
                    href="{{ route('client.orders.show', $order) }}"
                    class="inline-flex items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke order
                </a>
            </div>

            @if($errors->any())
                <div class="mb-5 rounded-2xl border border-red-100 bg-white px-5 py-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-500">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-red-600">
                                Periksa kembali data yang kamu isi.
                            </p>

                            <div class="mt-1 space-y-1">
                                @foreach($errors->all() as $error)
                                    <p class="text-xs text-red-500">
                                        {{ $error }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <section class="overflow-hidden rounded-3xl border border-[#DCE9E1] bg-white shadow-[0_8px_28px_rgba(18,49,40,0.045)]">

                <div class="border-b border-[#E9F0EC] bg-[#EAF7EF] px-5 py-6 sm:px-7">

                    <div class="flex items-start gap-4">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">
                            <i class="bi bi-shield-exclamation text-lg"></i>
                        </div>

                        <div>
                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                Dispute
                            </p>

                            <h1 class="mt-1 text-xl font-semibold tracking-[-0.03em] text-[#123128]">
                                Ajukan sengketa
                            </h1>

                            <p class="mt-2 max-w-2xl text-xs leading-5 text-[#63786E]">
                                Jelaskan masalah yang terjadi pada order ini secara jelas agar
                                freelancer dan admin dapat memahami situasinya.
                            </p>
                        </div>

                    </div>

                </div>

                <div class="px-5 py-6 sm:px-7">

                    <div class="rounded-2xl border border-[#E3ECE7] bg-[#F8FBF9] px-4 py-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#1E9E5A] shadow-sm">
                                <i class="bi bi-receipt"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-[10px] text-[#8A9992]">
                                    Order
                                </p>

                                <p class="mt-1 truncate text-xs font-semibold text-[#18382E]">
                                    {{ $order->order_number }}
                                </p>

                                <p class="mt-1 truncate text-[10px] text-[#7C8B84]">
                                    {{ $order->items->first()?->service_title ?? 'Pesanan Jasa' }}
                                </p>
                            </div>

                        </div>

                    </div>

                    <form
                        action="{{ route('client.orders.dispute.store', $order) }}"
                        method="POST"
                        class="mt-6"
                    >
                        @csrf

                        <div>
                            <label
                                for="category"
                                class="text-xs font-semibold text-[#355248]"
                            >
                                Jenis masalah
                            </label>

                            <select
                                id="category"
                                name="category"
                                required
                                class="mt-2 h-11 w-full rounded-xl border border-[#DCE7E1] bg-[#FAFCFB] px-4 text-xs text-[#123128] outline-none transition focus:border-[#9ACCB0] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
                            >
                                <option value="">
                                    Pilih jenis masalah
                                </option>

                                <option value="delivery_issue" @selected(old('category') === 'delivery_issue')>
                                    Masalah delivery
                                </option>

                                <option value="quality_issue" @selected(old('category') === 'quality_issue')>
                                    Kualitas hasil pekerjaan
                                </option>

                                <option value="scope_issue" @selected(old('category') === 'scope_issue')>
                                    Masalah scope pekerjaan
                                </option>

                                <option value="communication_issue" @selected(old('category') === 'communication_issue')>
                                    Masalah komunikasi
                                </option>

                                <option value="non_delivery" @selected(old('category') === 'non_delivery')>
                                    Pekerjaan belum dikirim
                                </option>

                                <option value="payment_issue" @selected(old('category') === 'payment_issue')>
                                    Masalah pembayaran
                                </option>

                                <option value="other" @selected(old('category') === 'other')>
                                    Masalah lainnya
                                </option>
                            </select>
                        </div>

                        <div class="mt-5">

                            <label
                                for="reason"
                                class="text-xs font-semibold text-[#355248]"
                            >
                                Jelaskan masalah
                            </label>

                            <textarea
                                id="reason"
                                name="reason"
                                rows="8"
                                required
                                maxlength="5000"
                                placeholder="Jelaskan masalah secara detail, termasuk apa yang terjadi, bagian yang tidak sesuai, dan penyelesaian yang kamu harapkan..."
                                class="mt-2 w-full rounded-xl border border-[#DCE7E1] bg-[#FAFCFB] px-4 py-3 text-sm leading-6 text-[#123128] outline-none placeholder:text-[#A0ADA7] transition focus:border-[#9ACCB0] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
                            >{{ old('reason') }}</textarea>

                            <p class="mt-1.5 text-right text-[10px] text-[#A0ADA7]">
                                Maksimal 5000 karakter
                            </p>

                        </div>

                        <div class="mt-5 rounded-2xl border border-[#DCE9E1] bg-[#F5FBF7] px-4 py-4">

                            <div class="flex items-start gap-3">

                                <i class="bi bi-info-circle mt-0.5 text-sm text-[#1E9E5A]"></i>

                                <p class="text-[10px] leading-5 text-[#667D73]">
                                    Setelah dispute dikirim, freelancer akan mendapat kesempatan
                                    memberikan tanggapan sebelum kasus masuk ke tahap peninjauan admin.
                                </p>

                            </div>

                        </div>

                        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                            <a
                                href="{{ route('client.orders.show', $order) }}"
                                class="inline-flex h-11 items-center justify-center rounded-xl border border-[#DCE7E1] bg-white px-5 text-xs font-semibold text-[#52685F] transition hover:bg-[#F6FAF7]"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 text-xs font-semibold text-white shadow-sm transition hover:bg-[#0F6B3A]"
                            >
                                <i class="bi bi-shield-exclamation"></i>
                                Ajukan Dispute
                            </button>

                        </div>

                    </form>

                </div>

            </section>

        </div>

    </div>

</x-layouts.client>