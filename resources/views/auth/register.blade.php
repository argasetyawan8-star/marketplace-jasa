
<x-guest-layout>
    @section('title', 'Buat Akun · ProKerja')

    @php
        $freelancerIntent = $freelancerIntent ?? false;
    @endphp

    <div class="auth-premium min-h-screen bg-[#F8FAFC]">

        <div class="mx-auto flex min-h-screen w-full max-w-[1240px] items-center px-3 py-5 sm:px-6 sm:py-8 lg:px-8 lg:py-10">

            <div class="grid w-full overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_24px_70px_rgba(15,23,42,0.08)] lg:grid-cols-[.92fr_1.08fr]">

                {{-- =======================================================
                    LEFT PANEL
                ======================================================== --}}
                <div class="hidden bg-[#2563EB] p-10 xl:p-14 text-white lg:flex lg:flex-col lg:justify-between">

                    <div>

                        <a
                            href="{{ route('marketplace.home') }}"
                            class="inline-flex items-center gap-3"
                        >
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-[#2563EB] text-lg font-extrabold">
                                P
                            </span>

                            <span class="text-lg font-bold tracking-tight">
                                ProKerja
                            </span>
                        </a>

                        <div class="mt-12 max-w-sm">

                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 text-xs font-semibold text-white/90">
                                <i class="bi bi-shield-check"></i>
                                Akun aman dengan OTP
                            </span>

                            <h1 class="mt-5 text-4xl font-extrabold leading-tight tracking-[-0.055em] xl:text-[48px]">
                                Mulai perjalananmu di ProKerja.
                            </h1>

                            <p class="mt-4 text-sm leading-6 text-blue-100">
                                Satu akun untuk menemukan jasa, mengelola project,
                                dan nantinya bisa digunakan untuk mendaftar sebagai freelancer.
                            </p>

                        </div>

                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/10 p-5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10">
                                <i class="bi bi-lightning-charge text-lg"></i>
                            </div>

                            <div>

                                <p class="text-sm font-semibold">
                                    Registrasi sederhana
                                </p>

                                <p class="mt-1 text-xs leading-5 text-blue-100">
                                    Cukup nama dan email atau nomor telepon.
                                    Detail freelancer diisi setelah akun selesai dibuat.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- =======================================================
                    RIGHT PANEL
                ======================================================== --}}
                <div class="p-6 sm:p-10 lg:p-12 xl:p-14">

                    {{-- Mobile brand --}}
                    <div class="lg:hidden">

                        <a
                            href="{{ route('marketplace.home') }}"
                            class="inline-flex items-center gap-2"
                        >
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#2563EB] text-base font-extrabold text-white">
                                P
                            </span>

                            <span class="text-base font-bold text-slate-900">
                                ProKerja
                            </span>
                        </a>

                    </div>

                    {{-- Heading --}}
                    <div class="mt-8 lg:mt-0">

                        @if ($freelancerIntent)

                            <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-[#2563EB]">
                                <i class="bi bi-briefcase"></i>
                                Daftar sebagai Freelancer
                            </span>

                            <h2 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                                Buat akun ProKerja
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Setelah akun berhasil diverifikasi, kamu akan
                                melanjutkan ke proses pendaftaran freelancer.
                            </p>

                        @else

                            <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                                Buat akun ProKerja
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Daftar dengan nama dan satu identitas kontak.
                                Kami akan mengirimkan kode OTP untuk verifikasi.
                            </p>

                        @endif

                    </div>

                    {{-- Error --}}
                    @if ($errors->any())

                        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </div>

                                <div class="min-w-0">

                                    <p class="text-sm font-semibold text-red-700">
                                        Periksa kembali data kamu
                                    </p>

                                    <ul class="mt-2 space-y-1 text-xs leading-5 text-red-600">

                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        </div>

                    @endif

                    {{-- Form --}}
                    <form
                        method="POST"
                        action="{{ route('register') }}"
                        class="mt-7 space-y-5"
                    >

                        @csrf

                        {{-- Name --}}
                        <div>

                            <label
                                for="name"
                                class="block text-sm font-semibold text-slate-800"
                            >
                                Nama lengkap
                            </label>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                autocomplete="name"
                                required
                                autofocus
                                maxlength="100"
                                placeholder="Nama kamu"
                                class="mt-2 block h-12 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                            >

                        </div>

                        {{-- Identifier --}}
                        <div>

                            <label
                                for="identifier"
                                class="block text-sm font-semibold text-slate-800"
                            >
                                Email atau nomor telepon
                            </label>

                            <p class="mt-1 text-xs text-slate-400">
                                Gunakan email atau nomor telepon Indonesia yang masih aktif.
                            </p>

                            <div class="relative mt-2">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#2563EB]">
                                    <i class="bi bi-at"></i>
                                </div>

                                <input
                                    id="identifier"
                                    name="identifier"
                                    type="text"
                                    value="{{ old('identifier') }}"
                                    autocomplete="email tel"
                                    required
                                    maxlength="255"
                                    placeholder="email@contoh.com atau +62 8xx"
                                    class="block h-12 w-full rounded-xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                                >

                            </div>

                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8] hover:shadow-md focus:outline-none focus:ring-4 focus:ring-blue-100"
                        >
                            <i class="bi bi-send"></i>
                            Kirim kode verifikasi
                        </button>

                    </form>

                    {{-- Google --}}
                    @if (Route::has('google.redirect'))

                        <div class="my-6 flex items-center gap-3">

                            <div class="h-px flex-1 bg-slate-200"></div>

                            <span class="text-[10px] font-medium uppercase tracking-[0.14em] text-slate-400">
                                atau
                            </span>

                            <div class="h-px flex-1 bg-slate-200"></div>

                        </div>

                        <a
                            href="{{ route('google.redirect') }}"
                            class="inline-flex h-12 w-full items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:border-slate-300"
                        >
                            <span class="flex h-6 w-6 items-center justify-center rounded-full text-sm font-bold">
                                G
                            </span>

                            Daftar dengan Google
                        </a>

                    @endif

                    {{-- Login --}}
                    <div class="mt-7 text-center text-sm text-slate-500">

                        Sudah punya akun?

                        <a
                            href="{{ route('login') }}"
                            class="font-semibold text-[#2563EB] transition hover:text-[#1D4ED8]"
                        >
                            Masuk
                        </a>

                    </div>

                    {{-- Security note --}}
                    <div class="mt-7 rounded-2xl border border-blue-100 bg-blue-50/60 p-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">
                                <i class="bi bi-shield-lock"></i>
                            </div>

                            <div>

                                <p class="text-xs font-semibold text-slate-800">
                                    Verifikasi dengan OTP
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Kode hanya digunakan untuk memverifikasi akses
                                    ke email atau nomor telepon kamu.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>

