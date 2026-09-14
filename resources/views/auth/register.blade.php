<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Daftar | Marketplace Jasa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f7f8fc] text-slate-900 antialiased">

    <div
        x-data="{
            showPassword: false,
            showPasswordConfirmation: false
        }"
        class="min-h-screen lg:flex"
    >

        {{-- ============================================================
             DESKTOP BRAND PANEL
        ============================================================= --}}

        <aside class="relative hidden overflow-hidden lg:flex lg:w-[44%] xl:w-[46%]">

            {{-- Main gradient --}}

            <div class="absolute inset-0 bg-[#2E3192]"></div>

            {{-- Very subtle background glow --}}

            <div class="absolute -left-28 -top-28 h-80 w-80 rounded-full bg-[#F6D21A]/10 blur-3xl"></div>

            <div class="absolute -bottom-32 -right-20 h-96 w-96 rounded-full bg-indigo-300/10 blur-3xl"></div>


            <div class="relative z-10 flex min-h-screen w-full flex-col p-10 xl:p-14">

                {{-- Brand --}}

                <a
                    href="{{ url('/') }}"
                    class="group flex w-fit items-center gap-3"
                >

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-[13px] font-black tracking-tight text-[#2E3192] shadow-sm transition duration-300 group-hover:-translate-y-0.5"
                    >
                        MJ
                    </div>

                    <div>
                        <p class="text-sm font-extrabold tracking-tight text-white">
                            Marketplace Jasa
                        </p>

                        <p class="mt-0.5 text-[10px] text-white/45">
                            Temukan. Pesan. Selesai.
                        </p>
                    </div>

                </a>


                {{-- Main message --}}

                <div class="my-auto max-w-xl">

                    <div class="mb-7 flex items-center gap-2">

                        <span class="h-1.5 w-1.5 rounded-full bg-[#F6D21A]"></span>

                        <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/55">
                            Marketplace Jasa
                        </span>

                    </div>


                    <h1
                        class="max-w-lg text-5xl font-black leading-[1.02] tracking-[-0.045em] text-white xl:text-[64px]"
                    >
                        Semua keahlian
                        <span class="text-[#F6D21A]">
                            ada di sini.
                        </span>
                    </h1>


                    <p
                        class="mt-7 max-w-md text-sm leading-7 text-white/55 xl:text-[15px]"
                    >
                        Cari freelancer untuk menyelesaikan kebutuhanmu,
                        atau ubah keahlian yang kamu punya menjadi peluang.
                    </p>


                    {{-- Small stats --}}

                    <div class="mt-10 flex flex-wrap items-center gap-x-8 gap-y-5">

                        <div>
                            <p class="text-2xl font-black tracking-tight text-white">
                                01
                            </p>

                            <p class="mt-1 text-[10px] font-medium text-white/40">
                                Cari jasa yang kamu butuhkan
                            </p>
                        </div>


                        <div class="h-8 w-px bg-white/10"></div>


                        <div>
                            <p class="text-2xl font-black tracking-tight text-white">
                                02
                            </p>

                            <p class="mt-1 text-[10px] font-medium text-white/40">
                                Pilih freelancer terbaik
                            </p>
                        </div>


                        <div class="h-8 w-px bg-white/10"></div>


                        <div>
                            <p class="text-2xl font-black tracking-tight text-white">
                                03
                            </p>

                            <p class="mt-1 text-[10px] font-medium text-white/40">
                                Selesaikan pesanan
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Bottom --}}

                <div class="flex items-center justify-between">

                    <p class="text-[10px] text-white/25">
                        © {{ date('Y') }} Marketplace Jasa
                    </p>

                    <span class="text-[10px] text-white/25">
                        Built for clients & freelancers
                    </span>

                </div>

            </div>

        </aside>



        {{-- ============================================================
             REGISTER AREA
        ============================================================= --}}

        <main class="flex min-h-screen flex-1 flex-col bg-white">

            {{-- Top bar --}}

            <header class="flex items-center justify-between px-6 py-6 sm:px-10 lg:justify-end lg:px-14">

                {{-- Mobile brand --}}

                <a
                    href="{{ url('/') }}"
                    class="flex items-center gap-2.5 lg:hidden"
                >

                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#2E3192] text-[11px] font-black text-white"
                    >
                        MJ
                    </div>

                    <span class="text-sm font-extrabold tracking-tight text-slate-800">
                        Marketplace Jasa
                    </span>

                </a>


                <div class="flex items-center gap-2 text-xs">

                    <span class="hidden text-slate-400 sm:inline">
                        Sudah punya akun?
                    </span>

                    <a
                        href="{{ route('login') }}"
                        class="rounded-lg px-2 py-1 font-bold text-[#2E3192] transition hover:bg-[#2E3192]/5"
                    >
                        Masuk
                    </a>

                </div>

            </header>



            {{-- Form section --}}

            <section class="flex flex-1 items-center justify-center px-5 pb-12 sm:px-8">

                <div class="w-full max-w-[470px]">

                    {{-- Heading --}}

                    <div class="mb-8">

                        <div
                            class="mb-5 inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[#2E3192]/8 text-[#2E3192]"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                class="h-4 w-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z"
                                />
                            </svg>
                        </div>


                        <h2
                            class="text-3xl font-black tracking-[-0.035em] text-slate-950 sm:text-[34px]"
                        >
                            Buat akunmu.
                        </h2>


                        <p class="mt-2 text-sm leading-6 text-slate-400">
                            Mulai perjalananmu di Marketplace Jasa.
                        </p>

                    </div>



                    {{-- Validation --}}

                    @if ($errors->any())

                        <div
                            class="mb-6 rounded-2xl border border-red-100 bg-red-50 px-4 py-3.5"
                        >

                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-100 text-xs font-bold text-red-600"
                                >
                                    !
                                </div>

                                <div>

                                    <p class="text-xs font-bold text-red-700">
                                        Periksa kembali data kamu.
                                    </p>

                                    <div class="mt-1 space-y-0.5">

                                        @foreach ($errors->all() as $error)

                                            <p class="text-[11px] leading-5 text-red-500">
                                                {{ $error }}
                                            </p>

                                        @endforeach

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif



                    {{-- ====================================================
                         FORM
                    ===================================================== --}}

                    <form
                        method="POST"
                        action="{{ route('register') }}"
                        class="space-y-5"
                    >

                        @csrf



                        {{-- ROLE --}}

                        <div>

                            <div class="mb-3 flex items-center justify-between">

                                <label class="text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                                    Pilih peranmu
                                </label>

                                <span class="text-[10px] text-slate-300">
                                    Wajib
                                </span>

                            </div>


                            <div class="grid grid-cols-2 gap-3">

                                {{-- CLIENT --}}

                                <label class="group relative cursor-pointer">

                                    <input
                                        type="radio"
                                        name="role"
                                        value="client"
                                        class="peer sr-only"
                                        {{ old('role', 'client') === 'client' ? 'checked' : '' }}
                                    >

                                    <div
                                        class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-4 transition-all duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/40 peer-checked:border-[#2E3192] peer-checked:bg-[#2E3192]/[0.025] peer-checked:shadow-lg peer-checked:shadow-[#2E3192]/10"
                                    >

                                        {{-- selected line --}}

                                        <div
                                            class="absolute inset-x-0 top-0 h-0.5 bg-[#2E3192] opacity-0 transition peer-checked:opacity-100"
                                        ></div>


                                        <div class="flex items-start justify-between">

                                            <div
                                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-xs font-black text-slate-500 transition peer-checked:bg-[#2E3192] peer-checked:text-white"
                                            >
                                                C
                                            </div>


                                            <div
                                                class="flex h-5 w-5 items-center justify-center rounded-full border border-slate-200 text-[9px] font-black text-white transition peer-checked:border-[#2E3192] peer-checked:bg-[#2E3192]"
                                            >
                                                ✓
                                            </div>

                                        </div>


                                        <p class="mt-4 text-xs font-extrabold text-slate-900">
                                            Saya Client
                                        </p>


                                        <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                            Mencari dan membeli jasa.
                                        </p>

                                    </div>

                                </label>



                                {{-- FREELANCER --}}

                                <label class="group relative cursor-pointer">

                                    <input
                                        type="radio"
                                        name="role"
                                        value="freelancer"
                                        class="peer sr-only"
                                        {{ old('role') === 'freelancer' ? 'checked' : '' }}
                                    >

                                    <div
                                        class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-4 transition-all duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/40 peer-checked:border-[#2E3192] peer-checked:bg-[#2E3192]/[0.025] peer-checked:shadow-lg peer-checked:shadow-[#2E3192]/10"
                                    >

                                        <div
                                            class="absolute inset-x-0 top-0 h-0.5 bg-[#2E3192] opacity-0 transition peer-checked:opacity-100"
                                        ></div>


                                        <div class="flex items-start justify-between">

                                            <div
                                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-xs font-black text-slate-500"
                                            >
                                                F
                                            </div>


                                            <div
                                                class="flex h-5 w-5 items-center justify-center rounded-full border border-slate-200 text-[9px] font-black text-white transition peer-checked:border-[#2E3192] peer-checked:bg-[#2E3192]"
                                            >
                                                ✓
                                            </div>

                                        </div>


                                        <p class="mt-4 text-xs font-extrabold text-slate-900">
                                            Saya Freelancer
                                        </p>


                                        <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                            Menawarkan jasa dan keahlian.
                                        </p>

                                    </div>

                                </label>

                            </div>

                        </div>



                        {{-- NAME --}}

                        <div>

                            <label
                                for="name"
                                class="mb-2 block text-[11px] font-extrabold uppercase tracking-wider text-slate-500"
                            >
                                Nama lengkap
                            </label>


                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Nama lengkap kamu"
                                class="h-12 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-300 hover:border-slate-300 focus:border-[#2E3192] focus:ring-4 focus:ring-[#2E3192]/5"
                            >


                            @error('name')

                                <p class="mt-1.5 text-[10px] font-medium text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>



                        {{-- EMAIL --}}

                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-[11px] font-extrabold uppercase tracking-wider text-slate-500"
                            >
                                Email
                            </label>


                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="username"
                                placeholder="kamu@email.com"
                                class="h-12 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-300 hover:border-slate-300 focus:border-[#2E3192] focus:ring-4 focus:ring-[#2E3192]/5"
                            >


                            @error('email')

                                <p class="mt-1.5 text-[10px] font-medium text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>



                        {{-- PASSWORD --}}

                        <div>

                            <div class="mb-2 flex items-center justify-between">

                                <label
                                    for="password"
                                    class="text-[11px] font-extrabold uppercase tracking-wider text-slate-500"
                                >
                                    Password
                                </label>

                            </div>


                            <div class="relative">

                                <input
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Buat password"
                                    :type="showPassword ? 'text' : 'password'"
                                    class="h-12 w-full rounded-xl border border-slate-200 bg-white px-4 pr-16 text-sm text-slate-900 outline-none transition placeholder:text-slate-300 hover:border-slate-300 focus:border-[#2E3192] focus:ring-4 focus:ring-[#2E3192]/5"
                                >


                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg px-2 py-1.5 text-[10px] font-bold text-slate-400 transition hover:bg-slate-100 hover:text-[#2E3192]"
                                >

                                    <span x-show="!showPassword">
                                        Lihat
                                    </span>

                                    <span
                                        x-show="showPassword"
                                        x-cloak
                                    >
                                        Sembunyikan
                                    </span>

                                </button>

                            </div>


                            @error('password')

                                <p class="mt-1.5 text-[10px] font-medium text-red-500">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>



                        {{-- CONFIRM PASSWORD --}}

                        <div>

                            <label
                                for="password_confirmation"
                                class="mb-2 block text-[11px] font-extrabold uppercase tracking-wider text-slate-500"
                            >
                                Konfirmasi password
                            </label>


                            <div class="relative">

                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Ulangi password"
                                    :type="showPasswordConfirmation ? 'text' : 'password'"
                                    class="h-12 w-full rounded-xl border border-slate-200 bg-white px-4 pr-16 text-sm text-slate-900 outline-none transition placeholder:text-slate-300 hover:border-slate-300 focus:border-[#2E3192] focus:ring-4 focus:ring-[#2E3192]/5"
                                >


                                <button
                                    type="button"
                                    @click="showPasswordConfirmation = !showPasswordConfirmation"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg px-2 py-1.5 text-[10px] font-bold text-slate-400 transition hover:bg-slate-100 hover:text-[#2E3192]"
                                >

                                    <span x-show="!showPasswordConfirmation">
                                        Lihat
                                    </span>

                                    <span
                                        x-show="showPasswordConfirmation"
                                        x-cloak
                                    >
                                        Sembunyikan
                                    </span>

                                </button>

                            </div>

                        </div>



                        {{-- SUBMIT --}}

                        <button
                            type="submit"
                            class="group relative mt-2 flex h-12 w-full items-center justify-center overflow-hidden rounded-xl bg-[#2E3192] px-5 text-sm font-extrabold text-white shadow-lg shadow-[#2E3192]/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#272a80] hover:shadow-xl hover:shadow-[#2E3192]/20 active:translate-y-0"
                        >

                            <span class="relative z-10 flex items-center gap-2">

                                Buat akun

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    class="h-4 w-4 transition duration-300 group-hover:translate-x-1"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                                    />
                                </svg>

                            </span>


                            <span
                                class="absolute -left-24 top-0 h-full w-20 -skew-x-12 bg-white/10 transition-all duration-500 group-hover:left-[110%]"
                            ></span>

                        </button>



                        {{-- Terms --}}

                        <p class="pt-1 text-center text-[10px] leading-5 text-slate-400">

                            Dengan membuat akun, kamu menyetujui

                            <span class="font-semibold text-slate-500">
                                ketentuan penggunaan
                            </span>

                            dan

                            <span class="font-semibold text-slate-500">
                                kebijakan platform
                            </span>.

                        </p>

                    </form>

                </div>

            </section>

        </main>

    </div>

</body>
</html>