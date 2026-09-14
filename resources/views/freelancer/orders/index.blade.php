<x-layouts.freelancer title="Pesanan">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                        <i class="bi bi-bag-check"></i>
                        Manajemen Pesanan
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        Pesanan
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#71837B]">
                        Pantau pesanan client, status pengerjaan, dan detail transaksi jasa kamu.
                    </p>
                </div>

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A]">
                    <i class="bi bi-bag-check text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="flex items-start gap-3 rounded-xl border border-[#CBEAD8] bg-[#EAF7EF] px-4 py-3.5 text-sm text-[#17663D]">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div>
                    <p class="font-semibold">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-[#557166]">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Order List --}}
        <div class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white">

            {{-- List Header --}}
            <div class="border-b border-[#E7EFEA] px-6 py-5 sm:px-7">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Semua Pesanan
                        </h2>

                        <p class="mt-1 text-sm text-[#8A9B94]">
                            {{ $orders->count() }} pesanan ditemukan.
                        </p>
                    </div>

                    <div class="inline-flex w-fit items-center gap-2 rounded-lg bg-[#F3F8F5] px-3 py-1.5 text-xs font-medium text-[#667D73]">
                        <i class="bi bi-list-check text-[#1E9E5A]"></i>
                        Pesanan terbaru
                    </div>
                </div>
            </div>

            {{-- Orders --}}
            @forelse($orders as $order)

                <a
                    href="{{ route('freelancer.orders.show', $order) }}"
                    class="group block border-b border-[#E7EFEA] p-5 transition last:border-b-0 hover:bg-[#F8FCF9] sm:p-6"
                >
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Left --}}
                        <div class="min-w-0 flex-1">

                            {{-- Number + Status --}}
                            <div class="flex flex-wrap items-center gap-2">

                                <span class="text-xs font-medium text-[#8A9B94]">
                                    #{{ $order->order_number }}
                                </span>

                                @if($order->status === 'pending_payment')
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#FFF7E6] px-2.5 py-1 text-xs font-semibold text-[#9A6700]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#D9A441]"></span>
                                        Menunggu Pembayaran
                                    </span>
                                @elseif($order->status === 'paid')
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#EFF6FF] px-2.5 py-1 text-xs font-semibold text-[#2563EB]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#3B82F6]"></span>
                                        Dibayar
                                    </span>
                                @elseif($order->status === 'in_progress')
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#EAF7EF] px-2.5 py-1 text-xs font-semibold text-[#17663D]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>
                                        Dikerjakan
                                    </span>
                                @elseif($order->status === 'delivered')
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#F3EEFF] px-2.5 py-1 text-xs font-semibold text-[#6B4BB6]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#8B5CF6]"></span>
                                        Menunggu Client
                                    </span>
                                @elseif($order->status === 'revision')
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#FFF4E8] px-2.5 py-1 text-xs font-semibold text-[#B45309]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#F59E0B]"></span>
                                        Revisi
                                    </span>
                                @elseif($order->status === 'completed')
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#DCFCE7] px-2.5 py-1 text-xs font-semibold text-[#166534]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#22C55E]"></span>
                                        Selesai
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#FEF0F0] px-2.5 py-1 text-xs font-semibold text-[#B42318]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#D92D20]"></span>
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#F3F5F4] px-2.5 py-1 text-xs font-semibold text-[#667D73]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#94A3A0]"></span>
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                @endif

                            </div>

                            {{-- Service Title --}}
                            <h3 class="mt-3 line-clamp-2 text-base font-semibold text-[#123128] transition group-hover:text-[#0F6B3A] sm:text-lg">
                                {{ $order->items->first()?->service_title ?? 'Pesanan Jasa' }}
                            </h3>

                            {{-- Meta --}}
                            <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm">

                                <span class="inline-flex items-center gap-1.5 text-[#667D73]">
                                    <i class="bi bi-person"></i>

                                    Client:
                                    <span class="font-medium text-[#123128]">
                                        {{ $order->client?->name ?? 'Client' }}
                                    </span>
                                </span>

                                <span class="inline-flex items-center gap-1.5 text-[#8A9B94]">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </span>

                            </div>

                        </div>

                        {{-- Right --}}
                        <div class="flex items-center justify-between gap-5 border-t border-[#E7EFEA] pt-4 sm:justify-end sm:border-t-0 sm:pt-0">

                            <div class="text-left sm:text-right">
                                <p class="text-xs font-medium text-[#8A9B94]">
                                    Total
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128]">
                                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F3F8F5] text-[#71837B] transition group-hover:bg-[#EAF7EF] group-hover:text-[#0F6B3A]">
                                <i class="bi bi-chevron-right"></i>
                            </div>

                        </div>

                    </div>
                </a>

            @empty

                {{-- Empty State --}}
                <div class="px-6 py-16 text-center sm:px-8">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-bag-x text-2xl"></i>
                    </div>

                    <h3 class="mt-5 text-base font-semibold text-[#123128]">
                        Belum ada pesanan
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#8A9B94]">
                        Pesanan dari client akan muncul di halaman ini ketika ada transaksi yang masuk.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</x-layouts.freelancer>