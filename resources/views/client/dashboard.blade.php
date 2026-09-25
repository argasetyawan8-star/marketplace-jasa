<x-layouts.marketplace title="Dashboard Client - ProKerja">


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


<div class="min-h-screen bg-[#F8FAFC] pt-[48px] pb-10 md:pt-[52px] lg:pb-14">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


        {{-- =========================================================
            WELCOME
        ========================================================== --}}
        <section
            class="relative overflow-hidden rounded-3xl border border-[#DBEAFE] bg-white px-5 py-6 shadow-[0_8px_30px_rgba(15,23,42,0.04)] sm:px-7 sm:py-8 lg:px-9"
        >

            {{-- Background decoration --}}
            <div class="pointer-events-none absolute inset-0 overflow-hidden">

                <div
                    class="absolute -right-20 -top-24 h-64 w-64 rounded-full bg-[#DBEAFE] opacity-70 blur-3xl"
                ></div>

                <div
                    class="absolute -bottom-24 left-1/3 h-52 w-52 rounded-full bg-[#EFF6FF] opacity-90 blur-3xl"
                ></div>

            </div>


            <div class="relative grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">


                {{-- LEFT --}}
                <div class="min-w-0">

                    <div class="flex items-center gap-3">

                        <div class="relative shrink-0">

                            @if($avatarUrl)

                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="{{ $user->name }}"
                                    class="h-12 w-12 rounded-full object-cover ring-4 ring-[#EFF6FF]"
                                >

                            @else

                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-[#EFF6FF] text-sm font-semibold text-[#2563EB] ring-4 ring-[#F8FAFC]"
                                >
                                    {{ $initial }}
                                </div>

                            @endif

                            <span
                                class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-[#16A34A]"
                            ></span>

                        </div>


                        <div class="min-w-0">

                            <p
                                class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]"
                            >
                                Dashboard Client
                            </p>

                            <p class="mt-0.5 text-xs text-[#64748B]">
                                Selamat datang kembali
                            </p>

                        </div>

                    </div>


                    <h1
                        class="mt-5 text-2xl font-semibold tracking-[-0.035em] text-[#0F172A] sm:text-3xl lg:text-[34px]"
                    >
                        Halo, {{ $user->name }}.
                    </h1>


                    <p
                        class="mt-3 max-w-2xl text-sm leading-6 text-[#64748B] sm:text-[15px]"
                    >
                        Temukan freelancer yang tepat untuk membantu menyelesaikan
                        pekerjaan, project, dan kebutuhan profesionalmu.
                    </p>


                    {{-- SEARCH --}}
                    <form
                        action="{{ route('marketplace.search') }}"
                        method="GET"
                        class="mt-6 max-w-3xl"
                    >

                        <div
                            class="flex flex-col gap-2 rounded-2xl border border-[#E2E8F0] bg-white p-2 shadow-[0_8px_24px_rgba(15,23,42,0.06)] sm:flex-row"
                        >

                            <div class="flex min-w-0 flex-1 items-center">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                                >
                                    <i class="bi bi-search text-[15px]"></i>
                                </div>


                                <input
                                    type="text"
                                    name="q"
                                    placeholder="Cari jasa yang kamu butuhkan..."
                                    autocomplete="off"
                                    class="h-11 min-w-0 flex-1 border-0 bg-transparent px-3 text-sm text-[#0F172A] outline-none placeholder:text-[#94A3B8]"
                                >

                            </div>


                            <button
                                type="submit"
                                class="flex h-11 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-xs font-semibold text-white transition duration-200 hover:bg-[#1D4ED8] active:scale-[0.98]"
                            >
                                Cari jasa
                                <i class="bi bi-arrow-right text-[11px]"></i>
                            </button>

                        </div>

                    </form>


                    {{-- POPULAR --}}
                    <div class="mt-4 flex flex-wrap items-center gap-2">

                        <span class="mr-1 text-[10px] font-medium text-[#94A3B8]">
                            Populer:
                        </span>

                        @foreach([
                            'Logo Design',
                            'Website',
                            'Video Editing',
                            'Social Media',
                            'Copywriting',
                            'AI Services',
                        ] as $keyword)

                            <a
                                href="{{ route('marketplace.search', ['q' => $keyword]) }}"
                                class="rounded-full border border-[#E2E8F0] bg-white px-3 py-1.5 text-[10px] font-medium text-[#64748B] transition duration-200 hover:border-[#BFDBFE] hover:bg-[#EFF6FF] hover:text-[#2563EB]"
                            >
                                {{ $keyword }}
                            </a>

                        @endforeach

                    </div>

                </div>


                {{-- RIGHT VISUAL --}}
                <div class="hidden lg:flex lg:justify-end">

                    <div
                        class="relative flex h-40 w-40 items-center justify-center rounded-[30px] border border-[#DBEAFE] bg-[#F8FBFF]"
                    >

                        <div
                            class="absolute inset-4 rounded-[24px] border border-[#DBEAFE]"
                        ></div>


                        <div
                            class="relative flex h-24 w-24 items-center justify-center rounded-3xl bg-[#2563EB] shadow-[0_14px_30px_rgba(37,99,235,0.20)]"
                        >
                            <i class="bi bi-grid-1x2-fill text-4xl text-white"></i>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
            QUICK ACCESS
        ========================================================== --}}
        <section class="mt-10">

            <div class="mb-4">

                <p
                    class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]"
                >
                    Akses cepat
                </p>

                <h2
                    class="mt-1 text-lg font-semibold tracking-[-0.025em] text-[#0F172A]"
                >
                    Kelola aktivitasmu
                </h2>

                <p class="mt-1 text-xs text-[#64748B]">
                    Semua aktivitas penting client ada di satu tempat.
                </p>

            </div>


            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">


                {{-- ORDERS --}}
                <a
                    href="{{ route('client.orders.index') }}"
                    class="group rounded-2xl border border-[#E2E8F0] bg-white p-5 shadow-[0_5px_18px_rgba(15,23,42,0.035)] transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_12px_28px_rgba(15,23,42,0.07)]"
                >

                    <div class="flex items-start justify-between">

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-bag-check text-[17px]"></i>
                        </div>

                        <div
                            class="flex h-7 w-7 items-center justify-center rounded-full text-[#94A3B8] transition group-hover:bg-[#EFF6FF] group-hover:text-[#2563EB]"
                        >
                            <i class="bi bi-arrow-up-right text-[11px]"></i>
                        </div>

                    </div>


                    <h3 class="mt-5 text-sm font-semibold text-[#0F172A]">
                        Pesanan saya
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-[#64748B]">
                        Lihat, pantau, dan kelola pesanan yang sedang berjalan.
                    </p>


                    <div
                        class="mt-5 flex items-center gap-2 text-[11px] font-semibold text-[#2563EB]"
                    >
                        Buka pesanan
                        <i class="bi bi-arrow-right text-[10px]"></i>
                    </div>

                </a>


                {{-- FAVORITES --}}
                <a
                    href="{{ route('client.favorites.index') }}"
                    class="group rounded-2xl border border-[#E2E8F0] bg-white p-5 shadow-[0_5px_18px_rgba(15,23,42,0.035)] transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_12px_28px_rgba(15,23,42,0.07)]"
                >

                    <div class="flex items-start justify-between">

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-heart text-[17px]"></i>
                        </div>

                        <div
                            class="flex h-7 w-7 items-center justify-center rounded-full text-[#94A3B8] transition group-hover:bg-[#EFF6FF] group-hover:text-[#2563EB]"
                        >
                            <i class="bi bi-arrow-up-right text-[11px]"></i>
                        </div>

                    </div>


                    <h3 class="mt-5 text-sm font-semibold text-[#0F172A]">
                        Favorit
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-[#64748B]">
                        Simpan layanan yang menarik untuk dipertimbangkan nanti.
                    </p>


                    <div
                        class="mt-5 flex items-center gap-2 text-[11px] font-semibold text-[#2563EB]"
                    >
                        Lihat favorit
                        <i class="bi bi-arrow-right text-[10px]"></i>
                    </div>

                </a>


                {{-- MESSAGES --}}
                <a
                    href="{{ route('client.messages.index') }}"
                    class="group rounded-2xl border border-[#E2E8F0] bg-white p-5 shadow-[0_5px_18px_rgba(15,23,42,0.035)] transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_12px_28px_rgba(15,23,42,0.07)]"
                >

                    <div class="flex items-start justify-between">

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-chat-dots text-[17px]"></i>
                        </div>

                        <div
                            class="flex h-7 w-7 items-center justify-center rounded-full text-[#94A3B8] transition group-hover:bg-[#EFF6FF] group-hover:text-[#2563EB]"
                        >
                            <i class="bi bi-arrow-up-right text-[11px]"></i>
                        </div>

                    </div>


                    <h3 class="mt-5 text-sm font-semibold text-[#0F172A]">
                        Pesan
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-[#64748B]">
                        Lanjutkan percakapan dengan freelancer pilihanmu.
                    </p>


                    <div
                        class="mt-5 flex items-center gap-2 text-[11px] font-semibold text-[#2563EB]"
                    >
                        Buka pesan
                        <i class="bi bi-arrow-right text-[10px]"></i>
                    </div>

                </a>

            </div>

        </section>


        {{-- =========================================================
            DISCOVER
        ========================================================== --}}
        <section class="mt-12">

            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">

                <div>

                    <p
                        class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]"
                    >
                        Jelajahi
                    </p>

                    <h2
                        class="mt-1 text-xl font-semibold tracking-[-0.025em] text-[#0F172A]"
                    >
                        Temukan jasa yang sesuai
                    </h2>

                    <p class="mt-1.5 text-xs text-[#64748B]">
                        Mulai dari kebutuhan sederhana sampai project profesional.
                    </p>

                </div>


                <a
                    href="{{ route('marketplace.search') }}"
                    class="inline-flex items-center gap-2 text-xs font-semibold text-[#2563EB] transition hover:text-[#1D4ED8]"
                >
                    Lihat semua jasa
                    <i class="bi bi-arrow-right text-[11px]"></i>
                </a>

            </div>


            <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">


                {{-- DESIGN --}}
                <a
                    href="{{ route('marketplace.search', ['category' => 'desain']) }}"
                    class="group flex items-center gap-3 rounded-2xl border border-[#E2E8F0] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_8px_22px_rgba(15,23,42,0.05)]"
                >

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                    >
                        <i class="bi bi-palette text-[15px]"></i>
                    </div>


                    <div class="min-w-0">

                        <h3 class="truncate text-xs font-semibold text-[#0F172A]">
                            Desain
                        </h3>

                        <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                            Logo, branding, visual
                        </p>

                    </div>


                    <i
                        class="bi bi-arrow-up-right ml-auto text-[10px] text-[#94A3B8] transition group-hover:text-[#2563EB]"
                    ></i>

                </a>


                {{-- MARKETING --}}
                <a
                    href="{{ route('marketplace.search', ['category' => 'digital-marketing']) }}"
                    class="group flex items-center gap-3 rounded-2xl border border-[#E2E8F0] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_8px_22px_rgba(15,23,42,0.05)]"
                >

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                    >
                        <i class="bi bi-megaphone text-[15px]"></i>
                    </div>


                    <div class="min-w-0">

                        <h3 class="truncate text-xs font-semibold text-[#0F172A]">
                            Digital Marketing
                        </h3>

                        <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                            Sosial media, iklan
                        </p>

                    </div>


                    <i
                        class="bi bi-arrow-up-right ml-auto text-[10px] text-[#94A3B8] transition group-hover:text-[#2563EB]"
                    ></i>

                </a>


                {{-- WRITING --}}
                <a
                    href="{{ route('marketplace.search', ['category' => 'penulisan']) }}"
                    class="group flex items-center gap-3 rounded-2xl border border-[#E2E8F0] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_8px_22px_rgba(15,23,42,0.05)]"
                >

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                    >
                        <i class="bi bi-pencil-square text-[15px]"></i>
                    </div>


                    <div class="min-w-0">

                        <h3 class="truncate text-xs font-semibold text-[#0F172A]">
                            Penulisan
                        </h3>

                        <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                            Artikel, copywriting
                        </p>

                    </div>


                    <i
                        class="bi bi-arrow-up-right ml-auto text-[10px] text-[#94A3B8] transition group-hover:text-[#2563EB]"
                    ></i>

                </a>


                {{-- BUSINESS --}}
                <a
                    href="{{ route('marketplace.search', ['category' => 'bisnis']) }}"
                    class="group flex items-center gap-3 rounded-2xl border border-[#E2E8F0] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_8px_22px_rgba(15,23,42,0.05)]"
                >

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                    >
                        <i class="bi bi-briefcase text-[15px]"></i>
                    </div>


                    <div class="min-w-0">

                        <h3 class="truncate text-xs font-semibold text-[#0F172A]">
                            Bisnis
                        </h3>

                        <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                            Konsultasi, strategi
                        </p>

                    </div>


                    <i
                        class="bi bi-arrow-up-right ml-auto text-[10px] text-[#94A3B8] transition group-hover:text-[#2563EB]"
                    ></i>

                </a>

            </div>

        </section>


        {{-- =========================================================
            JOB BOARD
        ========================================================== --}}
        <section class="mt-12">

            <div
                class="overflow-hidden rounded-3xl border border-[#DBEAFE] bg-white shadow-[0_8px_30px_rgba(15,23,42,0.04)]"
            >

                <div class="grid gap-0 lg:grid-cols-[1fr_auto] lg:items-center">

                    <div class="px-6 py-7 sm:px-8 sm:py-8">

                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-[#EFF6FF] px-3 py-1.5 text-[10px] font-semibold text-[#2563EB]"
                        >
                            <i class="bi bi-briefcase-fill text-[10px]"></i>
                            Job Board
                        </div>


                        <h2
                            class="mt-4 text-xl font-semibold tracking-[-0.025em] text-[#0F172A] sm:text-2xl"
                        >
                            Punya project khusus?
                        </h2>


                        <p
                            class="mt-2 max-w-2xl text-sm leading-6 text-[#64748B]"
                        >
                            Buat project dan biarkan freelancer mengirim proposal
                            sesuai kebutuhan yang kamu tentukan.
                        </p>


                        <div class="mt-5 flex flex-wrap gap-3">

                            <a
                                href="{{ route('marketplace.jobs.index') }}"
                                class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-[#BFDBFE] bg-[#EFF6FF] px-4 text-xs font-semibold text-[#2563EB] transition hover:bg-[#DBEAFE]"
                            >
                                Lihat Job Board
                                <i class="bi bi-arrow-right text-[10px]"></i>
                            </a>


                            <a
                                href="{{ route('client.jobs.create') }}"
                                class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-xs font-semibold text-white transition hover:bg-[#1D4ED8]"
                            >
                                Buat project
                                <i class="bi bi-plus-lg text-[10px]"></i>
                            </a>

                        </div>

                    </div>


                    <div class="hidden px-8 lg:block">

                        <div
                            class="flex h-36 w-36 items-center justify-center rounded-[28px] bg-[#EFF6FF]"
                        >
                            <i class="bi bi-kanban-fill text-5xl text-[#2563EB]"></i>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
            BOTTOM CTA
        ========================================================== --}}
        <section class="mt-10">

            <div
                class="overflow-hidden rounded-3xl border border-[#DBEAFE] bg-[#EFF6FF] px-6 py-7 sm:px-8 sm:py-8"
            >

                <div
                    class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between"
                >

                    <div class="max-w-2xl">

                        <p
                            class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]"
                        >
                            Butuh bantuan?
                        </p>


                        <h2
                            class="mt-2 text-xl font-semibold tracking-[-0.025em] text-[#0F172A] sm:text-2xl"
                        >
                            Temukan freelancer untuk project-mu.
                        </h2>


                        <p
                            class="mt-2 text-sm leading-6 text-[#64748B]"
                        >
                            Cari berdasarkan layanan, kategori, harga, dan pengalaman
                            freelancer.
                        </p>

                    </div>


                    <a
                        href="{{ route('marketplace.search') }}"
                        class="inline-flex h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-xs font-semibold text-white shadow-[0_6px_18px_rgba(37,99,235,0.16)] transition duration-200 hover:bg-[#1D4ED8] hover:shadow-[0_8px_24px_rgba(37,99,235,0.20)]"
                    >
                        Mulai cari jasa
                        <i class="bi bi-arrow-right text-[11px]"></i>
                    </a>

                </div>

            </div>

        </section>


    </div>

</div>


</x-layouts.marketplace>
