<x-layouts.admin title="Detail Dispute">

    @php
        $statusConfig = match ($dispute->status) {
            'open' => [
                'label' => 'Dispute Dibuka',
                'class' => 'border-[#CFE0F1] bg-[#F3F8FC] text-[#3C6F9F]',
                'icon' => 'bi-shield-exclamation',
            ],
            'pending_response' => [
                'label' => 'Menunggu Tanggapan',
                'class' => 'border-[#F2DDAF] bg-[#FFF9EA] text-[#9A6800]',
                'icon' => 'bi-hourglass-split',
            ],
            'under_review' => [
                'label' => 'Sedang Ditinjau',
                'class' => 'border-[#D8D4EE] bg-[#F7F5FD] text-[#6D62A4]',
                'icon' => 'bi-search',
            ],
            'resolved_client' => [
                'label' => 'Selesai untuk Client',
                'class' => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',
                'icon' => 'bi-check-circle-fill',
            ],
            'resolved_freelancer' => [
                'label' => 'Selesai untuk Freelancer',
                'class' => 'border-[#F0D5D5] bg-[#FFF6F6] text-[#B84E4E]',
                'icon' => 'bi-x-circle-fill',
            ],
            'resolved_partial' => [
                'label' => 'Selesai Sebagian',
                'class' => 'border-[#E8D3B0] bg-[#FFF9EA] text-[#A56A1B]',
                'icon' => 'bi-sliders',
            ],
            'closed' => [
                'label' => 'Ditutup',
                'class' => 'border-[#E1E7E3] bg-[#F7F9F8] text-[#66766E]',
                'icon' => 'bi-lock-fill',
            ],
            default => [
                'label' => ucfirst(str_replace('_', ' ', $dispute->status)),
                'class' => 'border-[#E1E7E3] bg-[#F7F9F8] text-[#66766E]',
                'icon' => 'bi-info-circle',
            ],
        };

        $resolutionLabel = match ($dispute->resolution) {
            'client' => 'Client',
            'freelancer' => 'Freelancer',
            'partial' => 'Partial Settlement',
            default => null,
        };

        $categoryLabel = ucfirst(
            str_replace('_', ' ', $dispute->category)
        );
    @endphp

    <div class="min-h-screen bg-[#F8FCF9]">

        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">

            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <a
                    href="{{ route('admin.disputes.index') }}"
                    class="inline-flex w-fit items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Dispute Center
                </a>

                <span class="text-[10px] text-[#99A59F]">
                    {{ $dispute->dispute_number }}
                </span>

            </div>

            @if(session('success'))
                <div class="mb-5 rounded-xl border border-[#CDE8D7] bg-white shadow-sm">
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

            @if($errors->any())
                <div class="mb-5 rounded-xl border border-red-100 bg-white shadow-sm">
                    <div class="px-4 py-3.5">
                        <p class="text-sm font-semibold text-red-600">
                            Periksa kembali data keputusan.
                        </p>
                        <div class="mt-1 space-y-1">
                            @foreach($errors->all() as $error)
                                <p class="text-xs text-red-500">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <section class="overflow-hidden rounded-3xl border border-[#E1EAE5] bg-white shadow-[0_8px_28px_rgba(18,49,40,0.045)]">

                <div class="px-5 py-6 sm:px-7 lg:px-8 lg:py-7">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F3F7F5] px-2.5 py-1 text-[9px] font-semibold text-[#7F8E87]">
                                    <i class="bi bi-shield-exclamation"></i>
                                    {{ $dispute->dispute_number }}
                                </span>
                                <span class="text-[10px] text-[#A0AAA5]">
                                    Dibuat {{ $dispute->created_at?->format('d M Y, H:i') }}
                                </span>
                            </div>

                            <h1 class="mt-4 text-xl font-semibold tracking-[-0.03em] text-[#123128] sm:text-2xl">
                                Detail sengketa
                            </h1>

                            <p class="mt-2 text-xs text-[#71837B]">
                                {{ $dispute->order?->order_number ?? '-' }}
                                ·
                                {{ $dispute->order?->items?->first()?->service_title ?? 'Pesanan Jasa' }}
                            </p>
                        </div>

                        <span class="inline-flex w-fit items-center gap-2 rounded-full border px-3 py-2 text-[10px] font-semibold {{ $statusConfig['class'] }}">
                            <i class="bi {{ $statusConfig['icon'] }}"></i>
                            {{ $statusConfig['label'] }}
                        </span>

                    </div>

                </div>

            </section>

            <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_340px]">

                <div class="space-y-5">

                    {{-- Reason --}}
                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                            Permasalahan
                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                            Alasan pengajuan
                        </h2>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="rounded-full bg-[#F3F7F5] px-3 py-1.5 text-[9px] font-semibold text-[#526960]">
                                {{ $categoryLabel }}
                            </span>
                            <span class="rounded-full bg-[#F3F7F5] px-3 py-1.5 text-[9px] font-semibold text-[#526960]">
                                Dibuka oleh {{ ucfirst($dispute->opened_by_role) }}
                            </span>
                        </div>

                        <div class="mt-4 rounded-xl bg-[#F8FBF9] px-4 py-4">
                            <p class="whitespace-pre-line text-xs leading-6 text-[#62766D]">
                                {{ $dispute->reason }}
                            </p>
                        </div>

                    </section>

                    {{-- Order --}}
                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                            Order
                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                            Data transaksi
                        </h2>

                        <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">

                            <div class="rounded-xl bg-[#FAFCFB] px-4 py-4">
                                <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">Client</p>
                                <p class="mt-2 text-xs font-semibold text-[#355248]">
                                    {{ $dispute->order?->client?->name ?? '-' }}
                                </p>
                                <p class="mt-1 truncate text-[10px] text-[#98A49E]">
                                    {{ $dispute->order?->client?->email ?? '-' }}
                                </p>
                            </div>

                            <div class="rounded-xl bg-[#FAFCFB] px-4 py-4">
                                <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">Freelancer</p>
                                <p class="mt-2 text-xs font-semibold text-[#355248]">
                                    {{ $dispute->order?->freelancerProfile?->user?->name ?? '-' }}
                                </p>
                                <p class="mt-1 truncate text-[10px] text-[#98A49E]">
                                    {{ $dispute->order?->freelancerProfile?->user?->email ?? '-' }}
                                </p>
                            </div>

                            <div class="rounded-xl bg-[#FAFCFB] px-4 py-4">
                                <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">Status order</p>
                                <p class="mt-2 text-xs font-semibold text-[#355248]">
                                    {{ ucfirst(str_replace('_', ' ', $dispute->order?->status ?? '-')) }}
                                </p>
                            </div>

                            <div class="rounded-xl bg-[#FAFCFB] px-4 py-4">
                                <p class="text-[9px] uppercase tracking-[0.12em] text-[#97A39E]">Total</p>
                                <p class="mt-2 text-xs font-semibold text-[#355248]">
                                    Rp {{ number_format((float) ($dispute->order?->total ?? 0), 0, ',', '.') }}
                                </p>
                            </div>

                        </div>

                    </section>

                    {{-- Messages --}}
                    <section class="overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <div class="border-b border-[#E8EFEB] px-5 py-5 sm:px-6">
                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                Tanggapan
                            </p>
                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                Riwayat komunikasi
                            </h2>
                        </div>

                        <div class="px-5 py-5 sm:px-6">

                            @forelse($dispute->messages as $message)

                                @php
                                    $isClient = $message->user_id === $dispute->order?->client_id;
                                @endphp

                                <div class="mb-4 last:mb-0 rounded-xl border border-[#E5ECE8] bg-[#FAFCFB] p-4">

                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-xs font-semibold text-[#355248]">
                                                {{ $message->user?->name ?? 'Pengguna' }}
                                            </p>
                                            <p class="mt-1 text-[9px] text-[#97A39E]">
                                                {{ $isClient ? 'Client' : 'Freelancer / Admin' }}
                                                ·
                                                {{ $message->created_at?->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                    </div>

                                    <p class="mt-3 whitespace-pre-line text-xs leading-6 text-[#62766D]">
                                        {{ $message->message }}
                                    </p>

                                </div>

                            @empty

                                <div class="rounded-xl border border-dashed border-[#DCE6E1] px-4 py-8 text-center">
                                    <i class="bi bi-chat-left-text text-lg text-[#A3AEA8]"></i>
                                    <p class="mt-2 text-xs text-[#98A49E]">
                                        Belum ada tanggapan.
                                    </p>
                                </div>

                            @endforelse

                        </div>

                    </section>

                    {{-- Evidence --}}
                    <section class="overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <div class="border-b border-[#E8EFEB] px-5 py-5 sm:px-6">
                            <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                                Bukti
                            </p>
                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                File pendukung
                            </h2>
                        </div>

                        <div class="px-5 py-5 sm:px-6">

                            @forelse($dispute->evidences as $evidence)

                                <div class="mb-3 last:mb-0 rounded-xl border border-[#E5ECE8] bg-[#FAFCFB] p-4">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div class="flex min-w-0 items-center gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">
                                                <i class="bi bi-file-earmark"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="truncate text-xs font-semibold text-[#355248]">
                                                    {{ $evidence->file_name }}
                                                </p>
                                                <p class="mt-1 text-[9px] text-[#98A49E]">
                                                    {{ $evidence->uploader?->name ?? 'Pengguna' }}
                                                    ·
                                                    {{ $evidence->created_at?->format('d M Y, H:i') }}
                                                </p>
                                            </div>
                                        </div>

                                        <a
                                            href="{{ asset('storage/' . $evidence->file_path) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex h-9 w-full items-center justify-center gap-2 rounded-lg border border-[#DCE7E1] bg-white px-3 text-[10px] font-semibold text-[#1E9E5A] sm:w-auto"
                                        >
                                            <i class="bi bi-box-arrow-up-right"></i>
                                            Lihat
                                        </a>
                                    </div>

                                    @if($evidence->description)
                                        <p class="mt-3 rounded-lg bg-white px-3 py-3 text-[10px] leading-5 text-[#63786E]">
                                            {{ $evidence->description }}
                                        </p>
                                    @endif
                                </div>

                            @empty

                                <div class="rounded-xl border border-dashed border-[#DCE6E1] px-4 py-8 text-center">
                                    <i class="bi bi-paperclip text-lg text-[#A3AEA8]"></i>
                                    <p class="mt-2 text-xs text-[#98A49E]">
                                        Belum ada bukti.
                                    </p>
                                </div>

                            @endforelse

                        </div>

                    </section>

                    {{-- Resolution --}}
                    @if($dispute->resolution)
                        <section class="overflow-hidden rounded-2xl border border-[#CDE7D7] bg-[#EAF7EF]">
                            <div class="px-5 py-5 sm:px-6">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">
                                        <i class="bi bi-check-circle-fill text-[15px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                                            Keputusan
                                        </p>
                                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                            Dispute sudah diselesaikan
                                        </h2>
                                    </div>
                                </div>

                                <div class="mt-4 rounded-xl bg-white/80 px-4 py-4">
                                    <p class="text-[9px] uppercase tracking-[0.14em] text-[#7A8D84]">
                                        Hasil
                                    </p>
                                    <p class="mt-1 text-sm font-semibold text-[#355248]">
                                        {{ $resolutionLabel }}
                                    </p>
                                    <p class="mt-3 whitespace-pre-line text-xs leading-6 text-[#5E7168]">
                                        {{ $dispute->resolution_note }}
                                    </p>
                                    <p class="mt-3 text-[10px] text-[#91A099]">
                                        {{ $dispute->resolver?->name ? 'Diputuskan oleh ' . $dispute->resolver->name . ' · ' : '' }}
                                        {{ $dispute->resolved_at?->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </section>
                    @endif

                </div>

                <aside class="space-y-5">

                    {{-- Review decision --}}
                    @if($dispute->status === 'under_review')

                        <section class="rounded-2xl border border-[#D8D4EE] bg-[#F7F5FD] p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#6D62A4] shadow-sm">
                                <i class="bi bi-gavel text-[15px]"></i>
                            </div>

                            <h2 class="mt-4 text-sm font-semibold text-[#123128]">
                                Keputusan admin
                            </h2>

                            <p class="mt-1.5 text-xs leading-5 text-[#6E6A82]">
                                Pilih hasil penyelesaian setelah seluruh informasi dan bukti diperiksa.
                            </p>

                            <form
                                action="{{ route('admin.disputes.resolve', $dispute) }}"
                                method="POST"
                                class="mt-5"
                            >
                                @csrf

                                <div class="space-y-2">

                                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-white bg-white px-3 py-3 shadow-sm">
                                        <input
                                            type="radio"
                                            name="resolution"
                                            value="client"
                                            required
                                            class="mt-0.5 accent-[#1E9E5A]"
                                        >
                                        <span>
                                            <span class="block text-xs font-semibold text-[#355248]">Diselesaikan untuk Client</span>
                                            <span class="mt-1 block text-[10px] leading-4 text-[#7B8C84]">Keputusan berpihak pada penyelesaian Client.</span>
                                        </span>
                                    </label>

                                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-white bg-white px-3 py-3 shadow-sm">
                                        <input
                                            type="radio"
                                            name="resolution"
                                            value="freelancer"
                                            required
                                            class="mt-0.5 accent-[#1E9E5A]"
                                        >
                                        <span>
                                            <span class="block text-xs font-semibold text-[#355248]">Diselesaikan untuk Freelancer</span>
                                            <span class="mt-1 block text-[10px] leading-4 text-[#7B8C84]">Keputusan berpihak pada penyelesaian Freelancer.</span>
                                        </span>
                                    </label>

                                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-white bg-white px-3 py-3 shadow-sm">
                                        <input
                                            type="radio"
                                            name="resolution"
                                            value="partial"
                                            required
                                            class="mt-0.5 accent-[#1E9E5A]"
                                        >
                                        <span>
                                            <span class="block text-xs font-semibold text-[#355248]">Partial Settlement</span>
                                            <span class="mt-1 block text-[10px] leading-4 text-[#7B8C84]">Penyelesaian sebagian untuk kedua pihak.</span>
                                        </span>
                                    </label>

                                </div>

                                <textarea
                                    name="resolution_note"
                                    rows="6"
                                    required
                                    maxlength="5000"
                                    placeholder="Tuliskan alasan keputusan admin dan tindakan lanjutan yang perlu dilakukan..."
                                    class="mt-4 w-full rounded-xl border border-[#D9D6E8] bg-white px-4 py-3 text-xs leading-5 text-[#123128] outline-none placeholder:text-[#A0A5AE] focus:border-[#A9A0D3] focus:ring-2 focus:ring-[#EEEAF8]"
                                >{{ old('resolution_note') }}</textarea>

                                <button
                                    type="submit"
                                    class="mt-4 inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-[#6D62A4] px-4 text-xs font-semibold text-white transition hover:bg-[#5D528F]"
                                >
                                    <i class="bi bi-check2-circle"></i>
                                    Selesaikan Dispute
                                </button>

                            </form>

                        </section>

                    @elseif(in_array($dispute->status, ['resolved_client', 'resolved_freelancer', 'resolved_partial'], true))

                        <section class="rounded-2xl border border-[#CDE7D7] bg-[#EAF7EF] p-5">
                            <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                                Dispute selesai
                            </p>
                            <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                                {{ $resolutionLabel }}
                            </h2>
                            <p class="mt-1.5 text-xs leading-5 text-[#63786E]">
                                Keputusan sudah disimpan. Proses refund, bila diperlukan, akan dilakukan pada modul Refund.
                            </p>

                            <form
                                action="{{ route('admin.disputes.close', $dispute) }}"
                                method="POST"
                                class="mt-4"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-white text-xs font-semibold text-[#526960] shadow-sm transition hover:text-[#1E9E5A]"
                                >
                                    <i class="bi bi-lock"></i>
                                    Tutup Dispute
                                </button>
                            </form>
                        </section>

                    @endif

                    {{-- Payment --}}
                    <section class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                            Pembayaran
                        </p>
                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                            Status pembayaran
                        </h2>

                        @if($dispute->order?->payment)
                            <div class="mt-5 flex items-center justify-between gap-3">
                                <span class="text-xs text-[#7D8D86]">Status</span>
                                <span class="rounded-full bg-[#F3F7F5] px-2.5 py-1 text-[9px] font-semibold text-[#526960]">
                                    {{ ucfirst(str_replace('_', ' ', $dispute->order->payment->status)) }}
                                </span>
                            </div>
                        @else
                            <p class="mt-5 text-xs text-[#98A49E]">
                                Data pembayaran belum tersedia.
                            </p>
                        @endif

                    </section>

                </aside>

            </div>

        </div>

    </div>

</x-layouts.admin>
