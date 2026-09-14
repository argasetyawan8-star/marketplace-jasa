<x-layouts.admin title="Detail Penarikan">

    @php
        $statusMap = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-[#FEF3C7] text-[#92400E] border-[#F2D99B] dark:bg-[#48391E] dark:text-[#E8C67A] dark:border-[#665326]',
                'icon' => 'bi-hourglass-split',
            ],
            'processing' => [
                'label' => 'Diproses',
                'class' => 'bg-[#DBEAFE] text-[#1D4ED8] border-[#BFDBFE] dark:bg-[#243A59] dark:text-[#9CC4FF] dark:border-[#35547E]',
                'icon' => 'bi-arrow-repeat',
            ],
            'approved' => [
                'label' => 'Disetujui',
                'class' => 'bg-[#DCFCE7] text-[#166534] border-[#B8E6C8] dark:bg-[#244732] dark:text-[#A0E8B7] dark:border-[#315C43]',
                'icon' => 'bi-check-circle-fill',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'class' => 'bg-[#FEE2E2] text-[#991B1B] border-[#F2C5C5] dark:bg-[#492727] dark:text-[#F0A3A3] dark:border-[#6A3B3B]',
                'icon' => 'bi-x-circle-fill',
            ],
        ];

        $withdrawalStatus = $statusMap[$withdrawal->status] ?? [
            'label' => ucfirst(str_replace('_', ' ', $withdrawal->status ?? 'Unknown')),
            'class' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600',
            'icon' => 'bi-question-circle',
        ];

        $freelancer = $withdrawal->freelancerProfile;
        $freelancerUser = $freelancer?->user;
    @endphp


    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <a
                    href="{{ route('admin.withdrawals.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#1E9E5A] dark:text-[#93A89F] dark:hover:text-[#7AD8B5]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke penarikan
                </a>

                <div class="mt-4">

                    <div class="flex flex-wrap items-center gap-2">

                        <p class="text-sm font-medium text-[#1E9E5A] dark:text-[#7AD8B5]">
                            Detail Penarikan
                        </p>

                        <span class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $withdrawalStatus['class'] }}">
                            <i class="bi {{ $withdrawalStatus['icon'] }}"></i>
                            {{ $withdrawalStatus['label'] }}
                        </span>

                    </div>


                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] dark:text-white">
                        Penarikan #{{ $withdrawal->id }}
                    </h1>

                    <p class="mt-1 text-sm text-[#667D73] dark:text-[#A9BCB2]">
                        Pengajuan penarikan saldo freelancer.
                    </p>

                </div>

            </div>


            {{-- Amount --}}
            <div class="rounded-xl border border-[#D6E4DD] bg-white px-5 py-4 dark:border-[#2E473A] dark:bg-[#13221A]">

                <p class="text-[11px] font-medium uppercase tracking-wide text-[#71837B] dark:text-[#8FA59A]">
                    Net Amount
                </p>

                <p class="mt-1 text-2xl font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                    Rp {{ number_format((float) $withdrawal->net_amount, 0, ',', '.') }}
                </p>

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
                            Periksa kembali data
                        </p>

                        <ul class="mt-2 space-y-1 text-sm text-[#7F4B4B] dark:text-[#D0A7A7]">

                            @foreach ($errors->all() as $error)

                                <li>
                                    • {{ $error }}
                                </li>

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


                {{-- Freelancer --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Freelancer
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Pemilik saldo
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

                            @if ($freelancerUser?->email)

                                <p class="mt-0.5 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    {{ $freelancerUser->email }}
                                </p>

                            @endif

                            @if ($freelancer?->username)

                                <p class="mt-1 truncate text-xs text-[#71837B] dark:text-[#8FA59A]">
                                    {{ '@' . $freelancer->username }}
                                </p>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- Withdrawal Information --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-bank2"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Informasi Penarikan
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Detail rekening dan metode pencairan
                            </p>
                        </div>

                    </div>


                    <div class="mt-6 grid gap-5 sm:grid-cols-2">

                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Metode
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-white">
                                {{ strtoupper($withdrawal->method ?? '-') }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Nama Rekening
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $withdrawal->account_name ?: '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Nomor Rekening
                            </p>

                            <p class="mt-1 break-all text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $withdrawal->account_number ?: '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Diproses
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                {{ $withdrawal->processed_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Note --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-chat-square-text-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Catatan
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Informasi tambahan dari freelancer
                            </p>
                        </div>

                    </div>


                    <div class="mt-5 rounded-xl border border-[#D6E4DD] bg-[#F8FCF9] p-4 dark:border-[#3A5245] dark:bg-[#17271F]">

                        @if ($withdrawal->note)

                            <p class="whitespace-pre-line text-sm leading-7 text-[#536B60] dark:text-[#B7C7C0]">
                                {{ $withdrawal->note }}
                            </p>

                        @else

                            <p class="text-sm text-[#71837B] dark:text-[#8FA59A]">
                                Tidak ada catatan tambahan.
                            </p>

                        @endif

                    </div>

                </div>


                {{-- Rejection --}}
                @if ($withdrawal->rejection_reason)

                    <div class="rounded-2xl border border-[#F2C5C5] bg-[#FFF5F5] p-6 dark:border-[#6A3B3B] dark:bg-[#2A1919]">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#FDE8E8] text-[#C62828] dark:bg-[#4A2525] dark:text-[#F39A9A]">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-[#991B1B] dark:text-[#FFAAAA]">
                                    Alasan Penolakan
                                </p>

                                <p class="mt-1 whitespace-pre-line text-sm leading-6 text-[#7F4B4B] dark:text-[#D0A7A7]">
                                    {{ $withdrawal->rejection_reason }}
                                </p>

                            </div>

                        </div>

                    </div>

                @endif

            </div>


            {{-- Right --}}
            <div class="space-y-6">


                {{-- Financial Summary --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-calculator"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Rincian Nominal
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Perhitungan pencairan
                            </p>
                        </div>

                    </div>


                    <div class="mt-6 space-y-4">

                        <div class="flex items-center justify-between gap-4">

                            <span class="text-sm text-[#667D73] dark:text-[#A9BCB2]">
                                Pengajuan
                            </span>

                            <span class="text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                Rp {{ number_format((float) $withdrawal->amount, 0, ',', '.') }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-4">

                            <span class="text-sm text-[#667D73] dark:text-[#A9BCB2]">
                                Fee Admin
                            </span>

                            <span class="text-sm font-medium text-[#263F35] dark:text-[#D7E3DE]">
                                Rp {{ number_format((float) $withdrawal->admin_fee, 0, ',', '.') }}
                            </span>

                        </div>


                        <div class="border-t border-[#E1EBE6] pt-4 dark:border-[#294036]">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-sm font-semibold text-[#123128] dark:text-white">
                                    Net Amount
                                </span>

                                <span class="text-lg font-semibold text-[#1E9E5A] dark:text-[#7AD8B5]">
                                    Rp {{ number_format((float) $withdrawal->net_amount, 0, ',', '.') }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Processing --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-white p-6 dark:border-[#2E473A] dark:bg-[#13221A]">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A] dark:bg-[#234632] dark:text-[#7AD8B5]">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128] dark:text-white">
                                Proses Penarikan
                            </h2>

                            <p class="text-xs text-[#71837B] dark:text-[#8FA59A]">
                                Perbarui status pengajuan
                            </p>
                        </div>

                    </div>


                    <form
                        action="{{ route('admin.withdrawals.update', $withdrawal) }}"
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

                                <option value="pending" @selected(old('status', $withdrawal->status) === 'pending')>
                                    Menunggu
                                </option>

                                <option value="processing" @selected(old('status', $withdrawal->status) === 'processing')>
                                    Diproses
                                </option>

                                <option value="approved" @selected(old('status', $withdrawal->status) === 'approved')>
                                    Disetujui
                                </option>

                                <option value="rejected" @selected(old('status', $withdrawal->status) === 'rejected')>
                                    Ditolak
                                </option>

                            </select>

                        </div>


                        {{-- Rejection Reason --}}
                        <div>

                            <label
                                for="rejection_reason"
                                class="mb-2 block text-sm font-medium text-[#355247] dark:text-[#D0DED8]"
                            >
                                Alasan Penolakan
                                <span class="font-normal text-[#8A9B94]">
                                    (opsional)
                                </span>
                            </label>

                            <textarea
                                id="rejection_reason"
                                name="rejection_reason"
                                rows="4"
                                placeholder="Tulis alasan apabila pengajuan ditolak..."
                                class="w-full rounded-xl border border-[#BFCFC7] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition placeholder:text-[#95A79F] hover:border-[#AFC2B8] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF] dark:border-[#3A5245] dark:bg-[#16251D] dark:text-white dark:placeholder:text-[#789086] dark:hover:border-[#4C695B] dark:focus:border-[#7AD8B5] dark:focus:ring-[#214532]"
                            >{{ old('rejection_reason', $withdrawal->rejection_reason) }}</textarea>

                        </div>


                        {{-- Button --}}
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#17844A] focus:outline-none focus:ring-4 focus:ring-[#D8F3E2] dark:focus:ring-[#28533B]"
                        >
                            <i class="bi bi-check2-circle"></i>
                            Simpan Status
                        </button>

                    </form>

                </div>


                {{-- Warning --}}
                <div class="rounded-2xl border border-[#E8D8AE] bg-[#FFFBEE] p-6 dark:border-[#665326] dark:bg-[#302818]">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#A16207] shadow-sm dark:bg-[#3B321F] dark:text-[#E8C67A]">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#7C5810] dark:text-[#E8CA85]">
                                Perhatian
                            </p>

                            <p class="mt-1 text-sm leading-6 text-[#866D38] dark:text-[#C8B47E]">
                                Persetujuan penarikan di halaman ini adalah pencatatan status. Proses transfer dana ke rekening freelancer akan dihubungkan ke sistem pembayaran pada tahap integrasi berikutnya.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- System Information --}}
                <div class="rounded-2xl border border-[#D6E4DD] bg-[#F8FCF9] p-6 dark:border-[#2E473A] dark:bg-[#17271F]">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm dark:bg-[#1D3025] dark:text-[#7AD8B5]">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#123128] dark:text-white">
                                Informasi Sistem
                            </p>

                            <div class="mt-3 space-y-2 text-xs text-[#71837B] dark:text-[#8FA59A]">

                                <p>
                                    ID:
                                    <span class="font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                        #{{ $withdrawal->id }}
                                    </span>
                                </p>

                                <p>
                                    Dibuat:
                                    <span class="font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                        {{ $withdrawal->created_at?->format('d M Y, H:i') ?? '-' }}
                                    </span>
                                </p>

                                <p>
                                    Diperbarui:
                                    <span class="font-medium text-[#536B60] dark:text-[#B7C7C0]">
                                        {{ $withdrawal->updated_at?->format('d M Y, H:i') ?? '-' }}
                                    </span>
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-layouts.admin>