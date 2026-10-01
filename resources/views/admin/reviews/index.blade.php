<x-layouts.admin title="Kelola Review">


@php
    $statusMap = [
        'published' => [
            'label' => 'Tampil',
            'class' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/25 dark:text-emerald-300',
            'icon' => 'bi-eye-fill',
        ],
        'hidden' => [
            'label' => 'Disembunyikan',
            'class' => 'bg-red-50 text-red-700 dark:bg-red-900/25 dark:text-red-300',
            'icon' => 'bi-eye-slash-fill',
        ],
    ];
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:border-blue-900/50 dark:bg-blue-900/20 dark:text-blue-300">
                <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                Marketplace
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Kelola Review
            </h1>

            <p class="mt-1.5 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Pantau dan moderasi ulasan client terhadap freelancer.
            </p>
        </div>

        {{-- Total --}}
        <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                <i class="bi bi-star-fill"></i>
            </div>

            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                    Total Review
                </p>

                <p class="mt-0.5 text-lg font-bold text-slate-900 dark:text-white">
                    {{ $reviews->total() }}
                </p>
            </div>

        </div>

    </div>

    {{-- Success --}}
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-900/50 dark:bg-emerald-900/15">
            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-sm leading-6 text-emerald-700 dark:text-emerald-200/80">
                        {{ session('success') }}
                    </p>
                </div>

            </div>
        </div>
    @endif

    {{-- Filter --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                        Filter Review
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                        Cari review berdasarkan client, freelancer, order, atau isi ulasan.
                    </p>
                </div>

            </div>

        </div>

        <form
            action="{{ route('admin.reviews.index') }}"
            method="GET"
            class="p-5"
        >

            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_180px_180px_auto] lg:items-end">

                {{-- Search --}}
                <div>
                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                    >
                        Cari review
                    </label>

                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <i class="bi bi-search text-slate-400"></i>
                        </div>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Client, freelancer, order, atau komentar..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-400 dark:focus:ring-blue-400/10"
                        >
                    </div>
                </div>

                {{-- Rating --}}
                <div>
                    <label
                        for="rating"
                        class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                    >
                        Rating
                    </label>

                    <select
                        id="rating"
                        name="rating"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-400 dark:focus:ring-blue-400/10"
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
                        class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-400 dark:focus:ring-blue-400/10"
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
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15 lg:w-auto"
                    >
                        <i class="bi bi-search"></i>
                        Cari
                    </button>

                    @if ($search !== '' || $status || $rating)
                        <a
                            href="{{ route('admin.reviews.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:border-slate-600 dark:hover:bg-slate-900 dark:hover:text-white"
                        >
                            Reset
                        </a>
                    @endif

                </div>

            </div>

        </form>

    </div>

    {{-- Review List --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- Header --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-slate-800">

            <div>
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                    Daftar Review
                </h2>

                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                    Menampilkan {{ $reviews->firstItem() ?? 0 }}–{{ $reviews->lastItem() ?? 0 }}
                    dari {{ $reviews->total() }} review
                </p>
            </div>

            <div class="hidden items-center gap-2 text-xs text-slate-500 sm:flex dark:text-slate-400">
                <i class="bi bi-shield-check text-blue-600 dark:text-blue-400"></i>
                Moderasi konten
            </div>

        </div>

        {{-- Desktop --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="min-w-full">

                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 dark:border-slate-800 dark:bg-slate-950/60">

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Review
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Client
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Freelancer
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Rating
                        </th>

                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Status
                        </th>

                        <th class="px-5 py-3.5 text-right text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-500 dark:text-slate-400">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                    @forelse ($reviews as $review)

                        @php
                            $reviewStatus = $statusMap[$review->status] ?? [
                                'label' => ucfirst($review->status ?? 'Unknown'),
                                'class' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
                                'icon' => 'bi-question-circle',
                            ];

                            $client = $review->client;
                            $clientProfile = $client?->profile;

                            $freelancerProfile = $review->freelancerProfile;
                            $freelancerUser = $freelancerProfile?->user;

                            $order = $review->order;

                            $clientAvatar = $clientProfile?->avatar;
                            $freelancerAvatar = $freelancerProfile?->avatar;
                        @endphp

                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-950/40">

                            {{-- Review --}}
                            <td class="px-5 py-4">

                                <div class="max-w-[330px]">

                                    @if ($review->comment)

                                        <p class="line-clamp-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                            "{{ $review->comment }}"
                                        </p>

                                    @else

                                        <p class="text-sm italic text-slate-400 dark:text-slate-500">
                                            Tidak ada komentar
                                        </p>

                                    @endif

                                    @if ($order)
                                        <a
                                            href="{{ route('admin.orders.show', $order) }}"
                                            class="mt-2 inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
                                        >
                                            <i class="bi bi-receipt"></i>
                                            Order #{{ $order->order_number }}
                                        </a>
                                    @endif

                                </div>

                            </td>

                            {{-- Client --}}
                            <td class="px-5 py-4">

                                <div class="flex min-w-[210px] items-center gap-3">

                                    <div class="h-11 w-11 shrink-0 overflow-hidden rounded-full border border-blue-100 bg-blue-50 dark:border-blue-900/50 dark:bg-blue-900/20">

                                        @if ($clientAvatar)

                                            <img
                                                src="{{ asset('storage/' . $clientAvatar) }}"
                                                alt="{{ $client?->name ?? 'Client' }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @elseif ($client)

                                            <div class="flex h-full w-full items-center justify-center text-sm font-bold text-blue-600 dark:text-blue-300">
                                                {{ strtoupper(substr($client->name, 0, 1)) }}
                                            </div>

                                        @else

                                            <div class="flex h-full w-full items-center justify-center text-blue-500 dark:text-blue-300">
                                                <i class="bi bi-person"></i>
                                            </div>

                                        @endif

                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $client?->name ?? 'Client tidak tersedia' }}
                                        </p>

                                        @if ($client?->email)
                                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                                {{ $client->email }}
                                            </p>
                                        @endif

                                    </div>

                                </div>

                            </td>

                            {{-- Freelancer --}}
                            <td class="px-5 py-4">

                                <div class="flex min-w-[210px] items-center gap-3">

                                    <div class="h-11 w-11 shrink-0 overflow-hidden rounded-full border border-indigo-100 bg-indigo-50 dark:border-indigo-900/50 dark:bg-indigo-900/20">

                                        @if ($freelancerAvatar)

                                            <img
                                                src="{{ asset('storage/' . $freelancerAvatar) }}"
                                                alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @elseif ($freelancerUser)

                                            <div class="flex h-full w-full items-center justify-center text-sm font-bold text-indigo-600 dark:text-indigo-300">
                                                {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                            </div>

                                        @else

                                            <div class="flex h-full w-full items-center justify-center text-indigo-500 dark:text-indigo-300">
                                                <i class="bi bi-person"></i>
                                            </div>

                                        @endif

                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                        </p>

                                        @if ($freelancerProfile?->username)
                                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                                {{ '@' . $freelancerProfile->username }}
                                            </p>
                                        @endif

                                    </div>

                                </div>

                            </td>

                            {{-- Rating --}}
                            <td class="px-5 py-4">

                                <div class="min-w-[120px]">

                                    <div class="flex items-center gap-0.5">

                                        @for ($star = 1; $star <= 5; $star++)

                                            <i class="bi bi-star-fill text-sm {{ $star <= $review->rating ? 'text-amber-400' : 'text-slate-200 dark:text-slate-700' }}"></i>

                                        @endfor

                                    </div>

                                    <p class="mt-1.5 text-xs font-medium text-slate-500 dark:text-slate-400">
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
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-400 dark:hover:border-blue-900/50 dark:hover:bg-blue-900/20 dark:hover:text-blue-300"
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

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                                    <i class="bi bi-star text-2xl"></i>
                                </div>

                                <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">
                                    Review belum ditemukan
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500 dark:text-slate-400">
                                    Tidak ada review yang sesuai dengan pencarian atau filter yang dipilih.
                                </p>

                                @if ($search !== '' || $status || $rating)

                                    <a
                                        href="{{ route('admin.reviews.index') }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700"
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
        <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">

            @forelse ($reviews as $review)

                @php
                    $reviewStatus = $statusMap[$review->status] ?? [
                        'label' => ucfirst($review->status ?? 'Unknown'),
                        'class' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
                        'icon' => 'bi-question-circle',
                    ];

                    $client = $review->client;
                    $clientProfile = $client?->profile;

                    $freelancerProfile = $review->freelancerProfile;
                    $freelancerUser = $freelancerProfile?->user;

                    $order = $review->order;

                    $clientAvatar = $clientProfile?->avatar;
                    $freelancerAvatar = $freelancerProfile?->avatar;
                @endphp

                <div class="p-4 sm:p-5">

                    {{-- Header --}}
                    <div class="flex items-start justify-between gap-3">

                        <div class="flex min-w-0 items-center gap-3">

                            <div class="h-11 w-11 shrink-0 overflow-hidden rounded-full border border-blue-100 bg-blue-50 dark:border-blue-900/50 dark:bg-blue-900/20">

                                @if ($clientAvatar)

                                    <img
                                        src="{{ asset('storage/' . $clientAvatar) }}"
                                        alt="{{ $client?->name ?? 'Client' }}"
                                        class="h-full w-full object-cover"
                                    >

                                @elseif ($client)

                                    <div class="flex h-full w-full items-center justify-center text-sm font-bold text-blue-600 dark:text-blue-300">
                                        {{ strtoupper(substr($client->name, 0, 1)) }}
                                    </div>

                                @else

                                    <div class="flex h-full w-full items-center justify-center text-blue-500">
                                        <i class="bi bi-person"></i>
                                    </div>

                                @endif

                            </div>

                            <div class="min-w-0">

                                <p class="truncate text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $client?->name ?? 'Client tidak tersedia' }}
                                </p>

                                @if ($order)
                                    <a
                                        href="{{ route('admin.orders.show', $order) }}"
                                        class="mt-0.5 inline-flex items-center gap-1 text-xs text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
                                    >
                                        <i class="bi bi-receipt"></i>
                                        #{{ $order->order_number }}
                                    </a>
                                @endif

                            </div>

                        </div>

                        <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $reviewStatus['class'] }}">
                            <i class="bi {{ $reviewStatus['icon'] }}"></i>
                            {{ $reviewStatus['label'] }}
                        </span>

                    </div>

                    {{-- Rating --}}
                    <div class="mt-4 flex items-center gap-2">

                        <div class="flex items-center gap-0.5">

                            @for ($star = 1; $star <= 5; $star++)
                                <i class="bi bi-star-fill text-sm {{ $star <= $review->rating ? 'text-amber-400' : 'text-slate-200 dark:text-slate-700' }}"></i>
                            @endfor

                        </div>

                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                            {{ $review->rating }}/5
                        </span>

                    </div>

                    {{-- Comment --}}
                    <div class="mt-3 rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">

                        @if ($review->comment)

                            <p class="line-clamp-4 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                "{{ $review->comment }}"
                            </p>

                        @else

                            <p class="text-sm italic text-slate-400 dark:text-slate-500">
                                Tidak ada komentar.
                            </p>

                        @endif

                    </div>

                    {{-- Freelancer --}}
                    <div class="mt-4 flex items-center gap-3">

                        <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-indigo-100 bg-indigo-50 dark:border-indigo-900/50 dark:bg-indigo-900/20">

                            @if ($freelancerAvatar)

                                <img
                                    src="{{ asset('storage/' . $freelancerAvatar) }}"
                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                    class="h-full w-full object-cover"
                                >

                            @elseif ($freelancerUser)

                                <div class="flex h-full w-full items-center justify-center text-sm font-bold text-indigo-600 dark:text-indigo-300">
                                    {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                </div>

                            @else

                                <div class="flex h-full w-full items-center justify-center text-indigo-500">
                                    <i class="bi bi-person"></i>
                                </div>

                            @endif

                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.08em] text-slate-400">
                                Freelancer
                            </p>

                            <p class="truncate text-sm font-semibold text-slate-700 dark:text-slate-300">
                                {{ $freelancerUser?->name ?? 'Tidak tersedia' }}
                            </p>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="mt-4 flex items-center justify-between gap-3 border-t border-slate-100 pt-4 dark:border-slate-800">

                        <div class="text-xs text-slate-500 dark:text-slate-400">
                            Review marketplace
                        </div>

                        <a
                            href="{{ route('admin.reviews.show', $review) }}"
                            class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700"
                        >
                            <i class="bi bi-eye"></i>
                            Detail
                        </a>

                    </div>

                </div>

            @empty

                <div class="px-6 py-14 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-star text-2xl"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">
                        Review belum ditemukan
                    </h3>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Belum ada review yang sesuai.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($reviews->hasPages())

            <div class="border-t border-slate-100 px-4 py-4 sm:px-5 dark:border-slate-800">
                {{ $reviews->links() }}
            </div>

        @endif

    </div>

</div>


</x-layouts.admin>
