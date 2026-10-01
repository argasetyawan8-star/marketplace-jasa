
<x-layouts.admin title="Detail Dispute">

    @php
        $statusConfig = match ($dispute->status) {
            'open' => [
                'label' => 'Dispute Dibuka',
                'class' => 'border-blue-200 bg-blue-50 text-blue-700',
                'icon' => 'bi-shield-exclamation',
            ],

            'pending_response' => [
                'label' => 'Menunggu Tanggapan',
                'class' => 'border-amber-200 bg-amber-50 text-amber-700',
                'icon' => 'bi-hourglass-split',
            ],

            'under_review' => [
                'label' => 'Sedang Ditinjau',
                'class' => 'border-violet-200 bg-violet-50 text-violet-700',
                'icon' => 'bi-search',
            ],

            'resolved_client' => [
                'label' => 'Selesai untuk Client',
                'class' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                'icon' => 'bi-check-circle-fill',
            ],

            'resolved_freelancer' => [
                'label' => 'Selesai untuk Freelancer',
                'class' => 'border-red-200 bg-red-50 text-red-700',
                'icon' => 'bi-x-circle-fill',
            ],

            'resolved_partial' => [
                'label' => 'Selesai Sebagian',
                'class' => 'border-orange-200 bg-orange-50 text-orange-700',
                'icon' => 'bi-sliders',
            ],

            'closed' => [
                'label' => 'Ditutup',
                'class' => 'border-slate-200 bg-slate-50 text-slate-600',
                'icon' => 'bi-lock-fill',
            ],

            default => [
                'label' => ucfirst(str_replace('_', ' ', $dispute->status)),
                'class' => 'border-slate-200 bg-slate-50 text-slate-600',
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

        /*
         * Client profile
         */
        $client = $dispute->order?->client;
        $clientProfile = $client?->profile;
        $clientAvatar = $clientProfile?->avatar;

        /*
         * Freelancer profile
         */
        $freelancerProfile = $dispute->order?->freelancerProfile;
        $freelancer = $freelancerProfile?->user;
        $freelancerAvatar = $freelancerProfile?->avatar;

        $clientInitial = strtoupper(
            substr(
                $client?->name ?? 'C',
                0,
                1
            )
        );

        $freelancerInitial = strtoupper(
            substr(
                $freelancer?->name ?? 'F',
                0,
                1
            )
        );
    @endphp

    <div class="min-h-screen bg-slate-50">

        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8 lg:py-7">

            {{-- Back + Number --}}
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <a
                    href="{{ route('admin.disputes.index') }}"
                    class="inline-flex w-fit items-center gap-2 rounded-lg px-2 py-1.5 text-sm font-medium text-slate-500 transition hover:bg-blue-50 hover:text-blue-600"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Dispute Center
                </a>

                <span class="w-fit rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-slate-500 ring-1 ring-inset ring-slate-200">
                    {{ $dispute->dispute_number }}
                </span>

            </div>

            {{-- Success --}}
            @if(session('success'))
                <div class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-white px-4 py-4 shadow-sm">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-900">
                            Berhasil
                        </p>

                        <p class="mt-0.5 text-sm leading-6 text-slate-600">
                            {{ session('success') }}
                        </p>
                    </div>

                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="mb-5 rounded-2xl border border-red-200 bg-white shadow-sm">

                    <div class="flex items-start gap-3 px-4 py-4">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>

                        <div class="min-w-0">

                            <p class="text-sm font-semibold text-slate-900">
                                Periksa kembali data keputusan
                            </p>

                            <div class="mt-2 space-y-1">
                                @foreach($errors->all() as $error)
                                    <p class="text-xs leading-5 text-red-600">
                                        {{ $error }}
                                    </p>
                                @endforeach
                            </div>

                        </div>

                    </div>

                </div>
            @endif

            {{-- Main Header --}}
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="bg-gradient-to-br from-white via-white to-blue-50/70 px-5 py-6 sm:px-7 lg:px-8">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-blue-700 ring-1 ring-inset ring-blue-200">
                                    <i class="bi bi-shield-exclamation"></i>
                                    {{ $dispute->dispute_number }}
                                </span>

                                <span class="text-xs text-slate-400">
                                    Dibuat
                                    {{ $dispute->created_at?->format('d M Y, H:i') ?? '-' }}
                                </span>

                            </div>

                            <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                                Detail Sengketa
                            </h1>

                            <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">
                                {{ $dispute->order?->order_number ?? '-' }}
                                <span class="mx-1 text-slate-300">•</span>
                                {{ $dispute->order?->items?->first()?->service_title ?? 'Pesanan Jasa' }}
                            </p>

                        </div>

                        <span
                            class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full border px-3.5 py-2 text-xs font-semibold {{ $statusConfig['class'] }}"
                        >
                            <i class="bi {{ $statusConfig['icon'] }}"></i>
                            {{ $statusConfig['label'] }}
                        </span>

                    </div>

                </div>

            </section>

            {{-- Main Layout --}}
            <div class="mt-5 grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,1fr)_360px]">

                {{-- LEFT --}}
                <div class="space-y-5">

                    {{-- Participants --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <div class="mb-5">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600">
                                Pihak Terlibat
                            </p>

                            <h2 class="mt-1 text-base font-bold text-slate-900">
                                Client & Freelancer
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Profil kedua pihak yang terkait dengan sengketa ini.
                            </p>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">

                            {{-- Client --}}
                            <div class="rounded-2xl border border-blue-100 bg-blue-50/50 p-4">

                                <div class="flex items-center gap-3">

                                    @if($clientAvatar)
                                        <img
                                            src="{{ asset('storage/' . $clientAvatar) }}"
                                            alt="{{ $client?->name ?? 'Client' }}"
                                            class="h-14 w-14 shrink-0 rounded-full object-cover ring-4 ring-white shadow-sm"
                                        >
                                    @else
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-blue-100 text-lg font-bold text-blue-700 ring-4 ring-white">
                                            {{ $clientInitial }}
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-[10px] font-semibold text-blue-700">
                                            Client
                                        </span>

                                        <p class="mt-1 truncate text-sm font-bold text-slate-900">
                                            {{ $client?->name ?? '-' }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-slate-500">
                                            {{ $client?->email ?? '-' }}
                                        </p>
                                    </div>

                                </div>

                                <div class="mt-4 rounded-xl border border-blue-100 bg-white px-3.5 py-3">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Username
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                        @if($clientProfile?->username)
                                            {{ '@' . $clientProfile->username }}
                                        @else
                                            -
                                        @endif
                                    </p>

                                </div>

                            </div>

                            {{-- Freelancer --}}
                            <div class="rounded-2xl border border-violet-100 bg-violet-50/50 p-4">

                                <div class="flex items-center gap-3">

                                    @if($freelancerAvatar)
                                        <img
                                            src="{{ asset('storage/' . $freelancerAvatar) }}"
                                            alt="{{ $freelancer?->name ?? 'Freelancer' }}"
                                            class="h-14 w-14 shrink-0 rounded-full object-cover ring-4 ring-white shadow-sm"
                                        >
                                    @else
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-violet-100 text-lg font-bold text-violet-700 ring-4 ring-white">
                                            {{ $freelancerInitial }}
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <span class="inline-flex rounded-full bg-violet-100 px-2 py-1 text-[10px] font-semibold text-violet-700">
                                            Freelancer
                                        </span>

                                        <p class="mt-1 truncate text-sm font-bold text-slate-900">
                                            {{ $freelancer?->name ?? '-' }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-slate-500">
                                            {{ $freelancer?->email ?? '-' }}
                                        </p>
                                    </div>

                                </div>

                                <div class="mt-4 rounded-xl border border-violet-100 bg-white px-3.5 py-3">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Username
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-700">
                                        @if($freelancerProfile?->username)
                                            {{ '@' . $freelancerProfile->username }}
                                        @else
                                            -
                                        @endif
                                    </p>

                                </div>

                            </div>

                        </div>

                    </section>

                    {{-- Reason --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <i class="bi bi-chat-left-text"></i>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600">
                                    Permasalahan
                                </p>

                                <h2 class="mt-1 text-base font-bold text-slate-900">
                                    Alasan Pengajuan
                                </h2>
                            </div>

                        </div>

                        <div class="mt-5 flex flex-wrap gap-2">

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-[11px] font-semibold text-slate-600">
                                <i class="bi bi-tag"></i>
                                {{ $categoryLabel }}
                            </span>

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-blue-700">
                                <i class="bi bi-person"></i>
                                Dibuka oleh {{ ucfirst($dispute->opened_by_role) }}
                            </span>

                        </div>

                        <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-5">

                            <p class="whitespace-pre-line text-sm leading-7 text-slate-700">
                                {{ $dispute->reason }}
                            </p>

                        </div>

                    </section>

                    {{-- Order --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <div class="flex items-start justify-between gap-3">

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600">
                                    Order
                                </p>

                                <h2 class="mt-1 text-base font-bold text-slate-900">
                                    Data Transaksi
                                </h2>
                            </div>

                            @if($dispute->order)
                                <a
                                    href="{{ route('admin.orders.show', $dispute->order) }}"
                                    class="inline-flex shrink-0 items-center gap-1.5 rounded-xl border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"
                                >
                                    Lihat Order
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>
                            @endif

                        </div>

                        <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Nomor Order
                                </p>

                                <p class="mt-2 break-all text-sm font-bold text-slate-800">
                                    {{ $dispute->order?->order_number ?? '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Jasa
                                </p>

                                <p class="mt-2 text-sm font-semibold text-slate-700">
                                    {{ $dispute->order?->items?->first()?->service_title ?? 'Pesanan Jasa' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Status Order
                                </p>

                                <p class="mt-2 text-sm font-semibold capitalize text-slate-700">
                                    {{ ucfirst(str_replace('_', ' ', $dispute->order?->status ?? '-')) }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-blue-50 p-4">
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-600">
                                    Total Transaksi
                                </p>

                                <p class="mt-2 text-base font-bold text-slate-900">
                                    Rp {{ number_format((float) ($dispute->order?->total ?? 0), 0, ',', '.') }}
                                </p>
                            </div>

                        </div>

                    </section>

                    {{-- Messages --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 px-5 py-5 sm:px-6">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi bi-chat-dots"></i>
                                </div>

                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600">
                                        Tanggapan
                                    </p>

                                    <h2 class="mt-1 text-base font-bold text-slate-900">
                                        Riwayat Komunikasi
                                    </h2>
                                </div>

                            </div>

                        </div>

                        <div class="px-5 py-5 sm:px-6">

                            @forelse($dispute->messages as $message)

                                @php
                                    $isClient = $message->user_id === $dispute->order?->client_id;
                                @endphp

                                <div class="mb-4 last:mb-0 rounded-2xl border border-slate-200 bg-slate-50 p-4">

                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                        <div class="flex min-w-0 items-center gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">
                                                {{ strtoupper(substr($message->user?->name ?? 'U', 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-slate-800">
                                                    {{ $message->user?->name ?? 'Pengguna' }}
                                                </p>

                                                <p class="mt-0.5 text-[10px] text-slate-400">
                                                    {{ $isClient ? 'Client' : 'Freelancer / Admin' }}
                                                    <span class="mx-1 text-slate-300">•</span>
                                                    {{ $message->created_at?->format('d M Y, H:i') }}
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="mt-4 rounded-xl bg-white p-4">
                                        <p class="whitespace-pre-line text-sm leading-6 text-slate-700">
                                            {{ $message->message }}
                                        </p>
                                    </div>

                                </div>

                            @empty

                                <div class="rounded-2xl border border-dashed border-slate-200 px-4 py-10 text-center">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                        <i class="bi bi-chat-left-text text-lg"></i>
                                    </div>

                                    <p class="mt-3 text-sm font-semibold text-slate-700">
                                        Belum ada tanggapan
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Riwayat komunikasi akan muncul di sini.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </section>

                    {{-- Evidence --}}
                    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 px-5 py-5 sm:px-6">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi bi-paperclip"></i>
                                </div>

                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600">
                                        Bukti
                                    </p>

                                    <h2 class="mt-1 text-base font-bold text-slate-900">
                                        File Pendukung
                                    </h2>
                                </div>

                            </div>

                        </div>

                        <div class="px-5 py-5 sm:px-6">

                            @forelse($dispute->evidences as $evidence)

                                <div class="mb-3 last:mb-0 rounded-2xl border border-slate-200 bg-slate-50 p-4">

                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                        <div class="flex min-w-0 items-center gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">
                                                <i class="bi bi-file-earmark"></i>
                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-slate-700">
                                                    {{ $evidence->file_name }}
                                                </p>

                                                <p class="mt-1 text-[10px] text-slate-400">
                                                    {{ $evidence->uploader?->name ?? 'Pengguna' }}
                                                    <span class="mx-1 text-slate-300">•</span>
                                                    {{ $evidence->created_at?->format('d M Y, H:i') }}
                                                </p>

                                            </div>

                                        </div>

                                        <a
                                            href="{{ asset('storage/' . $evidence->file_path) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-blue-200 bg-white px-4 text-xs font-semibold text-blue-600 transition hover:bg-blue-50 sm:w-auto"
                                        >
                                            <i class="bi bi-box-arrow-up-right"></i>
                                            Lihat File
                                        </a>

                                    </div>

                                    @if($evidence->description)
                                        <div class="mt-3 rounded-xl bg-white p-3">
                                            <p class="text-xs leading-5 text-slate-600">
                                                {{ $evidence->description }}
                                            </p>
                                        </div>
                                    @endif

                                </div>

                            @empty

                                <div class="rounded-2xl border border-dashed border-slate-200 px-4 py-10 text-center">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                        <i class="bi bi-paperclip text-lg"></i>
                                    </div>

                                    <p class="mt-3 text-sm font-semibold text-slate-700">
                                        Belum ada bukti
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        File pendukung belum tersedia.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </section>

                    {{-- Resolution --}}
                    @if($dispute->resolution)

                        <section class="overflow-hidden rounded-3xl border border-emerald-200 bg-emerald-50 shadow-sm">

                            <div class="px-5 py-5 sm:px-6">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>

                                    <div>
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-emerald-600">
                                            Keputusan
                                        </p>

                                        <h2 class="mt-1 text-base font-bold text-slate-900">
                                            Dispute Sudah Diselesaikan
                                        </h2>
                                    </div>

                                </div>

                                <div class="mt-5 rounded-2xl bg-white p-5">

                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                        Hasil
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-800">
                                        {{ $resolutionLabel }}
                                    </p>

                                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600">
                                        {{ $dispute->resolution_note }}
                                    </p>

                                    <div class="mt-4 border-t border-slate-100 pt-3">

                                        <p class="text-xs text-slate-400">

                                            @if($dispute->resolver?->name)
                                                Diputuskan oleh
                                                <span class="font-semibold text-slate-600">
                                                    {{ $dispute->resolver->name }}
                                                </span>

                                                <span class="mx-1 text-slate-300">•</span>
                                            @endif

                                            {{ $dispute->resolved_at?->format('d M Y, H:i') }}

                                        </p>

                                    </div>

                                </div>

                            </div>

                        </section>

                    @endif

                </div>

                {{-- RIGHT --}}
                <aside class="space-y-5">

                    {{-- Decision --}}
                    @if($dispute->status === 'under_review')

                        <section class="rounded-3xl border border-violet-200 bg-violet-50/70 p-5 shadow-sm sm:p-6">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-violet-600 shadow-sm">
                                <i class="bi bi-gavel text-lg"></i>
                            </div>

                            <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.16em] text-violet-600">
                                Admin Action
                            </p>

                            <h2 class="mt-1 text-base font-bold text-slate-900">
                                Keputusan Admin
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Pilih hasil penyelesaian setelah seluruh informasi dan bukti diperiksa.
                            </p>

                            <form
                                action="{{ route('admin.disputes.resolve', $dispute) }}"
                                method="POST"
                                class="mt-5"
                            >
                                @csrf

                                <div class="space-y-2.5">

                                    {{-- Client --}}
                                    <label class="group flex cursor-pointer items-start gap-3 rounded-2xl border border-white bg-white p-4 shadow-sm transition hover:border-blue-200 hover:bg-blue-50/40">

                                        <input
                                            type="radio"
                                            name="resolution"
                                            value="client"
                                            required
                                            class="mt-1 h-4 w-4 accent-blue-600"
                                        >

                                        <span class="min-w-0">

                                            <span class="block text-sm font-semibold text-slate-800">
                                                Diselesaikan untuk Client
                                            </span>

                                            <span class="mt-1 block text-xs leading-5 text-slate-500">
                                                Keputusan berpihak pada penyelesaian Client.
                                            </span>

                                        </span>

                                    </label>

                                    {{-- Freelancer --}}
                                    <label class="group flex cursor-pointer items-start gap-3 rounded-2xl border border-white bg-white p-4 shadow-sm transition hover:border-violet-200 hover:bg-violet-50/40">

                                        <input
                                            type="radio"
                                            name="resolution"
                                            value="freelancer"
                                            required
                                            class="mt-1 h-4 w-4 accent-blue-600"
                                        >

                                        <span class="min-w-0">

                                            <span class="block text-sm font-semibold text-slate-800">
                                                Diselesaikan untuk Freelancer
                                            </span>

                                            <span class="mt-1 block text-xs leading-5 text-slate-500">
                                                Keputusan berpihak pada penyelesaian Freelancer.
                                            </span>

                                        </span>

                                    </label>

                                    {{-- Partial --}}
                                    <label class="group flex cursor-pointer items-start gap-3 rounded-2xl border border-white bg-white p-4 shadow-sm transition hover:border-orange-200 hover:bg-orange-50/40">

                                        <input
                                            type="radio"
                                            name="resolution"
                                            value="partial"
                                            required
                                            class="mt-1 h-4 w-4 accent-blue-600"
                                        >

                                        <span class="min-w-0">

                                            <span class="block text-sm font-semibold text-slate-800">
                                                Partial Settlement
                                            </span>

                                            <span class="mt-1 block text-xs leading-5 text-slate-500">
                                                Penyelesaian sebagian untuk kedua pihak.
                                            </span>

                                        </span>

                                    </label>

                                </div>

                                <textarea
                                    name="resolution_note"
                                    rows="6"
                                    required
                                    maxlength="5000"
                                    placeholder="Tuliskan alasan keputusan admin dan tindakan lanjutan yang perlu dilakukan..."
                                    class="mt-4 block w-full resize-none rounded-2xl border border-violet-200 bg-white px-4 py-3 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >{{ old('resolution_note') }}</textarea>

                                <button
                                    type="submit"
                                    class="mt-4 inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 !text-white text-sm font-semibold shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-2"
                                >
                                    <i class="bi bi-check2-circle"></i>
                                    Selesaikan Dispute
                                </button>

                            </form>

                        </section>

                    @elseif(
                        in_array(
                            $dispute->status,
                            [
                                'resolved_client',
                                'resolved_freelancer',
                                'resolved_partial',
                            ],
                            true
                        )
                    )

                        {{-- Resolved Action --}}
                        <section class="rounded-3xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm sm:p-6">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>

                            <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.16em] text-emerald-600">
                                Dispute Selesai
                            </p>

                            <h2 class="mt-1 text-base font-bold text-slate-900">
                                {{ $resolutionLabel }}
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-600">
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
                                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-white px-4 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                >
                                    <i class="bi bi-lock"></i>
                                    Tutup Dispute
                                </button>

                            </form>

                        </section>

                    @endif

                    {{-- Payment --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <i class="bi bi-credit-card"></i>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600">
                                    Pembayaran
                                </p>

                                <h2 class="mt-1 text-base font-bold text-slate-900">
                                    Status Pembayaran
                                </h2>
                            </div>

                        </div>

                        @if($dispute->order?->payment)

                            <div class="mt-5 space-y-3">

                                <div class="flex items-center justify-between gap-3 rounded-xl bg-slate-50 px-4 py-3">

                                    <span class="text-xs text-slate-500">
                                        Status
                                    </span>

                                    <span class="rounded-full bg-blue-50 px-2.5 py-1.5 text-[11px] font-semibold capitalize text-blue-700">
                                        {{ ucfirst(str_replace('_', ' ', $dispute->order->payment->status)) }}
                                    </span>

                                </div>

                                @if($dispute->order?->total !== null)

                                    <div class="rounded-xl bg-blue-50 px-4 py-3">

                                        <p class="text-[10px] font-semibold uppercase tracking-wide text-blue-600">
                                            Total Order
                                        </p>

                                        <p class="mt-1 text-base font-bold text-slate-900">
                                            Rp {{ number_format((float) $dispute->order->total, 0, ',', '.') }}
                                        </p>

                                    </div>

                                @endif

                            </div>

                        @else

                            <div class="mt-5 rounded-xl border border-dashed border-slate-200 px-4 py-6 text-center">

                                <i class="bi bi-credit-card text-xl text-slate-300"></i>

                                <p class="mt-2 text-xs text-slate-400">
                                    Data pembayaran belum tersedia.
                                </p>

                            </div>

                        @endif

                    </section>

                    {{-- Quick Information --}}
                    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-600">
                            Informasi
                        </p>

                        <h2 class="mt-1 text-base font-bold text-slate-900">
                            Ringkasan Dispute
                        </h2>

                        <div class="mt-5 space-y-3">

                            <div class="flex items-start justify-between gap-4">
                                <span class="text-xs text-slate-400">
                                    Nomor Dispute
                                </span>

                                <span class="max-w-[190px] break-all text-right text-xs font-semibold text-slate-700">
                                    {{ $dispute->dispute_number }}
                                </span>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <span class="text-xs text-slate-400">
                                    Kategori
                                </span>

                                <span class="text-right text-xs font-semibold text-slate-700">
                                    {{ $categoryLabel }}
                                </span>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <span class="text-xs text-slate-400">
                                    Dibuka Oleh
                                </span>

                                <span class="text-right text-xs font-semibold text-slate-700">
                                    {{ ucfirst($dispute->opened_by_role) }}
                                </span>
                            </div>

                            <div class="flex items-start justify-between gap-4">
                                <span class="text-xs text-slate-400">
                                    Dibuat
                                </span>

                                <span class="text-right text-xs font-semibold text-slate-700">
                                    {{ $dispute->created_at?->format('d M Y, H:i') ?? '-' }}
                                </span>
                            </div>

                        </div>

                    </section>

                </aside>

            </div>

        </div>

    </div>

</x-layouts.admin>
