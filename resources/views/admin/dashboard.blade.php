<x-layouts.admin title="Dashboard">


@php
    $userChart = [
        'labels' => ['Client', 'Freelancer'],
        'data' => [
            (int) $totalClients,
            (int) $totalFreelancers,
        ],
    ];

    $orderChart = [
        'labels' => ['Selesai', 'Dibayar', 'Dibatalkan'],
        'data' => [
            (int) $completedOrders,
            (int) $paidOrders,
            (int) $cancelledOrders,
        ],
    ];

    $paymentChart = [
        'labels' => ['Paid', 'Refund Pending', 'Refunded'],
        'data' => [
            (int) $paidPayments,
            (int) $refundPendingPayments,
            (int) $refundedPayments,
        ],
    ];

    /*
     * Monitoring menggunakan grafik garis.
     * Angka yang digunakan berasal dari data monitoring yang sudah tersedia.
     */
    $monitoringChart = [
        'labels' => [
            'Withdrawal',
            'Cancellation',
            'Dispute',
            'Refund',
        ],
        'data' => [
            (int) $pendingWithdrawals,
            (int) $pendingCancellations,
            (int) $openDisputes,
            (int) $pendingRefunds,
        ],
    ];
@endphp

<div class="space-y-5 sm:space-y-6 lg:space-y-7">

    {{-- ==========================================================
         HEADER
    =========================================================== --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5 lg:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                    <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                    Admin Overview
                </div>

                <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-2xl">
                    Dashboard
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Ringkasan aktivitas dan kondisi sistem ProKerja.
                </p>
            </div>

            <a
                href="{{ route('marketplace.home') }}"
                class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-blue-500/30 dark:hover:bg-blue-500/10 dark:hover:text-blue-400"
            >
                <i class="bi bi-shop"></i>
                <span>Lihat Marketplace</span>
            </a>

        </div>
    </section>


    {{-- ==========================================================
         KPI UTAMA
    =========================================================== --}}
    <section class="grid grid-cols-2 gap-3 lg:grid-cols-4">

        {{-- Users --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">
            <div class="flex items-center justify-between gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <i class="bi bi-people text-lg"></i>
                </div>

                <span class="text-xs font-medium text-slate-400">
                    Pengguna
                </span>
            </div>

            <div class="mt-4">
                <p class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    {{ number_format((int) $totalUsers) }}
                </p>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Total user terdaftar
                </p>
            </div>
        </div>


        {{-- Services --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">
            <div class="flex items-center justify-between gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400">
                    <i class="bi bi-grid text-lg"></i>
                </div>

                <span class="text-xs font-medium text-slate-400">
                    Jasa
                </span>
            </div>

            <div class="mt-4">
                <p class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    {{ number_format((int) $totalServices) }}
                </p>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Total jasa tersedia
                </p>
            </div>
        </div>


        {{-- Orders --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">
            <div class="flex items-center justify-between gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                    <i class="bi bi-bag-check text-lg"></i>
                </div>

                <span class="text-xs font-medium text-slate-400">
                    Order
                </span>
            </div>

            <div class="mt-4">
                <p class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    {{ number_format((int) $totalOrders) }}
                </p>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Total order masuk
                </p>
            </div>
        </div>


        {{-- Commission --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-5">
            <div class="flex items-center justify-between gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <i class="bi bi-cash-stack text-lg"></i>
                </div>

                <span class="text-xs font-medium text-slate-400">
                    Komisi
                </span>
            </div>

            <div class="mt-4">
                <p class="text-xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-2xl">
                    Rp {{ number_format((float) ($totalCommission ?? $totalCommissions ?? 0), 0, ',', '.') }}
                </p>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Total komisi sistem
                </p>
            </div>
        </div>

    </section>


    {{-- ==========================================================
         ANALYTICS
    =========================================================== --}}
    <section class="grid gap-5 lg:grid-cols-3">

        {{-- Order Status --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:col-span-2">

            <div class="flex flex-col gap-2 border-b border-slate-100 px-4 py-4 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                <div>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                        Status Order
                    </h2>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Perbandingan status order saat ini.
                    </p>
                </div>

                <span class="inline-flex w-fit items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                    Order Analytics
                </span>
            </div>

            <div class="h-[280px] p-3 sm:h-[320px] sm:p-5">
                <canvas id="orderStatusChart"></canvas>
            </div>

        </div>


        {{-- User Distribution --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-5">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                    Distribusi User
                </h2>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Komposisi client dan freelancer.
                </p>
            </div>

            <div class="flex h-[280px] items-center justify-center p-5 sm:h-[320px]">
                <canvas id="userDistributionChart"></canvas>
            </div>

        </div>

    </section>


    {{-- ==========================================================
         MONITORING
    =========================================================== --}}
    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="border-b border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-5 lg:px-6">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                            Monitoring
                        </h2>

                        <span class="inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                    </div>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Pantau jumlah aktivitas yang masih membutuhkan perhatian admin.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                    <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                    Aktivitas Pending
                </div>

            </div>
        </div>


        {{-- LINE CHART --}}
        <div class="p-3 sm:p-5 lg:p-6">
            <div class="h-[300px] sm:h-[340px] lg:h-[370px]">
                <canvas id="monitoringChart"></canvas>
            </div>
        </div>


        {{-- MONITORING SUMMARY --}}
        <div class="grid grid-cols-2 gap-3 border-t border-slate-100 p-4 dark:border-slate-800 sm:grid-cols-4 sm:p-5 lg:px-6">

            {{-- Withdrawal --}}
            <div class="rounded-xl bg-slate-50 p-3 dark:bg-slate-800/60">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-500 dark:text-slate-400">
                        Withdrawal
                    </span>

                    <i class="bi bi-wallet2 text-blue-500"></i>
                </div>

                <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                    {{ number_format((int) $pendingWithdrawals) }}
                </p>

                <p class="mt-1 text-[11px] text-slate-400">
                    Menunggu proses
                </p>
            </div>


            {{-- Cancellation --}}
            <div class="rounded-xl bg-slate-50 p-3 dark:bg-slate-800/60">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-500 dark:text-slate-400">
                        Cancellation
                    </span>

                    <i class="bi bi-x-circle text-amber-500"></i>
                </div>

                <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                    {{ number_format((int) $pendingCancellations) }}
                </p>

                <p class="mt-1 text-[11px] text-slate-400">
                    Menunggu proses
                </p>
            </div>


            {{-- Dispute --}}
            <div class="rounded-xl bg-slate-50 p-3 dark:bg-slate-800/60">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-500 dark:text-slate-400">
                        Dispute
                    </span>

                    <i class="bi bi-shield-exclamation text-violet-500"></i>
                </div>

                <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                    {{ number_format((int) $openDisputes) }}
                </p>

                <p class="mt-1 text-[11px] text-slate-400">
                    Dispute terbuka
                </p>
            </div>


            {{-- Refund --}}
            <div class="rounded-xl bg-slate-50 p-3 dark:bg-slate-800/60">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs text-slate-500 dark:text-slate-400">
                        Refund
                    </span>

                    <i class="bi bi-arrow-counterclockwise text-rose-500"></i>
                </div>

                <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                    {{ number_format((int) $pendingRefunds) }}
                </p>

                <p class="mt-1 text-[11px] text-slate-400">
                    Menunggu refund
                </p>
            </div>

        </div>

    </section>


    {{-- ==========================================================
         FINANCIAL + PAYMENT
    =========================================================== --}}
    <section class="grid gap-5 lg:grid-cols-2">

        {{-- Financial Summary --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-5">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                    Financial Summary
                </h2>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Ringkasan transaksi finansial sistem.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 p-4 sm:p-5">

                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800/60">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Total Komisi
                    </p>

                    <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">
                        Rp {{ number_format((float) ($totalCommission ?? $totalCommissions ?? 0), 0, ',', '.') }}
                    </p>
                </div>

                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800/60">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Total Withdrawal
                    </p>

                    <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">
                        {{ number_format((int) $totalWithdrawals) }}
                    </p>
                </div>

                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800/60">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Withdrawal Pending
                    </p>

                    <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">
                        {{ number_format((int) $pendingWithdrawals) }}
                    </p>
                </div>

                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800/60">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Refund Pending
                    </p>

                    <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">
                        {{ number_format((int) $refundPendingPayments) }}
                    </p>
                </div>

            </div>
        </div>


        {{-- Payment Status --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-100 px-4 py-4 dark:border-slate-800 sm:px-5">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white sm:text-base">
                    Status Pembayaran
                </h2>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Distribusi status pembayaran.
                </p>
            </div>

            <div class="h-[300px] p-4 sm:h-[340px] sm:p-5">
                <canvas id="paymentStatusChart"></canvas>
            </div>

        </div>

    </section>


    {{-- ==========================================================
         PAYMENT DETAIL
    =========================================================== --}}
    <section class="grid grid-cols-2 gap-3 sm:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Paid
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                {{ number_format((int) $paidPayments) }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Refund Pending
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                {{ number_format((int) $refundPendingPayments) }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Refunded
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                {{ number_format((int) $refundedPayments) }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Review Published
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white">
                {{ number_format((int) $publishedReviews) }}
            </p>
        </div>

    </section>


    {{-- ==========================================================
         SYSTEM INFO
    =========================================================== --}}
    <section class="rounded-2xl border border-blue-100 bg-blue-50/70 p-4 dark:border-blue-500/20 dark:bg-blue-500/5 sm:p-5">

        <div class="flex gap-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                <i class="bi bi-info-circle text-lg"></i>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                    Monitoring Sistem
                </h3>

                <p class="mt-1 text-xs leading-5 text-slate-600 dark:text-slate-400">
                    Gunakan bagian monitoring untuk melihat aktivitas yang masih membutuhkan
                    tindakan admin seperti withdrawal, cancellation, dispute, dan refund.
                </p>
            </div>

        </div>

    </section>

</div>


{{-- ==========================================================
     CHART.JS
=========================================================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const isDark = document.documentElement.classList.contains('dark');

        const textColor = isDark
            ? '#CBD5E1'
            : '#64748B';

        const gridColor = isDark
            ? 'rgba(148,163,184,0.12)'
            : 'rgba(15,23,42,0.07)';


        {{-- ======================================================
             ORDER STATUS
        ======================================================= --}}
        const orderStatusCanvas = document.getElementById('orderStatusChart');

        if (orderStatusCanvas) {
            new Chart(orderStatusCanvas, {
                type: 'bar',
                data: {
                    labels: @json($orderChart['labels']),
                    datasets: [{
                        label: 'Jumlah Order',
                        data: @json($orderChart['data']),
                        backgroundColor: '#2563EB',
                        borderRadius: 8,
                        borderSkipped: false,
                        maxBarThickness: 42
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: textColor,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: textColor,
                                precision: 0,
                                stepSize: 1
                            },
                            grid: {
                                color: gridColor
                            }
                        }
                    }
                }
            });
        }


        {{-- ======================================================
             USER DISTRIBUTION
        ======================================================= --}}
        const userDistributionCanvas = document.getElementById('userDistributionChart');

        if (userDistributionCanvas) {
            new Chart(userDistributionCanvas, {
                type: 'doughnut',
                data: {
                    labels: @json($userChart['labels']),
                    datasets: [{
                        data: @json($userChart['data']),
                        backgroundColor: [
                            '#2563EB',
                            '#60A5FA'
                        ],
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: textColor,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 18,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }


        {{-- ======================================================
             MONITORING - LINE CHART
        ======================================================= --}}
        const monitoringCanvas = document.getElementById('monitoringChart');

        if (monitoringCanvas) {

            new Chart(monitoringCanvas, {
                type: 'line',

                data: {
                    labels: @json($monitoringChart['labels']),

                    datasets: [{
                        label: 'Aktivitas Pending',

                        data: @json($monitoringChart['data']),

                        borderColor: '#2563EB',

                        backgroundColor: 'rgba(37, 99, 235, 0.10)',

                        borderWidth: 3,

                        fill: true,

                        tension: 0.4,

                        pointRadius: 5,

                        pointHoverRadius: 7,

                        pointBackgroundColor: '#2563EB',

                        pointBorderColor: '#FFFFFF',

                        pointBorderWidth: 2
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },

                    plugins: {
                        legend: {
                            display: false
                        },

                        tooltip: {
                            backgroundColor: isDark
                                ? '#0F172A'
                                : '#FFFFFF',

                            titleColor: isDark
                                ? '#F8FAFC'
                                : '#0F172A',

                            bodyColor: isDark
                                ? '#CBD5E1'
                                : '#475569',

                            borderColor: isDark
                                ? 'rgba(148,163,184,0.15)'
                                : 'rgba(15,23,42,0.08)',

                            borderWidth: 1,

                            padding: 12,

                            displayColors: false,

                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' aktivitas';
                                }
                            }
                        }
                    },

                    scales: {

                        x: {
                            grid: {
                                display: false
                            },

                            ticks: {
                                color: textColor,
                                font: {
                                    size: 11
                                }
                            }
                        },

                        y: {
                            beginAtZero: true,

                            suggestedMax: Math.max(
                                5,
                                Math.max(...@json($monitoringChart['data'])) + 1
                            ),

                            ticks: {
                                color: textColor,

                                precision: 0,

                                stepSize: 1
                            },

                            grid: {
                                color: gridColor
                            }
                        }
                    }
                }
            });
        }


        {{-- ======================================================
             PAYMENT STATUS
        ======================================================= --}}
        const paymentStatusCanvas = document.getElementById('paymentStatusChart');

        if (paymentStatusCanvas) {
            new Chart(paymentStatusCanvas, {
                type: 'bar',

                data: {
                    labels: @json($paymentChart['labels']),

                    datasets: [{
                        label: 'Jumlah Pembayaran',

                        data: @json($paymentChart['data']),

                        backgroundColor: '#3B82F6',

                        borderRadius: 8,

                        borderSkipped: false,

                        maxBarThickness: 42
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            display: false
                        }
                    },

                    scales: {
                        x: {
                            grid: {
                                display: false
                            },

                            ticks: {
                                color: textColor,
                                font: {
                                    size: 11
                                }
                            }
                        },

                        y: {
                            beginAtZero: true,

                            ticks: {
                                color: textColor,

                                precision: 0,

                                stepSize: 1
                            },

                            grid: {
                                color: gridColor
                            }
                        }
                    }
                }
            });
        }

    });
</script>


</x-layouts.admin>
