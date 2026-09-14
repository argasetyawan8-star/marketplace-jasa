<x-layouts.freelancer title="Dashboard">

    @php
        $user = auth()->user();
        $profile = $user?->freelancerProfile;

        $serviceCountValue = (int) ($serviceCount ?? 0);
        $orderCountValue = (int) ($orderCount ?? 0);
        $conversationCountValue = (int) ($conversationCount ?? 0);
        $balanceValue = (float) ($balance ?? 0);

        $recentOrdersCollection = collect($recentOrders ?? []);
    @endphp

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- =========================================================
            WELCOME
        ========================================================== --}}
        <section class="overflow-hidden rounded-[24px] bg-[#123128]">

            <div class="relative px-5 py-7 sm:px-7 sm:py-8 lg:px-8">

                {{-- Decorative shapes --}}
                <div class="pointer-events-none absolute -right-16 -top-20 h-56 w-56 rounded-full border border-white/10"></div>
                <div class="pointer-events-none absolute -bottom-24 right-16 h-44 w-44 rounded-full border border-white/5"></div>

                <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

                    <div class="min-w-0">

                        <div class="flex items-center gap-3">

                            {{-- Avatar --}}
                            <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full bg-[#D8F0E2] ring-2 ring-white/10">

                                @if ($profile?->avatar)

                                    <img
                                        src="{{ asset('storage/' . $profile->avatar) }}"
                                        alt="{{ $user->name }}"
                                        class="block h-full w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-[#0F6B3A]">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>

                                @endif

                            </div>

                            <div class="min-w-0">
                                <p class="text-[11px] font-medium uppercase tracking-[0.08em] text-[#9AD7B5]">
                                    Dashboard freelancer
                                </p>

                                <p class="mt-1 truncate text-xs text-white/55">
                                    {{ $profile?->username ? '@' . $profile->username : 'Kelola aktivitasmu di JASAIN' }}
                                </p>
                            </div>

                        </div>

                        <h1 class="mt-6 max-w-2xl text-2xl font-semibold tracking-tight text-white sm:text-[30px]">
                            Halo, {{ $user->name }}.
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-white/65 sm:text-[15px]">
                            Kelola jasa, pesanan, percakapan dengan client, dan pendapatan
                            kamu dalam satu tempat.
                        </p>

                    </div>

                    {{-- CTA --}}
                    <div class="shrink-0">

                        <a
                            href="{{ route('freelancer.services.create') }}"
                            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 text-sm font-semibold text-white transition hover:bg-[#2BB66C] sm:w-auto"
                        >
                            <i class="bi bi-plus-lg"></i>
                            Tambah jasa
                        </a>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
            STATS
        ========================================================== --}}
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Services --}}
            <a
                href="{{ route('freelancer.services.index') }}"
                class="group rounded-[20px] border border-[#DDE9E2] bg-white p-5 transition duration-200 hover:-translate-y-0.5 hover:border-[#C8DDD0] hover:shadow-[0_12px_30px_rgba(18,49,40,0.05)]"
            >
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-xs text-[#84958D]">
                            Jasa aktif
                        </p>

                        <p class="mt-2 text-[28px] font-semibold tracking-tight text-[#123128]">
                            {{ $serviceCountValue }}
                        </p>

                        <p class="mt-2 text-[11px] text-[#9AA8A2]">
                            Layanan yang kamu tawarkan
                        </p>
                    </div>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] transition group-hover:bg-[#DDF3E6]">
                        <i class="bi bi-briefcase"></i>
                    </div>

                </div>
            </a>


            {{-- Orders --}}
            <a
                href="{{ route('freelancer.orders.index') }}"
                class="group rounded-[20px] border border-[#DDE9E2] bg-white p-5 transition duration-200 hover:-translate-y-0.5 hover:border-[#C8DDD0] hover:shadow-[0_12px_30px_rgba(18,49,40,0.05)]"
            >
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-xs text-[#84958D]">
                            Pesanan
                        </p>

                        <p class="mt-2 text-[28px] font-semibold tracking-tight text-[#123128]">
                            {{ $orderCountValue }}
                        </p>

                        <p class="mt-2 text-[11px] text-[#9AA8A2]">
                            Total pesanan yang masuk
                        </p>
                    </div>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EEF6F1] text-[#28664A] transition group-hover:bg-[#E2F1E8]">
                        <i class="bi bi-bag-check"></i>
                    </div>

                </div>
            </a>


            {{-- Conversations --}}
            <a
                href="{{ route('freelancer.messages.index') }}"
                class="group rounded-[20px] border border-[#DDE9E2] bg-white p-5 transition duration-200 hover:-translate-y-0.5 hover:border-[#C8DDD0] hover:shadow-[0_12px_30px_rgba(18,49,40,0.05)]"
            >
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-xs text-[#84958D]">
                            Percakapan
                        </p>

                        <p class="mt-2 text-[28px] font-semibold tracking-tight text-[#123128]">
                            {{ $conversationCountValue }}
                        </p>

                        <p class="mt-2 text-[11px] text-[#9AA8A2]">
                            Komunikasi dengan client
                        </p>
                    </div>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] transition group-hover:bg-[#DDF3E6]">
                        <i class="bi bi-chat-dots"></i>
                    </div>

                </div>
            </a>


            {{-- Balance --}}
            <a
                href="{{ route('freelancer.wallet.index') }}"
                class="group rounded-[20px] border border-[#DDE9E2] bg-white p-5 transition duration-200 hover:-translate-y-0.5 hover:border-[#C8DDD0] hover:shadow-[0_12px_30px_rgba(18,49,40,0.05)]"
            >
                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">
                        <p class="text-xs text-[#84958D]">
                            Saldo
                        </p>

                        <p class="mt-2 truncate text-[22px] font-semibold tracking-tight text-[#123128] sm:text-[24px]">
                            Rp {{ number_format($balanceValue, 0, ',', '.') }}
                        </p>

                        <p class="mt-2 text-[11px] text-[#9AA8A2]">
                            Saldo yang tersedia
                        </p>
                    </div>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F2F8F4] text-[#0F6B3A] transition group-hover:bg-[#EAF7EF]">
                        <i class="bi bi-wallet2"></i>
                    </div>

                </div>
            </a>

        </section>


        {{-- =========================================================
            MAIN CONTENT
        ========================================================== --}}
        <section class="grid gap-6 xl:grid-cols-[minmax(0,1.5fr)_minmax(320px,0.85fr)]">

            {{-- Recent Orders --}}
            <div class="overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

                <div class="flex flex-col gap-3 border-b border-[#E8EFEA] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Pesanan terbaru
                        </h2>

                        <p class="mt-1 text-xs text-[#8A9B94]">
                            Aktivitas pesanan terakhir yang perlu kamu perhatikan.
                        </p>
                    </div>

                    <a
                        href="{{ route('freelancer.orders.index') }}"
                        class="inline-flex w-fit items-center gap-1.5 text-xs font-semibold text-[#0F6B3A] transition hover:text-[#1E9E5A]"
                    >
                        Lihat semua
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                @if ($recentOrdersCollection->count())

                    <div class="divide-y divide-[#E9EFEB]">

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
                                        'class' => 'bg-[#EEF6FF] text-[#2B6CB0]',
                                    ],
                                    'in_progress' => [
                                        'label' => 'Sedang dikerjakan',
                                        'class' => 'bg-[#EAF7EF] text-[#0F6B3A]',
                                    ],
                                    'delivered' => [
                                        'label' => 'Menunggu persetujuan',
                                        'class' => 'bg-[#FFF1E8] text-[#B85C18]',
                                    ],
                                    'revision' => [
                                        'label' => 'Revisi',
                                        'class' => 'bg-[#F5EFFC] text-[#7650A8]',
                                    ],
                                    'completed' => [
                                        'label' => 'Selesai',
                                        'class' => 'bg-[#EAF7EF] text-[#0F6B3A]',
                                    ],
                                    'cancelled' => [
                                        'label' => 'Dibatalkan',
                                        'class' => 'bg-[#FDEEEE] text-[#B42318]',
                                    ],
                                    default => [
                                        'label' => ucfirst(str_replace('_', ' ', $statusKey)),
                                        'class' => 'bg-[#F3F6F4] text-[#677870]',
                                    ],
                                };
                            @endphp

                            <a
                                href="{{ route('freelancer.orders.show', $order) }}"
                                class="group block px-5 py-5 transition hover:bg-[#FBFDFC] sm:px-6"
                            >

                                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                                    <div class="flex min-w-0 items-start gap-3.5">

                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F0F7F3] text-[#0F6B3A]"
                                        >
                                            <i class="bi bi-bag-check"></i>
                                        </div>

                                        <div class="min-w-0">
                                            <h3 class="truncate text-sm font-medium text-[#29483D] transition group-hover:text-[#0F6B3A]">
                                                {{ $serviceTitle }}
                                            </h3>

                                            <p class="mt-1.5 text-xs text-[#8A9B94]">
                                                {{ $order->client?->name ?? 'Client' }}

                                                @if ($order->created_at)
                                                    <span class="mx-1 text-[#C5D0CB]">•</span>
                                                    {{ $order->created_at->format('d M Y') }}
                                                @endif
                                            </p>
                                        </div>

                                    </div>


                                    <div class="flex items-center justify-between gap-4 sm:justify-end">

                                        <div class="text-left sm:text-right">
                                            <p class="text-sm font-semibold text-[#123128]">
                                                Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                            </p>

                                            <p class="mt-1 text-[10px] text-[#9AA8A2]">
                                                {{ $order->order_number ?? 'Order' }}
                                            </p>
                                        </div>

                                        <span
                                            class="shrink-0 rounded-full px-2.5 py-1.5 text-[10px] font-semibold {{ $statusConfig['class'] }}"
                                        >
                                            {{ $statusConfig['label'] }}
                                        </span>

                                        <i class="bi bi-chevron-right shrink-0 text-xs text-[#A0ADA7] transition group-hover:translate-x-0.5 group-hover:text-[#0F6B3A]"></i>

                                    </div>

                                </div>

                            </a>

                        @endforeach

                    </div>

                @else

                    <div class="px-6 py-14 text-center">

                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A]"
                        >
                            <i class="bi bi-bag text-xl"></i>
                        </div>

                        <h3 class="mt-5 text-sm font-semibold text-[#29483D]">
                            Belum ada pesanan
                        </h3>

                        <p class="mx-auto mt-2 max-w-sm text-xs leading-5 text-[#8A9B94]">
                            Pesanan dari client akan muncul di sini setelah ada transaksi
                            melalui JASAIN.
                        </p>

                        <a
                            href="{{ route('freelancer.services.index') }}"
                            class="mt-5 inline-flex items-center gap-2 rounded-xl border border-[#D8E5DD] bg-white px-4 py-2.5 text-xs font-semibold text-[#0F6B3A] transition hover:bg-[#F8FCF9]"
                        >
                            Kelola jasa
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                @endif

            </div>


            {{-- Quick Actions --}}
            <div class="overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

                <div class="border-b border-[#E8EFEA] px-5 py-5 sm:px-6">

                    <h2 class="text-base font-semibold text-[#123128]">
                        Akses cepat
                    </h2>

                    <p class="mt-1 text-xs text-[#8A9B94]">
                        Shortcut untuk aktivitas freelancer kamu.
                    </p>

                </div>


                <div class="p-4 sm:p-5">

                    <div class="space-y-2">

                        {{-- Add Service --}}
                        <a
                            href="{{ route('freelancer.services.create') }}"
                            class="group flex items-center gap-3.5 rounded-2xl p-3.5 transition hover:bg-[#F8FCF9]"
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] transition group-hover:bg-[#DDF3E6]"
                            >
                                <i class="bi bi-plus-lg"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-[#29483D]">
                                    Tambah jasa
                                </p>

                                <p class="mt-0.5 text-[11px] text-[#8A9B94]">
                                    Tawarkan layanan baru
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[11px] text-[#A4B0AB] transition group-hover:text-[#0F6B3A]"></i>
                        </a>


                        {{-- Messages --}}
                        <a
                            href="{{ route('freelancer.messages.index') }}"
                            class="group flex items-center gap-3.5 rounded-2xl p-3.5 transition hover:bg-[#F8FCF9]"
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F2F8F4] text-[#0F6B3A] transition group-hover:bg-[#EAF7EF]"
                            >
                                <i class="bi bi-chat-dots"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-[#29483D]">
                                    Buka pesan
                                </p>

                                <p class="mt-0.5 text-[11px] text-[#8A9B94]">
                                    Balas client dan kirim penawaran
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[11px] text-[#A4B0AB] transition group-hover:text-[#0F6B3A]"></i>
                        </a>


                        {{-- Orders --}}
                        <a
                            href="{{ route('freelancer.orders.index') }}"
                            class="group flex items-center gap-3.5 rounded-2xl p-3.5 transition hover:bg-[#F8FCF9]"
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F2F8F4] text-[#0F6B3A] transition group-hover:bg-[#EAF7EF]"
                            >
                                <i class="bi bi-bag-check"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-[#29483D]">
                                    Kelola pesanan
                                </p>

                                <p class="mt-0.5 text-[11px] text-[#8A9B94]">
                                    Lihat dan kerjakan pesanan client
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[11px] text-[#A4B0AB] transition group-hover:text-[#0F6B3A]"></i>
                        </a>


                        {{-- Wallet --}}
                        <a
                            href="{{ route('freelancer.wallet.index') }}"
                            class="group flex items-center gap-3.5 rounded-2xl p-3.5 transition hover:bg-[#F8FCF9]"
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F2F8F4] text-[#0F6B3A] transition group-hover:bg-[#EAF7EF]"
                            >
                                <i class="bi bi-wallet2"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-[#29483D]">
                                    Lihat dompet
                                </p>

                                <p class="mt-0.5 text-[11px] text-[#8A9B94]">
                                    Cek saldo dan aktivitas pendapatan
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[11px] text-[#A4B0AB] transition group-hover:text-[#0F6B3A]"></i>
                        </a>


                        {{-- Profile --}}
                        <a
                            href="{{ route('freelancer.profile.edit') }}"
                            class="group flex items-center gap-3.5 rounded-2xl p-3.5 transition hover:bg-[#F8FCF9]"
                        >
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F2F8F4] text-[#0F6B3A] transition group-hover:bg-[#EAF7EF]"
                            >
                                <i class="bi bi-person-gear"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-[#29483D]">
                                    Edit profil
                                </p>

                                <p class="mt-0.5 text-[11px] text-[#8A9B94]">
                                    Lengkapi informasi freelancer
                                </p>
                            </div>

                            <i class="bi bi-chevron-right text-[11px] text-[#A4B0AB] transition group-hover:text-[#0F6B3A]"></i>
                        </a>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
            PROFILE / TIPS
        ========================================================== --}}
        <section class="grid gap-6 lg:grid-cols-[1fr_1.35fr]">

            {{-- Profile Summary --}}
            <div class="rounded-[22px] border border-[#DDE9E2] bg-white p-5 sm:p-6">

                <div class="flex items-center gap-4">

                    <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full bg-[#EAF7EF]">

                        @if ($profile?->avatar)

                            <img
                                src="{{ asset('storage/' . $profile->avatar) }}"
                                alt="{{ $user->name }}"
                                class="block h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full w-full items-center justify-center text-base font-semibold text-[#0F6B3A]">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                        @endif

                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-[#123128]">
                            {{ $user->name }}
                        </p>

                        <p class="mt-1 truncate text-xs text-[#8A9B94]">
                            {{ $profile?->headline ?: 'Freelancer di JASAIN' }}
                        </p>

                        @if ($profile?->location)
                            <p class="mt-1 flex items-center gap-1 text-[10px] text-[#9AA8A2]">
                                <i class="bi bi-geo-alt"></i>
                                {{ $profile->location }}
                            </p>
                        @endif
                    </div>

                </div>


                <div class="mt-5 grid grid-cols-2 gap-3">

                    <div class="rounded-xl bg-[#F8FCF9] p-3">
                        <p class="text-[10px] text-[#8A9B94]">
                            Rating
                        </p>

                        <p class="mt-1 text-sm font-semibold text-[#123128]">
                            <i class="bi bi-star-fill text-[#1E9E5A]"></i>
                            {{ number_format((float) ($profile?->rating ?? 0), 1) }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-[#F8FCF9] p-3">
                        <p class="text-[10px] text-[#8A9B94]">
                            Pesanan selesai
                        </p>

                        <p class="mt-1 text-sm font-semibold text-[#123128]">
                            {{ $profile?->completed_orders ?? 0 }}
                        </p>
                    </div>

                </div>


                <a
                    href="{{ route('freelancer.profile.show') }}"
                    class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-[#0F6B3A] transition hover:text-[#1E9E5A]"
                >
                    Lihat profil
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>


            {{-- Tips --}}
            <div class="overflow-hidden rounded-[22px] border border-[#D7E9DE] bg-[#EAF7EF] p-5 sm:p-6">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-start">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-lg text-[#0F6B3A]"
                    >
                        <i class="bi bi-lightbulb"></i>
                    </div>

                    <div class="min-w-0">

                        <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#1E9E5A]">
                            Tips freelancer
                        </p>

                        <h2 class="mt-2 text-lg font-semibold tracking-tight text-[#123128]">
                            Buat profil dan jasa yang mudah dipercaya client.
                        </h2>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-[#667D73]">
                            Gunakan judul jasa yang jelas, deskripsi yang lengkap,
                            harga yang sesuai, dan tampilkan informasi profil yang
                            membantu client memahami layananmu.
                        </p>

                        <div class="mt-4 flex flex-wrap gap-2">

                            <a
                                href="{{ route('freelancer.services.index') }}"
                                class="inline-flex h-9 items-center gap-1.5 rounded-xl bg-white px-3.5 text-[11px] font-semibold text-[#0F6B3A] transition hover:bg-[#F6FBF7]"
                            >
                                Kelola jasa
                                <i class="bi bi-arrow-right"></i>
                            </a>

                            <a
                                href="{{ route('freelancer.profile.edit') }}"
                                class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-[#C7E1D1] px-3.5 text-[11px] font-semibold text-[#416155] transition hover:bg-white"
                            >
                                Lengkapi profil
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

</x-layouts.freelancer>