<x-layouts.client title="Dashboard">

    @php
        $user = auth()->user();

        $profile = $user?->profile;

        $avatarUrl = $profile?->avatar
            ? asset('storage/' . $profile->avatar)
            : null;

        $initial = strtoupper(
            substr($user?->name ?: 'U', 0, 1)
        );
    @endphp


    <div class="min-h-screen bg-[#F8FCF9]">

        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">


            {{-- =========================================================
                WELCOME HERO
            ========================================================== --}}
            <section class="relative overflow-hidden rounded-[28px] bg-[#123128] shadow-[0_14px_45px_rgba(18,49,40,0.10)]">

                {{-- Decorative shapes --}}
                <div class="pointer-events-none absolute inset-0 overflow-hidden">

                    <div class="absolute -right-20 -top-24 h-72 w-72 rounded-full bg-[#1E9E5A]/20 blur-3xl"></div>

                    <div class="absolute -bottom-28 left-[42%] h-64 w-64 rounded-full bg-[#7AD8B5]/10 blur-3xl"></div>

                    <div class="absolute right-[22%] top-1/2 hidden h-28 w-28 -translate-y-1/2 rounded-full border border-white/[0.05] lg:block"></div>

                </div>


                <div class="relative px-6 py-7 sm:px-8 sm:py-9 lg:px-10 lg:py-10">

                    <div class="max-w-3xl">

                        {{-- Profile mini --}}
                        <div class="flex items-center gap-3">

                            <div class="relative shrink-0">

                                @if($avatarUrl)

                                    <img
                                        src="{{ $avatarUrl }}"
                                        alt="{{ $user->name }}"
                                        class="h-11 w-11 rounded-full object-cover ring-4 ring-white/10"
                                    >

                                @else

                                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-sm font-semibold text-white ring-4 ring-white/10">
                                        {{ $initial }}
                                    </div>

                                @endif

                                <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-[#123128] bg-[#35C978]"></span>

                            </div>


                            <div>

                                <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#7AD8B5]">
                                    Dashboard Client
                                </p>

                                <p class="mt-0.5 text-xs text-white/55">
                                    Senang melihatmu kembali
                                </p>

                            </div>

                        </div>


                        {{-- Heading --}}
                        <h1 class="mt-6 text-[28px] font-semibold tracking-[-0.035em] text-white sm:text-3xl lg:text-[36px]">
                            Halo, {{ $user->name }}.
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-white/60">
                            Cari freelancer terbaik untuk menyelesaikan pekerjaanmu dengan lebih cepat,
                            mudah, dan aman.
                        </p>


                        {{-- Search --}}
                        <form
                            action="{{ route('marketplace.search') }}"
                            method="GET"
                            class="mt-6 max-w-2xl"
                        >

                            <div class="flex flex-col gap-2 rounded-2xl bg-white p-2 shadow-[0_10px_30px_rgba(0,0,0,0.14)] sm:flex-row">

                                <div class="flex min-w-0 flex-1 items-center">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                        <i class="bi bi-search text-[15px]"></i>
                                    </div>

                                    <input
                                        type="text"
                                        name="q"
                                        placeholder="Apa yang sedang kamu cari?"
                                        class="h-11 min-w-0 flex-1 border-0 bg-transparent px-3 text-sm text-[#123128] outline-none placeholder:text-[#9BA9A3]"
                                    >

                                </div>


                                <button
                                    type="submit"
                                    class="flex h-11 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 text-xs font-semibold text-white transition duration-200 hover:bg-[#0F6B3A]"
                                >
                                    Cari jasa

                                    <i class="bi bi-arrow-right text-[11px]"></i>
                                </button>

                            </div>

                        </form>


                        {{-- Quick links --}}
                        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2">

                            <span class="text-[10px] text-white/40">
                                Mulai dari:
                            </span>

                            <a
                                href="{{ route('marketplace.search') }}"
                                class="text-[10px] font-medium text-white/65 transition hover:text-white"
                            >
                                Desain
                            </a>

                            <span class="text-white/20">•</span>

                            <a
                                href="{{ route('marketplace.search') }}"
                                class="text-[10px] font-medium text-white/65 transition hover:text-white"
                            >
                                Website
                            </a>

                            <span class="text-white/20">•</span>

                            <a
                                href="{{ route('marketplace.search') }}"
                                class="text-[10px] font-medium text-white/65 transition hover:text-white"
                            >
                                Marketing
                            </a>

                            <span class="text-white/20">•</span>

                            <a
                                href="{{ route('marketplace.search') }}"
                                class="text-[10px] font-medium text-white/65 transition hover:text-white"
                            >
                                Penulisan
                            </a>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =========================================================
                QUICK ACTIONS
            ========================================================== --}}
            <section class="mt-8">

                <div class="flex items-end justify-between">

                    <div>

                        <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                            Aktivitas
                        </p>

                        <h2 class="mt-1 text-lg font-semibold tracking-[-0.025em] text-[#123128]">
                            Apa yang ingin kamu lakukan?
                        </h2>

                    </div>

                </div>


                <div class="mt-4 grid gap-4 sm:grid-cols-3">


                    {{-- Pesanan --}}
                    <a
                        href="{{ route('client.orders.index') }}"
                        class="group rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] transition duration-200 hover:-translate-y-0.5 hover:border-[#CDE3D5] hover:shadow-[0_10px_28px_rgba(18,49,40,0.06)]"
                    >

                        <div class="flex items-center justify-between">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                <i class="bi bi-bag-check text-[17px]"></i>
                            </div>

                            <div class="flex h-7 w-7 items-center justify-center rounded-full text-[#A0ADA7] transition duration-200 group-hover:bg-[#EAF7EF] group-hover:text-[#1E9E5A]">
                                <i class="bi bi-arrow-up-right text-[11px] transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
                            </div>

                        </div>

                        <h3 class="mt-5 text-sm font-semibold text-[#18382E]">
                            Pesanan saya
                        </h3>

                        <p class="mt-1.5 text-xs leading-5 text-[#899890]">
                            Pantau pesanan, progres pekerjaan, dan hasil yang sedang dikerjakan freelancer.
                        </p>

                    </a>


                    {{-- Pesan --}}
                    <a
                        href="{{ route('client.messages.index') }}"
                        class="group rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] transition duration-200 hover:-translate-y-0.5 hover:border-[#CDE3D5] hover:shadow-[0_10px_28px_rgba(18,49,40,0.06)]"
                    >

                        <div class="flex items-center justify-between">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F0F7F3] text-[#1E9E5A]">
                                <i class="bi bi-chat-dots text-[17px]"></i>
                            </div>

                            <div class="flex h-7 w-7 items-center justify-center rounded-full text-[#A0ADA7] transition duration-200 group-hover:bg-[#EAF7EF] group-hover:text-[#1E9E5A]">
                                <i class="bi bi-arrow-up-right text-[11px] transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
                            </div>

                        </div>

                        <h3 class="mt-5 text-sm font-semibold text-[#18382E]">
                            Pesan
                        </h3>

                        <p class="mt-1.5 text-xs leading-5 text-[#899890]">
                            Diskusikan kebutuhan pekerjaan dan terima penawaran dari freelancer.
                        </p>

                    </a>


                    {{-- Favorit --}}
                    <a
                        href="{{ route('client.favorites.index') }}"
                        class="group rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] transition duration-200 hover:-translate-y-0.5 hover:border-[#CDE3D5] hover:shadow-[0_10px_28px_rgba(18,49,40,0.06)]"
                    >

                        <div class="flex items-center justify-between">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F0F7F3] text-[#1E9E5A]">
                                <i class="bi bi-heart text-[17px]"></i>
                            </div>

                            <div class="flex h-7 w-7 items-center justify-center rounded-full text-[#A0ADA7] transition duration-200 group-hover:bg-[#EAF7EF] group-hover:text-[#1E9E5A]">
                                <i class="bi bi-arrow-up-right text-[11px] transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
                            </div>

                        </div>

                        <h3 class="mt-5 text-sm font-semibold text-[#18382E]">
                            Favorit
                        </h3>

                        <p class="mt-1.5 text-xs leading-5 text-[#899890]">
                            Simpan jasa yang menarik agar mudah ditemukan kembali kapan saja.
                        </p>

                    </a>

                </div>

            </section>



            {{-- =========================================================
                MARKETPLACE INTRO
            ========================================================== --}}
            <section class="mt-12">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                            Marketplace
                        </p>

                        <h2 class="mt-1 text-xl font-semibold tracking-[-0.03em] text-[#123128]">
                            Temukan jasa untuk kebutuhanmu
                        </h2>

                        <p class="mt-1.5 text-xs leading-5 text-[#899890]">
                            Dari pekerjaan kreatif hingga kebutuhan bisnis sehari-hari.
                        </p>

                    </div>


                    <a
                        href="{{ route('marketplace.search') }}"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-[#1E9E5A] transition hover:text-[#0F6B3A]"
                    >
                        Jelajahi semua
                        <i class="bi bi-arrow-right text-[11px]"></i>
                    </a>

                </div>


                {{-- Category visual shortcuts --}}
                <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">


                    {{-- Design --}}
                    <a
                        href="{{ route('marketplace.search') }}"
                        class="group relative overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white p-5 transition duration-200 hover:border-[#CDE3D5] hover:shadow-[0_10px_25px_rgba(18,49,40,0.05)]"
                    >

                        <div class="flex items-center justify-between">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                <i class="bi bi-palette text-[16px]"></i>
                            </div>

                            <i class="bi bi-arrow-up-right text-[11px] text-[#A1AEA8] transition group-hover:text-[#1E9E5A]"></i>

                        </div>

                        <h3 class="mt-5 text-sm font-semibold text-[#18382E]">
                            Desain & Kreatif
                        </h3>

                        <p class="mt-1.5 text-xs leading-5 text-[#8B9A93]">
                            Logo, branding, ilustrasi, dan kebutuhan visual.
                        </p>

                    </a>


                    {{-- Technology --}}
                    <a
                        href="{{ route('marketplace.search') }}"
                        class="group relative overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white p-5 transition duration-200 hover:border-[#CDE3D5] hover:shadow-[0_10px_25px_rgba(18,49,40,0.05)]"
                    >

                        <div class="flex items-center justify-between">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                <i class="bi bi-code-slash text-[16px]"></i>
                            </div>

                            <i class="bi bi-arrow-up-right text-[11px] text-[#A1AEA8] transition group-hover:text-[#1E9E5A]"></i>

                        </div>

                        <h3 class="mt-5 text-sm font-semibold text-[#18382E]">
                            Teknologi
                        </h3>

                        <p class="mt-1.5 text-xs leading-5 text-[#8B9A93]">
                            Website, aplikasi, software, dan solusi digital.
                        </p>

                    </a>


                    {{-- Marketing --}}
                    <a
                        href="{{ route('marketplace.search') }}"
                        class="group relative overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white p-5 transition duration-200 hover:border-[#CDE3D5] hover:shadow-[0_10px_25px_rgba(18,49,40,0.05)]"
                    >

                        <div class="flex items-center justify-between">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                <i class="bi bi-megaphone text-[16px]"></i>
                            </div>

                            <i class="bi bi-arrow-up-right text-[11px] text-[#A1AEA8] transition group-hover:text-[#1E9E5A]"></i>

                        </div>

                        <h3 class="mt-5 text-sm font-semibold text-[#18382E]">
                            Marketing
                        </h3>

                        <p class="mt-1.5 text-xs leading-5 text-[#8B9A93]">
                            Sosial media, iklan, konten, dan strategi pemasaran.
                        </p>

                    </a>


                    {{-- Business --}}
                    <a
                        href="{{ route('marketplace.search') }}"
                        class="group relative overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white p-5 transition duration-200 hover:border-[#CDE3D5] hover:shadow-[0_10px_25px_rgba(18,49,40,0.05)]"
                    >

                        <div class="flex items-center justify-between">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                <i class="bi bi-briefcase text-[16px]"></i>
                            </div>

                            <i class="bi bi-arrow-up-right text-[11px] text-[#A1AEA8] transition group-hover:text-[#1E9E5A]"></i>

                        </div>

                        <h3 class="mt-5 text-sm font-semibold text-[#18382E]">
                            Bisnis
                        </h3>

                        <p class="mt-1.5 text-xs leading-5 text-[#8B9A93]">
                            Konsultasi, administrasi, riset, dan kebutuhan bisnis.
                        </p>

                    </a>

                </div>

            </section>



            {{-- =========================================================
                TRUST / INFO
            ========================================================== --}}
            <section class="mt-12">

                <div class="rounded-3xl border border-[#DDEAE2] bg-white p-6 shadow-[0_5px_20px_rgba(18,49,40,0.035)] sm:p-8">

                    <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">

                        <div class="max-w-lg">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                                JASAIN
                            </p>

                            <h2 class="mt-2 text-xl font-semibold tracking-[-0.025em] text-[#123128]">
                                Semua kebutuhan jasa, dalam satu tempat.
                            </h2>

                            <p class="mt-2.5 text-sm leading-6 text-[#7D8E87]">
                                Temukan freelancer, diskusikan kebutuhanmu, terima penawaran,
                                lalu kelola pekerjaanmu melalui satu platform.
                            </p>

                        </div>


                        <div class="grid grid-cols-3 divide-x divide-[#E7EEE9]">

                            <div class="px-5 text-center sm:px-8">

                                <div class="flex justify-center text-[#1E9E5A]">
                                    <i class="bi bi-people text-xl"></i>
                                </div>

                                <p class="mt-2 text-[11px] font-semibold text-[#355248]">
                                    Freelancer
                                </p>

                            </div>


                            <div class="px-5 text-center sm:px-8">

                                <div class="flex justify-center text-[#1E9E5A]">
                                    <i class="bi bi-chat-square-text text-xl"></i>
                                </div>

                                <p class="mt-2 text-[11px] font-semibold text-[#355248]">
                                    Diskusi
                                </p>

                            </div>


                            <div class="px-5 text-center sm:px-8">

                                <div class="flex justify-center text-[#1E9E5A]">
                                    <i class="bi bi-shield-check text-xl"></i>
                                </div>

                                <p class="mt-2 text-[11px] font-semibold text-[#355248]">
                                    Aman
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =========================================================
                FINAL CTA
            ========================================================== --}}
            <section class="mt-8">

                <div class="relative overflow-hidden rounded-3xl bg-[#EAF7EF] px-6 py-8 sm:px-8 lg:px-10">

                    <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

                        <div class="max-w-2xl">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                                Siap mulai?
                            </p>

                            <h2 class="mt-2 text-xl font-semibold tracking-[-0.025em] text-[#123128] sm:text-2xl">
                                Cari freelancer untuk pekerjaanmu hari ini.
                            </h2>

                            <p class="mt-2 text-xs leading-5 text-[#71837B]">
                                Jelajahi jasa yang tersedia dan temukan orang yang tepat untuk membantumu.
                            </p>

                        </div>


                        <a
                            href="{{ route('marketplace.search') }}"
                            class="inline-flex h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 text-xs font-semibold text-white shadow-[0_5px_18px_rgba(30,158,90,0.15)] transition duration-200 hover:bg-[#0F6B3A]"
                        >
                            Cari jasa
                            <i class="bi bi-arrow-right text-[11px]"></i>
                        </a>

                    </div>

                </div>

            </section>


        </div>

    </div>

</x-layouts.client>