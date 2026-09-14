<x-layouts.freelancer title="Ajukan Penarikan">

    <div class="mx-auto max-w-3xl space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                        <i class="bi bi-arrow-down-circle"></i>
                        Keuangan
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        Ajukan Penarikan
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-[#71837B]">
                        Masukkan nominal dan tujuan penarikan saldo.
                    </p>
                </div>

                <a
                    href="{{ route('freelancer.withdrawals.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E5DE] bg-white px-5 py-2.5 text-sm font-semibold text-[#526960] transition hover:border-[#BFE7CF] hover:bg-[#F8FCF9] hover:text-[#123128]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

            </div>
        </div>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="rounded-xl border border-[#F2D0D0] bg-[#FEF0F0] p-4 sm:p-5">
                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#B42318]">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-[#B42318]">
                            Periksa kembali data pengajuan.
                        </p>

                        <ul class="mt-2 space-y-1 text-sm text-[#A64A43]">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endif

        {{-- Balance --}}
        <div class="rounded-2xl bg-[#0F6B3A] p-6 text-white sm:p-7">
            <div class="flex items-start justify-between gap-5">

                <div>
                    <p class="text-sm text-[#D9F3E3]">
                        Saldo Tersedia
                    </p>

                    <p class="mt-2 text-3xl font-semibold tracking-tight">
                        Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                    </p>

                    <p class="mt-2 text-sm text-[#D9F3E3]">
                        Minimal penarikan Rp 10.000
                    </p>
                </div>

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/10">
                    <i class="bi bi-wallet2 text-xl"></i>
                </div>

            </div>
        </div>

        {{-- Form --}}
        <div class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white">

            {{-- Form Header --}}
            <div class="border-b border-[#E7EFEA] px-6 py-5 sm:px-7">
                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-bank"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Detail Penarikan
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Lengkapi informasi rekening atau e-wallet tujuan.
                        </p>
                    </div>

                </div>
            </div>

            <form
                action="{{ route('freelancer.withdrawals.store') }}"
                method="POST"
                class="space-y-6 p-6 sm:p-7"
            >
                @csrf

                {{-- Amount --}}
                <div>
                    <label
                        for="amount"
                        class="block text-sm font-semibold text-[#345047]"
                    >
                        Nominal Penarikan
                    </label>

                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-[#71837B]">
                            Rp
                        </span>

                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            value="{{ old('amount') }}"
                            min="10000"
                            max="{{ $wallet->balance }}"
                            step="1000"
                            placeholder="10000"
                            class="w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] py-3.5 pl-12 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                            required
                        >
                    </div>

                    <div class="mt-2 flex flex-col gap-1 text-xs text-[#8A9B94] sm:flex-row sm:items-center sm:justify-between">
                        <span>
                            Minimal Rp 10.000
                        </span>

                        <span>
                            Maksimal Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                        </span>
                    </div>

                    @error('amount')
                        <p class="mt-2 text-sm text-[#B42318]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Method --}}
                <div>
                    <label
                        for="method"
                        class="block text-sm font-semibold text-[#345047]"
                    >
                        Metode Penarikan
                    </label>

                    <select
                        id="method"
                        name="method"
                        class="mt-2 w-full rounded-xl border-[#D8E5DE] bg-white px-4 py-3.5 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                        required
                    >
                        <option value="">
                            Pilih metode
                        </option>

                        <option
                            value="BCA"
                            {{ old('method') === 'BCA' ? 'selected' : '' }}
                        >
                            Bank BCA
                        </option>

                        <option
                            value="BRI"
                            {{ old('method') === 'BRI' ? 'selected' : '' }}
                        >
                            Bank BRI
                        </option>

                        <option
                            value="BNI"
                            {{ old('method') === 'BNI' ? 'selected' : '' }}
                        >
                            Bank BNI
                        </option>

                        <option
                            value="Mandiri"
                            {{ old('method') === 'Mandiri' ? 'selected' : '' }}
                        >
                            Bank Mandiri
                        </option>

                        <option
                            value="BSI"
                            {{ old('method') === 'BSI' ? 'selected' : '' }}
                        >
                            Bank BSI
                        </option>

                        <option
                            value="DANA"
                            {{ old('method') === 'DANA' ? 'selected' : '' }}
                        >
                            DANA
                        </option>

                        <option
                            value="OVO"
                            {{ old('method') === 'OVO' ? 'selected' : '' }}
                        >
                            OVO
                        </option>

                        <option
                            value="GoPay"
                            {{ old('method') === 'GoPay' ? 'selected' : '' }}
                        >
                            GoPay
                        </option>
                    </select>

                    @error('method')
                        <p class="mt-2 text-sm text-[#B42318]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Account Name --}}
                <div>
                    <label
                        for="account_name"
                        class="block text-sm font-semibold text-[#345047]"
                    >
                        Nama Pemilik Rekening / E-Wallet
                    </label>

                    <input
                        type="text"
                        id="account_name"
                        name="account_name"
                        value="{{ old('account_name') }}"
                        placeholder="Contoh: Nadia Creative"
                        class="mt-2 w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                        required
                    >

                    @error('account_name')
                        <p class="mt-2 text-sm text-[#B42318]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Account Number --}}
                <div>
                    <label
                        for="account_number"
                        class="block text-sm font-semibold text-[#345047]"
                    >
                        Nomor Rekening / Nomor E-Wallet
                    </label>

                    <input
                        type="text"
                        id="account_number"
                        name="account_number"
                        value="{{ old('account_number') }}"
                        placeholder="Contoh: 1234567890"
                        class="mt-2 w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                        required
                    >

                    @error('account_number')
                        <p class="mt-2 text-sm text-[#B42318]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Note --}}
                <div>
                    <label
                        for="note"
                        class="block text-sm font-semibold text-[#345047]"
                    >
                        Catatan
                        <span class="font-normal text-[#8A9B94]">
                            (opsional)
                        </span>
                    </label>

                    <textarea
                        id="note"
                        name="note"
                        rows="4"
                        placeholder="Tambahkan catatan jika diperlukan..."
                        class="mt-2 w-full resize-none rounded-xl border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                    >{{ old('note') }}</textarea>

                    @error('note')
                        <p class="mt-2 text-sm text-[#B42318]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Summary --}}
                <div class="rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-5">

                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-[#0F6B3A]">
                            <i class="bi bi-calculator"></i>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-[#123128]">
                                Ringkasan Penarikan
                            </p>

                            <p class="mt-0.5 text-xs text-[#8A9B94]">
                                Perkiraan dana yang akan diproses.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 space-y-4">

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-[#71837B]">
                                Nominal yang diajukan
                            </span>

                            <span class="text-sm font-semibold text-[#123128]">
                                Rp <span id="withdrawal-summary">0</span>
                            </span>
                        </div>

                        <div class="border-t border-[#DCE9E2] pt-4">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-sm font-semibold text-[#345047]">
                                    Dana diterima
                                </span>

                                <span class="text-base font-semibold text-[#0F6B3A]">
                                    Rp <span id="withdrawal-net">0</span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Action --}}
                <div class="flex flex-col-reverse gap-3 border-t border-[#E7EFEA] pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('freelancer.withdrawals.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E5DE] bg-white px-5 py-3 text-sm font-semibold text-[#526960] transition hover:bg-[#F8FCF9] hover:text-[#123128]"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                    >
                        <i class="bi bi-send"></i>
                        Ajukan Penarikan
                    </button>

                </div>

            </form>
        </div>

    </div>

    <script>
        const amountInput = document.getElementById('amount');
        const summary = document.getElementById('withdrawal-summary');
        const net = document.getElementById('withdrawal-net');

        function updateWithdrawalSummary() {
            const amount = Number(amountInput.value || 0);
            const formatted = new Intl.NumberFormat('id-ID').format(amount);

            summary.textContent = formatted;
            net.textContent = formatted;
        }

        amountInput.addEventListener('input', updateWithdrawalSummary);

        updateWithdrawalSummary();
    </script>

</x-layouts.freelancer>