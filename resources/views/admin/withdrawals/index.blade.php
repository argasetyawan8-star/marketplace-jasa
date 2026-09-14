<x-layouts.admin title="Kelola Penarikan">

    @php
        $statusMap = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-[#FEF3C7] text-[#92400E] dark:bg-[#48391E] dark:text-[#E8C67A]',
                'icon' => 'bi-hourglass-split',
            ],
            'processing' => [
                'label' => 'Diproses',
                'class' => 'bg-[#DBEAFE] text-[#1D4ED8] dark:bg-[#243A59] dark:text-[#9CC4FF]',
                'icon' => 'bi-arrow-repeat',
            ],
            'approved' => [
                'label' => 'Disetujui',
                'class' => 'bg-[#DCFCE7] text-[#166534] dark:bg-[#244732] dark:text-[#A0E8B7]',
                'icon' => 'bi-check-circle-fill',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] dark:bg-[#492727] dark:text-[#F0A3A3]',
                'icon' => 'bi-x-circle-fill',
            ],
        ];
    @endphp

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>
                <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                    Keuangan
                </p>

                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                    Kelola Penarikan
                </h1>

                <p class="mt-1 max-w-2xl text-sm text-[#667D73] dark:text-[#A9BCB2]">
                    Kelola pengajuan penarikan saldo dari freelancer.
                </p>
            </div>

            <div class="rounded-xl border border-[#D6E4DD] bg-white px-4 py-3 dark:border-[#2E473A] dark:bg-[#13221A]">
                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                        <i class="bi bi-bank2"></i>
                    </div>

                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                            Total Pengajuan
                        </p>

                        <p class="mt-0.5 text-sm font-semibold text-[#123128] dark:text-white">
                            {{ $withdrawals->total() }}
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
                        Filter Penarikan
                    </h2>

                    <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                        Cari freelancer, metode, atau informasi rekening.
                    </p>
                </div>

            </div>


            <form
                action="{{ route('admin.withdrawals.index') }}"
                method="GET"
                class="grid gap-4 lg:grid-cols-[1fr_220px_auto]"
            >

                {{-- Search --}}
                <div>

                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                    >
                        Cari pengajuan
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
                            placeholder="Nama freelancer, rekening, metode..."
                            class="w-full rounded-xl border border-[#BFCFC7] bg-white py-3 pl-10 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#95A79F] hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:placeholder:text-[#789086] dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                        >

                    </div>

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

                        <option value="pending" @selected($status === 'pending')}>
                            Menunggu
                        </option>

                        <option value="processing" @selected($status === 'processing')}>
                            Diproses
                        </option>

                        <option value="approved" @selected($status === 'approved')}>
                            Disetujui
                        </option>

                        <option value="rejected" @selected($status === 'rejected')}>
                            Ditolak
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

                    @if ($search !== '' || $status)

                        <a
                            href="{{ route('admin.withdrawals.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm font-medium text-[#355247] transition hover:border-[#AFC2B8] hover:bg-[#F6FAF8] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-[#C4D2CC] dark:hover:border-[#4C695B] dark:hover:bg-[#1A3024]"
                        >
                            Reset
                        </a>

                    @endif

                </div>

            </form>

        </div>


        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-[#D6E4DD] bg-white dark:border-[#2E473A] dark:bg-[#13221A]">

            <div class="flex flex-col gap-2 border-b border-[#D6E4DD] px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-[#2E473A]">

                <div>
                    <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                        Daftar Penarikan
                    </h2>

                    <p class="mt-0.5 text-xs text-[#71837B] dark:text-[#8FA59A]">
                        Menampilkan {{ $withdrawals->firstItem() ?? 0 }}–{{ $withdrawals->lastItem() ?? 0 }}
                        dari {{ $withdrawals->total() }} pengajuan
                    </p>
                </div>

                <div class="hidden items-center gap-2 text-xs text-[#71837B] sm:flex dark:text-[#8FA59A]">
                    <i class="bi bi-shield-check text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                    Pemeriksaan penarikan
                </div>

            </div>


            {{-- Desktop --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full">

                    <thead>
                        <tr class="border-b border-[#D6E4DD] bg-[#F8FCF9] dark:border-[#2E473A] dark:bg-[#17271F]">

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Freelancer
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Metode
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Pengajuan
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#71837B] dark:text-[#9CB0A7]">
                                Net Amount
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

                        @forelse ($withdrawals as $withdrawal)

                            @php
                                $withdrawalStatus = $statusMap[$withdrawal->status] ?? [
                                    'label' => ucfirst(str_replace('_', ' ', $withdrawal->status ?? 'Unknown')),
                                    'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
                                    'icon' => 'bi-question-circle',
                                ];

                                $freelancer = $withdrawal->freelancerProfile;
                                $freelancerUser = $freelancer?->user;
                            @endphp

                            <tr class="transition hover:bg-[#F8FCF9] dark:hover:bg-[#17271F]">

                                {{-- Freelancer --}}
                                <td class="px-5 py-4">

                                    <div class="flex min-w-[210px] items-center gap-3">

                                        <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-[#D6E4DD] bg-[#EAF7EF] dark:border-[#2E473A] dark:bg-[#234632]">

                                            @if ($freelancer?->avatar)

                                                <img
                                                    src="{{ asset('storage/' . $freelancer->avatar) }}"
                                                    alt="{{ $freelancerUser?->name ?? 'Freelancer' }}"
                                                    class="h-full w-full object-cover"
                                                >

                                            @elseif ($freelancerUser)

                                                <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                                    {{ strtoupper(substr($freelancerUser->name, 0, 1)) }}
                                                </div>

                                            @else

                                                <div class="flex h-full w-full items-center justify-center">
                                                    <i class="bi bi-person text-[#1E9E5A] dark:text-[#7AD8B5]"></i>
                                                </div>

                                            @endif

                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-[#263F35] dark:text-[#D7E3DE]">
                                                {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                            </p>

                                            @if ($freelancerUser?->email)
                                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                                    {{ $freelancerUser->email }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Method --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[150px]">

                                        <p class="text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                            {{ strtoupper($withdrawal->method ?? '-') }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                            {{ $withdrawal->account_name ?: 'Nama rekening tidak tersedia' }}
                                        </p>

                                    </div>

                                </td>


                                {{-- Amount --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[140px]">

                                        <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                            Rp {{ number_format((float) $withdrawal->amount, 0, ',', '.') }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                            Fee: Rp {{ number_format((float) $withdrawal->admin_fee, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </td>


                                {{-- Net --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[140px]">

                                        <p class="text-sm font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                            Rp {{ number_format((float) $withdrawal->net_amount, 0, ',', '.') }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#71837B] dark:text-[#8FA59A]">
                                            Diterima freelancer
                                        </p>

                                    </div>

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $withdrawalStatus['class'] }}">
                                        <i class="bi {{ $withdrawalStatus['icon'] }}"></i>
                                        {{ $withdrawalStatus['label'] }}
                                    </span>

                                </td>


                                {{-- Action --}}
                                <td class="px-5 py-4">

                                    <div class="flex justify-end">

                                        <a
                                            href="{{ route('admin.withdrawals.show', $withdrawal) }}"
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
                                        <i class="bi bi-bank text-2xl"></i>
                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-[#123128] dark:text-white">
                                        Pengajuan belum ditemukan
                                    </h3>

                                    <p class="mx-auto mt-1 max-w-md text-sm text-[#71837B] dark:text-[#8FA59A]">
                                        Tidak ada pengajuan penarikan yang sesuai dengan pencarian atau filter.
                                    </p>

                                    @if ($search !== '' || $status)

                                        <a
                                            href="{{ route('admin.withdrawals.index') }}"
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

                @forelse ($withdrawals as $withdrawal)

                    @php
                        $withdrawalStatus = $statusMap[$withdrawal->status] ?? [
                            'label' => ucfirst(str_replace('_', ' ', $withdrawal->status ?? 'Unknown')),
                            'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
                            'icon' => 'bi-question-circle',
                        ];

                        $freelancer = $withdrawal->freelancerProfile;
                        $freelancerUser = $freelancer?->user;
                    @endphp

                    <div class="p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                                    {{ strtoupper(substr($freelancerUser?->name ?? 'F', 0, 1)) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-[#263F35] dark:text-[#D7E3DE]">
                                        {{ $freelancerUser?->name ?? 'Freelancer tidak tersedia' }}
                                    </p>

                                    <p class="mt-1 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                        {{ strtoupper($withdrawal->method ?? '-') }}
                                    </p>

                                </div>

                            </div>


                            <span class="inline-flex shrink-0 items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $withdrawalStatus['class'] }}">
                                <i class="bi {{ $withdrawalStatus['icon'] }}"></i>
                                {{ $withdrawalStatus['label'] }}
                            </span>

                        </div>


                        <div class="mt-4 grid grid-cols-2 gap-3">

                            <div class="rounded-xl bg-[#F8FCF9] p-3 dark:bg-[#17271F]">

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Pengajuan
                                </p>

                                <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                    Rp {{ number_format((float) $withdrawal->amount, 0, ',', '.') }}
                                </p>

                            </div>


                            <div class="rounded-xl bg-[#F8FCF9] p-3 dark:bg-[#17271F]">

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Net
                                </p>

                                <p class="mt-1 text-sm font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                    Rp {{ number_format((float) $withdrawal->net_amount, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>


                        <div class="mt-4 flex items-center justify-between gap-4 border-t border-[#E5EEE9] pt-4 dark:border-[#294036]">

                            <div class="min-w-0">

                                <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    Rekening
                                </p>

                                <p class="truncate text-sm text-[#355247] dark:text-[#D0DED8]">
                                    {{ $withdrawal->account_name ?: '-' }}
                                </p>

                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    {{ $withdrawal->account_number ?: '-' }}
                                </p>

                            </div>


                            <a
                                href="{{ route('admin.withdrawals.show', $withdrawal) }}"
                                class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-[#EAF7EF] px-4 py-2.5 text-sm font-semibold text-[#1E7045] transition hover:bg-[#DDF1E5] dark:bg-[#234632] dark:text-[#A4E5BA] dark:hover:bg-[#2B513B]"
                            >
                                <i class="bi bi-eye"></i>
                                Detail
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="px-6 py-14 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-bank text-2xl"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-semibold text-[#123128] dark:text-white">
                            Pengajuan belum ditemukan
                        </h3>

                        <p class="mt-1 text-sm text-[#71837B] dark:text-[#8FA59A]">
                            Belum ada pengajuan penarikan.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($withdrawals->hasPages())

                <div class="border-t border-[#D6E4DD] px-5 py-4 dark:border-[#2E473A]">
                    {{ $withdrawals->links() }}
                </div>

            @endif

        </div>

    </div>

</x-layouts.admin>