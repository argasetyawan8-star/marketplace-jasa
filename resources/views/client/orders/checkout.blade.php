<x-layouts.client title="Checkout">

    @php
        $serviceTitle = $order->items->first()?->service_title ?? 'Pesanan Jasa';

        $freelancerName =
            $order->freelancerProfile?->user?->name
            ?? 'Freelancer';

        $freelancerHeadline =
            $order->freelancerProfile?->headline
            ?? 'Freelancer JASAIN';

        $freelancerLocation =
            $order->freelancerProfile?->location;

        $freelancerInitial = strtoupper(
            substr($freelancerName, 0, 1)
        );

        $paymentStatus = match($order->payment?->status) {

            'pending' =>
                [
                    'label' => 'Menunggu pembayaran',
                    'class' => 'bg-[#FFF9EA] text-[#996600]',
                    'dot' => 'bg-[#D89B19]',
                ],

            'settlement',
            'capture',
            'paid' =>
                [
                    'label' => 'Pembayaran berhasil',
                    'class' => 'bg-[#EAF7EF] text-[#168A4D]',
                    'dot' => 'bg-[#35C978]',
                ],

            'deny' =>
                [
                    'label' => 'Pembayaran ditolak',
                    'class' => 'bg-[#FFF5F5] text-[#B84E4E]',
                    'dot' => 'bg-[#D16B6B]',
                ],

            'cancel' =>
                [
                    'label' => 'Pembayaran dibatalkan',
                    'class' => 'bg-[#FFF5F5] text-[#B84E4E]',
                    'dot' => 'bg-[#D16B6B]',
                ],

            'expire' =>
                [
                    'label' => 'Pembayaran kedaluwarsa',
                    'class' => 'bg-[#F5F6F5] text-[#6E7C75]',
                    'dot' => 'bg-[#9DA8A2]',
                ],

            default =>
                [
                    'label' => ucfirst($order->payment?->status ?? 'Pending'),
                    'class' => 'bg-[#F5F7F6] text-[#697971]',
                    'dot' => 'bg-[#9DA8A2]',
                ],

        };
    @endphp


    <div class="min-h-screen bg-[#F8FCF9]">

        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">


            {{-- =========================================================
                HEADER
            ========================================================== --}}
            <div class="mb-7">

                <a
                    href="{{ route('client.orders.show', $order) }}"
                    class="inline-flex items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
                >
                    <i class="bi bi-arrow-left text-[12px]"></i>
                    Kembali ke detail order
                </a>


                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <div class="flex items-center gap-2">

                            <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                                Secure Checkout
                            </p>

                        </div>

                        <h1 class="mt-2 text-2xl font-semibold tracking-[-0.03em] text-[#123128] sm:text-[28px]">
                            Checkout
                        </h1>

                        <p class="mt-2 max-w-xl text-sm leading-6 text-[#7B8C84]">
                            Periksa kembali detail pesanan sebelum menyelesaikan pembayaran.
                        </p>

                    </div>


                    <div class="inline-flex items-center gap-2 text-[10px] text-[#8A9992]">

                        <i class="bi bi-shield-check text-[#1E9E5A]"></i>

                        Pembayaran aman

                    </div>

                </div>

            </div>


            {{-- =========================================================
                ALERTS
            ========================================================== --}}
            @if(session('success'))

                <div class="mb-6 overflow-hidden rounded-xl border border-[#CDE8D7] bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="flex items-center gap-3 px-4 py-3.5">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF]">
                            <i class="bi bi-check-lg text-sm text-[#1E9E5A]"></i>
                        </div>

                        <p class="text-sm text-[#355248]">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            @if(session('error'))

                <div class="mb-6 overflow-hidden rounded-xl border border-red-100 bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="flex items-center gap-3 px-4 py-3.5">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-50">
                            <i class="bi bi-exclamation-lg text-sm text-red-500"></i>
                        </div>

                        <p class="text-sm text-red-600">
                            {{ session('error') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                CHECKOUT GRID
            ========================================================== --}}
            <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_380px]">


                {{-- =====================================================
                    LEFT
                ====================================================== --}}
                <div class="space-y-5">


                    {{-- Order detail --}}
                    <section class="overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_6px_22px_rgba(18,49,40,0.035)]">

                        <div class="flex items-center justify-between border-b border-[#E9EFEB] px-5 py-4 sm:px-6">

                            <div>

                                <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                    Pesanan
                                </p>

                                <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                    Detail pesanan
                                </h2>

                            </div>


                            <span class="rounded-full bg-[#F4F7F5] px-2.5 py-1 text-[9px] font-medium text-[#7D8C85]">
                                {{ $order->order_number }}
                            </span>

                        </div>


                        <div class="divide-y divide-[#EDF2EF]">

                            @forelse($order->items as $item)

                                <div class="flex gap-4 px-5 py-5 sm:px-6">

                                    {{-- Thumbnail --}}
                                    <div class="h-[72px] w-[72px] shrink-0 overflow-hidden rounded-xl bg-[#EAF7EF]">

                                        @if($item->service?->thumbnail)

                                            <img
                                                src="{{ asset('storage/' . $item->service->thumbnail) }}"
                                                alt="{{ $item->service_title }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @else

                                            <div class="flex h-full w-full items-center justify-center text-[#1E9E5A]">

                                                <i class="bi bi-image text-xl"></i>

                                            </div>

                                        @endif

                                    </div>


                                    {{-- Content --}}
                                    <div class="min-w-0 flex-1">

                                        <h3 class="text-sm font-semibold leading-6 text-[#18382E]">
                                            {{ $item->service_title }}
                                        </h3>


                                        <div class="mt-2 flex flex-wrap gap-x-4 gap-y-2">

                                            <span class="inline-flex items-center gap-1.5 text-[10px] text-[#8A9992]">

                                                <i class="bi bi-box text-[#1E9E5A]"></i>

                                                Qty {{ $item->quantity }}

                                            </span>


                                            <span class="inline-flex items-center gap-1.5 text-[10px] text-[#8A9992]">

                                                <i class="bi bi-clock text-[#1E9E5A]"></i>

                                                {{ $item->delivery_days }} hari

                                            </span>

                                        </div>


                                        <p class="mt-3 text-sm font-semibold text-[#123128]">
                                            Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>

                            @empty

                                <div class="px-5 py-8 sm:px-6">

                                    <p class="text-sm text-[#8A9992]">
                                        Tidak ada item dalam order.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </section>


                    {{-- Freelancer --}}
                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_6px_22px_rgba(18,49,40,0.035)] sm:p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                    Freelancer
                                </p>

                                <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                    Penyedia jasa
                                </h2>

                            </div>

                            <i class="bi bi-person-check text-[#A0ADA7]"></i>

                        </div>


                        <div class="mt-5 flex items-center gap-4">

                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A]">
                                {{ $freelancerInitial }}
                            </div>


                            <div class="min-w-0 flex-1">

                                <h3 class="truncate text-sm font-semibold text-[#18382E]">
                                    {{ $freelancerName }}
                                </h3>

                                <p class="mt-1 truncate text-xs text-[#7F8E87]">
                                    {{ $freelancerHeadline }}
                                </p>


                                @if($freelancerLocation)

                                    <p class="mt-2 flex items-center gap-1.5 text-[10px] text-[#96A39D]">

                                        <i class="bi bi-geo-alt text-[#1E9E5A]"></i>

                                        {{ $freelancerLocation }}

                                    </p>

                                @endif

                            </div>

                        </div>

                    </section>


                    {{-- Requirements --}}
                    <section class="rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_6px_22px_rgba(18,49,40,0.035)]">

                        <div class="border-b border-[#E9EFEB] px-5 py-4 sm:px-6">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                Brief
                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                Detail kebutuhan
                            </h2>

                        </div>


                        <div class="p-5 sm:p-6">

                            @if($order->requirements)

                                <div class="rounded-xl border border-[#DCEAE1] bg-[#F7FBF8] px-4 py-4">

                                    <p class="whitespace-pre-line text-xs leading-6 text-[#62766D]">
                                        {{ $order->requirements }}
                                    </p>

                                </div>

                            @else

                                <div class="rounded-xl border border-dashed border-[#DCE6E1] px-4 py-6 text-center">

                                    <i class="bi bi-file-text text-lg text-[#A4AEA9]"></i>

                                    <p class="mt-2 text-xs text-[#95A19B]">
                                        Tidak ada detail kebutuhan tambahan.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </section>


                    {{-- Security information --}}
                    <section class="rounded-2xl border border-[#D8E9DF] bg-[#EAF7EF] p-5 sm:p-6">

                        <div class="flex items-start gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">
                                <i class="bi bi-shield-check text-[16px]"></i>
                            </div>


                            <div>

                                <h2 class="text-sm font-semibold text-[#123128]">
                                    Pembayaran terlindungi
                                </h2>

                                <p class="mt-1.5 text-xs leading-5 text-[#60756B]">
                                    Pembayaran diproses melalui sistem pembayaran marketplace.
                                    Dana mengikuti alur pesanan hingga pekerjaan selesai sesuai proses JASAIN.
                                </p>

                            </div>

                        </div>

                    </section>

                </div>



                {{-- =====================================================
                    RIGHT
                ====================================================== --}}
                <aside>

                    <div class="sticky top-24 space-y-5">


                        {{-- Payment summary --}}
                        <section class="overflow-hidden rounded-2xl border border-[#DDE8E2] bg-white shadow-[0_9px_28px_rgba(18,49,40,0.06)]">

                            <div class="border-b border-[#E9EFEB] px-5 py-4">

                                <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                    Checkout
                                </p>

                                <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                    Ringkasan pembayaran
                                </h2>

                            </div>


                            <div class="p-5">


                                {{-- Service --}}
                                <div class="flex items-start justify-between gap-5">

                                    <span class="max-w-[200px] text-xs leading-5 text-[#74867D]">
                                        {{ $serviceTitle }}
                                    </span>

                                    <span class="shrink-0 text-xs font-medium text-[#355248]">
                                        Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}
                                    </span>

                                </div>


                                {{-- Subtotal --}}
                                <div class="mt-4 flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#7D8D86]">
                                        Subtotal
                                    </span>

                                    <span class="text-xs font-medium text-[#355248]">
                                        Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}
                                    </span>

                                </div>


                                {{-- Platform fee --}}
                                <div class="mt-3.5 flex items-center justify-between gap-4">

                                    <span class="flex items-center gap-1.5 text-xs text-[#7D8D86]">

                                        Biaya platform

                                        <i
                                            class="bi bi-info-circle text-[10px] text-[#A4AEA9]"
                                            title="Biaya penggunaan platform"
                                        ></i>

                                    </span>

                                    <span class="text-xs font-medium text-[#355248]">
                                        Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}
                                    </span>

                                </div>


                                {{-- Total --}}
                                <div class="mt-5 border-t border-[#E8EFEB] pt-5">

                                    <div class="flex items-end justify-between gap-4">

                                        <div>

                                            <p class="text-xs font-medium text-[#53685F]">
                                                Total pembayaran
                                            </p>

                                            <p class="mt-1 text-[10px] text-[#98A49F]">
                                                Sudah termasuk biaya platform
                                            </p>

                                        </div>


                                        <p class="text-xl font-semibold tracking-[-0.025em] text-[#1E9E5A]">
                                            Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Payment status --}}
                                <div class="mt-5 rounded-xl border border-[#E6ECE8] bg-[#F9FBFA] p-3.5">

                                    <div class="flex items-center justify-between gap-3">

                                        <span class="text-[10px] font-medium text-[#7D8D86]">
                                            Status pembayaran
                                        </span>


                                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[9px] font-semibold {{ $paymentStatus['class'] }}">

                                            <span class="h-1.5 w-1.5 rounded-full {{ $paymentStatus['dot'] }}"></span>

                                            {{ $paymentStatus['label'] }}

                                        </span>

                                    </div>

                                </div>


                                {{-- Pay button --}}
                                @if($order->status === 'pending_payment')

                                    <button
                                        type="button"
                                        id="pay-button"
                                        class="mt-5 flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-4 text-xs font-semibold text-white shadow-[0_6px_18px_rgba(30,158,90,0.16)] transition duration-200 hover:bg-[#0F6B3A] hover:shadow-[0_8px_22px_rgba(30,158,90,0.20)] disabled:cursor-not-allowed disabled:opacity-60"
                                    >

                                        <i class="bi bi-lock-fill text-[10px]"></i>

                                        <span id="pay-button-text">
                                            Bayar sekarang
                                        </span>

                                    </button>


                                    <p
                                        id="payment-message"
                                        class="mt-3 hidden text-center text-[10px] leading-5 text-red-600"
                                    ></p>


                                    <p class="mt-3 text-center text-[9px] leading-5 text-[#9AA6A0]">
                                        Dengan melanjutkan pembayaran, kamu menyetujui
                                        proses transaksi dan ketentuan JASAIN.
                                    </p>

                                @elseif($order->status === 'paid')

                                    <div class="mt-5 rounded-xl border border-[#CDE7D7] bg-[#EAF7EF] p-4">

                                        <div class="flex items-start gap-3">

                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-[#1E9E5A]">
                                                <i class="bi bi-check-lg text-sm"></i>
                                            </div>

                                            <div>

                                                <p class="text-xs font-semibold text-[#168A4D]">
                                                    Pembayaran berhasil
                                                </p>

                                                <p class="mt-1 text-[10px] leading-5 text-[#638077]">
                                                    Order ini sudah dibayar dan menunggu freelancer mengerjakan pekerjaan.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            </div>

                        </section>


                        {{-- Order mini info --}}
                        <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                Informasi order
                            </p>


                            <div class="mt-4 space-y-3.5">

                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#8A9992]">
                                        Nomor order
                                    </span>

                                    <span class="text-[10px] font-semibold text-[#355248]">
                                        {{ $order->order_number }}
                                    </span>

                                </div>


                                <div class="flex items-center justify-between gap-4">

                                    <span class="text-xs text-[#8A9992]">
                                        Durasi pengerjaan
                                    </span>

                                    <span class="text-[10px] font-semibold text-[#355248]">
                                        {{ $order->delivery_days }} hari
                                    </span>

                                </div>


                                @if($order->due_at)

                                    <div class="flex items-center justify-between gap-4">

                                        <span class="text-xs text-[#8A9992]">
                                            Deadline
                                        </span>

                                        <span class="text-[10px] font-semibold text-[#355248]">
                                            {{ $order->due_at->format('d M Y') }}
                                        </span>

                                    </div>

                                @endif

                            </div>

                        </section>


                        {{-- Need help --}}
                        <section class="rounded-2xl border border-[#DCE9E1] bg-[#F2F9F4] p-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">
                                    <i class="bi bi-chat-dots text-[14px]"></i>
                                </div>

                                <div>

                                    <p class="text-xs font-semibold text-[#18382E]">
                                        Butuh bantuan?
                                    </p>

                                    <p class="mt-0.5 text-[10px] text-[#83938B]">
                                        Hubungi freelancer melalui pesan.
                                    </p>

                                </div>

                            </div>


                            <a
                                href="{{ route('client.messages.index') }}"
                                class="mt-4 flex h-10 items-center justify-center gap-2 rounded-xl bg-white text-[10px] font-semibold text-[#355248] shadow-sm transition hover:text-[#1E9E5A]"
                            >
                                Buka pesan
                                <i class="bi bi-arrow-right text-[9px]"></i>
                            </a>

                        </section>

                    </div>

                </aside>

            </div>

        </div>

    </div>


    {{-- =========================================================
        PAYMENT SCRIPT
        Backend payment flow tetap dipertahankan
    ========================================================== --}}
    @if($order->status === 'pending_payment')

        <script
            src="{{ config('midtrans.is_production')
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('midtrans.client_key') }}"
        ></script>


        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const payButton = document.getElementById('pay-button');
                const payButtonText = document.getElementById('pay-button-text');
                const paymentMessage = document.getElementById('payment-message');

                if (!payButton) {
                    return;
                }


                payButton.addEventListener('click', async function () {

                    payButton.disabled = true;

                    payButtonText.textContent = 'Menyiapkan pembayaran...';

                    paymentMessage.classList.add('hidden');
                    paymentMessage.textContent = '';


                    try {

                        const response = await fetch(
                            '{{ route('client.orders.payment.token', $order) }}',
                            {
                                method: 'POST',

                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },

                                body: JSON.stringify({})
                            }
                        );


                        const data = await response.json();


                        if (!response.ok || !data.success || !data.token) {

                            throw new Error(
                                data.message ||
                                'Gagal menyiapkan pembayaran.'
                            );

                        }


                        window.snap.pay(
                            data.token,
                            {

                                onSuccess: function () {

                                    window.location.href =
                                        '{{ route('client.orders.show', $order) }}';

                                },


                                onPending: function () {

                                    window.location.href =
                                        '{{ route('client.orders.show', $order) }}';

                                },


                                onError: function () {

                                    paymentMessage.textContent =
                                        'Pembayaran gagal diproses. Silakan coba lagi.';

                                    paymentMessage.classList.remove('hidden');

                                    resetPaymentButton();

                                },


                                onClose: function () {

                                    resetPaymentButton();

                                }

                            }
                        );


                    } catch (error) {

                        console.error(
                            'Payment error:',
                            error
                        );


                        paymentMessage.textContent =
                            error.message ||
                            'Terjadi kesalahan saat menyiapkan pembayaran.';

                        paymentMessage.classList.remove('hidden');


                        resetPaymentButton();

                    }

                });


                function resetPaymentButton() {

                    payButton.disabled = false;

                    payButtonText.textContent =
                        'Bayar sekarang';

                }

            });
        </script>

    @endif

</x-layouts.client>