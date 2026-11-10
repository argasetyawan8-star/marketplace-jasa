<x-guest-layout>
    @section('title', 'Masuk · ProKerja')


@php
    /*
    |--------------------------------------------------------------------------
    | Authentication Login
    |--------------------------------------------------------------------------
    | Flow baru ProKerja:
    |
    | Email / Nomor HP
    |       ↓
    |   Lanjutkan
    |       ↓
    | Cek akun
    |       ↓
    |      OTP
    |       ↓
    |   Verifikasi
    |       ↓
    |     Login
    |
    | Backend nantinya membaca input "identifier".
    |--------------------------------------------------------------------------
    */

    $identifierValue = old('identifier');
@endphp


<div class="auth-premium min-h-screen bg-slate-50">

    {{-- =========================================================
        PAGE WRAPPER
    ========================================================== --}}

    <div class="mx-auto flex min-h-screen w-full max-w-[1320px] items-center px-3 py-5 sm:px-6 sm:py-8 lg:px-8 lg:py-10">

        <div class="grid w-full overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.08)] lg:grid-cols-[1.08fr_.92fr]">


            {{-- =================================================
                LEFT BRAND PANEL
            ================================================== --}}

            <section class="relative hidden overflow-hidden bg-[#2563EB] lg:flex">

                {{-- Decorative background --}}

                <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full border border-white/10"></div>

                <div class="pointer-events-none absolute -bottom-28 -left-24 h-80 w-80 rounded-full border border-white/10"></div>

                <div class="pointer-events-none absolute right-16 top-24 h-24 w-24 rounded-full bg-white/5"></div>


                <div class="relative flex min-h-[720px] w-full flex-col justify-between p-10 xl:p-14">

                    {{-- Brand --}}

                    <div>

                        <a
                            href="{{ route('marketplace.home') }}"
                            class="inline-flex items-center gap-3"
                        >

                            <span class="flex h-11 w-11 items-center justify-center rounded-[13px] bg-white text-lg font-extrabold text-[#123b78] shadow-[0_8px_22px_rgba(0,0,0,.16)]">
                                P
                            </span>

                            <span class="flex flex-col leading-none">

                                <span class="text-[20px] font-bold tracking-[-0.03em] text-white">
                                    ProKerja
                                </span>

                                <span class="mt-1 text-[9px] font-medium uppercase tracking-[0.12em] text-blue-100">
                                    Wujudkan Kerja
                                </span>

                            </span>

                        </a>

                    </div>


                    {{-- Main Message --}}

                    <div class="relative max-w-md">

                        <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-[10px] font-semibold text-blue-50 backdrop-blur-sm">

                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span>

                            Marketplace Jasa Indonesia

                        </span>


                        <h1 class="mt-5 text-4xl font-extrabold leading-tight tracking-[-0.055em] text-white xl:text-[54px]">

                            Kerja lebih mudah.
                            <br>
                            Peluang lebih luas.

                        </h1>


                        <p class="mt-5 max-w-sm text-sm leading-6 text-blue-100">

                            Masuk ke ProKerja untuk mengelola pesanan,
                            berkomunikasi dengan pengguna, dan membangun
                            perjalanan kerja kamu.

                        </p>


                        {{-- Trust points --}}

                        <div class="mt-8 space-y-4">

                            <div class="flex items-center gap-3">

                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-white">

                                    <i class="bi bi-shield-check"></i>

                                </span>

                                <div>

                                    <p class="text-xs font-semibold text-white">
                                        Akses akun yang aman
                                    </p>

                                    <p class="mt-0.5 text-[10px] text-blue-100">
                                        Verifikasi menggunakan kode OTP.
                                    </p>

                                </div>

                            </div>


                            <div class="flex items-center gap-3">

                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-white">

                                    <i class="bi bi-lightning-charge"></i>

                                </span>

                                <div>

                                    <p class="text-xs font-semibold text-white">
                                        Login lebih praktis
                                    </p>

                                    <p class="mt-0.5 text-[10px] text-blue-100">
                                        Tidak perlu mengingat password.
                                    </p>

                                </div>

                            </div>


                            <div class="flex items-center gap-3">

                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-white">

                                    <i class="bi bi-people"></i>

                                </span>

                                <div>

                                    <p class="text-xs font-semibold text-white">
                                        Satu akun ProKerja
                                    </p>

                                    <p class="mt-0.5 text-[10px] text-blue-100">
                                        Gunakan akun yang sama sebagai client maupun freelancer.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Bottom --}}

                    <div>

                        <p class="text-[10px] leading-5 text-blue-100/80">

                            Dengan masuk, kamu dapat melanjutkan aktivitas
                            yang sebelumnya sudah tersimpan di ProKerja.

                        </p>

                    </div>

                </div>

            </section>


            {{-- =================================================
                RIGHT LOGIN PANEL
            ================================================== --}}

            <section class="flex min-h-[680px] items-center justify-center bg-white px-5 py-8 sm:px-8 lg:px-10 xl:px-14">

                <div class="w-full max-w-md">


                    {{-- Mobile Brand --}}

                    <div class="mb-8 flex justify-center lg:hidden">

                        <a
                            href="{{ route('marketplace.home') }}"
                            class="inline-flex items-center gap-2.5"
                        >

                            <span class="flex h-10 w-10 items-center justify-center rounded-[12px] bg-[#2563EB] text-base font-extrabold text-white shadow-sm">
                                P
                            </span>

                            <span class="flex flex-col leading-none">

                                <span class="text-[18px] font-bold tracking-[-0.03em] text-slate-900">
                                    ProKerja
                                </span>

                                <span class="mt-1 text-[8px] font-medium uppercase tracking-[0.1em] text-slate-400">
                                    Wujudkan Kerja
                                </span>

                            </span>

                        </a>

                    </div>


                    {{-- Header --}}

                    <div>

                        <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-[10px] font-semibold text-[#2563EB]">

                            <i class="bi bi-box-arrow-in-right"></i>

                            Masuk

                        </div>


                        <h2 class="mt-4 text-2xl font-bold tracking-[-0.03em] text-slate-900 sm:text-3xl">

                            Masuk ke ProKerja

                        </h2>


                        <p class="mt-2 text-sm leading-6 text-slate-500">

                            Gunakan email atau nomor HP yang terdaftar
                            untuk menerima kode verifikasi.

                        </p>

                    </div>


                    {{-- Session Status --}}

                    @if (session('status'))

                        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3">

                            <div class="flex items-start gap-3">

                                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm">

                                    <i class="bi bi-check2-circle"></i>

                                </span>

                                <p class="text-xs leading-5 text-emerald-700">

                                    {{ session('status') }}

                                </p>

                            </div>

                        </div>

                    @endif


                    {{-- Validation Errors --}}

                    @if ($errors->any())

                        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3.5">

                            <div class="flex items-start gap-3">

                                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">

                                    <i class="bi bi-exclamation-triangle"></i>

                                </span>


                                <div class="min-w-0">

                                    <p class="text-xs font-semibold text-red-700">
                                        Tidak dapat melanjutkan
                                    </p>

                                    <div class="mt-1.5 space-y-1">

                                        @foreach ($errors->all() as $error)

                                            <p class="text-[11px] leading-5 text-red-600">
                                                {{ $error }}
                                            </p>

                                        @endforeach

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                        LOGIN FORM
                    ================================================== --}}

                    <form
                        method="POST"
                        action="{{ route('login') }}"
                        class="mt-7"
                    >

                        @csrf


                        {{-- Identifier --}}

                        <div>

                            <label
                                for="identifier"
                                class="block text-sm font-semibold text-slate-800"
                            >
                                Email atau Nomor HP
                            </label>


                            <p class="mt-1 text-[11px] leading-5 text-slate-400">

                                Masukkan email atau nomor HP yang kamu gunakan
                                saat membuat akun ProKerja.

                            </p>


                            <div class="relative mt-3">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">

                                    <i class="bi bi-person-vcard text-[17px]"></i>

                                </div>


                                <input
                                    id="identifier"
                                    type="text"
                                    name="identifier"
                                    value="{{ $identifierValue }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    inputmode="email"
                                    placeholder="email@contoh.com atau 08xxxxxxxxxx"
                                    class="block h-12 w-full rounded-xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                >

                            </div>


                            @error('identifier')

                                <p class="mt-2 text-[11px] leading-5 text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Submit --}}

                        <button
                            type="submit"
                            class="mt-5 inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-sm font-semibold !text-white shadow-[0_8px_20px_rgba(37,99,235,0.20)] transition duration-200 hover:-translate-y-0.5 hover:bg-[#1D4ED8] hover:shadow-[0_12px_25px_rgba(37,99,235,0.24)] focus:outline-none focus:ring-4 focus:ring-blue-100 active:translate-y-0"
                        >

                            <i class="bi bi-arrow-right-circle"></i>

                            Lanjutkan

                        </button>


                    </form>


                    {{-- Divider --}}

                    <div class="my-7 flex items-center gap-4">

                        <div class="h-px flex-1 bg-slate-200"></div>

                        <span class="shrink-0 text-[10px] font-medium uppercase tracking-[0.12em] text-slate-400">
                            atau
                        </span>

                        <div class="h-px flex-1 bg-slate-200"></div>

                    </div>


                    {{-- Google --}}

                    @if (Route::has('google.redirect'))

                        <a
                            href="{{ route('google.redirect') }}"
                            class="inline-flex h-12 w-full items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100"
                        >

                            <span class="flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white text-sm font-bold">

                                G

                            </span>

                            Lanjutkan dengan Google

                        </a>

                    @endif


                    {{-- Register --}}

                    <div class="mt-8 text-center">

                        <p class="text-sm text-slate-500">

                            Belum punya akun?

                            <a
                                href="{{ route('register') }}"
                                class="font-semibold text-[#2563EB] transition hover:text-[#1D4ED8]"
                            >
                                Daftar
                            </a>

                        </p>

                    </div>


                    {{-- Freelancer CTA --}}

                    <div class="mt-5 rounded-2xl border border-blue-100 bg-blue-50/70 p-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">

                                <i class="bi bi-briefcase"></i>

                            </div>


                            <div class="min-w-0 flex-1">

                                <p class="text-xs font-semibold text-slate-800">
                                    Ingin menjadi freelancer?
                                </p>

                                <p class="mt-1 text-[11px] leading-5 text-slate-500">

                                    Kamu bisa menggunakan akun ProKerja yang sama
                                    untuk mengajukan pendaftaran sebagai freelancer.

                                </p>


                                <a
                                    href="{{ Route::has('freelancer.register') ? route('freelancer.register') : route('register') }}"
                                    class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-[#2563EB] transition hover:text-[#1D4ED8]"
                                >

                                    Daftar sebagai Freelancer

                                    <i class="bi bi-arrow-right text-[10px]"></i>

                                </a>

                            </div>

                        </div>

                    </div>


                    {{-- Security Note --}}

                    <div class="mt-5 flex items-center justify-center gap-2 text-center text-[10px] leading-5 text-slate-400">

                        <i class="bi bi-shield-lock"></i>

                        <span>
                            Login menggunakan kode verifikasi yang dikirim ke akunmu.
                        </span>

                    </div>

                </div>

            </section>

        </div>

    </div>

</div>


{{-- =============================================================
    SMALL ANIMATION
============================================================== --}}

<style>
    @keyframes pk-auth-enter {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .pk-auth-enter {
        animation: pk-auth-enter .45s ease-out both;
    }
</style>


</x-guest-layout>
