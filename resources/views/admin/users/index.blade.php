<x-layouts.admin title="Pengguna">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 transition-colors dark:border-[#263B31] dark:bg-[#111F18] sm:p-7">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#1E9E5A] dark:text-[#7AD8B5]">
                        <i class="bi bi-people"></i>
                        Marketplace
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] dark:text-[#E7F2EC] sm:text-3xl">
                        Pengguna
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-[#71837B] dark:text-[#9CB0A5]">
                        Kelola seluruh akun client, freelancer, dan admin yang terdaftar di JASAIN.
                    </p>
                </div>

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                    <i class="bi bi-people text-xl"></i>
                </div>

            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-5 transition-colors dark:border-[#263B31] dark:bg-[#111F18] sm:p-6">

            <form
                action="{{ route('admin.users.index') }}"
                method="GET"
                class="grid gap-3 md:grid-cols-[1fr_auto_auto]"
            >

                {{-- Search --}}
                <div class="relative">
                    <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#8A9B94]"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama atau email..."
                        class="w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] py-3 pl-11 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#E7F2EC] dark:placeholder:text-[#71877B] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
                    >
                </div>

                {{-- Role --}}
                <select
                    name="role"
                    class="rounded-xl border-[#D8E5DE] bg-white px-4 py-3 text-sm font-medium text-[#526960] outline-none transition focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#C4D4CC] dark:focus:border-[#4BAF78] dark:focus:ring-[#173B29]"
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

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                >
                    <i class="bi bi-search"></i>
                    Cari
                </button>

            </form>

        </div>

        {{-- User Table --}}
        <div class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white transition-colors dark:border-[#263B31] dark:bg-[#111F18]">

            {{-- Table Header --}}
            <div class="border-b border-[#E7EFEA] px-6 py-5 dark:border-[#263B31] sm:px-7">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-base font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            Daftar Pengguna
                        </h2>

                        <p class="mt-1 text-sm text-[#8A9B94] dark:text-[#71877B]">
                            {{ $users->total() }} pengguna ditemukan.
                        </p>
                    </div>

                    @if($search || $role)
                        <a
                            href="{{ route('admin.users.index') }}"
                            class="inline-flex w-fit items-center gap-2 rounded-lg px-3 py-2 text-xs font-semibold text-[#667D73] transition hover:bg-[#F3F8F5] hover:text-[#0F6B3A] dark:text-[#9CB0A5] dark:hover:bg-[#17271F] dark:hover:text-[#7AD8B5]"
                        >
                            <i class="bi bi-x-circle"></i>
                            Reset filter
                        </a>
                    @endif

                </div>
            </div>

            @if($users->count())

                {{-- Desktop Table --}}
                <div class="hidden overflow-x-auto md:block">
                    <table class="min-w-full">

                        <thead class="bg-[#F8FCF9] dark:bg-[#16251D]">
                            <tr class="border-b border-[#E7EFEA] dark:border-[#263B31]">

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-[#8A9B94] dark:text-[#71877B]">
                                    Pengguna
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-[#8A9B94] dark:text-[#71877B]">
                                    Role
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-[#8A9B94] dark:text-[#71877B]">
                                    Verifikasi
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-[#8A9B94] dark:text-[#71877B]">
                                    Bergabung
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-[#8A9B94] dark:text-[#71877B]">
                                    Aksi
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#E7EFEA] dark:divide-[#263B31]">

                            @foreach($users as $user)

                                <tr class="transition hover:bg-[#FBFDFC] dark:hover:bg-[#16251D]">

                                    {{-- User --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A] dark:bg-[#1C402C] dark:text-[#7AD8B5]">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">
                                                <p class="truncate text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                                    {{ $user->name }}
                                                </p>

                                                <p class="mt-0.5 truncate text-xs text-[#8A9B94] dark:text-[#71877B]">
                                                    {{ $user->email }}
                                                </p>
                                            </div>

                                        </div>
                                    </td>

                                    {{-- Role --}}
                                    <td class="px-6 py-4">
                                        @if($user->role === 'admin')
                                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#173B29] px-2.5 py-1.5 text-xs font-semibold text-[#7AD8B5]">
                                                <i class="bi bi-shield-check"></i>
                                                Admin
                                            </span>
                                        @elseif($user->role === 'freelancer')
                                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#EAF7EF] px-2.5 py-1.5 text-xs font-semibold text-[#17663D] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                                                <i class="bi bi-briefcase"></i>
                                                Freelancer
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#F3F8F5] px-2.5 py-1.5 text-xs font-semibold text-[#667D73] dark:bg-[#1A2B22] dark:text-[#B3C4BC]">
                                                <i class="bi bi-person"></i>
                                                Client
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Verification --}}
                                    <td class="px-6 py-4">
                                        @if($user->email_verified_at)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#17663D] dark:text-[#7AD8B5]">
                                                <i class="bi bi-check-circle-fill"></i>
                                                Terverifikasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-[#9A6700]">
                                                <i class="bi bi-clock"></i>
                                                Belum terverifikasi
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Date --}}
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-[#667D73] dark:text-[#A9BBB2]">
                                            {{ $user->created_at?->format('d M Y') ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-6 py-4 text-right">
                                        <a
                                            href="{{ route('admin.users.show', $user) }}"
                                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#D8E5DE] bg-white px-3.5 py-2 text-xs font-semibold text-[#526960] transition hover:border-[#BFE7CF] hover:bg-[#EAF7EF] hover:text-[#0F6B3A] dark:border-[#2B4337] dark:bg-[#16251D] dark:text-[#B3C4BC] dark:hover:border-[#365747] dark:hover:bg-[#1A3025] dark:hover:text-[#7AD8B5]"
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

                {{-- Mobile List --}}
                <div class="divide-y divide-[#E7EFEA] dark:divide-[#263B31] md:hidden">

                    @foreach($users as $user)

                        <a
                            href="{{ route('admin.users.show', $user) }}"
                            class="block p-5 transition hover:bg-[#FBFDFC] dark:hover:bg-[#16251D]"
                        >

                            <div class="flex items-center gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#0F6B3A] dark:bg-[#1C402C] dark:text-[#7AD8B5]">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>

                                <div class="min-w-0 flex-1">

                                    <div class="flex items-center gap-2">
                                        <p class="truncate text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                            {{ $user->name }}
                                        </p>
                                    </div>

                                    <p class="mt-0.5 truncate text-xs text-[#8A9B94] dark:text-[#71877B]">
                                        {{ $user->email }}
                                    </p>

                                </div>

                                <i class="bi bi-chevron-right text-[#A2B2AA] dark:text-[#60756A]"></i>

                            </div>

                            <div class="mt-4 flex flex-wrap items-center gap-2">

                                @if($user->role === 'admin')
                                    <span class="rounded-lg bg-[#173B29] px-2.5 py-1 text-xs font-semibold text-[#7AD8B5]">
                                        Admin
                                    </span>
                                @elseif($user->role === 'freelancer')
                                    <span class="rounded-lg bg-[#EAF7EF] px-2.5 py-1 text-xs font-semibold text-[#17663D] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                                        Freelancer
                                    </span>
                                @else
                                    <span class="rounded-lg bg-[#F3F8F5] px-2.5 py-1 text-xs font-semibold text-[#667D73] dark:bg-[#1A2B22] dark:text-[#B3C4BC]">
                                        Client
                                    </span>
                                @endif

                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-[#17663D] dark:text-[#7AD8B5]">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-[#9A6700]">
                                        <i class="bi bi-clock"></i>
                                        Belum terverifikasi
                                    </span>
                                @endif

                            </div>

                        </a>

                    @endforeach

                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                    <div class="border-t border-[#E7EFEA] px-6 py-4 dark:border-[#263B31] sm:px-7">
                        {{ $users->links() }}
                    </div>
                @endif

            @else

                {{-- Empty State --}}
                <div class="px-6 py-16 text-center sm:px-8">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                        <i class="bi bi-people text-2xl"></i>
                    </div>

                    <h3 class="mt-5 text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                        Pengguna tidak ditemukan
                    </h3>

                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-[#8A9B94] dark:text-[#71877B]">
                        Tidak ada pengguna yang sesuai dengan pencarian atau filter yang dipilih.
                    </p>

                    @if($search || $role)
                        <a
                            href="{{ route('admin.users.index') }}"
                            class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                        >
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Reset Filter
                        </a>
                    @endif

                </div>

            @endif

        </div>

    </div>

</x-layouts.admin>