<x-layouts.admin title="Kelola Review">

    @php
        $statusMap = [
            'published' => [
                'label' => 'Tampil',
                'class' => 'bg-[#DCFCE7] text-[#166534] dark:bg-[#244732] dark:text-[#A0E8B7]',
                'icon' => 'bi-eye-fill',
            ],
            'hidden' => [
                'label' => 'Disembunyikan',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] dark:bg-[#492727] dark:text-[#F0A3A3]',
                'icon' => 'bi-eye-slash-fill',
            ],
        ];
    @endphp

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>
                <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                    Marketplace
                </p>

                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                    Kelola Review
                </h1>

                <p class="mt-1 max-w-2xl text-sm text-[#667D73] dark:text-[#A9BCB2]">
                    Pantau dan moderasi ulasan client terhadap freelancer.
                </p>
            </div>

            <div class="rounded-xl border border-[#D6E4DD] bg-white px-4 py-3 dark:border-[#2E473A] dark:bg-[#13221A]">
                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                        <i class="bi bi-star-fill"></i>
                    </div>

                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                            Total Review
                        </p>

                        <p class="mt-0.5 text-sm font-semibold text-[#123128] dark:text-white">
                            {{ $reviews->total() }}
                        </p>
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


        {{-- Filter --}}
        <div class="rounded-2xl border border-[#D6E4DD] bg-white p-5 dark:border-[#2E473A] dark:bg-[#13221A]">

            <div class="mb-4 flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                        Filter Review
                    </h2>

                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                        Cari review berdasarkan client, freelancer, order, atau isi ulasan.
                    </p>
                </div>

            </div>


            <form
                action="{{ route('admin.reviews.index') }}"
                method="GET"
                class="grid gap-4 lg:grid-cols-[1fr_180px_180px_auto]"
            >

                {{-- Search --}}
                <div>

                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                    >
                        Cari review
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <i class="bi bi-search text-[#80948A] dark:text-[#80988C]"></i>
                        </div>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Client, freelancer, order, atau komentar..."
                            class="w-full rounded-xl border border-[#BFCFC7] bg-white py-3 pl-10 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#95A79F] hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:placeholder:text-[#789086] dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                        >

                    </div>

                </div>


                {{-- Rating --}}
                <div>

                    <label
                        for="rating"
                        class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                    >
                        Rating
                    </label>

                    <select
                        id="rating"
                        name="rating"
                        class="w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                    >
                        <option value="">
                            Semua rating
                        </option>

                        <option value="5" @selected($rating === '5')>
                            5 bintang
                        </option>

                        <option value="4" @selected($rating === '4')>
                            4 bintang
                        </option>

                        <option value="3" @selected($rating === '3')>
                            3 bintang
                        </option>

                        <option value="2" @selected($rating === '2')>
                            2 bintang
                        </option>

                        <option value="1" @selected($rating === '1')>
                            1 bintang
                        </option>
                    </select>

                </div>


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
                        class="w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                    >
                        <option value="">
                            Semua status
                        </option>

                        <option value="published" @selected($status === 'published')>
                            Tampil
                        </option>

                        <option value="hidden" @selected($status === 'hidden')>
                            Disembunyikan
                        </option>
                    </select>

                </div>


                {{-- Buttons --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#17844A] focus:outline-none focus:ring-4 focus:ring-[#D8F3E2] dark:focus:ring-[#28533B] lg:w-auto"
                    >
                        <i class="bi bi-search"></i>
                        Cari
                    </button>

                    @if ($search !== '' || $status || $rating)
                        <a
                            href="{{ route('admin.reviews.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm font-medium text-[#355247] transition hover:border-[#AFC2B8] hover:bg-[#F6FAF8] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#C4D2CC] dark:hover:border-[#4C695B] dark:hover:bg-[#1A3024]"
                        >
                            Reset
                        </a>
                    @endif

                </div>

            </form>

        </div>


        {{-- Review Table --}}
        <div class="overflow-hidden rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

            <div class="flex flex-col gap-2 border-b border-[#D6E4DD] px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-[#2E473A]">

                <div>
                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                        Daftar Review
                    </h2>

                    <p class="mt-0.5 text-xs text-[#71837B] dark:text-[#8FA59A]">
                        Menampilkan {{ $reviews->firstItem() ?? 0 }}–{{ $reviews->lastItem() ?? 0 }}
                        dari {{ $reviews->total() }} review
                    </p>
                </div>

                <div class="hidden items-center gap-2 text-xs text-[#71837B] sm:flex dark:text-[#8FA59A]">
                    <i class="bi bi-shield-check text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                    Moderasi konten
                </div>

            </div>


            {{-- Desktop --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full">

                    <thead>
                        <tr class="border-b border-[#D6E4DD] bg-[#F8FCF9] dark:border-[#2E473A] dark:bg-[#17271F]">

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Review
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Client
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Freelancer
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Rating
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Status
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Aksi
                            </th>

                        </tr>
                    </thead>


                    <tbody class="divide-y divide-[#E5EEE9] dark:divide-[#294036]">

                        @forelse ($reviews as $review)

                            @php
                                $reviewStatus = $statusMap[$review->status] ?? [
                                    'label' => ucfirst($review->status ?? 'Unknown'),
                                    'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
                                    'icon' => 'bi-question-circle',
                                ];

                                $client = $review->client;
                                $freelancerUser = $review->freelancerProfile?->user;
                                $order = $review->order;
                            @endphp

                            <tr class="transition hover:bg-[#F8FCF9] dark:hover:bg-[#17271F]">

                                {{-- Review --}}
                                <td class="px-5 py-4">

                                    <div class="max-w-[300px]">

                                        @if ($review->comment)
                                            <p class="line-clamp-2 text-sm leading-6 text-[#355247] dark:text-[#D0DED8]">
                                                "{{ $review->comment }}"
                                            </p>
                                        @else
                                            <p class="text-sm italic text-[#8A9B94] dark:text-[#80958A]">
                                                Tidak ada komentar
                                            </p>
                                        @endif

                                        @if ($order)
                                            <a
                                                href="{{ route('admin.orders.show', $order) }}"
                                                class="mt-2 inline-block text-xs font-medium text-[#71837B] hover:text-[#1E9E5A] dark:text-[#8FA59A] dark:hover:text-[#7AD8B5]"
                                            >
                                                Order #{{ $order->order_number }}
                                            </a>
                                        @endif

                                    </div>

                                </td>


                                {{-- Client --}}
                                <td class="px-5 py-4">

                                    <div class="flex min-w-[180px] items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                            {{ strtoupper(substr($client?->name ?? 'C', 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                                {{ $client?->name ?? 'Client tidak tersedia' }}
                                            </p>

                                            @if ($client?->email)
                                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                    {{ $client->email }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Freelancer --}}
                                <td class="px-5 py-4">

                                    <div class="flex min-w-[180px] items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                            {{ strtoupper(substr($freelancerUser?->name ?? 'F', 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                                {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                            </p>

                                            @if ($review->freelancerProfile?->username)
                                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                    {{ '@' . $review->freelancerProfile->username }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Rating --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[120px]">

                                        <div class="flex items-center gap-1">

                                            @for ($star = 1; $star <= 5; $star++)

                                                <i class="bi bi-star-fill text-sm {{ $star <= $review->rating ? 'text-[#F0B429]' : 'text-[#D5DED9] dark:text-[#46594F]' }}"></i>

                                            @endfor

                                        </div>

                                        <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                            {{ $review->rating }}/5
                                        </p>

                                    </div>

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $reviewStatus['class'] }}">
                                        <i class="bi {{ $reviewStatus['icon'] }}"></i>
                                        {{ $reviewStatus['label'] }}
                                    </span>

                                </td>


                                {{-- Action --}}
                                <td class="px-5 py-4">

                                    <div class="flex justify-end">

                                        <a
                                            href="{{ route('admin.reviews.show', $review) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-[#D0DED8] bg-white text-[#486258] transition hover:border-[#9EB5AA] hover:bg-[#F4F8F5] hover:text-[#1E9E5A] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#AFC0B8] dark:hover:border-[#4C695B] dark:hover:bg-[#1D3327] dark:hover:text-[#7AD8B5]"
                                            title="Lihat detail"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-16 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                        <i class="bi bi-star text-2xl"></i>
                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-[#123128] dark:text-white">
                                        Review belum ditemukan
                                    </h3>

                                    <p class="mx-auto mt-1 max-w-md text-sm text-[#71837B] dark:text-[#8FA59A]">
                                        Tidak ada review yang sesuai dengan pencarian atau filter yang dipilih.
                                    </p>

                                    @if ($search !== '' || $status || $rating)
                                        <a
                                            href="{{ route('admin.reviews.index') }}"
                                            class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#1E9E5A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#17844A]"
                                        >
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                            Tampilkan semua
                                        </a>
                                    @endif

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Mobile --}}
            <div class="divide-y divide-[#E5EEE9] md:hidden dark:divide-[#294036]">

                @forelse ($reviews as $review)

                    @php
                        $reviewStatus = $statusMap[$review->status] ?? [
                            'label' => ucfirst($review->status ?? 'Unknown'),
                            'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
                            'icon' => 'bi-question-circle',
                        ];

                        $client = $review->client;
                        $freelancerUser = $review->freelancerProfile?->user;
                        $order = $review->order;
                    @endphp

                    <div class="p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    {{ strtoupper(substr($client?->name ?? 'C', 0, 1)) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-[#263F35] dark:text-[#D7E3DE]">
                                        {{ $client?->name ?? 'Client tidak tersedia' }}
                                    </p>

                                    @if ($order)
                                        <p class="mt-0.5 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                            #{{ $order->order_number }}
                                        </p>
                                    @endif

                                </div>

                            </div>


                            <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $reviewStatus['class'] }}">
                                <i class="bi {{ $reviewStatus['icon'] }}"></i>
                                {{ $reviewStatus['label'] }}
                            </span>

                        </div>


                        {{-- Rating --}}
                        <div class="mt-4 flex items-center gap-2">

                            <div class="flex items-center gap-1">

                                @for ($star = 1; $star <= 5; $star++)

                                    <i class="bi bi-star-fill text-sm {{ $star <= $review->rating ? 'text-[#F0B429]' : 'text-[#D5DED9] dark:text-[#46594F]' }}"></i>

                                @endfor

                            </div>

                            <span class="text-xs font-medium text-[#71837B] dark:text-[#8FA59A]">
                                {{ $review->rating }}/5
                            </span>

                        </div>


                        {{-- Comment --}}
                        <div class="mt-3">

                            @if ($review->comment)

                                <p class="line-clamp-3 text-sm leading-6 text-[#536B60] dark:text-[#B7C7C0]">
                                    "{{ $review->comment }}"
                                </p>

                            @else

                                <p class="text-sm italic text-[#8A9B94] dark:text-[#80958A]">
                                    Tidak ada komentar.
                                </p>

                            @endif

                        </div>


                        {{-- Freelancer --}}
                        <div class="mt-4 flex items-center gap-2 text-xs text-[#71837B] dark:text-[#8FA59A]">
                            <i class="bi bi-person-badge"></i>

                            <span>
                                Freelancer:
                                <span class="font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                    {{ $freelancerUser?->name ?? 'Tidak tersedia' }}
                                </span>
                            </span>
                        </div>


                        {{-- Footer --}}
                        <div class="mt-4 flex items-center justify-end border-t border-[#E5EEE9] pt-4 dark:border-[#294036]">

                            <a
                                href="{{ route('admin.reviews.show', $review) }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-[#EAF7EF] px-4 py-2.5 text-sm font-semibold text-[#1E7045] transition hover:bg-[#DDF1E5] dark:bg-[#234632] dark:text-[#A4E5BA] dark:hover:bg-[#2B513B]"
                            >
                                <i class="bi bi-eye"></i>
                                Detail
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="px-6 py-14 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-star text-2xl"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-semibold text-[#123128] dark:text-white">
                            Review belum ditemukan
                        </h3>

                        <p class="mt-1 text-sm text-[#71837B] dark:text-[#8FA59A]">
                            Belum ada review yang sesuai.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($reviews->hasPages())

                <div class="border-t border-[#D6E4DD] px-5 py-4 dark:border-[#2E473A]">
                    {{ $reviews->links() }}
                </div>

            @endif

        </div>

    </div>

</x-layouts.admin>