<footer class="bg-[#0A4D2A] text-white">

    {{-- Main footer --}}
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">

        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-[1.4fr_0.8fr_0.8fr_0.8fr]">

            {{-- Brand --}}
            <div class="max-w-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#1E9E5A] text-sm font-semibold text-white">
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
                </div>

                <p class="mt-5 text-sm leading-6 text-white/60">
                    Platform untuk menemukan freelancer profesional
                    dan berbagai layanan jasa sesuai kebutuhanmu.
                </p>

                <div class="mt-6 flex items-center gap-2">
                    <a
                        href="#"
                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 transition hover:border-white/20 hover:bg-white/5 hover:text-white"
                    >
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a
                        href="#"
                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 transition hover:border-white/20 hover:bg-white/5 hover:text-white"
                    >
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a
                        href="#"
                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 transition hover:border-white/20 hover:bg-white/5 hover:text-white"
                    >
                        <i class="bi bi-linkedin"></i>
                    </a>

                    <a
                        href="#"
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
                        class="block text-sm text-white/55 transition hover:text-white"
                    >
                        Beranda
                    </a>

                    <a
                        href="{{ route('marketplace.search') }}"
                        class="block text-sm text-white/55 transition hover:text-white"
                    >
                        Cari Jasa
                    </a>

                    @guest
                        <a
                            href="{{ route('register') }}"
                            class="block text-sm text-white/55 transition hover:text-white"
                        >
                            Daftar
                        </a>
                    @endguest
                </div>
            </div>


            {{-- Untuk pengguna --}}
            <div>
                <h3 class="text-sm font-semibold text-white">
                    Untuk Pengguna
                </h3>

                <div class="mt-5 space-y-3">

                    @guest
                        <a
                            href="{{ route('login') }}"
                            class="block text-sm text-white/55 transition hover:text-white"
                        >
                            Masuk
                        </a>
                    @else
                        @if (auth()->user()->role === 'client')
                            <a
                                href="{{ route('client.dashboard') }}"
                                class="block text-sm text-white/55 transition hover:text-white"
                            >
                                Dashboard
                            </a>

                            <a
                                href="{{ route('client.orders.index') }}"
                                class="block text-sm text-white/55 transition hover:text-white"
                            >
                                Pesanan
                            </a>

                            <a
                                href="{{ route('client.messages.index') }}"
                                class="block text-sm text-white/55 transition hover:text-white"
                            >
                                Pesan
                            </a>
                        @elseif (auth()->user()->role === 'freelancer')
                            <a
                                href="{{ route('freelancer.dashboard') }}"
                                class="block text-sm text-white/55 transition hover:text-white"
                            >
                                Dashboard
                            </a>

                            <a
                                href="{{ route('freelancer.services.index') }}"
                                class="block text-sm text-white/55 transition hover:text-white"
                            >
                                Jasa Saya
                            </a>

                            <a
                                href="{{ route('freelancer.messages.index') }}"
                                class="block text-sm text-white/55 transition hover:text-white"
                            >
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


    {{-- Bottom --}}
    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-5 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">

            <p class="text-xs text-white/45">
                © {{ date('Y') }} JASAIN. Semua hak dilindungi.
            </p>

            <div class="flex items-center gap-5 text-xs text-white/45">
                <span class="inline-flex items-center gap-1.5">
                    <i class="bi bi-shield-check text-[#7AD8B5]"></i>
                    Transaksi aman
                </span>

                <span class="inline-flex items-center gap-1.5">
                    <i class="bi bi-people text-[#7AD8B5]"></i>
                    Freelancer profesional
                </span>
            </div>

        </div>
    </div>

</footer>