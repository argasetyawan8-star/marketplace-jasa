@props([
    'title' => 'Admin - ProKerja',
])

@php
    /**
     * |--------------------------------------------------------------------------
     * | AUTH USER
     * |--------------------------------------------------------------------------
     */
    $user = auth()->user();

    $userInitial = strtoupper(
        mb_substr(
            $user?->name ?? 'A',
            0,
            1
        )
    );

    $avatarUrl = null;

    if (filled($user?->avatar)) {
        $avatarUrl = asset(
            'storage/' . ltrim($user->avatar, '/')
        );
    }

    $profileUrl = route('profile.show');

    /**
     * |--------------------------------------------------------------------------
     * | ADMIN NOTIFICATIONS
     * |--------------------------------------------------------------------------
     *
     * | Semua notifikasi Admin diambil sekali pada saat layout dirender.
     * | Badge sidebar dihitung berdasarkan event.
     * | Bell menampilkan total unread.
     */
    $adminUnreadNotifications = collect();
    $adminLatestNotifications = collect();
    $adminUnreadByEvent = collect();
    $adminUnreadCount = 0;

    if ($user?->role === 'admin') {
        $adminUnreadNotifications = $user
            ->notifications()
            ->whereNull('read_at')
            ->latest('created_at')
            ->get([
                'id',
                'data',
                'created_at',
                'read_at',
            ]);

        $adminUnreadCount = $adminUnreadNotifications->count();

        $adminUnreadByEvent = $adminUnreadNotifications
            ->groupBy(
                fn ($notification) =>
                    data_get($notification->data, 'event')
            )
            ->map(
                fn ($notifications) =>
                    $notifications->count()
            );

        $adminLatestNotifications = $adminUnreadNotifications
            ->take(8);
    }

    $displayUnreadCount =
        $adminUnreadCount > 99
            ? '99+'
            : $adminUnreadCount;

    /**
     * |--------------------------------------------------------------------------
     * | SIDEBAR MENU
     * |--------------------------------------------------------------------------
     */
    $sidebarGroups = [
        [
            'label' => 'Overview',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'route' => 'admin.dashboard',
                    'icon' => 'bi-speedometer2',
                    'match' => 'admin.dashboard',
                    'badge_events' => [],
                ],
            ],
        ],

        [
            'label' => 'Manajemen',
            'items' => [
                [
                    'label' => 'Pengguna',
                    'route' => 'admin.users.index',
                    'icon' => 'bi-people',
                    'match' => 'admin.users.*',
                    'badge_events' => [],
                ],
                [
                    'label' => 'Kategori',
                    'route' => 'admin.categories.index',
                    'icon' => 'bi-tags',
                    'match' => 'admin.categories.*',
                    'badge_events' => [],
                ],
                [
                    'label' => 'Layanan',
                    'route' => 'admin.services.index',
                    'icon' => 'bi-grid',
                    'match' => 'admin.services.*',
                    'badge_events' => [],
                ],
                [
                    'label' => 'Moderasi Layanan',
                    'route' => 'admin.service-moderation.index',
                    'icon' => 'bi-shield-check',
                    'match' => 'admin.service-moderation.*',
                    'badge_events' => [
                        \App\Services\NotificationService::SERVICE_SUBMITTED,
                        \App\Services\NotificationService::SERVICE_REVISION,
                    ],
                ],
            ],
        ],

        [
            'label' => 'Transaksi',
            'items' => [
                [
                    'label' => 'Pesanan',
                    'route' => 'admin.orders.index',
                    'icon' => 'bi-bag-check',
                    'match' => 'admin.orders.*',
                    'badge_events' => [
                        \App\Services\NotificationService::ORDER_CREATED,
                        \App\Services\NotificationService::ORDER_READY,
                        \App\Services\NotificationService::ORDER_STARTED,
                    ],
                ],
                [
                    'label' => 'Pembayaran',
                    'route' => 'admin.payments.index',
                    'icon' => 'bi-credit-card',
                    'match' => 'admin.payments.*',
                    'badge_events' => [
                        \App\Services\NotificationService::PAYMENT_SUCCESS,
                        \App\Services\NotificationService::PAYMENT_FAILED,
                        \App\Services\NotificationService::PAYMENT_CANCELLED,
                    ],
                ],
                [
                    'label' => 'Komisi',
                    'route' => 'admin.commissions.index',
                    'icon' => 'bi-percent',
                    'match' => 'admin.commissions.*',
                    'badge_events' => [
                        \App\Services\NotificationService::COMMISSION_DEDUCTED,
                    ],
                ],
                [
                    'label' => 'Penarikan',
                    'route' => 'admin.withdrawals.index',
                    'icon' => 'bi-cash-coin',
                    'match' => 'admin.withdrawals.*',
                    'badge_events' => [
                        \App\Services\NotificationService::WITHDRAWAL_SUBMITTED,
                        \App\Services\NotificationService::WITHDRAWAL_PROCESSING,
                    ],
                ],
                [
                    'label' => 'Refund',
                    'route' => 'admin.refunds.index',
                    'icon' => 'bi-arrow-counterclockwise',
                    'match' => 'admin.refunds.*',
                    'badge_events' => [
                        \App\Services\NotificationService::PAYMENT_REFUND_PENDING,
                        \App\Services\NotificationService::PAYMENT_REFUND_PROCESSING,
                    ],
                ],
            ],
        ],

        [
            'label' => 'Moderasi',
            'items' => [
                [
                    'label' => 'Ulasan',
                    'route' => 'admin.reviews.index',
                    'icon' => 'bi-star',
                    'match' => 'admin.reviews.*',
                    'badge_events' => [
                        \App\Services\NotificationService::REVIEW_RECEIVED,
                    ],
                ],
                [
                    'label' => 'Verifikasi Freelancer',
                    'route' => 'admin.verifications.index',
                    'icon' => 'bi-patch-check',
                    'match' => 'admin.verifications.*',
                    'badge_events' => [
                        \App\Services\NotificationService::KYC_SUBMITTED,
                    ],
                ],
                [
                    'label' => 'Pembatalan',
                    'route' => 'admin.cancellations.index',
                    'icon' => 'bi-x-octagon',
                    'match' => 'admin.cancellations.*',
                    'badge_events' => [
                        \App\Services\NotificationService::CANCELLATION_SUBMITTED,
                    ],
                ],
                [
                    'label' => 'Sengketa',
                    'route' => 'admin.disputes.index',
                    'icon' => 'bi-exclamation-diamond',
                    'match' => 'admin.disputes.*',
                    'badge_events' => [
                        \App\Services\NotificationService::DISPUTE_OPENED,
                        \App\Services\NotificationService::DISPUTE_RESPONSE,
                        \App\Services\NotificationService::DISPUTE_UNDER_REVIEW,
                    ],
                ],
            ],
        ],

        [
            'label' => 'CMS',
            'items' => [
                [
                    'label' => 'Banner',
                    'route' => 'admin.banners.index',
                    'icon' => 'bi-images',
                    'match' => 'admin.banners.*',
                    'badge_events' => [],
                ],
            ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html
    lang="id"
    class="h-full"
>
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="color-scheme"
        content="light dark"
    >

    <title>
        {{ $title }}
    </title>

    {{-- =========================================================
        ANTI FLASH DARK MODE
    ========================================================== --}}
    <script>
        (function () {
            try {
                const savedTheme =
                    localStorage.getItem('prokerja-theme');

                const systemDark =
                    window.matchMedia(
                        '(prefers-color-scheme: dark)'
                    ).matches;

                const shouldUseDark =
                    savedTheme === 'dark' ||
                    (
                        savedTheme === null &&
                        systemDark
                    );

                document.documentElement.classList.toggle(
                    'dark',
                    shouldUseDark
                );
            } catch (error) {
                console.warn(
                    'Theme initialization failed.',
                    error
                );
            }
        })();
    </script>

    {{-- =========================================================
        BOOTSTRAP ICONS
    ========================================================== --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    {{-- =========================================================
        CUSTOM ADMIN THEME
    ========================================================== --}}
    <style>
        [x-cloak] {
            display: none !important;
        }

        html,
        body {
            min-height: 100%;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
        }

        /* =====================================================
           THEME TRANSITION
        ===================================================== */

        .pk-admin-theme-transition,
        .pk-admin-theme-transition *,
        .pk-admin-theme-transition::before,
        .pk-admin-theme-transition::after {
            transition:
                background-color 180ms ease,
                color 180ms ease,
                border-color 180ms ease,
                box-shadow 180ms ease;
        }

        /* =====================================================
           SCROLLBAR
        ===================================================== */

        .pk-admin-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .pk-admin-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .pk-admin-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        html.dark .pk-admin-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
        }

        /* =====================================================
           SIDEBAR
        ===================================================== */

        #pk-admin-sidebar {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
        }

        html.dark #pk-admin-sidebar {
            background: #020617 !important;
            border-color: #1e293b !important;
        }

        /* =====================================================
           SIDEBAR GROUP TITLE
        ===================================================== */

        #pk-admin-sidebar .pk-admin-sidebar-group-title {
            color: #94a3b8 !important;
        }

        html.dark #pk-admin-sidebar .pk-admin-sidebar-group-title {
            color: #64748b !important;
        }

        #pk-admin-sidebar .pk-admin-sidebar-group-dot {
            background: #cbd5e1 !important;
        }

        html.dark #pk-admin-sidebar .pk-admin-sidebar-group-dot {
            background: #475569 !important;
        }

        /* =====================================================
           SIDEBAR LINK
        ===================================================== */

        #pk-admin-sidebar .pk-admin-sidebar-link {
            color: #475569 !important;
            background-color: transparent !important;
        }

        #pk-admin-sidebar .pk-admin-sidebar-link:hover {
            color: #0f172a !important;
            background-color: #f1f5f9 !important;
        }

        html.dark #pk-admin-sidebar .pk-admin-sidebar-link {
            color: #cbd5e1 !important;
            background-color: transparent !important;
        }

        html.dark #pk-admin-sidebar .pk-admin-sidebar-link:hover {
            color: #f8fafc !important;
            background-color: #0f172a !important;
        }

        /* =====================================================
           SIDEBAR MENU LABEL
        ===================================================== */

        #pk-admin-sidebar .pk-admin-sidebar-label {
            color: #475569 !important;
        }

        html.dark #pk-admin-sidebar .pk-admin-sidebar-label {
            color: #cbd5e1 !important;
        }

        html.dark
        #pk-admin-sidebar
        .pk-admin-sidebar-link:hover
        .pk-admin-sidebar-label {
            color: #f8fafc !important;
        }

        /* =====================================================
           SIDEBAR ICON
        ===================================================== */

        #pk-admin-sidebar .pk-admin-sidebar-icon {
            color: #64748b !important;
            background-color: #f1f5f9 !important;
        }

        #pk-admin-sidebar
        .pk-admin-sidebar-link:hover
        .pk-admin-sidebar-icon {
            color: #2563eb !important;
            background-color: #ffffff !important;
        }

        html.dark
        #pk-admin-sidebar
        .pk-admin-sidebar-icon {
            color: #94a3b8 !important;
            background-color: #0f172a !important;
        }

        html.dark
        #pk-admin-sidebar
        .pk-admin-sidebar-link:hover
        .pk-admin-sidebar-icon {
            color: #60a5fa !important;
            background-color: #1e293b !important;
        }

        /* =====================================================
           ACTIVE MENU
        ===================================================== */

        #pk-admin-sidebar
        .pk-admin-sidebar-link.is-active {
            color: #1d4ed8 !important;
            background-color: #eff6ff !important;
        }

        html.dark
        #pk-admin-sidebar
        .pk-admin-sidebar-link.is-active {
            color: #bfdbfe !important;
            background-color: #172554 !important;
        }

        /* =====================================================
           ACTIVE LABEL
        ===================================================== */

        #pk-admin-sidebar
        .pk-admin-sidebar-link.is-active
        .pk-admin-sidebar-label {
            color: #1d4ed8 !important;
        }

        html.dark
        #pk-admin-sidebar
        .pk-admin-sidebar-link.is-active
        .pk-admin-sidebar-label {
            color: #bfdbfe !important;
        }

        /* =====================================================
           ACTIVE ICON
        ===================================================== */

        #pk-admin-sidebar
        .pk-admin-sidebar-link.is-active
        .pk-admin-sidebar-icon {
            color: #2563eb !important;
            background-color: #ffffff !important;
            box-shadow:
                0 1px 3px rgba(15, 23, 42, 0.08) !important;
        }

        html.dark
        #pk-admin-sidebar
        .pk-admin-sidebar-link.is-active
        .pk-admin-sidebar-icon {
            color: #60a5fa !important;
            background-color: rgba(37, 99, 235, 0.14) !important;
            box-shadow: none !important;
        }

        /* =====================================================
           ACTIVE BAR
        ===================================================== */

        #pk-admin-sidebar
        .pk-admin-sidebar-active-bar {
            background-color: #2563eb !important;
        }

        html.dark
        #pk-admin-sidebar
        .pk-admin-sidebar-active-bar {
            background-color: #60a5fa !important;
        }

        /* =====================================================
           ACTIVE ARROW
        ===================================================== */

        #pk-admin-sidebar
        .pk-admin-sidebar-active-arrow {
            color: #2563eb !important;
            background-color: #dbeafe !important;
        }

        html.dark
        #pk-admin-sidebar
        .pk-admin-sidebar-active-arrow {
            color: #bfdbfe !important;
            background-color: rgba(30, 64, 175, 0.55) !important;
        }

        /* =====================================================
           SIDEBAR NOTIFICATION BADGE
        ===================================================== */

        .pk-admin-sidebar-badge {
            min-width: 22px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 7px;
            border-radius: 9999px;
            background: #fee2e2;
            color: #dc2626;
            font-size: 10px;
            font-weight: 800;
            line-height: 1;
            box-shadow:
                0 1px 2px rgba(220, 38, 38, 0.08);
            animation:
                pkAdminBadgeAppear 180ms ease-out;
        }

        html.dark .pk-admin-sidebar-badge {
            background: rgba(127, 29, 29, 0.45);
            color: #fca5a5;
            box-shadow: none;
        }

        @keyframes pkAdminBadgeAppear {
            from {
                opacity: 0;
                transform: scale(.75);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* =====================================================
           TOPBAR NOTIFICATION BUTTON
        ===================================================== */

        .pk-admin-notification-button {
            position: relative;
        }

        .pk-admin-notification-button.has-unread::after {
            content: "";
            position: absolute;
            top: 7px;
            right: 7px;
            width: 7px;
            height: 7px;
            border-radius: 9999px;
            background: #ef4444;
            border: 2px solid #ffffff;
        }

        html.dark .pk-admin-notification-button.has-unread::after {
            border-color: #020617;
        }

        .pk-admin-notification-count {
            min-width: 19px;
            height: 19px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border-radius: 9999px;
            background: #ef4444;
            color: #ffffff;
            font-size: 9px;
            font-weight: 800;
            line-height: 1;
            border: 2px solid #ffffff;
            box-shadow:
                0 2px 5px rgba(239, 68, 68, 0.22);
        }

        html.dark .pk-admin-notification-count {
            border-color: #020617;
        }

        /* =====================================================
           NOTIFICATION DROPDOWN
        ===================================================== */

        .pk-admin-notification-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: min(360px, calc(100vw - 2rem));
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow:
                0 20px 50px rgba(15, 23, 42, 0.12);
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform:
                translateY(8px)
                scale(.98);
            transform-origin: top right;
            transition:
                opacity 160ms ease,
                visibility 160ms ease,
                transform 160ms ease;
        }

        .pk-admin-notification-dropdown.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform:
                translateY(0)
                scale(1);
        }

        html.dark .pk-admin-notification-dropdown {
            border-color: #1e293b;
            background: #0f172a;
            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.4);
        }

        .pk-admin-notification-item {
            transition:
                background-color 150ms ease;
        }

        .pk-admin-notification-item:hover {
            background-color: #f8fafc;
        }

        html.dark .pk-admin-notification-item:hover {
            background-color: #111827;
        }

        /* =====================================================
           ADMIN CONTENT
        ===================================================== */

        html.dark .pk-admin-content .bg-white {
            background-color: #111827 !important;
        }

        html.dark .pk-admin-content .bg-slate-50 {
            background-color: #0f172a !important;
        }

        html.dark .pk-admin-content .bg-slate-100 {
            background-color: #1e293b !important;
        }

        html.dark .pk-admin-content .bg-slate-200 {
            background-color: #334155 !important;
        }

        /* =====================================================
           TEXT
        ===================================================== */

        html.dark .pk-admin-content .text-slate-950,
        html.dark .pk-admin-content .text-slate-900,
        html.dark .pk-admin-content .text-slate-800,
        html.dark .pk-admin-content .text-slate-700 {
            color: #f8fafc !important;
        }

        html.dark .pk-admin-content .text-slate-600 {
            color: #cbd5e1 !important;
        }

        html.dark .pk-admin-content .text-slate-500 {
            color: #94a3b8 !important;
        }

        html.dark .pk-admin-content .text-slate-400 {
            color: #64748b !important;
        }

        /* =====================================================
           BORDER
        ===================================================== */

        html.dark .pk-admin-content .border-slate-100,
        html.dark .pk-admin-content .border-slate-200,
        html.dark .pk-admin-content .border-slate-300 {
            border-color: #334155 !important;
        }

        /* =====================================================
           FORM
        ===================================================== */

        html.dark .pk-admin-content input,
        html.dark .pk-admin-content textarea,
        html.dark .pk-admin-content select {
            background-color: #0f172a !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        html.dark .pk-admin-content input::placeholder,
        html.dark .pk-admin-content textarea::placeholder {
            color: #64748b !important;
        }

        /* =====================================================
           TABLE
        ===================================================== */

        html.dark .pk-admin-content table thead {
            background-color: #0f172a !important;
        }

        html.dark .pk-admin-content table tbody tr {
            border-color: #334155 !important;
        }

        html.dark .pk-admin-content table tbody tr:hover {
            background-color:
                rgba(30, 41, 59, 0.58) !important;
        }

        /* =====================================================
           LEGACY GREEN COLORS
        ===================================================== */

        html.dark .pk-admin-content [class*="bg-[#F8FCF9]"] {
            background-color: #0f172a !important;
        }

        html.dark .pk-admin-content [class*="bg-[#F8FAFC]"] {
            background-color: #0f172a !important;
        }

        html.dark .pk-admin-content [class*="bg-[#EAF7EF]"] {
            background-color: #132d22 !important;
        }

        html.dark .pk-admin-content [class*="text-[#123128]"] {
            color: #f8fafc !important;
        }

        html.dark .pk-admin-content [class*="text-[#71837B]"] {
            color: #94a3b8 !important;
        }

        html.dark .pk-admin-content [class*="border-[#D6E4DD]"] {
            border-color: #334155 !important;
        }

        html.dark .pk-admin-content [class*="border-[#2E473A]"] {
            border-color: #334155 !important;
        }

        /* =====================================================
           ALERT
        ===================================================== */

        html.dark .pk-admin-content .bg-blue-50 {
            background-color: #0f2a4a !important;
        }

        html.dark .pk-admin-content .bg-emerald-50,
        html.dark .pk-admin-content .bg-green-50 {
            background-color: #09271d !important;
        }

        html.dark .pk-admin-content .bg-red-50 {
            background-color: #34141a !important;
        }

        html.dark .pk-admin-content .bg-amber-50,
        html.dark .pk-admin-content .bg-yellow-50 {
            background-color: #33240b !important;
        }

        /* =====================================================
           WHITE BUTTON
        ===================================================== */

        html.dark .pk-admin-content button.bg-white,
        html.dark .pk-admin-content a.bg-white {
            background-color: #1e293b !important;
        }
    </style>

    {{-- =========================================================
        VITE
    ========================================================== --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>

<body
    class="min-h-full bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100"
>

<div
    id="pk-admin-app"
    class="min-h-screen bg-slate-50 dark:bg-slate-950"
>

    {{-- =========================================================
        MOBILE OVERLAY
    ========================================================== --}}
    <div
        id="pk-admin-overlay"
        class="pointer-events-none fixed inset-0 z-[90] bg-slate-950/55 opacity-0 backdrop-blur-[2px] transition duration-200 lg:hidden"
    ></div>

    {{-- =========================================================
        SIDEBAR
    ========================================================== --}}
    <aside
        id="pk-admin-sidebar"
        class="pk-admin-scrollbar fixed inset-y-0 left-0 z-[100] flex w-[264px] -translate-x-full flex-col overflow-y-auto border-r bg-white shadow-2xl shadow-slate-900/10 transition-transform duration-300 dark:bg-slate-950 lg:translate-x-0 lg:shadow-none"
    >

        {{-- BRAND --}}
        <div
            class="flex h-[76px] shrink-0 items-center border-b border-slate-200 px-5 dark:border-slate-800"
        >
            <a
                href="{{ route('admin.dashboard') }}"
                class="group flex items-center gap-3"
            >
                <span
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#2563EB] text-base font-extrabold !text-white shadow-sm transition duration-200 group-hover:-translate-y-0.5 group-hover:shadow-lg group-hover:shadow-blue-500/20"
                >
                    P
                </span>

                <span class="min-w-0">
                    <span
                        class="block text-[17px] font-bold tracking-tight text-slate-900 dark:text-white"
                    >
                        ProKerja
                    </span>

                    <span
                        class="mt-0.5 block text-[9px] font-semibold uppercase tracking-[0.14em] text-slate-400 dark:text-slate-500"
                    >
                        Admin Panel
                    </span>
                </span>
            </a>
        </div>

        {{-- NAVIGATION --}}
        <nav
            class="flex-1 px-3 py-5"
            aria-label="Navigasi Admin"
        >
            @foreach ($sidebarGroups as $group)

                <div class="mb-6 last:mb-1">

                    {{-- GROUP TITLE --}}
                    <div class="mb-2 flex items-center gap-2 px-3">
                        <span
                            class="pk-admin-sidebar-group-dot h-1.5 w-1.5 rounded-full"
                        ></span>

                        <span
                            class="pk-admin-sidebar-group-title text-[10px] font-bold uppercase tracking-[0.14em]"
                        >
                            {{ $group['label'] }}
                        </span>
                    </div>

                    <div class="space-y-1">

                        @foreach ($group['items'] as $item)

                            @php
                                $isActive =
                                    request()->routeIs(
                                        $item['match']
                                    );

                                $badgeCount = 0;

                                foreach (
                                    ($item['badge_events'] ?? [])
                                    as $badgeEvent
                                ) {
                                    $badgeCount +=
                                        (int) $adminUnreadByEvent->get(
                                            $badgeEvent,
                                            0
                                        );
                                }

                                $displayBadge =
                                    $badgeCount > 99
                                        ? '99+'
                                        : $badgeCount;
                            @endphp

                            <a
                                href="{{ route($item['route']) }}"
                                class="pk-admin-sidebar-link group relative flex min-h-[46px] items-center gap-3 rounded-xl px-3 py-2 transition-all duration-200 {{ $isActive ? 'is-active' : '' }}"
                            >

                                {{-- ACTIVE BAR --}}
                                @if ($isActive)
                                    <span
                                        class="pk-admin-sidebar-active-bar absolute left-0 top-1/2 h-6 w-[3px] -translate-y-1/2 rounded-r-full"
                                    ></span>
                                @endif

                                {{-- ICON --}}
                                <span
                                    class="pk-admin-sidebar-icon flex h-9 w-9 shrink-0 items-center justify-center rounded-lg transition-all duration-200"
                                >
                                    <i
                                        class="bi {{ $item['icon'] }} text-[15px]"
                                    ></i>
                                </span>

                                {{-- LABEL --}}
                                <span
                                    class="pk-admin-sidebar-label min-w-0 flex-1 truncate text-[13px] font-semibold"
                                >
                                    {{ $item['label'] }}
                                </span>

                                {{-- BADGE --}}
                                @if ($badgeCount > 0)
                                    <span
                                        class="pk-admin-sidebar-badge shrink-0"
                                        title="{{ $badgeCount }} aktivitas baru"
                                    >
                                        {{ $displayBadge }}
                                    </span>
                                @endif

                                {{-- ACTIVE ARROW --}}
                                @if ($isActive)
                                    <span
                                        class="pk-admin-sidebar-active-arrow flex h-5 w-5 shrink-0 items-center justify-center rounded-md"
                                    >
                                        <i
                                            class="bi bi-chevron-right text-[9px]"
                                        ></i>
                                    </span>
                                @endif

                            </a>

                        @endforeach

                    </div>
                </div>

            @endforeach
        </nav>
    </aside>

    {{-- =========================================================
        MAIN AREA
    ========================================================== --}}
    <div class="min-h-screen lg:pl-[264px]">

        {{-- =====================================================
            TOP NAVIGATION
        ====================================================== --}}
        <header
            class="sticky top-0 z-[80] h-[72px] border-b border-slate-200 bg-white/95 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/95"
        >

            <div
                class="flex h-full items-center gap-3 px-4 sm:px-6 lg:px-7"
            >

                {{-- =================================================
                    MOBILE MENU
                ================================================== --}}
                <button
                    id="pk-admin-mobile-menu"
                    type="button"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-900 dark:hover:bg-blue-950/40 dark:hover:text-blue-400 lg:hidden"
                    aria-label="Buka menu admin"
                    aria-expanded="false"
                >
                    <i class="bi bi-list text-xl"></i>
                </button>

                {{-- =================================================
                    PAGE NAME
                ================================================== --}}
                <div class="min-w-0">

                    @php
                        $activeLabel = 'Dashboard';

                        foreach ($sidebarGroups as $group) {
                            foreach ($group['items'] as $item) {
                                if (
                                    request()->routeIs(
                                        $item['match']
                                    )
                                ) {
                                    $activeLabel =
                                        $item['label'];

                                    break 2;
                                }
                            }
                        }
                    @endphp

                    <p
                        class="hidden text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400 dark:text-slate-500 sm:block"
                    >
                        ProKerja Admin
                    </p>

                    <h1
                        class="max-w-[180px] truncate text-base font-bold tracking-tight text-slate-900 dark:text-slate-100 sm:max-w-[360px] sm:text-lg"
                    >
                        {{ $activeLabel }}
                    </h1>
                </div>

                {{-- =================================================
                    RIGHT NAV
                ================================================== --}}
                <div class="ml-auto flex items-center gap-2">

                    {{-- =================================================
                        NOTIFICATION BELL
                    ================================================== --}}
                    <div
                        id="pk-admin-notification-wrapper"
                        class="relative"
                    >

                        <button
                            id="pk-admin-notification-toggle"
                            type="button"
                            class="pk-admin-notification-button {{ $adminUnreadCount > 0 ? 'has-unread' : '' }} flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-900 dark:hover:bg-blue-950/40 dark:hover:text-blue-400"
                            aria-label="Notifikasi"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >

                            <i
                                id="pk-admin-notification-icon"
                                class="bi bi-bell text-[17px]"
                            ></i>

                            @if ($adminUnreadCount > 0)
                                <span
                                    class="absolute -right-1 -top-1 flex h-[19px] min-w-[19px] items-center justify-center rounded-full bg-red-500 px-1 text-[9px] font-extrabold leading-none text-white ring-2 ring-white dark:ring-slate-950"
                                >
                                    {{ $displayUnreadCount }}
                                </span>
                            @endif

                        </button>

                        {{-- NOTIFICATION DROPDOWN --}}
                        <div
                            id="pk-admin-notification-dropdown"
                            class="pk-admin-notification-dropdown"
                            aria-hidden="true"
                        >

                            {{-- HEADER --}}
                            <div
                                class="border-b border-slate-100 px-4 py-3 dark:border-slate-800"
                            >
                                <div class="flex items-center justify-between gap-3">

                                    <div>
                                        <h2
                                            class="text-sm font-bold text-slate-900 dark:text-slate-100"
                                        >
                                            Notifikasi
                                        </h2>

                                        <p
                                            class="mt-0.5 text-[11px] text-slate-400 dark:text-slate-500"
                                        >
                                            Aktivitas dan pekerjaan terbaru
                                        </p>
                                    </div>

                                    @if ($adminUnreadCount > 0)
                                        <span
                                            class="rounded-full bg-red-50 px-2.5 py-1 text-[10px] font-bold text-red-600 dark:bg-red-950/40 dark:text-red-400"
                                        >
                                            {{ $adminUnreadCount }} belum dibaca
                                        </span>
                                    @endif

                                </div>
                            </div>

                            {{-- LIST --}}
                            <div class="max-h-[420px] overflow-y-auto">

                                @forelse (
                                    $adminLatestNotifications
                                    as $notification
                                )

                                    @php
                                        $notificationData =
                                            $notification->data ?? [];

                                        $notificationTitle =
                                            data_get(
                                                $notificationData,
                                                'title',
                                                'Notifikasi baru'
                                            );

                                        $notificationMessage =
                                            data_get(
                                                $notificationData,
                                                'message',
                                                'Ada aktivitas baru.'
                                            );

                                        $notificationIcon =
                                            data_get(
                                                $notificationData,
                                                'icon',
                                                'bi-bell'
                                            );

                                        $notificationUrl =
                                            data_get(
                                                $notificationData,
                                                'action_url'
                                            );

                                        $notificationEvent =
                                            data_get(
                                                $notificationData,
                                                'event'
                                            );
                                    @endphp

                                    @if ($notificationUrl)
                                        <a
                                            href="{{ $notificationUrl }}"
                                            class="pk-admin-notification-item block border-b border-slate-100 px-4 py-3.5 dark:border-slate-800"
                                        >
                                    @else
                                        <div
                                            class="pk-admin-notification-item block border-b border-slate-100 px-4 py-3.5 dark:border-slate-800"
                                        >
                                    @endif

                                        <div class="flex items-start gap-3">

                                            {{-- ICON --}}
                                            <span
                                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400"
                                            >
                                                <i
                                                    class="bi {{ $notificationIcon }} text-sm"
                                                ></i>
                                            </span>

                                            {{-- CONTENT --}}
                                            <div class="min-w-0 flex-1">

                                                <div class="flex items-start gap-2">
                                                    <p
                                                        class="min-w-0 flex-1 text-xs font-bold text-slate-800 dark:text-slate-100"
                                                    >
                                                        {{ $notificationTitle }}
                                                    </p>

                                                    <span
                                                        class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-red-500"
                                                        title="Belum dibaca"
                                                    ></span>
                                                </div>

                                                <p
                                                    class="mt-1 line-clamp-2 text-[11px] leading-5 text-slate-500 dark:text-slate-400"
                                                >
                                                    {{ $notificationMessage }}
                                                </p>

                                                <div class="mt-2 flex items-center gap-2">

                                                    @if ($notificationEvent)
                                                        <span
                                                            class="truncate text-[9px] font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400"
                                                        >
                                                            {{ $notificationEvent }}
                                                        </span>
                                                    @endif

                                                    @if ($notification->created_at)
                                                        <span
                                                            class="text-[9px] text-slate-400 dark:text-slate-500"
                                                        >
                                                            {{ $notification->created_at->diffForHumans() }}
                                                        </span>
                                                    @endif

                                                </div>

                                            </div>

                                            @if ($notificationUrl)
                                                <i
                                                    class="bi bi-chevron-right mt-2 shrink-0 text-[9px] text-slate-400"
                                                ></i>
                                            @endif

                                        </div>

                                    @if ($notificationUrl)
                                        </a>
                                    @else
                                        </div>
                                    @endif

                                @empty

                                    <div class="px-5 py-10 text-center">

                                        <div
                                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500"
                                        >
                                            <i class="bi bi-bell-slash text-lg"></i>
                                        </div>

                                        <p
                                            class="mt-3 text-xs font-semibold text-slate-700 dark:text-slate-200"
                                        >
                                            Tidak ada notifikasi baru
                                        </p>

                                        <p
                                            class="mt-1 text-[11px] leading-5 text-slate-400 dark:text-slate-500"
                                        >
                                            Semua aktivitas baru akan muncul di sini.
                                        </p>

                                    </div>

                                @endforelse

                            </div>

                            {{-- FOOTER --}}
                            <div
                                class="border-t border-slate-100 bg-slate-50 px-3 py-2.5 dark:border-slate-800 dark:bg-slate-950"
                            >

                                <a
                                    href="{{ route('notifications.index') }}"
                                    class="flex h-9 items-center justify-center gap-2 rounded-lg text-[11px] font-bold text-blue-600 transition hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/40"
                                >
                                    <span>
                                        Lihat semua notifikasi
                                    </span>

                                    <i class="bi bi-arrow-right text-[10px]"></i>
                                </a>

                            </div>

                        </div>
                    </div>

                    {{-- =================================================
                        DARK MODE
                    ================================================== --}}
                    <button
                        id="pk-theme-toggle"
                        type="button"
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-900 dark:hover:bg-blue-950/40 dark:hover:text-blue-400"
                        aria-label="Ganti tema"
                        title="Ganti tema"
                    >
                        <i
                            id="pk-theme-icon"
                            class="bi bi-moon-stars text-[15px]"
                        ></i>
                    </button>

                    {{-- =================================================
                        MARKETPLACE
                    ================================================== --}}
                    <a
                        href="{{ route('marketplace.home') }}"
                        class="hidden h-10 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 text-xs font-semibold text-slate-600 transition duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-blue-900 dark:hover:bg-blue-950/40 dark:hover:text-blue-400 sm:inline-flex"
                    >
                        <i class="bi bi-globe2"></i>
                        Marketplace
                    </a>

                    {{-- =================================================
                        PROFILE DROPDOWN
                    ================================================== --}}
                    <div
                        id="pk-profile-wrapper"
                        class="relative"
                    >

                        <button
                            id="pk-profile-toggle"
                            type="button"
                            class="group flex h-10 items-center gap-2 rounded-xl px-1.5 transition duration-200 hover:bg-slate-100 dark:hover:bg-slate-900"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >

                            {{-- AVATAR --}}
                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-full bg-blue-100 text-sm font-bold text-blue-700 ring-1 ring-blue-200 dark:bg-blue-950/60 dark:text-blue-300 dark:ring-blue-900"
                            >
                                @if ($avatarUrl)
                                    <img
                                        src="{{ $avatarUrl }}"
                                        alt="{{ $user?->name ?? 'Admin' }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    {{ $userInitial }}
                                @endif
                            </span>

                            {{-- USER INFO --}}
                            <span
                                class="hidden min-w-0 xl:block"
                            >
                                <span
                                    class="block max-w-[150px] truncate text-xs font-bold text-slate-800 dark:text-slate-100"
                                >
                                    {{ $user?->name ?? 'Administrator' }}
                                </span>

                                <span
                                    class="mt-0.5 block text-[10px] text-slate-400 dark:text-slate-500"
                                >
                                    Administrator
                                </span>
                            </span>

                            <i
                                id="pk-profile-chevron"
                                class="bi bi-chevron-down ml-0.5 text-[9px] text-slate-400 transition duration-200"
                            ></i>

                        </button>

                        {{-- DROPDOWN --}}
                        <div
                            id="pk-profile-dropdown"
                            class="pointer-events-none absolute right-0 top-[52px] z-[120] w-[290px] translate-y-2 overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 opacity-0 shadow-2xl shadow-slate-900/10 transition-all duration-150 dark:border-slate-800 dark:bg-slate-900 dark:shadow-black/40"
                            aria-hidden="true"
                        >

                            {{-- USER SUMMARY --}}
                            <div
                                class="rounded-xl bg-slate-50 p-3 dark:bg-slate-950"
                            >

                                <div class="flex items-center gap-3">

                                    <span
                                        class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-blue-100 text-sm font-bold text-blue-700 dark:bg-blue-950/60 dark:text-blue-300"
                                    >
                                        @if ($avatarUrl)
                                            <img
                                                src="{{ $avatarUrl }}"
                                                alt="{{ $user?->name ?? 'Admin' }}"
                                                class="h-full w-full object-cover"
                                            >
                                        @else
                                            {{ $userInitial }}
                                        @endif
                                    </span>

                                    <div class="min-w-0 flex-1">

                                        <p
                                            class="truncate text-sm font-bold text-slate-900 dark:text-slate-100"
                                        >
                                            {{ $user?->name ?? 'Administrator' }}
                                        </p>

                                        <p
                                            class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400"
                                        >
                                            {{ $user?->email ?? 'Administrator' }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                            {{-- PROFILE --}}
                            <a
                                href="{{ $profileUrl }}"
                                class="group mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-600 dark:text-slate-300 dark:hover:bg-blue-950/40 dark:hover:text-blue-400"
                            >

                                <span
                                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500 transition group-hover:bg-blue-100 group-hover:text-blue-600 dark:bg-slate-800 dark:text-slate-400 dark:group-hover:bg-blue-950/60 dark:group-hover:text-blue-400"
                                >
                                    <i class="bi bi-person"></i>
                                </span>

                                <span class="flex-1">
                                    Profil Saya
                                </span>

                                <i
                                    class="bi bi-chevron-right text-[9px] text-slate-400"
                                ></i>

                            </a>

                            {{-- DIVIDER --}}
                            <div
                                class="my-1 border-t border-slate-100 dark:border-slate-800"
                            ></div>

                            {{-- LOGOUT --}}
                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="group flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/35"
                                >

                                    <span
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-400"
                                    >
                                        <i class="bi bi-box-arrow-right"></i>
                                    </span>

                                    <span class="flex-1 text-left">
                                        Keluar
                                    </span>

                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </header>

        {{-- =====================================================
            CONTENT
        ====================================================== --}}
        <main
            id="pk-admin-main-content"
            class="pk-admin-content min-h-[calc(100vh-72px)] overflow-x-hidden bg-slate-50 px-4 py-5 dark:bg-slate-950 sm:px-6 sm:py-6 lg:px-7 lg:py-7 xl:px-9 xl:py-8"
        >

            <div class="mx-auto w-full max-w-[1600px]">
                {{ $slot }}
            </div>

        </main>
    </div>
</div>

{{-- =========================================================
    JAVASCRIPT
========================================================== --}}
<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        /* =====================================================
           THEME
        ===================================================== */

        const html =
            document.documentElement;

        const body =
            document.body;

        const themeToggle =
            document.getElementById(
                'pk-theme-toggle'
            );

        const themeIcon =
            document.getElementById(
                'pk-theme-icon'
            );

        function isDarkMode() {
            return html.classList.contains(
                'dark'
            );
        }

        function updateThemeIcon() {
            if (!themeIcon) {
                return;
            }

            themeIcon.className =
                isDarkMode()
                    ? 'bi bi-sun text-[15px]'
                    : 'bi bi-moon-stars text-[15px]';
        }

        function saveTheme(theme) {
            try {
                localStorage.setItem(
                    'prokerja-theme',
                    theme
                );
            } catch (error) {
                console.warn(
                    'Unable to save theme.',
                    error
                );
            }
        }

        function setTheme(
            theme,
            persist = true
        ) {
            html.classList.toggle(
                'dark',
                theme === 'dark'
            );

            if (persist) {
                saveTheme(theme);
            }

            updateThemeIcon();
        }

        function toggleTheme() {
            body.classList.add(
                'pk-admin-theme-transition'
            );

            setTheme(
                isDarkMode()
                    ? 'light'
                    : 'dark'
            );

            window.setTimeout(
                function () {
                    body.classList.remove(
                        'pk-admin-theme-transition'
                    );
                },
                220
            );
        }

        updateThemeIcon();

        if (themeToggle) {
            themeToggle.addEventListener(
                'click',
                toggleTheme
            );
        }

        /* =====================================================
           MOBILE SIDEBAR
        ===================================================== */

        const sidebar =
            document.getElementById(
                'pk-admin-sidebar'
            );

        const overlay =
            document.getElementById(
                'pk-admin-overlay'
            );

        const mobileMenu =
            document.getElementById(
                'pk-admin-mobile-menu'
            );

        function openSidebar() {
            if (
                !sidebar ||
                !overlay
            ) {
                return;
            }

            sidebar.classList.remove(
                '-translate-x-full'
            );

            overlay.classList.remove(
                'pointer-events-none',
                'opacity-0'
            );

            overlay.classList.add(
                'pointer-events-auto',
                'opacity-100'
            );

            if (mobileMenu) {
                mobileMenu.setAttribute(
                    'aria-expanded',
                    'true'
                );
            }

            document.body.classList.add(
                'overflow-hidden'
            );
        }

        function closeSidebar() {
            if (
                !sidebar ||
                !overlay
            ) {
                return;
            }

            sidebar.classList.add(
                '-translate-x-full'
            );

            overlay.classList.add(
                'pointer-events-none',
                'opacity-0'
            );

            overlay.classList.remove(
                'pointer-events-auto',
                'opacity-100'
            );

            if (mobileMenu) {
                mobileMenu.setAttribute(
                    'aria-expanded',
                    'false'
                );
            }

            document.body.classList.remove(
                'overflow-hidden'
            );
        }

        if (mobileMenu) {
            mobileMenu.addEventListener(
                'click',
                function () {

                    const opened =
                        mobileMenu.getAttribute(
                            'aria-expanded'
                        ) === 'true';

                    if (opened) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                }
            );
        }

        if (overlay) {
            overlay.addEventListener(
                'click',
                closeSidebar
            );
        }

        /* =====================================================
           NOTIFICATION DROPDOWN
        ===================================================== */

        const notificationWrapper =
            document.getElementById(
                'pk-admin-notification-wrapper'
            );

        const notificationToggle =
            document.getElementById(
                'pk-admin-notification-toggle'
            );

        const notificationDropdown =
            document.getElementById(
                'pk-admin-notification-dropdown'
            );

        const notificationIcon =
            document.getElementById(
                'pk-admin-notification-icon'
            );

        function openNotifications() {
            if (
                !notificationToggle ||
                !notificationDropdown
            ) {
                return;
            }

            notificationDropdown.classList.add(
                'is-open'
            );

            notificationDropdown.setAttribute(
                'aria-hidden',
                'false'
            );

            notificationToggle.setAttribute(
                'aria-expanded',
                'true'
            );

            if (notificationIcon) {
                notificationIcon.className =
                    'bi bi-bell-fill text-[17px]';
            }
        }

        function closeNotifications() {
            if (
                !notificationToggle ||
                !notificationDropdown
            ) {
                return;
            }

            notificationDropdown.classList.remove(
                'is-open'
            );

            notificationDropdown.setAttribute(
                'aria-hidden',
                'true'
            );

            notificationToggle.setAttribute(
                'aria-expanded',
                'false'
            );

            if (notificationIcon) {
                notificationIcon.className =
                    'bi bi-bell text-[17px]';
            }
        }

        if (notificationToggle) {
            notificationToggle.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    const opened =
                        notificationToggle.getAttribute(
                            'aria-expanded'
                        ) === 'true';

                    if (opened) {
                        closeNotifications();
                    } else {
                        openNotifications();
                    }
                }
            );
        }

        /* =====================================================
           PROFILE DROPDOWN
        ===================================================== */

        const profileWrapper =
            document.getElementById(
                'pk-profile-wrapper'
            );

        const profileToggle =
            document.getElementById(
                'pk-profile-toggle'
            );

        const profileDropdown =
            document.getElementById(
                'pk-profile-dropdown'
            );

        const profileChevron =
            document.getElementById(
                'pk-profile-chevron'
            );

        function openProfile() {
            if (
                !profileToggle ||
                !profileDropdown
            ) {
                return;
            }

            closeNotifications();

            profileDropdown.classList.remove(
                'pointer-events-none',
                'opacity-0',
                'translate-y-2'
            );

            profileDropdown.classList.add(
                'pointer-events-auto',
                'opacity-100',
                'translate-y-0'
            );

            profileDropdown.setAttribute(
                'aria-hidden',
                'false'
            );

            profileToggle.setAttribute(
                'aria-expanded',
                'true'
            );

            if (profileChevron) {
                profileChevron.classList.add(
                    'rotate-180'
                );
            }
        }

        function closeProfile() {
            if (
                !profileToggle ||
                !profileDropdown
            ) {
                return;
            }

            profileDropdown.classList.add(
                'pointer-events-none',
                'opacity-0',
                'translate-y-2'
            );

            profileDropdown.classList.remove(
                'pointer-events-auto',
                'opacity-100',
                'translate-y-0'
            );

            profileDropdown.setAttribute(
                'aria-hidden',
                'true'
            );

            profileToggle.setAttribute(
                'aria-expanded',
                'false'
            );

            if (profileChevron) {
                profileChevron.classList.remove(
                    'rotate-180'
                );
            }
        }

        if (profileToggle) {
            profileToggle.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    closeNotifications();

                    const opened =
                        profileToggle.getAttribute(
                            'aria-expanded'
                        ) === 'true';

                    if (opened) {
                        closeProfile();
                    } else {
                        openProfile();
                    }
                }
            );
        }

        /* =====================================================
           OUTSIDE CLICK
        ===================================================== */

        document.addEventListener(
            'click',
            function (event) {

                if (
                    notificationWrapper &&
                    !notificationWrapper.contains(
                        event.target
                    )
                ) {
                    closeNotifications();
                }

                if (
                    profileWrapper &&
                    !profileWrapper.contains(
                        event.target
                    )
                ) {
                    closeProfile();
                }
            }
        );

        /* =====================================================
           ESCAPE
        ===================================================== */

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key !== 'Escape'
                ) {
                    return;
                }

                closeSidebar();
                closeNotifications();
                closeProfile();
            }
        );

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        window.addEventListener(
            'resize',
            function () {

                if (
                    window.innerWidth >= 1024
                ) {
                    closeSidebar();
                }
            }
        );
    }
);
</script>

</body>
</html>
