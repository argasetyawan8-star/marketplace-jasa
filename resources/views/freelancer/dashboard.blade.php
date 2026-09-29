
<x-layouts.freelancer title="Dashboard">

    @php
        $user = auth()->user();
        $profile = $user?->freelancerProfile;

        $serviceCountValue = (int) ($serviceCount ?? 0);
        $orderCountValue = (int) ($orderCount ?? 0);
        $conversationCountValue = (int) ($conversationCount ?? 0);
        $balanceValue = (float) ($balance ?? 0);

        $recentOrdersCollection = collect($recentOrders ?? []);

        $avatarUrl = $profile?->avatar
            ? asset('storage/' . $profile->avatar)
            : null;

        $userInitial = strtoupper(substr($user->name ?? 'U', 0, 1));

        $ratingValue = number_format(
            (float) ($profile?->rating ?? 0),
            1
        );

        $completedOrders = (int) ($profile?->completed_orders ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Grafik
        |--------------------------------------------------------------------------
        | Menggunakan data pesanan yang memang tersedia di dashboard.
        | Tidak menggunakan angka dummy.
        */
        $chartOrders = $recentOrdersCollection
            ->filter(fn ($order) => $order->created_at)
            ->sortBy('created_at')
            ->take(8)
            ->values();

        $chartLabels = $chartOrders
            ->map(fn ($order) => $order->created_at->format('d M'))
            ->values()
            ->toArray();

        $chartValues = $chartOrders
            ->map(fn ($order) => (float) $order->total)
            ->values()
            ->toArray();
    @endphp


    <main class="min-h-[calc(100vh-72px)] bg-white lg:bg-[#F8FAFC]">

        <div class="mx-auto max-w-7xl lg:px-6 lg:py-6 xl:px-8">


            {{-- =========================================================
                TOP PROFILE BAR
            ========================================================== --}}
            <section
                class="border-b border-[#E8EDF3] bg-white px-5 py-4
                       lg:rounded-[22px] lg:border lg:border-[#E2E8F0]
                       lg:px-6 lg:py-5
                       lg:shadow-[0_8px_30px_rgba(15,23,42,0.035)]"
            >

                <div class="flex items-center justify-between gap-4">

                    {{-- Profile --}}
                    <div class="flex min-w-0 items-center gap-3">

                        <div
                            class="h-11 w-11 shrink-0 overflow-hidden rounded-full
                                   bg-[#EFF6FF] ring-1 ring-[#DBEAFE]"
                        >
                            @if ($avatarUrl)

                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="{{ $user->name }}"
                                    class="block h-full w-full object-cover"
                                >

                            @else

                                <div
                                    class="flex h-full w-full items-center justify-center
                                           text-sm font-bold text-[#2563EB]"
                                >
                                    {{ $userInitial }}
                                </div>

                            @endif
                        </div>


                        <div class="min-w-0">

                            <div class="flex items-center gap-1.5">

                                <h1
                                    class="truncate text-sm font-bold text-[#172B4D]
                                           sm:text-base"
                                >
                                    {{ $user->name }}
                                </h1>

                                <span
                                    class="flex h-4 w-4 shrink-0 items-center justify-center
                                           rounded-full bg-[#2563EB] text-white"
                                >
                                    <i class="bi bi-check text-[9px]"></i>
                                </span>

                            </div>

                            <div
                                class="mt-0.5 flex items-center gap-2 text-[10px]
                                       text-[#94A3B8]"
                            >

                                <span>
                                    {{ $profile?->headline ?: 'Freelancer ProKerja' }}
                                </span>

                                <span class="text-[#CBD5E1]">•</span>

                                <span class="flex items-center gap-1">
                                    <i class="bi bi-star-fill text-[#F59E0B]"></i>
                                    {{ $ratingValue }}
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="flex items-center gap-2">

                        <a
                            href="{{ route('freelancer.profile.show') }}"
                            class="hidden h-9 items-center gap-1.5 rounded-lg
                                   border border-[#E2E8F0] px-3 text-[11px]
                                   font-semibold text-[#475569]
                                   transition hover:border-[#BFDBFE]
                                   hover:bg-[#EFF6FF]
                                   hover:text-[#2563EB] sm:inline-flex"
                        >
                            <i class="bi bi-person"></i>
                            Profil
                        </a>

                        <a
                            href="{{ route('freelancer.services.create') }}"
                            class="inline-flex h-9 items-center gap-1.5 rounded-lg
                                   bg-[#2563EB] px-3.5 text-[11px] font-semibold
                                   text-white transition hover:bg-[#1D4ED8]"
                        >
                            <i class="bi bi-plus-lg"></i>
                            <span class="hidden xs:inline sm:inline">
                                Tambah jasa
                            </span>
                            <span class="sm:hidden">
                                Jasa
                            </span>
                        </a>

                    </div>

                </div>

            </section>



            {{-- =========================================================
                OVERVIEW
            ========================================================== --}}
            <section
                class="mt-0 border-b border-[#E8EDF3] bg-white
                       lg:mt-5 lg:rounded-[22px]
                       lg:border lg:border-[#E2E8F0]
                       lg:shadow-[0_8px_30px_rgba(15,23,42,0.035)]"
            >

                <div class="px-5 pt-5 lg:px-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <h2 class="text-sm font-bold text-[#172B4D]">
                                Overview
                            </h2>

                            <p class="mt-1 text-[11px] text-[#94A3B8]">
                                Ringkasan aktivitas akunmu
                            </p>
                        </div>

                        <span
                            class="hidden text-[10px] text-[#94A3B8] sm:block"
                        >
                            Freelancer
                        </span>

                    </div>

                </div>


                <div class="mt-4 grid grid-cols-2 lg:grid-cols-4">


                    {{-- Jasa --}}
                    <a
                        href="{{ route('freelancer.services.index') }}"
                        class="group border-t border-[#EDF2F7] px-5 py-5
                               transition hover:bg-[#F8FAFC]
                               lg:border-r lg:px-6"
                    >

                        <div class="flex items-start justify-between gap-3">

                            <div>
                                <p class="text-[10px] text-[#64748B]">
                                    Jasa aktif
                                </p>

                                <p
                                    class="mt-1 text-[25px] font-bold
                                           tracking-tight text-[#172B4D]"
                                >
                                    {{ $serviceCountValue }}
                                </p>
                            </div>

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center
                                       rounded-lg bg-[#EFF6FF] text-[#2563EB]"
                            >
                                <i class="bi bi-briefcase text-sm"></i>
                            </div>

                        </div>

                    </a>


                    {{-- Pesanan --}}
                    <a
                        href="{{ route('freelancer.orders.index') }}"
                        class="group border-t border-[#EDF2F7] px-5 py-5
                               transition hover:bg-[#F8FAFC]
                               lg:border-r lg:px-6"
                    >

                        <div class="flex items-start justify-between gap-3">

                            <div>
                                <p class="text-[10px] text-[#64748B]">
                                    Pesanan
                                </p>

                                <p
                                    class="mt-1 text-[25px] font-bold
                                           tracking-tight text-[#172B4D]"
                                >
                                    {{ $orderCountValue }}
                                </p>
                            </div>

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center
                                       rounded-lg bg-[#EFF6FF] text-[#2563EB]"
                            >
                                <i class="bi bi-bag-check text-sm"></i>
                            </div>

                        </div>

                    </a>


                    {{-- Pesan --}}
                    <a
                        href="{{ route('freelancer.messages.index') }}"
                        class="group border-t border-[#EDF2F7] px-5 py-5
                               transition hover:bg-[#F8FAFC]
                               lg:border-r lg:px-6"
                    >

                        <div class="flex items-start justify-between gap-3">

                            <div>
                                <p class="text-[10px] text-[#64748B]">
                                    Pesan
                                </p>

                                <p
                                    class="mt-1 text-[25px] font-bold
                                           tracking-tight text-[#172B4D]"
                                >
                                    {{ $conversationCountValue }}
                                </p>
                            </div>

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center
                                       rounded-lg bg-[#EFF6FF] text-[#2563EB]"
                            >
                                <i class="bi bi-chat-dots text-sm"></i>
                            </div>

                        </div>

                    </a>


                    {{-- Saldo --}}
                    <a
                        href="{{ route('freelancer.wallet.index') }}"
                        class="group border-t border-[#EDF2F7] px-5 py-5
                               transition hover:bg-[#F8FAFC]
                               lg:px-6"
                    >

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <p class="text-[10px] text-[#64748B]">
                                    Saldo
                                </p>

                                <p
                                    class="mt-1 truncate text-[19px] font-bold
                                           tracking-tight text-[#172B4D]"
                                >
                                    Rp {{ number_format($balanceValue, 0, ',', '.') }}
                                </p>

                            </div>

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center
                                       rounded-lg bg-[#EFF6FF] text-[#2563EB]"
                            >
                                <i class="bi bi-wallet2 text-sm"></i>
                            </div>

                        </div>

                    </a>

                </div>

            </section>



            {{-- =========================================================
                CHART + QUICK SUMMARY
            ========================================================== --}}
            <section
                class="mt-0 grid gap-5 lg:mt-5 lg:grid-cols-[minmax(0,1.65fr)_minmax(260px,0.7fr)]"
            >


                {{-- =====================================================
                    PERFORMANCE GRAPH
                ====================================================== --}}
                <div
                    class="border-b border-[#E8EDF3] bg-white px-5 py-5
                           lg:rounded-[22px] lg:border lg:border-[#E2E8F0]
                           lg:px-6 lg:py-6
                           lg:shadow-[0_8px_30px_rgba(15,23,42,0.035)]"
                >

                    <div class="flex items-start justify-between gap-4">

                        <div>

                            <h2 class="text-sm font-bold text-[#172B4D]">
                                Performa pesanan
                            </h2>

                            <p class="mt-1 text-[11px] text-[#94A3B8]">
                                Nilai pesanan terbaru
                            </p>

                        </div>

                        <div
                            class="flex h-9 w-9 items-center justify-center
                                   rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>

                    </div>


                    @if ($chartOrders->count())

                        <div class="mt-5 h-[230px] w-full">
                            <canvas id="freelancerPerformanceChart"></canvas>
                        </div>

                    @else

                        <div
                            class="flex h-[230px] items-center justify-center
                                   text-center"
                        >

                            <div>

                                <div
                                    class="mx-auto flex h-12 w-12 items-center justify-center
                                           rounded-full bg-[#F8FAFC] text-[#94A3B8]"
                                >
                                    <i class="bi bi-bar-chart text-lg"></i>
                                </div>

                                <p
                                    class="mt-3 text-xs font-semibold text-[#475569]"
                                >
                                    Belum ada data grafik
                                </p>

                                <p
                                    class="mt-1 text-[10px] text-[#94A3B8]"
                                >
                                    Grafik akan muncul setelah ada pesanan.
                                </p>

                            </div>

                        </div>

                    @endif

                </div>



                {{-- =====================================================
                    QUICK SUMMARY
                ====================================================== --}}
                <div
                    class="border-b border-[#E8EDF3] bg-white
                           lg:overflow-hidden lg:rounded-[22px]
                           lg:border lg:border-[#E2E8F0]
                           lg:shadow-[0_8px_30px_rgba(15,23,42,0.035)]"
                >

                    <div class="px-5 pt-5 lg:px-6 lg:pt-6">

                        <h2 class="text-sm font-bold text-[#172B4D]">
                            Aktivitas
                        </h2>

                        <p class="mt-1 text-[11px] text-[#94A3B8]">
                            Informasi akun freelancer
                        </p>

                    </div>


                    <div class="mt-4 border-t border-[#EDF2F7]">


                        {{-- Rating --}}
                        <div
                            class="flex items-center justify-between
                                   border-b border-[#EDF2F7] px-5 py-4
                                   lg:px-6"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-9 w-9 items-center justify-center
                                           rounded-xl bg-[#FFF7E8] text-[#F59E0B]"
                                >
                                    <i class="bi bi-star-fill text-xs"></i>
                                </div>

                                <div>
                                    <p class="text-[11px] text-[#94A3B8]">
                                        Rating
                                    </p>

                                    <p class="mt-0.5 text-sm font-bold text-[#172B4D]">
                                        {{ $ratingValue }}
                                    </p>
                                </div>

                            </div>

                            <span class="text-[10px] text-[#94A3B8]">
                                / 5.0
                            </span>

                        </div>


                        {{-- Completed --}}
                        <div
                            class="flex items-center justify-between
                                   border-b border-[#EDF2F7] px-5 py-4
                                   lg:px-6"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-9 w-9 items-center justify-center
                                           rounded-xl bg-[#ECFDF5] text-[#059669]"
                                >
                                    <i class="bi bi-check2-circle text-sm"></i>
                                </div>

                                <div>
                                    <p class="text-[11px] text-[#94A3B8]">
                                        Pesanan selesai
                                    </p>

                                    <p class="mt-0.5 text-sm font-bold text-[#172B4D]">
                                        {{ $completedOrders }}
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- Profile --}}
                        <a
                            href="{{ route('freelancer.profile.edit') }}"
                            class="group flex items-center gap-3
                                   px-5 py-4 transition hover:bg-[#F8FAFC]
                                   lg:px-6"
                        >

                            <div
                                class="flex h-9 w-9 items-center justify-center
                                       rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                            >
                                <i class="bi bi-person-gear text-sm"></i>
                            </div>

                            <div class="min-w-0 flex-1">

                                <p class="text-xs font-semibold text-[#334155]">
                                    Kelola profil
                                </p>

                                <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                                    Perbarui profil freelancer
                                </p>

                            </div>

                            <i
                                class="bi bi-chevron-right text-[10px]
                                       text-[#CBD5E1]
                                       group-hover:text-[#2563EB]"
                            ></i>

                        </a>

                    </div>

                </div>

            </section>



            {{-- =========================================================
                RECENT ORDERS
            ========================================================== --}}
            <section
                class="mt-0 overflow-hidden border-b border-[#E8EDF3] bg-white
                       lg:mt-5 lg:rounded-[22px]
                       lg:border lg:border-[#E2E8F0]
                       lg:shadow-[0_8px_30px_rgba(15,23,42,0.035)]"
            >

                <div
                    class="flex items-center justify-between px-5 py-5
                           lg:px-6"
                >

                    <div>

                        <h2 class="text-sm font-bold text-[#172B4D]">
                            Pesanan terbaru
                        </h2>

                        <p class="mt-1 text-[11px] text-[#94A3B8]">
                            Pekerjaan yang baru masuk atau sedang berjalan
                        </p>

                    </div>

                    <a
                        href="{{ route('freelancer.orders.index') }}"
                        class="inline-flex items-center gap-1.5
                               text-[11px] font-semibold text-[#2563EB]"
                    >
                        Lihat semua
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                @if ($recentOrdersCollection->count())

                    <div class="border-t border-[#EDF2F7]">

                        @foreach ($recentOrdersCollection as $order)

                            @php
                                $orderItem = $order->items->first();

                                $serviceTitle = $orderItem?->service_title
                                    ?? $orderItem?->title
                                    ?? 'Pesanan jasa';

                                $statusKey = $order->status;

                                $statusConfig = match ($statusKey) {

                                    'pending_payment' => [
                                        'label' => 'Menunggu pembayaran',
                                        'class' => 'bg-[#FFF7E8] text-[#9A6A12]',
                                    ],

                                    'paid' => [
                                        'label' => 'Sudah dibayar',
                                        'class' => 'bg-[#EFF6FF] text-[#2563EB]',
                                    ],

                                    'in_progress' => [
                                        'label' => 'Sedang dikerjakan',
                                        'class' => 'bg-[#EEF2FF] text-[#4F46E5]',
                                    ],

                                    'delivered' => [
                                        'label' => 'Menunggu persetujuan',
                                        'class' => 'bg-[#FFF1E8] text-[#B85C18]',
                                    ],

                                    'revision' => [
                                        'label' => 'Revisi',
                                        'class' => 'bg-[#F5F3FF] text-[#7C3AED]',
                                    ],

                                    'completed' => [
                                        'label' => 'Selesai',
                                        'class' => 'bg-[#ECFDF5] text-[#047857]',
                                    ],

                                    'cancelled' => [
                                        'label' => 'Dibatalkan',
                                        'class' => 'bg-[#FEF2F2] text-[#B42318]',
                                    ],

                                    default => [
                                        'label' => ucfirst(
                                            str_replace('_', ' ', $statusKey)
                                        ),
                                        'class' => 'bg-[#F1F5F9] text-[#64748B]',
                                    ],
                                };
                            @endphp


                            <a
                                href="{{ route('freelancer.orders.show', $order) }}"
                                class="group block border-b border-[#EDF2F7]
                                       px-5 py-4 transition last:border-b-0
                                       hover:bg-[#F8FAFC]
                                       lg:px-6 lg:py-5"
                            >

                                <div class="flex items-center gap-3.5">

                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center
                                               justify-center rounded-full
                                               bg-[#EFF6FF] text-[#2563EB]"
                                    >
                                        <i class="bi bi-bag-check"></i>
                                    </div>


                                    <div class="min-w-0 flex-1">

                                        <h3
                                            class="truncate text-sm font-semibold
                                                   text-[#334155]
                                                   group-hover:text-[#2563EB]"
                                        >
                                            {{ $serviceTitle }}
                                        </h3>

                                        <p
                                            class="mt-1 truncate text-[10px]
                                                   text-[#94A3B8]"
                                        >
                                            {{ $order->client?->name ?? 'Client' }}

                                            @if ($order->created_at)
                                                <span class="mx-1">
                                                    •
                                                </span>

                                                {{ $order->created_at->format('d M Y') }}
                                            @endif
                                        </p>

                                    </div>


                                    <div class="hidden text-right sm:block">

                                        <p
                                            class="text-sm font-bold text-[#172B4D]"
                                        >
                                            Rp {{ number_format(
                                                (float) $order->total,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </p>

                                        <p class="mt-1 text-[9px] text-[#94A3B8]">
                                            {{ $order->order_number ?? 'Order' }}
                                        </p>

                                    </div>


                                    <div class="shrink-0 text-right">

                                        <span
                                            class="inline-flex rounded-full
                                                   px-2.5 py-1.5 text-[9px]
                                                   font-semibold
                                                   {{ $statusConfig['class'] }}"
                                        >
                                            {{ $statusConfig['label'] }}
                                        </span>

                                        <i
                                            class="bi bi-chevron-right mt-1 block
                                                   text-[10px] text-[#CBD5E1]
                                                   group-hover:text-[#2563EB]"
                                        ></i>

                                    </div>

                                </div>


                                {{-- Mobile amount --}}
                                <div
                                    class="mt-3 flex items-center justify-between
                                           border-t border-[#F1F5F9] pt-3
                                           sm:hidden"
                                >

                                    <span class="text-[9px] text-[#94A3B8]">
                                        {{ $order->order_number ?? 'Order' }}
                                    </span>

                                    <span class="text-xs font-bold text-[#172B4D]">
                                        Rp {{ number_format(
                                            (float) $order->total,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </span>

                                </div>

                            </a>

                        @endforeach

                    </div>

                @else

                    <div
                        class="border-t border-[#EDF2F7] px-5 py-12 text-center"
                    >

                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center
                                   rounded-full bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-bag text-xl"></i>
                        </div>

                        <h3
                            class="mt-4 text-sm font-semibold text-[#334155]"
                        >
                            Belum ada pesanan
                        </h3>

                        <p
                            class="mx-auto mt-1.5 max-w-sm text-xs leading-5
                                   text-[#94A3B8]"
                        >
                            Pesanan dari client akan muncul di sini.
                        </p>

                        <a
                            href="{{ route('freelancer.services.index') }}"
                            class="mt-4 inline-flex items-center gap-1.5
                                   text-xs font-semibold text-[#2563EB]"
                        >
                            Kelola jasa
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                @endif

            </section>



            {{-- =========================================================
                QUICK ACTIONS
            ========================================================== --}}
            <section
                class="mt-0 border-b border-[#E8EDF3] bg-white
                       lg:mt-5 lg:rounded-[22px]
                       lg:border lg:border-[#E2E8F0]
                       lg:shadow-[0_8px_30px_rgba(15,23,42,0.035)]"
            >

                <div class="px-5 py-5 lg:px-6">

                    <h2 class="text-sm font-bold text-[#172B4D]">
                        Akses cepat
                    </h2>

                    <p class="mt-1 text-[11px] text-[#94A3B8]">
                        Fitur yang sering digunakan
                    </p>

                </div>


                <div
                    class="grid border-t border-[#EDF2F7]
                           sm:grid-cols-2 lg:grid-cols-4"
                >

                    {{-- Tambah jasa --}}
                    <a
                        href="{{ route('freelancer.services.create') }}"
                        class="group flex items-center gap-3
                               border-b border-[#EDF2F7] px-5 py-4
                               transition hover:bg-[#F8FAFC]
                               sm:border-r lg:border-b-0 lg:px-6"
                    >

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center
                                   rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="text-xs font-semibold text-[#334155]">
                                Tambah jasa
                            </p>

                            <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                                Buat layanan baru
                            </p>

                        </div>

                        <i
                            class="bi bi-chevron-right text-[10px]
                                   text-[#CBD5E1]
                                   group-hover:text-[#2563EB]"
                        ></i>

                    </a>


                    {{-- Pesan --}}
                    <a
                        href="{{ route('freelancer.messages.index') }}"
                        class="group flex items-center gap-3
                               border-b border-[#EDF2F7] px-5 py-4
                               transition hover:bg-[#F8FAFC]
                               lg:border-r lg:border-b-0 lg:px-6"
                    >

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center
                                   rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-chat-dots"></i>
                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="text-xs font-semibold text-[#334155]">
                                Pesan
                            </p>

                            <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                                Hubungi client
                            </p>

                        </div>

                        <i
                            class="bi bi-chevron-right text-[10px]
                                   text-[#CBD5E1]
                                   group-hover:text-[#2563EB]"
                        ></i>

                    </a>


                    {{-- Pesanan --}}
                    <a
                        href="{{ route('freelancer.orders.index') }}"
                        class="group flex items-center gap-3
                               border-b border-[#EDF2F7] px-5 py-4
                               transition hover:bg-[#F8FAFC]
                               sm:border-r lg:border-b-0 lg:px-6"
                    >

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center
                                   rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-bag-check"></i>
                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="text-xs font-semibold text-[#334155]">
                                Pesanan
                            </p>

                            <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                                Kelola pekerjaan
                            </p>

                        </div>

                        <i
                            class="bi bi-chevron-right text-[10px]
                                   text-[#CBD5E1]
                                   group-hover:text-[#2563EB]"
                        ></i>

                    </a>


                    {{-- Wallet --}}
                    <a
                        href="{{ route('freelancer.wallet.index') }}"
                        class="group flex items-center gap-3
                               px-5 py-4 transition hover:bg-[#F8FAFC]
                               lg:px-6"
                    >

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center
                                   rounded-xl bg-[#EFF6FF] text-[#2563EB]"
                        >
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="text-xs font-semibold text-[#334155]">
                                Dompet
                            </p>

                            <p class="mt-0.5 text-[10px] text-[#94A3B8]">
                                Kelola pendapatan
                            </p>

                        </div>

                        <i
                            class="bi bi-chevron-right text-[10px]
                                   text-[#CBD5E1]
                                   group-hover:text-[#2563EB]"
                        ></i>

                    </a>

                </div>

            </section>

        </div>

    </main>


    {{-- ================================================================
        CHART.JS
    ================================================================= --}}
    @if ($chartOrders->count())

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const canvas = document.getElementById(
                    'freelancerPerformanceChart'
                );

                if (!canvas) return;

                const labels = @json($chartLabels);
                const values = @json($chartValues);

                new Chart(canvas, {
                    type: 'line',

                    data: {
                        labels: labels,

                        datasets: [{
                            data: values,

                            borderColor: '#2563EB',

                            backgroundColor: 'rgba(37, 99, 235, 0.08)',

                            borderWidth: 2.5,

                            pointRadius: 3,

                            pointHoverRadius: 5,

                            pointBackgroundColor: '#2563EB',

                            pointBorderColor: '#FFFFFF',

                            pointBorderWidth: 2,

                            fill: true,

                            tension: 0.4
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
                                displayColors: false,

                                backgroundColor: '#172B4D',

                                padding: 10,

                                titleFont: {
                                    size: 11,
                                    weight: '600'
                                },

                                bodyFont: {
                                    size: 11
                                },

                                callbacks: {
                                    label: function (context) {

                                        const value = context.parsed.y ?? 0;

                                        return ' Rp ' +
                                            new Intl.NumberFormat('id-ID')
                                                .format(value);
                                    }
                                }
                            }
                        },

                        scales: {

                            x: {
                                grid: {
                                    display: false
                                },

                                border: {
                                    display: false
                                },

                                ticks: {
                                    color: '#94A3B8',
                                    font: {
                                        size: 10
                                    }
                                }
                            },

                            y: {
                                beginAtZero: true,

                                grid: {
                                    color: '#F1F5F9'
                                },

                                border: {
                                    display: false
                                },

                                ticks: {
                                    color: '#94A3B8',

                                    font: {
                                        size: 10
                                    },

                                    callback: function (value) {

                                        if (value >= 1000000) {
                                            return 'Rp ' +
                                                (value / 1000000)
                                                    .toFixed(1) +
                                                ' jt';
                                        }

                                        if (value >= 1000) {
                                            return 'Rp ' +
                                                (value / 1000)
                                                    .toFixed(0) +
                                                ' rb';
                                        }

                                        return 'Rp ' + value;
                                    }
                                }
                            }
                        }
                    }
                });

            });
        </script>

    @endif

</x-layouts.freelancer>
