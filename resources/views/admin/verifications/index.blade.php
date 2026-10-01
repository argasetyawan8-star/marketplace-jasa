<x-layouts.admin title="Verifikasi Freelancer">


<div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div class="min-w-0">

            <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 dark:border-blue-900/40 dark:bg-blue-950/30">
                <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                <span class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-700 dark:text-blue-300">
                    Manajemen Freelancer
                </span>
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Verifikasi Freelancer
            </h1>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                Periksa identitas dan rekening freelancer sebelum akun dinyatakan terverifikasi.
            </p>

        </div>

        <div class="hidden h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/20 sm:flex">
            <i class="bi bi-patch-check-fill text-lg"></i>
        </div>

    </div>

    {{-- =========================================================
         SUCCESS
    ========================================================== --}}
    @if (session('success'))
        <div class="overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50 dark:border-emerald-900/40 dark:bg-emerald-950/30">

            <div class="flex items-start gap-3 px-5 py-4">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-400">
                    <i class="bi bi-check-circle-fill text-sm"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold text-emerald-800 dark:text-emerald-300">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-xs leading-5 text-emerald-700 dark:text-emerald-400">
                        {{ session('success') }}
                    </p>
                </div>

            </div>

        </div>
    @endif

    {{-- =========================================================
         SUMMARY
    ========================================================== --}}
    <div class="grid grid-cols-2 gap-3 xl:grid-cols-4">

        {{-- ALL --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                        Semua Pengajuan
                    </p>

                    <p class="mt-3 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $counts['all'] }}
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                    <i class="bi bi-people"></i>
                </div>

            </div>

            <p class="mt-2 text-[10px] text-slate-400">
                Total pengajuan verifikasi
            </p>

        </div>

        {{-- PENDING --}}
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 shadow-sm dark:border-amber-900/40 dark:bg-amber-950/20 sm:p-5">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-amber-700 dark:text-amber-300">
                        Menunggu Review
                    </p>

                    <p class="mt-3 text-2xl font-bold tracking-tight text-amber-800 dark:text-amber-200">
                        {{ $counts['pending'] }}
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/80 text-amber-600 shadow-sm dark:bg-slate-900 dark:text-amber-300">
                    <i class="bi bi-hourglass-split"></i>
                </div>

            </div>

            <p class="mt-2 text-[10px] text-amber-700/70 dark:text-amber-300/70">
                Membutuhkan pemeriksaan
            </p>

        </div>

        {{-- VERIFIED --}}
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 shadow-sm dark:border-emerald-900/40 dark:bg-emerald-950/20 sm:p-5">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-300">
                        Terverifikasi
                    </p>

                    <p class="mt-3 text-2xl font-bold tracking-tight text-emerald-800 dark:text-emerald-200">
                        {{ $counts['verified'] }}
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/80 text-emerald-600 shadow-sm dark:bg-slate-900 dark:text-emerald-300">
                    <i class="bi bi-patch-check-fill"></i>
                </div>

            </div>

            <p class="mt-2 text-[10px] text-emerald-700/70 dark:text-emerald-300/70">
                Freelancer terverifikasi
            </p>

        </div>

        {{-- REJECTED --}}
        <div class="col-span-2 rounded-2xl border border-red-200 bg-red-50 p-4 shadow-sm dark:border-red-900/40 dark:bg-red-950/20 xl:col-span-1 sm:p-5">

            <div class="flex items-start justify-between gap-3">

                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-red-700 dark:text-red-300">
                        Ditolak
                    </p>

                    <p class="mt-3 text-2xl font-bold tracking-tight text-red-800 dark:text-red-200">
                        {{ $counts['rejected'] }}
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/80 text-red-600 shadow-sm dark:bg-slate-900 dark:text-red-300">
                    <i class="bi bi-x-circle-fill"></i>
                </div>

            </div>

            <p class="mt-2 text-[10px] text-red-700/70 dark:text-red-300/70">
                Pengajuan yang ditolak
            </p>

        </div>

    </div>

    {{-- =========================================================
         FILTER
    ========================================================== --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="mb-5 flex items-center gap-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                <i class="bi bi-funnel-fill"></i>
            </div>

            <div>
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                    Filter Verifikasi
                </h2>

                <p class="mt-0.5 text-[10px] text-slate-400 dark:text-slate-500">
                    Cari freelancer atau tampilkan berdasarkan status verifikasi.
                </p>
            </div>

        </div>

        <form
            method="GET"
            action="{{ route('admin.verifications.index') }}"
            class="grid grid-cols-1 gap-4 md:grid-cols-[minmax(0,1fr)_200px_auto]"
        >

            {{-- SEARCH --}}
            <div>

                <label
                    for="search"
                    class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                >
                    Cari freelancer
                </label>

                <div class="relative">

                    <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama freelancer atau email..."
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-xs text-slate-700 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                    >

                </div>

            </div>

            {{-- STATUS --}}
            <div>

                <label
                    for="status"
                    class="mb-2 block text-xs font-semibold text-slate-700 dark:text-slate-300"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:focus:border-blue-500 dark:focus:bg-slate-900"
                >

                    <option value="">
                        Semua status
                    </option>

                    <option
                        value="pending"
                        @selected($status === 'pending')
                    >
                        Menunggu review
                    </option>

                    <option
                        value="verified"
                        @selected($status === 'verified')
                    >
                        Terverifikasi
                    </option>

                    <option
                        value="rejected"
                        @selected($status === 'rejected')
                    >
                        Ditolak
                    </option>

                </select>

            </div>

            {{-- BUTTON --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15 md:w-auto"
                >
                    <i class="bi bi-search"></i>
                    Filter
                </button>

                @if ($search !== '' || $status)
                    <a
                        href="{{ route('admin.verifications.index') }}"
                        class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-900 dark:hover:bg-blue-950/20 dark:hover:text-blue-400"
                    >
                        Reset
                    </a>
                @endif

            </div>

        </form>

    </section>

    {{-- =========================================================
         DESKTOP TABLE
    ========================================================== --}}
    <section class="hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:block">

        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div>

                <div class="flex items-center gap-2">

                    <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                    <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-blue-600 dark:text-blue-400">
                        Verifikasi
                    </p>

                </div>

                <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                    Daftar Pengajuan
                </h2>

                <p class="mt-1 text-xs leading-5 text-slate-400 dark:text-slate-500">
                    Periksa identitas, rekening, status, dan tanggal pengajuan freelancer.
                </p>

            </div>

            <div class="hidden items-center gap-2 rounded-xl bg-blue-50 px-3 py-2 text-[10px] font-semibold text-blue-700 dark:bg-blue-950/30 dark:text-blue-300 sm:flex">
                <i class="bi bi-shield-check"></i>
                Pemeriksaan identitas
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-50 dark:bg-slate-950/60">
                    <tr class="border-b border-slate-100 dark:border-slate-800">

                        <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Freelancer
                        </th>

                        <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Identitas
                        </th>

                        <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Bank
                        </th>

                        <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Status
                        </th>

                        <th class="px-5 py-3 text-left text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Diajukan
                        </th>

                        <th class="px-5 py-3 text-right text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                    @forelse ($verifications as $verification)

                        @php
                            $user = $verification->freelancerProfile?->user;
                            $freelancerProfile = $verification->freelancerProfile;
                            $avatar = $freelancerProfile?->avatar;

                            $avatarUrl = null;

                            if ($avatar) {
                                $avatarUrl =
                                    str_starts_with($avatar, 'http://')
                                    || str_starts_with($avatar, 'https://')
                                    ? $avatar
                                    : asset('storage/' . ltrim($avatar, '/'));
                            }

                            $displayName = $user?->name ?? $verification->full_name ?? 'Freelancer';

                            $initials = collect(explode(' ', trim($displayName)))
                                ->filter()
                                ->take(2)
                                ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                                ->implode('');
                        @endphp

                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/40">

                            {{-- FREELANCER --}}
                            <td class="px-5 py-4">

                                <div class="flex min-w-[230px] items-center gap-3">

                                    <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-slate-200 bg-blue-50 dark:border-slate-700 dark:bg-blue-950/30">

                                        @if ($avatarUrl)

                                            <img
                                                src="{{ $avatarUrl }}"
                                                alt="{{ $displayName }}"
                                                class="h-full w-full object-cover"
                                                loading="lazy"
                                            >

                                        @else

                                            <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-blue-600 dark:text-blue-400">
                                                {{ $initials ?: 'FR' }}
                                            </div>

                                        @endif

                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-xs font-bold text-slate-800 dark:text-slate-200">
                                            {{ $displayName }}
                                        </p>

                                        <p class="mt-1 truncate text-[10px] text-slate-400">
                                            {{ $user?->email ?? '-' }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            {{-- IDENTITAS --}}
                            <td class="px-5 py-4">

                                <div class="min-w-[150px]">

                                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                                        {{ $verification->identity_type }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-slate-400">
                                        @if ($verification->identity_number)
                                            ••••••••{{ substr($verification->identity_number, -4) }}
                                        @else
                                            -
                                        @endif
                                    </p>

                                </div>

                            </td>

                            {{-- BANK --}}
                            <td class="px-5 py-4">

                                <div class="min-w-[180px]">

                                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                                        {{ $verification->bank_name }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-slate-400">
                                        {{ $verification->bank_account_name }}
                                    </p>

                                </div>

                            </td>

                            {{-- STATUS --}}
                            <td class="px-5 py-4">

                                @if ($verification->status === 'pending')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1.5 text-[9px] font-bold text-amber-700 dark:bg-amber-950/30 dark:text-amber-300">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        <i class="bi bi-hourglass-split"></i>
                                        Menunggu
                                    </span>

                                @elseif ($verification->status === 'verified')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1.5 text-[9px] font-bold text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        <i class="bi bi-patch-check-fill"></i>
                                        Terverifikasi
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1.5 text-[9px] font-bold text-red-700 dark:bg-red-950/30 dark:text-red-300">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        <i class="bi bi-x-circle-fill"></i>
                                        Ditolak
                                    </span>

                                @endif

                            </td>

                            {{-- DATE --}}
                            <td class="px-5 py-4">

                                <p class="whitespace-nowrap text-[10px] font-medium text-slate-600 dark:text-slate-300">
                                    {{ $verification->submitted_at?->format('d M Y') ?? '-' }}
                                </p>

                                @if ($verification->submitted_at)
                                    <p class="mt-1 whitespace-nowrap text-[9px] text-slate-400">
                                        {{ $verification->submitted_at->format('H:i') }}
                                    </p>
                                @endif

                            </td>

                            {{-- ACTION --}}
                            <td class="px-5 py-4">

                                <div class="flex justify-end">

                                    <a
                                        href="{{ route('admin.verifications.show', $verification) }}"
                                        class="inline-flex h-9 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-[10px] font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-900 dark:hover:bg-blue-950/20 dark:hover:text-blue-400"
                                    >
                                        <i class="bi bi-eye"></i>
                                        Detail
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-950/30 dark:text-blue-400">
                                    <i class="bi bi-shield-check text-2xl"></i>
                                </div>

                                <h3 class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-200">
                                    Belum ada pengajuan verifikasi
                                </h3>

                                <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-slate-400 dark:text-slate-500">
                                    Pengajuan dari freelancer akan muncul di halaman ini.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if ($verifications->hasPages())
            <div class="border-t border-slate-100 px-5 py-4 dark:border-slate-800 sm:px-6">
                {{ $verifications->links() }}
            </div>
        @endif

    </section>

    {{-- =========================================================
         MOBILE CARDS
    ========================================================== --}}
    <div class="space-y-4 lg:hidden">

        @forelse ($verifications as $verification)

            @php
                $user = $verification->freelancerProfile?->user;
                $freelancerProfile = $verification->freelancerProfile;
                $avatar = $freelancerProfile?->avatar;

                $avatarUrl = null;

                if ($avatar) {
                    $avatarUrl =
                        str_starts_with($avatar, 'http://')
                        || str_starts_with($avatar, 'https://')
                        ? $avatar
                        : asset('storage/' . ltrim($avatar, '/'));
                }

                $displayName = $user?->name ?? $verification->full_name ?? 'Freelancer';

                $initials = collect(explode(' ', trim($displayName)))
                    ->filter()
                    ->take(2)
                    ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                    ->implode('');
            @endphp

            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                {{-- TOP PROFILE --}}
                <div class="p-4">

                    <div class="flex items-start justify-between gap-3">

                        <div class="flex min-w-0 items-center gap-3">

                            <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border border-slate-200 bg-blue-50 dark:border-slate-700 dark:bg-blue-950/30">

                                @if ($avatarUrl)

                                    <img
                                        src="{{ $avatarUrl }}"
                                        alt="{{ $displayName }}"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center text-xs font-bold text-blue-600 dark:text-blue-400">
                                        {{ $initials ?: 'FR' }}
                                    </div>

                                @endif

                            </div>

                            <div class="min-w-0">

                                <p class="truncate text-xs font-bold text-slate-800 dark:text-slate-200">
                                    {{ $displayName }}
                                </p>

                                <p class="mt-1 truncate text-[10px] text-slate-400">
                                    {{ $user?->email ?? '-' }}
                                </p>

                            </div>

                        </div>

                        {{-- STATUS --}}
                        @if ($verification->status === 'pending')

                            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1.5 text-[9px] font-bold text-amber-700 dark:bg-amber-950/30 dark:text-amber-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                Menunggu
                            </span>

                        @elseif ($verification->status === 'verified')

                            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1.5 text-[9px] font-bold text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Terverifikasi
                            </span>

                        @else

                            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1.5 text-[9px] font-bold text-red-700 dark:bg-red-950/30 dark:text-red-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                Ditolak
                            </span>

                        @endif

                    </div>

                    {{-- IDENTITAS --}}
                    <div class="mt-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                                <i class="bi bi-person-vcard text-sm"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                    Identitas
                                </p>

                                <p class="mt-1 text-xs font-bold text-slate-700 dark:text-slate-200">
                                    {{ $verification->identity_type }}
                                </p>

                                <p class="mt-1 text-[10px] text-slate-400">
                                    @if ($verification->identity_number)
                                        ••••••••{{ substr($verification->identity_number, -4) }}
                                    @else
                                        Nomor identitas tidak tersedia
                                    @endif
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- BANK --}}
                    <div class="mt-3 rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm dark:bg-slate-900 dark:text-blue-400">
                                <i class="bi bi-bank2 text-sm"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                    Rekening Bank
                                </p>

                                <p class="mt-1 text-xs font-bold text-slate-700 dark:text-slate-200">
                                    {{ $verification->bank_name }}
                                </p>

                                <p class="mt-1 truncate text-[10px] text-slate-400">
                                    {{ $verification->bank_account_name }}
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- DATE --}}
                    <div class="mt-3 flex items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950/50">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-slate-500 shadow-sm dark:bg-slate-900 dark:text-slate-400">
                                <i class="bi bi-calendar3 text-sm"></i>
                            </div>

                            <div>

                                <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                    Diajukan
                                </p>

                                <p class="mt-1 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    {{ $verification->submitted_at?->format('d M Y H:i') ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- ACTION --}}
                    <a
                        href="{{ route('admin.verifications.show', $verification) }}"
                        class="mt-3 inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-xs font-semibold !text-white shadow-sm shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/15"
                    >
                        <i class="bi bi-eye"></i>
                        Lihat Detail Verifikasi
                    </a>

                </div>

            </article>

        @empty

            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-14 text-center dark:border-slate-700 dark:bg-slate-900">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-950/30 dark:text-blue-400">
                    <i class="bi bi-shield-check text-2xl"></i>
                </div>

                <h3 class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-200">
                    Belum ada pengajuan verifikasi
                </h3>

                <p class="mt-1 text-xs leading-5 text-slate-400 dark:text-slate-500">
                    Pengajuan dari freelancer akan muncul di halaman ini.
                </p>

            </div>

        @endforelse

        {{-- PAGINATION MOBILE --}}
        @if ($verifications->hasPages())
            <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                {{ $verifications->links() }}
            </div>
        @endif

    </div>

</div>


</x-layouts.admin>
