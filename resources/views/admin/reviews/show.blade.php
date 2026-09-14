<x-layouts.admin title="Detail Review">

    @php
        $statusMap = [
            'published' => [
                'label' => 'Tampil',
                'class' => 'bg-[#DCFCE7] text-[#166534] border-[#B8E6C8] dark:bg-[#244732] dark:text-[#A0E8B7] dark:border-[#315C43]',
                'icon' => 'bi-eye-fill',
            ],
            'hidden' => [
                'label' => 'Disembunyikan',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] border-[#F2C5C5] dark:bg-[#492727] dark:text-[#F0A3A3] dark:border-[#6A3B3B]',
                'icon' => 'bi-eye-slash-fill',
            ],
        ];

        $reviewStatus = $statusMap[$review->status] ?? [
            'label' => ucfirst($review->status ?? 'Unknown'),
            'class' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600',
            'icon' => 'bi-question-circle',
        ];

        $client = $review->client;
        $freelancer = $review->freelancerProfile;
        $freelancerUser = $freelancer?->user;
        $order = $review->order;
    @endphp


    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <a
                    href="{{ route('admin.reviews.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#1E9E5A] dark:text-[#93A89F] dark:hover:text-[#7AD8B5]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke review
                </a>

                <div class="mt-4">

                    <div class="flex flex-wrap items-center gap-2">

                        <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                            Detail Review
                        </p>

                        <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $reviewStatus['class'] }}">
                            <i class="bi {{ $reviewStatus['icon'] }}"></i>
                            {{ $reviewStatus['label'] }}
                        </span>

                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                        Review #{{ $review->id }}
                    </h1>

                    <p class="mt-1 text-sm text-[#667D73] dark:text-[#A9BCB2]">
                        Review client terhadap pengalaman menggunakan jasa freelancer.
                    </p>

                </div>

            </div>


            {{-- Rating --}}
            <div class="rounded-xl border border-[#D6E4DD] bg-white px-5 py-4 dark:border-[#2E473A] dark:bg-[#13221A]">

                <p class="text-[11px] font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                    Rating
                </p>

                <div class="mt-1 flex items-center gap-2">

                    <span class="text-2xl font-semibold text-[#123128] dark:text-white">
                        {{ $review->rating }}
                    </span>

                    <div class="flex items-center gap-0.5">

                        @for ($star = 1; $star <= 5; $star++)

                            <i class="bi bi-star-fill {{ $star <= $review->rating ? 'text-[#F0B429]' : 'text-[#D5DED9] dark:text-[#46594F]' }}"></i>

                        @endfor

                    </div>

                </div>

            </div>

        </div>


        {{-- Success --}}
        @if (session('success'))

            <div class="rounded-2xl border border-[#BFE7CE] bg-[#F0FBF4] px-4 py-3 dark:border-[#315C43] dark:bg-[#14271C]">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#DCFCE7] text-[#15803D] dark:bg-[#234632] dark:text-[#8FE2AB]">
                        <i class="bi bi-check-lg"></i>
                    </div>

                    <div>

                        <p class="text-sm font-semibold text-[#166534] dark:text-[#9BE7B0]">
                            Berhasil
                        </p>

                        <p class="mt-0.5 text-sm text-[#47705A] dark:text-[#B0C5B9]">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            </div>

        @endif


        {{-- Validation --}}
        @if ($errors->any())

            <div class="rounded-2xl border border-[#F0C8C8] bg-[#FFF5F5] px-4 py-4 dark:border-[#6A3B3B] dark:bg-[#2A1919]">

                <div class="flex items-start gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#FDE8E8] text-[#C62828] dark:bg-[#4A2525] dark:text-[#F39A9A]">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>

                    <div>

                        <p class="text-sm font-semibold text-[#991B1B] dark:text-[#FFAAAA]">
                            Ada data yang perlu diperiksa
                        </p>

                        <ul class="mt-2 space-y-1 text-sm text-[#7F4B4B] dark:text-[#D0A7A7]">

                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- Main --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">


            {{-- Left --}}
            <div class="space-y-6">

                {{-- Review Content --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-chat-square-quote-fill"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Isi Review
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Ulasan yang diberikan client
                            </p>

                        </div>

                    </div>


                    <div class="mt-6 rounded-2xl border border-[#D6E4DD] bg-[#F8FCF9] p-6 dark:border-[#3A5245] dark:bg-[#17271F]">

                        <div class="flex items-center gap-1.5">

                            @for ($star = 1; $star <= 5; $star++)

                                <i class="bi bi-star-fill text-lg {{ $star <= $review->rating ? 'text-[#F0B429]' : 'text-[#D5DED9] dark:text-[#46594F]' }}"></i>

                            @endfor

                        </div>


                        @if ($review->comment)

                            <p class="mt-5 whitespace-pre-line text-base leading-8 text-[#355247] dark:text-[#D0DED8]">
                                "{{ $review->comment }}"
                            </p>

                        @else

                            <p class="mt-5 text-sm italic text-[#8A9B94] dark:text-[#80958A]">
                                Client tidak memberikan komentar tambahan.
                            </p>

                        @endif

                    </div>

                </div>


                {{-- Client --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-person"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Client
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Pemberi review
                            </p>

                        </div>

                    </div>


                    <div class="mt-5 flex items-center gap-4">

                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-lg font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            {{ strtoupper(substr($client?->name ?? 'C', 0, 1)) }}
                        </div>

                        <div class="min-w-0">

                            <p class="truncate text-sm font-semibold text-[#123128] dark:text-white">
                                {{ $client?->name ?? 'Client tidak tersedia' }}
                            </p>

                            @if ($client?->email)

                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    {{ $client->email }}
                                </p>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- Freelancer --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-person-badge"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Freelancer
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Penerima review
                            </p>

                        </div>

                    </div>


                    <div class="mt-5 flex items-center gap-4">

                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full border border-[#D6E4DD] bg-[#EAF7EF] dark:border-[#2E473A] dark:bg-[#234632]">

                            @if ($freelancer?->avatar)

                                <img
                                    src="{{ asset('storage/' . $freelancer->avatar) }}"
                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                    class="h-full w-full object-cover"
                                >

                            @elseif ($freelancerUser)

                                <div class="flex h-full w-full items-center justify-center text-lg font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                    {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                </div>

                            @else

                                <div class="flex h-full w-full items-center justify-center">
                                    <i class="bi bi-person text-xl text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                                </div>

                            @endif

                        </div>


                        <div class="min-w-0">

                            <p class="truncate text-sm font-semibold text-[#123128] dark:text-white">
                                {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                            </p>

                            @if ($freelancer?->username)

                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    {{ '@' . $freelancer->username }}
                                </p>

                            @endif

                            @if ($freelancer?->headline)

                                <p class="mt-1 truncate text-sm text-[#536B60] dark:text-[#B7C7C0]">
                                    {{ $freelancer->headline }}
                                </p>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- Related Order --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="border-b border-[#D6E4DD] px-6 py-4 dark:border-[#2E473A]">

                        <div class="flex items-center justify-between gap-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    <i class="bi bi-receipt-cutoff"></i>
                                </div>

                                <div>

                                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                        Pesanan Terkait
                                    </h2>

                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Transaksi sumber review
                                    </p>

                                </div>

                            </div>


                            @if ($order)

                                <a
                                    href="{{ route('admin.orders.show', $order) }}"
                                    class="inline-flex items-center gap-2 rounded-xl border border-[#BFCFC7] bg-white px-3.5 py-2.5 text-sm font-medium text-[#486258] transition hover:border-[#AFC2B8] hover:bg-[#F6FAF8] hover:text-[#1E9E5A] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#AFC0B8] dark:hover:border-[#4C695B] dark:hover:bg-[#1D3327] dark:hover:text-[#7AD8B5]"
                                >
                                    Detail Order
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>

                            @endif

                        </div>

                    </div>


                    @if ($order)

                        <div class="p-6">

                            <div class="grid gap-5 sm:grid-cols-2">

                                <div>

                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Nomor Order
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                        #{{ $order->order_number }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        Status Order
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                        {{ ucfirst(str_replace('_', ' ', $order->status ?? '-')) }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @else

                        <div class="p-6">

                            <p class="text-sm text-[#71837B] dark:text-[#8FA59A]">
                                Order terkait tidak ditemukan.
                            </p>

                        </div>

                    @endif

                </div>


                {{-- Admin Note --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-sticky-fill"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Catatan Admin
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Catatan internal moderasi
                            </p>

                        </div>

                    </div>


                    <div class="mt-5 rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#3A5245] dark:bg-[#17271F]">

                        @if ($review->admin_note)

                            <p class="whitespace-pre-line text-sm leading-6 text-[#536B60] dark:text-[#B7C7C0]">
                                {{ $review->admin_note }}
                            </p>

                        @else

                            <p class="text-sm text-[#71837B] dark:text-[#8FA59A]">
                                Belum ada catatan admin.
                            </p>

                        @endif

                    </div>

                </div>

            </div>


            {{-- Right --}}
            <div class="space-y-6">


                {{-- Moderation --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Moderasi Review
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Atur visibilitas review
                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route('admin.reviews.update', $review) }}"
                        method="POST"
                        class="mt-6 space-y-5"
                    >

                        @csrf
                        @method('PATCH')


                        {{-- Status --}}
                        <div>

                            <label
                                for="status"
                                class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                            >
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                            >

                                <option value="published" @selected(old('status', $review->status) === 'published')>
                                    Tampil
                                </option>

                                <option value="hidden" @selected(old('status', $review->status) === 'hidden')>
                                    Disembunyikan
                                </option>

                            </select>

                        </div>


                        {{-- Admin Note --}}
                        <div>

                            <label
                                for="admin_note"
                                class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                            >
                                Catatan Admin
                            </label>

                            <textarea
                                id="admin_note"
                                name="admin_note"
                                rows="5"
                                placeholder="Tulis catatan internal moderasi..."
                                class="w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition placeholder:text-[#95A79F] hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:placeholder:text-[#789086] dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                            >{{ old('admin_note', $review->admin_note) }}</textarea>

                        </div>


                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#17844A] focus:outline-none focus:ring-4 focus:ring-[#D8F3E2] dark:focus:ring-[#28533B]"
                        >
                            <i class="bi bi-check2-circle"></i>
                            Simpan Moderasi
                        </button>

                    </form>

                </div>


                {{-- Current Status --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Status Saat Ini
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Kondisi review
                            </p>

                        </div>

                    </div>


                    <div class="mt-5 rounded-xl border px-4 py-4 {{ $reviewStatus['class'] }}">

                        <div class="flex items-start gap-3">

                            <i class="bi {{ $reviewStatus['icon'] }} mt-0.5"></i>

                            <div>

                                <p class="text-sm font-semibold">
                                    {{ $reviewStatus['label'] }}
                                </p>

                                <p class="mt-1 text-xs leading-5 opacity-90">

                                    @if ($review->status === 'published')
                                        Review dapat ditampilkan kepada pengguna marketplace.
                                    @else
                                        Review tidak ditampilkan kepada pengguna marketplace.
                                    @endif

                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Date --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-[#F8FCF9] p-6 dark:border-[#2E473A] dark:bg-[#17271F]">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm dark:bg-[#1D3025] dark:text-[#7AD8B5]">
                            <i class="bi bi-calendar3"></i>
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                Informasi Waktu
                            </p>

                            <div class="mt-3 space-y-2 text-xs text-[#71837B] dark:text-[#8FA59A]">

                                <p>
                                    Dibuat:
                                    <span class="font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                        {{ $review->created_at?->format('d M Y, H:i') ?? '-' }}
                                    </span>
                                </p>

                                <p>
                                    Ditampilkan:
                                    <span class="font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                        {{ $review->published_at?->format('d M Y, H:i') ?? '-' }}
                                    </span>
                                </p>

                                <p>
                                    Diperbarui:
                                    <span class="font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                        {{ $review->updated_at?->format('d M Y, H:i') ?? '-' }}
                                    </span>
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- System Note --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-[#F8FCF9] p-6 dark:border-[#2E473A] dark:bg-[#17271F]">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm dark:bg-[#1D3025] dark:text-[#7AD8B5]">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                Catatan Moderasi
                            </p>

                            <p class="mt-1 text-sm leading-6 text-[#667D73] dark:text-[#A9BCB2]">
                                Menyembunyikan review hanya mengubah visibilitasnya. Data review tetap tersimpan untuk kebutuhan administrasi dan audit.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-layouts.admin>