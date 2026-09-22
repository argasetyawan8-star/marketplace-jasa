<x-layouts.admin title="Dashboard">

    <div class="space-y-8">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Dashboard Admin
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Pantau aktivitas dan operasional marketplace JASAIN.
            </p>
        </div>


        {{-- ========================================================= --}}
        {{-- OVERVIEW --}}
        {{-- ========================================================= --}}

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Pengguna --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Total Pengguna
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($totalUsers) }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                            <circle cx="9" cy="7" r="4" stroke-width="1.8"/>
                            <path stroke-linecap="round" stroke-width="1.8"
                                  d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                        </svg>
                    </div>

                </div>

                <div class="mt-4 flex gap-4 text-xs">
                    <span class="text-gray-500 dark:text-gray-400">
                        Client:
                        <strong class="text-gray-700 dark:text-gray-200">
                            {{ number_format($totalClients) }}
                        </strong>
                    </span>

                    <span class="text-gray-500 dark:text-gray-400">
                        Freelancer:
                        <strong class="text-gray-700 dark:text-gray-200">
                            {{ number_format($totalFreelancers) }}
                        </strong>
                    </span>
                </div>

            </div>


            {{-- Total Jasa --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Total Jasa
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($totalServices) }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-lime-50 text-lime-600 dark:bg-lime-950/40 dark:text-lime-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M20 7.5L12 3 4 7.5v9L12 21l8-4.5v-9Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M4 7.5l8 4.5 8-4.5M12 12v9"/>
                        </svg>
                    </div>

                </div>

                <a href="{{ route('admin.services.index') }}"
                   class="mt-4 inline-flex items-center text-xs font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">
                    Kelola jasa
                    <svg class="ml-1 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

            </div>


            {{-- Total Pesanan --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Total Pesanan
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($totalOrders) }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M6 3h12l1 4H5l1-4Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M5 7h14v11a3 3 0 01-3 3H8a3 3 0 01-3-3V7Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M9 11h6"/>
                        </svg>
                    </div>

                </div>

                <div class="mt-4 flex flex-wrap gap-x-4 gap-y-1 text-xs">

                    <span class="text-gray-500 dark:text-gray-400">
                        Selesai:
                        <strong class="text-emerald-600 dark:text-emerald-400">
                            {{ number_format($completedOrders) }}
                        </strong>
                    </span>

                    <span class="text-gray-500 dark:text-gray-400">
                        Dibayar:
                        <strong class="text-blue-600 dark:text-blue-400">
                            {{ number_format($paidOrders) }}
                        </strong>
                    </span>

                    <span class="text-gray-500 dark:text-gray-400">
                        Dibatalkan:
                        <strong class="text-red-600 dark:text-red-400">
                            {{ number_format($cancelledOrders) }}
                        </strong>
                    </span>

                </div>

            </div>


            {{-- Pendapatan Platform --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Pendapatan Platform
                        </p>

                        <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            Rp {{ number_format($totalCommission, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 2v20M17 5.5C16 4.5 14.5 4 12.5 4 9.7 4 8 5.5 8 7.5S9.7 11 12.5 11 17 12.5 17 15s-1.7 4-4.5 4c-2 0-3.5-.5-4.5-1.5"/>
                        </svg>
                    </div>

                </div>

                <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                    Total komisi:
                    <strong class="text-gray-700 dark:text-gray-200">
                        {{ number_format($totalCommissions) }}
                    </strong>
                </p>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- OPERASIONAL --}}
        {{-- ========================================================= --}}

        <div>

            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Operasional
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Hal-hal yang membutuhkan perhatian admin.
                </p>
            </div>


            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Withdrawal --}}
                <a href="{{ route('admin.withdrawals.index') }}"
                   class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-emerald-700">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Withdrawal
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($pendingWithdrawals) }}
                            </p>
                        </div>

                        <span class="rounded-full bg-orange-50 px-2.5 py-1 text-xs font-semibold text-orange-600 dark:bg-orange-950/40 dark:text-orange-400">
                            Pending
                        </span>

                    </div>

                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        Total pengajuan:
                        {{ number_format($totalWithdrawals) }}
                    </p>

                </a>


                {{-- Cancellation --}}
                <a href="{{ route('admin.cancellations.index') }}"
                   class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-emerald-700">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Cancellation
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($pendingCancellations) }}
                            </p>
                        </div>

                        <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-600 dark:bg-red-950/40 dark:text-red-400">
                            Perlu Review
                        </span>

                    </div>

                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        Total request:
                        {{ number_format($totalCancellations) }}
                    </p>

                </a>


                {{-- Dispute --}}
                <a href="{{ route('admin.disputes.index') }}"
                   class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-emerald-700">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Dispute Aktif
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($openDisputes) }}
                            </p>
                        </div>

                        <span class="rounded-full bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-600 dark:bg-purple-950/40 dark:text-purple-400">
                            Dispute
                        </span>

                    </div>

                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        Total dispute:
                        {{ number_format($totalDisputes) }}
                    </p>

                </a>


                {{-- Refund --}}
                <a href="{{ route('admin.refunds.index') }}"
                   class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-emerald-700">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Refund
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($pendingRefunds) }}
                            </p>
                        </div>

                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-600 dark:bg-amber-950/40 dark:text-amber-400">
                            Menunggu
                        </span>

                    </div>

                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        Refund selesai:
                        {{ number_format($completedRefunds) }}
                    </p>

                </a>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- MANAGEMENT --}}
        {{-- ========================================================= --}}

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Quick Management --}}
            <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Manajemen
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Akses cepat ke modul utama admin.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-4 rounded-xl border border-gray-200 p-4 transition hover:border-emerald-300 hover:bg-emerald-50/50 dark:border-gray-800 dark:hover:border-emerald-700 dark:hover:bg-emerald-950/20">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path stroke-linecap="round" stroke-width="1.8"
                                      d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                            </svg>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Pengguna
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Kelola akun pengguna
                            </p>
                        </div>

                    </a>


                    <a href="{{ route('admin.categories.index') }}"
                       class="flex items-center gap-4 rounded-xl border border-gray-200 p-4 transition hover:border-emerald-300 hover:bg-emerald-50/50 dark:border-gray-800 dark:hover:border-emerald-700 dark:hover:bg-emerald-950/20">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-lime-100 text-lime-700 dark:bg-lime-950/50 dark:text-lime-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M4 5h6v6H4zM14 5h6v6h-6zM4 15h6v6H4zM14 15h6v6h-6z"/>
                            </svg>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Kategori
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Kelola kategori jasa
                            </p>
                        </div>

                    </a>


                    <a href="{{ route('admin.services.index') }}"
                       class="flex items-center gap-4 rounded-xl border border-gray-200 p-4 transition hover:border-emerald-300 hover:bg-emerald-50/50 dark:border-gray-800 dark:hover:border-emerald-700 dark:hover:bg-emerald-950/20">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-700 dark:bg-blue-950/50 dark:text-blue-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M20 7.5L12 3 4 7.5v9L12 21l8-4.5v-9Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M4 7.5l8 4.5 8-4.5"/>
                            </svg>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Jasa
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Kelola layanan freelancer
                            </p>
                        </div>

                    </a>


                    <a href="{{ route('admin.orders.index') }}"
                       class="flex items-center gap-4 rounded-xl border border-gray-200 p-4 transition hover:border-emerald-300 hover:bg-emerald-50/50 dark:border-gray-800 dark:hover:border-emerald-700 dark:hover:bg-emerald-950/20">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-100 text-purple-700 dark:bg-purple-950/50 dark:text-purple-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M6 3h12l1 4H5l1-4Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M5 7h14v11a3 3 0 01-3 3H8a3 3 0 01-3-3V7Z"/>
                            </svg>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Pesanan
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Monitor semua pesanan
                            </p>
                        </div>

                    </a>

                </div>

            </div>


            {{-- Financial --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Keuangan
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Ringkasan transaksi platform.
                    </p>
                </div>

                <div class="space-y-4">

                    <a href="{{ route('admin.payments.index') }}"
                       class="flex items-center justify-between rounded-xl border border-gray-200 p-4 transition hover:border-emerald-300 dark:border-gray-800 dark:hover:border-emerald-700">

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Pembayaran
                            </p>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ number_format($paidPayments) }} pembayaran berhasil
                            </p>
                        </div>

                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"/>
                        </svg>

                    </a>


                    <a href="{{ route('admin.commissions.index') }}"
                       class="flex items-center justify-between rounded-xl border border-gray-200 p-4 transition hover:border-emerald-300 dark:border-gray-800 dark:hover:border-emerald-700">

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Komisi
                            </p>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Rp {{ number_format($totalCommission, 0, ',', '.') }}
                            </p>
                        </div>

                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"/>
                        </svg>

                    </a>


                    <a href="{{ route('admin.reviews.index') }}"
                       class="flex items-center justify-between rounded-xl border border-gray-200 p-4 transition hover:border-emerald-300 dark:border-gray-800 dark:hover:border-emerald-700">

                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                Review
                            </p>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ number_format($publishedReviews) }} review dipublikasikan
                            </p>
                        </div>

                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"/>
                        </svg>

                    </a>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- PAYMENT STATUS --}}
        {{-- ========================================================= --}}

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Status Pembayaran
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Ringkasan status pembayaran yang tersimpan di sistem.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-xl bg-emerald-50 p-4 dark:bg-emerald-950/30">
                    <p class="text-xs font-medium text-emerald-700 dark:text-emerald-400">
                        Paid
                    </p>

                    <p class="mt-1 text-2xl font-bold text-emerald-800 dark:text-emerald-300">
                        {{ number_format($paidPayments) }}
                    </p>
                </div>

                <div class="rounded-xl bg-amber-50 p-4 dark:bg-amber-950/30">
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-400">
                        Refund Pending
                    </p>

                    <p class="mt-1 text-2xl font-bold text-amber-800 dark:text-amber-300">
                        {{ number_format($refundPendingPayments) }}
                    </p>
                </div>

                <div class="rounded-xl bg-gray-100 p-4 dark:bg-gray-800">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">
                        Refunded
                    </p>

                    <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-gray-200">
                        {{ number_format($refundedPayments) }}
                    </p>
                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- ADMIN INFO --}}
        {{-- ========================================================= --}}

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 dark:border-emerald-900/50 dark:bg-emerald-950/20">

            <div class="flex gap-4">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18Z"/>
                    </svg>

                </div>

                <div>

                    <h3 class="font-semibold text-emerald-900 dark:text-emerald-300">
                        Dashboard terhubung ke database
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-emerald-800 dark:text-emerald-400">
                        Statistik dashboard sekarang mengambil data langsung dari pengguna,
                        jasa, pesanan, pembayaran, komisi, withdrawal, cancellation,
                        dispute, refund, dan review.
                    </p>

                </div>

            </div>

        </div>

    </div>

</x-layouts.admin>