<x-layouts.admin title="Dashboard">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                        <i class="bi bi-grid-1x2"></i>
                        Admin Panel
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        Dashboard
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#71837B]">
                        Pantau aktivitas marketplace dan kelola seluruh operasional JASAIN dari satu tempat.
                    </p>
                </div>

                <div class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A] sm:flex">
                    <i class="bi bi-speedometer2 text-xl"></i>
                </div>

            </div>
        </div>

        {{-- Overview --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Users --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6">
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm text-[#71837B]">
                            Total Pengguna
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-[#123128]">
                            0
                        </p>

                        <p class="mt-3 text-xs text-[#8A9B94]">
                            Client dan freelancer terdaftar
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-people text-xl"></i>
                    </div>

                </div>
            </div>

            {{-- Services --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6">
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm text-[#71837B]">
                            Total Jasa
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-[#123128]">
                            0
                        </p>

                        <p class="mt-3 text-xs text-[#8A9B94]">
                            Jasa yang ada di marketplace
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-briefcase text-xl"></i>
                    </div>

                </div>
            </div>

            {{-- Orders --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6">
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm text-[#71837B]">
                            Total Pesanan
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-[#123128]">
                            0
                        </p>

                        <p class="mt-3 text-xs text-[#8A9B94]">
                            Semua transaksi marketplace
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-bag-check text-xl"></i>
                    </div>

                </div>
            </div>

            {{-- Revenue --}}
            <div class="rounded-2xl bg-[#0F6B3A] p-6 text-white">
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm text-[#D9F3E3]">
                            Pendapatan Platform
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight">
                            Rp 0
                        </p>

                        <p class="mt-3 text-xs text-[#D9F3E3]">
                            Total komisi marketplace
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10">
                        <i class="bi bi-graph-up-arrow text-xl"></i>
                    </div>

                </div>
            </div>

        </div>

        {{-- Main Content --}}
        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Quick Management --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 lg:col-span-2">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-sliders"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Kelola Marketplace
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Akses menu administrasi utama JASAIN.
                        </p>
                    </div>

                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">

                    {{-- Users --}}
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="group rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 transition hover:border-[#BFE7CF] hover:bg-[#EAF7EF]"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                                <i class="bi bi-people"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-[#123128]">
                                    Pengguna
                                </p>

                                <p class="mt-0.5 text-xs text-[#8A9B94]">
                                    Kelola client dan freelancer
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[#A2B2AA] transition group-hover:text-[#0F6B3A]"></i>
                        </div>
                    </a>

                    {{-- Categories --}}
                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="group rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 transition hover:border-[#BFE7CF] hover:bg-[#EAF7EF]"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                                <i class="bi bi-grid"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-[#123128]">
                                    Kategori
                                </p>

                                <p class="mt-0.5 text-xs text-[#8A9B94]">
                                    Atur kategori dan subkategori
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[#A2B2AA] transition group-hover:text-[#0F6B3A]"></i>
                        </div>
                    </a>

                    {{-- Services --}}
                    <a
                        href="{{ route('admin.services.index') }}"
                        class="group rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 transition hover:border-[#BFE7CF] hover:bg-[#EAF7EF]"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                                <i class="bi bi-briefcase"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-[#123128]">
                                    Jasa
                                </p>

                                <p class="mt-0.5 text-xs text-[#8A9B94]">
                                    Moderasi dan kelola jasa
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[#A2B2AA] transition group-hover:text-[#0F6B3A]"></i>
                        </div>
                    </a>

                    {{-- Orders --}}
                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="group rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 transition hover:border-[#BFE7CF] hover:bg-[#EAF7EF]"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                                <i class="bi bi-bag-check"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-[#123128]">
                                    Pesanan
                                </p>

                                <p class="mt-0.5 text-xs text-[#8A9B94]">
                                    Pantau seluruh transaksi
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[#A2B2AA] transition group-hover:text-[#0F6B3A]"></i>
                        </div>
                    </a>

                    {{-- Payments --}}
                    <a
                        href="{{ route('admin.payments.index') }}"
                        class="group rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 transition hover:border-[#BFE7CF] hover:bg-[#EAF7EF]"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                                <i class="bi bi-credit-card"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-[#123128]">
                                    Pembayaran
                                </p>

                                <p class="mt-0.5 text-xs text-[#8A9B94]">
                                    Monitoring transaksi pembayaran
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[#A2B2AA] transition group-hover:text-[#0F6B3A]"></i>
                        </div>
                    </a>

                    {{-- Withdrawals --}}
                    <a
                        href="{{ route('admin.withdrawals.index') }}"
                        class="group rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 transition hover:border-[#BFE7CF] hover:bg-[#EAF7EF]"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                                <i class="bi bi-bank"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-[#123128]">
                                    Penarikan
                                </p>

                                <p class="mt-0.5 text-xs text-[#8A9B94]">
                                    Kelola pengajuan withdrawal
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[#A2B2AA] transition group-hover:text-[#0F6B3A]"></i>
                        </div>
                    </a>

                </div>

            </div>

            {{-- Financial Overview --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Keuangan
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Ringkasan transaksi platform.
                        </p>
                    </div>

                </div>

                <div class="mt-6 space-y-4">

                    <a
                        href="{{ route('admin.commissions.index') }}"
                        class="group flex items-center justify-between gap-4 rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 transition hover:border-[#BFE7CF] hover:bg-[#EAF7EF]"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-[#0F6B3A]">
                                <i class="bi bi-percent"></i>
                            </div>

                            <span class="text-sm font-semibold text-[#123128]">
                                Komisi
                            </span>
                        </div>

                        <i class="bi bi-chevron-right text-[#A2B2AA] transition group-hover:text-[#0F6B3A]"></i>
                    </a>

                    <a
                        href="{{ route('admin.reviews.index') }}"
                        class="group flex items-center justify-between gap-4 rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 transition hover:border-[#BFE7CF] hover:bg-[#EAF7EF]"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-[#0F6B3A]">
                                <i class="bi bi-star"></i>
                            </div>

                            <span class="text-sm font-semibold text-[#123128]">
                                Review
                            </span>
                        </div>

                        <i class="bi bi-chevron-right text-[#A2B2AA] transition group-hover:text-[#0F6B3A]"></i>
                    </a>

                </div>

            </div>

        </div>

        {{-- Admin Notice --}}
        <div class="rounded-2xl border border-[#CBEAD8] bg-[#EAF7EF] p-5 sm:p-6">
            <div class="flex items-start gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#0F6B3A]">
                    <i class="bi bi-info-circle text-lg"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold text-[#17663D]">
                        Area Administrasi
                    </p>

                    <p class="mt-1 max-w-4xl text-sm leading-6 text-[#557166]">
                        Dashboard ini menjadi pusat pengelolaan marketplace. Nantinya statistik
                        pengguna, jasa, pesanan, pembayaran, komisi, withdrawal, dan review
                        akan terhubung langsung dengan data database.
                    </p>
                </div>

            </div>
        </div>

    </div>

</x-layouts.admin>