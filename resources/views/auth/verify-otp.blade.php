
<x-guest-layout>
    @section('title', 'Verifikasi OTP · ProKerja')

    @php
        /*
        |--------------------------------------------------------------------------
        | OTP DATA
        |--------------------------------------------------------------------------
        */

        $identifier = $identifier ?? session('prokerja_otp_identifier', '');
        $channel = $channel ?? session('prokerja_otp_channel', 'email');
        $purpose = $purpose ?? session('prokerja_otp_purpose', 'login');

        $cooldown = isset($cooldown)
            ? (int) $cooldown
            : 45;

        $lifetime = isset($lifetime)
            ? (int) $lifetime
            : 5;


        /*
        |--------------------------------------------------------------------------
        | CHANNEL LABEL
        |--------------------------------------------------------------------------
        */

        $channelLabel = match ($channel) {
            'phone' => 'WhatsApp / SMS',
            'email' => 'email',
            default => 'email',
        };


        /*
        |--------------------------------------------------------------------------
        | MASK IDENTIFIER
        |--------------------------------------------------------------------------
        */

        $maskedIdentifier = $identifier;

        if ($channel === 'email' && filter_var($identifier, FILTER_VALIDATE_EMAIL)) {

            [$emailName, $emailDomain] = array_pad(
                explode('@', $identifier, 2),
                2,
                ''
            );

            $nameLength = strlen($emailName);

            if ($nameLength <= 1) {
                $maskedName = '*';
            } elseif ($nameLength === 2) {
                $maskedName =
                    substr($emailName, 0, 1)
                    . '*';
            } else {
                $visibleLength = min(2, $nameLength);

                $maskedName =
                    substr($emailName, 0, $visibleLength)
                    . str_repeat(
                        '*',
                        max(2, $nameLength - $visibleLength)
                    );
            }

            $maskedIdentifier =
                $maskedName . '@' . $emailDomain;
        }

        elseif ($channel === 'phone' && $identifier !== '') {

            $digitsOnly = preg_replace(
                '/\D+/',
                '',
                $identifier
            );

            if (str_starts_with($digitsOnly, '62')) {

                $prefix = '+62';
                $number = substr($digitsOnly, 2);

                if (strlen($number) >= 6) {
                    $maskedIdentifier =
                        $prefix
                        . ' '
                        . substr($number, 0, 2)
                        . str_repeat('*', max(2, strlen($number) - 5))
                        . substr($number, -3);
                } else {
                    $maskedIdentifier =
                        $prefix
                        . ' '
                        . str_repeat('*', max(1, strlen($number)));
                }

            } else {

                if (strlen($digitsOnly) >= 6) {
                    $maskedIdentifier =
                        substr($digitsOnly, 0, 3)
                        . str_repeat('*', max(2, strlen($digitsOnly) - 6))
                        . substr($digitsOnly, -3);
                } else {
                    $maskedIdentifier =
                        str_repeat('*', max(1, strlen($digitsOnly)));
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PURPOSE LABEL
        |--------------------------------------------------------------------------
        */

        $purposeLabel = $purpose === 'register'
            ? 'Verifikasi pendaftaran'
            : 'Verifikasi login';
    @endphp


    <div
        class="auth-premium min-h-screen bg-[#F8FAFC]"
        x-data="otpVerification({
            cooldown: {{ $cooldown }},
            lifetime: {{ $lifetime }}
        })"
        x-init="init()"
    >

        {{-- =========================================================
            PAGE
        ========================================================== --}}
        <div class="mx-auto flex min-h-screen w-full max-w-[1240px] items-center px-3 py-5 sm:px-6 sm:py-8 lg:px-8 lg:py-10">

            <div class="grid w-full overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_24px_70px_rgba(15,23,42,0.08)] lg:grid-cols-[.9fr_1.1fr]">


                {{-- =====================================================
                    LEFT PANEL
                ====================================================== --}}
                <div class="hidden bg-[#2563EB] p-10 xl:p-14 text-white lg:flex lg:flex-col lg:justify-between">

                    <div>

                        {{-- Logo --}}
                        <a
                            href="{{ route('marketplace.home') }}"
                            class="inline-flex items-center gap-2"
                        >

                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15">
                                <i class="bi bi-briefcase-fill text-lg"></i>
                            </span>

                            <span class="text-lg font-bold tracking-tight">
                                ProKerja
                            </span>

                        </a>


                        {{-- Intro --}}
                        <div class="mt-16">

                            <span class="inline-flex items-center rounded-full bg-white/10 px-3 py-1.5 text-[11px] font-semibold">
                                Verifikasi keamanan
                            </span>

                            <h1 class="mt-5 max-w-sm text-3xl font-bold leading-tight tracking-tight">
                                Satu langkah lagi untuk melanjutkan.
                            </h1>

                            <p class="mt-4 max-w-md text-sm leading-6 text-blue-100">
                                Masukkan kode OTP yang dikirim ke kontak kamu
                                untuk memastikan bahwa proses ini benar-benar
                                dilakukan oleh pemilik akun.
                            </p>

                        </div>

                    </div>


                    {{-- Security Note --}}
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>

                                <p class="text-xs font-semibold">
                                    Lindungi kode OTP kamu
                                </p>

                                <p class="mt-1 text-[11px] leading-5 text-blue-100">
                                    Jangan pernah membagikan kode OTP kepada siapa pun,
                                    termasuk pihak yang mengaku sebagai ProKerja.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    RIGHT PANEL
                ====================================================== --}}
                <div class="p-6 sm:p-10 lg:p-12 xl:p-14">

                    {{-- Header --}}
                    <div class="text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB]">

                            <i class="bi bi-shield-lock text-xl"></i>

                        </div>


                        <div class="mt-5">

                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-[10px] font-semibold text-slate-500">
                                {{ $purposeLabel }}
                            </span>

                            <h2 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-[28px]">
                                Masukkan kode OTP
                            </h2>

                            <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
                                Kode verifikasi telah dikirim ke
                                <span class="font-semibold text-slate-700">
                                    {{ $maskedIdentifier }}
                                </span>
                                melalui {{ $channelLabel }}.
                            </p>

                        </div>

                    </div>


                    {{-- =================================================
                        FLASH SUCCESS
                    ================================================== --}}
                    @if (session('success'))

                        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm">
                                    <i class="bi bi-check-circle"></i>
                                </div>

                                <div>

                                    <p class="text-xs font-semibold text-emerald-800">
                                        Berhasil
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-emerald-700">
                                        {{ session('success') }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                        VALIDATION ERROR
                    ================================================== --}}
                    @if ($errors->any())

                        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </div>

                                <div>

                                    <p class="text-xs font-semibold text-red-800">
                                        Verifikasi gagal
                                    </p>

                                    <ul class="mt-1 space-y-1 text-xs leading-5 text-red-700">

                                        @foreach ($errors->all() as $error)

                                            <li>
                                                {{ $error }}
                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                        OTP FORM
                    ================================================== --}}
                    <form
                        method="POST"
                        action="{{ route('otp.verify.submit') }}"
                        class="mt-7"
                        @submit="beforeSubmit"
                    >

                        @csrf


                        {{-- Hidden OTP --}}
                        <input
                            type="hidden"
                            name="otp"
                            x-model="otp"
                        >


                        {{-- OTP Input --}}
                        <div>

                            <label
                                class="block text-center text-xs font-semibold uppercase tracking-[0.12em] text-slate-400"
                            >
                                Kode 6 digit
                            </label>


                            <div class="mt-4 flex justify-center gap-2 sm:gap-3">

                                @for ($i = 0; $i < 6; $i++)

                                    <input
                                        type="text"
                                        inputmode="numeric"
                                        autocomplete="{{ $i === 0 ? 'one-time-code' : 'off' }}"
                                        maxlength="1"
                                        x-ref="otp{{ $i }}"
                                        @input="handleInput($event, {{ $i }})"
                                        @keydown="handleKeydown($event, {{ $i }})"
                                        @paste="handlePaste($event)"
                                        class="otp-digit h-12 w-11 rounded-xl border border-slate-200 bg-white text-center text-lg font-bold text-slate-900 outline-none transition placeholder:text-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 sm:h-14 sm:w-12 sm:text-xl"
                                        aria-label="Digit OTP {{ $i + 1 }}"
                                    >

                                @endfor

                            </div>


                            <p class="mt-3 text-center text-[11px] text-slate-400">
                                Masukkan kode yang terdiri dari 6 digit.
                            </p>

                        </div>


                        {{-- =================================================
                            TIMER
                        ================================================== --}}
                        <div class="mt-6 rounded-2xl border border-blue-100 bg-blue-50/60 p-4">

                            <div class="flex items-center justify-between gap-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">

                                        <i class="bi bi-clock"></i>

                                    </div>

                                    <div>

                                        <p class="text-xs font-semibold text-slate-800">
                                            Kode berlaku
                                        </p>

                                        <p class="mt-0.5 text-[11px] text-slate-500">
                                            Jangan menutup halaman ini.
                                        </p>

                                    </div>

                                </div>


                                <div
                                    class="shrink-0 rounded-full bg-white px-3 py-1.5 text-xs font-bold text-[#2563EB] shadow-sm"
                                    x-text="formattedTime"
                                >
                                    05:00
                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            SUBMIT BUTTON
                        ================================================== --}}
                        <button
                            type="submit"
                            :disabled="otp.length !== 6 || submitting"
                            class="mt-5 inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8] focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-50"
                        >

                            <template x-if="!submitting">

                                <span class="inline-flex items-center gap-2">
                                    <i class="bi bi-check2-circle"></i>
                                    Verifikasi dan lanjutkan
                                </span>

                            </template>


                            <template x-if="submitting">

                                <span class="inline-flex items-center gap-2">

                                    <svg
                                        class="h-4 w-4 animate-spin"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            class="opacity-30"
                                        ></circle>

                                        <path
                                            d="M21 12a9 9 0 0 1-9 9"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                        ></path>

                                    </svg>

                                    Memverifikasi...

                                </span>

                            </template>

                        </button>

                    </form>


                    {{-- =================================================
                        RESEND
                    ================================================== --}}
                    <div class="mt-6 text-center">

                        <p class="text-xs text-slate-400">
                            Belum menerima kode?
                        </p>


                        <form
                            method="POST"
                            action="{{ route('otp.resend') }}"
                            class="mt-2"
                            @submit="resending = true"
                        >

                            @csrf

                            <button
                                type="submit"
                                :disabled="resendCountdown > 0 || resending"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#2563EB] transition hover:text-[#1D4ED8] disabled:cursor-not-allowed disabled:text-slate-400"
                            >

                                <template x-if="!resending">

                                    <span>

                                        <template x-if="resendCountdown <= 0">
                                            <span>Kirim ulang OTP</span>
                                        </template>

                                        <template x-if="resendCountdown > 0">
                                            <span>
                                                Kirim ulang dalam
                                                <span x-text="resendCountdown"></span>
                                                detik
                                            </span>
                                        </template>

                                    </span>

                                </template>


                                <template x-if="resending">

                                    <span class="inline-flex items-center gap-1.5">

                                        <svg
                                            class="h-3.5 w-3.5 animate-spin"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                        >

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                class="opacity-30"
                                            ></circle>

                                            <path
                                                d="M21 12a9 9 0 0 1-9 9"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                            ></path>

                                        </svg>

                                        Mengirim ulang...

                                    </span>

                                </template>

                            </button>

                        </form>

                    </div>


                    {{-- =================================================
                        BACK TO LOGIN
                    ================================================== --}}
                    <div class="mt-7 border-t border-slate-100 pt-6 text-center">

                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 text-xs font-medium text-slate-500 transition hover:text-[#2563EB]"
                        >

                            <i class="bi bi-arrow-left"></i>

                            Kembali ke halaman login

                        </a>

                    </div>


                    {{-- =================================================
                        SECURITY FOOTER
                    ================================================== --}}
                    <div class="mt-7 flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-slate-500 shadow-sm">

                            <i class="bi bi-shield-lock"></i>

                        </div>

                        <p class="text-[10px] leading-5 text-slate-400">

                            Demi keamanan akun, jangan berikan kode OTP kepada
                            orang lain. Tim ProKerja tidak akan pernah meminta
                            kode OTP kamu.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =============================================================
        ALPINE
    ============================================================== --}}
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('otpVerification', (config = {}) => ({

                /*
                |--------------------------------------------------------------------------
                | STATE
                |--------------------------------------------------------------------------
                */

                cooldownDuration:
                    Number(config.cooldown ?? 45),

                lifetimeDuration:
                    Number(config.lifetime ?? 5) * 60,

                resendCountdown: 0,

                remainingTime:
                    Number(config.lifetime ?? 5) * 60,

                otp: '',

                submitting: false,

                resending: false,

                timer: null,

                resendTimer: null,


                /*
                |--------------------------------------------------------------------------
                | COMPUTED TIME
                |--------------------------------------------------------------------------
                */

                get formattedTime() {

                    const total =
                        Math.max(
                            0,
                            Math.floor(
                                this.remainingTime
                            )
                        );

                    const minutes =
                        Math.floor(
                            total / 60
                        );

                    const seconds =
                        total % 60;

                    return (
                        String(minutes).padStart(2, '0')
                        + ':'
                        + String(seconds).padStart(2, '0')
                    );
                },


                /*
                |--------------------------------------------------------------------------
                | INIT
                |--------------------------------------------------------------------------
                */

                init() {

                    this.startLifetimeTimer();

                    this.startResendCountdown();

                    this.$nextTick(() => {

                        if (this.$refs.otp0) {
                            this.$refs.otp0.focus();
                        }

                    });

                },


                /*
                |--------------------------------------------------------------------------
                | LIFETIME TIMER
                |--------------------------------------------------------------------------
                */

                startLifetimeTimer() {

                    clearInterval(this.timer);

                    this.timer =
                        setInterval(() => {

                            if (this.remainingTime > 0) {

                                this.remainingTime--;

                            } else {

                                clearInterval(
                                    this.timer
                                );

                            }

                        }, 1000);

                },


                /*
                |--------------------------------------------------------------------------
                | RESEND COUNTDOWN
                |--------------------------------------------------------------------------
                */

                startResendCountdown() {

                    clearInterval(
                        this.resendTimer
                    );

                    this.resendCountdown =
                        this.cooldownDuration;

                    this.resendTimer =
                        setInterval(() => {

                            if (
                                this.resendCountdown > 0
                            ) {

                                this.resendCountdown--;

                            } else {

                                clearInterval(
                                    this.resendTimer
                                );

                            }

                        }, 1000);

                },


                /*
                |--------------------------------------------------------------------------
                | INPUT
                |--------------------------------------------------------------------------
                */

                handleInput(
                    event,
                    index
                ) {

                    const input =
                        event.target;

                    let value =
                        input.value
                            .replace(/\D/g, '')
                            .slice(0, 1);

                    input.value = value;

                    this.syncOtp();


                    if (
                        value &&
                        index < 5
                    ) {

                        const next =
                            this.$refs[
                                'otp' + (index + 1)
                            ];

                        if (next) {
                            next.focus();
                        }

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | KEYBOARD
                |--------------------------------------------------------------------------
                */

                handleKeydown(
                    event,
                    index
                ) {

                    const key =
                        event.key;

                    /*
                    Backspace:
                    */

                    if (
                        key === 'Backspace' &&
                        !event.target.value &&
                        index > 0
                    ) {

                        const previous =
                            this.$refs[
                                'otp' + (index - 1)
                            ];

                        if (previous) {

                            previous.focus();

                            previous.value = '';

                            this.syncOtp();

                        }

                        return;

                    }


                    /*
                    Arrow left:
                    */

                    if (
                        key === 'ArrowLeft' &&
                        index > 0
                    ) {

                        event.preventDefault();

                        const previous =
                            this.$refs[
                                'otp' + (index - 1)
                            ];

                        if (previous) {
                            previous.focus();
                        }

                        return;

                    }


                    /*
                    Arrow right:
                    */

                    if (
                        key === 'ArrowRight' &&
                        index < 5
                    ) {

                        event.preventDefault();

                        const next =
                            this.$refs[
                                'otp' + (index + 1)
                            ];

                        if (next) {
                            next.focus();
                        }

                        return;

                    }


                    /*
                    Hanya izinkan digit.
                    */

                    if (
                        key.length === 1 &&
                        !/[0-9]/.test(key)
                    ) {

                        event.preventDefault();

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | PASTE OTP
                |--------------------------------------------------------------------------
                */

                handlePaste(event) {

                    event.preventDefault();

                    const pasted =
                        (
                            event.clipboardData
                                ?.getData('text')
                            || ''
                        )
                            .replace(/\D/g, '')
                            .slice(0, 6);

                    if (!pasted) {
                        return;
                    }


                    for (
                        let index = 0;
                        index < 6;
                        index++
                    ) {

                        const input =
                            this.$refs[
                                'otp' + index
                            ];

                        if (!input) {
                            continue;
                        }

                        input.value =
                            pasted[index] || '';

                    }


                    this.syncOtp();


                    const focusIndex =
                        Math.min(
                            pasted.length,
                            6
                        ) - 1;

                    if (focusIndex >= 0) {

                        const target =
                            this.$refs[
                                'otp' + focusIndex
                            ];

                        if (target) {
                            target.focus();
                        }

                    }

                },


                /*
                |--------------------------------------------------------------------------
                | SYNC OTP
                |--------------------------------------------------------------------------
                */

                syncOtp() {

                    let value = '';

                    for (
                        let index = 0;
                        index < 6;
                        index++
                    ) {

                        const input =
                            this.$refs[
                                'otp' + index
                            ];

                        value +=
                            input?.value || '';

                    }

                    this.otp =
                        value
                            .replace(/\D/g, '')
                            .slice(0, 6);

                },


                /*
                |--------------------------------------------------------------------------
                | SUBMIT
                |--------------------------------------------------------------------------
                */

                beforeSubmit(event) {

                    this.syncOtp();

                    if (
                        this.otp.length !== 6
                    ) {

                        event.preventDefault();

                        const firstEmpty =
                            Array.from({
                                length: 6
                            })
                                .findIndex(
                                    (_, index) => {

                                        const input =
                                            this.$refs[
                                                'otp' + index
                                            ];

                                        return !input?.value;

                                    }
                                );

                        const focusIndex =
                            firstEmpty >= 0
                                ? firstEmpty
                                : 0;

                        const target =
                            this.$refs[
                                'otp' + focusIndex
                            ];

                        if (target) {
                            target.focus();
                        }

                        return;

                    }

                    this.submitting = true;

                },

            }));

        });
    </script>

</x-guest-layout>
