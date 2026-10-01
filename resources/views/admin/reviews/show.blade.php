<x-layouts.admin title="Detail Review">


@php
    $statusMap = [
        'published' => [
            'label' => 'Tampil',
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/25 dark:text-emerald-300 dark:border-emerald-800',
            'icon' => 'bi-eye-fill',
        ],
        'hidden' => [
            'label' => 'Disembunyikan',
            'class' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/25 dark:text-red-300 dark:border-red-800',
            'icon' => 'bi-eye-slash-fill',
        ],
    ];

    $reviewStatus = $statusMap[$review->status] ?? [
        'label' => ucfirst($review->status ?? 'Unknown'),
        'class' => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700',
        'icon' => 'bi-question-circle',
    ];

    $client = $review->client;
    $clientProfile = $client?->profile;

    $freelancer = $review->freelancerProfile;
    $freelancerUser = $freelancer?->user;

    $order = $review->order;

    $clientAvatar = $clientProfile?->avatar;
    $freelancerAvatar = $freelancer?->avatar;

    $clientInitial = strtoupper(substr($client?->name ?? 'C', 0, 1));
    $freelancerInitial = strtoupper(substr($freelancerUser?->name ?? 'F', 0, 1));
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div class="min-w-0">

            <a
                href="{{ route('admin.reviews.index') }}"
                class="group inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
            >
                <span class="flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 bg-white transition group-hover:border-blue-200 group-hover:bg-blue-50 dark:border-slate-700 dark:bg-slate-900 dark:group-hover:border-blue-900/50 dark:group-hover:bg-blue-900/20">
                    <i class="bi bi-arrow-left"></i>
                </span>

                Kembali ke review
            </a>

            <div class="mt-4">

                <div class="flex flex-wrap items-center gap-2.5">

                    <span class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:border-blue-900/50 dark:bg-blue-900/20 dark:text-blue-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                        Detail Review
                    </span>

                    <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $reviewStatus['class'] }}">
                        <i class="bi {{ $reviewStatus['icon'] }}"></i>
                        {{ $reviewStatus['label'] }}
                    </span>

                </div>

                <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                    Review #{{ $review->id }}
                </h1>

                <p class="mt-1.5 max-w-3xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Review client terhadap pengalaman menggunakan jasa freelancer.
                </p>

            </div>

        </div>

        {{-- Rating --}}
        <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-slate-400">
                Rating
            </p>

            <div class="mt-1 flex items-center gap-3">

                <span class="text-2xl font-bold text-slate-900 dark:text-white">
                    {{ $review->rating }}
                </span>

                <div class="flex items-center gap-0.5">

                    @for ($star = 1; $star <= 5; $star++)
                        <i class="bi bi-star-fill text-sm {{ $star <= $review->rating ? 'text-amber-400' : 'text-slate-200 dark:text-slate-700' }}"></i>
                    @endfor

                </div>

            </div>

            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                dari 5 bintang
            </p>

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

    {{-- Validation --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 dark:border-red-900/50 dark:bg-red-900/15">

            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-300">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <div class="min-w-0">

                    <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                        Ada data yang perlu diperiksa
                    </p>

                    <ul class="mt-2 space-y-1 text-sm leading-6 text-red-700 dark:text-red-200/80">
                        @foreach ($errors->all() as $error)
                            <li class="flex gap-2">
                                <span>•</span>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>

                </div>

            </div>

        </div>
    @endif

    {{-- Main --}}
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">

        {{-- LEFT --}}
        <div class="min-w-0 space-y-6">

            {{-- Review Content --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6 dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                            <i class="bi bi-chat-square-quote-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                                Isi Review
                            </h2>

                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">
                                Ulasan yang diberikan oleh client
                            </p>
                        </div>

                    </div>

                </div>

                <div class="p-5 sm:p-6">

                    {{-- Rating --}}
                    <div class="flex flex-wrap items-center gap-3">

                        <div class="flex items-center gap-1.5">

                            @for ($star = 1; $star <= 5; $star++)
                                <i class="bi bi-star-fill text-lg {{ $star <= $review->rating ? 'text-amber-400' : 'text-slate-200 dark:text-slate-700' }}"></i>
                            @endfor

                        </div>

                        <span class="rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/20 dark:text-amber-300">
                            {{ $review->rating }}/5
                        </span>

                    </div>

                    {{-- Comment --}}
                    <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-950/60 sm:p-6">

                        @if ($review->comment)

                            <div class="flex gap-3">

                                <i class="bi bi-quote text-xl text-blue-300 dark:text-blue-700"></i>

                                <p class="min-w-0 whitespace-pre-line text-base leading-8 text-slate-700 dark:text-slate-300">
                                    {{ $review->comment }}
                                </p>

                            </div>

                        @else

                            <div class="flex items-center gap-3 text-sm italic text-slate-400 dark:text-slate-500">
                                <i class="bi bi-chat-square"></i>
                                Client tidak memberikan komentar tambahan.
                            </div>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Client & Freelancer --}}
            <div class="grid gap-6 md:grid-cols-2">

                {{-- Client --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                            <i class="bi bi-person"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                                Client
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Pemberi review
                            </p>
                        </div>

                    </div>

                    <div class="mt-5 flex items-center gap-3">

                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full border-2 border-blue-100 bg-blue-50 dark:border-blue-900/50 dark:bg-blue-900/20">

                            @if ($clientAvatar)

                                <img
                                    src="{{ asset('storage/' . $clientAvatar) }}"
                                    alt="{{ $client?->name ?? 'Client' }}"
                                    class="h-full w-full object-cover"
                                >

                            @elseif ($client)

                                <div class="flex h-full w-full items-center justify-center text-lg font-bold text-blue-600 dark:text-blue-300">
                                    {{ $clientInitial }}
                                </div>

                            @else

                                <div class="flex h-full w-full items-center justify-center text-blue-500 dark:text-blue-300">
                                    <i class="bi bi-person text-xl"></i>
                                </div>

                            @endif

                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="truncate text-sm font-bold text-slate-900 dark:text-white">
                                {{ $client?->name ?? 'Client tidak tersedia' }}
                            </p>

                            @if ($client?->email)
                                <p class="mt-1 truncate text-xs text-slate-500 dark:text-slate-400">
                                    {{ $client->email }}
                                </p>
                            @endif

                        </div>

                    </div>

                </div>

                {{-- Freelancer --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-300">
                            <i class="bi bi-person-badge"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                                Freelancer
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Penerima review
                            </p>
                        </div>

                    </div>

                    <div class="mt-5 flex items-center gap-3">

                        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full border-2 border-indigo-100 bg-indigo-50 dark:border-indigo-900/50 dark:bg-indigo-900/20">

                            @if ($freelancerAvatar)

                                <img
                                    src="{{ asset('storage/' . $freelancerAvatar) }}"
                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                    class="h-full w-full object-cover"
                                >

                            @elseif ($freelancerUser)

                                <div class="flex h-full w-full items-center justify-center text-lg font-bold text-indigo-600 dark:text-indigo-300">
                                    {{ $freelancerInitial }}
                                </div>

                            @else

                                <div class="flex h-full w-full items-center justify-center text-indigo-500 dark:text-indigo-300">
                                    <i class="bi bi-person text-xl"></i>
                                </div>

                            @endif

                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="truncate text-sm font-bold text-slate-900 dark:text-white">
                                {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                            </p>

                            @if ($freelancer?->username)
                                <p class="mt-1 truncate text-xs text-slate-500 dark:text-slate-400">
                                    {{ '@' . $freelancer->username }}
                                </p>
                            @endif

                        </div>

                    </div>

                    @if ($freelancer?->headline)
                        <div class="mt-4 rounded-xl bg-slate-50 p-3.5 dark:bg-slate-950/60">
                            <p class="line-clamp-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                {{ $freelancer->headline }}
                            </p>
                        </div>
                    @endif

                </div>

            </div>

            {{-- Related Order --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6 dark:border-slate-800">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                                <i class="bi bi-receipt-cutoff"></i>
                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                                    Pesanan Terkait
                                </h2>

                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Transaksi sumber review
                                </p>
                            </div>

                        </div>

                        @if ($order)

                            <a
                                href="{{ route('admin.orders.show', $order) }}"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:border-blue-900/50 dark:hover:bg-blue-900/20 dark:hover:text-blue-300 sm:w-auto"
                            >
                                Detail Order
                                <i class="bi bi-arrow-up-right"></i>
                            </a>

                        @endif

                    </div>

                </div>

                @if ($order)

                    <div class="p-5 sm:p-6">

                        <div class="grid gap-4 sm:grid-cols-2">

                            <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">

                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Nomor Order
                                </p>

                                <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                                    #{{ $order->order_number }}
                                </p>

                            </div>

                            <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-950/60">

                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Status Order
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                    {{ ucfirst(str_replace('_', ' ', $order->status ?? '-')) }}
                                </p>

                            </div>

                        </div>

                    </div>

                @else

                    <div class="p-5 sm:p-6">
                        <div class="flex items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
                            <i class="bi bi-info-circle"></i>
                            Order terkait tidak ditemukan.
                        </div>
                    </div>

                @endif

            </div>

            {{-- Admin Note --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-sticky-fill"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Catatan Admin
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Catatan internal moderasi
                        </p>
                    </div>

                </div>

                <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/60">

                    @if ($review->admin_note)

                        <p class="whitespace-pre-line text-sm leading-6 text-slate-600 dark:text-slate-300">
                            {{ $review->admin_note }}
                        </p>

                    @else

                        <div class="flex items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
                            <i class="bi bi-info-circle"></i>
                            Belum ada catatan admin.
                        </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            {{-- Moderation --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Moderasi Review
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
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
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:hover:border-slate-600 dark:focus:border-blue-400 dark:focus:ring-blue-400/10"
                        >
                            <option
                                value="published"
                                @selected(old('status', $review->status) === 'published')
                            >
                                Tampil
                            </option>

                            <option
                                value="hidden"
                                @selected(old('status', $review->status) === 'hidden')
                            >
                                Disembunyikan
                            </option>
                        </select>

                    </div>

                    {{-- Admin Note --}}
                    <div>

                        <label
                            for="admin_note"
                            class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"
                        >
                            Catatan Admin
                        </label>

                        <textarea
                            id="admin_note"
                            name="admin_note"
                            rows="5"
                            placeholder="Tulis catatan internal moderasi..."
                            class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-400 dark:focus:ring-blue-400/10"
                        >{{ old('admin_note', $review->admin_note) }}</textarea>

                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15"
                    >
                        <i class="bi bi-check2-circle"></i>
                        Simpan Moderasi
                    </button>

                </form>

            </div>

            {{-- Current Status --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                            Status Saat Ini
                        </h2>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Kondisi review
                        </p>
                    </div>

                </div>

                <div class="mt-5 rounded-xl border px-4 py-4 {{ $reviewStatus['class'] }}">

                    <div class="flex items-start gap-3">

                        <i class="bi {{ $reviewStatus['icon'] }} mt-0.5"></i>

                        <div class="min-w-0">

                            <p class="text-sm font-semibold">
                                {{ $reviewStatus['label'] }}
                            </p>

                            <p class="mt-1 text-xs leading-5 opacity-90">

                                @if ($review->status === 'published')
                                    Review dapat ditampilkan kepada pengguna marketplace.
                                @elseif ($review->status === 'hidden')
                                    Review tidak ditampilkan kepada pengguna marketplace.
                                @else
                                    Status review belum memiliki keterangan khusus.
                                @endif

                            </p>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Date --}}
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-950/60 sm:p-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                        <i class="bi bi-calendar3"></i>
                    </div>

                    <div class="min-w-0 flex-1">

                        <p class="text-sm font-semibold text-slate-900 dark:text-white">
                            Informasi Waktu
                        </p>

                        <div class="mt-4 space-y-3">

                            <div class="flex items-start justify-between gap-4">
                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                    Dibuat
                                </span>

                                <span class="text-right text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    {{ $review->created_at?->format('d M Y, H:i') ?? '-' }}
                                </span>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                    Ditampilkan
                                </span>

                                <span class="text-right text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    {{ $review->published_at?->format('d M Y, H:i') ?? '-' }}
                                </span>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                    Diperbarui
                                </span>

                                <span class="text-right text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    {{ $review->updated_at?->format('d M Y, H:i') ?? '-' }}
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Moderation Note --}}
            <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-5 dark:border-blue-900/40 dark:bg-blue-900/10 sm:p-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-300">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <div class="min-w-0">

                        <p class="text-sm font-semibold text-slate-900 dark:text-white">
                            Catatan Moderasi
                        </p>

                        <p class="mt-1.5 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            Menyembunyikan review hanya mengubah visibilitasnya. Data review tetap tersimpan untuk kebutuhan administrasi dan audit.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


</x-layouts.admin>
