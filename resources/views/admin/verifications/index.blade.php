<x-layouts.admin title="Verifikasi Freelancer">

    <div class="min-h-screen bg-[#F8FCF9] px-4 py-6 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-7xl">

            {{-- HEADER --}}
            <div class="mb-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                            Manajemen Freelancer
                        </p>

                        <h1 class="mt-1 text-2xl font-semibold tracking-tight text-[#123128]">
                            Verifikasi Freelancer
                        </h1>

                        <p class="mt-2 text-sm text-[#71837B]">
                            Periksa identitas dan rekening freelancer sebelum akun dinyatakan terverifikasi.
                        </p>
                    </div>

                </div>
            </div>

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- SUMMARY --}}
            <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <div class="rounded-2xl border border-[#E2EBE5] bg-white p-5">
                    <p class="text-xs text-[#7C8B84]">
                        Semua Pengajuan
                    </p>

                    <p class="mt-2 text-2xl font-semibold text-[#123128]">
                        {{ $counts['all'] }}
                    </p>
                </div>

                <div class="rounded-2xl border border-amber-200 bg-white p-5">
                    <p class="text-xs text-[#7C8B84]">
                        Menunggu Review
                    </p>

                    <p class="mt-2 text-2xl font-semibold text-amber-600">
                        {{ $counts['pending'] }}
                    </p>
                </div>

                <div class="rounded-2xl border border-green-200 bg-white p-5">
                    <p class="text-xs text-[#7C8B84]">
                        Terverifikasi
                    </p>

                    <p class="mt-2 text-2xl font-semibold text-green-600">
                        {{ $counts['verified'] }}
                    </p>
                </div>

                <div class="rounded-2xl border border-red-200 bg-white p-5">
                    <p class="text-xs text-[#7C8B84]">
                        Ditolak
                    </p>

                    <p class="mt-2 text-2xl font-semibold text-red-600">
                        {{ $counts['rejected'] }}
                    </p>
                </div>

            </div>

            {{-- FILTER --}}
            <div class="mb-5 rounded-2xl border border-[#E2EBE5] bg-white p-4">

                <form
                    method="GET"
                    action="{{ route('admin.verifications.index') }}"
                    class="grid gap-3 md:grid-cols-[1fr_180px_auto]"
                >

                    <div class="relative">
                        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-[#94A39B]"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari nama freelancer atau email..."
                            class="h-11 w-full rounded-xl border border-[#DCE7E1] bg-white pl-11 pr-4 text-sm text-[#123128] outline-none focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10"
                        >
                    </div>

                    <select
                        name="status"
                        class="h-11 rounded-xl border border-[#DCE7E1] bg-white px-4 text-sm text-[#123128] outline-none focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10"
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

                    <button
                        type="submit"
                        class="h-11 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#0C5A31]"
                    >
                        Filter
                    </button>

                </form>

            </div>

            {{-- TABLE --}}
            <div class="overflow-hidden rounded-2xl border border-[#E2EBE5] bg-white">

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead class="border-b border-[#EAF0EC] bg-[#F8FCF9]">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-semibold text-[#6D7D75]">
                                    Freelancer
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-semibold text-[#6D7D75]">
                                    Identitas
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-semibold text-[#6D7D75]">
                                    Bank
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-semibold text-[#6D7D75]">
                                    Status
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-semibold text-[#6D7D75]">
                                    Diajukan
                                </th>

                                <th class="px-5 py-4 text-right text-xs font-semibold text-[#6D7D75]">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#EDF2EF]">

                            @forelse ($verifications as $verification)

                                @php
                                    $user = $verification->freelancerProfile?->user;
                                @endphp

                                <tr class="transition hover:bg-[#FBFDFC]">

                                    {{-- FREELANCER --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A]">
                                                {{ strtoupper(substr($user?->name ?? $verification->full_name, 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate font-semibold text-[#18382E]">
                                                    {{ $user?->name ?? $verification->full_name }}
                                                </p>

                                                <p class="truncate text-xs text-[#89968F]">
                                                    {{ $user?->email ?? '-' }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- IDENTITAS --}}
                                    <td class="px-5 py-4">

                                        <p class="font-medium text-[#30483F]">
                                            {{ $verification->identity_type }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#89968F]">
                                            ••••••••{{ substr($verification->identity_number, -4) }}
                                        </p>

                                    </td>

                                    {{-- BANK --}}
                                    <td class="px-5 py-4">

                                        <p class="font-medium text-[#30483F]">
                                            {{ $verification->bank_name }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#89968F]">
                                            {{ $verification->bank_account_name }}
                                        </p>

                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-5 py-4">

                                        @if ($verification->status === 'pending')

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">
                                                <i class="bi bi-hourglass-split"></i>
                                                Pending
                                            </span>

                                        @elseif ($verification->status === 'verified')

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700">
                                                <i class="bi bi-patch-check-fill"></i>
                                                Verified
                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">
                                                <i class="bi bi-x-circle-fill"></i>
                                                Rejected
                                            </span>

                                        @endif

                                    </td>

                                    {{-- DATE --}}
                                    <td class="px-5 py-4 text-xs text-[#7F8D86]">
                                        {{ $verification->submitted_at?->format('d M Y H:i') ?? '-' }}
                                    </td>

                                    {{-- ACTION --}}
                                    <td class="px-5 py-4 text-right">

                                        <a
                                            href="{{ route('admin.verifications.show', $verification) }}"
                                            class="inline-flex h-9 items-center gap-2 rounded-lg border border-[#DCE7E1] px-3 text-xs font-semibold text-[#466057] transition hover:border-[#BFD9C8] hover:bg-[#F4FAF6] hover:text-[#1E9E5A]"
                                        >
                                            <i class="bi bi-eye"></i>
                                            Detail
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="6"
                                        class="px-6 py-16 text-center"
                                    >
                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#F1F6F3] text-[#91A099]">
                                            <i class="bi bi-shield-check text-xl"></i>
                                        </div>

                                        <p class="mt-4 text-sm font-semibold text-[#30483F]">
                                            Belum ada pengajuan verifikasi
                                        </p>

                                        <p class="mt-1 text-xs text-[#89968F]">
                                            Pengajuan dari freelancer akan muncul di halaman ini.
                                        </p>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if ($verifications->hasPages())
                    <div class="border-t border-[#EAF0EC] px-5 py-4">
                        {{ $verifications->links() }}
                    </div>
                @endif

            </div>

        </div>

    </div>

</x-layouts.admin>