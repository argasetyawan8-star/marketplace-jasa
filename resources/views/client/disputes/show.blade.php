<x-layouts.marketplace title="Detail Dispute">

    @php
        $statusConfig = match ($dispute->status) {
            'open' => [
                'label' => 'Dispute Dibuka',
                'class' => 'border-blue-100 bg-blue-50 text-blue-700',
                'icon' => 'bi-shield-exclamation',
            ],
            'pending_response' => [
                'label' => 'Menunggu Tanggapan',
                'class' => 'border-amber-100 bg-amber-50 text-amber-700',
                'icon' => 'bi-hourglass-split',
            ],
            'under_review' => [
                'label' => 'Sedang Ditinjau Admin',
                'class' => 'border-indigo-100 bg-indigo-50 text-indigo-700',
                'icon' => 'bi-search',
            ],
            'resolved_client' => [
                'label' => 'Diselesaikan untuk Client',
                'class' => 'border-emerald-100 bg-emerald-50 text-emerald-700',
                'icon' => 'bi-check-circle-fill',
            ],
            'resolved_freelancer' => [
                'label' => 'Diselesaikan untuk Freelancer',
                'class' => 'border-rose-100 bg-rose-50 text-rose-700',
                'icon' => 'bi-x-circle-fill',
            ],
            'resolved_partial' => [
                'label' => 'Diselesaikan Sebagian',
                'class' => 'border-orange-100 bg-orange-50 text-orange-700',
                'icon' => 'bi-sliders',
            ],
            'closed' => [
                'label' => 'Dispute Ditutup',
                'class' => 'border-slate-200 bg-slate-50 text-slate-600',
                'icon' => 'bi-lock-fill',
            ],
            default => [
                'label' => ucfirst(str_replace('_', ' ', $dispute->status)),
                'class' => 'border-slate-200 bg-slate-50 text-slate-600',
                'icon' => 'bi-info-circle',
            ],
        };

        $categoryLabel = match ($dispute->category) {
            'delivery_issue' => 'Masalah delivery',
            'quality_issue' => 'Kualitas hasil pekerjaan',
            'scope_issue' => 'Masalah scope pekerjaan',
            'communication_issue' => 'Masalah komunikasi',
            'non_delivery' => 'Pekerjaan belum dikirim',
            'payment_issue' => 'Masalah pembayaran',
            'other' => 'Masalah lainnya',
            default => ucfirst(str_replace('_', ' ', $dispute->category)),
        };

        $isActive = in_array(
            $dispute->status,
            [
                'open',
                'pending_response',
                'under_review',
            ],
            true
        );

        $client = $dispute->order?->client;
        $freelancer = $dispute->order?->freelancerProfile?->user;
        $currentUserId = auth()->id();
    @endphp

    <div class="min-h-screen bg-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            {{-- =========================================================
                BREADCRUMB / TOP BAR
            ========================================================== --}}
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a
                    href="{{ route('client.orders.show', $dispute->order) }}"
                    class="inline-flex w-fit items-center gap-2 text-xs font-semibold text-slate-500 transition hover:text-[#2563EB]"
                >
                    <i class="bi bi-arrow-left text-[11px]"></i>
                    Kembali ke order
                </a>

                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[10px] font-medium text-slate-400">
                        {{ $dispute->dispute_number }}
                    </span>

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-[9px] font-semibold {{ $statusConfig['class'] }}"
                    >
                        <i class="bi {{ $statusConfig['icon'] }}"></i>
                        {{ $statusConfig['label'] }}
                    </span>
                </div>
            </div>

            {{-- =========================================================
                FLASH SUCCESS
            ========================================================== --}}
            @if(session('success'))
                <div class="mb-5 overflow-hidden rounded-2xl border border-emerald-100 bg-white shadow-sm">
                    <div class="flex items-center gap-3 px-4 py-3.5">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                            <i class="bi bi-check-lg text-sm"></i>
                        </div>

                        <p class="text-sm text-slate-600">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- =========================================================
                FLASH ERROR
            ========================================================== --}}
            @if(session('error'))
                <div class="mb-5 overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-sm">
                    <div class="flex items-center gap-3 px-4 py-3.5">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-rose-50 text-rose-500">
                            <i class="bi bi-exclamation-lg text-sm"></i>
                        </div>

                        <p class="text-sm text-rose-600">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- =========================================================
                VALIDATION ERRORS
            ========================================================== --}}
            @if($errors->any())
                <div class="mb-5 overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-sm">
                    <div class="px-4 py-4">
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-rose-50 text-rose-500">
                                <i class="bi bi-exclamation-lg text-sm"></i>
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-rose-600">
                                    Terdapat kesalahan pada form.
                                </p>

                                <div class="mt-1 space-y-0.5">
                                    @foreach($errors->all() as $error)
                                        <p class="text-xs text-rose-500">
                                            {{ $error }}
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- =========================================================
                HERO
            ========================================================== --}}
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="relative px-5 py-6 sm:px-7 lg:px-8 lg:py-7">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-[9px] font-semibold text-blue-700">
                                    <i class="bi bi-shield-exclamation text-[8px]"></i>
                                    {{ $dispute->dispute_number }}
                                </span>

                                <span class="text-[10px] text-slate-400">
                                    Dibuat
                                    {{ $dispute->created_at?->format('d M Y, H:i') }}
                                </span>
                            </div>

                            <h1 class="mt-4 max-w-4xl text-xl font-bold leading-8 tracking-tight text-slate-900 sm:text-2xl">
                                Penyelesaian sengketa order
                            </h1>

                            <p class="mt-2 max-w-3xl text-xs leading-5 text-slate-500">
                                {{ $dispute->order?->order_number ?? '-' }}
                                <span class="mx-1 text-slate-300">•</span>
                                {{ $dispute->order?->items?->first()?->service_title ?? 'Pesanan Jasa' }}
                            </p>
                        </div>

                        <div class="shrink-0">
                            <span
                                class="inline-flex items-center gap-2 rounded-full border px-3 py-2 text-[10px] font-semibold {{ $statusConfig['class'] }}"
                            >
                                <i class="bi {{ $statusConfig['icon'] }}"></i>
                                {{ $statusConfig['label'] }}
                            </span>
                        </div>

                    </div>
                </div>
            </section>

            {{-- =========================================================
                ACTIVE NOTICE
            ========================================================== --}}
            @if($isActive)
                <section class="mt-5 overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-r from-blue-50 via-white to-blue-50/60">
                    <div class="px-5 py-5 sm:px-6">
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">
                                <i class="bi bi-info-circle text-[15px]"></i>
                            </div>

                            <div>
                                @if($dispute->status === 'pending_response')
                                    <p class="text-xs font-semibold text-slate-900">
                                        Menunggu tanggapan freelancer
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Freelancer dapat memberikan penjelasan dan bukti sebelum
                                        sengketa masuk ke tahap peninjauan admin.
                                    </p>

                                @elseif($dispute->status === 'under_review')
                                    <p class="text-xs font-semibold text-slate-900">
                                        Sengketa sedang ditinjau admin
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Admin sedang memeriksa informasi, tanggapan, dan bukti
                                        dari kedua pihak.
                                    </p>

                                @else
                                    <p class="text-xs font-semibold text-slate-900">
                                        Dispute sedang diproses
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Sampaikan informasi yang relevan melalui tanggapan dan
                                        bukti agar kasus dapat diperiksa dengan jelas.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- =========================================================
                MAIN GRID
            ========================================================== --}}
            <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_340px]">

                {{-- =====================================================
                    LEFT COLUMN
                ====================================================== --}}
                <div class="space-y-5">

                    {{-- =================================================
                        DISPUTE REASON
                    ================================================== --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">
                                Masalah
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-slate-900">
                                Alasan pengajuan dispute
                            </h2>
                        </div>

                        <div class="mt-5 flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-[9px] font-semibold text-blue-700">
                                <i class="bi bi-tag text-blue-600"></i>
                                {{ $categoryLabel }}
                            </span>

                            <span class="text-[10px] text-slate-400">
                                Diajukan oleh
                                {{ $dispute->opened_by_role === 'client' ? 'Client' : 'Freelancer' }}
                            </span>
                        </div>

                        <div class="mt-5 rounded-2xl bg-slate-50 px-4 py-4">
                            <p class="whitespace-pre-line text-xs leading-6 text-slate-600">
                                {{ $dispute->reason }}
                            </p>
                        </div>
                    </section>

                    {{-- =================================================
                        PARTICIPANTS
                    ================================================== --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">
                                Pihak terkait
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-slate-900">
                                Client & Freelancer
                            </h2>
                        </div>

                        <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">

                            {{-- Client --}}
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-4">
                                <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                                    Client
                                </p>

                                <div class="mt-3 flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                                        {{ strtoupper(substr($client?->name ?? 'C', 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-bold text-slate-800">
                                            {{ $client?->name ?? 'Client' }}
                                        </p>

                                        <p class="mt-0.5 truncate text-[10px] text-slate-400">
                                            {{ $client?->email ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Freelancer --}}
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-4">
                                <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                                    Freelancer
                                </p>

                                <div class="mt-3 flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                                        {{ strtoupper(substr($freelancer?->name ?? 'F', 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-bold text-slate-800">
                                            {{ $freelancer?->name ?? 'Freelancer' }}
                                        </p>

                                        <p class="mt-0.5 truncate text-[10px] text-slate-400">
                                            {{ $freelancer?->email ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>

                    {{-- =================================================
                        MESSAGES
                    ================================================== --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
                            <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">
                                Tanggapan
                            </p>

                            <h2 class="mt-1 text-sm font-bold text-slate-900">
                                Riwayat komunikasi dispute
                            </h2>
                        </div>

                        <div class="px-5 py-5 sm:px-6">
                            @if($dispute->messages->count() > 0)

                                <div class="space-y-4">
                                    @foreach($dispute->messages as $message)

                                        @php
                                            $isMine = $message->user_id === $currentUserId;
                                        @endphp

                                        <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                            <div class="max-w-[90%] sm:max-w-[78%]">

                                                <div class="mb-1.5 flex items-center gap-2 {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                                    <span class="text-[9px] font-bold text-slate-600">
                                                        {{ $message->user?->name ?? 'Pengguna' }}
                                                    </span>

                                                    <span class="text-[9px] text-slate-400">
                                                        {{ $message->created_at?->format('d M Y, H:i') }}
                                                    </span>
                                                </div>

                                                <div
                                                    class="rounded-2xl px-4 py-3.5 {{ $isMine ? 'rounded-br-md bg-blue-50 text-slate-700' : 'rounded-bl-md bg-slate-100 text-slate-600' }}"
                                                >
                                                    <p class="whitespace-pre-line text-xs leading-5">
                                                        {{ $message->message }}
                                                    </p>
                                                </div>

                                            </div>
                                        </div>

                                    @endforeach
                                </div>

                            @else

                                <div class="rounded-2xl border border-dashed border-slate-200 px-4 py-8 text-center">
                                    <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                                        <i class="bi bi-chat-left-text text-lg"></i>
                                    </div>

                                    <p class="mt-3 text-xs text-slate-400">
                                        Belum ada tanggapan.
                                    </p>
                                </div>

                            @endif
                        </div>

                        @if($isActive)
                            <div class="border-t border-slate-200 bg-slate-50/50 px-5 py-5 sm:px-6">

                                <form
                                    action="{{ route('client.disputes.message', $dispute) }}"
                                    method="POST"
                                >
                                    @csrf

                                    <label
                                        for="message"
                                        class="text-xs font-bold text-slate-700"
                                    >
                                        Tambahkan tanggapan
                                    </label>

                                    <textarea
                                        id="message"
                                        name="message"
                                        rows="5"
                                        maxlength="5000"
                                        required
                                        placeholder="Tambahkan penjelasan atau tanggapan yang relevan..."
                                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-800 outline-none placeholder:text-slate-400 transition focus:border-blue-300 focus:ring-4 focus:ring-blue-50"
                                    >{{ old('message') }}</textarea>

                                    @error('message')
                                        <p class="mt-1.5 text-xs text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <div class="mt-4 flex justify-end">
                                        <button
                                            type="submit"
                                            class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 text-xs font-bold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md"
                                        >
                                            <i class="bi bi-send"></i>
                                            Kirim Tanggapan
                                        </button>
                                    </div>
                                </form>

                            </div>
                        @endif

                    </section>

                    {{-- =================================================
                        EVIDENCE
                    ================================================== --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
                            <div class="flex items-end justify-between gap-4">
                                <div>
                                    <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">
                                        Bukti
                                    </p>

                                    <h2 class="mt-1 text-sm font-bold text-slate-900">
                                        Bukti pendukung
                                    </h2>
                                </div>

                                <span class="text-[10px] font-medium text-slate-400">
                                    {{ $dispute->evidences->count() }} file
                                </span>
                            </div>
                        </div>

                        <div class="px-5 py-5 sm:px-6">

                            @if($dispute->evidences->count() > 0)

                                <div class="space-y-3">

                                    @foreach($dispute->evidences as $evidence)

                                        @php
                                            $extension = strtolower(
                                                pathinfo(
                                                    $evidence->file_name ?? '',
                                                    PATHINFO_EXTENSION
                                                )
                                            );

                                            $evidenceIcon = match ($extension) {
                                                'jpg',
                                                'jpeg',
                                                'png',
                                                'webp' => 'bi-image',

                                                'pdf' => 'bi-file-earmark-pdf',

                                                'doc',
                                                'docx' => 'bi-file-earmark-word',

                                                'xls',
                                                'xlsx' => 'bi-file-earmark-excel',

                                                'zip' => 'bi-file-earmark-zip',

                                                default => 'bi-file-earmark',
                                            };

                                            $fileSize = $evidence->file_size
                                                ? number_format(
                                                    $evidence->file_size / 1024 / 1024,
                                                    2
                                                ) . ' MB'
                                                : '-';
                                        @endphp

                                        <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">

                                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                                <div class="flex min-w-0 items-start gap-3">

                                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                                                        <i class="bi {{ $evidenceIcon }}"></i>
                                                    </div>

                                                    <div class="min-w-0">
                                                        <p class="truncate text-xs font-bold text-slate-700">
                                                            {{ $evidence->file_name }}
                                                        </p>

                                                        <p class="mt-1 text-[10px] text-slate-400">
                                                            Oleh
                                                            {{ $evidence->uploader?->name ?? 'Pengguna' }}
                                                            <span class="mx-1 text-slate-300">•</span>
                                                            {{ $fileSize }}
                                                            <span class="mx-1 text-slate-300">•</span>
                                                            {{ $evidence->created_at?->format('d M Y, H:i') }}
                                                        </p>
                                                    </div>

                                                </div>

                                                <a
                                                    href="{{ asset('storage/' . $evidence->file_path) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="inline-flex h-9 w-full shrink-0 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-[10px] font-bold text-[#2563EB] transition hover:bg-blue-50 sm:w-auto"
                                                >
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                    Lihat file
                                                </a>

                                            </div>

                                            @if($evidence->description)
                                                <div class="mt-3 rounded-xl bg-white px-3 py-3">
                                                    <p class="text-[10px] leading-5 text-slate-500">
                                                        {{ $evidence->description }}
                                                    </p>
                                                </div>
                                            @endif

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="rounded-2xl border border-dashed border-slate-200 px-4 py-8 text-center">
                                    <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                                        <i class="bi bi-paperclip text-lg"></i>
                                    </div>

                                    <p class="mt-3 text-xs text-slate-400">
                                        Belum ada bukti yang diunggah.
                                    </p>
                                </div>

                            @endif

                        </div>

                        @if($isActive)
                            <div class="border-t border-slate-200 bg-slate-50/50 px-5 py-5 sm:px-6">

                                <form
                                    action="{{ route('client.disputes.evidence', $dispute) }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                >
                                    @csrf

                                    <label class="text-xs font-bold text-slate-700">
                                        Tambahkan bukti
                                    </label>

                                    <label
                                        for="evidence-file"
                                        class="mt-2 flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-7 text-center transition hover:border-blue-300 hover:bg-blue-50/40"
                                    >
                                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                                            <i class="bi bi-cloud-arrow-up text-lg"></i>
                                        </div>

                                        <p class="mt-3 text-xs font-bold text-slate-700">
                                            Pilih file bukti
                                        </p>

                                        <p class="mt-1 text-[10px] text-slate-400">
                                            JPG, PNG, WEBP, PDF, DOC, DOCX, XLS, XLSX, ZIP · Maksimal 10 MB
                                        </p>

                                        <input
                                            id="evidence-file"
                                            type="file"
                                            name="file"
                                            required
                                            class="hidden"
                                            accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.xls,.xlsx,.zip"
                                        >
                                    </label>

                                    <p
                                        id="selected-evidence-file"
                                        class="mt-2 hidden text-[10px] font-semibold"
                                    ></p>

                                    @error('file')
                                        <p class="mt-1.5 text-xs text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <textarea
                                        name="description"
                                        rows="3"
                                        maxlength="1000"
                                        placeholder="Keterangan bukti (opsional)"
                                        class="mt-4 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-xs leading-5 text-slate-800 outline-none placeholder:text-slate-400 transition focus:border-blue-300 focus:ring-4 focus:ring-blue-50"
                                    >{{ old('description') }}</textarea>

                                    @error('description')
                                        <p class="mt-1.5 text-xs text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <div class="mt-4 flex justify-end">
                                        <button
                                            type="submit"
                                            class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-blue-200 bg-white px-4 text-xs font-bold text-[#2563EB] transition hover:bg-blue-50"
                                        >
                                            <i class="bi bi-paperclip"></i>
                                            Upload Bukti
                                        </button>
                                    </div>

                                </form>

                            </div>
                        @endif

                    </section>

                    {{-- =================================================
                        RESOLUTION
                    ================================================== --}}
                    @if(in_array($dispute->status, [
                        'resolved_client',
                        'resolved_freelancer',
                        'resolved_partial',
                        'closed',
                    ], true))

                        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                            <div class="px-5 py-5 sm:px-6">
                                <div class="flex items-start gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                        <i class="bi bi-check-circle text-[15px]"></i>
                                    </div>

                                    <div>
                                        <p class="text-[9px] font-bold uppercase tracking-[0.16em] text-emerald-600">
                                            Keputusan
                                        </p>

                                        <h2 class="mt-1 text-sm font-bold text-slate-900">
                                            Hasil penyelesaian dispute
                                        </h2>
                                    </div>

                                </div>

                                <div class="mt-5 rounded-2xl bg-slate-50 px-4 py-4">

                                    <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400">
                                        Hasil
                                    </p>

                                    <p class="mt-2 text-sm font-bold text-slate-700">
                                        @switch($dispute->resolution)

                                            @case('client')
                                                Diselesaikan untuk Client
                                                @break

                                            @case('freelancer')
                                                Diselesaikan untuk Freelancer
                                                @break

                                            @case('partial')
                                                Penyelesaian sebagian
                                                @break

                                            @default
                                                {{ $dispute->resolution ?? 'Dispute ditutup' }}

                                        @endswitch
                                    </p>

                                    @if($dispute->resolution_note)
                                        <div class="mt-4 rounded-xl bg-white px-3 py-3">
                                            <p class="whitespace-pre-line text-xs leading-5 text-slate-500">
                                                {{ $dispute->resolution_note }}
                                            </p>
                                        </div>
                                    @endif

                                    <div class="mt-4 flex flex-wrap gap-x-5 gap-y-2 text-[10px] text-slate-400">

                                        @if($dispute->resolver)
                                            <span>
                                                Diputuskan oleh
                                                <strong class="font-bold text-slate-600">
                                                    {{ $dispute->resolver->name }}
                                                </strong>
                                            </span>
                                        @endif

                                        @if($dispute->resolved_at)
                                            <span>
                                                {{ $dispute->resolved_at->format('d M Y, H:i') }}
                                            </span>
                                        @endif

                                    </div>

                                </div>
                            </div>

                        </section>

                    @endif

                </div>

                {{-- =====================================================
                    RIGHT COLUMN
                ====================================================== --}}
                <aside class="space-y-5">

                    {{-- =================================================
                        ORDER SUMMARY
                    ================================================== --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">

                        <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">
                            Order
                        </p>

                        <h2 class="mt-1 text-sm font-bold text-slate-900">
                            Ringkasan order
                        </h2>

                        <div class="mt-5 space-y-4">

                            <div>
                                <p class="text-[10px] text-slate-400">
                                    Nomor order
                                </p>

                                <p class="mt-1 text-xs font-bold text-slate-700">
                                    {{ $dispute->order?->order_number ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] text-slate-400">
                                    Layanan
                                </p>

                                <p class="mt-1 text-xs font-bold leading-5 text-slate-700">
                                    {{ $dispute->order?->items?->first()?->service_title ?? 'Pesanan Jasa' }}
                                </p>
                            </div>

                            <div class="border-t border-slate-100 pt-4">
                                <div class="flex items-center justify-between gap-3">

                                    <span class="text-[10px] text-slate-500">
                                        Total order
                                    </span>

                                    <span class="text-sm font-bold text-slate-900">
                                        Rp
                                        {{ number_format((float) ($dispute->order?->total ?? 0), 0, ',', '.') }}
                                    </span>

                                </div>
                            </div>

                            <a
                                href="{{ route('client.orders.show', $dispute->order) }}"
                                class="flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                            >
                                <i class="bi bi-receipt"></i>
                                Lihat Detail Order
                            </a>

                        </div>
                    </section>

                    {{-- =================================================
                        STATUS
                    ================================================== --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">

                        <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">
                            Status
                        </p>

                        <h2 class="mt-1 text-sm font-bold text-slate-900">
                            Perjalanan dispute
                        </h2>

                        <div class="relative mt-5">

                            <div class="absolute bottom-5 left-[15px] top-5 w-px bg-slate-200"></div>

                            <div class="space-y-5">

                                {{-- Dibuka --}}
                                <div class="relative flex gap-3">
                                    <div class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-blue-200 bg-blue-50 text-[#2563EB]">
                                        <i class="bi bi-plus-lg text-[10px]"></i>
                                    </div>

                                    <div class="pt-0.5">
                                        <p class="text-xs font-bold text-slate-700">
                                            Dispute dibuka
                                        </p>

                                        <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                            {{ $dispute->created_at?->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Current status --}}
                                <div class="relative flex gap-3">
                                    <div class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full border {{ $statusConfig['class'] }}">
                                        <i class="bi {{ $statusConfig['icon'] }} text-[10px]"></i>
                                    </div>

                                    <div class="pt-0.5">
                                        <p class="text-xs font-bold text-slate-700">
                                            {{ $statusConfig['label'] }}
                                        </p>

                                        <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                            Status saat ini
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>

                    {{-- =================================================
                        PAYMENT
                    ================================================== --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">

                        <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">
                            Pembayaran
                        </p>

                        <h2 class="mt-1 text-sm font-bold text-slate-900">
                            Status pembayaran
                        </h2>

                        @if($dispute->order?->payment)

                            <div class="mt-5 flex items-center justify-between gap-3">

                                <span class="text-xs text-slate-500">
                                    Status
                                </span>

                                @if($dispute->order->payment->status === 'paid')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[9px] font-bold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Lunas
                                    </span>

                                @elseif($dispute->order->payment->status === 'pending')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[9px] font-bold text-amber-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu pembayaran
                                    </span>

                                @elseif($dispute->order->payment->status === 'refund_pending')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-2.5 py-1 text-[9px] font-bold text-indigo-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                                        Menunggu refund
                                    </span>

                                @elseif($dispute->order->payment->status === 'cancelled')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-[9px] font-bold text-rose-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                        Dibatalkan
                                    </span>

                                @else

                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[9px] font-bold text-slate-600">
                                        {{ ucfirst($dispute->order->payment->status) }}
                                    </span>

                                @endif

                            </div>

                        @else

                            <div class="mt-5 rounded-2xl border border-dashed border-slate-200 px-4 py-5 text-center">
                                <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                                    <i class="bi bi-credit-card text-lg"></i>
                                </div>

                                <p class="mt-2 text-xs text-slate-400">
                                    Data pembayaran belum tersedia.
                                </p>
                            </div>

                        @endif

                    </section>

                    {{-- =================================================
                        HELP
                    ================================================== --}}
                    <section class="rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 via-white to-blue-50/70 p-5">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">
                            <i class="bi bi-shield-check text-[15px]"></i>
                        </div>

                        <h2 class="mt-4 text-sm font-bold text-slate-900">
                            Tentang dispute
                        </h2>

                        <p class="mt-1.5 text-xs leading-5 text-slate-500">
                            Gunakan halaman ini untuk memberikan informasi yang relevan.
                            Hindari mengirim data yang tidak berhubungan dengan sengketa.
                        </p>

                    </section>

                </aside>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput =
                document.getElementById('evidence-file');

            const selectedFile =
                document.getElementById('selected-evidence-file');

            if (!fileInput || !selectedFile) {
                return;
            }

            fileInput.addEventListener('change', function () {

                if (this.files && this.files.length > 0) {

                    const file = this.files[0];

                    const sizeInMb =
                        file.size / (1024 * 1024);

                    if (sizeInMb > 10) {

                        selectedFile.textContent =
                            'File terlalu besar. Maksimal 10 MB.';

                        selectedFile.classList.remove(
                            'hidden',
                            'text-[#2563EB]'
                        );

                        selectedFile.classList.add(
                            'text-red-600'
                        );

                        this.value = '';

                        return;
                    }

                    selectedFile.textContent =
                        'File dipilih: ' + file.name;

                    selectedFile.classList.remove(
                        'hidden',
                        'text-red-600'
                    );

                    selectedFile.classList.add(
                        'text-[#2563EB]'
                    );

                } else {

                    selectedFile.textContent = '';

                    selectedFile.classList.add(
                        'hidden'
                    );

                }
            });
        });
    </script>

</x-layouts.marketplace>