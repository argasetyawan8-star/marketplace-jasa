<footer class="bg-[#0A4D2A] text-white">


{{-- Main Footer --}}
<div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">

    <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-[1.4fr_0.9fr_0.9fr_0.9fr]">

        {{-- Brand --}}
        <div class="max-w-sm">

            <a
                href="{{ route('marketplace.home') }}"
                class="group inline-flex items-center gap-3"
            >
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#1E9E5A] text-sm font-semibold text-white shadow-[0_4px_16px_rgba(30,158,90,0.18)] transition duration-200 group-hover:bg-[#35C978]"
                >
                    J
                </div>

                <div>
                    <div class="text-lg font-semibold tracking-tight">
                        JASAIN
                    </div>

                    <div class="text-xs text-white/50">
                        Marketplace Jasa
                    </div>
                </div>
            </a>

            <p class="mt-5 text-sm leading-6 text-white/60">
                Platform untuk menemukan freelancer profesional
                dan berbagai layanan jasa sesuai kebutuhanmu.
            </p>

            {{-- Social --}}
            <div class="mt-6 flex items-center gap-2">

                <a
                    href="#"
                    aria-label="Instagram"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 transition hover:border-white/20 hover:bg-white/5 hover:text-white"
                >
                    <i class="bi bi-instagram"></i>
                </a>

                <a
                    href="#"
                    aria-label="Facebook"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 transition hover:border-white/20 hover:bg-white/5 hover:text-white"
                >
                    <i class="bi bi-facebook"></i>
                </a>

                <a
                    href="#"
                    aria-label="LinkedIn"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 transition hover:border-white/20 hover:bg-white/5 hover:text-white"
                >
                    <i class="bi bi-linkedin"></i>
                </a>

                <a
                    href="#"
                    aria-label="TikTok"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 transition hover:border-white/20 hover:bg-white/5 hover:text-white"
                >
                    <i class="bi bi-tiktok"></i>
                </a>

            </div>

        </div>


        {{-- Marketplace --}}
        <div>

            <h3 class="text-sm font-semibold text-white">
                Marketplace
            </h3>

            <div class="mt-5 space-y-3">

                <a
                    href="{{ route('marketplace.home') }}"
                    class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                >
                    <i class="bi bi-house text-xs opacity-70 transition group-hover:opacity-100"></i>
                    Beranda
                </a>

                <a
                    href="{{ route('marketplace.search') }}"
                    class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                >
                    <i class="bi bi-search text-xs opacity-70 transition group-hover:opacity-100"></i>
                    Cari Jasa
                </a>

                <a
                    href="{{ route('marketplace.jobs.index') }}"
                    class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                >
                    <i class="bi bi-briefcase text-xs opacity-70 transition group-hover:opacity-100"></i>
                    Job Board
                </a>

                @auth

                    @if(auth()->user()->role === 'client')

                        <a
                            href="{{ route('client.favorites.index') }}"
                            class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                        >
                            <i class="bi bi-heart text-xs opacity-70 transition group-hover:opacity-100"></i>
                            Favorit
                        </a>

                    @endif

                @else

                    <a
                        href="{{ route('register') }}"
                        class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                    >
                        <i class="bi bi-person-plus text-xs opacity-70 transition group-hover:opacity-100"></i>
                        Daftar
                    </a>

                @endauth

            </div>

        </div>


        {{-- Untuk Pengguna --}}
        <div>

            <h3 class="text-sm font-semibold text-white">
                Untuk Pengguna
            </h3>

            <div class="mt-5 space-y-3">

                @guest

                    <a
                        href="{{ route('login') }}"
                        class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                    >
                        <i class="bi bi-box-arrow-in-right text-xs opacity-70 transition group-hover:opacity-100"></i>
                        Masuk
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                    >
                        <i class="bi bi-person-plus text-xs opacity-70 transition group-hover:opacity-100"></i>
                        Buat Akun
                    </a>

                @else

                    @if(auth()->user()->role === 'client')

                        <a
                            href="{{ route('client.dashboard') }}"
                            class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                        >
                            <i class="bi bi-grid text-xs opacity-70 transition group-hover:opacity-100"></i>
                            Dashboard
                        </a>

                        <a
                            href="{{ route('client.orders.index') }}"
                            class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                        >
                            <i class="bi bi-bag text-xs opacity-70 transition group-hover:opacity-100"></i>
                            Pesanan
                        </a>

                        <a
                            href="{{ route('client.messages.index') }}"
                            class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                        >
                            <i class="bi bi-chat-dots text-xs opacity-70 transition group-hover:opacity-100"></i>
                            Pesan
                        </a>

                    @elseif(auth()->user()->role === 'freelancer')

                        <a
                            href="{{ route('freelancer.dashboard') }}"
                            class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                        >
                            <i class="bi bi-grid text-xs opacity-70 transition group-hover:opacity-100"></i>
                            Dashboard
                        </a>

                        <a
                            href="{{ route('freelancer.services.index') }}"
                            class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                        >
                            <i class="bi bi-briefcase text-xs opacity-70 transition group-hover:opacity-100"></i>
                            Jasa Saya
                        </a>

                        <a
                            href="{{ route('freelancer.messages.index') }}"
                            class="group flex items-center gap-2 text-sm text-white/55 transition hover:text-white"
                        >
                            <i class="bi bi-chat-dots text-xs opacity-70 transition group-hover:opacity-100"></i>
                            Pesan
                        </a>

                    @endif

                @endguest

            </div>

        </div>


        {{-- Bantuan --}}
        <div>

            <h3 class="text-sm font-semibold text-white">
                Bantuan
            </h3>

            <div class="mt-5 space-y-3">

                <a
                    href="#"
                    class="block text-sm text-white/55 transition hover:text-white"
                >
                    Pusat Bantuan
                </a>

                <a
                    href="#"
                    class="block text-sm text-white/55 transition hover:text-white"
                >
                    Cara Kerja
                </a>

                <a
                    href="#"
                    class="block text-sm text-white/55 transition hover:text-white"
                >
                    Ketentuan Layanan
                </a>

                <a
                    href="#"
                    class="block text-sm text-white/55 transition hover:text-white"
                >
                    Kebijakan Privasi
                </a>

            </div>

        </div>

    </div>

</div>


{{-- Bottom Footer --}}
<div class="border-t border-white/10">

    <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-5 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">

        <p class="text-xs text-white/45">
            © {{ date('Y') }} JASAIN. Semua hak dilindungi.
        </p>

        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-white/45">

            <span class="inline-flex items-center gap-1.5">
                <i class="bi bi-shield-check text-[#7AD8B5]"></i>
                Transaksi aman
            </span>

            <span class="inline-flex items-center gap-1.5">
                <i class="bi bi-people text-[#7AD8B5]"></i>
                Freelancer profesional
            </span>

            <span class="inline-flex items-center gap-1.5">
                <i class="bi bi-lightning-charge text-[#7AD8B5]"></i>
                Proses mudah
            </span>

        </div>

    </div>

</div>

</footer>
