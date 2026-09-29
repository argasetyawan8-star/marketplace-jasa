
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

    <div
        class="min-h-screen bg-[#F8FAFC] pt-[48px] pb-10 md:pt-[52px] lg:pb-14"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- =========================================================
                PROFILE HEADER
            ========================================================== --}}
            <section class="border-b border-[#E2E8F0] bg-[#F8FAFC] py-5 sm:py-6">
                <div class="flex items-center justify-between gap-4">

                    <div class="flex min-w-0 items-center gap-3">
                        <div class="relative shrink-0">
                            @if($avatarUrl)
                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="{{ $user->name }}"
                                    class="h-12 w-12 rounded-full object-cover ring-2 ring-white shadow-sm"
                                >
                            @else
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-[#DBEAFE] text-sm font-bold text-[#2563EB] ring-2 ring-white"
                                >
                                    {{ $initial }}
                                </div>
                            @endif

                            <span
                                class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-[#F8FAFC] bg-[#22C55E]"
                            ></span>
                        </div>

                        <div class="min-w-0">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#2563EB]">
                                Dashboard Client
                            </p>

                            <h1 class="mt-0.5 truncate text-base font-semibold tracking-[-0.02em] text-[#0F172A] sm:text-lg">
                                {{ $user->name }}
                            </h1>
                        </div>
                    </div>

                    <a
                        href="{{ route('marketplace.search') }}"
                        class="inline-flex h-10 shrink-0 items-center gap-2 rounded-xl bg-[#2563EB] px-4 text-xs font-semibold text-white transition hover:bg-[#1D4ED8] active:scale-[0.98]"
                    >
                        <i class="bi bi-search text-[11px]"></i>
                        <span class="hidden sm:inline">Cari jasa</span>
                        <span class="sm:hidden">Cari</span>
                    </a>

                </div>
            </section>


            {{-- =========================================================
                SEARCH
            ========================================================== --}}
            <section class="py-6 sm:py-8">
                <div class="max-w-3xl">

                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]">
                            Mulai dari sini
                        </p>

                        <h2 class="mt-1 text-2xl font-semibold tracking-[-0.035em] text-[#0F172A] sm:text-3xl">
                            Temukan jasa yang kamu butuhkan
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-[#64748B]">
                            Cari freelancer berdasarkan layanan, kategori, atau keahlian.
                        </p>
                    </div>

                    <form
                        action="{{ route('marketplace.search') }}"
                        method="GET"
                        class="mt-5"
                    >
                        <div
                            class="flex flex-col gap-2 rounded-2xl border border-[#E2E8F0] bg-white p-2 shadow-[0_6px_22px_rgba(15,23,42,0.045)] sm:flex-row"
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
                                    placeholder="Cari jasa, keahlian, atau freelancer..."
                                    autocomplete="off"
                                    class="h-11 min-w-0 flex-1 border-0 bg-transparent px-3 text-sm text-[#0F172A] outline-none placeholder:text-[#94A3B8]"
                                >
                            </div>

                            <button
                                type="submit"
                                class="flex h-11 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-xs font-semibold text-white transition hover:bg-[#1D4ED8] active:scale-[0.98]"
                            >
                                Cari jasa
                                <i class="bi bi-arrow-right text-[10px]"></i>
                            </button>
                        </div>
                    </form>

                    <div class="mt-3 flex flex-wrap items-center gap-2">
                        <span class="mr-1 text-[10px] font-medium text-[#94A3B8]">
                            Populer
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
                                class="rounded-full border border-[#E2E8F0] bg-white px-3 py-1.5 text-[10px] font-medium text-[#64748B] transition hover:border-[#BFDBFE] hover:bg-[#EFF6FF] hover:text-[#2563EB]"
                            >
                                {{ $keyword }}
                            </a>
                        @endforeach
                    </div>

                </div>
            </section>


            {{-- =========================================================
                QUICK ACCESS
            ========================================================== --}}
            <section class="border-y border-[#E2E8F0] py-6 sm:py-8">

                <div class="mb-4 flex items-end justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]">
                            Aktivitas
                        </p>

                        <h2 class="mt-1 text-lg font-semibold tracking-[-0.025em] text-[#0F172A]">
                            Akses cepat
                        </h2>
                    </div>
                </div>

                <div class="divide-y divide-[#E2E8F0] overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white sm:grid sm:grid-cols-3 sm:divide-x sm:divide-y-0">

                    {{-- ORDERS --}}
                    <a
                        href="{{ route('client.orders.index') }}"
                        class="group flex items-center gap-4 p-4 transition hover:bg-[#F8FBFF] sm:p-5"
                    >
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-bag-check text-[17px]"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-semibold text-[#0F172A]">
                                Pesanan saya
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#64748B]">
                                Pantau pesanan yang sedang berjalan.
                            </p>
                        </div>

                        <i class="bi bi-chevron-right shrink-0 text-[11px] text-[#94A3B8] transition group-hover:text-[#2563EB]"></i>
                    </a>


                    {{-- FAVORITES --}}
                    <a
                        href="{{ route('client.favorites.index') }}"
                        class="group flex items-center gap-4 p-4 transition hover:bg-[#F8FBFF] sm:p-5"
                    >
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-heart text-[17px]"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-semibold text-[#0F172A]">
                                Favorit
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#64748B]">
                                Simpan jasa yang ingin kamu pertimbangkan.
                            </p>
                        </div>

                        <i class="bi bi-chevron-right shrink-0 text-[11px] text-[#94A3B8] transition group-hover:text-[#2563EB]"></i>
                    </a>


                    {{-- MESSAGES --}}
                    <a
                        href="{{ route('client.messages.index') }}"
                        class="group flex items-center gap-4 p-4 transition hover:bg-[#F8FBFF] sm:p-5"
                    >
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-chat-dots text-[17px]"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-semibold text-[#0F172A]">
                                Pesan
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#64748B]">
                                Lanjutkan percakapan dengan freelancer.
                            </p>
                        </div>

                        <i class="bi bi-chevron-right shrink-0 text-[11px] text-[#94A3B8] transition group-hover:text-[#2563EB]"></i>
                    </a>

                </div>
            </section>


            {{-- =========================================================
                DISCOVER CATEGORIES
            ========================================================== --}}
            <section class="py-8 sm:py-10">

                <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">

                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]">
                            Jelajahi
                        </p>

                        <h2 class="mt-1 text-xl font-semibold tracking-[-0.025em] text-[#0F172A]">
                            Kategori populer
                        </h2>

                        <p class="mt-1.5 text-xs text-[#64748B]">
                            Temukan layanan berdasarkan kebutuhanmu.
                        </p>
                    </div>

                    <a
                        href="{{ route('marketplace.search') }}"
                        class="inline-flex w-fit items-center gap-2 text-xs font-semibold text-[#2563EB] transition hover:text-[#1D4ED8]"
                    >
                        Lihat semua
                        <i class="bi bi-arrow-right text-[10px]"></i>
                    </a>

                </div>


                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">

                    {{-- DESIGN --}}
                    <a
                        href="{{ route('marketplace.search', ['category' => 'desain']) }}"
                        class="group flex items-center gap-3 rounded-2xl border border-[#E2E8F0] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_8px_22px_rgba(15,23,42,0.05)]"
                    >
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                            <i class="bi bi-palette text-[15px]"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="truncate text-xs font-semibold text-[#0F172A]">
                                Desain
                            </h3>

                            <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                                Logo, branding, visual
                            </p>
                        </div>

                        <i class="bi bi-arrow-up-right shrink-0 text-[10px] text-[#94A3B8] transition group-hover:text-[#2563EB]"></i>
                    </a>


                    {{-- MARKETING --}}
                    <a
                        href="{{ route('marketplace.search', ['category' => 'digital-marketing']) }}"
                        class="group flex items-center gap-3 rounded-2xl border border-[#E2E8F0] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_8px_22px_rgba(15,23,42,0.05)]"
                    >
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                            <i class="bi bi-megaphone text-[15px]"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="truncate text-xs font-semibold text-[#0F172A]">
                                Digital Marketing
                            </h3>

                            <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                                Sosial media, iklan
                            </p>
                        </div>

                        <i class="bi bi-arrow-up-right shrink-0 text-[10px] text-[#94A3B8] transition group-hover:text-[#2563EB]"></i>
                    </a>


                    {{-- WRITING --}}
                    <a
                        href="{{ route('marketplace.search', ['category' => 'penulisan']) }}"
                        class="group flex items-center gap-3 rounded-2xl border border-[#E2E8F0] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_8px_22px_rgba(15,23,42,0.05)]"
                    >
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                            <i class="bi bi-pencil-square text-[15px]"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="truncate text-xs font-semibold text-[#0F172A]">
                                Penulisan
                            </h3>

                            <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                                Artikel, copywriting
                            </p>
                        </div>

                        <i class="bi bi-arrow-up-right shrink-0 text-[10px] text-[#94A3B8] transition group-hover:text-[#2563EB]"></i>
                    </a>


                    {{-- BUSINESS --}}
                    <a
                        href="{{ route('marketplace.search', ['category' => 'bisnis']) }}"
                        class="group flex items-center gap-3 rounded-2xl border border-[#E2E8F0] bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-[#BFDBFE] hover:shadow-[0_8px_22px_rgba(15,23,42,0.05)]"
                    >
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                            <i class="bi bi-briefcase text-[15px]"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="truncate text-xs font-semibold text-[#0F172A]">
                                Bisnis
                            </h3>

                            <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                                Konsultasi, strategi
                            </p>
                        </div>

                        <i class="bi bi-arrow-up-right shrink-0 text-[10px] text-[#94A3B8] transition group-hover:text-[#2563EB]"></i>
                    </a>

                </div>
            </section>


            {{-- =========================================================
                JOB BOARD
            ========================================================== --}}
            <section class="border-t border-[#E2E8F0] py-8 sm:py-10">

                <div class="overflow-hidden rounded-2xl border border-[#DBEAFE] bg-white">

                    <div class="grid lg:grid-cols-[1fr_auto] lg:items-center">

                        <div class="p-6 sm:p-8">

                            <div class="inline-flex items-center gap-2 rounded-full bg-[#EFF6FF] px-3 py-1.5 text-[10px] font-semibold text-[#2563EB]">
                                <i class="bi bi-briefcase-fill text-[10px]"></i>
                                Job Board
                            </div>

                            <h2 class="mt-4 text-xl font-semibold tracking-[-0.025em] text-[#0F172A] sm:text-2xl">
                                Punya project khusus?
                            </h2>

                            <p class="mt-2 max-w-2xl text-sm leading-6 text-[#64748B]">
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
                            <div class="flex h-32 w-32 items-center justify-center rounded-[26px] bg-[#EFF6FF]">
                                <i class="bi bi-kanban-fill text-5xl text-[#2563EB]"></i>
                            </div>
                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                FINAL CTA
            ========================================================== --}}
            <section class="pb-4 sm:pb-6">

                <div class="flex flex-col gap-4 border-t border-[#E2E8F0] pt-7 sm:flex-row sm:items-center sm:justify-between">

                    <div class="max-w-2xl">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]">
                            Siap mulai?
                        </p>

                        <h2 class="mt-1 text-lg font-semibold tracking-[-0.025em] text-[#0F172A]">
                            Temukan freelancer untuk project-mu.
                        </h2>

                        <p class="mt-1 text-xs leading-5 text-[#64748B]">
                            Cari layanan yang sesuai dengan kebutuhan dan budget project kamu.
                        </p>
                    </div>

                    <a
                        href="{{ route('marketplace.search') }}"
                        class="inline-flex h-10 w-fit shrink-0 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-xs font-semibold text-white shadow-[0_5px_16px_rgba(37,99,235,0.14)] transition hover:bg-[#1D4ED8] hover:shadow-[0_7px_20px_rgba(37,99,235,0.18)]"
                    >
                        Mulai cari jasa
                        <i class="bi bi-arrow-right text-[10px]"></i>
                    </a>

                </div>

            </section>

        </div>
    </div>

</x-layouts.marketplace>
