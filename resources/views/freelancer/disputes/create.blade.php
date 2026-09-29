<x-layouts.freelancer title="Ajukan Dispute">

    @php
        $clientName = $order->client?->name ?? 'Client';

        $clientInitial = strtoupper(
            substr($clientName, 0, 1)
        );

        $categoryLabels = [
            'delivery_issue' => 'Masalah Pengiriman',
            'quality_issue' => 'Masalah Kualitas',
            'scope_issue' => 'Masalah Ruang Lingkup',
            'communication_issue' => 'Masalah Komunikasi',
            'non_delivery' => 'Pekerjaan Belum Diterima',
            'payment_issue' => 'Masalah Pembayaran',
            'other' => 'Masalah Lainnya',
        ];
    @endphp

    <div class="mx-auto w-full max-w-4xl px-4 py-5 sm:px-6 lg:px-8">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="mb-6">

            <a
                href="{{ route('freelancer.orders.index') }}"
                class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m15 18-6-6 6-6"/>
                </svg>

                Kembali ke Pesanan
            </a>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>
                        Penyelesaian Sengketa
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Ajukan Dispute
                    </h1>

                    <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
                        Jelaskan kendala yang terjadi pada pesanan ini agar ProKerja dapat membantu
                        proses penyelesaiannya.
                    </p>
                </div>

            </div>
        </div>


        {{-- =========================================================
            EXISTING DISPUTE NOTICE
        ========================================================== --}}
        @if ($existingDispute)

            <div class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 p-4">

                <div class="flex gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 8v4"/>
                            <path d="M12 16h.01"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-blue-900">
                            Pernah ada dispute pada pesanan ini
                        </p>

                        <p class="mt-1 text-sm leading-6 text-blue-800">
                            Pastikan alasan dispute yang diajukan berkaitan dengan kendala
                            pesanan saat ini.
                        </p>
                    </div>

                </div>

            </div>

        @endif


        {{-- =========================================================
            ORDER SUMMARY
        ========================================================== --}}
        <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Order Header --}}
            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">

                <div class="flex items-center justify-between gap-4">

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Pesanan
                        </p>

                        <p class="mt-1 text-sm font-bold text-slate-900">
                            {{ $order->order_number }}
                        </p>
                    </div>

                    <span class="inline-flex shrink-0 items-center rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold capitalize text-blue-700">
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>

                </div>

            </div>


            {{-- Order Content --}}
            <div class="px-5 py-5 sm:px-6">

                {{-- Client --}}
                <div class="flex items-start gap-4">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                        {{ $clientInitial }}
                    </div>

                    <div class="min-w-0 flex-1">

                        <p class="text-xs font-medium text-slate-400">
                            Client
                        </p>

                        <p class="mt-0.5 truncate text-sm font-semibold text-slate-900">
                            {{ $clientName }}
                        </p>

                        @if ($order->client?->email)

                            <p class="mt-0.5 truncate text-xs text-slate-500">
                                {{ $order->client->email }}
                            </p>

                        @endif

                    </div>

                </div>


                {{-- Services --}}
                @if ($order->items->count())

                    <div class="mt-5 border-t border-slate-100 pt-5">

                        <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Layanan
                        </p>

                        <div class="space-y-3">

                            @foreach ($order->items as $item)

                                <div class="flex items-start justify-between gap-4">

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-medium text-slate-800">
                                            {{ $item->service?->title ?? 'Layanan' }}
                                        </p>

                                        @if (($item->quantity ?? 1) > 1)

                                            <p class="mt-0.5 text-xs text-slate-400">
                                                {{ $item->quantity }} item
                                            </p>

                                        @endif

                                    </div>

                                    @if (isset($item->subtotal))

                                        <p class="shrink-0 text-sm font-semibold text-slate-900">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </p>

                                    @endif

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- Total --}}
                <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">

                    <span class="text-sm text-slate-500">
                        Total pesanan
                    </span>

                    <span class="text-base font-bold text-slate-900">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </span>

                </div>

            </div>

        </div>


        {{-- =========================================================
            MAIN FORM
        ========================================================== --}}
        <form
            action="{{ route('freelancer.orders.dispute.store', $order) }}"
            method="POST"
            class="space-y-5"
        >

            @csrf


            {{-- =====================================================
                CATEGORY
            ====================================================== --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                <div class="mb-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M12 9v4"/>
                                <path d="M12 17h.01"/>
                                <path d="M10.3 3.7 2.5 17a2 2 0 0 0 1.7 3h15.6a2 2 0 0 0 1.7-3L13.7 3.7a2 2 0 0 0-3.4 0Z"/>
                            </svg>

                        </div>

                        <div>

                            <h2 class="text-base font-bold text-slate-900">
                                Apa kendala yang terjadi?
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Pilih kategori yang paling sesuai dengan masalah pesanan.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Category Options --}}
                <div class="grid gap-3 sm:grid-cols-2">

                    @foreach ($categoryLabels as $value => $label)

                        <label class="group cursor-pointer">

                            <input
                                type="radio"
                                name="category"
                                value="{{ $value }}"
                                class="peer sr-only"
                                {{ old('category') === $value ? 'checked' : '' }}
                            >

                            <div
                                class="rounded-xl border border-slate-200 bg-white p-4 transition
                                hover:border-blue-300 hover:bg-slate-50
                                peer-checked:border-blue-500
                                peer-checked:bg-blue-50
                                peer-focus-visible:ring-2
                                peer-focus-visible:ring-blue-500
                                peer-focus-visible:ring-offset-2"
                            >

                                <div class="flex items-center gap-3">

                                    <div class="flex h-4 w-4 shrink-0 items-center justify-center rounded-full border-2 border-slate-300 peer-checked:border-blue-500">

                                        <div class="hidden h-2 w-2 rounded-full bg-blue-600 peer-checked:block"></div>

                                    </div>

                                    <span class="text-sm font-medium text-slate-700">
                                        {{ $label }}
                                    </span>

                                </div>

                            </div>

                        </label>

                    @endforeach

                </div>


                @error('category')

                    <p class="mt-3 text-sm font-medium text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- =====================================================
                REASON
            ====================================================== --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                <div class="mb-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M21 15a4 4 0 0 1-4 4H7l-4 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z"/>
                            </svg>

                        </div>

                        <div>

                            <h2 class="text-base font-bold text-slate-900">
                                Jelaskan masalahnya
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Ceritakan kondisi yang terjadi secara jelas dan berdasarkan fakta.
                            </p>

                        </div>

                    </div>

                </div>


                <div>

                    <label
                        for="reason"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Alasan dispute
                    </label>

                    <textarea
                        id="reason"
                        name="reason"
                        rows="7"
                        maxlength="5000"
                        required
                        placeholder="Jelaskan kendala pekerjaan, komunikasi yang sudah dilakukan, bagian pekerjaan yang bermasalah, dan penyelesaian yang sudah dicoba..."
                        class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >{{ old('reason') }}</textarea>


                    <div class="mt-2 flex items-start justify-between gap-4">

                        <p class="text-xs leading-5 text-slate-400">
                            Minimal 20 karakter. Jelaskan informasi yang relevan agar proses pemeriksaan lebih mudah.
                        </p>

                        <span class="shrink-0 text-xs text-slate-400">
                            Maks. 5000
                        </span>

                    </div>


                    @error('reason')

                        <p class="mt-2 text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>


            {{-- =====================================================
                INFORMATION
            ====================================================== --}}
            <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5 sm:p-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 16v-4"/>
                            <path d="M12 8h.01"/>
                        </svg>

                    </div>


                    <div>

                        <h3 class="text-sm font-bold text-slate-900">
                            Sebelum mengajukan dispute
                        </h3>

                        <ul class="mt-2 space-y-1.5 text-sm leading-6 text-slate-600">

                            <li class="flex gap-2">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-500"></span>
                                <span>
                                    Pastikan masalah berkaitan langsung dengan pesanan ini.
                                </span>
                            </li>

                            <li class="flex gap-2">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-500"></span>
                                <span>
                                    Gunakan penjelasan yang jelas dan objektif.
                                </span>
                            </li>

                            <li class="flex gap-2">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-500"></span>
                                <span>
                                    Client akan menerima notifikasi setelah dispute diajukan.
                                </span>
                            </li>

                            <li class="flex gap-2">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-500"></span>
                                <span>
                                    Admin ProKerja dapat meninjau proses penyelesaian dispute.
                                </span>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                ACTIONS
            ====================================================== --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">

                <a
                    href="{{ route('freelancer.orders.index') }}"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M22 2 11 13"/>
                        <path d="m22 2-7 20-4-9-9-4Z"/>
                    </svg>

                    Ajukan Dispute

                </button>

            </div>

        </form>

    </div>

</x-layouts.freelancer>