<x-layouts.freelancer title="Detail Dispute">

    @php

        $order = $dispute->order;

        $statusConfig = match ($dispute->status) {

            'open' => [

                'label' => 'Dispute Dibuka',

                'class' => 'border-[#BFDBFE] bg-[#EFF6FF] text-[#2563EB]',

                'dot' => 'bg-[#3B82F6]',

                'icon' => 'bi-shield-exclamation',

            ],

            'pending_response' => [

                'label' => 'Menunggu Tanggapan',

                'class' => 'border-[#FDE68A] bg-[#FFFBEB] text-[#A16207]',

                'dot' => 'bg-[#F59E0B]',

                'icon' => 'bi-hourglass-split',

            ],

            'under_review' => [

                'label' => 'Sedang Ditinjau Admin',

                'class' => 'border-[#DDD6FE] bg-[#F5F3FF] text-[#7C3AED]',

                'dot' => 'bg-[#8B5CF6]',

                'icon' => 'bi-search',

            ],

            'resolved_client' => [

                'label' => 'Diselesaikan untuk Client',

                'class' => 'border-[#FECACA] bg-[#FEF2F2] text-[#DC2626]',

                'dot' => 'bg-[#EF4444]',

                'icon' => 'bi-check-circle',

            ],

            'resolved_freelancer' => [

                'label' => 'Diselesaikan untuk Freelancer',

                'class' => 'border-[#BFDBFE] bg-[#EFF6FF] text-[#2563EB]',

                'dot' => 'bg-[#3B82F6]',

                'icon' => 'bi-check-circle-fill',

            ],

            'resolved_partial' => [

                'label' => 'Diselesaikan Sebagian',

                'class' => 'border-[#FDE68A] bg-[#FFFBEB] text-[#A16207]',

                'dot' => 'bg-[#F59E0B]',

                'icon' => 'bi-sliders',

            ],

            'closed' => [

                'label' => 'Dispute Ditutup',

                'class' => 'border-[#E2E8F0] bg-[#F8FAFC] text-[#64748B]',

                'dot' => 'bg-[#94A3B8]',

                'icon' => 'bi-lock-fill',

            ],

            default => [

                'label' => ucfirst(str_replace('_', '', $dispute->status)),

                'class' => 'border-[#E2E8F0] bg-[#F8FAFC] text-[#64748B]',

                'dot' => 'bg-[#94A3B8]',

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

            default => ucfirst(str_replace('_', '', $dispute->category)),

        };

        $isActive = in_array(

            $dispute->status,

            ['open', 'pending_response', 'under_review'],

            true

        );

        $canRespond = in_array(

            $dispute->status,

            ['open', 'pending_response', 'under_review'],

            true

        );

        $client = $order?->client;

        $currentUserId = auth()->id();

    @endphp

    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">

            {{-- TOP BAR --}}

            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <a

                    href="{{ route('freelancer.orders.show', $order) }}"

                    class="inline-flex w-fit items-center gap-2 text-xs font-medium text-[#64748B] transition hover:text-[#1D4ED8]"

                >

                    <i class="bi bi-arrow-left text-[12px]"></i>

                    Kembali ke order

                </a>

                <div class="flex flex-wrap items-center gap-2">

                    <span class="text-[10px] text-[#94A3B8]">

                        {{ $dispute->dispute_number }}

                    </span>

                    <span

                        class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-[9px] font-semibold {{ $statusConfig['class'] }}"

                    >

                        <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>

                        <i class="bi {{ $statusConfig['icon'] }}"></i>

                        {{ $statusConfig['label'] }}

                    </span>

                </div>

            </div>

            {{-- SUCCESS --}}

            @if(session('success'))

                <div class="mb-5 rounded-xl border border-[#BFDBFE] bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="flex items-center gap-3 px-4 py-3.5">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#EFF6FF]">

                            <i class="bi bi-check-lg text-sm text-[#2563EB]"></i>

                        </div>

                        <p class="text-sm text-[#334155]">

                            {{ session('success') }}

                        </p>

                    </div>

                </div>

            @endif

            {{-- ERROR --}}

            @if(session('error'))

                <div class="mb-5 rounded-xl border border-red-100 bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

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

            {{-- VALIDATION --}}

            @if($errors->any())

                <div class="mb-5 rounded-xl border border-red-100 bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="px-4 py-3.5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-50">

                                <i class="bi bi-exclamation-lg text-sm text-red-500"></i>

                            </div>

                            <div>

                                <p class="text-sm font-medium text-red-600">

                                    Terdapat kesalahan pada form.

                                </p>

                                <div class="mt-1 space-y-0.5">

                                    @foreach($errors->all() as $error)

                                        <p class="text-xs text-red-500">

                                            {{ $error }}

                                        </p>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endif

            {{-- HEADER --}}

            <section class="overflow-hidden rounded-3xl border border-[#E2E8F0] bg-white shadow-[0_8px_28px_rgba(18,49,40,0.045)]">

                <div class="px-5 py-6 sm:px-7 lg:px-8 lg:py-7">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EFF6FF] px-2.5 py-1 text-[9px] font-medium text-[#64748B]">

                                    <i class="bi bi-shield-exclamation text-[8px]"></i>

                                    {{ $dispute->dispute_number }}

                                </span>

                                <span class="text-[10px] text-[#94A3B8]">

                                    Dibuat {{ $dispute->created_at?->format('d M Y, H:i') }}

                                </span>

                            </div>

                            <h1 class="mt-4 text-xl font-semibold tracking-[-0.03em] text-[#0F172A] sm:text-2xl">

                                Detail Dispute

                            </h1>

                            <p class="mt-2 max-w-3xl text-xs leading-5 text-[#64748B]">

                                Sengketa untuk order

                                <span class="font-semibold text-[#475569]">

                                    {{ $order?->order_number ?? '-' }}

                                </span>

                            </p>

                        </div>

                        <span class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full border px-3 py-2 text-[10px] font-semibold {{ $statusConfig['class'] }}">

                            <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>

                            <i class="bi {{ $statusConfig['icon'] }}"></i>

                            {{ $statusConfig['label'] }}

                        </span>

                    </div>

                </div>

            </section>

            {{-- ACTIVE NOTICE --}}

            @if($isActive)

                <section class="mt-5 overflow-hidden rounded-2xl border border-[#BFDBFE] bg-[#EFF6FF]">

                    <div class="flex items-start gap-3 px-5 py-5 sm:px-6">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">

                            <i class="bi bi-shield-check text-[15px]"></i>

                        </div>

                        <div>

                            @if($dispute->status === 'pending_response')

                                <p class="text-xs font-semibold text-[#0F172A]">

                                    Tanggapan kamu diperlukan

                                </p>

                                <p class="mt-1 max-w-2xl text-xs leading-5 text-[#64748B]">

                                    Client telah mengajukan dispute. Berikan penjelasan dan bukti

                                    yang relevan agar Admin dapat meninjau kasus dari kedua sisi.

                                </p>

                            @elseif($dispute->status === 'under_review')

                                <p class="text-xs font-semibold text-[#0F172A]">

                                    Sengketa sedang ditinjau Admin

                                </p>

                                <p class="mt-1 max-w-2xl text-xs leading-5 text-[#64748B]">

                                    Informasi dari Client dan Freelancer sedang diperiksa oleh Admin.

                                    Tambahkan informasi hanya jika masih diperlukan.

                                </p>

                            @else

                                <p class="text-xs font-semibold text-[#0F172A]">

                                    Dispute sedang berjalan

                                </p>

                                <p class="mt-1 max-w-2xl text-xs leading-5 text-[#64748B]">

                                    Sampaikan informasi dan bukti yang berhubungan langsung

                                    dengan masalah pada order.

                                </p>

                            @endif

                        </div>

                    </div>

                </section>

            @endif

            {{-- MAIN GRID --}}

            <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-[minmax(0,1fr)_340px]">

                {{-- LEFT --}}

                <div class="space-y-5">

                    {{-- CLIENT REQUEST --}}

                    <section class="rounded-2xl border border-[#E2E8F0] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)] sm:p-6">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#FFFBEB] text-[#B7791F]">

                                <i class="bi bi-flag text-[15px]"></i>

                            </div>

                            <div class="min-w-0">

                                <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#B7791F]">

                                    Pengajuan Client

                                </p>

                                <h2 class="mt-1 text-sm font-semibold text-[#0F172A]">

                                    Alasan dispute

                                </h2>

                            </div>

                        </div>

                        <div class="mt-5 flex flex-wrap items-center gap-2">

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EFF6FF] px-3 py-1.5 text-[9px] font-semibold text-[#475569]">

                                <i class="bi bi-tag text-[#2563EB]"></i>

                                {{ $categoryLabel }}

                            </span>

                            <span class="text-[10px] text-[#9AA6A0]">

                                Diajukan {{ $dispute->created_at?->format('d M Y, H:i') }}

                            </span>

                        </div>

                        <div class="mt-5 rounded-xl bg-[#F8FBF9] px-4 py-4">

                            <p class="whitespace-pre-line text-xs leading-6 text-[#62766D]">

                                {{ $dispute->reason }}

                            </p>

                        </div>

                    </section>

                    {{-- RESPONSE HISTORY --}}

                    <section class="rounded-2xl border border-[#E2E8F0] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <div class="border-b border-[#E2E8F0] px-5 py-5 sm:px-6">

                            <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#2563EB]">

                                Tanggapan

                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#0F172A]">

                                Riwayat komunikasi

                            </h2>

                        </div>

                        <div class="px-5 py-5 sm:px-6">

                            @if($dispute->messages->count())

                                <div class="space-y-4">

                                    @foreach($dispute->messages as $message)

                                        @php

                                            $mine = $message->user_id === $currentUserId;

                                        @endphp

                                        <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }}">

                                            <div class="w-full max-w-[88%] sm:max-w-[76%]">

                                                <div class="mb-1.5 flex flex-wrap items-center gap-2 {{ $mine ? 'justify-end' : 'justify-start' }}">

                                                    <span class="text-[9px] font-semibold text-[#475569]">

                                                        {{ $message->user?->name ?? 'Pengguna' }}

                                                    </span>

                                                    <span class="text-[9px] text-[#94A3B8]">

                                                        {{ $message->created_at?->format('d M Y, H:i') }}

                                                    </span>

                                                </div>

                                                <div class="rounded-2xl px-4 py-3.5 {{ $mine ? 'rounded-br-md bg-[#EFF6FF] text-[#334155]' : 'rounded-bl-md bg-[#F5F8F6] text-[#475569]' }}">

                                                    <p class="whitespace-pre-line text-xs leading-5">

                                                        {{ $message->message }}

                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="rounded-xl border border-dashed border-[#E2E8F0] px-4 py-8 text-center">

                                    <i class="bi bi-chat-left-text text-lg text-[#94A3B8]"></i>

                                    <p class="mt-2 text-xs text-[#94A3B8]">

                                        Belum ada tanggapan dari kedua pihak.

                                    </p>

                                </div>

                            @endif

                        </div>

                    </section>

                    {{-- FREELANCER RESPONSE --}}

                    @if($canRespond)

                        <section class="overflow-hidden rounded-2xl border border-[#BFDBFE] bg-white shadow-[0_8px_24px_rgba(18,49,40,0.04)]">

                            <div class="border-b border-[#E2E8F0] bg-[#EFF6FF] px-5 py-5 sm:px-6">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">

                                        <i class="bi bi-reply text-[16px]"></i>

                                    </div>

                                    <div>

                                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#2563EB]">

                                            Respons Freelancer

                                        </p>

                                        <h2 class="mt-1 text-sm font-semibold text-[#0F172A]">

                                            Berikan tanggapan kamu

                                        </h2>

                                        <p class="mt-1 text-xs leading-5 text-[#64748B]">

                                            Jelaskan kronologi, posisi kamu, dan informasi yang relevan

                                            dengan dispute ini.

                                        </p>

                                    </div>

                                </div>

                            </div>

                            <form

                                action="{{ route('freelancer.disputes.message', $dispute) }}"

                                method="POST"

                                class="px-5 py-5 sm:px-6"

                            >

                                @csrf

                                <label

                                    for="message"

                                    class="break-words text-xs font-semibold text-[#334155]"

                                >

                                    Tanggapan

                                </label>

                                <textarea

                                    id="message"

                                    name="message"

                                    rows="7"

                                    maxlength="5000"

                                    required

                                    placeholder="Tulis penjelasan kamu berdasarkan brief, komunikasi, delivery, atau proses pekerjaan..."

                                    class="mt-2 w-full rounded-xl border border-[#DBEAFE] bg-[#F8FAFC] px-4 py-3 text-sm leading-6 text-[#0F172A] outline-none placeholder:text-[#A0ADA7] transition focus:border-[#93C5FD] focus:bg-white focus:ring-2 focus:ring-[#EFF6FF]"

                                >{{ old('message') }}</textarea>

                                <p class="mt-1.5 text-right text-[10px] text-[#A0ADA7]">

                                    Maksimal 5000 karakter

                                </p>

                                <button

                                    type="submit"

                                    class="mt-5 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 text-xs font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8]"

                                >

                                    <i class="bi bi-send"></i>

                                    Kirim Tanggapan Freelancer

                                </button>

                            </form>

                        </section>

                        {{-- EVIDENCE UPLOAD --}}

                        <section class="rounded-2xl border border-[#E2E8F0] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                            <div class="border-b border-[#E2E8F0] px-5 py-5 sm:px-6">

                                <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#2563EB]">

                                    Bukti

                                </p>

                                <h2 class="mt-1 text-sm font-semibold text-[#0F172A]">

                                    Tambahkan bukti Freelancer

                                </h2>

                            </div>

                            <form

                                action="{{ route('freelancer.disputes.evidence', $dispute) }}"

                                method="POST"

                                enctype="multipart/form-data"

                                class="px-5 py-5 sm:px-6"

                            >

                                @csrf

                                <label

                                    for="evidence-file"

                                    class="flex cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed border-[#BFDBFE] bg-[#F8FAFC] px-5 py-8 text-center transition hover:border-[#93C5FD] hover:bg-[#EFF6FF]"

                                >

                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">

                                        <i class="bi bi-cloud-arrow-up text-lg"></i>

                                    </div>

                                    <p class="mt-3 break-words text-xs font-semibold text-[#334155]">

                                        Pilih file bukti

                                    </p>

                                    <p class="mt-1 text-[10px] text-[#94A3B8]">

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

                                    class="mt-2 hidden text-[10px] font-medium text-[#2563EB]"

                                ></p>

                                <textarea

                                    name="description"

                                    rows="3"

                                    maxlength="1000"

                                    placeholder="Keterangan bukti (opsional)"

                                    class="mt-4 w-full rounded-xl border border-[#DBEAFE] bg-[#F8FAFC] px-4 py-3 text-xs leading-5 text-[#0F172A] outline-none placeholder:text-[#A0ADA7] transition focus:border-[#93C5FD] focus:bg-white focus:ring-2 focus:ring-[#EFF6FF]"

                                >{{ old('description') }}</textarea>

                                <button

                                    type="submit"

                                    class="mt-4 inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-[#BFDBFE] bg-white px-4 text-xs font-semibold text-[#2563EB] transition hover:bg-[#EFF6FF]"

                                >

                                    <i class="bi bi-paperclip"></i>

                                    Upload Bukti

                                </button>

                            </form>

                        </section>

                    @endif

                    {{-- EVIDENCE LIST --}}

                    <section class="rounded-2xl border border-[#E2E8F0] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <div class="border-b border-[#E2E8F0] px-5 py-5 sm:px-6">

                            <div class="flex items-end justify-between gap-4">

                                <div>

                                    <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#2563EB]">

                                        Arsip Bukti

                                    </p>

                                    <h2 class="mt-1 text-sm font-semibold text-[#0F172A]">

                                        Bukti dispute

                                    </h2>

                                </div>

                                <span class="text-[10px] text-[#98A49F]">

                                    {{ $dispute->evidences->count() }} file

                                </span>

                            </div>

                        </div>

                        <div class="px-5 py-5 sm:px-6">

                            @if($dispute->evidences->count())

                                <div class="space-y-3">

                                    @foreach($dispute->evidences as $evidence)

                                        @php

                                            $extension = strtolower(

                                                pathinfo(

                                                    $evidence->file_name ?? '',

                                                    PATHINFO_EXTENSION

                                                )

                                            );

                                            $icon = match ($extension) {

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

                                            $size = $evidence->file_size

                                                ? number_format(

                                                    $evidence->file_size / 1024 / 1024,

                                                    2

                                                ) . 'MB'

                                                : '-';

                                        @endphp

                                        <div class="rounded-xl border border-[#E5ECE8] bg-[#F8FAFC] p-4">

                                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                                <div class="flex min-w-0 items-start gap-3">

                                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm">

                                                        <i class="bi {{ $icon }}"></i>

                                                    </div>

                                                    <div class="min-w-0">

                                                        <p class="truncate break-words text-xs font-semibold text-[#334155]">

                                                            {{ $evidence->file_name }}

                                                        </p>

                                                        <p class="mt-1 text-[10px] text-[#94A3B8]">

                                                            Oleh

                                                            {{ $evidence->uploader?->name ?? 'Pengguna' }}

                                                            · {{ $size }}

                                                            · {{ $evidence->created_at?->format('d M Y, H:i') }}

                                                        </p>

                                                    </div>

                                                </div>

                                                <a

                                                    href="{{ asset('storage/' . $evidence->file_path) }}"

                                                    target="_blank"

                                                    rel="noopener noreferrer"

                                                    class="inline-flex h-9 w-full shrink-0 items-center justify-center gap-2 rounded-lg border border-[#DBEAFE] bg-white px-3 text-[10px] font-semibold text-[#2563EB] transition hover:bg-[#EFF6FF] sm:w-auto"

                                                >

                                                    <i class="bi bi-box-arrow-up-right"></i>

                                                    Lihat file

                                                </a>

                                            </div>

                                            @if($evidence->description)

                                                <div class="mt-3 rounded-lg bg-white px-3 py-3">

                                                    <p class="text-[10px] leading-5 text-[#64748B]">

                                                        {{ $evidence->description }}

                                                    </p>

                                                </div>

                                            @endif

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="rounded-xl border border-dashed border-[#E2E8F0] px-4 py-8 text-center">

                                    <i class="bi bi-paperclip text-lg text-[#94A3B8]"></i>

                                    <p class="mt-2 text-xs text-[#94A3B8]">

                                        Belum ada bukti yang diunggah.

                                    </p>

                                </div>

                            @endif

                        </div>

                    </section>

                    {{-- RESOLUTION --}}

                    @if(in_array($dispute->status, [

                        'resolved_client',

                        'resolved_freelancer',

                        'resolved_partial',

                        'closed',

                    ], true))

                        <section class="overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                            <div class="px-5 py-5 sm:px-6">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">

                                        <i class="bi bi-check-circle text-[15px]"></i>

                                    </div>

                                    <div>

                                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#2563EB]">

                                            Keputusan Admin

                                        </p>

                                        <h2 class="mt-1 text-sm font-semibold text-[#0F172A]">

                                            Hasil penyelesaian

                                        </h2>

                                    </div>

                                </div>

                                <div class="mt-5 rounded-xl bg-[#F8FBF9] px-4 py-4">

                                    <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#94A3B8]">

                                        Hasil

                                    </p>

                                    <p class="mt-2 text-sm font-semibold text-[#334155]">

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

                                        <div class="mt-4 rounded-lg bg-white px-3 py-3">

                                            <p class="whitespace-pre-line text-xs leading-5 text-[#64748B]">

                                                {{ $dispute->resolution_note }}

                                            </p>

                                        </div>

                                    @endif

                                    <div class="mt-4 flex flex-wrap gap-x-5 gap-y-2 text-[10px] text-[#94A3B8]">

                                        @if($dispute->resolver)

                                            <span>

                                                Diputuskan oleh

                                                <strong class="font-semibold text-[#475569]">

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

                {{-- RIGHT --}}

                <aside class="space-y-5">

                    {{-- ORDER SUMMARY --}}

                    <section class="rounded-2xl border border-[#E2E8F0] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]">

                            Order

                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#0F172A]">

                            Ringkasan order

                        </h2>

                        <div class="mt-5 space-y-4">

                            <div>

                                <p class="text-[10px] text-[#94A3B8]">

                                    Nomor order

                                </p>

                                <p class="mt-1 break-words text-xs font-semibold text-[#334155]">

                                    {{ $order?->order_number ?? '-' }}

                                </p>

                            </div>

                            <div>

                                <p class="text-[10px] text-[#94A3B8]">

                                    Layanan

                                </p>

                                <p class="mt-1 break-words text-xs font-semibold leading-5 text-[#334155]">

                                    {{ $order?->items?->first()?->service_title ?? 'Pesanan Jasa' }}

                                </p>

                            </div>

                            <div>

                                <p class="text-[10px] text-[#94A3B8]">

                                    Client

                                </p>

                                <p class="mt-1 break-words text-xs font-semibold text-[#334155]">

                                    {{ $client?->name ?? 'Client' }}

                                </p>

                            </div>

                            <div class="border-t border-[#E2E8F0] pt-4">

                                <div class="flex items-center justify-between gap-3">

                                    <span class="text-[10px] text-[#64748B]">

                                        Nilai order

                                    </span>

                                    <span class="text-sm font-semibold text-[#0F172A]">

                                        Rp {{ number_format((float) ($order?->total ?? 0), 0, ',', '.') }}

                                    </span>

                                </div>

                            </div>

                            <a

                                href="{{ route('freelancer.orders.show', $order) }}"

                                class="flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-[#DBEAFE] bg-white break-words text-xs font-semibold text-[#334155] transition hover:bg-[#EFF6FF] hover:text-[#2563EB]"

                            >

                                <i class="bi bi-receipt"></i>

                                Lihat Detail Order

                            </a>

                        </div>

                    </section>

                    {{-- CLIENT --}}

                    <section class="rounded-2xl border border-[#E2E8F0] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]">

                            Pihak terkait

                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#0F172A]">

                            Client

                        </h2>

                        <div class="mt-5 flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#EFF6FF] text-sm font-semibold text-[#2563EB]">

                                {{ strtoupper(substr($client?->name ?? 'C', 0, 1)) }}

                            </div>

                            <div class="min-w-0">

                                <p class="truncate break-words text-xs font-semibold text-[#334155]">

                                    {{ $client?->name ?? 'Client' }}

                                </p>

                                <p class="mt-0.5 truncate text-[10px] text-[#94A3B8]">

                                    {{ $client?->email ?? '-' }}

                                </p>

                            </div>

                        </div>

                    </section>

                    {{-- PAYMENT --}}

                    <section class="rounded-2xl border border-[#E2E8F0] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]">

                            Pembayaran

                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#0F172A]">

                            Status pembayaran

                        </h2>

                        @if($order?->payment)

                            <div class="mt-5 flex items-center justify-between gap-3">

                                <span class="text-xs text-[#64748B]">

                                    Status

                                </span>

                                @if($order->payment->status === 'paid')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EFF6FF] px-2.5 py-1 text-[9px] font-semibold text-[#2563EB]">

                                        <span class="h-1.5 w-1.5 rounded-full bg-[#3B82F6]"></span>

                                        Lunas

                                    </span>

                                @elseif($order->payment->status === 'refund_pending')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F5F3FF] px-2.5 py-1 text-[9px] font-semibold text-[#7C3AED]">

                                        <span class="h-1.5 w-1.5 rounded-full bg-[#8B5CF6]"></span>

                                        Menunggu refund

                                    </span>

                                @elseif($order->payment->status === 'cancelled')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#FEF2F2] px-2.5 py-1 text-[9px] font-semibold text-[#DC2626]">

                                        <span class="h-1.5 w-1.5 rounded-full bg-[#EF4444]"></span>

                                        Dibatalkan

                                    </span>

                                @else

                                    <span class="rounded-full bg-[#F4F6F5] px-2.5 py-1 text-[9px] font-semibold text-[#64748B]">

                                        {{ ucfirst($order->payment->status) }}

                                    </span>

                                @endif

                            </div>

                        @else

                            <div class="mt-5 rounded-xl border border-dashed border-[#E2E8F0] px-4 py-5 text-center">

                                <i class="bi bi-credit-card text-lg text-[#94A3B8]"></i>

                                <p class="mt-2 text-xs text-[#94A3B8]">

                                    Data pembayaran belum tersedia.

                                </p>

                            </div>

                        @endif

                    </section>

                    {{-- STATUS FLOW --}}

                    <section class="rounded-2xl border border-[#E2E8F0] bg-white p-5 shadow-[0_5px_18px_rgba(18,49,40,0.035)]">

                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#2563EB]">

                            Status

                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#0F172A]">

                            Alur dispute

                        </h2>

                        <div class="mt-5 space-y-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#EFF6FF] text-[#2563EB]">

                                    <i class="bi bi-plus-lg text-[10px]"></i>

                                </div>

                                <div>

                                    <p class="break-words text-xs font-semibold text-[#334155]">

                                        Dispute dibuat

                                    </p>

                                    <p class="mt-1 text-[10px] leading-4 text-[#94A3B8]">

                                        Client mengajukan sengketa pada order.

                                    </p>

                                </div>

                            </div>

                            <div class="flex items-start gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#FFFBEB] text-[#A16207]">

                                    <i class="bi bi-reply text-[10px]"></i>

                                </div>

                                <div>

                                    <p class="break-words text-xs font-semibold text-[#334155]">

                                        Tanggapan Freelancer

                                    </p>

                                    <p class="mt-1 text-[10px] leading-4 text-[#94A3B8]">

                                        Jelaskan posisi dan bukti dari sisi Freelancer.

                                    </p>

                                </div>

                            </div>

                            <div class="flex items-start gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#F5F3FF] text-[#7C3AED]">

                                    <i class="bi bi-search text-[10px]"></i>

                                </div>

                                <div>

                                    <p class="break-words text-xs font-semibold text-[#334155]">

                                        Review Admin

                                    </p>

                                    <p class="mt-1 text-[10px] leading-4 text-[#94A3B8]">

                                        Admin menentukan hasil penyelesaian sengketa.

                                    </p>

                                </div>

                            </div>

                        </div>

                    </section>

                </aside>

            </div>

        </div>

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const fileInput = document.getElementById('evidence-file');

            const selectedFile = document.getElementById('selected-evidence-file');

            if (!fileInput || !selectedFile) {

                return;

            }

            fileInput.addEventListener('change', function () {

                if (!this.files || this.files.length === 0) {

                    selectedFile.textContent = '';

                    selectedFile.classList.add('hidden');

                    return;

                }

                const file = this.files[0];

                const sizeInMb = file.size / (1024  1024);

                if (sizeInMb > 10) {

                    selectedFile.textContent =

                        'File terlalu besar. Maksimal 10 MB.';

                    selectedFile.classList.remove(

                        'hidden',

                        'text-[#2563EB]'

                    );

                    selectedFile.classList.add('text-red-600');

                    this.value = '';

                    return;

                }

                selectedFile.textContent =

                    'File dipilih:' + file.name;

                selectedFile.classList.remove(

                    'hidden',

                    'text-red-600'

                );

                selectedFile.classList.add(

                    'text-[#2563EB]'

                );

            });

        });

    </script>

</x-layouts.freelancer>