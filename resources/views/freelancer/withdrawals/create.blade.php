<x-layouts.freelancer title="Ajukan Penarikan">


<div class="min-h-screen bg-slate-50/70">
    <div class="mx-auto w-full max-w-4xl px-3.5 py-4 pb-24 sm:px-5 sm:py-6 lg:px-8 lg:py-8">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <section class="mb-5 sm:mb-6">

            <div class="flex items-start justify-between gap-3">

                <div class="flex min-w-0 items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 ring-1 ring-blue-100 sm:h-11 sm:w-11 sm:rounded-2xl">
                        <i class="bi bi-arrow-down-circle text-base sm:text-lg"></i>
                    </div>

                    <div class="min-w-0">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-blue-600 sm:text-[10px]">
                            Keuangan
                        </p>

                        <h1 class="mt-0.5 text-xl font-bold tracking-[-0.03em] text-slate-900 sm:text-2xl lg:text-3xl">
                            Ajukan Penarikan
                        </h1>

                        <p class="mt-1 hidden text-sm leading-6 text-slate-500 sm:block">
                            Masukkan nominal dan tujuan penarikan saldo kamu.
                        </p>

                    </div>

                </div>

                <a
                    href="{{ route('freelancer.withdrawals.index') }}"
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 sm:h-10 sm:w-auto sm:gap-2 sm:px-4 sm:text-sm sm:font-semibold"
                    aria-label="Kembali ke penarikan"
                >
                    <i class="bi bi-arrow-left text-xs"></i>
                    <span class="hidden sm:inline">Kembali</span>
                </a>

            </div>

        </section>

        {{-- =========================================================
            ERRORS
        ========================================================== --}}
        @if ($errors->any())

            <section class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3.5 sm:mb-5 sm:px-5">

                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm ring-1 ring-red-100">
                        <i class="bi bi-exclamation-circle-fill text-sm"></i>
                    </div>

                    <div class="min-w-0">

                        <p class="text-xs font-bold text-red-900 sm:text-sm">
                            Periksa kembali data pengajuan.
                        </p>

                        <ul class="mt-2 space-y-1 text-[11px] leading-5 text-red-700 sm:text-sm">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-2">
                                    <span class="mt-[7px] h-1 w-1 shrink-0 rounded-full bg-red-500"></span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>

                    </div>

                </div>

            </section>

        @endif

        {{-- =========================================================
            AVAILABLE BALANCE
        ========================================================== --}}
        <section class="relative overflow-hidden rounded-[22px] bg-blue-600 px-5 py-5 text-white shadow-[0_10px_30px_rgba(37,99,235,0.16)] sm:rounded-3xl sm:p-6 lg:p-7">

            <div class="pointer-events-none absolute -right-12 -top-12 h-36 w-36 rounded-full border border-white/10"></div>
            <div class="pointer-events-none absolute -bottom-16 right-8 h-28 w-28 rounded-full border border-white/10"></div>

            <div class="relative">

                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">

                        <p class="text-xs font-medium text-blue-100 sm:text-sm">
                            Saldo tersedia
                        </p>

                        <p class="mt-2 break-words text-[26px] font-bold leading-tight tracking-[-0.035em] sm:text-3xl lg:text-[34px]">
                            Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                        </p>

                        <p class="mt-1.5 text-[10px] leading-5 text-blue-100 sm:text-xs">
                            Minimal penarikan Rp 10.000
                        </p>

                    </div>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10 sm:h-12 sm:w-12 sm:rounded-2xl">
                        <i class="bi bi-wallet2 text-base sm:text-xl"></i>
                    </div>

                </div>

            </div>

        </section>

        {{-- =========================================================
            FORM
        ========================================================== --}}
        <section class="mt-4 overflow-hidden rounded-[22px] border border-slate-200 bg-white shadow-[0_8px_28px_rgba(15,23,42,0.035)] sm:mt-5 sm:rounded-3xl">

            {{-- Form Header --}}
            <div class="border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5 lg:px-7">

                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-10 sm:w-10">
                        <i class="bi bi-bank text-sm sm:text-base"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-sm font-bold tracking-[-0.02em] text-slate-900 sm:text-base lg:text-lg">
                            Detail Penarikan
                        </h2>

                        <p class="mt-0.5 text-[10px] leading-4 text-slate-400 sm:text-xs sm:leading-5">
                            Lengkapi informasi rekening atau e-wallet tujuan.
                        </p>

                    </div>

                </div>

            </div>

            <form
                action="{{ route('freelancer.withdrawals.store') }}"
                method="POST"
                class="divide-y divide-slate-100"
            >
                @csrf

                {{-- =================================================
                    FORM FIELDS
                ================================================== --}}
                <div class="space-y-5 px-4 py-5 sm:space-y-6 sm:px-6 sm:py-6 lg:px-7 lg:py-7">

                    {{-- =================================================
                        AMOUNT
                    ================================================== --}}
                    <div>

                        <label
                            for="amount"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Nominal penarikan
                        </label>

                        <div class="relative mt-2">

                            <span class="pointer-events-none absolute inset-y-0 left-0 flex w-12 items-center justify-center text-sm font-bold text-slate-500">
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
                                class="h-13 w-full rounded-xl border border-slate-200 bg-slate-50/70 py-3.5 pl-12 pr-4 text-base font-semibold text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50 sm:h-14 sm:text-sm"
                                required
                            >

                        </div>

                        <div class="mt-2 flex flex-col gap-1 text-[10px] leading-4 text-slate-400 sm:flex-row sm:items-center sm:justify-between sm:text-xs sm:leading-5">

                            <span>
                                Minimal Rp 10.000
                            </span>

                            <span>
                                Maksimal Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                            </span>

                        </div>

                        @error('amount')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- =================================================
                        METHOD
                    ================================================== --}}
                    <div>

                        <label
                            for="method"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Metode penarikan
                        </label>

                        <div class="relative mt-2">

                            <select
                                id="method"
                                name="method"
                                class="h-12 w-full appearance-none rounded-xl border border-slate-200 bg-slate-50/70 px-4 pr-11 text-sm text-slate-900 outline-none transition hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50"
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

                            <i class="bi bi-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>

                        </div>

                        @error('method')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- =================================================
                        ACCOUNT NAME
                    ================================================== --}}
                    <div>

                        <label
                            for="account_name"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Nama pemilik rekening / e-wallet
                        </label>

                        <input
                            type="text"
                            id="account_name"
                            name="account_name"
                            value="{{ old('account_name') }}"
                            placeholder="Contoh: Nadia Creative"
                            class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            required
                        >

                        @error('account_name')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- =================================================
                        ACCOUNT NUMBER
                    ================================================== --}}
                    <div>

                        <label
                            for="account_number"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Nomor rekening / nomor e-wallet
                        </label>

                        <input
                            type="text"
                            id="account_number"
                            name="account_number"
                            value="{{ old('account_number') }}"
                            inputmode="numeric"
                            placeholder="Contoh: 1234567890"
                            class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            required
                        >

                        @error('account_number')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- =================================================
                        NOTE
                    ================================================== --}}
                    <div>

                        <label
                            for="note"
                            class="block text-sm font-semibold text-slate-700"
                        >
                            Catatan
                            <span class="font-normal text-slate-400">
                                (opsional)
                            </span>
                        </label>

                        <textarea
                            id="note"
                            name="note"
                            rows="4"
                            placeholder="Tambahkan catatan jika diperlukan..."
                            class="mt-2 w-full resize-none rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-50"
                        >{{ old('note') }}</textarea>

                        @error('note')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                {{-- =================================================
                    SUMMARY
                ================================================== --}}
                <div class="bg-slate-50/70 px-4 py-5 sm:px-6 sm:py-6 lg:px-7">

                    <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-4 sm:p-5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm ring-1 ring-blue-100">
                                <i class="bi bi-calculator text-sm"></i>
                            </div>

                            <div class="min-w-0">

                                <p class="text-xs font-bold text-slate-800 sm:text-sm">
                                    Ringkasan Penarikan
                                </p>

                                <p class="mt-0.5 text-[10px] leading-4 text-slate-400 sm:text-xs sm:leading-5">
                                    Perkiraan dana yang akan diproses.
                                </p>

                            </div>

                        </div>

                        <div class="mt-4 space-y-3">

                            <div class="flex items-center justify-between gap-4">
                                <span class="text-[11px] text-slate-500 sm:text-sm">
                                    Nominal yang diajukan
                                </span>

                                <span class="shrink-0 text-xs font-semibold text-slate-800 sm:text-sm">
                                    Rp <span id="withdrawal-summary">0</span>
                                </span>
                            </div>

                            <div class="border-t border-blue-100 pt-3">

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs font-bold text-slate-700 sm:text-sm">
                                        Dana diterima
                                    </span>

                                    <span class="shrink-0 text-sm font-bold text-blue-600 sm:text-base">
                                        Rp <span id="withdrawal-net">0</span>
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- =================================================
                    ACTION
                ================================================== --}}
                <div class="bg-white px-4 py-4 sm:px-6 sm:py-5 lg:px-7">

                    <div class="flex flex-col-reverse gap-2.5 sm:flex-row sm:justify-end sm:gap-3">

                        <a
                            href="{{ route('freelancer.withdrawals.index') }}"
                            class="inline-flex h-11 w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50 sm:w-auto sm:text-sm"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-xs font-semibold !text-white shadow-[0_6px_18px_rgba(37,99,235,0.16)] transition hover:bg-blue-700 hover:shadow-[0_8px_24px_rgba(37,99,235,0.20)] active:scale-[0.99] sm:w-auto sm:px-6 sm:text-sm"
                        >
                            <i class="bi bi-send"></i>
                            Ajukan Penarikan
                        </button>

                    </div>

                </div>

            </form>

        </section>

        {{-- =========================================================
            MOBILE INFO
        ========================================================== --}}
        <section class="mt-4 flex items-start gap-3 px-1 sm:hidden">

            <i class="bi bi-shield-check mt-0.5 shrink-0 text-blue-500"></i>

            <p class="text-[10px] leading-5 text-slate-400">
                Pastikan nama pemilik dan nomor rekening sesuai dengan rekening atau e-wallet tujuan sebelum mengirim pengajuan.
            </p>

        </section>

    </div>
</div>

<script>
    const amountInput = document.getElementById('amount');
    const summary = document.getElementById('withdrawal-summary');
    const net = document.getElementById('withdrawal-net');

    function updateWithdrawalSummary() {
        if (!amountInput || !summary || !net) {
            return;
        }

        const amount = Number(amountInput.value || 0);
        const formatted = new Intl.NumberFormat('id-ID').format(amount);

        summary.textContent = formatted;
        net.textContent = formatted;
    }

    if (amountInput) {
        amountInput.addEventListener('input', updateWithdrawalSummary);
        updateWithdrawalSummary();
    }
</script>


</x-layouts.freelancer>
