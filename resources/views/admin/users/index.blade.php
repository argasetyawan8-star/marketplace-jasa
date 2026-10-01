<x-layouts.admin title="Pengguna">


<div class="mx-auto max-w-7xl space-y-5 sm:space-y-6">

    {{-- ==========================================================
         HEADER
    =========================================================== --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900 sm:p-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">
                <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-blue-600 dark:text-blue-400">
                    <i class="bi bi-people"></i>
                    Marketplace
                </div>

                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                    Pengguna
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Kelola seluruh akun client, freelancer, dan admin yang terdaftar di ProKerja.
                </p>
            </div>

            <div class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 sm:flex">
                <i class="bi bi-people text-xl"></i>
            </div>

        </div>

    </section>


    {{-- ==========================================================
         SEARCH & FILTER
    =========================================================== --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">

        <form
            action="{{ route('admin.users.index') }}"
            method="GET"
            class="grid gap-3 md:grid-cols-[minmax(0,1fr)_auto_auto]"
        >

            {{-- Search --}}
            <div class="relative min-w-0">
                <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama atau email..."
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-blue-500 dark:focus:bg-slate-800"
                >
            </div>


            {{-- Role --}}
            <select
                name="role"
                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:border-blue-500 sm:w-auto"
            >
                <option value="">Semua Role</option>

                <option value="client" {{ $role === 'client' ? 'selected' : '' }}>
                    Client
                </option>

                <option value="freelancer" {{ $role === 'freelancer' ? 'selected' : '' }}>
                    Freelancer
                </option>

                <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
            </select>


            {{-- Search Button --}}
            <button
                type="submit"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold !text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20"
            >
                <i class="bi bi-search"></i>
                Cari
            </button>

        </form>

    </section>


    {{-- ==========================================================
         USER TABLE / LIST
    =========================================================== --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-900">

        {{-- Table Header --}}
        <div class="border-b border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-6 sm:py-5">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">
                            Daftar Pengguna
                        </h2>

                        <span class="rounded-md bg-blue-50 px-2 py-1 text-[11px] font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                            {{ number_format($users->total()) }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Pengguna yang terdaftar di platform.
                    </p>
                </div>


                @if($search || $role)

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="inline-flex w-fit items-center gap-2 rounded-lg px-3 py-2 text-xs font-semibold text-slate-500 transition hover:bg-blue-50 hover:text-blue-600 dark:text-slate-400 dark:hover:bg-blue-500/10 dark:hover:text-blue-400"
                    >
                        <i class="bi bi-x-circle"></i>
                        Reset filter
                    </a>

                @endif

            </div>

        </div>


        @if($users->count())

            {{-- ==================================================
                 DESKTOP TABLE
            =================================================== --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full">

                    <thead class="bg-slate-50 dark:bg-slate-800/70">

                        <tr class="border-b border-slate-100 dark:border-slate-800">

                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Pengguna
                            </th>

                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Role
                            </th>

                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Verifikasi
                            </th>

                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Bergabung
                            </th>

                            <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                        @foreach($users as $user)

                            <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/50">

                                {{-- User --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">
                                                {{ $user->name }}
                                            </p>

                                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                                {{ $user->email }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Role --}}
                                <td class="px-6 py-4">

                                    @if($user->role === 'admin')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-2.5 py-1.5 text-xs font-semibold !text-white">
                                            <i class="bi bi-shield-check"></i>
                                            Admin
                                        </span>

                                    @elseif($user->role === 'freelancer')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                            <i class="bi bi-briefcase"></i>
                                            Freelancer
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                            <i class="bi bi-person"></i>
                                            Client
                                        </span>

                                    @endif

                                </td>


                                {{-- Verification --}}
                                <td class="px-6 py-4">

                                    @if($user->email_verified_at)

                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Terverifikasi
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-amber-600 dark:text-amber-400">
                                            <i class="bi bi-clock"></i>
                                            Belum terverifikasi
                                        </span>

                                    @endif

                                </td>


                                {{-- Date --}}
                                <td class="px-6 py-4">

                                    <span class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $user->created_at?->format('d M Y') ?? '-' }}
                                    </span>

                                </td>


                                {{-- Action --}}
                                <td class="px-6 py-4 text-right">

                                    <a
                                        href="{{ route('admin.users.show', $user) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-blue-500/30 dark:hover:bg-blue-500/10 dark:hover:text-blue-400"
                                    >
                                        Detail
                                        <i class="bi bi-chevron-right"></i>
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- ==================================================
                 MOBILE LIST
            =================================================== --}}
            <div class="divide-y divide-slate-100 md:hidden dark:divide-slate-800">

                @foreach($users as $user)

                    <a
                        href="{{ route('admin.users.show', $user) }}"
                        class="block p-4 transition active:bg-slate-50 dark:active:bg-slate-800/60"
                    >

                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>


                            <div class="min-w-0 flex-1">

                                <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">
                                    {{ $user->name }}
                                </p>

                                <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                    {{ $user->email }}
                                </p>

                            </div>

                            <i class="bi bi-chevron-right shrink-0 text-slate-300 dark:text-slate-600"></i>

                        </div>


                        <div class="mt-4 flex flex-wrap items-center gap-2">

                            {{-- Role --}}
                            @if($user->role === 'admin')

                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-2.5 py-1 text-xs font-semibold !text-white">
                                    <i class="bi bi-shield-check"></i>
                                    Admin
                                </span>

                            @elseif($user->role === 'freelancer')

                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                    <i class="bi bi-briefcase"></i>
                                    Freelancer
                                </span>

                            @else

                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    <i class="bi bi-person"></i>
                                    Client
                                </span>

                            @endif


                            {{-- Verification --}}
                            @if($user->email_verified_at)

                                <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Terverifikasi
                                </span>

                            @else

                                <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-600 dark:text-amber-400">
                                    <i class="bi bi-clock"></i>
                                    Belum terverifikasi
                                </span>

                            @endif

                        </div>


                        <div class="mt-3 flex items-center justify-between text-[11px] text-slate-400 dark:text-slate-500">

                            <span>
                                Bergabung
                            </span>

                            <span class="font-medium text-slate-500 dark:text-slate-400">
                                {{ $user->created_at?->format('d M Y') ?? '-' }}
                            </span>

                        </div>

                    </a>

                @endforeach

            </div>


            {{-- ==================================================
                 PAGINATION
            =================================================== --}}
            @if($users->hasPages())

                <div class="border-t border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-6">
                    {{ $users->links() }}
                </div>

            @endif

        @else

            {{-- ==================================================
                 EMPTY STATE
            =================================================== --}}
            <div class="px-5 py-16 text-center sm:px-8">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="bi bi-people text-2xl"></i>
                </div>

                <h3 class="mt-5 text-sm font-bold text-slate-900 dark:text-white">
                    Pengguna tidak ditemukan
                </h3>

                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Tidak ada pengguna yang sesuai dengan pencarian atau filter yang dipilih.
                </p>


                @if($search || $role)

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold !text-white transition hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/20"
                    >
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Filter
                    </a>

                @endif

            </div>

        @endif

    </section>

</div>


</x-layouts.admin>
